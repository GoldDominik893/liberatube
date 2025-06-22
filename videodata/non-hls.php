<?php
include('../config.php');
header('Content-Type: video/mp4');

// ── BEGIN multi‑instance fail‑over ──
$value = null;
$errors = [];

foreach ($InvVIServerArray as $idx => $instance) {
    $pos = $idx + 1;
    $url = rtrim($instance, '/') . '/api/v1/videos/' . $_GET['id'] . '?hl=en';

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 5,
    ]);
    $resp = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        $errors[$pos] = $err;
        continue;
    }

    $data = json_decode($resp, true);
    if (!isset($data['formatStreams']) || isset($data['error']) || $data === null) {
        $errors[$pos] = $data['error'] ?? 'API returned null or missing formatStreams';
        continue;
    }

    // Check for googlevideo link
    $hasGV = false;
    foreach ($data['formatStreams'] as $fmt) {
        if (!empty($fmt['url']) && strpos($fmt['url'], 'googlevideo.com') !== false) {
            $hasGV = true;
            break;
        }
    }
    if (!$hasGV) {
        $errors[$pos] = 'no googlevideo link';
        continue;
    }

    // Success!
    header('X-Invidious-Instance: ' . $pos);
    $value = $data;
    break;
}

if (!$value) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 503 Service Unavailable');
    header('Content-Type: text/plain; charset=utf-8');
    foreach ($errors as $pos => $msg) {
        echo "Instance #{$pos}: {$msg}\n";
    }
    exit;
}
// ── END multi‑instance fail‑over ──


// Extract stream data
$nonHlsUrls = [];
$nonHlsItag = [];
$nonHlsQuality = [];
$nonHlsType = [];
$nonHlsSize = [];

foreach ($value['formatStreams'] as $formatStream) {
    if (isset($formatStream['url'])) {
        $nonHlsUrls[] = $formatStream['url'];
        $nonHlsItag[] = $formatStream['itag'];
        $nonHlsQuality[] = $formatStream['quality'];
        $nonHlsType[] = $formatStream['type'];
        $nonHlsSize[] = $formatStream['size'];
    }
}

// Preferred itags
$selectedNonHlsUrl = '';
if ($_GET['itag']) {
    $preferredItags = [$_GET['itag']];
} else {
    $preferredItags = [end($nonHlsItag)];
}

// Select URL
foreach ($value['formatStreams'] as $formatStream) {
    if (isset($formatStream['url'], $formatStream['itag'])) {
        if (in_array($formatStream['itag'], $preferredItags)) {
            $selectedNonHlsUrl = $formatStream['url'];
            break;
        }
    }
}

// Redirect or proxy
if ($_GET['dl'] == "dl" && ($allowProxy == "true" || $allowProxy == "downloads")) {
    readfile($selectedNonHlsUrl);
    exit();
} elseif ($_GET['dl'] == "true" && $allowProxy == "true") {
    readfile($selectedNonHlsUrl);
    exit();
} else {
    header('Location: ' . $selectedNonHlsUrl);
    exit();
}

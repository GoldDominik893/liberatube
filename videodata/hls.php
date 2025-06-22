<?php
include('../config.php');
header('Content-type: video/mp4');

// ── BEGIN multi‑instance fail‑over ──
$value  = null;
$errors = [];

foreach ($InvVIServerArray as $idx => $instance) {
    $pos = $idx + 1;
    $api = rtrim($instance, '/') . '/api/v1/videos/' . $_GET['id'] . '?hl=en';

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $api,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT        => 5,
    ]);
    $resp = curl_exec($ch);
    $err  = curl_error($ch);
    curl_close($ch);

    if ($err) {
        $errors[$pos] = $err;
        continue;
    }

    $data = json_decode($resp, true);
    if (!isset($data['adaptiveFormats']) || isset($data['error']) || $data === null) {
        $errors[$pos] = $data['error'] ?? 'API returned null or missing adaptiveFormats';
        continue;
    }

    // check for a googlevideo.com URL
    $hasGV = false;
    foreach ($data['adaptiveFormats'] as $fmt) {
        if (!empty($fmt['url']) && strpos($fmt['url'], 'googlevideo.com') !== false) {
            $hasGV = true;
            break;
        }
    }
    if (!$hasGV) {
        $errors[$pos] = 'no googlevideo link';
        continue;
    }

    // SUCCESS!  ↴
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

    $nonHlsUrls    = [];
    $nonHlsItag    = [];
    $nonHlsQuality = [];
    $nonHlsType    = [];
    $nonHlsSize    = [];

    foreach ($value['adaptiveFormats'] as $formatStream) {
        if (isset($formatStream['url'])) {
            $nonHlsUrls[]    = $formatStream['url'];
            $nonHlsItag[]    = $formatStream['itag'];
            $nonHlsQuality[] = $formatStream['quality'];
            $nonHlsType[]    = $formatStream['type'];
            $nonHlsSize[]    = $formatStream['size'];
        }
    }

                    $selectedNonHlsUrl = '';
                    if ($_GET['itag']) {
                        $preferredItags = [$_GET['itag']];
                    } else {
                        $preferredItags = ['140', '249', '250', '251', '139'];
                    }
                    

                    if (isset($value['adaptiveFormats']) && is_array($value['adaptiveFormats'])) {
                        foreach ($value['adaptiveFormats'] as $formatStream) {
                            if (isset($formatStream['url']) && isset($formatStream['itag'])) {
                                $url = $formatStream['url'];
                                $itag = $formatStream['itag'];

                                if (in_array($itag, $preferredItags)) {
                                    $selectedNonHlsUrl = $url;
                                    break;
                                }
                            }
                        }
                    }

                    
if ($_GET['dl'] == "dl" and ($allowProxy == "true" or $allowProxy == "downloads")) {
    readfile($selectedNonHlsUrl);
    exit();
} elseif ($_GET['dl'] == "true" and $allowProxy == "true") {
    readfile($selectedNonHlsUrl);
    exit();
}
else {
    header('Location: '.$selectedNonHlsUrl);
}
exit;

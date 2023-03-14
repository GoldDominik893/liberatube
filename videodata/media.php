<?php
    include('../config.php');
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $link = "https";
    else $link = "http";
    $link .= "://";
    $link .= $_SERVER['HTTP_HOST'];
    $link .= $_SERVER['REQUEST_URI'];
$url = $link;
$url_components = parse_url($url);
parse_str($url_components['query'], $params);

if ($params['type'] == "audiouhqserver1") {
    $server = $InvVDServer1;
    $itag = "140";
} elseif ($params['type'] == "audiouhqserver2") {
    $server = $InvVDServer2;
    $itag = "140";
} elseif ($params['type'] == "audiohqserver1") {
    $server = $InvVDServer1;
    $itag = "250";
} elseif ($params['type'] == "audiohqserver2") {
    $server = $InvVDServer2;
    $itag = "250";
} elseif ($params['type'] == "audiolqserver1") {
    $server = $InvVDServer1;
    $itag = "599";
} elseif ($params['type'] == "audiolqserver2") {
    $server = $InvVDServer2;
    $itag = "599";
} elseif ($params['type'] == "mediumserver1") {
    $server = $InvVDServer1;
    $itag = "18";
} elseif ($params['type'] == "mediumserver2") {
    $server = $InvVDServer2;
    $itag = "18";
} elseif ($params['type'] == "hd720server1") {
    $server = $InvVDServer1;
    $itag = "22";
} elseif ($params['type'] == "hd720server2") {
    $server = $InvVDServer2;
    $itag = "22";
}

if ($params['dl'] == "dl" and ($allowProxy == "true" or $allowProxy == "downloads")) {
    $url = $InvVDServer1."/latest_version?id=" . $params['id'] . "&itag=".$itag;
    readfile($url);
    exit();
} elseif ($params['dl'] == "true" and $allowProxy == "true") {
    $url = $InvVDServer1."/latest_version?id=" . $params['id'] . "&itag=".$itag;
    readfile($url);
    exit();
}
else {
    header('Location: '.$server.'/latest_version?id=' . $params['id'] . '&itag='.$itag);
}
exit;
?>
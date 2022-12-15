<?php
include('../config.php');
header('Content-Type: text/plain');
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $link = "https";
    else $link = "http";
    $link .= "://";
    $link .= $_SERVER['HTTP_HOST'];
    $link .= $_SERVER['REQUEST_URI'];
$url = $link;
$url_components = parse_url($url);
parse_str($url_components['query'], $params);
$filename = $InvVDCAServer2.'/api/v1/captions/' . $params['id'] . '?label=English%20(auto-generated)';
echo file_get_contents($filename);
?>
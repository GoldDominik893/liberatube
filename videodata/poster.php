<?php
include('../config.php');
header('Content-Type: image/png');
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $link = "https";
    else $link = "http";
    $link .= "://";
    $link .= $_SERVER['HTTP_HOST'];
    $link .= $_SERVER['REQUEST_URI'];
$url = $link;
$url_components = parse_url($url);
parse_str($url_components['query'], $params);
header('Location: '.$InvVIServer.'/vi/' . $params['id'] . '/maxres.jpg');
exit;
?>
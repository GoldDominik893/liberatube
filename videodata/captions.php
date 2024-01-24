<?php
include('../config.php');
header('Content-Type: text/plain');

$filename = $InvVIServer.$_GET['c_ext'];
$content = file_get_contents($filename); 
    echo $content;
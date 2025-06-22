<?php
include('../config.php');
header('Content-Type: text/plain');

$filename = $InvSServer.$_GET['c_ext'];
$content = file_get_contents($filename); 
    echo $content;
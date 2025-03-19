<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $videoUrl = $_POST['videoUrl'];
    $videoTitle = $_POST['videoTitle'];
    $videoAuthor = $_POST['videoAuthor'];
    $friend = $_POST['friend'];

    if ($videoUrl||$videoTitle||$videoAuthor||$friend||$_SESSION['librebook_instance']||$_SESSION['librebook_apikey']) {
    
    $librebook_url = $_SESSION['librebook_instance'];
    $librebook_key = $_SESSION['librebook_apikey'];
    $message = 'Check out this video! '.$videoTitle.' - '.$videoAuthor.' - '.$videoUrl;
    $librebook_request = $librebook_url.'/api.php?apikey='.$librebook_key.'&function=dm_sendmessage&recipient='.$friend.'&message='.$message;
    $response = file_get_contents($librebook_request);

    $response_array = array_map('trim', explode(',', $response));

    if ($response_array[1] == 'Message sent successfully!') {
        echo "Video shared with $friend!<br>";
    } else {
        echo "Error sharing video with $friend!<br>";
    }
    
    }
    
}
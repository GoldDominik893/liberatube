<?php
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $link = "https";
    else $link = "http";
    $link .= "://";
    $link .= $_SERVER['HTTP_HOST'];
    $link .= $_SERVER['REQUEST_URI'];
$url = $link;
$url_components = parse_url($url);
parse_str($url_components['query'], $params);
?>
<h4><a href="..">< bad youtube</a> | <a href="../vi/?w=<?php echo $params['w']; ?>&t=<?php echo $params['t']; ?>&d=<?php echo $params['d']; ?>">back to video player</a></h4><br>
        <center><audio autoplay controls>
        <source src="https://yewtu.be/latest_version?id=<?php echo $params['w']; ?>&itag=139" type="audio/webm">
        <source src="https://invidious.lunar.icu/latest_version?id=<?php echo $params['w']; ?>&itag=139" type="audio/mpeg">
        Your Browser Sucks! Can't play the audio.
        </audio></center>
        <center> <h2> <?php echo $params['t']; ?> </h2> </center>
        <center> <h4> <?php echo $params['d']; ?> </h4> </center>
        <title>Bad YouTube</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="/styles/player.css">
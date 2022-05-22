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
<h4><a href="..">< bad youtube</a> | <a href="../so/?w=<?php echo $params['w']; ?>&t=<?php echo $params['t']; ?>&d=<?php echo $params['d']; ?>">listen in audio only mode</a></h4><br>
<center><video style="max-width: 75%;" poster="https://yewtu.be/vi/<?php echo $params['w']; ?>/maxres.jpg" autoplay controls>
        <source src="https://yewtu.be/latest_version?id=<?php echo $params['w']; ?>&itag=22" type="video/mp4" label="hd720">
        <source src="https://invidio.xamh.de/latest_version?id=<?php echo $params['w']; ?>&itag=22" type="video/mp4" label="hd720">
        <source src="https://yewtu.be/latest_version?id=<?php echo $params['w']; ?>&itag=18" type="video/mp4" label="medium">
        <source src="https://invidio.xamh.de/latest_version?id=<?php echo $params['w']; ?>&itag=18" type="video/mp4" label="medium">
        <track kind="captions" src="https://invidious.epicsite.xyz/api/v1/captions/<?php echo $params['w']; ?>?label=English (auto-generated)" label="English (auto-generated)">
        <track kind="captions" src="https://invidio.xamh.de/api/v1/captions/<?php echo $params['w']; ?>?label=English (auto-generated)" label="English (auto-generated)">
        Your Browser Sucks! Can't play the video.
        </video></center>
        <center> <h2> <?php echo $params['t']; ?> </h2> </center>
        <center> <h4> <?php echo $params['d']; ?> </h4> </center>
        <title><?php echo $params['t']; ?>Bad YouTube</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="/styles/player.css">

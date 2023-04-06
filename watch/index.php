<?php
session_start();  
include('../config.php');
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$query = mysqli_query($conn, "SELECT * FROM login WHERE username = '".$_SESSION['logged_in_user']."'");
$numrows = mysqli_num_rows($query);
while ($row = mysqli_fetch_assoc($query))
{   
    $pwrow = $row['password'];
}
if ($_SESSION['hashed_pass'] == $pwrow) {
    } else {
        session_destroy();
    }

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
<html>
<head>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<?php
$dbsenduser = $_SESSION['logged_in_user'];
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if (isset($_SESSION['logged_in_user']))
{
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$query = mysqli_query($conn, "SELECT * FROM login WHERE username = '".$_SESSION['logged_in_user']."'");
$numrows = mysqli_num_rows($query);
while ($row = mysqli_fetch_assoc($query))
{
    $themerow = $row['theme'];
    $userproxysetting = $row['proxy'];
}
$row = mysqli_fetch_assoc($query);
$numrows = mysqli_num_rows($query);
}
                if(strcmp($themerow, 'dark') == 0)
            {
                echo '<link rel="stylesheet" href="../styles/playerdark.css">';
            } elseif(strcmp($themerow, 'blue') == 0)
            {
                echo '<link rel="stylesheet" href="../styles/playerblue.css">';
            } elseif(strcmp($themerow, 'ultra-dark') == 0)
            {
                echo '<link rel="stylesheet" href="../styles/playerultra-dark.css">';
            } elseif(strcmp($themerow, 'light') == 0)
            {
                echo '<link rel="stylesheet" href="../styles/playerlight.css">';
            } else 
            {
                echo '<link rel="stylesheet" href="../styles/player'.$defaultTheme.'.css">';
            } 
                ?>

<div class="w3-sidebar w3-bar-block w3-collapse w3-card sidebar" style="width:55px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">&times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">home</span></a>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">history</span></a>
  <a href="/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">list_alt</span></a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">subscriptions</span></a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">settings</span></a>
  <hr class="hr">
  <?php
            if ($params['listen'] == "true") {
                echo '<a href="?v='.$params['v'].'&listen=false" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">live_tv</span></a>
                      <a href="#" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">headphones</span></a>';
            }
            else {
                echo '<a href="#" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">live_tv</span></a>
                      <a href="?v='.$params['v'].'&listen=true" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">headphones</span></a>';
            }
        ?>
  
</div>

<div class="w3-main" style="margin-left:55px">
<div class="w3-tssseal">
  <button class="w3-button w3-darkgrey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
  </div>
</div>
 <?php
                $InvApiUrl = $InvVIServer.'/api/v1/videos/' . $params['v'] . '?fields=title,description,viewCount,subCountText,likeCount,author,authorId,publishedText&hl=en';

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $InvApiUrl);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_VERBOSE, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);

                curl_close($ch);
                $data = json_decode($response);
                $value = json_decode(json_encode($data), true);
                
                    $title = $value['title'];
                    $description = $value['description'];
                    $views = number_format($value['viewCount']);
                    $likes = number_format($value['likeCount']);
                    $author = $value['author'];
                    $authorId = $value['authorId'];
                    $autsubs = $value['subCountText'];
                    $shared = $value['publishedText'];
if ($useReturnYTDislike == "true") {
$dislikeapiurl = 'https://returnyoutubedislikeapi.com/votes?videoId='.$params['v'];

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $dislikeapiurl);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_VERBOSE, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);

                curl_close($ch);
                $data = json_decode($response);
                $value = json_decode(json_encode($data), true);
                
                    $dislikes = number_format($value['dislikes']);
                    $dislikes = " · ".$dislikes." estimated dislikes"; }
                    ?> 

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta property="og:title" content="<?php echo $title; ?>">
        <meta property="og:type" content="website">
        <meta property="og:url" content="/?v=<?php echo $params['v']; ?>">
        <meta name="theme-color" content="#303EE1">
        <meta name="author" content="<?php echo $title; ?>">
         <meta name="keywords" content="badyt.cf, liberatube, EpicFaucet, two.epicfaucet.gq, yewtu.be, online videos, alternative youtube frontend, Liberatube">
         <meta property="og:locale" content="en_US">
         <meta property="og:description" content="<?php echo $value['description']; ?>">
            <meta property="description" content="<?php echo $value['description']; ?>">
<meta name="og:image" content="https://yewtu.be/vi/<?php echo $params['v']; ?>/maxres.jpg"/>

<meta property="og:video:type" content="text/html">
<meta property="og:video:width" content="640">
<meta property="og:video:height" content="480">
<span><meta property="og:site_name" content="Liberatube">
<link itemprop="name" content="Liberatube"></span></head>

<div class="tenborder">
<br>
<center>
            <?php
            if ($userproxysetting == "on" and $allowProxy = "true") {
                $dlsetting = "&dl=true";
            } else {
                $dlsetting = "&dl=false";
            }
            if ($params['listen'] == "true") {
                
                echo '<link rel="stylesheet" href="../styles/audioplayer.css">
                    <video id="video" style="max-width: 75%; max-height: 90vh;" poster="/videodata/poster.php?id='.$params['v'].'" autoplay controls>
                    <source src="/videodata/media.php?type=audiouhqserver1'.$dlsetting.'&id='.$params['v'].'" type="audio/webm" label="Lossless Quality 1">
                    <source src="/videodata/media.php?type=audiouhqserver2'.$dlsetting.'&id='.$params['v'].'" type="audio/webm" label="Lossless Quality 2">
                    <source src="/videodata/media.php?type=audiohqserver1'.$dlsetting.'&id='.$params['v'].'" type="audio/webm" label="High Quality 1">
                    <source src="/videodata/media.php?type=audiohqserver2'.$dlsetting.'&id='.$params['v'].'" type="audio/webm" label="High Quality 2">
                    <source src="/videodata/media.php?type=audiolqserver1'.$dlsetting.'&id='.$params['v'].'" type="audio/webm" label="Low Quality 1">
                    <source src="/videodata/media.php?type=audiolqserver2'.$dlsetting.'&id='.$params['v'].'" type="audio/webm" label="Low Quality 2">
                    <track kind="captions" src="/videodata/captions.php?server=1&id='.$params['v'].'" label="English 1">
                    <track kind="captions" src="/videodata/captions.php?server=2&id='.$params['v'].'" label="English 2">
                    Your Browser Sucks! Can not play the audio.
                    </video>';
            }
            else {
                echo '<video id="video" class="video-js" style="max-width: 75%; max-height: 90vh;" poster="/videodata/poster.php?id='.$params['v'].'" autoplay controls>
                    <source src="/videodata/media.php?type=hd720server1'.$dlsetting.'&id='.$params['v'].'" type="video/mp4" label="hd720">
                    <source src="/videodata/media.php?type=hd720server2'.$dlsetting.'&id='.$params['v'].'" type="video/mp4" label="hd720">
                    <source src="/videodata/media.php?type=mediumserver1'.$dlsetting.'&id='.$params['v'].'" type="video/mp4" label="medium">
                    <source src="/videodata/media.php?type=mediumserver2'.$dlsetting.'&id='.$params['v'].'" type="video/mp4" label="medium">
                    <track kind="captions" src="/videodata/captions.php?server=1&id='.$params['v'].'" label="English 1">
                    <track kind="captions" src="/videodata/captions.php?server=2&id='.$params['v'].'" label="English 2">
                    Your Browser Sucks! Can not play the video.
                    </video>';
            }
        ?>
        <script src="/scripts/playermain.js"></script>
<script src="/scripts/sidebar.js"></script>
    </center>
        <br>
        <center>
        <div align="center" style="width: 92%; max-width: 300px; border-radius: 6px;">

        <textarea hidden id="textbox" value="<?php echo $url; ?>"><?php echo $url; ?></textarea><br />
        
        
</div><a class="popup button" onclick="myFunction(), copyText()">
          <span class="popuptext" id="myPopup">URL Copied.</span>Share</a>

<a class="button" onclick="Alert.render('ok')">Download</a>
<a class="button" href="/channel/?id=<?php echo $authorId; ?>"><?php echo $author; ?> · <?php echo $autsubs; ?></a>
</center>
<div id="boxerlay"></div>
<div id="popUpBox">
<div id="box">
<h3> Right click > Save video as / Save audio as </h3><br>
<h4>Video</h4>
<a class="button" href="/videodata/media.php/?type=hd720server1&id=<?php echo $params['v']; ?>&dl=dl" download="<?php echo $params['v']?>.mp4"> 720p MP4 (Server 1)</a><a class="button" href="/videodata/media.php/?type=hd720server2&id=<?php echo $params['v']; ?>&dl=dl" download="<?php echo $params['v']?>.mp4"> 720p MP4 (Server 2)</a><br>
<a class="button" href="/videodata/media.php/?type=mediumserver1&id=<?php echo $params['v']; ?>&dl=dl" download="<?php echo $params['v']?>.mp4"> 360p MP4 (Server 1)</a><a class="button" href="/videodata/media.php/?type=mediumserver2&id=<?php echo $params['v']; ?>&dl=dl" download="<?php echo $params['v']?>.mp4"> 360p MP4 (Server 2)</a><br><br>
<h4>Audio</h4>
<a class="button" href="/videodata/media.php/?type=audiolqserver1&id=<?php echo $params['v']; ?>&dl=dl" download="<?php echo $params['v']?>.webm"> Low Quality WebM (Server 1)</a><a class="button" href="/videodata/media.php/?type=audiolqserver2&id=<?php echo $params['v']; ?>&dl=dl" download="<?php echo $params['v']?>.webm"> Low Quality WebM (Server 2)</a><br>
<a class="button" href="/videodata/media.php/?type=audiohqserver1&id=<?php echo $params['v']; ?>&dl=dl" download="<?php echo $params['v']?>.webm"> High Quality WebM (Server 1)</a><a class="button" href="/videodata/media.php/?type=audiohqserver2&id=<?php echo $params['v']; ?>&dl=dl" download="<?php echo $params['v']?>.webm"> High Quality WebM (Server 2)</a><br>
<a class="button" href="/videodata/media.php/?type=audiouhqserver1&id=<?php echo $params['v']; ?>&dl=dl" download="<?php echo $params['v']?>.webm"> Lossless Quality WebM (Server 1)</a><a class="button" href="/videodata/media.php/?type=audiouhqserver2&id=<?php echo $params['v']; ?>&dl=dl" download="<?php echo $params['v']?>.webm"> Lossless Quality WebM (Server 2)</a><br><br>
<div id="closeModal"></div>
</div>
</div>
<h6></h6>
     <?php
function makeUrltoLink($string) {
 $reg_pattern = "/(((http|https|ftp|ftps)\:\/\/)|(www\.))[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,12}(\:[0-9]+)?(\/\S*)?/";
 return preg_replace($reg_pattern, '<a href="$0" target="_blank" rel="noopener noreferrer">$0</a>', $string);
}

$str = ($description);
$cdesc = nl2br($convertedStr = makeUrltoLink($str));

$cdesc = str_replace('href="https://youtu.be/','href="/watch?v=',$cdesc);
$cdesc = str_replace('href="https://www.youtube.com/watch?v=','href="/watch?v=',$cdesc);
?>
<small>
 <h2 style="text-align: center;"> <?php echo $title; ?> <br></h2></small>
 <b><h4 style="text-align: center;"><?php echo $shared; ?> · <?php echo $views; ?> views · <?php echo $likes; ?> likes<?php echo $dislikes; ?></h4></b> <br> <details><summary><a class="button">Show/Hide Description</a><br><br></summary> <a class="button" href="//youtu.be/<?php echo $params['v']?>">Watch on YouTube</a><a class="button" href="//redirect.invidious.io/<?php echo $params['v']?>">Watch on Invidious</a><a class="button">Switch Instance</a><hr class="hr"><?php echo $cdesc; ?> </details>



 <?php if(!empty($response)) { ?>
        <?php }?>
        <?php                        
                $InvApiUrl = $InvCServer.'/api/v1/comments/'.$params['v'].'?region=GB&hl=en';

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $InvApiUrl);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_VERBOSE, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);
                curl_close($ch);
                $data = json_decode($response);
                $value = json_decode(json_encode($data), true);
                $ccount = $value['commentCount'] ?? "";
                
                echo '<br><br><br><br><h2>'.number_format($ccount).' Comments</h2><br>';

                if ($ccount > 20) {
                $ccountl = "20";
                }
                else {
                    $ccountl = $ccount - "1";
                }

                for ($i = 0; $i < $ccountl; $i++) {
                    $aname = $value['comments'][$i]['author'] ?? "";
                    $aturl = $value['comments'][$i]['authorThumbnails']['0']['url'] ?? "";
                    $acon = $value['comments'][$i]['content'] ?? "";
                    $ptex = $value['comments'][$i]['publishedText'] ?? "";
                    $alik = $value['comments'][$i]['likeCount'] ?? "";
                    $auid = $value['comments'][$i]['authorId'] ?? "";

                    $commentreplycontinuation = $value['comments'][$i]['replies']['continuation'] ?? "";
                    $commentreplyamount = $value['comments'][$i]['replies']['replyCount'] ?? "";

                    $nextpagestr = $value['continuation'] ?? "";

                        $InvApiUrl = $InvCServer.'/api/v1/comments/'.$params['v'].'?region=GB&hl=en&continuation='.$commentreplycontinuation;

                        $ch = curl_init();
        
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_URL, $InvApiUrl);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                        curl_setopt($ch, CURLOPT_VERBOSE, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        $response = curl_exec($ch);
                        curl_close($ch);
                        $data = json_decode($response);
                        $value_reply = json_decode(json_encode($data), true);
                        $ccount_reply = substr_count($response,"authorIsChannelOwner");

                        if ($ccount_reply > 20) {
                            $ccountl_reply = "20";
                            }
                            else {
                                $ccountl_reply = $ccount_reply - "1";
                            }
                    ?>
<div style="width: 100%; max-width: 775px;">
                    <h4><img style="margin-bottom: -25px;" src=<?php echo $aturl; ?>> <a href="/channel/?id=<?php echo $auid.'">'.$aname."</a>"; ?> · <?php echo $ptex; ?> · <?php echo number_format($alik)." likes"; ?>
                    </h4>
                    <br><h5 style="margin-left: 53px; margin-top: -25px;"><?php echo $acon; 
                    
                        if ($commentreplyamount != "") {?>

                        <details><summary>show <?php echo $commentreplyamount; ?> replies</summary><?php

                            for ($ii = 0; $ii < $ccountl_reply; $ii++) {
                                $aname_reply = $value_reply['comments'][$ii]['author'] ?? "";
                        $aturl_reply = $value_reply['comments'][$ii]['authorThumbnails']['0']['url'] ?? "";
                        $acon_reply = $value_reply['comments'][$ii]['content'] ?? "";
                        $ptex_reply = $value_reply['comments'][$ii]['publishedText'] ?? "";
                        $alik_reply = $value_reply['comments'][$ii]['likeCount'] ?? "";
                        $auid_reply = $value_reply['comments'][$ii]['authorId'] ?? "";
                             ?>

                            <div style="width: 100%; max-width: 775px;">
                            <h4><img style="margin-bottom: -25px;" src=<?php echo $aturl_reply; ?>> <a href="/channel/?id=<?php echo $auid.'">'.$aname_reply."</a>"; ?> · <?php echo $ptex_reply; ?> · <?php if($alik_reply > -1){echo number_format($alik_reply)." likes";} ?>
                            </h4>
                            <br><h5 style="margin-left: 53px; margin-top: -25px;"><?php echo $acon_reply; ?></h5><br>

                       <?php } }?></details></h5>
                    <br><br>
                </div>  
           <?php 
                    }
            ?> 
            </div>
            </div>
        <title><?php echo $title; ?> · Liberatube</title>
</div> 
</div>
         </body>
         </html>
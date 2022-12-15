<?php
session_start();
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
include('../config.php');
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
                echo '<link rel="stylesheet" href="../styles/playerdark.css">';
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
  <a href="#" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">live_tv</span></a>
  <a href="../so/?w=<?php echo $params['w']; ?>" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">headphones</span></a>
</div>

<div class="w3-main" style="margin-left:55px">
<div class="w3-tssseal">
  <button class="w3-button w3-darkgrey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
  </div>
</div>
 <?php
                $InvApiUrl = $InvVIServer.'/api/v1/videos/' . $params['w'] . '?fields=title,description,viewCount,subCountText,likeCount,author,authorId&pretty=1';

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
                    $authorid = $value['authorId'];
                    $autsubs = $value['subCountText'];
                    ?> 

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta property="og:title" content="<?php echo $title; ?>">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://badyt.cf/vi/?w=<?php echo $params['w']; ?>">
        <meta name="theme-color" content="#303EE1">
        <meta name="author" content="<?php echo $title; ?>">
         <meta name="keywords" content="badyt.cf, badyt, EpicFaucet, two.epicfaucet.gq, yewtu.be, online videos, alternative youtube frontend, Bad YouTube">
         <meta property="og:locale" content="en_US">
         <meta property="og:description" content="<?php echo $value['description']; ?>">
            <meta property="description" content="<?php echo $value['description']; ?>">
<meta name="og:image" content="https://yewtu.be/vi/<?php echo $params['w']; ?>/maxres.jpg"/>

<link itemprop="thumbnailUrl" href="https://i.ytimg.com/vi/<?php echo $params['w']; ?>/maxresdefault.jpg">
<meta name="twitter:card" content="summary_large_image">
<span itemprop="thumbnail" itemscope itemtype="http://schema.org/ImageObject">
<link itemprop="url" href="https://invidious.epicsite.xyz/embed/<?php echo $params['w']; ?>">
<meta itemprop="width" content="1280">
<meta itemprop="height" content="720">
</span>
<link itemprop="embedUrl" href="https://invidious.epicsite.xyz/embed/<?php echo $params['w']; ?>">
<meta itemprop="playerType" content="HTML5 Flash">
<meta itemprop="width" content="1280">
<meta itemprop="height" content="720">

<meta property="og:type" content="video.other">
<meta property="og:video" content="/videodata/mediumserver2.php?id=<?php echo $params['w']; ?>">
<meta property="og:video:url" content="/videodata/mediumserver2.php?id=<?php echo $params['w']; ?>">
<meta property="og:video:secure_url" content="/videodata/mediumserver2.php?id=<?php echo $params['w']; ?>">
<meta property="og:video:type" content="text/html">
<meta property="og:video:width" content="640">
<meta property="og:video:height" content="480">
<span><meta property="og:site_name" content="Bad YouTube">
<link itemprop="name" content="Bad YouTube"></span></head>
<script src="../scripts/playermain.js"></script>

<div class="tenborder">
<br>
<center><video id="my-video" class="video-js" style="max-width: 75%; max-height: 90vh;" poster="/videodata/posterdirect.php?id=<?php echo $params['w']; ?>" autoplay controls>
        <source src="/videodata/hd720server1.php?id=<?php echo $params['w']; ?>" type="video/mp4" label="hd720">
        <source src="/videodata/hd720server2.php?id=<?php echo $params['w']; ?>" type="video/mp4" label="hd720">
        <source src="/videodata/mediumserver1.php?id=<?php echo $params['w']; ?>" type="video/mp4" label="medium">
        <source src="/videodata/mediumserver2.php?id=<?php echo $params['w']; ?>" type="video/mp4" label="medium">
        <track kind="captions" src="/videodata/captionserver1.php?id=<?php echo $params['w']; ?>" label="English 1">
        <track kind="captions" src="/videodata/captionserver2.php?id=<?php echo $params['w']; ?>" label="English 2">
        Your Browser Sucks! Can't play the video.
        </video></center>
        <br>
        <center>
        <div align="center" style="width: 92%; max-width: 300px; border-radius: 6px;">

        <textarea hidden id="textbox" value="<?php echo $url; ?>"><?php echo $url; ?></textarea><br />
        <div class="popup button" onclick="myFunction(), copyText()">
        Share
  <span class="popuptext" id="myPopup">URL Copied.</span>
</div>
<a class="button" onclick="Alert.render('ok')">Download</a>
    </div>
</center>
<div id="boxerlay"></div>
<div id="popUpBox">
<div id="box">
<h3> I can't be bothered to make a downloader maybe youll see it in a <br>future update who knows. Yes i know you can just click the 3 dots<br> and click download but like all the qualities and that...<br>Heres the current url of the site btw: </h3>

<a href="/videodata/hd720server2.php/?id=<?php echo $params['w']; ?>&dl=true" download="<?php echo $params['w']?>.mp4"> TEST DL HD720 (SERVER 2) </a>

<h3 style="color: #00ffff;" id="myInput" value="<?php echo $url; ?>"><?php echo $url; ?></h3>
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

$cdesc = str_replace('href="https://youtu.be/','href="/vi/?w=',$cdesc);
$cdesc = str_replace('href="https://www.youtube.com/watch?v=','href="/vi/?w=',$cdesc);
?>

 <h2 style="text-align: center;"> <?php echo $title; ?> <br>
 <b><h4><?php echo $author.': '.$autsubs.' Subscribers'; ?> | <?php echo $views; ?> views | <?php echo $likes; ?> likes </h4></b> <br> <small style="text-align: left;"> <?php echo $cdesc; ?> </h2> </small>



 <?php if(!empty($response)) { ?>
        <?php }?>
        <?php                        
              if (1 == 1)
              {
                $InvApiUrl = $InvCServer.'/api/v1/comments/'.$params['w'].'?region=GB&hl=en';

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
                    $nextpagestr = $value['continuation'] ?? "";
                    ?>
<div style="width: 100%; max-width: 775px;">
                    <h4><img style="margin-bottom: -25px;" src=<?php echo $aturl; ?>> <?php echo $aname; ?> | <?php echo $ptex; ?> | <?php echo number_format($alik)." likes"; ?>
                    </h4>
                    <br><h5 style="margin-left: 53px; margin-top: -25px;"><?php echo $acon; ?></h5>
                    <br><br>
                </div>
                       
           <?php 
                    }
            }
            ?> 
            </div>
            </div>
        <title><?php echo $title; ?> | Bad YouTube</title>
        
</div> 
</div>

         </body>
         </html>
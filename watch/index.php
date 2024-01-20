<?php
session_start();  
include('../config.php');

if ($useSQL == true) {
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


<?php
                $InvApiUrl = $InvVIServer.'/api/v1/videos/' . $params['v'] . '?hl=en';

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

                    $nonHlsUrls = [];
                    $nonHlsItag = [];
                    $nonHlsQuality = [];
                    $nonHlsType = [];
                    $nonHlsSize = [];

                    $HlsUrls = [];
                    $HlsItag = [];
                    $HlsQuality = [];
                    $HlsType = [];
                    $HlsSize = [];

                    if (isset($value['formatStreams']) && is_array($value['formatStreams'])) {
                        foreach ($value['formatStreams'] as $formatStream) {
                            if (isset($formatStream['url'])) {
                                $nonHlsUrls[] = $formatStream['url'];
                                $nonHlsItag[] = $formatStream['itag'];
                                $nonHlsQuality[] = $formatStream['qualityLabel'];
                                $nonHlsType[] = $formatStream['container'];
                                $nonHlsSize[] = $formatStream['size'];
                            }
                        }
                    }
                    if (isset($value['adaptiveFormats']) && is_array($value['adaptiveFormats'])) {
                        foreach ($value['adaptiveFormats'] as $formatStream) {
                            if (isset($formatStream['url'])) {
                                $HlsUrls[] = $formatStream['url'];
                                $HlsItag[] = $formatStream['itag'];
                                $HlsQuality[] = $formatStream['qualityLabel'];
                                $HlsType[] = $formatStream['container'];
                                $HlsSize[] = $formatStream['size'];
                            }
                        }
                    }

if ($useReturnYTDislike == true) {
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
        <meta property="og:description" content="<?php echo $description; ?>">
        <meta property="description" content="<?php echo $description; ?>">

<meta name="og:image" content="<?php echo $InvVIServer ?>/vi/<?php echo $params['v']; ?>/maxres.jpg"/>
<meta name="twitter:card" content="summary_large_image">

<span><meta property="og:site_name" content="Liberatube">
<link itemprop="name" content="Liberatube"></span></head>

<link rel="stylesheet" href="/styles/-w3.css">
<link rel="stylesheet" href="/styles/-bootstrap.min.css">
<link rel="stylesheet" href="/styles/-googlesymbols.css">

<?php
if ($useSQL == true) {
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
        $regionrow = $row['region'];
        $loadcomments = $row['loadcomments'];
        $userproxysetting = $row['proxy'];

    }
    $row = mysqli_fetch_assoc($query);
    $numrows = mysqli_num_rows($query);
    }
    if(strcmp($themerow, 'blue') == 0)
    {
        echo '<link rel="stylesheet" href="../styles/playerblue.css">';
    } elseif(strcmp($themerow, 'ultra-dark') == 0)
    {
        echo '<link rel="stylesheet" href="../styles/playerultra-dark.css">';
    } else 
    {
        echo '<link rel="stylesheet" href="../styles/player'.$defaultTheme.'.css">';
    } 
    } else {
        echo '<link rel="stylesheet" href="../styles/player'.$defaultTheme.'.css">';
    }
                ?>

<div class="w3-sidebar w3-bar-block w3-collapse w3-card sidebar" style="width:55px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">&times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">home</span></a>
  <?php
  if ($useSQL == true) { ?>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">history</span></a>
  <a href="/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">list_alt</span></a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">subscriptions</span></a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">settings</span></a>
  <?php } ?>
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
 

<div class="tenborder">
<br>
<center>
            <?php
            if ($userproxysetting == "on" and $allowProxy = "true") {
                $dlsetting = "&dl=true";
            } else {
                $dlsetting = "&dl=false";
            }
            if(strcmp($playerrow, 'vjs') == 0) {
                echo '<link rel="stylesheet" href="../styles/-video-js.css"> <script src="../scripts/-video.min.js"></script>';
                $videosizingcss = 'style="max-width: 90vw"';
            } else {
                $videosizingcss = 'style="max-width: 90%; max-height: 90vh;"';
            }
            if ($params['listen'] == "true") {
                
                echo '<link rel="stylesheet" href="../styles/audioplayer.css">
                    <video id="video" class="video-js video" controls preload="auto" data-setup="{}" '.$videosizingcss.' poster="/videodata/poster.php?id='.$params['v'].'" autoplay controls>
                    <source src="/videodata/hls.php?id='.$params['v'].$dlsetting.'" type="audio/webm">
                    <track kind="captions" src="/videodata/captions.php?server=1&id='.$params['v'].'" label="English 1">
                    <track kind="captions" src="/videodata/captions.php?server=2&id='.$params['v'].'" label="English 2">
                    Your Browser Sucks! Can not play the audio.
                    </video>';
            }
            else {
                echo '<video id="video" class="video-js video" controls preload="auto" data-setup="{}" '.$videosizingcss.' poster="/videodata/poster.php?id='.$params['v'].'" autoplay controls>
                    <source src="/videodata/non-hls.php?id='.$params['v'].$dlsetting.'" type="video/mp4">
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
<?php
if ($allowProxy == "true" or $allowProxy == "downloads") {
    $isProxyDisabled = "";
} else {
    $isProxyDisabled = "disabled";
    $isProxyDisabledMessage = "Proxying is disabled by this instance.";
}
?>
<h3>Download this video</h3>
<table>
<?php
echo $isProxyDisabledMessage;
?>
<tr><td><h4>Non HLS options:</h4></td></tr>
<?php
if (isset($nonHlsItag) && is_array($nonHlsItag) && !empty($nonHlsItag)) {
    // Loop through the $nonHlsItag array
    for ($i = 0; $i < count($nonHlsItag); $i++) {
        $itag = $nonHlsItag[$i];
        $url = $nonHlsUrls[$i];
        $quality = $nonHlsQuality[$i];
        $type = $nonHlsType[$i];
        $size = $nonHlsSize[$i];

        // Output HTML buttons for each itag value along with other corresponding values
        echo '<tr><td>'.$quality.'('.$itag.') - '.$type.'</td><td><a class="button-in-table" href="'.$url.'">Direct</a><a download="'.$params['v'].'.'.$type.'" class="button-in-table" href="/videodata/non-hls.php?id='.$params['v'].'&dl=dl&itag='.$itag.'">Proxy</a></td></tr>';
    }
}
?>
<tr><td><h4>HLS options:</h4></td></tr>
<?php
if (isset($HlsItag) && is_array($HlsItag) && !empty($HlsItag)) {
    // Loop through the $HlsItag array
    for ($i = 0; $i < count($HlsItag); $i++) {
        $itag = $HlsItag[$i];
        $url = $HlsUrls[$i];
        $quality = $HlsQuality[$i];
        $type = $HlsType[$i];
        $size = $HlsSize[$i];

        // Output HTML buttons for each itag value along with other corresponding values
        echo '<tr><td>'.$quality.'('.$itag.') - '.$type.'</td><td><a class="button-in-table" href="'.$url.'">Direct</a><a download="'.$params['v'].'.'.$type.'" class="button-in-table" href="/videodata/hls.php?id='.$params['v'].'&dl=dl&itag='.$itag.'">Proxy</a></td></tr>';
    }
}
?>
</table>
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



 <?php

    if ($_GET['comments']) {
        $loadcomments = $_GET['comments'];
    }
    if ($loadcomments) {} else {
        $loadcomments = $defaultLoadCommentsSetting;
    }
    if ($loadcomments != "nothing") {
 
    if(!empty($response)) { ?>
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

                    if ($loadcomments != "noreplies") {
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
                            } }
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
                } else {
                    echo '<a class="button" href="?v='.$params['v'].'&comments=noreplies">Load Comments</a>';
                }
            ?> 
            </div>
            </div>
        <title><?php echo $title; ?> · Liberatube</title>
</div> 
</div>
</body>
</html>
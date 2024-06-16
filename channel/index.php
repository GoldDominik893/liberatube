<?php
session_start();  
include('../config.php');
$langrow = $defaultLang;
include('../lang.php');

if ($useSQL == true) {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['logged_in_user']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc())
    {   
        $pwrow = $row['password'];
        $customthemehomerow = $row['customtheme_home_url'];
        $langrow = $row['lang'];
    }
    if ($_SESSION['hashed_pass'] == $pwrow) {
    } else {
        session_destroy();
    }
} else {
    session_destroy();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Liberatube · <?php echo $translations[$langrow]['channel']; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="Liberatube">
<link rel="apple-touch-icon" href="favicon.ico">
        <link rel="stylesheet" href="/styles/-w3.css">
<link rel="stylesheet" href="/styles/-bootstrap.min.css">

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
    $stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['logged_in_user']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc())
    {
        $themerow = $row['theme'];
        $regionrow = $row['region'];
        $loadcomments = $row['loadcomments'];
        $userproxysetting = $row['proxy'];
        $playerrow = $row['player'];
    }
    if(strcmp($themerow, 'blue') == 0) {
        echo '<link rel="stylesheet" href="../styles/homeblue.css">';
    } elseif(strcmp($themerow, 'ultra-dark') == 0) {
        echo '<link rel="stylesheet" href="../styles/homeultra-dark.css">';
    } elseif ($themerow == "custom") {
        echo '<link rel="stylesheet" href="'.$customthemehomerow.'">';
    } else {
        echo '<link rel="stylesheet" href="../styles/home'.$defaultTheme.'.css">';
    } 
    } else {
        echo '<link rel="stylesheet" href="../styles/home'.$defaultTheme.'.css">';
    }
}
?>
    <body>
    <div class="w3-sidebar w3-bar-block w3-collapse w3-card sidebar" style="width:55px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">&times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">home</span><span class="tooltiptext"><?php echo $translations[$langrow]['home']; ?></span></a>
  <?php
  if ($useSQL == true) { ?>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">history</span><span class="tooltiptext"><?php echo $translations[$langrow]['watch_history']; ?></span></a>
  <a href="/playlist/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">list_alt</span><span class="tooltiptext"><?php echo $translations[$langrow]['playlists']; ?></span></a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">subscriptions</span><span class="tooltiptext"><?php echo $translations[$langrow]['subscriptions']; ?></span></a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">settings</span><span class="tooltiptext"><?php echo $translations[$langrow]['settings']; ?></span></a>
  <?php } ?>
  <hr class="hr">
  <a href="#" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">person</span><span class="tooltiptext"><?php echo $translations[$langrow]['channel']; ?></span></a>
</div>

<div class="w3-main" style="margin-left:55px">
<div class="w3-tssseal">
  <button class="w3-button w3-darkgrey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
  <div class="topbar">
    <div class="topbarelements topbarelements-center">
    <h3 class="title-top topbarelements">Liberatube</h3>
    <form class="input-row topbarelements" id="keywordForm" method="get" action="/search/">
                    <input class="input-field" type="search" id="keyword" name="q" placeholder="<?php echo $translations[$langrow]['search_yt']; ?>" value="<?php echo $keyword; ?>">
            </form>
    </div>

    <?php if ($useSQL == true) { ?>
    <div class="topbarelements topbarelements-right">
    <h4> <?php echo $_SESSION['logged_in_user'] ?? ""; 
    $loggedinuser = $_SESSION['logged_in_user'] ?? "";?> 
    <?php if($loggedinuser != "")
    {
        echo '<a class="button awhite login-item" href="/auth/logout.php"><span class="material-symbols-outlined login-item-icon">logout</span><h5 class="login-item-text">'.$translations[$langrow]['logout'].'</h5></a>';
    }
    else
    {
        echo '<a class="button awhite login-item" href="/auth/login.html"><span class="material-symbols-outlined login-item-icon">login</span><h5 class="login-item-text">'.$translations[$langrow]['login-signup'].'</h5></a>';
    }
    ?>
    </div>
    <?php } ?>

    </div>
        </div>
</div>
<script src="/scripts/sidebar.js"></script>
<div class="tenborder">
        
        <?php if(!empty($response)) { ?>
                <div class="response <?php echo $response["type"]; ?>"> <?php echo $response["message"]; ?> </div>
        <?php }?>
        <?php    
                $InvApiUrl = $InvVIServer.'/api/v1/channels/'.$_GET['id'].'?hl='.$langrow.'&sort_by='.$_GET['sort_by'];    
                
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

                $authorc = $value['author'] ?? "";
                $bannerUrl = $value['authorBanners'][1]['url'] ?? "";
                $subcount = number_format($value['subCount']) ?? "";
                $joined = $value['joined'] ?? "";
                $channelDescription = $value['description'];
                $channelPfpUrl = $value['authorThumbnails'][5]['url'] ?? "";

                if($_GET['q']){
                $InvApiUrl = $InvVIServer.'/api/v1/channels/search/'.$_GET['id'].'?hl='.$langrow.'&q='.$_GET['q'];
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
                $value_search = json_decode(json_encode($data), true);
                }   
                ?>

                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta property="og:title" content="<?php echo $authorc; ?>">
                    <meta property="og:type" content="website">
                    <meta name="theme-color" content="#303EE1">
                    <meta name="keywords" content="libretube, badyt.cf, liberatube, EpicFaucet, two.epicfaucet.gq, yewtu.be, alternative youtube frontend, Liberatube, invidious">
                    <meta property="og:locale" content="en_GB">
                    <meta property="og:description" content="<?php echo $channelDescription; ?>">
                    <meta property="description" content="<?php echo $channelDescription; ?>">
                    <meta name="og:image" content="<?php echo $channelPfpUrl; ?>"/>

                    <span><meta property="og:site_name" content="Liberatube">
                    <link itemprop="name" content="Liberatube"></span></head>

                <?php

                $pl = file_get_contents($InvVIServer.'/api/v1/channels/'.$_GET['id'].'/playlists/?hl='.$langrow);
                $plitemsint = substr_count($pl,"playlistThumbnail");


                if ($_GET['type'] == "videos" or $_GET['type'] == "")
                {
                echo '<div class="search-form-container">

                <img src="'.$bannerUrl.'" style="max-width: 100%; margin-bottom: 10px;">
                <div style="display: flex;">
                <img style="width: 100px; margin-bottom: 10px; height: 100px;" src="'.$channelPfpUrl.'">
                <div style="margin-left: 5px;">
                    <h4 style="margin-top: 2px;">'.$authorc.': '.$subcount.' '.$translations[$langrow]['subscribers'].'</h4>
                    <p>'.$channelDescription.'</p>
                </div>
                </div>
                


                    <a class="trending-cat-btn trending-cat-btn-selected" href="#">'.$translations[$langrow]['videos'].'</a>';
                    if ($_GET['sort_by'] == "latest" or $_GET['sort_by'] == "") {
                        echo '
                            <a class="trending-cat-btn trending-cat-btn-selected" href="#">'.$translations[$langrow]['latest'].'</a>
                            <a class="trending-cat-btn" href="/channel/?id='.$_GET['id'].'&type=videos&sort_by=popular">'.$translations[$langrow]['popular'].'</a>
                            <a class="trending-cat-btn" href="/channel/?id='.$_GET['id'].'&type=videos&sort_by=oldest">'.$translations[$langrow]['oldest'].'</a>';
                    } elseif ($_GET['sort_by'] == "popular") {
                        echo '
                            <a class="trending-cat-btn" href="/channel/?id='.$_GET['id'].'&type=videos&sort_by=latest">'.$translations[$langrow]['latest'].'</a>
                            <a class="trending-cat-btn trending-cat-btn-selected" href="#">'.$translations[$langrow]['popular'].'</a>
                            <a class="trending-cat-btn" href="/channel/?id='.$_GET['id'].'&type=videos&sort_by=oldest">'.$translations[$langrow]['oldest'].'</a>';
                    } elseif ($_GET['sort_by'] == "oldest") {
                        echo '
                            <a class="trending-cat-btn" href="/channel/?id='.$_GET['id'].'&type=videos&sort_by=latest">'.$translations[$langrow]['latest'].'</a>
                            <a class="trending-cat-btn" href="/channel/?id='.$_GET['id'].'&type=videos&sort_by=popular">'.$translations[$langrow]['popular'].'</a>
                            <a class="trending-cat-btn trending-cat-btn-selected" href="#">'.$translations[$langrow]['oldest'].'</a>';
                    }
                echo '    
                        <form class="input-row topbarelements" id="keywordForm" method="get" action="/channel/">
                            <div class="input-row">
                                <input style="margin-bottom: -32px; background-color: rgb(27, 27, 27); border: none; border-radius: 6px; height: 27px;" class="input-field" type="search" id="keyword" name="q" placeholder="'.$translations[$langrow]['search_this_channel'].'" value="'.$_GET['q'].'">
                                <input type="hidden" id="id" name="id" value="'.$_GET['id'].'">
                            </div>
                        </form>
                
                
                <a class="trending-cat-btn" href="/channel/?id='.$_GET['id'].'&type=playlists">'.$translations[$langrow]['playlists'].'</a><br>';
            }
                elseif ($_GET['type'] == "playlists") 
                {
                echo '<div class="search-form-container">
                <img src="'.$bannerUrl.'" style="max-width: 100%; margin-bottom: 10px;">
                <div style="display: flex;">
                <img style="width: 100px; margin-bottom: 10px; height: 100px;" src="'.$channelPfpUrl.'">
                <div style="margin-left: 5px;">
                    <h4 style="margin-top: 2px;">'.$authorc.': '.$subcount.' '.$translations[$langrow]['subscribers'].'</h4>
                    <p>'.$channelDescription.'</p>
                </div>
                </div>

                    <a class="trending-cat-btn" href="/channel/?id='.$_GET['id'].'&type=videos">'.$translations[$langrow]['videos'].'</a>
                    <a class="trending-cat-btn trending-cat-btn-selected" href="#">'.$translations[$langrow]['playlists'].'</a><br>'; }
                
                ?>

            <br>
            <div class="videos-data-container" id="SearchResultsDiv">
            
<div style="text-align: center;">
            <?php
            $vidcount = substr_count($response,"videoThumbnails");

            if ($_GET['type'] == "videos" or $_GET['type'] == "") 
            {
                for ($i = 0; $i < $vidcount; $i++) {
                    if ($_GET['q'] == False) {
                        $title = $value['latestVideos'][$i]['title'] ?? "";
                        $videoId = $value['latestVideos'][$i]['videoId'] ?? "";
                        $publishedText = $value['latestVideos'][$i]['publishedText'] ?? "";
                        $viewCountText = $value['latestVideos'][$i]['viewCountText'] ?? "";

                        $lengthseconds = $value['latestVideos'][$i]['lengthSeconds'] ?? "";
                        $vidhours = floor($lengthseconds / 3600) ?? "";
                        $vidmins = floor($lengthseconds / 60 % 60) ?? "";
                        $vidsecs = floor($lengthseconds % 60) ?? "";
                        if ($vidhours == "0") {
                            $timestamp = $vidmins.':'.$vidsecs ?? "";
                        } else {
                            $timestamp = $vidhours.':'.$vidmins.':'.$vidsecs ?? "";
                        }
                    } elseif ($_GET['q']) {
                        $title = $value_search[$i]['title'] ?? "";
                        $videoId = $value_search[$i]['videoId'] ?? "";
                        $publishedText = $value_search[$i]['publishedText'] ?? "";
                        $viewCountText = $value['latestVideos'][$i]['viewCountText'] ?? "";

                        $lengthseconds = $value_search[$i]['lengthSeconds'] ?? "";
                        $vidhours = floor($lengthseconds / 3600) ?? "";
                        $vidmins = floor($lengthseconds / 60 % 60) ?? "";
                        $vidsecs = floor($lengthseconds % 60) ?? "";
                        if ($vidhours == "0") {
                            $timestamp = $vidmins.':'.$vidsecs ?? "";
                        } else {
                            $timestamp = $vidhours.':'.$vidmins.':'.$vidsecs ?? "";
                        }
                    }
                    
                    ?>


                    <a class="awhite" href="/watch/?v=<?php echo $videoId; ?>">
                       <div class="video-tile w3-animate-left">
                        <div class="videoDiv">
                        <img src="http://i.ytimg.com/vi/<?php echo $videoId; ?>/mqdefault.jpg" height="144px">
                        <div class="timestamp"><?php echo $timestamp; ?></div>
                        </div>
                        <div class="videoInfo">
                        <div class="videoTitle"><b><?php echo $title; ?></b><br><?php echo $publishedText; ?>  <div style="float: right;"><?php echo $viewCountText; ?></div>  </div>
                        </div>
                        </div>
                        </a>
           <?php 
                    }
                } elseif ($_GET['type'] == "playlists") {
                    $InvApiUrl = $InvVIServer.'/api/v1/channels/'.$_GET['id'].'/playlists?hl=en';

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
                    for ($i = 0; $i < $plitemsint; $i++) {
                        $title = $value['playlists'][$i]['title'] ?? "";
                        $videoId = $value['playlists'][$i]['playlistId'] ?? "";
                        $plThumb = $value['playlists'][$i]['playlistThumbnail'] ?? "";
                        ?>
    
    
                        <a class="awhite" href="/playlist/?id=<?php echo $videoId; ?>">
                           <div class="video-tile w3-animate-left">
                            <div class="videoDiv">
                            
                            <img src="<?php echo $plThumb; ?>" height="144px">
                            
                            <div><?php echo $timestamp; ?></div>
                            </div>
                            <div class="videoInfo">
                            <div class="videoTitle"><b><?php echo $title; ?></b></div>
    
                            </div>
                            </div>
                            </a>
               <?php }
                        } ?>

            </div>
        </div>
        </div>
    </body>
</html>
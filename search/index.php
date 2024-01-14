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

$keyword = $params['q'];
$resultsmaximum = $params['maxresults'];


    $resultsmaximum = 20;

    define("MAX_RESULTS", $resultsmaximum);

    
     if (isset($_POST['submit']) )
     {   
        if (empty($keyword))
        {
            $response = array(
                  "type" => "error",
                  "message" => "Please enter the keyword."
                );
        } 
    }
         
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Liberatube · Search Results</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="/styles/-w3.css">
<link rel="stylesheet" href="/styles/-bootstrap.min.css">
<link rel="stylesheet" href="/styles/-googlesymbols.css">
        <script src="/scripts/sidebar.js"></script>
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
    }
    $row = mysqli_fetch_assoc($query);
    $numrows = mysqli_num_rows($query);
    }
    if(strcmp($themerow, 'blue') == 0)
    {
        echo '<link rel="stylesheet" href="../styles/homeblue.css">';
    } elseif(strcmp($themerow, 'ultra-dark') == 0)
    {
        echo '<link rel="stylesheet" href="../styles/homeultra-dark.css">';
    } else 
    {
        echo '<link rel="stylesheet" href="../styles/home'.$defaultTheme.'.css">';
    } 
    } else {
        echo '<link rel="stylesheet" href="../styles/home'.$defaultTheme.'.css">';
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
  <a href="#" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">search</span></a>
</div>

<div class="w3-main" style="margin-left:55px">
<div class="w3-tssseal">
  <button class="w3-button w3-darkgrey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
  <div class="topbar">
    <div class="topbarelements topbarelements-center">
    <h1 class="title-top topbarelements">Liberatube · Search Results</h1>
    <form class="input-row topbarelements" id="keywordForm" method="get" action="/search/">
                <div class="input-row topbarelements topbarelements-right">
                    <input class="input-field" type="search" id="keyword" name="q" placeholder="Type the search query here" value="<?php echo $keyword; ?>">
                    <input class="btn-submit" type="submit" value="Search">
            </div>
            </form>
    </div>
    <?php if ($useSQL == true) { ?>
    <div class="topbarelements topbarelements-right">
    <h4> <?php echo $_SESSION['logged_in_user'] ?? ""; 
    $loggedinuser = $_SESSION['logged_in_user'] ?? "";?> 
    <?php if($loggedinuser != "")
    {
        echo '<a class="button awhite login-item" href="/auth/logout.php"><span class="material-symbols-outlined login-item-icon">logout</span><h5 class="login-item-text">Logout</h5></a>';
    }
    else
    {
        echo '<a class="button awhite login-item" href="/auth/login.html"><span class="material-symbols-outlined login-item-icon">login</span><h5 class="login-item-text">Login/Signup</h5></a>';
    }
    if($loggedinuser == $adminuser)
            {
                echo '<a style="margin-left: 5px;" class="button awhite login-item" href="/admin/"><span class="material-symbols-outlined login-item-icon">monitor_heart</span><h5 class="login-item-text">Admin Panel</h5></a>';
            }
    ?>
    </div>
    <?php } ?>
    </div>
  </div>
</div>

<div class="tenborder">
        
        <?php 
    $searchqk = $params['q'];
    $params['q'] = str_replace(' ','+',$params['q']);
    ?>
        
    
        <?php if(!empty($response)) { ?>
                <div class="response <?php echo $response["type"]; ?>"> <?php echo $response["message"]; ?> </div>
        <?php }?>
        <?php                        
              if (!empty($params['q']))
              {
                $googleApiUrl = $InvSServer.'/api/v1/search?q=' . $params['q'] . '&hl=en';

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_VERBOSE, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);

                curl_close($ch);
                $data = json_decode($response);
                $value = json_decode(json_encode($data), true);
            ?>

            <br>
            <div class="videos-data-container w3-animate-left" id="SearchResultsDiv">
<div style="text-align: center;">
            <?php
                for ($i = 0; $i < MAX_RESULTS; $i++) {
                    $channel = $value[$i]['author'] ?? "";
                    $channelId = $value[$i]['authorId'] ?? "";
                    $type = "video";
                    $videoId = $value[$i]['videoId'] ?? "";
                    if ($value[$i]['type'] == 'channel') {
                    $type = "channel";
                    $profpic = $value[$i]['authorThumbnails'][0]['url']; }
                    if ($type == "channel") {
                        $burl = "/channel/?id=";
                        $videoId = $channelId;
                    }
                    elseif ($type == "video") {
                        $burl = "/watch/?v=";
                    }
                    $title = $value[$i]['title'] ?? "";
                    $sharedat = $value[$i]['publishedText'] ?? "";

                    $lengthseconds = $value[$i]['lengthSeconds'] ?? "0";
                    $vidhours = floor($lengthseconds / 3600) ?? "";
                    $vidmins = floor($lengthseconds / 60 % 60) ?? "";
                    $vidsecs = floor($lengthseconds % 60) ?? "";
                    if ($vidhours == "0") {
                        $timestamp = $vidmins.':'.$vidsecs ?? "";
                    } else {
                        $timestamp = $vidhours.':'.$vidmins.':'.$vidsecs ?? "";
                    }
                    ?> <a class="awhite" href="<?php echo $burl.$videoId; ?>">
                       <div class="video-tile w3-animate-left">
                        <div class="videoDiv">
                        <center>
                            
                        <?php 
                        if ($type == "video") {
                            echo '<img src="http://i.ytimg.com/vi/' . $videoId . '/mqdefault.jpg" height="144px">';
                        }
                        elseif ($type == "channel") {
                            echo '<img src="' . $profpic . '" height="144px">';
                        }
                            ?>
                        </center>
                        <div class="timestamp"><?php echo $timestamp; ?></div>
                        </div>
                        <div class="videoInfo">
                        <div class="videoTitle"><?php echo $channel; ?> · <?php echo $sharedat; ?><center><?php echo $title; ?></center></div>
                        </div>
                        </div>
                        </a>
           <?php 
                    }
           
            }
            ?> 
            <?php

            ?>
            </div>
            
        </div>
        </div>
    </body>
</html>
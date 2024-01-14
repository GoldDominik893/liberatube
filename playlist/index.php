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
<!DOCTYPE html>
<html>
    <head>
        <title>Liberatube · Playlist</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <body>
<div class="w3-sidebar w3-bar-block w3-collapse w3-card sidebar" style="width:55px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">&times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">home</span></a>
  <?php
  if ($useSQL == true) { ?>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">history</span></a>
  <a href="/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">list_alt</span></a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">subscriptions</span></a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">settings</span></a>
  <?php } ?>
</div>

<div class="w3-main" style="margin-left:55px">
<div class="w3-tssseal">
  <button class="w3-button w3-darkgrey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
  <div class="topbar">
    <div class="topbarelements topbarelements-center">
    <h1>Liberatube · Playlist</h1>
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
<script src="/scripts/sidebar.js"></script>
<div class="tenborder">
        
        <?php if(!empty($response)) { ?>
                <div class="response <?php echo $response["type"]; ?>"> <?php echo $response["message"]; ?> </div>
        <?php }?>
        <?php                        
                $InvApiUrl = $InvVIServer.'/api/v1/playlists/'.$params['id'].'?page=1';

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

                $videoCount = $value['videoCount'] ?? "";
                $pltitle = $value['title'] ?? "";
                $plauthor = $value['author'] ?? "";
                $plviews = $value['viewCount'] ?? "";



                echo '<div class="search-form-container w3-animate-left"><h4>
                    '.$pltitle.'<br>          
                    '.$videoCount.' Videos · Created by '.$plauthor.' · '.$plviews.' Views</h4>
                </div>';
            
            ?>

            <br>
            <div class="videos-data-container w3-animate-left" id="SearchResultsDiv">
            
<div style="text-align: center;">
            <?php
            
                for ($i = 0; $i < $videoCount; $i++) {
                    $title = $value['videos'][$i]['title'] ?? "";
                    $videoId = $value['videos'][$i]['videoId'] ?? "";
                    $channel = $value['videos'][$i]['author'] ?? "";
                    $indexr = $value['videos'][$i]['index']+1 ?? "";
                    $publishedtext = $value['videos'][$i]['publishedText'] ?? "";

                    
                    $lengthseconds = $value['videos'][$i]['lengthSeconds'] ?? "";
                    $vidhours = floor($lengthseconds / 3600) ?? "";
                    $vidmins = floor($lengthseconds / 60 % 60) ?? "";
                    $vidsecs = floor($lengthseconds % 60) ?? "";
                    if ($vidhours == "0") {
                        $timestamp = $vidmins.':'.$vidsecs ?? "";
                    } else {
                        $timestamp = $vidhours.':'.$vidmins.':'.$vidsecs ?? "";
                    }
                    ?>


                    <a class="awhite" href="/watch/?v=<?php echo $videoId; ?>">
                       <div class="video-tile w3-animate-left">
                        <div class="videoDiv">
                        <center>
                        <img src="http://i.ytimg.com/vi/<?php echo $videoId; ?>/mqdefault.jpg" height="144px">
                        </center>
                        <div class="timestamp"><?php echo $timestamp; ?></div>
                        </div>
                        <div class="videoInfo">
                        <div class="videoTitle"><?php echo $channel; ?><br><b><center><?php echo $title; ?></center></b></div>

                        </div>
                        </div>
                        </a>
           <?php 
                    }
                ?> 
            </div>
        </div>
        </div>
    </body>
</html>
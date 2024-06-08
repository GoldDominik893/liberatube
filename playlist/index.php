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
        <title>Liberatube · <?php echo $translations[$langrow]['playlist']; ?></title>
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
  <a href="/playlist/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">list_alt</span><span class="tooltiptext"><?php echo $translations[$langrow]['playlists']; ?></span></a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">subscriptions</span><span class="tooltiptext"><?php echo $translations[$langrow]['subscriptions']; ?></span></a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">settings</span><span class="tooltiptext"><?php echo $translations[$langrow]['settings']; ?></span></a>
  <?php } ?>
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
                $pagenumber = $_GET['page'] ?? 1;                     
                $InvApiUrl = $InvVIServer.'/api/v1/playlists/'.$params['id'].'?page='.$pagenumber;

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
                    '.$videoCount.' '.$translations[$langrow]['videos'].' · '.$translations[$langrow]['created_by'].' '.$plauthor.' · '.$plviews.' '.$translations[$langrow]['views'].'</h4>
                </div>';
            
            ?>

            <br>
            <div class="videos-data-container w3-animate-left" id="SearchResultsDiv">
            <?php
            if ($videoCount > 200) {
                if ($pagenumber == 1) {
                    echo '<a href="?id='.$_GET['id'].'&page='.($pagenumber + 1).'">'.$translations[$langrow]['next_page'].'</a>';
                } else {
                    echo '<a href="?id='.$_GET['id'].'&page='.($pagenumber - 1).'">'.$translations[$langrow]['previous_page'].'</a> · ';
                    echo '<a href="?id='.$_GET['id'].'&page='.($pagenumber + 1).'">'.$translations[$langrow]['next_page'].'</a>';
                }
            }
                
            ?>
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
                        <img src="http://i.ytimg.com/vi/<?php echo $videoId; ?>/mqdefault.jpg" height="144px">
                        <div class="timestamp"><?php echo $timestamp; ?></div>
                        </div>
                        <div class="videoInfo">
                        <div class="videoTitle"><?php echo $title; ?><br><b><?php echo $channel; ?></b></div>

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
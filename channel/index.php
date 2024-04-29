<?php
session_start();  
include('../config.php');

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
        <title>Liberatube · Channel</title>
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
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">home</span></a>
  <?php
  if ($useSQL == true) { ?>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">history</span></a>
  <a href="/playlist/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">list_alt</span></a>
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
    <h3 class="title-top topbarelements">Liberatube</h3>
    <form class="input-row topbarelements" id="keywordForm" method="get" action="/search/">
                    <input class="input-field" type="search" id="keyword" name="q" placeholder="Search YouTube..." value="<?php echo $keyword; ?>">
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
<script src="/scripts/sidebar.js"></script>
<div class="tenborder">
        
        <?php if(!empty($response)) { ?>
                <div class="response <?php echo $response["type"]; ?>"> <?php echo $response["message"]; ?> </div>
        <?php }?>
        <?php    
                $InvApiUrl = $InvVIServer.'/api/v1/channels/'.$params['id'].'?hl=en&sort_by='.$_GET['sort_by'];    
                
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
                $channelPfpUrl = $value['authorThumbnails'][1]['url'] ?? "";

                if($params['q']){
                $InvApiUrl = $InvVIServer.'/api/v1/channels/search/'.$params['id'].'?hl=en&q='.$params['q'];
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
                

                

                $pl = file_get_contents($InvVIServer.'/api/v1/channels/'.$params['id'].'/playlists/?hl=en');
                $plitemsint = substr_count($pl,"playlistThumbnail");


                if ($params['type'] == "videos" or $params['type'] == "")
                {
                echo '<div class="search-form-container">
                <img src="'.$bannerUrl.'" style="max-width: 100%"><br><br>
                <img style="margin-bottom: -25px; width: 100px;" src="'.$channelPfpUrl.'"><br><br>
                    
                <div style="margin-left: 105px; margin-top: -105px;">
                    <h4>'.$authorc.': '.$subcount.' Subscribers</h4>
                </div>
                <div style="margin-left: 105px; margin-top: -7px;">
                    > <a href="#">Videos</a>';
                    if ($params['sort_by'] == "latest" or $params['sort_by'] == "") {
                        echo '
                            > <a href="#">Latest</a> <
                            <a href="/channel/?id='.$params['id'].'&type=videos&sort_by=popular">Popular</a>
                            <a href="/channel/?id='.$params['id'].'&type=videos&sort_by=oldest">Oldest</a>';
                    } elseif ($params['sort_by'] == "popular") {
                        echo '
                            <a href="/channel/?id='.$params['id'].'&type=videos&sort_by=latest">Latest</a>
                            > <a href="#">Popular</a> <
                            <a href="/channel/?id='.$params['id'].'&type=videos&sort_by=oldest">Oldest</a>';
                    } elseif ($params['sort_by'] == "oldest") {
                        echo '
                            <a href="/channel/?id='.$params['id'].'&type=videos&sort_by=latest">Latest</a>
                            <a href="/channel/?id='.$params['id'].'&type=videos&sort_by=popular">Popular</a>
                            > <a href="#">Oldest</a> <';
                    }
                echo '    
                    <br><a href="/channel/?id='.$params['id'].'&type=playlists">Playlists</a><br>
                </div>
                        <form class="input-row topbarelements" id="keywordForm" method="get" action="/channel/">
                            <div class="input-row topbarelements topbarelements-right">
                                <input style="margin-left: 105px; margin-top: -2px;" class="input-field" type="search" id="keyword" name="q" placeholder="Search this channel..." value="'.$params['q'].'">
                                <input type="hidden" id="id" name="id" value="'.$params['id'].'">
                            </div>
                        </form>
                </div>';
            }
                elseif ($params['type'] == "playlists") 
                {
                echo '<div class="search-form-container">
                <img src="'.$bannerUrl.'" style="max-width: 100%"><br><br>
                <img style="margin-bottom: -25px; width: 100px;" src="'.$channelPfpUrl.'"><br><br>
                    
                <div style="margin-left: 105px; margin-top: -105px;">
                    <h4>'.$authorc.': '.$subcount.' Subscribers</h4>
                </div>
                <div style="margin-left: 105px; margin-top: -7px;">
                    <a href="/channel/?id='.$params['id'].'&type=videos">Videos</a><br>
                    > <a href="#">Playlists</a><br>
                </div><br><br>'; }
                ?>

            <br>
            <div class="videos-data-container" id="SearchResultsDiv">
            
<div style="text-align: center;">
            <?php
            $vidcount = substr_count($response,"videoThumbnails");

            if ($params['type'] == "videos" or $params['type'] == "") 
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
                } elseif ($params['type'] == "playlists") {
                    $InvApiUrl = $InvVIServer.'/api/v1/channels/'.$params['id'].'/playlists?hl=en';

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
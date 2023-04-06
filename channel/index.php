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
<!DOCTYPE html>
<html>
    <head>
        <title>Liberatube · Channel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
}
$row = mysqli_fetch_assoc($query);
$numrows = mysqli_num_rows($query);
}
if(strcmp($themerow, 'dark') == 0)
{
    echo '<link rel="stylesheet" href="../styles/homedark.css">';
} elseif(strcmp($themerow, 'blue') == 0)
{
    echo '<link rel="stylesheet" href="../styles/homeblue.css">';
} elseif(strcmp($themerow, 'ultra-dark') == 0)
{
    echo '<link rel="stylesheet" href="../styles/homeultra-dark.css">';
} elseif(strcmp($themerow, 'light') == 0)
{
    echo '<link rel="stylesheet" href="../styles/homelight.css">';
} else 
{
    echo '<link rel="stylesheet" href="../styles/home'.$defaultTheme.'.css">';
} 
                ?>
    <body>
<div class="w3-sidebar w3-bar-block w3-collapse w3-card sidebar" style="width:55px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">&times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">home</span></a>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">history</span></a>
  <a href="/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">list_alt</span></a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">subscriptions</span></a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">settings</span></a>
</div>

<div class="w3-main" style="margin-left:55px">
<div class="w3-tssseal">
  <button class="w3-button w3-darkgrey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
  <div class="topbar">
    <div class="topbarelements topbarelements-center">
    <h1>Liberatube · Channel</h1>
    </div>
    <div class="topbarelements topbarelements-right">
    <h4> <?php echo $_SESSION['logged_in_user'] ?? ""; 
    $loggedinuser = $_SESSION['logged_in_user'] ?? "";?> 
    <?php if($loggedinuser != "")
    {
        echo '<a class="button awhite login-item" href="/logout.php"><span class="material-symbols-outlined login-item-icon">logout</span><h5 class="login-item-text">Logout</h5></a>';
    }
    else
    {
        echo '<a class="button awhite login-item" href="/login.html"><span class="material-symbols-outlined login-item-icon">login</span><h5 class="login-item-text">Login/Signup</h5></a>';
    }
    if($loggedinuser == $adminuser)
            {
                echo '<a style="margin-left: 5px;" class="button awhite login-item" href="/admin"><span class="material-symbols-outlined login-item-icon">monitor_heart</span><h5 class="login-item-text">Admin Panel</h5></a>';
            }
    ?>
    </div>
    </div>
  </div>
</div>
<script src="/scripts/sidebar.js"></script>
<div class="tenborder">
        
        <?php if(!empty($response)) { ?>
                <div class="response <?php echo $response["type"]; ?>"> <?php echo $response["message"]; ?> </div>
        <?php }?>
        <?php    
                $InvApiUrl = $InvVIServer.'/api/v1/channels/'.$params['id'].'?hl=en';    
                
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
                echo '<div class="search-form-container"><h4>
                <img src="'.$bannerUrl.'" style="max-width: 100%"><br><br>
                    '.$authorc.': '.$subcount.' Subscribers</h4>
                    > <a href="#">Latest Videos</a><br>
                    <a href="/channel/?id='.$params['id'].'&type=playlists">Playlists</a><br>
                    <a href="/channel/?id='.$params['id'].'&type=channels">Related Channels</a><br>

                        <form class="input-row topbarelements" id="keywordForm" method="get" action="/channel/">
                        <div class="input-row topbarelements topbarelements-right">
                            <input class="input-field" type="search" id="keyword" name="q" placeholder="Type the search query here" value="'.$params['q'].'">
                            <input type="hidden" id="id" name="id" placeholder="Type the search query here" value="'.$params['id'].'">
                            <input class="btn-submit" type="submit" name="submit" value="Search">
                        </div>
                        </form>
                </div>'; }
                elseif ($params['type'] == "playlists") 
                {
                echo '<div class="search-form-container"><h4>
                <img src="'.$bannerUrl.'" style="max-width: 100%"><br><br>
                    '.$authorc.': '.$subcount.' Subscribers</h4>
                    <a href="/channel/?id='.$params['id'].'&type=videos">Latest Videos</a><br>
                    > <a href="#">Playlists</a><br>
                    <a href="/channel/?id='.$params['id'].'&type=channels">Related Channels</a>
                </div>'; }
                elseif ($params['type'] == "channels") 
                {
                echo '<div class="search-form-container"><h4>
                <img src="'.$bannerUrl.'" style="max-width: 100%"><br><br>
                    '.$authorc.': '.$subcount.' Subscribers</h4>
                    <a href="/channel/?id='.$params['id'].'&type=videos">Latest Videos</a><br>
                    <a href="/channel/?id='.$params['id'].'&type=playlists">Playlists</a><br>
                    > <a href="#">Related Channels</a>
                </div>'; }
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
                        <center>
                        <img src="http://i.ytimg.com/vi/<?php echo $videoId; ?>/mqdefault.jpg" height="144px">
                        </center>
                        <div class="timestamp"><?php echo $timestamp; ?></div>
                        </div>
                        <div class="videoInfo">
                        <div class="videoTitle"><center>Shared <?php echo $publishedText; ?><br><b><?php echo $title; ?></center></b></div>

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
                            <center>
                            <img src="<?php echo $plThumb; ?>" height="144px">
                            </center>
                            <div style="position: absolute; margin-top: -23px; right: 10px; background: rgba(0,0,0,0.7); padding-left: 4px; padding-right: 4px; border-radius: 3px;"><?php echo $timestamp; ?></div>
                            </div>
                            <div class="videoInfo">
                            <div class="videoTitle"><center><b><?php echo $title; ?></center></b></div>
    
                            </div>
                            </div>
                            </a>
               <?php }
                        } elseif ($params['type'] == "channels") {
                            $chitemsint = substr_count($response,"authorThumbnails")-1;

                            for ($i = 0; $i < $chitemsint; $i++) {
                                $title = $value['relatedChannels'][$i]['author'] ?? "";
                                $videoId = $value['relatedChannels'][$i]['authorId'] ?? "";
                                $plThumb = $value['relatedChannels'][$i]['authorThumbnails'][3]['url'] ?? "";
                                ?>
            
            
                                <a class="awhite" href="/channel/?id=<?php echo $videoId; ?>">
                                   <div class="video-tile w3-animate-left">
                                    <div class="videoDiv">
                                    <center>
                                    <img src="<?php echo $plThumb; ?>" height="144px">
                                    </center>
                                    <div style="position: absolute; margin-top: -23px; right: 10px; background: rgba(0,0,0,0.7); padding-left: 4px; padding-right: 4px; border-radius: 3px;"><?php echo $timestamp; ?></div>
                                    </div>
                                    <div class="videoInfo">
                                    <div class="videoTitle"><center><b><?php echo $title; ?></center></b></div>
            
                                    </div>
                                    </div>
                                    </a>
                       <?php }
                                }
                    ?>

            </div>
        </div>
        </div>
    </body>
</html>
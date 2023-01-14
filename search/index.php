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
include('../config.php');

$keyword = $params['q'];
$resultsmaximum = $params['maxresults'];

if ($resultsmaximum > 20) {
    $resultsmaximum = 20;
}
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
        <title>Bad YouTube | Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

        <?php
include('config.php');
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

<div class="w3-sidebar w3-bar-block w3-collapse w3-card sidebar" style="width:55px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">&times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">home</span></a>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">history</span></a>
  <a href="/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">list_alt</span></a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">subscriptions</span></a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">settings</span></a>
  <hr class="hr">
  <a href="#" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">search</span></a>
</div>

<div class="w3-main" style="margin-left:55px">
<div class="w3-tssseal">
  <button class="w3-button w3-darkgrey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
  <div class="topbar">
    <div class="topbarelements topbarelements-center">
    <h1>Bad YouTube</h1>
    </div>
    <div class="topbarelements topbarelements-right">
    <h4> <?php echo $_SESSION['logged_in_user'] ?? ""; 
    $loggedinuser = $_SESSION['logged_in_user'] ?? "";?> 
    <?php if($loggedinuser != "")
    {
        echo '<a class="button awhite login-item" href="../logout.php"><span class="material-symbols-outlined login-item-icon">logout</span><h5 class="login-item-text">Logout</h5></a>';
    }
    else
    {
        echo '<a class="button awhite login-item" href="../login.php"><span class="material-symbols-outlined login-item-icon">login</span><h5 class="login-item-text">Login/Signup</h5></a>';
    }
    if($loggedinuser == 'GoldDominik893')
            {
                echo '<a style="margin-left: 5px;" class="button awhite login-item" href="../admin"><span class="material-symbols-outlined login-item-icon">monitor_heart</span><h5 class="login-item-text">Admin Panel</h5></a>';
            }
    ?>
    </div>
    </div>
  </div>
</div>
<script>
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
}

function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
}
</script>
<div class="tenborder">
        <div class="search-form-container w3-animate-left">
            <form id="keywordForm" method="get" action="">
                <div class="input-row">
                    <label for="keyword">Search:</label>
                    <input class="input-field" type="search" id="q" name="q"  placeholder="Type the search query here" value="<?php echo $keyword; ?>">
                    <br><br>
                    <label for="maxresults">Results:</label><br>
                    <input class="input-field2" type="number" id="maxresults" name="maxresults" min="1" max="20" value="<?php if(isset($params['maxresults']))
    {
        echo $resultsmaximum;
    }
    else
    {
        echo '12';
    }
    ?>"> 
                </div>

                <input class="btn-submit" type="submit" name="submit" value="Search">
            </form>
        </div>
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
                $apikey = $ytapikey; 
                $googleApiUrl = 'https://www.googleapis.com/youtube/v3/search?part=snippet&q=' . $params['q'] . '&maxResults=' . MAX_RESULTS . '&key=' . $apikey;

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
            
<h4> You have searched for: <font color="red"><?php echo $searchqk; ?></font><br>
What was sent to Google's API: <font color="red"><?php echo $params['q']; ?></font> </h4>
<div style="text-align: center;">
            <?php
                for ($i = 0; $i < MAX_RESULTS; $i++) {
                    $channel = $value['items'][$i]['snippet']['channelTitle'] ?? "";
                    $channelId = $value['items'][$i]['snippet']['channelId'] ?? "";
                    $type = "video";
                    $videoId = $value['items'][$i]['id']['videoId'] ?? "";
                    if ($videoId == "") {
                    $type = "channel";
                    $profpic = $value['items'][$i]['snippet']['thumbnails']['default']['url'];}
                    if ($type == "channel") {
                        $burl = "/channel/?id=";
                        $videoId = $channelId;
                    }
                    elseif ($type == "video") {
                        $burl = "/watch?v=";
                    }
                    $title = $value['items'][$i]['snippet']['title'] ?? "";
                    $description = $value['items'][$i]['snippet']['description'] ?? "";
                    $sharedat = $value['items'][$i]['snippet']['publishedAt'] ?? "";
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
                        </div>
                        <div class="videoInfo">
                        <div class="videoTitle"><u>Channel: <?php echo $channel; ?><br>Shared: <?php echo $sharedat; ?></u><br><b><center><?php echo $title; ?></center></b></div>
                        <div class="videoDesc"><center><?php echo $description; ?></center></div>
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

<?php
session_start();
    $params['region'] = "GB"; 
    $keyword = $_POST['keyword'] ?? "";
    $resultsmaximum = $_POST['maxresults'] ?? "12"; 

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
                echo '<link rel="stylesheet" href="../styles/.css">';
            } elseif(strcmp($themerow, 'light') == 0)
            {
                echo '<link rel="stylesheet" href="../styles/playerlight.css">';
            } else 
            {
                echo '<link rel="stylesheet" href="../styles/playerdark.css">';
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
    <h1>Bad YouTube</h1>
    </div>
    <div class="topbarelements topbarelements-right">
    <h4> <?php echo $_SESSION['logged_in_user'] ?? ""; 
    $loggedinuser = $_SESSION['logged_in_user'] ?? "";?> 
    <?php if($loggedinuser != "")
    {
        echo '<a class="button awhite login-item" href="logout.php"><span class="material-symbols-outlined login-item-icon">logout</span><h5 class="login-item-text">Logout</h5></a>';
    }
    else
    {
        echo '<a class="button awhite login-item" href="login.php"><span class="material-symbols-outlined login-item-icon">login</span><h5 class="login-item-text">Login/Signup</h5></a>';
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
<script>
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
}

function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
}
</script>
<div class="tenborder">

<button style="text-align: left;" class="detailgreen w3-animate-left" onclick="location.href='https://discord.gg/z4cCk5c5Zj'">
   Join the Discord server!
</button><br><br>

<details class="detailred w3-animate-left">
<summary>Important News</summary>
<h4>This website will be transferring to another domain <a href="//badyt.epicsite.xyz/">(subdomain of epicsite.xyz)</a>. This will happen within the the next 6 months when badyt.cf will expire.<br>
</h4>
</details><br>
<details class="w3-animate-left">
<summary>Links</summary>
<h4>Credits go to me, Dominic Wajda, and to GitHub<br>
This website was optimised for mobile users and does not collect any user data apart from watch history when logged in.<br>
[<a href="https://invidious.epicsite.xyz">Good YouTube</a>]<br>
[<a href="https://invidious.lunar.icu">Good YouTube Backup</a>]<br>
[<a href="https://github.com/GoldDominik893/bad-youtube/">Fork this site</a>]<br>
[<a href="/todo.txt">todo list</a>]<br>
[<a href="/privacy.html">Privacy Policy</a>]<br>
Want to suggest something? Send suggestions to <a href="mailto:suggestions@epicsite.xyz">suggestions@epicsite.xyz</a>!
</h4>
</details><br>
        <div class="search-form-container w3-animate-left">
            <form id="keywordForm" method="get" action="/search/">
                <div class="input-row">
                    <label for="keyword">Search:</label>
                    <input class="input-field" type="search" id="keyword" name="q"  placeholder="Type the search query here" value="<?php echo $keyword; ?>">
                    <br><br>
                    <label for="maxresults">Results:</label><br>
                    <input class="input-field2" type="number" id="maxresults" name="maxresults" min="1" max="20" value="<?php if(isset($_POST['maxresults']))
    {
        echo $resultsmaximum;
    }
    else
    {
        echo '12';
    }
    ?>"> 
                </div>

                <input class="btn-submit"  type="submit" name="submit" value="Search">
            </form>
        </div>
        <?php 
    $searchqk = $keyword;
    $keyword = str_replace(' ','+',$keyword);
    ?>
        
    
        <?php if(!empty($response)) { ?>
                <div class="response <?php echo $response["type"]; ?>"> <?php echo $response["message"]; ?> </div>
        <?php }?>
        <?php                        
              if (1 == 1)
              {
                if (($params['region'] ?? "") == "") {
                    $params['region'] = "GB";
                }
                if ($params['region'] == "GB") {
                    $responsetren = "Trending Content For Great Britain";
                }
                elseif ($params['region'] == "US") {
                    $responsetren = "Trending Content For The United States of America";
                }
                else {
                    $responsetren = "Trending Content For Country With Country Code '".$params['region']."'";
                }
                $InvApiUrl = $InvTServer.'/api/v1/trending?pretty=1&region='.$params['region'].'&hl=en';

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

                $rsults = substr_count($response,"descriptionHtml");
            ?>

            <br>
            <div class="videos-data-container w3-animate-left" id="SearchResultsDiv">
            
<div style="text-align: center;">
<h2><?php echo $responsetren; ?></h2>
            <?php
                for ($i = 0; $i < $rsults; $i++) {
                    $videoId = $value[$i]['videoId'] ?? "";
                    $title = $value[$i]['title'] ?? "";
                    $description = $value[$i]['descriptionHtml'] ?? "";
                    $channel = $value[$i]['author'] ?? "";
                    $sharedat = $value[$i]['publishedText'] ?? "";
                    ?>


                    <a class="awhite" href="/vi/?w=<?php echo $videoId; ?>">
                       <div class="video-tile w3-animate-left">
                        <div class="videoDiv">
                        <center>
                        <img src="http://i.ytimg.com/vi/<?php echo $videoId; ?>/mqdefault.jpg" height="144px">
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
            </div>
        </div>
        </div>
    </body>
</html>
<?php
session_start();  
include('config.php');
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
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Liberatube · Playlists</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="/styles/-w3.css">
<link rel="stylesheet" href="/styles/-bootstrap.min.css">
<link rel="stylesheet" href="/styles/-googlesymbols.css">

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
                echo '<link rel="stylesheet" href="../styles/player'.$defaultTheme.'.css">';
            } 
                ?>
    <body>
<div class="w3-sidebar w3-bar-block w3-collapse w3-card sidebar" style="width:55px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">&times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">home</span></a>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">history</span></a>
  <a href="/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">list_alt</span></a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">subscriptions</span></a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">settings</span></a>
</div>

<div class="w3-main" style="margin-left:55px">
<div class="w3-tssseal">
  <button class="w3-button w3-darkgrey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
    <div class="topbar">
    <div class="topbarelements topbarelements-center">
    <h1>Playlists</h1>
    </div>
    <div class="topbarelements topbarelements-right">
    <h4> <?php echo $_SESSION['logged_in_user']; ?>
    <?php if(isset($_SESSION['logged_in_user']))
    {
        echo '<a class="button awhite login-item" href="logout.php"><span class="material-symbols-outlined login-item-icon">logout</span><h5 class="login-item-text">Logout</h5></a>';
    }
    else
    {
        echo '<a class="button awhite login-item" href="login.html"><span class="material-symbols-outlined login-item-icon">login</span><h5 class="login-item-text">Login/Signup</h5></a>';
    }
    ?>

    
    </div>
    </div>
  </div>
  <script src="/scripts/sidebar.js"></script>


<?php
if(isset($_SESSION['logged_in_user'])) {
echo '<center><h4>This is still in development.</h4></center>









<div class="videos-data-container w3-animate-left" id="SearchResultsDiv">
<div style="text-align: center;">
                    
    
    
                        <a class="awhite" href="/watch/?v=<?php echo $videoId; ?>">
                           <div class="video-tile w3-animate-left">
                            <div class="videoDiv">
                            <center>
                            <img src="http://i.ytimg.com/vi/<?php echo $videoId; ?>/mqdefault.jpg" height="144px">
                            </center>
                            <div style="position: absolute; margin-top: -23px; right: 10px; background: rgba(0,0,0,0.7); padding-left: 4px; padding-right: 4px; border-radius: 3px;"><?php echo $timestamp; ?></div>
                            </div>
                            <div class="videoInfo">
                            <div class="videoTitle"><br><b><center><?php echo $title; ?></center></b></div>
    
                            </div>
                            </div>
                            </a>





</div></div>

';
} else {
echo '<center><h4>You are not logged in.</h4></center>';
}
?>



    </div>
    </div>
  </div>
</div>
  </div>
</div>
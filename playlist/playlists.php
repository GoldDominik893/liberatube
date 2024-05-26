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
<!DOCTYPE HTML>
<html>
    <head>
        <title>Liberatube · <?php echo $translations[$langrow]['playlists']; ?></title>
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
$stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
$stmt->bind_param("s", $_SESSION['logged_in_user']);
$stmt->execute();
$result = $stmt->get_result();
$numrows = $result->num_rows;
while ($row = $result->fetch_assoc())
{
    $themerow = $row['theme'];
}
$numrows = $result->num_rows;
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
?>
    <body>
<div class="w3-sidebar w3-bar-block w3-collapse w3-card sidebar" style="width:55px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">&times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">home</span><span class="tooltiptext"><?php echo $translations[$langrow]['home']; ?></span></a>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">history</span><span class="tooltiptext"><?php echo $translations[$langrow]['watch_history']; ?></span></a>
  <a href="/playlist/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">list_alt</span><span class="tooltiptext"><?php echo $translations[$langrow]['playlists']; ?></span></a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">subscriptions</span><span class="tooltiptext"><?php echo $translations[$langrow]['subscriptions']; ?></span></a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">settings</span><span class="tooltiptext"><?php echo $translations[$langrow]['settings']; ?></span></a>
</div>

<div class="w3-main" style="margin-left:55px">
<div class="w3-tssseal">
  <button class="w3-button w3-darkgrey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
    <div class="topbar">
    <div class="topbarelements topbarelements-center">
    <h3 class="title-top topbarelements"><?php echo $translations[$langrow]['playlists']; ?></h3>
    </div>
    <div class="topbarelements topbarelements-right">
    <h4> <?php echo $_SESSION['logged_in_user']; ?>
    <?php if(isset($_SESSION['logged_in_user']))
    {
        echo '<a class="button awhite login-item" href="/auth/logout.php"><span class="material-symbols-outlined login-item-icon">logout</span><h5 class="login-item-text">'.$translations[$langrow]['logout'].'</h5></a>';
    }
    else
    {
        echo '<a class="button awhite login-item" href="/auth/login.html"><span class="material-symbols-outlined login-item-icon">login</span><h5 class="login-item-text">'.$translations[$langrow]['login-signup'].'</h5></a>';
    }
    ?>

    
    </div>
    </div>
  </div>
  <script src="/scripts/sidebar.js"></script>
  <div class="tenborder">
  <div class="videos-data-container" id="SearchResultsDiv">
  <div style="text-align: center;">

<?php
if(isset($_SESSION['logged_in_user'])) {

  // Create a database connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  
  // Check the connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  
  // Retrieve playlists for the logged-in user
  $query = "SELECT playlist_id, playlist_name, video_ids FROM playlist WHERE username = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $_SESSION['logged_in_user']);
  $stmt->execute();
  $result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<h3>'.$translations[$langrow]['your_playlists'].'</h3>';

    while ($row = $result->fetch_assoc()) {
        $playlistId = $row['playlist_id'];
        $playlistName = $row['playlist_name'];
        
        $playlistCont = json_decode($row['video_ids'], true);

        $vidsInPlaylist = count($playlistCont);
        if ($vidsInPlaylist == 1) {
          $vidsInPlaylistText = "1 ".$translations[$langrow]['video'];
        } else {
          $vidsInPlaylistText = $vidsInPlaylist." ".$translations[$langrow]['videos'];
        }

        if (!empty($playlistCont)) {
            $firstVideo = $playlistCont[0];
            $videoId = 'http://i.ytimg.com/vi/'.$firstVideo['id'].'/mqdefault.jpg'; 
        } else {
            $videoId = 'https://github.com/GoldDominik893/file-hosting/blob/main/images/empty-playlist.png?raw=true'; 
        }
    

        echo <<<HTML
                <a class="awhite" href='view_playlist.php?playlist_id={$playlistId}'>
                    <div class="video-tile w3-animate-left">
                        <div class="videoDiv">
                            <img src='{$videoId}' height="144px">
                        </div>
                        <div class="videoInfo">
                            <div class="videoTitle"><b>{$playlistName}</b> <div style="float: right;">{$vidsInPlaylistText}</div></div>
                        </div>
                    </div>
                </a>
HTML;
    }
} else {
    echo "<p>0 ".$translations[$langrow]['playlists'].".</p>";
}

  $stmt->close();
  $conn->close();


echo '

<script src="/scripts/-jquery-3.6.4.min.js"></script>
<script src="/scripts/playlist.js"></script>

<br><br>
<div class="epicdiv"><h4>'.$translations[$langrow]['create_a_playlist'].'</h4>
<form method="POST" action="create_playlist.php">
    <label for="new_playlist_name">'.$translations[$langrow]['name'].':</label>
    <input type="text" id="new_playlist_name" name="new_playlist_name" required>
    <br>
    <input type="submit" value="'.$translations[$langrow]['create_playlist'].'">
</form>
</div>


<div id="result"></div>
';
} else {
echo '<center><h4>You are not logged in.</h4></center>';
}
?>

</div></div>



    </div>
    </div>
  </div>
</div>
  </div>
</div>
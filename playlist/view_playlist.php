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
        <title>Liberatube · Playlist</title>
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
?>
    <body>
<div class="w3-sidebar w3-bar-block w3-collapse w3-card sidebar" style="width:55px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">&times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">home</span></a>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">history</span></a>
  <a href="/playlist/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">list_alt</span></a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">subscriptions</span></a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">settings</span></a>
</div>

<div class="w3-main" style="margin-left:55px">
<div class="w3-tssseal">
  <button class="w3-button w3-darkgrey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
    <div class="topbar">
    <div class="topbarelements topbarelements-center">
    <h3 class="title-top topbarelements">Playlist</h3>
    </div>
    <div class="topbarelements topbarelements-right">
    <h4> <?php echo $_SESSION['logged_in_user']; ?>
    <?php if(isset($_SESSION['logged_in_user']))
    {
        echo '<a class="button awhite login-item" href="/auth/logout.php"><span class="material-symbols-outlined login-item-icon">logout</span><h5 class="login-item-text">Logout</h5></a>';
    }
    else
    {
        echo '<a class="button awhite login-item" href="/auth/login.html"><span class="material-symbols-outlined login-item-icon">login</span><h5 class="login-item-text">Login/Signup</h5></a>';
    }
    ?>

    
    </div>
    </div>
  </div>
  <script src="/scripts/sidebar.js"></script>



  <div class="videos-data-container w3-animate-left" id="SearchResultsDiv">
<div style="text-align: center;">
                    
    

<?php
// Fetch playlist information
$playlistId = $_GET['playlist_id'];
$query = "SELECT playlist_name, username, video_ids FROM playlist WHERE playlist_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $playlistId);
$stmt->execute();
$result = $stmt->get_result();

// Display playlist information
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $playlistName = $row['playlist_name'];
    $username = $row['username'];
    $videoInfoArray = json_decode($row['video_ids'], true);

    echo "<h2>$playlistName</h2><h4>author: $username</h4>";
    echo "<div class='video-container'>";

    foreach ($videoInfoArray as $videoInfo) {
        if (is_array($videoInfo)) {
            $videoId = $videoInfo['id'];
            $title = $videoInfo['title'];
            $author = $videoInfo['author'];

            echo <<<HTML
                <a class="awhite" href="/watch/?v={$videoId}">
                    <div class="video-tile w3-animate-left">
                        <div class="videoDiv">
                                <img src="http://i.ytimg.com/vi/{$videoId}/mqdefault.jpg" height="144px">
                            <div style="position: absolute; margin-top: -23px; right: 10px; background: rgba(0,0,0,0.7); padding-left: 4px; padding-right: 4px; border-radius: 3px;">{$timestamp}</div>
                        </div>
                        <div class="videoInfo">
                            <div class="videoTitle"><b>{$title}</b><br>{$author}</div>
                        </div>
                    </div>
                </a>
HTML;
        } else {
            echo "<p>Invalid video information</p>";
        }
    }

    echo "</div>";
} else {
    echo "<p>Playlist not found or empty.</p>";
}

// Close the statement
$stmt->close();

// Close the database connection
$conn->close();
?>





</div></div>







    </div>
    </div>
  </div>
</div>
  </div>
</div>
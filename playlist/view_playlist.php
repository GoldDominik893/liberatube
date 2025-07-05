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

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $playlistId = $_GET['playlist_id'];
    
    // Update playlist
    if (isset($_POST['save_playlist'])) {
        $newTitle = $_POST['new_title'];
        $isPublic = isset($_POST['is_public']) ? 1 : 0;
        
        $stmt = $conn->prepare("UPDATE playlist SET playlist_name = ?, public = ? WHERE playlist_id = ?");
        $stmt->bind_param("sis", $newTitle, $isPublic, $playlistId);
        $stmt->execute();
        
        header("Location: view_playlist.php?playlist_id=".$playlistId);
        exit;
    } 
    // Delete playlist
    elseif (isset($_POST['delete_playlist'])) {
        $stmt = $conn->prepare("DELETE FROM playlist WHERE playlist_id = ?");
        $stmt->bind_param("s", $playlistId);
        $stmt->execute();
        
        header("Location: playlists.php");
        exit;
    }
}

// Check if we're in edit mode
$editMode = isset($_GET['edit']) && $_GET['edit'] == '1';

?>
<!DOCTYPE HTML>
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
    <h3 class="title-top topbarelements"><?php echo $translations[$langrow]['playlist']; ?></h3>
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
<div class="videos-data-container w3-animate-left" id="SearchResultsDiv">
<div class="tenborder">

                    
<?php
// Fetch playlist information
$playlistId = $_GET['playlist_id'];
$query = "SELECT playlist_name, username, video_ids, public FROM playlist WHERE playlist_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $playlistId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $playlistName = $row['playlist_name'];
    $plusername = $row['username'];
    $isPublic = $row['public'];
    $videoInfoArray = json_decode($row['video_ids'], true);

    // Check if current user is the owner (to show edit options)
    $isOwner = ($plusername == $_SESSION['logged_in_user']);

// Calculate video count
$videoCount = is_array($videoInfoArray) ? count($videoInfoArray) : 0;

if ($editMode && $isOwner) {
    echo '<form method="post" action="view_playlist.php?playlist_id='.$playlistId.'">';
    echo '<div class="search-form-container w3-animate-left">';
    echo '<input type="text" name="new_title" value="'.htmlspecialchars($playlistName).'" style="width:100%; max-width: 460px; margin-bottom:10px;" required>';
    
    echo '<div >';
    echo '<label class="w3-checkbox">';
    echo '<input type="checkbox" name="is_public" '.($isPublic ? 'checked' : '').'>';
    echo ' '.$translations[$langrow]['public_playlist'];
    echo '</label>';
    echo '</div>';
    
    echo '<div>';
    echo '<button class="trending-cat-btn" type="submit" name="save_playlist">';
    echo $translations[$langrow]['save'];
    echo '</button>';
    
    echo ' <a class="trending-cat-btn" href="view_playlist.php?playlist_id='.$playlistId.'">';
    echo $translations[$langrow]['cancel'];
    echo '</a>';
    
    echo ' <button class="trending-cat-btn" type="submit" name="delete_playlist"';
    echo 'onclick="return confirm(\''.$translations[$langrow]['confirm_delete_playlist'].'\')">';
    echo $translations[$langrow]['delete'];
    echo '</button>';
    echo '</div>';
    echo '</div>';
    echo '</form>';
} else {
    echo '<div class="search-form-container w3-animate-left"><h4>';
    echo htmlspecialchars($playlistName).'<br>';          
    echo $videoCount.' '.$translations[$langrow]['videos'].' · ';
    echo ($isPublic ? $translations[$langrow]['public'] : $translations[$langrow]['private']).' · ';
    echo $translations[$langrow]['created_by'].' '.htmlspecialchars($plusername);
    echo '</h4></div>';
    
    // Show edit button if owner
    if ($isOwner) {
        echo '<a class="trending-cat-btn" href="view_playlist.php?playlist_id='.$playlistId.'&edit=1">';
        echo $translations[$langrow]['edit_playlist'];
        echo '</a>';
    }
}

    // Check visibility (only show if public or owner)
    if ($isPublic || $isOwner) {
        echo '<div class="video-container">
              <div style="text-align: center;">';

        $videoIndex = 1;
        foreach ($videoInfoArray as $videoInfo) {
            if (is_array($videoInfo)) {
                $videoId = $videoInfo['id'];
                $title = $videoInfo['title'];
                $author = $videoInfo['author'];

                echo <<<HTML
                    <a class="awhite" href="/watch/?v={$videoId}&list={$playlistId}&index={$videoIndex}">
                        <div class="video-tile w3-animate-left">
                            <div class="videoDiv">
                                    <img src="http://i.ytimg.com/vi/{$videoId}/mqdefault.jpg" width="256px">
                                <div style="position: absolute; margin-top: -23px; right: 10px; background: rgba(0,0,0,0.7); padding-left: 4px; padding-right: 4px; border-radius: 3px;">{$timestamp}</div>
                            </div>
                            <div class="videoInfo">
                                <div class="videoTitle">{$title}<br><b>{$author}</b></div>
                            </div>
                        </div>
                    </a>
                HTML;
                $videoIndex++; 
            }
        }
        echo "</div>";
    } else {
        echo "<p>".$translations[$langrow]['private_playlist_message']."</p>";
    }
} else {
    echo "<p>".$translations[$langrow]['playlist_not_found']."</p>";
}

$stmt->close();
$conn->close();
?>

</div>
</div></div>

    </div>
    </div>
  </div>
</div>
  </div>
</div>
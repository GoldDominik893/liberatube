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

// Handle video removal from playlist
if (isset($_POST['remove_video_index'])) {
    $videoIndexToRemove = (int)$_POST['remove_video_index'];
    $playlistId = $_GET['playlist_id'];
    
    // Get current playlist data
    $stmt = $conn->prepare("SELECT video_ids FROM playlist WHERE playlist_id = ?");
    $stmt->bind_param("s", $playlistId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $videoInfoArray = json_decode($row['video_ids'], true);
    
    // Remove the video by index
    if (isset($videoInfoArray[$videoIndexToRemove])) {
        array_splice($videoInfoArray, $videoIndexToRemove, 1);
        
        // Update the playlist
        $stmt = $conn->prepare("UPDATE playlist SET video_ids = ? WHERE playlist_id = ?");
        $newVideoJson = json_encode(array_values($videoInfoArray));
        $stmt->bind_param("ss", $newVideoJson, $playlistId);
        $stmt->execute();
    }
    
    // Refresh the page
    header("Location: view_playlist.php?playlist_id=".$playlistId);
    exit;
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
    $checked = $isPublic ? 'checked' : '';
    $escapedPlaylistName = htmlspecialchars($playlistName);
    echo <<<HTML
        <form method="post" action="view_playlist.php?playlist_id={$playlistId}">
            <div class="search-form-container w3-animate-left">
                <input type="text" name="new_title" value="{$escapedPlaylistName}" style="width:100%; max-width: 460px; margin-bottom:10px;" required>
                
                <div>
                    <label class="w3-checkbox">
                        <input type="checkbox" name="is_public" {$checked}>
                        {$translations[$langrow]['public_playlist']}
                    </label>
                </div>
                
                <div>
                    <button class="trending-cat-btn" type="submit" name="save_playlist">
                        {$translations[$langrow]['save']}
                    </button>
                    
                    <a class="trending-cat-btn" href="view_playlist.php?playlist_id={$playlistId}">
                        {$translations[$langrow]['cancel']}
                    </a>
                    
                    <button class="trending-cat-btn" type="submit" name="delete_playlist" onclick="return confirm('{$translations[$langrow]['confirm_delete_playlist']}')">
                        {$translations[$langrow]['delete']}
                    </button>
                </div>
            </div>
        </form>
    HTML;
} else {
    $visibility = $isPublic ? $translations[$langrow]['public'] : $translations[$langrow]['private'];
    $escapedPlaylistName = htmlspecialchars($playlistName);
    $escapedUsername = htmlspecialchars($plusername);
    echo <<<HTML
        <div class="search-form-container w3-animate-left">
            <h4>
                {$escapedPlaylistName}<br>
                {$videoCount} {$translations[$langrow]['videos']} · 
                {$visibility} · 
                {$translations[$langrow]['created_by']} {$escapedUsername}
            </h4>
        </div>
    HTML;
    
    // Show edit button if owner
    if ($isOwner) {
        echo <<<HTML
            <a class="trending-cat-btn" href="view_playlist.php?playlist_id={$playlistId}&edit=1">
                {$translations[$langrow]['edit_playlist']}
            </a>
        HTML;
    }
}

    // Check visibility (only show if public or owner)
    if ($isPublic || $isOwner) {
        echo '<div class="video-container">
              <div style="text-align: center;"><br>';

        $videoIndex = 1;
        foreach ($videoInfoArray as $index => $videoInfo) {
            if (is_array($videoInfo)) {
                $videoId = $videoInfo['id'];
                $title = $videoInfo['title'];
                $author = $videoInfo['author'];
                $displayIndex = $index + 1; // Display position starts at 1

                echo <<<HTML
                        <a class="awhite" href="/watch/?v={$videoId}&list={$playlistId}&index={$displayIndex}">
                            <div class="video-tile w3-animate-left">
                                <div class="videoDiv">
                                        <img src="http://i.ytimg.com/vi/{$videoId}/mqdefault.jpg" width="256px">
                HTML;

                // Add delete button if in edit mode and owner
                if ($isOwner) {
                    echo <<<HTML
                        <div class="button-on-vid">
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="remove_video_index" value="{$index}">
                                <button type="submit" class="remove-button">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </form>
                        </div>
                    HTML;
                }

                echo <<<HTML
                                    </div>
                                    <div class="videoInfo">
                                        <div class="videoTitle">{$title}<br><b>{$author}</b></div>
                                    </div>
                                </div>
                            </a>
                            
                HTML;
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
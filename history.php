<?php
session_start();  
include('config.php');
$langrow = $defaultLang;
include('lang.php');

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
        <title>Liberatube · <?php echo $translations[$langrow]['watch_history']; ?></title>
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
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">history</span><span class="tooltiptext"><?php echo $translations[$langrow]['watch_history']; ?></span></a>
  <a href="/playlist/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">list_alt</span><span class="tooltiptext"><?php echo $translations[$langrow]['playlists']; ?></span></a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">subscriptions</span><span class="tooltiptext"><?php echo $translations[$langrow]['subscriptions']; ?></span></a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">settings</span><span class="tooltiptext"><?php echo $translations[$langrow]['settings']; ?></span></a>
</div>

<div class="w3-main" style="margin-left:55px">
<div class="w3-tssseal">
  <button class="w3-button w3-darkgrey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
    <div class="topbar">
    <div class="topbarelements topbarelements-center">
    <h3 class="title-top topbarelements"><?php echo $translations[$langrow]['watch_history']; ?></h3>
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
<?php

if(isset($_SESSION['logged_in_user'])) { ?>

<div style="text-align: center;">

<?php
if ($useSQL == true) {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    if ($_POST['remove-vid'] && $_POST['timestamp']) {
      $videoIdToRemove = $_POST['remove-vid'];
      $timestampToRemove = $_POST['timestamp'];
  
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
  
      $stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
      $stmt->bind_param("s", $_SESSION['logged_in_user']);
      $stmt->execute();
      $result = $stmt->get_result();
  
      while ($row = $result->fetch_assoc()) {
          $watchHistory = json_decode($row['watch_history'], true);
  
          // Filter out the video with matching video_id and timestamp
          $watchHistory = array_filter($watchHistory, function($item) use ($videoIdToRemove, $timestampToRemove) {
              return $item['video_id'] !== $videoIdToRemove || $item['timestamp'] !== $timestampToRemove;
          });
  
          // Reindex array
          $watchHistory = array_values($watchHistory);
  
          $updatedWatchHistory = json_encode($watchHistory);
  
          $updateStmt = $conn->prepare("UPDATE login SET watch_history = ? WHERE username = ?");
          $updateStmt->bind_param("ss", $updatedWatchHistory, $_SESSION['logged_in_user']);
          $updateStmt->execute();
  
          $updateStmt->close();
      }
  

  }
  


    $stmt = $conn->prepare("SELECT watch_history FROM login WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['logged_in_user']);
    $stmt->execute();
    $result = $stmt->get_result();

    $watchHistory = [];
    while ($row = $result->fetch_assoc()) {
        $watchHistory = json_decode($row['watch_history'], true);
    }

    $stmt->close();
    $conn->close();

    if (!is_array($watchHistory)) {
        $watchHistory = [];
    } else {
        $watchHistory = array_reverse($watchHistory);
    }

    $groupedWatchHistory = [];
    foreach ($watchHistory as $item) {
    $date = (new DateTime($item['timestamp']))->format('d M Y');
    $time = (new DateTime($item['timestamp']))->format('H:i:s');
    $item['time'] = $time;
    if (!isset($groupedWatchHistory[$date])) {
        $groupedWatchHistory[$date] = [];
    }
    $groupedWatchHistory[$date][] = $item;
}

}


                    

if (count($groupedWatchHistory) > 0) {
    foreach ($groupedWatchHistory as $date => $videos) { ?>
        <h3><?php echo htmlspecialchars($date); ?></h3>
        <?php foreach ($videos as $item) {
            $title = htmlspecialchars($item['title']);
            $author = htmlspecialchars($item['author']);
            $videoId = htmlspecialchars($item['video_id']);
            $time = htmlspecialchars($item['time']);
            $timestamp = htmlspecialchars($item['timestamp']); // Assume 'timestamp' exists in the watch history
            echo <<<HTML
            <a class="awhite" href="/watch/?v={$videoId}">
                <div class="video-tile w3-animate-left">
                    <div class="videoDiv">
                        <img src="http://i.ytimg.com/vi/{$videoId}/mqdefault.jpg" width="256px">
                        <div class="button-on-vid">
                          <form method="POST" action="" style="display:inline;">
                <input type="hidden" name="remove-vid" value="{$videoId}">
                <input type="hidden" name="timestamp" value="{$timestamp}">
                <button type="submit" class="remove-button"><span class="material-symbols-outlined">delete</span></button>
            </form></div>
                    </div>
                    <div class="videoInfo">
                        <div class="videoTitle">
                            <b>{$title}</b><br>{$author} <div style="float: right;">{$time}</div>
                        </div>
                    </div>
                </div>
            </a>
            
            HTML;
        } ?>
    <?php }
} ?>



<?php } else { ?>
<h4 style="text-align: center;">You are not logged in.</h4>
<?php
}
?>
</div>
</div>
    </div>
  </div>
</div>
  </div>
</div>
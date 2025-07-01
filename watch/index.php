<?php
session_start();  
include('../config.php');
$langrow = $defaultLang;
include('../lang.php');

$currentUrl = "http";
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $currentUrl .= "s";
}
$currentUrl .= "://";
$currentUrl .= $_SERVER['HTTP_HOST'];
$currentUrl .= $_SERVER['REQUEST_URI'];


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
        $customthemeplayerrow = $row['customtheme_player_url'];
        $langrow = $row['lang'];
        $librebook_urlrow = $row['librebook_url'];
        $librebook_keyrow = $row['librebook_key'];
    }
    if ($_SESSION['hashed_pass'] == $pwrow) {
    } else {
        session_destroy();
    }
} else {
    session_destroy();
}

?>
<html>
<head>
<?php

$dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$lang = $langrow;
$videoId = $_GET['v'];

$query = "SELECT data, created_at FROM cache_video WHERE video_id = ? AND lang = ?";
$stmt = $pdo->prepare($query);

$stmt->execute([$videoId, $lang]);

$cacheData = $stmt->fetch(PDO::FETCH_ASSOC);

if ($cacheData && (time() - strtotime($cacheData['created_at']) < $cacheTime)) {
    $value = json_decode($cacheData['data'], true);
} else {
    foreach ($InvVIServerArray as $idx => $instance) {
    $position = $idx + 1; 
    $url      = rtrim($instance, '/') . '/api/v1/videos/' . $videoId . '?hl=' . $lang;

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT        => 5,
    ]);
    $resp = curl_exec($ch);
    $err  = curl_error($ch);
    curl_close($ch);

    if ($err) {
        $errors[$position] = $err;
        continue;
    }

    $data = json_decode($resp, true);
    if (isset($data['error']) || $data === null) {
        $errors[$position] = $data['error'] ?? 'API returned null';
        continue;
    }

    // add to cache
    $value    = $data;
    $cacheSql = "REPLACE INTO cache_video (video_id, lang, data, created_at) VALUES (?, ?, ?, CURRENT_TIMESTAMP)";
    $stmt     = $pdo->prepare($cacheSql);
    $stmt->execute([$videoId, $lang, json_encode($value)]);
    break;
}

// ERROR HANDLING
if (!$value) {
    $parts = [];
    foreach ($errors as $pos => $msg) {
        $parts[] = "<br>Instance #{$pos}: {$msg}";
    }
    $apiError = implode("; ", $parts);
}
}  
                    $title = $value['title'];
                    $description = $value['description'];
                    $views = number_format($value['viewCount']);
                    $likes = number_format($value['likeCount']);
                    $author = $value['author'];
                    $authorId = $value['authorId'];
                    $autsubs = $value['subCountText'];
                    $shared = $value['publishedText'];

                    foreach ($value['captions'] as $caption) {
                        $captionshtml .= '<track kind="captions" label="' . htmlspecialchars($caption['label']) . '" srclang="' . htmlspecialchars($caption['languageCode']) . '" src="/videodata/captions.php/?c_ext=' . htmlspecialchars($caption['url']) . '" default>';
                    }

                    if (isset($value['formatStreams']) && is_array($value['formatStreams'])) {
                        foreach ($value['formatStreams'] as $formatStream) {
                            if (isset($formatStream['url'])) {
                                $nonHlsUrls[] = $formatStream['url'];
                                $nonHlsItag[] = $formatStream['itag'];
                                $nonHlsQuality[] = $formatStream['qualityLabel'];
                                $nonHlsType[] = $formatStream['container'];
                                $nonHlsSize[] = $formatStream['size'];
                            }
                        }
                    }
                    if (isset($value['adaptiveFormats']) && is_array($value['adaptiveFormats'])) {
                        foreach ($value['adaptiveFormats'] as $formatStream) {
                            if (isset($formatStream['url'])) {
                                $HlsUrls[] = $formatStream['url'];
                                $HlsItag[] = $formatStream['itag'];
                                $HlsQuality[] = $formatStream['qualityLabel'];
                                $HlsType[] = $formatStream['container'];
                                $HlsSize[] = $formatStream['size'];
                            }
                        }
                    }

$dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($useReturnYTDislike == true) {
    $query = "SELECT data, created_at FROM cache_dislike WHERE video_id = ?";
    $stmt = $pdo->prepare($query);
    
    $stmt->execute([$videoId]);

    $cacheData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cacheData && (time() - strtotime($cacheData['created_at']) < $cacheTime)) {
        $dislikeData = json_decode($cacheData['data'], true);
        $dislikes = " · " . number_format($dislikeData['dislikes']) . ' ' . $translations[$langrow]['estimated_dislikes'];
    } else {
        $dislikeapiurl = 'https://returnyoutubedislikeapi.com/votes?videoId=' . $videoId;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $dislikeapiurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        $dislikeData = json_decode($response, true);
        $dataToCache = json_encode($dislikeData);
        $query = "REPLACE INTO cache_dislike (video_id, data, created_at) VALUES (?, ?, CURRENT_TIMESTAMP)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$videoId, $dataToCache]);
        $dislikes = " · " . number_format($dislikeData['dislikes'] ?? 0) . ' ' . $translations[$langrow]['estimated_dislikes'];
    }
} else {
    $dislikes = '';
}
?>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="Liberatube">
        <link rel="apple-touch-icon" href="favicon.ico">
        <meta property="og:title" content="<?php echo $title; ?>">
        <meta property="og:type" content="website">
        <meta property="og:url" content="/?v=<?php echo $_GET['v']; ?>">
        <meta name="theme-color" content="#303EE1">
        <meta name="author" content="<?php echo $title; ?>">
        <meta name="keywords" content="badyt.cf, liberatube, EpicFaucet, two.epicfaucet.gq, yewtu.be, online videos, alternative youtube frontend, Liberatube">
        <meta property="og:locale" content="en_GB">
        <meta property="og:description" content="<?php echo $description; ?>">
        <meta property="description" content="<?php echo $description; ?>">

<meta name="og:image" content="<?php echo $InvSServer ?>/vi/<?php echo $_GET['v']; ?>/maxres.jpg"/>
<meta name="twitter:card" content="summary_large_image">

<span><meta property="og:site_name" content="Liberatube">
<link itemprop="name" content="Liberatube"></span>

</head>
<body>

<link rel="stylesheet" href="/styles/-w3.css">
<link rel="stylesheet" href="/styles/-bootstrap.min.css">

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
        echo '<link rel="stylesheet" href="../styles/playerblue.css">';
    } elseif(strcmp($themerow, 'ultra-dark') == 0) {
        echo '<link rel="stylesheet" href="../styles/playerultra-dark.css">';
    } elseif ($themerow == "custom") {
        echo '<link rel="stylesheet" href="'.$customthemeplayerrow.'">';
    } else {
        echo '<link rel="stylesheet" href="../styles/player'.$defaultTheme.'.css">';
    } 
    } else {
        echo '<link rel="stylesheet" href="../styles/player'.$defaultTheme.'.css">';
    }
}
?>

<div class="w3-sidebar w3-bar-block w3-collapse w3-card sidebar" style="width:55px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">&times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">home</span><span class="tooltiptext"><?php echo $translations[$langrow]['home']; ?></span></a>
  <?php
  if ($useSQL == true) { ?>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">history</span><span class="tooltiptext"><?php echo $translations[$langrow]['watch_history']; ?></span></a>
  <a href="/playlist/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">list_alt</span><span class="tooltiptext"><?php echo $translations[$langrow]['playlists']; ?></span></a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">subscriptions</span><span class="tooltiptext"><?php echo $translations[$langrow]['subscriptions']; ?></span></a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">settings</span><span class="tooltiptext"><?php echo $translations[$langrow]['settings']; ?></span></a>
  <?php } ?>

  <hr class="hr">
  <?php
            if ($_GET['listen'] == "true") {
                echo '<a href="?v='.$_GET['v'].'&listen=false" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">live_tv</span><span class="tooltiptext">'.$translations[$langrow]['video'].'</span></a>
                      <a href="#" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">headphones</span><span class="tooltiptext">'.$translations[$langrow]['audio'].'</span></a>';
            }
            else {
                echo '<a href="#" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">live_tv</span><span class="tooltiptext">'.$translations[$langrow]['video'].'</span></a>
                      <a href="?v='.$_GET['v'].'&listen=true" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">headphones</span><span class="tooltiptext">'.$translations[$langrow]['audio'].'</span></a>';
            }
        ?>
  </div>
</div>

<div class="w3-main" style="margin-left:55px">
<div class="w3-tssseal">
  <button class="w3-button w3-darkgrey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
  </div>
</div>

<div class="tenborder">

            <?php
            if ($apiError) {
                echo "<h3>API Error: ".$apiError."</h3>";
            }
            if ($userproxysetting == "on" and $allowProxy = "true") {
                $dlsetting = "&dl=true";
            } else {
                $dlsetting = "&dl=false";
            }
            if ($_GET['listen'] == "true") {

                echo '<link rel="stylesheet" href="../styles/audioplayer.css">
                    <center><img style="max-height: 60vh; max-width: 100%;" src="https://i.ytimg.com/vi/'.$_GET['v'].'/maxresdefault.jpg"></center>
                    <audio preload="auto" style="width: 100%; max-height: 90vh; background-color: rgb(0,0,0);" autoplay controls>
                    <source src="/videodata/hls.php?id='.$_GET['v'].$dlsetting.'" type="audio/mp4">
                    Your Browser Sucks! Can not play the audio.
                    </audio>';
            }
            else {

                    $baseUrl = '/videodata/hls.php?id={{videoId}}&itag={{itag}}';

                    foreach ($HlsItag as $index => $itag) {
                        $quality = $HlsQuality[$index];
                        if ($HlsQuality[$index] === null AND $HlsType[$index] !== null AND $HlsType[$index] !== 'webm') {
                            $audioUrl = str_replace(['{{videoId}}', '{{itag}}'], [$_GET['v'], $itag], $baseUrl);
                        } else {
                            $videoUrls[] = [
                                'url' => str_replace(['{{videoId}}', '{{itag}}'], [$_GET['v'], $itag], $baseUrl),
                                'quality' => $quality,
                                'type' => $HlsType[$index]
                            ];
                            
                        }
                    }
                    $videoUrls = array_reverse($videoUrls);
                    echo '<video id="video" class="video" controls preload="auto" data-setup="{}" style="width: 100%; max-height: 90vh; background-color: rgb(0,0,0);" poster="https://i.ytimg.com/vi/'.$_GET['v'].'/maxresdefault.jpg" autoplay>';
                    foreach ($videoUrls as $video) {
                        echo '<source src="'.$video['url'].$dlsetting.'" type="video/mp4" label="HLS '.$video['quality'].' '.$video['type'].'">';
                    }
                    echo '<source src="/videodata/non-hls.php?id='.$_GET['v'].$dlsetting.'" type="video/mp4" label="360p">'
                    .$captionshtml.'Your Browser Sucks! Can not play the video.</video>

                    <audio id="audio" preload="auto">
                    <source src="'.$audioUrl.$dlsetting.'" type="audio/mp4">
                    </audio>
                    ';
            } ?>

    <div class="relatedVideos" style="float: right;">
    <h3>Related videos</h3>
    <?php
    for ($i = 0; $i < 9; $i++) {
        $suggestedvideoId = $value['recommendedVideos'][$i]['videoId'] ?? "";
        $suggestedtitle = $value['recommendedVideos'][$i]['title'] ?? "";
        $suggesteddescription = $value['recommendedVideos'][$i]['descriptionHtml'] ?? "";
        $suggestedchannel = $value['recommendedVideos'][$i]['author'] ?? "";
        $suggestedsharedat = $value['recommendedVideos'][$i]['publishedText'] ?? "";
        $suggestedauthorId = $value['recommendedVideos'][$i]['authorId'] ?? "";

        $lengthseconds = $value['recommendedVideos'][$i]['lengthSeconds'] ?? "";
        $vidhours = floor($lengthseconds / 3600) ?? "";
        $vidmins = floor($lengthseconds / 60 % 60) ?? "";
        $vidsecs = floor($lengthseconds % 60) ?? "";
        if ($vidhours == "0") {
            $timestamp = $vidmins . ':' . $vidsecs ?? "";
        } else {
            $timestamp = $vidhours . ':' . $vidmins . ':' . $vidsecs ?? "";
        }
    ?>

        <a class="awhite" href="/watch/?v=<?php echo $suggestedvideoId; ?>">
            <div class="video-tile w3-animate-left">
                <div class="videoDiv">
                    <img src="http://i.ytimg.com/vi/<?php echo $suggestedvideoId; ?>/mqdefault.jpg" width="256px">
                    <div class="timestamp"><?php echo $timestamp; ?></div>
                </div>
                <div class="videoInfo">
                    <div class="videoTitle"><b><?php echo $suggestedtitle; ?></b><br><?php echo $suggestedchannel; ?> <div style="float: right;"><?php echo $suggestedsharedat; ?></div></div>
                </div>
            </div>
        </a>

    <?php 
    }
    ?> 
</div>  
       
<h3><?php echo $title; ?></h3>
<h4><?php echo $shared; ?> · <?php echo $views; ?> <?php echo $translations[$langrow]['views']; ?> · <?php echo $likes; ?> <?php echo $translations[$langrow]['likes']; ?><?php echo $dislikes; ?></h4>

<?php if ($_GET['listen'] != "true") { ?>
    <select class="button" id="qualitySelector"></select>
<?php } ?>

<a class="button" onclick="Alert_share.render('ok')"><?php echo $translations[$langrow]['share_librebook']; ?>Share</a>
<a class="button" onclick="Alert.render('ok')"><?php echo $translations[$langrow]['download']; ?></a>
<a class="button" onclick="Alert_pl.render('ok')"><?php echo $translations[$langrow]['add_to_playlist']; ?></a>
<a class="button" href="/channel/?id=<?php echo $authorId; ?>"><?php echo $author; ?> · <?php echo $autsubs; ?></a>

<div id="popUpBox_share" style="display: none;">
<div id="box_share" style="max-width: 1200px;">

<h3 style="margin-bottom: 17px;">Share this video</h3>

<h4 style="text-align: left;">Share this video with a link</h4>

<div style="display: flex; align-items: flex-start;">
  <input id="textbox" style="background-color: #2a2a2a; border: none; border-top-left-radius: 8px; border-bottom-left-radius: 8px; padding: 12px; width: 300px; height: 150px; resize: none; outline: none; overflow-x: auto; overflow-y: hidden; text-overflow: ellipsis; white-space: nowrap; height: 34px;" value="<?php echo $currentUrl; ?>">
  <button onclick="copyText(), toast('success', 'URL Copied', 4000);" style="background-color:rgb(44, 68, 0); border: none; padding: 5px 6px; border-top-right-radius: 8px; border-bottom-right-radius: 8px; cursor: pointer;"><span class="material-symbols-outlined">content_copy</span></button>
</div>

<br><h4 style="text-align: left;">Share this video with a Librebook friend</h4>

<?php 
if ($_SESSION['logged_in_user']) { ?>

<?php
if ($librebook_keyrow and $librebook_urlrow) {
    $librebook_request = $librebook_urlrow.'/api.php?apikey='.$librebook_keyrow.'&function=people_you_follow';
    $librebook_friends_c = file_get_contents($librebook_request);

    $librebook_friends = array_map('trim', explode(',', $librebook_friends_c));
    $librebook_user = $librebook_friends[0];
    array_shift($librebook_friends);

    $_SESSION['librebook_instance'] = $librebook_urlrow;
    $_SESSION['librebook_apikey'] = $librebook_keyrow;

    if ($librebook_friends[0] == "No users found.") {
        echo "No friends found.";
    } else {

    ?>
    <form>
    <input type="hidden" id="videoUrl" name="videoUrl" value="<?php echo $currentUrl; ?>">
    <input type="hidden" id="videoTitle" name="videoTitle" value="<?php echo $title; ?>">
    <input type="hidden" id="videoAuthor" name="videoAuthor" value="<?php echo $author; ?>">

    <div id="friendSelect">
        <?php
        foreach ($librebook_friends as $index => $friend) {
            echo '<input type="radio" id="friend'.$index.'" name="friendSelect" value="'.$friend.'" required>';
            echo '<label for="friend'.$index.'">'.$friend.'</label>';
        }
        ?>
    </div>

    <div style="max-width: 250px; text-align: left;">
        <br>
        <p><b><?php echo $librebook_user ?> --> You</b><br>Check out this video!<br><?php echo $title.' - '.$author.' - '.$currentUrl ?></p>
    </div>

    <input type="button" value="Share" onclick="shareWithFriend()">
    </form>
    <style>
        input[type="radio"] {
            display: none;
        }
        label {
            display: block;
            width: 100%;
            padding: 5px;
            padding-left: 15px;
            margin-bottom: 1px;
            text-align: left;
            background-color:rgb(32, 32, 32);
            color: white;
            border-radius: 2px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.1s ease;
        }
        label:hover {
            background-color:rgb(37, 37, 37);
        }
        input[type="radio"]:checked + label {
            background-color:rgb(44, 44, 44);
        }
        input[type="button"] {
            width: 100%;
            padding: 4px;
            background-color:rgb(32, 32, 32);
            color: white;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.1s ease;
        }
        input[type="button"]:hover {
            background-color:rgb(37, 37, 37);
        }
</style>
<?php
    }
} else {
    echo "Librebook API key or URL not set or misconfigured in settings.";
}
} else {
    echo 'You are not logged in. <a href="/auth/login.html">Login</a>';
} ?>

<div id="closeModal_share"><a class="button" onclick="Alert_share.ok()">Close</a></div>
</div>
</div>

<div id="popUpBox_pl" style="display: none;">
<div id="box_pl">
<?php if ($_SESSION['logged_in_user']) { ?>
<h3><?php echo $translations[$langrow]['add_vid_to_playlist']; ?></h3>
<form id="addToPlaylistForm">
    <input type="hidden" id="videoId" name="videoId" value="<?php echo $_GET['v']; ?>">
    <input type="hidden" id="videoTitle" name="videoTitle" value="<?php echo $title; ?>">
    <input type="hidden" id="videoAuthor" name="videoAuthor" value="<?php echo $author; ?>">
    <select id="playlistSelect" name="playlistSelect" required>
    </select>
    <input type="button" value="<?php echo $translations[$langrow]['add_to_playlist']; ?>" onclick="addToPlaylist()">
</form>
<?php } else { ?>
<h3><?php echo $translations[$langrow]['add_vid_to_playlist']; ?></h3>
You are not logged in. <a href="/auth/login.html">Login</a><br><br>
<?php } ?>
<div id="closeModal_pl"><a class="button" onclick="Alert_pl.ok()">Close</a></div>
</div>
</div>

<div id="popUpBox" style="display: none;">
<div id="box">
<?php
if ($allowProxy == "true" or $allowProxy == "downloads") {
    $isProxyDisabled = "";
} else {
    $isProxyDisabled = "disabled";
    $isProxyDisabledMessage = "Proxying is disabled by this instance.";
}
?>
<h3><?php echo $translations[$langrow]['download_this_video']; ?></h3>
<table>
<?php
echo $isProxyDisabledMessage;
?>
<tr><td><h4><?php echo $translations[$langrow]['non-hls_options']; ?></h4></td></tr>
<?php
if (isset($nonHlsItag) && is_array($nonHlsItag) && !empty($nonHlsItag)) {
    for ($i = 0; $i < count($nonHlsItag); $i++) {
        $itag = $nonHlsItag[$i];
        $url = $nonHlsUrls[$i];
        $quality = $nonHlsQuality[$i];
        $type = $nonHlsType[$i];
        $size = $nonHlsSize[$i];

        echo '<tr><td>'.$quality.'('.$itag.') - '.$type.'</td><td><a class="button-in-table" href="'.$url.'">'.$translations[$langrow]['direct'].'</a><a download="'.$_GET['v'].'.'.$type.'" class="button-in-table" href="/videodata/non-hls.php?id='.$_GET['v'].'&dl=dl&itag='.$itag.'">'.$translations[$langrow]['proxy'].'</a></td></tr>';
    }
}
?>
<tr><td><h4><?php echo $translations[$langrow]['hls_options']; ?></h4></td></tr>
<?php
if (isset($HlsItag) && is_array($HlsItag) && !empty($HlsItag)) {
    for ($i = 0; $i < count($HlsItag); $i++) {
        $itag = $HlsItag[$i];
        $url = $HlsUrls[$i];
        $quality = $HlsQuality[$i];
        $type = $HlsType[$i];
        $size = $HlsSize[$i];

        echo '<tr><td>'.$quality.'('.$itag.') - '.$type.'</td><td><a class="button-in-table" href="'.$url.'">'.$translations[$langrow]['direct'].'</a><a download="'.$_GET['v'].'.'.$type.'" class="button-in-table" href="/videodata/hls.php?id='.$_GET['v'].'&dl=dl&itag='.$itag.'">'.$translations[$langrow]['proxy'].'</a></td></tr>';
    }
}
?>
</table>
<div id="closeModal"><a class="button" onclick="Alert.ok()">Close</a></div>
</div>
</div>
<h6></h6>
     <?php
function makeUrltoLink($string) {
    $reg_pattern = "/(((http|https|ftp|ftps)\:\/\/)|(www\.))[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,12}(\:[0-9]+)?(\/\S*)?/";
    return preg_replace($reg_pattern, '<a href="$0" target="_blank" rel="noopener noreferrer">$0</a>', $string);
}

function makeTimestamptoLink($string) {
    $reg_pattern = "/(?<!<\/a>)\b\d{1,2}:\d{1,2}:\d{1,2}\b/";
    return preg_replace($reg_pattern, '<a onclick="seekToTime(\'$0\')">$0</a>', $string);
}

function makeTimestamptoLinkSmaller($string) {
    $reg_pattern = "/<a [^>]*>.*?<\/a>(*SKIP)(*F)|\b\d{1,2}:\d{1,2}\b/";
    return preg_replace($reg_pattern, '<a onclick="seekToTime(\'$0\')">$0</a>', $string);
}

$str = $description;
$cdesc = nl2br($convertedStr = makeUrltoLink($str));
$cdesc = makeTimestamptoLink($cdesc);
$cdesc = makeTimestamptoLinkSmaller($cdesc);

$cdesc = str_replace('href="https://youtu.be/','href="/watch/?v=',$cdesc);
$cdesc = str_replace('href="https://www.youtube.com/watch?v=','href="/watch/?v=',$cdesc);
?>


 
 <details><summary><a class="button"><?php echo $translations[$langrow]['show-hide-desc']; ?></a></summary> <a style="margin-right: 3px;" class="button" href="//youtu.be/<?php echo $_GET['v']?>"><?php echo $translations[$langrow]['watch_on_yt']; ?></a><a style="margin-right: 3px;" class="button" href="//redirect.invidious.io/<?php echo $_GET['v']?>"><?php echo $translations[$langrow]['watch_on_inv']; ?></a><a href="https://liberatube-instances.epicsite.xyz/?v=<?php echo $_GET['v']?>" class="button"><?php echo $translations[$langrow]['switch_instance']; ?></a><hr style="margin-top: 8px; margin-bottom: 5px;" class="hr"><?php echo $cdesc; ?> </details><br>

        <title><?php echo $title; ?> · Liberatube</title>
        <script src="/scripts/-jquery-3.6.4.min.js"></script>
        <script src="/scripts/playermain.js"></script>
        <script src="/scripts/playlist.js"></script>
        <script src="/scripts/sidebar.js"></script>
        <script src="/scripts/toast.js"></script>

<div class="relatedVideosMob">
    <h3>Related videos</h3>
    <?php
    for ($i = 0; $i < 9; $i++) {
        $suggestedvideoId = $value['recommendedVideos'][$i]['videoId'] ?? "";
        $suggestedtitle = $value['recommendedVideos'][$i]['title'] ?? "";
        $suggesteddescription = $value['recommendedVideos'][$i]['descriptionHtml'] ?? "";
        $suggestedchannel = $value['recommendedVideos'][$i]['author'] ?? "";
        $suggestedsharedat = $value['recommendedVideos'][$i]['publishedText'] ?? "";
        $suggestedauthorId = $value['recommendedVideos'][$i]['authorId'] ?? "";

        $lengthseconds = $value['recommendedVideos'][$i]['lengthSeconds'] ?? "";
        $vidhours = floor($lengthseconds / 3600) ?? "";
        $vidmins = floor($lengthseconds / 60 % 60) ?? "";
        $vidsecs = floor($lengthseconds % 60) ?? "";
        if ($vidhours == "0") {
            $timestamp = $vidmins . ':' . $vidsecs ?? "";
        } else {
            $timestamp = $vidhours . ':' . $vidmins . ':' . $vidsecs ?? "";
        }
    ?>

        <a class="awhite" href="/watch/?v=<?php echo $suggestedvideoId; ?>">
            <div class="video-tile w3-animate-left">
                <div class="videoDiv">
                    <img src="http://i.ytimg.com/vi/<?php echo $suggestedvideoId; ?>/mqdefault.jpg" width="256px">
                    <div class="timestamp"><?php echo $timestamp; ?></div>
                </div>
                <div class="videoInfo">
                    <div class="videoTitle"><b><?php echo $suggestedtitle; ?></b><br><?php echo $suggestedchannel; ?> <div style="float: right;"><?php echo $suggestedsharedat; ?></div></div>
                </div>
            </div>
        </a>

    <?php 
    }
    ?> 
</div>
 <?php

    if ($_GET['comments']) {
        $loadcomments = $_GET['comments'];
    }
    if ($loadcomments) {} else {
        $loadcomments = $defaultLoadCommentsSetting;
    }
    if ($loadcomments != "nothing") {
 
    if(!empty($response)) { ?>
        <?php }?>
        <?php                        
                $InvApiUrl = $InvCServer.'/api/v1/comments/'.$_GET['v'].'?hl='.$langrow;

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
                $ccount = $value['commentCount'] ?? "";
                
                echo '<br><br><br><br><h3>'.number_format($ccount).' '.$translations[$langrow]['comments'].'</h3><br>';

                if ($ccount > 20) {
                $ccountl = "20";
                }
                else {
                    $ccountl = $ccount - "1";
                }

                for ($i = 0; $i < $ccountl; $i++) {
                    $aname = $value['comments'][$i]['author'] ?? "";
                    $aturl = $value['comments'][$i]['authorThumbnails']['0']['url'] ?? "";
                    $acon = $value['comments'][$i]['content'] ?? "";
                    $ptex = $value['comments'][$i]['publishedText'] ?? "";
                    $alik = $value['comments'][$i]['likeCount'] ?? "";
                    $auid = $value['comments'][$i]['authorId'] ?? "";

                    if ($loadcomments != "noreplies") {
                    $commentreplycontinuation = $value['comments'][$i]['replies']['continuation'] ?? "";
                    $commentreplyamount = $value['comments'][$i]['replies']['replyCount'] ?? "";

                    $nextpagestr = $value['continuation'] ?? "";

                        $InvApiUrl = $InvCServer.'/api/v1/comments/'.$_GET['v'].'?hl='.$langrow.'&continuation='.$commentreplycontinuation;

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
                        $value_reply = json_decode(json_encode($data), true);
                        $ccount_reply = substr_count($response,"authorIsChannelOwner");

                        if ($ccount_reply > 20) {
                            $ccountl_reply = "20";
                            }
                            else {
                                $ccountl_reply = $ccount_reply - "1";
                            } }
                    ?>
                    <div style="width: 100%; max-width: 775px;">
                    <h4><img style="margin-bottom: -25px; max-width: 48px;" src=<?php echo $aturl; ?>> <a href="/channel/?id=<?php echo $auid.'">'.$aname."</a>"; ?> · <?php echo $ptex; ?> · <?php echo number_format($alik)." ".$translations[$langrow]['likes']; ?>
                    </h4>
                    <br><h5 style="margin-left: 53px; margin-top: -25px;"><?php echo makeTimestamptoLinkSmaller(makeTimestamptoLink(makeUrltoLink($acon)));
                    
                        if ($commentreplyamount != "") {?>

                        <details><summary><?php echo $translations[$langrow]['show']; ?> <?php echo $commentreplyamount; ?> <?php echo $translations[$langrow]['replies']; ?></summary><?php

                            for ($ii = 0; $ii < $ccountl_reply; $ii++) {
                                $aname_reply = $value_reply['comments'][$ii]['author'] ?? "";
                                $aturl_reply = $value_reply['comments'][$ii]['authorThumbnails']['0']['url'] ?? "";
                                $acon_reply = $value_reply['comments'][$ii]['content'] ?? "";
                                $ptex_reply = $value_reply['comments'][$ii]['publishedText'] ?? "";
                                $alik_reply = $value_reply['comments'][$ii]['likeCount'] ?? "";
                                $auid_reply = $value_reply['comments'][$ii]['authorId'] ?? "";
                             ?>

                            <div style="width: 100%; max-width: 775px;">
                            <h4><img style="margin-bottom: -25px; max-width: 48px;" src=<?php echo $aturl_reply; ?>> <a href="/channel/?id=<?php echo $auid.'">'.$aname_reply."</a>"; ?> · <?php echo $ptex_reply; ?> · <?php if($alik_reply > -1){echo number_format($alik_reply)." ".$translations[$langrow]['likes'];} ?>
                            </h4>
                            <br><h5 style="margin-left: 53px; margin-top: -25px;"><?php echo makeTimestamptoLinkSmaller(makeTimestamptoLink(makeUrltoLink($acon_reply))); ?></h5><br>

                       <?php } }?></details></h5>
                    <br>
                </div>  
           <?php 
                    }
                } else {
                    echo '<a class="button" href="?v='.$_GET['v'].'&comments=noreplies">'.$translations[$langrow]['load_comments'].'</a>';
                }
            ?> 
            </div>
            </div>
        
</div> 
</div>
</body>
</html>

<?php // THIS PART ADDS THIS VIDEO TO THE WATCH HISTORY
if ($useSQL == true) {
    $newItem = [
    'video_id' => $_GET['v'],
    'title' => $title,
    'author' => $author,
    'timestamp' => (new \DateTime())->format('Y-m-d H:i:s'),
    ];

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

    $stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['logged_in_user']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) { $watchHistory = json_decode($row['watch_history'], true); }

    $watchHistory[] = $newItem;
    $updatedWatchHistory = json_encode($watchHistory);

    $updateStmt = $conn->prepare("UPDATE login SET watch_history = ? WHERE username = ?");
    $updateStmt->bind_param("ss", $updatedWatchHistory, $_SESSION['logged_in_user']);
    $updateStmt->execute();

    $stmt->close();
    $conn->close();
} ?>
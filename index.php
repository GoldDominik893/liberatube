<?php
session_start();  
include('config.php');

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

$keyword = $_POST['keyword'] ?? "";
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
        <title>Liberatube · Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="Liberatube">
        <link rel="apple-touch-icon" href="favicon.ico">



        <link rel="stylesheet" href="/styles/-w3.css">
<link rel="stylesheet" href="/styles/-bootstrap.min.css">
<link rel="stylesheet" href="/styles/-googlesymbols.css">

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
    } else {
        echo '<link rel="stylesheet" href="../styles/home'.$defaultTheme.'.css">';
    }
}
?>
    <body>




<div class="w3-sidebar w3-bar-block w3-collapse w3-card sidebar" style="width:55px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">&times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">home</span></a>
  <?php
  if ($useSQL == true) { ?>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">history</span></a>
  <a href="/playlist/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">list_alt</span></a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">subscriptions</span></a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">settings</span></a>
  <?php } ?>
</div>

<div class="w3-main" style="margin-left:55px">
<div class="w3-tssseal">
  <button class="w3-button w3-darkgrey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
  <div class="topbar">
    <div class="topbarelements topbarelements-center">
    <h3 class="title-top topbarelements">Liberatube</h3>
    <form class="input-row topbarelements" id="keywordForm" method="get" action="/search/">
                    <input class="input-field" type="search" id="keyword" name="q" placeholder="Search YouTube..." value="<?php echo $keyword; ?>">
            </form>
    </div>

    <?php if ($useSQL == true) { ?>
    <div class="topbarelements topbarelements-right">
    <h4> <?php echo $_SESSION['logged_in_user'] ?? ""; 
    $loggedinuser = $_SESSION['logged_in_user'] ?? "";?> 
    <?php if($loggedinuser != "")
    {
        echo '<a class="button awhite login-item" href="/auth/logout.php"><span class="material-symbols-outlined login-item-icon">logout</span><h5 class="login-item-text">Logout</h5></a>';
    }
    else
    {
        echo '<a class="button awhite login-item" href="/auth/login.html"><span class="material-symbols-outlined login-item-icon">login</span><h5 class="login-item-text">Login/Signup</h5></a>';
    }
    if($loggedinuser == $adminuser)
            {
                echo '<a style="margin-left: 5px;" class="button awhite login-item" href="/admin/"><span class="material-symbols-outlined login-item-icon">monitor_heart</span><h5 class="login-item-text">Admin Panel</h5></a>';
            }
    ?>
    </div>
    <?php } ?>

    </div>
        </div>
</div>
<script src="/scripts/sidebar.js"></script>
<div class="tenborder">
<?php
if ($testinstance == true) {
if ($params['disclaimer'] == "accept") {
    $_SESSION['disclaimer'] = "accept";
    echo '<a href="/?disclaimer=show">Disclaimer</a>';
} 
elseif ($params['disclaimer'] == "show") {
    $_SESSION['disclaimer'] = "";
    echo '<div class="w3-panel w3-blue" style="max-width: 800px; border-radius: 8px;">
        <h3 style="text-decoration: underline;">Disclaimer!</h3>
        <p>Using this Liberatube instance is not recommended for average users as there are some new and untested features and the database which stores user data is sometimes reset.</p>
        <a class="button" href="/?disclaimer=accept">I understand</a><br><br>
      </div>';
} 
else {
    if ($_SESSION['disclaimer'] == "accept") {
        echo '<a href="/?disclaimer=show">Disclaimer</a>';
    } else {
        echo '<div class="w3-panel w3-blue" style="max-width: 800px; border-radius: 8px;">
        <h3 style="text-decoration: underline;">Disclaimer!</h3>
        <p>Using this Liberatube instance is not recommended for average users as there are some new and untested features and the database which stores user data is sometimes reset.</p>
        <a class="button" href="/?disclaimer=accept">I understand</a><br><br>
      </div>';
    }
}
}

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
                    $params['region'] = $regionrow;
                    if (($regionrow ?? "") == "") {
                        $params['region'] = $defaultRegion;
                }
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
                $InvApiUrl = $InvTServer.'/api/v1/trending?pretty=1&region='.$params['region'].'&hl=en&type='.$params['type'];

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
            
            if ($params['type'] == "General" or $params['type'] == "") 
                {
                echo '<div align="left" style="margin-top:-50px">
                      > <a href="#">General</a><br>
                      <a href="/?type=Music">Music</a><br>
                      <a href="/?type=Gaming">Gaming</a><br>
                      <a href="/?type=Movies">Movies</a><br>
                      </div>'; }
            elseif ($params['type'] == "Music") 
                {
                echo '<div align="left" style="margin-top:-50px">
                      <a href="/?type=">General</a><br>
                      > <a href="#">Music</a><br>
                      <a href="/?type=Gaming">Gaming</a><br>
                      <a href="/?type=Movies">Movies</a><br>
                      </div>'; }
            elseif ($params['type'] == "Gaming") 
                {
                echo '<div align="left" style="margin-top:-50px">
                      <a href="/?type=">General</a><br>
                      <a href="/?type=Music">Music</a><br>
                      > <a href="#">Gaming</a><br>
                      <a href="/?type=Movies">Movies</a><br>
                      </div>'; }
            elseif ($params['type'] == "Movies") 
                {
                echo '<div align="left" style="margin-top:-50px">
                      <a href="/?type=">General</a><br>
                      <a href="/?type=Music">Music</a><br>
                      <a href="/?type=Gaming">Gaming</a><br>
                      > <a href="#">Movies</a><br>
                      </div>'; }

                for ($i = 0; $i < $rsults; $i++) {
                    $videoId = $value[$i]['videoId'] ?? "";
                    $title = $value[$i]['title'] ?? "";
                    $description = $value[$i]['descriptionHtml'] ?? "";
                    $channel = $value[$i]['author'] ?? "";
                    $sharedat = $value[$i]['publishedText'] ?? "";

                    $lengthseconds = $value[$i]['lengthSeconds'] ?? "";
                    $vidhours = floor($lengthseconds / 3600) ?? "";
                    $vidmins = floor($lengthseconds / 60 % 60) ?? "";
                    $vidsecs = floor($lengthseconds % 60) ?? "";
                    if ($vidhours == "0") {
                        $timestamp = $vidmins.':'.$vidsecs ?? "";
                    } else {
                        $timestamp = $vidhours.':'.$vidmins.':'.$vidsecs ?? "";
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
                        <div class="videoTitle"><?php echo $channel; ?> · Shared <?php echo $sharedat; ?><br><b><center><?php echo $title; ?></center></b></div>
                        
                        </div>
                        </div>
                        </a>
           <?php 
                    }
           
            }
            ?> 
            </div>
        </div>
        <br><div class="videos-data-container footer w3-animate-left">
            Liberatube Version 1.9 beta · Licensed under AGPLv3 on GitHub · Credits: Dominic Wajda (GoldDominik893).<br>
            This website is optimised for mobile users and does not collect any user data apart from<br> watch history which doesn't exist yet and you will be able to turn it off when logged in.
            <br><a href="https://matrix.to/#/#libreratube:matrix.org">Join the Matrix</a> <a href="https://discord.gg/z4cCk5c5Zj">or discord</a> · <a href="https://invidious.io">Invidious</a> · <a href="https://github.com/GoldDominik893/liberatube">GitHub</a> · <a href="/donate.html">Donate to the Liberatube project</a><br>
            Have you noticed a bug or want to see a new feature? <a href="https://github.com/GoldDominik893/liberatube/issues">Open an issue on GitHub</a>
            </div>
        </div>
    </body>
</html>
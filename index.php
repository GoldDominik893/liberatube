<?php
session_start();  
include('config.php');
$langrow = $defaultLang;
include('lang.php');

if ($useSQL) {

$sqlFilePath = "database.sql";
$flagFilePath = "database.sql.executed";

    if (!file_exists($flagFilePath)) {
        $sqlCommands = file_get_contents($sqlFilePath);
        $conn = new mysqli($servername, $username, $password);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($conn->multi_query($sqlCommands)) {
            file_put_contents($flagFilePath, "");
            echo "<h1>To Admin: Database and tables created successfully.</h1>";
        } else {
            echo "<h1>To Admin: Error executing SQL file: " . $conn->error . "<br>Are you using a online hosting provider? Check the documentation for installation on a hosting provider.</h1>";
        }

        $conn->close();
    }
}

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
<head>
    <head>

        <title>Liberatube · <?php echo $translations[$langrow]['home']; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="Liberatube">
        <link rel="apple-touch-icon" href="favicon.ico">



        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta property="og:title" content="Home Page">
        <meta property="og:type" content="website">
        <meta property="og:url" content="/">
        <meta name="theme-color" content="#303EE1">
        <meta name="keywords" content="libretube, badyt.cf, liberatube, EpicFaucet, two.epicfaucet.gq, yewtu.be, alternative youtube frontend, Liberatube, invidious">
        <meta property="og:locale" content="en_GB">
        <meta property="og:description" content="Liberatube is a Privacy, Feature Rich alternative front end to YouTube.">
        <meta property="description" content="Liberatube is a Privacy, Feature Rich alternative front end to YouTube.">
        <meta name="og:image" content="https://github.com/GoldDominik893/file-hosting/blob/main/images/favicon.png?raw=true"/>

        <span><meta property="og:site_name" content="Liberatube">
        <link itemprop="name" content="Liberatube"></span>



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
        echo '<link rel="stylesheet" href="../styles/homeblue.css">';
    } elseif(strcmp($themerow, 'ultra-dark') == 0) {
        echo '<link rel="stylesheet" href="../styles/homeultra-dark.css">';
    } elseif ($themerow == "custom") {
        echo '<link rel="stylesheet" href="'.$customthemehomerow.'">';
    } else {
        echo '<link rel="stylesheet" href="../styles/home'.$defaultTheme.'.css">';
    } 
    } else {
        echo '<link rel="stylesheet" href="../styles/home'.$defaultTheme.'.css">';
    }
}
?>

</head>
    <body>




<div class="w3-sidebar w3-bar-block w3-collapse w3-card sidebar" style="width:55px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">&times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">home</span><span class="tooltiptext"><?php echo $translations[$langrow]['home']; ?></span></a>
  <?php
  if ($useSQL == true) { ?>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">history</span><span class="tooltiptext"><?php echo $translations[$langrow]['watch_history']; ?></span></a>
  <a href="/playlist/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">list_alt</span><span class="tooltiptext"><?php echo $translations[$langrow]['playlists']; ?></span></a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">subscriptions</span><span class="tooltiptext"><?php echo $translations[$langrow]['subscriptions']; ?></span></a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">settings</span><span class="tooltiptext"><?php echo $translations[$langrow]['settings']; ?></span></a>
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
                    <input class="input-field" type="search" id="keyword" name="q" placeholder="<?php echo $translations[$langrow]['search_yt']; ?>" value="<?php echo $keyword; ?>">
            </form>
    </div>

    <?php if ($useSQL == true) { ?>
    <div class="topbarelements topbarelements-right">
    <h4> <?php echo $_SESSION['logged_in_user'] ?? ""; 
    $loggedinuser = $_SESSION['logged_in_user'] ?? "";?> 
    <?php if($loggedinuser != "")
    {
        echo '<a class="button awhite login-item" href="/auth/logout.php"><span class="material-symbols-outlined login-item-icon">logout</span><h5 class="login-item-text">'.$translations[$langrow]['logout'].'</h5></a>';
    }
    else
    {
        echo '<a class="button awhite login-item" href="/auth/login.html"><span class="material-symbols-outlined login-item-icon">login</span><h5 class="login-item-text">'.$translations[$langrow]['login-signup'].'</h5></a>';
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
    echo '<a href="/?disclaimer=show">'.$translations[$langrow]['disclaimer'].'</a>';
} 
elseif ($params['disclaimer'] == "show") {
    $_SESSION['disclaimer'] = "";
    echo '<div class="w3-panel" style="max-width: 800px; border-radius: 8px; background-color: #1e81b066">
        <h3 style="text-decoration: underline;">'.$translations[$langrow]['disclaimer'].'!</h3>
        <p>'.$translations[$langrow]['disclaimer_text'].'</p>
        <a class="button" href="/?disclaimer=accept">'.$translations[$langrow]['i-understand'].'</a><br><br>
      </div>';
} 
else {
    if ($_SESSION['disclaimer'] == "accept") {
        echo '<a href="/?disclaimer=show">'.$translations[$langrow]['disclaimer'].'</a>';
    } else {
        echo '<div class="w3-panel" style="max-width: 800px; border-radius: 8px; background-color: #1e81b066;">
        <h3 style="text-decoration: underline;">'.$translations[$langrow]['disclaimer'].'!</h3>
        <p>'.$translations[$langrow]['disclaimer_text'].'</p>
        <a class="button" href="/?disclaimer=accept">'.$translations[$langrow]['i-understand'].'</a><br><br>
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
                if (($params['region'] ?? "") == "") {
                    $params['region'] = $regionrow;
                    if (($regionrow ?? "") == "") {
                        $params['region'] = $defaultRegion;
                }
                }
                
                if ($params['region'] == "GB") {
                    $responsetren = '<h3>'.$translations[$langrow]['trendingcontent_gb'].'</h3>';
                }
                elseif ($params['region'] == "US") {
                    $responsetren = '<h3>'.$translations[$langrow]['trendingcontent_usa'].'</h3>';
                }
                else {
                    $responsetren = '<h3>'.$translations[$langrow]['trendingcontent_code'].' "'.$params['region'].'"</h3>';
                }
                $InvApiUrl = $InvTServer.'/api/v1/trending?pretty=1&region='.$params['region'].'&hl='.$langrow.'&type='.$params['type'];

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
                echo '<div align="left" style="margin-top:10px">
                      <a class="trending-cat-btn trending-cat-btn-selected" href="#">'.$translations[$langrow]['general'].'</a>
                      <a class="trending-cat-btn" href="/?type=Music">'.$translations[$langrow]['music'].'</a>
                      <a class="trending-cat-btn" href="/?type=Gaming">'.$translations[$langrow]['gaming'].'</a>
                      <a class="trending-cat-btn" href="/?type=Movies">'.$translations[$langrow]['movies'].'</a><br><br>
                      </div>'; }
            elseif ($params['type'] == "Music") 
                {
                echo '<div align="left" style="margin-top:10px">
                      <a class="trending-cat-btn" href="/?type=">'.$translations[$langrow]['general'].'</a>
                      <a class="trending-cat-btn trending-cat-btn-selected" href="#">'.$translations[$langrow]['music'].'</a>
                      <a class="trending-cat-btn" href="/?type=Gaming">'.$translations[$langrow]['gaming'].'</a>
                      <a class="trending-cat-btn" href="/?type=Movies">'.$translations[$langrow]['movies'].'</a><br><br>
                      </div>'; }
            elseif ($params['type'] == "Gaming") 
                {
                echo '<div align="left" style="margin-top:10px">
                      <a class="trending-cat-btn" href="/?type=">'.$translations[$langrow]['general'].'</a>
                      <a class="trending-cat-btn" href="/?type=Music">'.$translations[$langrow]['music'].'</a>
                      <a class="trending-cat-btn trending-cat-btn-selected" href="#">'.$translations[$langrow]['gaming'].'</a>
                      <a class="trending-cat-btn" href="/?type=Movies">'.$translations[$langrow]['movies'].'</a><br><br>
                      </div>'; }
            elseif ($params['type'] == "Movies") 
                {
                echo '<div align="left" style="margin-top:10px">
                      <a class="trending-cat-btn" href="/?type=">'.$translations[$langrow]['general'].'</a>
                      <a class="trending-cat-btn" href="/?type=Music">'.$translations[$langrow]['music'].'</a>
                      <a class="trending-cat-btn" href="/?type=Gaming">'.$translations[$langrow]['gaming'].'</a>
                      <a class="trending-cat-btn trending-cat-btn-selected" href="#">'.$translations[$langrow]['movies'].'</a><br><br>
                      </div>'; }

                for ($i = 0; $i < $rsults; $i++) {
                    $videoId = $value[$i]['videoId'] ?? "";
                    $title = $value[$i]['title'] ?? "";
                    $description = $value[$i]['descriptionHtml'] ?? "";
                    $channel = $value[$i]['author'] ?? "";
                    $sharedat = $value[$i]['publishedText'] ?? "";
                    $authorId = $value[$i]['authorId'] ?? "";

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
                        <img src="http://i.ytimg.com/vi/<?php echo $videoId; ?>/mqdefault.jpg" height="144px">
                        <div class="timestamp"><?php echo $timestamp; ?></div>
                        </div>
                        <div class="videoInfo">
                        <div class="videoTitle"><b><?php echo $title; ?></b><br><?php echo $channel; ?> <div style="float: right;"><?php echo $sharedat; ?></div></div>
                        </div>
                        </div>
                        </a>

                        
           <?php 
                    }
            ?> 
            </div>
        </div>
        <br><div class="videos-data-container footer w3-animate-left">
            Liberatube Version 1.9 delta · Licensed under AGPLv3 on GitHub · Credits: Dominic Wajda (GoldDominik893).
            <br><a href="https://matrix.to/#/#libreratube:matrix.org">Join the Matrix</a> <a href="https://discord.gg/z4cCk5c5Zj">or discord</a> · <a href="https://invidious.io">Invidious</a> · <a href="https://github.com/GoldDominik893/liberatube">GitHub</a> · <a href="https://epicsite.xyz#donate">Donate to the Liberatube project</a> · <a href="https://liberatube-docs.epicsite.xyz/general/4.privacy/">Privacy Policy</a><br>
            Have you noticed a bug or want to see a new feature? <a href="https://github.com/GoldDominik893/liberatube/issues">Open an issue on GitHub</a>
            </div>
        </div>
    </body>
</html>
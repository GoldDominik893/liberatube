<?php
session_start();

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
include('config.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Bad YouTube | Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

        <style>

            body {
                font-family: Arial;
                padding: 0px;
                color: white;
                background-color: #2a2a2a;
            }
            .search-form-container {
                background: #3B3B3B;
                border: #3B3B3B 1px solid;
                padding: 20px;
                border-radius: 6px;
            }
            .input-row {
                margin-bottom: 20px;
            }
            .input-field {
                width: 100%;
                border-radius: 2px;
                padding: 10px;
                border: #515151 1px solid;
                background: #515151;
            }
            .input-field:focus {
                color: white;
            }
            .input-field2 {
                width: 100%;
                max-width: 100px;
                border-radius: 2px;
                padding: 10px;
                border: #515151 1px solid;
                background: #515151;
            }
            .input-field2:focus {
                color: white;
            }
            .btn-submit {
                padding: 10px 20px;
                background: #333;
                border: #333 1px solid;
                color: #f0f0f0;
                font-size: 0.9em;
                width: 100px;
                border-radius: 6px;
                cursor:pointer;
            }
            .videos-data-container {
                background: #3B3B3B;
                border: #3B3B3B 1px solid;
                padding: 10px;
                border-radius: 6px;
            }
            .response {
                padding: 10px;
                margin-top: 10px;
                border-radius: 2px;
            }
            .error {
                 background: #331111;
            }
           .success {
                background: #c5f3c3;
                border: #bbe6ba 1px solid;
            }
            .result-heading {
                margin: 30px 0px;
                padding: 20px 10px 5px 0px;
                border-bottom: #e0dfdf 1px solid;
            }
            iframe {
                border: 0px;
            }
            .video-tile {
                display: inline-block;
                margin: 10px 10px 20px 10px;
                border: #222222 2px solid;
                border-radius: 8px;
                background-color: #222222;
                transition: transform 0.2s;
            }
            .video-tile:hover {
                transform: scale(1.01);
                transition: transform 0.2s;
            }
            .videoDiv {
                width: 270px;
                height: 160px;
                display: inline-block;
                padding-top: 6px;
            }
            .videoTitle {
                text-overflow: ellipsis;
                overflow: hidden;
                white-space: initial;
            }
            .videoDesc {
                text-overflow: ellipsis;
                overflow: hidden;
                white-space: initial;
            }
            .videoInfo {
                width: 270px;
            }
            a {
                color: #777;
                transition: transform 0.2s;
            }
            a:hover{
    color:#ff4444;
    text-decoration: none;
    transition: transform 0.2s;
            }
            a:focus {
               color:#ff4444;
    text-decoration: none;
    transition: transform 0.2s;
            }
            details {
              padding: 10px 20px;
                background: #335;
                border: #333 1px solid;
                color: #f0f0f0;
                font-size: 0.9em;
                width: 100%;
                max-width: 415px;
                border-radius: 6px;
                cursor:pointer;  
            }
            .detailred {
                padding: 10px 20px;
                background: #533;
                border: #333 1px solid;
                color: #f0f0f0;
                font-size: 0.9em;
                width: 100%;
                max-width: 415px;
                border-radius: 6px;
                cursor:pointer;  
            }
            .search-inline {
                display: inline-block;
            }
            .awhite {
                color: white;
            }
            .awhite:hover {
                color: DodgerBlue;
            }
            .tenborder {
                padding: 10px;
            }
            .sidebar {
                background-color: #222222;
                margin: 10px;
                border-radius: 6px;
            }
            .sidebarbtn-selected {
                background-color: #444444;
            }
            .sidebarbtn:hover {
                background-color: #333333;
            }
            .awhitesidebar {
                color: white;
            }
            .awhitesidebar:hover {
                color: lightgray;
            }
            .sidebarbtn-selected:hover {
                background-color: #555555;
            }
            .topbar {
                  width: 100%;
            }
            .topbarelements {
                display: inline-block;
            }
            .topbarelements-right {
                float: right;
                margin-top: 15px;
            }
            .topbarelements-center {
                float: left;
            }
            .button {
        display: inline-block;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        background-color: rgba(20,20,20,0.2);
        border-radius: 6px;
        outline: none;
      }
.material-symbols-outlined {
  font-variation-settings:
  'FILL' 0,
  'wght' 400,
  'GRAD' 0,
  'opsz' 48
}
            .login-item {
                display: inline-block;
            }
            .login-item-icon {
                float: left;
                margin-right: 5px;
                margin-top: 5px;
            }
            .login-item-icon, .login-item-text {
  display: flex;
  flex-direction: row;
  align-items: center;
  list-style-type: none;
}
        </style>

    <body>




<div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-left sidebar" style="width:190px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Close &times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected">Home</a>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar">Watch History</a>
  <a href="/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar">Playlists</a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar">Subscriptions</a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar">Settings</a>
</div>

<div class="w3-main" style="margin-left:200px">
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
                $InvApiUrl = 'https://inv.riverside.rocks/api/v1/trending?pretty=1';

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
            ?>

            <br>
            <div class="videos-data-container w3-animate-left" id="SearchResultsDiv">
            
<div style="text-align: center;">
<h2> Trending Content </h2>
            <?php
                for ($i = 0; $i < 115; $i++) {
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
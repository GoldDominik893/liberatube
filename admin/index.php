<?php
session_start();  
include('../config.php');
?>
<!DOCTYPE HTML>
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
.hr {
    margin: 3px;
    margin-right: 5px;
    margin-left: 5px;

    height: 1px;
    color: #888888;
    background-color: #888888;
    border: none;
}
        </style>

    <body>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag("js", new Date());
gtag("config", "ID");
</script>


<div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-left sidebar" style="width:190px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Close &times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar">Home</a>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar">Watch History</a>
  <a href="/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar">Playlists</a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar">Subscriptions</a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar">Settings</a>
  <hr class="hr">
  <a href="#" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected">Admin Panel</a>
</div>

<div class="w3-main" style="margin-left:200px">
<div class="w3-tssseal">
  <button class="w3-button w3-darkgrey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
  <div class="topbar">
    <div class="topbarelements topbarelements-center">
    </div>
    <div class="topbarelements topbarelements-right">

    <h4> <?php echo $_SESSION['logged_in_user']; ?>
    <?php if(isset($_SESSION['logged_in_user']))
    {
        echo '<a class="button awhite login-item" href="../logout.php"><span class="material-symbols-outlined login-item-icon">logout</span><h5 class="login-item-text">Logout</h5></a>';
    }
    else
    {
        echo '<a class="button awhite login-item" href="../login.php"><span class="material-symbols-outlined login-item-icon">login</span><h5 class="login-item-text">Login/Signup</h5></a>';
    }
    ?>
    </h4>
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
<?php
        if($_SESSION['logged_in_user'] == $adminuser)
            {
                echo '<h1>Welcome to the admin panel!</h1>';
$n=8;
function getName($n) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
 
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
 
    return $randomString;
}
 
echo getName($n);

            }
            else 
            {
                echo '<h1>You do not have permission to access this page.</h1>';
            }
            ?>
            </div>
        </div>
        </div>
    </body>
</html>
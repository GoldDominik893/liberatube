<?php 
session_start(); 
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

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
                width: 100%;
                max-width: 400px;
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
                margin-bottom: 10px;
            }
            .input-field:focus {
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
                color: green;
            }
            a:hover {
                color: lime;
            }
            a:focus {
                color: lime;
            }
            details {
              padding: 10px 20px;
                background: #335;
                border: #333 1px solid;
                color: #f0f0f0;
                font-size: 0.9em;
                width: 300px;
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
            hr {
    margin: 3px;
    margin-right: 5px;
    margin-left: 5px;

    height: 1px;
    color: #888888;
    background-color: #888888;
    border: none;
}
        </style>

<div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-left sidebar" style="width:190px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Close &times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar">Home</a>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar">Watch History</a>
  <a href="/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar">Playlists</a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar">Subscriptions</a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar">Settings</a>
  <hr>
  <a href="#" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected">Login</a>
  <a href="/signup.php" class="w3-bar-item sidebarbtn awhitesidebar">Signup</a>
</div>

<div class="w3-main" style="margin-left:200px">
<div class="w3-tssseal">
  <button class="w3-button w3-darkgrey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
    <center><h1>Login</h1></center>
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
    
     if (isset($_POST['submit']) )
     {
          
        $name = $_POST['name'];
        $pass = $_POST['pass'];

    }
         
?>

<div class="search-form-container">
            <form id="keywordForm" method="post" action="loginsql.php" formtarget="_blank">
                    <label for="name">Username</label>
                    <input required class="input-field" type="text" id="name" name="name"  placeholder="Username" value=""><br>
                    <label for="pass">Password</label>
                    <input required class="input-field" type="password" id="pass" name="pass" placeholder="Password" value=""><br>
                <input class="btn-submit" type="submit" name="submit" value="Login">    
            </form>
       </div>

 
<br><video src="https://files.epicsite.xyz/videos/wmpwinxp.mp4" autoplay controls style="width: 100%; max-width: 400px;"></video>

<h3 style="width: 100%; max-width: 400px;"> Why is this video here? In developing it makes it easier to find this tab as i usually have loads of tabs open and on the tab there is a little sound icon so it makes it easier. </h3>

        </div>
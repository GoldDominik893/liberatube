<?php
session_start();
include('config.php');
$nothing = ""
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<?php
include('../config.php');
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
$query = mysqli_query($conn, "SELECT * FROM login WHERE username = '".$_SESSION['logged_in_user']."'");
$numrows = mysqli_num_rows($query);
while ($row = mysqli_fetch_assoc($query))
{
    $themerow = $row['theme'];
    $langrow = $row['lang'];
}
$row = mysqli_fetch_assoc($query);
$numrows = mysqli_num_rows($query);
}
?>

<div class="w3-sidebar w3-bar-block w3-collapse w3-card sidebar" style="width:55px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">&times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">home</span></a>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">history</span></a>
  <a href="/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">list_alt</span></a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">subscriptions</span></a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">settings</span></a>
</div>

<div class="w3-main" style="margin-left:55px">
<div class="w3-tssseal">
  <button class="w3-button w3-darkgrey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
    <center><h1>Settings</h1></center>
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

<?php
if(isset($_SESSION['logged_in_user'])) {
echo '<h4 style="text-align: center;">This is still in development.<br></h4>';
echo '<div class="tenborder">
<form action="" method="post" formtarget="_blank">
  <label for="theme">Theme:</label>
  <select class="formsel" style="border-radius: 6px;" id="theme" name="theme" value="--Please Select--">
  <option class="formsel" value="'.$themerow.'">Selected: '.$themerow.'</option>
  <option class="formsel" disabled value="">----------</option>
    <option class="formsel" value="dark">Dark</option>
    <option class="formsel" value="blue">Blue</option>
    <option class="formsel" value="ultra-dark">Ultra-Dark</option>
    <option class="formsel" value="light">Light</option>
  </select>
  <br>
  <label for="lang">Language: <i>(soon)</i></label>
  <select class="formsel" style="border-radius: 6px;" id="lang" name="lang" value="--Please Select--">
  <option class="formsel" value="'.$langrow.'">Selected: '.$langrow.'</option>
  <option class="formsel" disabled value="">----------</option>
    <option class="formsel" value="en">English</option>
    <option class="formsel" value="fr">Français</option>
    <option class="formsel" value="es">Español</option>
    <option class="formsel" value="pl">Polski</option>
  </select>
  <br>
  <label for="region">Region: <i>(soon)</i></label>
  <select class="formsel" style="border-radius: 6px;" id="region" name="region" value="--Please Select--">
  <option class="formsel" value="'.$nothing.'">Selected: '.$nothing.'</option>
  <option class="formsel" disabled value="">----------</option>
    <option class="formsel" value="GB">GB</option>
    <option class="formsel" value="FR">FR</option>
    <option class="formsel" value="US">US</option>
    <option class="formsel" value="ES">ES</option>
    <option class="formsel" value="PL">PL</option>
    <option class="formsel" value="DE">DE</option>
    <option class="formsel" value="KR">KR</option>
    <option class="formsel" value="NO">NO</option>    
    <option class="formsel" value="CA">CA</option>
    <option class="formsel" value="UA">UA</option>
    <option class="formsel" value="RU">RU</option>
    <option class="formsel" value="SA">SA</option>
    <option class="formsel" value="MT">MT</option>
    <option class="formsel" value="JP">JP</option>
    <option class="formsel" value="AD">AD</option>
    <option class="formsel" value="DZ">DZ</option>
    <option class="formsel" value="MX">MX</option>
    <option class="formsel" value="MA">MA</option>
    <option class="formsel" value="MC">MC</option>
    <option class="formsel" value="NL">NL</option>
    <option class="formsel" value="NZ">NZ</option>
    <option class="formsel" value="AU">AU</option>
    <option class="formsel" value="PT">PT</option>
    <option class="formsel" value="QA">QA</option>
    <option class="formsel" value="SG">SG</option>
    <option class="formsel" value="TR">TR</option>
    <option class="formsel" value="IN">IN</option>
    <option class="formsel" value="ZA">ZA</option>
    <option class="formsel" value="TN">TN</option>
    <option class="formsel" value="DK">DK</option>
    <option class="formsel" value="BR">BR</option>
    <option class="formsel" value="CZ">CZ</option>
    <option class="formsel" value="IE">IE</option>
    <option class="formsel" value="IT">IT</option>
    <option class="formsel" value="LV">LV</option>
    <option class="formsel" value="RO">RO</option>
    <option class="formsel" value="SK">SK</option>
    <option class="formsel" value="SI">SI</option>
  </select>
  <br>
  <label for="vidshadow">Video Shadow: <i>(Soon)</i></label>
  <input type="checkbox" id="vidshadow" name="vidshadow" checked>
  <br><input class="formsel" style="border-radius: 6px;" value="Save" type="submit">
</form>
</div>';
} else {
echo '<h4 style="text-align: center;">You are not logged in.</h4>';
}
$theme = $_POST['theme'] ?? "";
$lang = $_POST['lang'] ?? "";
$dbsenduser = $_SESSION['logged_in_user'];
if($theme != "")
{
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$select = mysqli_query($conn, "SELECT * FROM login WHERE username = '".$_POST['name']."'");
if(mysqli_num_rows($select)) {
}

$sql = "UPDATE login
SET theme = '$theme', lang = '$lang'
WHERE username = '$dbsenduser';";

if ($conn->query($sql) === TRUE) {
      
} else {
  echo "Error: <br>" . $conn->error;
}
$conn->close();
}

?>

<?php
include('../config.php');
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
$query = mysqli_query($conn, "SELECT * FROM login WHERE username = '".$_SESSION['logged_in_user']."'");
$numrows = mysqli_num_rows($query);
while ($row = mysqli_fetch_assoc($query))
{
    $themerow = $row['theme'];
}
$row = mysqli_fetch_assoc($query);
$numrows = mysqli_num_rows($query);
}
                if(strcmp($themerow, 'dark') == 0)
            {
                echo '<link rel="stylesheet" href="../styles/playerdark.css">';
            } elseif(strcmp($themerow, 'blue') == 0)
            {
                echo '<link rel="stylesheet" href="../styles/playerblue.css">';
            } elseif(strcmp($themerow, 'ultra-dark') == 0)
            {
                echo '<link rel="stylesheet" href="../styles/playerultra-dark.css">';
            } elseif(strcmp($themerow, 'light') == 0)
            {
                echo '<link rel="stylesheet" href="../styles/playerlight.css">';
            } else 
            {
                echo '<link rel="stylesheet" href="../styles/player'.$defaultTheme.'.css">';
            } 
                ?>
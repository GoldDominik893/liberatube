<?php
session_start();  
include('../config.php');
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$query = mysqli_query($conn, "SELECT * FROM login WHERE username = '".$_SESSION['logged_in_user']."'");
$numrows = mysqli_num_rows($query);
while ($row = mysqli_fetch_assoc($query))
{   
    $pwrow = $row['password'];
}
if ($_SESSION['hashed_pass'] == $pwrow) {
    } else {
        session_destroy();
    }
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Liberatube · Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="/styles/general.css">

    <body>


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
        echo '<a class="button awhite login-item" href="/logout.php"><span class="material-symbols-outlined login-item-icon">logout</span><h5 class="login-item-text">Logout</h5></a>';
    }
    else
    {
        echo '<a class="button awhite login-item" href="/login.html"><span class="material-symbols-outlined login-item-icon">login</span><h5 class="login-item-text">Login/Signup</h5></a>';
    }
    ?>
    </h4>
    </div>
    </div>
  </div>
</div>
<script src="/scripts/sidebar.js"></script>
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
    echo "randomstring: ";
    return $randomString;
}
 
echo getName($n);


echo '<br><br>PHP_SELF: '.$_SERVER['PHP_SELF'].'<br>GATEWAY_INTERFACE: '.
$_SERVER['GATEWAY_INTERFACE'].'<br>SERVER_ADDR: '.
$_SERVER['SERVER_ADDR']	.'<br>SERVER_NAME: '.
$_SERVER['SERVER_NAME'].'<br>SERVER_SOFTWARE: '.
$_SERVER['SERVER_SOFTWARE']	.'<brSERVER_PROTOCOL: >'.
$_SERVER['SERVER_PROTOCOL']	.'<brREQUEST_MOTHOD: >'.
$_SERVER['REQUEST_METHOD'].'<brREQUEST_TIME: >'.
$_SERVER['REQUEST_TIME'].'<brQUERY_STRING: >'.
$_SERVER['QUERY_STRING'].'<brHTTP_ACCEPT: >'.
$_SERVER['HTTP_ACCEPT']	.'<brHTTP_ACCEPT_CHARSET: >'.
$_SERVER['HTTP_ACCEPT_CHARSET'].'<br>HTTP_HOST: '.
$_SERVER['HTTP_HOST'].'<br>HTTP_REFERRER: '.
$_SERVER['HTTP_REFERER'].'<br>HTTPS: '.
$_SERVER['HTTPS'].'<br>REMOTE_ADDR: '.
$_SERVER['REMOTE_ADDR']	.'<br>REMOTE_HOST: '.
$_SERVER['REMOTE_HOST'].'<br>REMOTE_PORT: '.
$_SERVER['REMOTE_PORT']	.'<br>SCRIPT_FILENAME: '.
$_SERVER['SCRIPT_FILENAME']	.'<br>SERVER_ADMIN: '.
$_SERVER['SERVER_ADMIN'].'<br>SERVER_PORT: '.
$_SERVER['SERVER_PORT']	.'<br>SERVER_SIGNATURE: '.
$_SERVER['SERVER_SIGNATURE'].'<br>PATH_TRANSLATED: '.
$_SERVER['PATH_TRANSLATED']	.'<br>SCRIPT_NAME: '.
$_SERVER['SCRIPT_NAME']	.'<br>SCRIPT_URI: '.
$_SERVER['SCRIPT_URI'];


echo '<br><br><br><a href="update.php">Launch Liberatube updater</a>';

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
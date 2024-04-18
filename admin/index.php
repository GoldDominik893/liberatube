<?php
session_start();  
include('../config.php');
if ($useSQL == false) {
    echo "the sql-less feature is on so this won't work. redirecting back to home in 2 seconds";
    header( "refresh:2;url=/" );
    exit();
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
        <title>Liberatube · Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="/styles/-w3.css">
<link rel="stylesheet" href="/styles/-bootstrap.min.css">
<link rel="stylesheet" href="/styles/-googlesymbols.css">
        <link rel="stylesheet" href="/styles/general.css">

    <body>


<div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-left sidebar" style="width:190px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Close &times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar">Home</a>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar">Watch History</a>
  <a href="/playlist/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar">Playlists</a>
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
        echo '<a class="button awhite login-item" href="/auth/logout.php"><span class="material-symbols-outlined login-item-icon">logout</span><h5 class="login-item-text">Logout</h5></a>';
    }
    else
    {
        echo '<a class="button awhite login-item" href="/auth/login.html"><span class="material-symbols-outlined login-item-icon">login</span><h5 class="login-item-text">Login/Signup</h5></a>';
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
                echo '<h3>Welcome to the admin panel!</h3><br>';

                        ?>
                        <form method="post" action=".">
                            <p>Update the Invidious instances used</p>
                            <label for="InvCServer">InvCServer: </label>
                            <input type="text" value="<?php echo $_POST['InvCServer'] ?? $InvCServer; ?>" name="InvCServer" id="InvCServer">
                            <br><label for="InvVIServer">InvVIServer: </label>
                            <input type="text" value="<?php echo $_POST['InvVIServer'] ?? $InvVIServer; ?>" name="InvVIServer" id="InvVIServer">
                            <br><label for="InvTServer">InvTServer: </label>
                            <input type="text" value="<?php echo $_POST['InvTServer'] ?? $InvTServer; ?>" name="InvTServer" id="InvTServer">
                            <br><label for="InvSServer">InvSServer: </label>
                            <input type="text" value="<?php echo $_POST['InvSServer'] ?? $InvSServer; ?>" name="InvSServer" id="InvSServer">
                            <br><input type="submit">
                        </form>
                        <?php
                    


                        $configFilePath = "../config.php";

                        if(isset($_POST['InvCServer']) && isset($_POST['InvVIServer']) && isset($_POST['InvTServer']) && isset($_POST['InvSServer'])) {

                            $newInvCServer = $_POST['InvCServer'];
                            $newInvVIServer = $_POST['InvVIServer'];
                            $newInvTServer = $_POST['InvTServer'];
                            $newInvSServer = $_POST['InvSServer'];

                            $configContent = file_get_contents($configFilePath);

                            $patterns = array(
                                '/\$InvCServer\s*=\s*".*?";/',
                                '/\$InvVIServer\s*=\s*".*?";/',
                                '/\$InvTServer\s*=\s*".*?";/',
                                '/\$InvSServer\s*=\s*".*?";/'
                            );

                            $replacements = array(
                                '$InvCServer = "' . $newInvCServer . '";',
                                '$InvVIServer = "' . $newInvVIServer . '";',
                                '$InvTServer = "' . $newInvTServer . '";',
                                '$InvSServer = "' . $newInvSServer . '";'
                            );

                            $newConfigContent = preg_replace($patterns, $replacements, $configContent);

                            file_put_contents($configFilePath, $newConfigContent);

                        }






                echo '<br><br><a href="update.php">Launch Liberatube updater</a>';

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
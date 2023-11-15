<!DOCTYPE HTML>
<html>
    <head>
        <title>Liberatube · Manage your account</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="/styles/-w3.css">
<link rel="stylesheet" href="/styles/-bootstrap.min.css">
<link rel="stylesheet" href="/styles/-googlesymbols.css">
        <link rel="stylesheet" href="/styles/login.css">
        <?php
session_start();  
include('config.php');
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

    <body>

<div class="w3-sidebar w3-bar-block w3-collapse w3-card sidebar" style="width:55px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">&times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">home</span></a>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">history</span></a>
  <a href="/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">list_alt</span></a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">subscriptions</span></a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">settings</span></a>
  <hr class="hr">
  <a href="#" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">account_circle</span></a>
</div>

<div class="w3-main" style="margin-left:55px">
<div class="w3-tssseal">
  <button class="w3-button w3-darkgrey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
    <div class="topbar">
    <div class="topbarelements topbarelements-center">
    <h1>Manage your account</h1>
    </div>
    <div class="topbarelements topbarelements-right">
    <h4> <?php echo $_SESSION['logged_in_user']; ?>
    <?php if(isset($_SESSION['logged_in_user']))
    {
        echo '<a class="button awhite login-item" href="logout.php"><span class="material-symbols-outlined login-item-icon">logout</span><h5 class="login-item-text">Logout</h5></a>';
    }
    else
    {
        echo '<a class="button awhite login-item" href="login.html"><span class="material-symbols-outlined login-item-icon">login</span><h5 class="login-item-text">Login/Signup</h5></a>';
    }
    ?>
    </div>
    </div>
  </div>
<script src="/scripts/sidebar.js"></script>


<?php

if ($_SESSION['logged_in_user'] == False) {
    echo '<center><h4>You are not logged in.</h4></center>';
} else {
?>
    <div style="margin: 0 auto;" class="settingsdiv">
        <?php
        if ($_GET['r'] == "password") {
            ?> 
                <h3>Change your password</h3><br>
                <form action="" method="post">
  <label for="oldpass">Old Password:</label>
  <input type="password" id="oldpass" name="oldpass" required placeholder="Old Password"><br>

  <label for="newpass">New Password:</label>
  <input type="password" id="newpass" name="newpass" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 16 or more characters" placeholder="New Password" value=""><br>

  <input type="submit" value="Change Password">
</form>
<div id="message">
  <h3>Password must contain the following:</h3>
  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
  <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
  <p id="number" class="invalid">A <b>number</b></p>
  <p id="length" class="invalid">Minimum <b>16 characters</b></p>
</div>	
<script src="/scripts/password_validator.js"></script>

            <?php
            if ($_POST['oldpass'] and $_POST['newpass']) {
                $conn = mysqli_connect($servername, $username, $password, $dbname);
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                $oldpass = $_POST['oldpass'];
                $newpass = $_POST['newpass'];
                $username = $_SESSION['logged_in_user'];
                $sql = "SELECT salt1, password, salt2 FROM login WHERE username='$username'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);
                    $hashed_password = hash('sha512', $row['salt1'] . $oldpass . $row['salt2']);
                    if ($hashed_password == $row['password']) {
                        $new_hashed_password = hash('sha512', $row['salt1'] . $newpass . $row['salt2']);
                        $sql = "UPDATE login SET password='$new_hashed_password' WHERE username='$username'";
                        if (mysqli_query($conn, $sql)) {
                            echo "Password updated successfully";
                            header("Location: /");
                        } else {
                            echo "Error updating password: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Incorrect old password";
                    }
                } else {
                    echo "User not found";
                }
                mysqli_close($conn); 
            }
        } elseif ($_GET['r'] == "delete") {
            ?>
                <h3>Delete your account</h3>
                <form action="" method="post">
  <label for="newpass">Password:</label>
  <input type="password" id="password" name="password" required placeholder="Password" value=""><br>

  <input type="submit" class="danger" value="Delete your account">
</form>
            <?php
            if ($_POST['password']) {
            $conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$password = $_POST['password'];
$username = $_SESSION['logged_in_user'];
$sql = "SELECT salt1, password, salt2 FROM login WHERE username='$username'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $hashed_password = hash('sha512', $row['salt1'] . $password . $row['salt2']);
    if ($hashed_password == $row['password']) {
        $sql = "DELETE FROM login WHERE username='$username'";
        if (mysqli_query($conn, $sql)) {
            header("Location: /");
            exit;
        } else {
            echo "Error deleting user account: " . mysqli_error($conn);
        }
    } else {
        echo "Incorrect password";
    }
} else {
    echo "User not found";
}

mysqli_close($conn);
            }
        } 
    }
        ?>
    </div>

    </div>
    </div>
  </div>
</div>
</div>
</div>
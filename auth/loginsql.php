<link rel="stylesheet" href="/styles/login.css">
<?php
session_start();

$usr = $_POST['name'];
$pw = $_POST['pass'];

include('../config.php');

if ($usr && $pw)
{
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->bind_param("s", $usr);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc())
    {
        $dbusername = $row['username'];
        $dbpassword = $row['password'];
        $dbsalt1 = $row['salt1'];
        $dbsalt2 = $row['salt2'];
        $hashsaltusergivenpassword = hash('sha512', $dbsalt1 . $pw . $dbsalt2);
    }

    if ($usr == $dbusername && $hashsaltusergivenpassword == $dbpassword)
    {
        $_SESSION['logged_in_user'] = $usr;
        $_SESSION['hashed_pass'] = $dbpassword;
        header("refresh:0;url=/");
    }
    else {
        echo "<h2>Invalid User or Password</h2>";
    }

    die();
}
?>
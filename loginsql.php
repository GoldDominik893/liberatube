<?php
session_start();

$usr = $_POST['name'];
$pw = $_POST['pass'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($usr&&$pw)

{
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$query = mysqli_query($conn, "SELECT * FROM login WHERE username = '".$usr."'");
$numrows = mysqli_num_rows($query);


while ($row = mysqli_fetch_assoc($query))
{
    $dbusername = $row['username'];
    $dbpassword = $row['password'];
    $dbsalt1 = $row['salt1'];
    $dbsalt2 = $row['salt2'];
    $hashsaltusergivenpassword = hash('sha512', $dbsalt1 . $pw . $dbsalt2);
}
if ($usr==$dbusername&&$hashsaltusergivenpassword==$dbpassword)
{
    $_SESSION['logged_in_user'] = $usr;
    header("refresh:0;url=/");
}
else {
    echo "<h2>Invalid User or Password</h2>";
}

die();
}

?>
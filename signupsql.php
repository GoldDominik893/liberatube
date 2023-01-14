<style>
  body {
    background-color: #2a2a2a;
  }
</style>
<?php
session_start();

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

$usr = $_POST['name'];
$salt1 = getName($n);
$salt2 = getName($n);
$pw = hash('sha512', $salt1.$_POST['pass'].$salt2);

include('config.php');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$select = mysqli_query($conn, "SELECT * FROM login WHERE username = '".$_POST['name']."'");
if(mysqli_num_rows($select)) {
    header( "refresh:2;url=signup.php" );
    exit('<h2>This username already exists</h2>');
}

$sql = "INSERT INTO login (username, password, salt1, salt2)
VALUES ('$usr', '$pw', '$salt1', '$salt2')";

if ($conn->query($sql) === TRUE) {
      echo "<h2>Welcome $usr. Redirecting Soon...</h2>";
    $_SESSION['logged_in_user'] = $usr;
} else {
  echo "Error: <br>" . $conn->error;
}

$conn->close();

header( "refresh:2;url=index.php" );
?>
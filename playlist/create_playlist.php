<?php
include('../config.php');
session_start();

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["new_playlist_name"])) {
    $newPlaylistName = $_POST["new_playlist_name"];

    // Create an array with an empty string
    $videoIdsArray = [];

    // Convert the array to a JSON-encoded string
    $videoIds = json_encode($videoIdsArray);

    // Prepare and execute the SQL query to create a new playlist with the array
    $query = "INSERT INTO playlist (username, playlist_name, video_ids) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Use "s" for a string
    $stmt->bind_param("sss", $_SESSION['logged_in_user'], $newPlaylistName, $videoIds);

    if ($stmt->execute()) {
        header('Location: playlists.php');
    } else {
        echo "Error creating playlist: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
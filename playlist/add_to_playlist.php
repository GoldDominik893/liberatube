<?php
include('../config.php');
session_start();

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $videoId = $_POST["videoId"];
    $playlistId = $_POST["playlistId"];

    // Validate and sanitize user inputs as needed

    // Check if the video ID and playlist ID exist
    $query = "SELECT video_ids, playlist_name FROM playlist WHERE playlist_id = ? AND username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $playlistId, $_SESSION['logged_in_user']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $videoInfoArray = json_decode($row['video_ids'], true);
        $playlistName = $row['playlist_name'];

        // Add new video information to the array
        $newVideoInfo = array(
            "id" => $videoId,
            "title" => $_POST["videoTitle"],
            "author" => $_POST["videoAuthor"]
        );

        $videoInfoArray[] = $newVideoInfo;

        // Update the playlists table with the modified video information
        $updateQuery = "UPDATE playlist SET video_ids = ? WHERE playlist_id = ? AND username = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("sss", json_encode($videoInfoArray), $playlistId, $_SESSION['logged_in_user']);

        if ($updateStmt->execute()) {
            echo 'Video added to the "'.$playlistName.'" playlist.';
        } else {
            echo "Error adding video to playlist.";
        }
        $updateStmt->close();
    } else {
        echo "Playlist not found.";
    }
    $stmt->close();
}
$conn->close();
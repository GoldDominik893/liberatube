<?php
include('../config.php');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['logged_in_user'])) {
    http_response_code(403);
    echo "Not logged in.";
    exit;
}

// Validate request method
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo "Invalid request method.";
    exit;
}

// Validate required POST fields
if (!isset($_POST["videoId"], $_POST["playlistId"], $_POST["videoTitle"], $_POST["videoAuthor"])) {
    http_response_code(400);
    echo "Missing required parameters.";
    exit;
}

// Create DB connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo "Database connection failed.";
    exit;
}

$videoId = $_POST["videoId"];
$playlistId = $_POST["playlistId"];
$videoTitle = $_POST["videoTitle"];
$videoAuthor = $_POST["videoAuthor"];
$username = $_SESSION['logged_in_user'];

// Fetch playlist
$query = "SELECT video_ids, playlist_name FROM playlist WHERE playlist_id = ? AND username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $playlistId, $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Playlist not found.";
    $stmt->close();
    $conn->close();
    exit;
}

$row = $result->fetch_assoc();
$playlistName = $row['playlist_name'];
$videoInfoArray = json_decode($row['video_ids'], true) ?: [];

// Append new video
$videoInfoArray[] = [
    "id" => $videoId,
    "title" => $videoTitle,
    "author" => $videoAuthor
];

// Update playlist
$updateQuery = "UPDATE playlist SET video_ids = ? WHERE playlist_id = ? AND username = ?";
$updateStmt = $conn->prepare($updateQuery);
$updatedJson = json_encode($videoInfoArray);
$updateStmt->bind_param("sss", $updatedJson, $playlistId, $username);

if ($updateStmt->execute()) {
    echo 'Video added to the "' . htmlspecialchars($playlistName) . '" playlist.';
} else {
    http_response_code(500);
    echo "Error updating playlist.";
}

$updateStmt->close();
$stmt->close();
$conn->close();
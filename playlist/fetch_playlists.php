<?php
// Enable error reporting for debugging (you may remove this in a production environment)
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Include the configuration file
include('../config.php');

// Start the session
session_start();

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the SQL query to fetch playlists
$query = "SELECT playlist_id AS id, playlist_name AS name FROM playlist WHERE username = ?";
$stmt = $conn->prepare($query);

// Bind the session username to the query
$stmt->bind_param("s", $_SESSION['logged_in_user']);
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Initialize an array to store playlists
$playlists = array();

// Fetch playlists and store them in the array
while ($row = $result->fetch_assoc()) {
    $playlists[] = array(
        'id'   => $row['id'],
        'name' => $row['name']
    );
}

// Close the database connection
$stmt->close();
$conn->close();

// Return the playlists as JSON
header('Content-Type: application/json');
echo json_encode($playlists);
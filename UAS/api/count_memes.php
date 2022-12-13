<?php
session_start();
header('Access-Control-Allow-Origin: *');
$mysqli = new mysqli("localhost", "root", "", "uas_fsp");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}

// Default Status and Message
$status = 'error';
$msg = 'Get memes error!';

if (isset($_SESSION['user'])) {
    // Get all meme counts
    $sql = "SELECT count(*) as total_memes FROM memes";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    // Set success status 
    $status = 'success';
    $msg = $row['total_memes'];
}

// Return Json
echo json_encode(array(
    "status" => $status,
    "msg" => $msg,
));

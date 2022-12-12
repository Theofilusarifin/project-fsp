<?php
session_start();
header('Access-Control-Allow-Origin: *');
$mysqli = new mysqli("localhost", "root", "", "uas_fsp");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}

// Default Status and Message
$status = 'error';
$msg = 'Like Process error!';

if(isset($_SESSION['user']) && isset($_POST['meme_id'])){
    // Get passed variable
    $username = $_SESSION['user'];
    $meme_id = $_POST['meme_id'];
    
    // Insert new many to many like data
    $sql = "INSERT INTO likes (user_username, meme_id) VALUES (?,?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $username, $meme_id);
    $stmt->execute();

    // Get new meme detail
    $sql = "SELECT count(meme_id) as total_like FROM memes m LEFT JOIN likes l ON l.meme_id = m.id WHERE m.id = ? GROUP BY m.id";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $meme_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()){
        // Assign passed variable
        $status = 'success';
        $msg = $row['total_like'];
    }
}

// Return Json
echo json_encode(array(
    "status" => $status,
    "msg" => $msg,
));
?>
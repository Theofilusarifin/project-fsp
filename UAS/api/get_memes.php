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

if (isset($_SESSION['user']) && isset($_POST['data_page']) && isset($_POST['page'])) {
    // Get passed variable
    $username = $_SESSION['user'];
    $data_page = $_POST['data_page'];
    $page = $_POST['page'];
    $offset = $data_page * ($page-1);

    // Get meme id that already liked by login user
    $sql = "SELECT meme_id FROM likes WHERE user_username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $username);
    $stmt->execute();
    $res = $stmt->get_result();

    $meme_liked_id = [];
    // If there is memes that liked by login user
    if ($res->num_rows > 0){
        while ($row = $res->fetch_assoc()) {
            // Store the meme id in array
            array_push($meme_liked_id, $row['meme_id']);
        }
    }

    // Get all meme detail and pagination
    $sql = "SELECT m.*, count(meme_id) as total_like FROM memes m LEFT JOIN likes l ON l.meme_id = m.id GROUP BY m.id ORDER BY m.id LIMIT ?,?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $offset, $data_page);
    $stmt->execute();
    $res = $stmt->get_result();

    $memes = [];
    while ($row = $res->fetch_assoc()) {
        // if meme is already liked by user, set liked to true so user can not like it again
        $liked = (in_array($row['id'], $meme_liked_id)) ? true : false;
        $meme = array("id" => $row['id'], "img_url" => $row['img_url'], "total_like" => $row['total_like'], "liked" => $liked);
        // Store meme details to array
        $memes[] = $meme;
    }
    // Set success status 
    $status = 'success';
    $msg = $memes;
}

// Return Json
echo json_encode(array(
    "status" => $status,
    "msg" => $msg,
));
?>
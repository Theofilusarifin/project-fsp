<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "uas_fsp");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}

if(isset($_SESSION['username']) && isset($_POST['idMeme'])){
    $username = $_SESSION['username'];
    $id = $_POST['idMeme'];
    $sql = "INSERT INTO likes (user_username, meme_id) VALUES (?,?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $username, $id);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        $arr = ["status" => "success", "msg" => "insert success"];
    } else {
        $arr = ["status" => "failed", "msg" => "insert failed"];
    }
} else {
    $arr = ["status" => "failed", "msg" => "no session or id memes"];
}
echo json_encode($arr);
?>
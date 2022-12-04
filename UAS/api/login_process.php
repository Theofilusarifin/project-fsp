<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "uas_fsp");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $status = '';
    $msg = '';

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $username, $password);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    if (!$row) {
        $status = 'error';
        $msg = 'This credential does not match our records!';
    } else {
        $status = 'success';
        $msg = 'Login successful!';
    }
    
    echo json_encode(array(
        "status" => $status, 
        "msg" => $msg
    ));
}

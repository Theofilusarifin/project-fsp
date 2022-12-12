<?php
session_start();
header('Access-Control-Allow-Origin: *');
// Default Status and Message
$status = 'error';
$msg = 'Logout error!';

// Check if there any user that login before
if (isset($_SESSION['user']) && !empty($_SESSION['user'])){
    // unset session
    unset($_SESSION['user']);
    session_destroy();

    $status = 'success';
    $msg = 'Logout successful!';
}

// Return Json
echo json_encode(array(
    "status" => $status,
    "msg" => $msg
));

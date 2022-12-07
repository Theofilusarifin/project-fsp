<?php
$mysqli = new mysqli("localhost", "root", "", "uas_fsp");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}

if (isset($_POST['memes'])) {
    $status = '';

    $sql = "SELECT * FROM memes LIMIT 0, 12";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $res = $stmt->get_result();

    if($res->num_rows > 0){
        // $row = $res->fetch_all();
        $data = [];
        while($row = $res->fetch_assoc()){
            array_push($data, $row);
        }
        $status = "success";
        $arr = ["status"=>$status, "msg"=>$data];
    } else{
        $status = "failed";
        $arr = ["status"=>$status, "msg"=>"error"];
    }
    
    echo json_encode($arr);
}

<?php
$mysqli = new mysqli("localhost", "root", "", "uas_fsp");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}

if (isset($_POST['memes']) && isset($_POST['username'])) {
    $username = $_POST['username'];

    //Select all memes that already liked by user login
    $sql = "SELECT meme_id FROM likes WHERE user_username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        $idLiked = [];
        while ($row = $res->fetch_assoc()) {
            array_push($idLiked, $row['meme_id']);
        }

        // Select 12 first memes to be shown on index.php
        $sql = "SELECT * FROM memes LIMIT 0, 12";
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $data = [];
            while ($row = $res->fetch_assoc()) {
                if(in_array($row['id'], $idLiked)){
                    $row['liked'] = 'yes';
                } else {
                    $row['liked'] = 'no';
                }
                array_push($data, $row);
            }
            $status = "success";
            $arr = ["status" => $status, "msg" => $data, "idLiked" => $idLiked];
        } else {
            $status = "failed";
            $arr = ["status" => $status, "msg" => "error"];
        }
        echo json_encode($arr);
    }

    // $sql = "SELECT * FROM memes LIMIT 0, 12";
    // $stmt = $mysqli->prepare($sql);
    // $stmt->execute();
    // $res = $stmt->get_result();

    // if ($res->num_rows > 0) {
    //     $data1 = [];
    //     while ($row = $res->fetch_assoc()) {
    //         array_push($data1, $row);
    //     }
    //     $status = "success";
    //     $arr = ["status" => $status, "msg" => $data1];
    // } else {
    //     $status = "failed";
    //     $arr = ["status" => $status, "msg" => "error"];
    // }
    // echo json_encode($arr);
}
?>
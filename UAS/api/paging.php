<?php
$mysqli = new mysqli("localhost", "root", "", "uas_fsp");
$arr = [];

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}
if (isset($_POST['command'])) {
    $command = $_POST['command'];
    if ($command == 'jumpage') {
        $sql = "SELECT * FROM memes";
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
        $res = $stmt->get_result();

        //How many paging we could create
        if ($res->num_rows > 0) {
            $jumData = $res->num_rows;
            $jumPage = ceil($jumData / 12);
            $status = 'success';
            $msg = $jumPage;
            $status = "success";
            $arr = ["status" => $status, "msg" => $msg];
        } else {
            $status = "failed";
            $arr = ["status" => $status, "msg" => $sql];
        }
    } else if ($command == 'showContent' && isset($_POST['page']) && isset($_POST['idLiked'])) {
        $start = ((int) $_POST['page'] - 1) * 12;
        $idLiked = $_POST['idLiked'];

        $sql = "SELECT * FROM memes LIMIT $start, 12";
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            // $row = $res->fetch_all();
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
            $arr = ["status" => $status, "msg" => $data];
        } else {
            $status = "failed";
            $arr = ["status" => $status, "msg" => $sql];
        }
    }
} else {
    $status = "failed";
    $arr = ["status" => $status, "msg" => "no command to be executed"];
}
echo json_encode($arr);
?>
<?php

//  Define all the require
require("class/jadwal.php");
//Create objects from class
$jadwal = new Jadwal("localhost", "root", "", "project_uts");

// print_r($_POST);
if (isset($_POST['submit'])) {
    if (!empty($_POST['checkbox_jadwal'])) {
        $nrp = $_POST['nrp'];
        $jadwal->DeleteJadwal($nrp);
        foreach ($_POST['checkbox_jadwal'] as $value) {
            $data = explode("_", $value);
            $idhari = $data[0];
            $idjam_kuliah = $data[1];
            $jadwal->InsertJadwal($nrp, $idjam_kuliah, $idhari);
        }
        header("Location: index.php");
    }
}
?>
<?php
//  Define the require
require("class/jadwal.php");
//Create object from class
$jadwal = new Jadwal("localhost", "root", "", "project_uts");

// Security for post method 
if (isset($_POST['submit'])) {
    if (!empty($_POST['checkbox_jadwal'])) {
        // Define selected mahasiswa nrp
        $nrp = $_POST['nrp'];
        // Delete all previous selected mahasiswa jadwal
        $jadwal->DeleteJadwal($nrp);
        // Input all new many to many jadwal data
        foreach ($_POST['checkbox_jadwal'] as $value) {
            $data = explode("_", $value);
            $idhari = $data[0];
            $idjam_kuliah = $data[1];
            $jadwal->InsertJadwal($nrp, $idjam_kuliah, $idhari);
        }
        // After finished, redirect to index
        header("Location: index.php");
    }
}
?>
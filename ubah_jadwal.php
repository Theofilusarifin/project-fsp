<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <title>Ubah Jadwal</title>
</head>

<body>
    <?php
    //Return to index.php if user direct manually to ubah_jadwal.php without submit nrp from the index.php
        if(!isset($_GET['nrp'])){
            header('Location: index.php');
        }
    ?>
    <form action="proses_update_jadwal.php" method="post">
        <?php
        //  Define all the require
        require("class/mahasiswa.php");
        require("class/hari.php");
        require("class/jam_kuliah.php");
        require("class/jadwal.php");

        //Create objects from class
        $mahasiswa = new Mahasiswa("localhost", "root", "", "project_uts");
        $hari = new Hari("localhost", "root", "", "project_uts");
        $jam_kuliah = new Jam_Kuliah("localhost", "root", "", "project_uts");
        $jadwal = new Jadwal("localhost", "root", "", "project_uts");

        // Get Mahasiswa Name
        $mahasiswa_name = $mahasiswa->SearchMahasiswa($_GET['nrp'])->fetch_assoc()['nama'];

        // Display Mahasiswa Name
        echo "<label id='label1'>Mahasiswa : </label>";
        echo "<label>" . $_GET['nrp'] . " - " . $mahasiswa_name . "</label>";
        echo "<br><br>";

        // Get current mahasiswa jadwal
        $jadwal_kuliah_mahasiwa = [];
        $data_jadwal = $jadwal->SearchJadwal($_GET['nrp']);
        // Pass all current mahasiswa jadwal to the array
        while ($row = $data_jadwal->fetch_assoc()) {
            $jadwal_kuliah_mahasiwa[$row['idjam_kuliah']][$row['idhari']] = 1;
        }

        // Create a new array for jadwal
        $jadwal_keseluruhan = [];
        $range_jam_kuliah = [];
        // Fill jadwal keseluruhan
        $data_jam_kuliah = $jam_kuliah->ShowJamKuliah();
        // Model array [idjam_kuliah][idhari]
        while ($row = $data_jam_kuliah->fetch_assoc()) {
            $data_hari = $hari->ShowHari();
            $range_jam_kuliah[] = date('H:i', strtotime($row['jam_mulai'])) . " - " . date('H:i', strtotime($row['jam_selesai']));
            while ($col = $data_hari->fetch_assoc()) {
                // If there is jadwal on currect 2d index, fill the array with 1
                $jadwal_keseluruhan[$row['idjam_kuliah']][$col['idhari']] = isset($jadwal_kuliah_mahasiwa[$row['idjam_kuliah']][$col['idhari']]) ? 1 : 0;
            }
        }

        echo "<table class='container'>";

        echo "<tr>";
        echo "<th></th>";
        $data_hari = $hari->ShowHari();
        //  Display row 1 that filled with all hari in database
        while ($row = $data_hari->fetch_assoc()) {
            echo "<th><h1>" . $row['nama'] . "</h1></th>";
        }
        echo "</tr>";

        // Display row 2-n that filled with jam kuliah and selected jadwal 
        $i = 0;
        // Define jam_kuliah prequisities
        foreach ($jadwal_keseluruhan as $idjam_kuliah => $jam_kuliah) {
            echo "<tr>";
            echo "<td>" . $range_jam_kuliah[$i] . "</td>";
            $i += 1;
            // Define hari prequisities
            foreach ($jam_kuliah as $idhari => $hari) {
                echo "<td>";
                // Check wheter there is jadwal or not? if any, give checked
                $checked = isset($jadwal_kuliah_mahasiwa[$idjam_kuliah][$idhari]) ? "checked" : "";
                // Set checkbox value into idjamkuliah_idhari, we will explode it on the process
                $value = $idjam_kuliah . "_" . $idhari;
                echo "<input type='checkbox' name='checkbox_jadwal[]' value='$value' $checked>";
                echo "</td>";
            }
            echo "</tr>";
        }

        echo "</table>";
        ?>
        <br>
        <!-- Input hidden to pass selected mahasiswa NRP to the process -->
        <input type="hidden" name="nrp" value="<?= $_GET['nrp'] ?>">
        <input type="submit" name="submit" value="Ubah Jadwal" id="btn_ubah">
    </form>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        table,
        td,
        th {
            border: 1px solid black;
            text-align: left;
            /* width: 35rem; */
            height: 2rem;
            padding-left: 5px;
            padding-right: 5px;
        }

        table {
            border-collapse: collapse;
        }
    </style>

</head>

<body>
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

        $nama_mhs = '';
        //panggil method SearchMahasiswa
        $result = $mahasiswa->SearchMahasiswa($_GET['nrp']);
        while ($row = $result->fetch_assoc()) {
            $nama_mhs = $row['nama'];
        }

        echo "<label>Mahasiswa : </label>";
        echo $_GET['nrp'] . " - " . $nama_mhs;
        echo "<br><br>";

        // Get current student jadwal
        $jadwal_kuliah_mahasiwa = [];
        $result_jadwal = $jadwal->SearchJadwal($_GET['nrp']);
        // Pass all current student jadwal to the array
        while ($row = $result_jadwal->fetch_assoc()) {
            $jadwal_kuliah_mahasiwa[$row['idjam_kuliah']][$row['idhari']] = 1;
        }

        // Create a new array for jadwal
        $jadwal_keseluruhan = [];
        $range_jam_kuliah = [];
        // Fill jadwal keseluruhan
        $result_jam_kuliah = $jam_kuliah->ShowJamKuliah();
        while ($row = $result_jam_kuliah->fetch_assoc()) {
            $result_hari = $hari->ShowHari();
            $range_jam_kuliah[] = date('H:i', strtotime($row['jam_mulai'])) . " - " . date('H:i', strtotime($row['jam_selesai']));
            while ($col = $result_hari->fetch_assoc()) {
                $jadwal_keseluruhan[$row['idjam_kuliah']][$col['idhari']] = isset($jadwal_kuliah_mahasiwa[$row['idjam_kuliah']][$col['idhari']]) ? 1 : 0;
            }
        }

        echo "<table>";

        $show_hari = $hari->ShowHari();
        echo "<tr>";
        echo "<td></td>";
        //nampilin harinya dalam satu baris
        while ($row = $show_hari->fetch_assoc()) {
            echo "<td>" . $row['nama'] . "</td>";
        }
        echo "</tr>";

        $i = 0;
        foreach ($jadwal_keseluruhan as $idjam_kuliah => $jam_kuliah) {
            echo "<tr>";
            echo "<td>" . $range_jam_kuliah[$i] . "</td>";
            $i += 1;
            foreach ($jam_kuliah as $idhari => $hari) {
                echo "<td>";
                $checked = isset($jadwal_kuliah_mahasiwa[$idjam_kuliah][$idhari]) ? "checked" : "";
                $value = $idjam_kuliah . "_" . $idhari;
                echo "<input type='checkbox' name='checkbox_jadwal[]' value='$value' $checked>";
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        ?>
        <br>
        <input type="hidden" name="nrp" value="<?= $_GET['nrp'] ?>">
        <input type="submit" name="submit" value="Ubah Jadwal">
    </form>

</body>

</html>
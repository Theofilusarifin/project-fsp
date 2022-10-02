<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/custom.css">
</head>

<body>
    <!-- FORM SELECT MAHASISWA -->
    <form action="" method="get">
        <label id="label1">Mahasiswa : </label>
        <select id="nrp_mahasiswa" name="selector_nrp">
            <option value="" selected>-- Pilih Mahasiswa --</option>
            <?php
            // Define the require
            require("class/mahasiswa.php");
            // Create object from class 
            $mahasiswa = new Mahasiswa("localhost", "root", "", "project_uts");

            // Define prequisities data
            $selected_nrp = 0;
            $is_disabled = "disabled";
            // Check if there any nrp that already selected
            if (isset($_GET['selector_nrp'])) {
                if ($_GET['selector_nrp'] != "") {
                    $selected_nrp = $_GET['selector_nrp'];
                    $is_disabled = "";
                }
            }

            // Get all mahasiswa data
            $data_mahasiswa = $mahasiswa->ShowMahasiswa();
            // Passing data to the select box
            while ($mahasiswa = $data_mahasiswa->fetch_assoc()) {
                // Store each mahasiswa data upon itteration
                $nama_mahasiswa = $mahasiswa['nama'];
                $nrp_mahasiswa = $mahasiswa['nrp'];
                // Check if current mahasiswa is selected or not
                $is_selected = ($nrp_mahasiswa == $selected_nrp) ? 'selected' : '';
                // Pass mahasiswa name to the select box
                echo "<option value='$nrp_mahasiswa' $is_selected>$nama_mahasiswa</option>";
            }
            ?>
        </select>
        <input type="submit" value="Pilih" id="btn_pilih">
    </form>

    <br>
    <!-- SCHEDULE TABLE -->
    <table class="container">
        <?php
        display_data($selected_nrp);
        ?>
    </table>
    <br>

    <!-- FORM UBAH JADWAL -->
    <form action="ubah_jadwal.php" method="get" id="form-ubah">
        <input type="hidden" name="nrp" value="">
        <button id="btn_ubah" <?php echo $is_disabled ?>>Ubah Jadwal</button>
    </form>

    <!-- JQUERY SCRIPT -->
    <script>
        $("#btn_ubah").on("click", function() {
            // Pass selected NRP in FORM SELECT MAHASISWA into input hidden in FORM UBAH JADWAL
            $("input[name='nrp']").attr("value", $('select[name=selector_nrp] option').filter(':selected').val());
            // Submit FORM UBAH JADWAL
            $("form-ubah").submit();
        });
    </script>

    <?php
    function display_data($nrp)
    {
        //  Define all the require
        require("class/hari.php");
        require("class/jam_kuliah.php");
        require("class/jadwal.php");

        //Create objects from class
        $hari = new Hari("localhost", "root", "", "project_uts");
        $jam_kuliah = new Jam_Kuliah("localhost", "root", "", "project_uts");
        $jadwal = new Jadwal("localhost", "root", "", "project_uts");

        // Get current student jadwal
        $jadwal_kuliah_mahasiswa = [];
        $selected_jadwal = $jadwal->SearchJadwal($nrp);
        // Pass all current student jadwal to the array
        while ($row = $selected_jadwal->fetch_assoc()) {
            $jadwal_kuliah_mahasiswa[$row['idjam_kuliah']][$row['idhari']] = 1;
        }

        echo "<tr>";
        echo "<th></th>";
        $data_hari = $hari->ShowHari();
        //  Display row 1 that filled with all hari in database
        while ($row = $data_hari->fetch_assoc()) {
            echo "<th><h1>" . $row['nama'] . "</h1></th>";
        }
        echo "</tr>";

        // Display row 2-n that filled with jam kuliah and selected jadwal 
        $data_jam_kuliah = $jam_kuliah->ShowJamKuliah();
        while ($row = $data_jam_kuliah->fetch_assoc()) {
            echo "<tr>";
            // Display the range jam kuliah on the first col
            echo "<td>" . date('H:i', strtotime($row['jam_mulai'])) . " - " . date('H:i', strtotime($row['jam_selesai'])) . "</td>";
            $data_hari = $hari->ShowHari();
            while ($col = $data_hari->fetch_assoc()) {
                // If the jadwal is match then give a tick symbol ✔
                $is_ticked = (isset($jadwal_kuliah_mahasiswa[$row['idjam_kuliah']][$col['idhari']])) ? '✔' : '';
                echo "<td>$is_ticked</td>";
            }
            echo "</tr>";
        }
    }
    ?>
</body>

</html>
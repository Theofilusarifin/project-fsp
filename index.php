<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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
    <form action="" method="post">
        <label>Mahasiswa : </label>
        <select id="nama" name="selector_nama">
            <option value="" selected>-- Pilih Mahasiswa --</option>
            <?php
            require("class/mahasiswa.php");
            //ciptain object mahasiswa, panggil class Mahasiswa
            $mahasiswa = new Mahasiswa("localhost", "root", "", "project_uts");

            //panggil method ShowMahasiswa
            $result = $mahasiswa->ShowMahasiswa();

            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['nrp'] . "'>" . $row['nama'] . "</option>";
            }
            ?>
        </select>
        <input type="submit" value="Pilih" name="id">
    </form>
    <br>
    <table>
        <?php
        require("class/hari.php");
        //ciptain object hari, panggil class hari
        $hari = new Hari("localhost", "root", "", "project_uts");

        //panggil method ShowHari
        $result1 = $hari->ShowHari();
        echo "<tr>";
        echo "<td>";
        echo "</td>";

        //nampilin harinya dalam satu baris
        while ($row = $result1->fetch_assoc()) {
            echo "<td>";
            echo $row['nama'];
            echo "</td>";
        }
        echo "</tr>";

        require("class/jam_kuliah.php");
        //ciptain object jam_kuliah, panggil class Jam_Kuliah
        $jam_kuliah = new Jam_Kuliah("localhost", "root", "", "project_uts");
        //panggil method ShowJamKuliah
        $result2 = $jam_kuliah->ShowJamKuliah();

        //nampilin jam kuliahnya, kalo kurang rapi mohon maap, bisa dibantu rapihin yak
        while ($row = $result2->fetch_assoc()) {
            echo "<tr";
            echo "<td>";
            echo "</td>";
            echo "<td>";
            echo date('H:i', strtotime($row['jam_mulai'])) . " - " . date('H:i', strtotime($row['jam_selesai']));
            echo "</td>";
            for ($i = 0; $i < mysqli_num_rows($result1); $i++) {
                echo "<td>";
                echo "</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>

    <br>
    <form action="ubah-jadwal.php" method="get" id="form-ubah">
        <input type="hidden" name="nrp" value="">
        <button id="btn_ubah">Ubah Jadwal</button>
    </form>

    <script>
        $("#btn_ubah").on("click", function() {
            $("input[name='nrp']").attr("value", $('select[name=selector_nama] option').filter(':selected').val());
            $("form-ubah").submit();
        });
    </script>
</body>

</html>
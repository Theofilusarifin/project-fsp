<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        table, td, th {
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
    <table>
        <?php
            require("class/jadwal.php");
            //ciptain object jadwal, panggil class jadwal
            $jadwal = new Jadwal("localhost", "root", "", "project_uts");

            //panggil method ShowHari
            $hari = $jadwal->ShowHari();
            echo "<tr>";
            echo "<td>";
            echo "</td>";

            //nampilin harinya dalam satu baris
            while ($row = $hari->fetch_assoc()) 
            {
                echo "<td>";
                echo $row['nama'];
                echo "</td>";
            }
            echo "</tr>";

            //panggil method ShowJamKuliah
            $jam = $jadwal->ShowJamKuliah();

            //nampilin jam kuliahnya, kalo kurang rapi mohon maap, bisa dibantu rapihin yak
            while ($row = $jam->fetch_assoc()) 
            {
                echo "<tr";
                echo "<td>";
                echo "</td>";
                echo "<td>";
                echo date('H:i', strtotime($row['jam_mulai']))." - ".date('H:i', strtotime($row['jam_selesai']));
                echo "</td>";
                echo "</tr>";
            }
        ?>
    </table>
</body>

</html>
<?php
require_once("koneksi.php");
    class Jam_Kuliah extends Koneksi 
    {
        public function __construct($server, $user, $pass, $db)
        {
            parent::__construct($server, $user, $pass, $db);
        }

        //nampilin semua jam kuliah (awal dan akhir)
        public function ShowJamKuliah() 
        {
            $sql = "SELECT * FROM jam_kuliah";
            $res = $this->con->query($sql);
            return $res;
        }
    }
?>
<?php
require_once("koneksi.php");
    class Mahasiswa extends Koneksi 
    {
        public function __construct($server, $user, $pass, $db)
        {
            parent::__construct($server, $user, $pass, $db);
        }

        //nampilin mahasiswa
        public function ShowMahasiswa() 
        {
            $sql = "SELECT * FROM mahasiswa";
            $res = $this->con->query($sql);
            return $res;
        }
    }
?>
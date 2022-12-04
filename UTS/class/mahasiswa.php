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

        public function SearchMahasiswa($nrp) 
        {
            $sql = "SELECT * FROM mahasiswa WHERE nrp = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param('s', $nrp);
            $stmt->execute();
            $res = $stmt->get_result();
            return $res;
        }
    }
?>
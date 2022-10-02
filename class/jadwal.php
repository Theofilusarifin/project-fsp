<?php
require_once("koneksi.php");
    class Jadwal extends Koneksi 
    {
        public function __construct($server, $user, $pass, $db)
        {
            parent::__construct($server, $user, $pass, $db);
        }

        public function SearchJadwal($nrp) 
        {
            $sql = "SELECT * FROM jadwal WHERE nrp = ? ORDER BY idjam_kuliah, idhari";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param('s', $nrp);
            $stmt->execute();
            $res = $stmt->get_result();
            return $res;
        }

        public function DeleteJadwal($nrp)
        {
            $sql = "DELETE FROM jadwal where nrp = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param('i', $nrp);
            $stmt->execute();
        }

        public function InsertJadwal($nrp, $idjam_kuliah, $idhari)
        {
            $sql = "INSERT INTO jadwal (nrp, idhari, idjam_kuliah) VALUES (?,?,?)";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param('iii',$nrp, $idjam_kuliah, $idhari);
            $stmt->execute();
        }
    }
?>
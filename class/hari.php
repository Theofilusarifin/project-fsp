<?php
require_once("koneksi.php");
    class Hari extends Koneksi 
    {
        public function __construct($server, $user, $pass, $db)
        {
            parent::__construct($server, $user, $pass, $db);
        }

        //nampilin hari (senin-jumat)
        public function ShowHari() 
        {
            $sql = "SELECT * FROM hari";
            $res = $this->con->query($sql);
            return $res;
        }
    }
?>
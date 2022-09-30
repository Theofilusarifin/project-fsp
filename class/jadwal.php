<?php
require_once("koneksi.php");
    class Jadwal extends Koneksi 
    {
        public function __construct($server, $user, $pass, $db)
        {
            parent::__construct($server, $user, $pass, $db);
        }
    }
?>
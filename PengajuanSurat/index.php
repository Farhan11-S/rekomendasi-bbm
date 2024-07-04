<?php

try {
    $con = new PDO('mysql:host=localhost;port=3306;dbname=joki_rekomendasi-bbm', 'root', '', array(PDO::ATTR_PERSISTENT => true));
} catch (PDOException $e) {
    echo $e->getMessage();
}

include_once 'PengajuanSurat.php';

$pengajuanSurat = new PengajuanSurat($con);
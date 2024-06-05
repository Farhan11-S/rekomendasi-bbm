<?php

try {
    $con = new PDO('mysql:host=127.0.0.1;port=3306;dbname=rekomendasi-bbm', 'root', 'lalala', array(PDO::ATTR_PERSISTENT => true));
} catch (PDOException $e) {
    echo $e->getMessage();
}

include_once 'PerpanjanganSurat.php';

$perpanjanganSurat = new PerpanjanganSurat($con);

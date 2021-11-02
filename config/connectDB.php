<?php
/*
========================
== Connect DATABASE   ==
========================
*/

$dsn      = 'mysql:host=localhost;dbname=manadeeb';
$username = 'root';
$pass     = '';
$options  = array(
         PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try {
    $con = new PDO($dsn, $username, $pass, $options);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch (PDOException $e) {
    echo 'Fail To Connect' . $e->getMessage(); // ERROR MODE
}

?>

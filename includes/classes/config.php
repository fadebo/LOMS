<?php
$session_handler = 'none';
	session_start();

    try{
        $con = new PDO("mysql:dbname=loms;host=localhost", "root", "");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    catch (PDOException $e) {
        exit("Connection failed: " . $e->getMessage());
    }

?>
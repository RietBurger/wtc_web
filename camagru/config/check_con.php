<?php
include "database.php";

try {
    $con = new PDO("$DB_DSN;dbname=camagru", $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>
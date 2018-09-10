<?php

include "database.php";

try {
    $con = new PDO("$DB_DSN;dbname=matcha", $DB_USER, $DB_PASSWD);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {

    echo "<script> alert('Could not connect to Database, please ensure that it is established.'); location.href='../index.php' </script>";

}

?>
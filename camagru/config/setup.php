<?php

include "database.php";

try {
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS Camagru";
    $conn->exec($sql);
    echo "DB Created successfully";
    $sql = "USE Camagru";
    $conn->exec($sql);
    echo "Connected to Camagru db";

    $sql = "CREATE TABLE IF NOT EXISTS Users (
    id INT(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
    first_name VARCHAR (255),
    notifications VARCHAR (10),
    uid VARCHAR (255),
    token VARCHAR (255),
    email VARCHAR (255),
    passwd VARCHAR (1000)
    )";
    $conn->exec($sql);
    echo "Users created successfully";

    $sql = "CREATE TABLE IF NOT EXISTS Images (
    id INT(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
    img_name VARCHAR (255),
    image longblob NOT NULL,
    uid VARCHAR (255),
    published DATETIME DEFAULT CURRENT_TIMESTAMP,
    like_count int(100) DEFAULT 0,
    like_uid VARCHAR (255),
    comments VARCHAR (255)
    )";
    $conn->exec($sql);
    echo "Images created successfully";

}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}

?>

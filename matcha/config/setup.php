<?php

include "database.php";

try {
    $con = new PDO($DB_DSN, $DB_USER, $DB_PASSWD);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = "CREATE DATABASE IF NOT EXISTS Matcha";
    $con->exec($stmt);
    echo "DB named Matcha created successfully. ";

    $stmt = "USE Matcha";
    $con->exec($stmt);
    echo "Connected to Matcha. ";

    $stmt = "CREATE TABLE IF NOT EXISTS Users (
    uid INT(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
    first_name VARCHAR (255) NOT NULL ,
    last_name VARCHAR (255) NOT NULL ,
    user_name VARCHAR (255) NOT NULL , 
    email VARCHAR (255) NOT NULL ,
    token VARCHAR (255) NOT NULL ,
    passwd VARCHAR (1000) NOT NULL
)";
    $con->exec($stmt);
    echo "Users created successfully. ";

    $stmt = "CREATE TABLE IF NOT EXISTS Profile (
    uid INT (100) UNSIGNED NOT NULL ,
    user_name VARCHAR (255) NOT NULL ,
    gender VARCHAR (10) NOT NULL ,
    sexual_pref VARCHAR (20) NOT NULL ,
    biography VARCHAR (600) NOT NULL ,
    fame_rate INT (10) UNSIGNED NOT NULL ,
    age INT (10) UNSIGNED DEFAULT '0',
    flag VARCHAR (15) DEFAULT 'no flag' ,
    distance INT (30) DEFAULT '0' ,
    tag1 VARCHAR (30) NOT NULL ,
    tag2 VARCHAR (30) NOT NULL ,
    tag3 VARCHAR (30) NOT NULL ,
    tag4 VARCHAR (30) NOT NULL ,
    tag5 VARCHAR (30) NOT NULL ,
    profile_pic VARCHAR (255) NOT NULL ,
    img1 VARCHAR (255) NOT NULL ,
    img2 VARCHAR (255) NOT NULL ,
    img3 VARCHAR (255) NOT NULL ,
    img4 VARCHAR (255) NOT NULL ,
    matched INT (10) UNSIGNED DEFAULT '0' ,
    tagged INT (10) UNSIGNED DEFAULT '0' ,
    age_gap INT (10) UNSIGNED DEFAULT '0' ,
    fame_gap INT (10) UNSIGNED DEFAULT '0' ,
    area VARCHAR (255) NOT NULL ,
    last_seen VARCHAR (50) NOT NULL 
)";
    $con->exec($stmt);
    echo "Profile created successfully. ";

    $stmt = "CREATE TABLE IF NOT EXISTS Liked (
    uid INT (100) UNSIGNED NOT NULL ,
    looked INT (100) UNSIGNED NOT NULL ,
    liked INT (100) UNSIGNED NOT NULL ,
    unliked INT (100) UNSIGNED NOT NULL DEFAULT '0',
    blocked INT (100) UNSIGNED NOT NULL DEFAULT '0',
    connected INT (100) UNSIGNED NOT NULL DEFAULT '0'
)";
    $con->exec($stmt);
    echo "Like created successfully. ";

    $stmt = "CREATE TABLE IF NOT EXISTS Chat (
    msage_id INT (100) AUTO_INCREMENT PRIMARY KEY ,
    cid INT (100) UNSIGNED NOT NULL ,
    from_user INT (100) UNSIGNED NOT NULL ,
    to_user INT (100) UNSIGNED NOT NULL ,
    message VARCHAR (1000) NOT NULL ,
    time_sent DATETIME DEFAULT CURRENT_TIMESTAMP 
)";
    $con->exec($stmt);
    echo "Chat created successfully. ";

    $stmt = "CREATE TABLE IF NOT EXISTS Connected (
    cid INT (100) UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
    uid1 INT (100) UNSIGNED NOT NULL DEFAULT '0',
    uid2 INT (100) UNSIGNED NOT NULL DEFAULT '0'
)";
    $con->exec($stmt);
    echo "Connected created successfully. ";

    $stmt = "CREATE TABLE IF NOT EXISTS Tags (
    id INT (5) UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
    tag VARCHAR (100) NOT NULL ,
    weight INT (5) DEFAULT 1
)";
    $con->exec($stmt);
    echo "Tags created successfully. ";

    $stmt = "CREATE TABLE IF NOT EXISTS Location (
    uid INT (100) UNSIGNED NOT NULL ,
    area VARCHAR (100) NOT NULL ,
    lattitude FLOAT (10, 6) NOT NULL ,
    longitude FLOAT (10, 6) NOT NULL 
)";
    $con->exec($stmt);
    echo "Location created successfully.";

    $stmt = "CREATE TABLE IF NOT EXISTS notifications (
    id INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    uid INT (11) UNSIGNED NOT NULL ,
    subject VARCHAR (30) NOT NULL ,
    note VARCHAR (100) NOT NULL ,
    status INT (5) DEFAULT '0'
)";

    $con->exec($stmt);
    echo "Notifications created successfully.";

    $stmt = $con->prepare("SELECT * FROM tags WHERE tag= '#SaRcAsM'");
    $stmt->execute();
    $result = $stmt->fetchAll();
    if (!$result) {


        $con->exec("INSERT INTO tags (tag) VALUES ('')");
        $con->exec("INSERT INTO tags (tag) VALUES ('#Do_the_right_thing')");
        $con->exec("INSERT INTO tags (tag) VALUES ('#There_is_wrong_and_right')");
        $con->exec("INSERT INTO tags (tag) VALUES ('#Why_is_it..?')");
        $con->exec("INSERT INTO tags (tag) VALUES ('#Screw_it_lets_do_it')");
        $con->exec("INSERT INTO tags (tag) VALUES ('#Rebels_rule!')");
        $con->exec("INSERT INTO tags (tag) VALUES ('#Take_what_I_want')");
        $con->exec("INSERT INTO tags (tag) VALUES ('#Know_what_to_say_and_what_not_to_say')");
        $con->exec("INSERT INTO tags (tag) VALUES ('#SaRcAsM')");
        $con->exec("INSERT INTO tags (tag) VALUES ('#Everyone_lies...')");
        $con->exec("INSERT INTO tags (tag) VALUES ('#Bat_those_lashes')");
        $con->exec("INSERT INTO tags (tag) VALUES ('#Honesty')");
        $con->exec("INSERT INTO tags (tag) VALUES ('#Anything_goes')");
        $con->exec("INSERT INTO tags (tag) VALUES ('#Like_to_whisper')");
        $con->exec("INSERT INTO tags (tag) VALUES ('#Patient')");
        $con->exec("INSERT INTO tags (tag) VALUES ('#Think_before_I_do')");
        $con->exec("INSERT INTO tags (tag) VALUES ('#What_are_rules_for?')");
        $con->exec("INSERT INTO tags (tag) VALUES ('#I_dont_hate_a_thing')");
        $con->exec("INSERT INTO tags (tag) VALUES ('#Integrity')");

        echo "Tags successfully inserted into table. ALL DONE!";
    }else
        echo "Tags already inserted into table. ALL DONE!";

}
catch (PDOException $e) {
    echo $stmt . $e->getMessage();
}

?>
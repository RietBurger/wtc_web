<?php
include "../config/check_con.php";

session_start();
if (isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];

    date_default_timezone_set('Africa/Harare');

    $online = date('Y-m-d H:i:s');
    $stmt = $con->prepare("UPDATE profile SET last_seen= :online WHERE uid= :uid");
    $stmt->execute(['online' => $online, 'uid' => $uid]);
    if ($stmt->rowCount()) {

        session_destroy();
        echo "<script> alert('You are now logged out.'); location.href='../index.php'; </script>";
    }
}
else
    echo "<script> alert('You are not logged in.'); location.href='../index.php'; </script>";



?>

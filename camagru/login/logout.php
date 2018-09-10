<?php

session_start();

if (isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];


    if (session_destroy()) {
        echo "<script> alert('$uid, you are now logged out.'); location.href='../index.php'; </script>";
    }
}
else
    echo "<script> alert('You are not logged in.'); location.href='../index.php'; </script>";

?>
<?php

session_start();

include "../config/check_con.php";
include "../functions/functions.php";

if (isset ($_SESSION['uid']) && isset($_SESSION['user'])) {
    $uid = $_SESSION['uid'];
    $user = $_SESSION['user'];
}
else
    echo "<script> alert('Please log in to access account details.'); location.href='../index.php';</script>";

if (isset($_POST['submit']) == 'OK') {
    $passwd = $_POST['passwd'];

    if (!preg_match("/(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,13}/", $passwd)) {
        echo "<script>alert('please match pattern. Click on emailed link again'); location.href='../index.php'; </script>";
    } else {

        $encrypt_passwd = serialize(hash('whirlpool', $passwd));

        $stmt = $con->prepare("UPDATE users SET passwd = :passwd WHERE uid = :uid");
        $stmt->execute(['passwd' => $encrypt_passwd, 'uid' => $uid]);
        if ($stmt->rowCount()) {
            echo "<script> alert('$uid , Your password has been successfully reset, please log in.'); location.href='../htmls/login.php'; </script>";
        } else
            echo "<script> alert('Unable to verify user, please try again.'); location.href='index.php';</script>";
    }
}

?>
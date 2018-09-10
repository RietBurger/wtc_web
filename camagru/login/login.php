<?php
session_start();

$uid = $_POST['uid'];
$passwd = $_POST['passwd'];

include '../config/check_con.php';

if ($_POST['signin'] == "OK") {
    $passwd_encrypt = serialize(hash('whirlpool', $passwd));
    $stmt = $con->query("SELECT * FROM users WHERE uid='$uid' AND passwd='$passwd_encrypt' AND token='1'");

    if (!$row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<script> alert("Login details are incorrect."); location.href="../htmls/login.php"; </script>';
    }
    else {
        $_SESSION['uid'] = $uid;
        $email = $row['email'];
        $_SESSION['email'] = $email;

        header("Location: ../htmls/loggedin.php");

    }
}
elseif ($_POST['register'] == "OK")
    header("Location: ../htmls/register.php");
?>
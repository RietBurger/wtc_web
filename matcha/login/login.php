<?php
session_start();

$user = $_POST['user_name'];
$passwd = $_POST['passwd'];

include '../config/check_con.php';

if ($_POST['signin'] == "OK") {
    $passwd_encrypt = serialize(hash('whirlpool', $passwd));
    $stmt = $con->query("SELECT * FROM users WHERE user_name='$user' AND passwd='$passwd_encrypt' AND token='1'");

    if (!$row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<script> alert("Login details are incorrect."); location.href="../htmls/login.php"; </script>';
    }
    else {
        $uid = $row['uid'];
        $_SESSION['uid'] = $uid;
        $_SESSION['user'] = $user;

        $online = "online";
        $stmt = $con->prepare("UPDATE profile SET last_seen= :online WHERE uid= :uid");
        $stmt->execute(['online' => $online, 'uid' => $uid]);
        if ($stmt->rowCount()) {

            header("Location: ../htmls/home.php");
        }
        else
            echo "<script> alert('Unable to set last_seen'); location.href='../htmls/home.php'; </script>";
    }
}
elseif ($_POST['register'] == "OK")
    header("Location: ../index.php");
?>
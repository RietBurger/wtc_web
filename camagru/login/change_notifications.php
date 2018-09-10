<?php

session_start();

include "../config/check_con.php";

if (isset($_SESSION['uid']) && isset($_SESSION['email'])) {
    $uid = $_SESSION['uid'];
    $email = $_SESSION['email'];
}
else
    echo "<script> alert('Please log in.'); location.href='../htmls/login.php'; </script>";



if ($_POST['submit'] == "Change") {
    $answ = $_POST['notification'];

    $stmt = $con->prepare("SELECT `uid` FROM `users` WHERE `uid` = :uid AND `email` = :email");
    $stmt->execute(['uid' => $uid, 'email' => $email]);

    if ($stmt->rowCount()) {
        $stmt = $con->prepare("UPDATE users SET notifications = :answ WHERE uid = :uid AND email = :email");
        $stmt->execute(['answ' => $answ, 'uid' => $uid, 'email' => $email]);

        if ($stmt->rowCount()) {

            $subject = "Change notification preferences";
            $body = "Hi $uid! This email is just to confirm that your email notification preferences has been successfully changed to $answ.";
            mail($email, $subject, $body);
            echo "<script> alert('Your notification preferences has been successfully changed.'); location.href='../htmls/loggedin.php'; </script>";
        } else
            echo "<script> alert('This is your current notification preference. Please try again.'); location.href='../htmls/change_notifications.php'; </script>";
    } else
        echo "<script> alert('No such email or user.'); location.href='../htmls/change_notifications.php'; </script>";
}
?>
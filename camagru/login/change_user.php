<?php

session_start();

include "../config/check_con.php";

if (isset($_SESSION['uid']) && isset($_SESSION['email'])) {
    $uid = $_SESSION['uid'];
    $email = $_SESSION['email'];
}
else
    echo "<script> alert('Please log in.'); location.href='../htmls/login.php'; </script>";

$newuid = $_POST['newuid'];
$confirm = $_POST['confirm'];

if ($_POST['submit'] == "Change") {
    if ($newuid == $confirm) {
        $stmt = $con->prepare("SELECT `uid` FROM `users` WHERE `uid` = :uid AND `email` = :email");
        $stmt->execute(['uid' => $uid, 'email' => $email]);

        if ($stmt->rowCount()) {
            $stmt = $con->prepare("SELECT uid FROM users WHERE uid = :newuid");
            $stmt->execute(['newuid' => $newuid]);
            if ($stmt->rowCount())
                echo "<script> alert('User name already in use. Please use another.'); location.href='../htmls/change_user.php'; </script>";
            else {

                $stmt = $con->prepare("SELECT uid FROM images WHERE uid = :newuid");
                $stmt->execute(['newuid' => $newuid]);
                if ($stmt->rowCount())
                    echo "<script> alert('User name already in use. Please use another.'); location.href='../htmls/change_user.php'; </script>";
                else {

                    $stmt = $con->prepare("UPDATE `users` SET uid = :newuid WHERE uid = :uid AND `email` = :email");
                    $stmt->execute(['newuid' => $newuid, 'uid' => $uid, 'email' => $email]);

                    if ($stmt->rowCount()) {

                        $stmt = $con->prepare("UPDATE images SET uid = :newuid WHERE uid = :uid");
                        $stmt->execute(['newuid' => $newuid, 'uid' => $uid]);
                        $_SESSION['uid'] = $newuid;
                        $subject = "User Reset";
                        $body = "Hi $newuid! This email is just to confirm that your user name has been successfully changed.";
                        mail($email, $subject, $body);
                        echo "<script> alert('Your User name has been successfully changed.'); location.href='../htmls/loggedin.php'; </script>";
                    } else
                        echo "<script> alert('Error in changing user name. Please try again.'); location.href='../htmls/change_user.php'; </script>";
                }
            }

        } else
            echo "<script> alert('Incorrect user name or email.'); location.href='../htmls/change_user.php'; </script>";
    } else
        echo "<script> alert('User name do not match.'); location.href='../htmls/change_user.php'; </script>";
}

$con = NULL;

?>
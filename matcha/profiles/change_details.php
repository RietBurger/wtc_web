<?php

session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['user'])) {
    $uid = $_SESSION['uid'];
    $user = $_SESSION['user'];
}
else
    echo "<script> alert('Please log in or register to access account details.'); location.href='../index.php' </script>";

if (isset($_POST['submit'])) {
    include "../functions/functions.php";
    include "../config/check_con.php";

    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $users = $_POST['user_name'];
    $email = $_POST['email'];
    $passwd = $_POST['passwd'];

    if (!preg_match("/(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,13}/",$passwd)) {
        echo "<script>alert('please match pattern.'); location.href='../htmls/change_details.php'; </script>";
    } else {
        $encrypt_passwd = serialize(hash('whirlpool', $passwd));
    }

    $stmt = $con->prepare("SELECT uid FROM users WHERE uid = :uid");
    $stmt->execute(['uid' => $uid]);
    if (!$stmt->rowCount()) {
        echo "<script> alert('User no longer exists, please register.'); location.href='../index.php' </script>";
    } else {

        if (strcmp($first, "") != 0) {

            $stmt = $con->prepare("UPDATE `users` SET `first_name`= :first_name WHERE `uid` = :uid");
            $stmt->execute(['first_name' => $first, 'uid' => $uid]);
            if ($stmt->rowCount()) {
                echo "<script> alert('Your First name has been successfully updated.'); location.href='../htmls/home.php'; </script>";
            } else
                echo "<script> alert('Unable to insert into DB.'); location.href='../htmls/change_details.php';</script>";
        }
        if (strcmp($last, "") != 0) {
            $stmt = $con->prepare("UPDATE `users` SET `last_name`= :last_name WHERE `uid` = :uid");
            $stmt->execute(['last_name' => $last, 'uid' => $uid]);
            if ($stmt->rowCount()) {
                echo "<script> alert('Your Last name has been successfully updated.'); location.href='../htmls/home.php'; </script>";
            } else
                echo "<script> alert('Unable to insert into DB.'); location.href='../htmls/change_details.php';</script>";
        }
        if (strcmp($users, "") != 0) {

            $stmt = $con->prepare("SELECT user_name FROM users WHERE user_name = :users");
            $stmt->execute(['users' => $users]);
            if ($stmt->rowCount()) {
                echo "<script> alert('User already exists, please choose a different user name.'); location.href='../htmls/change_details.php' </script>";
            } else {
                $stmt = $con->prepare("SELECT user_name FROM profile WHERE user_name = :users");
                $stmt->execute(['users' => $users]);
                if ($stmt->rowCount()) {
                    echo "<script> alert('User already exists, please choose a different user name.'); location.href='../htmls/change_details.php' </script>";
                } else {
                    $stmt = $con->prepare("UPDATE `users` SET `user_name`= :users WHERE `uid` = :uid");
                    $stmt->execute(['users' => $users, 'uid' => $uid]);
                    if ($stmt->rowCount()) {
                        $stmt = $con->prepare("UPDATE `profile` SET `user_name`= :users WHERE `uid` = :uid");
                        $stmt->execute(['users' => $users, 'uid' => $uid]);
                        if ($stmt->rowCount()) {
                            $_SESSION['user'] = $users;
                            echo "<script> alert('Your User name has been successfully updated.'); location.href='../htmls/home.php'; </script>";
                        } else
                            echo "<script> alert('Unable to insert into profile.'); location.href='../htmls/change_details.php';</script>";
                    } else
                        echo "<script> alert('Unable to insert into users.'); location.href='../htmls/change_details.php';</script>";
                }
            }
        }
        if (strcmp($email, "") != 0) {
            $stmt = $con->prepare("UPDATE `users` SET `email`= :email WHERE `uid` = :uid");
            $stmt->execute(['email' => $email, 'uid' => $uid]);
            if ($stmt->rowCount()) {
                echo "<script> alert('Your Email has been successfully updated.'); location.href='../htmls/home.php'; </script>";
            } else
                echo "<script> alert('Unable to insert into DB.'); location.href='../htmls/change_details.php';</script>";
        }
        if (strcmp($passwd, "") != 0) {
            $stmt = $con->prepare("UPDATE `users` SET `passwd`= :passwd WHERE `uid` = :uid");
            $stmt->execute(['passwd' => $encrypt_passwd, 'uid' => $uid]);
            if ($stmt->rowCount()) {
                echo "<script> alert('Your Password has been successfully updated.'); location.href='../htmls/home.php'; </script>";
            } else
                echo "<script> alert('Unable to insert into DB.'); location.href='../htmls/change_details.php';</script>";
        }
        else
            echo "<script> alert('No changes detected.'); location.href='../htmls/change_details.php' </script>";
    }
}


?>
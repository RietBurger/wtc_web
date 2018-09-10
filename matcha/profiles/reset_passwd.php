<?php

session_start();

include "../config/check_con.php";
include "../functions/functions.php";

$url = $_SESSION['url'];
$first = htmlspecialchars($_POST['first_name']);
$last = htmlspecialchars($_POST['last_name']);
$user = htmlspecialchars($_POST['user_name']);
$email = htmlspecialchars($_POST['email']);
/* Load the stuff into the config table */
if ($_POST['register'] == "OK") {
    /* Only insert staff if fields are not left blank */
    /* This is to prevent creating empty rows */
    if ($first && $last && $user && $email) {
        $token = substr(md5(mt_rand()), 0, 15); //creating token
        /* Encrypt the passwd before storing it */
        $passwd_encrypt = serialize(hash('whirlpool', $token));

        $stmt = $con->prepare("SELECT user_name FROM `users` WHERE `user_name` = :user_name");
        $stmt->execute(['user_name' => $user]);
        if (!$stmt->rowCount())
            echo "<script> alert('Username does not exist. Please register.'); location.href='../index.php'; </script>";
        else {
                $stmt = $con->prepare("UPDATE users SET passwd = :passwd WHERE user_name = :users");
                $result = $stmt->execute(['passwd' => $passwd_encrypt, 'users' => $user]);
                if ($result) {
                    ft_mail($user, $email, $url, $token);
                    echo "<script> alert('Dear $user, your password has been reset and an email sent to you. Please click on link to create new password'); location.href='../index.php'</script>";
                }
                else
                    echo "<script> alert('Could not register, please try again'); location.href='../index.php'</script>";
            }
    }
    else {
        /* jump to back registration page */
        header("Location: ../index.php");
        echo "please complete all the fields";
    }
}
else /* Go to the sign in page if the signin button is pressed */
    header("Location: user_login.php");
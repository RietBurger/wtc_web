<?php

session_start();

include "../config/check_con.php";
include "../functions/functions.php";

$url = $_SESSION['url'];
$first = htmlspecialchars($_POST['first_name']);
$last = htmlspecialchars($_POST['last_name']);
$user = htmlspecialchars($_POST['user_name']);
$email = htmlspecialchars($_POST['email']);
$passwd = $_POST['passwd'];
/* Load the stuff into the config table */
if ($_POST['register'] == "OK") {

    if (!preg_match("/(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,13}/",$passwd)) {
        echo "<script>alert('please match pattern.'); location.href='../index.php'; </script>";
    } else {
        /* Only insert staff if fields are not left blank */
        /* This is to prevent creating empty rows */
        if ($first && $last && $user && $passwd) {
            $token = substr(md5(mt_rand()), 0, 15); //creating token
            /* Encrypt the passwd before storing it */
            $passwd_encrypt = serialize(hash('whirlpool', $passwd));

            $stmt = $con->prepare("SELECT user_name FROM `users` WHERE `user_name` = :user_name");
            $stmt->execute(['user_name' => $user]);
            if ($stmt->rowCount())
                echo "<script> alert('Username already in use. Please use another.'); location.href='../index.php'; </script>";
            else {

                $stmt = $con->prepare("SELECT user_name FROM profile WHERE user_name = :users");
                $stmt->execute(['users' => $user]);
                if ($stmt->rowCount())
                    echo "<script> alert('Username already in use. Please use another.'); location.href='../index.php'; </script>";
                else {

                    $stmt = $con->prepare("INSERT INTO users (first_name, last_name, user_name, token, email, passwd) 
                VALUES ('$first', '$last', '$user', '$token', '$email', '$passwd_encrypt')");
                    $result = $stmt->execute();
                    if ($result) {
                        ft_mail($user, $email, $url, $token);
                        echo "<script> alert('Dear $user, you have been registered.'); location.href='../index.php'</script>";

                    } else
                        echo "<script> alert('Could not register, please try again'); location.href='../index.php'</script>";
                }
            }
        } else {
            /* jump to back registration page */
            header("Location: ../index.php");
            echo "please complete all the fields";
        }
    }

}
else /* Go to the sign in page if the signin button is pressed */
    header("Location: user_login.php");
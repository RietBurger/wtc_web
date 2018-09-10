<?php

session_start();

include "../config/check_con.php";

if (isset($_SESSION['uid']))
    $uid = $_SESSION['uid'];
else
    echo "<script> alert('Please log in.'); location.href='../htmls/login.php'; </script>";

if (isset($_SESSION['email']))
    $email = $_SESSION['email'];
else
    echo "<script> alert('Please log in.'); location.href='../htmls/login.php'; </script>";

$newem = $_POST['newem'];
$confirm = $_POST['confirm'];

if ($_POST['submit'] == "Change")
{
    if ($newem == $confirm)
    {
        $stmt = $con->prepare("SELECT `uid` FROM `users` WHERE `uid` = :uid AND `email` = :email");
        $stmt->execute(['uid' => $uid, 'email' => $email]);

        if ($stmt->rowCount())
        {
            $stmt = $con->prepare("SELECT `email` FROM `users` WHERE `email` = :email");
            $stmt->execute(['email' => $newem]);
            if ($stmt->rowCount())
                echo "<script> alert('Email address already in use. Please use another.'); location.href='../htmls/change_email.php'; </script>";
            else
            {
                $sql = "UPDATE `users` SET email = '$newem' WHERE uid = '$uid' AND `email` = '$email'";
                $result = $con->query($sql);

                if ($result)
                {
                    $_SESSION['email'] = $newem;
                    $subject = "Email Reset";
                    $body = "Hi $uid! This email is just to confirm that your email address has been successfully changed to $newem.";
                    mail($newem, $subject, $body);
                    echo "<script> alert('Your email address has been sucessfully changed.'); location.href='../htmls/loggedin.php'; </script>";
                }
                else
                    echo "<script> alert('Error in changing email. Please try again.'); location.href='../htmls/change_email.php'; </script>";
            }

        }
        else
            echo "<script> alert('Incorrect email.'); location.href='../htmls/change_email.php'; </script>";
    }
    else
        echo "<script> alert('Emails do not match.'); location.href='../htmls/change_email.php'; </script>";
}

$con = NULL;

?>
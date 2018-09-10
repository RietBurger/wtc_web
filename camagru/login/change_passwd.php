<?php

session_start();

include "../config/check_con.php";

if (isset($_SESSION['uid']) && isset($_SESSION['email']))
{
    $uid = $_SESSION['uid'];
    $email = $_SESSION['email'];
}
else
    echo "<script> alert('Please log in.'); location.href='../htmls/login.php'; </script>";

$newpasswd = $_POST['newpasswd'];

$confirm = $_POST['confirm'];

if ($_POST['submit'] == "Change")
{
    if ($newpasswd == $confirm)
    {
        $encrypt_passwd = serialize(hash('whirlpool', $newpasswd));

        $stmt = $con->prepare("SELECT `uid` FROM `users` WHERE `uid` = :uid AND `email` = :email");
        $stmt->execute(['uid' => $uid, 'email' => $email]);

        if ($stmt->rowCount())
        {
                $sql = "UPDATE `users` SET passwd = '$encrypt_passwd' WHERE uid = '$uid' AND `email` = '$email'";
                $result = $con->query($sql);

                if ($result)
                {
                    $_SESSION['email'] = $email;
                    $subject = "Password Reset";
                    $body = "Hi $uid! This email is just to confirm that your password has been successfully changed.";
                    mail($email, $subject, $body);
                    echo "<script> alert('Your password has been sucessfully changed.'); location.href='../htmls/loggedin.php'; </script>";
                }
                else
                    echo "<script> alert('Error in changing password. Please try again.'); location.href='../htmls/change_passwd.php'; </script>";
            }
    }
    else
        echo "<script> alert('Passwords do not match.'); location.href='../htmls/change_passwd.php'; </script>";
}

$con = NULL;

?>
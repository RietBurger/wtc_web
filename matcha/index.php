<?php

include "functions/functions.php";
session_start();

ft_set_url_session();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php ft_head(); ?>
</head>
<body>
<div class="container">

    <nav class="navbar navbar-inverse">
        <div class="page-header" style="text-align: center; font-family: \'Apple Chancery\';">
            <h1 style="font-size: 50px; color: greenyellow">Someone Like Me</h1>
        </div>
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">REGISTER</a>
            </div>

            <ul class="nav navbar-nav navbar-inverse">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown"><span class="label label-pill label-danger count"
                                                             style="border-radius: 10px"></span> <span class="glyphicon glyphicon-bell" style="font-size: 18px;" ></span> </a>
                    <ul></ul>
                </li>
            </ul>
            <div class="menu">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="htmls/login.php" id="home">Login</a> </li>
                    <li><a href="htmls/reset_passwd.php" id="home">Forgot Password</a> </li>
                </ul>
            </div>
        </div>
    </nav>

<br><br>
    <?php
        if (isset($_GET['token']) && isset($_GET['email'])) {
            include "config/check_con.php";

            $email = $_GET['email'];
            $token = $_GET['token'];
            $stmt = $con->query("SELECT * FROM users WHERE email='$email' AND token='$token'");

            if (!$row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<script> alert("details are incorrect."); location.href="index.php"; </script>';
            } else {
                $uid = $row['uid'];
                $user = $row['user_name'];
                $_SESSION['temp_uid'] = $uid;
                $_SESSION['temp_user'] = $user;
                $stmt = $con->prepare("UPDATE users SET token = 1 WHERE email = :email AND token = :token");
                $stmt->execute(['email' => $email, 'token' => $token]);
                if ($stmt->rowCount()) {
                    echo "<script> alert('$uid , You have been successfully verified. Please complete your profile.'); location.href='htmls/my_profile.php'; </script>";
                } else
                    echo "<script> alert('Unable to verify user, please try again.'); location.href='index.php';</script>";
            }
        }
        else {
                echo '<div class="input-group">
    <form action="login/register.php" method="post">
            <label><b>First name</b></label><br>
        <input type="text" placeholder="Enter First Name" name="first_name" required="required" pattern="(?=.*[a-z])(?=.*[A-Z]).{3,20}" title="Must contain at least one uppercase and one lowercase letter. Only 3 to 20 characters long">
        <br>
        <label><b>Last name</b></label><br>
        <input type="text" placeholder="Enter Last Name" name="last_name" required="required" pattern="(?=.*[a-z])(?=.*[A-Z]).{3,20}" title="Must contain at least one uppercase and one lowercase letter. Only 3 to 20 characters long">
        <br>
        <label><b>User name</b></label><br>
        <input type="text" placeholder="User Name" name="user_name" required="required" pattern="(?=.*[a-z])(?=.*[A-Z]).{3,20}" title="Must contain at least one uppercase and one lowercase letter. Only 3 to 20 characters long">
        <br>
        <label><b>Email address</b></label><br>
        <input type="email" placeholder="Enter email address" name="email" required="required">
        <br>
        <label><b>Password</b></label><br>
        <input type="password" placeholder="Enter Password" name="passwd" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,13}" title="Must contain at least one number and one uppercase and lowercase letter, and between 8 and 13 characters" maxlength="13">
        <br><br>
       <div class="clearfix">
            <button type="submit" class="btn btn-default" name="register" value="OK" style="width: 80%">Register</button>
        </div>
    </form>
    </div>';
        }
            ?>

    <div class="footer">
        <h2>&copy; 2017 by rburger </h2>
    </div>
</div>


</body>
</html>

<?php
session_start();
include "../functions/functions.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php ft_head();?>
</head>
<body>
<div class="container">

    <nav class="navbar navbar-inverse">
        <div class="page-header" style="text-align: center; font-family: \'Apple Chancery\';">
            <h1 style="font-size: 50px; color: greenyellow">Someone Like Me</h1>
        </div>
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">LOGIN</a>
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
                    <li><a href="../index.php" id="home">Register</a> </li>
                    <li><a href="reset_passwd.php" id="home">Forgot Password</a> </li>
                </ul>
            </div>
        </div>
    </nav>

        <form action="../login/login.php" method="POST">
            <div class="form_inside">
                <label><b>Username</b></label><br>
                <input type="text" placeholder="Enter Username" name="user_name" maxlength="20" title="Maximum 20 characters">
                <br>
                <label><b>Password</b></label><br>
                <input type="password" placeholder="Enter Password" name="passwd" maxlength="13" title="Maximum 13 characters">

                <div class="clearfix">
                    <button type="submit" class="btn default-btn" name = "signin" value="OK">Sign In</button>
                    <a href=""><button  type="submit" class="btn default-btn" name = "register" value="OK">Register</button></a>

                </div>
            </div>
        </form>
    <div class="footer">
        <h2>&copy; 2017 by rburger </h2>
    </div>

    </div>

</body>
</html>
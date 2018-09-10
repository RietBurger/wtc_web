<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title> Login </title>
    <link href = "../css/loginstyles.css" type = "text/css" rel = "stylesheet">
    <link rel='stylesheet' media='screen and (max-width: 700px)' href='../css/mobile.css' type="text/css" />
</head>

<body>
<div class="main">
    <div class="header">
        <h1>CAMA-ra-G-u-RU</h1>
    </div>

<div class="container">
    <h2>User Login</h2>
    <li ><a href="../index.php" id="home">Home</a></li>
    <li><a href="../htmls/request_new_pw.php" id="home">Forgot Password?</a></li>
    <form action="../login/login.php" method="POST">
        <div class="form_inside">
            <label><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uid" maxlength="8" title="Maximum 8 characters">

            <label><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="passwd" maxlength="13" title="Maximum 13 characters">

            <div class="clearfix">
                <button type="submit" class="signupbtn" name = "signin" value="OK">Sign In</button>
                <a href=""><button  type="submit" class="registerbtn" name = "register" value="OK">Register</button></a>

            </div>
        </div>
    </form>
</div>
</div>

<div class="footer">
    <h2>&copy; 2017 by rburger </h2>
</div>

</body>
</html>

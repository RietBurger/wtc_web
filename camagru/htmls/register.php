<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title> Register</title>
    <!-- Styling -->
    <link href = "../css/loginstyles.css" type = "text/css" rel = "stylesheet">
    <link rel='stylesheet' media='screen and (max-width: 700px)' href='../css/mobile.css' type="text/css" />
</head>

<body>

<div class="main">
    <div class="header">
        <h1>CAMA-ra-G-u-RU</h1>
    </div>

<div class="container">
    <h2>User Registration</h2>
    <li><a href="../index.php" id="home">Home</a></li>

    <form action="../login/register.php" method="POST">
        <div class="form_inside">
            <label><b>First Name</b></label>
            <input type="text" placeholder="Enter First Name" name="first_name" required="required" maxlength="8" title="Up to 8 characters only">
            <br><br>
            <label><b>Email notifications?</b></label>
            <input type="radio" name="notifications" value="yes" required="required">Yes
            <input type="radio" name="notifications" value="no" required="required">No
            <br><br>
            <label><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uid" required="required" maxlength="8" title="Up to 8 characters only">
            <label><b>E-mail</b></label>
            <input type="email" placeholder="Enter E-mail" name="email" required="required">
            <label><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="passwd" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,13}" title="Must contain at least one number and one uppercase and lowercase letter, and between 8 and 13 characters" maxlength="13">
            <div class="clearfix">
                <button type="submit" class="registerbtn" name = "register" value="OK" style="width:100%">Register</button>
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
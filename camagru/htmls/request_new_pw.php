<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../css/loginstyles.css" madia="all">
    <link rel='stylesheet' media='screen and (max-width: 700px)' href='../css/mobile.css' type="text/css" />
</head>
<body>
<div class="main">
    <div class="header">
        <h1>CAMA-ra-G-u-RU</h1>
    </div
<div class="container">
    <h2>Request new Password</h2>
    <li><a href="../index.php" id="home">Home</a></li>

    <div class="form_inside">
        <form action="../login/request_new_pw.php" method="post">
            Enter Username<input type="text" name="uid" required="required" placeholder="Current Password" maxlength="8" title="Up to 8 characters only">
            Enter Email<input type="email" name="email" required="required" placeholder="Email Address">
            <input type="submit" value="Request Password" name="submit">
        </form>
    </div>
</div>
</div>

<div class="footer">
    <h2>&copy; 2017 by rburger </h2>
</div>
</body>
</html>
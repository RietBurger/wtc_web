<?php

include "../functions/functions.php";
session_start();

$url = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$url_enc = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');

$_SESSION['url'] = $url_enc;

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
                <a class="navbar-brand" href="#">RESET PASSWORD </a>
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
                    <li><a href="../index.php">Register</a> </li>
                    <li><a href="login.php">Login</a> </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<div class="container">

    <div class="box">
<?php
if (isset($_GET['token']) && isset($_GET['email'])) {
    include "../config/check_con.php";

    $email = $_GET['email'];
    $token = $_GET['token'];
    $passwd = serialize(hash('whirlpool', $token));
    $stmt = $con->query("SELECT * FROM users WHERE email='$email' AND passwd='$passwd'");

    if (!$row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<script> alert("details are incorrect."); location.href="../index.php"; </script>';
    } else {

        echo ' <div class="container">
 <div class="input-group">
  <form method="post" enctype="multipart/form-data" action="../profiles/save_passwd.php" class="form-inline">
            <label><b>New password</b></label><br>
            <input type="password" placeholder="Enter new password" name="passwd" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,13}" title="Must contain at least one number and one uppercase and lowercase letter, and between 8 and 13 characters" maxlength="13">
            <br><br>
            <div class="clearfix">
            <button type="submit" class="btn btn-default" name="submit" value="OK" style="width: 80%">Save Password</button>
        </div>
        </div>
        </form>
        </div>
        ';

        $uid = $row['uid'];
        $user = $row['user_name'];
        $_SESSION['uid'] = $uid;
        $_SESSION['user'] = $user;
    }
}
else {
    echo '
<div class="container">
<div class="input-group">
        <form method="post" enctype="multipart/form-data" action="../profiles/reset_passwd.php" class="form-inline">
            <label><b>First name</b></label><br>
            <input type="text"  placeholder="Enter First Name" required="required" name="first_name" pattern="(?=.*[a-z])(?=.*[A-Z]).{3,20}" title="Must contain at least one uppercase and one lowercase letter. Only 3 to 20 characters long">
            <br>
            <label><b>Last name</b></label><br>
            <input type="text" placeholder="Enter Last Name" required="required" name="last_name" pattern="(?=.*[a-z])(?=.*[A-Z]).{3,20}" title="Must contain at least one uppercase and one lowercase letter. Only 3 to 20 characters long">
            <br>
            <label><b>User name</b></label><br>
            <input type="text" placeholder="User Name" required="required" name="user_name" pattern="(?=.*[a-z])(?=.*[A-Z]).{3,20}" title="Must contain at least one uppercase and one lowercase letter. Only 3 to 20 characters long">
            <br>
            <label><b>Email address</b></label><br>
            <input type="email" required="required" placeholder="Enter email address" name="email">
            <br>
            <br>
            <div class="clearfix">
            <button type="submit" class="btn btn-default" name="register" value="OK" style="width: 80%">Reset</button>
        </div>
        </div>
        
        </form>
    </div>';
}
    ?>
    </div>
<div class="container">
    <div class="footer">
        <h2>&copy; 2017 by rburger </h2>
    </div>
</div>

</div>
</body>
</html>
<script src="../notifications/notice.js" type="text/javascript"></script>

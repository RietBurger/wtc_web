<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title> Verify </title>
    <link href = "../css/loginstyles.css" type = "text/css" rel = "stylesheet">
    <link rel='stylesheet' media='screen and (max-width: 700px)' href='../css/mobile.css' type="text/css" />
</head>

<body>
<div class="main">
    <div class="header">
        <h1>CAMA-ra-G-u-RU</h1>
    </div

<div class="container">
    <h2>Verify User</h2>
    <li><a href="../index.php" id="home">Home</a></li>

    <?php

    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['token']) && !empty($_GET['token'])){
        // Verify data
        include "../config/check_con.php";

        $email = addslashes($_GET['email']);
        $token = addslashes($_GET['token']);
        $stmt = $con->prepare("SELECT * FROM users WHERE email = :email AND token = :token");
        $stmt->execute(['email' => $email, 'token' => $token]);
        if ($stmt->rowCount()) {

            $stmt = $con->prepare("UPDATE users SET token = 1 WHERE token = :token");
            $stmt->execute(['token' => $token]);
            if ($stmt->rowCount()) {
                echo "<script> alert('You have been successfully verified. Please log in.'); location.href='login.php';</script>";
            }
        }
        else
            echo "<script> alert('Could not verify.'); location.href='register.php' </script>";
    }
    else
        echo "<script> alert('Unable to find token or email address.'); location.href='register.php' </script>";
    ?>

</div>
</div>
<div class="footer">
    <h2>&copy; 2017 by rburger </h2>
</div>

</body>
</html>

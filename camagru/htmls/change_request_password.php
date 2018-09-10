<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="stylesheet" href="../css/loginstyles.css" madia="all">
    <link rel='stylesheet' media='screen and (max-width: 700px)' href='../css/mobile.css' type="text/css" />
</head>
<body>
<div class="main">
    <div class="header">
        <h1>CAMA-ra-G-u-RU</h1>
    </div
<div class="container">
    <h2>Change Password</h2>
    <li><a href="../index.php" id="home">Home</a></li>

    <div class="form_inside">
<?php if (isset($_GET['empw']) && isset($_GET['uid']) && isset($_GET['email'])) {

    $_SESSION['passwd'] = $_GET['empw'];
    $_SESSION['uid'] = $_GET['uid'];
    $_SESSION['email'] = $_GET['email'];

    echo '<form action="../login/change_request_password.php" method="post">
            
            Enter new password<input type="password" name="newpw" required="required" placeholder="New Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,13}" title="Must contain at least one number and one uppercase and lowercase letter, and between 8 and 13 characters" maxlength="13">
            Confirm new password<input type="password" name="confirm" required="required" placeholder="Confirm new password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,13}" title="Must contain at least one number and one uppercase and lowercase letter, and between 8 and 13 characters" maxlength="13">
            <input type="submit" value="Reset" name="submit">
        </form>';
}
else
    echo "<script> alert('Unable to find correct information.'); location.href='../index.php' </script>";
?>
    </div>
</div>
</div>
</body>
<div class="footer">
    <h2>&copy; 2017 by rburger </h2>
</div>
</html>
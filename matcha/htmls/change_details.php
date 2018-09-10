<?php

include "../functions/functions.php";

session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['user'])) {
    $uid = $_SESSION['uid'];
    $user = $_SESSION['user'];

    if (isset($_GET['nid'])) {
        $nid = $_GET['nid'];
        header("Location: stats.php");
    }
}
else
    echo "<script> alert('Please log in or register to access account details.'); location.href='login.php' </script>";

?>

<!DOCTYPE html>
<html lang="en">

<?php ft_head(); ?>

<body>

<?php ft_notification();
ft_menu(); ?>

    <div class="box">
        <form method="post" enctype="multipart/form-data" action="../profiles/change_details.php">
            <label><b>First name</b></label><br>
            <input type="text" placeholder="Enter First Name" name="first_name" pattern="(?=.*[a-z])(?=.*[A-Z]).{3,20}" title="Must contain at least one uppercase and one lowercase letter. Only 3 to 20 characters long">
            <br>
            <label><b>Last name</b></label><br>
            <input type="text" placeholder="Enter Last Name" name="last_name" pattern="(?=.*[a-z])(?=.*[A-Z]).{3,20}" title="Must contain at least one uppercase and one lowercase letter. Only 3 to 20 characters long">
            <br>
            <label><b>User name</b></label><br>
            <input type="text" placeholder="User Name" name="user_name" pattern="(?=.*[a-z])(?=.*[A-Z]).{3,20}" title="Must contain at least one uppercase and one lowercase letter. Only 3 to 20 characters long">
            <br>
            <label><b>Email address</b></label><br>
            <input type="email" placeholder="Enter email address" name="email">
            <br>
            <label><b>Password</b></label><br>
            <input type="password" placeholder="Enter Password" name="passwd" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,13}" title="Must contain at least one number and one uppercase and lowercase letter, and between 8 and 13 characters" maxlength="13">
            <br>
            <input type="submit" name="submit" value="Submit">
        </form>


    </div>
<div class="footer">
    <h2>&copy; 2017 by rburger </h2>
</div>
</div>


</body>
</html>

<script type="text/javascript" src="../notifications/notice.js"></script>
<?php
include "../functions/functions.php";
session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['user'])) {
    $uid = $_SESSION['uid'];
    $user = $_SESSION['user'];
}
else
    echo "<script> alert('Please log in or register to access account details.'); location.href='login.php' </script>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php ft_head(); ?>
    <link rel="stylesheet" href="../css/styles.css" type="text/css" media="all"/>
</head>
<body>
<?php ft_notification();
ft_menu(); ?>

    <div class="box">
        <h1>Please select a profile image</h1>
        <form method="post" enctype="multipart/form-data" action="../profiles/images.php">
            <label><b>Profile Picture</b></label><br>
            <input type="file" name="profile_pic">
            <input type="submit" name="profile" value="Upload"><br>
        </form>
    </div>

</div>
<div class="footer">
    <h2>&copy; 2017 by rburger </h2>
</div>
</body>
</html>
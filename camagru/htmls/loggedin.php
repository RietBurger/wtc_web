<?php

session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['email'])) {
    $user = $_SESSION['uid'];
    $email = $_SESSION['email'];
}
else
    echo "<script> alert('Please login or register to access account details.'); location.href='../index.php'; </script>";

include ("../camera/functions.php");
?>

<!DOCTYPE html>
<head>
    <title>Camagru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
    <link rel='stylesheet' media='screen and (max-width: 700px)' href='../css/mobile.css' type="text/css" />
</head>

<body>
<div class="main">
    <div class="header">
        <h1>CAMA-ra-G-u-RU</h1>
        <h6 style="color:white"><?php echo "Welcome $user, with email address $email"; ?></h6>
    </div>

    <div class="menubar">
        <ul id="menu">
            <li><a href="#">Home</a></li>
            <li><a href="loggedin_gallery.php">Gallery</a></li>
            <li><a href="../login/logout.php">Logout</a></li>
            <li><a href="../htmls/change_email.php">Change email</a></li>
            <li><a href="../htmls/change_user.php">Change User name</a></li>
            <li><a href="../htmls/change_passwd.php">Change Password</a></li>
            <li><a href="../htmls/change_notifications.php">Change Notifications</a></li>
        </ul>
    </div>

    <form method="get" action="../camera/save_tmp.php" enctype="multipart/form-data">
        <div class="wrapper">

            <div class="box">

                <input type="image" value="nine.png" name="image" src="../pictures/nine.png" width="80%" height="80%" required="required"> </div>
            <div class="box">
                <input type="image" value="four.png" name="image" src="../pictures/four.png" width="80%" height="80%" required="required"></div>
            <div class="box">
                <input type="image" value="five.png" name="image" src="../pictures/five.png" width="80%" height="80%" required="required"></div>
            <div class="box">
            <input type="image" value="eleven.png" name="image" src="../pictures/eleven.png" width="80%" height="80%" required="required">
        </div>
    <div class="box">
        <input type="image" value="three.png" name="image" src="../pictures/three.png" width="80%" height="80%" required="required">
    </div>
</div>
</form>

<form id="submit-form" name="sub-form" method="post" action="../camera/save_pic.php">
    <input type="hidden" name="sub-image" id="sub-image" value""/>
    <video id="video" width="400px" height="300px" src=""></video>
    <?php if (isset($_SESSION['set'])) {
        echo '<a href="#" id="capture" class="booth-capture-button" name="sub-image">Take picture</a>';
            }
            else
                echo '<input type="submit" id="capture" class="booth-capture-button" name="sub-image" disabled="true" value="Take picture">'
            ?>
    <canvas id="canvas" width="400px" height="300px"></canvas>
    <?php if (isset($_SESSION['set'])) {
        echo '<input type="submit" name="submit" value="submit" /> <br>';
    }
    else
        echo '<input type="submit" name="submit" value="submit" disabled="true"/> <br>'
    ?>
</form>

    <form method="post" enctype="multipart/form-data" action="../camera/save_tmp2.php">
        <input type="file" name="own_image" />
        <input type="submit" name="upload" value="Upload" />
        <br>
    </form>
    <form name="all" method="post" enctype="multipart/form-data" action="../camera/save_image.php">
        <input type="text" name="img_name" value="" maxlength="8" title="Maximum 8 characters" required="required">
        <?php if ((isset($_SESSION['set']) && isset($_SESSION['set3'])) || isset($_SESSION['set2'])) {
            echo '<input type="submit" name="save-all" value="save" /> <br>';
        }
        else
            echo '<input type="submit" name="save-all" value="save" disabled="true"/> <br>'
        ?>
    </form>



    <form name="delete" action="../camera/delete.php" method="post">
        <div class="wrapper" style="float: right;">

            <?php displayimage($user); ?>
        </div>
    </form>

    <script src="../js/display_cam.js"></script>

</div>

<div class="footer">
    <h2>&copy; 2017 by rburger </h2>
</div>
</body>
</html>
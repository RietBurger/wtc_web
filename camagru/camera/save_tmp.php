<?php

session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['email'])) {
    $uid = $_SESSION['uid'];
    $email = $_SESSION['email'];
}
else
    echo " <script> alert('Please log in.'); location.href='../htmls/login.php'; </script> ";

include "../config/check_con.php";

if (isset($_GET['image']) && !empty($_GET['image'])) {

    $image1 = $_GET['image'];
    $src_dir = "../pictures/";
    $image = $src_dir . $image1;

    $name = $image1;
    $image = file_get_contents($image);
    $dest = "../temp_img/image2.png";

    if (!empty($image)) {
        move_uploaded_file($image, $dest);
        file_put_contents($dest, $image);
        $_SESSION['set'] = "true";

        echo "<script> alert('Overlay selected. Please take picture or upload own image.'); location.href='../htmls/loggedin.php'; </script>";
    }
    else
        echo "<script> alert('Unable to upload selected image.'); location.href='../htmls/loggedin.php'; </script>";
}
?>
<?php

include "functions.php";

session_start();

if (isset($_SESSION['uid']))
    $uid = $_SESSION['uid'];
else
    echo '<script> alert("Please log in 1."); location.href="../htmls/login.php"; </script>';

    if (isset($_POST['submit']) && isset($_POST['sub-image'])){
    if (empty($_POST['sub-image']))
        echo "<script> alert('Please take picture to submit.'); location.href='../htmls/loggedin.php'; </script>";
    else {
        $img = explode(',', $_POST['sub-image']);
        $data = base64_decode($img[1]);

        $img_name = "../temp_img/image1.png";
        file_put_contents($img_name, $data);
        $_SESSION['set3'] = "true";


        echo "<script> alert('Image saved. Please insert file name and click `save` to finish.'); location.href='../htmls/loggedin.php'; </script>";
    }
}
?>
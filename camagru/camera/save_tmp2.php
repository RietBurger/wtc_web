<?php

include "functions.php";

session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['email'])) {
    $uid = $_SESSION['uid'];
    $email = $_SESSION['email'];
}
else
    echo " <script> alert('Please log in.'); location.href='../htmls/login.php'; </script> ";

include "../config/check_con.php";

if (isset($_POST['upload'])) {

    if ($_FILES['own_image']['error'] !== UPLOAD_ERR_OK) {
        echo "<script> alert('Upload failed, please try again.'); location.href='../htmls/loggedin.php' </script>";
    }
    $info = getimagesize($_FILES['own_image']['tmp_name']);
    if ($info === FALSE) {
        echo "<script> alert('Unable to determine type of uploaded file'); location.href='../htmls/loggedin.php' </script>";

    }
    if ($info[2] !== IMAGETYPE_PNG) {
        echo "<script> alert('Image not a png.'); location.href='../htmls/loggedin.php' </script>";

    }

//    if ($_FILES["own_image"]["error"] == 4)


    else {
        $image = addslashes($_FILES['own_image']['tmp_name']);
        $image = file_get_contents($image);
        $dest_dir = "../temp_img/image1.png";

        file_put_contents($dest_dir, $image);
        $_SESSION['set2'] = "true";

        echo "<script> alert('Image uploaded. Please save it.'); location.href='../htmls/loggedin.php' </script>";
    }
}

?>
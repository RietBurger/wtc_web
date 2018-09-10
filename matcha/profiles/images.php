<?php
include "../functions/functions.php";
include "../config/check_con.php";

session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['user'])) {
    $uid = $_SESSION['uid'];
    $user = $_SESSION['user'];

    $stmt = $con->prepare("SELECT uid FROM profile WHERE uid = :uid");
    $stmt->execute(['uid' => $uid]);
    if (!$stmt->rowCount()) {
        echo "<script> alert('Your profile does not exist yet, please submit above information first.'); location.href='../htmls/my_profile.php' </script>";
    }
}
else
    echo "<script> alert('Please log in or register to access account details.'); location.href='../index.php' </script>";

    //PROFILE PIC
    if (isset($_POST['profile'])) {


        if ($_FILES ['profile_pic']['error'] !== UPLOAD_ERR_OK) {
            echo "<script> alert('Upload failed, please try again.'); location.href='../htmls/edit_profile.php' </script>";
        }
        $info = getimagesize($_FILES['profile_pic']['tmp_name']);
        if ($info === FALSE) {
            echo "<script> alert('Unable to determine type of uploaded file'); location.href='../htmls/edit_profile.php' </script>";
        } else {
            $img_nr = "profile_pic";
            $image = addslashes($_FILES['profile_pic']['tmp_name']);
            ft_save_img($image, $uid, $img_nr);
        }
    }

//IMG 1
    if (isset($_POST['image1'])) {
        if ($_FILES ['img1']['error'] !== UPLOAD_ERR_OK) {
            echo "<script> alert('Upload failed, please try again.'); location.href='../htmls/edit_profile.php' </script>";
        }
        $info = getimagesize($_FILES['img1']['tmp_name']);
        if ($info === FALSE) {
            echo "<script> alert('Unable to determine type of uploaded file'); location.href='../htmls/edit_profile.php' </script>";
        } else {
            $img_nr = "img1";
            $image = addslashes($_FILES['img1']['tmp_name']);
            ft_save_img($image, $uid, $img_nr);
        }
    }

// IMG 2
    if (isset($_POST['image2'])) {
        if ($_FILES ['img2']['error'] !== UPLOAD_ERR_OK) {
            echo "<script> alert('Upload failed, please try again.'); location.href='../htmls/edit_profile.php' </script>";
        }
        $info = getimagesize($_FILES['img2']['tmp_name']);
        if ($info === FALSE) {
            echo "<script> alert('Unable to determine type of uploaded file'); location.href='../htmls/edit_profile.php' </script>";
        } else {
            $img_nr = "img2";
            $image = addslashes($_FILES['img2']['tmp_name']);
            ft_save_img($image, $uid, $img_nr);
        }
    }

// IMG 3
    if (isset($_POST['image3'])) {
        if ($_FILES ['img3']['error'] !== UPLOAD_ERR_OK) {
            echo "<script> alert('Upload failed, please try again.'); location.href='../htmls/edit_profile.php' </script>";
        }
        $info = getimagesize($_FILES['img3']['tmp_name']);
        if ($info === FALSE) {
            echo "<script> alert('Unable to determine type of uploaded file'); location.href='../htmls/edit_profile.php' </script>";
        } else {
            $img_nr = "img3";
            $image = addslashes($_FILES['img3']['tmp_name']);
            ft_save_img($image, $uid, $img_nr);
        }
    }

//IMG 4
    if (isset($_POST['image4'])) {
        if ($_FILES ['img4']['error'] !== UPLOAD_ERR_OK) {
            echo "<script> alert('Upload failed, please try again.'); location.href='../htmls/edit_profile.php' </script>";
        }
        $info = getimagesize($_FILES['img4']['tmp_name']);
        if ($info === FALSE) {
            echo "<script> alert('Unable to determine type of uploaded file'); location.href='../htmls/edit_profile.php' </script>";
        } else {
            $img_nr = "img4";
            $image = addslashes($_FILES['img4']['tmp_name']);
            ft_save_img($image, $uid, $img_nr);
        }
    }


?>
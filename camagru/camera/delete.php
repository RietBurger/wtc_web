<?php
session_start();

if (isset($_SESSION['uid']))
    $uid = $_SESSION['uid'];
else
    echo "<script> alert('Please log in 1. user is $uid); location.href='../htmls/login.php' </script>";

include "../config/check_con.php";

if (isset($_POST['delete'])) {

    $id = $_POST['delete'];
    // echo "<script> alert('This is posted id/delete $id, and user $uid.'); location.href='../htmls/loggedin.php'; </script>";
    $stmt = $con->prepare("SELECT * FROM users WHERE uid = :uid");
    $stmt->execute(['uid' => $uid]);

        if ($stmt->rowCount()) {
            try {
            $stmt = $con->prepare("DELETE FROM images WHERE images.id = :id");
            $stmt->execute(['id' => $id]);
//        $stmt = $con->query("DELETE FROM `images` WHERE `images`.`img_name`= '$id'");
            if ($stmt->rowCount()) {
                echo "<script> alert('Your image with id $id has been deleted.'); location.href='../htmls/loggedin.php' </script>";
            } else
                echo "<script> alert('Unable to delete image. this is id/delete $id, and user $uid.'); location.href='../htmls/loggedin.php'; </script>";
          }
          catch (PDOException $e) {
        echo $stmt . $e->getMessage();
            }
        }
        else
    echo "<script> alert('You are not logged in, please log in.'); location.href='../htmls/login.php'</script>";

}
else
    echo "<script> alert('oops. something went wrong. This is posted id/delete $id, and user $uid.'); location.href='../htmls/loggedin.php'; </script>";


?>
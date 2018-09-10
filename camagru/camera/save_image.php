<?php

session_start();

include "functions.php";

if (isset($_SESSION['uid']) && isset($_SESSION['email'])) {
    $uid = $_SESSION['uid'];
    $email = $_SESSION['email'];
}
else
    echo '<script> alert("Please log in 1."); location.href="../htmls/login.php"; </script>';

include "../config/check_con.php";

if (isset($_POST['save-all'])) {

    $img_name = $_POST['img_name'];
    $name = $img_name . ".png";

    overlay_img($uid, $name);
}
?>
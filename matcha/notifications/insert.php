<?php
session_start();

if (isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];
}
else
    $uid = '1';

if (isset($_POST['subject'])) {

    include "../config/check_con.php";

    $subject = addslashes($_POST['subject']);
    $comment = addslashes($_POST['comment']);

    $stmt = "INSERT INTO comments (subject, text, uid) VALUES ('$subject', '$comment', '$uid')";
    $con->exec($stmt);
    if ($con->rowCount()) {
        echo "Successfully inserted into db";
        header("Location: index.php");
    }
    else
        echo "<script> alert('could not insert into db...'); location.href='../htmls/sample2.php' </script>";
}

?>
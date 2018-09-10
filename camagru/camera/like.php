<?php
session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['email'])) {
    $uid = $_SESSION['uid'];
    $email = $_SESSION['email'];
}
else
    echo "<script> alert('Please register or log in to like image'); location.href='../htmls/loggedin_gallery.php'</script> ";


if (isset($_POST['like'])) {

    include "../config/check_con.php";

    $img_id = $_POST['liked'];
    $stmt = $con->prepare("SELECT * FROM users WHERE uid=:uid");
    $stmt->execute(['uid' => $uid]);

    if ($stmt->rowCount()) {

        $stmt = $con->prepare("SELECT * FROM images WHERE like_uid = :uid && images.id = :img_id");
        $stmt->execute(['uid' => $uid, 'img_id' => $img_id]);
        if ($stmt->rowCount()) {
            echo "<script> alert('You already liked this image.'); location.href='../htmls/loggedin_gallery.php'; </script>";
        } else {

            $stmt = $con->prepare("SELECT * FROM images WHERE uid=:uid && images.id=:img_id");
            $stmt->execute(['uid' => $uid, 'img_id' => $img_id]);
            if ($stmt->rowCount()) {
                echo "<script> alert('Can not like own images.'); location.href='../htmls/loggedin_gallery.php'; </script>";
            } else {

                $stmt = $con->prepare("UPDATE images SET like_count = like_count + 1, like_uid = :uid WHERE images.id = :img_id");
                $stmt->execute(['img_id' => $img_id, 'uid' => $uid]);
                if ($stmt->rowCount()) {
                    echo "<script> alert('Like accepted. Like var is $img_id'); location.href='../htmls/loggedin_gallery.php' </script>";

                } else
                    echo "<script> alert('Could not like in db. Like var is $img_id. Uid is $uid, email is $email'); location.href='../htmls/loggedin_gallery.php' </script>";
            }
        }
    }
}

else
    echo "<script> alert('Could not find uid and email vars. Comment var is $comment. Uid is $uid, email is $email'); location.href='../htmls/loggedin_gallery.php' </script>";
?>


<?php
session_start();


if (isset($_SESSION['uid']) && isset($_SESSION['email'])) {
    $uid = $_SESSION['uid'];
    $email = $_SESSION['email'];
}
else
    echo "<script> alert('Please register or log in to like and comment.'); location.href='../htmls/loggedin_gallery.php'; </script>";

if (isset($_POST['comment'])) {

    include "../config/check_con.php";


    $comment = addslashes($_POST['comm']);
    $img_id = $_POST['img_id'];
    $creator_id = $_POST['creator'];
    $answ = "yes";

    $stmt = $con->prepare("SELECT * FROM users WHERE uid=:creator_id");
    $stmt->execute(['creator_id' => $creator_id]);

    if ($stmt->rowCount()) {

        $stmt = $con->prepare("SELECT * FROM images WHERE comments = :uid && images.id = :img_id");
        $stmt->execute(['uid' => $uid, 'img_id' => $img_id]);
        if ($stmt->rowCount()) {
            echo "<script> alert('You already commented on this image.'); location.href='../htmls/loggedin_gallery.php'; </script>";
        } else {

            $stmt = $con->prepare("SELECT * FROM images WHERE uid=:uid AND images.id=:img_id");
            $stmt->execute(['uid' => $uid, 'img_id' => $img_id]);
            if ($stmt->rowCount()) {
                echo "<script> alert('Can not comment on own images.'); location.href='../htmls/loggedin_gallery.php'; </script>";
            } else {

                $stmt = $con->prepare("SELECT * FROM users WHERE uid= :creator_id AND notifications = :answ");
                $stmt->execute(['creator_id' => $creator_id, 'answ' => $answ]);
                if ($stmt->rowCount()) {
                    $result = $stmt->fetchAll();

                    foreach ($result as $row) {
                        $send_to = $row['email'];
                    }

                    $stmt = $con->prepare("UPDATE images SET comments = :uid WHERE uid = :creator_id AND images.id = :img_id");
                    $stmt->execute(['uid' => $uid, 'creator_id' => $creator_id, 'img_id' => $img_id]);
                    if ($stmt->rowCount()) {
                        $subject = "You have a comment";
                        $body = "Hi $creator_id, $uid commented the following on your picture, id nr $img_id:' $comment '.";
                        mail($send_to, $subject, $body);
                        echo "<script> alert('Your comment has been sent to creator.'); location.href='../htmls/loggedin_gallery.php'; </script>";
                    }
                    else
                        echo "<script> alert('Something went wrong. Can not comment.'); location.href='../htmls/loggedin_gallery.php'; </script>";
                }
                else {
                    $stmt = $con->prepare("UPDATE images SET comments = :uid WHERE uid = :creator_id AND images.id = :img_id");
                    $stmt->execute(['uid' => $uid, 'creator_id' => $creator_id, 'img_id' => $img_id]);
                    if ($stmt->rowCount()) {
                        echo "<script> alert('Thank you for your comment'); location.href='../htmls/loggedin_gallery.php' </script>";
                    }
                }

            }
        }
    }
    else
        echo "<script> alert('Creator no longer exist'); location.href='../htmls/loggedin_gallery.php' </script>";
}

else
    echo "<script> alert('Could not find uid and email vars. Comment var is $comment. Uid is $uid, email is $email'); location.href='../htmls/loggedin_gallery.php' </script>";
?>

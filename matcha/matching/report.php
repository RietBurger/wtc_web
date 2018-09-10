<?php

include "../functions/functions.php";

session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['user']) && isset($_SESSION['userP'])) {
    $uid = $_SESSION['uid'];
    $user = $_SESSION['user'];
    $userP = $_SESSION['userP'];
}
else
    echo "<script> alert('Please log in to access account details.'); location.href='../htmls/login.php'; </script>";

include "../config/check_con.php";

if (isset($_POST['block'])) {

    ft_block($uid, $userP);



}

if (isset($_POST['dislike'])) {


    ft_dislike($uid, $user, $userP);

}


if (isset($_POST['report'])) {

    $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :userP");
    $stmt->execute(['userP' => $userP]);
    if ($stmt->rowCount()) {

        $flag = "Fake Account";
        $stmt = $con->prepare("UPDATE profile SET flag= :flag WHERE uid= :userP");
        $stmt->execute(['flag' => $flag, 'userP' => $userP]);
        if ($stmt->rowCount()) {

            ft_dislike($uid, $user, $userP);
            ft_block($uid, $userP);

        } else
            echo "<script> alert('Could not flag user as fake account, without having liked him.'); location.href='../htmls/browse.php'  </script>";
    } else
        echo "<script> alert('User profile does not exist.'); location.href='../htmls/browse.php'  </script>";
}

function ft_dislike($uid, $user, $userP) {

    include "../config/check_con.php";

    $stmt = $con->prepare(("SELECT * FROM liked WHERE uid= :uid AND liked= :userP"));
    $stmt->execute(['uid' => $uid, 'userP' => $userP]);
    if ($stmt->rowCount()) {

        $stmt = $con->prepare("UPDATE liked SET unliked= :userP, liked= '0' WHERE uid= :uid AND liked= :userP");
        $stmt->execute(['userP' => $userP, 'uid' => $uid]);
        if ($stmt->rowCount()) {

            $stmt = $con->prepare("SELECT * FROM connected WHERE (uid1= :userP AND uid2= :uid) OR (uid1= :uid AND uid2= :userP)");
            $stmt->execute(['userP' => $userP, 'uid' => $uid]);
            if ($stmt->rowCount()) {

                $result = $stmt->fetchAll();

                foreach ($result as $row) {
                    $chat_id = $row['cid'];
                }

                $stmt = $con->prepare("DELETE FROM connected WHERE cid= :cid");
                $stmt->execute(['cid' => $chat_id]);
                if ($stmt->rowCount()) {

                    $sub = "DISLIKED";
                    $note = $user . " just disliked you...";

                    $stmt = $con->prepare("INSERT INTO notifications (uid, subject, note) VALUES (:userP, :sub, :note)");
                    $stmt->execute(['userP' => $userP, 'sub' => $sub, 'note' => $note]);
                    if ($stmt->rowCount()) {

                        ft_get_rating($userP);
                        echo "<script> alert('User successfully disliked and chat disconnected, and notification sent.'); location.href='../htmls/browse.php' </script>";
                    } else
                        echo "<script> alert('User successfully disliked and chat disconnected, but could not send notification.'); location.href='../htmls/browse.php' </script>";
                } else
                    echo "<script> alert('Could not delete from connected.'); location.href='../htmls/browse.php' </script>";
            } else {
                $sub = "DISLIKED";
                $note = $user . " just disliked you...";

                $stmt = $con->prepare("INSERT INTO notifications (uid, subject, note) VALUES (:userP, :sub, :note)");
                $stmt->execute(['userP' => $userP, 'sub' => $sub, 'note' => $note]);
                if ($stmt->rowCount()) {

                    ft_get_rating($userP);
                    echo "<script> alert('User successfully disliked and notifications sent.'); location.href='../htmls/browse.php' </script>";
                } else
                    echo "<script> alert('User disliked but no notification sent.'); location.href='../htmls/browse.php' </script>";
            }
        } else
            echo "<script> alert('Could not dislike user.'); location.href='../htmls/browse.php' </script>";
    }else
        echo "<script> alert('Can not dislike a user you never liked.'); location.href='../htmls/browse.php' </script>";
}

function ft_block($uid, $userP)
{

    include "../config/check_con.php";

    $stmt = $con->prepare(("SELECT * FROM liked WHERE uid= :uid AND looked= :userP"));
    $stmt->execute(['uid' => $uid, 'userP' => $userP]);
    if ($stmt->rowCount()) {

        //block user as well on own stuff
        //check if we are connected, if so, continue with this:
        $stmt = $con->prepare("SELECT * FROM connected WHERE (uid1= :userP AND uid2= :uid) OR (uid2= :userP AND uid1= :uid)");
        $stmt->execute(['userP' => $userP, 'uid' => $uid]);
        if ($stmt->rowCount()) {

            $result = $stmt->fetchAll();

            foreach ($result as $row) {
                $chat_id = $row['cid'];
            }

            $stmt = $con->prepare("DELETE FROM connected WHERE cid= :cid");
            $stmt->execute(['cid' => $chat_id]);
            if ($stmt->rowCount()) {

                $stmt = $con->prepare("UPDATE liked SET blocked= :userP, connected= '0', liked= '0' WHERE uid= :uid AND looked= :userP");
                $stmt->execute(['userP' => $userP, 'uid' => $uid]);
                if ($stmt->rowCount()) {

                    echo "<script> alert('User $userP successfully blocked.'); location.href='../htmls/stats.php' </script>";
                } else
                    echo "<script> alert('could not block user...'); location.href='../htmls/browse.php' </script>";

            } else
                echo "<script> alert('Chat id could not be deleted from connected.'); location.href='../htmls/browse.php' </script>";
        } else {
            $stmt = $con->prepare("UPDATE liked SET blocked= :userP, connected= '0', liked= '0' WHERE uid= :uid AND looked= :userP");
            $stmt->execute(['userP' => $userP, 'uid' => $uid]);
            if ($stmt->rowCount()) {
                echo "<script> alert('User $userP successfully blocked.'); location.href='../htmls/stats.php' </script>";
            } else
                echo "<script> alert('could not block user.'); location.href='../htmls/stats.php' </script>";
        }

    } else
        echo "<script> alert('can not find that you have looked at user you are attempting to block.'); location.href='../htmls/browse.php' </script>";
}

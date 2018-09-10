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

if (isset($_POST['like'])) {
    include "../config/check_con.php";

    $stmt = $con->prepare(("SELECT * FROM liked WHERE uid= :uid AND looked= :userP AND liked= :uid"));
    $stmt->execute(['uid' => $uid, 'userP' => $userP]);
    if (!$stmt->rowCount()) {

        $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :uid");
        $stmt->execute(['uid' => $uid]);
        if ($stmt->rowCount()) {
            $result = $stmt->fetchAll();
            foreach ($result as $row) {
                $profile = $row['profile_pic'];
                $img1 = $row['img1'];
                $img2 = $row['img2'];
                $img3 = $row['img3'];
                $img4 = $row['img4'];
                $user_name = $row['user_name'];
            }
            if (strcmp($profile, "") != 0 || strcmp($img1, "") != 0 || strcmp($img2, "") != 0
                || strcmp($img3, "") != 0 || strcmp($img4, "") != 0) {


                $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :userP AND looked= :uid AND blocked= :uid");
                $stmt->execute(['userP' => $userP, 'uid' => $uid]);
                if ($stmt->rowCount()) {
                    echo "<script> alert('You have been blocked by this user, can not like.'); location.href='../htmls/browse.php' </script>";
                } else {
                    //see if user has like you
                    $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :userP AND liked= :uid");
                    $stmt->execute(['userP' => $userP, 'uid' => $uid]);
                    if ($stmt->rowCount()) {
                        // if he did, it's a match, thus, do the following...

                        $stmt = $con->prepare("UPDATE liked SET liked= :userP, unliked= '0' WHERE uid= :uid AND looked= :userP");
                        $stmt->execute(['userP' => $userP, 'uid' => $uid]);
                        if ($stmt->rowCount()) {

                            $stmt = $con->prepare("SELECT * FROM connected WHERE (uid1= :uid AND uid2= :userP) OR (uid1= :userP AND uid2= :uid)");
                            $stmt->execute(['uid' => $uid, 'userP' => $userP]);
                            if (!$stmt->rowCount()) {

                                $stmt = $con->prepare("INSERT INTO connected (uid1, uid2) VALUES ('$uid', '$userP')");
                                $stmt->execute();
                                if ($stmt->rowCount()) {

                                    $stmt = $con->prepare("SELECT * FROM connected WHERE uid1= :uid AND uid2= :userP");
                                    $stmt->execute(['uid' => $uid, 'userP' => $userP]);
                                    if ($stmt->rowCount()) {

                                        $result = $stmt->fetchAll();
                                        foreach ($result as $row) {
                                            $chat_id = $row['cid'];
                                        }

                                        $stmt = $con->prepare("UPDATE liked SET connected= :cid WHERE (uid= :uid AND liked= :userP) OR (uid= :userP AND liked= :uid)");
                                        $stmt->execute(['cid' => $chat_id, 'uid' => $uid, 'userP' => $userP]);
                                        if ($stmt->rowCount()) {

                                            $sub = "LIKED";
                                            $note = "You and " . $user_name . " just matched!!";
                                            $stmt = $con->prepare("INSERT INTO notifications (uid, subject, note) VALUES (:userP, :liked, :note)");
                                            $stmt->execute(['userP' => $userP, 'liked' => $note, 'note' => $note]);

                                            ft_get_rating($userP);

                                            echo "<script> alert('It\'s a match!. You can now chat to this user.'); location.href='../htmls/chat.php?cid=$chat_id' </script>";
                                        } // set cid in liked -> connected
                                        else
                                            echo "<script> alert('could not set cid in liked'); </script>";

                                    } // find cid from connected
                                    else
                                        echo "<script> alert('could not find cid from connected.'); </script>";
                                } //inserted into connected
                                else
                                    echo "<script> alert('could not insert into connected.'); </script>";
                            } else
                                echo "<script> alert('Already connected to user.'); location.href='../htmls/browse.php' </script>";
                        }else
                            echo "<script> alert('could not like user in db, matched like.'); location.href='../htmls/browse.php'</script>";

                    } else {// this means i haven't been liked by the user i just liked
                        $stmt = $con->prepare("UPDATE liked SET liked= :userP, unliked= '0' WHERE uid= :uid AND looked= :userP");
                        $stmt->execute(['userP' => $userP, 'uid' => $uid]);
                        if ($stmt->rowCount()) {

                            $sub = "LIKED";
                            $note = $user_name . " just liked you!";

                            $stmt = $con->prepare("INSERT INTO notifications (uid, subject, note) VALUES (:userP, :sub, :note)");
                            $stmt->execute(['userP' => $userP, 'sub' => $sub, 'note' => $note]);
                            if ($stmt->rowCount()) {
                                ft_get_rating($userP);
                                echo "<script> alert('Successfully liked user $userP.'); location.href='../htmls/browse.php' </script>";
                            } else
                                echo "<script> alert('could not insert into notifications, unmatched like.'); location.href='../htmls/browse.php' </script>";
                        }else
                            echo "<script> alert('You have already liked this user.'); location.href='../htmls/browse.php'</script>";
                    }//this closes an else statement
                }
            } else
                echo "<script> alert('Can not like, you must have at least a profile picture or one image.'); location.href='../htmls/edit_profile.php' </script>";
        } else
            echo "<script> alert('could not find uid in profile.'); location.href='../htmls/browse.php'</script>";

    } else
        echo "<script> alert('Already liked user #2.'); location.href='../htmls/browse.php' </script>";
}

?>
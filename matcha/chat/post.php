<?php

session_start();

if (isset($_SESSION['user']) && isset($_SESSION['uid'])) {

    $uid = $_SESSION['uid'];
    $user = $_SESSION['user'];

} else
    echo "<script> alert('Please log in to access user information.'); location.href='../htmls/login.php' </script>";

if (isset($_POST['send'])) {

    if (isset($_SESSION['cid'])) {
        $chat_id = $_SESSION['cid'];
    } else
        echo "<script> alert('Please select a person to send message to.'); location.href='../htmls/chat.php' </script>";

    if (!empty($_POST['text']) && !ctype_space($_POST['text'])) {

        $text = htmlspecialchars($_POST['text']);

        include "../config/check_con.php";

        $stmt = $con->prepare("SELECT * FROM connected WHERE cid= :cid");
        $stmt->execute(['cid' => $chat_id]);
        if ($stmt->rowCount()) {
            $result = $stmt->fetchAll();

            foreach ($result as $row) {
                $uid1 = $row['uid1'];
                $uid2 = $row['uid2'];
            }

            if (strcmp($uid, $uid1) == 0) {
                $userP = $uid2;
            } else
                $userP = $uid1;

            $stmt = $con->prepare("INSERT INTO chat (cid, from_user, to_user, message)
                          VALUES (:cid, :from_user, :to_user, :text)");
            $stmt->execute(['cid' => $chat_id, 'from_user' => $uid, 'to_user' => $userP, 'text' => $text]);
            if ($stmt->rowCount()) {

                $sub = "NEW MESSAGE";
                $note = "You have a new message from " . $user;

                $stmt = $con->prepare("INSERT INTO notifications (uid, subject, note) 
                                            VALUES (:userP, :sub, :note)");
                $stmt->execute(['userP' => $userP, 'sub' => $sub, 'note' => $note]);
                if ($stmt->rowCount()) {
                    header("Location: ../htmls/chat.php");

                } else
                    echo "<script> alert('Could not insert into notifications.'); location.href='../htmls/chat.php' </script>";

            } else
                echo "<script> alert('Could not insert into chat.'); location.href='../htmls/chat.php' </script>";

        } else
            echo "<script> alert('Could not find chat_id.'); location.href='../htmls/chat.php' </script>";
    } else
        echo "<script> alert('No text inserted.'); location.href='../htmls/chat.php' </script>";
}
?>
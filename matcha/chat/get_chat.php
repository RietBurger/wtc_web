<?php
include "../config/check_con.php";

session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['user'])) {
    $uid = $_SESSION['uid'];
    $user = $_SESSION['user'];
}
else
    echo "<script> alert('Please log in or register to access account details.'); location.href='login.php' </script>";

if (isset($_SESSION['cid'])) {
    $cid = $_SESSION['cid'];

    $output = "";

    $stmt = $con->prepare("SELECT * FROM connected WHERE cid= :cid");
    $stmt->execute(['cid' => $cid]);
    if (!$stmt->rowCount()) {
        echo "<script> alert('You are no longer connected to this user.'); location.href='../htmls/chat.php' </script>";
    } else {

        $stmt = $con->prepare("SELECT * FROM chat WHERE cid= :cid ORDER BY time_sent DESC");
        $stmt->execute(['cid' => $cid]);
        if ($stmt->rowCount()) {
            $result = $stmt->fetchAll();

            foreach ($result as $row) {

                $from = $row['from_user'];
                $to = $row['to_user'];
                $message = $row['message'];
                $time = $row['time_sent'];

                if (strcmp($from, $uid) == 0) {
                    $userP = $to;
                } else
                    $userP = $from;

                $stmt = $con->prepare('SELECT * FROM profile WHERE uid= :userP');
                $stmt->execute(['userP' => $userP]);
                $result = $stmt->fetchAll();

                foreach ($result as $row) {
                    $userP_name = $row['user_name'];
                }

                if ($uid == $from) {
//wrap text!!
                    $output .= "<div class='msgln' style='background-color: yellow; text-align: right'>" . $time . "<b><br/>" . $user . "</b><br/>"
                        . stripcslashes(htmlspecialchars($message)) . "</div>";
                } else {
                    $output .= "<div class='msgln' style='background-color: greenyellow; text-align: left'>" . $time . "<b><br/>" . $userP_name . "</b><br/>"
                        . stripcslashes(htmlspecialchars($message)) . "<br></div>";
                }

            }
            // find each messsage and output
            $data = array('chat' => $output);
            echo json_encode($data);

        } else
            echo "<script> alert('Chat does not exist.'); location.href='../htmls/chat.php' </script>";
    }
}
?>
<?php

session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['user'])) {
    $uid = $_SESSION['uid'];
    $user = $_SESSION['user'];
}
else
    echo "<script> alert('Please log in or register to access account details.'); location.href='../htmls/login.php' </script>";

include "../config/check_con.php";

if (isset($_POST['view'])) {

    $output = "";

    if ($_POST['view'] != "") {
        $stmt = $con->prepare("UPDATE notifications SET status= '1' WHERE uid= '$uid' AND status='0'");
        $stmt->execute();
    }

    $stmt = $con->prepare("SELECT * FROM notifications WHERE uid= '$uid' ORDER BY id DESC LIMIT 5");
    $stmt->execute();
    if ($stmt->rowCount()) {

    $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $output .= "<li> <a href='?nid=" . $row['id'] ."'>
                        <strong>" . $row['subject'] . "</strong><br/>
                        <small><em>" . $row['note'] . "</em></small> </a></li>
                        <small><em>" . $row['uid'] . "</em></small>
                        <small><em>" . $row['status'] . "</em></small>";
        }
    } else {
        $output .= "<li><a href='#' class='text-bold text-italic'>No Notifications found</a></li>";
    }
    $stmt = $con->prepare("SELECT * FROM notifications WHERE status= '0' AND uid= $uid");
    $stmt->execute();
    $count = $stmt->rowCount();

    $data = array ('notification' => $output, 'unseen_notification' => $count);

    echo json_encode($data);
}

?>
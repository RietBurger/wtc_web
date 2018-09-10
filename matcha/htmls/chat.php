<?php
include "../functions/functions.php";
session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['user'])) {
    $uid = $_SESSION['uid'];
    $user = $_SESSION['user'];

    if (isset($_GET['nid'])) {
        $nid = $_GET['nid'];
        header("Location: stats.php");
    }

    if (isset($_GET['cid'])) {
        ft_authenticate_cid($uid, $_GET['cid']);

    }
}
else
    echo "<script> alert('Please log in or register to access account details.'); location.href='login.php' </script>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php ft_head(); ?>
    <link type="text/css" rel="stylesheet" href="../chat/chat_styles.css" />
</head>

<body>

<?php ft_notification(); ft_menu(); ?>

    <div class="wrapper">
        <div class="box">
            <h3>CHATS</h3>
            <ul>
                <?php ft_chats($uid); ?>
            </ul>
        </div>
    </div>
</div>

<div id="chat_wrapper">
    <div id="menu">
        <?php ft_chat_notice($uid, $user); ?>
        <div style="clear:both"></div>
    </div>
    <div id="chatbox">

    </div>
    <form method="post" action="../chat/post.php">
        <input name="text" type="text" id="textbox" size="63" default="default"/>
        <input name="send" type="submit" value="Send" />
    </form>
</div>

<div class="footer">
    <h2>&copy; 2017 by rburger </h2>
</div>

</body>
</html>

<script type="text/javascript" src="../notifications/notice.js"></script>

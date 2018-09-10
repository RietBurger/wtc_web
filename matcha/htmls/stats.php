<?php
include "../functions/functions.php";
session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['user'])) {
    $uid = $_SESSION['uid'];
    $user = $_SESSION['user'];

    if (isset($_GET['nid'])) {
        $nid = $_GET['nid'];
        delete_notification($nid);
    }
}
else
    echo "<script> alert('Please log in or register to access account details.'); location.href='login.php' </script>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php ft_head(); ?>
</head>

<body>
    <?php ft_notification(); ft_menu(); ?>

    <div class="box">
        <div class="col">

            <h3>MY FAME RATING</h3>
            <ul>
                <?php ft_rating($uid); ?>
            </ul>
        </div>
        <div class="">

            <h3>I LIKED</h3>
            <ul>
                <?php ft_i_liked($uid); ?>
            </ul>

        </div>

    <div class="row">
        <h3>LIKED BY</h3>
        <ul>
            <?php ft_liked_by($uid); ?>
        </ul>
    </div>

        <div class="row">
            <h3>I LOOKED AT</h3>
            <ul>
                <?php ft_looked_at($uid); ?>
            </ul>
        </div>

        <div class="row">
            <h3>LOOKED AT BY</h3>
            <ul>
                <?php ft_looked_by($uid); ?>
            </ul>
        </div>

        <div class="row">
            <h3> I BLOCKED USER: </h3>
            <ul>
                <?php ft_i_blocked($uid); ?>
            </ul>
        </div>

        <div class="row">
            <h3>BLOCKED BY USER: </h3>
            <ul>
                <?php ft_blocked($uid); ?>
            </ul>
        </div>

        <div class="row">
            <h3>CONNECTED TO</h3>
            <ul>
                <?php ft_connected($uid); ?>
            </ul>
        </div>
        <div class="row">
            <h3>CHATS</h3>
            <ul>
                <?php ft_chats($uid); ?>
            </ul>
        </div>
    </div>

    <div class="footer">
        <h2>&copy; 2017 by rburger </h2>
    </div>
</div>

</body>
</html>

    <script type="text/javascript" src="../notifications/notice.js"></script>

<?php
include "../functions/functions.php";
include "../config/check_con.php";


session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['user'])) {
    $uid = $_SESSION['uid'];
    $user = $_SESSION['user'];
    $userP = $_GET['uid'];
    $_SESSION['userP'] = $userP;

    if (isset($_GET['nid'])) {
        $nid = $_GET['nid'];
        header("Location: stats.php");
    }

    ft_set_looked_at($uid, $userP);
}
else
    echo "<script> alert('Please log in or register to access account details.'); location.href='login.php' </script>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php ft_head(); ?>
    <link rel="stylesheet" href="../css/styles.css" type="text/css" media="all"/>
</head>
<body>

<?php ft_notification(); ft_menu();?>

    <div class="row">
            <?php ft_display_img($userP); ?>
    </div>

    <div class="container">
        <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
        <img id="expandedImg" style="width:100%">
        <div id="imgtext"></div>
    </div>

    <div class="media-body">
        <?php ft_display_info_form($userP);  ?>
    </div>
    <form action="../matching/like.php" method="post">
        <button type="submit" class="btn btn-default" name="like">
            <span class="glyphicon glyphicon-thumbs-up" area-hidden="true"> Like</span>
        </button>
    </form>
    <br><br>
    <form action="../matching/report.php" method="post">
        <button type="submit" class="btn btn-default" name="block">
            <span class="glyphicon glyphicon-ban-circle" area-hidden="true"> Block</span>
        </button>
        <button type="submit" class="btn btn-default" name="report">
            <span class="glyphicon glyphicon-eye-close" area-hidden="true"> Report</span>
        </button>
        <button type="submit" class="btn btn-default" name="dislike">
            <span class="glyphicon glyphicon-thumbs-down" area-hidden="true"> Dislike</span>
        </button>
    </form>
<br><br>

<button onclick="goBack()" class="btn btn-default">Back</button>

<br><br>

<div class="footer">
    <h2>&copy; 2017 by rburger </h2>
</div>
</div>


<script>
//    to expand image
    function myFunction(imgs) {
        var expandImg = document.getElementById("expandedImg");
        var imgText = document.getElementById("imgtext");
        expandImg.src = imgs.src;
        imgText.innerHTML = imgs.alt;
        expandImg.parentElement.style.display = "block";
    }

    function goBack() {
        window.history.back();
    }

    function goForward() {
        window.history.forward();
    }

</script>


</body>
</html>

<script type="text/javascript" src="../notifications/notice.js"></script>

<?php
include "../functions/functions.php";
session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['user'])) {
    $uid = $_SESSION['uid'];
    $user = $_SESSION['user'];

    if (isset($_GET['nid'])) {
        $nid = $_GET['nid'];
        header("Location: stats.php");    }
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

<?php ft_notification(); ft_menu(); ?>

    <div class="row">
        <?php ft_display_img($uid); ?>
    </div>
    <div class="container">
        <span onclick="this.parentElement.style.display='none'" class="red_closebtn">&times;</span>
        <img id="expandedImg" style="width:100%">
        <div id="imgtext"></div>
    </div>
    <div class="info">
        <?php ft_display_info($uid);  ?>
    </div>
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
</script>


</body>
</html>

<script type="text/javascript" src="../notifications/notice.js"></script>
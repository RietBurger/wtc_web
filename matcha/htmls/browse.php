
<?php
include "../matching/browse.php";
include "../functions/functions.php";
include "../functions/search_fts.php";
include "../config/check_con.php";

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
            <?php ft_notification();
            ft_menu(); ?>


    <form action="" method="post" enctype="multipart/form-data">
        <select name="order">
            <option value="matched"></option>
            <option value="distance">distance</option>
            <option value="age">Age</option>
            <option value="area">Area</option>
            <option value="fame_rate">Fame Rating</option>
            <option value="tag1">Tag1</option>
        </select>
        <input type="submit" name="sort" value="sort">
    </form>

    <form action="" method="post" enctype="multipart/form-data">
        <select name="filter">
            <option value="distance"></option>
            <option value="age">Age</option>
            <option value="area">Area</option>
            <option value="fame_rate">Fame Rating</option>
            <option value="tag1">Tag1</option>
        </select>
        <input type="submit" value="filter" name="filter_by">
    </form>
    <div>
        <!--        <p id="demo"></p>-->
    </div>
</div>
    <div class="container">
        <div class="row" style="height:80%">

        <?php
            if (isset($_POST['sort'])) {

                $orderBy = array('age', 'tag1', 'fame_rate', 'area', 'distance');

                if (in_array($_POST['order'], $orderBy)) {
                    $order = $_POST['order'];

                    $filter = "none";
                    find_and_save_arr($uid, $order, $filter);
                } else
                    echo "<script> alert('That is not an option...'); location.href='browse.php' </script>";
            } elseif (isset($_POST['filter_by'])) {

                $orderBy = array('age', 'tag1', 'fame_rate', 'area', 'distance');

                if (in_array($_POST['filter'], $orderBy)) {
                    $filter = $_POST['filter'];

                    $order = "none";
                    find_and_save_arr($uid, $order, $filter);
                } else
                    echo "<script> alert('That is not an option...'); location.href='browse.php' </script>";
            } else {
                $order = "matched";
                $filter = "none";
                find_and_save_arr($uid, $order, $filter);

        }

        ?>
        </div>
        <br>
        <div class="footer">
            <h2>&copy; 2017 by rburger </h2>
        </div>
    </div>




</body>
</html>

<script type="text/javascript" src="../notifications/notice.js"></script>


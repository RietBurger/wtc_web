<?php
include "../matching/browse.php";
include "../functions/functions.php";
include "../functions/search_fts.php";
include "../config/check_con.php";

session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['user'])) {
    $uid = $_SESSION['uid'];
    $user = $_SESSION['user'];
    if (isset($_SESSION['uid_arr'])) {
        $uid_arr = $_SESSION['uid_arr'];
    }

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

    <div class="info">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="checkbox" value="area" name="search[]" />Area <br>
            <input type="checkbox" value="fame_gap" name="search[]" />Fame rating gap <br>
            <input type="checkbox" value="age_gap" name="search[]" />Age Gap <br>
            <h3>Tags</h3>
            <div>
                <?php  ft_echo_all_tags();   ?>
            </div>

            <button type="submit" name="search_for" onclick="goForward();">Search</button><br><br>
        </form>

        <form action="" method="post" enctype="multipart/form-data">
            <select name="order">
                <option value="distance"></option>
                <option value="age_gap">Age Gap</option>
                <option value="area">Area</option>
                <option value="fame_gap">Fame Rating Gap</option>
                <option value="tag1">Tags</option>
            </select>
            <button type="submit" name="sort" onclick="goForward();">Sort</button>
        </form>

        <form action="" method="post" enctype="multipart/form-data">
            <select name="filter">
                <option value="distance"></option>
                <option value="age">Age</option>
                <option value="area">Area</option>
                <option value="fame_rate">Fame Rating</option>
                <option value="tag1">Tag1</option>
            </select>
            <button type="submit" value="filter" name="filter_by" onclick="goForward();">Filter</button>
        </form>
    </div>
    <div class="wrapper">

        <?php

        if (isset($_POST['search_for'])) {

            if (!empty($_POST['search'])) {

                ft_set_zero();

                $search_arr = array();

                foreach ($_POST['search'] as $row) {
                    $search_arr[] = $row;
                }

                $uid_arr = ft_match_gender($uid);
                $uid_arr2 = ft_find_all_tags($uid, $search_arr, $uid_arr);

                if (in_array("fame_gap", $search_arr) || in_array("age_gap", $search_arr)) {
                    $gap_uid_arr = ft_set_gaps($uid, $uid_arr);
                } else
                    $gap_uid_arr = array();

                if (in_array("area", $search_arr)) {
                    $uid_arr3 = ft_find_area($uid, $uid_arr);
                } else
                    $uid_arr3 = array();

                $uid_arr_use = array_merge($uid_arr2, $uid_arr3, $gap_uid_arr);
                $order = "age";
                $_SESSION['uid_arr'] = $uid_arr_use;
                ft_show_new_matches($uid, $uid_arr_use, $order);

            } else
                echo "<script> alert('That is not an option...'); </script>";
        }

        if (isset($_POST['sort']) && isset($_SESSION['uid_arr'])) {

            $order = $_POST['order'];
            $uid_arr1 = $_SESSION['uid_arr'];
            ft_show_new_matches($uid, $uid_arr1, $order);
        }

        if (isset($_POST['filter_by']) && isset($_SESSION['uid_arr'])) {
            $filter = $_POST['filter'];
            $uid_arr1 = $_SESSION['uid_arr'];

            ft_show_filtered_matches($uid, $uid_arr1, $filter);
        }

        ?>

    </div>

    <br>
</div>

<div class="footer">
    <h2>&copy; 2017 by rburger </h2>
</div>
</body>
</html>

<script type="text/javascript" src="../notifications/notice.js"></script>
<?php

include "../functions/functions.php";

if (isset($_POST['submit'])) {
    $lat1 = $_POST['lat1'];
    $long1 = $_POST['long1'];
    $lat2 = $_POST['lat2'];
    $long2 = $_POST['long2'];

    if (($lat1 != '0' && $long1 != 0) || ($lat2 != '0' && $long2 != '0')) {

        $result = ft_distance($lat1, $long1, $lat2, $long2);
        echo "<script> alert('This is distance between 2 locations: $result'); location.href='../htmls/browse.php' </script>";
    }
}

?>
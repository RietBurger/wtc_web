<?php

function ft_find_area($lat, $long)
{

    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false&key=AIzaSyDBwkjYxema4e0IV9Zhj2ylYiUg0yz4mvk";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_ENCODING, "");
    $curlData = curl_exec($curl);
    curl_close($curl);

    $address = json_decode($curlData);

    $a = $address->results[0];
    $address_use = explode(",", $a->formatted_address);

    $area = $address_use[1];
    return ($area);
}

function ft_latt_long($prepAddr)
{

    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$prepAddr&sensor=false&key=AIzaSyDBwkjYxema4e0IV9Zhj2ylYiUg0yz4mvk";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_ENCODING, "");
    $curlData = curl_exec($curl);
    curl_close($curl);

    $info = json_decode($curlData);

    if (strcmp($info->status, "ZERO_RESULTS") != 0) {

        $lat = $info->results[0]->geometry->location->lat;
        $long = $info->results[0]->geometry->location->lng;

        $lat_long = array($lat, $long);

       return ($lat_long);
    }
    else
        echo "<script> alert('Location does not exist...'); </script>";

}
?>
<?php
include "../functions/functions.php";
session_start();

if (isset($_SESSION['temp_uid']) && isset($_SESSION['temp_user'])) {
    $uid = $_SESSION['temp_uid'];
    $user = $_SESSION['temp_user'];
}
else
    echo "<script> alert('TEMP session vars not set... Please log in or register to access account details.'); location.href='../index.php' </script>";

?>

<!DOCTYPE html>
<html lang="en">

<?php ft_head(); ?>

<body onload="getLocation()">
<div class="container">

    <nav class="navbar navbar-inverse">
        <div class="page-header" style="text-align: center; font-family: \'Apple Chancery\';">
            <h1 style="font-size: 50px; color: greenyellow">Someone Like Me</h1>
        </div>
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">DETAILS FOR PROFILE</a>
            </div>

            <ul class="nav navbar-nav navbar-inverse">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown"><span class="label label-pill label-danger count"
                                                             style="border-radius: 10px"></span> <span class="glyphicon glyphicon-bell" style="font-size: 18px;" ></span> </a>
                    <ul></ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="box">
        <form method="post" action="../profiles/my_profile.php">
            <label><b>Gender</b></label><br>
            <select name="gender" required="required">
                <option value="Male">Male </option>
                <option value="Female">Female </option>
                <option value="Trans">Trans</option>
            </select>
            <br><br>
            <label><b> Sexual preference </b></label><br>
            <select name="preference" required="required">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Male and Female" selected="selected">Male and Female</option>
                <option value="Trans">Trans</option>
            </select>
            <br><br>
            <label><b>Age</b></label>
            <input type="text" name="age" required="required" pattern="(?=.*\d).{2,2}" title="Must contain two numbers" maxlength="2"><br><br>
            <label><b>Tags</b></label><br>
            <label><b>Tag 1</b></label>
            <select name="tag1" required="required"><br>
                <?php ft_display_tags(); ?>
            </select><br>
            <label><b>Tag 2</b></label>
            <select name="tag2" required="required"><br>
                <?php ft_display_tags(); ?>
            </select><br>
            <label><b>Tag 3</b></label>
            <select name="tag3" required="required"><br>
                <?php ft_display_tags(); ?>
            </select><br>
            <label><b>Tag 4</b></label>
            <select name="tag4"><br>
                <?php ft_display_tags(); ?>
            </select><br>
            <label><b>Tag 5</b></label>
            <select name="tag5"><br>
                <?php ft_display_tags(); ?>
            </select><br><br>
            <label><b>Describe yourself in 500 characters</b></label><br>
            <textarea name="bio" required="required" style="width: 50%; height: 300px;" minlength="10" maxlength="500" title="Must contain at least one uppercase and one lowercase letter. Must be between 10 and 500 characters long"></textarea>
            <br><br>
            <label><b>Location</b></label><br>
            <p id="location"></p> <br><br>
            <br><br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </div>
<div class="footer">
    <h2>&copy; 2017 by rburger </h2>
</div>
</div>


</body>
</html>
<script>
    var x = document.getElementById("location");

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {

        x.innerHTML = "<input type='text' name='lat' value='" + position.coords.latitude + "' readonly /><br> " +
            "<input type='text' name='long' value='" + position.coords.longitude + "' readonly/>";
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                $.getJSON('http://ip-api.com/json')
                    .done (function(location) {
                        x.innerHTML = "<input type='text' name='lat' value='" + location.lat + "' readonly /><br> " +
                            "<input type='text' name='long' value='" + location.lon + "' readonly/>";
                    });
                x.innerHTML = "<p>Enter Your Street name</p>\n" +
                    "    <input type='text' name='address' placeholder='Street name' />";
                break;
            case error.POSITION_UNAVAILABLE:
                x.innerHTML = "Location information is unavailable."
                break;
            case error.TIMEOUT:
                x.innerHTML = "The request to get user location timed out."
                break;
            case error.UNKNOWN_ERROR:
                x.innerHTML = "An unknown error occurred."
                break;
        }
    }
</script>
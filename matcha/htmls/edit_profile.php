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
}
else
    echo "<script> alert('Please log in or register to access account details.'); location.href='login.php' </script>";

?>

<!DOCTYPE html>
<html lang="en">

<?php ft_head(); ?>

<body onload="getLocation()">

<?php ft_notification();
ft_menu(); ?>

    <div class="box">
        <form method="post" enctype="multipart/form-data" action="../profiles/edit_profile.php">
            <label><b>Gender</b></label><br>
            <select name="gender" title="Gender">
                <option value="none" selected="selected"></option>
                <option value="Male">Male </option>
                <option value="Female">Female </option>
                <option value="Trans">Trans</option>
            </select>
            <br><br>
            <label><b> Sexual preference </b></label><br>
            <select name="preference" title="Sexual Preference">
                <option value="none" selected="selected"></option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Male and Female">Male and Female</option>
                <option value="Trans">Trans</option>
            </select>
            <br><br>

            <label><b>Age</b></label>
            <input type="text" name="age" pattern="(?=.*\d).{2,2}" title="Must contain two numbers" maxlength="2"><br><br>
            <label><b>Location</b></label><br>
            <p id="location"></p> <br><br>
            <label>Enter Your Street name or address</label>
            <input type='text' name='address' placeholder='Street name,City state,Country' /><br><br>

            <label><b>Tags</b></label><br><br>
            <label><b>Tag 1</b></label>
            <select name="tag1"><br>
                <?php ft_display_tags(); ?>
            </select><br>
            <label><b>Tag 2</b></label>
            <select name="tag2"><br>
                <?php ft_display_tags(); ?>
            </select><br>
            <label><b>Tag 3</b></label>
            <select name="tag3"><br>
                <?php ft_display_tags(); ?>
            </select><br>
            <label><b>Tag 4</b></label>
            <select name="tag4"><br>
                <?php ft_display_tags(); ?>
            </select><br>
            <label><b>Tag 5</b></label>
            <select name="tag5"><br>
                <?php ft_display_tags(); ?>
            </select><br>


            <label><b>Describe yourself in 500 characters</b></label><br>
            <textarea name="bio" style="width: 50%; height: 300px;" minlength="10" maxlength="500" title="Must contain at least one uppercase and one lowercase letter. Must be between 10 and 500 characters long"></textarea>
            <br><br>
            <label><b> Select to update info</b></label><br>
            <input type="submit" name="update" value="Update"> <br><br>
        </form>
        <form method="post" enctype="multipart/form-data" action="../profiles/images.php">
        <label><b>Profile Picture</b></label><br>
            <input type="file" name="profile_pic">
            <input type="submit" name="profile" value="Upload"><br><br>
            <label><b>Image 1</b></label><br>
            <input type="file" name="img1">
            <input type="submit" name="image1" value="Upload"><br><br>
            <label><b>Image 2</b></label><br>
            <input type="file" name="img2">
            <input type="submit" name="image2" value="Upload"><br><br>
            <label><b>Image 3</b></label><br>
            <input type="file" name="img3">
            <input type="submit" name="image3" value="Upload"><br><br>
            <label><b>Image 4</b></label>
            <input type="file" name="img4"><br>
            <input type="submit" name="image4" value="Upload"><br><br>
        </form>
        <br>
    </div>
    <div class="row">
        <?php ft_display_img($uid); ?>
    </div>
    <div class="container">
        <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
        <img id="expandedImg" style="width:100%">
        <div id="imgtext"></div>
    </div>
<div class="footer">
    <h2>&copy; 2017 by rburger </h2>
</div>
</div>
<script>
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
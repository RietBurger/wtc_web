<?php
session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['email'])) {
    $uid = $_SESSION['uid'];
    $email = $_SESSION['email'];
}

include ("../camera/functions.php");
?>

<!DOCTYPE html>
<head>
    <title>Camagru</title>
    <link rel="stylesheet" href="../css/styles.css" madia="all">
    <link rel='stylesheet' media='screen and (max-width: 700px)' href='../css/mobile.css' type="text/css" />
</head>

<body>
<div class="main">
    <div class="header">
        <h1>CAMA-ra-G-u-RU</h1>
    </div>

    <div class="menubar">
        <ul id="menu">
            <li><a href="../htmls/loggedin.php">Home</a></li>
            <li><a href="../htmls/loggedin_gallery.php">Gallery</a></li>
            <li><a href="../login/logout.php">Log out</a></li>
        </ul>
    </div>

    <div class="pagination">
        <a href="loggedin_gallery.php?page=1">1</a>
        <a href="loggedin_gallery.php?page=2">2</a>
        <a href="loggedin_gallery.php?page=3">3</a>
        <a href="loggedin_gallery.php?page=4">4</a>
        <a href="loggedin_gallery.php?page=5">5</a>
        <a href="loggedin_gallery.php?page=6">6</a>
    </div>



<div class="wrapper">
<?php displayGallery(); //displayGalleryPage(); ?>
</div>

    <div class="container">
        <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
        <img id="expandedImg" style="width:100%">
        <div id="imgtext"></div>
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

<div class="footer">
    <h2>&copy; 2017 by rburger </h2>
</div>
</body>
</html>
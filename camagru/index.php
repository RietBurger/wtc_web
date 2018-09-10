<?php

include ("config/check_con.php");

?>

<!DOCTYPE html>
<head>
    <title>Camagru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css" madia="all">
    <link rel="stylesheet" media="screen and (max-width: 700px)" href="css/mobile.css" type="text/css" />
</head>

<body>
<div class="main">
    <div class="header">
        <h1>CAMA-ra-G-u-RU</h1>
    </div>

    <div class="menubar">
        <ul id="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="htmls/loggedin_gallery.php">Gallery</a></li>
            <li><a href="htmls/login.php">Sign In</a></li>
            <li><a href="htmls/register.php">Register</a></li>
            <li><a href="htmls/request_new_pw.php">Forgot Password?</a></li>
        </ul>
    </div>

    <div class="container">
        <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
        <img id="expandedImg" style="width:100%">
        <div id="imgtext"></div>
    </div>

    <div class="wrapper">
    <?php

        $stmt = $con->prepare("SELECT * FROM images ORDER BY id DESC LIMIT 10");
        $stmt->execute();
        if ($stmt->rowCount()) {
            $result = $stmt->fetchAll();

            foreach ($result as $row) {
                echo '<div class="box">
            <img width="200px" height="150" alt=" ' . $row['img_name'] . ' " src="data:image;base64,' . $row['image'] . ' " onclick="myFunction(this);"/>
        </div>';
            }
        }

        ?>
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
</div>
<div class="footer">
    <h2>&copy; 2017 by rburger </h2>
</div>
</body>
</html>
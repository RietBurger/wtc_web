<?php

function overlay_img($uid, $name) {

    unlink("../saved/temp.png");
    unset($_SESSION['set']);
    unset($_SESSION['set2']);
    unset($_SESSION['set3']);

    $dest = imagecreatefrompng('../temp_img/image1.png');

    if (file_exists('../temp_img/image2.png')) {
        $src = imagecreatefrompng('../temp_img/image2.png');

        imagecopy($dest, $src, 0, 0, 0, 0, 150, 150);
        imagepng($dest, "../saved/temp.png");

        $image = file_get_contents("../saved/temp.png");
        $image = base64_encode($image);
        saveimage($name, $image, $uid);
    }
    else {
        imagepng($dest, "../saved/temp.png");
        $image = file_get_contents("../saved/temp.png");
        $image = base64_encode($image);

        saveoneimage($name, $image, $uid);
    }

}

function displayGallery() {

    include "../config/check_con.php";

    $resultsPerPage = 5;
    if (isset($_GET['page']) && ctype_digit($_GET['page']) && $_GET['page'] > 0)
    {
        $offset = ($_GET['page'] - 1) * $resultsPerPage;
    }
    else
        $offset = 0;


    $stmt = $con->prepare("SELECT * FROM images ORDER BY id DESC LIMIT $offset, $resultsPerPage");
    $stmt->execute();
    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {

            echo '<div class="box">
                <form action="../camera/like.php" name="like" method="post" enctype="multipart/form-data">
                <input type="submit" name="like" value="Like">
                <input type="hidden" name="liked" value=" '. $row['id'] . '"></form>
                <img width="200px" height="150" alt=" '. $row['img_name'] .' " src="data:image;base64,' . $row['image'] . ' " onclick="myFunction(this);"/>
    
                <form action="../camera/comment.php" name="comment" method="post" enctype="multipart/form-data">
                <input type="hidden" name="creator" value="' .$row['uid']. ' "><input type="hidden" name="img_id" value=" '. $row['id'] .'">
                <input type="text" name="comm" required="required" maxlength="150"> <input type="submit" name="comment" value="comment"></form>
                </div>';
        }
    }
}

function saveimage($name, $image, $uid) {

    include "../config/check_con.php";

    $stmt = $con->prepare("SELECT * FROM users WHERE uid = :uid");
    $stmt->execute(['uid' => $uid]);

    if ($stmt->rowCount()) {

        $stmt = $con->prepare("INSERT INTO images (img_name, image, uid) VALUES ('$name', '$image', '$uid')");
        $stmt->execute();
        if ($stmt->rowCount()) {
            unlink('../temp_img/image1.png');
            unlink('../temp_img/image2.png');

            echo '<script> alert("Image saved successfully."); location.href="../htmls/loggedin.php"; </script>';
        }
        else
            echo '<script> alert("Unable to save image."); location.href="../htmls/login.php"; </script>';
    }
    else
        echo '<script> alert("Please log in 2."); location.href="../htmls/login.php"; </script>';

    $stmt->close();
    $con->close();

}

function saveoneimage($name, $image, $uid) {

    include "../config/check_con.php";

    $stmt = $con->prepare("SELECT * FROM users WHERE uid = :uid");
    $stmt->execute(['uid' => $uid]);

    if ($stmt->rowCount()) {

        $stmt = $con->prepare("INSERT INTO images (img_name, image, uid) VALUES ('$name', '$image', '$uid')");
        $stmt->execute();
        if ($stmt->rowCount()) {
            unlink('../temp_img/image1.png');

            echo '<script> alert("Image saved successfully."); location.href="../htmls/loggedin.php"; </script>';
        }
        else
            echo '<script> alert("Unable to save image."); location.href="../htmls/login.php"; </script>';
    }
    else
        echo '<script> alert("Please log in 2."); location.href="../htmls/login.php"; </script>';

    $stmt->close();
    $con->close();

}

function displayimage($uid) {

    include "../config/check_con.php";

    $stmt = $con->prepare("SELECT * FROM images WHERE uid = :uid ORDER BY id DESC");
    $stmt->execute(['uid' => $uid]);
    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            echo '<div class="box"><input type="submit" value=" ' . $row['id'] . '" name="delete" >
<img height="150" width="200" src="data:image;base64,' . $row['image'] . ' "/>
        </br></div> ';
        }
    }
}

?>

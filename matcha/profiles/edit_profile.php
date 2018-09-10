<?php

session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['user'])) {
    $uid = $_SESSION['uid'];
    $user = $_SESSION['user'];
}
else
    echo "<script> alert('Please log in or register to access account details.'); location.href='../index.php' </script>";

    if (isset($_POST['update'])) {
        include "../functions/functions.php";
        include "../config/check_con.php";
        include "../maps/find_area.php";

        $gender = $_POST['gender'];
        $pref = $_POST['preference'];
        $bio = htmlspecialchars($_POST['bio']);
        $age = htmlspecialchars($_POST['age']);
        $address = $_POST['address'];
        $tag1 = $_POST['tag1'];
        $tag2 = $_POST['tag2'];
        $tag3 = $_POST['tag3'];
        $tag4 = $_POST['tag4'];
        $tag5 = $_POST['tag5'];
        $lat = $_POST['lat'];
        $long = $_POST['long'];

        $stmt = $con->prepare("SELECT uid FROM profile WHERE uid = :uid");
        $stmt->execute(['uid' => $uid]);
        if (!$stmt->rowCount()) {
            echo "<script> alert('Your profile has not been created, please complete profile before continuing.'); location.href='../htmls/my_profile.php' </script>";
        } else {

            if (strcmp($gender, "none") != 0) {

            $stmt = $con->prepare("UPDATE `profile` SET `gender`= :gender WHERE `uid` = :uid");
            $stmt->execute(['gender' => $gender, 'uid' => $uid]);
            if ($stmt->rowCount()) {
                echo "<script> alert('Your gender has been successfully updated.'); location.href='../htmls/home.php'; </script>";
            } else
                echo "<script> alert('Unable to insert into DB.'); location.href='../htmls/edit_profile.php';</script>";
        }

            if (strcmp($age, "") != 0) {

                if (!preg_match("/(?=.*\d).{2}/", $age)) {
                    echo "<script>alert('Please match pattern for age.'); location.href='../htmls/edit_profile.php'; </script>";
                } else {

                    $stmt = $con->prepare("UPDATE `profile` SET `age`= :age WHERE `uid` = :uid");
                    $stmt->execute(['age' => $age, 'uid' => $uid]);
                    if ($stmt->rowCount()) {
                        echo "<script> alert('Your age has been successfully updated.'); location.href='../htmls/home.php'; </script>";
                    } else
                        echo "<script> alert('Unable to insert into DB.'); location.href='../htmls/edit_profile.php';</script>";
                }
            }

        if (strcmp($pref, "none") != 0) {
            $stmt = $con->prepare("UPDATE `profile` SET `sexual_pref`= :pref WHERE `uid` = :uid");
            $stmt->execute(['pref' => $pref, 'uid' => $uid]);
            if ($stmt->rowCount()) {
                echo "<script> alert('Your sexual preference has been successfully updated.'); location.href='../htmls/home.php'; </script>";
            } else
                echo "<script> alert('Unable to insert into DB.'); location.href='../htmls/edit_profile.php';</script>";
            }
            if (strcmp($bio, "") != 0) {
                $stmt = $con->prepare("UPDATE `profile` SET `biography`= :bio WHERE `uid` = :uid");
                $stmt->execute(['bio' => $bio, 'uid' => $uid]);
                if ($stmt->rowCount()) {
                    echo "<script> alert('Your biography has been successfully updated.'); location.href='../htmls/home.php'; </script>";
                } else
                    echo "<script> alert('Unable to insert into DB.'); location.href='../htmls/edit_profile.php';</script>";
            }
            if (strcmp($tag1, "") != 0) {
                $stmt = $con->prepare("UPDATE `profile` SET `tag1`= :tag WHERE `uid` = :uid");
                $stmt->execute(['tag' => $tag1, 'uid' => $uid]);
                if ($stmt->rowCount()) {
                    echo "<script> alert('Your Tag1 has been successfully updated.'); location.href='../htmls/home.php'; </script>";
                } else
                    echo "<script> alert('Unable to insert into DB.'); location.href='../htmls/edit_profile.php';</script>";
            }
            if (strcmp($tag2, "") != 0) {
                $stmt = $con->prepare("UPDATE `profile` SET `tag2`= :tag WHERE `uid` = :uid");
                $stmt->execute(['tag' => $tag2, 'uid' => $uid]);
                if ($stmt->rowCount()) {
                    echo "<script> alert('Your Tag2 has been successfully updated.'); location.href='../htmls/home.php'; </script>";
                } else
                    echo "<script> alert('Unable to insert into DB.'); location.href='../htmls/edit_profile.php';</script>";
            }
            if (strcmp($tag3, "") != 0) {
                $stmt = $con->prepare("UPDATE `profile` SET `tag3`= :tag WHERE `uid` = :uid");
                $stmt->execute(['tag' => $tag3, 'uid' => $uid]);
                if ($stmt->rowCount()) {
                    echo "<script> alert('Your Tag 3 has been successfully updated.'); location.href='../htmls/home.php'; </script>";
                } else
                    echo "<script> alert('Unable to insert into DB.'); location.href='../htmls/edit_profile.php';</script>";
            }
            if (strcmp($tag4, "") != 0) {
                $stmt = $con->prepare("UPDATE `profile` SET `tag4`= :tag WHERE `uid` = :uid");
                $stmt->execute(['tag' => $tag4, 'uid' => $uid]);
                if ($stmt->rowCount()) {
                    echo "<script> alert('Your Tag 4 has been successfully updated.'); location.href='../htmls/home.php'; </script>";
                } else
                    echo "<script> alert('Unable to insert into DB.'); location.href='../htmls/edit_profile.php';</script>";
            }
            if (strcmp($tag5, "") != 0) {
                $stmt = $con->prepare("UPDATE `profile` SET `tag5`= :tag WHERE `uid` = :uid");
                $stmt->execute(['tag' => $tag5, 'uid' => $uid]);
                if ($stmt->rowCount()) {
                    echo "<script> alert('Your Tag 5 has been successfully updated.'); location.href='../htmls/home.php'; </script>";
                } else
                    echo "<script> alert('Unable to insert into DB.'); location.href='../htmls/edit_profile.php';</script>";
            }

            if (isset($_POST['lat']) && isset($_POST['long'])) {
                $area = ft_find_area($lat, $long);

                if ($area) {
                    $stmt = $con->prepare("SELECT * FROM location WHERE uid= :uid");
                    $stmt->execute(['uid' => $uid]);
                    if ($stmt->rowCount()) {

                        $stmt = $con->prepare("UPDATE location SET lattitude= :lat, longitude= :long WHERE uid= :uid");
                        $stmt->execute(['lat' => $lat, 'long' => $long, 'uid' => $uid]);

                        if ($stmt->rowCount()) {
                            $stmt = $con->prepare("UPDATE profile SET area= :area WHERE uid= :uid");
                            $stmt->execute(['area' => $area, 'uid' => $uid]);
                            if ($stmt->rowCount()) {

                                echo "<script> alert('Your location has been successfully updated.'); location.href='../htmls/home.php'; </script>";
                            }
                        }
                    } else {
                        $stmt = $con->prepare("INSERT INTO location (uid, lattitude, longitude)
                                  VALUES ('$uid', '$lat', '$long')");
                        $stmt->execute();

                        if ($stmt->rowCount()) {
                            $stmt = $con->prepare("UPDATE profile SET area= :area WHERE uid= :uid");
                            $stmt->execute(['area' => $area, 'uid' => $uid]);
                            if ($stmt->rowCount()) {

                                echo "<script> alert('Your location has been successfully updated.'); location.href='../htmls/home.php'; </script>";
                            }
                        }
                    }

                }else
                    echo "<script> alert('no area found.'); location.href='../htmls/edit_profile.php'; </script>";
            }

            if (strcmp($address, "") != 0) {
                 $prepAddr = str_replace(' ', '+', $address);

                $lat_long = ft_latt_long($prepAddr);

                $lat = $lat_long[0];
                $long = $lat_long[1];

                if ((strcmp($lat, "") == 0 && strcmp($long, "") == 0) || ($lat == '0' && $long == 0)) {
                    echo "<script> alert('Latitude or longitude empty, in strcmp(address)...'); location.href='../htmls/edit_profile.php'; </script>";
                } else {

                    $area = ft_find_area($lat, $long);

                    $stmt = $con->prepare("SELECT * FROM location WHERE uid= :uid");
                    $stmt->execute(['uid' => $uid]);
                    if ($stmt->rowCount()) {

                        $stmt = $con->prepare("UPDATE location SET lattitude= :lat, longitude= :long WHERE uid= :uid");
                        $stmt->execute(['lat' => $lat, 'long' => $long, 'uid' => $uid]);

                        if ($stmt->rowCount()) {
                            $stmt = $con->prepare("UPDATE profile SET area= :area WHERE uid= :uid");
                            $stmt->execute(['area' => $area, 'uid' => $uid]);
                            if ($stmt->rowCount()) {

                                echo "<script> alert('Your location has been successfully updated.'); location.href='../htmls/home.php'; </script>";
                            }
                        }
                    } else {
                        $stmt = $con->prepare("INSERT INTO location (uid, lattitude, longitude)
                                  VALUES ('$uid', '$lat', '$long')");
                        $stmt->execute();

                        if ($stmt->rowCount()) {
                            $stmt = $con->prepare("UPDATE profile SET area= :area WHERE uid= :uid");
                            $stmt->execute(['area' => $area, 'uid' => $uid]);
                            if ($stmt->rowCount()) {

                                echo "<script> alert('Your location has been successfully updated.'); location.href='../htmls/home.php'; </script>";
                            }
                        }
                    }
                }
            }

            else
                echo "<script> alert('No changes detected.'); location.href='../htmls/edit_profile.php' </script>";
        }
    }


?>
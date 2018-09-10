<?php
session_start();

if (isset($_SESSION['temp_uid']) && isset($_SESSION['temp_user'])) {
    $uid = $_SESSION['temp_uid'];
    $user = $_SESSION['temp_user'];
}
else
    echo "<script> alert('TEMP session vars not set... Please log in or register to access account details.'); location.href='../index.php' </script>";

if (isset($_POST['submit'])) {

    include "../config/check_con.php";
    include "../maps/find_area.php";

    $gender = $_POST['gender'];
    $pref = $_POST['preference'];
    $bio = htmlspecialchars($_POST['bio']);
    $age = htmlspecialchars($_POST['age']);
    $tag1 = $_POST['tag1'];
    $tag2 = $_POST['tag2'];
    $tag3 = $_POST['tag3'];
    $tag4 = $_POST['tag4'];
    $tag5 = $_POST['tag5'];

    if (isset($_POST['lat']) && isset($_POST['long'])) {
        $lat = $_POST['lat'];
        $long = $_POST['long'];
    } else
        echo "<script> alert('Latitude or longitude empty... first'); </script>";

    if ($gender && $pref && $bio) {

        if (!preg_match("/(?=.*\d).{2}/", $age)) {
            echo "<script>alert('Please match pattern for age.'); location.href='../htmls/my_profile.php'; </script>";
        } else {

            $stmt = $con->prepare("SELECT uid FROM profile WHERE uid = :uid");
            $stmt->execute(['uid' => $uid]);
            if ($stmt->rowCount()) {
                echo "<script> alert('Your profile already exists, please select update to edit information.'); location.href='../htmls/edit_profile.php' </script>";
            } else {
                $stmt = $con->prepare("INSERT INTO profile (uid, user_name, gender, sexual_pref, 
    biography, age) VALUES (:uid, :users, :gender, :pref, :bio, :age)");
                $stmt->execute(['uid' => $uid, 'users' => $user, 'gender' => $gender, 'pref' => $pref,
                    'bio' => $bio, 'age' => $age]);
                if ($stmt->rowCount()) {

                    $_SESSION['uid'] = $uid;
                    $_SESSION['user'] = $user;
                    unset($_SESSION['temp_user']);
                    unset($_SESSION['temp_uid']);

                    if (strcmp($tag1, "") != 0) {
                        $stmt = $con->prepare("UPDATE `profile` SET `tag1`= :tag WHERE `uid` = :uid");
                        $stmt->execute(['tag' => $tag1, 'uid' => $uid]);
                        if ($stmt->rowCount()) {
//                        echo "<script> alert('Your Tag1 has been successfully updated.'); location.href='../htmls/images.php'; </script>";
                        } else
                            echo "<script> alert('Unable to insert into DB.'); location.href='../htmls/my_profile.php';</script>";
                    }
                    if (strcmp($tag2, "") != 0) {
                        $stmt = $con->prepare("UPDATE `profile` SET `tag2`= :tag WHERE `uid` = :uid");
                        $stmt->execute(['tag' => $tag2, 'uid' => $uid]);
                        if ($stmt->rowCount()) {
//                        echo "<script> alert('Your Tag2 has been successfully updated.'); location.href='../htmls/images.php'; </script>";
                        } else
                            echo "<script> alert('Unable to insert into DB.'); location.href='../htmls/my_profile.php';</script>";
                    }
                    if (strcmp($tag3, "") != 0) {
                        $stmt = $con->prepare("UPDATE `profile` SET `tag3`= :tag WHERE `uid` = :uid");
                        $stmt->execute(['tag' => $tag3, 'uid' => $uid]);
                        if ($stmt->rowCount()) {
//                        echo "<script> alert('Your Tag 3 has been successfully updated.'); location.href='../htmls/images.php'; </script>";
                        } else
                            echo "<script> alert('Unable to insert into DB.'); location.href='../htmls/my_profile.php';</script>";
                    }
                    if (strcmp($tag4, "") != 0) {
                        $stmt = $con->prepare("UPDATE `profile` SET `tag4`= :tag WHERE `uid` = :uid");
                        $stmt->execute(['tag' => $tag4, 'uid' => $uid]);
                        if ($stmt->rowCount()) {
//                        echo "<script> alert('Your Tag 4 has been successfully updated.'); location.href='../htmls/images.php'; </script>";
                        } else
                            echo "<script> alert('Unable to insert into DB.'); location.href='../htmls/my_profile.php';</script>";
                    }
                    if (strcmp($tag5, "") != 0) {
                        $stmt = $con->prepare("UPDATE `profile` SET `tag5`= :tag WHERE `uid` = :uid");
                        $stmt->execute(['tag' => $tag5, 'uid' => $uid]);
                        if ($stmt->rowCount()) {
//                        echo "<script> alert('Your Tag 5 has been successfully updated.'); location.href='../htmls/images.php'; </script>";
                        } else
                            echo "<script> alert('Unable to insert into DB.'); location.href='../htmls/my_profile.php';</script>";
                    }

                    if (!empty($lat) && !empty($long)) {
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
                                        $online = "online";
                                        $stmt = $con->prepare("UPDATE profile SET last_seen= :online WHERE uid= :uid");
                                        $stmt->execute(['online' => $online, 'uid' => $uid]);
                                        if ($stmt->rowCount()) {
                                            echo "<script> alert('All your information have been successfully saved.'); location.href='../htmls/images.php'; </script>";
                                        } else
                                            echo "<script> alert('All your information have been successfully saved, but could not set last_seen.'); location.href='../htmls/images.php'; </script>";
                                    }
                                }

                            }

                        } else
                            echo "<script> alert('no area found.'); location.href='../htmls/edit_profile.php'; </script>";
                    } else
                        echo "<script> alert('lat or long empty... two'); location.href='../htmls/edit_profile.php'; </script>";

                    if (isset($_POST['address'])) {
                        $address = $_POST['address'];
                        $prepAddr = str_replace(' ', '+', $address);

                        $lat_long = ft_latt_long($prepAddr);

                        $lat = $lat_long[0];
                        $long = $lat_long[1];

                        if (!$lat || !$long) {
                            echo "<script> alert('Latitude or longitude empty...');  location.href='../htmls/edit_profile.php'; </script>";
                        } else {

                            $area = ft_find_area($lat, $long);
                        }
                        if ((strcmp($lat, "") == 0 && strcmp($long, "") == 0) || ($lat == '0' && $long == 0)) {
                            echo "<script> alert('Latitude or longitude empty...'); location.href='../htmls/edit_profile.php'; </script>";
                        } else {
                            $stmt = $con->prepare("INSERT INTO location (uid, lattitude, longitude, area) 
                                  VALUES ('$uid', '$lat', '$long', '$area')");
                            $stmt->execute();
                        }
                    } elseif ((strcmp($lat, "") == 0 && strcmp($long, "") == 0) || ($lat == '0' && $long == 0)) {
                        echo "<script> alert('Latitude or longitude empty...'); </script>";
                    } else {

                        $area = ft_find_area($lat, $long);

                        $stmt = $con->prepare("INSERT INTO location (uid, lattitude, longitude)
                                      VALUES ('$uid', '$lat', '$long')");
                        $stmt->execute();
                        if (!$stmt->rowCount()) {
                            echo "<script> alert('Unable to save location...'); location.href='../htmls/my_profile.php'; </script>";
                        } elseif (!empty($area)) {

                            $stmt = $con->prepare("UPDATE profile SET area= :area WHERE uid= :uid");
                            $stmt->execute(['area' => $area, 'uid' => $uid]);
                            if ($stmt->rowCount()) {


                                $online = "online";
                                $stmt = $con->prepare("UPDATE profile SET last_seen= :online WHERE uid= :uid");
                                $stmt->execute(['online' => $online, 'uid' => $uid]);
                                if ($stmt->rowCount()) {
                                    echo "<script> alert('All your information have been successfully saved.'); location.href='../htmls/images.php'; </script>";
                                } else
                                    echo "<script> alert('All your information have been successfully saved, but could not set last_seen.'); location.href='../htmls/images.php'; </script>";
                            }
                        } else {

                            $online = "online";
                            $stmt = $con->prepare("UPDATE profile SET last_seen= :online WHERE uid= :uid");
                            $stmt->execute(['online' => $online, 'uid' => $uid]);
                            if ($stmt->rowCount()) {
                                echo "<script> alert('Your location saved, could not determine area...'); location.href='../htmls/images.php'; </script>";
                            } else {
                                echo "<script> alert('Your location saved, but could not set last_seen...'); location.href='../htmls/images.php'; </script>";
                            }
                        }//closes an else statement
                    }//closes an else statement
                } else
                    echo "<script> alert('Your profile has been successfully saved.'); location.href='../htmls/images.php'; </script>";
            }
        }
    }else
        echo "<script> alert('Gender, Preference or Bio is empty.'); location.href='../htmls/my_profile.php';</script>";
}
?>
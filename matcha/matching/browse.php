<?php

function ft_display($uid)
{

    include "../config/check_con.php";

    /** @var TYPE_NAME $con */

    //find all my info
    $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :uid");
    $stmt->execute(['uid' => $uid]);
    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {

            $pref = $row['sexual_pref'];
            $age = $row['age'];
            $tag1 = $row['tag1'];
            $tag2 = $row['tag2'];
            $tag3 = $row['tag3'];
            $tag4 = $row['tag4'];
            $tag5 = $row['tag5'];
        }

        if (strcmp($pref, "Male and Female") == 0) {
            $pref1 = "Male";
            $pref2 = "Female";
        } else {
            $pref1 = $pref;
            $pref2 = $pref;
        }
    } else
        echo "<script> alert('User does not exist. Please register or complete profile'); location.href='../htmls/login.php'; </script>";

    $stmt = $con->prepare("SELECT * FROM location WHERE uid = :uid");
    $stmt->execute(['uid' => $uid]);
    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $lat1 = $row['lattitude'];
            $long1 = $row['longitude'];
        }
        if ($lat1 == 0 || $long1 == 0) {
            echo "<script> alert('No location, unable to find matches. Please update location information.'); location.href='../htmls/edit_profile.php' </script>";
        }
    } else
        echo "<script> alert('Location does not exist, please update location information to obtain matches.'); location.href='../htmls/edit_profile.php' </script>";

    $stmt = $con->prepare("SELECT * FROM location");
    $stmt->execute();

    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $user = $row['uid'];
            $lat2 = $row['lattitude'];
            $long2 = $row['longitude'];
        }

        if ($lat2 != '0' && $lat2 != '0') {
            $distance = ft_distance($lat1, $long1, $lat2, $long2);
            if ($distance) {

                $stmt = $con->prepare("UPDATE profile SET distance= :distance WHERE uid=:userP");
                $stmt->execute(['distance' => $distance, 'userP' => $user]);
                if ($stmt->rowCount()) {
                    echo "<script> alert('Distance set.'); </script>";
                }
            }
        }
    }

    $stmt = $con->prepare("SELECT * FROM profile WHERE gender = :pref1 OR gender = :pref2 AND
                  tag1= :tag1 OR tag1= :tag2 OR tag1 = :tag3 OR tag1 = :tag4 OR tag1= :tag5 OR 
                  tag2= :tag1 OR tag2= :tag2 OR tag2 = :tag3 OR tag2 = :tag4 OR tag2= :tag5 OR
                  tag3= :tag1 OR tag3= :tag2 OR tag3 = :tag3 OR tag3 = :tag4 OR tag3= :tag5 OR
                  tag4= :tag1 OR tag4= :tag2 OR tag4 = :tag3 OR tag4 = :tag4 OR tag4= :tag5 OR
                  tag5= :tag1 OR tag5= :tag2 OR tag5 = :tag3 OR tag5 = :tag4 OR tag5= :tag5 ORDER BY distance ASC");
    $stmt->execute(['pref1' => $pref1, 'pref2' => $pref2, 'tag1' => $tag1, 'tag2' => $tag2, 'tag3' => $tag3,
        'tag4' => $tag4, 'tag5' => $tag5]);
    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            if (strcmp($row['uid'], $uid) != 0) {
                $user = $row['uid'];
                $user_name = $row['user_name'];
                $profile_pic = $row['profile_pic'];
                $fame_rate = $row['fame_rate'];
                $flag = $row['flag'];
                $dist = $row['distance'];

                $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :uid AND liked= :userP");
                $stmt->execute(['uid' => $uid, 'userP' => $user]);
                if (!$stmt->rowCount()) {

                    $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :uid AND blocked= :userP");
                    $stmt->execute(['uid' => $uid, 'userP' => $user]);
                    if (!$stmt->rowCount()) {

                        echo "
            <div class='box'>
            
            <h2>" . $user_name . "</h2>
            <h3 style='color:black;'>" . $flag . "</h3>
            <h3> Fame Rating! " . $fame_rate . "%</h3>
            <img height='auto' width='200' src='" . $profile_pic . "' name='" . $user . "' />
            <p>Age: $age</p>
            <p> This is distance: $dist</p>
            <a href='../htmls/view_profile.php?uid=$user' style='float:left; color:white;'>View</a></div>
                ";
                    }
                }
            }
        }
    }
    else
        echo "<script> alert('Unable to find any matches.'); location.href='../htmls/home.php' </script>";
}


function ft_filter($uid, $cat)
{

    include "../config/check_con.php";
    /** @var TYPE_NAME $con */
    $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :uid");
    $stmt->execute(['uid' => $uid]);
    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {

            $ret = $row[$cat];
        }

        $stmt = $con->prepare("SELECT * FROM profile WHERE $cat= :ret");
        $stmt->execute(['ret' => $ret]);
        if ($stmt->rowCount()) {
            $result = $stmt->fetchAll();

            foreach ($result as $row) {
                $userP = $row['uid'];
                $user_name = $row['user_name'];
                $return = $row[$cat];

                if ($uid != $userP) {


                    echo "<p> this is results: $userP, $user_name for search: $return </p>";
                } else
                    echo "<script> alert('No matches found.') </script>";

            }
        }
    }
}

function ft_tags($uid)
{

    include "../config/check_con.php";
    /** @var TYPE_NAME $con */

//    $tag = "#sarcasm";

    $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :uid");
    $stmt->execute(['uid' => $uid]);
    if ($stmt->rowCount()) {

        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $tag = $row['tag1'];
        }

        $stmt = $con->prepare("SELECT * FROM profile WHERE CONCAT_WS('|',`tag1`,`tag2`,`tag3`,`tag4`,`tag5`) 
                            LIKE '%$tag%'");
        $stmt->execute();
        if ($stmt->rowCount()) {

            $result = $stmt->fetchAll();


            foreach ($result as $row) {

                $userP = $row['uid'];
//                ft_filter_tags($uid, $userP);
                $order = "tag1";
                $upDown = " ASC";
                 ft_display_matches($uid, $order, $upDown);
                echo "<br><br><span></span><p>user name" . $row['user_name'] . "</p>" .
                    "<p>tag 1" . $row['tag1'] . "</p>" .
                    "<p>tag 2" . $row['tag2'] . "</p>" .
                    "<p>tag 3" . $row['tag3'] . "</p>" .
                    "<p>tag 4" . $row['tag4'] . "</p>" .
                    "<p>tag 5" . $row['tag5'] . "</p> </span>";

            }
        } else
            echo "<script> alert('Unable to find any matches.'); location.href='' </script>";
    } else
        echo "no such uid.";
}

function ft_filter_tags($uid, $userP)
{

    include "../config/check_con.php";
    /** @var TYPE_NAME $con */
    $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :uid");
    $stmt->execute(['uid' => $uid]);
    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {

            $ret = $row['tag1'];
        }

        $stmt = $con->prepare("SELECT * FROM profile WHERE tag1= :ret");
        $stmt->execute(['ret' => $ret]);
        if ($stmt->rowCount()) {
            $result = $stmt->fetchAll();

            foreach ($result as $row) {
                $userP = $row['uid'];
                $user_name = $row['user_name'];
                $return = $row['tag1'];

                if ($uid != $userP) {


                    echo "<p> this is results: $userP, $user_name for search: $return </p>";
                }
//                else
//                    echo "<script> alert('No matches found.') </script>";

            }
        }
    }
}

?>
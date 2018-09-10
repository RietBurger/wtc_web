<?php

function find_and_save_arr($uid, $order, $filter)
{

    include "../config/check_con.php";

    $stmt = $con->prepare("UPDATE profile SET matched= '0'");
    $stmt->execute();

    $uid_arr1 = ft_match_gender($uid);

    if (!$uid_arr1) {
        echo "<script>alert('No matches found...'); location.href='../htmls/home.php' </script>";
    } else {

        ft_find_distance($uid);

        $uid_arr2 = array();

        $stmt = $con->prepare("SELECT * FROM profile WHERE distance <= '50' AND distance >= '-50'");
        $stmt->execute();
        if ($stmt->rowCount()) {

            $dist_arr = $stmt->fetchAll();
            foreach ($dist_arr as $row) {
                $userP = $row['uid'];

                if (in_array($userP, $uid_arr1)) {

                    $stmt = $con->prepare("UPDATE profile SET matched = matched + '1' WHERE uid= :userP");
                    $stmt->execute(['userP' => $userP]);

                    $uid_arr2[] = $userP;
                }
            }
        }

        if (!empty($uid_arr2)) {

            $tag = "tag1";
            ft_find_each_tag($uid, $uid_arr2, $tag);
            $tag = "tag2";
            ft_find_each_tag($uid, $uid_arr2, $tag);
            $tag = "tag3";
            ft_find_each_tag($uid, $uid_arr2, $tag);
            $tag = "tag4";
            ft_find_each_tag($uid, $uid_arr2, $tag);
            $tag = "tag5";
            ft_find_each_tag($uid, $uid_arr2, $tag);

            if (strcmp($filter, "none") == 0) {

                ft_show_new_matches($uid, $uid_arr2, $order);
            } else {
                ft_show_filtered_matches($uid, $uid_arr2, $filter);
            }
            echo "<br><br>";
        }
    }
}

function ft_match_gender($uid)
{
    include "../config/check_con.php";

    $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :uid");
    $stmt->execute(['uid' => $uid]);

    if ($stmt->rowCount()) {

        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $pref = $row['sexual_pref'];
            $gender = "%" .$row['gender'] . "%";
        }

        if (strcmp($pref, "Male and Female") == 0) {
            $pref1 = "Male";
            $pref2 = "Female";
        } else {
            $pref1 = $pref;
            $pref2 = $pref;
        }

        $stmt = $con->prepare("SELECT * FROM profile WHERE (gender= :pref1 OR gender= :pref2) AND sexual_pref LIKE :gender");
        $stmt->execute(['pref1' => $pref1, 'pref2' => $pref2, 'gender' => $gender]);
        if ($stmt->rowCount()) {

            $gender_match = $stmt->fetchAll();

            $uid_arr1 = array();

            foreach ($gender_match as $row) {
                $uid_arr1[] = $row['uid'];
            }
            return ($uid_arr1);
        } else
            echo "<script> alert('No matches found.'); location.href='../htmls/home.php'</script>";
        
    }
}

function ft_find_each_tag($uid, $uid_arr1, $var)
{

    include "../config/check_con.php";

    $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :uid");
    $stmt->execute(['uid' => $uid]);

    if ($stmt->rowCount()) {

        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $tag1 = $row['tag1'];
            $tag2 = $row['tag2'];
            $tag3 = $row['tag3'];
            $tag4 = $row['tag4'];
            $tag5 = $row['tag5'];
        }

        $stmt = $con->prepare("SELECT * FROM profile WHERE 
              $var= :tag1 OR $var= :tag2 OR $var = :tag3 OR $var = :tag4 OR $var= :tag5");
        $stmt->execute(['tag1' => $tag1, 'tag2' => $tag2, 'tag3' => $tag3,
            'tag4' => $tag4, 'tag5' => $tag5]);
        if ($stmt->rowCount()) {
            $result = $stmt->fetchAll();
            foreach ($result as $row) {
                $userP2 = $row['uid'];
                if (in_array($userP2, $uid_arr1)) {

                    $stmt = $con->prepare("UPDATE profile SET matched = matched + '1' WHERE uid= :userP");
                    $stmt->execute(['userP' => $userP2]);
                }
            }
        }
    }
}

function ft_show_new_matches($uid, $uid_arr1, $order)
{

    include "../config/check_con.php";

    $uid_arr2 = array();

    foreach ($uid_arr1 as $row) {
        $uid_arr2[] = $row;
    }

    if (strcmp($order, "fame_rate") == 0) {
        $upDown = "DESC";
    }
    else
        $upDown = "ASC";

    if (strcmp($order, "tag1") == 0) {

            ft_order_by_tag($uid, $uid_arr2);
            $order = "tagged";
            $upDown = "DESC";
    }

    $stmt = $con->prepare("SELECT * FROM profile ORDER BY $order $upDown");
    $stmt->execute();
    if ($stmt->rowCount()) {

        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            if (strcmp($row['uid'], $uid) != 0) {

                if (in_array($row['uid'], $uid_arr2)) {

                    $user = $row['uid'];
                    $user_name = $row['user_name'];
                    $profile_pic = $row['profile_pic'];
                    $fame_rate = $row['fame_rate'];
                    $flag = $row['flag'];
                    $dist = $row['distance'];
                    $age = $row['age'];
                    $age_gap = $row['age_gap'];
                    $fame_gap = $row['fame_gap'];
                    $area = $row['area'];

                    $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :uid AND liked= :userP");
                    $stmt->execute(['uid' => $uid, 'userP' => $user]);
                    if (!$stmt->rowCount()) {

                        $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :uid AND blocked= :userP");
                        $stmt->execute(['uid' => $uid, 'userP' => $user]);
                        if (!$stmt->rowCount()) {

                            $_SESSION['uid_arr'] = $uid_arr2;

                            echo "

        <div class='col-xs-6 col-md-3 item'>
            <div class='thumbnail'>
            <img height='auto' width='200' src='" . $profile_pic . "' name='" . $user . "' />
            <div class='caption'>
            <h3>" . $user_name . "</h3>
            <h5 style='color:black;'>" . $flag . "</h5>
            <h4> Fame Rating! " . $fame_rate . "%</h4>
            <p> This is distance: $dist</p>
            <p>This is age: $age</p>
            <p>This is age_gap: $age_gap</p>
            <p>This is fame_gap: $fame_gap</p>
            <p>This is area: $area</p>
            <p><a href='../htmls/view_profile.php?uid=$user' class='btn btn-primary' role='button' onclick='goForward();'>View</a></p>
            </div></div></div>
                ";
                        }
                    }

                }
            }
        }
    } else
        echo "<script> alert('Unable to find any matches.'); location.href='../htmls/home.php' </script>";
}

function ft_order_by_tag($uid, $uid_arr)
{

    include "../config/check_con.php";

    $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :uid");
    $stmt->execute(['uid' => $uid]);

    if ($stmt->rowCount()) {

        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $tag = $row['tag1'];
        }

        $stmt = $con->prepare("SELECT * FROM profile WHERE 
              tag1= :tag OR tag2= :tag OR tag3= :tag OR tag4= :tag OR tag5= :tag");
        $stmt->execute(['tag' => $tag]);
        if ($stmt->rowCount()) {
            $result = $stmt->fetchAll();
            foreach ($result as $row) {
                $userP = $row['uid'];

                if (in_array($userP, $uid_arr)) {

                    $stmt = $con->prepare("UPDATE profile SET tagged = tagged + '1' WHERE uid= :userP");
                    $stmt->execute(['userP' => $userP]);
                }
            }
        }
    }
}

function ft_show_filtered_matches($uid, $uid_arr1, $filter)
{

    include "../config/check_con.php";

    $uid_arr2 = array();

    foreach ($uid_arr1 as $row) {
        $uid_arr2[] = $row;
    }

    $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :uid");
    $stmt->execute(['uid' => $uid]);
    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $var = $row[$filter];

        }
    }

    $stmt = $con->prepare("SELECT * FROM profile WHERE $filter= :var");
    $stmt->execute(['var' => $var]);
    if ($stmt->rowCount()) {

        $result = $stmt->fetchAll();
        foreach ($result as $row) {

            $userP = $row['uid'];

            if ($userP != $uid) {
                if (in_array($row['uid'], $uid_arr2)) {

                    $user = $row['uid'];
                    $user_name = $row['user_name'];
                    $profile_pic = $row['profile_pic'];
                    $fame_rate = $row['fame_rate'];
                    $flag = $row['flag'];
                    $dist = $row['distance'];
                    $age = $row['age'];
                    $age_gap = $row['age_gap'];
                    $fame_gap = $row['fame_gap'];
                    $area = $row['area'];

                    $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :uid AND liked= :userP");
                    $stmt->execute(['uid' => $uid, 'userP' => $user]);
                    if (!$stmt->rowCount()) {

                        $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :uid AND blocked= :userP");
                        $stmt->execute(['uid' => $uid, 'userP' => $user]);
                        if (!$stmt->rowCount()) {


                            echo "

        <div class='col-xs-6 col-md-3 item'>
            <div class='thumbnail'>
            <img height='auto' width='200' height='200' src='" . $profile_pic . "' name='" . $user . "' />
            <div class='caption'>
            <h3>" . $user_name . "</h3>
            <h5 style='color:black;'>" . $flag . "</h5>
            <h4> Fame Rating! " . $fame_rate . "%</h4>
            <p> This is distance: $dist</p>
            <p>This is age: $age</p>
            <p>This is age_gap: $age_gap</p>
            <p>This is fame_gap: $fame_gap</p>
            <p>This is area: $area</p>
            <p><a href='../htmls/view_profile.php?uid=$user' class='btn btn-primary' role='button' onclick='goForward();'>View</a></p>
            </div></div></div>
                ";
                        }
                    }

                }
            }
        }
    } else
        echo "<script> alert('Unable to find any matches.'); location.href='../htmls/home.php' </script>";
}

function ft_display_search_matches($uid, $uid_arr1)
{

    include "../config/check_con.php";

    foreach ($uid_arr1 as $var) {

        $stmt = $con->prepare("SELECT * FROM profile  WHERE uid= :var");
        $stmt->execute(['var' => $var]);
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
                    $age = $row['age'];
                    $area = $row['area'];
                    $age_gap = $row['age_gap'];
                    $fame_gap = $row['fame_gap'];


                    $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :uid AND liked= :userP");
                    $stmt->execute(['uid' => $uid, 'userP' => $user]);
                    if (!$stmt->rowCount()) {

                        $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :uid AND blocked= :userP");
                        $stmt->execute(['uid' => $uid, 'userP' => $user]);
                        if (!$stmt->rowCount()) {


                            echo "

        <div class='col-xs-3 col-md-6 item'>
            <div class='thumbnail'>
            <img height='auto' width='200' height='200' src='" . $profile_pic . "' name='" . $user . "' />
            <div class='caption'>
            <h3>" . $user_name . "</h3>
            <h5 style='color:black;'>" . $flag . "</h5>
            <h4> Fame Rating! " . $fame_rate . "%</h4>
            <p> This is distance: $dist</p>
            <p>This is age: $age</p>
            <p>This is age_gap: $age_gap</p>
            <p>This is fame_gap: $fame_gap</p>
            <p>This is area: $area</p>
            <p><a href='../htmls/view_profile.php?uid=$user' class='btn btn-primary' role='button' onclick='goForward();'>View</a></p>
            </div></div></div>
                ";
                        }
                    }

                }

            }
        } else
            echo "<script> alert('Unable to find any matches.'); location.href='../htmls/home.php' </script>";
    }
}

// FOR SEARCH.PHP SPECIFICALLY

function ft_search_matches($uid, $filter_arr)
{
    include "../config/check_con.php";
//    echo "<script> alert('this is filter in search matches $filter'); </script>";
//    $columns = array('age_gap', 'fame_gap',  'tag1', 'tag2', 'tag3', 'tag4', 'tag5');
//    echo "<p> This is columns array </p>";
//    print_r($columns);
    $stmt = $con->query("SELECT * FROM profile");
    $stmt->execute();
    foreach ($filter_arr as $filter) {
//        if (in_array($filter, $columns)) {
        if (strcmp($filter, "area") != 0) {
            $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :uid");
            $stmt->execute(['uid' => $uid]);
            if ($stmt->rowCount()) {
                $result = $stmt->fetchAll();
                foreach ($result as $row) {
                    $var = $row[$filter];
                }
                $stmt = $con->prepare("SELECT * FROM profile WHERE $filter= :var");
                $stmt->execute(['var' => $var]);
                if ($stmt->rowCount()) {
                    $result = $stmt->fetchAll();
                    $uid_arr2 = array();
                    foreach ($result as $row) {
                        if (strcmp($row['uid'], $uid) != 0) {
                            $uid_arr2[] = $row['uid'];
                        }
                    }
                    return ($uid_arr2);
                } else
                    echo "<script> alert('Unable to find any matches.'); </script>";
            }
        }
        else
            echo "no area column yet";
    }
}




function ft_find_all_tags($uid, $tag_arr, $uid_arr1) {

    include "../config/check_con.php";
//SELECT * FROM table1 WHERE (Name LIKE '%$keyword%' OR ZipCode LIKE '%$keyword%' OR '$keyword' = '')


    foreach ($tag_arr as $row) {

        $tag = $row;

        $stmt = $con->prepare("SELECT * FROM profile WHERE tag1= :tag OR tag2= :tag 
        OR tag3= :tag OR tag4= :tag OR tag5= :tag");
        $stmt->execute(['tag' => $tag]);

        $uid_arr = array();

        if ($stmt->rowCount()) {
            $result = $stmt->fetchAll();

            foreach ($result as $row) {
                if (strcmp($row['uid'], $uid) != 0) {
                    if (in_array($row['uid'], $uid_arr1)) {

                        $uid_arr[] = $row['uid'];
                        $uidS = $row['uid'];
                        $stmt = $con->prepare("UPDATE profile SET tagged= tagged + '1' WHERE uid= :uidS");
                        $stmt->execute(['uidS' => $uidS]);
                    }
                }
            }
        }
    }
    return ($uid_arr);
}

function ft_echo_all_tags() {

    include "../config/check_con.php";

    $stmt = $con->prepare("SELECT * FROM tags");
    $stmt->execute();
    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {

            echo "<div ><br>
                  <input type='checkbox' value='" . $row[1] . "' name='search[]'/> " . $row[1] . "<br></div>";
        }
    }
}

function ft_set_gaps($uid, $uid_arr) {

    include "../config/check_con.php";

    $uid_arr1 = array();
    $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :uid");
    $stmt->execute(['uid' => $uid]);
    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $age = $row['age'];
            $fame = $row['fame_rate'];


            foreach ($uid_arr as $userP) {

                $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :userP");
                $stmt->execute(['userP' => $userP]);
                if ($stmt->rowCount()) {
                    $result = $stmt->fetchAll();

                    foreach ($result as $row) {
                        $age2 = $row['age'];
                        $fame2 = $row['fame_rate'];

                        $age_gap = $age - $age2;
                        $fame_gap = $fame - $fame2;

                        $stmt = $con->prepare("UPDATE profile SET age_gap= :age_gap, fame_gap= :fame_gap WHERE uid= :userP");
                        $stmt->execute(['age_gap' => $age_gap, 'fame_gap' => $fame_gap, 'userP' => $userP]);
                        if ($stmt->rowCount()) {
                            $uid_arr1[] = $userP;
                        }

//                        $uid_arr1[] = $userP;
                    }
                }
            }
        }
    }
    $uid_arr2 = array();
    $stmt = $con->prepare("SELECT * FROM profile WHERE age_gap >= '-5' AND age_gap <= '5'");
    $stmt->execute();
    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $uid_arr2[] = $row['uid'];
        }
    }

    $stmt = $con->prepare("SELECT * FROM profile WHERE fame_gap >= '-50' AND age_gap <= '50'");
    $stmt->execute();
    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $uid_arr2[] = $row['uid'];
        }
    }

    return ($uid_arr2);
}

function ft_find_area($uid, $uid_arr) {

    include "../config/check_con.php";

    $uid_arr3 = array();

    $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :uid");
    $stmt->execute(['uid' =>$uid]);

    $result = $stmt->fetchAll();

    foreach ($result as $row) {
        $area = $row['area'];
    }

    if ($area) {
        foreach ($uid_arr as $userP) {

            $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :userP AND area= :area");
            $stmt->execute(['userP' => $userP, 'area' => $area]);
            if ($stmt->rowCount()) {

                $uid_arr3[] = $userP;
            }
        }
    }
    return ($uid_arr3);
}

function ft_set_zero() {

    include "../config/check_con.php";

    $stmt = $con->prepare("UPDATE profile SET distance= '0', matched= '0', age_gap= '0', fame_gap='0', tagged= '0'");
    $stmt->execute();
}


?>
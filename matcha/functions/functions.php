<?php

function find_uid($result) {
    include "../config/check_con.php";
    if ($result) {
        foreach ($result as $row) {
            $uid = $row['uid'];
           return ($uid);
        }
    } else
        echo "<script>alert('Unable to find uid.'); location.href='../index.php';</script>";
}

function ft_mail($user, $email, $url, $token) {

    $from = "self";
    $headers = "MIME-Version: 1.0\r\n" . "Content-Type: text/html; charset=ISO-8859-1\r\n" . "From:" . $from;
    $subject = "Matcha";
    $to = $email;
    $body = ' 
 <html>
    <head>
      <title>' . $subject . '</title>
    </head>
    <body>
      Hello ' . htmlspecialchars($user) . '! </br>
      Please click the link to complete action. </br>
      <a href="http:' . $url . '?token=' . $token . '&email=' . $email . '">Go to link</a>
    </body>
    
  </html>
  ';
    mail($to, $subject, $body, $headers);

    echo "<script> alert('Dear $user, A verification email has been sent to $email. Please verify before continuing.'); location.href='../index.php' </script>";
}

function ft_head() {
    echo '
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    
    <title>Matcha</title>
    <style>
    body {background-color: lightgreen}
</style>    
    ';
}

function ft_menu() {
    echo ' 
 

<div class="menu">
        <ul class="nav navbar-nav navbar-right">
            <li><a href="edit_profile.php">Edit profile</a> </li>
            <li><a href="change_details.php">Edit personal info</a></li>
            <li><a href="browse.php">Browse</a> </li>
            <li><a href="search.php">Search</a> </li>
            <li><a href="stats.php">My Stats</a> </li>
            <li><a href="chat.php">Chat</a> </li>
            <li><a href="../login/logout.php">Log out</a> </li>
        </ul>
    </div>
    </div>
    </nav>
</div>
<div class="container">
    ';
}

function ft_notification() {
    echo ' <div class="container">

    <nav class="navbar navbar-inverse">
        <div class="page-header" style="text-align: center; font-family: \'Apple Chancery\';">
            <h1 style="font-size: 50px; color: greenyellow">Someone Like Me</h1>
        </div>
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="home.php">' . $_SESSION['user']. ' </a>
            </div>

            <ul class="nav navbar-nav navbar-inverse">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"
                     style="border-radius: 10px"></span> <span class="glyphicon glyphicon-bell" style="font-size: 18px;" ></span> </a>
                    <ul class="dropdown-menu"></ul>
                </li>
            </ul>
    ';
}

function ft_display_tags()
{

    include "../config/check_con.php";

    /** @var TYPE_NAME $con */
    $stmt = $con->prepare("SELECT * FROM tags");
    $stmt->execute();
    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            echo '<option value="' . $row['tag'] . '">'. $row['tag'] .'</option>
        </br>    
    ';
        }
    }
}

function ft_save_img($image, $uid, $img_nr)
{
    include ("../config/check_con.php");

    $image = file_get_contents($image);
    $name = $uid . "_" . $img_nr;
    $dest_dir = "../images/" . $name . ".png";
    file_put_contents($dest_dir, $image);

    /** @var TYPE_NAME $con */
    $stmt = $con->prepare("UPDATE profile SET $img_nr = :img WHERE uid = :uid");
    $stmt->execute(['img' => $dest_dir, 'uid' => $uid]);
    if ($stmt->rowCount()) {
        echo "<script> alert('Image $img_nr uploaded.'); location.href='../htmls/edit_profile.php' </script>";
    }
    else
        echo "<script> alert('Image nr $img_nr saved in DB.'); location.href='../htmls/edit_profile.php' </script>";
}

function ft_display_img($uid) {
    include "../config/check_con.php";

    /** @var TYPE_NAME $con */
    $stmt = $con->prepare("SELECT * FROM profile WHERE uid = :uid");
    $stmt->execute(['uid' => $uid]);
    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            echo '<div class="col-xs-4 col-md-2 items">
<div class="thumbnail">
<img height="auto" width="200" src="' . $row['profile_pic'] . ' " onclick="myFunction(this);"/>
        </br></div></div>
        <div class="col-xs-4 col-md-2 items">
<div class="thumbnail">
<img height="auto" width="200" src="' . $row['img1'] . ' " onclick="myFunction(this);"/>
        </br></div></div>
               <div class="col-xs-4 col-md-2 items">
<div class="thumbnail">
<img height="auto" width="200" src="' . $row['img2'] . ' " onclick="myFunction(this);"/>
        </br></div></div>
               <div class="col-xs-4 col-md-2 items">
<div class="thumbnail">
<img height="auto" width="200" src="' . $row['img3'] . ' " onclick="myFunction(this);"/>
        </br></div></div>
               <div class="col-xs-4 col-md-2 items">
<div class="thumbnail">
<img height="auto" width="200" src="' . $row['img4'] . ' " onclick="myFunction(this);"/>
        </br></div></div>
        <br><br>
         ';
        }
    }
}

function ft_display_info($uid)
{
    include "../config/check_con.php";

    /** @var TYPE_NAME $con */
    $stmt = $con->prepare("SELECT * FROM profile WHERE uid = :uid");
    $stmt->execute(['uid' => $uid]);
    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $area = $row['area'];
            echo '
<p>Gender</p>
<pre> ' . $row['gender']. '</pre>
</br>
<p>Age</p>
<pre> ' . $row['age']. '</pre>
</br>
<p>Sexual Preference</p>
<pre>' . $row['sexual_pref']. '</pre>
</br>
<p>Biography</p>
<pre>' . $row['biography']. '</pre>
</br>
<p>#Tags</p>
<pre> ' . $row['tag1']. '</pre>
<pre> ' . $row['tag2']. '</pre>
<pre> ' . $row['tag3']. '</pre>
<pre> ' . $row['tag4']. '</pre>
<pre> ' . $row['tag5']. '</pre>

        </br>
        ';
        }
        $stmt = $con->prepare("SELECT * FROM location WHERE uid= :uid");
        $stmt->execute(['uid' => $uid]);
        if ($stmt->rowCount()) {
            $result = $stmt->fetchAll();

            foreach ($result as $row) {
                $lat = $row['lattitude'];
                $long = $row['longitude'];
            }

                echo '  <p>Area</p>
<pre> ' . $area. '</pre> </br>
 <p>Lattitude</p>
<pre> ' . $lat. '</pre> </br>
<p>Longitude</p>
<pre>' . $long . '</pre> <br>
</br>
                ';
            }
        }
}

function ft_display_info_form($uid)
{
include "../config/check_con.php";

    /** @var TYPE_NAME $con */
    $stmt = $con->prepare("SELECT * FROM profile WHERE uid = :uid");
    $stmt->execute(['uid' => $uid]);
    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            echo '<div>
<pre><b>' . $row['flag'] . '</b></pre>
</br>
<p>User name</p>
<pre>' . $row['user_name'] . '</pre>
</br>
<p>Fame Rating</p>
<pre>' . $row['fame_rate'] . '%</pre>
</br>
<p>Gender</p>
<pre> ' . $row['gender']. '</pre>
</br>
<p>Age</p>
<pre> ' . $row['age']. '</pre>
</br>
<p>Biography</p>
<pre> ' . $row['biography']. '</pre>
</br>
<p>#Tags</p>
<pre> ' . $row['tag1']. '</pre>
<pre> ' . $row['tag2']. '</pre>
<pre> ' . $row['tag3']. '</pre>
<pre> ' . $row['tag4']. '</pre>
<pre> ' . $row['tag5']. '</pre>

        </br></div>
        ';
        }
    }
}

function ft_distance($lat1, $long1, $lat2, $long2) {
    $theta = $long1 - $long2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $km = $dist * 60 * 1.1515 * 1.609344;
//    $miles = $dist * 60 * 1.1515;
//    $km = $miles * 1.609344;
    return ($km);
}

function ft_display_matches($uid, $order, $upDown) {

    include "../config/check_con.php";

    /** @var TYPE_NAME $con */

    //find all my info
    $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :uid");
    $stmt->execute(['uid' => $uid]);
    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {

            $pref = $row['sexual_pref'];
            $tag1 = $row['tag1'];
            $tag2 = $row['tag2'];
            $tag3 = $row['tag3'];
            $tag4 = $row['tag4'];
            $tag5 = $row['tag5'];
        }

        if (strcmp($pref, "Male and Female") == 0) {
            $pref1 = "Male";
            $pref2 = "Female";
        }
        else {
            $pref1 = $pref;
            $pref2 = $pref;
        }
    }
    else
        echo "<script> alert('User does not exist. Please register or complete profile'); location.href='../htmls/login.php'; </script>";

    ft_find_distance($uid);

    $stmt = $con->prepare("SELECT * FROM profile WHERE gender = :pref1 OR gender = :pref2 AND
                  tag1= :tag1 OR tag1= :tag2 OR tag1 = :tag3 OR tag1 = :tag4 OR tag1= :tag5 OR 
                  tag2= :tag1 OR tag2= :tag2 OR tag2 = :tag3 OR tag2 = :tag4 OR tag2= :tag5 OR
                  tag3= :tag1 OR tag3= :tag2 OR tag3 = :tag3 OR tag3 = :tag4 OR tag3= :tag5 OR
                  tag4= :tag1 OR tag4= :tag2 OR tag4 = :tag3 OR tag4 = :tag4 OR tag4= :tag5 OR
                  tag5= :tag1 OR tag5= :tag2 OR tag5 = :tag3 OR tag5 = :tag4 OR tag5= :tag5 ORDER BY ".$order . " " .$upDown);
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

function ft_i_liked($uid) {

    include "../config/check_con.php";

    /** @var TYPE_NAME $con */
    $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :uid AND blocked= '0' AND unliked= '0'");
    $stmt->execute(['uid' => $uid]);

    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $userP = $row['liked'];

            $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :userP");
            $stmt->execute(['userP' => $userP]);

            if ($stmt->rowCount()) {

                $result = $stmt->fetchAll();

                foreach ($result as $row) {
                    $user_name = $row['user_name'];

                   echo "<li><a href='../htmls/view_profile.php?uid=". $userP ."' >$user_name</a></li> ";
                }
            }
        }
    }
}

function ft_liked_by($uid) {

    include "../config/check_con.php";

    /** @var TYPE_NAME $con */
    $stmt = $con->prepare("SELECT * FROM liked WHERE liked= :uid");
    $stmt->execute(['uid' => $uid]);

    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $userP = $row['uid'];

            $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :uid AND blocked= :userP");
            $stmt->execute(['uid' => $uid, 'userP' => $userP]);
            if (!$stmt->rowCount()) {

                $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :userP");
                $stmt->execute(['userP' => $userP]);

                if ($stmt->rowCount()) {

                    $result = $stmt->fetchAll();

                    foreach ($result as $row) {
                        $user_name = $row['user_name'];

                        echo "<li><a href='../htmls/view_profile.php?uid=" . $userP . "' >$user_name</a></li> ";
                    }
                }
            }
        }
    }
}

function ft_looked_at($uid) {

    include "../config/check_con.php";

    /** @var TYPE_NAME $con */
    $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :uid AND blocked= '0' AND unliked= '0'");
    $stmt->execute(['uid' => $uid]);

    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $userP = $row['looked'];

            $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :userP");
            $stmt->execute(['userP' => $userP]);

            if ($stmt->rowCount()) {

                $result = $stmt->fetchAll();

                foreach ($result as $row) {
                    $user_name = $row['user_name'];

                    echo "<li><a href='../htmls/view_profile.php?uid=". $userP ."' >$user_name</a></li> ";
                }
            }
        }
    }
}

function ft_looked_by($uid) {

    include "../config/check_con.php";

    /** @var TYPE_NAME $con */
    $stmt = $con->prepare("SELECT * FROM liked WHERE looked= :uid AND blocked= '0' AND unliked= '0'");
    $stmt->execute(['uid' => $uid]);

    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $userP = $row['uid'];

            $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :uid AND blocked= :userP");
            $stmt->execute(['uid' => $uid, 'userP' => $userP]);
            if (!$stmt->rowCount()) {

                $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :userP");
                $stmt->execute(['userP' => $userP]);

                if ($stmt->rowCount()) {

                    $result = $stmt->fetchAll();

                    foreach ($result as $row) {
                        $user_name = $row['user_name'];

                        echo "<li><a href='../htmls/view_profile.php?uid=" . $userP . "' >$user_name</a></li> ";
                    }
                }
            }
        }
    }
}

function ft_connected($uid) {

    include "../config/check_con.php";

    /** @var TYPE_NAME $con */
    $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :uid ");
    $stmt->execute(['uid' => $uid]);

    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $userP = $row['liked'];

            $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :userP");
            $stmt->execute(['userP' => $userP]);

            if ($stmt->rowCount()) {

                $result = $stmt->fetchAll();

                foreach ($result as $row) {
                    $user_name = $row['user_name'];
                }

                $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :userP AND liked= :uid AND blocked= '0' AND unliked= '0'");
                $stmt->execute(['userP' => $userP, 'uid' => $uid]);
                if ($stmt->rowCount()) {

                    echo "<li><a href='../htmls/view_profile.php?uid=" . $userP . "' >$user_name</a></li>";
                }
            }
        }
    }
}

function ft_blocked($uid) {

    include "../config/check_con.php";
    /** @var TYPE_NAME $con */

    $stmt = $con->prepare("SELECT * FROM liked WHERE blocked= :uid");
    $stmt->execute(['uid' => $uid]);

    $result = $stmt->fetchAll();

    if ($result) {

        foreach ($result as $row) {
            $userP = $row['uid'];

            echo "<p>you have been blocked by user id: " . $userP . "</p>";
        }
    }else
        echo "<p>you have not been blocked by anyone</p>";
}

function ft_i_blocked($uid) {

    include "../config/check_con.php";
    /** @var TYPE_NAME $con */

    $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :uid AND blocked > '0' ");
    $stmt->execute(['uid' => $uid]);

    $result = $stmt->fetchAll();

    if ($result) {

        foreach ($result as $row) {
            $userP = $row['blocked'];

            echo "<p>you haveblocked user id: " . $userP . "</p>";
        }
    }else
        echo "<p>you have not blocked anyone</p>";

}

function ft_rating($uid)
{

    include "../config/check_con.php";
    /** @var TYPE_NAME $con */

    $stmt = $con->prepare("SELECT * FROM liked WHERE looked= :uid");
    $stmt->execute(['uid' => $uid]);

    if ($stmt->rowCount()) {
        $looked = $stmt->rowCount();

        $stmt = $con->prepare("SELECT * FROM liked WHERE liked= :uid");
        $stmt->execute(['uid' => $uid]);

        if ($stmt->rowCount()) {
            $liked = $stmt->rowCount();
            $rate = ($liked / $looked) * 100;
            $rate = explode('.', $rate);
            echo "<li>You have been liked $liked times</li>
                    <br><li>Your profile has been viewed $looked times</li>
                    <br><li>Your fame rating is $rate[0]% </li>";
        }
    }
}

function ft_get_rating($uid)
{

    include "../config/check_con.php";
    /** @var TYPE_NAME $con */

    $stmt = $con->prepare("SELECT * FROM liked WHERE looked= :uid");
    $stmt->execute(['uid' => $uid]);

    if ($stmt->rowCount()) {
        $looked = $stmt->rowCount();

        $stmt = $con->prepare("SELECT * FROM liked WHERE liked= :uid");
        $stmt->execute(['uid' => $uid]);

        if ($stmt->rowCount()) {
            $liked = $stmt->rowCount();
            $rate = ($liked / $looked) * 100;
            $rate = explode('.', $rate);
            $rate_use = $rate[0];

            $stmt = $con->prepare("UPDATE profile SET fame_rate= :rate WHERE uid= :uid");
            $stmt->execute(['rate' => $rate_use, 'uid' => $uid]);
            if (!$stmt->rowCount()) {
                echo "<script> alert('Fame_rate up to date.'); location.href='../htmls/browse.php' </script>";
            }
        }
//        else
//            echo "<script> alert('could not find in user in liked table liked.'); location.href='../htmls/browse.php' </script>";
    } else
        echo "<script> alert('could not find in user in liked table looked.'); location.href='../htmls/browse.php' </script>";
}

function ft_chats($uid) {
    include "../config/check_con.php";
    /** @var TYPE_NAME $con */
    $stmt = $con->prepare("SELECT * FROM connected WHERE uid1= :uid OR uid2= :uid");
    $stmt->execute(['uid' => $uid]);
    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {

            $chat_id = $row['cid'];

            if ($row['uid1'] == $uid) {
              $userP = $row['uid2'];
        }
        elseif ($row['uid2'] == $uid) {
                $userP = $row['uid1'];
        }
            $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :userP");
            $stmt->execute(['userP' => $userP]);
            if ($stmt->rowCount()) {
                $result = $stmt->fetchAll();
                foreach ($result as $row) {
                    $user_name = $row['user_name'];
                    $last_seen = $row['last_seen'];
                }
                echo "<li><a href='../htmls/chat.php?cid=" . $chat_id . "' >$user_name</a></li>
                    <p>Last Seen: " .$last_seen. "</p>";
            } else
                echo  "<script> alert('Unable to find matched user') </script>";
        }
    }
}

function ft_find_distance($uid) {

    include "../config/check_con.php";
    /** @var TYPE_NAME $con */

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
    }
    else
        echo "<script> alert('Location does not exist, please update location information to obtain matches.'); location.href='../htmls/edit_profile.php' </script>";

    $stmt = $con->prepare("SELECT * FROM location");
    $stmt->execute();

    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $uid_dist = $row['uid'];
            $lat2 = $row['lattitude'];
            $long2 = $row['longitude'];

            if ($lat2 && $long2) {
                $distance = ft_distance($lat1, $long1, $lat2, $long2);
                if ($distance) {

                    $stmt = $con->prepare("UPDATE profile SET distance= :distance WHERE uid=:userP");
                    $stmt->execute(['distance' => $distance, 'userP' => $uid_dist]);
                }
            }
        }
    }
}

function ft_set_url_session() {

    $url = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $url_enc = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');

    $_SESSION['url'] = $url_enc;
}

function delete_notification ($nid) {

    include "../config/check_con.php";
    /** @var TYPE_NAME $con */

    $stmt = $con->prepare("DELETE FROM notifications WHERE id= :nid");
    $stmt->execute(['nid' => $nid]);
    if ($stmt->rowCount()) {
        echo "<script> alert('Notification deleted from db'); location.href='../htmls/stats.php'; </script>";
    }
}

function ft_set_looked_at($uid, $userP) {

    include "../config/check_con.php";
    /** @var TYPE_NAME $con */

    $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :uid");
    $stmt->execute(['uid' => $uid]);
    $result = $stmt->fetchAll();

    foreach ($result as $row) {
        $user_name = $row['user_name'];
    }

    $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :userP AND blocked= :uid");
    $stmt->execute(['userP' => $userP, 'uid' => $uid]);
    if ($stmt->rowCount()) {
        echo "<script> alert('You have been blocked by this user, can not view profile.'); location.href='../htmls/browse.php'; </script>";
    } else {

        if (strcmp($user_name, "") != 0) {
            $stmt = $con->prepare("SELECT * FROM liked WHERE uid= :uid AND looked= :userP");
            $stmt->execute(['uid' => $uid, 'userP' => $userP]);

            if (!$stmt->rowCount()) {

                $stmt = $con->prepare("INSERT INTO liked (uid, looked) VALUES ('$uid', '$userP') ");
                $stmt->execute();

                $sub = "LOOKED";
                $note = $user_name . " just looked at your profile!";

                $stmt = $con->prepare("INSERT INTO notifications (uid, subject, note) VALUES (:userP, :sub, :note)");
                $stmt->execute(['userP' => $userP, 'sub' => $sub, 'note' => $note]);
                ft_get_rating($userP);
            }
        } else
            echo "<script> alert('User name not set.'); location.href='../htmls/browse.php'; </script>";
    }
}

function ft_authenticate_cid($uid, $cid) {

    include "../config/check_con.php";
    /** @var TYPE_NAME $con */

    $stmt = $con->prepare("SELECT * FROM connected WHERE cid= :cid AND uid1= :uid XOR uid2= :uid");
    $stmt->execute(['cid' => $cid, 'uid' => $uid]);
    if ($stmt->rowCount()) {
        $_SESSION['cid'] = $cid;
    }
    else
        echo "<script> alert('You are not authorized to access this chat.'); location.href='../htmls/chat.php'; </script>";
}

function ft_chat_notice($uid, $user)
{

    if (isset($_SESSION['cid'])) {
        $cid = $_SESSION['cid'];

        include "../config/check_con.php";

        $stmt = $con->prepare("SELECT * FROM connected WHERE cid= :cid");
        $stmt->execute(['cid' => $cid]);
        if ($stmt->rowCount()) {
            $result = $stmt->fetchAll();

            foreach ($result as $row) {
                $uid1 = $row['uid1'];
                $uid2 = $row['uid2'];
            }

            if ($uid === $uid2) {
                $userP = $uid1;
            } else
                $userP = $uid2;


            if ($userP) {

                $stmt = $con->prepare("SELECT * FROM profile WHERE uid= :userP");
                $stmt->execute(['userP' => $userP]);
                if ($stmt->rowCount()) {
                    $result = $stmt->fetchAll();
                    foreach ($result as $row) {
                        $user_name = $row['user_name'];
                    }
                }
            } else
                echo "<p class='welcome'> Welcome, " . $user . ". Please select a user to chat to.</p>";

            if ($user_name) {
                echo "<p class='welcome'> You are talking to: " . $user_name;
            } else
                echo "<p class='welcome'> Welcome, " . $user . ". Please select a user to chat to.</p>";
        }
    }else
        echo "<p class='welcome'> Welcome, " . $user . ". Please select a user to chat to.</p>";
}

?>
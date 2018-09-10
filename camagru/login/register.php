<?php

session_start();

include "../config/check_con.php";

$first = $_POST['first_name'];
$notice = $_POST['notifications'];
$uid = $_POST['uid'];
$email = $_POST['email'];
$passwd = $_POST['passwd'];
/* Load the stuff into the config table */
if ($_POST['register'] == "OK") {
    /* Only insert staff if fields are not left blank */
    /* This is to prevent creating empty rows */
    if ($first && $notice && $uid && $passwd) {
        $token = substr(md5(mt_rand()), 0, 15); //creating token
        /* Encrypt the passwd before storing it */
        $passwd_encrypt = serialize(hash('whirlpool', $passwd));

        $stmt = $con->prepare("SELECT `uid` FROM `users` WHERE `uid` = :uid");
        $stmt->execute(['uid' => $uid]);
        if ($stmt->rowCount())
            echo "<script> alert('Username already in use. Please use another.'); location.href='../htmls/register.php'; </script>";
        else {

            $stmt = $con->prepare("SELECT uid FROM images WHERE uid = :uid");
            $stmt->execute(['uid' => $uid]);
            if ($stmt->rowCount())
                echo "<script> alert('Username already in use. Please use another.'); location.href='../htmls/register.php'; </script>";
            else {

                $stmt = $con->prepare("INSERT INTO users (first_name, notifications, uid, token, email, passwd) VALUES ('$first', '$notice', '$uid', '$token', '$email', '$passwd_encrypt')");
                $result = $stmt->execute();
                if ($result) {

                    /* This is the mailing function */
                    $message = "Your Activation Code is " . $token . "";
                    $to = $email;
                    $subject = "Activation Code For Camagru.com";
                    $from = "self";
                    $body = '
  <html>
    <head>
      <title>' . $subject . '</title>
    </head>
    <body>
      Hello ' . htmlspecialchars($uid) . ' </br>
      Please click the link below to verify your account. </br>
      <a href="http://localhost:8080/cama3/htmls/verify.php?token=' . $token . '&email=' . $email . '">Verify my email</a>
    </body>
    
  </html>
  ';
                    $headers = "From:" . $from;
                    mail($to, $subject, $body, $headers);

                    echo "<script> alert('An email has been sent to $email. Please verify before logging in.'); location.href='../index.php'</script>";
                }
            }
        }
    }
    else {
        /* jump to back registration page */
        header("Location: ../htmls/register.php");
        echo "please complete all the fields";
    }

}
else /* Go to the sign in page if the signin button is pressed */
    header("Location: user_login.php");
?>
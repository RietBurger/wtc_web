<?PHP

session_start();

include "../config/check_con.php";

$uid = $_POST['uid'];
$email = $_POST['email'];

try {
    if ($_POST['submit'] == "Request Password") {
//    if ($newpw == $confirm) {
        $stmt = $con->prepare("SELECT `uid` FROM `users` WHERE `uid` = :uid AND `email` = :email");
        $stmt->execute(['uid' => $uid, 'email' => $email]);

        if ($stmt->rowCount()) {

            $empw = substr(md5(mt_rand()), 0, 13);
//                $stmt = $con->prepare("UPDATE 'users' SET passwd = ':passwd' WHERE uid = ':uid' AND passwd = ':oldpw'");
            $sql = "UPDATE `users` SET passwd = '$empw' WHERE uid = '$uid' AND `email` = '$email'";
            $result = $con->query($sql);
//                $stmt->execute(['passwd' => $newpw, 'uid' => $uid, 'oldpw' => $oldpw]);

            if ($result->rowCount()) {

                $subject = "New Password";
                $to = $email;
                $from = "self";
                $body = '
  <html>
    <head>
      <title>' . $subject . '</title>
    </head>
    <body>
      Hello ' . htmlspecialchars($uid) . ' </br>
      Please click the link below to reset your password. </br>
      <a href="http://localhost:8080/cama3/htmls/change_request_password.php?empw=' . $empw . '&email=' .$email .'&uid=' . $uid . '">Change password</a>
    </body>
    
  </html>
  ';
                $headers = "From:" . $from;
                mail($to, $subject, $body, $headers);

                echo "<script> alert('$uid, Your new password has been sent to your email address.'); location.href='../index.php'; </script>";
            } else
                echo "<script> alert('$uid, Error in requesting password. Please try again.'); location.href='../htmls/request_new_pw.php'; </script>";
        } else
            echo "<script> alert('$uid, Username and email do not match.'); location.href='../htmls/request_new_pw.php'; </script>";
//    } else
//        echo "<script> alert('$uid, Passwords do not match.'); location.href='../htmls/change_request_password.php'; </script>";
    }
    $con = NULL;
}
catch (PDOException $e) {
    echo $stmt . $e->getMessage();
}
?>
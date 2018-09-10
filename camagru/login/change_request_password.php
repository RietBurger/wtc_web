<?PHP

session_start();

if (isset($_SESSION['uid']) && isset($_SESSION['email']) && isset($_SESSION['passwd'])) {
    $empw = $_SESSION['passwd'];
    $uid = $_SESSION['uid'];
    $email = $_SESSION['email'];
}
else
    echo "<script> alert('Unable to find correct information. Please request new password.'); location.href='../htmls/request_new_pw.php' </script>";

include "../config/check_con.php";


    $newpw = serialize(hash("whirlpool", $_POST['newpw']));
    $confirm = serialize(hash("whirlpool", $_POST['confirm']));

//    try {
        if ($_POST['submit'] == "Reset") {
            if ($newpw == $confirm) {
                $stmt = $con->prepare("SELECT * FROM users WHERE passwd = :empw");
                $stmt->execute(['empw' => $empw]);

                if ($stmt->rowCount()) {

                    $stmt = $con->prepare("UPDATE users SET passwd = :newpw WHERE passwd = :empw");
                    $stmt->execute(['newpw' => $newpw, 'empw' => $empw]);

                    if ($stmt->rowCount()) {
                        $subject = "Password Reset";
                        $body = "Hi $uid! This email is just to confirm that your password has been successfully reset.";
                        mail($email, $subject, $body);
                        echo "<script> alert('$uid, Your password has been sucessfully reset.'); location.href='../htmls/login.php'; </script>";
                    } else
                        echo "<script> alert('$uid, Error in resetting password. Please try again.'); location.href='../index.php'; </script>";
                } else
                    echo "<script> alert('$uid, Username, Email or Password do not match.'); location.href='../index.php'; </script>";
            } else
                echo "<script> alert('$uid, Passwords do not match.'); location.href='../index.php'; </script>";
        }
        $con = NULL;
//    }
//    catch (PDOException $e) {
//        echo $stmt . $e->getMessage();

?>
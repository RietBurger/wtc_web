<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="stylesheet" href="../css/loginstyles.css" madia="all">
    <link rel='stylesheet' media='screen and (max-width: 700px)' href='../css/mobile.css' type="text/css" />
</head>
<body>
<div class="main">
    <div class="header">
        <h1>CAMA-ra-G-u-RU</h1>
    </div>

<div class="container">
    <h2>Change Password</h2>
    <li><a href="../htmls/loggedin.php" id="home">Home</a></li>
    <li><a href="../login/logout.php" id="home">Logout</a></li>

    <div class="form_inside">
        <form action="../login/change_passwd.php" method="post">
            Enter new Password<input type="password" name="newpasswd" placeholder="New Password" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,13}" title="Must contain at least one number and one uppercase and lowercase letter, and between 8 and 13 characters" maxlength="13">
            Confirm new Password<input type="password" name="confirm" placeholder="Confirm new Password" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,13}" title="Must contain at least one number and one uppercase and lowercase letter, and between 8 and 13 characters" maxlength="13">
            <input type="submit" value="Change" name="submit">
        </form>
    </div>
</div>
</div>

<div class="footer">
    <h2>&copy; 2017 by rburger </h2>
</div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Notifications</title>
    <link rel="stylesheet" href="../css/loginstyles.css" madia="all">
    <link rel='stylesheet' media='screen and (max-width: 700px)' href='../css/mobile.css' type="text/css" />
</head>
<body>
<div class="main">
    <div class="header">
        <h1>CAMA-ra-G-u-RU</h1>
    </div>

<div class="container">
    <h2>Change Notifications</h2>
    <li><a href="../htmls/loggedin.php" id="home">Home</a></li>
    <li><a href="../login/logout.php" id="home">Logout</a></li>

    <div class="form_inside">
        <form action="../login/change_notifications.php" method="post">
            <label><b>Email notifications?</b></label>
            <input type="radio" name="notification" required="required" value="yes"> Yes
            <input type="radio" name="notification" required="required" value="no"> No
            <input type="submit" value="Change" name="submit">
        </form>
    </div>
</div>
</div>

<div class="footer" style="margin-top: 130px">
    <h2>&copy; 2017 by rburger </h2>
</div>
</body>
</html>
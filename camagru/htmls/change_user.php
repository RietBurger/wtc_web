<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change User name</title>
    <link rel="stylesheet" href="../css/loginstyles.css" madia="all">
    <link rel='stylesheet' media='screen and (max-width: 700px)' href='../css/mobile.css' type="text/css" />
</head>
<body>
<div class="main">
    <div class="header">
        <h1>CAMA-ra-G-u-RU</h1>
    </div>

<div class="container">
    <h2>Change User Name</h2>
    <li><a href="../htmls/loggedin.php" id="home">Home</a></li>
    <li><a href="../login/logout.php" id="home">Logout</a></li>

    <div class="form_inside">
        <form action="../login/change_user.php" method="post">
            Enter new User name<input type="text" name="newuid" placeholder="New User name" required="required" maxlength="8" title="Up to 8 characters only">
            Confirm new User name<input type="text" name="confirm" placeholder="Confirm new User name" required="required" maxlength="8" title="Up to 8 characters only">
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
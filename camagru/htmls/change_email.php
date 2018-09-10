<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/loginstyles.css" madia="all">
    <link rel='stylesheet' media='screen and (max-width: 700px)' href='../css/mobile.css' type="text/css" />
</head>
<body>
<div class="main">
<div class="header">
    <h1>CAMA-ra-G-u-RU</h1>
</div>

<div class="container">


    <h2>Change Email</h2>
    <li><a href="../htmls/loggedin.php" id="home">Home</a></li>
    <li><a href="../login/logout.php" id="home">Logout</a></li>

    <div class="form_inside">
        <form action="../login/change_email.php" method="post">
            Enter new email<input type="email" name="newem" placeholder="New Email" required="required" >
            Confirm new email<input type="email" name="confirm" placeholder="Confirm new email" required="required" >
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
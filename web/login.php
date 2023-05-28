<?php
session_start();
if (isset($_SESSION['id']) != "") {
    header("Location: index.php");
}
include("dbconnect.php");

if (isset($_POST['btn-login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $result   = $mysqli->query("SELECT * FROM users WHERE username='$username'");
    $user     = $result->fetch_array();
    if ($user['password'] == md5($password)) {
        $_SESSION['id']     = $user['id'];
        $_SESSION['user']   = $user['username'];
        $_SESSION['name']   = $user['name'];
        $_SESSION['phone']  = $user['phone'];
        $_SESSION['email']  = $user['email'];
        $_SESSION['access'] = $user['access_level'];
        header("Location: index.php");
    } else {
        ?>
        <script>alert('Wrong username or password');</script>
        <?php
    }
}
?>
<!DOCTYPE html>
<html>
<meta name="viewport"
    content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1, user-scalable=no">
<link href="resources/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="resources/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>

<head>
    <title>House Alarm System Login</title>
    </body>
    <div class="container pt-5 d-flex align-items-center justify-content-center"
        style="max-width: 400px; min-width: 100px !important;">
        <div class="row col-12 form-group border border-2 border-success rounded-start rounded-end">
            <div class="container" style="margin-top:50px; margin-bottom:50px">
                <form id="login" method="post" role="form">
                    <div class="mb-3 ">
                        <h6 class="text-center text-white text-solid bg-success">Security System Login: </h6>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <div class="d-flex align-items-end justify-content-end">
                        <button class="btn btn-success" name="btn-login" type="submit">Login</button>
                    </div>
                    </p>
                </form>
            </div>
        </div>
    </div>
    </body>

</html>
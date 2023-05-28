<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['id']) || isset($_SESSION['access']) != "admin") {
    header("Location: login.php");
}
include 'dbconnect.php';
if (isset($_GET['data']) == "sensors") {
    $id = $_GET['id'];
    $mysqli->query("DELETE FROM sensors WHERE id='$id'");
    $message = "updateSensor";
    $a       = socketClient::socketMesage($message);
    echo "<script type='text/javascript'> document.location = 'sensors.php'; </script>";
} elseif (isset($_GET['data']) == "users") {
    $id = $_GET['id'];
    $mysqli->query("DELETE FROM users WHERE id='$id'");
    echo "<script type='text/javascript'> document.location = 'newuser.php'; </script>";
} else {
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}

?>
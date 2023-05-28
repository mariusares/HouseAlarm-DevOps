<?php
session_start();
include_once 'dbconnect.php';
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}
include "header.php";
$message     = "reqestData";
$a           = socketClient::socketMesage($message);
$check_alarm = "requestTrigger";
$b           = socketClient::socketMesage($check_alarm);
$sensors     = array();
for ($i = 0; $i < count($a); $i++) {
    if (strpos($a[$i], 'Temp') !== false) {
        $temp = trim($a[$i], "[ ' ]");
    } else {
        $temp2 = trim($a[$i], "[ ' ]");
        array_push($sensors, $temp2);
    }
}

$alarm = $mysqli->query("SELECT * from status  ORDER BY id DESC LIMIT 1")->fetch_assoc();

if (isset($_GET['alarmdisable'])) {
    $alarmsilent = $alarm['silent'];
    $alarmname   = $_SESSION['name'];
    $alarmstatus = "Unset";
    $mysqli->query("INSERT INTO status(status, silent, set_by, set_date)VALUES('$alarmstatus','$alarmsilent', '$alarmname', '$my_date')");
    $alarmmessage = "alarmUnset";
    $socket_msg   = socketClient::socketMesage($alarmmessage);
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}
if (isset($_POST['alarmenable'])) {
    $alarmsilent = $alarm['silent'];
    $alarmname   = $_SESSION['name'];
    $alarmstatus = "Armed";
    $mysqli->query("INSERT INTO status(status, silent, set_by, set_date)VALUES('$alarmstatus','$alarmsilent', '$alarmname', '$my_date')");
    $alarmmessage = "alarmSet";
    $socket_msg   = socketClient::socketMesage($alarmmessage);
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}
if (isset($_GET['silentdisable'])) {
    $alarmsilent = "no";
    $alarmname   = $_SESSION['name'];
    $alarmstatus = $alarm['status'];
    $mysqli->query("INSERT INTO status(status, silent, set_by, set_date)VALUES('$alarmstatus','$alarmsilent', '$alarmname', '$my_date')");
    $alarmsilent = "alarmMute";
    $socket_msg  = socketClient::socketMesage($alarmsilent);
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}
if (isset($_POST['silentenable'])) {
    $alarmsilent = "yes";
    $alarmname   = $_SESSION['name'];
    $alarmstatus = $alarm['status'];
    $mysqli->query("INSERT INTO status(status, silent, set_by, set_date)VALUES('$alarmstatus','$alarmsilent', '$alarmname', '$my_date')");
    $alarmsilent = "alarmUnmute";
    $socket_msg  = socketClient::socketMesage($alarmsilent);
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}

?>

<body>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <div class="container-sm " style="max-width: 900px; min-width: 100px !important;">

        <div class="pt-5">
            <div class="row  g-1 p-2 col-12 form-group border border-2 border-success rounded-start rounded-end">
                <h4 class="text-center text-white text-solid bg-success">Security Monitor</h4>
                <?php
                if ($b[0] > 0) {
                    $alarm_temp = trim($b[1], "[ ' ]");
                    $color      = "bg-danger bg-opacity-25";
                } else {
                    $color = "bg-info bg-opacity-10";
                }
                ?>
                <div class="col-md-6 col-xs-12 text-center">
                    <div
                        class="row border border-success m-1 <?php echo $color; ?> border-info rounded-start rounded-end">
                        <label for="alarmSwitch"><strong>Alarm:</strong></label>
                        <?php if ($alarm['status'] != "Armed") { ?>
                            <form method="post">
                                <div class="d-flex justify-content-center justify-text-center " style="font-size: 20px">
                                    <p>Off</p>
                                    <div class="form-check form-switch form-check-inline" style="font-size: 20px">
                                        <input class="form-check-input float-end" type="checkbox" name="alarmenable"
                                            onchange="this.form.submit()" role="switch">
                                    </div>
                            </form>
                            <p>On</p>
                        </div <?php } ?> <?php if ($alarm['status'] == "Armed") { ?> <form action="?alarmdisable=true"
                            method="post">
                        <div class="d-flex justify-content-center justify-text-center " style="font-size: 20px">
                            <p>Off</p>
                            <div class="form-check form-switch form-check-inline" style="font-size: 20px">
                                <input class="form-check-input float-end" type="checkbox" name="alarmdisable"
                                    onchange="this.form.submit()" role="switch" checked>
                            </div>
                            </form>
                            <p>On</p>
                        </div <?php } ?> </div>
                </div>
            </div>

            <div class="col-md-6 col-xs-12 text-center">
                <div class="row border border-success m-1 <?php echo $color; ?> border-info rounded-start rounded-end">
                    <label for="alarmSwitch"><strong>Speaker:</strong></label>
                    <?php if ($alarm['silent'] != "yes") { ?>
                        <form method="post">
                            <div class="d-flex justify-content-center justify-text-center " style="font-size: 20px">
                                <p>Off</p>
                                <div class="form-check form-switch form-check-inline" style="font-size: 20px">
                                    <input class="form-check-input float-end" type="checkbox" name="silentenable"
                                        onchange="this.form.submit()" role="switch">
                                </div>
                        </form>
                        <p>On</p>
                    </div <?php } ?> <?php if ($alarm['silent'] == "yes") { ?> <form action="?silentdisable=true"
                        method="post">
                    <div class="d-flex justify-content-center justify-text-center " style="font-size: 20px">
                        <p>Off</p>
                        <div class="form-check form-switch form-check-inline" style="font-size: 20px">
                            <input class="form-check-input float-end" type="checkbox" name="silentdisable"
                                onchange="this.form.submit()" role="switch" checked>
                        </div>
                        </form>
                        <p>On</p>
                    </div <?php } ?> </div>
            </div>
        </div>

        <div class="col-md-12 col-xs-12 text-center">
            <div class="row border border-success  m-1 p-2 bg-info bg-opacity-10 border-info rounded-start rounded-end">
                <div class="text-center">
                    <?php echo $temp; ?>
                </div>
            </div>
        </div>
        <?php
        for ($i = 0; $i < count($sensors); $i++) {
            if (strpos($sensors[$i], 'Alarm') !== false) {
                $color = "bg-danger bg-opacity-25";
            } else {
                $color = "bg-info bg-opacity-10";
            }
            echo '
<div class="col-md-4 col-xs-12 text-center">
<div class="row border border-success p-2 m-1 ' . $color . ' border-info rounded-start rounded-end" >
<div class="text-center">
' . $sensors[$i] . '
</div>
</div>
</div>';
        }
        ?>
        <div class="row  g-1 p-2 col-12 form-group">
            <h4 class="text-center text-white text-solid bg-success">Alarm Logs</h4>
            <div class="table-wrapper">
                <table class="table table-nowrap border-sucess">
                    <thead>
                        <tr>
                            <td style="width : 25%"><b><small>Status/Speaker</small></b></td>
                            <td style="width : 40%"><b><small>User</small></b></td>
                            <td style="width : 35%"><b><small>Date</small></b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM status ORDER BY id DESC LIMIT 5";
                        $users = mysqli_query($mysqli, $query);
                        if ($users->num_rows > 0) {
                            while ($user = $users->fetch_assoc()) {
                                $login  = $user['status'];
                                $name   = $user['set_by'];
                                $email  = $user['set_date'];
                                $silent = $user['silent'];

                                ?>
                                <tr>
                                    <td><small>
                                            <?php echo $login ?? null;
                                            echo " / " . $silent ?? null; ?>
                                    </td>
                                    <td><small>
                                            <?php echo $name ?? null; ?>
                                    </td>
                                    <td><small>
                                            <?php echo $email ?? null; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>

            </div>
        </div>
        <?php
        include 'footer.php';
        ?>
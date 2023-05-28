<?php
if (!isset($_SESSION)) {
    session_start();
}
include 'dbconnect.php';
include 'header.php';
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}
if (isset($_POST['btn-timezone'])) {
    $timezone = $_POST['selectTimezone'];
    shell_exec("sudo timedatectl set-timezone $timezone");
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}
?>
<div class="d-inline d-none d-sm-block">
    <div class="pt-5">
    </div>
</div>
<div class="container bg-light border border-2 border-success rounded-start rounded-end"
    style="max-width: 900px; padding: 15px; min-width: 100px !important;">
    <h4 class="text-center text-white text-solid bg-success">Timezone Setup</h4>
    <form class="form p-4" id="timezone" method="post" role="form">
        <div class="row g-1">
            <div class="col-6">
                <h6>Timezone: </h6>
            </div>
            <div class="col-6">
                <?php
                function select_Timezone($selected = '')
                {
                    $OptionsArray = timezone_identifiers_list();
                    $select       = '<select class="form-control" name="selectTimezone">';
                    while (list($key, $row) = each($OptionsArray)) {
                        $select .= '<option value="' . $row . '"';
                        $select .= ($row === $selected ? ' selected' : '');
                        $select .= '>' . $row . '</option>';
                    }
                    ;
                    $select .= '</select>';
                    return $select;
                }

                $selected_timezone = trim(shell_exec("cat /etc/timezone"));
                echo select_Timezone($selected_timezone);
                ?>
            </div>
            </p>

            <div class="d-flex align-items-end justify-content-end ">
                <button class="btn btn-success" type="submit" name="btn-timezone">Submit</button>
            </div>
        </div>
</div>
</form>

<?php
include 'footer.php';
?>
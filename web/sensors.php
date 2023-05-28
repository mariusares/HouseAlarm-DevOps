<?php
if (!isset($_SESSION)) {
  session_start();
}
include 'dbconnect.php';
include 'header.php';
if (!isset($_SESSION['id'])) {
  header("Location: login.php");
}
if (isset($_POST['btn-sensors'])) {
  $sensor = $_POST['sensor'];
  $type   = $_POST['type'];
  $pin    = $_POST['pin'];
  $mysqli->query("INSERT INTO sensors(sensor_name,sensor_type,sensor_pin)VALUES('$sensor','$type','$pin')");
  $message = "updateSensor";
  $a       = socketClient::socketMesage($message);
  echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}
?>
<div class="d-inline d-none d-sm-block">
  <div class="pt-5">
  </div>
</div>
<div class="container bg-light border border-2 border-success rounded-start rounded-end"
  style="max-width: 900px; padding: 15px; min-width: 100px !important;">
  <h4 class="text-center text-white text-solid bg-success">Sensors Settings</h4>
  <form class="password-strength form p-4" id="newuser" method="post" role="form">
    <div class="row g-1">
      <div class="col-6">
        <h6>Sensor name/location: </h6>
      </div>
      <div class="col-6">
        <input type="text" class="form-control" name="sensor" placeholder="sensor name">
      </div>

      <div class="col-6">
        <h6>Sensor type: </h6>
      </div>
      <div class="col-6">
        <select class="form-control" name="type" required>
          <option value="Intrusion">Intrusion</option>
          <option value="Motion">Motion</option>
          <option value="Fire">Fire</option>
          <option value="temp">Temperature</option>
        </select>
      </div>
      <div class="col-6">
        <h6>Sensor pin: </h6>
      </div>
      <div class="col-6">
        <div class="input-group">
          <input type="text" class="form-control" id="password-input" name="pin" autocomplete="off" required>
        </div>
        </p>
        <div class="d-flex align-items-end justify-content-end ">
          <button class="btn btn-success" type="submit" name="btn-sensors">Submit</button>
        </div>
  </form>
</div>
</div>
</p>
<div class="table-wrapper">
  <table class="table table-nowrap border-sucess">
    <thead>
      <tr>
        <th class="text-white text-solid bg-success" style="width : 33%"><small>Sensor</small></th>
        <th class="text-white text-solid bg-success" style="width : 33%"><small>Type</small></th>
        <th class="text-white text-solid bg-success" style="width : 25%"><small>Pin</small></th>
        <th class="bg-success" style="width : 9%"></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $query   = "SELECT * FROM sensors";
      $sensors = mysqli_query($mysqli, $query);
      if ($sensors->num_rows > 0) {
        while ($sensor = $sensors->fetch_assoc()) {
          $id    = $sensor['id'];
          $sname = $sensor['sensor_name'];
          $stype = $sensor['sensor_type'];
          $spin  = $sensor['sensor_pin'];

          ?>
          <tr>
            <td><small>
                <?php echo $sname ?? null; ?>
            </td>
            <td><small>
                <?php echo $stype ?? null; ?>
            </td>
            <td><small>
                <?php echo $spin ?? null; ?>
            </td>
            <td><a href="delete.php?data=sensors&id=<?php echo $id; ?>"><small>delete</small></td>
          </tr>
          <?php
        }
      }
      ?>
    </tbody>
  </table>
</div>
<?php
include 'footer.php';
?>
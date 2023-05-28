<?php
if (!isset($_SESSION)) {
  session_start();
}
include 'dbconnect.php';
include 'header.php';
if (!isset($_SESSION['id'])) {
  header("Location: login.php");
}
$alert = $mysqli->query("SELECT * FROM alert WHERE id='1'")->fetch_array();
//$user=$result->fetch_array();
if (isset($_POST['btn-emailsettings'])) {
  $login    = $_POST['login'];
  $password = $_POST['password'];
  $server   = $_POST['server'];
  $port     = $_POST['port'];
  //$subject = $_POST['subject'];
  //$body = $_POST['body'];
  $mysqli->query("UPDATE alert SET email_server='$server', email_port='$port', email_login='$login', email_password='$password' WHERE id='1'");
}
?>
<div class="d-inline d-none d-sm-block">
  <div class="pt-5">
  </div>
</div>
<div class="container bg-light border border-2 border-success rounded-start rounded-end"
  style="max-width: 900px; padding: 15px; min-width: 100px !important;">
  <h4 class="text-center text-white text-solid bg-success">Email Server Settings</h4>
  <form class="form p-4" id="newuser" method="post" role="form">
    <div class="row g-1">
      <div class="col-6">
        <h6>Email Login: </h6>
      </div>
      <div class="col-6">
        <input type="text" class="form-control" name="login" placeholder="youremail@email.com"
          value="<?php echo $alert['email_login']; ?>">
      </div>

      <div class="col-6">
        <h6>Email Password: </h6>
      </div>
      <div class="col-6">
        <input type="text" class="form-control" name="password" autocomplete="off" required>
      </div>
      <div class="col-6">
        <h6>Email Server: </h6>
      </div>
      <div class="col-6">
        <input type="text" class="form-control" name="server" placeholder="mail.email.com"
          value="<?php echo $alert['email_server']; ?>">
      </div>
      <div class="col-6">
        <h6>Email Server Port: </h6>
      </div>
      <div class="col-6">
        <input type="text" class="form-control" name="port" placeholder="587"
          value="<?php echo $alert['email_port']; ?>">
      </div>
      </p>
      <div class="d-flex align-items-end justify-content-end ">
        <button class="btn btn-success" type="submit" name="btn-emailsettings">Submit</button>
      </div>
      </p>
  </form>
</div>
<?php
include 'footer.php';
?>
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
  $subject  = $_POST['subject'];
  $body     = $_POST['body'];
  if ($password1 !== $password2) {
    echo '<script>alert("The password did not match")</script>';
  } else {
    $mysqli->query("INSERT INTO users(username,name,phone,email,password,access_level,created_at)
VALUES('$uuser','$uname','$uphone','$uemail','$password1','$uaccess','$my_date')");
    echo '<script>alert("New user ' . $uuser . ' successfully registered !")</script>';
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
  }
}
?>
<div class="d-inline d-none d-sm-block">
  <div class="pt-5">
  </div>
</div>
<div class="container bg-light border border-2 border-success rounded-start rounded-end"
  style="max-width: 900px; padding: 15px; min-width: 100px !important;">
  <h4 class="text-center text-white text-solid bg-success">Email Server Settings</h4>
  <form class="password-strength form p-4" id="newuser" method="post" role="form">
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
        <input type="password" class="form-control" name="password" autocomplete="off" required>
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
      <div class="col-6">
        <h6>Email Subject: </h6>
      </div>
      <div class="col-6">
        <input type="text" class="form-control" name="subject" placeholder="House Alarm - $alarmType"
          value="<?php echo $alert['email_subject']; ?>">
      </div>
      <div class="mb-3">
        <label for="emailBody" class="form-label">
          <h6>Email Message:</h6>
        </label>
        <textarea class="form-control" id="emailBody" rows="5"
          placeholder="your message here"><?php echo $alert['email_body']; ?></textarea>
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
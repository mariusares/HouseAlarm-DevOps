<?php
if (!isset($_SESSION)) {
  session_start();
}
include_once 'dbconnect.php';
include_once 'header.php';
if (!isset($_SESSION['id'])) {
  header("Location: login.php");
}
if (isset($_POST['btn-chinfos'])) {
  $cuser     = $_POST['cuser'];
  $cname     = $_POST['cname'];
  $cphone    = $_POST['cphone'];
  $cemail    = $_POST['cmail'];
  $password1 = md5($_POST['password1']);
  $password2 = md5($_POST['password2']);
  if ($password1 !== $password2) {

    ?>
    <script>alert('The password did not match');</script>
    <?php

  } else {
    $mysqli->query("UPDATE users SET username='$cuser', name='$cname', phone='$cphone', email='$cemail', password='$password1' WHERE id='" . $_SESSION['id'] . "'");

    ?>

    <script>alert('The infos are successfully updated !');</script>
    <?php
    session_destroy();
    unset($_SESSION['id']);
    echo '<script language="javascript">window.location.href=""</script>';
  }
}
?>

<div class="d-inline d-none d-sm-block">
  <div class="pt-5">
  </div>
</div>
<div class="container bg-light border border-2 border-success rounded-start rounded-end"
  style="max-width: 900px; padding: 15px; min-width: 100px !important;">
  <h4 class="text-center text-white text-solid bg-success">Update User Infos</h4>
  <form class="password-strength form p-4" id="newinfos" method="post" role="form">
    <div class="row g-1">
      <div class="col-6">
        <h6>Full Name: </h6>
      </div>
      <div class="col-6">
        <input type="text" class="form-control" name="cname" value="<?php echo $_SESSION['name'] ?? null; ?>">
      </div>

      <div class="col-6">
        <h6>Username: </h6>
      </div>
      <div class="col-6">
        <input type="text" class="form-control" name="cuser" value="<?php echo $_SESSION['user'] ?? null; ?>">
      </div>
      <div class="col-6">
        <h6>Phone: </h6>
      </div>
      <div class="col-6">
        <input type="text" class="form-control" name="cphone" value="<?php echo $_SESSION['phone'] ?? null; ?>">
      </div>
      <div class="col-6">
        <h6>Email: </h6>
      </div>
      <div class="col-6">
        <input type="text" class="form-control" name="cmail" autocomplete="off"
          value="<?php echo $_SESSION['email'] ?? null; ?>">
      </div>
      <div class="col-6">
        <h6>New Password: </h6>
      </div>
      <div class="col-6">
        <div class="input-group">
          <input type="password" class="form-control" id="password-input" name="password1" autocomplete="off" required>
        </div>
      </div>
      <div class="col-6">
        <h6>Retype password: </h6>
      </div>
      <div class="col-6">
        <input type="password" class="form-control" name="password2" autocomplete="off" required>
      </div>
      </p>
      <div class="d-flex align-items-end justify-content-end ">
        <button class="btn btn-success" type="submit" name="btn-chinfos">Submit</button>
      </div>
      </p>
  </form>
</div>
<?php
include 'footer.php';
?>
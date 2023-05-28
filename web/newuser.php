<?php
if (!isset($_SESSION)) {
  session_start();
}
include 'dbconnect.php';
include 'header.php';
if (!isset($_SESSION['id'])) {
  header("Location: login.php");
}
if (isset($_POST['btn-newuser'])) {
  $uuser     = $_POST['uuser'];
  $uname     = $_POST['uname'];
  $uphone    = $_POST['uphone'];
  $uemail    = $_POST['umail'];
  $uaccess   = $_POST['uaccess'];
  $password1 = md5($_POST['password1']);
  $password2 = md5($_POST['password2']);
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
  <h4 class="text-center text-white text-solid bg-success">New Username</h4>
  <form class="password-strength form p-4" id="newuser" method="post" role="form">
    <div class="row g-1">
      <div class="col-6">
        <h6>Full Name: </h6>
      </div>
      <div class="col-6">
        <input type="text" class="form-control" name="uname" placeholder="username">
      </div>

      <div class="col-6">
        <h6>Username: </h6>
      </div>
      <div class="col-6">
        <input type="text" class="form-control" name="uuser" placeholder="login user">
      </div>
      <div class="col-6">
        <h6>Phone number: </h6>
      </div>
      <div class="col-6">
        <input type="text" class="form-control" name="uphone" placeholder="telephone">
      </div>
      <div class="col-6">
        <h6>Email address: </h6>
      </div>
      <div class="col-6">
        <input type="text" class="form-control" name="umail" autocomplete="off" placeholder="email address">
      </div>
      <div class="col-6">
        <h6>Access level: </h6>
      </div>
      <div class="col-6">
        <select class="form-control" name="uaccess" required>
          <option value="admin">Administrator</option>
          <option value="user">Monitor</option>
        </select>
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
        <button class="btn btn-success" type="submit" name="btn-newuser">Submit</button>
      </div>
      </p>
  </form>
  <div class="table-wrapper">
    <table class="table table-nowrap border-sucess">
      <thead>
        <tr>
          <th class="text-white text-solid bg-success" style="width : 33%"><small>Login</small></th>
          <th class="text-white text-solid bg-success" style="width : 33%"><small>Name</small></th>
          <th class="text-white text-solid bg-success" style="width : 25%"><small>email</small></th>
          <th class="bg-success" style="width : 9%"></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = "SELECT * FROM users";
        $users = mysqli_query($mysqli, $query);
        if ($users->num_rows > 0) {
          while ($user = $users->fetch_assoc()) {
            $id    = $user['id'];
            $login = $user['username'];
            $name  = $user['name'];
            $email = $user['email'];

            ?>
            <tr>
              <td><small>
                  <?php echo $login ?? null; ?>
              </td>
              <td><small>
                  <?php echo $name ?? null; ?>
              </td>
              <td><small>
                  <?php echo $email ?? null; ?>
              </td>
              <td><a href="delete.php?data=users&id=<?php echo $id; ?>"><small>delete</small></td>
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
<?php
function PageName()
{
  return substr($_SERVER["REQUEST_URI"], strrpos($_SERVER["REQUEST_URI"], "/") + 1);
}
$current_page = PageName();
//$current_page = "$_SERVER[REQUEST_URI]";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel='icon' href='images/hsa.png' type='image/x-icon' sizes="16x16" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1, user-scalable=no">
  <link href="resources/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="resources/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>
  <script src="resources/jquery.min.js"></script>
  <link rel="stylesheet" href="resources/style.css">
  <link rel="stylesheet" href="resources/bootstrap-icons.css">
  <title>House Security System</title>
  <div class="pt-5">
    <!-- navbar -->
    <nav
      class="navbar flex-sm-column flex-row flex-grow-1 align-items-center navbar-expand-lg navbar-dark bg-dark fixed-top main-navigation">
      <div class="container-fluid sticky-top">
        <a class="navbar-brand flex-sm-column flex-grow-1 align-items-center align-items-sm-end pt-1 px-1 text-white"
          href="index.php"><img src="images/hsa.png" height="36"></a>
        <button class="navbar-toggler" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="overlay d-flex d-lg-none allign-items-start justify-content-end"></div>
        <div class="order-lg-2 d-lg-flex bg-dark w-100 sidebar pb-3 pb-lg-0 justify-content-end pt-2">
          <ul class="navbar-nav mr-auto mb-2 mb-lg-0 nav allign-items-start" id="pills-tab" role="tablist">
            <li clss="nav-item" role="presentation">
              <a class="nav-link d-flex <?php echo $current_page == 'index.php' ? 'active' : NULL ?>"
                aria-selected="false" href="index.php">Status</a>
            </li>
            <?php
            if ($_SESSION['access'] == "admin") {
              echo '<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Settings
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdown">
            <li class="nav-item">
             <a class="dropdown-item" href="email.php">Email</a></li>
            <li class="nav-item">
            <li><hr class="dropdown-divider"></li>
             <a class="dropdown-item" href="sensors.php">Sensors</a></li>
            <li class="nav-item">
             <li><hr class="dropdown-divider"></li>
             <a class="dropdown-item" href="network.php">Network</a></li>
            <li class="nav-item">
             <li><hr class="dropdown-divider"></li>
             <a class="dropdown-item" href="timezone.php">Timezone</a></li>
            </ul>';
            } ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="dropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <?php echo $_SESSION['name']; ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdown">
                <li class="nav-item">
                  <a class="dropdown-item" href="infouser.php">Info User</a>
                </li>
                <?php
                if ($_SESSION['access'] == "admin") {
                  echo '<li><hr class="dropdown-divider"></li>';
                  echo '<li class="nav-item"><a class="dropdown-item" href="newuser.php">New User</a></li>';
                }
                ?>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="logout.php?logout">Logout</a></li>
            </li>
          </ul>
          </li>

          </ul>
        </div>
      </div>
    </nav>
  </div>
</head>
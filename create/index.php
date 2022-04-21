<?php

include_once('header.php');
if (isset($_POST['email']) && isset($_POST['password'])) {
  function validate($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $name = validate($_POST['name']);
  $email = validate($_POST['email']);
  $password = validate($_POST['password']);
  $confirm_password = validate($_POST['confirm_password']);

  if (empty($name)) {
    header("Location: " . ADMIN_ROOT . "/create?error=Name is required");
    exit();
  } elseif (empty($email)) {
    header("Location: " . ADMIN_ROOT . "/create?error=Email is required");
    exit();
  } else if (empty($password)) {
    header("Location: " . ADMIN_ROOT . "/create?error=Password is required");
    exit();
  } else if (strlen($password) < 5) {
    header("Location: " . ADMIN_ROOT . "/create?error=Password must be greater than 5 charactars");
    exit();
  } else if (empty($confirm_password)) {
    header("Location: " . ADMIN_ROOT . "/create?error=Confirm password is required");
    exit();
  } else {
    if($password != $confirm_password) {
      header("Location: " . ADMIN_ROOT . "/create?error=Password does not match");
      exit();
    }

    $checkExistsSql = "SELECT * FROM users WHERE email = '$email'";
    $checkExistsRes = mysqli_query($connect, $checkExistsSql);

    if (mysqli_num_rows($checkExistsRes) > 0) {
      header("Location: " . ADMIN_ROOT . "/create?error=This account already exists!");
      exit();
    }

    $sql = "INSERT INTO users (`name`, `email`, `password`) VALUES('$name', '$email', MD5('$password'))";
    $result = mysqli_query($connect, $sql);

    if ($result) {
        header("Location: " . ADMIN_ROOT . "/pages/users?success=Successfully created new user");
        exit();
    } else {
      header("Location: " . ADMIN_ROOT . "/create?error=Something went wrong");
      exit();
    }
  }
}
?>

<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?= ADMIN_ROOT ?>/" class="h1"><b>Clone</b> Admin</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="" method="post">
        <?php if (isset($_GET['error'])) : ?>
        <div class="alert alert-danger">
          <p class="error"><?php echo $_GET['error']; ?></p>
        </div>
        <?php endif; ?>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="name" placeholder="Full name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="confirm_password" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Create</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<?php include_once('footer.php'); ?>

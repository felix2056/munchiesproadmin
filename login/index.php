<?php  
include_once('header.php');

if (isset($_POST['email']) && isset($_POST['password'])) {
  function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $email = validate($_POST['email']);
  $password = validate($_POST['password']);

  if (empty($email)) {
    header("Location: " . ADMIN_ROOT . "/login?error=Email is required");
    exit();
  } else if(empty($password)){
      header("Location: " . ADMIN_ROOT . "/login?error=Password is required");
      exit();
  } else {
      $sql = "SELECT * FROM users WHERE email = '$email' AND password = MD5('$password')";
      $result = mysqli_query($connect, $sql);

      // echo mysqli_num_rows($result);
      // return;

      if (mysqli_num_rows($result) === 1) {
          $row = mysqli_fetch_assoc($result);
          
          if ($row['email'] == $email) {
              echo "Logged in!";
              
              $_SESSION['id'] = $row['id'];
              $_SESSION['name'] = $row['name'];
              $_SESSION['avatar'] = $row['avatar'];
              $_SESSION['bio'] = $row['bio'];
              $_SESSION['role'] = $row['role'];

              header("Location: " . ADMIN_ROOT . "/");
              exit();

          } else{
            header("Location: " . ADMIN_ROOT . "/login?error=Incorect email or password");
            exit();
          }

      } else{
        header("Location: " . ADMIN_ROOT . "/login?error=No record for this account");
        exit();
    }
  }
}
?>

<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?= ADMIN_ROOT ?>" class="h1"><b>Clone</b> Admin</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post">
        <?php if (isset($_GET['error'])) : ?>
          <div class="alert alert-danger">
            <p class="error"><?php echo $_GET['error']; ?></p>
          </div>
        <?php endif; ?>

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
        <div class="row">
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -

<?php include_once('footer.php'); ?>

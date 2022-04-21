<?php include_once('../../includes/header.php'); ?>

<!-- Navbar -->
<?php include_once('../../includes/nav.php'); ?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php include_once('../../includes/aside.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Contacts</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= ADMIN_ROOT ?>/">Home</a></li>
            <li class="breadcrumb-item active">Users</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <?php 
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $user_id = $_POST['user_id'] ?? null;

            if (!empty($user_id)) {
                $deleteSql = "DELETE FROM `users` WHERE id = '$user_id'";
                $deleteQuery = mysqli_query($link, $deleteSql);
                
                if ($deleteQuery) {
                    header("Location: /pages/users?success=User deleted successfully");
                    exit();
                }
                header("Location: /pages/users?error=User was not deleted");
                exit();
            }
        }

        $sql = "SELECT * FROM users";
        $result = mysqli_query($link, $sql);
    ?>

  <?php if ($result && mysqli_num_rows($result) > 0) : ?>
  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="card card-solid">
      <div class="card-body pb-0">
        <?php if (isset($_GET['error'])) : ?>
        <div class="alert alert-danger">
          <p class="text text-light"><?php echo $_GET['error']; ?></p>
        </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])) : ?>
        <div class="alert alert-success">
          <p class="text text-light"><?php echo $_GET['success']; ?></p>
        </div>
        <?php endif; ?>
        <div class="row">
          <?php while($user = mysqli_fetch_array($result)) : ?>
          <form action="" method="POST" id="form-<?= $user['id'] ?>" style="display: none;">
            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
          </form>
          <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
            <div class="card bg-light d-flex flex-fill">
              <div class="card-header text-muted border-bottom-0">
                <?= $user['role'] ?>
              </div>
              <div class="card-body pt-0">
                <div class="row">
                  <div class="col-7">
                    <h2 class="lead"><b><?= $user['name'] ?></b></h2>
                    <p class="text-muted text-sm"><b>About: </b> <?= $user['bio'] ?> </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: Demo
                        Street 123, Demo City 04312, NJ</li>
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 -
                        12 12 23 52</li>
                    </ul>
                  </div>
                  <div class="col-5 text-center">
                    <img src="<?= ADMIN_ROOT . $user['avatar'] ?>" alt="user-avatar" class="img-circle img-fluid">
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="text-right">
                  <a href="#" class="btn btn-sm bg-danger"
                    onclick="deleteUser('<?=$user['id']?>', '<?=$user['name']?>')">
                    <i class="fas fa-times"></i> Delete Profile
                  </a>
                  <a href="<?= ADMIN_ROOT ?>/pages/users/profile.php?user=<?= $user['id'] ?>" class="btn btn-sm btn-primary">
                    <i class="fas fa-user"></i> View Profile
                  </a>
                </div>
              </div>
            </div>
          </div>
          <?php endwhile; ?>
        </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <nav aria-label="Contacts Page Navigation">
          <ul class="pagination justify-content-center m-0">
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">5</a></li>
            <li class="page-item"><a class="page-link" href="#">6</a></li>
            <li class="page-item"><a class="page-link" href="#">7</a></li>
            <li class="page-item"><a class="page-link" href="#">8</a></li>
          </ul>
        </nav>
      </div>
      <!-- /.card-footer -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
  <?php endif; ?>
</div>
<!-- /.content-wrapper -->

<script>
  function deleteUser(user_id, user_name) {
    var txt;
    var confirm = window.confirm("Are you sure you want to delete " + user_name + '?');
    if (confirm == true) {
      form = document.getElementById('form-' + user_id);
      form.submit();
    }
  }

</script>

<?php include_once('../../includes/footer.php'); ?>

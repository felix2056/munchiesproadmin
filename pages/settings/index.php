<?php include_once('../../includes/header.php'); ?>

<!-- Navbar -->
<?php include_once('../../includes/nav.php'); ?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php include_once('../../includes/aside.php'); ?>

<?php
  if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $site_name = mysqli_real_escape_string($link, $_POST['site_name']);
    $site_desc = mysqli_real_escape_string($link, $_POST['site_desc']);
    $site_email = mysqli_real_escape_string($link, $_POST['site_email']);
    $site_phone = mysqli_real_escape_string($link, $_POST['site_phone']);
    $site_address = mysqli_real_escape_string($link, $_POST['site_address']);
    $site_currency = mysqli_real_escape_string($link, $_POST['site_currency']);
    $site_keywords = mysqli_real_escape_string($link, $_POST['site_keywords']);

    if (!empty($site_name) && !empty($site_desc) && !empty($site_email) && !empty($site_phone) && !empty($site_address) && !empty($site_currency) && !empty($site_keywords)) {
      // upload logo to server
      $site_logo = NULL;
      if(!empty($_FILES['site_logo']['name']) && $_FILES['site_logo']['error'] == 0) {
        $target_dir = "../../logo/";
        $target_file = $target_dir . basename($_FILES["site_logo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // echo json_encode($file);
    
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["site_logo"]["tmp_name"]);
        if($check == false) {
          echo "File is not an image.";
          $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["site_logo"]["size"] > 500000) {
          echo "Sorry, your file is too large.";
          $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
          echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.";
        } else {
          // Check if file already exists
          if (file_exists($target_file)) {
            // delete old image
            unlink($target_file);
          }

          if (move_uploaded_file($_FILES["site_logo"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["site_logo"]["name"]). " has been uploaded.";
          } else {
            echo "Sorry, there was an error uploading your file.";
          }
        }

        $site_logo = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . '://' . $_SERVER['SERVER_NAME'] . '/logo/' . basename($_FILES["site_logo"]["name"]);
      }

      if(!empty($site_logo)) {
        $update = "UPDATE settings SET `id` = 1, `site_name` = '$site_name', `site_desc` = '$site_desc', `site_email` = '$site_email', `site_phone` = '$site_phone', `site_address` = '$site_address', `site_currency` = '$site_currency', `site_keywords` = '$site_keywords', `site_logo` = '$site_logo' WHERE id = 1";
      } else {
        $update = "UPDATE settings SET `id` = 1, `site_name` = '$site_name', `site_desc` = '$site_desc', `site_email` = '$site_email', `site_phone` = '$site_phone', `site_address` = '$site_address', `site_currency` = '$site_currency', `site_keywords` = '$site_keywords' WHERE id = 1";
      }
        
      $updateQuery = mysqli_query($link, $update);
      
      if ($updateQuery) {
        echo "Record updated successfully";
      } else {
        echo "Error: " . $insert . "<br>" . mysqli_error($link);
      }
    }
    
  }

  $sql = "SELECT * FROM settings WHERE id = 1";
  $result = mysqli_query($link, $sql);
?>

<?php while($setting = mysqli_fetch_array($result)) : ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Site Settings</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= ADMIN_ROOT ?>/">Home</a></li>
            <li class="breadcrumb-item active">
              Settings
            </li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form action="" method="post">
      <div class="row">
        <div class="col-md-12">
          <!-- SELECT2 EXAMPLE -->
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Site Settings</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="inputTitle">Site Name</label>
                    <input type="text" id="inputTitle" class="form-control" name="site_name"
                      value="<?= $setting['site_name'] ?>">
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label for="inputTitle">Site Desc</label>
                    <input type="text" id="inputTitle" class="form-control" name="site_desc"
                      value="<?= $setting['site_desc'] ?>" maxlength="200">
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label for="inputDesc">Site Contact</label>
                    <input type="email" id="inputTitle" class="form-control" name="site_email"
                      value="<?= $setting['site_email'] ?>" placeholder="E-mail address">
                      <input type="text" id="inputTitle" class="form-control" name="site_phone"
                      value="<?= $setting['site_phone'] ?>" minlength="5" maxlength="100" placeholder="Phone number">
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label for="inputLogo">Site Address</label>
                    <input type="url" id="inputLogo" class="form-control" name="site_address"
                      value="<?= $site['site_address'] ?>">
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label for="inputLogo">Site Currency</label>
                    <select class="form-control select2" name="site_currency" style="width: 100%;">
                      <option value="USD" <?= $setting['site_currency'] == 'USD' ? 'selected' : '' ?>>USD</option>
                      <option value="EUR" <?= $setting['site_currency'] == 'EUR' ? 'selected' : '' ?>>EUR</option>
                      <option value="GBP" <?= $setting['site_currency'] == 'GBP' ? 'selected' : '' ?>>GBP</option>
                      <option value="AUD" <?= $setting['site_currency'] == 'AUD' ? 'selected' : '' ?>>AUD</option>
                      <option value="CAD" <?= $setting['site_currency'] == 'CAD' ? 'selected' : '' ?>>CAD</option>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label for="inputLogo">Site Keywords (comma separated)</label>
                    <input type="url" id="inputLogo" class="form-control" name="site_keywords"
                      value="<?= $site['site_keywords'] ?>">
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                  <label for="inputLogo">Site Logo</label>
                    <input type="file" name="site_logo" accept="image/*">
                    <p class="help-block text-red">Max. 32MB (Leave empty if you want to retain old logo)</p>
                    <p class="help-block">
                      <?php if (!empty($setting['site_logo'])) : ?>
                        <img src="<?= $setting['site_logo'] ?>" alt="<?= $setting['site_name'] ?>" class="img-fluid" style="width:10%">
                      <?php endif; ?>
                    </p>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <!-- /.card -->
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <a href="#" onclick="window.back()" class="btn btn-secondary">Cancel</a>
          <input type="submit" value="Save Changes" class="btn btn-success float-right">
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php endwhile; ?>

<?php include_once('../../includes/footer.php'); ?>

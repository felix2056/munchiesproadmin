<?php include_once('../../includes/header.php'); ?>

<!-- Navbar -->
<?php include_once('../../includes/nav.php'); ?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php include_once('../../includes/aside.php'); ?>

<?php
  $product_id = (int) $_GET['id'];

  if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $price = mysqli_real_escape_string($link, $_POST['price']);
    $body = mysqli_real_escape_string($link, $_POST['body']) ?? '';
    $category_id = mysqli_real_escape_string($link, $_POST['category_id']);
      
    if (!empty($title) && !empty($price) && !empty($category_id)) {
      // upload image to server
      $image = NULL;
      if(!empty($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../../uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // echo json_encode($file);
    
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check == false) {
          echo "File is not an image.";
          $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
          echo "Sorry, your file is too large.";
          $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" || $imageFileType != "png" || $imageFileType != "jpeg" || $imageFileType != "gif" || $imageFileType != "webp" ) {
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

          if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
          } else {
            echo "Sorry, there was an error uploading your file.";
          }
        }

        $image = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . '://' . $_SERVER['SERVER_NAME'] . '/admin/uploads/' . basename($_FILES["image"]["name"]);
      }

      if(!empty($image)) {
        $update = "UPDATE products SET title = '$title', price = '$price', body = '$body', image = '$image', category_id = '$category_id' WHERE id = '$product_id'";
      } else {
        $update = "UPDATE products SET title = '$title', price = '$price', body = '$body', category_id = '$category_id' WHERE id = '$product_id'";
      }

      $updateQuery = mysqli_query($link, $update);
        
      if ($updateQuery) {
        echo "Record updated successfully";
        header("Location:"  . ADMIN_ROOT . "/pages/products/single.php?id=" . $product_id);
        die();
      } else {
        echo "Error: " . $insert . "<br>" . mysqli_error($link);
      }
    }
  }

  $sql = "SELECT products.*, categories.* FROM products LEFT JOIN categories ON categories.id = products.category_id WHERE products.id = '$product_id'";
  $result = mysqli_query($link, $sql);
?>

<?php while($single = mysqli_fetch_array($result)) : ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Product</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= ADMIN_ROOT ?>/">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= ADMIN_ROOT ?>/pages/products/">Products</a></li>
            <li class="breadcrumb-item active"><?= $single['title'] ?></li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Edit <?= $single['title'] ?></h3>
            </div>
            <form action="" method="post">
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                  <input class="form-control" name="title" placeholder="Title:" value="<?= $single['title'] ?>">
                </div>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                  </div>
                  <input class="form-control" name="price" placeholder="Price:" value="<?= $single['price'] ?>" type="number" step="0.01">
                </div>

                <div class="form-group">
                  <select class="form-control" name="category_id">
                    <?php
                      $sql = "SELECT * FROM categories";
                      $categories = mysqli_query($link, $sql);
                    ?>
                    <?php while($category = mysqli_fetch_array($categories)) : ?>
                      <option value="<?= $category['id'] ?>" <?= $category['id'] == $single['category_id'] ? 'selected' : '' ?>><?= $category['title'] ?></option>
                    <?php endwhile; ?>
                  </select>

                <div class="form-group">
                  <textarea id="compose-textarea" name="body" class="form-control" style="height: 300px"><?= $single['body'] ?></textarea>
                </div>

                <div class="form-group">
                  <input type="file" name="image" accept="image/*">
                  <p class="help-block text-red">Max. 32MB (Leave empty if you want to retain old image)</p>
                  <p class="help-block">
                    <?php if ($single['featured_image']) : ?>
                      <img src="<?= $single['featured_image'] ?>" alt="<?= $single['title'] ?>" class="img-fluid" style="width:20%">
                    <?php endif; ?>
                  </p>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <div class="float-right">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
                </div>
                <button type="reset" class="btn btn-default" onclick="window.back()"><i class="fas fa-times"></i>
                  Discard</button>
              </div>
              <!-- /.card-footer -->
            </form>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php endwhile; ?>

<?php include_once('../../includes/footer.php'); ?>

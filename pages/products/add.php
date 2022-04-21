<?php include_once('../../includes/header.php'); ?>

<!-- Navbar -->
<?php include_once('../../includes/nav.php'); ?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php include_once('../../includes/aside.php'); ?>

<?php
  if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $price = mysqli_real_escape_string($link, $_POST['price']);
    $body = mysqli_real_escape_string($link, $_POST['body']);
    $category_id = mysqli_real_escape_string($link, $_POST['category_id']);
    

    if (!empty($title) && !empty($price) && !empty($body) && !empty($category_id)) {
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

        // Check if file already exists
        if (file_exists($target_file)) {
          echo "Sorry, file already exists.";
          $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
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
          if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
          } else {
            echo "Sorry, there was an error uploading your file.";
          }
        }

        $image = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . '://' . $_SERVER['SERVER_NAME'] . '/uploads/' . basename($_FILES["image"]["name"]);
      }

      $insert = "INSERT INTO products (`title`, `price`, `featured_image`, `body`, `category_id`) VALUES ('$title', '$price', '$image', '$body', '$category_id')";
      $insertQuery = mysqli_query($link, $insert);
      
      if ($insertQuery) {
        echo "Record updated successfully";
        header("Location:"  . ADMIN_ROOT . "/pages/products/single.php?id=" . mysqli_insert_id($link));
        die();
      } else {
        echo "Error: " . $insert . "<br>" . mysqli_error($link);
      }
    } else {
      echo "Please fill in all fields";
    }
  }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add New Product</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= ADMIN_ROOT ?>/">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= ADMIN_ROOT ?>/pages/products/">Products</a></li>
            <li class="breadcrumb-item active">Add</li>
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
            <div class="card-header"></div>
            <form action="" method="post" enctype="multipart/form-data">
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                  <input class="form-control" name="title" placeholder="Title:">
                </div>

                <div class="form-group">
                  <!-- add input group with dollar sign -->
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">$</span>
                    </div>
                    <input class="form-control" name="price" placeholder="Price:" type="number" step="0.01">
                  </div>
                </div>

                <div class="form-group">
                  <textarea id="compose-textarea" class="form-control" name="body" placeholder="Body:" style="height: 200px"></textarea>
                </div>

                <div class="form-group">
                  <select class="form-control" name="category_id">
                    <option value="">Select Category</option>
                    <?php
                      $query = "SELECT * FROM categories";
                      $result = mysqli_query($link, $query);
                      while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                      }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <input type="file" name="image" accept="image/*">
                  <p class="help-block text-red">Max. 32MB</p>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <div class="float-right">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add</button>
                </div>
                <button type="reset" class="btn btn-default" onclick="window.back()"><i class="fas fa-times"></i> Discard</button>
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

<script>
  function deletePage(page_id, page_name) {
    var txt;
    var confirm = window.confirm("Are you sure you want to delete " + page_name + '?');
    if (confirm == true) {
      form = document.getElementById('form-' + page_id);
      form.submit();
    }
  }

</script>

<?php include_once('../../includes/footer.php'); ?>

<?php include_once('../../includes/header.php'); ?>

<!-- Navbar -->
<?php include_once('../../includes/nav.php'); ?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php include_once('../../includes/aside.php'); ?>

<?php
  if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $product_id = $_POST['product_id'] ?? null;

    if (!empty($product_id)) {
      $sql = "DELETE FROM products WHERE id = '$product_id'";
      $result = mysqli_query($link, $sql);
      echo 'deleting';
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
          <h1>Products</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= ADMIN_ROOT ?>/">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= ADMIN_ROOT ?>/pages/products">Products</a></li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- /.col -->
      <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Products</h3>

            <div class="card-tools">
                <a href="<?= ADMIN_ROOT ?>/pages/products/add.php" class="btn btn-success btn-sm">Add <i class="fa fa-plus"></i></a>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="table-responsive mailbox-messages">
                <?php
                    $sql = "SELECT products.*, categories.name AS product_category FROM products LEFT JOIN categories ON products.category_id = categories.id GROUP BY products.id ORDER BY products.created_at DESC";
                    $result = mysqli_query($link, $sql);
                ?>
                <?php if ($result && mysqli_num_rows($result) > 0) : ?>
                <table class="table table-hover table-striped">
                    <tbody>
                        <tr>
                            <th>S/N</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Action</th>
                        </tr>
                        <?php 
                          $index = 0;
                          while($product = mysqli_fetch_array($result)) : 
                        ?>
                        <?php $index++ ?>
                          <tr>
                            <form action="" method="POST" id="form-<?= $product['id'] ?>" style="display: none;">
                              <input type="hidden" name="page_id" value="<?= $product['id'] ?>">
                            </form>

                            <td class="mailbox-star">
                              <?= $index ?>
                            </td>
                            <td class="mailbox-name">
                              <a href="<?= ADMIN_ROOT ?>/pages/products/single.php?id=<?= $product['id'] ?>"><?= $product['title'] ?></a>
                            </td>
                            <td class="mailbox-name">
                              <?= $product['price'] ?>
                            </td>
                            <td class="mailbox-name">
                              <?= $product['product_category'] ?>
                            </td>
                            <td class="mailbox-name">
                              <img src="<?= $product['featured_image'] ?>" alt="<?= $product['title'] ?>" width="100">
                            </td>
                            <td class="mailbox-date"><?= date('F d, Y', strtotime($product['created_at'])) ?></td>
                            <td class="mailbox-date"><?= date('F d, Y', strtotime($product['updated_at'])) ?></td>
                            <td class="project-actions d-flex text-right">
                              <a class="btn btn-info btn-sm" href="<?= ADMIN_ROOT ?>/pages/products/edit.php?id=<?= $product['id'] ?>">
                                <i class="fas fa-pencil-alt"></i>
                              </a>
                              <a class="btn btn-danger btn-sm" href="#" onclick="deleteProduct('<?= $product['id'] ?>', '<?= $product['title'] ?>')">
                                <i class="fas fa-times"></i>
                              </a>
                            </td>
                          </tr>
                        <?php endwhile ;?>
                    </tbody>
                </table>
                <!-- /.table -->
                <?php endif ;?>
            </div>
            <!-- /.mail-box-messages -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    function deletePage(product_id, product_title) {
        var confirm = window.confirm("Are you sure you want to delete " + product_title + '?');
        if (confirm == true) {
            form = document.getElementById('form-' + product_id);
            form.submit();
        }
    }
</script>

<?php include_once('../../includes/footer.php'); ?>
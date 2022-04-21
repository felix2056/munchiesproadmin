<?php include_once('includes/header.php'); ?>

<!-- Navbar -->
<?php include_once('includes/nav.php'); ?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php include_once('includes/aside.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Munchies Pro Admin Panel</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Munchies Pro Admin Panel</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <?php
        $categoryCountSql = "SELECT COUNT(*) AS total_categories FROM categories";
        $categoryCountQuery = mysqli_query($link, $categoryCountSql);

        $productCountSql = "SELECT COUNT(*) AS total_products FROM products";
        $productCountQuery = mysqli_query($link, $productCountSql);

        $userCountSql = "SELECT COUNT(*) AS total_users FROM users";
        $userCountQuery = mysqli_query($link, $userCountSql);
      ?>

      <!-- Info boxes -->
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cog"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">CPU Traffic</span>
              <span class="info-box-number">
                10
                <small>%</small>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <?php while($count = mysqli_fetch_array($categoryCountQuery)) : ?>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fa fa-list-alt"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Categories</span>
              <span class="info-box-number"><?= $count['total_categories'] ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <?php endwhile; ?>


        <?php while($count = mysqli_fetch_array($productCountQuery)) : ?>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Products</span>
              <span class="info-box-number"><?= $count['total_products'] ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <?php endwhile; ?>

        <?php while($count = mysqli_fetch_array($userCountQuery)) : ?>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Members</span>
              <span class="info-box-number"><?= $count['total_users'] ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <?php endwhile; ?>
      </div>
      <!-- /.row -->

      <?php
        $categoriesSql = "SELECT categories.name, categories.created_at, categories.updated_at, COUNT(products.id) AS products_count FROM categories LEFT JOIN products ON products.category_id = categories.id GROUP BY categories.id ORDER BY categories.created_at DESC LIMIT 10";
        $categoriesQuery = mysqli_query($link, $categoriesSql);
      ?>

      <?php if ($categoriesQuery && mysqli_num_rows($categoriesQuery) > 0) : ?>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Recent Categories</h3>

              <div class="card-tools">
                <span class="badge badge-danger"><?= mysqli_num_rows($categoriesQuery) ?> Categories</span>
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
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Products</th>
                    <th>Created On</th>
                    <th>Updated On</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $index = 0;
                    while($category = mysqli_fetch_array($categoriesQuery)) : 
                  ?>
                  <tr>
                    <?php $index++ ?>
                    <td><?= $index ?></td>
                    <td><?= $category['name'] ?></td>
                    <td><?= $category['products_count'] ?></td>
                    <td><?= date('F d, Y', strtotime($category['created_at'])) ?></td>
                    <td><?= date('F d, Y', strtotime($category['updated_at'])) ?></td>
                  </tr>
                  <?php endwhile; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Products</th>
                    <th>Created On</th>
                    <th>Updated On</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <?php endif; ?>


      <?php
        $productsSql = "SELECT products.*, categories.name AS product_category FROM products LEFT JOIN categories ON products.category_id = categories.id GROUP BY categories.id ORDER BY products.created_at DESC LIMIT 10";
        $productsQuery = mysqli_query($link, $productsSql);
      ?>

      <?php if ($productsQuery && mysqli_num_rows($productsQuery) > 0) : ?>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Recent Products</h3>

              <div class="card-tools">
                <span class="badge badge-danger"><?= mysqli_num_rows($productsQuery) ?> Products</span>
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
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>S/N</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Featured Image</th>
                    <th>Created On</th>
                    <th>Updated On</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $index = 0;
                    while($product = mysqli_fetch_array($productsQuery)) : 
                  ?>
                  <tr>
                    <?php $index++ ?>
                    <td><?= $index ?></td>
                    <td><?= $product['title'] ?></td>
                    <td><?= $product['price'] ?></td>
                    <td><?= $product['product_category'] ?></td>
                    <td><img src="<?= $product['featured_image'] ?>" alt="<?= $product['title'] ?>" class="img-fluid" width="100"></td>
                    <td><?= date('F d, Y', strtotime($product['created_at'])) ?></td>
                    <td><?= date('F d, Y', strtotime($product['updated_at'])) ?></td>
                  </tr>
                  <?php endwhile; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>S/N</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Featured Image</th>
                    <th>Created On</th>
                    <th>Updated On</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <?php endif; ?>
      
      <?php
        $usersSql = "SELECT * FROM users LIMIT 8";
        $usersQuery = mysqli_query($link, $usersSql);
      ?>

      <?php if ($usersQuery && mysqli_num_rows($usersQuery) > 0) : ?>
      <!-- Main row -->
      <div class="row">
        <div class="col-md-12">
          <!-- USERS LIST -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">All Members</h3>

              <div class="card-tools">
                <span class="badge badge-danger"><?= mysqli_num_rows($usersQuery) ?> Members</span>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="users-list clearfix">
                <?php while($user = mysqli_fetch_array($usersQuery)) : ?>
                <li>
                  <a href="<?= ADMIN_ROOT ?>/pages/users/profile.php?user=<?= $user['id'] ?>">
                    <img src="<?= ADMIN_ROOT . $user['avatar']; ?>" alt="User Image" style="cursor: pointer;">
                  </a>

                  <a class="users-list-name" href="<?= ADMIN_ROOT ?>/pages/users/profile.php?user=<?= $user['id'] ?>">
                    <?= $user['name']; ?>
                  </a>
                  <span class="users-list-date"><?= date('F d, Y', strtotime($user['created_at'])) ?></span>
                </li>
                <?php endwhile; ?>
              </ul>
              <!-- /.users-list -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
              <a href="<?= ADMIN_ROOT ?>/pages/users">View All Users</a>
            </div>
            <!-- /.card-footer -->
          </div>
          <!--/.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.col -->
      <?php endif; ?>
    </div>
    <!-- /.row -->
</div>
<!--/. container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->


<?php include_once('includes/footer.php'); ?>

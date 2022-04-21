<?php
    $website = (string) $_GET['website'] ?? null;
    $sidebarSql = "SELECT * FROM pages WHERE clone_name = '$website' ORDER BY title ASC";
    $sidebarQuery = mysqli_query($link, $sidebarSql);
?>

<?php if ($sidebarQuery && mysqli_num_rows($sidebarQuery) > 0) : ?>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Pages</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse">
        <i class="fas fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="card-body p-0">
    <ul class="nav nav-pills flex-column">
    <?php while($sidebarPage = mysqli_fetch_array($sidebarQuery)) : ?>
      <li class="nav-item active">
        <a href="<?= ADMIN_ROOT ?>/pages/clones/pages/page.php?id=<?= $sidebarPage['id'] ?>&website=<?=  $website ?>" class="nav-link">
          <i class="fa fa-book"></i> <?= $sidebarPage['title'] ?>
        </a>
      </li>
      <?php endwhile; ?>
    </ul>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->
<?php endif ;?>

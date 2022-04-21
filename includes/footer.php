<footer class="main-footer">
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 1.1.0
  </div>
</footer>

<!-- Main Footer -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?= ADMIN_ROOT ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?= ADMIN_ROOT ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= ADMIN_ROOT ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= ADMIN_ROOT ?>/dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?= ADMIN_ROOT ?>/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?= ADMIN_ROOT ?>/plugins/raphael/raphael.min.js"></script>
<script src="<?= ADMIN_ROOT ?>/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?= ADMIN_ROOT ?>/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="<?= ADMIN_ROOT ?>/plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="<?= ADMIN_ROOT ?>/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= ADMIN_ROOT ?>/dist/js/pages/dashboard2.js"></script>

<!-- Summernote -->
<script src="<?= ADMIN_ROOT ?>/plugins/summernote/summernote-bs4.min.js"></script>

<script>
  $(function () {
    //Add text editor
    $('#compose-textarea').summernote(
      {
        height: 200,
        placeholder: 'Write content here...'
      }
    )
  })
</script>
</body>

</html>

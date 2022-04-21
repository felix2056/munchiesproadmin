<?php
ob_start();
session_start();

define("DB_HOST", 'localhost'); //localhost
define("DB_USER", 'root'); //root
define("DB_PASS", ''); //
define("DB_NAME", 'admin_cls'); //root

define("ADMIN_ROOT", '/admin'); // change to your directory ('/admin')

// Open up a new MySQLi connection to the MySQL database
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME); // Change these to your own DB credentials

if($link === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}

if (!isset($_SESSION['id']) && !isset($_SESSION['email'])) {
    header("Location: " . ADMIN_ROOT .'/login');
    exit();
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == 'logout') {
        session_unset();
        session_destroy();
        
        header("Location: " . ADMIN_ROOT . "/login");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= ADMIN_ROOT ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= ADMIN_ROOT ?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= ADMIN_ROOT ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= ADMIN_ROOT ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= ADMIN_ROOT ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= ADMIN_ROOT ?>/plugins/summernote/summernote-bs4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= ADMIN_ROOT ?>/dist/css/adminlte.min.css">
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

  <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="<?= ADMIN_ROOT ?>/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

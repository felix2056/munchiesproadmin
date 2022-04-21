<?php
session_start();

define("DB_HOST", 'localhost'); //localhost
define("DB_USER", 'root'); //root
define("DB_PASS", ''); //
define("DB_NAME", 'admin_cls'); //root

define("ADMIN_ROOT", '/admin'); // change to your directory ('/admin')

// Open up a new MySQLi connection to the MySQL database
$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME); // Change these to your own DB credentials

if($connect === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= ADMIN_ROOT ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= ADMIN_ROOT ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= ADMIN_ROOT ?>/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
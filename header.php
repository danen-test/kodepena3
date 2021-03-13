<?php
include "conf_config.php";


$query_data_komunitas = mysqli_query($conn, "select * from data_komunitas");
$data_komunitas = mysqli_fetch_assoc($query_data_komunitas);

$query_data_logo = mysqli_query($conn, "select * from logo");
$data_logo = mysqli_fetch_assoc($query_data_logo);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $data_komunitas["nama_komunitas"]; ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Template Main CSS File -->
  <link href="assets/css/styles.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: BizLand - v1.2.0
  * Template URL: https://bootstrapmade.com/bizland-bootstrap-business-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="d-none d-lg-flex align-items-center fixed-top">
    <div class="container d-flex">
      <div class="contact-info mr-auto">
        <i class="icofont-envelope"></i> <a href="mailto:contact@example.com"><?php echo $data_komunitas['email']; ?></a>
        <i class="icofont-phone"></i> <?php echo $data_komunitas['tlp']; ?>
      </div>
      <div class="social-links">
        <a <?php if ($data_komunitas['link_twitter'] == '') {echo "style='display:none'";} ?> href="<?php echo $data_komunitas['link_twitter']; ?>" class="twitter"><i class="icofont-twitter"></i></a>
        <a <?php if ($data_komunitas['link_facebook'] == '') {echo "style='display:none'";} ?> href="<?php echo $data_komunitas['link_facebook']; ?>" class="facebook"><i class="icofont-facebook"></i></a>
        <a <?php if ($data_komunitas['link_instagram'] == '') {echo "style='display:none'";} ?> href="<?php echo $data_komunitas['link_instagram']; ?>" class="instagram"><i class="icofont-instagram"></i></a>
      </div>
    </div>
  </div>

    
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo mr-auto"><a href="index.html"><img src="logo/<?php echo $data_logo['nama_logo']; ?>" alt="Logo"></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt=""></a>-->

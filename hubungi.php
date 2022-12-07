<?php
include 'config.php';
include 'koneksi.php';
include 'assets/lib/function.php';
include 'query_header.php';

$sql_kontak = $con->query("SELECT * FROM kontak ORDER BY kd_kontak");
$row_kontak = $sql_kontak->fetch(PDO::FETCH_LAZY);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- <link rel="icon" href="../images/favicon.ico"> -->

  <title></title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/animate.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/sweetalert.css">
  <link rel="stylesheet" href="assets/fontawesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/jquery.bootstrap-touchspin.min.css">
  <link rel="stylesheet" href="assets/css/fileinput.css">
</head>

<body>
  <?php include 'header.php'; ?>
  <?php include 'slidecari.php'; ?>
  <div class="container">

    <div class="row">


      <div class="col-md-12">
        <ol class="breadcrumb">
          <li><a href="./">Home</a></li>
          <li class="active">Hubungi Kami</li>
        </ol>
        <h4>Hubungi Kami</h4>
        <?php do { ?>
          <address>
            <strong><?php echo $row_kontak['kontak']; ?></strong><br>
            <?php echo $row_kontak['isi_kontak']; ?><br>
          </address>
        <?php } while ($row_kontak = $sql_kontak->fetch()); ?>
      </div>
      <!-- /.row -->
    </div>
  </div>
  <!-- /.container -->

  <?php include 'footer.php'; ?>

  <!-- Bootstrap core JavaScript
        ================================================== -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/validasi.js"></script>
  <script src="assets/js/validasiinput.js"></script>
</body>

</html>
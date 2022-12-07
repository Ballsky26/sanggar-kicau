<?php
include 'config.php';
include 'koneksi.php';
include 'assets/lib/function.php';
include 'query_header.php';
include 'hapus_otomatis.php';


$sql_kontak = $con->query("SELECT * FROM kontak ORDER BY kd_kontak");
$row_kontak = $sql_kontak->fetch(PDO::FETCH_LAZY);

$sql_halaman = $con->query("SELECT * FROM halaman");
$row_halaman = $sql_halaman->fetch(PDO::FETCH_LAZY);

$sql_tentang = $con->query("SELECT * FROM halaman WHERE nama_halaman='Tentang'");
$row_tentang = $sql_tentang->fetch(PDO::FETCH_LAZY);

$sql_footer_kategori = $con->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
$row_footer_kategori = $sql_footer_kategori->fetch(PDO::FETCH_LAZY);

$sql_rekening = $con->query("SELECT * FROM rekening");
$row_rekening = $sql_rekening->fetch(PDO::FETCH_LAZY);

$sql_footer_kategori2 = $con->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
$row_footer_kategori2 = $sql_footer_kategori2->fetch(PDO::FETCH_LAZY);

$sql_produk_home = $con->query("SELECT * FROM produk ORDER BY kd_produk ASC");
$row_produk_home = $sql_produk_home->fetch(PDO::FETCH_LAZY);
$trow_produk_home = $sql_produk_home->rowCount();

$sql_produk_baru = $con->query("SELECT * FROM produk ORDER BY tgl_produk DESC");
$row_produk_baru = $sql_produk_baru->fetch(PDO::FETCH_LAZY);
$trow_produk_baru = $sql_produk_baru->rowCount();
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
  <link rel="stylesheet" href="assets/fontawesome/css/font-awesome.min.css">
</head>

<body>

  <?php include 'header.php'; ?>
  <?php include 'slidecari.php'; ?>
  <div class="container">

    <div class="konten">
      <?php echo "<h4><b>PRODUK YANG TERSEDIA<b></h4><p>"; ?>
      <div class="row">
        <?php do {
          if ($row_produk_baru['diskon'] != null and $row_produk_baru['diskon'] != "0") {
            $ndskn = $row_produk_baru['diskon'];
            $nilai_harga = uang($row_produk_baru['harga']);
            $diskon = tampilDiskon($row_produk_baru['diskon']);
            $hargaBarang = '<i style="text-decoration: line-through; color: #898989">' . $nilai_harga . '</i>';
            $hargaDiskon = uang(hargaDiskon($row_produk_baru['diskon'], $row_produk_baru['harga']));
          } else {
            $diskon = '';
            $hargaBarang = uang($row_produk_baru['harga']);
            $hargaDiskon = "";
          }

        ?>
          <div class="col-sm-2 col-lg-2 col-md-2">
            <div class="thumbnail">
              <div class="gproduk"> <img src="assets/images/produk/<?php echo $row_produk_baru['foto']; ?>" width="100%">
              </div>
              <div class="caption">
                <!-- <h4 class="pull-right">$24.99</h4> -->
                <p> <a href="detail_produk?kd_produk=<?php echo $row_produk_baru['kd_produk']; ?>"><?php echo $row_produk_baru['nama_produk']; ?></a>
                </p>
              </div>
              <div class="harga">
                <p class="text-right"> <?php echo $diskon; ?><?php echo $hargaBarang; ?>
                  <br>
                  <?php if ($row_produk_baru['stok'] > 0) {
                    echo "Stok (" . $row_produk_baru['stok'] . ")";
                  } else {
                    echo "STOK HABIS";
                  } ?>
                  <?php echo $hargaDiskon; ?>
                </p>

              </div>
            </div>
          </div>
        <?php } while ($row_produk_baru = $sql_produk_baru->fetch()); ?>
      </div>

    </div>
  </div>
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
  <script src="assets/js/app.js"></script>
</body>

</html>
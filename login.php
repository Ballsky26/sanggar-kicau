<?php 
include 'config.php';
include 'koneksi.php';
include 'assets/lib/function.php';
include 'query_header.php';

$error = "";
$halaman = "login";

if ((isset($_POST["flogin"])) && ($_POST["flogin"] == "y")) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql_cari = $con->query("SELECT * FROM user WHERE userid='$username' AND password='$password' AND tipe='Pelanggan' AND status='Y' ");
    $row_cari = $sql_cari->fetch(PDO::FETCH_LAZY);
    $trow_cari = $sql_cari->rowCount();

    // jika data ada
    if (!empty($trow_cari)) {

        // Deklarasi variable pelanggan
        $_SESSION['pelanggan'] = $row_cari->userid;
        $userid = $_SESSION['pelanggan'];

        include 'cek_status_faktur.php';

        // jika sudah melakukan pembelian
        if (isset($_SESSION['temp_kd_produk'])) {

            // Deklarasi Variable
            $temp_kd_produk = $_SESSION['temp_kd_produk'];
            $temp_jml_beli = $_SESSION['temp_jml_beli'];
            $temp_harga_produk = $_SESSION['temp_harga_produk'];


            // proses simpan ke table order_produk
            $con->exec("INSERT INTO order_produk (kd_faktur, kd_produk, harga_produk, jml_beli) 
                    VALUES (
                    '".$kd_faktur."',
                    '".$temp_kd_produk."',
                    '".$temp_harga_produk."',
                    '".$temp_jml_beli."'
                    )");
            $con->exec("UPDATE produk SET stok=stok-$temp_jml_beli WHERE kd_produk='$temp_kd_produk' ");

            unset($_SESSION['temp_kd_produk']);
            unset($_SESSION['temp_jml_beli']);
            unset($_SESSION['temp_harga_produk']);
            $halaman = "daftar_pembelian";

        } else { // belum beli

            $halaman = "./";
        }
        
        header("Location: " . $halaman );
    } else { // tidak ada data

        $error = '<div class="alert alert-danger" role="alert">Email / Password yang Anda masukkan salah.</div>';
    }
    
}
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
        <link rel="stylesheet" href="assets/css/toko.css">
        <link rel="stylesheet" href="assets/fontawesome/css/font-awesome.min.css">
    </head>
    <body style="padding-top: 35px">

        <?php // include 'header.php'; ?>

        <div class="container">

            <div class="row">

                
    <div class="col-md-12"> 
      <div class="login-header"> 
        <!-- <a href="./"><img src="assets/images/logo.png" width="200"></a> -->
        <h3>Masuk Sanggar Kicau</h3>
        <p>Belum punya akun? Daftar <a href="daftar">di sini</a></p>
      </div>
      <div class="row input-login"> 
        <div class="col-md-12"> <?php echo $error; ?> 
          <form method="POST">
            <div class="form-group" id="f-username"> 
              <div class="input-group col-xs-12" data-validate="email"> 
                <input type="email" class="form-control" id="username" name="username" placeholder="email" autocomplete="off" required autofocus>
                <span class="input-group-addon danger" style="display: none;"></span> 
              </div>
            </div>
            <div class="form-group" id="f-password"> 
              <div class="input-group col-xs-12"> 
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required>
                <span class="input-group-addon danger" style="display: none;"></span> 
              </div>
            </div>
            <button name="flogin" value="y" type="submit" class="btn btn-success btn-block"> 
            Masuk ke <?php echo $nama_perusahaan; ?> </button>
			<p>&nbsp;</p>
			<p align="center">Lupa Password? Klik <a href="forgot">di sini</a></p>
          </form>
        </div>
      </div>
    </div>

            </div>

        </div>

        <div class="container" style="text-align: center">
            <footer>
                <div class="row">
                    
    <div class="col-lg-12"> 
      <p>Copyright &copy; <a href="./"><?php echo $nama_perusahaan."</a> ".date("Y"); ?> 
      </p>
    </div>
                </div>
            </footer>
        </div>
        <!-- /.container -->

        <?php // include 'footer.php'; ?>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/validasi.js"></script>
        <script src="assets/js/validasiinput.js"></script>
    </body>
</html>
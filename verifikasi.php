<?php
include 'config.php';
include 'koneksi.php';
include 'assets/lib/function.php';
include 'assets/lib/rajaongkir.php';
include 'query_header.php';

$error = "";
$error = "<div class='alert alert-success alert-dismissible animated fadeIn' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
                </button>
                <strong>Berhasil!</strong> Email anda telah terverifikasi
            </div>";

$user = $_GET['user'];
$kode = $_GET['kode'];

$sql_user = $con->query("SELECT * FROM user WHERE userid='$user' ");
$row_user = $sql_user->fetch(PDO::FETCH_LAZY);

if ($row_user['kode'] == $kode) {
    $con->exec("UPDATE user SET status='Y' WHERE userid='$user' ");
    $error = "<div class='alert alert-success alert-dismissible animated fadeIn' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
                </button>
                <strong>Berhasil!</strong> Email anda telah terverifikasi
            </div>";

    $_SESSION['pelanggan'] = $user;
    include 'cek_status_faktur.php';
    echo '<script type="text/javascript">setTimeout(function(){window.top.location="./"} , 2000);</script>';
} else {
    $error = "<div class='alert alert-danger alert-dismissible animated fadeIn' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
                </button>
                <strong>Maaf!</strong> Verifikasi email gagal
            </div>";
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
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/fontawesome/css/font-awesome.min.css">
</head>

<body style="padding-top: 35px">

    <?php // include 'header.php'; 
    ?>

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <div class="login-header">
                    <a href="./"><img src="assets/images/logo.png" width="200"></a>
                </div>

                <div class="row input-login">
                    <div class="col-md-12">
                        <?php echo $error; ?>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="container" style="text-align: center">
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; <a href="./"><?php echo $nama_perusahaan . "</a> " . date("Y"); ?>
                    </p>
                </div>
            </div>
        </footer>
    </div>
    <!-- /.container -->

    <?php // include 'footer.php'; 
    ?>

    <!-- Bootstrap core JavaScript
        ================================================== -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/validasi.js"></script>
    <script src="assets/js/validasiinput.js"></script>
</body>

</html>
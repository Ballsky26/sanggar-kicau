<?php
include 'config.php';
include 'koneksi.php';
include 'assets/lib/function.php';
include 'query_header.php';

$sql_rekening = $con->query("SELECT * FROM rekening");
$row_rekening = $sql_rekening->fetch(PDO::FETCH_LAZY);
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
                    <li class="active">Rekening Pembayaran</li>
                </ol>
                <h4>Rekening</h4>
                <?php do { ?>
                    <address>
                        <strong><?php echo $row_rekening['bank']; ?></strong><br>
                        a.n. Susiana<br>
                        <?php echo $row_rekening['no_rek']; ?><br>
                    </address>
                <?php } while ($row_rekening = $sql_rekening->fetch()); ?>
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
    <script src="assets/js/sweetalert.js"></script>
    <script src="assets/js/file-input/fileinput.js" type="text/javascript"></script>
    <script src="assets/js/file-input/fileinput_locale_LANG.js" type="text/javascript"></script>
    <script>
        $("#bukti").fileinput({
            overwriteInitial: true,
            maxFileSize: 10000,
            showClose: false,
            showCaption: false,
            browseLabel: '',
            removeLabel: '',
            browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
            removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
            removeTitle: 'Batalkan',
            elErrorContainer: '#kv-avatar-errors',
            msgErrorClass: 'alert alert-block alert-danger',
            // defaultPreviewContent: '<img src="../assets/images/produk/produk.png" style="width:250px">',
            // layoutTemplates: {main2: '{preview} {browse}'},
            allowedFileExtensions: ["jpg", "png", "gif"]
        });
    </script>
</body>

</html>
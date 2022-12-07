<?php
include 'config.php';
include 'koneksi.php';
include 'assets/lib/function.php';
include 'query_header.php';

$judul = "";
if (isset($_GET['kategori'])) {
    $kategori = str_replace("_", " ", $_GET['kategori']);
    $sql_produk_home = $con->query("SELECT a.*, b.* FROM produk AS a, kategori AS b WHERE b.kd_kategori = a.kd_kategori AND b.nama_kategori LIKE '%$kategori%' ");
    $judul = '<h4>Kategori: <i class="text-kategori">"' . $kategori . '"</i></h4><hr>';
} else if (isset($_GET['cari_barang'])) {
    $barang = str_replace("%", " ", $_GET['cari_barang']);
    if (empty($barang)) {
        $sql_produk_home = $con->query("SELECT * FROM produk ORDER BY tgl_produk DESC");
    } else {
        $sql_produk_home = $con->query("SELECT a.*, b.* FROM produk AS a, kategori AS b WHERE  b.kd_kategori = a.kd_kategori HAVING b.nama_kategori LIKE '%$barang%' OR a.nama_produk LIKE  '%$barang%'");
        $judul = '<h4>Hasil pencarian: <i class="text-kategori">"' . $barang . '"</i></h4><hr>';
    }
} else {
    $sql_produk_home = $con->query("SELECT * FROM produk ORDER BY tgl_produk DESC");
}

$row_produk_home = $sql_produk_home->fetch(PDO::FETCH_LAZY);
$trow_produk_home = $sql_produk_home->rowCount();
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

    <div class="container">

        <div class="row">

            <!-- <div class="col-md-3">
                    <p class="lead">Shop Name</p>
                    <div class="list-group">
                        <a href="#" class="list-group-item">List 1</a>
                        <a href="#" class="list-group-item">List 2</a>
                        <a href="#" class="list-group-item">List 3</a>
                    </div>
                </div> -->


            <div class="col-md-12">
                <?php if (!empty($trow_produk_home)) : ?>
                    <?php echo $judul; ?>
                    <div class="row">
                        <?php do {
                            if ($row_produk_home['diskon'] != null and $row_produk_home['diskon'] != "0") {
                                $ndskn = $row_produk_home['diskon'];
                                $nilai_harga = uang($row_produk_home['harga']);
                                $diskon = tampilDiskon($row_produk_home['diskon']);
                                $hargaBarang = '<i style="text-decoration: line-through; color: #898989">' . $nilai_harga . '</i>';
                                $hargaDiskon = uang(hargaDiskon($row_produk_home['diskon'], $row_produk_home['harga']));
                            } else {
                                $diskon = '';
                                $hargaBarang = uang($row_produk_home['harga']);
                                $hargaDiskon = "";
                            }

                        ?>
                            <div class="col-sm-2 col-lg-2 col-md-2">
                                <div class="thumbnail">
                                    <div class="gproduk"> <img src="assets/images/produk/<?php echo $row_produk_home['foto']; ?>" width="100%">
                                    </div>
                                    <div class="caption">
                                        <!-- <h4 class="pull-right">$24.99</h4> -->
                                        <p> <a href="detail_produk?kd_produk=<?php echo $row_produk_home['kd_produk']; ?>"><?php echo $row_produk_home['nama_produk']; ?></a>
                                        </p>
                                    </div>
                                    <div class="harga">
                                        <p class="text-right"> <?php echo $diskon; ?><?php echo $hargaBarang; ?>
                                            <br>
                                            <?php echo $hargaDiskon; ?>
                                        </p>
                                    </div>
                                    <br>
                                    <?php echo stok($row_produk_home['stok']); ?>
                                </div>
                            </div>
                        <?php } while ($row_produk_home = $sql_produk_home->fetch()); ?>
                    </div>
                <?php else : ?>
                    <p class="well text-center"> Maaf, hasil pencarian tidak ditemukan. </p>
                <?php endif; ?>
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
</body>

</html>
<?php
include 'config.php';
include 'koneksi.php';
include 'assets/lib/function.php';
include 'query_header.php';

if ((isset($_POST["fterima"])) && ($_POST["fterima"] == "y")) {

  $kd_faktur   = $_POST['kd_faktur'];
  $tgl_terima  = date("Y-m-d h:i:s");

  $con->exec("UPDATE faktur SET tgl_terima='$tgl_terima' WHERE kd_faktur='$kd_faktur' ");
  // pesan berhasil
  tampilPesan("Berhasil Disimpan!", "Barang telah diterima!", "success", "transaksi");
}

if ((isset($_POST["fbayarcod"])) && ($_POST["fbayarcod"] == "y")) {

  $kd_faktur   = $_POST['kd_faktur'];

  $con->exec("UPDATE faktur SET konfirm='Sudah' WHERE kd_faktur='$kd_faktur' ");
  // pesan berhasil
  tampilPesan("Berhasil Disimpan!", "Konfirmasi Pembayaran Tunai Selesai!", "success", "transaksi");
}

$id = $_SESSION['pelanggan'];
$sql = $con->query("SELECT * FROM faktur WHERE userid='$id' AND konfirm!='Belum' ORDER BY tgl DESC");
$row = $sql->fetch(PDO::FETCH_LAZY);
$trow = $sql->rowCount();
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
  <div class="container" style="margin-bottom: 150px">

    <div class="row">


      <div class="col-md-12">
        <ol class="breadcrumb">
          <li><a href="./">Home</a></li>
          <li class="active">Transaksi</li>
        </ol>
        <hr>
        <h3>Transaksi</h3>
        <table id="tabel" class="table table-bordered" cellspacing="0" width="100%" style="font-size: 12px">
          <thead>
            <tr>
              <th width="20%">Detail Transaksi</th>
              <th width="auto">Barang</th>
              <th width="20%">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php do {
              $faktur = $row['kd_faktur'];
            ?>
              <tr>
                <td>
                  <h5><a href="detail_transaksi?faktur=<?php echo $faktur; ?>"><?php echo $row['kd_faktur']; ?></a></h5>
                  <?php echo longDate($row['tgl']); ?> <br>
                </td>
                <?php
                $sql_penjualan = $con->query("SELECT a.*, b.* FROM penjualan as a, produk as b WHERE a.kd_faktur='$faktur' AND b.kd_produk=a.kd_produk ");
                $row_penjualan = $sql_penjualan->fetch(PDO::FETCH_LAZY);
                $trow_penjualan = $sql_penjualan->rowCount();
                ?>
                <td>
                  <?php do { ?>
                    <div class="media">
                      <div class="media-left">
                        <div class="gproduk-sm"> <img src="assets/images/produk/<?php echo $row_penjualan['foto']; ?>" width="100">
                        </div>
                      </div>
                      <div class="media-body" data-id="<?php echo $row_penjualan['kd_produk']; ?>">
                        <h5 class="media-heading"><?php echo $row_penjualan['nama_produk']; ?></h5>
                        <b><?php echo $row_penjualan['jml_beli']; ?> Barang</b>
                      </div>
                    </div>
                  <?php } while ($row_penjualan = $sql_penjualan->fetch()); ?>
                </td>
                <td>
                  <?php if ($row['konfirm'] == 'Sudah') : ?>
                    <?php
                    if ($row['konfirm'] == 'Sudah') {
                      if ($row['tgl_kirim'] == NULL) {
                        echo "Barang Sedang Kami Proses";
                      } else {
                        if ($row['tgl_terima'] == NULL) {
                          echo "Barang dalam Pengiriman <br>";
                        } else {
                          echo "Barang sudah diterima <br>";
                        }
                        echo "<b>No. Resi : " . $row['resi'] . "<b><br>";
                        echo "<b>Tgl. Kirim : " . longDatepukul($row['tgl_kirim']) . "<b>";
                        if ($row['tgl_terima'] == NULL) { ?>
                          <form method="POST" enctype="multipart/form-data">
                            <button type="submit" class="btn btn-success">Terima Barang</button>
                            <input type="hidden" name="fterima" value="y" />
                            <input type="hidden" name="kd_faktur" value="<?php echo $row['kd_faktur']; ?>" />
                          </form>
                    <?php
                        } else {
                          echo "<br><b>Tgl. Terima Barang : " . longDatepukul($row['tgl_terima']) . "<b>";
                        }
                      }
                    }
                    ?>
                  <?php else : ?>
                    <?php if ($row['pembayaran'] == 'COD') : ?>
                      <form method="POST" enctype="multipart/form-data">
                        <button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button>
                        <input type="hidden" name="fbayarcod" value="y" />
                        <input type="hidden" name="kd_faktur" value="<?php echo $row['kd_faktur']; ?>" />
                      </form>
                    <?php else : ?>
                      <a href="konfirmasi?faktur=<?php echo $faktur; ?>" class="btn btn-success btn-block">Konfirmasi
                        Pembayaran</a>
                    <?php endif ?>
                    <p class="text-justify">Segera lakukan konfirmasi pembayaran sebelum
                      tanggal <?php echo longDatepukul2($row['tgl']); ?></p>
                  <?php endif ?>

                </td>
              </tr>
            <?php } while ($row = $sql->fetch()); ?>
          </tbody>
        </table>
      </div>

    </div>
    <!-- /.row -->

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
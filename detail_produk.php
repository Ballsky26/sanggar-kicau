<?php
include 'config.php';
include 'koneksi.php';
include 'assets/lib/function.php';
include 'query_header.php';


// jika menekan tombol beli
if ((isset($_POST["beli"])) && ($_POST["beli"] == "y")) {

  $kd_produk = $_POST['kd_produk'];
  $jml_beli = $_POST['jml_beli'];
  $harga_produk = $_POST['harga_produk'];

  // jika belum login
  if (!isset($_SESSION['pelanggan'])) {
    $_SESSION['temp_kd_produk'] = $kd_produk;
    $_SESSION['temp_jml_beli'] = $jml_beli;
    $_SESSION['temp_harga_produk'] = $harga_produk;
    // dialihkan ke halaman login
    $halaman = "login";
  } else {
    $userid = $_SESSION['pelanggan'];
    include 'cek_status_faktur.php';

    // proses simpan ke table penjualan
    $con->exec("INSERT INTO penjualan (kd_faktur, kd_produk, harga_produk, jml_beli) 
	                VALUES (
	                '" . $kd_faktur . "',
	                '" . $kd_produk . "',
	                '" . $harga_produk . "',
	                '" . $jml_beli . "'
	                )");

    $con->exec("UPDATE produk SET stok=stok-$jml_beli WHERE kd_produk='$kd_produk' ");

    $halaman = "daftar_pembelian";
  }

  header("Location: " . $halaman);
} // end if tekan tombol

// jika menekan tombol testimoni
if ((isset($_POST["ftestimoni"])) && ($_POST["ftestimoni"] == "y")) {
  $kd_produk    = $_POST['kd_produk'];
  $userid       = $_POST['userid'];
  $isi_testimoni = $_POST['isi_testimoni'];

  $con->exec("INSERT INTO testimoni (kd_produk, userid, isi_testimoni) 
	                VALUES (
	                '" . $kd_produk . "',
	                '" . $userid . "',
	                '" . $isi_testimoni . "'
	                )");
  tampilPesan("Konfirmasi Berhasil!", "testimoni anda berhasil dikirim!", "success", "detail_produk?kd_produk=$kd_produk");
}

// jika tidak mendapatkan nilai kd_produk dari halaman sebelumnya
if (!isset($_GET['kd_produk'])) {

  // diambilkan nilai kd_produk yang dikirim ketika menekan tombol beli
  $kd_produk = $_POST['kd_produk'];
} else {
  $kd_produk = $_GET['kd_produk'];
}

$sql_detail_p = $con->query("SELECT a.*, b.*, c.* FROM produk as a, kategori as b, promo as c WHERE b.kd_kategori=a.kd_kategori AND a.kd_produk='$kd_produk' AND c.kd_produk=a.kd_produk ");
$row_detail_p = $sql_detail_p->fetch(PDO::FETCH_LAZY);
$trow_detail_p = $sql_detail_p->rowCount();

if ($row_detail_p['diskon'] != null and $row_detail_p['diskon'] != "0") {
  $nilai_harga2 = uang($row_detail_p['harga']);
  $diskon2 = tampilDiskon2($row_detail_p['diskon']);
  $hargaBarang2 = '<i style="text-decoration: line-through; color: #898989">' . $nilai_harga2 . '</i>';
  $hargaDiskon2 = "<br>" . uang(hargaDiskon($row_detail_p['diskon'], $row_detail_p['harga']));
  $hproduk = hargaDiskon($row_detail_p['diskon'], $row_detail_p['harga']);
} else {
  $diskon2 = '';
  $hargaBarang2 = uang($row_detail_p['harga']);
  $hargaDiskon2 = "";
  $hproduk = $row_detail_p['harga'];
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
  <link rel="stylesheet" href="assets/css/jquery.bootstrap-touchspin.min.css">
</head>

<body>

  <?php include 'header.php'; ?>

  <div class="container">

    <div class="row">


      <div class="col-md-12">
        <?php if ((!empty($trow_detail_p)) && (!empty($kd_produk))) : ?>
          <ol class="breadcrumb">
            <li><a href="./">Home</a></li>
            <li><a href="produk?kategori=<?php echo str_replace(" ", "_", $row_detail_p['nama_kategori']); ?>"><?php echo $row_detail_p['nama_kategori']; ?></a></li>
            <li class="active"><?php echo $row_detail_p['nama_produk']; ?></li>
          </ol>
          <hr>
          <div class="row">
            <!-- Foto
							================================================ -->
            <?php
            $sql_foto_slide = $con->query("SELECT * FROM foto_produk WHERE kd_produk='$kd_produk' ");
            $trow_foto_slide = $sql_foto_slide->rowCount();
            ?>
            <div class="preview col-sm-4">
              <div class="preview-pic tab-content">
                <?php for ($i = 1; $i <= $trow_foto_slide; $i++) {
                  $row_foto_slide = $sql_foto_slide->fetch(PDO::FETCH_LAZY);
                  if ($i == 1) {
                    $active = 'active';
                  } else {
                    $active = '';
                  }
                ?>
                  <div class="tab-pane <?php echo $active; ?>" id="pic-<?php echo $i; ?>">
                    <img src="assets/images/produk/<?php echo $row_foto_slide['foto']; ?>" class="img-thumbnail" width="350" hight="200" />
                  </div>
                <?php } ?>
              </div>
              <?php
              $sql_foto_prev = $con->query("SELECT * FROM foto_produk WHERE kd_produk='$kd_produk' ");
              $trow_foto_prev = $sql_foto_prev->rowCount();
              ?>
              <ul class="preview-thumbnail nav nav-tabs">
                <?php
                for ($ii = 1; $ii <= $trow_foto_prev; $ii++) {
                  $row_foto_prev = $sql_foto_prev->fetch(PDO::FETCH_LAZY);
                  if ($ii == 1) {
                    $active2 = 'active';
                  } else {
                    $active2 = '';
                  }
                ?>
                  <li class="<?php echo $active2; ?>"> <a data-target="#pic-<?php echo $ii; ?>" data-toggle="tab"><img src="assets/images/produk/<?php echo $row_foto_prev['foto']; ?>" /></a>
                  </li>
                <?php } ?>
              </ul>
            </div>
            <form method="POST">
              <!-- Detail
							================================================ -->
              <div class="col-sm-5">
                <h3><?php echo $row_detail_p['nama_produk']; ?></h3>
                <table width="100%" style="margin-top: 20px; font-size: 13px">
                  <tr>
                    <td>
                      <p>Bahan</p>
                    </td>
                    <td>
                      <p>: <?php echo $row_detail_p['bahan']; ?></p>
                    </td>
                    <td>
                      <p>Ukuran</p>
                    </td>
                    <td>
                      <p>: <?php echo $row_detail_p['ukuran']; ?></p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p>Warna</p>
                    </td>
                    <td>
                      <p>: <?php echo $row_detail_p['warna']; ?></p>
                    </td>
                    <td>
                      <p>Berat</p>
                    </td>
                    <td>
                      <p>: <?php echo berat($row_detail_p['berat']); ?></p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p>Stok</p>
                    </td>
                    <td>
                      <p>: <?php echo $row_detail_p['stok']; ?></p>
                    </td>
                  </tr>
                </table>
                <div class="form-horizontal row">
                  <div class="form-group col-sm-8">
                    <label class="control-label col-sm-2" for="jml_beli">Beli</label>
                    <div class="col-sm-7">
                      <input id="jml_beli" type="text" name="jml_beli" onKeyUp="validasi_stok(this)" maxlength="3" min="1" value="1" max="<?php echo $row_detail_p['stok']; ?>" class="text-center">
                    </div>
                    <label class="control-label text-right col-sm-3" for="jml_beli">Barang</label>
                  </div>
                </div>
                <?php if ($row_detail_p['isi'] != "") : ?>
                  <h4 style="margin-top: 30px">Promo</h4>
                  <hr>
                  <?php echo $row_detail_p['isi']; ?>
                <?php endif ?>
                <h4 style="margin-top: 30px">Deskripsi</h4>
                <hr>
                <?php echo $row_detail_p['deskripsi']; ?>
              </div>
              <!-- Harga
							================================================ -->
              <div class="col-sm-3">
                <div class="panel panel-default">
                  <div class="panel-body" style="text-align: center; color: #FA7455; font-size: 20px">
                    <b><?php echo $hargaBarang2; ?> <?php echo $hargaDiskon2; ?></b>
                  </div>
                </div>
                <!-- Tombol beli
								================================================ -->
                <button type="submit" name="beli" value="y" class="btn btn-large btn-block btn-warning" style="font-size: 18px">
                  <i class="fa fa-shopping-cart" aria-hidden="true"></i> Beli </button>
                <input type="hidden" name="kd_produk" value="<?php echo $kd_produk; ?>">
                <input type="hidden" name="harga_produk" value="<?php echo $hproduk; ?>">
              </div>
            </form>
          </div>
          <!-- Jika kosong
					================================================ -->
        <?php else : ?>
          <p class="well text-center"> Maaf, barang tidak ditemukan. </p>
        <?php endif; ?>
        <?php
        $sql_testimoni = $con->query("SELECT a.*, b.email_plg, b.nama_plg FROM testimoni as a, pelanggan as b WHERE a.kd_produk = '$kd_produk' AND b.email_plg = a.userid ORDER BY tgl_testimoni DESC");
        $row_testimoni = $sql_testimoni->fetch(PDO::FETCH_LAZY);
        $trow_testimoni = $sql_testimoni->rowCount();
        ?>
        <!-- testimoni
					================================================ -->
        <h4 style="margin-top: 100px"> <b>Testimoni</b>
          <hr>
        </h4>
        <div class="row">
          <?php if (!empty($trow_testimoni)) : ?>
            <!-- Tampil testimoni -->
            <?php do { ?>
              <div class="col-md-12">
                <div class="panel">
                  <div class="panel-body">
                    <h5> <?php echo $row_testimoni['nama_plg']; ?> <small><?php echo longDatepukul($row_testimoni['tgl_testimoni']); ?></small>
                    </h5>
                    <hr>
                    <p class="text-justify"> <?php echo $row_testimoni['isi_testimoni']; ?>
                    </p>
                  </div>
                </div>
              </div>
            <?php } while ($row_testimoni = $sql_testimoni->fetch()); ?>
          <?php else : ?>
            <div class="col-md-12">
              <p> Belum ada testimoni.. <br>
                <br>
              </p>
            </div>
          <?php endif ?>
          <?php if (isset($_SESSION['pelanggan'])) : ?>
            <!-- Tulis testimoni -->
            <div class="col-md-12">
              <form method="POST">
                <div class="form-group">
                  <div class="input-group col-xs-12">
                    <textarea class="form-control" name="isi_testimoni" placeholder="Tulis testimoni tentang produk ini disini.." required></textarea>
                    <span class="input-group-addon danger" style="display: none;"></span>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group col-xs-12">
                    <button type="submit" class="btn btn-primary">Kirim</button>
                  </div>
                </div>
                <input type="hidden" name="kd_produk" value="<?php echo $kd_produk; ?>">
                <input type="hidden" name="userid" value="<?php echo $_SESSION['pelanggan']; ?>">
                <input type="hidden" name="ftestimoni" value="y">
              </form>
            </div>
          <?php endif ?>
        </div>
        <!-- Barang Sejenis
					================================================ -->
        <?php
        $barang = str_replace(" ", "_", $row_detail_p['nama_kategori']);
        $sql_produk_home = $con->query("SELECT a.*, b.* FROM produk AS a, kategori AS b WHERE a.stok > 0 AND b.kd_kategori = a.kd_kategori AND a.kd_produk!='$kd_produk' HAVING b.nama_kategori LIKE '%$barang%' ");
        $row_produk_home = $sql_produk_home->fetch(PDO::FETCH_LAZY);
        $trow_produk_home = $sql_produk_home->rowCount();
        ?>
        <?php if ($trow_produk_home) : ?>
          <h4 style="margin-top: 30px"> <b>Barang sejenis</b>
            <hr>
          </h4>
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
                </div>
              </div>
            <?php } while ($row_produk_home = $sql_produk_home->fetch()); ?>
          </div>
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
  <script src="assets/js/jquery.bootstrap-touchspin.min.js"></script>
  <script type="text/javascript">
    function validasi_stok(tag) {
      var stok = parseInt('<?php echo $row_detail_p['stok'] ?>');
      if (stok < $(tag).val()) {
        alert('stok tidak mencukupi');
        $(tag).val('1');
      }
    }
    $(document).ready(function() {
      //VALIDASI STOK
      $('#jml_beli').change(function() {
        validasi_stok(this);
      });
      $('#jml_beli').keyup(function() {
        validasi_stok(this);
      });

    });
  </script>
  <script>
    $("#jml_beli").TouchSpin({
      min: 1,
      max: <?php echo $row_detail_p['stok']; ?>,
      buttondown_class: 'btn btn-default',
      buttonup_class: 'btn btn-default'
    });
  </script>
</body>

</html>
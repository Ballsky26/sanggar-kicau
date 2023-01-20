<?php
include 'config.php';
include 'koneksi.php';
include 'assets/lib/function.php';
include 'assets/lib/rajaongkir.php';
include 'query_header.php';

$faktur    = $_SESSION['kd_faktur'];
$pelanggan = $_SESSION['pelanggan'];

/*
Input data pengiriman
============================================== */
$sql_cek_dtpengiriman = $con->query("SELECT * FROM pengiriman WHERE kd_faktur='$faktur' ");
$row_cek_dtpengiriman = $sql_cek_dtpengiriman->fetch(PDO::FETCH_LAZY);
$trow_cek_dtpengiriman = $sql_cek_dtpengiriman->rowCount();

if (empty($trow_cek_dtpengiriman)) {

  $sql_dtpelanggan = $con->query("SELECT * FROM pelanggan WHERE email_plg='$pelanggan' ");
  $row_dtpelanggan = $sql_dtpelanggan->fetch(PDO::FETCH_LAZY);

  $penerima          = $row_dtpelanggan['nama_plg'];
  $provinsi_penerima = $row_dtpelanggan['kd_provinsi'];
  $kota_penerima     = $row_dtpelanggan['kd_kota'];
  $alamat_penerima   = $row_dtpelanggan['alamat_plg'];
  $kdpos_penerima    = $row_dtpelanggan['kodepos_plg'];
  $tlp_penerima      = $row_dtpelanggan['tlp_plg'];
  $con->exec("INSERT INTO pengiriman (kd_faktur, penerima, kd_provinsi, kd_kota, alamat_penerima, kdpos_penerima, tlp_penerima) 
            VALUES (
	            '" . $faktur . "',
	            '" . $penerima . "',
	            '" . $provinsi_penerima . "',
	            '" . $kota_penerima . "',
	            '" . $alamat_penerima . "',
	            '" . $kdpos_penerima . "',
	            '" . $tlp_penerima . "'
            )");
}

/*
Edit Penerima
============================================== */
if ((isset($_POST["edit_alamat"])) && ($_POST["edit_alamat"] == "y")) {

  $con->exec("DELETE FROM pengiriman WHERE kd_faktur='$faktur'");

  $penerima          = $_POST['penerima'];
  $provinsi_penerima = $_POST['kd_provinsi'];
  $kota_penerima     = $_POST['kd_kota'];
  $alamat_penerima   = $_POST['alamat_penerima'];
  $kdpos_penerima    = $_POST['kdpos_penerima'];
  $tlp_penerima      = $_POST['tlp_penerima'];
  if (($kota_penerima != $AsalKiriman) and ($kota_penerima != $AsalKiriman2)) {
    $con->exec("UPDATE faktur SET pembayaran='Transfer', kurir='jne', biaya_pengiriman='0', lama_kirim=null WHERE kd_faktur='$faktur'");
  }
  $con->exec("INSERT INTO pengiriman (kd_faktur, penerima, kd_provinsi, kd_kota, alamat_penerima, kdpos_penerima, tlp_penerima) 
            VALUES (
	            '" . $faktur . "',
	            '" . $penerima . "',
	            '" . $provinsi_penerima . "',
	            '" . $kota_penerima . "',
	            '" . $alamat_penerima . "',
	            '" . $kdpos_penerima . "',
	            '" . $tlp_penerima . "'
            )");

  header("Location: daftar_pembelian");
}

/*
Kembalikan Penerima
============================================== */
if ((isset($_POST["edit_alamat"])) && ($_POST["edit_alamat"] == "t")) {

  $con->exec("DELETE FROM pengiriman WHERE kd_faktur='$faktur'");

  $sql_dtpelanggan = $con->query("SELECT * FROM pelanggan WHERE email_plg='$pelanggan' ");
  $row_dtpelanggan = $sql_dtpelanggan->fetch(PDO::FETCH_LAZY);

  $penerima          = $row_dtpelanggan['nama_plg'];
  $provinsi_penerima = $row_dtpelanggan['kd_provinsi'];
  $kota_penerima     = $row_dtpelanggan['kd_kota'];
  $alamat_penerima   = $row_dtpelanggan['alamat_plg'];
  $kdpos_penerima    = $row_dtpelanggan['kodepos_plg'];
  $tlp_penerima      = $row_dtpelanggan['tlp_plg'];
  $con->exec("INSERT INTO pengiriman (kd_faktur, penerima, kd_provinsi, kd_kota, alamat_penerima, kdpos_penerima, tlp_penerima) 
            VALUES (
	            '" . $faktur . "',
	            '" . $penerima . "',
	            '" . $provinsi_penerima . "',
	            '" . $kota_penerima . "',
	            '" . $alamat_penerima . "',
	            '" . $kdpos_penerima . "',
	            '" . $tlp_penerima . "'
            )");

  header("Location: daftar_pembelian");
}

/*
Edit Pembelian
============================================== */
if ((isset($_POST["edit"])) && ($_POST["edit"] == "y")) {
  $jml_beli    = $_POST['jml_beli'];
  $stok_semula = $_POST['stok_semula'];
  $produk      = $_POST['produk'];
  $faktur      = $_POST['faktur'];
  $stok_baru = $stok_semula - $jml_beli;

  $con->exec("UPDATE produk SET stok='$stok_baru' WHERE kd_produk='$produk' ");
  $con->exec("UPDATE penjualan SET jml_beli='$jml_beli' WHERE kd_faktur='$faktur' AND kd_produk='$produk' ");

  header("Location: daftar_pembelian");
}



/*
Hapus Pembelian
============================================== */
if ((isset($_POST["hapus"])) && ($_POST["hapus"] == "y")) {
  $jml_beli        = $_POST['jml_beli'];
  $kd_penjualan = $_POST['kd_penjualan'];
  $kd_produk       = $_POST['kd_produk'];

  $con->exec("UPDATE produk SET stok=stok+$jml_beli WHERE kd_produk='$kd_produk' ");
  $con->exec("DELETE FROM penjualan WHERE kd_penjualan='$kd_penjualan' ");
}

/*
Edit Pembayaran
============================================== */
if ((isset($_POST["pilih_pembayaran"])) && ($_POST["pilih_pembayaran"] == "y")) {
  $faktur     = $_SESSION['kd_faktur'];
  $pembayaran = $_POST['pembayaran'];

  if ($pembayaran == "COD") {
    $con->exec("UPDATE faktur SET pembayaran='$pembayaran', kurir='sanggar kicau', biaya_pengiriman='10000', lama_kirim='2' WHERE kd_faktur='$faktur'");
  } else {
    $con->exec("UPDATE faktur SET pembayaran='$pembayaran', kurir='jne', biaya_pengiriman='0', lama_kirim=null WHERE kd_faktur='$faktur'");
  }
  header("Location: daftar_pembelian");
}

/*
Edit Kurir
============================================== */
if ((isset($_POST["pilih_kurir"])) && ($_POST["pilih_kurir"] == "y")) {
  $faktur = $_SESSION['kd_faktur'];
  $kurir  = $_POST['kurir'];

  $con->exec("UPDATE faktur SET kurir='$kurir' WHERE kd_faktur='$faktur'");
  header("Location: daftar_pembelian");
}

/*
Selesai Belanja
============================================== */
if ((isset($_POST["selesai_belanja"])) && ($_POST["selesai_belanja"] == "y")) {

  $faktur     = $_SESSION['kd_faktur'];
  $pembayaran = $_POST['pembayaran'];

  if ($pembayaran == "COD") {
    $con->exec("UPDATE faktur SET konfirm='Menunggu Pembayaran' WHERE kd_faktur='$faktur'");
  } else {
    $con->exec("UPDATE faktur SET konfirm='Menunggu Pembayaran' WHERE kd_faktur='$faktur'");
  }

  unset($_SESSION['kd_faktur']);
  //include 'cek_status_faktur.php';

  header("Location: transaksi");
}

$sql_penjualan = $con->query("SELECT a.*, b.* FROM penjualan as a, produk as b WHERE a.kd_faktur='$faktur' AND b.kd_produk=a.kd_produk ");
$row_penjualan = $sql_penjualan->fetch(PDO::FETCH_LAZY);
$trow_penjualan = $sql_penjualan->rowCount();
$jml_barang = 0;
$jml_berat = 0;
$sub_total = 0;

$sql_data_faktur = $con->query("SELECT * FROM faktur WHERE kd_faktur='$faktur' ");
$row_data_faktur = $sql_data_faktur->fetch(PDO::FETCH_LAZY);
$trow_data_faktur = $sql_data_faktur->rowCount();

$sql_tampil_pengiriman = $con->query("SELECT * FROM pengiriman WHERE kd_faktur='$faktur' ");
$row_tampil_pengiriman = $sql_tampil_pengiriman->fetch(PDO::FETCH_LAZY);
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

  <div class="container" style="margin-bottom: 150px">

    <div class="row">


      <div class="col-md-12">
        <ol class="breadcrumb">
          <li><a href="./">Home</a></li>
          <li class="active">Daftar Pembelian</li>
        </ol>
        <hr>
        <?php if (!empty($trow_penjualan)) : ?>
          <div class="col-xs-6">
            <h4 class="pull-left">Faktur Pembelian: <span style="color: red"><?php echo $faktur ?></span></h4>
          </div>
          <div class="row">
            <!-- 
						=========================================================== Pilih Metode Pembayaran -->
            <div class="col-xs-3">
              <form id="fpembayaran" name="fpembayaran" method="POST">
                <div class="form-group">
                  <label>Metode Pembayaran</label>
                  <div class="input-group col-xs-9">
                    <select id="pembayaran" name="pembayaran" class="form-control" required>
                      <option value="Transfer" <?php echo terpilih($row_data_faktur['pembayaran'], "Transfer"); ?>>
                        Transfer </option>
                      <?php if (($row_tampil_pengiriman['kd_kota'] == $AsalKiriman) or ($row_tampil_pengiriman['kd_kota'] == $AsalKiriman2)) : ?>
                        <option value="COD" <?php echo terpilih($row_data_faktur['pembayaran'], "COD"); ?>>
                          COD </option>
                      <?php endif ?>
                    </select>
                  </div>
                </div>
                <input type="hidden" name="pilih_pembayaran" value="y">
              </form>
            </div>
            <!-- 
						=========================================================== Pilih Kurir -->
            <div class="col-xs-3">
              <?php if ($row_data_faktur['pembayaran'] != "COD") : ?>
                <form id="fkurir" name="fkurir" method="POST">
                  <div class="form-group">
                    <label>Kurir</label>
                    <div class="input-group col-xs-9">
                      <select id="kurir" name="kurir" class="form-control" required>
                        <option value="jne" <?php echo terpilih($row_data_faktur['kurir'], "jne"); ?>>
                          JNE </option>
                        <option value="pos" <?php echo terpilih($row_data_faktur['kurir'], "pos"); ?>>
                          POS </option>
                      </select>
                    </div>
                  </div>
                  <input type="hidden" name="pilih_kurir" value="y">
                </form>
              <?php else : ?>
                <div class="form-group">
                  <label>Kurir</label>
                  <div class="input-group col-xs-9">
                    <input type="text" class="form-control" value="<?php echo $row_data_faktur['kurir']; ?>" readonly> Maksimal 1 Produk
                  </div>
                </div>
              <?php endif ?>
            </div>

          </div>
          <table class="table table-bordered table-hover" style="font-size: 12px">
            <thead>
              <tr>
                <th colspan="5">
                  <h4>Daftar Barang</h4>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php do {

                if ($row_penjualan['diskon'] != null and $row_penjualan['diskon'] != "0") {
                  $nilai_harga = uang($row_penjualan['harga']);
                  $hargaBarang = '<i style="text-decoration: line-through; color: #898989">' . $nilai_harga . '</i>';
                  $diskon      = tampilDiskon2($row_penjualan['diskon']);
                  $hargaDiskon = uang($row_penjualan['harga_produk']);
                } else {
                  $diskon      = '';
                  $hargaBarang = uang($row_penjualan['harga_produk']);
                  $hargaDiskon = "";
                }
              ?>
                <tr>
                  <td colspan="3">
                    <div class="media">
                      <div class="media-left">
                        <div class="gproduk-sm"> <img src="assets/images/produk/<?php echo $row_penjualan['foto']; ?>" width="100">
                        </div>
                      </div>
                      <div class="media-body" data-id="<?php echo $row_penjualan['kd_produk']; ?>">
                        <h5 class="media-heading"><?php echo $row_penjualan['nama_produk']; ?></h5>
                        <b><?php echo $row_penjualan['jml_beli']; ?> Barang (<?php echo berat_kg($row_penjualan['berat']) ?>
                          kg)</b> x <?php echo $hargaBarang; ?> <?php echo $hargaDiskon; ?>
                        <p>
                        <div class="view-edit"> <a href="#ubah" data-toggle="modal">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah
                          </a> </div>
                        </p>
                      </div>
                    </div>
                  </td>
                  <td colspan="2">
                    <h5>Harga Barang</h5>
                    <?php echo uang(perkalian($row_penjualan['jml_beli'], $row_penjualan['harga_produk'])); ?>
                    <br> <br>
                    <form method="POST">
                      <button type="submit" name="hapus" value="y" class="btn btn-danger btn-sm pull-right">Hapus</button>
                      <input type="hidden" name="kd_penjualan" value="<?php echo $row_penjualan['kd_penjualan']; ?>">
                      <input type="hidden" name="kd_produk" value="<?php echo $row_penjualan['kd_produk']; ?>">
                      <input type="hidden" name="jml_beli" value="<?php echo $row_penjualan['jml_beli']; ?>">
                    </form>
                  </td>
                </tr>
              <?php

                $jml_barang = $row_penjualan['jml_beli'] + $jml_barang;
                $sub_berat = $row_penjualan['berat'] * $row_penjualan['jml_beli'];
                $jml_berat = $sub_berat + $jml_berat;
                $sub_total = perkalian($row_penjualan['jml_beli'], $row_penjualan['harga_produk']) + $sub_total;
              } while ($row_penjualan = $sql_penjualan->fetch()); ?>
              <tr>
                <!-- ============================================== Kolom Pengiriman -->
                <td>
                  <h5>Dikirim ke: </h5>
                  <div class="row" style="margin-bottom: 20px">
                    <div class="col-xs-3"> Penerima:<br>
                      Telepon:<br>
                      Alamat:<br>
                      Kota:<br>
                      Provinsi:<br>
                      Kode Pos:<br>
                    </div>
                    <div class="col-xs-9"> <?php echo $row_tampil_pengiriman['penerima']; ?><br>
                      <?php echo $row_tampil_pengiriman['tlp_penerima']; ?><br>
                      <?php echo $row_tampil_pengiriman['alamat_penerima']; ?><br>
                      <?php echo tampilKota($row_tampil_pengiriman['kd_provinsi'], $row_tampil_pengiriman['kd_kota']); ?><br>
                      <?php echo tampilProvinsi($row_tampil_pengiriman['kd_provinsi']); ?><br>
                      <?php echo $row_tampil_pengiriman['kdpos_penerima']; ?><br>
                    </div>
                  </div>
                  <a href="#ubah-alamat" data-toggle="modal" class="btn btn-warning btn-sm">
                    Ganti Alamat</a>
                </td>
                <!-- ./ Kolom Pengiriman -->
                <td>
                  <h5>Total Barang</h5>
                  <p><?php echo $jml_barang; ?></p>
                </td>
                <td>
                  <h5>Total Berat</h5>
                  <p><?php echo berat_kg($jml_berat); ?> kg</p>
                </td>
                <td width="150px">
                  <h5>Subtotal</h5>
                  <p><?php echo uang($sub_total); ?></p>
                </td>
                <td width="150px">
                  <?php if ($row_data_faktur['pembayaran'] == "COD") { ?>
                    <h5>Ongkir (Sanggar Kicau)</h5>
                    <?php
                    $ongkir = $row_data_faktur['biaya_pengiriman'];
                    echo uang($ongkir);
                    ?>
                    <h5>Lama Pengiriman</h5>
                    <?php echo $row_data_faktur['lama_kirim'] . " hari"; ?>
                  <?php } else {

                    $TujuanKiriman = $row_tampil_pengiriman['kd_kota'];
                    $BeratProduk = berat_kg($jml_berat);
                    $TipeOngkir = $row_data_faktur['kurir'];

                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                      CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "POST",
                      CURLOPT_POSTFIELDS => "origin=$AsalKiriman&destination=$TujuanKiriman&weight=$BeratProduk&courier=$TipeOngkir",
                      CURLOPT_HTTPHEADER => array(
                        "content-type: application/x-www-form-urlencoded",
                        "key: $APIKeyRaja"
                      ),
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    if ($err) {
                      echo "cURL Error #:" . $err;
                    } else {
                      $hasil = json_decode($response, true);

                      for ($i = 0; $i < count($hasil['rajaongkir']['results'][0]['costs']); $i++) {

                        for ($ix = 0; $ix < count($hasil['rajaongkir']['results'][0]['costs'][$i]['cost']); $ix++) {
                          if ($hasil['rajaongkir']['results'][0]['costs'][$i]['service'] == "REG") {
                            $service = $hasil['rajaongkir']['results'][0]['costs'][$i]['service'];
                            $ongkir = ($hasil['rajaongkir']['results'][0]['costs'][$i]['cost'][$ix]['value'] * $BeratProduk);
                            $lama = $hasil['rajaongkir']['results'][0]['costs'][$i]['cost'][$ix]['etd'];
                          }
                          if (empty($service) or $TipeOngkir == "pos") {
                            $service = $hasil['rajaongkir']['results'][0]['costs'][0]['service'];
                            $ongkir = ($hasil['rajaongkir']['results'][0]['costs'][0]['cost'][0]['value'] * $BeratProduk);
                            $lama = $hasil['rajaongkir']['results'][0]['costs'][0]['cost'][0]['etd'];
                          }
                        }
                      }
                    }
                  ?>
                    <h5>Ongkir (<?php echo tampilKurir($TipeOngkir); ?>)</h5>
                    <?php
                    echo uang($ongkir);
                    ?>
                    <h5>Lama Pengiriman</h5>
                    <?php echo $lama; ?> hari
                  <?php
                    $con->exec("UPDATE faktur SET total_biaya_barang='$sub_total', lama_kirim='$lama', biaya_pengiriman='$ongkir' WHERE kd_faktur='$faktur'");
                  }
                  ?>
                </td>
              </tr>
              <tr>
                <td align="left" style="font-size: 16px">
                  <a href="./" class="btn btn-info pull-left">
                    Tambah Lagi?</a>
                </td>
                <td colspan="4" align="right" style="font-size: 16px"> Total Tagihan
                  <b style="color: red;"><?php echo uang($sub_total + $ongkir); ?></b>
                </td>
              </tr>
            </tbody>
          </table>
          <form method="POST">
            <?php if (($row_data_faktur['pembayaran'] == "COD") and ($trow_penjualan > 1)) : ?>
              <button name="selesai_belanja" value="y" type="button" class="btn btn-success pull-right" disabled>Selesai
                Belanja</button>
            <?php else : ?>
              <button name="selesai_belanja" value="y" type="submit" class="btn btn-success pull-right">Checkout</button>
            <?php endif; ?>
            <input type="hidden" name="pembayaran" value="<?php echo $row_data_faktur['pembayaran']; ?>">
          </form>
        <?php else : ?>
          <p class="well text-center"> Daftar Pembelian Kosong </p>
        <?php endif; ?>
      </div>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- 
		====================================================== Form Ubah Pembelian -->
  <div class="modal fade" id="ubah" role="dialog">

    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div id="hasil"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- 
		====================================================== Form Ubah Pengiriman -->
  <div class="modal fade" id="ubah-alamat" role="dialog">

    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div> <b style='font-size: 18px;'>Ubah Alamat Kirim</b>
            <div style='float: right;'>
              <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
            </div>
          </div>
          <hr>
          <form method="POST">
            <div class="form-group" id="f-username">
              <div class="input-group col-xs-12">
                <input type="text" class="form-control" id="penerima" name="penerima" placeholder="Nama Lengkap" autocomplete="off" required value="<?php echo $row_tampil_pengiriman['penerima']; ?>">
                <span class="input-group-addon danger" style="display: none;"></span>
              </div>
            </div>
            <div class="form-group" id="f-username">
              <div class="input-group col-xs-12">
                <textarea name="alamat_penerima" class="form-control" required placeholder="Alamat"><?php echo $row_tampil_pengiriman['alamat_penerima']; ?></textarea>
                <span class="input-group-addon danger" style="display: none;"></span>
              </div>
            </div>
            <div class="form-group" id="f-username">
              <div class="input-group col-xs-12">
                <select id="kd_provinsi" name="kd_provinsi" class="form-control" required>
                  <?php
                  $response = curl_exec(setProvinsi());
                  $err = curl_error(setProvinsi());
                  curl_close(setProvinsi());

                  if ($err) {
                    echo "cURL Error #:" . $err;
                  } else {
                    $hasil = json_decode($response, true);
                    for ($i = 0; $i < count($hasil['rajaongkir']['results']); $i++) {
                  ?>
                      <option value="<?php echo $hasil['rajaongkir']['results'][$i]['province_id']; ?>" <?php echo terpilih($row_tampil_pengiriman['kd_provinsi'], $hasil['rajaongkir']['results'][$i]['province_id']) ?>>
                        <?php echo $hasil['rajaongkir']['results'][$i]['province']; ?>
                      </option>
                  <?php
                    }
                  }
                  ?>
                </select>
                <span class="input-group-addon danger" style="display: none;"></span>
              </div>
            </div>
            <div class="form-group" id="f-username">
              <div class="input-group col-xs-12">
                <select id="kd_kota" name="kd_kota" class="form-control" required>
                  <?php
                  $response = curl_exec(setKota($row_tampil_pengiriman['kd_provinsi']));
                  $err = curl_error(setKota($row_tampil_pengiriman['kd_provinsi']));
                  curl_close(setKota($row_tampil_pengiriman['kd_provinsi']));

                  if ($err) {
                    echo "cURL Error #:" . $err;
                  } else {
                    $hasil = json_decode($response, true);
                    for ($i = 0; $i < count($hasil['rajaongkir']['results']); $i++) {
                  ?>
                      <option value="<?php echo $hasil['rajaongkir']['results'][$i]['city_id']; ?>" <?php echo terpilih($row_tampil_pengiriman['kd_kota'], $hasil['rajaongkir']['results'][$i]['city_id']) ?>>
                        <?php echo $hasil['rajaongkir']['results'][$i]['city_name']; ?>
                      </option>
                  <?php
                    }
                  }
                  ?>
                </select>
                <span class="input-group-addon danger" style="display: none;"></span>
              </div>
            </div>
            <div class="form-group" id="f-username">
              <div class="input-group col-xs-12">
                <input type="text" class="form-control" maxlength="5" id="kdpos_penerima" name="kdpos_penerima" placeholder="Kode Pos" autocomplete="off" required autofocus onKeyPress="return goodchars(event,'0123456789',this)" value="<?php echo $row_tampil_pengiriman['kdpos_penerima']; ?>">
                <span class="input-group-addon danger" style="display: none;"></span>
              </div>
            </div>
            <div class="form-group" id="f-username">
              <div class="input-group col-xs-12">
                <input type="text" class="form-control" maxlength="13" id="tlp_penerima" name="tlp_penerima" placeholder="Telepon" autocomplete="off" required autofocus onKeyPress="return goodchars(event,'0123456789',this)" value="<?php echo $row_tampil_pengiriman['tlp_penerima']; ?>">
                <span class="input-group-addon danger" style="display: none;"></span>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-6">
                <button name="edit_alamat" value="y" type="submit" class="btn btn-block btn-success">Simpan</button>
              </div>
              <div class="col-xs-6">
                <button name="edit_alamat" value="t" type="submit" class="btn btn-block btn-danger">Ubah
                  Kesemula</button>
              </div>
            </div>
            <input type="hidden" name="kota_asal" value="<?php echo $row_pelanggan['kd_kota'] ?>">
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>

  <!-- Bootstrap core JavaScript
        ================================================== -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/validasi.js"></script>
  <script src="assets/js/validasiinput.js"></script>

  <script src="assets/js/jquery.bootstrap-touchspin.min.js"></script>
  <script>
    $(document).ready(function() {
      $(".view-edit").click(function() {
        var id = $(this).parents('div').data('id');
        $.ajax({
          type: "post",
          url: "ubah_keranjang.php",
          data: "p=" + id,
          success: function(data) {
            $("#hasil").html(data);
          }
        });
      });
      $("#kurir").change(function() {
        document.fkurir.submit()
      });
      $("#pembayaran").change(function() {
        document.fpembayaran.submit()
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $('#kd_provinsi').change(function() {
        var id = $(this).val();
        $('#kd_kota').empty();
        $.ajax({
          type: "post",
          url: "cari_kota.php",
          data: "q=" + id,
          success: function(data) {
            $("#kd_kota").html(data);
            // if (data !== "") {
            //     $('#kd_kota').prop('disabled', false);
            // }else {
            //     $('#kd_kota').prop('disabled', true);
            // };
          }
        });
      });
    });
  </script>
</body>

</html>
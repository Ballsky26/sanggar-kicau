<?php
include '../koneksi.php';
include '../config.php';
include '../assets/lib/function.php';
include '../assets/lib/rajaongkir.php';
$page = "order";

$kd_faktur = $_GET['kd_faktur'];
$id = $_GET['pelanggan'];
$sql_order_produk = $con->query("SELECT a.*, b.* FROM order_produk as a, produk as b WHERE a.kd_faktur='$kd_faktur' AND b.kd_produk=a.kd_produk ");
$row_order_produk = $sql_order_produk->fetch(PDO::FETCH_LAZY);
$trow_order_produk = $sql_order_produk->rowCount();

$sql_data_faktur = $con->query("SELECT * FROM faktur WHERE kd_faktur = '$kd_faktur' ");
$row_data_faktur = $sql_data_faktur->fetch(PDO::FETCH_LAZY);
$trow_data_faktur = $sql_data_faktur->rowCount();

$sql_tampil_pengiriman = $con->query("SELECT * FROM pengiriman WHERE kd_faktur='$kd_faktur' ");
$row_tampil_pengiriman = $sql_tampil_pengiriman->fetch(PDO::FETCH_LAZY);

$jml_barang = 0;
$jml_berat  = 0;
$sub_total  = 0;

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
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/font-awesome.min.css">
</head>

<body onLoad="window.print()">

    <div class="container">

        <!-- Tabel
			========================================================= -->
        <table class="table table-bordered" style="font-size: 12px; margin-top: 50px">
            <thead>
                <tr>
                    <th colspan="5" style="text-align: left; font-weight: bold">
                        <h5 style="font-weight: bold">No. Faktur: <?php echo $kd_faktur; ?></h5>
                        <?php if ($row_data_faktur['tgl_kirim'] != NULL) : ?>
                            <h5 style="font-weight: bold">No. Resi: <?php echo $row_data_faktur['resi']; ?></h5>
                        <?php endif ?>
                        <h5><?php echo longDate($row_data_faktur['tgl']); ?></h5>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php do {
                    if ($row_order_produk['diskon'] != null and $row_order_produk['diskon'] != "0") {
                        $nilai_harga = uang($row_order_produk['harga']);
                        $hargaBarang = '<i style="text-decoration: line-through; color: #898989">' . $nilai_harga . '</i>';
                        $diskon      = tampilDiskon2($row_order_produk['diskon']);
                        $hargaDiskon = uang($row_order_produk['harga_produk']);
                    } else {
                        $diskon      = '';
                        $hargaBarang = uang($row_order_produk['harga_produk']);
                        $hargaDiskon = "";
                    }
                ?>
                    <tr>
                        <td colspan="3">
                            <div class="media">
                                <div class="media-left">
                                    <div class="gproduk-sm">
                                        <img src="../assets/images/produk/<?php echo $row_order_produk['foto']; ?>" width="100">
                                    </div>
                                </div>
                                <div class="media-body" data-id="<?php echo $row_order_produk['kd_produk']; ?>">
                                    <h5 class="media-heading"><?php echo $row_order_produk['nama_produk']; ?></h5>
                                    <b><?php echo $row_order_produk['jml_beli']; ?> Barang (<?php echo berat_kg($row_order_produk['berat']) ?> kg)</b>
                                    x <?php echo $hargaBarang; ?> <?php echo $hargaDiskon; ?>
                                </div>
                            </div>
                        </td>
                        <td colspan="2">
                            <h5>Harga Barang</h5>
                            <?php echo uang(perkalian($row_order_produk['jml_beli'], $row_order_produk['harga_produk'])); ?>
                        </td>
                    </tr>

                <?php

                    $jml_barang = $row_order_produk['jml_beli'] + $jml_barang;
                    $sub_berat = berat_kg($row_order_produk['berat']) * $row_order_produk['jml_beli'];
                    $jml_berat = $sub_berat + $jml_berat;
                    $sub_total = perkalian($row_order_produk['jml_beli'], $row_order_produk['harga_produk']) + $sub_total;
                } while ($row_order_produk = $sql_order_produk->fetch()); ?>
                <tr>
                    <!-- ============================================== Kolom Pengiriman -->
                    <td>
                        <h5>Dikirim ke: </h5>
                        <div class="row" style="margin-bottom: 20px">
                            <div class="col-xs-3">
                                Penerima:<br>
                                Telepon:<br>
                                Alamat:<br>
                                Kota:<br>
                                Provinsi:<br>
                                Kode Pos:<br>
                            </div>
                            <div class="col-xs-9">
                                <?php echo $row_tampil_pengiriman['penerima']; ?><br>
                                <?php echo $row_tampil_pengiriman['tlp_penerima']; ?><br>
                                <?php echo $row_tampil_pengiriman['alamat_penerima']; ?><br>
                                <?php echo tampilKota($row_tampil_pengiriman['kd_provinsi'], $row_tampil_pengiriman['kd_kota']); ?><br>
                                <?php echo tampilProvinsi($row_tampil_pengiriman['kd_provinsi']); ?><br>
                                <?php echo $row_tampil_pengiriman['kdpos_penerima']; ?><br>
                            </div>
                        </div>
                    </td>
                    <!-- ./ Kolom Pengiriman -->
                    <td>
                        <h5>Total Barang</h5>
                        <p><?php echo $jml_barang; ?></p>
                    </td>
                    <td>
                        <h5>Total Berat</h5>
                        <p><?php echo $jml_berat; ?> kg</p>
                    </td>
                    <td width="150px">
                        <h5>Subtotal</h5>
                        <p><?php echo uang($sub_total); ?></p>
                    </td>
                    <td width="150px">
                        <?php if ($row_data_faktur['kurir'] == "Flanel") : ?>
                            <h5>Ongkir (<font style="text-transform: capitalize"><?php echo $row_data_faktur['kurir']; ?></font>)</h5>
                        <?php else : ?>
                            <h5>Ongkir (<font style="text-transform: uppercase"><?php echo $row_data_faktur['kurir']; ?></font>)</h5>
                        <?php endif ?>
                        <?php
                        $ongkir = $row_data_faktur['biaya_pengiriman'];
                        echo uang($ongkir);
                        ?>
                        <h5>Lama Pengiriman</h5>
                        <?php echo $row_data_faktur['lama_kirim'] . " hari"; ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="5" align="right" style="font-size: 16px">
                        Total Tagihan <b style="color: red;"><?php echo uang($sub_total + $row_data_faktur['biaya_pengiriman']); ?></b>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- JavaScript
        ================================================== -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
</body>

</html>
<?php
include 'config.php';
include 'koneksi.php';
include 'assets/lib/function.php';
include 'assets/lib/rajaongkir.php';
include 'query_header.php';

$faktur = $_GET['faktur'];
$pelanggan = $_SESSION['pelanggan'];
$sql_penjualan = $con->query("SELECT a.*, b.* FROM penjualan as a, produk as b WHERE a.kd_faktur='$faktur' AND b.kd_produk=a.kd_produk ");
$row_penjualan = $sql_penjualan->fetch(PDO::FETCH_LAZY);
$trow_penjualan = $sql_penjualan->rowCount();

$sql_data_faktur = $con->query("SELECT * FROM faktur WHERE kd_faktur='$faktur' ");
$row_data_faktur = $sql_data_faktur->fetch(PDO::FETCH_LAZY);
$trow_data_faktur = $sql_data_faktur->rowCount();

$sql_tampil_pengiriman = $con->query("SELECT * FROM pengiriman WHERE kd_faktur='$faktur' ");
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
					<li><a href="transaksi">Transaksi</a></li>
					<li class="active">Daftar Pembelian</li>
				</ol>
				<hr>

				<h3>Detail Transaksi <small><?php echo $faktur; ?></small></h3>

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
											<div class="gproduk-sm">
												<img src="assets/images/produk/<?php echo $row_penjualan['foto']; ?>" width="100">
											</div>
										</div>
										<div class="media-body" data-id="<?php echo $row_penjualan['kd_produk']; ?>">
											<h5 class="media-heading"><?php echo $row_penjualan['nama_produk']; ?></h5>
											<b><?php echo $row_penjualan['jml_beli']; ?> Barang (<?php echo berat_kg($row_penjualan['berat']) ?> kg)</b>
											x <?php echo $hargaBarang; ?> <?php echo $hargaDiskon; ?>

										</div>
									</div>
								</td>
								<td colspan="2">
									<h5>Harga Barang</h5>
									<?php echo uang(perkalian($row_penjualan['jml_beli'], $row_penjualan['harga_produk'])); ?>
								</td>
							</tr>

						<?php

							$jml_barang = $row_penjualan['jml_beli'] + $jml_barang;
							$sub_berat = berat_kg($row_penjualan['berat']) * $row_penjualan['jml_beli'];
							$jml_berat = $sub_berat + $jml_berat;
							$sub_total = perkalian($row_penjualan['jml_beli'], $row_penjualan['harga_produk']) + $sub_total;
						} while ($row_penjualan = $sql_penjualan->fetch()); ?>
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
									<h5>Ongkir (<?php echo tampilKurir($row_data_faktur['kurir']); ?>)</h5>
								<?php else : ?>
									<h5>Ongkir (<?php echo tampilKurir($row_data_faktur['kurir']); ?>)</h5>
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

				<h3>Status Transaksi</h3>
				<hr>
				<table width="100%" style="font-size: 14px">
					<?php if ($row_data_faktur['tgl_kirim'] != NULL) : ?>
						<tr>
							<td colspan="2" height="30">
								Barang telah dikirim pada <?php echo longDatepukul($row_data_faktur['tgl_kirim']); ?>
							</td>
						</tr>
						<tr>
							<td width="10%" height="30">Jasa Pengiriman</td>
							<td>: <?php echo $row_data_faktur['kurir']; ?></td>
						</tr>
						<tr>
							<td height="30">Nomor Resi</td>
							<td>: <?php echo $row_data_faktur['resi']; ?></td>
						</tr>
					<?php else : ?>
						<tr>
							<td colspan="2" height="30">
								<?php if ($row_data_faktur['konfirm'] == 'Tunda') : ?>
									<p>Menunggu Konfirmasi Pembayaran.</p>
									<p class="text-justify">Segera lakukan konfirmasi pembayaran sebelum tanggal <?php echo longDatepukul2($row_data_faktur['tgl']); ?></p>
								<?php else : ?>
									Barang Sedang Kami Proses
								<?php endif ?>
							</td>
						</tr>
					<?php endif ?>
				</table>
				<?php if ($row_data_faktur['pembayaran'] != "COD") { ?>
					<h3>Bukti Pembayaran</h3>
					<?php if (empty($row_data_faktur['bukti_transfer'])) {
						echo "Gambar Bukti Pembayaran Belum ada";
					} else { ?>
						<img src="assets/images/konfirmasi/<?php echo $row_data_faktur['bukti_transfer']; ?>" class="img-thumbnail">
					<?php } ?>
				<?php } ?>
			</div>

		</div>
		<!-- /.row -->

	</div>
	<!-- /.container -->

	<div class="modal fade" id="ubah" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div id="hasil"></div>
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
</body>

</html>
<?php
include '../koneksi.php';
include '../config.php';
include '../assets/lib/function.php';
include '../assets/lib/rajaongkir.php';
$page = "order";

if ((isset($_POST["ftambah"])) && ($_POST["ftambah"] == "y")) {

	$kd_faktur = $_POST['kd_faktur'];
	$pelanggan = $_POST['pelanggan'];
	$tgl       = $_POST['tgl'];
	$jam       = $_POST['jam'];
	$tgl_kirim = TglSql($tgl) . " " . $jam;
	$resi      = $_POST['resi'];

	$con->exec("UPDATE faktur SET tgl_kirim='$tgl_kirim', resi='$resi' WHERE kd_faktur='$kd_faktur' ");
	// pesan berhasil
	tampilPesan("Berhasil Disimpan!", "Data yang anda inputkan berhasil disimpan!", "success", "detail_order?kd_faktur=$kd_faktur&&pelanggan=$pelanggan");
}

$kd_faktur = $_GET['kd_faktur'];
$id = $_GET['pelanggan'];
$sql_penjualan = $con->query("SELECT a.*, b.* FROM penjualan as a, produk as b WHERE a.kd_faktur='$kd_faktur' AND b.kd_produk=a.kd_produk ");
$row_penjualan = $sql_penjualan->fetch(PDO::FETCH_LAZY);
$trow_penjualan = $sql_penjualan->rowCount();

$sql_data_faktur = $con->query("SELECT * FROM faktur WHERE kd_faktur='$kd_faktur' ");
$row_data_faktur = $sql_data_faktur->fetch(PDO::FETCH_LAZY);
$trow_data_faktur = $sql_data_faktur->rowCount();

$sql_tampil_pengiriman = $con->query("SELECT * FROM pengiriman WHERE kd_faktur='$kd_faktur' ");
$row_tampil_pengiriman = $sql_tampil_pengiriman->fetch(PDO::FETCH_LAZY);

$jml_barang = 0;
$jml_berat  = 0;
$sub_total  = 0;

if ($row_data_faktur['pembayaran'] != "COD") {
	$a = "required";
	$b = '<span class="input-group-addon danger" style="display: none;"></span>';
} else {
	$a = 'readonly value="COD"';
	$b = '';
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
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/animate.css">
	<link rel="stylesheet" href="../assets/css/admin.css">
	<link rel="stylesheet" href="../assets/fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../assets/css/datepicker/jquery-ui.css">
	<link rel="stylesheet" href="../assets/css/fileinput.css">
</head>

<body class="skin-blue">
	<!-- memanggil file header -->
	<?php include 'header.php'; ?>

	<div class="wrapper row-offcanvas row-offcanvas-left">

		<!-- memanggil file sidemenu -->
		<?php include 'sidemenu.php'; ?>

		<aside class="right-side">
			<!-- Main content -->
			<section class="content">
				<!-- Main row -->
				<div class="row">
					<div class="col-lg-12">
						<div class="panel">
							<header class="panel-heading">
								Detail Order
							</header>
							<div class="panel-body">
								<!-- Tombol tambah -->
								<a href="print_faktur_detail1?kd_faktur = <?php echo $kd_faktur; ?>&&pelanggan=<?php echo $id ?>" target="_blank" class="btn btn-success btn-sm"><span class="fa fa-print"></span> Cetak Faktur</a>
								<br><br>

								<?php if ($row_data_faktur['tgl_kirim'] == NULL and $row_data_faktur['konfirm'] == 'Sudah') : ?>
									<h3>Input Pengiriman</h3>
									<div class="row">
										<div class="col-xs-12">
											<form method="POST" enctype="multipart/form-data">
												<div class="row">
													<div class="col-xs-4">
														<div class="form-group">
															<label>Tanggal Pengiriman</label>
															<div class="input-group col-xs-12">
																<input id="datepicker" type="text" class="form-control" name="tgl" required autocomplete="off">
																<span class="input-group-addon danger" style="display: none;"></span>
															</div>
														</div>
													</div>
													<div class="col-xs-4">
														<div class="form-group">
															<label>Jam Pengiriman</label>
															<div class="input-group col-xs-12">
																<input type="time" class="form-control" name="jam" required autocomplete="off">
																<span class="input-group-addon danger" style="display: none;"></span>
															</div>
														</div>
													</div>
													<div class="col-xs-4">
														<div class="form-group">
															<label>Nomor Resi</label>
															<div class="input-group col-xs-12">
																<input type="text" class="form-control" name="resi" <?php echo $a; ?> autocomplete="off">
																<?php echo $b; ?>
															</div>
														</div>
													</div>
													<div class="col-xs-6">
														<button type="submit" class="btn btn-success" disabled>Simpan</button>
														<input type="hidden" name="ftambah" value="y" />
														<input type="hidden" name="kd_faktur" value="<?php echo $kd_faktur; ?>" />
														<input type="hidden" name="pelanggan" value="<?php echo $id; ?>" />
													</div>
												</div>
											</form>
										</div>
									</div><!-- /.row -->
								<?php endif ?>

								<!-- Tabel -->
								<table class="table table-bordered" style="font-size: 12px">
									<thead>
										<tr>
											<th colspan="5" style="text-align: left; font-weight: bold">
												<h5 style="font-weight: bold">No. Faktur: <?php echo $kd_faktur; ?></h5>
												<h5>Tgl. Faktur : <?php echo longDate($row_data_faktur['tgl']); ?></h5>
												<?php if ($row_data_faktur['tgl_kirim'] != NULL) : ?>
													<h5 style="font-weight: bold">No. Resi : <?php echo $row_data_faktur['resi']; ?></h5>
													<h5 style="font-weight: bold">Tgl. Kirim : <?php echo longDate($row_data_faktur['tgl_kirim']); ?></h5>
												<?php endif ?>
												<?php if ($row_data_faktur['tgl_terima'] != NULL) : ?>
													<h5 style="font-weight: bold">Tgl. Terima Barang : <?php echo longDate($row_data_faktur['tgl_terima']); ?></h5>
												<?php endif ?>
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
																<img src="../assets/images/produk/<?php echo $row_penjualan['foto']; ?>" width="100">
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

								<?php if ($row_data_faktur['pembayaran'] != "COD") { ?>
									<h3>Bukti Pembayaran</h3>
									<?php if (empty($row_data_faktur['bukti_transfer'])) {
										echo "Gambar Bukti Pembayaran Belum ada";
									} else { ?>
										<img src="../assets/images/konfirmasi/<?php echo $row_data_faktur['bukti_transfer']; ?>" class="img-thumbnail">
									<?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div> <!-- /.row -->
			</section><!-- /.content -->

		</aside><!-- /.right-side -->
	</div><!-- ./wrapper -->

	<!-- JavaScript
        ================================================== -->
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/app.js"></script>
	<script src="../assets/js/validasi.js"></script>
	<script src="../assets/js/validasiinput.js"></script>

	<script src="../assets/js/datepicker/jquery-ui.js"></script>
	<script type="text/javascript">
		$('#datepicker').datepicker({
			dateFormat: "dd-mm-yy",
			yearRange: '2000:2020',
			changeMonth: true,
			changeYear: true,
			showAnim: "drop"
		});
	</script>
</body>

</html>
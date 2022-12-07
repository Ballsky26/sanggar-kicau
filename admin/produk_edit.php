<?php
include '../koneksi.php';
include '../config.php';
include '../assets/lib/function.php';
$page = "produk";
$tbbatal = "Batal";
$gagal = false;
if ((isset($_POST["ftambah"])) && ($_POST["ftambah"] == "y")) {

	$kd_produk   = $_POST['kd_produk'];
	$nama_produk = $_POST['nama_produk'];
	$kd_kategori = $_POST['kd_kategori'];
	$warna       = $_POST['warna'];
	$ukuran      = $_POST['ukuran'];
	$berat       = $_POST['berat'];
	$harga       = hanyaAngka($_POST['harga']);
	$stok        = $_POST['stok'];
	$deskripsi   = $_POST['deskripsi'];
	$foto        = $_FILES['foto']['name'];
	$diskon      = $_POST['diskon'];
	$isi         = $_POST['promo'];
	$jumlah_foto = count($_FILES['foto']['name']);

	// query untuk mencari nama produk yang sama
	$sql_cek = $con->query("SELECT * FROM produk WHERE nama_produk='$nama_produk' AND kd_produk!='$kd_produk' ");
	$row_cek = $sql_cek->fetch(PDO::FETCH_LAZY);
	$trow_cek = $sql_cek->rowCount();

	if (empty($trow_cek)) { // bila data tidak ada

		$sql_cek_promo = $con->query("SELECT * FROM promo WHERE kd_produk='$kd_produk'");
		$row_cek_promo = $sql_cek_promo->fetch(PDO::FETCH_LAZY);
		$trow_cek_promo = $sql_cek_promo->rowCount();

		if (empty($trow_cek_promo)) {
			$con->exec("INSERT INTO promo (isi, kd_produk) VALUES('$isi','$kd_produk') ");
		} else {
			$con->exec("UPDATE promo SET isi='$isi' WHERE kd_produk='$kd_produk' ");
		}

		if (!empty($foto)) {  // jika foto tidak kosong

			$folder     = '../assets/images/produk/';
			$no = 1;

			for ($i = 0; $i < $jumlah_foto; $i++) {

				$foto_baru = "produk" . date("dmyhis") . $no++ . ".jpg";
				if (move_uploaded_file($_FILES['foto']['tmp_name'][$i], $folder . $foto_baru)) {
					$con->exec("INSERT INTO foto_produk (kd_produk, foto) 
				    			VALUES (
				    			'" . $kd_produk . "',
				    			'" . $foto_baru . "'
				    			)");
				} else {
					// pesan gagal
					tampilPesan("Gagal Disimpan!", "Telah terjadi kesalahan pada sistem!", "warning");
					$tbbatal = "Ulangi";
				}
			}
			$sql_pfoto = $con->query("SELECT * FROM foto_produk WHERE kd_produk='$kd_produk' ");
			$row_pfoto = $sql_pfoto->fetch(PDO::FETCH_LAZY);
			$trow_pfoto = $sql_pfoto->rowCount();
			if (!empty($trow_pfoto)) {
				$pfoto = $row_pfoto['foto'];
			} else {
				$pfoto = "produk.png";
			}
			$con->exec("UPDATE produk SET nama_produk='$nama_produk', kd_kategori='$kd_kategori', warna='$warna', ukuran='$ukuran', berat='$berat', harga='$harga', stok='$stok', deskripsi='$deskripsi', foto='$pfoto', diskon='$diskon' WHERE kd_produk='$kd_produk' ");

			tampilPesan("Berhasil Disimpan!", "Data yang anda inputkan berhasil disimpan!", "success", "produk");
		} else { // foto kosong
			// proses simpan tanpa upload gambar
			$con->exec("UPDATE produk SET nama_produk='$nama_produk', kd_kategori='$kd_kategori', warna='$warna', ukuran='$ukuran', berat='$berat', harga='$harga', stok='$stok', deskripsi='$deskripsi', diskon='$diskon' WHERE kd_produk='$kd_produk' ");
			// pesan berhasil
			tampilPesan("Berhasil Disimpan!", "Data yang anda inputkan berhasil disimpan!", "success", "produk");
		}
	} else { // bila data ada
		// pesan gagal
		tampilPesan("Gagal Disimpan!", "Data yang anda inputkan sudah ada!", "warning");
		$tbbatal = "Ulangi";
	} //end if

}

if ((isset($_GET["hapusfoto"])) && ($_GET["hapusfoto"] == "y")) {

	$kd_produk  = $_GET['kd_produk'];
	$foto = $_GET['foto'];
	if ($foto != "produk.png") {
		unlink("../assets/images/produk/$foto");
	}
	$con->exec("DELETE FROM foto_produk WHERE foto = '$foto'");
	tampilPesan("Berhasil Dihapus!", "Data yang dipilih berhasil dihapus!", "success", "produk_edit?kd_produk=$kd_produk");
}

$kd_produk = $_GET['kd_produk'];
$sql = $con->query("SELECT * FROM produk WHERE kd_produk='$kd_produk' ");
$row = $sql->fetch(PDO::FETCH_LAZY);

$sql_promo = $con->query("SELECT * FROM promo WHERE kd_produk='$kd_produk'");
$row_promo = $sql_promo->fetch(PDO::FETCH_LAZY);
$trow_promo = $sql_promo->rowCount();

$sql_foto = $con->query("SELECT * FROM foto_produk WHERE kd_produk='$kd_produk' ");
$row_foto = $sql_foto->fetch(PDO::FETCH_LAZY);
$trow_foto = $sql_foto->rowCount();

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
	<link rel="stylesheet" href="../assets/css/sweetalert.css">
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
								Edit Produk
							</header>
							<div class="panel-body table-responsive">
								<?php if (!empty($trow_foto)) : ?>
									<div class="row">
										<?php do { ?>
											<form method="GET">
												<div class="col-sm-3">
													<div class="thumbnail">
														<div class="gproduk">
															<img src="../assets/images/produk/<?php echo $row_foto['foto']; ?>">
														</div>
														<div class="caption">
															<p>
																<button type="submit" class="btn btn-danger">Hapus</button>
															</p>
														</div>
													</div>
												</div>
												<input type="hidden" name="hapusfoto" value="y">
												<input type="hidden" name="foto" value="<?php echo $row_foto['foto']; ?>">
												<input type="hidden" name="kd_produk" value="<?php echo $kd_produk; ?>">
											</form>
										<?php } while ($row_foto = $sql_foto->fetch()); ?>
									</div>
								<?php endif ?>
								<form method="POST" enctype="multipart/form-data">
									<div class="row">
										<div class="col-xs-12">
											<div class="row">
												<div class="col-xs-12">
													<div class="form-group">
														<label>Gambar</label>
														<div class="input-group col-xs-12">
															<input id="avatar" name="foto[]" type="file" multiple class="file" data-overwrite-initial="false" />
														</div>
													</div>
												</div>
												<div class="col-xs-6">
													<div class="form-group">
														<label>Nama produk</label>
														<div class="input-group col-xs-12">
															<input type="text" class="form-control" name="nama_produk" required autocomplete="off" value="<?php echo $row['nama_produk']; ?>">
															<span class="input-group-addon danger" style="display: none;"></span>
														</div>
													</div>
												</div>
												<div class="col-xs-6">
													<div class="form-group">
														<label>Kategori</label>
														<div class="input-group col-xs-12">
															<select name="kd_kategori" class="form-control" required>
																<?php
																$sql_kategori = $con->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
																$row_kategori = $sql_kategori->fetch();
																do {
																	$kd_kategori = $row_kategori['kd_kategori'];
																	$nama_kategori = $row_kategori['nama_kategori'];
																?>
																	<option value="<?php echo $kd_kategori ?>" <?php echo terpilih($kd_kategori, $row['kd_kategori']); ?>>
																		<?php echo $nama_kategori; ?>
																	</option>
																<?php } while ($row_kategori = $sql_kategori->fetch()); ?>
															</select>
															<span class="input-group-addon danger" style="display: none;"></span>
														</div>
													</div>
												</div>
												<!-- <div class="col-xs-6">
													<div class="form-group">
														<label>Bahan</label>
														<div class="input-group col-xs-12">
															<input type="text" class="form-control" name="bahan" required autocomplete="off" value="<?php echo $row['bahan']; ?>">
															<span class="input-group-addon danger" style="display: none;"></span>
														</div>
													</div>
												</div> -->
												<div class="col-xs-6">
													<div class="form-group">
														<label>Warna</label>
														<div class="input-group col-xs-12">
															<input type="text" class="form-control" name="warna" required autocomplete="off" value="<?php echo $row['warna']; ?>">
															<span class="input-group-addon danger" style="display: none;"></span>
														</div>
													</div>
												</div>
											</div>
											<div class="row" style="margin-top: 20px">
												<div class="col-xs-6">
													<div class="form-group">
														<label>Ukuran</label>
														<div class="input-group col-xs-12">
															<input type="text" class="form-control" name="ukuran" required autocomplete="off" value="<?php echo $row['ukuran']; ?>">
															<span class="input-group-addon danger" style="display: none;"></span>
														</div>
													</div>
													<div class="form-group">
														<label>Berat (gram)</label>
														<div class="input-group col-xs-12">
															<input type="text" class="form-control" name="berat" required autocomplete="off" onKeyPress="return goodchars(event,'0123456789.',this)" value="<?php echo $row['berat']; ?>">
															<span class="input-group-addon danger" style="display: none;"></span>
														</div>
													</div>
												</div>
												<div class="col-xs-6">
													<div class="form-group">
														<label>Harga</label>
														<div class="input-group col-xs-12">
															<input id="harga" type="text" class="form-control" name="harga" required autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" value="<?php echo $row['harga']; ?>">
															<span class="input-group-addon danger" style="display: none;"></span>
														</div>
													</div>
													<div class="form-group">
														<label>Stok</label>
														<div class="input-group col-xs-12">
															<input type="text" class="form-control" name="stok" maxlength="5" required autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" value="<?php echo $row['stok']; ?>">
															<span class="input-group-addon danger" style="display: none;"></span>
														</div>
													</div>
												</div>
												<div class="col-xs-6">
													<div class="form-group">
														<label>Diskon (%)</label>
														<div class="input-group col-xs-12">
															<input type="text" class="form-control" name="diskon" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" maxlength="2" max="90" onKeyUp="validasi_diskon(this)" value="<?php echo $row['diskon']; ?>">
														</div>
													</div>
												</div>
												<div class="col-xs-6">
													<div class="form-group">
														<label>Promo</label>
														<div class="input-group col-xs-12">
															<input type="text" class="form-control" name="promo" autocomplete="off" value="<?php echo $row_promo['isi']; ?>">
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-12">
													<div class="form-group">
														<label>Deskripsi</label>
														<div class="input-group col-xs-12">
															<textarea name="deskripsi" class="ckeditor" id="editor1"><?php echo $row['deskripsi']; ?></textarea>
														</div>
													</div>
													<button type="submit" class="btn btn-success" disabled>Simpan</button>
													<button type="button" class="btn btn-danger" onclick="self.history.back()"><?php echo $tbbatal; ?></button>
													<input type="hidden" name="ftambah" value="y" />
													<input type="hidden" name="kd_produk" value="<?php echo $kd_produk; ?>" />
													<input type="hidden" name="foto_lama" value="<?php echo $foto; ?>" />
												</div>
											</div>
										</div>
									</div><!-- /.row -->
							</div> <!-- /.panel body -->
							</form>
						</div> <!-- /.panel -->
					</div>
				</div> <!-- /.row -->
			</section> <!-- /.content -->

		</aside><!-- /.right-side -->
	</div><!-- ./wrapper -->

	<!-- JavaScript
        ================================================== -->
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/app.js"></script>
	<script src="../assets/js/sweetalert.js"></script>
	<script src="../assets/js/validasi.js"></script>
	<script src="../assets/js/validasiinput.js"></script>
	<script src="../assets/js/matauang.js"></script>
	<script type="text/javascript">
		function validasi_diskon(tag) {
			var diskon = parseInt('90');
			if (diskon < $(tag).val()) {
				alert('Maaf.. Diskon melebihi ketentuan');
				$(tag).val('1');
			}
		}
		$(document).ready(function() {
			//VALIDASI STOK
			$('#diskon').change(function() {
				validasi_diskon(this);
			});
			$('#diskon').keyup(function() {
				validasi_diskon(this);
			});

		});
	</script>
	<script type="text/javascript">
		$('#harga').priceFormat({
			prefix: '', // Simbol mata uang
			centsSeparator: '.', // Karakter pemisah untuk sen atau koma, gunakan str_replace saat menyimpan data ke database
			thousandsSeparator: '.', // Karakter pemisah untuk ribuan
			centsLimit: 0 // Jumlah batas angka di belakang koma
		});
	</script>

	<script src="../assets/js/ckeditor/ckeditor.js"></script>
	<script language="javascript" type="text/javascript">
		CKEDITOR.replace('editor1', {
			toolbar: 'Basic',
			height: '300px',
			// filebrowserWindowWidth : '900',
			// filebrowserWindowHeight : '400',
			filebrowserBrowseUrl: '/gsb/assets/js/ckfinder/ckfinder.html',
			filebrowserImageBrowseUrl: '/gsb/assets/js/ckfinder/ckfinder.html?type=Images',
			filebrowserFlashBrowseUrl: '/gsb/assets/js/ckfinder/ckfinder.html?type=Flash',
			filebrowserUploadUrl: '/gsb/assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
			filebrowserImageUploadUrl: '/gsb/assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
			filebrowserFlashUploadUrl: '/gsb/assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
		});
	</script>

	<script src="../assets/js/file-input/fileinput.js" type="text/javascript"></script>
	<script src="../assets/js/file-input/fileinput_locale_LANG.js" type="text/javascript"></script>
	<script>
		$("#avatar").fileinput({
			uploadUrl: 'http://web/gsb/assets/images/produk/', // you must set a valid URL here else you will get an error
			overwriteInitial: false,
			maxFileSize: 1000000,
			maxFilesNum: 10,
			showUpload: false,
			layoutTemplates: {
				main2: '{preview} {browse}'
			},
			allowedFileExtensions: ["jpg"],
			slugCallback: function(filename) {
				return filename.replace('(', '_').replace(']', '_');
			}
		});
	</script>
</body>

</html>
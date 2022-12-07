<?php
include '../koneksi.php';
include '../config.php';
include '../assets/lib/function.php';
$page = "produk";
$tbbatal = "Batal";
$gagal = false;
if ((isset($_POST["ftambah"])) && ($_POST["ftambah"] == "y")) {

	$nama_produk = $_POST['nama_produk'];
	$kd_kategori = $_POST['kd_kategori'];
	// $bahan       = $_POST['bahan'];
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
	$sql_cek = $con->query("SELECT * FROM produk WHERE nama_produk='$nama_produk' ");
	$row_cek = $sql_cek->fetch(PDO::FETCH_LAZY);
	$trow_cek = $sql_cek->rowCount();

	$sql_max = $con->query("SELECT MAX(kd_produk) as max_produk FROM produk");
	$row_max = $sql_max->fetch(PDO::FETCH_LAZY);
	$trow_max = $sql_max->rowCount();
	$max_produk = $row_max['max_produk'] + 1;
	$kd_produk_baru = $max_produk;


	if (empty($trow_cek)) { // bila data tidak ada

		// ======================= Input Promo
		$con->exec("INSERT INTO promo (isi, kd_produk) VALUES('$isi','$kd_produk_baru') ");

		if (!empty($foto)) {  // jika foto tidak kosong

			$folder     = '../assets/images/produk/';
			$no = 1;

			for ($i = 0; $i < $jumlah_foto; $i++) {

				$foto_baru = "produk" . date("dmyhis") . $no++ . ".jpg .png";
				if (move_uploaded_file($_FILES['foto']['tmp_name'][$i], $folder . $foto_baru)) {
					$con->exec("INSERT INTO foto_produk (kd_produk, foto) 
				    			VALUES (
				    			'" . $kd_produk_baru . "',
				    			'" . $foto_baru . "'
				    			)");
				} else {
					// pesan gagal
					tampilPesan("Gagal Disimpan!", "Telah terjadi kesalahan pada sistem!", "warning");
					$tbbatal = "Ulangi";
				}
			}
			$con->exec("INSERT INTO produk (kd_produk, nama_produk, kd_kategori, warna, ukuran, berat, harga, stok, deskripsi, foto, diskon) 
				    			VALUES (
				    			'" . $kd_produk_baru . "',
				    			'" . $nama_produk . "',
				    			'" . $kd_kategori . "',
				    			'" . $warna . "',
				    			'" . $ukuran . "',
				    			'" . $berat . "',
				    			'" . $harga . "',
				    			'" . $stok . "',
				    			'" . $deskripsi . "',
				    			'" . $foto_baru . "',
				    			'" . $diskon . "'
				    			)");
			tampilPesan("Berhasil Disimpan!", "Data yang anda inputkan berhasil disimpan!", "success", "produk");
		} else { // foto kosong
			// proses simpan tanpa upload gambar
			$con->exec("INSERT INTO produk (kd_produk, nama_produk, kd_kategori, warna, ukuran, berat, harga, stok, deskripsi, diskon) 
		    			VALUES (
		    			'" . $kd_produk_baru . "',
		    			'" . $nama_produk . "',
		    			'" . $kd_kategori . "',
		    			'" . $warna . "',
		    			'" . $ukuran . "',
		    			'" . $berat . "',
		    			'" . $harga . "',
		    			'" . $stok . "',
		    			'" . $deskripsi . "',
		    			'" . $diskon . "'
		    			)");
			// pesan berhasil
			tampilPesan("Berhasil Disimpan!", "Data yang anda inputkan berhasil disimpan!", "success", "produk");
		}
	} else { // bila data ada
		// pesan gagal
		tampilPesan("Gagal Disimpan!", "Data yang anda inputkan sudah ada!", "warning");
		$tbbatal = "Ulangi";
	} //end if

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
								Tambah Produk
							</header>
							<form method="POST" enctype="multipart/form-data">
								<div class="panel-body table-responsive">
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
															<input type="text" class="form-control" name="nama_produk" required autocomplete="off">
															<span class="input-group-addon danger" style="display: none;"></span>
														</div>
													</div>
												</div>
												<div class="col-xs-6">
													<div class="form-group">
														<label>Kategori</label>
														<div class="input-group col-xs-12">
															<select name="kd_kategori" class="form-control" required>
																<option>-- Pilih Kategori --</option>
																<?php
																$sql_kategori = $con->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
																$row_kategori = $sql_kategori->fetch();
																do {
																	$kd_kategori = $row_kategori['kd_kategori'];
																	$nama_kategori = $row_kategori['nama_kategori'];
																?>
																	<option value="<?php echo $kd_kategori ?>">
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
				                                            <input type="text" class="form-control" name="bahan" required autocomplete="off">
				                                            <span class="input-group-addon danger" style="display: none;"></span>
				                                        </div>
				                                    </div>
				                                </div> -->
												<div class="col-xs-6">
													<div class="form-group">
														<label>Warna</label>
														<div class="input-group col-xs-12">
															<input type="text" class="form-control" name="warna" required autocomplete="off">
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
															<input type="text" class="form-control" name="ukuran" required autocomplete="off">
															<span class="input-group-addon danger" style="display: none;"></span>
														</div>
													</div>
													<div class="form-group">
														<label>Berat (gram)</label>
														<div class="input-group col-xs-12">
															<input type="text" class="form-control" name="berat" required autocomplete="off" onKeyPress="return goodchars(event,'0123456789.',this)">
															<span class="input-group-addon danger" style="display: none;"></span>
														</div>
													</div>
												</div>
												<div class="col-xs-6">
													<div class="form-group">
														<label>Harga</label>
														<div class="input-group col-xs-12">
															<input id="harga" type="text" class="form-control" name="harga" required autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)">
															<span class="input-group-addon danger" style="display: none;"></span>
														</div>
													</div>
													<div class="form-group">
														<label>Stok</label>
														<div class="input-group col-xs-12">
															<input type="text" class="form-control" name="stok" maxlength="5" required autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)">
															<span class="input-group-addon danger" style="display: none;"></span>
														</div>
													</div>
												</div>
												<div class="col-xs-6">
													<div class="form-group">
														<label>Diskon (%)</label>
														<div class="input-group col-xs-12">
															<input type="text" class="form-control" name="diskon" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" maxlength="2" max="50" onKeyUp="validasi_diskon(this)">
														</div>
													</div>
												</div>
												<div class="col-xs-6">
													<div class="form-group">
														<label>Promo</label>
														<div class="input-group col-xs-12">
															<input type="text" class="form-control" name="promo" autocomplete="off">
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-12">
													<div class="form-group">
														<label>Deskripsi</label>
														<div class="input-group col-xs-12">
															<textarea name="deskripsi" class="ckeditor" id="editor1"></textarea>
														</div>
													</div>
													<button type="submit" class="btn btn-success" disabled>Simpan</button>
													<button type="button" class="btn btn-danger" onclick="self.history.back()"><?php echo $tbbatal; ?></button>
													<input type="hidden" name="ftambah" value="y" />
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
			var diskon = parseInt('50');
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
			allowedFileExtensions: ['jpg'],
			overwriteInitial: false,
			maxFileSize: 1000000,
			maxFilesNum: 10,
			showUpload: false,
			layoutTemplates: {
				main2: '{preview} {browse}'
			},
			slugCallback: function(filename) {
				return filename.replace('(', '_').replace(']', '_');
			}
		});
	</script>
</body>

</html>
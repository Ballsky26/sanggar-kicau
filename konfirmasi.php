<?php
include 'config.php';
include 'koneksi.php';
include 'assets/lib/function.php';
include 'query_header.php';

$faktur = $_GET['faktur'];

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
					<li><a href="daftar_pembelian">Daftar Pembelian</a></li>
					<li class="active">Konfirmasi</li>
				</ol>

				<?php
				$gagal = false;
				if ((isset($_POST["konfirmasi"])) && ($_POST["konfirmasi"] == "y")) {

					$foto        = $_FILES['foto']['name'];
					$faktur      = $_POST['kd_faktur'];

					$folder     = 'assets/images/konfirmasi/';
					//type file yang bisa diupload
					$file_type  = array('jpg', 'png', 'gif', 'JPG', 'PNG');
					//tukuran maximum file yang dapat diupload
					$max_size   = 1000000; // 10MB
					//Mulai memorises data
					$file_name  = $_FILES['foto']['name'];
					$file_size  = $_FILES['foto']['size'];
					//cari extensi file dengan menggunakan fungsi explode
					$explode    = explode('.', $file_name);
					$extensi    = $explode[count($explode) - 1];

					//check apakah type file sudah sesuai
					if (!in_array($extensi, $file_type)) {
						$gagal = true;
						$pesan = 'Type file yang anda upload tidak sesuai = ' . $extensi;
					}
					//check ukuran file apakah sudah sesuai
					if ($file_size > $max_size) {
						$gagal = true;
						$pesan = 'Ukuran file melebihi batas maximum';
					}

					if ($gagal == true) {
						tampilPesan("Konfirmasi Gagal!", "$pesan", "warning");
					} else {
						//mengganti nama file foto
						$foto_baru = $faktur . "." . $extensi;
						if (move_uploaded_file($_FILES['foto']['tmp_name'], $folder . $foto_baru)) {

							$con->exec("UPDATE faktur SET konfirm='Dikirim', bukti_transfer='$foto_baru' WHERE kd_faktur='$faktur'");
							// pesan berhasil
							tampilPesan("Konfirmasi Berhasil!", "Bukti pembayaran yang anda upload berhasil dikirim!", "success", "./");
						} else {
							// pesan gagal
							tampilPesan("Konfirmasi Gagal!", "Telah terjadi kesalahan pada sistem!", "warning");
						}
					}
				}
				?>
				<hr>

				<h3>Konfirmasi Pembayaran</h3>

				<br>
				<br>
				<form method="POST" enctype="multipart/form-data">
					<div class="row">
						<div class="col-xs-3">
							<div class="form-group">
								<label>Silahkan Upload Bukti Pembayaran</label>
								<div class="input-group col-xs-12">
									<input id="bukti" name="foto" type="file" class="form-control" required />
									<span class="input-group-addon danger" style="display: none;"></span>
								</div>
							</div>
							<!-- <button type="submit" class="btn btn-large btn-success pull-right"  disabled>Kirim Konfirmasi</button> -->
						</div>
					</div>
					<input type="hidden" name="kd_faktur" value="<?php echo $faktur; ?>">
					<input type="hidden" name="konfirmasi" value="y">
				</form>

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
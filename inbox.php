<?php
include 'config.php';
include 'koneksi.php';
include 'assets/lib/function.php';
include 'query_header.php';

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
	<link rel="stylesheet" href="assets/css/datatables/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/sweetalert.css">
</head>

<body>
	<?php include 'header.php'; ?>
	<div class="container" style="margin-bottom: 150px">

		<div class="row">

			<div class="col-md-12">

				<ol class="breadcrumb">
					<li><a href="./">Home</a></li>
					<li class="active">Inbox</li>
				</ol>
				<hr>
				<?php
				$userid = $_SESSION['pelanggan'];
				if ((isset($_POST["fhapus"])) && ($_POST["fhapus"] == "y")) {

					$kd_inbox  = $_POST['kd_inbox'];

					$con->exec("DELETE FROM inbox WHERE kd_inbox = '$kd_inbox'");
					$con->exec("DELETE FROM inbox_detail WHERE kd_inbox = '$kd_inbox'");

					// pesan berhasil
					tampilPesan("Berhasil Dihapus!", "Data yang dipilih berhasil dihapus!", "success", "inbox");
				}

				if ((isset($_POST["fkirim"])) && ($_POST["fkirim"] == "y")) {

					$kd_inbox = $_POST['kd_inbox'];
					$userid   = $_POST['userid'];
					$pesan    = $_POST['kirimpesan'];
					$con->exec("INSERT INTO inbox_detail (kd_inbox, userid, pesan) 
	    			VALUES (
	    			'" . $kd_inbox . "',
	    			'" . $userid . "',
	    			'" . $pesan . "'
	    			)");

					// pesan berhasil
					tampilPesan("Berhasil Dikirim!", "Data yang dipilih berhasil dikirim!", "success", "inbox");
				}

				if ((isset($_POST["buat_pesan"])) && ($_POST["buat_pesan"] == "y")) {

					$kd_inbox = $_POST['kd_inbox'];
					$pengirim = $_POST['pengirim'];
					$judul    = $_POST['judul'];
					$pesan    = $_POST['pesan'];

					$con->exec("INSERT INTO inbox (kd_inbox, pengirim, judul, tujuan) 
	    			VALUES (
	    			'" . $kd_inbox . "',
	    			'" . $pengirim . "',
	    			'" . $judul . "',
	    			'Admin'
	    			)");

					$con->exec("INSERT INTO inbox_detail (kd_inbox, userid, pesan) 
	    			VALUES (
	    			'" . $kd_inbox . "',
	    			'" . $pengirim . "',
	    			'" . $pesan . "'
	    			)");

					tampilPesan("Berhasil Dikirim!", "Data yang dipilih berhasil dikirim!", "success", "inbox");
				}

				$sql = $con->query("SELECT * FROM inbox WHERE pengirim='$userid' ");
				$row = $sql->fetch(PDO::FETCH_LAZY);
				$trow = $sql->rowCount();
				?>
				<div class="row">
					<div id="panelPesan" class="col-lg-12">
						<div class="panel">
							<header class="panel-heading">
								<a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#buat_pesan"><span class="fa fa-pencil-square-o"></span> Tulis Pesan</a>
							</header>

							<div class="panel-body table-responsive">
								<!-- Tombol tambah -->


								<!-- Tabel -->
								<table id="tabel" class="table table-hover table-striped" cellspacing="0" width="100%" style="font-size: 13px">
									<thead>
										<tr class="hidden">
											<th>Hapus</th>
											<th>Pelanggan</th>
											<th>Isi</th>
											<th>Tanggal</th>
										</tr>
									</thead>
									<tbody>
										<?php do {
											$kd_inbox = $row['kd_inbox'];

											$sql_dpesan = $con->query("SELECT * FROM inbox_detail WHERE kd_inbox='$kd_inbox' ORDER BY tgl DESC ");
											$row_dpesan = $sql_dpesan->fetch(PDO::FETCH_LAZY);
											$trow_dpesan = $sql_dpesan->rowCount();
											$emailadmin = $row_dpesan['userid'];

											$sql_cariadmin = $con->query("SELECT * FROM admin WHERE email='$emailadmin' ");
											$row_cariadmin = $sql_cariadmin->fetch(PDO::FETCH_LAZY);
											$trow_cariadmin = $sql_cariadmin->rowCount();
											$nama = $row_cariadmin['nama_admin'];

											if ($row_dpesan['status'] == "N" and $row_dpesan['userid'] != $userid) {
												$tebal = "style='font-weight: bold; vertical-align: middle;'";
											} else {
												$tebal = "style='vertical-align: middle;'";
											}

										?>
											<tr data-id="<?php echo $kd_inbox; ?>">
												<td width="1%" <?php echo $tebal; ?>>
													<form method="POST">
														<?php if (!empty($trow)) : ?>
															<button type="submit" class='submit btn btn-default btn-sm'>
																<i class="fa fa-trash" aria-hidden="true"></i>
															</button>
														<?php endif; ?>
														<input type="hidden" name="fhapus" value="y" />
														<input type="hidden" name="kd_inbox" value="<?php echo $row['kd_inbox']; ?>" />
													</form>
												</td>
												<td width="auto" <?php echo $tebal; ?>><?php echo $nama; ?></td>
												<td width="auto" <?php echo $tebal; ?>>
													<div class="view_pesan">
														<a href="javascript:void(0)" style="color: black" class="sidebar-hide-btn">
															<h4 style="font-weight: bolder; color: #20B0A8;"><?php echo $row['judul']; ?></h4>
															<p><?php echo substr($row_dpesan['pesan'], 0, 50) . '..'; ?></p>
														</a>
													</div>
												</td>
												<td width="auto" align="right" <?php echo $tebal; ?>>
													<small><i style="padding-right: 20px"><?php echo timeAgo(strtotime($row_dpesan['tgl'])); ?></i></small>
												</td>
											</tr>
										<?php } while ($row = $sql->fetch(PDO::FETCH_LAZY)); ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div id="panelSlide" class="col-lg-4 hidden pull-right">
						<section class="panel">
							<header class="panel-heading">
								Detail Pesan
								<button id="tutupPanelSlide" class="btn btn-default btn-sm pull-right"><i class="fa fa-times"></i></button>
							</header>
							<div class="panel-body" id="noti-box">
								<div id="hasil"></div>

						</section>
					</div>
				</div>

			</div>

		</div>
		<!-- /.row -->

	</div>
	<!-- /.container -->

	<div class="modal fade" id="buat_pesan">
		<?php
		$sql_max_inbox  = $con->query("SELECT *, MAX(kd_inbox) AS max_inbox FROM inbox");
		$row_max_inbox  = $sql_max_inbox->fetch(PDO::FETCH_LAZY);
		$trow_max_inbox = $sql_max_inbox->rowCount();
		$max            = $row_max_inbox['max_inbox'];
		$id_max         = $max + 1;
		?>
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="POST">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Tulis Pesan Baru</h4>
					</div>
					<div class="modal-body">

						<div class="form-group">
							<label>Judul</label>
							<div class="input-group col-xs-12">
								<input class="form-control" name="judul" required>
								<span class="input-group-addon danger" style="display: none;"></span>
							</div>
						</div>
						<div class="form-group">
							<label>Pesan</label>
							<div class="input-group col-xs-12">
								<textarea name="pesan" class="form-control" style="width:100%; resize: none;" rows="4" required></textarea>
								<span class="input-group-addon danger" style="display: none;"></span>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
						<button name="buat_pesan" value="y" type="submit" class="btn btn-primary" disabled>Kirim</button>
						<input type="hidden" name="pengirim" value="<?php echo $userid; ?>">
						<input type="hidden" name="kd_inbox" value="<?php echo $id_max; ?>">
					</div>
				</form>
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
	<script src="assets/js/app.js"></script>
	<!-- tabel -->
	<script src="assets/js/datatables/jquery.dataTables.js"></script>
	<script src="assets/js/datatables/dataTables.bootstrap.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#tabel').dataTable({
				"columnDefs": [{
					"targets": [0],
					"searchable": false,
					"orderable": false,
				}]
			});
		});
	</script>
	<script>
		$(document).ready(function() {
			$(".view_pesan").click(function() {
				var id = $(this).parents('tr').data('id');
				$.ajax({
					type: "post",
					url: "inbox_slide.php",
					data: "q=" + id,
					success: function(data) {
						$("#hasil").html(data);
					}
				});
			});
		});
	</script>

	<!-- konfirmasi -->
	<script src="assets/js/sweetalert.js"></script>
	<script>
		$('.submit').on('click', function(e) {
			e.preventDefault();
			var form = $(this).parents('form');
			swal({
				title: "Apakah anda yakin?",
				text: "Data yang terhapus tidak dapat dikembalikan!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Ya, hapus saja!",
				cancelButtonText: "Batal",
				closeOnConfirm: false
			}, function(isConfirm) {
				if (isConfirm) form.submit();
			});
		})
	</script>
	<script>
		var a = false;
		var delay = 300;
		$(".sidebar-hide-btn").click(function() {

			$('#panelPesan').removeClass('col-lg-12');
			$('#panelPesan').addClass('col-lg-8');
			$('#panelPesan').addClass('animasi');
			a = true;
			if (a == true) {
				setTimeout(function() {
					$('#panelSlide').removeClass('hidden');
					$('#panelSlide').addClass('visible');
					$('#panelSlide').addClass('animasi');
				}, delay);
			};
		});

		$("#tutupPanelSlide").click(function() {
			$('#panelPesan').removeClass('col-lg-8');
			$('#panelPesan').addClass('col-lg-12');
			$('#panelPesan').addClass('animasi');

			$('#panelSlide').removeClass('visible');
			$('#panelSlide').addClass('hidden');
			$('#panelSlide').addClass('animasi');
		});
	</script>
</body>

</html>
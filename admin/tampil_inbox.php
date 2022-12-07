<?php
include '../koneksi.php';
include '../config.php';
include '../assets/lib/function.php';
$page = "inbox";

$kd_inbox = $_GET['kd_inbox'];
$pelanggan = $_GET['email_plg'];

$sql = $con->query("SELECT * FROM inbox_detail WHERE kd_inbox='$kd_inbox' ORDER BY kd_inbox_detail ASC");
$row = $sql->fetch();
$con->exec("UPDATE inbox_detail SET status='R' WHERE kd_inbox='$kd_inbox' AND userid='$pelanggan' ");

$sql_pelanggan = $con->query("SELECT * FROM pelanggan WHERE email_plg='$pelanggan' ");
$row_pelanggan = $sql_pelanggan->fetch(PDO::FETCH_LAZY);

$sql_inbox = $con->query("SELECT * FROM inbox WHERE kd_inbox='$kd_inbox' ");
$row_inbox = $sql_inbox->fetch(PDO::FETCH_LAZY);

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
	    <link rel="stylesheet" href="../assets/css/datatables/dataTables.bootstrap.min.css">
	    <link rel="stylesheet" href="../assets/css/sweetalert.css">
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
				        <div id="panelPesan" class="col-lg-12">
							<div class="panel">
				                <header class="panel-heading">
				                    Pesan dari <?php echo $row_pelanggan['nama_plg']; ?> - <?php echo $row_inbox['judul']; ?>
				                    <a href="inbox" class="btn btn-default btn-sm pull-right"><i class="fa fa-times"></i></a>
				                </header>
				                <div class="panel-body table-responsive">
				                	<div style='width:100%' id='pesan'>
										<?php
											do{
												$userid = $row['userid'];

												$sql_tipe = $con->query("SELECT * FROM user WHERE userid='$userid' ");
												$row_tipe = $sql_tipe->fetch(PDO::FETCH_LAZY);
												$tipe = $row_tipe['tipe'];
												echo '<div class="row">';
												echo '<div class="col-lg-12">';
												if ($tipe == "Pelanggan") {
													echo '<div class="balon-a pull-left" style="width:78%">';
													$waktu = "balon-jam-left";
													$pelanggan = $row['userid'];
												} else {
													echo '<div class="balon-b pull-right" style="width:78%">';
													$waktu = "balon-jam-right";
												}
												echo $row['pesan'];
												echo '</div>';
												echo '</div>';
												echo '<div class="'.$waktu.'">'.longDateTs($row['tgl']).'</div>';
												echo '</div>';
											}while($row = $sql->fetch());
										?>
									</div>

									<div class="panel-footer bg-white">
										<form method="POST" action="inbox">
											<div class="form-group">
									            <div class="input-group col-xs-12">
													<textarea name="kirimpesan" class="form-control" style="width:100%; resize: none;" rows="2" required></textarea>
									                <span class="input-group-addon danger" style="display: none;"></span>
									            </div>
									        </div>
									        <button type="submit" class="btn btn-success pull-right" disabled>Kirim</button>
										    <input type="hidden" name="fkirim" value="y" />
										    <input type="hidden" name="kd_inbox" value="<?php echo $kd_inbox ?>" />
										    <input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>" />
										</form>
									</div>
									</div>
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
		<script>
			$('#pesan').slimScroll({
			    height: '350px',
			    size: '3px',
			    BorderRadius: '3px',
			    start: 'bottom'
			});
		</script>
        <!-- tabel -->
        <script src="../assets/js/datatables/jquery.dataTables.js"></script>
	    <script src="../assets/js/datatables/dataTables.bootstrap.min.js"></script>

        <!-- konfirmasi -->
        <script src="../assets/js/sweetalert.js"></script>
        <script src="../assets/js/validasi.js"></script>
	    <script src="../assets/js/validasiinput.js"></script>
    </body>
</html>
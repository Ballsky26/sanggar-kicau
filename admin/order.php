<?php
include '../koneksi.php';
include '../config.php';
include '../assets/lib/function.php';
$page = "order";

if ((isset($_POST["fhapus"])) && ($_POST["fhapus"] == "y")) {

    $kd_faktur  = $_POST['kd_faktur'];
    $con->exec("DELETE FROM faktur WHERE kd_faktur = '$kd_faktur'");
    $con->exec("DELETE FROM order_produk WHERE kd_faktur = '$kd_faktur'");
    $con->exec("DELETE FROM pengiriman WHERE kd_faktur = '$kd_faktur'");

    // pesan berhasil
    tampilPesan("Berhasil Dihapus!","Data yang dipilih berhasil dihapus!","success","$page");
}


$sql = $con->query("SELECT a.*, b.* FROM faktur as a, pelanggan as b WHERE b.email_plg=a.userid AND a.konfirm!='Belum' ORDER BY a.tgl DESC");
$row = $sql->fetch(PDO::FETCH_LAZY);
$trow = $sql->rowCount();

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
	    <link rel="stylesheet" href="../assets/css/datepicker/jquery-ui.css">
	    <style>
		    .ui-datepicker{ z-index:1151 !important; }
		</style>
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
				                    Data Order
				                </header>
				                <div class="panel-body table-responsive">
				                	<!-- Tombol tambah -->
				                	<a data-toggle="modal" href='#modal-id' class="btn btn-success btn-sm"><span class="fa fa-print"></span> Cetak Laporan Penjualan</a>
				                	&nbsp;
				                	<!-- Tombol tambah -->
				                	<a data-toggle="modal" href='#modal-idlaba' class="btn btn-success btn-sm"><span class="fa fa-print"></span> Cetak Laporan Laba/Rugi</a>
				                	<br><br>

				                	<!-- Tabel -->
				                    <table id="tabel" class="table table-bordered table-striped" cellspacing="0" width="100%" style="font-size: 12px">
				                        <thead>
				                            <tr>
				                                <th>KD. Faktur</th>
				                                <th>Pelanggan</th>
				                                <th>Total Biaya</th>
				                                <th>Kurir</th>
				                                <th>Tgl. Order</th>
				                                <th>Konfirm</th>
				                                <th>proses</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                        <?php do{

				                        	$kd_faktur=$row['kd_faktur'];

				                        	if ($row['tgl_kirim'] == NULL) {
				                        		$tebal = "font-weight: bold";
				                        	} else {
				                        		$tebal = "font-weight: normal";
				                        	}
				                        	
				                        ?>
				                            <tr style="<?php echo $tebal; ?>">
				                                <td width="10%"><?php echo $row['kd_faktur']; ?></td>
				                                <td width="15%"><?php echo $row['nama_plg']; ?></td>
				                                <td width="15%"><?php echo uang($row['total_biaya_barang']); ?></td>
				                                <td width="10%"><?php echo tampilKurir($row['kurir']); ?></td>
				                                <td width="15%"><?php echo longDateTs($row['tgl']); ?></td>
				                                <td width="10%"><?php echo $row['konfirm']; ?></td>
				                                <td width="10%">
					                                <form method="POST">
														<?php if(!empty($trow)): ?>
															<a href="detail_order?kd_faktur=<?php echo $kd_faktur; ?>&&pelanggan=<?php echo $row['userid'] ?>" class="btn btn-info btn-xs">Detail</a>
															<?php if ($row['konfirm'] != 'Sudah'): ?>
	                                                    		<button type="submit" class='submit btn btn-danger btn-xs'>Hapus</button> 
															<?php endif ?>
														<?php endif; ?>
						                                <input type="hidden" name="fhapus" value="y" />
						                                <input type="hidden" name="kd_faktur" value="<?php echo $row['kd_faktur']; ?>" />
					                                </form>
				                                </td>
				                            </tr>
				                        <?php } while ($row = $sql->fetch(PDO::FETCH_LAZY)); ?>
				                        </tbody>
				                    </table>
				                </div>
				            </div>
						</div>
				  	</div> <!-- /.row -->
				</section><!-- /.content -->

            </aside><!-- /.right-side -->
		</div><!-- ./wrapper -->

		<div class="modal fade" id="modal-id">
			<div class="modal-dialog">
				<form method="GET" action="print_faktur" target="_blank">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Pilih Range Tanggal Penjualan</h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Awal</label>
                                        <div class="input-group col-xs-12">
                                            <input id="tgl1" type="text" class="form-control" name="awal" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Akhir</label>
                                        <div class="input-group col-xs-12">
                                            <input id="tgl2" type="text" class="form-control" name="akhir" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
							<button type="submit" class="btn btn-primary">Print</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="modal fade" id="modal-idlaba">
			<div class="modal-dialog">
				<form method="GET" action="print_laba" target="_blank">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Pilih Range Tanggal Penjualan Laba/Rugi</h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Awal</label>
                                        <div class="input-group col-xs-12">
                                            <input id="tgl3" type="text" class="form-control" name="awal" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Akhir</label>
                                        <div class="input-group col-xs-12">
                                            <input id="tgl4" type="text" class="form-control" name="akhir" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
							<button type="submit" class="btn btn-primary">Print</button>
						</div>
					</div>
				</form>
			</div>
		</div>

        <!-- JavaScript
        ================================================== -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/app.js"></script>

        <!-- tabel -->
        <script src="../assets/js/datatables/jquery.dataTables.js"></script>
	    <script src="../assets/js/datatables/dataTables.bootstrap.min.js"></script>
	    <script>
	        $(document).ready(function() {
	            $('#tabel').dataTable({
	                "columnDefs": [{
	                    "targets": [6],
	                    "searchable": false,
	                    "orderable": false,
	                    }],
	                "order": false
	            });
	        });
	    </script>

        <!-- konfirmasi -->
        <script src="../assets/js/sweetalert.js"></script>
		<script>
			$('.submit').on('click',function(e){
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
			    }, function(isConfirm){
			        if (isConfirm) form.submit();
			    });
			})
		</script>

		<script src="../assets/js/datepicker/jquery-ui.js"></script>
	    <script type="text/javascript">
	        $('#tgl1').datepicker({
	            dateFormat: "dd-mm-yy",
	            yearRange: '2000:<?php echo date('Y'); ?>',
	            changeMonth: true,
	            changeYear: true,
	            showAnim: "drop",
	        });
	        $('#tgl2').datepicker({
	            dateFormat: "dd-mm-yy",
	            yearRange: '2000:<?php echo date('Y'); ?>',
	            changeMonth: true,
	            changeYear: true,
	            showAnim: "drop",
	        });
	        $('#tgl3').datepicker({
	            dateFormat: "dd-mm-yy",
	            yearRange: '2000:<?php echo date('Y'); ?>',
	            changeMonth: true,
	            changeYear: true,
	            showAnim: "drop",
	        });
	        $('#tgl4').datepicker({
	            dateFormat: "dd-mm-yy",
	            yearRange: '2000:<?php echo date('Y'); ?>',
	            changeMonth: true,
	            changeYear: true,
	            showAnim: "drop",
	        });
	    </script>

    </body>
</html>
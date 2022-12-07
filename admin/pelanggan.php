<?php
include '../koneksi.php';
include '../config.php';
include '../assets/lib/function.php';
include '../assets/lib/rajaongkir.php';
$page = "pelanggan";

if ((isset($_POST["fhapus"])) && ($_POST["fhapus"] == "y")) {

    $email_plg  = $_POST['email_plg'];

    $con->exec("DELETE FROM pelanggan WHERE email_plg = '$email_plg'");
    $con->exec("DELETE FROM user WHERE userid = '$email_plg'");
    $con->exec("DELETE FROM inbox WHERE pengirim = '$email_plg'");
    $con->exec("DELETE FROM inbox_detail WHERE userid = '$email_plg'");
    $con->exec("DELETE FROM faktur WHERE userid = '$email_plg'");

    // pesan berhasil
    tampilPesan("Berhasil Dihapus!","Data yang dipilih berhasil dihapus!","success","pelanggan");
}


$sql = $con->query("SELECT * FROM pelanggan");
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
				                    Pelanggan
				                </header>
				                <div class="panel-body table-responsive">
				                	<!-- Tombol tambah -->
				                	<a href="print_pelanggan" target="_blank" class="btn btn-success btn-sm"><span class="fa fa-print"></span> Cetak</a>
				                	<br><br>

				                	<!-- Tabel -->
				                    <table id="tabel" class="table table-bordered table-striped" cellspacing="0" width="100%" style="font-size: 12px">
				                        <thead>
				                            <tr>
				                                <th>pelanggan</th>
				                                <th>alamat</th>
				                                <th>kota</th>
				                                <th>Provinsi</th>
				                                <th>k. pos</th>
				                                <th>telepon</th>
				                                <th>proses</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                        <?php do{ $email_plg=$row['email_plg']; ?>
				                            <tr>
				                                <td width="15%"><?php echo $row['nama_plg']; ?></td>
				                                <td width="auto"><?php echo $row['alamat_plg']; ?></td>
				                                <td width="10%"><?php echo tampilKota($row['kd_provinsi'],$row['kd_kota']); ?></td>
				                                <td width="10%"><?php echo tampilProvinsi($row['kd_provinsi']); ?></td>
				                                <td width="7%"><?php echo $row['kodepos_plg']; ?></td>
				                                <td width="10%"><?php echo $row['tlp_plg']; ?></td>
				                                <td width="10%" align="center">
					                                <form method="POST">
														<?php if(!empty($trow)): ?>
                                                    		<button type="submit" class='submit btn btn-danger btn-xs'>Hapus</button> 
														<?php endif; ?>
						                                <input type="hidden" name="fhapus" value="y" />
						                                <input type="hidden" name="email_plg" value="<?php echo $row['email_plg']; ?>" />
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
	                    "targets": [5],
	                    "searchable": false,
	                    "orderable": false,
	                    }]
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
    </body>
</html>
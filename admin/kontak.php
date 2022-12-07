<?php
include '../koneksi.php';
include '../config.php';
include '../assets/lib/function.php';
$page = "kontak";

if ((isset($_POST["fhapus"])) && ($_POST["fhapus"] == "y")) {

    $kd_kontak  = $_POST['kd_kontak'];
    $con->exec("DELETE FROM kontak WHERE kd_kontak = '$kd_kontak'");

    // pesan berhasil
    tampilPesan("Berhasil Dihapus!","Data yang dipilih berhasil dihapus!","success","kontak");
}


$sql = $con->query("SELECT * FROM kontak");
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
				                    Kontak
				                </header>
				                <div class="panel-body table-responsive">
				                	<!-- Tombol tambah -->
				                	<a href="kontak_tambah" class="btn btn-primary btn-sm"><span class="fa fa-plus"></span> Tambah</a>
				                	<br><br>

				                	<!-- Tabel -->
				                    <table id="tabel" class="table table-bordered table-striped" cellspacing="0" width="100%">
				                        <thead>
				                            <tr>
				                                <th>Kontak</th>
				                                <th>Isi Kontak</th>
				                                <th>proses</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                        <?php do{ $kd_kontak=$row['kd_kontak']; ?>
				                            <tr>
				                                <td width="auto"><?php echo $row['kontak']; ?></td>
				                                <td width="auto"><?php echo $row['isi_kontak']; ?></td>
				                                <td width="10%">
					                                <form method="POST">
														<?php if(!empty($trow)): ?>
															<a href="kontak_edit?kd_kontak=<?php echo $kd_kontak; ?>" class="btn btn-info btn-xs">Edit</a>
                                                    		<button type="submit" class='submit btn btn-danger btn-xs'>Hapus</button> 
														<?php endif; ?>
						                                <input type="hidden" name="fhapus" value="y" />
						                                <input type="hidden" name="kd_kontak" value="<?php echo $row['kd_kontak']; ?>" />
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
	                    "targets": [2],
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
<?php
include '../koneksi.php';
include '../config.php';
include '../assets/lib/function.php';
$page = "kategori";
$tbbatal = "Batal";

if ((isset($_POST["ftambah"])) && ($_POST["ftambah"] == "y")) {

	$kd_kategori   = $_POST['kd_kategori'];
	$nama_kategori = $_POST['nama_kategori'];

    // query untuk mencari nama kategori yang sama
    $sql_cek = $con->query("SELECT * FROM kategori WHERE nama_kategori='$nama_kategori' ");
    $row_cek = $sql_cek->fetch(PDO::FETCH_LAZY);
    $trow_cek = $sql_cek->rowCount();

    if (empty($trow_cek)) { // bila data tidak ada
    	// proses simpan
	    $con->exec("UPDATE kategori SET nama_kategori='$nama_kategori' WHERE kd_kategori='$kd_kategori' ");
	    // pesan berhasil
	    tampilPesan("Berhasil Disimpan!","Data yang anda inputkan berhasil disimpan!","success","kategori");

    } else { // bila data ada
	    // pesan gagal
	    tampilPesan("Gagal Disimpan!","Data yang anda inputkan sudah ada!","warning");
	    $tbbatal = "Ulangi";
    } //end if
}

$kd_kategori = $_GET['kd_kategori'];
$sql = $con->query("SELECT * FROM kategori WHERE kd_kategori='$kd_kategori' ");
$row = $sql->fetch(PDO::FETCH_LAZY);

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
				                    Edit Kategori
				                </header>
				                <div class="panel-body table-responsive">
				                	<div class="row">
			                            <div class="col-md-7 col-sm-9 col-xs-12">
			                                <form method="POST" enctype="multipart/form-data">
			                                    <div class="form-group">
			                                        <label>Nama Kategori</label>
			                                        <div class="input-group col-xs-9">
			                                            <input type="text" class="form-control" name="nama_kategori" required autocomplete="off" value="<?php echo $row['nama_kategori']; ?>">
			                                            <span class="input-group-addon danger" style="display: none;"></span>
			                                        </div>
			                                    </div>
			                                    <button type="submit" class="btn btn-success" disabled>Simpan</button>
			                                    <button type="button" class="btn btn-danger" onclick="self.history.back()"><?php echo $tbbatal; ?></button>
			                                    <input type="hidden" name="kd_kategori" value="<?php echo $kd_kategori; ?>" />
			                                    <input type="hidden" name="ftambah" value="y" />
			                                </form>
			                            </div>
			                        </div><!-- /.row -->
				                </div> <!-- /.panel body -->
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
    </body>
</html>
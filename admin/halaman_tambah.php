<?php
include '../koneksi.php';
include '../config.php';
include '../assets/lib/function.php';
$page = "halaman";
$tbbatal = "Batal";

if ((isset($_POST["ftambah"])) && ($_POST["ftambah"] == "y")) {

	$nama_halaman = $_POST['nama_halaman'];
	$isi_halaman  = $_POST['isi_halaman'];
	$admin        = $_POST['admin'];

    // query untuk mencari nama halaman yang sama
    $sql_cek = $con->query("SELECT * FROM halaman WHERE nama_halaman='$nama_halaman' ");
    $row_cek = $sql_cek->fetch(PDO::FETCH_LAZY);
    $trow_cek = $sql_cek->rowCount();

    if (empty($trow_cek)) { // bila data tidak ada
    	// proses simpan
	    $con->exec("INSERT INTO halaman (nama_halaman, isi_halaman, admin) 
	    			VALUES (
	    			'".$nama_halaman."',
	    			'".$isi_halaman."',
	    			'".$admin."'
	    			)");
	    // pesan berhasil
	    tampilPesan("Berhasil Disimpan!","Data yang anda inputkan berhasil disimpan!","success","halaman");

    } else { // bila data ada
	    // pesan gagal
	    tampilPesan("Gagal Disimpan!","Data yang anda inputkan sudah ada!","warning");
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
				                    Tambah Halaman
				                </header>
				                <div class="panel-body table-responsive">
				                	<div class="row">
			                            <div class="col-xs-12">
			                                <form method="POST" enctype="multipart/form-data">
			                                    <div class="form-group">
			                                        <label>Nama Halaman</label>
			                                        <div class="input-group col-xs-4">
			                                            <input type="text" class="form-control" name="nama_halaman" required autocomplete="off" >
			                                            <span class="input-group-addon danger" style="display: none;"></span>
			                                        </div>
			                                    </div>
			                                    <div class="form-group">
			                                        <label>Isi Halaman</label>
			                                        <div class="input-group col-xs-12">
			                                        <textarea name="isi_halaman" class="ckeditor" id="editor1"></textarea>
			                                        </div>
			                                    </div>
			                                    <button type="submit" class="btn btn-success" disabled>Simpan</button>
			                                    <button type="button" class="btn btn-danger" onclick="self.history.back()"><?php echo $tbbatal; ?></button>
			                                    <input type="hidden" name="ftambah" value="y" />
			                                    <input type="hidden" name="admin" value="<?php echo $_SESSION['userid']; ?>" />
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
	    <script src="../assets/js/matauang.js"></script>

	    <script src="../assets/js/ckeditor/ckeditor.js"></script>
        <script language="javascript" type="text/javascript">
            CKEDITOR.replace( 'editor1',
            {
            	toolbar : 'Basic',
                height: '600px',
                // filebrowserWindowWidth : '900',
                // filebrowserWindowHeight : '400',
                filebrowserBrowseUrl : '/gsb/assets/js/ckfinder/ckfinder.html',
                filebrowserImageBrowseUrl : '/gsb/assets/js/ckfinder/ckfinder.html?type=Images',
                filebrowserFlashBrowseUrl : '/gsb/assets/js/ckfinder/ckfinder.html?type=Flash',
                filebrowserUploadUrl : '/gsb/assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserImageUploadUrl : '/gsb/assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                filebrowserFlashUploadUrl : '/gsb/assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
            });
        </script>
    </body>
</html>
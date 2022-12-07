<?php
include '../koneksi.php';
include '../config.php';
include '../assets/lib/function.php';
$page = "";
$tbbatal = "Batal";

// Proses update akun
if ((isset($_POST["fedit"])) && ($_POST["fedit"] == "y")) {

	$userid   = $_POST['userid'];
	$nama_admin   = $_POST['nama_admin'];
	$tlp_admin   = $_POST['tlp_admin'];
	$alamat_admin   = $_POST['alamat_admin'];

    $con->exec("UPDATE admin SET nama_admin='$nama_admin', alamat_admin='$alamat_admin', tlp_admin='$tlp_admin' WHERE email='$userid' ");
    // pesan berhasil
    tampilPesan("Berhasil Diperbarui!","Data yang anda inputkan berhasil diperbarui!","success","setting_akun?userid=$userid");
}

// Proses update password
if ((isset($_POST["fpassword"])) && ($_POST["fpassword"] == "y")) {

	$userid   = $_POST['userid'];
	$password   = $_POST['password'];

    $con->exec("UPDATE user SET password='$password' WHERE userid='$userid' ");
    // pesan berhasil
    tampilPesan("Berhasil Diperbarui!","Data yang anda inputkan berhasil diperbarui!","success","setting_akun?userid=$userid");
}

$userid = $_SESSION['userid'];
$sql = $con->query("SELECT a.*, b.* FROM user as a, admin as b WHERE a.userid='$userid' ");
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
				        <div class="col-lg-6">
							<div class="panel">
				                <header class="panel-heading">
				                    Setting Akun
				                </header>
				                <div class="panel-body table-responsive">
				                	<div class="row">
			                            <div class="col-xs-12">
			                                <form method="POST" enctype="multipart/form-data">
			                                    <div class="form-group">
			                                        <label>Nama Admin</label>
			                                        <div class="input-group col-xs-9">
			                                            <input type="text" class="form-control" name="nama_admin" required autocomplete="off" value="<?php echo $row['nama_admin']; ?>">
			                                            <span class="input-group-addon danger" style="display: none;"></span>
			                                        </div>
			                                    </div>
			                                    <div class="form-group">
			                                        <label>Telepon</label>
			                                        <div class="input-group col-xs-9">
			                                            <input type="text" class="form-control" name="tlp_admin" required autocomplete="off" value="<?php echo $row['tlp_admin']; ?>" onKeyPress="return goodchars(event,'0123456789.',this)" maxlength="13">
			                                            <span class="input-group-addon danger" style="display: none;"></span>
			                                        </div>
			                                    </div>
			                                    <div class="form-group">
			                                        <label>Alamat</label>
			                                        <div class="input-group col-xs-9">
			                                            <textarea name="alamat_admin" class="form-control" style="resize: none;" rows="3" required><?php echo $row['alamat_admin']; ?></textarea>
			                                            <span class="input-group-addon danger" style="display: none;"></span>
			                                        </div>
			                                    </div>
			                                    <button type="submit" class="btn btn-success" disabled>Perbarui</button>
			                                    <button type="button" class="btn btn-danger" onclick="self.history.back()"><?php echo $tbbatal; ?></button>
			                                    <input type="hidden" name="userid" value="<?php echo $userid; ?>">
			                                    <input type="hidden" name="fedit" value="y" />
			                                </form>
			                            </div>
			                        </div><!-- /.row -->
				                </div> <!-- /.panel body -->
				            </div> <!-- /.panel -->
						</div>
						
						<!-- Ganti Password
						================================================= -->
						<div class="col-lg-6">
							<div class="panel">
				                <header class="panel-heading">
				                    Ganti Password
				                </header>
				                <div class="panel-body table-responsive">
				                	<div class="row">
			                            <div class="col-xs-12">
			                                <form method="POST" enctype="multipart/form-data">
			                                    <div class="form-group">
			                                        <label for="password">Password Lama</label>
			                                        <div class="input-group col-xs-9" data-validate="password_lama">
			                                            <input type="password" class="form-control" maxlength="20" required>
			                                            <span class="input-group-addon danger" style="display: none;"></span>
			                                        </div>
			                                    </div>
			                                    <div class="form-group">
			                                        <label for="password">Password Baru</label>
			                                        <div class="input-group col-xs-9">
			                                            <input type="password" class="form-control" maxlength="20" name="password" id="password" required>
			                                            <span class="input-group-addon danger" style="display: none;"></span>
			                                        </div>
			                                    </div>
			                                    <div class="form-group">
			                                        <label for="password">Konfirmasi Password</label>
			                                        <div class="input-group col-xs-9" data-validate="kpassword">
			                                            <input type="password" class="form-control" maxlength="20" required>
			                                            <span class="input-group-addon danger" style="display: none;"></span>
			                                        </div>
			                                    </div>
			                                    <button type="submit" class="btn btn-success" disabled>Perbarui</button>
			                                    <button type="button" class="btn btn-danger" onclick="self.history.back()"><?php echo $tbbatal; ?></button>
			                                    <input type="hidden" id="password_lama" value="<?php echo $row['password']; ?>">
			                                    <input type="hidden" name="userid" value="<?php echo $userid; ?>">
			                                    <input type="hidden" name="fpassword" value="y" />
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
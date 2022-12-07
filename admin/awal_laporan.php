<?php
include '../koneksi.php';
include '../config.php';
include '../assets/lib/function.php';
include 'akses.php';
$page = "laporan";
$tbbatal = "Batal";


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
	    <link rel="stylesheet" href="../assets/css/datepicker/jquery-ui.css">
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
      <div class="panel"> <header class="panel-heading"> Laporan Penjualan </header> 
        <div class="panel-body table-responsive"> 
          <div class="row"> 
            <div class="col-xs-6"> 
              <form method="POST" enctype="multipart/form-data" action="print_penjualan" target="_blank">
                <div class="form-group"> 
                  <label>Tanggal Awal</label>
                  <div class="input-group col-xs-9"> 
                    <input id="awal" type="text" class="form-control" name="tgl_awal" required autocomplete="off">
                    <span class="input-group-addon danger" style="display: none;"></span> 
                  </div>
                </div>
                <div class="form-group"> 
                  <label>Tanggal Akhir</label>
                  <div class="input-group col-xs-9"> 
                    <input id="akhir" type="text" class="form-control" name="tgl_akhir" required autocomplete="off">
                    <span class="input-group-addon danger" style="display: none;"></span> 
                  </div>
                </div>
                <button type="submit" class="btn btn-success" disabled>Lihat</button>
                <button type="button" class="btn btn-danger" onclick="self.history.back()"><?php echo $tbbatal; ?></button>
                <input type="hidden" name="ftambah" value="y" />
              </form>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.panel body -->
      </div>
      <!-- /.panel -->
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
	    <script src="../assets/js/datepicker/jquery-ui.js"></script>
	    <script type="text/javascript">
	        $('#awal').datepicker({
	            dateFormat: "dd-mm-yy",
	            yearRange: '2010:2050',
	            changeMonth: true,
	            changeYear: true,
	            showAnim: "drop"
	        });
	    </script>
	    <script type="text/javascript">
	        $('#akhir').datepicker({
	            dateFormat: "dd-mm-yy",
	            yearRange: '2010:2050',
	            changeMonth: true,
	            changeYear: true,
	            showAnim: "drop"
	        });
	    </script>

	    <script type="text/javascript">
	        $('#awal2').datepicker({
	            dateFormat: "dd-mm-yy",
	            yearRange: '2010:2050',
	            changeMonth: true,
	            changeYear: true,
	            showAnim: "drop"
	        });
	    </script>
	    <script type="text/javascript">
	        $('#akhir2').datepicker({
	            dateFormat: "dd-mm-yy",
	            yearRange: '2010:2050',
	            changeMonth: true,
	            changeYear: true,
	            showAnim: "drop"
	        });
	    </script>
    </body>
</html>
<?php
include '../koneksi.php';
include '../config.php';
include '../assets/lib/function.php';
include '../hapus_otomatis.php';
$page = "index";

include 'total.php';
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
        <link rel="stylesheet" href="../assets/css/ionicons.min.css">
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
				    <div class="row" style="margin-bottom:5px;">
				        <div class="col-md-3">
				            <div class="sm-st clearfix">
				                <span class="sm-st-icon st-red"><i class="fa fa-users"></i></span>
				                <div class="sm-st-info">
				                    <span><?php echo $trow_tplg ?></span>
				                    Total Pelanggan
				                </div>
				            </div>
				        </div>
				        <div class="col-md-3">
				            <div class="sm-st clearfix">
				                <span class="sm-st-icon st-blue"><i class="fa fa-archive"></i></span>
				                <div class="sm-st-info">
				                    <span><?php echo $trow_tbarang ?></span>
				                    Total Produk
				                </div>
				            </div>
				        </div>
				        <div class="col-md-3">
				            <div class="sm-st clearfix">
				                <span class="sm-st-icon st-green"><i class="fa fa-shopping-basket"></i></span>
				                <div class="sm-st-info">
				                    <span><?php echo $trow_torder ?></span>
				                    Total Transaksi
				                </div>
				            </div>
				        </div>
				        <div class="col-md-3">
				            <div class="sm-st clearfix">
				                <span class="sm-st-icon st-violet"><i class="fa fa-envelope-o"></i></span>
				                <div class="sm-st-info">
				                    <span><?php echo $trow_tinbox ?></span>
				                    Total Inbox
				                </div>
				            </div>
				        </div>
				    </div>

				    <!-- Main row -->
				    <?php
				    	$sql = $con->query("SELECT a.*, b.* FROM faktur as a, pelanggan as b WHERE b.email_plg=a.userid AND a.total_biaya_barang!='' ORDER BY a.tgl DESC LIMIT 5");
						$row = $sql->fetch(PDO::FETCH_LAZY);
						$trow = $sql->rowCount();

						// mencari produk yang habis
				    	$sql_cari_produk_habis = $con->query("SELECT * FROM produk WHERE stok=0");
				    	$row_cari_produk_habis = $sql_cari_produk_habis->fetch(PDO::FETCH_LAZY);
				    	$trow_cari_produk_habis = $sql_cari_produk_habis->rowCount();

				    	if (!empty($trow_cari_produk_habis)) {
				    		$col_transaksi = "col-lg-9";
				    	} else {
				    		$col_transaksi = "col-lg-12";
				    	}
				    	
				    ?>
				    <div class="row">
				        <div class="<?php echo $col_transaksi; ?>">
							<div class="panel">
				                <header class="panel-heading">
				                    5 Transaksi Terakhir
				                </header>
				                <div class="panel-body table-responsive">
								<!-- Tabel -->
			                    <table class="table table-bordered" style="font-size: 12px">
			                        <thead>
			                            <tr>
			                                <th>KD. Faktur</th>
			                                <th>Pelanggan</th>
			                                <th>Total Biaya</th>
			                                <th>Kurir</th>
			                                <th>Tgl. Order</th>
			                            </tr>
			                        </thead>
			                        <tbody>
			                        <?php do{

			                        	$kd_faktur=$row['kd_faktur'];
			                        ?>
			                            <tr>
			                                <td width="10%">
			                                	<a href="detail_order?kd_faktur=<?php echo $kd_faktur; ?>&&pelanggan=<?php echo $row['userid'] ?>">
			                                	<?php echo $row['kd_faktur']; ?>
			                                	</a>
			                                </td>
			                                <td width="15%"><?php echo $row['nama_plg']; ?></td>
			                                <td width="15%"><?php echo uang($row['total_biaya_barang']); ?></td>
			                                <td width="10%"><?php echo tampilKurir($row['kurir']); ?></td>
			                                <td width="15%"><?php echo longDateTs($row['tgl']); ?></td>
			                            </tr>
			                        <?php } while ($row = $sql->fetch(PDO::FETCH_LAZY)); ?>
			                        </tbody>
			                    </table>
				                </div>
				            </div>
						</div>
						
						<!-- Produk habis (akan tampil jika ada produk yang habis)
						========================================= -->
					    <?php if (!empty($trow_cari_produk_habis)): ?>
				        <div class="col-lg-3">
							<div class="panel">
				                <header class="panel-heading">
				                    Produk Habis
				                </header>
				                <div class="panel-body table-responsive">
								<?php do{ ?>
									<a href="produk_edit?kd_produk=<?php echo $row_cari_produk_habis['kd_produk']; ?>">
		                            <?php echo $row_cari_produk_habis['nama_produk']; ?>
		                            </a>
		                            <br>
		                        <?php } while ($row_cari_produk_habis = $sql_cari_produk_habis->fetch(PDO::FETCH_LAZY)); ?>
				                </div>
				            </div>
						</div>
				      <?php endif ?>
				  </div>
				   
				</section><!-- /.content -->

            </aside><!-- /.right-side -->
		</div><!-- ./wrapper -->

        <!-- JavaScript
        ================================================== -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/app.js"></script>
    </body>
</html>
<?php
include '../koneksi.php';
include '../config.php';
include '../assets/lib/function.php';
include '../assets/lib/rajaongkir.php';


$sql = $con->query("SELECT * FROM pelanggan");
$row = $sql->fetch(PDO::FETCH_LAZY);
$trow = $sql->rowCount();
$no = 1;

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
        <link rel="stylesheet" href="../assets/fontawesome/css/font-awesome.min.css">
    </head>
    <body onLoad="window.print()">
    	
    	<div class="container">
			

			<!-- Kop Laporan
			========================================================= -->
    		<header style="text-align: center">
                <h3><?php echo $nama_perusahaan ?></h3>
    			<h3>Laporan Data Pelanggan</h3>
    			<hr style="border: 1px solid #000000">
    		</header>


    		<!-- Tabel
			========================================================= -->
            <table id="tabel" class="table table-bordered" cellspacing="0" width="100%" style="font-size: 12px">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Pelanggan</th>
                        <th>Alamat</th>
                        <th>Kota</th>
                        <th>Provinsi</th>
                        <th>KD Pos</th>
                        <th>Telepon</th>
                    </tr>
                </thead>
                <tbody>
                <?php do{ $email_plg=$row['email_plg']; ?>
                    <tr>
                        <td width="1%"><?php echo $no++; ?></td>
                        <td width="15%"><?php echo $row['nama_plg']; ?></td>
                        <td width="auto"><?php echo $row['alamat_plg']; ?></td>
                        <td width="10%"><?php echo tampilKota($row['kd_provinsi'],$row['kd_kota']); ?></td>
                        <td width="10%"><?php echo tampilProvinsi($row['kd_provinsi']); ?></td>
                        <td width="10%"><?php echo $row['kodepos_plg']; ?></td>
                        <td width="10%"><?php echo $row['tlp_plg']; ?></td>
                    </tr>
                <?php } while ($row = $sql->fetch(PDO::FETCH_LAZY)); ?>
                </tbody>
            </table>
			
			<!-- Tanda Tangan
			========================================================= -->
            <div class="row" style="margin-top: 50px">
            	<div class="col-xs-4 pull-right" style="text-align: center">
            		<p>Mengetahui, <?php echo longDate(date("Y-m-d")); ?></p>
					<p>Manager <?php echo $nama_perusahaan ?></p>
            	</div>
            </div>
            <div class="row" style="margin-top: 70px">
            	<div class="col-xs-4 pull-right" style="text-align: center">
            		Panji Agus  Pranama
            	</div>
            </div>
    	</div>

        <!-- JavaScript
        ================================================== -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
    </body>
</html>
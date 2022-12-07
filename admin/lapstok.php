<?php
include '../koneksi.php';
include '../config.php';
include '../assets/lib/function.php';

$awal = TglSql($_GET['awal']);
$akhir = TglSql($_GET['akhir']);

$sql = $con->query("SELECT a.*, b.* FROM produk as a, kategori as b WHERE b.kd_kategori=a.kd_kategori");
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
                <h3>Laporan Stok Produk</h3>
                <hr style="border: 1px solid #000000">
    		</header>


    		<!-- Tabel
			========================================================= -->
            <table id="tabel" class="table table-bordered" cellspacing="0" width="100%" style="font-size: 12px">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Foto</th>
                        <th>Kategori</th>
                        <th>Nama Produk</th>
                        <th>Ukuran</th>
                        <th>Berat</th>
                        <th>Stok</th>
                        <th>Terjual</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                <?php do{ 
                    $kd_produk=$row['kd_produk']; 
                    $sql_terjual = $con->query("SELECT a.*, b.*, SUM(b.jml_beli) as jml_terjual FROM faktur as a, penjualan as b WHERE b.kd_produk='$kd_produk' AND b.kd_faktur=a.kd_faktur ");
                    // $sql_terjual = $con->query("SELECT * FROM penjualan WHERE kd_produk='$kd_produk'");
                    $row_terjual = $sql_terjual->fetch(PDO::FETCH_LAZY);
                    $trow_terjual = $sql_terjual->rowCount();
                ?>
                    <tr data-id="<?php echo $kd_produk; ?>">
                        <td width="1%"><?php echo $no++; ?></td>
                        <td width="10%">
                            <img src="../assets/images/produk/<?php echo $row['foto']; ?>" class="img-thumbnail" width="100" height="100">
                        </td>
                        <td width="auto" align="center"><?php echo $row['nama_kategori']; ?></td>
                        <td width="auto"><?php echo $row['nama_produk']; ?></td>
                        <td width="auto" align="center"><?php echo $row['ukuran']; ?></td>
                        <td width="auto" align="center"><?php echo berat($row['berat']); ?></td>
                        <td width="auto" align="center"><?php echo $row['stok']; ?></td>
                        <td width="auto" align="center"><?php echo $row_terjual['jml_terjual']; ?></td>
                        <td width="auto" align="right"><?php echo uang($row['harga']); ?></td>
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
            		Sumarhati
            	</div>
            </div>
    	</div>

        <!-- JavaScript
        ================================================== -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
    </body>
</html>
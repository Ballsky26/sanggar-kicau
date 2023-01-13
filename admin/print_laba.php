<?php
include '../koneksi.php';
include '../config.php';
include '../assets/lib/function.php';
$page = "order";

$awal = TglSql($_GET['awal']);
$akhir = TglSql($_GET['akhir']);

$awal1 = date('Y-m-d', strtotime('-1 days', strtotime($awal)));
$akhir1 = date('Y-m-d', strtotime('+1 days', strtotime($akhir)));

$sql = $con->query("SELECT a.*, b.* FROM faktur as a, penjualan as b WHERE b.kd_faktur=a.kd_faktur AND a.tgl BETWEEN '$awal1' AND '$akhir1' GROUP BY b.kd_produk ");
$row = $sql->fetch(PDO::FETCH_LAZY);
$trow = $sql->rowCount();

$tstok = 0;
$jbeli = 0;
$tjbeli = 0;
$tharga = 0;
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
    			<h3>Laporan Laba/rugi Periode <?php echo longDate($awal)." - ".longDate($akhir); ?></h3>
    			<hr style="border: 1px solid #000000">
    		</header>


    		<!-- Tabel
			========================================================= -->
    		<table id="tabel" class="table table-bordered" cellspacing="0" width="100%" style="font-size: 12px">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Foto</th>
                        <th>Produk</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Terjual</th>
                        <th>Total Harga Pembelian</th>
                        <th>Total Harga Penjualan</th>
                        <th>Jumlah Laba/Rugi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($trow)): ?>
                <?php do{ 
                    $kd_faktur=$row['kd_faktur'];
                    $kd_produk=$row['kd_produk'];

                    $sql_barang = $con->query("SELECT a.*, b.*, d.* FROM penjualan as a, produk as b, kategori as d WHERE a.kd_faktur='$kd_faktur' AND b.kd_produk=a.kd_produk AND b.kd_produk='$kd_produk' AND d.kd_kategori=b.kd_kategori ");
                    $row_barang = $sql_barang->fetch(PDO::FETCH_LAZY);
                    $trow_barang = $sql_barang->rowCount();

                ?>
                    <tr>
                        <td width="1%"><?php echo $no++; ?></td>
                        <!-- 
                        ========================================================= Gambar Produk -->
                        <td width="8%">
                            <img src="../assets/images/produk/<?php echo $row_barang['foto']; ?>" class="img-thumbnail" width="100" height="100">
                        </td>

                        <!-- 
                        ========================================================= Nama dan Warna Produk -->
                        <td width="auto">
                            <b>Kategori:</b> <?php echo $row_barang['nama_kategori']; ?>
                            <br>
                            <b>Produk:</b> <?php echo $row_barang['nama_produk']; ?>
                            
                        </td>

                        <!-- 
                        ========================================================= Harga Produk -->
                        <td width="auto" align="right"><?php echo uang($row_barang['hargabeli']); ?></td>
                        <td width="auto" align="right"><?php echo uang($row_barang['harga']); ?></td>

                        <!-- 
                        ========================================================= Stok Produk -->
                        <td width="auto" align="center"><?php echo $row_barang['stok']; ?></td>

                        <!-- 
                        ========================================================= Jumlah Beli Produk -->
                        <td width="auto" align="center">
                            <?php
                                $sql_terjual = $con->query("SELECT a.*, b.* FROM faktur as a, penjualan as b  WHERE b.kd_faktur=a.kd_faktur AND b.kd_produk='$kd_produk' ");
                                $row_terjual = $sql_terjual->fetch(PDO::FETCH_LAZY);
                                $trow_terjual = $sql_terjual->rowCount();
                            ?>
                            <?php do{ ?>
                            <?php echo $row_terjual['jml_beli'] ?>
                            <br>
                            <br>
                            <br>
                            <?php 
                                $beli = $row_terjual['jml_beli'];
                                $jbeli = $jbeli + $beli;
                                }while($row_terjual = $sql_terjual->fetch()); ?>
                        </td>

                        <!-- 
                    ======== Total Harga Pembelian -->
                        <td width="auto" align="right">
                        <?php
                            $sql_total_harga = $con->query("SELECT a.*, b.*, c.* FROM faktur as a, penjualan as b, produk as c  WHERE  b.kd_faktur=a.kd_faktur AND b.kd_produk='$kd_produk' AND c.kd_produk=b.kd_produk ");
                            $row_total_harga = $sql_total_harga->fetch(PDO::FETCH_LAZY);
                            $trow_total_harga = $sql_total_harga->rowCount();
                        ?>
                            <?php do{ ?>
                            <?php echo uang($row_total_harga['jml_beli'] * $row_total_harga['hargabeli']); ?>
                            <br>
                            <br>
                            <br>
                            <?php 
                            $ttalbeli   = $row_total_harga['jml_beli'] * $row_total_harga['hargabeli'];
                            $thargabeli = $ttalbeli + $thargabeli;
                            }while($row_total_harga = $sql_total_harga->fetch()); ?>
                        </td>
                        <!-- ======== Total Harga Penjualan -->
                        <td width="auto" align="right">
                        <?php
                            $sql_total_harga = $con->query("SELECT a.*, b.*, c.* FROM faktur as a, penjualan as b, produk as c  WHERE  b.kd_faktur=a.kd_faktur AND b.kd_produk='$kd_produk' AND c.kd_produk=b.kd_produk ");
                            $row_total_harga = $sql_total_harga->fetch(PDO::FETCH_LAZY);
                            $trow_total_harga = $sql_total_harga->rowCount();
                        ?>
                            <?php do{ ?>
                            <?php echo uang($row_total_harga['jml_beli'] * $row_total_harga['harga']); ?>
                            <br>
                            <br>
                            <br>
                            <?php 
                            $ttaljual   = $row_total_harga['jml_beli'] * $row_total_harga['harga'];
                            $thargajual = $ttaljual + $thargajual;
                            }while($row_total_harga = $sql_total_harga->fetch()); ?>
                        </td>
                         <!-- ======== Jumlah Laba/rugi -->
                        <td width="auto" align="right" style="font-weight: bold">
                        <?php
                            $sql_total_harga = $con->query("SELECT a.*, b.*, c.* FROM faktur as a, penjualan as b, produk as c  WHERE  b.kd_faktur=a.kd_faktur AND b.kd_produk='$kd_produk' AND c.kd_produk=b.kd_produk ");
                            $row_total_harga = $sql_total_harga->fetch(PDO::FETCH_LAZY);
                            $trow_total_harga = $sql_total_harga->rowCount();
                        ?>
                            <?php do{ ?>
                            <?php echo uang(($row_total_harga['jml_beli'] * $row_total_harga['harga'])-($row_total_harga['jml_beli'] * $row_total_harga['hargabeli'])); ?>
                            <br>
                            <br>
                            <br>
                            <?php 
                            $ttallaba   = ($row_total_harga['jml_beli'] * $row_total_harga['harga'])-($row_total_harga['jml_beli'] * $row_total_harga['hargabeli']);
                            $thargalaba = $ttallaba + $thargalaba;
                            }while($row_total_harga = $sql_total_harga->fetch()); ?>
                        </td>
                    </tr>
                <?php
                $jstok = $row_barang['stok'];
                $tstok = $tstok + $jstok;

                $sjbeli = $jbeli;
                $tjbeli = $sjbeli;

                } while ($row = $sql->fetch(PDO::FETCH_LAZY)); ?>
                    <tr style="font-weight: bold">
                        <td colspan="3">Total</td>
                        <td></td>
                        <td align="center"><?php echo $tstok; ?></td>
                        <td align="center"><?php echo $tjbeli; ?></td>
                        <td align="right"></td>
                        <td align="right"><?php echo uang($thargabeli) ?></td>
                        <td align="right"><?php echo uang($thargajual) ?></td>
                        <td align="right"><?php echo uang($thargalaba) ?></td>
                    </tr>
                    <?php endif ?>
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
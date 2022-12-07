<?php
include '../koneksi.php';
include '../config.php';
include '../assets/lib/function.php';
$page = "order";

$awal = TglSql($_GET['awal']);
$akhir = TglSql($_GET['akhir']);
$awal1 = date('Y-m-d', strtotime('-1 days', strtotime($awal)));
$akhir1 = date('Y-m-d', strtotime('+1 days', strtotime($awal)));

$sql = $con->query("SELECT a.*, b.* FROM faktur as a, order_produk as b WHERE b.kd_faktur=a.kd_faktur AND a.tgl BETWEEN '$awal1' AND '$akhir1' GROUP BY b.kd_produk ");
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
    			<h3>Laporan Penjualan Produk Periode <?php echo longDate($awal)." - ".longDate($akhir); ?></h3>
    			<hr style="border: 1px solid #000000">
  </header> 
  <!-- Tabel
			========================================================= -->
  <table id="tabel" class="table table-bordered" cellspacing="0" width="100%" style="font-size: 12px">
    <thead>
      <tr> 
        <th>No</th>
        <th>Kategori</th>
        <th>Produk</th>
        <th>Kode Faktur</th>
        <th>Pelanggan</th>
        <th>Stok</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Total Harga Pembelian</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($trow)): ?>
      <?php 
	  $no=1;
	  do{ 
                    $kd_faktur=$row['kd_faktur'];
                    $kd_produk=$row['kd_produk'];

                    $sql_barang = $con->query("SELECT a.*, b.*, d.* FROM order_produk as a, produk as b, kategori as d WHERE a.kd_faktur='$kd_faktur' AND b.kd_produk=a.kd_produk AND b.kd_produk='$kd_produk' AND d.kd_kategori=b.kd_kategori ");
                    $row_barang = $sql_barang->fetch(PDO::FETCH_LAZY);
                    $trow_barang = $sql_barang->rowCount();

                ?>
      <tr> 
        <!-- 
                        ========================================================= Gambar Produk -->
        <td width="10%"> <?php echo $no++; ?></td>
        <!-- 
                        ========================================================= Nama dan Warna Produk -->
        <td width="auto"> <?php echo $row_barang['nama_kategori']; ?> </td>
        <td width="200px"><?php echo $row_barang['nama_produk']; ?></td>
        <td width="200px"> 
          <?php
                            $sql_pembeli = $con->query("SELECT a.*, b.* FROM faktur as a, order_produk as b  WHERE b.kd_faktur=a.kd_faktur AND b.kd_produk='$kd_produk'  ");
                            $row_pembeli = $sql_pembeli->fetch(PDO::FETCH_LAZY);
                            $trow_pembeli = $sql_pembeli->rowCount();
                            $kd_pelanggan=$row_pembeli['userid'];
                        ?>
          <?php do{
                                        $fb=$row_pembeli['kd_faktur'];
                                        $sql_pelanggan = $con->query("SELECT a.*, b.* FROM faktur as a, pelanggan as b WHERE b.email_plg=a.userid AND a.kd_faktur='$fb' ");
                                        $row_pelanggan = $sql_pelanggan->fetch(PDO::FETCH_LAZY);
                                        $trow_pelanggan = $sql_pelanggan->rowCount();
                            ?>
          <b>KD faktur:</b> <?php echo $row_pembeli['kd_faktur']; ?><br> 
          <?php }while($row_pembeli = $sql_pembeli->fetch()); ?>
        </td>
        <td width="200px"> 
          <?php
                            $sql_pembeli = $con->query("SELECT a.*, b.* FROM faktur as a, order_produk as b  WHERE b.kd_faktur=a.kd_faktur AND b.kd_produk='$kd_produk'  ");
                            $row_pembeli = $sql_pembeli->fetch(PDO::FETCH_LAZY);
                            $trow_pembeli = $sql_pembeli->rowCount();
                            $kd_pelanggan=$row_pembeli['userid'];
                        ?>
          <?php do{
                                        $fb=$row_pembeli['kd_faktur'];
                                        $sql_pelanggan = $con->query("SELECT a.*, b.* FROM faktur as a, pelanggan as b WHERE b.email_plg=a.userid AND a.kd_faktur='$fb' ");
                                        $row_pelanggan = $sql_pelanggan->fetch(PDO::FETCH_LAZY);
                                        $trow_pelanggan = $sql_pelanggan->rowCount();
                            ?>
          
          <?php echo $row_pelanggan['nama_plg']; ?><br> 
          <?php }while($row_pembeli = $sql_pembeli->fetch()); ?>
        </td>
        <td width="100px"><table>
            <?php 
		$kd_produk = $row['kd_produk'];
		$sqlstok = $con->query("SELECT a.*, b.*, c.* FROM stok as a, warna as b, ukuran as c WHERE a.kd_warna=b.kd_warna and a.kd_ukuran=c.kd_ukuran and a.kd_produk='$kd_produk' order by b.nama_warna ASC");
		$rowstok = $sqlstok->fetch(PDO::FETCH_LAZY);
		$trowstok = $sqlstok->rowCount();
		if($trowstok>0) {
		do{
		echo '<tr>';
		echo '<td width="100">'.$rowstok['nama_warna'].'</td>';
		echo '<td width="50">'.$rowstok['nama_ukuran'].'</td>';
		echo '<td width="50">'.$rowstok['stok_produk'].'</td>';
		
		echo '</tr>';											
		} while ($rowstok = $sqlstok->fetch(PDO::FETCH_LAZY));
		} else { echo "Belum Ada Stok"; }
		?>
          </table></td>
        <!-- 
                        ========================================================= Harga Produk -->
        <td width="100px" align="right"><?php echo uang($row_barang['harga']); $jmlharga= $jmlharga + $row_barang['harga']; ?>
          <p><?php echo uang($row_barang['harga']); $jmlharga= $jmlharga + $row_barang['harga']; ?></p></td>
        <!-- 
                        ========================================================= Stok Produk -->
        <!-- 
                        ========================================================= Jumlah Beli Produk -->
        <td width="auto" align="center"> 
          <?php
                                $sql_terjual = $con->query("SELECT a.*, b.* FROM faktur as a, order_produk as b  WHERE b.kd_faktur=a.kd_faktur AND b.kd_produk='$kd_produk' ");
                                $row_terjual = $sql_terjual->fetch(PDO::FETCH_LAZY);
                                $trow_terjual = $sql_terjual->rowCount();
                            ?>
          <?php 
		  $subbeli = 0;
		  do{ ?>
          <?php echo $row_terjual['jml_beli'] ?> <br> 
          <?php 
                                $beli = $row_terjual['jml_beli'];
								$subbeli = $subbeli +$beli;
                                $jbeli = $jbeli + $beli;
                            }while($row_terjual = $sql_terjual->fetch()); ?>
        </td>
        <!-- 
                        ========================================================= Pembeli -->
        <!-- 
                        ========================================================= Total Harga -->
        <td width="100px" align="right"> 
          <?php
                            $sql_total_harga = $con->query("SELECT a.*, b.*, c.* FROM faktur as a, order_produk as b, produk as c  WHERE  b.kd_faktur=a.kd_faktur AND b.kd_produk='$kd_produk' AND c.kd_produk=b.kd_produk ");
                            $row_total_harga = $sql_total_harga->fetch(PDO::FETCH_LAZY);
                            $trow_total_harga = $sql_total_harga->rowCount();
                        ?>
          <?php 
		  $subharga = 0;
		  do{ ?>
          <?php echo uang($row_total_harga['jml_beli'] * $row_total_harga['harga']); ?> 
          <br> 
          <?php 
                            $ttal   = $row_total_harga['jml_beli'] * $row_total_harga['harga'];
                            $subharga = $ttal + $subharga;
							$tharga = $ttal + $tharga;
							
                            }while($row_total_harga = $sql_total_harga->fetch()); ?>
        </td>
      </tr>
      <?php
                $jstok = $row_barang['stok'];
                $tstok = $tstok + $jstok;

                $sjbeli = $jbeli;
                $tjbeli = $sjbeli; ?>
      <tr style="font-weight: bold"> 
        <td colspan="2">Sub Total</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td></td>
        <td></td>
        <td align="center"><?php echo $subbeli; ?></td>
        <td align="right"><?php echo uang($subharga) ?></td>
      </tr>
      <?php } while ($row = $sql->fetch(PDO::FETCH_LAZY)); ?>
      <tr style="font-weight: bold; font-size: 16px;"> 
        <td colspan="2">TOTAL</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td></td>
        <td></td>
        <td align="center"><?php echo $tjbeli; ?></td>
        <td align="right"><?php echo uang($tharga) ?></td>
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
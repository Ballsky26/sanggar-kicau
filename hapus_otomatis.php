<?php

$waktu=1;
$sql_pembelianLama = $con->query("SELECT * FROM faktur WHERE konfirm='Tunda' AND DATEDIFF(CURDATE(),tgl) >= $waktu");
$row_pembelianLama = $sql_pembelianLama->fetch(PDO::FETCH_LAZY);
$trow_pembelianLama = $sql_pembelianLama->rowCount();

// if (!empty($trow_pembelianLama)) {

// 	do{
// 		$kfakturLama = $row_pembelianLama['kd_faktur'];

// 		$sql_kembaliProduk = $con->query("SELECT * FROM order_produk WHERE kd_faktur='$kfakturLama' ");
// 		$row_kembaliProduk = $sql_kembaliProduk->fetch(PDO::FETCH_LAZY);
// 		$trow_kembaliProduk = $sql_kembaliProduk->rowCount();

// 		do {

// 			$kd_produkLama = $row_kembaliProduk['kd_produk'];
// 			$jmlBeliLama = $row_kembaliProduk['jml_beli'];

// 			$con->exec("UPDATE produk SET stok=stok+$jmlBeliLama WHERE kd_produk='$kd_produkLama' ");

// 		} while($row_kembaliProduk = $sql_kembaliProduk->fetch(PDO::FETCH_LAZY));

// 		$con->exec("DELETE FROM faktur WHERE kd_faktur='$kfakturLama' ");
// 		$con->exec("DELETE FROM order_produk WHERE kd_faktur='$kfakturLama' ");

// 	}while($row_pembelianLama = $sql_pembelianLama->fetch(PDO::FETCH_LAZY));
// }
?>
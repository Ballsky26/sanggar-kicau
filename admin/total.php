<?php

$sql_tinbox = $con->query("SELECT * FROM inbox");
$row_tinbox = $sql_tinbox->fetch(PDO::FETCH_LAZY);
$trow_tinbox = $sql_tinbox->rowCount();

$sql_torder = $con->query("SELECT * FROM faktur WHERE total_biaya_barang != 'NULL' ");
$row_torder = $sql_torder->fetch(PDO::FETCH_LAZY);
$trow_torder = $sql_torder->rowCount();

$sql_tplg = $con->query("SELECT * FROM pelanggan");
$row_tplg = $sql_tplg->fetch(PDO::FETCH_LAZY);
$trow_tplg = $sql_tplg->rowCount();

$sql_tbarang = $con->query("SELECT * FROM produk");
$row_tbarang = $sql_tbarang->fetch(PDO::FETCH_LAZY);
$trow_tbarang = $sql_tbarang->rowCount();
?>
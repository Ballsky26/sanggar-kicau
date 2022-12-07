<?php
$userid = $_SESSION['pelanggan'];
// Cek apakah pengguna sudah melakukan transaksi yang belum dikonfirmasi
$sql_status_faktur  = $con->query("SELECT * FROM faktur WHERE userid='$userid' AND konfirm='Belum' ");
$row_status_faktur  = $sql_status_faktur->fetch(PDO::FETCH_LAZY);
$trow_status_faktur = $sql_status_faktur->rowCount();

// jika tidak ada
if (empty($trow_status_faktur)) {

    // dibuatkan kode faktur baru
	$_SESSION['kd_faktur'] = time();
	$kd_faktur             = $_SESSION['kd_faktur'];

    // proses simpan ke tabel faktur
    $con->exec("INSERT INTO faktur (kd_faktur, userid) 
            VALUES (
            '".$kd_faktur."',
            '".$userid."'
            )");

} else { // ada

    // kd faktur di ambil dari transaksi yang pernah dilakukan sebelumnya
	$_SESSION['kd_faktur'] = $row_status_faktur['kd_faktur'];
	$kd_faktur             = $_SESSION['kd_faktur'];
}
?>
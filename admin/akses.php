<?php
if (!isset($_SESSION)) {
  session_start();
}
$halaman = "login";
if (!isset($_SESSION['userid']) OR $_SESSION['tipe'] != "Admin")
    {
        header("Location: ". $halaman); 
        exit;
    }

$userid = $_SESSION['userid'];
$sql_akun = $con->query("SELECT * FROM admin WHERE email = '$userid' ");
$row_akun = $sql_akun->fetch(PDO::FETCH_LAZY);

$nama_akun = $row_akun['nama_admin'];
?>
<?php

$sql_list_kategori = $con->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
$row_list_kategori = $sql_list_kategori->fetch(PDO::FETCH_LAZY);

$sql_prd_custom = $con->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
$row_prd_custom = $sql_prd_custom->fetch(PDO::FETCH_LAZY);

?>
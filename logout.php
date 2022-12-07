<?php 
	// ** Logout **
	$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
	if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
	  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
	}

	if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
		require('koneksi.php');
		$_SESSION['pelanggan'] = NULL;
		$_SESSION['kd_faktur'] = NULL;
		$_SESSION['temp_kd_produk'] = NULL;
		$_SESSION['temp_jml_beli'] = NULL;
		$_SESSION['PrevUrl'] = NULL;
		unset($_SESSION['pelanggan']);
		unset($_SESSION['kd_faktur']);
		unset($_SESSION['temp_kd_produk']);
		unset($_SESSION['temp_jml_beli']);
		unset($_SESSION['temp_harga_produk']);
		unset($_SESSION['PrevUrl']);
		
	  	$logoutGoTo = "./";
	  	if ($logoutGoTo) {
	    	header("Location: $logoutGoTo");
	    	exit;
	  	}
	}
?>
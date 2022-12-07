<?php 
	include('akses.php');
	// ** Logout **
	$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
	if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
	  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
	}

	if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
		require('../koneksi.php');
		$_SESSION['userid'] = NULL;
		$_SESSION['tipe'] = NULL;
		$_SESSION['PrevUrl'] = NULL;
		unset($_SESSION['userid']);
		unset($_SESSION['tipe']);
		unset($_SESSION['PrevUrl']);
		
	  	$logoutGoTo = "login";
	  	if ($logoutGoTo) {
	    	header("Location: $logoutGoTo");
	    	exit;
	  	}
	}
?>
<?php 
include '../config.php';
if (!isset($_SESSION)) {
  session_start();
}
// ************************************************************* Validasi Login
$error = "";
$halaman = "login";

// Input Login
if ((isset($_POST["login"])) && ($_POST["login"] == "flogin"))
    {   
        include '../koneksi.php';
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = $con->query("SELECT * FROM user WHERE userid = '$username' AND password = '$password' AND tipe='Admin' AND status='Y' ");
        $row = $sql->fetch(PDO::FETCH_LAZY);
        $trow = $sql->rowCount();
        if (!empty($trow))
        {
            $_SESSION['userid'] = $row->userid;
            $_SESSION['tipe'] = $row->tipe;
            $halaman = "./";
            header("Location: " . $halaman );
        }
        else
        {
            $error = '<div style="font-size: 14px; color:#DE1717; font-weight: normal; text-align: center;">Username atau password yang Anda masukkan salah</div>';
        }
}

?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>

        <!-- CSS -->
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="../assets/css/login/form-elements.css">
        <link rel="stylesheet" href="../assets/css/login/style.css">
    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1>Sanggar Kicau</h1>
                            <!-- <div class="description">
                            	<p>
	                            	Lorem ipsum dolor sit amet.
                            	</p>
                            </div> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Login Administrator</h3>
                            		<p>Masukkan email dan password Anda untuk login:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-key"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="" method="post" class="login-form">
			                    	<div class="input-group col-xs-12" data-validate="email">
			                    		<label class="sr-only" for="form-username">Email</label>
			                        	<input type="text" name="username" placeholder="Email..." class="form-username form-control" id="form-username" required >
                                        <span class="input-group-addon danger" style="display: none;"></span>
			                        </div>
			                        <div class="input-group col-xs-12">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="password" placeholder="Password..." class="form-password form-control" id="form-password" required >
                                        <span class="input-group-addon danger" style="display: none;"></span>
			                        </div>
			                        <button type="submit" class="btn">Masuk!</button>
                                    <input type="hidden" name="login" value="flogin">
			                    </form>
                                <?php echo $error; ?>
		                    </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>


        <!-- Javascript -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/jquery.backstretch.min.js"></script>
        <script src="../assets/js/scripts.js"></script>
        <script src="../assets/js/validasi.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>
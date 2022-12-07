<?php
include 'config.php';
include 'koneksi.php';
include 'assets/lib/function.php';
include 'assets/lib/rajaongkir.php';
include 'query_header.php';

$error = "";
$halaman = "login";



if ((isset($_POST["fdaftar"])) && ($_POST["fdaftar"] == "y")) {
  $nama_plg    = $_POST["nama_plg"];
  $alamat_plg  = $_POST["alamat_plg"];
  $kd_provinsi = $_POST["kd_provinsi"];
  $kd_kota     = $_POST["kd_kota"];
  $kodepos_plg = $_POST["kodepos_plg"];
  $tlp_plg     = $_POST["tlp_plg"];
  $username    = $_POST["username"];
  $password    = $_POST["password"];
  $kode        = $_POST["kode"];

  $sql_cari = $con->query("SELECT * FROM user WHERE userid='$username' ");
  $row_cari = $sql_cari->fetch(PDO::FETCH_LAZY);
  $trow_cari = $sql_cari->rowCount();

  // jika data ada
  if (!empty($trow_cari)) {

    $error = '<div class="alert alert-danger" role="alert">Email yang anda masukkan sudah ada.</div>';
  } else { // tidak ada data

    $con->exec("INSERT INTO pelanggan (nama_plg, alamat_plg, kd_provinsi, kd_kota, kodepos_plg, tlp_plg, email_plg) 
                    VALUES (
                    '" . $nama_plg . "',
                    '" . $alamat_plg . "',
                    '" . $kd_provinsi . "',
                    '" . $kd_kota . "',
                    '" . $kodepos_plg . "',
                    '" . $tlp_plg . "',
                    '" . $username . "'
                    )");

    $con->exec("INSERT INTO user (userid, password, tipe, status, kode) 
                    VALUES (
                    '" . $username . "',
                    '" . $password . "',
                    'Pelanggan',
                    'Y',
                    '" . $kode . "'
                    )");

    //include('assets/lib/phpmailer/class.phpmailer.php');
    //include('assets/lib/phpmailer/class.smtp.php');

    //$email_pengirim = "sanggarkicau@gmail.com";
    //$pass_pengirim = "sanggarkicau123";

    //$mail = new PHPMailer();

    //$mail->Host     = "ssl://smtp.gmail.com"; 
    //$mail->Mailer   = "smtp";
    //$mail->SMTPAuth = true; 

    //$mail->Username = $email_pengirim; 
    //$mail->Password = $pass_pengirim;
    //$webmaster_email = $email_pengirim; 
    //$email = $username;
    //$name = $nama_plg; 
    //$mail->From = $webmaster_email;
    //$mail->FromName = "Sanggar Kicau";
    //$mail->AddAddress($email,$name);
    //$mail->AddReplyTo($webmaster_email,"Sanggar Kicau");
    //$mail->WordWrap = 50; 
    //$mail->AddAttachment("module.txt"); // attachment
    //$mail->AddAttachment("new.jpg"); // attachment
    //$mail->IsHTML(true); 
    //$mail->Subject = "Verifikasi Email Sanggar Kicau";
    //$mail->Body = "<h4>Pendaftaran berhasil!</h4><p>Hi $nama_plg, pendaftaran anda di toko online Sanggar Kicau kami telah berhasil!</p><p>Tinggal selangkah lagi untuk menjadi member kami, silahkan klik link dibawah ini untuk menyelesaikan pendaftaran</p><p>http://localhost/gsb/verifikasi?user=$username&&kode=$kode</p>"; 
    //$mail->AltBody = "This is the body when user views in plain text format"; 
    //if(!$mail->Send())
    //{
    //    $error = '<div class="alert alert-danger" role="alert">Gagal mengirim konfirmasi email</div>';
    //}
    //else
    //{
    $error = '<div class="alert alert-success" role="alert">Anda Berhasil Terdaftar menjadi Member, Silahkan melakukan login.</div>';
    //}
  }
}
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
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/animate.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/fontawesome/css/font-awesome.min.css">
</head>

<body style="padding-top: 35px">

  <?php // include 'header.php'; 
  ?>

  <div class="container">

    <div class="row">


      <div class="col-md-12">
        <div class="login-header">
          <!-- <a href="./"><img src="assets/images/logo.png" width="200"></a> -->
          <h3>Daftar Sanggar Kicau</h3>
          <p>Sudah punya akun Sanggar Kicau? Masuk <a href="login">di sini</a></p>
        </div>
        <div class="row input-login">
          <div class="col-md-12"> <?php echo $error; ?>
            <form method="POST">
              <div class="form-group" id="f-username">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control" id="nama_plg" name="nama_plg" placeholder="Nama Lengkap" autocomplete="off" required autofocus>
                  <span class="input-group-addon danger" style="display: none;"></span>
                </div>
              </div>
              <div class="form-group" id="f-username">
                <div class="input-group col-xs-12">
                  <textarea name="alamat_plg" class="form-control" required placeholder="Alamat"></textarea>
                  <span class="input-group-addon danger" style="display: none;"></span>
                </div>
              </div>
              <div class="form-group" id="f-username">
                <div class="input-group col-xs-12">
                  <select id="kd_provinsi" name="kd_provinsi" class="form-control" required>
                    <option>Pilih Provinsi</option>
                    <?php
                    $response = curl_exec(setProvinsi());
                    $err = curl_error(setProvinsi());
                    curl_close(setProvinsi());

                    if ($err) {
                      echo "cURL Error #:" . $err;
                    } else {
                      $hasil = json_decode($response, true);
                      for ($i = 0; $i < count($hasil['rajaongkir']['results']); $i++) {
                    ?>
                        <option value="<?php echo $hasil['rajaongkir']['results'][$i]['province_id']; ?>">
                          <?php echo $hasil['rajaongkir']['results'][$i]['province']; ?>
                        </option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                  <span class="input-group-addon danger" style="display: none;"></span>
                </div>
              </div>
              <div class="form-group" id="f-username">
                <div class="input-group col-xs-12">
                  <select id="kd_kota" name="kd_kota" class="form-control" required>
                  </select>
                  <span class="input-group-addon danger" style="display: none;"></span>
                </div>
              </div>
              <div class="form-group" id="f-username">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control" maxlength="5" id="kodepos_plg" name="kodepos_plg" placeholder="Kode Pos" autocomplete="off" required autofocus onKeyPress="return goodchars(event,'0123456789',this)">
                  <span class="input-group-addon danger" style="display: none;"></span>
                </div>
              </div>
              <div class="form-group" id="f-username">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control" maxlength="13" id="kodepos_plg" name="tlp_plg" placeholder="Telepon" autocomplete="off" required autofocus onKeyPress="return goodchars(event,'0123456789',this)">
                  <span class="input-group-addon danger" style="display: none;"></span>
                </div>
              </div>
              <div class="form-group" id="f-username">
                <div class="input-group col-xs-12" data-validate="email">
                  <input type="email" class="form-control" id="username" name="username" placeholder="Email" autocomplete="off" required autofocus>
                  <span class="input-group-addon danger" style="display: none;"></span>
                </div>
              </div>
              <div class="form-group" id="f-password">
                <div class="input-group col-xs-12">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required>
                  <span class="input-group-addon danger" style="display: none;"></span>
                </div>
              </div><button name="fdaftar" value="y" type="submit" class="btn btn-success btn-block">
                <input type="hidden" name="kode" value="<?php echo rand(1111111111, 9999999999); ?>">
                Daftar ke <?php echo $nama_perusahaan; ?> </button>
            </form>
          </div>
        </div>
      </div>

    </div>

  </div>

  <div class="container" style="text-align: center">
    <footer>
      <div class="row">

        <div class="col-lg-12">
          <p>Copyright &copy; <a href="./"><?php echo $nama_perusahaan . "</a> " . date("Y"); ?>
          </p>
        </div>
      </div>
    </footer>
  </div>
  <!-- /.container -->

  <?php // include 'footer.php'; 
  ?>

  <!-- Bootstrap core JavaScript
        ================================================== -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/validasi.js"></script>
  <script src="assets/js/validasiinput.js"></script>
  <script>
    $(document).ready(function() {
      $('#kd_provinsi').change(function() {
        var id = $(this).val();
        $('#kd_kota').empty();
        $.ajax({
          type: "post",
          url: "cari_kota.php",
          data: "q=" + id,
          success: function(data) {
            $("#kd_kota").html(data);
            // if (data !== "") {
            //     $('#kd_kota').prop('disabled', false);
            // }else {
            //     $('#kd_kota').prop('disabled', true);
            // };
          }
        });
      });
    });
  </script>
</body>

</html>
<html>
<head>
<title>Resset Password</title>
<style>
body {background:#e84c3d; padding:0px; margin:0px}
h3 {color:#ffffff; text-align:center; font-family:Arial, Helvetica, sans-serif; font-size:20px; margin:20px;}
.wrapper-f{width:300px; margin:auto; padding:40px 20px 20px 20px; background:#e84c3d; margin-top:5%; min-height:120px;}
.wrapper-f label {color:#ffffff;}
.wrapper-f input {padding:5px; background:#eeeeee; border:0px; color:#333; width:98%; margin-bottom:10px;}
.wrapper-f input:focus{ background:#ccc;}
.wrapper-f .button {padding:10px 20px 10px 20px; color:#ffffff; background:#e84c3d; margin-top:10px; cursor:pointer}
.wrapper-f .button:hover {background:#333;}
.warning {background:#FF9900; color:#ffffff; padding:10px; border-radius:5px; border:1px; text-align:center;margin:auto;
 width:400px; margin-top:20px;}
</style>
</head>
<h3> Sanggar Kicau</h3>
<h3>FORGOT PASSWORD</h3>
<div class="wrapper-f">
<form action="" method="post">
<label>Masukkan Email anda</label>
<input name="email" type="email" placeholder="Masukkan Email" required oninvalid="this.setCustomValidity('Masukkan Email Dengan Benar')">
<input class="button" name="act_resset" type="submit" value="Submit">

</form>

</div>
<div style="width:600px; margin:auto">
<?PHP 
$server = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'dbgscb';
$x = mysql_connect($server,$dbuser,$dbpass) or die(mysql_error());
mysql_select_db($dbname,$x);
///////////////////////////////////////////////////////////////////////
if (isset($_POST['act_resset']))  {
date_default_timezone_set("Asia/Jakarta");
$pass="1A2B4HTjsk5kwhadbwlff"; $panjang='8'; $len=strlen($pass); 
$start=$len-$panjang; $xx=rand('0',$start); 
$yy=str_shuffle($pass); 
$passwordbaru=substr($yy, $xx, $panjang);

$email = trim(strip_tags($_POST['email']));
$password = mysql_real_escape_string(htmlentities((md5($passwordbaru))));
$datetime=date("h:i:s-j-M-Y");

// mencari alamat email si user
$query = "SELECT user.*, pelanggan.* FROM user, pelanggan WHERE user.userid=pelanggan.email_plg AND user.userid ='$email'";
$hasil = mysql_query($query);
$data  = mysql_fetch_array($hasil);
$cek = mysql_num_rows($hasil);
$id_member = strip_tags($data['userid']);
$alamatEmail = strip_tags($data['email_plg']);
$nama = strip_tags($data['nama_plg']);
if ($cek == 1) {

// title atau subject email
$title  = "Permintaan Password Baru";
// isi pesan email disertai password
$pesan  = "Kami telah meresset Ulang Kata sandi ".$nama." Dan anda dapat login kembali ke web kami \n\n 
DETAIL AKUN ANDA :\n Email : ".$alamatEmail." \n 
Kata sandi Anda yang baru adalah: ".$passwordbaru."\n\n 
\n\n PESAN NO-REPLY";
// header email berisi alamat pengirim
$header = "From: nama-website<no-reply@domain.com>";
// mengirim email
$kirimEmail = mail($alamatEmail, $title, $pesan, $header);
// cek status pengiriman email
if ($kirimEmail) { 

    // update password baru ke database (jika pengiriman email sukses)
    $query = "UPDATE user SET password='$password' WHERE userid = '$id_member'";
    $hasil = mysql_query($query);

    if ($hasil) 
	echo'<div class="warning">Kata sandi baru telah direset dan sudah dikirim ke email "'.$alamatEmail.'" Silahkan cek emailnya</div><br><br><br>
	'.$pesan.'<hr>';
    }
	else {
echo'<div class="warning">Pengiriman Kata sandi baru ke email gagal</div>';
}
}
else{

echo'<div class="warning">Alamat Email tidak ditemukan</div>';
}}


?>

</div>

<body>
</body>
</html>

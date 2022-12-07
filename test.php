<?php
include('assets/lib/phpmailer/class.phpmailer.php');
include('assets/lib/phpmailer/class.smtp.php');

$email_pengirim = "sanggar.kicau@gmail.com";
$pass_pengirim = "sanggarkicau123";

$username = "rizkyandana@gmail.com";
$nama_plg = "Rizky";
$kode = "56466";

$mail = new PHPMailer();
 
$mail->Host     = "ssl://smtp.gmail.com"; 
$mail->Mailer   = "smtp";
$mail->SMTPAuth = true; 
 
$mail->Username = $email_pengirim; 
$mail->Password = $pass_pengirim;
$webmaster_email = $email_pengirim; 
$email = $username;
$name = $nama_plg; 
$mail->From = $webmaster_email;
$mail->FromName = "Sanggar Kicau";
$mail->AddAddress($email,$name);
$mail->AddReplyTo($webmaster_email,"Sanggar Kicau");
$mail->WordWrap = 50; 
//$mail->AddAttachment("module.txt"); // attachment
//$mail->AddAttachment("new.jpg"); // attachment
$mail->IsHTML(true); 
$mail->Subject = "Verifikasi Akun Sanggar Kicau";
$mail->Body = "<h4>Verifikasi email</h4><p>Hi $nama_plg, pendaftaran anda di toko online Sanggar Kicau kami berhasil!</p><p>Tinggal selangkah lagi untuk menjadi member kami, silahkan klik link dibawah ini untuk menyelesaikan pendaftaran</p><p>http://localhost/gsb/verifikasi?user=$username&&kode=$kode</p>"; 
$mail->AltBody = "This is the body when user views in plain text format"; 
if(!$mail->Send())
{
    $error = '<div class="alert alert-danger" role="alert">Gagal mengirim konfirmasi email</div>';
}
else
{
    $error = '<div class="alert alert-success" role="alert">Silahkan konfirmasi email anda</div>';
}
echo $error;
?>
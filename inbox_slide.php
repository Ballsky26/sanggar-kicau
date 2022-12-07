<?php 
include 'config.php';
include 'koneksi.php';
include 'assets/lib/function.php';
include 'query_header.php';
$kd_inbox = $_POST['q'];

$sql = $con->query("SELECT * FROM inbox_detail WHERE kd_inbox='$kd_inbox' ORDER BY kd_inbox_detail ASC");
$row = $sql->fetch();
$noUrut = 1;
?>

<div style='width:97%; padding-right:3%' id='pesan'>
	<?php
		do{
			$userid = $row['userid'];

			$sql_tipe = $con->query("SELECT * FROM user WHERE userid='$userid' ");
			$row_tipe = $sql_tipe->fetch(PDO::FETCH_LAZY);
			$tipe = $row_tipe['tipe'];
			if ($tipe == "Admin") {
				echo '<div class="balon-a pull-left">';
				$admin = $row['userid'];
			} else {
				echo '<div class="balon-b pull-right">';
			}
			echo $row['pesan'];
			echo '</div>';
			echo '<div class="balon-jam">'.longDateTs($row['tgl']).'</div>';
		}while($row = $sql->fetch());
		$con->exec("UPDATE inbox_detail SET status='R' WHERE kd_inbox='$kd_inbox' AND userid='$admin' ");
		
	?>
</div>

<div class="panel-footer bg-white">
	<form method="POST">
		<div class="form-group">
            <div class="input-group col-xs-12">
				<textarea name="kirimpesan" class="form-control" style="width:100%; resize: none;" rows="2" required></textarea>
                <span class="input-group-addon danger" style="display: none;"></span>
            </div>
        </div>
        <button type="submit" class="btn btn-success pull-right" disabled>Kirim</button>
	    <input type="hidden" name="fkirim" value="y" />
	    <input type="hidden" name="kd_inbox" value="<?php echo $kd_inbox ?>" />
	    <input type="hidden" name="userid" value="<?php echo $_SESSION['pelanggan']; ?>" />
	</form>
</div>
</div>
<script src="assets/js/validasi.js"></script>
<script src="assets/js/validasiinput.js"></script>
<script>
	$('#pesan').slimScroll({
	    height: '300px',
	    size: '3px',
	    BorderRadius: '3px',
	    start: 'bottom'
	});
</script>
<?php 
include 'koneksi.php';

$p = $_POST['p'];
$f = $_SESSION['kd_faktur'];
$sql = $con->query("SELECT a.*, b.* FROM penjualan as a, produk as b WHERE a.kd_faktur='$f' AND a.kd_produk='$p' AND b.kd_produk=a.kd_produk ");
$row = $sql->fetch();

?>

<div>
    <b style='font-size: 18px;'>Ubah Daftar Pembelian</b>
    <div style='float: right;'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    </div>
</div> <hr>

<form method="POST">
	<div class="form-group">
        <label>Nama Produk</label>
        <div class="input-group col-xs-12">
            <input class="form-control" value="<?php echo $row['nama_produk']; ?>" readonly>
            <span class="input-group-addon danger" style="display: none;"></span>
        </div>
    </div>
	<div class="form-group">
        <label>Jumlah Beli</label>
        <div class="input-group col-xs-3">
            <input id="jml_beli" type="text" name="jml_beli" value="<?php echo $row['jml_beli']; ?>" class="text-center">
        </div>
    </div>

    <button name="edit" value="y" type="submit" class="btn btn-block btn-success">Simpan</button>
    <input type="hidden" name="stok_semula" value="<?php echo $row['stok']+$row['jml_beli']; ?>">
    <input type="hidden" name="faktur" value="<?php echo $f; ?>">
    <input type="hidden" name="produk" value="<?php echo $p; ?>">
</form>
<script>

    $("#jml_beli").TouchSpin({
    	min: 1,
    	max: <?php echo $row['stok']+$row['jml_beli']; ?>,
    	buttondown_class: 'btn btn-default',
    	buttonup_class: 'btn btn-default'
    });
</script>
<?php
$sql_kontak = $con->query("SELECT * FROM kontak ORDER BY kd_kontak");
$row_kontak = $sql_kontak->fetch(PDO::FETCH_LAZY);

$sql_halaman = $con->query("SELECT * FROM halaman");
$row_halaman = $sql_halaman->fetch(PDO::FETCH_LAZY);

$sql_tentang = $con->query("SELECT * FROM halaman WHERE nama_halaman='Tentang'");
$row_tentang = $sql_tentang->fetch(PDO::FETCH_LAZY);

$sql_footer_kategori = $con->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
$row_footer_kategori = $sql_footer_kategori->fetch(PDO::FETCH_LAZY);

$sql_rekening = $con->query("SELECT * FROM rekening");
$row_rekening = $sql_rekening->fetch(PDO::FETCH_LAZY);

$sql_footer_kategori2 = $con->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
$row_footer_kategori2 = $sql_footer_kategori2->fetch(PDO::FETCH_LAZY);

?>
<hr>
<div class="container">
    <footer>
        <div class="row">
            <div class="col-lg-3">
                <h4>Hubungi Kami</h4>
                <?php do { ?>
                    <address>
                        <strong><?php echo $row_kontak['kontak']; ?></strong><br>
                        <?php echo $row_kontak['isi_kontak']; ?><br>
                    </address>
                <?php } while ($row_kontak = $sql_kontak->fetch()); ?>
            </div>

            <div class="col-lg-3">
                <h4>Rekening</h4>
                <?php do { ?>
                    <address>
                        <strong><?php echo $row_rekening['bank']; ?></strong><br>
                        a.n. Susiana<br>
                        <?php echo $row_rekening['no_rek']; ?><br>
                    </address>
                <?php } while ($row_rekening = $sql_rekening->fetch()); ?>
            </div>

            <div class="col-lg-3">
                <h4>Kategori Produk</h4>
                <ul class="list-unstyled">
                    <?php do { ?>
                        <li><a href="produk?kategori=<?php echo str_replace(" ", "_", $row_footer_kategori['nama_kategori']); ?>"><?php echo $row_footer_kategori['nama_kategori']; ?></a></li>
                    <?php } while ($row_footer_kategori = $sql_footer_kategori->fetch()); ?>
                </ul>
                <br>
                <!-- <h4>Beli Produk Custom</h4>
                <ul class="list-unstyled">
                    <?php // do{ 
                    ?>
                    <li><a href="produk_custom?kategori=<?php // echo str_replace(" ","_",$row_footer_kategori2['nama_kategori']); 
                                                        ?>"><?php // echo $row_footer_kategori2['nama_kategori']; 
                                                            ?></a></li>
                    <?php // }while($row_footer_kategori2 = $sql_footer_kategori2->fetch()); 
                    ?>
                </ul> -->
            </div>

            <div class="col-lg-3">
                <h4>Tentang <?php echo $nama_perusahaan; ?></h4>
                <p class="text-justify">
                    <?php echo $row_tentang['isi_halaman']; ?>
                </p>
            </div>
        </div>
    </footer>

</div>
<hr>
<div class="container">
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
<?php
include 'logout.php';
$sql_halaman = $con->query("SELECT * FROM halaman");
$row_halaman = $sql_halaman->fetch(PDO::FETCH_LAZY);
?>
<nav class="navbar navbar-default navbar-fixed-top bg-primary" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="./"><?php echo $nama_perusahaan; ?></a>
    </div>


    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">

        <!-- Menu kiri -->
        <ul class="nav navbar-nav">

            <!-- Tombol produk custom 
                ============================================ 
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Produk Custom <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php //do{ 
                        ?>
                        <li><a href="produk_custom?kategori=<?php //echo str_replace(" ","_",$row_prd_custom['nama_kategori']); 
                                                            ?>"><?php //echo $row_prd_custom['nama_kategori']; 
                                                                ?></a></li>
                        <?php // }while($row_prd_custom = $sql_prd_custom->fetch()); 
                        ?>
                    </ul>
                </li>
                 -->
            <!-- Tombol kategori
                ============================================ -->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Kategori <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php do { ?>
                        <li><a href="produk?kategori=<?php echo str_replace(" ", "_", $row_list_kategori['nama_kategori']); ?>"><?php echo $row_list_kategori['nama_kategori']; ?></a></li>
                    <?php } while ($row_list_kategori = $sql_list_kategori->fetch()); ?>
                </ul>
            </li>
            <li><a href="hubungi">Hubungi Kami</a></li>
            <li><a href="rekening">Rekening Pembayaran</a></li>
            <?php do { ?>
                <li><a href="halaman?kd_halaman=<?php echo $row_halaman['kd_halaman']; ?>"><?php echo $row_halaman['nama_halaman']; ?></a></li>
            <?php } while ($row_halaman = $sql_halaman->fetch()); ?>

        </ul>

        <!-- Input cari
            ================================================ -->
        <form id="form_cari" method="get" class="navbar-form navbar-left" action="produk" style="padding-top: 2px">
            <div class="form-group has-feedback">
                <input id="input_cari" type="text" placeholder="Cari Produk Disini.." class="form-control input-sm" name="cari_barang" style="width: 500px">
                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true" style="color: #AAAAAA"></span>
            </div>
        </form>
        <script type="text/javascript">
            $('#input_cari').keypress(function(event) {
                var kata_kunci = $('#input_cari').val()
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if (keycode == '13') {
                    document.form_cari.submit()
                }
                event.stopPropagation();
            });
        </script>
        <ul class="nav navbar-nav">

            <!-- Jika pelanggan belum login -->
            <?php if (!isset($_SESSION['pelanggan'])) : ?>
                <!-- Tombol daftar
======================================================= -->
                <li><a href="daftar">Daftar</a></li>

                <!-- Tombol masuk
====================================================== -->
                <li class="dropdown">
                    <a href="login">Masuk</a>
                    <!-- <ul class="dropdown-menu">
                        <form name="form-login" method="POST" action="login" id="form-login">
                            <div class="modal-body" style="width: 300px">
                                <div class="form-group" id="f-username">
                                    <div class="input-group col-xs-12" data-validate="email">
                                        <input type="email" class="form-control" id="username" name="username" placeholder="email" autocomplete="off" required autofocus>
                                        <span class="input-group-addon danger" style="display: none;"></span>
                                    </div>
                                </div>
                                <div class="form-group" id="f-password">
                                    <div class="input-group col-xs-12">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required>
                                        <span class="input-group-addon danger" style="display: none;"></span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-block" id="tombollogin" disabled>Masuk</button>
                            </div>
                            <input type="hidden" name="flogin" value="y" />
                        </form>
                    </ul> -->
                </li>

                <!-- Pelanggan sudah login -->
            <?php else : ?>
                <?php
                $id = $_SESSION['pelanggan'];
                $sql_pelanggan = $con->query("SELECT * FROM pelanggan WHERE email_plg = '$id' ");
                $row_pelanggan = $sql_pelanggan->fetch(PDO::FETCH_LAZY);
                $trow_pelanggan = $sql_pelanggan->rowCount();
                ?>
                <!-- Tombol pesan masuk
============================= -->
                <li style="margin-right: 20px">
                    <?php
                    $sql_inboxHeader = $con->query("SELECT a.*, b.* FROM inbox_detail as a, inbox as b WHERE a.kd_inbox=b.kd_inbox AND b.pengirim='$id' AND a.status='N' AND  a.userid!='$id' ORDER BY a.tgl ASC");
                    $row_inboxHeader = $sql_inboxHeader->fetch(PDO::FETCH_LAZY);
                    $trow_inboxHeader = $sql_inboxHeader->rowCount();
                    ?>
                    <a href="inbox" style="padding-bottom: 15px;padding-top: 20px">
                        <i class="fa fa-envelope fa-lg" aria-hidden="true"></i>
                        <?php if (!empty($trow_inboxHeader)) : ?>
                            <span class="label label-warning jml_beli"><?php echo $trow_inboxHeader; ?></span>
                        <?php endif ?>
                    </a>
                </li>

                <!-- Tombol keranjang belanja
==================================== -->
                <li style="margin-right: 20px">
                    <?php
                    $kd_faktur = $_SESSION['kd_faktur'];
                    $sql_keranjang = $con->query("SELECT * FROM penjualan WHERE kd_faktur='$kd_faktur' ");
                    $row_keranjang = $sql_keranjang->fetch(PDO::FETCH_LAZY);
                    $trow_keranjang = $sql_keranjang->rowCount();
                    ?>
                    <a href="daftar_pembelian" style="padding-bottom: 15px;padding-top: 20px">
                        <i class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i>
                        <?php if (!empty($trow_keranjang)) : ?>
                            <span class="label label-warning jml_beli"><?php echo $trow_keranjang; ?></span>
                        <?php endif ?>
                    </a>
                </li>

                <!-- Tombol transaksi
==================================== -->
                <?php
                $sql_cariTransaksi = $con->query("SELECT * FROM faktur WHERE userid='$id' AND konfirm!='Belum'");
                $row_cariTransaksi = $sql_cariTransaksi->fetch(PDO::FETCH_LAZY);
                $trow_cariTransaksi = $sql_cariTransaksi->rowCount();
                ?>
                <?php if (!empty($trow_cariTransaksi)) : ?>
                    <li style="margin-right: 20px">
                        <a href="transaksi" style="padding-bottom: 15px;padding-top: 20px">
                            <i class="fa fa-exchange fa-lg" aria-hidden="true"></i>
                        </a>
                    </li>
                <?php endif ?>

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i>
                        <span><?php echo $row_pelanggan['nama_plg'] ?> <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                        <li>
                            <a href="<?php echo $logoutAction ?>"><i class="fa fa-ban fa-fw pull-right"></i> Keluar</a>
                        </li>
                    </ul>
                </li>

            <?php endif; ?>
        </ul>
    </div>

    <!-- /.navbar-collapse -->
    <!-- /.container -->
</nav>
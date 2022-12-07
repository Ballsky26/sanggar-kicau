<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="../assets/images/foto/avatar.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>Hallo, <?php echo $nama_akun; ?></p>

                <a href="#"><i class="fa fa-calendar text-success"></i> <?php echo longDate(date("Y-m-d")); ?></a>
            </div>
        </div>
        <!-- search form -->
        <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form> -->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li <?php menuAktif("index", $page); ?>>
                <a href="./">
                    <i class="fa fa-home fa-lg"></i> <span>Home</span>
                </a>
            </li>
            <li <?php menuAktif("kategori", $page); ?>>
                <a href="kategori">
                    <i class="fa fa-tags fa-lg"></i> <span>kategori</span>
                </a>
            </li>
            <li <?php menuAktif("produk", $page); ?>>
                <a href="produk">
                    <i class="fa fa-archive fa-lg"></i> <span>produk</span>
                </a>
            </li>
            <!-- <li <?php // menuAktif("produk_custom", $page); 
                        ?>>
                <a href="produk_custom">
                    <i class="fa fa-archive fa-lg"></i> <span>produk Custom</span>
                </a>
            </li> -->
            <li <?php menuAktif("pelanggan", $page); ?>>
                <a href="pelanggan">
                    <i class="fa fa-users fa-lg"></i> <span>pelanggan</span>
                </a>
            </li>
            <li <?php menuAktif("order", $page); ?>>
                <a href="order">
                    <i class="fa fa-shopping-basket fa-lg"></i> <span>order</span>
                </a>
            </li>
            <!-- 
            <li <?php //menuAktif("laporan", $page); 
                ?>>
                <a href="awal_laporan">
                    <i class="fa fa-file fa-lg"></i> <span>Laporan</span>
                </a>
            </li> -->
            <li <?php menuAktif("lapstok", $page); ?>>
                <a href="lapstok" target="_blank">
                    <i class="fa fa-file fa-lg"></i> <span>Laporan Stok Produk</span>
                </a>
            </li>
            <li <?php menuAktif("laporanpenjualan", $page); ?>>
                <a href="awal_laporan">
                    <i class="fa fa-file fa-lg"></i> <span>Laporan Penjualan</span>
                </a>
            </li>
            <li <?php menuAktif("inbox", $page); ?>>
                <a href="inbox">
                    <i class="fa fa-inbox fa-lg"></i> <span>inbox</span>
                </a>
            </li>
            <li <?php menuAktif("halaman", $page); ?>>
                <a href="halaman">
                    <i class="fa fa-gears fa-lg"></i> <span>Setting halaman</span>
                </a>
            </li>
            <li <?php menuAktif("rekening", $page); ?>>
                <a href="rekening">
                    <i class="fa fa-gears fa-lg"></i> <span>Setting Rekening</span>
                </a>
            </li>
            <li <?php menuAktif("kontak", $page); ?>>
                <a href="kontak">
                    <i class="fa fa-gears fa-lg"></i> <span>Setting Kontak</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
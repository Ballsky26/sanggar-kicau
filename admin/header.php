<?php
include 'akses.php'; 
include 'logout.php'; 

$sql_inboxHeader = $con->query("SELECT * FROM inbox_detail WHERE status='N' AND userid!='$userid' ORDER BY tgl ASC");
$row_inboxHeader = $sql_inboxHeader->fetch(PDO::FETCH_LAZY);
$trow_inboxHeader = $sql_inboxHeader->rowCount();
if (!empty($trow_inboxHeader)) {
    $link = "javascript:void(0)";
    $data = 'data-toggle="dropdown"';
} else {
    $link = "inbox";
    $data = '';
}

?>
<header class="header">
    <a href="./" class="logo">
    Administrator
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="<?php echo $link; ?>" class="dropdown-toggle" <?php echo $data; ?>>
                        <i class="fa fa-envelope"></i>
                        <?php if(!empty($trow_inboxHeader)): ?>
                            <span class="label label-success"><?php echo $trow_inboxHeader; ?></span>
                        <?php endif; ?>
                    </a>

                    <?php if(!empty($trow_inboxHeader)): ?>
                    <ul class="dropdown-menu">
                        <li class="header">You have <?php echo $trow_inboxHeader; ?> messages</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <?php do{
                                    $emailplg_inboxHeader = $row_inboxHeader['userid'];
                                    $kdinbox_inboxHeader = $row_inboxHeader['kd_inbox'];

                                    $sql_cariPlgn = $con->query("SELECT * FROM pelanggan WHERE email_plg='$emailplg_inboxHeader' ");
                                    $row_cariPlgn = $sql_cariPlgn->fetch(PDO::FETCH_LAZY);
                                    $trow_cariPlgn = $sql_cariPlgn->rowCount();
                                    $nama = $row_cariPlgn['nama_plg'];

                                    ?>
                                    <li><!-- start message -->
                                        <a href="tampil_inbox?kd_inbox=<?php echo $kdinbox_inboxHeader; ?>&&email_plg=<?php echo $emailplg_inboxHeader; ?>">
                                            <!-- <div class="pull-left">
                                            <img src="img/26115.jpg" class="img-circle" alt="User Image"/>
                                            </div> -->
                                            <h4>
                                                <?php echo $nama; ?>
                                            </h4>
                                            <p><?php echo substr($row_inboxHeader['pesan'],0,43); ?></p>
                                            <small class="pull-right"><i class="fa fa-clock-o"></i> <?php echo timeAgo(strtotime($row_inboxHeader['tgl'])); ?></small>
                                        </a>
                                    </li><!-- end message -->
                                <?php }while($row_inboxHeader = $sql_inboxHeader->fetch()); ?>
                            </ul>
                        </li>
                        <li class="footer"><a href="inbox">Tampilkan Semua Pesan</a></li>
                    </ul>
                    <?php endif; ?>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i>
                        <span><?php echo $nama_akun; ?> <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                        <!-- <li class="dropdown-header text-center">Akun</li> -->

                        <li>
                            <a href="setting_akun"><i class="fa fa-cog fa-fw pull-right"></i> Setting Akun</a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="<?php echo $logoutAction ?>"><i class="fa fa-ban fa-fw pull-right"></i> Keluar</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
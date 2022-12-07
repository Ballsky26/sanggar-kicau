<?php
include '../koneksi.php';
include '../config.php';
include '../assets/lib/function.php';
$page = "produk";

if ((isset($_POST["fhapus"])) && ($_POST["fhapus"] == "y")) {

  $kd_produk  = $_POST['kd_produk'];
  $foto = $_POST['foto'];
  if ($foto != "produk.png") {
    unlink("../assets/images/produk/$foto");
  }
  $con->exec("DELETE FROM produk WHERE kd_produk = '$kd_produk'");
  $con->exec("DELETE FROM foto_produk WHERE kd_produk = '$kd_produk'");
  tampilPesan("Berhasil Dihapus!", "Data yang dipilih berhasil dihapus!", "success", "$page");
}


$sql = $con->query("SELECT a.*, b.* FROM produk as a, kategori as b WHERE b.kd_kategori=a.kd_kategori");
$row = $sql->fetch(PDO::FETCH_LAZY);
$trow = $sql->rowCount();
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
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../assets/fontawesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../assets/css/datatables/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/sweetalert.css">
  <link rel="stylesheet" href="../assets/css/datepicker/jquery-ui.css">
  <style>
    .ui-datepicker {
      z-index: 1151 !important;
    }
  </style>
</head>

<body class="skin-blue">
  <!-- memanggil file header -->
  <?php include 'header.php'; ?>

  <div class="wrapper row-offcanvas row-offcanvas-left">

    <!-- memanggil file sidemenu -->
    <?php include 'sidemenu.php'; ?>

    <aside class="right-side">
      <!-- Main content -->
      <section class="content">
        <!-- Main row -->
        <div class="row">

          <div class="col-lg-12">
            <div class="panel">
              <header class="panel-heading"> Produk </header>
              <div class="panel-body table-responsive">
                <!-- Tombol tambah -->
                <a href="produk_tambah" class="btn btn-primary btn-sm"><span class="fa fa-plus"></span>
                  Tambah</a> <a data-toggle="modal" href='#modal-id' class="btn btn-success btn-sm"><span class="fa fa-print"></span>
                  Cetak</a> <br>
                <br>
                <!-- Tabel -->
                <table id="tabel" class="table table-bordered table-striped" cellspacing="0" width="100%" style="font-size: 12px">
                  <thead>
                    <tr>
                      <th>foto</th>
                      <th>Kategori</th>
                      <th>nama Produk</th>
                      <th>warna</th>
                      <th>Ukuran</th>
                      <th>berat</th>
                      <th>Stok</th>
                      <th>harga</th>
                      <th>diskon</th>
                      <th>proses</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php do {
                      $kd_produk = $row['kd_produk'];
                      if ($row['diskon'] != null) {
                        $diskon = $row['diskon'] . "%";
                      } else {
                        $diskon = "-";
                      }
                    ?>
                      <tr data-id="<?php echo $kd_produk; ?>">
                        <td width="10%"> <img src="../assets/images/produk/<?php echo $row['foto']; ?>" class="img-thumbnail" width="100" height="100">
                        </td>
                        <td width="auto" align="center"><?php echo $row['nama_kategori']; ?></td>
                        <td width="auto"><?php echo $row['nama_produk']; ?></td>
                        <td width="auto" align="center"><?php echo $row['warna']; ?></td>
                        <td width="auto" align="center"><?php echo $row['ukuran']; ?></td>
                        <td width="auto" align="center"><?php echo berat($row['berat']); ?></td>
                        <td width="auto" align="center"><?php echo stok($row['stok']); ?></td>
                        <td width="auto" align="right"><?php echo uang($row['harga']); ?></td>
                        <td width="auto" align="center"><?php echo $diskon; ?></td>
                        <td width="10%" align="center">
                          <form method="POST" class="form-inline">
                            <?php if (!empty($trow)) : ?>
                              <div class="view_detail" style="width: 100%; padding-bottom: 5px">
                                <a href="detail_produk?kd_produk=<?php echo $kd_produk; ?>" class="btn btn-success btn-xs">Deskripsi</a>
                              </div>
                              <a href="produk_edit?kd_produk=<?php echo $kd_produk; ?>" class="btn btn-info btn-xs">Edit</a>
                              <button type="submit" class='submit btn btn-danger btn-xs'>Hapus</button>
                            <?php endif; ?>
                            <input type="hidden" name="fhapus" value="y" />
                            <input type="hidden" name="kd_produk" value="<?php echo $row['kd_produk']; ?>" />
                          </form>
                        </td>
                      </tr>
                    <?php } while ($row = $sql->fetch(PDO::FETCH_LAZY)); ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div> <!-- /.row -->
      </section><!-- /.content -->

    </aside><!-- /.right-side -->
  </div><!-- ./wrapper -->

  <div class="modal fade" id="modal-id">

    <div class="modal-dialog">
      <form method="GET" action="print_produk" target="_blank">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Pilih Range Tanggal Penjualan</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                  <label>Awal</label>
                  <div class="input-group col-xs-12">
                    <input id="tgl1" type="text" class="form-control" name="awal" required autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label>Akhir</label>
                  <div class="input-group col-xs-12">
                    <input id="tgl2" type="text" class="form-control" name="akhir" required autocomplete="off">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Print</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="deskripsi" role="dialog">

    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div id="hasil"></div>
        </div>
      </div>
    </div>
  </div>


  <!-- JavaScript
        ================================================== -->
  <script src="../assets/js/jquery.min.js"></script>
  <script src="../assets/js/bootstrap.min.js"></script>
  <script src="../assets/js/app.js"></script>

  <!-- tabel -->
  <script src="../assets/js/datatables/jquery.dataTables.js"></script>
  <script src="../assets/js/datatables/dataTables.bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#tabel').dataTable({
        "columnDefs": [{
          "targets": [10],
          "searchable": false,
          "orderable": false,
        }]
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      $(".view_detail").click(function() {
        var id = $(this).parents('tr').data('id');
        $.ajax({
          type: "post",
          url: "detail_produk.php",
          data: "q=" + id,
          success: function(data) {
            $("#hasil").html(data);
          }
        });
      });
    });
  </script>

  <!-- konfirmasi -->
  <script src="../assets/js/sweetalert.js"></script>
  <script>
    $('.submit').on('click', function(e) {
      e.preventDefault();
      var form = $(this).parents('form');
      swal({
        title: "Apakah anda yakin?",
        text: "Data yang terhapus tidak dapat dikembalikan!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, hapus saja!",
        cancelButtonText: "Batal",
        closeOnConfirm: false
      }, function(isConfirm) {
        if (isConfirm) form.submit();
      });
    })
  </script>

  <script src="../assets/js/datepicker/jquery-ui.js"></script>
  <script type="text/javascript">
    $('#tgl1').datepicker({
      dateFormat: "dd-mm-yy",
      yearRange: '2000:<?php echo date('Y'); ?>',
      changeMonth: true,
      changeYear: true,
      showAnim: "drop",
    });
    $('#tgl2').datepicker({
      dateFormat: "dd-mm-yy",
      yearRange: '2000:<?php echo date('Y'); ?>',
      changeMonth: true,
      changeYear: true,
      showAnim: "drop",
    });
  </script>

</body>

</html>
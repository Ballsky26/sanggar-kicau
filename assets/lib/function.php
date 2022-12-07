<?php  

// ==================================================================== pesan berhasil
function tampilPesan($title, $pesan, $tipe, $halaman="") {
    // jika tidak pindah halaman
    if ($halaman=="") {
        $alert = '
                    setTimeout(function () {
                        swal({
                            title: "'.$title.'",
                            text: "'.$pesan.'", 
                            type: "'.$tipe.'",  
                            showConfirmButton: true
                        });
                    }, 0);
        ';
        echo '<script type="text/javascript">'.$alert.'</script>';

    } else { // jika pindah halaman
        $alert = '
                    setTimeout(function () {
                        swal({
                            title: "'.$title.'",
                            text: "'.$pesan.'", 
                            type: "'.$tipe.'",  
                            showConfirmButton: false 
                        });
                    }, 0);
        ';
        $pindah_halaman = 'setTimeout(function(){window.top.location="'.$halaman.'"} , 2000);';
        echo '<script type="text/javascript">'.$alert.$pindah_halaman.'</script>';
    }
}

// ==================================================================== berat
function berat($nilai){
    if ($nilai < 1000) {
        $hasil = $nilai." gram";
    } else {
        $hitung = round($nilai/1000);
        $hasil = $hitung." kg";
    }
    return $hasil;
}
// ==================================================================== berat ke kg
function berat_kg($nilai){
    $hasil = ceil($nilai / 1000);
    return $hasil;
}
// ==================================================================== menu aktif
function menuAktif($menu="", $halaman="") {
    if ($menu == $halaman) {
        echo "class='active'";
    } else {
        echo "";
    }
}
// ==================================================================== fungsi uang
function uang($nilai){
    if ($nilai) {
        $hasil = "Rp. ".number_format($nilai,0,",",".");
    }
    if ($nilai == 0) {
        $hasil = "Rp. 0";
    }
    if ($nilai == null) {
        $hasil = "";
    }
    
    return $hasil;
} 
// ==================================================================== fungsi hanya angka
function hanyaAngka($nilai){
    $tampil = preg_replace("/[^0-9]/", "", $nilai);
    return $tampil;
}
// ==================================================================== fungsi tanggal -> 17 Agustus 1945
function longDate($tanggal){
    if ($tanggal) {
        $tgl            = date('d', strtotime($tanggal));
        $bulan          = date('m', strtotime($tanggal));
        $tahun          = date('Y', strtotime($tanggal));

        $indo_bulan = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'Nopember',
            '12' => 'Desember'
            );

        $tampil_tanggal = $tgl.' '.$indo_bulan[$bulan].' '.$tahun;
    }

    return $tampil_tanggal;
}

// ==================================================================== fungsi tanggal
function longDateTs($tanggal){
    if ($tanggal) {
        $tgl   = date('d', strtotime($tanggal));
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $jam   = date('H', strtotime($tanggal));
        $menit = date('m', strtotime($tanggal));

        $indo_bulan = array(
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'Mei',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Agust',
            '09' => 'Sep',
            '10' => 'Okt',
            '11' => 'Nop',
            '12' => 'Des'
            );

        $tampil_tanggal = $tgl.'/'.$indo_bulan[$bulan].'/'.$tahun.' '.$jam.':'.$menit;
    }

    return $tampil_tanggal;
}

// ==================================================================== fungsi tanggal
function longDatepukul($tanggal){
    if ($tanggal) {
        $tgl   = date('d', strtotime($tanggal));
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $jam   = date('H', strtotime($tanggal));
        $menit = date('m', strtotime($tanggal));

        $indo_bulan = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'Nopember',
            '12' => 'Desember'
            );

        $tampil_tanggal = $tgl.' '.$indo_bulan[$bulan].' '.$tahun.' pukul '.$jam.'.'.$menit.' WIB';
    }

    return $tampil_tanggal;
}
// ==================================================================== fungsi tanggal
function longDatepukul2($tanggal){
    if ($tanggal) {
        $tgl   = date('d', strtotime($tanggal))+1;
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $jam   = date('H', strtotime($tanggal));
        $menit = date('i', strtotime($tanggal));

        $indo_bulan = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'Nopember',
            '12' => 'Desember'
            );

        $tampil_tanggal = $tgl.' '.$indo_bulan[$bulan].' '.$tahun.' pukul '.$jam.'.'.$menit.' WIB';
    }

    return $tampil_tanggal;
}

// ==================================================================== fungsi tanggal -> 17 Agu 1945
function mediumDate($tanggal){
    if ($tanggal) {
        $tgl            = date('d', strtotime($tanggal));
        $bulan          = date('m', strtotime($tanggal));
        $tahun          = date('Y', strtotime($tanggal));

        $indo_bulan = array(
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'Mei',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Agust',
            '09' => 'Sep',
            '10' => 'Okt',
            '11' => 'Nop',
            '12' => 'Des'
            );

        $tampil_tanggal = $tgl.' '.$indo_bulan[$bulan].' '.$tahun;
    }

    return $tampil_tanggal;
}

// ==================================================================== fungsi bulan -> 01 = Januari
function bulan($bulan) {
	$indo_bulan = array(
		'01' => 'Januari',
		'02' => 'Februari',
		'03' => 'Maret',
		'04' => 'April',
		'05' => 'Mei',
		'06' => 'Juni',
		'07' => 'Juli',
		'08' => 'Agustus',
		'09' => 'September',
		'10' => 'Oktober',
		'11' => 'November',
		'12' => 'Desember'
	);
	return $indo_bulan[$bulan];
}

// ==================================================================== fungsi umur
function umur($tgllhr) { 
    if ($tgllhr) {
        list($thn,$bln,$tgl) = explode('-',$tgllhr); 
        $lahir        = mktime(0, 0, 0, (int)$bln, (int)$tgl, $thn); //jam,menit,detik,bulan,tanggal,tahun
        $t            = time(); 
        $umur         = ($lahir < 0) ? ( $t + ($lahir * -1) ) : $t - $lahir; $tahun = 60 * 60 * 24 * 365; 
        $tahunlahir   = $umur / $tahun; 
        $umursekarang = floor($tahunlahir) ; 
    }
    
    return $umursekarang; 
} 

// ==================================================================== fungsi jenis kelamin
function kelamin($status){
    if ($status) {
        if ($status == 'L') {
            $jekel = "Laki-laki";
        }else{
            $jekel = "Perempuan";
        }
    }
	
    return $jekel;
}

// ==================================================================== fungsi tanggal sql
function TglSql($tanggal) {
    if ($tanggal) {
        $string_tgl   = $tanggal;
        $potongan_tgl = explode("-", $string_tgl); 
        $tgl          = $potongan_tgl[0];
        $bulan        = $potongan_tgl[1];
        $tahun        = $potongan_tgl[2];
        $tgl_sql      = $tahun.'-'.$bulan.'-'.$tgl;
    }
	
	return $tgl_sql;
}

// ==================================================================== fungsi tanggal indonesia
function TglIndo($tanggal) {
    if ($tanggal) {
        $string_tgl   = $tanggal;
        $potongan_tgl = explode("-", $string_tgl); 
        $tahun        = $potongan_tgl[0];
        $bulan        = $potongan_tgl[1];
        $tgl          = $potongan_tgl[2];
        $tgl_sql      = $tgl.'-'.$bulan.'-'.$tahun;
    }
    
    return $tgl_sql;
}
// ==================================================================== fungsi terpilih
function terpilih($nilai1="", $nilai2=""){
    if ($nilai1 == $nilai2) {
        $tampil = "selected";
    } else {
        $tampil = "";
    }
    return $tampil;
}
    date_default_timezone_set('Asia/Jakarta');

// ==================================================================== fungsi beberapa waktu yang lalu
function timeAgo($waktuPosting){
    date_default_timezone_set('Asia/Jakarta');
    //  timeAgo adalah waktu estimasi kira-kira berapa lama jeda antara hari ini dengan waktu posting
    //  timeAgo = tanggal sekarang - waktu posting 
    $timeAgo = time() - $waktuPosting;

    //  jika timeAgo kurang dari 1 detik, maka munculkan pesan 'beberapa saat yang lalu'
    if( $timeAgo < 60 )
    {
        return 'Baru saja';
    }

    //  kondisi dimana tahun, bulan, hari, jam, menit, dan detik dalam satuan detik 
    //  dimasukkan ke dalam sebuah array untuk pembanding
    $condition = array( 
                31104000    =>  'tahun',
                2592000     =>  'bulan',
                86400       =>  'hari',
                3600        =>  'jam',
                60          =>  'menit',
                1           =>  'detik'
    );

    //  melakukan perulangan untuk mengecek kondisi mana yang paling sesuai dengan timeAgo
    foreach($condition as $secs => $str)
    {
        //  $d adalah nilai satuan yg digunakan seperti '1 tahun' atau '2 jam'
        //  $d didapat dari timeAgo dibagi dengan kondisi
        $d = $timeAgo / $secs;

        // jika $d lebih dari atau sama dengan 1 maka cetak hasil kondisi dan sudahi perulangan
        if($d >= 1)
        {
            //  waktu di bulatkan
            $r = round($d);
            return $r.' '.$str.' yang lalu';
        }
    }
}

// ==================================================================== Judul
function potongText($tipe, $kalimat) {

    $jml_karakter = strlen($kalimat);

    if ($tipe == "judul") {
        if ($jml_karakter > 48) {
            echo substr($kalimat,0,48)."...";
        } else {
            echo $kalimat;
        }

    } else {
        if ($jml_karakter > 120) {
            echo substr($kalimat,0,120)."...";
        } else {
            echo $kalimat;
        }

    }
    
}

// ==================================================================== Judul
function perkalian($nilai1=0, $nilai2=0) {
    $hasil = $nilai1 * $nilai2;
    return $hasil;
}
// ==================================================================== Stok
function stok($nilai=0) {
    if ($nilai > 0) {
        $hasil = $nilai;
    } else {
        $hasil = "<b style='color: red'>Stok Habis</b>";
    }
    return $hasil;
}
function hargaDiskon($diskon=0, $nilai=0){
    $persen = ($diskon/100)*$nilai;
    $hasil = $nilai - $persen;
    return $hasil;
}
function tampilDiskon($nilai){
    $tampil = '<i class="badge pull-left" style="font-weight: normal; background-color: red; font-size:11px">Diskon '.$nilai.'%</i>';
    return $tampil;
}

function tampilDiskon2($nilai){
    $tampil = '<i class="badge" style="font-weight: normal; background-color: red;">Diskon '.$nilai.'%</i>';
    return $tampil;
}

function tampilKurir($kurir){
    if ($kurir != "Flanel") {
        $tampil = '<font style="text-transform: uppercase">'.$kurir.'</font>';
    } else {
        $tampil = $kurir;
    }
    return $tampil;
}
?>
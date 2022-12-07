<?php
//Setting Ongkir Otomatis Memanfaat akun starter RajaOngkir.Com
$SetPropinsi = "10"; //10 Propinsi Jawa Tengah
$AsalKiriman = "349"; //349 Kab Pekalongan Jawa Tengah
$AsalKiriman2 = "348"; //348 Pekalongan Jawa Tengah
$APIKeyRaja = "a60b1a32bddf7ad464219a31c3a2d5f2"; //API Key Raja

function setProvinsi(){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: a60b1a32bddf7ad464219a31c3a2d5f2"
        ),
    ));
    return $curl;
}

function setKota($provinsi_id=""){
    $curl = curl_init();
	curl_setopt_array($curl, array(
	    CURLOPT_URL => "http://api.rajaongkir.com/starter/city?province=$provinsi_id",
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_ENCODING => "",
	    CURLOPT_MAXREDIRS => 10,
	    CURLOPT_TIMEOUT => 30,
	    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	    CURLOPT_CUSTOMREQUEST => "GET",
	    CURLOPT_HTTPHEADER => array(
	        "key: a60b1a32bddf7ad464219a31c3a2d5f2"
	    ),
	));
    return $curl;
}

function tampilProvinsi($provinsi_id=""){
    $tampil = "";
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: a60b1a32bddf7ad464219a31c3a2d5f2"
        ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $hasil = json_decode($response, true);
        for($i=0; $i<count($hasil['rajaongkir']['results']); $i++){
            if ($hasil['rajaongkir']['results'][$i]['province_id'] == "$provinsi_id") {
                $tampil = $hasil['rajaongkir']['results'][$i]['province'];
            }
        }
    }
    return $tampil;
}

function tampilKota($provinsi_id="",$city_id=""){
    $tampil = "";
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://api.rajaongkir.com/starter/city?province=$provinsi_id",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: a60b1a32bddf7ad464219a31c3a2d5f2"
        ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $hasil = json_decode($response, true);
        for($i=0; $i<count($hasil['rajaongkir']['results']); $i++){
            if ($hasil['rajaongkir']['results'][$i]['city_id'] == "$city_id") {
                if ($hasil['rajaongkir']['results'][$i]['type'] == "Kota") {
                    $tampil = "Kab. ".$hasil['rajaongkir']['results'][$i]['city_name'];
                } else {
                    $tampil = $hasil['rajaongkir']['results'][$i]['city_name'];
                }
            }
        }
    }
    return $tampil;
}
?>
<?php  
include 'assets/lib/rajaongkir.php';

$q = $_POST['q'];
?>
<option>Pilih Kota</option>
<?php

$response = curl_exec(setKota($q));
$err = curl_error(setKota($q));
curl_close(setKota($q));

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $hasil = json_decode($response, true);
    for($i=0; $i<count($hasil['rajaongkir']['results']); $i++){
?>
        <option value="<?php echo $hasil['rajaongkir']['results'][$i]['city_id']; ?>">
        	<?php
        		if ($hasil['rajaongkir']['results'][$i]['type'] == "Kota") {
        			echo "Kab. ".$hasil['rajaongkir']['results'][$i]['city_name'];
        		} else {
        			echo $hasil['rajaongkir']['results'][$i]['city_name'];
        		}
        	?>
        </option>
<?php
    }
}
?>
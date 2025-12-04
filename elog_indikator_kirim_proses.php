<?php
session_start();
$nama_admin = $_SESSION['nama_petugas'];
$kota = $_SESSION['kota'];
$kodepuskesmas = $_SESSION['kodepuskesmas'];
include "config/koneksi.php";

if(strlen($kodepuskesmas) > 4){
	$area = substr($kodepuskesmas,1,4);
}else{
	$area = $kodepuskesmas;
}
	$query = mysqli_query($koneksi, "SELECT * FROM `ref_obatindikator` ORDER BY id_indikator");
	foreach($query as $ti){
		$periode = $_POST['bln']."_".$_POST['thn'];
		$kode_area = $_POST['kodearea'];
		$id_indikator = $ti['id_indikator'];
		$nama_indikator = $ti['nama_indikator'];

		if($kode_area == 'semua'){
			$querypuskesmas = mysqli_query($koneksi,"SELECT * FROM tbpuskesmas WHERE `Kota`='$kota' AND KodePuskesmas != '-' AND (KodePuskesmas != '3204' OR KodePuskesmas != '3201' OR KodePuskesmas != '3216')  order by NamaPuskesmas");
			while($dtpus = mysqli_fetch_assoc($querypuskesmas)){
				$str_gfk = "SELECT a.KodeBarang FROM `tbgudangpkmstok` a
				JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang
				WHERE b.id_indikator = '$id_indikator' AND a.KodePuskesmas = '$dtpus[KodePuskesmas]'";				

				$query_gfk = mysqli_query($koneksi,$str_gfk);
				$dt_gfk = mysqli_num_rows($query_gfk );
				
				if ($dt_gfk != 0){
					$status = 1;
				}else{
					$status = 0;
				}
				
				$kode_area = $dtpus['KodePuskesmas'];
				
				$arr['kode_pusk'] = $kode_area;
				$arr['id_obatindikator'] = $id_indikator;
				$arr['nama_indikator'] = $nama_indikator;
				$arr['sedia'] = $status;
				$arr_j[] = $arr;
			}
		
		}else{
			$str_gfk = "SELECT a.KodeBarang FROM `tbgudangpkmstok` a
			JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang
			WHERE b.id_indikator = '$id_indikator' AND a.KodePuskesmas = '$kode_area'";

			$query_gfk = mysqli_query($koneksi,$str_gfk);
			$dt_gfk = mysqli_num_rows($query_gfk );
			
			if ($dt_gfk != 0){
				$status = 1;
			}else{
				$status = 0;
			}
			
			$arr['kode_pusk'] = $kode_area;
			$arr['id_obatindikator'] = $id_indikator;
			$arr['nama_indikator'] = $nama_indikator;
			$arr['sedia'] = $status;
			$arr_j[] = $arr;
		}
	}
		
if ($kota == "KABUPATEN BANDUNG"){
	$usernameelog = "tomi4812@yahoo.co.id";
	$passelog = base64_encode(87654321);
}elseif($kota == "KABUPATEN BOGOR"){
	$usernameelog = "tomi4812i@gmail.com";
	$passelog = base64_encode(12345678);
}elseif($kota == "KABUPATEN BEKASI"){
	$usernameelog = "uptdfarmasikab.bekasi@gmail.com";
	$passelog = base64_encode(12345678);
}

$json_kirim = '
	{
        "dataEnvironment":{
          "token":{"username":"'.$usernameelog.'","password":"'.$passelog.'", "area":"'.$area.'"},
          "content": {
              "area": "'.$area.'",					
              "periode": "'.$periode.'",				
              "type": "Obat Indikator Puskesmas",		
              "user": "'.$nama_admin.'",					
              "table":'.json_encode($arr_j).'
            }
        }
    }';
	// echo $json_kirim;
	// die();

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://bankdataelog.kemkes.go.id/api/indicator/reports",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 100,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $json_kirim,
  CURLOPT_HTTPHEADER => array(
	"Content-Type: application/json"
  ),
));


$response = curl_exec($curl);
$err = curl_error($curl);
// echo $response;
// die();
curl_close($curl);

// insert tbelogistikkemkes, untuk memonitpring laporan jika belum kirim tidak bisa buat sbbk
mysqli_query($koneksi, "DELETE FROM `tbelogistikkemkes` WHERE `Bulan`='$_POST[bln]' AND `Tahun`='$_POST[thn]' AND `Status`='indikator'");
$strelog = "INSERT INTO `tbelogistikkemkes`(`Bulan`, `Tahun`, `Status`) 
VALUES ('$_POST[bln]','$_POST[thn]','indikator')";
mysqli_query($koneksi,$strelog);

if ($err) {
  echo "cURL Error #:" . $err;
} else {

	$data = json_decode($response, true);
	// echo $response;
	// die();
	//header('location:index.php?page=elog_indikator_kirim');
		echo "<script>";
		echo "alert('Data berhasil dikirim');";
		echo "document.location.href='index.php?page=elog_indikator_kirim';";
		echo "</script>";
}				
	
?>
<?php
	session_start();
	$nama_admin = $_SESSION['nama_petugas'];
	function bln_sebelumnya($b,$t,$x){
		$bln = $b - $x;
		if($bln == 0){
			$blns = 12;
		}else if($bln == -1){
			$blns = 11;
		}else if($bln == -2){
			$blns = 10;
		}else{
			$blns = $bln;
		}
		if(strlen($blns) == 1){
			$x = "0".$blns;
		}else{
			$x = $blns;
		}
		return $x;
	}
	
	function thn_sebelumnya($b,$t,$x){
		$bln = $b - $x;
		if($bln <= 0){
			$thn = $t - 1;
		}else{
			$thn = $t;
		}
		return $thn;
	}	
	include "config/koneksi.php";
	$thn = $_POST['thn'];
	$bln = $_POST['bln'];

	$query = mysqli_query($koneksi,"SELECT * FROM `ref_obatketersediaan` order by nama_obj");
	$no = 0;
	foreach($query as $ti){
	$no = $no + 1;
		if($thn == date('Y') and $bln == date('m')){
			// tbgfkstok
			$str_gfk = "SELECT SUM(Stok) as `jstok`, KodeBarang FROM `tbgfkstok` WHERE `KodeBarangElog` = '$ti[kode_obat]'";
			$dt_gfk = mysqli_fetch_array(mysqli_query($koneksi,$str_gfk));
			$stok = intval($dt_gfk['jstok']);
			
			//penggunaan obat 3bulan sebelumnya
			$str_gfk3 = "SELECT SUM(Jumlah) as `Jumlah` FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE a.KodeBarang = '$dt_gfk[KodeBarang]' AND (MONTH(b.TanggalPengeluaran) = '".$bln."' AND YEAR(b.TanggalPengeluaran) = '".$thn."')";
			$dt_gfk3 = mysqli_fetch_array(mysqli_query($koneksi,$str_gfk3));
			$stok_jml_pengunaan = intval($dt_gfk3['Jumlah']);
		}else{
			// get kodebarang
			$kobt = $ti['kode_obat'];
			$dtgfk = mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbgfkstok` WHERE `KodeBarangElog` = '$ti[kode_obat]'");
			
			if(mysqli_num_rows($dtgfk) > 0){
				// get stok	
				$nn = $ti['kode_obat'];
				while($dt_gfk = mysqli_fetch_array($dtgfk)){
					// tbgfkstok				
					$str_gfk3 = "SELECT SUM(StokAwalSistem) as `jstok` FROM `tbstokbulanandinas` WHERE `KodeBarang`='$dt_gfk[KodeBarang]' AND Bulan = '".$bln."' and Tahun = '".$thn."'";
					$dt_gfk3 = mysqli_fetch_array(mysqli_query($koneksi,$str_gfk3));
					$stok_arr[$kobt][] = intval($dt_gfk3['jstok']);				
					
					// penggunaan obat 3bulan sebelumnya
					$str_gfk3 = "SELECT SUM(StokAwalSistem) as `jstok` FROM `tbstokbulanandinas` WHERE `KodeBarang`='$dt_gfk[KodeBarang]' AND ((Bulan = '".bln_sebelumnya($bln,$thn,1)."' and Tahun = '".thn_sebelumnya($bln,$thn,1)."') or (Bulan = '".bln_sebelumnya($bln,$thn,2)."' and Tahun = '".thn_sebelumnya($bln,$thn,2)."') or (Bulan = '".bln_sebelumnya($bln,$thn,3)."' and Tahun = '".thn_sebelumnya($bln,$thn,3)."'))";
					$dt_gfk3 = mysqli_fetch_array(mysqli_query($koneksi,$str_gfk3));				
					$stok_jml_pengunaan_arr[$kobt][] = intval($dt_gfk3['jstok']);			
				}
				
				if($stok_arr != null){
					$stok = array_sum($stok_arr[$kobt]);
					// echo $stok."<br/>";
				}else{
					$stok = 0;
				}
				if($stok_jml_pengunaan_arr != null){
					$stok_jml_pengunaan = array_sum($stok_jml_pengunaan_arr[$kobt]);
				}else{
					$stok_jml_pengunaan = 0;
				}
			}else{
				$stok = 0;
				$stok_jml_pengunaan = 0;
			}
		}
		$curmont = $stok + $stok_jml_pengunaan;
		
		$arr['kode_obat'] = $ti['kode_obat'];
		$arr['nama_obj'] = $ti['nama_obj'];
		$arr['jml_stok'] = $stok;
		$arr['jml_penggunaan'] = $stok_jml_pengunaan;
		$arr['cur_mont'] = $curmont;
		$arr['kelompok'] = $ti['kelompok'];
		$arr_j[] = $arr;
			
		// kirim ke tabel lokal
		// $query_insert[] = "('$thn','$bln','$arr[kode_obat]','$arr[nama_obj]','$arr[jml_stok]')"; 		
	}
	// $str_insert = "INSERT INTO `tbgfkketersediaan`(`thn`,`bln`,`kode_obat`, `nama_obj`, `jml_stok`) VALUES ".implode(",",$query_insert).";";	
	// $insert = mysqli_query($koneksi,$str_insert);
			
		
$periode = $bln ."_".$thn;

$kota = $_SESSION['kota'];
$kodepuskesmas = $_SESSION['kodepuskesmas'];

if ($kota == "KABUPATEN BANDUNG"){
	$usernameelog = "tomi4812@yahoo.co.id";
	$passelog = base64_encode(87654321);
}elseif($kota == "KABUPATEN BOGOR"){
	$usernameelog = "tomi4812i@gmail.com";
	$passelog = base64_encode(12345678);
}

if(strlen($kodepuskesmas) > 4){
	$area = substr($kodepuskesmas,1,4);
}else{
	$area = $kodepuskesmas;
}
	
$json_kirim = '
	{
        "dataEnvironment":{
          "token":{"username":"'.$usernameelog.'", "password":"'.$passelog.'", "area":"'.$area.'"},
          "content": {
              "area": "'.$area.'",					
              "periode": "'.$periode.'",				
              "type": "Ketersediaan Obat",		
              "user": "'.$nama_admin.'",				
              "table":'.json_encode($arr_j).'
            }
        }
    }';

	// echo $json_kirim;
	// die();

		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://bankdataelog.kemkes.go.id/api/availibility/reports",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 10,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $json_kirim,
		  CURLOPT_HTTPHEADER => array(
			"Content-Type: application/json"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		
			$data = json_decode($response, true);
			// echo $response;
			// die();
			//header('location:index.php?page=elog_indikator_kirim');
				echo "<script>";
				echo "alert('Data berhasil dikirim');";
				echo "document.location.href='index.php?page=elog_ketersediaan_kirim&bln=$bln&thn=$thn';";
				echo "</script>";
		}				
			
		?>
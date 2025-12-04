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
		// ref_obat_lplpo
		$str_lplpo = "SELECT * FROM `ref_obat_lplpo` WHERE `IdKetersediaan` = '$ti[kode_obat]'";
		$dt_lplpo = mysqli_fetch_array(mysqli_query($koneksi, $str_lplpo));
		$kodebarang = $dt_lplpo['KodeBarang'];			
		$namabarang = $dt_lplpo['NamaBarang'];
		$idketersediaan = $dt_lplpo['IdKetersediaan'];

		// jika direfobatlplp0 gak ada
		if($idketersediaan = $dt_lplpo['IdKetersediaan'] != ''){
			$idketersediaan = $dt_lplpo['IdKetersediaan'];
		}else{
			$idketersediaan = '999'; 
		}
				
		// tahap1, menentukan stok awal stok / saldo awal
		if (substr($namabarang,0,6) == "Vaksin" or substr($namabarang,0,6) == "VAKSIN"){
			$str_stokawal = "SELECT SUM(Stok) AS Stok FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kodebarang'";
			$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
			if ($dt_stokawal_dtl['Stok'] = null OR $dt_stokawal_dtl['Stok'] = ''){
				$stokawal = $dt_stokawal_dtl['Stok'];
			}else{
				$stokawal = '0';
			}
		}else{
			$str_stokawal = "SELECT SUM(Stok) AS Stok FROM `tbgfkstok` WHERE `KodeBarangElog`='$idketersediaan'";
			$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
			// echo $str_stokawal."stokawal :".$dt_stokawal_dtl['Stok'];
			if ($dt_stokawal_dtl['Stok'] != null){
				$stokawal = $dt_stokawal_dtl['Stok'];
			}else{
				$stokawal = '0';
			}
		}
		// echo $idketersediaan." ".$stokawal;
		// echo $str_stokawal;
		// die();
		
		// tahap1.1 cek jika 0, hitung jumlah penerimaan bulan sebelumnya
		if (substr($namabarang,0,6) == "Vaksin" or substr($namabarang,0,6) == "VAKSIN"){
			$str_terima_lalu = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah 
			FROM `tbgfk_vaksin_penerimaandetail` a JOIN `tbgfk_vaksin_penerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
			WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.TanggalPenerimaan) = '$thn' AND MONTH(b.TanggalPenerimaan) = '$bln'";		
		}else{
			$str_terima_lalu = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah 
			FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
			WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.TanggalPenerimaan) = '$thn' AND MONTH(b.TanggalPenerimaan) = '$bln'";
			// echo $str_terima_lalu;
			// die();
		}

		$dt_terima_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_terima_lalu));									
		if ($dt_terima_lalu['Jumlah'] != null || $dt_terima_lalu['Jumlah'] != 0){
			$penerimaan_lalu = $dt_terima_lalu['Jumlah'];
		}else{
			$penerimaan_lalu = '0';
		}
		
		$stokawal_total = $stokawal + $penerimaan_lalu;	
		// echo $idketersediaan." ".$stokawal_total;		
		
		// tahap2, penggunaan obat
		if (substr($namabarang,0,6) == "Vaksin" or substr($namabarang,0,6) == "VAKSIN"){
			$str_gfk3 = "SELECT SUM(Jumlah) as `Jumlah` FROM `tbgfk_vaksin_pengeluarandetail` a JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE a.KodeBarang = '$kodebarang' AND (MONTH(b.TanggalPengeluaran) = '".$bln."' AND YEAR(b.TanggalPengeluaran) = '".$thn."')";
		}else{
			$str_gfk3 = "SELECT SUM(Jumlah) as `Jumlah` FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE a.KodeBarang = '$kodebarang' AND (MONTH(b.TanggalPengeluaran) = '".$bln."' AND YEAR(b.TanggalPengeluaran) = '".$thn."')";	
		}
		$dt_gfk3 = mysqli_fetch_array(mysqli_query($koneksi,$str_gfk3));
		$stok_jml_pengunaan = intval($dt_gfk3['Jumlah']);
		
		$curmont = $stokawal_total + $stok_jml_pengunaan;
		
		// tahap3, kirim ke elog
		$arr['kode_obat'] = $ti['kode_obat'];
		$arr['nama_obj'] = $ti['nama_obj'];
		$arr['jml_stok'] = $stokawal_total;
		$arr['jml_penggunaan'] = $stok_jml_pengunaan;
		$arr['cur_mont'] = $curmont;
		$arr['kelompok'] = $ti['kelompok'];
		$arr_j[] = $arr;
			
		// kirim ke tabel lokal
		// $query_insert[] = "('$thn','$bln','$arr[kode_obat]','$arr[nama_obj]','$arr[jml_stok]')"; 		
	}
	// $str_insert = "INSERT INTO `tbgfkketersediaan`(`thn`,`bln`,`kode_obat`, `nama_obj`, `jml_stok`) VALUES ".implode(",",$query_insert).";";	
	// $insert = mysqli_query($koneksi,$str_insert);
	// die();		
		
$periode = $bln ."_".$thn;

$kota = $_SESSION['kota'];
$kodepuskesmas = $_SESSION['kodepuskesmas'];

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
		  CURLOPT_URL => "https://bankdataelog.kemkes.go.id/api/availibility/reports",
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
		
		// insert tbelogistikkemkes, untuk memonitpring laporan jika belum kirim tidak bisa buat sbbk
		mysqli_query($koneksi, "DELETE FROM `tbelogistikkemkes` WHERE `Bulan`='$_POST[bln]' AND `Tahun`='$_POST[thn]' AND `Status`='ketersediaan'");
		$strelog = "INSERT INTO `tbelogistikkemkes`(`Bulan`, `Tahun`, `Status`) 
		VALUES ('$_POST[bln]','$_POST[thn]','ketersediaan')";
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
			echo "document.location.href='index.php?page=elog_ketersediaan_kirim&bln=$bln&thn=$thn';";
			echo "</script>";
		}	
		?>
		
		
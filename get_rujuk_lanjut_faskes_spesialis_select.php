<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	include "config/helper_bpjs_v4.php";	

	$kdsubspesialis = $_POST['kdsubspesialis'];
	// echo $kdsubspesialis;
	$kdsarana = $_POST['kdsarana'];
	$isippk = $_POST['isippk'];
	$tgl = date('d-m-Y',strtotime($_POST['tgl']));
	//echo $tgl;
//	if($_SESSION['koneksi_bpjs'] == 'Stabil'){
	$data_faskes = get_data_referensi_faskes_spesialis($kdsubspesialis,$kdsarana,$tgl);
	 // echo $data_faskes;
	 // die();
	$dtfaskes = json_decode($data_faskes,True);

		$list = $dtfaskes['response']['list'];
		if($list == ""){
			echo "<option>Tidak ada rumah sakit yang sesuai poli</option>";
		}else{

			foreach($list as $ket){
				if($isippk == $ket['kdppk']){
					echo "<option value='".$ket['kdppk']."' SELECTED>".$ket['nmppk']." | ".$ket['kelas']." | ".$ket['jadwal']."</option>";
				}else{
					echo "<option value='".$ket['kdppk']."'>".$ket['nmppk']." | ".$ket['kelas']." | ".$ket['jadwal']."</option>";
				}	
                
				// echo "<tr class='pilihfaskes'>";
				// echo "<td>".$no."</td>";
				// echo "<td class='namappk'>".strtoupper($ket['nmppk'])."</td>";
				// echo "<td align='center'>".$ket['kelas']."</td>";
				// // echo "<td>".$ket['nmkc']."</td>";
				// echo "<td>".$ket['alamatPpk'].", Telp.".$ket['telpPpk']."</td>";
				// echo "<td align='center'>".round($ket['distance'] / 1000 ,2)."KM</td>";
				// echo "<td align='center'>".$ket['jmlRujuk']."</td>";
				// echo "<td align='center'>".$ket['kapasitas']."</td>";
				// echo "<td align='center'>".$ket['persentase']."</td>";
				// echo "<td>".$ket['jadwal']."</td>";
				// echo "<td align='center'><input type='radio' class='pilihradio' name='faskes' value='".$ket['kdppk']."'></td>";
				// echo "</tr>";
			}

	}
//}
?>
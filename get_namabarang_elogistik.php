<?php
include "config/koneksi.php";
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

$keyword = $segments[3];
	$query = mysqli_query($koneksi,"SELECT * FROM `ref_obat_all` WHERE `object_name` LIKE '%$keyword%' ORDER BY `object_name`"); 
	
	$arr['suggestions'][]['value']="<table width='100%' style='table-layout:fixed;'><tr><th width='40%'>Nama Obat</th><th width='15%'>Satuan</th><th width='15%'>Kategori</th><th width='30%'>Produsen</th></tr></table>";
	if(mysqli_num_rows($query) == 0){
		$arr['suggestions'][]['value']="<table width='100%' style='table-layout:fixed;'><tr><td colspan='4'>Obat tidak ditemukan...</td></tr></table>";
	}else{
		while($data = mysqli_fetch_assoc($query))
		{
			$arr['suggestions'][] = array(
				'value'	=> "<table width='100%' style='table-layout:fixed;'><tr><td width='40%'>".$data['object_name']."</td><td width='15%'>".$data['deskripsi']."</td><td width='15%'>".$data['kategori_objek']."</td><td width='30%'>".$data['org_pembuat']."</td></tr></table>",
				'namabarang' => $data['object_name'],
				'kodebarangelog' => $data['id_obat'],
				'produsen' => $data['org_pembuat'],
				'namagenerik' => $data['nama_generik']
			);	
		}
	}
	echo json_encode($arr);
?>	
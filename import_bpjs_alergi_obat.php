<?php
	include "config/koneksi.php";
	include "config/helper_bpjs_v4.php";
    $data = get_alergi_obat();
    $dmedis = json_decode($data,True);
    $list = $dmedis['response']['list'];
    // echo $data;
	// die();

    foreach($list as $ls){
        $kodealergi = $ls['kdAlergi'];
        $namaalergi = $ls['nmAlergi'];        
        $str = "INSERT INTO `tbbpjs_alegi_obat`(`KodeAlergi`,`NamaAlergi`) VALUES ('$kodealergi','$namaalergi')";
        // cek dulu
		$cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbbpjs_alegi_obat` WHERE `KodeAlergi` = '$kodealergi'"));
		if($cek == 0){
			mysqli_query($koneksi, $str);
		}
    }
    setcookie("alert","<div class='alert alert-success'>Data berhasil diupdate...</div>",time()+5);
    header('location:index.php?page=bpjs_alergi_obat');
   
?>
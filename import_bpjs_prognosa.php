<?php
	include "config/koneksi.php";
	include "config/helper_bpjs_v4.php";
    $data = get_prognosa();
    $dmedis = json_decode($data,True);
    $list = $dmedis['response']['list'];
    // echo $data;
	// die();

    foreach($list as $ls){
        $kdPrognosa = $ls['kdPrognosa'];
        $nmPrognosa = $ls['nmPrognosa'];        
        $str = "INSERT INTO `tbbpjs_prognosa`(`kdPrognosa`,`nmPrognosa`) VALUES ('$kdPrognosa','$nmPrognosa')";
        // cek dulu
		$cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbbpjs_prognosa` WHERE `kdPrognosa` = '$kdPrognosa'"));
		if($cek == 0){
			mysqli_query($koneksi, $str);
		}
    }
    setcookie("alert","<div class='alert alert-success'>Data berhasil diupdate...</div>",time()+5);
    header('location:index.php?page=bpjs_prognosa');
   
?>
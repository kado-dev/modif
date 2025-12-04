<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$bulan=date('m');
	$tahun=date('y');
	$sql_cek="SELECT max(NoFaktur)as maxno from tbadm_pendampingan";//WHERE substring(NoFaktur,3,11)='$kodepuskesmas'
	$query_cek=mysqli_query($koneksi,$sql_cek);
	$datareg=mysqli_fetch_array($query_cek);
		$no=substr($datareg['maxno'],-3);
		$no_next=$no+1;
			if(strlen($no_next)==1)
			{
				$no="00".$no_next;
			}
			elseif(strlen($no_next)==2)
			{
				$no="0".$no_next;
			}
			else
			{
				$no=$no_next;
			}
	$nofaktur = "PDPKM".$no;
	
	$tanggalpendampingan = $_POST['tanggalpendampingan'];
	$tglp = explode("-",$tanggalpendampingan);
	$tanggalpendampingan1=$tglp[2]."-".$tglp[1]."-".$tglp[0];
	$puskesmas = strtoupper($_POST['puskesmas']);
	$bersedia = strtoupper($_POST['bersedia']);
	$sdm = strtoupper($_POST['sdm']);
	$komputer = strtoupper($_POST['komputer']);
	$printer = strtoupper($_POST['printer']);
	$internet = strtoupper($_POST['internet']);
	$keterangan = strtoupper($_POST['keterangan']);
		
	//image
	$var_file = $_FILES['image'];
		$nama_file = $var_file['name']; // nama file asli
		$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // proses mengambil extensi file
		$tmp[] = $var_file['tmp_name']; // sumber file
		if($ext != ''){
			$namaimg[] = date('Ymdgis').".".$ext; // proses penamaan file foto	
		}
	$var_file2 = $_FILES['image2'];
		$nama_file2 = $var_file2['name']; // nama file asli
		$ext2 = pathinfo($nama_file2, PATHINFO_EXTENSION); // proses mengambil extensi file
		$tmp[] = $var_file2['tmp_name']; // sumber file
		if($ext2 != ''){
			$namaimg[] = date('Ymdgis')."2.".$ext2; // proses penamaan file foto
		}
		
	$namaimgs = json_encode($namaimg);
	$str = "INSERT INTO `tbadm_pendampingan`(`Tanggal`, `NoFaktur`, `Puskesmas`, `Bersedia`, `Sdm`, `Komputer`, `Printer`, `Internet`, `Keterangan`, `Foto`)
	VALUES ('$tanggalpendampingan1','$nofaktur','$puskesmas','$bersedia','$sdm','$komputer','$printer','$internet','$keterangan','$namaimgs')";
	$query=mysqli_query($koneksi,$str);
	
	
	if($query){	
		$i = 0;
		foreach($namaimg as $nmimg){
			copy($tmp[$i],'image/pendampingan/'.$nmimg);//proses copy	
			$i = $i + 1;
		}
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=adm_pendampingan';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=adm_pendampingan_tambah&faktur=$nofaktur';";
		echo "</script>";
	} 	
?>
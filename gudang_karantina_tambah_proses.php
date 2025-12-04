<?php
	$tahun=date('Y');
	$sql_cek='SELECT max(NoFaktur)as maxno FROM tbgfk_karantina WHERE substring(NoFaktur,8,4)=YEAR(now())';
	$query_cek=mysqli_query($koneksi,$sql_cek);
	$datareg=mysqli_fetch_array($query_cek);
		$no=substr($datareg['maxno'],-5);
		$no_next=$no+1;
			if(strlen($no_next)==1)
			{
				$no="0000".$no_next;
			}
			elseif(strlen($no_next)==2)
			{
				$no="000".$no_next;
			}
			elseif(strlen($no_next)==3)
			{
				$no="00".$no_next;
			}
			elseif(strlen($no_next)==4)
			{
				$no="0".$no_next;
			}
			else
			{
				$no=$no_next;
			}
	$nofaktur="UPT.GK/".$tahun."/".$no;

	//--variabel tbgfkpenerimaan--//						
	$namapegawaisimpan = $_SESSION['nama_petugas'];							
	$jamkarantina = date('G:i:s');								
	$tanggalkarantina = date('Y-m-d', strtotime($_POST['tanggalkarantina']));	
	$statusgudang = $_POST['statusgudang'];
	$statuskarantina = $_POST['statuskarantina'];
	$sts = $_POST['sts'];
	
	if($sts == '1'){
		// ini yang dari dashboard_uptd_obat, cek dulu jika tanggalnya sama maka jgn buat faktur baru
		$tanggalkarantina_sts = date('Y-m-d');
		$cekfaktur = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoFaktur`) AS Jumlah, `NoFaktur`  FROM `tbgfk_karantina` WHERE `TanggalKarantina` = '$tanggalkarantina_sts'"));
		
		if($cekfaktur['Jumlah'] > 0){
			echo "<script>";
			echo "alert('Data berhasil disimpan...');";
			echo "document.location.href='index.php?page=gudang_karantina_lihat&id=$cekfaktur[NoFaktur]';";
			echo "</script>";
			die();
		}else{
			$str_karantina = "INSERT INTO `tbgfk_karantina`(`TanggalKarantina`,`JamKarantina`,`NoFaktur`,`StatusGudang`,`StatusKarantina`,`NamaPegawaiSimpan`)
			VALUES ('$tanggalkarantina_sts','$jamkarantina','$nofaktur','Gudang Besar','Expire','$namapegawaisimpan')";
			$query2 = mysqli_query($koneksi,$str_karantina);
		}	
	}else{
		$str_karantina = "INSERT INTO `tbgfk_karantina`(`TanggalKarantina`,`JamKarantina`,`NoFaktur`,`StatusGudang`,`StatusKarantina`,`NamaPegawaiSimpan`)
		VALUES ('$tanggalkarantina','$jamkarantina','$nofaktur','$statusgudang','$statuskarantina','$namapegawaisimpan')";
		$query1 = mysqli_query($koneksi,$str_karantina);
	}	
	
	if($query2){	
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=gudang_karantina_lihat&id=$nofaktur';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=dashboard';";
		echo "</script>";
	} 

	if($query1){	
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=gudang_karantina';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=gudang_karantina_tambah';";
		echo "</script>";
	} 
?>
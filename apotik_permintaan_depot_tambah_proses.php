<?php
	$tahun=date('Y');
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$sql_cek="SELECT max(NoFaktur)as maxno from tbgudangpkmpengeluaran WHERE substring(NoFaktur,13,4)=YEAR(now()) AND substring(NoFaktur,1,11)='$kodepuskesmas'";
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
	$nofaktur = $kodepuskesmas."/".$tahun."/".$no;

	// variabel tbgfkpenerimaan
	$tanggalpengeluaran = $_POST['tanggalpengeluaran'];	
	$tglp = explode("-",$tanggalpengeluaran);
	$tanggalpengeluaran1=$tglp[2]."-".$tglp[1]."-".$tglp[0];
	$jam = date('G:i:s');	
	$statuspengeluaran = $_POST['statuspengeluaran'];	
	$penerima = $_POST['penerima'];				
	$sumberanggaran = $_POST['sumberanggaran'];				
	$keterangan = $_POST['keterangan'];	
	$namapegawaisimpan = $_SESSION['nama_petugas'];		
	
	$str = "INSERT INTO `tbgudangpkmpengeluaran`(`TanggalPengeluaran`,`JamPengeluaran`,`NoFaktur`,`KodePuskesmas`,`StatusPengeluaran`,`Penerima`,`SumberAnggaran`,`Keterangan`,`NamaPegawaiSimpan`)
	VALUES ('$tanggalpengeluaran1','$jam','$nofaktur','$kodepuskesmas','$statuspengeluaran','$penerima','$sumberanggaran','$keterangan','$namapegawaisimpan')";
	$query=mysqli_query($koneksi,$str);

	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=apotik_permintaan_depot_lihat&nf=$nofaktur';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=apotik_permintaan_depot_tambah';";
		echo "</script>";
	} 
?>
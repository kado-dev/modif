<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);

	$array_stskeluarga = array(
		'KEPALA KELUARGA'=>'00',
		'ISTRI'=>'01',
		'ANAK KANDUNG'=>'02',
		'ANAK 1'=>'02',
		'ANAK 2'=>'03',
		'ANAK 3'=>'04',
		'ANAK 4'=>'05',
		'ANAK 5'=>'06',
		'ANAK 6'=>'07',
		'ANAK 7'=>'08',
		'ANAK 8'=>'09',
		'ANAK 9'=>'10',
		'ANAK 10'=>'11',
		'ANAK 11'=>'12',
		'ANAK 12'=>'13',
		'ANAK 13'=>'14',
		'ANAK 14'=>'15',
		'ANAK 15'=>'16',
		'ANAK 16'=>'17',
		'ANAK 17'=>'18',
		'ANAK 18'=>'19',
		'ANAK 19'=>'20',
		'BAPAK'=>'90',
		'IBU'=>'91',
		'KAKEK'=>'92',
		'NENEK'=>'93',
		'CUCU'=>'94',
		'MENANTU'=>'95',
		'MERTUA'=>'96',
		'SAUDARA KANDUNG'=>'97',
		'KEPONAKAN'=>'98',
		'PONDOK PESANTREN'=>'99',
		'ANAK SEKOLAH'=>'100'
	);

	$nocm = $_POST['nocm'];
	$stskeluarga = $_POST['stskeluarga'];
	$desa = $_POST['desa'];
	$kota = $_POST['kota'];
	$noindex = $_POST['noindex'];

	

	//cari kodedesa
	$getdesa = mysqli_query($koneksi,"SELECT KodeRM, Kelurahan FROM tbkelurahan WHERE Kelurahan = '$desa' AND KodePuskesmas = '$kodepuskesmas'");
	if(mysqli_num_rows($getdesa) > 0){
		$dtdesa = mysqli_fetch_assoc($getdesa);
		$koderm_desa = $dtdesa['KodeRM'];
	}else{
		$koderm_desa = '09';

		//cek daerah
		$getdaerah = mysqli_query($koneksi,"SELECT KodeRM, Kota FROM tbkelurahan WHERE Kota = '$kota' AND KodePuskesmas = '$kodepuskesmas'");
		if(mysqli_num_rows($getdaerah) == 0){
			$koderm_desa = '99';
		}
	}

	$cekstatusrm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstatusnomerrm`"));
	
	if($cekstatusrm['StatusIndex'] == "Y"){
	$desa = $_POST['desa'];
		$newrm = $koderm_desa."/".substr($noindex, -5)."/".$array_stskeluarga[$stskeluarga];
	}else{
		// NoIndex
		$tahun=date('Y');
		$sql_newrm = "SELECT max(SUBSTRING(NewNoRM,4,5)) as maxno FROM `$tbpasien`";
		$query_newrm = mysqli_query($koneksi, $sql_newrm);
		$data_newrm = mysqli_fetch_array($query_newrm);
		$no1=substr($data_newrm['maxno'],-5);
		
		$no_next1=$no1+1;
			if(strlen($no_next1)==1)
			{
				$no2="0000".$no_next1;
			}
			elseif(strlen($no_next1)==2)
			{
				$no2="000".$no_next1;
			}
			elseif(strlen($no_next1)==3)
			{
				$no2="00".$no_next1;
			}
			elseif(strlen($no_next1)==4)
			{
				$no2="0".$no_next1;
			}
			else
			{
				$no2=$no_next1;
			}
		$noindexnewrm = $no2;
		$newrm = $koderm_desa."/".$noindexnewrm."/".$array_stskeluarga[$stskeluarga];
	}

	//update tbpasien
	mysqli_query($koneksi,"UPDATE `$tbpasien` SET NewNoRM = '$newrm' WHERE NoCM = '$nocm'");
	echo $newrm;
?>
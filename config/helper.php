<?php

	function alert_notify($sts,$ket){
		$_SESSION['alert']=$sts;
		$_SESSION['alert_ket']=$ket;
	}

	function alert_swal($sts,$ket){
		$_SESSION['alert_swal']=$sts;
		$_SESSION['alert_swal_ket']=$ket;
	}
	
	function ubah_format_tgl($date){
		$pecah = explode("-",$date);
		$hasil = $pecah[2]."-".$pecah[1]."-".$pecah[0];
		return $hasil;
	}

	function hitung_menit($awal,$akhir){
		$awals  = date_create($awal);
		$akhirs = date_create($akhir);
		$diff  = date_diff( $awals, $akhirs);

		if($diff->i > 0){
			$h = $diff->i." menit";
		}else{
			$h = $diff->s." detik";
		}
		return $h;
	}

	function asal_pasien_text($kode){
		switch($kode){
			case '1':
				$asalpasien = "KELAS BALITA";
			break;
			case '2':			
				$asalpasien = "KELAS IBU";
			break;
			case '3':
				$asalpasien = "PENYULUHAN KELOMPOK";
			break;
			case '4':
				$asalpasien = "PENYULUHAN KELUARGA";
			break;
			case '5':
				$asalpasien = "POLINDES";
			break;
			case '6':
				$asalpasien = "POSBINDU";
			break;
			case '7':
				$asalpasien = "POSKESDES";
			break;
			case '8':
				$asalpasien = "POSYANDU";
			break;
			case '9':
				$asalpasien = "PUSKEL";
			break;
			case '10':
				$asalpasien = "PUSKESMAS";
			break;
			case '11':
				$asalpasien = "PUSTU";
			break;
			case '12':
				$asalpasien = "STBM";
			break;
			case '13':
				$asalpasien = "PERKESMAS";
			break;
			default:
				$asalpasien = "-";		
			break;
		}
		return $asalpasien;
	}

	function alert_popup($text){
		$div = "<div class='alertpopup' style='background:red;width:350px;height:100px;position:fixed;top:0;left:0;bottom:0;right:0;margin:auto;padding:10px;'>".$text."</div>";
		return $div;
	}

	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " Belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "Minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}

function hari_ini_val($hari){
	
	switch($hari){
		case 'Sun':
			$hari_ini = "Minggu";
		break;
		case 'Mon':			
			$hari_ini = "Senin";
		break;
		case 'Tue':
			$hari_ini = "Selasa";
		break;
		case 'Wed':
			$hari_ini = "Rabu";
		break;
		case 'Thu':
			$hari_ini = "Kamis";
		break;
		case 'Fri':
			$hari_ini = "Jum'at";
		break;
		case 'Sat':
			$hari_ini = "Sabtu";
		break;
		default:
			$hari_ini = "-";		
		break;
	}
	return "<b>" . $hari_ini . "</b>";
}

function hari_ini(){
	$hari = date ("D");
 
	switch($hari){
		case 'Sun':
			$hari_ini = "Minggu";
		break;
		case 'Mon':			
			$hari_ini = "Senin";
		break;
		case 'Tue':
			$hari_ini = "Selasa";
		break;
		case 'Wed':
			$hari_ini = "Rabu";
		break;
		case 'Thu':
			$hari_ini = "Kamis";
		break;
		case 'Fri':
			$hari_ini = "Jum'at";
		break;
		case 'Sat':
			$hari_ini = "Sabtu";
		break;
		default:
			$hari_ini = "-";		
		break;
	}
	return $hari_ini;
}

function reporting_sukses($text)
{
	$html = '<div class="alert alert-success" style="clear:both; font-size:12px;">';
	$html .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';	
    $html .= $text;
    $html .= '</div>';
	$set = setcookie("report",$html, time()+4);
	return $set;
}

function reporting_error($text)
{
	$html = '<div class="alert alert-danger" style="clear:both;font-size:12px;">';
	$html .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';	
    $html .= $text;
    $html .= '</div>';
	$set = setcookie("report",$html, time()+4);
	return $set;
}

function redirect($lokasi){
	$html = "<script>";
	$html .= "document.location.href='".$lokasi."';";
	$html .= "</script>";
	echo $html;	
}

function umur_tahun($tanggallahir){
	$tglla=explode("-",$tanggallahir);
	$tgl_lahir=$tglla[2];
	$bln_lahir=$tglla[1];
	$thn_lahir=$tglla[0];

	$tanggal_today = date('d');
	$bulan_today=date('m');
	$tahun_today = date('Y');

	$harilahir=gregoriantojd($bln_lahir,$tgl_lahir,$thn_lahir); //menghitung jumlah hari sejak tahun 0 masehi
	$hariini=gregoriantojd($bulan_today,$tanggal_today,$tahun_today);//menghitung jumlah hari sejak tahun 0 masehi

	$umur=$hariini-$harilahir;//menghitung selisih hari antara tanggal sekarang dengan tanggal lahir

	$tahun=$umur/365;//menghitung usia tahun
	$sisa=$umur%365;//sisa pembagian dari tahun untuk menghitung bulan
	$bulan=$sisa/30;//menghitung usia bulan
	$hari=$sisa%30;//menghitung sisa hari	

	$tahun_umur = floor($tahun); // floor pembulatan
	$bulan_umur = floor($bulan);
	$hari_umur = $hari;
	return $tahun_umur;
}

function umur_bulan($tanggallahir){
	$tglla=explode("-",$tanggallahir);
	$tgl_lahir=$tglla[2];
	$bln_lahir=$tglla[1];
	$thn_lahir=$tglla[0];

	$tanggal_today = date('d');
	$bulan_today=date('m');
	$tahun_today = date('Y');

	$harilahir=gregoriantojd($bln_lahir,$tgl_lahir,$thn_lahir); //menghitung jumlah hari sejak tahun 0 masehi
	$hariini=gregoriantojd($bulan_today,$tanggal_today,$tahun_today);//menghitung jumlah hari sejak tahun 0 masehi

	$umur=$hariini-$harilahir;//menghitung selisih hari antara tanggal sekarang dengan tanggal lahir

	$tahun=$umur/365;//menghitung usia tahun
	$sisa=$umur%365;//sisa pembagian dari tahun untuk menghitung bulan
	$bulan=$sisa/30;//menghitung usia bulan
	$hari=$sisa%30;//menghitung sisa hari	

	$tahun_umur = floor($tahun); // floor pembulatan
	$bulan_umur = floor($bulan);
	$hari_umur = $hari;
	return $bulan_umur;
}

function umur_hari($tanggallahir){
	$tglla=explode("-",$tanggallahir);
	$tgl_lahir=$tglla[2];
	$bln_lahir=$tglla[1];
	$thn_lahir=$tglla[0];

	$tanggal_today = date('d');
	$bulan_today=date('m');
	$tahun_today = date('Y');

	$harilahir=gregoriantojd($bln_lahir,$tgl_lahir,$thn_lahir); //menghitung jumlah hari sejak tahun 0 masehi
	$hariini=gregoriantojd($bulan_today,$tanggal_today,$tahun_today);//menghitung jumlah hari sejak tahun 0 masehi

	$umur=$hariini-$harilahir;//menghitung selisih hari antara tanggal sekarang dengan tanggal lahir

	$tahun=$umur/365;//menghitung usia tahun
	$sisa=$umur%365;//sisa pembagian dari tahun untuk menghitung bulan
	$bulan=$sisa/30;//menghitung usia bulan
	$hari=$sisa%30;//menghitung sisa hari	

	$tahun_umur = floor($tahun); // floor pembulatan
	$bulan_umur = floor($bulan);
	$hari_umur = $hari;
	return $hari_umur;
}

function perkiraan_umur($tanggallahir){
	$tglla=explode("-",$tanggallahir);
	$tgl_lahir=$tglla[2];
	$bln_lahir=$tglla[1];
	$thn_lahir=$tglla[0];
	$tanggal_today = date('d');
	$bulan_today=date('m');
	$tahun_today = date('Y');

	$harilahir=GregorianToJD($bln_lahir, $tgl_lahir, $thn_lahir); //menghitung jumlah hari sejak tahun 0 masehi
	$hariini=GregorianToJD($bulan_today, $tanggal_today, $tahun_today);//menghitung jumlah hari sejak tahun 0 masehi

	$umur=$hariini-$harilahir;//menghitung selisih hari antara tanggal sekarang dengan tanggal lahir

	$tahun=$umur/365;//menghitung usia tahun
	$sisa=$umur%365;//sisa pembagian dari tahun untuk menghitung bulan
	$bulan=$sisa/30;//menghitung usia bulan
	$hari=$sisa%30;//menghitung sisa hari	

	$tahun_umur = floor($tahun); // floor pembulatan
	$bulan_umur = floor($bulan);
	$hari_umur = $hari;
	return $tahun_umur." Th ".$bulan_umur." Bl ".$hari_umur." Hr";
}

function nama_bulan($i){
	$nama = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	$x = $i - 1;
	return $nama[$x];
}

function nama_bulan_singkat($i){
	$nama = array('JAN','FEB','MAR','APR','MEI','JUN','JUL','AGUS','SEP','OKT','NOV','DES');
	$x = $i - 1;
	return $nama[$x];
}

function tgl_singkat($date){
	$p = explode("-",$date);

	$nama = array('JAN','FEB','MAR','APR','MEI','JUN','JUL','AGUS','SEP','OKT','NOV','DES');
	$x = $p[1] - 1;
	return $nama[$x]." ".$p[0];
}

function tgl_lengkap($date){
	$p = explode("-",$date);

	$nama = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	$x = $p[1] - 1;
	return $p[2]." ".$nama[$x]." ".$p[0];
}

function tgl_slas($date){
	$p = explode("-",$date);
	
	return $p[2]."/".$p[1]."/".$p[0];
}	

function rupiah($angka)
{
	$jadi = number_format($angka,0,',','.');
	return $jadi;
}		

function rupiahd($angka)
{
	$jadi = number_format($angka,2,',','.');
	return $jadi;
}		


function tgl_format($date){
	$p = explode("-",$date);
	
	return $p[2]."-".$p[1]."-".$p[0];
}

function tgl_format2($date){
	$p = explode("-",$date);
	
	return $p[0]."-".$p[1]."-".$p[2];
}

function selecteds($x,$y){
	if($x == $y){
		echo "SELECTED";
	}
}

function hitungSelisihHari($tanggal1, $tanggal2) {
    $date1 = new DateTime($tanggal1);
    $date2 = new DateTime($tanggal2);
    $selisih = $date1->diff($date2);
    return $selisih->days; // hasilnya integer jumlah hari (tanpa tanda)
}
?>

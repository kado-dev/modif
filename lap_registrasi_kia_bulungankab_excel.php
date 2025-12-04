<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kodepuskesmas = $_GET['kd'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kecamatan = $_SESSION['kecamatan'];
	$kelurahan = $_SESSION['kelurahan'];
	$alamat = $_SESSION['alamat'];
	$tanggal = date('Y-m-d');
	$tbpasienrj = 'tbpasienrj_'.$bulan;
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;	
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Register_Poli_KIA (".$hariini.").xls");
	if(isset($bulan) and isset($tahun)){
?>

<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:-15px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
	display: none;
}
.printheader h4{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printbody{
	margin-left:-10px;
	margin-right:-10px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	display:none;
	margin-top:10px;
}
.bawahtabel{
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font10{
	font-size:10px;
	font-family: "Tahoma";
}
.font11{
	font-size:11px;
	font-family: "Tahoma";
}
.font12{
	font-size:12px;
	font-family: "Tahoma";
}
.font14{
	font-size:14px;
	font-family: "Tahoma";
}


@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}
	.printbody{
		display:block;
	}
	.atastabel{
		display:block;
	}
	.bawahtabel{
		display:block;
	}
}
</style>

<div class="printheader">
	<span class="font14" style="margin:1px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
	<span class="font14" style="margin:1px;"><b>DINAS KESEHATAN</b></span><br>
	<span class="font14" style="margin:1px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font10" style="margin:1px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER PASIEN POLI KIA</b></span><br>
	<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
	<br/>
</div>

<div class=" atastabel font11">
	<div style="float:left; width:100%; margin-top:0px;">
		<table style="font-size:12px; width:300px;">
			<tr>
				<td colspan=2>Kode Puskesmas</td>
				<td><?php echo ": ".$kodepuskesmas;?></td>
			</tr>
			<tr>
				<td colspan=2>Puskesmas</td>
				<td><?php echo ": ".$namapuskesmas;?></td>
			</tr>
			<tr>
				<td colspan=2>Kelurahan/Desa</td>
				<td><?php echo ": ".$kelurahan?></td>
			</tr>
			<tr>
				<td colspan=2>Kecamatan</td>
				<td><?php echo ": ".$kecamatan;?></td>
			</tr>
		</table>
	</div>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<span>Jumlah Kasus Baru</span>
		<table class="table table-condensed" border="1">
			<thead style="font-size:10px;">
				<tr>
					<th rowspan="4" width="2%">No.</th>
					<th colspan="5">Register</th>
					<th colspan="16">Pemeriksaan</th>
					<th rowspan="4" class="rotate"><div>Konseling</div></th>
					<th rowspan="4" class="rotate"><div>Status Imunisasi TT</div></th>
					<th colspan="3">Pelayanan</th>
					<th colspan="8">Laboratorium</th>
					<th rowspan="4" class="rotate"><div>Riwayat SC</div></th>
				</tr>
				<tr>
					<th rowspan="3" width="6%">Tgl</th><!--Register-->
					<th rowspan="3" width="5%">No.RM</th>
					<th rowspan="3" width="7%">Nama Ibu</th>
					<th rowspan="3" class="rotate"><div>Usia Kehamilan</div></th>
					<th rowspan="3" class="rotate"><div>Trimester</div></th>
					<th colspan="11">Ibu</th><!--Pemeriksaan-->
					<th colspan="5">Bayi</th>
					<th rowspan="2" class="rotate"><div>Injeksi TT</div></th><!--Pelayanan-->
					<th rowspan="2" class="rotate"><div>Catat Buku KIA</div></th>
					<th rowspan="2" class="rotate"><div>Fe (tab/btl)</div></th>
					<th rowspan="2" class="rotate"><div>K1 HB (gr/dl)</div></th><!--Laboratorium-->
					<th rowspan="2" class="rotate"><div>Protein Urin (+/-)</div></th>
					<th rowspan="2" class="rotate"><div>Gula Darah (+/-)</div></th>
					<th rowspan="2" class="rotate"><div>K4 HB (gr/dl)</div></th>
					<th rowspan="2" class="rotate"><div>Sifilis (+/-)</div></th>
					<th rowspan="2" class="rotate"><div>HBsAg (+/-)</div></th>
					<th rowspan="2" class="rotate"><div>Golongan Darah</div></th>
					<th rowspan="2" class="rotate"><div>HIV</div></th>
				</tr>
				<tr>
					<th rowspan="2" class="rotate"><p class="kolom2">Kunjungan</th>
					<th rowspan="2" class="rotate"><p class="kolom2">G/P/A</th>
					<th rowspan="2" class="rotate"><p class="kolom2">Hpht</th>
					<th rowspan="2" width="10%">Anamnesis</th><!--Ibu-->
					<th rowspan="2" class="rotate"><p class="kolom2">BB</p></th>
					<th rowspan="2" class="rotate"><p class="kolom2">TB</p></th>
					<th rowspan="2" class="rotate"><p class="kolom2">TD</p></th>
					<th rowspan="2" class="rotate"><p class="kolom2">TFU</p></th>
					<th rowspan="2" class="rotate"><p class="kolom2">Lila</p></th>
					<th rowspan="2" class="rotate"><p class="kolom2">S.Gizi</p></th>
					<th rowspan="2" class="rotate"><p class="kolom2">R.Patella</p></th>
					<th rowspan="2" class="rotate"><p class="kolom2">DJJ</p></th><!--Bayi-->
					<th rowspan="2" class="rotate"><p class="kolom2">THD</p></th>
					<th rowspan="2" class="rotate"><p class="kolom2">TBJ</p></th>
					<th rowspan="2" class="rotate"><p class="kolom2">Jml.Janin</p></th>
					<th rowspan="2" class="rotate"><p class="kolom2">Presentasi</p></th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<?php
				$waktu = "YEAR(TanggalPeriksa) = '$tahun'";
				$tbpasien = 'tbpasien_'.$tahun;
				$tbpasienrj = 'tbpasienrj_'.$bulan;
				$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
				$tbpasienperpegawai='tbpasienperpegawai_'.$bulan;
				
				if ($bulan == 'semua'){
					if($kelurahan == 'semua'){
						$str = "SELECT * FROM `$tbpolikia` WHERE SUBSTRING(NoPemeriksaan,1,11) = '$kodepuskesmas' AND YEAR(TanggalPeriksa) = '$tahun'";
						$str2 = $str."ORDER BY `NamaPasien`, TanggalPeriksa DESC";
					}else{
						$str = "SELECT * FROM `$tbpolikia` a 
						JOIN `$tbkk` b ON a.NoIndex = b.NoIndex 
						WHERE SUBSTRING(a.NoPemeriksaan,1,11) = '$kodepuskesmas' AND b.Kelurahan = '$kelurahan' AND YEAR(TanggalPeriksa) = '$tahun'";
						$str2 = $str."ORDER BY a.`NamaPasien`, a.TanggalPeriksa DESC";
					}
				}else{
					if($kelurahan == 'semua'){
						$str = "SELECT * FROM `$tbpolikia` WHERE SUBSTRING(NoPemeriksaan,1,11) = '$kodepuskesmas' AND YEAR(TanggalPeriksa) = '$tahun' AND MONTH(TanggalPeriksa)='$bulan'";
						$str2 = $str."ORDER BY `NamaPasien`, TanggalPeriksa DESC";
					}else{
						$str = "SELECT * FROM `$tbpolikia` a 
						JOIN `$tbkk` b ON a.NoIndex = b.NoIndex 
						WHERE SUBSTRING(a.NoPemeriksaan,1,11) = '$kodepuskesmas' AND b.Kelurahan = '$kelurahan' AND YEAR(TanggalPeriksa) = '$tahun' AND MONTH(TanggalPeriksa)='$bulan'";
						$str2 = $str."ORDER BY a.`NamaPasien`, a.TanggalPeriksa DESC";
					}
				}
			
				$no = 0;
				$nocmtmp = '';
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noregistrasi = $data['NoRegistrasi'];
					$noindex = $data['NoIndex'];
				
					// tbpasienperpegawai
					$tbpasienperpegawai='tbpasienperpegawai_'.$bulan;
					$dt_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` where NoRegistrasi='$noregistrasi'"));
					if($dt_pegawai['NamaPegawai1']!=''){
						$pemeriksa = $dt_pegawai['NamaPegawai1'];
					}else{
						$pemeriksa = $dt_pegawai['NamaPegawai2'];
					}
					
					//tbpasienrj
					$str_rj = "SELECT JenisKelamin,UmurTahun,UmurBulan,PoliPertama,StatusPulang
					FROM `$tbpasienrj` 
					WHERE `NoRegistrasi` = '$noregistrasi'";
					$query_rj = mysqli_query($koneksi,$str_rj);
					$data_rj = mysqli_fetch_assoc($query_rj);
					$kelamin = $data_rj['JenisKelamin'];
					
					// tbkk
					$str_kk = "SELECT `Alamat`, `RT`, `RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					// echo $str_kk;
					$query_kk = mysqli_query($koneksi,$str_kk);
					$data_kk = mysqli_fetch_assoc($query_kk);
					
					// tbdiagnosapasien
					$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
					$query_diagnosapsn = mysqli_query($koneksi, $str_diagnosapsn);
					
					// cek umur kelamin
					if ($kelamin == 'L'){
						$umur_l = $data_rj['UmurTahun']."th ".$data_rj['UmurBulan']."Bl";
						$umur_p = "-";
					}else{
						$umur_l = "-";
						$umur_p = $data_rj['UmurTahun']."th ".$data_rj['UmurBulan']."Bl";
					}
				
					if($alamat != null){
						$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];
					}else{
						$alamat = "-";
					}
					
					//cek rujukan
					$rujukan = $data_rj['StatusPulang'];
					if ($rujukan == 3){
						$berobatjalan = '<span class="fa fa-check"></span>';
						$rujuklanjut = '-';
					}else if($rujukan == 4){
						$rujuklanjut = '<span class="fa fa-check"></span>';
						$berobatjalan = '-';
					}
								
					//cek diagnosa pasien				
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$array_data[$data['NoRegistrasi']][] = $data_diagnosapsn['KodeDiagnosa'];
					}
					if ($array_data[$data['NoRegistrasi']] != ''){
						$data_dgs = implode(",", $array_data[$data['NoRegistrasi']]);
					}else{
						$data_dgs ="";
					}
					// echo $data_dgs;
					
			
					if(strlen($data['NoRM']) == 20){
						$normpasien = substr($data['NoRM'],14,7); // ambil 6 digit dari belakang
					}else if(strlen($data['NoRM']) == 19){
						$normpasien = substr($data['NoRM'],13,9); // ambil 6 digit dari belakang
					}else if(strlen($data['NoRM']) == 17){
						$normpasien = substr($data['NoRM'],11,6); // ambil 6 digit dari belakang
					}else if(strlen($data['NoRM']) == 7){
						$normpasien = substr($data['NoRM'],1,6);
					}					
					
					//get jml norm
					$rowspan_rm = mysqli_num_rows(mysqli_query($koneksi,$str." AND b.NoCM = '".$data['NoCM']."'"));
					
				?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $data['TanggalPeriksa'];?></td>
						<?php
						if($nocmtmp != $data['NoCM']){
						?>
						<td rowspan="<?php echo $rowspan_rm;?>"><?php echo $normpasien;?></td>
						<td rowspan="<?php echo $rowspan_rm;?>"><?php echo $data['NamaPasien'];?></td>
						<?php
						}
						?>
						<td><?php echo $data['UsiaKehamilan'];?></td>
						<td><?php echo $data['Trimester'];?></td>
						<td><?php echo $data['KunjunganKehamilan'];?></td>
						<td><?php echo $data['Gravida']."/".$data['Partus']."/".$data['Abortus'];?></td>
						<td><?php echo $data['Hpht'];?></td>
						<td><?php echo $data['Anamnesa'];?></td>
						<td><?php echo $data['BeratBadan'];?></td>
						<td><?php echo $data['TinggiBadan'];?></td>
						<td><?php echo $data['Sistole']."/".$data['Diastole'];?></td>
						<td><?php echo $data['Tfu'];?></td>
						<td><?php echo $data['Lila'];?></td>
						<td><?php echo $data['StatusGizi'];?></td>
						<td><?php echo $data['RefleksPatella'];?></td>
						<td><?php echo $data['Djj'];?></td>
						<td><?php echo $data['KepThd'];?></td>
						<td><?php echo $data['Tbj'];?></td>
						<td><?php echo $data['JumlahJanin'];?></td>
						<td><?php echo $data['Presentasi'];?></td>
						<td></td>
						<td></td>
						<td><?php echo $data['InjeksiTT'];?></td>
						<td><?php echo $data['CatatBukuKia'];?></td>
						<td><?php echo $data['FeTab'];?></td>
						<td><?php echo $data['K1Hb'];?></td>
						<td><?php echo $data['ProteinUrin'];?></td>
						<td><?php echo $data['GulaDarah'];?></td>
						<td><?php echo $data['K4Hb'];?></td>
						<td><?php echo $data['Sifilis'];?></td>
						<td><?php echo $data['Hbsag'];?></td>
						<td><?php echo $data['GolonganDarah'];?></td>
						<td><?php echo $data['Hiv'];?></td>
						<td><?php echo $data['RiwayatSc'];?></td>
					</tr>
				<?php
					$nocmtmp = $data['NoCM'];
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
}
?>
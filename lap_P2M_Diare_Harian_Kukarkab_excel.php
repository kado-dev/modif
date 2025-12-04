<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$tanggal = date('Y-m-d');
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;	
	// filterdata
	$opsiform = $_GET['opsiform'];
	$keydate = $_GET['keydate'];
	$kasus = $_GET['kasus'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Register_Diare (".$namapuskesmas." ".$hariini.").xls");
	if(isset($bulan) and isset($tahun)){
?>
<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
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
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
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
	<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b>DINAS KESEHATAN</b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTRASI DIARE</b></h4>
	<p style="margin:1px;">Periode Laporan: 
		<?php 
		if($opsiform == 'tanggal'){
			echo date('d-m-Y', strtotime($keydate1)) ." s/d ".date('d-m-Y', strtotime($keydate2));
		}else{
			echo nama_bulan($bulan)." ".$tahun;
		}
		?>
	</p>
</div>
<br/>
<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:10px;">
				<tr style="border:1px dashed #000;">
					<th rowspan="2" width="2%">No.</th>
					<th rowspan="2">Tgl.Reg</th>
					<th rowspan="2">No.RM</th>
					<th rowspan="2">NIK</th>
					<th rowspan="2" width="12%">Nama Pasien</th>
					<th rowspan="2">Umur</th>
					<th rowspan="2">Kelamin</th>
					<th rowspan="2">Desa/Kel</th>
					<th rowspan="2">Alamat</th>
					<th rowspan="2">Pelayanan</th>
					<th rowspan="2" width="10%">Derajat Dehidrasi</th>
					<th colspan="3">Jumlah Pemakaian</th>
					<th rowspan="2">Antibiotik</th>
					<th rowspan="2" width="15%">Therapy</th>
					<th rowspan="2">Status</th>
					<th rowspan="2">Konseling</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th>Oralit</th>
					<th>Infus</th>
					<th>Zinc</th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<?php
				if($kasus == "semua"){
					$qkasus = " ";
				}else{
					$qkasus = " AND `Kasus`='$kasus'";
				}
				
				$str = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa)='$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `KodeDiagnosa`='A09'".$qkasus; 
				$str2 = $str;
								
				$query_diare = mysqli_query($koneksi,$str2);
				while($data_diare = mysqli_fetch_assoc($query_diare)){
					$no = $no + 1;
					$nocm = $data_diare['NoCM'];
					$noregistrasi = $data_diare['NoRegistrasi'];
					$tanggaldiagnosa = $data_diare['TanggalDiagnosa'];
											
					// tbpasien
					$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpasien` WHERE `NoCM` = '$nocm'"));
					$nik = $datapasien['Nik'];
					$norm = $datapasien['NoRM'];
					$namapasien = $datapasien['NamaPasien'];
					$desa = $datapasien['Kelurahan'];
					$alamat = $datapasien['Alamat'];
					
					// tbpasienrj
					$datapasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'"));
					$kunjungan = $datapasienrj['StatusKunjungan'];
					$jeniskelamin = $datapasienrj['JenisKelamin'];
					$umurtahun = $datapasienrj['UmurTahun'];
					$umurbulan= $datapasienrj['UmurBulan'];
					$pelayanan= $datapasienrj['PoliPertama'];
					
					if ($umurtahun != '0'){
						$umur = $umurtahun."Th";
					}else{
						$umur = $umurbulan."Bl";
					}
					
					// derajat dehidrasi
					if ($pelayanan == 'POLI MTBS'){
						$dt_mtbs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolimtbs` WHERE `NoPemeriksaan`='$noregistrasi'"));
						$dehidrasi = $dt_mtbs['KlasifikasiDiare'];
					}else{
						$dehidrasi = "-";
					}
					
					// tbresepdetail
					$oralit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.jumlahobat FROM `tbresepdetail` a
							JOIN `tbgudangpkmstok` b ON a.KodeBarang = b.KodeBarang
							WHERE a.`NoResep`='$noregistrasi' AND `NamaBarang` like '%ORALIT%'"));
							
							if($oralit != 0){
								$oralit_jml = $oralit['jumlahobat'];
							}else{
								$oralit_jml = "-";
							}
					
					$infus = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.jumlahobat FROM `tbresepdetail` a
							JOIN `tbgudangpkmstok` b ON a.KodeBarang = b.KodeBarang
							WHERE a.`NoResep`='$noregistrasi' AND `NamaBarang` like '%RINGER LAKTAT%'"));
							
							if($infus != 0){
								$infus_jml = $infus['jumlahobat'];
							}else{
								$infus_jml = "-";
							}
							
					$zinc = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.jumlahobat FROM `tbresepdetail` a
							JOIN `tbgudangpkmstok` b ON a.KodeBarang = b.KodeBarang
							WHERE a.`NoResep`='$noregistrasi' AND `NamaBarang` like '%ZINC%'"));
							
							if($zinc != 0){
								$zinc_jml = $zinc['jumlahobat'];
							}else{
								$zinc_jml = "-";
							}
							
					// therapy
					$str_therapy = "SELECT * FROM `tbresepdetail` a JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang WHERE a.`NoResep` = '$noregistrasi'";
					$query_therapy = mysqli_query($koneksi, $str_therapy);
					while($dt_therapy = mysqli_fetch_array($query_therapy)){
						$array_therapy[$no][] = $dt_therapy['NamaBarang']." (".$dt_therapy['jumlahobat'].")";
					}
					if ($array_therapy[$no] != ''){
						$data_trp = implode(",", $array_therapy[$no]);
					}else{
						$data_trp ="";
					}
										
				?>
					<tr style="border:1px dashed #000;">
						<td><?php echo $no;?></td>
						<td><?php echo $tanggaldiagnosa;?></td>
						<td><?php echo substr($norm,-8);?></td>
						<td><?php echo "NIK.".$nik;?></td>
						<td><?php echo $namapasien;?></td>
						<td><?php echo $umur;?></td>
						<td><?php echo $jeniskelamin;?></td>
						<td><?php echo $desa;?></td>
						<td><?php echo $alamat;?></td>
						<td><?php echo $pelayanan;?></td>
						<td><?php echo strtoupper($dehidrasi);?></td>
						<td><?php echo $oralit_jml;?></td><!--oralit-->
						<td><?php echo $infus_jml;?></td><!--infus-->
						<td><?php echo $zinc_jml;?></td><!--zinc-->
						<td>Tidak</td><!--antibiotik-->
						<td><?php echo $data_trp;?></td>
						<td>Hidup</td>
						<td>Ya</td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
}
?>
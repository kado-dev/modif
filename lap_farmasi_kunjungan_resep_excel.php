<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	include_once('config/helper_pasienrj.php');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Pelayanan Resep (".$keydate1." s/d ".$keydate2.").xls");
	if(isset($keydate1)){
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
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN PELAYANAN RESEP</b></span><br>
	<span class="font12" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y',strtotime($keydate1))." s/d ".date('d-m-Y',strtotime($keydate2));?></span>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
		<thead>
			<tr>
				<th width="4%">NO.</th>
				<th width="8%">TGL.KUNJUNGAN</th>
				<th width="15%">NAMA PASIEN</th>
				<th width="6%">UMUR</th>
				<th width="20%">ALAMAT</th>
				<th width="10%">JAMINAN</th>
				<th width="10%">PELAYANAN</th>
				<th width="10%">DIAGNOSA</th>
				<th width="20%">THERAPY</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$str = "SELECT * FROM `$tbresep` WHERE TanggalResep BETWEEN '$keydate1' AND '$keydate2'";
			$str2 = $str."ORDER BY `TanggalResep` DESC";				
			// echo $str2;
			
			$no = 0;
			$query = mysqli_query($koneksi,$str2);					
			while($data = mysqli_fetch_assoc($query)){
				$no = $no + 1;
				$noresep = $data['NoResep'];
				$noindex = $data['NoIndex'];
				$umur_thn = $data['UmurTahun'];
				$umur_bln = $data['UmurBulan'];
				$jaminan = $data['StatusBayar'];
				$pelayanan = $data['Pelayanan'];
				
				// tbkk
				$str_kk = "SELECT `NamaKK`, `Alamat`, `RT`, `RW`, `Kelurahan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
				$query_kk = mysqli_query($koneksi,$str_kk);
				$data_kk = mysqli_fetch_assoc($query_kk);
				if($alamat != null || $alamat != '' || $alamat != '-'){
					$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW']."<br/>DS.".$data_kk['Kelurahan'];
				}else{
					$alamat = "-";
				}
				
				// cek diagnosa pasien
				$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noresep'";
				$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
				while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
					$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
					$array_data[$no][] = "<b>".$data_diagnosapsn['KodeDiagnosa']."</b> ".$dtdiagnosa['Diagnosa'];
				}
				if ($array_data[$no] != ''){
					$data_dgs = implode("<br/>", $array_data[$no]);
				}else{
					$data_dgs ="";
				}
										
				// tbresepdetail						
				$str_resepdtl = "SELECT KodeBarang FROM `$tbresepdetail` WHERE `NoResep` = '$noresep'";
				$query_resepdtl = mysqli_query($koneksi,$str_resepdtl);
				while($data_resepdtl = mysqli_fetch_array($query_resepdtl)){
					$kodebarang = $data_resepdtl['KodeBarang'];
					
					// tbgfkstok
					$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'"));
					$array_data_resep[$no][] = $dtgfk['NamaBarang'];
				}
				if ($array_data_resep[$no] != ''){
					$data_rsp = implode("<br/>", $array_data_resep[$no]);
				}else{
					$data_rsp ="";
				}
				// echo $data_rsp;
			
			?>
				<tr style="border:1px dashed #000;">
					<td align="center"><?php echo $no;?></td>
					<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalResep']));?></td>
					<td align="left">
						<?php 
							echo "<b>".strtoupper($data['NamaPasien']."</b><br/>".
							strtoupper($data_kk['NamaKK'])."<br/>".
							substr($noindex, -10));
						?>
					</td>
					<td align="center">
						<?php 
							if($umur_thn == '0'){
								echo $umur_bln."Bl";
							}else{
								echo $umur_thn."Th";
							}	
						?>
					</td>
					<td align="left"><?php echo strtoupper($alamat);?></td>
					<td align="center"><?php echo $jaminan;?></td>
					<td align="center"><?php echo $pelayanan;?></td>
					<td align="center"><?php echo $data_dgs;?></td>
					<td align="left"><?php echo $data_rsp;?></td>
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
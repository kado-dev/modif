<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	include_once('config/helper_pasienrj.php');
	$hariini = date('d-m-Y');
	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];
	$key = $_GET['key'];
	echo "tanggal : ".$tgl1;
	$statusdilayani = $_GET['statusdilayani'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Pelayanan_Resep (".$hariini.").xls");
	if(isset($tgl1)){
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
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN PELAYANAN RESEP</b></h4>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
		<thead>
			<tr>
				<th width="4%">NO.</th>
				<th width="10%">TGL.RESEP</th>
				<th width="8%">NO.RESEP</th>
				<th width="8%">NO.INDEX</th>
				<th width="20%">NAMA PASIEN</th>
				<th width="6%">UMUR</th>
				<th width="12%">PELAYANAN</th>
				<th width="10%">JAMINAN</th>
				<th width="8%">STATUS</th>
				<th width="10%">DIAGNOSA</th>
				<th width="10%">THERAPY</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if($statusdilayani == ''){
				if($kota == 'KABUPATEN BOGOR'){
					$statusdilayani = 'SUDAH';
				}else{
					$statusdilayani = 'BELUM';
				}								
			}
						
			if($key !=''){
				$strcari = " (`NamaPasien` Like '%$key%' OR `NoResep` Like '%$key%') AND ";
			}else{
				$strcari = " ";
			}
			
			if($tgl1 != ""){
				$tglawal = $tgl1;
				$tglakhir = $tgl2;
			}else{
				$tglawal = date('Y-m-d');
				$tglakhir = date('Y-m-d');
			}
			
			if($statusdilayani != 'SEMUA'){
				$statusdilayanis = " `Status`='$statusdilayani'";
			}else{
				$statusdilayanis = " ";
			}
			
			if($loketobat == 'semua'){
				$loketobats = "";
			}elseif($loketobat == 'LOKET OBAT'){
				$loketobats = " AND Pelayanan <> 'POLI LANSIA'";
			}elseif($loketobat == 'POLI LANSIA'){
				$loketobats = " AND Pelayanan = 'POLI LANSIA'";
			}

			$str = "SELECT * FROM `$tbresep` WHERE date(TanggalResep) BETWEEN '$tglawal' AND '$tglakhir' AND".$strcari.$statusdilayanis." GROUP BY NamaPasien, Pelayanan";
			$str2 = $str." ORDER BY IdResep ASC";
			// echo $str2;
						
			$query = mysqli_query($koneksi,$str2);
			$jmldata = mysqli_num_rows($query);
			while($data = mysqli_fetch_assoc($query)){
				$no = $no + 1;
				$idpasienrj = $data['IdPasienrj'];
				$noindex = $data['NoIndex'];
				$noresep = $data['NoResep'];
				if(strlen($noindex) == 24){
					$noindex2 = substr($data['NoIndex'],14);
				}else{
					$noindex2 = $data['NoIndex'];
				}
			?>
			
				<tr>
					<td align="center"><?php echo $no;?></td>
					<td align="center"><?php echo date('Y-m-d', strtotime($data['TanggalResep']));?></td>
					<td align="center"><?php echo substr($noresep,-10);?></td>
					<td align="center"><?php echo $noindex2;?></td>
					<td align="left" class="namakk"><?php echo $data['NamaPasien'];?></td>
					<td align="right">
						<?php 
							if($data['UmurTahun'] == '0'){
								echo $data['UmurBulan']." Bl";
							}else{
								echo $data['UmurTahun']." Th";
							}	
						?>
					</td>
					<td align="left" class="pelayanan"><?php echo $data['Pelayanan'];?></td>
					<td align="center"><?php echo $data['StatusBayar'];?></td>
					<td align="center"><?php echo $data['Status'];?></td>	
					<td align="center">
					<?php 
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
						
						echo $data_dgs;
					?>
					</td>	
					<td align="left">
						<?php
						// tbresepdetail						
						$strresep = "SELECT `KodeBarang` FROM `$tbresepdetail` WHERE `IdPasienrj`='$idpasienrj' GROUP BY NoResep, KodeBarang";
						
						$query_resepdtl = mysqli_query($koneksi, $strresep);
						while($data_resepdtl = mysqli_fetch_array($query_resepdtl)){
							$kodebarang = $data_resepdtl['KodeBarang'];
							
							//tbgfkstok
							$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'"));
							$array_data2[$no][] = $dtgfk['NamaBarang'];
						}
						if ($array_data2[$no] != ''){
							$data_rsp = implode(",", $array_data2[$no]);
						}else{
							$data_rsp ="";
						}
						echo $data_rsp;
						?>
					</td>	
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
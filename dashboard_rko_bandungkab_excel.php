<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	
	$tahun = $_GET['tahun'];
	if($tahun != ''){
		$tahun = $_GET['tahun'];
	}else{
		$tahun = date('Y');
	}	
		
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=RKO PUSKESMAS (".$tahun.").xls");
	if(isset($tahun)){
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
	font-size:24px;
	font-family: "Roboto Condensed", Arial, sans-serif;
}
.printheader p{
	font-size:24px;
	font-family: "Roboto Condensed", Arial, sans-serif;
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
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>RKO PUSKESMAS</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $tahun;?></p>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
    <table class="table-judul-form" border="1" width="100%">
		<thead>
			<tr>
				<th width='5%'>NO.</td>
				<th width='10%'>KODE</td>
				<th width='35%'>PUSKESMAS</td>
				<th width='30%'>APOTEKER</td>
				<th width='10%'>TAHUN</td>
				<th width='10%'>STATUS RKO</td>
			</tr>
		</thead>						
		<tbody>
			<?php
			$tahunrko = date('Y');	
			$hariini = date('Y-m-d');
			$no = 0;
			$str_rko = "SELECT * FROM tbpuskesmas 
			WHERE (Namapuskesmas != 'UPTD FARMASI' AND Namapuskesmas != 'DINAS KESEHATAN' AND `Kota`='$kota') ORDER BY NamaPuskesmas";
			$query_rko = mysqli_query($koneksi,$str_rko);
			while($data_rko = mysqli_fetch_assoc($query_rko)){
				$no = $no + 1;
			?>
				<tr>
					<td align = "right"><?php echo $no;?></td>
					<td align = "center"><?php echo $data_rko['KodePuskesmas'];?></td>
					<td><?php echo $data_rko['NamaPuskesmas'];?></td>
					<td>
						<?php
							// data apoteker										
							$dtapoteker = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPegawai` FROM `tbpegawai` WHERE `status` = 'APOTEKER' AND `KodePuskesmas`='$data_rko[KodePuskesmas]'"));
							echo $dtapoteker['NamaPegawai'];
						?>
					</td>
					<td align = "center">
						<?php 
							if($_GET['tahun'] != ''){
								echo $_GET['tahun'];
							}else{												
								echo $tahunrko;
							}	
						?>
					</td>
					<td align="center">
						<?php 
							if($_GET['tahun'] != ''){
								$tahunrko = $_GET['tahun'];
							}else{												
								$tahunrko = $tahunrko;
							}	
							$dtrko = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS JumlahItem FROM `tbrkobandungkab` WHERE `KodePuskesmas` = '$data_rko[KodePuskesmas]' and (StokAwal <> '' OR PemakaianRata <> '') and `Tahun`='$tahunrko';"));
							if($dtrko['JumlahItem'] > 50){
						?>		
							<!--<a href="?page=lap_farmasi_rko_dinkes&kodepuskesmas=<?php echo $data_rko['KodePuskesmas'];?>&tahun=<?php echo $tahunrko;?>&sumberanggaran=<?php echo "APBD KAB/KOTA";?>" target="_blank" class="btn btn-sm btn-success">Sudah</a>-->
						<?php
							}else{
						?>
							<a href="?page=lap_farmasi_rko_dinkes&kodepuskesmas=<?php echo $data_rko['KodePuskesmas'];?>&tahun=<?php echo $tahunrko;?>&sumberanggaran=<?php echo "APBD KAB/KOTA";?>" target="_blank" class="btn btn-sm btn-danger">Belum</a>
						<?php		
							}	
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
<?php
	include "otoritas.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$tanggal = date('Y-m-d');
?>
<style>
.printheader{
	margin-top:-30px;
	margin-left:px;
	margin-right:0px;
	text-align:center;
}
.printheader h4{
	font-size:12px;
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.printheader p{
	font-size:10px;
}
.printbody{
	margin-left:-15px;
	margin-right:-80px;
	display: none;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.atastabel{
	display:none;
	margin-top:10px;
}
.bawahtabel{
	margin-top:20px;
	margin-bottom:10px;
	margin-left:50px;
	display:none;
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

<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Laporan Wabah (W2)</h1>
		</div>
	</div>
</div>

<!--cari pasien-->
<div class="row noprint">
	<div class="col-xs-12 col-sm-12">
		<div class="search-area well well-sm">
			<div class="search-filter-header bg-primary">
				<h4 class="panel-title"><i class="fa fa-search"></i> Cari Berdasar</h4>
			</div>
			<div class="space-10"></div>
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_P2M_wabah"/>
						<?php
						if($_SESSION['kodepuskesmas'] == '-'){
						?>
							<div class="col-sm-3">
								<SELECT name="kodepuskesmas" class="form-control">
								<option value='semua'>Semua</option>
								<?php
								$kota = $_SESSION['kota'];
								$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `Kota`='$kota' order by `NamaPuskesmas`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
								}
								?>
							
								</SELECT>
							</div>
						<?php
						}
						?>
						<div style = "padding-top:5px; padding-left:30px" class="col-sm-1">
							Periode:
						</div>
						<div class="col-sm-7">
							<div class="tampilformdate">
								<input type="text" name="keydate1" class="form-control datepicker2" style="width:150px;float:left;margin-right:10px;" placeholder = "Tanggal Awal" required> <input type="text" name="keydate2" class="form-control datepicker2" style="width:150px;float:left;margin-right:10px;" placeholder = "Tanggal Akhir" required>
							</div>
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_wabah" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$tgl1 = $_GET['keydate1'];
$tgl2 = $_GET['keydate2'];
$tbdiagnosapasien = 'tbdiagnosapasien_'.date('m', strtotime($tgl1));
if($_SESSION['kodepuskesmas'] == '-'){
	$kdpuskesmas = $_GET['kodepuskesmas'];
	if($kdpuskesmas == 'semua'){
		$semua = " ";
	}else{
		$semua = " AND substring(NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
	}
}else{
	$kdpuskesmas = $_SESSION['kodepuskesmas'];
	$semua = " AND substring(NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
}
if(isset($tgl1) and isset($tgl2)){
?>

<!--data registrasi-->
<div class="printheader">
	<?php
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kdpuskesmas'"));
	$kota1 = $datapuskesmas['Kota'];
	$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` WHERE `Kota` = '$kota1'"));
	?>
		<?php 
		if($kdpuskesmas == 'semua'){
		?>
			<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
			<h4 style="margin:5px;"><b><?php echo $namapuskesmas;?></b></h4>
			<p style="margin:5px;"><?php echo $alamat;?></p>
		<?php
		}else{
		?>
			<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$datapuskesmas['Kota'];?></b></h4>
			<h4 style="margin:5px;"><b><?php echo $datadinas['NamaDinkes'];?></b></h4>
			<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$datapuskesmas['NamaPuskesmas'];?></b></h4>
			<p style="margin:5px;"><?php echo $datapuskesmas['Alamat']?></p>
		<?php	
		}
		?>
		<hr style="margin:3px; border:1px solid #000">
		<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN WABAH (W2)</b></h4>
		<p style="margin:1px;">Periode Laporan: <?php echo $tgl1." s/d ".$tgl2;?></p>
		<br/>
</div>
<div class="table-responsive">
	<table class="table table-condensed">
		<thead style="font-size:10px;">
			<tr style="border:1px dashed #000;">
				<th style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Kode Sms</th>
				<th style="text-align:center;width:3%;vertical-align:middle; border:1px dashed #000; padding:3px;">Kode Diagnosa</th>
				<th style="text-align:center;width:20%;vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Diagnosa</th>
				<th style="text-align:center;width:5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Jumlah Kasus Baru</th>
			</tr>
		</thead>
		<tbody style="font-size:10px;">
			<!--paging-->
			<?php
			error_reporting(0);
			$str = "SELECT * FROM `tbdiagnosaw2`";
			$str2 = $str."order by `KodeSms` ASC";
			$query = mysqli_query($koneksi,$str2);

			while($data = mysqli_fetch_assoc($query)){
			$kds = substr($data['KodeDiagnosa'],0,3);
			
			$kd = mysqli_query($koneksi,"SELECT KodeDiagnosaBPJS from tbdiagnosa where KodeDiagnosa LIKE '$kds%'");
			if(mysqli_num_rows($kd) <= 1){
				$array_diagnosa = $data['KodeDiagnosa'];
				$str_diagnosa = "SELECT count(KodeDiagnosa) AS Jumlah FROM `$tbdiagnosapasien` WHERE (TanggalDiagnosa Between '$tgl1' and '$tgl2')".$semua."AND KodeDiagnosa = '".$array_diagnosa."' AND `Kasus` = 'Baru'";
			}else{
				while($dt2 = mysqli_fetch_assoc($kd)){
					$kdarry[$kds][] = $dt2['KodeDiagnosaBPJS'];
				}
				$array_diagnosa_key = implode("','",$kdarry[$kds]);
				$array_diagnosa = implode(", ",$kdarry[$kds]);
				$str_diagnosa = "SELECT count(KodeDiagnosa) AS Jumlah FROM `$tbdiagnosapasien` WHERE (TanggalDiagnosa Between '$tgl1' and '$tgl2')".$semua."AND KodeDiagnosa IN ('".$array_diagnosa_key."') AND `Kasus` = 'Baru'";
			}
			//$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;??
			
			
			$count = mysqli_fetch_assoc(mysqli_query($koneksi,$str_diagnosa));

			?>
				<tr style="border:1px dashed #000;">
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['KodeSms'];?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $array_diagnosa;?></td>
					<td style="border:1px dashed #000; padding:3px;"><?php echo $data['NamaDiagnosa'];?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $count['Jumlah'];?></td>
				</tr>
			<?php

			}
			?>
		</tbody>
	</table>
</div>
<?php
}
?>

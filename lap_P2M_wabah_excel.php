<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	// get data
	$tgl1 = $_GET['keydate1'];
	$tgl2 = $_GET['keydate2'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_P2M_Wabah(W2) (".$hariini.").xls");
	if(isset($tgl1) and isset($tgl2)){
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
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN WABAH (W2)</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo $tgl1." s/d ".$tgl2;?></p>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px solid #000;">
					<th rowspan="2" width="7%">KODE SMS</th>
					<th rowspan="2" width="8%">KODE DIAGNOSA<br/>ICD X</th>
					<th rowspan="2" width="60%">NAMA DIAGNOSA</th>
					<th colspan="2">JUMLAH KASUS</th>
					<th rowspan="2" width="10%">TOTAL KASUS</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th width="5%">BARU</th>
					<th width="5%">LAMA</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$str = "SELECT * FROM `tbdiagnosaw2`";
				$str2 = $str."ORDER BY `KodeSms` ASC";
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					// kasus baru							
					$str_baru = "SELECT COUNT(KodeDiagnosa) AS Jumlah FROM `$tbdiagnosapasien` WHERE TanggalDiagnosa Between '$tgl1' and '$tgl2' AND (KodeDiagnosa like '%".$data['KodeDiagnosa']."%') AND `Kasus` = 'Baru'";
					$baru = mysqli_fetch_assoc(mysqli_query($koneksi,$str_baru));
					
					// kasus lama
					$str_lama = "SELECT COUNT(KodeDiagnosa) AS Jumlah FROM `$tbdiagnosapasien` WHERE TanggalDiagnosa Between '$tgl1' and '$tgl2' AND (KodeDiagnosa like '%".$data['KodeDiagnosa']."%') AND `Kasus` = 'Lama'";
					$lama = mysqli_fetch_assoc(mysqli_query($koneksi,$str_lama));
					
					// ngecek jika bulannya sama
					$jumlah_baru = $baru['Jumlah'];
					$jumlah_lama = $lama['Jumlah'];
				?>
					<tr style="border:1px solid #000;">
						<td align="center"><?php echo $data['KodeSms'];?></td>
						<td align="center"><?php echo $data['KodeDiagnosa'];?></td>
						<td align="left"><?php echo strtoupper($data['NamaDiagnosa']);?></td>
						<td align="right"><?php echo $jumlah_baru;?></td>
						<td align="right"><?php echo $jumlah_lama;?></td>
						<td align="right"><?php echo $jumlah_baru + $jumlah_lama;?></td>
					</tr>
				<?php
				}
				?>
					<tr style="border:1px solid #000; font-weight: bold;">
						<td></td>
						<td></td>
						<td>JUMLAH KUNJUNGAN PASIEN</td>
						<td colspan="3" align="right">
						<?php 
							$jmlkunjungan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jml FROM `$tbpasienrj` WHERE date(TanggalRegistrasi) BETWEEN '$tgl1' AND '$tgl2'"));
							echo $jmlkunjungan['Jml'];
						?>
						</td>
					</tr>
			</tbody>
		</table>
	</div>
</div>
<?php
	}
?>
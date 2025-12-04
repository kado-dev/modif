<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Pelayanan Informasi Obat (PIO) (".$hariini.").xls");
	if(isset($keydate1) and isset($keydate2)){
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
	display: none;
	
}
.printheader h4{
	font-size:18px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:18px;
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
.font14{
	font-size:14px;
	font-family: "Tahoma";
}

td {
    padding: 5px;
}
.rotate {
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  width: 1.5em;
}
.rotate div {
    -moz-transform: rotate(-90.0deg);  /* FF3.5+ */
    -o-transform: rotate(-90.0deg);  /* Opera 10.5 */
	-webkit-transform: rotate(-90.0deg);  /* Saf3.1+, Chrome */
    filter:  progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083);  /* IE6,IE7 */
    -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)"; /* IE8 */
	margin-left: -5em;
	margin-right: -5em;
	margin-top: -6em;
}
.kolom2{
	-moz-transform: rotate(-90.0deg);  /* FF3.5+ */
    -o-transform: rotate(-90.0deg);  /* Opera 10.5 */
	-webkit-transform: rotate(-90.0deg);  /* Saf3.1+, Chrome */
    filter:  progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083);  /* IE6,IE7 */
    -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)"; /* IE8 */
	margin-left: -5em;
	margin-right: -5em;
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
	<p style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN PELAYANAN INFORMASI OBAT (PIO)</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo $keydate1." s/d ".$keydate2;?></p><br/>
</div>

<div class="atastabel font14">
	<div style="float:left; width:65%; margin-bottom:0px;">
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5 style="margin:5px;">Kode Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".$kodepuskesmas;?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".$namapuskesmas;?></h5 ></td>
			</tr>
		</table>
	</div>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="3%" rowspan="2">NO.</th>
					<th width="12%" rowspan="2">TGL.RESEP</th>
					<th width="15%" rowspan="2">NAMA PASIEN</th>
					<th width="7" rowspan="2">UMUR</th>
					<th width="10%" rowspan="2">PELAYANAN</th>
					<th width="10%" rowspan="2">DIAGNOSA</th>
					<th width="10%" colspan="10" class="rotate">INFORMASI YANG DIBERIKAN</th>
					<th width="3%" colspan="2">PARAF</th>
				</tr>
				<tr style="border:1px solid #000;height:120px">
					<th width="3%"><p class="kolom2">NAMA OBAT</th>
					<th width="3%"><p class="kolom2">SEDIAAN</th>
					<th width="3%"><p class="kolom2">DOSIS</th>
					<th width="3%"><p class="kolom2">CARA PAKAI</th>
					<th width="3%"><p class="kolom2">PENYIMPANAN</th>
					<th width="3%"><p class="kolom2">INDIKASI</th>
					<th width="3%"><p class="kolom2">KONTRAINDIKASI</th>
					<th width="3%"><p class="kolom2">STABILITAS</th>
					<th width="3%"><p class="kolom2">EFEK SAMPING</th>
					<th width="3%"><p class="kolom2">INTERAKSI</th>
					<th width="6%">PETUGAS</th>
					<th width="6%">PASIEN</th>
				</tr>
			</thead>
			<tbody>
				<?php										
				$str = "SELECT * FROM `$tbresep` WHERE date(`TanggalResep`) BETWEEN '$keydate1' AND '$keydate2'";
				$str2 = $str."ORDER BY `TanggalResep` DESC";											
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noresep = $data['NoResep'];
					$noindex = $data['NoIndex'];
					$umur_thn = $data['UmurTahun'];
					$umur_bln = $data['UmurBulan'];
					$jaminan = $data['StatusBayar'];
					$pelayanan = $data['Pelayanan'];
					$data_dgs = $data['Diagnosa'];
					$pio = $data['Pio'];
					$jenis_pio = explode(",", $pio);
					// echo $jenis_pio[0];
					
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TanggalResep'];?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umur_thn."Th ".$umur_bln."Bl";?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo str_replace('POLI','',$pelayanan);?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data_dgs;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Nama Obat',$jenis_pio)){
								echo "Y";
							}
						?>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Sediaan',$jenis_pio)){
								echo "Y";						
							}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Dosis',$jenis_pio)){
								echo "Y";							
							}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Cara Pakai',$jenis_pio)){
								echo "Y";							
							}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Penyimpanan',$jenis_pio)){
								echo "Y";							
							}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Indikasi',$jenis_pio)){
								echo "Y";							
							}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Kontraindikasi',$jenis_pio)){
								echo "Y";							
							}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Stabilitas',$jenis_pio)){
								echo "Y";							
							}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Efek Samping',$jenis_pio)){
								echo "Y";							
							}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Interaksi',$jenis_pio)){
								echo "Y";							
							}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">-</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">-</td>
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
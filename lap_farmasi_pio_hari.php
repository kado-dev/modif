<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
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

<div class="tableborderdiv">
	<div class = "row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul">LEMBAR CHEKLIS PIO</h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_farmasi_pio_hari"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal" required>
						</div>
						<div class="col-xl-2">
							 <input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir" required>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_pio_hari" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="lap_farmasi_pio_hari_excel.php?&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>	
	</div>
	<?php
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	if(isset($keydate1) and isset($keydate2)){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN PELAYANAN INFORMASI OBAT (PIO)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2))?> <?php echo $tahun;?></span>
		<br/>
	</div>

	<div class="atastabel">
		<div style="float:left; width:100%; margin-bottom:10px;">
			<table style="font-size:10px; width:300px;">
				<tr>
					<td style="padding:2px 4px;">Kode Puskesmas</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kodepuskesmas;?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Puskesmas</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $namapuskesmas;?></td>
				</tr>
			</table>
		</div>
	</div><br/>
	
	<!--data registrasi-->
	<div class="row">
		<div class="col-sm-12">
			<table class="table-judul-laporan" width="100%">
				<thead>
					<tr>
						<th width="3%"rowspan="2">NO.</th>
						<th width="12%"rowspan="2">TGL.RESEP</th>
						<th width="15%"rowspan="2">NAMA PASIEN</th>
						<th width="7"rowspan="2">UMUR</th>
						<th width="10%"rowspan="2">PELAYANAN</th>
						<th width="7%"rowspan="2">JML.OBAT</th>
						<th width="10%"rowspan="2">DIAGNOSA</th>
						<th width="10%"colspan="10" class="rotate">INFORMASI YANG DIBERIKAN</th>
						<th width="3%"rowspan="2">KET.</th>
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
					</tr>
				</thead>
				<tbody>
					<?php
					$jumlah_perpage = 50;
						
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}

					$str = "SELECT * FROM `$tbresep` WHERE date(`TanggalResep`) BETWEEN '$keydate1' AND '$keydate2'";
					$str2 = $str."ORDER BY `TanggalResep` DESC  LIMIT $mulai,$jumlah_perpage";											
					$query = mysqli_query($koneksi,$str2);

					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
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
						
						//tbresepdetail
						$dt_detailrsp = mysqli_num_rows(mysqli_query($koneksi, "SELECT `IdResepDetail` FROM `$tbresepdetail` WHERE `NoResep`='$noresep'"));
					?>
						<tr style="border:1px solid #000;">
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TanggalResep'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umur_thn."Th ".$umur_bln."Bl";?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo str_replace('POLI','',$pelayanan);?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $dt_detailrsp;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data_dgs;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php
								if(in_array('Nama Obat',$jenis_pio)){
									echo "<i class='fa fa-check'></i>";
								}
							?>
							<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php
								if(in_array('Sediaan',$jenis_pio)){
									echo "<i class='fa fa-check'></i>";						
								}
							?>
							</td>
							<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php
								if(in_array('Dosis',$jenis_pio)){
									echo "<i class='fa fa-check'></i>";							
								}
							?>
							</td>
							<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php
								if(in_array('Cara Pemakaian',$jenis_pio)){
									echo "<i class='fa fa-check'></i>";							
								}
							?>
							</td>
							<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php
								if(in_array('Penyimpanan',$jenis_pio)){
									echo "<i class='fa fa-check'></i>";							
								}
							?>
							</td>
							<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php
								if(in_array('Indikasi',$jenis_pio)){
									echo "<i class='fa fa-check'></i>";							
								}
							?>
							</td>
							<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php
								if(in_array('Kontra Indikasi',$jenis_pio)){
									echo "<i class='fa fa-check'></i>";							
								}
							?>
							</td>
							<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php
								if(in_array('Stabilitas',$jenis_pio)){
									echo "<i class='fa fa-check'></i>";							
								}
							?>
							</td>
							<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php
								if(in_array('Efek Samping',$jenis_pio)){
									echo "<i class='fa fa-check'></i>";							
								}
							?>
							</td>
							<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php
								if(in_array('Interaksi',$jenis_pio)){
									echo "<i class='fa fa-check'></i>";							
								}
							?>
							</td>
							<td style="text-align:center; border:1px solid #000; padding:3px;">-</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<br/>
	<hr class="noprint">
	<ul class="pagination noprint">
		<?php
			$query2 = mysqli_query($koneksi,$str);
			$jumlah_query = mysqli_num_rows($query2);
			
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = ($jumlah_query / $jumlah_perpage)+1;
			}else{
				$jumlah = $jumlah_query / $jumlah_perpage;
			}
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=lap_farmasi_pio_hari&keydate1=$keydate1&keydate2=$keydate2&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	mysqli_close($koneksi);
	?>
</div>	

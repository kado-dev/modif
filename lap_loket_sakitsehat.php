<?php
	include "otoritas.php";
	$kota = $_SESSION['kota'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$tanggal = date('Y-m-d');
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
			<h1>Laporan Register Kunjungan Pasien</h1>
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
					<input type="hidden" name="page" value="lap_loket_sakitsehat"/>
					<?php
					if($_SESSION['kodepuskesmas'] == '-'){
					?>
						<div class="col-sm-3">
							<select name="kodepuskesmas" class="form-control">
								<option value='semua'>Semua</option>
								<?php
								$kota = $_SESSION['kota'];
								$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `Kota`='$kota' order by `NamaPuskesmas`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
								}
								?>
							</select>
						</div>
					<?php
					}
					?>
					<div class="col-sm-2">
						<select name="bulan" class="form-control">
							<option value="01" <?php if($_GET['bulan'] == '01'){echo "SELECTED";}?>>Januari</option>
							<option value="02" <?php if($_GET['bulan'] == '02'){echo "SELECTED";}?>>Februari</option>
							<option value="03" <?php if($_GET['bulan'] == '03'){echo "SELECTED";}?>>Maret</option>
							<option value="04" <?php if($_GET['bulan'] == '04'){echo "SELECTED";}?>>April</option>
							<option value="05" <?php if($_GET['bulan'] == '05'){echo "SELECTED";}?>>Mei</option>
							<option value="06" <?php if($_GET['bulan'] == '06'){echo "SELECTED";}?>>Juni</option>
							<option value="07" <?php if($_GET['bulan'] == '07'){echo "SELECTED";}?>>Juli</option>
							<option value="08" <?php if($_GET['bulan'] == '08'){echo "SELECTED";}?>>Agustus</option>
							<option value="09" <?php if($_GET['bulan'] == '09'){echo "SELECTED";}?>>September</option>
							<option value="10" <?php if($_GET['bulan'] == '10'){echo "SELECTED";}?>>Oktober</option>
							<option value="11" <?php if($_GET['bulan'] == '11'){echo "SELECTED";}?>>November</option>
							<option value="12" <?php if($_GET['bulan'] == '12'){echo "SELECTED";}?>>Desember</option>
						</select>
					</div>
					<div class="col-sm-1" style ="width:125px">
						<select name="tahun" class="form-control">
							<?php
								for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
								?>
								<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
							<?php }?>
						</select>
					</div>
					<div class="col-sm-2">
						<select name="statuspasien" class="form-control" style="width:150px;">
							<option value="semua" <?php if($_GET['statuspasien'] == 'semua'){echo "SELECTED";}?>>Semua</option>
							<option value="1" <?php if($_GET['statuspasien'] == '1'){echo "SELECTED";}?>>Kunjungan Sakit</option>
							<option value="2" <?php if($_GET['statuspasien'] == '2'){echo "SELECTED";}?>>Kunjungan Sehat</option>
						</select>
					</div>
					<div class="col-sm-3">
						<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
						<a href="?page=lap_loket_sakitsehat" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
						<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						<a href="?page=laporan_pendaftaran" class="btn btn-sm btn-purple"><span class="fa fa-arrow-circle-left"></span></a>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>

<?php
$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];
$statuspasien = $_GET['statuspasien'];
$tbpasienrj = 'tbpasienrj_'.$bulan ;
if($_SESSION['kodepuskesmas'] == '-'){
	$kdpuskesmas = $_GET['kodepuskesmas'];
	if($kdpuskesmas == 'semua'){
		$semua = " ";
	}else{
		$semua = " AND substring(NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
	}
}else{
	$semua = " AND substring(NoRegistrasi,1,11) = '".$kodepuskesmas."' ";
}
if(isset($bulan) and isset($tahun)){
?>

<div class="printheader">
	<?php
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
	$kota1 = $datapuskesmas['Kota'];
	$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` WHERE `Kota` = '$kota1'"));
	?>
	<?php 
	if($kdpuskesmas == 'semua'){
	?>
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
	<?php
	}else{
	?>
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$datapuskesmas['Kota'];?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $datadinas['NamaDinkes'];?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$datapuskesmas['NamaPuskesmas'];?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $datapuskesmas['Alamat']?></span>
	<?php	
	}
	?>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER KUNJUNGAN PASIEN</b></span><br>
	<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
	<br/>
</div>

<div class="atastabel font11">
	<div style="float:left; width:65%; margin-bottom:10px;">
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;">Kode Puskesmas</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo$datapuskesmas['KodePuskesmas'];?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Puskesmas</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo$datapuskesmas['NamaPuskesmas'];?></td>
			</tr>
		</table><p/>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table>
			<tr>
				<td style="padding:2px 4px;">Kelurahan/Desa</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo$datapuskesmas['Kelurahan'];?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Kecamatan</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo$datapuskesmas['Kecamatan'];?></td>
			</tr>
		</table>
	</div>	
</div>

<!--tabel view-->
<div class="row font10">
	<div class="col-sm-12">
		<div class="table-responsive font10">
			<table class="table table-condensed">
				<thead style="font-size:10px;">
					<tr style="border:0.3px dashed #000;">
						<th rowspan="2" style="text-align:center;width:1%;vertical-align:middle; border:0.3px dashed #000; padding:3px;">NO.</th>
						<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:0.3px dashed #000; padding:3px;">TGL</th>
						<th rowspan="2" style="text-align:center;width:5%;vertical-align:middle; border:0.3px dashed #000; padding:3px;">NAMA</th>
						<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:0.3px dashed #000; padding:3px;">NOMOR KARTU</th>
						<th rowspan="2" style="text-align:center;width:1%;vertical-align:middle; border:0.3px dashed #000; padding:3px;">UMUR</th>
						<th rowspan="2" style="text-align:center;width:1%;vertical-align:middle; border:0.3px dashed #000; padding:3px;">PISA</th>
						<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:0.3px dashed #000; padding:3px;">DIAGNOSA</th>
						<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:0.3px dashed #000; padding:3px;">PELAYANAN</th>
						<th colspan="2" style="text-align:center;border:0.3px dashed #000; padding:3px;">DIRUJUK</th>
						<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:0.3px dashed #000; padding:3px;">ASURANSI</th>
						<th rowspan="2" style="text-align:center;width:1%;vertical-align:middle; border:0.3px dashed #000; padding:3px;">TARIF</th>
					</tr>
					<tr style="border:0.3px dashed #000;">
						<th style="text-align:center;width:2%; border:0.3px dashed #000; padding:3px;">YA</th>
						<th style="text-align:center;width:3%; border:0.3px dashed #000; padding:3px;">TIDAK</th>
					</tr>
				</thead>
				<tbody style="font-size:10px;">
					<!--paging-->
					<?php
					$jumlah_perpage = 100;
					
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					if ($statuspasien == 'semua'){
						$str = "select * from `$tbpasienrj` where YEAR(TanggalRegistrasi) = '$tahun'".$semua; //."AND (Asuransi = 'UMUM' or Asuransi = 'GRATIS')"
					}else{
						$str = "select * from `$tbpasienrj` where YEAR(TanggalRegistrasi) = '$tahun'".$semua; //."AND (Asuransi = 'UMUM' or Asuransi = 'GRATIS') and Statuspasien = '$statuspasien'"
					}
					$str2 = $str."order by `TanggalRegistrasi` Desc limit $mulai,$jumlah_perpage";
					// echo var_dump($str);
					
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$noindex = $data['NoIndex'];
						$nocm = $data['NoCM'];
						$asuransi = $data['Asuransi'];
						
						//tbpoli
						if($data['PoliPertama'] == 'POLI UMUM'){
							$strpoli = "SELECT Diagnosa from tbpoliumum where NoPemeriksaan = '$data[NoRegistrasi]'"; 
						}else if($data['PoliPertama'] == 'POLI GIGI'){
							$strpoli = "SELECT Diagnosa from tbpoligigi where NoPemeriksaan = '$data[NoRegistrasi]'"; 
						}else if($data['PoliPertama'] == 'POLI LANSIA'){
							$strpoli = "SELECT Diagnosa from tbpolilansia where NoPemeriksaan = '$data[NoRegistrasi]'"; 
						}else if($data['PoliPertama'] == 'POLI KIA'){
							$strpoli = "SELECT Diagnosa from tbpolikia where NoPemeriksaan = '$data[NoRegistrasi]'"; 
						}else if($data['PoliPertama'] == 'POLI KB'){
							$strpoli = "SELECT Diagnosa from tbpolikb where NoPemeriksaan = '$data[NoRegistrasi]'"; 
						}else{
							$strpoli = "";
						}
						if($strpoli == ""){
							$diagnosa = '-';
						}else{
							if(mysqli_num_rows(mysqli_query($koneksi,$strpoli))==0){
								$diagnosa = '-';
							}else{
								$datapoli = mysqli_fetch_assoc(mysqli_query($koneksi,$strpoli));
								$diag = json_decode($datapoli['Diagnosa']);
								if($diag){
									$diagnosa = implode(", ",$diag);
								}
							}
						}
												
						//cek rujukan
						$rujukan = $data['StatusPulang'];
						if ($rujukan == 3){
							$berobatjalan = '<span class="fa fa-check"></span>';
							$rujuklanjut = '-';
						}else if($rujukan == 4){
							$rujuklanjut = '<span class="fa fa-check"></span>';
							$berobatjalan = '-';
						}
								
						?>
							<tr style="border:0.3px dashed #000;">
								<td style="text-align:right; border:0.3px dashed #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:0.3px dashed #000; padding:3px;"><?php echo $data['TanggalRegistrasi'];?></td>
								<td style="text-align:left; border:0.3px dashed #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
								<td style="text-align:center; border:0.3px dashed #000; padding:3px;"><?php echo $data['nokartu'];?></td>
								<td style="text-align:right; border:0.3px dashed #000; padding:3px;"><?php echo $data['UmurTahun'];?> Th<!--, <?php echo $data['UmurBulan'];?> Bl,  <?php echo $data['UmurHari'];?> Hr--></td>
								<td style="text-align:center; border:0.3px dashed #000; padding:3px;"><?php echo $datapasien['StatusAsuransi'];?></td>
								<td style="text-align:left; border:0.3px dashed #000; padding:3px;"><?php echo $diagnosa;?></td>
								<td style="text-align:left; border:0.3px dashed #000; padding:3px;"><?php echo $data['PoliPertama'];?></td>
								<td style="text-align:center; border:0.3px dashed #000; padding:3px;"><?php echo $rujuklanjut;?></td>
								<td style="text-align:center; border:0.3px dashed #000; padding:3px;"><?php echo $berobatjalan;?></td>
								<td style="text-align:center; border:0.3px dashed #000; padding:3px;"><?php echo $data['Asuransi'];?></td>
								<td style="text-align:right; border:0.3px dashed #000; padding:3px;"><?php echo $data['Tarif'];?></td>		
							</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

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
					echo "<li><a href='?page=lap_loket_sakitsehat&bulan=$bulan&tahun=$tahun&statuspasien=$statuspasien&h=$i'>$i</a></li>";
				}
			}
		}
	?>	
</ul>
<?php
}
?>
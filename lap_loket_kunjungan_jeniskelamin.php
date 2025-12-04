<?php
	include "otoritas.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$alamat = $_SESSION['alamat'];
	$kota = $_SESSION['kota'];
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
			<h1>Kunjungan Pasien (Jenis Kelamin)</h1>
		</div>
	</div>
</div>

<!--cari data-->
<div class="row noprint">
	<div class="col-xs-12 col-sm-12">
		<div class="search-area well well-sm">
			<div class = "row">
				<form role="form">
					<input type="hidden" name="page" value="lap_loket_kunjungan_jeniskelamin"/>
					<div class="col-sm-2 bulanformcari">
						<select name="tahun" class="form-control">
							<?php
								for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
								?>
								<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
							<?php }?>
						</select>
					</div>
					<div class="col-sm-3">
						<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
						<a href="?page=lap_loket_registrasi_kunjungan" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
						<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>
<?php
$tahun = $_GET['tahun'];
if(isset($tahun)){
?>

<div class="printheader">
	<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
	<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
	<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN KUNJUNGAN PASIEN (JENIS KELAMIN)</b></span><br>
	<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
	<br/>
</div>

<div class="atastabel font11">
	<div style="float:left; width:65%; margin-bottom:10px;">
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
		</table><p/>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table>
			<tr>
				<td style="padding:2px 4px;">Kelurahan/Desa</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo $kelurahan;?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Kecamatan</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo $kecamatan;?></td>
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
					<tr style="border:1px dashed #000;">
						<th width="3%" rowspan="3" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
						<th width="10%" rowspan="3" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">Bulan</th>
						<th colspan="4" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">Jumlah Kunjungan</th>
						<th colspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">Jumlah</th>
						<th width="8%" rowspan="3" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">Total</th>
					</tr>
					<tr style="border:1px dashed #000;">
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">Laki-laki</th>
						<th colspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">Perempuan</th>
						<th width="5%" rowspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">Baru</th>
						<th width="5%" rowspan="2" style="text-align:center;border:1px dashed #000; padding:3px;">Lama</th>
					</tr>
					<tr style="border:1px dashed #000;">
						<th width="5%" style="text-align:center;border:1px dashed #000; padding:3px;">Baru</th>
						<th width="5%" style="text-align:center;border:1px dashed #000; padding:3px;">Lama</th>
						<th width="5%" style="text-align:center;border:1px dashed #000; padding:3px;">Baru</th>
						<th width="5%" style="text-align:center;border:1px dashed #000; padding:3px;">Lama</th>
					</tr>
				</thead>
				<tbody style="font-size:10px;">
					<?php
					$jml_l_baru_total = 0;
					$jml_l_lama_total = 0;
					$jml_p_baru_total = 0;
					$jml_p_lama_total = 0;
					$jml_baru_total = 0;
					$jml_lama_total = 0;
					$jml_total = 0;
					
					$str_bulan = "SELECT * FROM `tbbulan` ORDER BY KodeBulan";
					$query_bln = mysqli_query($koneksi, $str_bulan);
					while($dt_bln = mysqli_fetch_assoc($query_bln)){
						$kode_bln = $dt_bln['KodeBulan'];
						$nama_bln = $dt_bln['NamaBulan'];
						$tbpsienrj = 'tbpasienrj_'.$kode_bln;
						if($kodepuskesmas == '-'){
							$semua = " ";
						}else{
							$semua = " AND `KodePuskesmas` = '$_SESSION[kodepuskesmas]'";
						}
						$jml_l_baru = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM $tbpsienrj WHERE JenisKelamin = 'L' AND StatusKunjungan = 'Baru' AND YEAR(TanggalRegistrasi) = '$tahun'"));
						$jml_l_lama =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM $tbpsienrj WHERE JenisKelamin = 'L' AND StatusKunjungan = 'Lama' AND YEAR(TanggalRegistrasi) = '$tahun'"));
						$jml_p_baru = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM $tbpsienrj WHERE JenisKelamin = 'P' AND StatusKunjungan = 'Baru' AND YEAR(TanggalRegistrasi) = '$tahun'"));
						$jml_p_lama =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM $tbpsienrj WHERE JenisKelamin = 'P' AND StatusKunjungan = 'Lama' AND YEAR(TanggalRegistrasi) = '$tahun'"));
						$jml_baru = $jml_l_baru + $jml_p_baru;
						$jml_lama = $jml_l_lama + $jml_p_lama;
						$jml = $jml_baru + $jml_lama;
					?>
						<tr style="border:1px dashed #000;">
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $kode_bln;?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $nama_bln;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($jml_l_baru);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($jml_l_lama);?></td>	
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($jml_p_baru);?></td>		
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($jml_p_lama);?></td>		
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($jml_baru);?></td>		
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($jml_lama);?></td>		
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($jml);?></td>		
						</tr>
					<?php
						$jml_l_baru_total = $jml_l_baru_total + $jml_l_baru;
						$jml_l_lama_total = $jml_l_lama_total + $jml_l_lama;
						$jml_p_baru_total = $jml_p_baru_total + $jml_p_baru;
						$jml_p_lama_total = $jml_p_lama_total + $jml_p_lama;
						$jml_baru_total = $jml_baru_total + $jml_baru;
						$jml_lama_total = $jml_lama_total + $jml_lama;
						$jml_total = $jml_total + $jml;
						}
					?>
						<tr style="border:1px dashed #000;">
							<td colspan="2" style="text-align:center; border:1px dashed #000; padding:3px; font-weight: bold;">Total</td>
							<td style="text-align:right; border:1px dashed #000; padding:3px; font-weight: bold;"><?php echo rupiah($jml_l_baru_total);?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px; font-weight: bold;"><?php echo rupiah($jml_l_lama_total);?></td>	
							<td style="text-align:right; border:1px dashed #000; padding:3px; font-weight: bold;"><?php echo rupiah($jml_p_baru_total);?></td>		
							<td style="text-align:right; border:1px dashed #000; padding:3px; font-weight: bold;"><?php echo rupiah($jml_p_lama_total);?></td>		
							<td style="text-align:right; border:1px dashed #000; padding:3px; font-weight: bold;"><?php echo rupiah($jml_baru_total);?></td>		
							<td style="text-align:right; border:1px dashed #000; padding:3px; font-weight: bold;"><?php echo rupiah($jml_lama_total);?></td>		
							<td style="text-align:right; border:1px dashed #000; padding:3px; font-weight: bold;"><?php echo rupiah($jml_total);?></td>		
						</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
}
?>
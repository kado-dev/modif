<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KUNJUNGAN PASIEN (USIA ANAK & REMAJA)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_kunjungan_anakremaja"/>
						<div class="col-xl-2 bulanformcari">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-10">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_kunjungan_anakremaja" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>

	<?php
	$tahun = $_GET['tahun'];
	if(isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:2px; border:1px solid #000">
		<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN KUNJUNGAN PASIEN (ANAK & REMAJA)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
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
	</div>

	<div class="row font10">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th width="3%" rowspan="3">NO.</th>
							<th width="10%" rowspan="3">BULAN</th>
							<th colspan="2">JUMLAH KUNJUNGAN</th>
							<th rowspan="2" width="10%">TOTAL</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th width="15%">ANAK (0-18TH)</th>
							<th width="15%">REMAJA (10-22TH)</th>
						</tr>
					</thead>
					<tbody style="font-size:12px;">
						<?php
						$jml_anak = 0;
						$jml_remaja = 0;
						$jml = 0;
						$jml_remaja_total = 0;
						$jml_anak_total = 0;
						$jml_total = 0;
						
						$str_bulan = "SELECT * FROM `tbbulan` ORDER BY KodeBulan";
						$query_bln = mysqli_query($koneksi, $str_bulan);
						while($dt_bln = mysqli_fetch_assoc($query_bln)){
							$kode_bln = $dt_bln['KodeBulan'];
							$nama_bln = $dt_bln['NamaBulan'];
							$jml_anak = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kode_bln' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun Between '0' AND '18'"));
							$jml_remaja =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kode_bln' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun Between '10' AND '22'"));
							$jml = $jml_anak + $jml_remaja;
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $kode_bln;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $nama_bln;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($jml_anak);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($jml_remaja);?></td>	
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($jml);?></td>		
							</tr>
						<?php
							$jml_remaja_total = $jml_remaja_total + $jml_remaja;
							$jml_anak_total = $jml_anak_total + $jml_anak;
							$jml_total = $jml_remaja_total + $jml_anak_total;
							}
						?>
							<tr style="border:1px solid #000;">
								<td colspan="2" style="text-align:center; border:1px solid #000; padding:3px; font-weight: bold;">Total</td>
								<td style="text-align:right; border:1px solid #000; padding:3px; font-weight: bold;"><?php echo rupiah($jml_remaja_total);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px; font-weight: bold;"><?php echo rupiah($jml_anak_total);?></td>	
								<td style="text-align:right; border:1px solid #000; padding:3px; font-weight: bold;"><?php echo rupiah($jml_total);?></td>			
							</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>
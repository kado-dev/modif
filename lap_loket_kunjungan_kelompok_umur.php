<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KUNJUNGAN PASIEN (KELOMPOK UMUR)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_kunjungan_kelompok_umur"/>
						<div class="col-xl-2 bulanformcari">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-10">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_kunjungan_kelompok_umur" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_loket_kunjungan_kelompok_umur_excel.php?tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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
		<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN KUNJUNGAN PASIEN (JENIS KELAMIN & KELOMPOK UMUR)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
		<br/>
	</div>

	<div class="row font10">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="3%" rowspan="3">NO.</th>
							<th width="6%" rowspan="3">BULAN</th>
							<th colspan="24">JUMLAH KUNJUNGAN</th>
							<th width="6%" colspan="2" rowspan="2">TOTAL (L/P)</th>
							<th width="5%" rowspan="3">TOTAL</th>
							<th width="15%" colspan="4">JENIS KUNJUNGAN</th>
						</tr>
						<tr>
							<th width="6%" colspan="2">0-7 HR</th>
							<th width="6%" colspan="2">8-31 HR</th>
							<th width="6%" colspan="2"><1 TH</th>
							<th width="6%" colspan="2">1-4 TH</th>
							<th width="6%" colspan="2">5-9 TH</th>
							<th width="6%" colspan="2">10-14 TH</th>
							<th width="6%" colspan="2">15-19 TH</th>
							<th width="6%" colspan="2">20-44 TH</th>
							<th width="6%" colspan="2">45-54 TH</th>
							<th width="6%" colspan="2">55-59 TH</th>
							<th width="6%" colspan="2">60-69 TH</th>
							<th width="6%" colspan="2">>70 TH</th>
							<th width="6%" colspan="2">BARU</th><!--Jenis Kunjungan-->
							<th width="6%" colspan="2">LAMA</th>
						</tr>
						<tr>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--total (l/p)-->
							<th>P</th>
							<th>L</th><!--baru-->
							<th>P</th>
							<th>L</th><!--lama-->
							<th>P</th>
						</tr>
					</thead>
					<tbody style="font-size:12px;">
						<?php		
												
						$arraybulan = array ("01"=>"Januari","02"=>"Februari","03"=>"Maret","04"=>"April","05"=>"Mei","06"=>"Juni","07"=>"Juli","08"=>"Agustus","09"=>"September","10"=>"Oktober","11"=>"November","12"=>"Desember");			
						foreach($arraybulan as $key => $val){
							$no = $no + 1;
							$kodebulan = $key;					
							$bulan = $val;	
							$jml_0_7_hr_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between '0' AND '7' AND `JenisKelamin`='L'"));
							$jml_0_7_hr_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between '0' AND '7' AND `JenisKelamin`='P'"));
							$jml_8_31_hr_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between '8' AND '31' AND `JenisKelamin`='L'"));
							$jml_8_31_hr_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between '8' AND '31' AND `JenisKelamin`='P'"));
							$jml_1_th_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun = '0' AND UmurBulan Between '1' AND '12' AND `JenisKelamin`='L'"));
							$jml_1_th_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun = '0' AND UmurBulan Between '1' AND '12' AND `JenisKelamin`='P'"));
							$jml_1_4_th_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun Between '1' AND '4' AND `JenisKelamin`='L'"));
							$jml_1_4_th_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun Between '1' AND '4' AND `JenisKelamin`='P'"));
							$jml_5_9_th_l =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun Between '5' AND '9' AND `JenisKelamin`='L'"));
							$jml_5_9_th_p =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun Between '5' AND '9' AND `JenisKelamin`='P'"));
							$jml_10_14_th_l =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun Between '10' AND '14' AND `JenisKelamin`='L'"));
							$jml_10_14_th_p =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun Between '10' AND '14' AND `JenisKelamin`='P'"));
							$jml_15_19_th_l =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun Between '15' AND '19' AND `JenisKelamin`='L'"));
							$jml_15_19_th_p =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun Between '15' AND '19' AND `JenisKelamin`='P'"));
							$jml_20_44_th_l =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun Between '20' AND '44' AND `JenisKelamin`='L'"));
							$jml_20_44_th_p =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun Between '20' AND '44' AND `JenisKelamin`='P'"));
							$jml_45_54_th_l =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun Between '45' AND '54' AND `JenisKelamin`='L'"));
							$jml_45_54_th_p =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun Between '45' AND '54' AND `JenisKelamin`='P'"));
							$jml_55_59_th_l =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun Between '55' AND '59' AND `JenisKelamin`='L'"));
							$jml_55_59_th_p =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun Between '55' AND '59' AND `JenisKelamin`='P'"));
							$jml_60_69_th_l =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun Between '60' AND '69' AND `JenisKelamin`='L'"));
							$jml_60_69_th_p =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun Between '60' AND '69' AND `JenisKelamin`='P'"));
							$jml_70_th_l =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun >= '70' AND `JenisKelamin`='L'"));
							$jml_70_th_p =mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND UmurTahun >= '70' AND `JenisKelamin`='P'"));
							$jml_l = $jml_0_7_hr_l + $jml_8_31_hr_l + $jml_1_th_l + $jml_1_4_th_l + $jml_5_9_th_l + $jml_10_14_th_l + $jml_15_19_th_l + $jml_20_44_th_l +
									$jml_45_54_th_l + $jml_55_59_th_l + $jml_60_69_th_l + $jml_70_th_l;
							$jml_p = $jml_0_7_hr_p + $jml_8_31_hr_p + $jml_1_th_p + $jml_1_4_th_p + $jml_5_9_th_p + $jml_10_14_th_p + $jml_15_19_th_p + $jml_20_44_th_p +
									$jml_45_54_th_p +  $jml_55_59_th_p + $jml_60_69_th_p + $jml_70_th_p;		
							$jml = 	$jml_l + $jml_p;	
							
							// jenis kunjungan baru dan lama
							$kunjunganbaru_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `StatusKunjungan`='Baru' AND `JenisKelamin`='L'"));
							$kunjunganbaru_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `StatusKunjungan`='Baru' AND `JenisKelamin`='P'"));
							$kunjunganlama_l = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `StatusKunjungan`='Lama' AND `JenisKelamin`='L'"));
							$kunjunganlama_p = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$kodebulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `StatusKunjungan`='Lama' AND `JenisKelamin`='P'"));
						?>
							<tr>
								<td><?php echo $kodebulan;?></td>
								<td><?php echo $bulan;?></td>
								<td><?php echo rupiah($jml_0_7_hr_l);?></td>
								<td><?php echo rupiah($jml_0_7_hr_p);?></td>
								<td><?php echo rupiah($jml_8_31_hr_l);?></td>
								<td><?php echo rupiah($jml_8_31_hr_p);?></td>
								<td><?php echo rupiah($jml_1_th_l);?></td>
								<td><?php echo rupiah($jml_1_th_p);?></td>
								<td><?php echo rupiah($jml_1_4_th_l);?></td>
								<td><?php echo rupiah($jml_1_4_th_p);?></td>
								<td><?php echo rupiah($jml_5_9_th_l);?></td>	
								<td><?php echo rupiah($jml_5_9_th_p);?></td>	
								<td><?php echo rupiah($jml_10_14_th_l);?></td>	
								<td><?php echo rupiah($jml_10_14_th_p);?></td>	
								<td><?php echo rupiah($jml_15_19_th_l);?></td>	
								<td><?php echo rupiah($jml_15_19_th_p);?></td>	
								<td><?php echo rupiah($jml_20_44_th_l);?></td>	
								<td><?php echo rupiah($jml_20_44_th_p);?></td>	
								<td><?php echo rupiah($jml_45_54_th_l);?></td>	
								<td><?php echo rupiah($jml_45_54_th_p);?></td>	
								<td><?php echo rupiah($jml_55_59_th_l);?></td>	
								<td><?php echo rupiah($jml_55_59_th_p);?></td>	
								<td><?php echo rupiah($jml_60_69_th_l);?></td>	
								<td><?php echo rupiah($jml_60_69_th_p);?></td>	
								<td><?php echo rupiah($jml_70_th_l);?></td>	
								<td><?php echo rupiah($jml_70_th_p);?></td>	
								<td><?php echo rupiah($jml_l);?></td>		
								<td><?php echo rupiah($jml_p);?></td>		
								<td><?php echo rupiah($jml);?></td>		
								<td><?php echo $kunjunganbaru_l;?></td>		
								<td><?php echo $kunjunganbaru_p;?></td>		
								<td><?php echo $kunjunganlama_l;?></td>		
								<td><?php echo $kunjunganlama_p;?></td>		
							</tr>
						<?php
							$jml_0_7_hr_total_l = $jml_0_7_hr_total_l + $jml_0_7_hr_l;
							$jml_0_7_hr_total_p = $jml_0_7_hr_total_p + $jml_0_7_hr_p;
							$jml_8_31_hr_total_l = $jml_8_31_hr_total_l + $jml_8_31_hr_l;
							$jml_8_31_hr_total_p = $jml_8_31_hr_total_p + $jml_8_31_hr_p;
							$jml_1_th_total_l = $jml_1_th_total_l + $jml_1_th_l;
							$jml_1_th_total_p = $jml_1_th_total_p + $jml_1_th_p;
							$jml_1_4_th_total_l = $jml_1_4_th_total_l + $jml_1_4_th_l;
							$jml_1_4_th_total_p = $jml_1_4_th_total_p + $jml_1_4_th_p;
							$jml_5_9_th_total_l = $jml_5_9_th_total_l + $jml_5_9_th_l;							
							$jml_5_9_th_total_p = $jml_5_9_th_total_p + $jml_5_9_th_p;							
							$jml_10_14_th_total_l = $jml_10_14_th_total_l + $jml_10_14_th_l;
							$jml_10_14_th_total_p = $jml_10_14_th_total_p + $jml_10_14_th_p;
							$jml_15_19_th_total_l = $jml_15_19_th_total_l + $jml_15_19_th_l;
							$jml_15_19_th_total_p = $jml_15_19_th_total_p + $jml_15_19_th_p;
							$jml_20_44_th_total_l = $jml_20_44_th_total_l + $jml_20_44_th_l;
							$jml_20_44_th_total_p = $jml_20_44_th_total_p + $jml_20_44_th_p;
							$jml_45_54_th_total_l = $jml_45_54_th_total_l + $jml_45_54_th_l;
							$jml_45_54_th_total_p = $jml_45_54_th_total_p + $jml_45_54_th_p;
							$jml_55_59_th_total_l = $jml_55_59_th_total_l + $jml_55_59_th_l;
							$jml_55_59_th_total_p = $jml_55_59_th_total_p + $jml_55_59_th_p;
							$jml_60_69_th_total_l = $jml_60_69_th_total_l + $jml_60_69_th_l;
							$jml_60_69_th_total_p = $jml_60_69_th_total_p + $jml_60_69_th_p;
							$jml_70_th_total_l = $jml_70_th_total_l + $jml_70_th_l;
							$jml_70_th_total_p = $jml_70_th_total_p + $jml_70_th_p;
							$jml_total_l = $jml_0_7_hr_total_l + $jml_8_31_hr_total_l + $jml_1_th_total_l + $jml_1_4_th_total_l + $jml_5_9_th_total_l + $jml_10_14_th_total_l + 
										$jml_15_19_th_total_l + $jml_20_44_th_total_l + $jml_45_54_th_total_l + $jml_55_59_th_total_l + $jml_60_69_th_total_l + $jml_70_th_total_l;
							$jml_total_p = $jml_0_7_hr_total_p + $jml_8_31_hr_total_p + $jml_1_th_total_p + $jml_1_4_th_total_p + $jml_5_9_th_total_p +  $jml_10_14_th_total_p + 
										$jml_15_19_th_total_p + $jml_20_44_th_total_p + $jml_45_54_th_total_p + $jml_55_59_th_total_p + $jml_60_69_th_total_p + $jml_70_th_total_p;			
							$jml_total = $jml_total_l + $jml_total_p;
							
							// jenis kunjungan baru dan lama
							$total_kunjunganbaru_l = $total_kunjunganbaru_l + $kunjunganbaru_l;
							$total_kunjunganbaru_p = $total_kunjunganbaru_p + $kunjunganbaru_p;
							$total_kunjunganlama_l = $total_kunjunganlama_l + $kunjunganlama_l;
							$total_kunjunganlama_p = $total_kunjunganlama_p + $kunjunganlama_p;
							}
						?>
							<tr style="border:1px solid #000;">
								<td colspan="2">Total</td>
								<td><?php echo rupiah($jml_0_7_hr_total_l);?></td>
								<td><?php echo rupiah($jml_0_7_hr_total_p);?></td>
								<td><?php echo rupiah($jml_8_31_hr_total_l);?></td>
								<td><?php echo rupiah($jml_8_31_hr_total_p);?></td>
								<td><?php echo rupiah($jml_1_th_total_l);?></td>
								<td><?php echo rupiah($jml_1_th_total_p);?></td>
								<td><?php echo rupiah($jml_1_4_th_total_l);?></td>
								<td><?php echo rupiah($jml_1_4_th_total_p);?></td>
								<td><?php echo rupiah($jml_5_9_th_total_l);?></td>	
								<td><?php echo rupiah($jml_5_9_th_total_p);?></td>	
								<td><?php echo rupiah($jml_10_14_th_total_l);?></td>	
								<td><?php echo rupiah($jml_10_14_th_total_p);?></td>	
								<td><?php echo rupiah($jml_15_19_th_total_l);?></td>	
								<td><?php echo rupiah($jml_15_19_th_total_p);?></td>	
								<td><?php echo rupiah($jml_20_44_th_total_l);?></td>	
								<td><?php echo rupiah($jml_20_44_th_total_p);?></td>	
								<td><?php echo rupiah($jml_45_54_th_total_l);?></td>	
								<td><?php echo rupiah($jml_45_54_th_total_p);?></td>	
								<td><?php echo rupiah($jml_55_59_th_total_l);?></td>	
								<td><?php echo rupiah($jml_55_59_th_total_p);?></td>	
								<td><?php echo rupiah($jml_60_69_th_total_l);?></td>	
								<td><?php echo rupiah($jml_60_69_th_total_p);?></td>	
								<td><?php echo rupiah($jml_70_th_total_l);?></td>	
								<td><?php echo rupiah($jml_70_th_total_p);?></td>	
								<td><?php echo rupiah($jml_total_l);?></td>			
								<td><?php echo rupiah($jml_total_p);?></td>			
								<td><?php echo rupiah($jml_total);?></td>			
								<td><?php echo rupiah($total_kunjunganbaru_l);?></td>			
								<td><?php echo rupiah($total_kunjunganbaru_p);?></td>			
								<td><?php echo rupiah($total_kunjunganlama_l);?></td>			
								<td><?php echo rupiah($total_kunjunganlama_p);?></td>			
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
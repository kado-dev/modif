<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KUNJUNGAN PASIEN (BULANAN)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_kunjungan_bulan"/>
						<div class="col-xl-2 bulanformcari" style ="width:125px">
							<select name="tahun" class="form-control tahuncls">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-10">
							<button type="submit" class="btn btn-round btn-warning btncls"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_kunjungan_bulan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];

	// select tbpasienrj_retensi
	if($tahun == $tahunini){
		$tbpasienrj = $tbpasienrj;
	}else{
		$tbpasienrj = $tbpasienrj."_RETENSI";
	}

	if($tahun != null){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN KUNJUNGAN PASIEN (BULANAN)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
	</div><br/>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th width="3%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
							<th width="10%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">BULAN</th>
							<?php
								$bln = date('m');
								$thn = $_GET['tahun'];
								$mulai = 1;
								// $selesai = date('t',strtotime("01-".$bln."-".$thn));
								// for($d = $mulai;$d <= $selesai; $d++){	
								for($d = $mulai;$d <= 31; $d++){	
							?>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $d;?></th>
							<?php
								}
							?>
							<th width="8%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">TOTAL</th>
						</tr>
					</thead>
					<tbody style="font-size:12px;">
						<?php
						// insert ke tbpasienrj_bulan
						// $strpasienrj = "SELECT * FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun'";
						// $querypasienrj = mysqli_query($koneksi, $strpasienrj);
						// mysqli_query($koneksi, "DELETE FROM `tbpasienrj_bulan` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'");
						// while($datapsrj= mysqli_fetch_assoc($querypasienrj)){
						// 	$strpasienrjbulan = "INSERT INTO `tbpasienrj_bulan`(`TanggalRegistrasi`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NoRM`,`NamaPasien`,`JenisKelamin`,
						// 	`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKunjungan`,`AsalPasien`,`StatusPasien`,`PoliPertama`,`Asuransi`,`StatusKunjungan`,`WaktuKunjungan`,`TarifKarcis`,
						// 	`TarifKir`,`TotalTarif`,`StatusPelayanan`,`StatusPulang`,`NamaPegawaiSimpan`,`NamaPegawaiEdit`,`TanggalEdit`,`NoKunjunganBpjs`,`NoUrutBpjs`,`kdprovider`,
						// 	`nokartu`,`kdpoli`,`Kir`) VALUES 
						// 	('$datapsrj[TanggalRegistrasi]','$datapsrj[NoRegistrasi]','$datapsrj[NoIndex]','$datapsrj[NoCM]','$datapsrj[NoRM]','$datapsrj[NamaPasien]',
						// 	'$datapsrj[JenisKelamin]','$datapsrj[UmurTahun]','$datapsrj[UmurBulan]','$datapsrj[UmurHari]','$datapsrj[JenisKunjungan]','$datapsrj[AsalPasien]',
						// 	'$datapsrj[StatusPasien]','$datapsrj[PoliPertama]','$datapsrj[Asuransi]','$datapsrj[StatusKunjungan]','$datapsrj[WaktuKunjungan]','$datapsrj[TarifKarcis]',
						// 	'$datapsrj[TarifKir]','$datapsrj[TotalTarif]','$datapsrj[StatusPelayanan]','$datapsrj[StatusPulang]','$datapsrj[NamaPegawaiSimpan]','$datapsrj[NamaPegawaiEdit]'
						// 	,'$datapsrj[TanggalEdit]','$datapsrj[NoKunjunganBpjs]','$datapsrj[NoUrutBpjs]','$datapsrj[kdprovider]','$datapsrj[nokartu]','$datapsrj[kdpoli]',
						// 	'$datapsrj[Kir]')";
						// 	mysqli_query($koneksi, $strpasienrjbulan);
						// }						
						
						$arraybulan = array ("01"=>"Januari","02"=>"Februari","03"=>"Maret","04"=>"April","05"=>"Mei","06"=>"Juni","07"=>"Juli","08"=>"Agustus","09"=>"September","10"=>"Oktober","11"=>"November","12"=>"Desember");			
						foreach($arraybulan as $key => $val){
							$no = $no + 1;
							$kodebulan = $key;					
							$bulan = $val;					
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $bulan;?></td>
								<?php
								$jml = 0;	
								// $tbpasienrj = "tbpasienrj_".$kodebulan;
								// for($d2= $mulai;$d2 <= $selesai; $d2++){	
								for($d2= $mulai;$d2 <= 31; $d2++){	
									$tanggal = $thn."-".$kodebulan."-".$d2;
									$strs = "SELECT COUNT(NoRegistrasi) as jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`)='$tanggal'
									AND MONTH(TanggalRegistrasi)='$kodebulan' AND YEAR(TanggalRegistrasi)='$tahun'";
									$count = mysqli_fetch_assoc(mysqli_query($koneksi,$strs));
									$jml = $jml + $count['jumlah'];
									
								?>	
									<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $count['jumlah'];?></td>
								<?php } ?>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jml;?></td>
							</tr>	
						<?php
						}						
						?>
							<tr style="border:1px solid #000; font-weight: bold;">
								<td style="text-align:right; border:1px solid #000; padding:3px;">#</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;">TOTAL</td>
								<?php
								$jmltotals = 0;
								// for($d3= $mulai; $d3 <= $selesai; $d3++){											
								for($d3= $mulai; $d3 <= 31; $d3++){											
									$kodebulan1 = $key;
									// $tbpasienrj = "tbpasienrj_".$kodebulan1;
									$tanggal = $thn."-".$kodebulan1."-".$d3;
									$strs2 = "SELECT COUNT(NoRegistrasi) as jumlah FROM `$tbpasienrj` WHERE (DAY(TanggalRegistrasi)='$d3' AND YEAR(TanggalRegistrasi) = '$thn')
									AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'";
									$countall = mysqli_fetch_assoc(mysqli_query($koneksi,$strs2));
									$jmls = $countall['jumlah'];
									$jmltotals = $jmltotals + $countall['jumlah'];
									
								?>	
									<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jmls;?></td>
								<?php 
								} 								
								?>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($jmltotals);?></td>
							</tr>	
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br>
	
	<?php
	}
	?>
</div>	

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
	$('.btncls').click(function(){
		$( ".hasilpencarian" ).html( "<p style='text-align:center'><img src='assets/js/loader.gif' width='40px'></p>" );
		var tahun = $(this).parent().parent().find(".tahuncls").val()

		$.post( "lap_loket_kunjungan_bulan.php?jqry=yes", { tahun: tahun })
		  .done(function( data ) {
			 $( ".hasilpencarian" ).html( data );
		});
	});
</script>
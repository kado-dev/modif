<?php
	session_start();
	include "config/koneksi.php";
	// include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KUNJUNGAN PASIEN (PUSKESMAS)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">	
						<input type="hidden" name="page" value="lap_loket_kunjungan_puskesmas_tahun"/>
						<div class="col-xl-2 bulanformcari" style ="width:125px">
							<select name="tahun" class="form-control tahuncls">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-10">
							<button type="submit" class="btn btn-round btn-warning btncls"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_kunjungan_puskesmas_tahun" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_loket_kunjungan_puskesmas_tahun_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>" class="btn btn-round btn-success">Excel</a>
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

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead style="font-size:10px;">
						<tr style="border:1px solid #000;">
							<th width="3%" rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th width="10%" rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Puskesmas</th>
							<th colspan="24" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Kunjungan</th>
							<th width="8%" rowspan="3" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Total</th>
						</tr>
						<tr style="border:1px solid #000;">
							<?php
							for($bln = 1; $bln <= 12;$bln++){
								echo "<th colspan='2' style='text-align:center vertical-align:middle; border:1px solid #000; padding:3px;'>".nama_bulan_singkat($bln)."</th>";
							}
							?>
						</tr>
						<tr style="border:1px solid #000;">
							<?php
							for($bln = 1; $bln <= 12;$bln++){
							?>	
							<th width="3%" rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th width="3%" rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<?php
							}
							?>
						</tr>
					</thead>
					<tbody style="font-size:10px;">
						<?php
						
						$str = "SELECT * FROM `tbpuskesmas` WHERE `Kota` = '$kota'";
						$str2 = $str." ORDER BY `NamaPuskesmas`";
						// echo $str2;
				
						$query = mysqli_query($koneksi, $str2);					
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kdpuskesmas = $data['KodePuskesmas'];
							$namapuskesmas = $data['NamaPuskesmas'];						
							$tbpasienrj = 'tbpasienrj_'.str_replace(' ', '', $namapuskesmas);
							$dtrj1_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '01' AND `JenisKelamin`='L'"));
							$dtrj1_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '01' AND `JenisKelamin`='P'"));
							$dtrj2_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '02' AND `JenisKelamin`='L'"));
							$dtrj2_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '02' AND `JenisKelamin`='P'"));
							$dtrj3_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '03' AND `JenisKelamin`='L'"));
							$dtrj3_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '03' AND `JenisKelamin`='P'"));
							$dtrj4_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '04' AND `JenisKelamin`='L'"));
							$dtrj4_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '04' AND `JenisKelamin`='P'"));
							$dtrj5_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '05' AND `JenisKelamin`='L'"));
							$dtrj5_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '05' AND `JenisKelamin`='P'"));
							$dtrj6_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '06' AND `JenisKelamin`='L'"));
							$dtrj6_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '06' AND `JenisKelamin`='P'"));
							$dtrj7_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '07' AND `JenisKelamin`='L'"));
							$dtrj7_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '07' AND `JenisKelamin`='P'"));
							$dtrj8_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '08' AND `JenisKelamin`='L'"));
							$dtrj8_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '08' AND `JenisKelamin`='P'"));
							$dtrj9_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '09' AND `JenisKelamin`='L'"));
							$dtrj9_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '09' AND `JenisKelamin`='P'"));
							$dtrj10_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '10' AND `JenisKelamin`='L'"));
							$dtrj10_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '10' AND `JenisKelamin`='P'"));
							$dtrj11_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '11' AND `JenisKelamin`='L'"));
							$dtrj11_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '11' AND `JenisKelamin`='P'"));
							$dtrj12_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '12' AND `JenisKelamin`='L'"));
							$dtrj12_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '12' AND `JenisKelamin`='P'"));
							$dtttl_l = $dtrj1_l['Jml'] + $dtrj2_l['Jml'] + $dtrj3_l['Jml'] + $dtrj4_l['Jml'] + $dtrj5_l['Jml'] + $dtrj6_l['Jml'] + $dtrj7_l['Jml'] + $dtrj8_l['Jml'] + $dtrj9_l['Jml'] + $dtrj10_l['Jml'] + $dtrj11_l['Jml'] + $dtrj12_l['Jml'];
							$dtttl_p = $dtrj1_p['Jml'] + $dtrj2_p['Jml'] + $dtrj3_p['Jml'] + $dtrj4_p['Jml'] + $dtrj5_p['Jml'] + $dtrj6_p['Jml'] + $dtrj7_p['Jml'] + $dtrj8_p['Jml'] + $dtrj9_p['Jml'] + $dtrj10_p['Jml'] + $dtrj11_p['Jml'] + $dtrj12_p['Jml'];
							$dtttl = $dtttl_l + $dtttl_p;
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namapuskesmas;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj1_l['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj1_p['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj2_l['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj2_p['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj3_l['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj3_p['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj4_l['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj4_p['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj5_l['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj5_p['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj6_l['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj6_p['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj7_l['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj7_p['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj8_l['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj8_p['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj9_l['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj9_p['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj10_l['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj10_p['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj11_l['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj11_p['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj12_l['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj12_p['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtttl);?></td>	
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>	

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
	$('.btncls').click(function(){
		$( ".hasilpencarian" ).html( "<p style='text-align:center'><img src='assets/js/loader.gif' width='40px'></p>" );
		var tahun = $(this).parent().parent().find(".tahuncls").val()

		$.post( "lap_loket_kunjungan_puskesmas_tahun.php?jqry=yes", { tahun: tahun })
		  .done(function( data ) {
			 $( ".hasilpencarian" ).html( data );
		});
	});
</script>
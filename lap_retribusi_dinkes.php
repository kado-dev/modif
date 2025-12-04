<?php
	session_start();
	include "config/koneksi.php";
	// include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>RETRIBUSI PUSKESMAS</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">	
						<input type="hidden" name="page" value="lap_retribusi_dinkes"/>
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
							<a href="?page=lap_retribusi_dinkes" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_retribusi_dinkes_excel.php?tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-success">Excel</a>
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
							<th colspan="24" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Retribusi Puskesmas</th>
							<th width="8%" colspan="2" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Total</th>
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
							<th width="3%" rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">KARCIS</th>
							<th width="3%" rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">TINDAKAN</th>
                            <?php
							}
							?>
                            <th width="3%" rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">KARCIS</th>
							<th width="3%" rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">TINDAKAN</th>
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
                            $tbtindakanpasien = "tbtindakanpasien_".str_replace(' ', '', $namapuskesmas);
							$dt_karcis_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '01' AND `Asuransi`='UMUM'"));
							$dt_tindakan_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '01' AND `CaraBayar` ='UMUM'"));
                            $dt_karcis_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '02' AND `Asuransi`='UMUM'"));
							$dt_tindakan_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '02' AND `CaraBayar` ='UMUM'"));
                            $dt_karcis_3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '03' AND `Asuransi`='UMUM'"));
							$dt_tindakan_3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '03' AND `CaraBayar` ='UMUM'"));
                            $dt_karcis_4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '04' AND `Asuransi`='UMUM'"));
							$dt_tindakan_4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '04' AND `CaraBayar` ='UMUM'"));
                            $dt_karcis_5 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '05' AND `Asuransi`='UMUM'"));
							$dt_tindakan_5 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '05' AND `CaraBayar` ='UMUM'"));
                            $dt_karcis_6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '06' AND `Asuransi`='UMUM'"));
							$dt_tindakan_6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '06' AND `CaraBayar` ='UMUM'"));
                            $dt_karcis_7 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '07' AND `Asuransi`='UMUM'"));
							$dt_tindakan_7 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '07' AND `CaraBayar` ='UMUM'"));
                            $dt_karcis_8 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '08' AND `Asuransi`='UMUM'"));
							$dt_tindakan_8 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '08' AND `CaraBayar` ='UMUM'"));
                            $dt_karcis_9 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '09' AND `Asuransi`='UMUM'"));
							$dt_tindakan_9 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '09' AND `CaraBayar` ='UMUM'"));
                            $dt_karcis_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '10' AND `Asuransi`='UMUM'"));
							$dt_tindakan_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '10' AND `CaraBayar` ='UMUM'"));
                            $dt_karcis_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '11' AND `Asuransi`='UMUM'"));
							$dt_tindakan_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '11' AND `CaraBayar` ='UMUM'"));
                            $dt_karcis_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '12' AND `Asuransi`='UMUM'"));
							$dt_tindakan_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '12' AND `CaraBayar` ='UMUM'"));
                            $dt_karcis = $dt_karcis_1['Jml'] + $dt_karcis_2['Jml'] + $dt_karcis_3['Jml'] + $dt_karcis_4['Jml'] + $dt_karcis_5['Jml'] + $dt_karcis_6['Jml'] + $dt_karcis_7['Jml'] + $dt_karcis_8['Jml'] + $dt_karcis_9['Jml'] + $dt_karcis_10['Jml'] + $dt_karcis_11['Jml'] + $dt_karcis_12['Jml'];
							$dt_tindakan = $dt_tindakan_1['Jml'] + $dt_tindakan_2['Jml'] + $dt_tindakan_3['Jml'] + $dt_tindakan_4['Jml'] + $dt_tindakan_5['Jml'] + $dt_tindakan_6['Jml'] + $dt_tindakan_7['Jml'] + $dt_tindakan_8['Jml'] + $dt_tindakan_9['Jml'] + $dt_tindakan_10['Jml'] + $dt_tindakan_11['Jml'] + $dt_tindakan_12['Jml'];
						    $dtttl = $dt_karcis + $dt_tindakan;
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namapuskesmas;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_1['Jml'] * 7000);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_tindakan_1['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_2['Jml'] * 7000);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_tindakan_2['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_3['Jml'] * 7000);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_tindakan_3['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_4['Jml'] * 7000);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_tindakan_4['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_5['Jml'] * 7000);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_tindakan_5['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_6['Jml'] * 7000);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_tindakan_6['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_7['Jml'] * 7000);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_tindakan_7['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_8['Jml'] * 7000);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_tindakan_8['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_9['Jml'] * 7000);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_tindakan_9['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_10['Jml'] * 7000);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_tindakan_10['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_11['Jml'] * 7000);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_tindakan_11['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_12['Jml'] * 7000);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_tindakan_12['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis * 7000);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_tindakan);?></td>
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

<!-- <script src="assets/js/jquery.js"></script>
<script type="text/javascript">
	$('.btncls').click(function(){
		$( ".hasilpencarian" ).html( "<p style='text-align:center'><img src='assets/js/loader.gif' width='40px'></p>" );
		var tahun = $(this).parent().parent().find(".tahuncls").val()

		$.post( "lap_retribusi_dinkes.php?jqry=yes", { tahun: tahun })
		  .done(function( data ) {
			 $( ".hasilpencarian" ).html( data );
		});
	});
</script> -->
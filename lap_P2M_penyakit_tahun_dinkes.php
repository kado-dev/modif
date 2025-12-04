<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>TRACKING DIAGNOSA (TAHUN)</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_P2M_penyakit_tahun_dinkes"/>
						<div class="col-sm-2">
							<select name="tahun" class="form-control tahuncls">
								<?php
									for($tahun = 2020 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-5">
							<td class="col-sm-7">
								<input type="text" class="form-control diagnosabpjs" value="<?php echo $_GET['kodebpjs'];?>">
								<input type="hidden" name="kodebpjs" class="form-control kodebpjs" value="<?php echo $_GET['kodebpjs'];?>">
								<input type="hidden" class="form-control diagnosahiddenbpjs">
							</td>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_penyakit_tahun_dinkes" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_penyakit_tahun_dinkes_excel.php?tahun=<?php echo $_GET['tahun'];?>&kodebpjs=<?php echo $_GET['kodebpjs'];?>" class="btn btn-sm btn-success">Excel</a>
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

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr style="border:1px solid #000;">
							<th width="3%" rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
							<th width="20%" rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NAMA PUSKESMAS</th>
							<th colspan="12" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">JUMLAH DIAGNOSA <?php echo $_GET['kodebpjs'];?></th>
							<th width="10%" rowspan="3" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">TOTAL</th>
						</tr>
						<tr width="5%" style="border:1px solid #000;">
							<?php
							for($bln = 1; $bln <= 12;$bln++){
								echo "<th style='text-align:center vertical-align:middle; border:1px solid #000; padding:3px;'>".nama_bulan_singkat($bln)."</th>";
							}
							?>
						</tr>
					</thead>
					<tbody>
						<?php
						
						$str = "SELECT * FROM `tbpuskesmas` WHERE NamaPuskesmas != 'DINAS KESEHATAN' AND NamaPuskesmas != 'UPTD FARMASI'";
						$str2 = $str." ORDER BY `NamaPuskesmas`";
						// echo $str2;
				
						$query = mysqli_query($koneksi, $str2);					
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kdpuskesmas = $data['KodePuskesmas'];
							$namapuskesmas = $data['NamaPuskesmas'];	
							$dt_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_01` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
							$dt_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_02` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
							$dt_3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_03` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
							$dt_4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_04` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
							$dt_5 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_05` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
							$dt_6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_06` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
							$dt_7 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_07` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
							$dt_8 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_08` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
							$dt_9 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_09` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
							$dt_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_10` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
							$dt_l1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_11` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
							$dt_l2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdDiagnosa`) AS Jml FROM `tbdiagnosapasien_12` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas' AND `KodeDiagnosa`='$_GET[kodebpjs]'"));
							$dtttl = $dt_l['Jml'] + $dt_2['Jml'] + $dt_3['Jml'] + $dt_4['Jml'] + $dt_5['Jml'] + $dt_6['Jml'] + $dt_7['Jml'] + $dt_8['Jml'] + $dt_9['Jml'] + $dt_l0['Jml'] + $dt_l1['Jml'] + $dt_12['Jml'];
							
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namapuskesmas;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_l['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_2['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_3['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_4['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_5['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_6['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_7['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_8['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_9['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_l0['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_l1['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_l2['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtttl);?></td>	
							</tr>
						<?php
							$ttl_l = $ttl_l + $dt_l['Jml'];
							$ttl_2 = $ttl_2 + $dt_2['Jml'];
							$ttl_3 = $ttl_3 + $dt_3['Jml'];
							$ttl_4 = $ttl_4 + $dt_4['Jml'];
							$ttl_5 = $ttl_5 + $dt_5['Jml'];
							$ttl_6 = $ttl_6 + $dt_6['Jml'];
							$ttl_7 = $ttl_7 + $dt_7['Jml'];
							$ttl_8 = $ttl_8 + $dt_8['Jml'];
							$ttl_9 = $ttl_9 + $dt_9['Jml'];
							$ttl_10 = $ttl_l0 + $dt_l0['Jml'];
							$ttl_11 = $ttl_l1 + $dt_l1['Jml'];
							$ttl_12 = $ttl_l2 + $dt_l2['Jml'];
							$ttl = $ttl + $dtttl;
						}
						
						
						?>
						
						<tr style="border:1px solid #000;">
							<td style="text-align:right; border:1px solid #000; padding:3px;">#</td>
							<td style="text-align:center; border:1px solid #000; padding:3px;">Total</td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_l);?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_2);?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_3);?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_4);?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_5);?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_6);?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_7);?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_8);?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_9);?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_l0);?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_l1);?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl_l2);?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($ttl);?></td>
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

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
	$('.btncls').click(function(){
		$( ".hasilpencarian" ).html( "<p style='text-align:center'><img src='assets/js/loader.gif' width='40px'></p>" );
		var tahun = $(this).parent().parent().find(".tahuncls").val()

		$.post( "lap_P2M_penyakit_tahun_dinkes.php?jqry=yes", { tahun: tahun })
		  .done(function( data ) {
			 $( ".hasilpencarian" ).html( data );
		});
	});
</script>
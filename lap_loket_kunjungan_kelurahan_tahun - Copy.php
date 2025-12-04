<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KUNJUNGAN PASIEN (PER-DESA/KELURAHAN)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_kunjungan_kelurahan_tahun"/>
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
							<a href="?page=lap_loket_kunjungan_kelurahan_tahun" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>	
			</div>	
		</div>
	</div>

	<?php
	$tahun = $_GET['tahun'];
	$tahunini = date('Y');
	if(isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN KUNJUNGAN PASIEN (DESA/KELURAHAN) PERTAHUN</b></span><br>
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
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="3%" rowspan="2">NO.</th>
							<th width="10%" rowspan="2">DESA/KELURAHAN</th>
							<th colspan="12">JUMLAH KUNJUNGAN</th>
							<th width="8%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">TOTAL</th>
						</tr>
						<tr>
							<?php
							for($bln = 1; $bln <= 12;$bln++){
								echo "<th style='text-align:center vertical-align:middle; border:1px solid #000; padding:3px;'>".nama_bulan_singkat($bln)."</th>";
							}
							?>
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
						
						$str = "SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$kodepuskesmas' OR `KodePuskesmas` = '*'";
						$str2 = $str." ORDER BY Kelurahan LIMIT $mulai,$jumlah_perpage";
						// echo $str2;

						if($tahun == $tahunini){
							$tbpsnrj = $tbpasienrj;
						}else{
							$tbpsnrj = $tbpasienrj."_RETENSI";
						}
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi, $str2);					
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kelurahan = $data['Kelurahan'];
							
							if ($kelurahan == 'Luar Wilayah'){
								$dtrj1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '01' AND b.`Kelurahan` <> '$kelurahan'"));
								$dtrj2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '02' AND b.`Kelurahan` <> '$kelurahan'"));
								$dtrj3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '03' AND b.`Kelurahan` <> '$kelurahan'"));
								$dtrj4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '04' AND b.`Kelurahan` <> '$kelurahan'"));
								$dtrj5 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '05' AND b.`Kelurahan` <> '$kelurahan'"));
								$dtrj6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '06' AND b.`Kelurahan` <> '$kelurahan'"));
								$dtrj7 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '07' AND b.`Kelurahan` <> '$kelurahan'"));
								$dtrj8 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '08' AND b.`Kelurahan` <> '$kelurahan'"));
								$dtrj9 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '09' AND b.`Kelurahan` <> '$kelurahan'"));
								$dtrj10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '10' AND b.`Kelurahan` <> '$kelurahan'"));
								$dtrj11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '11' AND b.`Kelurahan` <> '$kelurahan'"));
								$dtrj12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '12' AND b.`Kelurahan` <> '$kelurahan'"));
							}else{
								$dtrj1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '01' AND b.`Kelurahan` = '$kelurahan'"));
								$dtrj2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '02' AND b.`Kelurahan` = '$kelurahan'"));
								$dtrj3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '03' AND b.`Kelurahan` = '$kelurahan'"));
								$dtrj4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '04' AND b.`Kelurahan` = '$kelurahan'"));
								$dtrj5 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '05' AND b.`Kelurahan` = '$kelurahan'"));
								$dtrj6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '06' AND b.`Kelurahan` = '$kelurahan'"));
								$dtrj7 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '07' AND b.`Kelurahan` = '$kelurahan'"));
								$dtrj8 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '08' AND b.`Kelurahan` = '$kelurahan'"));
								$dtrj9 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '09' AND b.`Kelurahan` = '$kelurahan'"));
								$dtrj10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '10' AND b.`Kelurahan` = '$kelurahan'"));
								$dtrj11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '11' AND b.`Kelurahan` = '$kelurahan'"));
								$dtrj12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`IdPasienrj`)AS Jml FROM `$tbpsnrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '12' AND b.`Kelurahan` = '$kelurahan'"));
							}
							$dtttl = $dtrj1['Jml'] + $dtrj2['Jml'] + $dtrj3['Jml'] + $dtrj4['Jml'] + $dtrj5['Jml'] + $dtrj6['Jml'] + $dtrj7['Jml'] + $dtrj8['Jml'] + $dtrj9['Jml'] + $dtrj10['Jml'] + $dtrj11['Jml'] + $dtrj12['Jml'];
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="left"><?php echo $kelurahan;?></td>
								<td align="right"><?php echo rupiah($dtrj1['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj2['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj3['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj4['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj5['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj6['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj7['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj8['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj9['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj10['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj11['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj12['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtttl);?></td>	
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<hr class="noprint"><!--css-->
	<ul class="pagination noprint">
		<?php
			$bulan = $_GET['bulan'];
			$tahun = $_GET['tahun'];
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
						echo "<li><a href='?page=lap_loket_kunjungan_kelurahan_tahun&tahun=$tahun&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	
	<?php
	}
	?>
</div>

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
	$('.btncls').click(function(){
		$( ".hasilpencarian" ).html( "<p style='text-align:center'><img src='assets/js/loader.gif' width='40px'></p>" );
		var tahun = $(this).parent().parent().find(".tahuncls").val()

		$.post( "lap_loket_kunjungan_kelurahan_tahun.php?jqry=yes", { tahun: tahun })
		  .done(function( data ) {
			 $( ".hasilpencarian" ).html( data );
		});
	});
</script>
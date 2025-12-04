<?php
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>REGISTER KIA</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_registrasi_kia_kukarkab"/>
						<div class="col-sm-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal" required>
						</div>
						<div class="col-sm-2">
							 <input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir" required>
						</div>
						<div class="col-sm-8">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_kia_kukarkab" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="lap_registrasi_kia_kukarkab_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>" class="btn btn-sm btn-info"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>	
	<?php
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	if(isset($keydate1) and isset($keydate2)){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER PELAYANAN KIA</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2))?> <?php echo $tahun;?></span>
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
	
	<!--data registrasi-->
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead style="font-size:10px;">
						<tr style="border:1px solid #000;">
							<th rowspan="2" width="2%">No.</th>
							<th rowspan="2" width="3%">Tanggal</th>
							<th rowspan="2" width="3%">No.Index</th>
							<th rowspan="2" width="3%">No.Resti</th>
							<th rowspan="2" width="6%">Nama Ibu / Suami</th>					
							<th rowspan="2" width="6%">Alamat</th>
							<th rowspan="2" width="2%">Usia</th>
							<th rowspan="2" width="3%">Usia<br/>Kehamilan</th>
							<th rowspan="2" width="3%">G.P.A</th>
							<th rowspan="2" width="4%">Jenis<br/>Kunjungan</th>
							<th rowspan="2" width="2%">BB</th>
							<th rowspan="2" width="2%">TB</th>
							<th rowspan="2" width="2%">LILA</th>
							<th rowspan="2" width="2%">SF</th>
							<th rowspan="2" width="2%">TT</th>
							<th colspan="10">Laboratorium</th>
							<th rowspan="2" width="5%">Hasil<br/>Pemeriksaan</th>
							<th rowspan="2" width="5%">Keluhan</th>
							<th rowspan="2" width="3%">N/FR/R</th>
							<th rowspan="2" width="2%">B/L</th>
							<th rowspan="2" width="3%">Therapy</th>
							<th rowspan="2" width="3%">Ket</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th rowspan="2" width="3%">PP Test</th>
							<th rowspan="2" width="3%">HB</th>
							<th rowspan="2" width="3%">Protein</th>
							<th rowspan="2" width="3%">Gds</th>
							<th rowspan="2" width="3%">HbsAg</th>
							<th rowspan="2" width="3%">Hiv</th>
							<th rowspan="2" width="3%">Sifilis</th>
							<th rowspan="2" width="3%">Malaria</th>
							<th rowspan="2" width="3%">Asam Urat</th>
							<th rowspan="2" width="3%">Goldar</th>
						</tr>
					</thead>
					<tbody style="font-size:10px;">
						<?php
						$jumlah_perpage = 20;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						if($opsiform == 'bulan'){
							$waktu = "YEAR(TanggalPeriksa) = '$tahun' AND MONTH(TanggalPeriksa) = '$bulan'";
							$str = "SELECT * FROM `$tbpolikia` WHERE ".$waktu." and SUBSTRING(NoPemeriksaan,1,11) = '$kodepuskesmas'";
							$str2 = $str."ORDER BY `TanggalPeriksa` DESC LIMIT $mulai,$jumlah_perpage";
						}else{
							$waktu = "TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2'";
							$str = "SELECT * FROM `$tbpolikia` WHERE ".$waktu." and SUBSTRING(NoPemeriksaan,1,11) = '$kodepuskesmas'";
							$str2 = $str."ORDER BY `TanggalPeriksa` DESC LIMIT $mulai,$jumlah_perpage";
						}
						// echo $str2;
						// die();
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi,$str2);
						while($datakia = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$noregistrasi = $datakia['NoPemeriksaan'];
							$noindex = $datakia['NoIndex'];
							
							// tbpasienrj
							$dtpasien_rj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `UmurTahun`,`StatusKunjungan` FROM $tbpasienrj WHERE `NoRegistrasi`='$noregistrasi'"));
							
							// tbkk
							$str_kk = "SELECT `NamaKK`,`Alamat`, `RT`, `RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
							$query_kk = mysqli_query($koneksi,$str_kk);
							$data_kk = mysqli_fetch_assoc($query_kk);
							$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];					
							
							// tbpasienperpegawai
							$tbpasienperpegawai='tbpasienperpegawai_'.$kodepuskesmas;
							$dt_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` where NoRegistrasi='$noregistrasi'"));
							if($dt_pegawai['NamaPegawai1']!=''){
								$pemeriksa = $dt_pegawai['NamaPegawai1'];
							}else{
								$pemeriksa = $dt_pegawai['NamaPegawai2'];
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
							
							//cek diagnosa pasien
							if($opsiform == 'bulan'){
								$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
							}else{
								$str_diagnosapsn = "SELECT * from(
													SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'
													UNION
													SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien2` WHERE `NoRegistrasi` = '$noregistrasi'
													)a";
							}
							$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
							while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
								$array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
							}
							if ($array_data[$no] != ''){
								$data_dgs = implode(",", $array_data[$no]);
							}else{
								$data_dgs ="";
							}
							
							// therapy
							$str_therapy = "SELECT * FROM `tbresepdetail` WHERE `NoResep` = '$noregistrasi'";
							$query_therapy = mysqli_query($koneksi, $str_therapy);
							while($dt_therapy = mysqli_fetch_array($query_therapy)){
								$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT NamaBarang FROM `tbgudangpkmstok` WHERE `KodeBarang` = '$dt_therapy[KodeBarang]'"));
								$array_therapy[$no][] = $dtobat['NamaBarang']." (".$dt_therapy['jumlahobat'].")";
							}
							if ($array_therapy[$no] != ''){
								$data_trp = implode(",", $array_therapy[$no]);
							}else{
								$data_trp ="-";
							}
							
						?>
							<tr>
								<td><?php echo $no;?></td>
								<td><?php echo $datakia['TanggalPeriksa'];?></td>
								<td><?php echo substr($noindex,-10);?></td>
								<td></td>
								<td><?php echo strtoupper($datakia['NamaPasien'])." | ".strtoupper($data_kk['NamaKK']);?></td>
								<td><?php
										if($data_kk['Alamat'] == ''){
											echo $alamat = '<span style="color:red;">Belum Terdaftar di Puskesmas</span>';
										}else{
											echo $alamat;
										}
									?>
								</td>
								<td><?php echo $dtpasien_rj['UmurTahun']." Th";?></td>
								<td><?php echo $datakia['UsiaKehamilan'];?></td>
								<td>
								<?php 
									if($datakia['Gravida']!=""){
										echo $datakia['Gravida']."/".$datakia['Partus']."/".$datakia['Abortus'];
									}else{
										echo "-";
									}	
								?>
								</td>
								<td><?php echo $datakia['KunjunganKehamilan'];?></td>
								<td><?php echo $datakia['BeratBadan'];?></td>
								<td><?php echo $datakia['TinggiBadan'];?></td>
								<td><?php if($datakia['Lila']!=""){echo $datakia['Lila'];}else{ echo "-";}?></td>
								<td><?php if($datakia['FE']!=""){echo $datakia['FE'];}else{ echo "-";}?></td>
								<td><?php if($datakia['TT']!=""){echo $datakia['TT'];}else{ echo "-";}?></td>
								<td><?php if($datakia['Pptest']!=""){echo $datakia['Pptest'];}else{ echo "-";}?></td>
								<td><?php if($datakia['K1Hb']!=""){echo $datakia['K1Hb'];}else{ echo $datakia['K4Hb'];}?></td>
								<td><?php if($datakia['ProteinUrin']!=""){echo $datakia['ProteinUrin'];}else{ echo "-";}?></td>
								<td><?php if($datakia['GulaDarahSewaktu']!=""){echo $datakia['GulaDarahSewaktu'];}else{ echo "-";}?></td>
								<td><?php if($datakia['Hbsag']!=""){echo $datakia['Hbsag'];}else{ echo "-";}?></td>
								<td><?php if($datakia['Hiv']!=""){echo $datakia['Hiv'];}else{ echo "-";}?></td>
								<td><?php if($datakia['Sifilis']!=""){echo $datakia['Sifilis'];}else{ echo "-";}?></td>
								<td><?php if($datakia['Malaria']!=""){echo $datakia['Malaria'];}else{ echo "-";}?></td>
								<td><?php if($datakia['AsamUrat']!=""){echo $datakia['AsamUrat'];}else{ echo "-";}?></td>
								<td><?php if($datakia['GolonganDarah']!=""){echo $datakia['GolonganDarah'];}else{ echo "-";}?></td>
								<td>
									<?php
										echo "Tfu: ".$datakia['Tfu'].", Djj: ".$datakia['Djj'].", KepThd: ".$datakia['KepThd'].", Presentasi: ".$datakia['Presentasi'];
									?>
								</td>
								<td><?php echo $datakia['Anamnesa'];?></td>
								<td></td>
								<td><?php echo $dtpasien_rj['StatusKunjungan'];?></td>
								<td><?php echo $data_trp;?></td>
								<td><?php echo $pemeriksa;?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
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
						echo "<li><a href='?page=lap_registrasi_kia_kukarkab&opsiform=$opsiform&keydate1=$keydate1&keydate2=$keydate2&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
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
$('.opsiform').change(function(){
	if($(this).val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}else{	
		$(".bulanformcari").hide();
		$(".tanggalformcari").show();
	}
});	
$(document).ready(function(){
	if($(".opsiform").val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}else{	
		$(".bulanformcari").hide();
		$(".tanggalformcari").show();
	}
});	
// $(".btnprosess").click(function() {
	// $.post( "lap_registrasi_kia_kukarkab_print.php")
		// .done(function( data ) {
		// $( ".lapregistrasihtml" ).html( data );
	// });
// });
</script>


<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul">REGISTER KUNJUNGAN RESEP</h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_farmasi_kunjungan_resep"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal">
						</div>
						<div class="col-xl-2">
							<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_kunjungan_resep" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_farmasi_kunjungan_resep_excel.php?keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>	
			</div>	
		</div>
	</div>	
			
	<?php
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	if(isset($keydate1) and isset($keydate2)){
	?>
	<!--data registrasi-->
	<div class="noprint">
		<div class="table-responsive noprint">
			<table class="table-judul-laporan">
				<thead>
					<tr>
						<th width="4%">NO.</th>
						<th width="8%">TGL.KUNJUNGAN</th>
						<th width="15%">NAMA PASIEN</th>
						<th width="6%">UMUR</th>
						<th width="20%">ALAMAT</th>
						<th width="10%">JAMINAN</th>
						<th width="10%">PELAYANAN</th>
						<th width="10%">DIAGNOSA</th>
						<th width="20%">THERAPY</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$jumlah_perpage = 20;
					
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}					
					
					$str = "SELECT * FROM `$tbresep` WHERE date(TanggalResep) BETWEEN '$keydate1' AND '$keydate2'";
					$str2 = $str."ORDER BY `TanggalResep` DESC LIMIT $mulai,$jumlah_perpage";				
					// echo $str2;
										
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$query = mysqli_query($koneksi,$str2);					
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$noresep = $data['NoResep'];
						$noindex = $data['NoIndex'];
						$umur_thn = $data['UmurTahun'];
						$umur_bln = $data['UmurBulan'];
						$jaminan = $data['StatusBayar'];
						$pelayanan = $data['Pelayanan'];
						
						// tbkk
						$str_kk = "SELECT `NamaKK`, `Alamat`, `RT`, `RW`, `Kelurahan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
						$query_kk = mysqli_query($koneksi,$str_kk);
						$data_kk = mysqli_fetch_assoc($query_kk);
						if($alamat != null || $alamat != '' || $alamat != '-'){
							$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW']."<br/>DS.".$data_kk['Kelurahan'];
						}else{
							$alamat = "-";
						}
						
						// cek diagnosa pasien
						$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noresep'";
						$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
						while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
							$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
							$array_data[$no][] = "<b>".$data_diagnosapsn['KodeDiagnosa']."</b> ".$dtdiagnosa['Diagnosa'];
						}
						if ($array_data[$no] != ''){
							$data_dgs = implode("<br/>", $array_data[$no]);
						}else{
							$data_dgs ="";
						}
												
						// tbresepdetail						
						$str_resepdtl = "SELECT KodeBarang FROM `$tbresepdetail` WHERE `NoResep` = '$noresep'";
						$query_resepdtl = mysqli_query($koneksi,$str_resepdtl);
						while($data_resepdtl = mysqli_fetch_array($query_resepdtl)){
							$kodebarang = $data_resepdtl['KodeBarang'];
							
							// tbgfkstok
							$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'"));
							$array_data_resep[$no][] = $dtgfk['NamaBarang'];
						}
						if ($array_data_resep[$no] != ''){
							$data_rsp = implode("<br/>", $array_data_resep[$no]);
						}else{
							$data_rsp ="";
						}
						// echo $data_rsp;
					
					?>
						<tr style="border:1px dashed #000;">
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalResep']));?></td>
							<td align="left">
								<?php 
									echo "<b>".strtoupper($data['NamaPasien']."</b><br/>".
									strtoupper($data_kk['NamaKK'])."<br/>".
									substr($noindex, -10));
								?>
							</td>
							<td align="center">
								<?php 
									if($umur_thn == '0'){
										echo $umur_bln."Bl";
									}else{
										echo $umur_thn."Th";
									}	
								?>
							</td>
							<td align="left"><?php echo strtoupper($alamat);?></td>
							<td align="center"><?php echo $jaminan;?></td>
							<td align="center"><?php echo $pelayanan;?></td>
							<td align="center"><?php echo $data_dgs;?></td>
							<td align="left"><?php echo $data_rsp;?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<br>
	<hr class="noprint"><!--css-->
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
						echo "<li><a href='?page=lap_farmasi_kunjungan_resep&opsiform=$opsiform&keydate1=$keydate1&keydate2=$keydate2&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>
<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row search-page noprint" id="search-page-1">
		<div class="col-xs-12">
			<h3 class="judul">LPLPO</h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_lplpo_provinsi"/>
						<div class="col-sm-2">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsi'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsi'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</select>	
						</div>

						<div class="col-sm-3 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate1" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" placeholder = "Tanggal Awal"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" placeholder = "Tanggal Akhir">
							</div>
						</div>	
					
						<div class="col-sm-2 bulanformcari">
							<select name="bulan" class="form-control">
								<option value="01" <?php if($_GET['bulan'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulan'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulan'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulan'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulan'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulan'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulan'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulan'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulan'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulan'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulan'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulan'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-sm-1 bulanformcari" style ="width:125px">
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
							<a href="?page=lap_farmasi_lplpo_provinsi" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
	$bulansebelumnya1 = $bulan - 1;
	if(strlen($bulansebelumnya1) == 1){
		$bulansebelumnya = "0".$bulansebelumnya1;
	}

	if(isset($bulan) and isset($tahun)){
	?>
	
	<div class="row">	
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr>
							<th rowspan="2" width="5%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="2" width="5%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kode</th>
							<th width="25%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Barang</th>
							<th width="7%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Satuan</th>
							<th width="7%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Stok Awal</th>
							<th width="7%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Penerimaan</th>
							<th width="7%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Persediaan</th>
							<th width="7%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pemakaian</th>
							<th width="7%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Sisa Akhir</th>
							<th width="7%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Stok Optimum</th>
							<th width="7%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Permintaan</th>
							<th width="10%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pemberian</th>
							<th width="5%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Ket.</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 20;
						
						if($opsiform == 'bulan'){
							$waktu = "YEAR(TanggalRegistrasi) = '$tahun'";
							$tbpasienrj = 'tbpasienrj_'.$bulan;
							$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
						}else{
							$waktu = "TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2'";
							$tbdiagnosapasien = 'tbdiagnosapasien';
							$str1 = mysqli_query($koneksi, "SELECT * FROM `tbdiagnosapasien` WHERE TanggalDiagnosa BETWEEN '$keydate1' AND '$keydate2'");
							while($data = mysqli_fetch_assoc($str1)){
								$bln = substr($data['NoRegistrasi'],14,2);
								$tbpasienrj = 'tbpasienrj_'.$bln;
								// echo $tbpasienrj;
							}
						}
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$str = "SELECT * FROM `tbgfkmasterobat` a JOIN `tbobatkelompok` b ON a.KodeKelompok = b.KodeKelompok";
						$str2 = $str." order by b.KodeKelompok, a.NamaBarang ASC limit $mulai,$jumlah_perpage";
						// echo $str2;
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;				
							$kodebarang = $data['KodeBarang'];
							
							// untuk awal ngambil dari tbstokbulanangop dan tbstokbulananapotik
							// bulan selanjutnya ngambil di tbstokbulananpuskesmas
							// stok awal gudang obat puskesmas
							$stokawalpuskesmas = mysqli_query($koneksi, "SELECT Stok FROM `tbstokbulananpuskesmas` WHERE KodePuskesmas='$kodepuskesmas' AND `Bulan`='$bulansebelumnya' AND `Tahun`='$tahun' AND KodeBarang='$kodebarang'");
							$ttlstokawal = mysqli_fetch_assoc($stokawalpuskesmas)['Stok'];
							
							
							// penerimaan
							$penerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Jumlah FROM `tbgudangpkmpenerimaandetail` a join tbgudangpkmpenerimaan b on a.NoFaktur = b.NoFaktur WHERE MONTH(b.TanggalPenerimaan) = '$bulan' AND YEAR(b.TanggalPenerimaan) = '$tahun' AND a.KodePuskesmas='$kodepuskesmas' AND a.KodeBarang='$kodebarang'"));
							if($penerimaan['Jumlah'] != ''){
								$terima = $penerimaan['Jumlah'];
							}else{
								$terima = 0;
							}
							$persediaan = $ttlstokawal + $terima;
							
							$tahun_2digit = substr($tahun,2,2);
							//echo $tahun_2digit;
							$pemakaian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(jumlahobat)AS jml FROM tbresepdetail 
							WHERE SUBSTRING(Noresep,1,11)='$kodepuskesmas' AND SUBSTRING(NoResep,13,2)='$tahun_2digit' 
							AND SUBSTRING(NoResep,15,2)='$bulan' AND KodeBarang='$kodebarang'"));
							$sisa = $persediaan - $pemakaian['jml'];
							$stokoptimum = $sisa * 1.6;
							$permintaan = 0;
							
							// if($data['KodeKelompok'] == 'KO01'){
								// echo "<tr style='border:1px solid #000;'><td style='text-align:center; border:1px solid #000; padding:3px; font-weight:bold'>$data[KodeKelompok]</td><td colspan='12' style='text-align:left; font-weight:bold; border:1px solid #000; padding:3px;'>$data[KelompokObat]</td></tr>";
							// }
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['KodeBarang'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaBarang'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $ttlstokawal;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $terima;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $persediaan;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $pemakaian['jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $sisa;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $stokoptimum;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $permintaan;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['SumberAnggaran'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;">-</td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>	
		</div>	
	</div>
	<div class="bawahtabel font10">
		<table width="100%">
			<tr>
				<td width="10%"></td>
				<td style="text-align:center;">
				Diterima Oleh
				<br>
				<br>
				<br>
				(..............................)
				</td>
				
				
				<td width="10%"></td>
				<td style="text-align:center;">
				Diserahkan Oleh
				<br>
				<br>
				<br>
				(..............................)
				</td>
			</tr>
		</table>
	</div>
	<br/>

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
						echo "<li><a href='?page=lap_farmasi_lplpo_provinsi&keydate1=$keydate1&keydate2=$keydate2&opsiform=$opsiform&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>

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
	</script>
</div>	
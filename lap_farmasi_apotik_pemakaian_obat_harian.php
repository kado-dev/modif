<?php
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";	
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
	$ref_obat_lplpo = "ref_obat_lplpo_".str_replace(' ', '', $namapuskesmas);
?>

<style>
	.blockhitam_aktif{
		background:black;opacity:0.4;z-index:5000;position:absolute;left:0;right:0;top:0;bottom:0;
	}
</style>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>PEMAKAIAN HARIAN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_farmasi_apotik_pemakaian_obat_harian"/>
						<div class="col-xl-2">
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
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2022 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning btnkirimdata"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_apotik_pemakaian_obat_harian" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_farmasi_apotik_pemakaian_obat_harian_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];

	if($bulan != null AND $tahun != null){
	?>
	<div>
		<table class="table-judul-laporan-min" width="100%">
			<thead>
				<tr>
					<th width="3%">No.</th>
					<th width="5%">Kode</th>
					<th width="30%">Nama Barang</th>
					<?php
						$bln = $_GET['bulan'];
						$thn = $_GET['tahun'];
					
						$mulai = 1;
						$selesai = 31;
						for($d = $mulai;$d <= $selesai; $d++){	

					?>
					<th><?php echo $d;?></th>
					<?php
						}
					?>
					<th width="5%">Jumlah</th>
				</tr>
			</thead>
			<tbody style="font-size: 12px;">
				<?php
				// simpan sementara tbresepdetail_replika
				mysqli_query($koneksi, "DELETE FROM `tbresepdetail_replika`;");
				$strreplika = "SELECT * FROM `$tbresepdetail` WHERE YEAR(`TanggalResep`)='$tahun' AND MONTH(`TanggalResep`)='$bulan'";
				$queryreplika = mysqli_query($koneksi, $strreplika);
				while($dtreplika = mysqli_fetch_assoc($queryreplika)){
					$strreplika = "INSERT INTO `tbresepdetail_replika`(`TanggalResep`,`KodeBarang`,`jumlahobat`) VALUES 
					('$dtreplika[TanggalResep]','$dtreplika[KodeBarang]','$dtreplika[jumlahobat]')";
					mysqli_query($koneksi, $strreplika);
				}

				if($kota == "KOTA TARAKAN"){
					$str1 = "SELECT a.TanggalResep, a.KodeBarang, b.NamaBarang, b.Satuan, c.NamaObatJkn FROM `$tbresepdetail` a 
					LEFT JOIN `$ref_obat_lplpo` b ON a.KodeBarang = b.KodeBarang
					LEFT JOIN `ref_obat_jkn` c ON a.KodeBarang = c.KodeObatJkn
					WHERE YEAR(a.Tanggalresep)='$tahun' AND MONTH(a.Tanggalresep)='$bulan' AND b.NamaBarang != ''";
					$str2 = $str1." GROUP BY `KodeBarang` ORDER BY `KodeBarang` ASC";
				}else{
					$str1 = "SELECT * FROM `$tbresepdetail`
					WHERE YEAR(Tanggalresep)='$tahun' AND MONTH(Tanggalresep)='$bulan'";
					$str2 = $str1." GROUP BY `KodeBarang` ORDER BY `KodeBarang`";
				}	
				// echo $str2;
				// die();				
				
				$query = mysqli_query($koneksi, $str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					if(substr($data['KodeBarang'],0,3) == "JKN"){
						$dtbarang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_obat_jkn` WHERE `KodeObatJkn`='$data[KodeBarang]'"));
						$namabarang = $dtbarang['NamaObatJkn'];
						$sumberanggaran = 'JKN';
					}else{
						$dtbarang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbapotikstok` WHERE `KodeBarang`='$data[KodeBarang]'"));
						$namabarang = $dtbarang['NamaBarang'];
						$sumberanggaran = $dtbarang['SumberAnggaran'];
					}
				?>
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo $data['KodeBarang'];?></td>
						<td align="left">
							<?php echo strtoupper($namabarang);?>
							<span class="badge badge-success" style='padding: 4px;'><?php echo $sumberanggaran;?></span>
						</td>
						<?php
							$jml2 = 0;	
							for($d2= $mulai;$d2 <= $selesai; $d2++){	
								$tanggal = $thn."-".$bln."-".$d2;
								$strs = "SELECT SUM(jumlahobat) as jumlah FROM `tbresepdetail_replika`
								WHERE date(TanggalResep) = '$tanggal' AND `KodeBarang` = '$data[KodeBarang]'";
								// echo $strs;
								// die();
								$jml = mysqli_fetch_assoc(mysqli_query($koneksi,$strs));
								$jml2 = $jml2 + $jml['jumlah'];
						?>	
							<td align="right"><a href="?page=lap_farmasi_apotik_pemakaian_obat_harian_detail&tgl=<?php echo $tanggal;?>&kdbrg=<?php echo $data['KodeBarang'];?>" style="color: black" target="_blank"><?php echo $jml['jumlah'];?></a></td>
						<?php
							}
						?>
						<td align="right"><?php echo $jml2;?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<hr class="noprint">
	<ul class="pagination noprint">
		<?php
			$query2 = mysqli_query($koneksi,$str1);
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
						echo "<li><a href='?page=lap_farmasi_apotik_pemakaian_obat_harian&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>
<div class="modal fade" id="alert-modal-tunggu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" style="text-align:center;padding:0px">
			<div class="modal-body ">
				<div style="background: #137ee9; padding: 20px; margin-bottom: 20px; color:#fff;">
					<i class="fa fa-spinner fa-spin fa-6x"></i>
				</div>
				<div class="modalbody-alert">Data anda sedang diproses...</div>
			</div>
		</div>
	</div>
</div>
<div class="blockhitam"></div>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>
	$(".btnkirimdata").click(function(){
		$(".blockhitam").addClass("blockhitam_aktif");
		$("#alert-modal-tunggu").modal('show');
	});
</script>
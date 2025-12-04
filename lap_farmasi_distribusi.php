<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>DISTRIBUSI</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_distribusi"/>
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
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
							<div class="input-group">
								<select name="kodepuskesmas" class="form-control">
									<option value='semua'>Semua</option>
									<?php
									$kota = $_SESSION['kota'];
									$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `Kota`='$kota' order by `NamaPuskesmas`");
									while($data3 = mysqli_fetch_assoc($queryp)){
										if($_GET['kodepuskesmas'] == $data3['KodePuskesmas']){
											echo "<option value='$data3[KodePuskesmas]' SELECTED>$data3[NamaPuskesmas]</option>";
										}else{
											echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
										}
									}
									?>
								</select>
								<span class="input-group-addon">Puskesmas</span>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="input-group">
								<select name="namaprogram" class="form-control">
									<option value='semua'>Semua</option>
									<?php
									$queryp = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` order by `nama_program`");
									while($data3 = mysqli_fetch_assoc($queryp)){
										if($_GET['namaprogram'] == $data3['nama_program']){
											echo "<option value='$data3[nama_program]' SELECTED>$data3[nama_program]</option>";
										}else{
											echo "<option value='$data3[nama_program]'>$data3[nama_program]</option>";
										}
									}
									?>
								</select>
								<span class="input-group-addon">Program</span>
							</div>
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-warning btn-white">Cari</button>
							<a href="javascript:print()" class="btn btn-primary btn-white">Print</a>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>
	
	<?php
		$jumlah_perpage = 20;
		if($_GET['h']==''){
			$mulai=0;
		}else{
			$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
		
		$bulan = $_GET['bulan'];
		$tahun = $_GET['tahun'];
		$kodepuskesmas = $_GET['kodepuskesmas'];
		$namaprogram = $_GET['namaprogram'];
		
		if($namaprogram == "semua" || $namaprogram == ""){
			$program = "";
		}else{
			$program = "WHERE NamaProgram = '$namaprogram'";
		}
		
		$str = "SELECT * FROM `ref_obat_lplpo`".$program;
		$str2 = $str." ORDER BY `IdLplpo`,`KodeBarang` ASC LIMIT $mulai,$jumlah_perpage";
		// echo $str2;
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr>
							<th width="2%" rowspan="2">No.</th>
							<th width="5%" rowspan="2">Kode</th>
							<th width="15%" rowspan="2">Nama Obat & BMHP</th>
							<th width="5%" rowspan="2">Satuan</th>
							<th width="5%" rowspan="2">StokAwal</th>
							<th width="5%" rowspan="2">Penerimaan</th>
							<th width="5%" rowspan="2">Persediaan</th>
							<th width="30%" colspan="6">Distribusi</th>
							<th width="5%" rowspan="2">Jumlah Distribusi</th>
							<th width="5%" rowspan="2">SisaStok</th>
							<th width="5%" rowspan="2">Total Rupiah</th>
						</tr>
						<tr>
							<th>Depot</th>
							<th>Poli</th>
							<th>Pustu</th>
							<th>Poned</th>
							<th>Rawat Inap</th>
							<th>IGD</th>
						</tr>
					</thead>
					<tbody style="font-size: 10px;">
					<?php
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						if($namaprogram != $data['NamaProgram']){
							echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='16'>$data[NamaProgram]</td></tr>";
							$namaprogram = $data['NamaProgram'];
						}
						
						if($kodepuskesmas == "semua"){
							$semuapkm = "";
							$semuapkm_penerimaan = "";
							$semuapkm_stokawal = "";
						}else{
							$semuapkm = " AND a.KodePuskesmas = '$kodepuskesmas'";
							$semuapkm_penerimaan = " AND a.`KodePenerima`='$kodepuskesmas'";
							$semuapkm_stokawal = " AND `KodePuskesmas`='$kodepuskesmas'";
						}
						
						$no = $no + 1;
						$kodebarang = $data['KodeBarang'];
						$harga = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaSatuan` FROM `tbgudangpkmstok` WHERE `KodeBarang` = '$kodebarang'"));
						
						// stokawal, ini sementara pakai kolom "stoklalu" seharusnya kolom "stok" karena saat ini blum semua puskesmas melakukan stok opname
						$stokawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(StokLalu) AS Jumlah FROM tbstokopnam_puskesmas_gudang WHERE `Bulan`='$bulan' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'".$semuapkm_stokawal));
												
						// penerimaan 
						$penerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE MONTH(a.TanggalPengeluaran) = '$bulan' AND YEAR(a.TanggalPengeluaran) = '$tahun' AND b.KodeBarang = '$kodebarang'".$semuapkm));
						
						// persediaan
						$persediaan = $stokawal['Jumlah'] + $penerimaan['Jumlah']; 
						
						// distribusi
						$depot = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgudangpkmpengeluaran a JOIN tbgudangpkmpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE MONTH(a.TanggalPengeluaran) = '$bulan' AND YEAR(a.TanggalPengeluaran) = '$tahun' AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='LOKET OBAT'".$semuapkm));
						$poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgudangpkmpengeluaran a JOIN tbgudangpkmpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE MONTH(a.TanggalPengeluaran) = '$bulan' AND YEAR(a.TanggalPengeluaran) = '$tahun' AND b.KodeBarang = '$kodebarang' AND a.`Penerima` like '%POLI%'".$semuapkm));
						$pustu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgudangpkmpengeluaran a JOIN tbgudangpkmpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE MONTH(a.TanggalPengeluaran) = '$bulan' AND YEAR(a.TanggalPengeluaran) = '$tahun' AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='PUSTU'".$semuapkm));
						$poned = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgudangpkmpengeluaran a JOIN tbgudangpkmpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE MONTH(a.TanggalPengeluaran) = '$bulan' AND YEAR(a.TanggalPengeluaran) = '$tahun' AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='PONED'".$semuapkm));
						$rawatinap = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgudangpkmpengeluaran a JOIN tbgudangpkmpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE MONTH(a.TanggalPengeluaran) = '$bulan' AND YEAR(a.TanggalPengeluaran) = '$tahun' AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='RAWAT INAP'".$semuapkm));
						$igd = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgudangpkmpengeluaran a JOIN tbgudangpkmpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE MONTH(a.TanggalPengeluaran) = '$bulan' AND YEAR(a.TanggalPengeluaran) = '$tahun' AND b.KodeBarang = '$kodebarang'  AND a.`Penerima`='IGD'".$semuapkm));
						$jumlahdistribusi = $depot['Jumlah'] + $poli['Jumlah'] + $pustu['Jumlah'] + $poned['Jumlah'] + $rawatinap['Jumlah'] + $igd['Jumlah'];
						$sisastok = $persediaan - $jumlahdistribusi;
						$totalrupiah = $sisastok * $harga['HargaSatuan'];
					?>
						<tr>
							<td align="right"><?php echo $no;?></td>							
							<td align="center"><?php echo $data['KodeBarang'];?></td>									
							<td align="left"><?php echo $data['NamaBarang'];?></td>									
							<td align="center"><?php echo $data['Satuan'];?></td>							
							<td align="right"><?php if($stokawal['Jumlah'] == ""){echo "0";}else{echo rupiah($stokawal['Jumlah']);}?></td>					
							<td align="right"><?php if($penerimaan['Jumlah'] == ""){echo "0";}else{echo rupiah($penerimaan['Jumlah']);}?></td>										
							<td align="right"><?php echo rupiah($persediaan);?></td>										
							<td align="right"><?php if($depot['Jumlah'] == ""){echo "0";}else{echo rupiah($depot['Jumlah']);}?></td>										
							<td align="right"><?php if($poli['Jumlah'] == ""){echo "0";}else{echo rupiah($poli['Jumlah']);}?></td>										
							<td align="right"><?php if($pustu['Jumlah'] == ""){echo "0";}else{echo rupiah($pustu['Jumlah']);}?></td>										
							<td align="right"><?php if($poned['Jumlah'] == ""){echo "0";}else{echo rupiah($poned['Jumlah']);}?></td>										
							<td align="right"><?php if($rawatinap['Jumlah'] == ""){echo "0";}else{echo rupiah($rawatinap['Jumlah']);}?></td>										
							<td align="right"><?php if($igd['Jumlah'] == ""){echo "0";}else{echo rupiah($igd['Jumlah']);}?></td>										
							<td align="right"><?php echo rupiah($jumlahdistribusi);?></td>										
							<td align="right"><?php echo rupiah($sisastok);?></td>										
							<td align="right"><?php echo rupiah($totalrupiah);?></td>										
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div><hr/>
	
	<ul class="pagination">
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
						echo "<li><a href='?page=lap_farmasi_distribusi&bulan=$bulan&tahun=$tahun&kodepuskesmas=$kodepuskesmas&namaprogram=$namaprogram&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p>
					<b>Perhatikan :</b><br/>
					Laporan distribusi diambil dari :<br/>
					1. Menu Pengeluaran Obat Puskesmas<br>
				</p>
			</div>
		</div>
	</div>
</div>	
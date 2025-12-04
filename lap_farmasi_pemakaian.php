<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>PEMAKAIAN</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_pemakaian"/>
						<div class="col-sm-1 bulanformcari" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-4">
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
						<div class="col-sm-3">
							<button type="submit" class="btn btn-warning btn-white">Cari</button>
							<a href="?page=lap_farmasi_pemakaian" class="btn btn-success btn-white">Refresh</a>
							<button type="submit" class="btn btn-info btn-white">Excel</button>
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
							<th width="2%">No.</th>
							<th width="5%">Kode</th>
							<th width="20%">Nama Obat & BMHP</th>
							<th width="4%">Satuan</th>
							<th width="4%">Jan</th>
							<th width="4%">Feb</th>
							<th width="4%">Mar</th>
							<th width="4%">Apr</th>
							<th width="4%">Mei</th>
							<th width="4%">Jun</th>
							<th width="4%">Jul</th>
							<th width="4%">Ags</th>
							<th width="4%">Sep</th>
							<th width="4%">Okt</th>
							<th width="4%">Nov</th>
							<th width="4%">Des</th>
							<th width="6%">Total Pemakaian</th>
							<th width="6%">Harga Satuan</th>
							<th width="6%">Jumlah Harga</th>
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
							echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='19'>$data[NamaProgram]</td></tr>";
							$namaprogram = $data['NamaProgram'];
						}
						
						$no = $no + 1;
						$kodebarang = $data['KodeBarang'];
						
						//tbgfkstok
						$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli` FROM tbgfkstok WHERE `KodeBarang`='$kodebarang'"));
						
						//pengeluaran bulan
						if($kodepuskesmas == "semua"){
							$semuapkm = "";
						}else{
							$semuapkm = " AND SUBSTRING(b.NoResep,1,11) = '$kodepuskesmas'";
						}
						
						//pengeluaran bulan
						$jan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalResep, b.KodeBarang, SUM(b.jumlahobat)AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep
									WHERE MONTH(a.TanggalResep) = '01' AND YEAR(a.TanggalResep) = '$tahun' AND b.KodeBarang = '$kodebarang'".$semuapkm));
						$feb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalResep, b.KodeBarang, SUM(b.jumlahobat)AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep
									WHERE MONTH(a.TanggalResep) = '02' AND YEAR(a.TanggalResep) = '$tahun' AND b.KodeBarang = '$kodebarang'".$semuapkm));
						$mar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalResep, b.KodeBarang, SUM(b.jumlahobat)AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep
									WHERE MONTH(a.TanggalResep) = '03' AND YEAR(a.TanggalResep) = '$tahun' AND b.KodeBarang = '$kodebarang'".$semuapkm));
						$apr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalResep, b.KodeBarang, SUM(b.jumlahobat)AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep
									WHERE MONTH(a.TanggalResep) = '04' AND YEAR(a.TanggalResep) = '$tahun' AND b.KodeBarang = '$kodebarang'".$semuapkm));
						$mei = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalResep, b.KodeBarang, SUM(b.jumlahobat)AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep
									WHERE MONTH(a.TanggalResep) = '05' AND YEAR(a.TanggalResep) = '$tahun' AND b.KodeBarang = '$kodebarang'".$semuapkm));
						$jun = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalResep, b.KodeBarang, SUM(b.jumlahobat)AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep
									WHERE MONTH(a.TanggalResep) = '06' AND YEAR(a.TanggalResep) = '$tahun' AND b.KodeBarang = '$kodebarang'".$semuapkm));
						$jul = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalResep, b.KodeBarang, SUM(b.jumlahobat)AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep
									WHERE MONTH(a.TanggalResep) = '07' AND YEAR(a.TanggalResep) = '$tahun' AND b.KodeBarang = '$kodebarang'".$semuapkm));
						$ags = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalResep, b.KodeBarang, SUM(b.jumlahobat)AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep
									WHERE MONTH(a.TanggalResep) = '08' AND YEAR(a.TanggalResep) = '$tahun' AND b.KodeBarang = '$kodebarang'".$semuapkm));
						$sep = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalResep, b.KodeBarang, SUM(b.jumlahobat)AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep
									WHERE MONTH(a.TanggalResep) = '09' AND YEAR(a.TanggalResep) = '$tahun' AND b.KodeBarang = '$kodebarang'".$semuapkm));
						$okt = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalResep, b.KodeBarang, SUM(b.jumlahobat)AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep
									WHERE MONTH(a.TanggalResep) = '10' AND YEAR(a.TanggalResep) = '$tahun' AND b.KodeBarang = '$kodebarang'".$semuapkm));
						$nov = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalResep, b.KodeBarang, SUM(b.jumlahobat)AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep
									WHERE MONTH(a.TanggalResep) = '11' AND YEAR(a.TanggalResep) = '$tahun' AND b.KodeBarang = '$kodebarang'".$semuapkm));
						$des = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalResep, b.KodeBarang, SUM(b.jumlahobat)AS Jumlah FROM tbresep a JOIN tbresepdetail b ON a.NoResep = b.NoResep
									WHERE MONTH(a.TanggalResep) = '12' AND YEAR(a.TanggalResep) = '$tahun' AND b.KodeBarang = '$kodebarang'".$semuapkm));
					
						$total = $jan['Jumlah'] + $feb['Jumlah'] + $mar['Jumlah'] + $apr['Jumlah'] + $mei['Jumlah'] + $jun['Jumlah'] + $jul['Jumlah'] + $ags['Jumlah'] + $sep['Jumlah'] + $okt['Jumlah'] + $nov['Jumlah'] + $des['Jumlah'];
						$jmlharga = $total * $dtgfk['HargaBeli'];
					?>
						<tr>
							<td align="right"><?php echo $no;?></td>							
							<td align="center"><?php echo $data['KodeBarang'];?></td>									
							<td align="left"><?php echo $data['NamaBarang'];?></td>									
							<td align="center"><?php echo $data['Satuan'];?></td>							
							<td align="right"><?php if($jan['Jumlah'] == ""){echo "0";}else{echo rupiah($jan['Jumlah']);}?></td>							
							<td align="right"><?php if($feb['Jumlah'] == ""){echo "0";}else{echo rupiah($feb['Jumlah']);}?></td>							
							<td align="right"><?php if($mar['Jumlah'] == ""){echo "0";}else{echo rupiah($mar['Jumlah']);}?></td>							
							<td align="right"><?php if($apr['Jumlah'] == ""){echo "0";}else{echo rupiah($apr['Jumlah']);}?></td>							
							<td align="right"><?php if($mei['Jumlah'] == ""){echo "0";}else{echo rupiah($mei['Jumlah']);}?></td>							
							<td align="right"><?php if($jun['Jumlah'] == ""){echo "0";}else{echo rupiah($jun['Jumlah']);}?></td>							
							<td align="right"><?php if($jul['Jumlah'] == ""){echo "0";}else{echo rupiah($jul['Jumlah']);}?></td>							
							<td align="right"><?php if($ags['Jumlah'] == ""){echo "0";}else{echo rupiah($ags['Jumlah']);}?></td>							
							<td align="right"><?php if($sep['Jumlah'] == ""){echo "0";}else{echo rupiah($sep['Jumlah']);}?></td>							
							<td align="right"><?php if($okt['Jumlah'] == ""){echo "0";}else{echo rupiah($okt['Jumlah']);}?></td>							
							<td align="right"><?php if($nov['Jumlah'] == ""){echo "0";}else{echo rupiah($nov['Jumlah']);}?></td>							
							<td align="right"><?php if($des['Jumlah'] == ""){echo "0";}else{echo rupiah($des['Jumlah']);}?></td>							
							<td align="right"><?php echo rupiah($total);?></td>							
							<td align="right"><?php echo rupiah($dtgfk['HargaBeli']);?></td>							
							<td align="right"><?php echo rupiah($jmlharga);?></td>							
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
						echo "<li><a href='?page=lap_farmasi_pemakaian&tahun=$tahun&kodepuskesmas=$kodepuskesmas&namaprogram=$namaprogram&h=$i'>$i</a></li>";
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
					Laporan pemakaian diambil dari :<br/>
					1. Entry Resep (Fix)<br>
					2. Distribusi Ke depot (Progres)
				</p>
			</div>
		</div>
	</div>
</div>	
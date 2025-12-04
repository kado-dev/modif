<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
?>
<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>DAFTAR KISARAN HARGA (DKH)</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_dkh"/>
						<div class="col-sm-8">
							<input type="text" name="key" class="form-control key" value="<?php echo $_GET['key'];?>" required>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_dkh" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_farmasi_dkh_excel.php?key=<?php echo $_GET['key'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
							<button type="submit" class="btn btn-sm btn-success btnmodaldkh">Tambah Data</button>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>
	
	<!--untuk menampilkan modal-->
	<div class="modal fade" id="modaldkh" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel"> Input DKH</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" action="index.php?page=lap_farmasi_dkh_proses" method="post" enctype="multipart/form-data" role="form">
						<table class="table">
							<tr>
								<td class="col-sm-2">Kegiatan</td>
								<td class="col-sm-10">
									<input type="text" name="kegiatan" class="form-control" maxlength ="200" placeholder="Misal : Pengadaan Bahan Medis Habis Pakai (BMHP)" required>
								</td>
							</tr>
							<tr>
								<td>Pekerjaan</td>
								<td>
									<input type="text" name="pekerjaan" class="form-control" maxlength ="200" placeholder="Misal : Belanja Alat Kedokteran Pakai Habis" required>
								</td>
							</tr>
							<tr>
								<td>Kode Kegiatan</td>
								<td>
									<input type="text" name="kodekegiatan" class="form-control" maxlength ="200" placeholder="Misal : 29.008" required>
								</td>
							</tr>
							<tr>
								<td>Kode Rekening</td>
								<td>
									<input type="text" name="koderekening" class="form-control" maxlength ="200" placeholder="Misal : 5.2.2.01.10" required>
								</td>
							</tr>
							<tr>
								<td>Pagu Dana</td>
								<td>
									<input type="text" name="pagudana" class="form-control" maxlength ="200" placeholder="Misal : 760.819.220 (Ketikan tanpa titik)" required>
								</td>
							</tr>
							<tr>
								<td>Tahun Anggaran</td>
								<td>
									<input type="text" name="tahunanggaran" class="form-control" maxlength ="200" placeholder="2019" required>
								</td>
							</tr>
							<tr>
								<td>Paket</td>
								<td>
									<div class="input-group">
										<select class="form-control" name="paket">
											<option value="Paket I">Paket I</option>
											<option value="Paket II">Paket II</option>
											<option value="Paket III">Paket II</option>
											<option value="Paket IV">Paket IV</option>
										</select>
									</div>
								</td>
							</tr>
							<tr>
								<td>Status</td>
								<td>
									<div class="input-group">
										<select class="form-control" name="statuskatalog">
											<option value="Ekatalog">Ekatalog</option>
											<option value="Non Ekatalog">Non Ekatalog</option>
										</select>
									</div>
								</td>
							</tr>
						</table><hr/>
						<button type="submit" class="btnsimpan">Simpan</button>
					</form>
				</div>	
			</div>
		</div>
	</div>
	<div class="hasilmodal"></div>


	<?php
		$jumlah_perpage = 20;
		if($_GET['h']==''){
			$mulai=0;
		}else{
			$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
		
		$key = $_GET['key'];
		if($key != ''){
			$keys = " AND `NamaBarang` like '%$key%'";				
		}else{
			$keys = "";
		}		
		$str = "SELECT * FROM `tbgudangpkmdkh` WHERE `KodePuskesmas`='$kodepuskesmas'".$keys;
		$str2 = $str." ORDER BY IdDkh DESC LIMIT $mulai,$jumlah_perpage";
		// echo $str2;
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr>
							<th width="2%">NO.</th>
							<th width="15%">KEGIATAN</th>
							<th width="15%">PEKERJAAN</th>
							<th width="8%">KODE KEGIATAN</th>
							<th width="8%">KODE REKENING</th>
							<th width="8%">PAGU DANA</th>
							<th width="8%">TAHUN ANGGARAN</th>
							<th width="6%">PAKET</th>
							<th width="10%">#</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					?>
						<tr>
							<td align="right"><?php echo $no;?></td>							
							<td align="left">
								<?php 
									echo "<b>".strtoupper($data['Kegiatan'])."</b><br/> 
									TGL.INPUT: ".date("d-m-Y", strtotime($data['TanggalEntry']))."<br/> 
									STATUS: ".strtoupper($data['StatusKatalog']);
								?>
							</td>									
							<td align="left"><?php echo strtoupper($data['Pekerjaan']);?></td>									
							<td align="center"><?php echo $data['KodeKegiatan'];?></td>									
							<td align="center"><?php echo $data['KodeRekening'];?></td>									
							<td align="right"><?php echo rupiah($data['PaguDana']);?></td>									
							<td align="center"><?php echo $data['TahunAnggaran'];?></td>									
							<td align="center"><?php echo strtoupper($data['PaketDkh']);?></td>									
							<td align="center">
								<a href="?page=lap_farmasi_dkh_detail&iddkh=<?php echo $data['IdDkh'];?>&status=<?php echo $data['StatusKatalog'];?>" class="btn btn-xs btn-success">Lihat</a>
								<a href="?page=lap_farmasi_dkh_delete&iddkh=<?php echo $data['IdDkh'];?>" class="btn btn-xs btn-danger" onClick="return confirm('Data ingin di Hapus...?')">Hapus</a>
							</td>									
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
						echo "<li><a href='?page=lap_farmasi_dkh&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>	
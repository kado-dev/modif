<?php
	include "config/helper_pasienrj.php";
	$otoritas = explode(',',$_SESSION['otoritas']);
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>DATA PEGAWAI</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="master_pegawai_garutkab"/>
						<div class="col-sm-6">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama Pegawai" required>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=master_pegawai_garutkab" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<?php
								if(in_array("OPERATOR", $otoritas) || in_array("PROGRAMMER", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){ 
							?>
							<button type="submit" class="btn btn-sm btn-success btnmodalpegawai"> Tambah Pegawai</button>
							<?php } ?>
						</div>
					</form>
				</div>		
			</div>
		</div>
	</div>

	<!--untuk menampilkan modal-->
	<div class="modal fade" id="modalpegawai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel"> Tambah Data Pegawai</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" action="index.php?page=master_pegawai_proses" method="post" enctype="multipart/form-data" role="form">
						<table class="table">
							<tr>
								<td class="col-sm-3">Nama Pegawai</td>
								<td class="col-sm-9">
									<input type="text" name="namapegawai" style="text-transform: uppercase;" class="form-control" maxlength ="50" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Username</td>
								<td class="col-sm-9">
									<input type="text" name="nip" class="form-control" maxlength ="20" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Password</td>
								<td class="col-sm-9">
									<input type="text" name="password" class="form-control" maxlength ="20" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Status</td>
								<td class="col-sm-10">
									<select name="status" class="form-control">
										<option value="-">--Pilih--</option>
										<option value="AKUNTAN">AKUNTAN</option>
										<option value="ANALIS">ANALIS</option>
										<option value="APOTEKER">APOTEKER</option>
										<option value="ASISTEN APOTEKER">ASISTEN APOTEKER</option>
										<option value="BIDAN">BIDAN</option>
										<option value="DOKTER">DOKTER</option>
										<option value="IT">IT</option>
										<option value="KESLING">KESLING</option>
										<option value="KESMAS">KESMAS</option>
										<option value="LOKET">LOKET</option>
										<option value="PERAWAT">PERAWAT</option>
										<option value="NUTRISIONIST">NUTRISIONIST</option>
										<option value="REKAM MEDIS">REKAM MEDIS</option>
										<option value="TU">TU</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Otoritas</td>
								<td class="col-sm-10">
									<input type="checkbox" name="otoritas[]" value="ADMINISTRATOR"> ADMINISTRATOR<br/>
									<input type="checkbox" name="otoritas[]" value="OPERATOR"> OPERATOR<br/>
									<input type="checkbox" name="otoritas[]" value="APOTEK"> APOTEK<br/>
									<input type="checkbox" name="otoritas[]" value="LOKET"> LOKET<br/>
									<input type="checkbox" name="otoritas[]" value="POLI GIGI"> POLI GIGI<br/>
									<input type="checkbox" name="otoritas[]" value="POLI KONSELING"> POLI KONSELING<br/>
									<input type="checkbox" name="otoritas[]" value="POLI IMUNISASI"> POLI IMUNISASI<br/>
									<input type="checkbox" name="otoritas[]" value="POLI KB"> POLI KB<br/>
									<input type="checkbox" name="otoritas[]" value="POLI KESWA"> POLI KESWA<br/>
									<input type="checkbox" name="otoritas[]" value="POLI KIA"> POLI KIA<br/>
									<input type="checkbox" name="otoritas[]" value="POLI LABORATORIUM"> POLI LABORATORIUM<br/>
									<input type="checkbox" name="otoritas[]" value="POLI LANSIA"> POLI LANSIA<br/>
									<input type="checkbox" name="otoritas[]" value="POLI MTBS"> POLI MTBS<br/>
									<input type="checkbox" name="otoritas[]" value="POLI TB"> POLI TB<br/>
									<input type="checkbox" name="otoritas[]" value="POLI UGD"> POLI UGD<br/>
									<input type="checkbox" name="otoritas[]" value="POLI UMUM"> POLI UMUM<br/>
								</td>
							</tr>
							
							<tr>
								<td class="col-sm-3">Alamat</td>
								<td class="col-sm-9">
									<input type="text" name="alamat" class="form-control" maxlength ="200" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Telepon</td>
								<td class="col-sm-9">
									<input type="text" name="telepon" class="form-control" maxlength ="12" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Foto</td>
								<td class="col-sm-9">
									<input type="file" name="image" class="form-control">
								</td>
							</tr>
							<tr>
								<td colspan="2"><span style="font-weight:bold;">Display Antrian, abaikan jika menggunakan sis.antrian lainnya</span></td>
							</tr>
							<tr>
								<td class="col-sm-3">Loket</td>
								<td class="col-sm-10">
									<select name="loket" class="form-control loketcls">
										<option value="loket 1">loket 1</option>
										<option value="loket 2">loket 2</option>
										<option value="loket 3">loket 3</option>
										<option value="loket 4">loket 4</option>
										<option value="-">-</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Poli</td>
								<td class="col-sm-10">
									<?php
										$sqldttbapelayanan = mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` where `KodePuskesmas` = '$kodepuskesmas'");
										while($dttbapelayanan = mysqli_fetch_assoc($sqldttbapelayanan)){
									?>
										<label><input type="checkbox" name="poli[]" value="<?php echo $dttbapelayanan['KodePelayanan'];?>"><?php echo $dttbapelayanan['Pelayanan'];?> </label>
									<?php		
										}
									?>	
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Antrian</td>
								<td class="col-sm-10">
									<input type="checkbox" name="statuspustu[]" value="puskesmas"> PUSKESMAS 
									<input type="checkbox" name="statuspustu[]" value="pustu"> PUSTU
								</td>
							</tr>
						</table><hr/>
						<input type="hidden" name="kodepuskesmas" class="form-control" value="<?php echo $_SESSION['kodepuskesmas'];?>">
						<button type="submit" class="btnsimpan">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="hasilmodal"></div>

	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<table class="table-judul">
				<thead>
					<tr>
						<th width="3%">NO.</th>
						<th width="17%">USERNAME</th>
						<th width="25%">NAMA PEGAWAI</th>
						<th width="20%">ALAMAT</th>
						<th width="10%">STATUS</th>
						<th width="10%">TELP</th>
						<?php
						if(in_array("OPERATOR", $otoritas) || in_array("PROGRAMMER", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){ 
						?>
						<th width="15%">AKSI</th>
						<?php }?>
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
							
					$key = $_GET['key'];				
					
					if($kodepuskesmas == "-" OR $namapuskesmas == "UPTD FARMASI"){
						$str = "SELECT * FROM `tbpegawai` WHERE(`NamaPegawai` like '%$key%' OR `Status` like '%like%')";
					}else{
						$str = "SELECT * FROM `tbpegawai` WHERE `KodePuskesmas` = '$kodepuskesmas' AND (`NamaPegawai` like '%$key%')";
					}
					$str2 = $str." order by NamaPegawai Asc LIMIT $mulai,$jumlah_perpage";
					// echo $str2;
					// die();
					
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}					
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						
						// tbpuskesmas
						$kdpkm = $data['KodePuskesmas'];
						$datapkm = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kdpkm'"));
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="left" class="nip"><?php echo strtoupper($data['Nip']);?></td>
							<td align="left" class="kota" style="display:none;"><?php echo $_SESSION['kota'];?></td>
							<td align="left" class="nama"><?php echo $data['NamaPegawai'];?></td>
							<td align="left"><?php echo $data['Alamat'];?></td>
							<td align="center"><?php echo $data['Status'];?></td>
							<td align="center"><?php echo $data['Telepon'];?></td>
							<?php							
							if(in_array("OPERATOR", $otoritas) || in_array("PROGRAMMER", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){ 
							?>
							<td align="center">
								<a href="#" class="btnmodalpegawaiedit btn btn-xs btn-info">Edit</a>
								<a href="?page=master_pegawai_delete&nip=<?php echo $data['Nip'];?>" class="btn btn-xs btn-danger btnhapus">Hapus</a>
							</td>
							<?php }?>									
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<hr>
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
						echo "<li><a href='?page=master_pegawai_garutkab&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>	
	
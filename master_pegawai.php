<?php
	include "config/helper_pasienrj.php";
	$otoritas = explode(',',$_SESSION['otoritas']);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DATA PEGAWAI</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="master_pegawai"/>
						<div class="col-xl-6">
							<input type="text" name="key" class="form-control cari" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama / Nip Pegawai" required>
						</div>
						<div class="col-xl-6">
							<button type="submit" class="btn btn-round btn-warning btnsubmit"><span class="fa fa-search"></span></button>
							<a href="?page=master_pegawai" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<?php
								if(in_array("OPERATOR", $otoritas) || in_array("PROGRAMMER", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){ 
							?>
							<button type="submit" class="btn btn-round btn-success btnmodalpegawai">Tambah</button>
							<?php } ?>
						</div>
					</div>
				</form>		
			</div>
		</div>
	</div>

	<!--untuk menampilkan modal-->
	<div class="modal fade" id="modalpegawai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"> Tambah Data Pegawai</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" action="master_pegawai_proses.php" method="post" enctype="multipart/form-data" role="form">
						<table class="table-judul">
							<tr>
								<td class="col-sm-3">User Id / Nip</td>
								<td class="col-sm-9">
									<input type="text" name="nip" class="form-control" maxlength ="20" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Nama Pegawai</td>
								<td class="col-sm-9">
									<input type="text" name="namapegawai" style="text-transform: uppercase;" class="form-control" maxlength ="50" required>
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
										<option value="AHLI TELNOLOGI LABORATORIUM MEDIK">AHLI TELNOLOGI LABORATORIUM MEDIK</option>
										<option value="BIDAN">BIDAN</option>
										<option value="DOKTER">DOKTER</option>
										<option value="EPIDEMIOLOGI">EPIDEMIOLOGI</option>
										<option value="IT">IT</option>
										<option value="KESLING">KESLING</option>
										<option value="KESMAS">KESMAS</option>
										<option value="LOKET">LOKET</option>
										<option value="PERAWAT">PERAWAT</option>
										<option value="PROMKES">PROMKES</option>
										<option value="NUTRISIONIST">NUTRISIONIST</option>
										<option value="REKAM MEDIS">REKAM MEDIS</option>
										<option value="TATA USAHA">TATA USAHA</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Otoritas</td>
								<td class="col-sm-10">
									<input type="checkbox" name="otoritas[]" value="ADMINISTRATOR"> ADMINISTRATOR<br/>
									<input type="checkbox" name="otoritas[]" value="APOTEK"> APOTEK<br/>
									<input type="checkbox" name="otoritas[]" value="DINAS KESEHATAN"> DINAS KESEHATAN<br/>
									<input type="checkbox" name="otoritas[]" value="KEPALA PUSKESMAS"> KEPALA PUSKESMAS<br/>
									<input type="checkbox" name="otoritas[]" value="LOKET"> PENDAFTARAN<br/>
									<input type="checkbox" name="otoritas[]" value="POLI ANAK"> RUANG ANAK<br/>
									<input type="checkbox" name="otoritas[]" value="POLI GIGI"> RUANG GIGI<br/>
									<input type="checkbox" name="otoritas[]" value="POLI GIZI"> RUANG GIZI<br/>
									<input type="checkbox" name="otoritas[]" value="POLI IMUNISASI"> RUANG IMUNISASI<br/>
									<input type="checkbox" name="otoritas[]" value="POLI ISOLASI"> RUANG ISOLASI<br/>
									<input type="checkbox" name="otoritas[]" value="POLI KB"> RUANG KB<br/>
									<input type="checkbox" name="otoritas[]" value="POLI KESWA"> RUANG KESWA<br/>
									<input type="checkbox" name="otoritas[]" value="POLI KIA"> RUANG KIA<br/>
									<input type="checkbox" name="otoritas[]" value="POLI LABORATORIUM"> RUANG LABORATORIUM<br/>
									<input type="checkbox" name="otoritas[]" value="POLI LANSIA"> RUANG LANSIA<br/>
									<input type="checkbox" name="otoritas[]" value="POLI MTBS"> RUANG MTBS<br/>
									<input type="checkbox" name="otoritas[]" value="POLI TB"> RUANG TB<br/>
									<input type="checkbox" name="otoritas[]" value="POLI UGD"> RUANG UGD / TINDAKAN<br/>
									<input type="checkbox" name="otoritas[]" value="POLI UMUM"> RUANG UMUM<br/>
									<input type="checkbox" name="otoritas[]" value="TATA USAHA"> TATA USAHA<br/>
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
									<input type="text" name="telepon" class="form-control" maxlength ="15" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Foto</td>
								<td class="col-sm-9">
									<input type="file" name="image" class="form-control">
								</td>
							</tr>
						</table><br/>

						<table class="table-judul">
							<h4 class="judul">
								<i class="icon-note"></i>
								Tanda Tangan Elektronik
							</h4>
							<tr>
								<td class="col-sm-3">Pin</td>
								<td class="col-sm-9">
									<input type="text" name="ttepin" class="form-control" maxlength ="10" placeholder="Jika diisi pin akan terupadate">
								</td>
							</tr>	
						</table><br/>

						<table class="table-judul">
							<h4 class="judul">
								<i class="icon-user"></i>
								Display Antrian, abaikan jika menggunakan sis.antrian lainnya
							</h4>
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
								<td class="col-sm-3">Lantai</td>
								<td class="col-sm-10">
									<select name="lantai" class="form-control loketcls">
										<option value="1">Lantai 1</option>
										<option value="2">Lantai 2</option>
										<option value="3">Lantai 3</option>
										<option value="4">Lantai 4</option>
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
						<input type="hidden" name="puskesmas" class="form-control" value="<?php echo $_SESSION['kodepuskesmas'];?>">
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
						<th width="12%">USER ID / NIP</th>
						<th width="25%">NAMA PEGAWAI</th>
						<th width="10%">STATUS</th>
						<th width="10%">TTE</th>
						<?php
						if(in_array("OPERATOR", $otoritas) || in_array("PROGRAMMER", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){ 
						?>
						<th width="15%">AKSI</th>
						<?php }?>
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
							
					$key = $_GET['key'];				
					
					if($kodepuskesmas == "-" OR $namapuskesmas == "UPTD FARMASI"){
						$str = "SELECT * FROM `tbpegawai` WHERE(`NamaPegawai` LIKE '%$key%' OR `Status` LIKE '%$key%' OR `Nip` LIKE '%$key%')";
					}else{
						$str = "SELECT * FROM `tbpegawai` WHERE `KodePuskesmas` = '$kodepuskesmas' AND (`NamaPegawai` LIKE '%$key%' OR `Status` LIKE '%$key%' OR `Nip` LIKE '%$key%')";
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
							<td align="left" class="nip"><?php echo $data['Nip'];?></td>
							<td align="left">
								<?php echo strtoupper($data['NamaPegawai']);?><br/>
								<?php if($data['Status'] == "DOKTER"){ ?>
								<span class="badge badge-primary" style='font-style: italic; padding: 4px;'><?php echo "SIP.".$data['Sip'];?></span><br/>
								<?php } ?>
							</td>
							<td align="center"><?php echo $data['Status'];?></td>
							<td align="center"><?php echo $data['TtePin'];?></td>
							<?php							
								if(in_array("OPERATOR", $otoritas) || in_array("PROGRAMMER", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){ 
							?>
							<td align="center">
								<a href="#" class="btnmodalpegawaiedit btn btn-sm btn-round btn-info">Edit</a>
								<a href="?page=master_pegawai_delete&nip=<?php echo $data['Nip'];?>" data-ketconfirm="Apakah data ini akan dihapus?" class="btn btn-sm btn-round btn-danger btnconfirm">Hapus</a>
							</td>
							<?php }?>									
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
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
						echo "<li><a href='?page=master_pegawai&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>	
	
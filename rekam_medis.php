<?php
	include "config/helper_pasienrj.php";
	$tanggal = date('Y-m-d');
	$tahunini = date('Y');
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DATA REGISTER</b></h3>
			<div class="formbg">
				<form role="form" class="submit">
					<div class = "row">
						<input type="hidden" name="page" value="rekam_medis"/>
						<div class="col-xl-2">
							<input type="text" name="tgl" class="form-control datepicker" value="<?php echo $_GET['tgl'];?>" placeholder = "Pilih Tanggal">
						</div>
						<div class="col-xl-4">
							<input type="text" name="key" class="form-control key barcodefocus" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama Pasien / NoIndex / RM">
						</div>
						<div class="col-sm-2">
							<select name="stsbuku" class="form-control opsiform">
								<option value="semua" <?php if($_GET['stsbuku'] == 'semua'){echo "SELECTED";}?>>Semua</option>
								<option value="i" <?php if($_GET['stsbuku'] == 'i'){echo "SELECTED";}?>>In</option>
								<option value="o" <?php if($_GET['stsbuku'] == 'o'){echo "SELECTED";}?>>Out</option>
							</select>	
						</div>
						<div class="col-xl-2">
							<select name="pelayanan" class="form-control">
								<option value="semua">Semua</option>
								<?php
									$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` WHERE `JenisPelayanan`='KUNJUNGAN SAKIT' ORDER BY `Pelayanan`");
									while($data = mysqli_fetch_assoc($query)){
										if($data['Pelayanan'] == $_GET['pelayanan']){
											echo "<option value='$data[Pelayanan]' SELECTED>$data[Pelayanan]</option>";
										}else{
											echo "<option value='$data[Pelayanan]'>$data[Pelayanan]</option>";
										}	
									}
								?>
							</select>
						</div>
						<div class="col-xl-2">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=rekam_medis" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
		
	<div class="table-responsive">
		<form action="index.php?page=rekam_medis_proses" method="post">
			<table class="table-judul">
				<thead>
					<tr>
						<th width="3%" rowspan="2">NO.</th>
						<th width="20%" rowspan="2">NAMA PASIEN</th>
						<th width="25%" colspan="2">SELESAI ENTRY DATA</th>
						<th colspan="3">KELENGKAPAN ENTRY DATA</th>
						<th width="7%" rowspan="2">#</th>
					</tr>
					<tr>
						<th>PENDAFTARAN</th>
						<th>PEMERIKSAAN</th>
						<th width="15%" >ANAMNESA</th>
						<th width="15%" >DIAGNOSA</th>
						<th width="15%" >THERAPY</th>
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
					$tgl = $_GET['tgl'];	
					$stsbuku = $_GET['stsbuku'];	
					$pelayanan = $_GET['pelayanan'];	
					
					if($tgl != null){
						$tgls = date('Y-m-d',strtotime($tgl));
						$tgl_str = " date(TanggalRegistrasi) = '$tgls' AND ";
					}else{
						$tgl_str = " date(TanggalRegistrasi) = '".date('Y-m-d')."' AND ";
					}
													
					if($key !=''){
						$strcari = " AND (`NamaPasien` like '%$key%' OR `NoIndex` like '%$key%' OR `NoRM` like '%$key%')";
					}else{
						$strcari = " ";
					}
					
					if($stsbuku == 'semua' || $stsbuku == ''){
						$stb = " ";
					}else{
						$stb = " AND `StatusBuku`='$stsbuku'";
					}
					
					if($pelayanan == 'semua' || $pelayanan == ''){
						$ply = " ";
					}else{
						$ply = " AND `PoliPertama`='$pelayanan'";
					}
					
					//kunjungan sehat tidak ditampilkan
					$str = "SELECT * FROM `$tbpasienrj`
					WHERE ".$tgl_str." StatusPasien = '1'".$strcari.$stb.$ply;		
					$str2 = $str." order by NoRegistrasi DESC LIMIT $mulai,$jumlah_perpage";
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
						$idpasienrj = $data['IdPasienrj'];
						$noindex = $data['NoIndex'];
						$nocm = $data['NoCM'];
						$noregistrasi = $data['NoRegistrasi'];
						$kunjungan = $data['StatusKunjungan'];
						if($kunjungan == 'Baru' AND substr($noindex,14,4) == $tahunini){
							$stylewarna = "style='background:#b3ecfd'";
						}else{
							$stylewarna = "";
						}
					?>
						<tr <?php echo $stylewarna;?>>
							<td align="center"><?php echo $no;?></td>
							<td align="left">
								<?php echo "<b>".$data['NamaPasien']."</b>"?>
								<span class="badge badge-success" style='font-style: italic; padding: 4px;'><?php echo substr($data['NoIndex'],-10);?></span><br/>
								<?php 
									echo"Cara Bayar : ".str_replace('POLI','', $data['Asuransi'])."<br/>".
									"Pelayanan : ".str_replace('POLI','', $data['PoliPertama']);
								?>
							</td>
							<td align="center"><?php echo $data['TanggalRegistrasi'];?></td>
							<td align="center"><?php echo $data['JamKembaliRM'];?></td>
							<td align="center">
								<?php
									// cek anamnesa
									$namapkm = str_replace(' ','',strtoupper($namapuskesmas));
									if ($data['PoliPertama'] == "POLI UMUM"){
										$pelayanan = "tb".str_replace(' ','',strtolower($data['PoliPertama']))."_$namapkm";	
									}else{
										$pelayanan = "tb".str_replace(' ','',strtolower($data['PoliPertama']));
									}

									$stranamnesa = "SELECT * FROM `$pelayanan` WHERE `NoPemeriksaan`='$data[NoRegistrasi]'";
									// echo $stranamnesa;
									$queryanamnesa = mysqli_query($koneksi, $stranamnesa);
									$dtanamnesa = mysqli_fetch_assoc($queryanamnesa);
									
									if ($dtanamnesa['Anamnesa'] != ''){
										$anamnesa = $dtanamnesa['Anamnesa'];	
									}else{
										$anamnesa = $data_dgs ="<span class='badge badge-danger' style='font-style: italic; padding: 8px;'>Kosong</span>";
									}
									echo $anamnesa;									
								?>	
							</td>
							<td align="center">
								<?php
									// tbdiagnosa
									$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
									$qrdata_kd_diagnosa = mysqli_query($koneksi, "SELECT * FROM `$tbdiagnosapasien` WHERE `IdPasienrj` = '$idpasienrj' GROUP BY `KodeDiagnosa`");
									while($data_diagnosapsn = mysqli_fetch_array($qrdata_kd_diagnosa)){
										$data_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
										$array_diagnosa[$no][] = $data_diagnosa['Diagnosa'];
										$array_kode_diagnosa[$no][] = $data_diagnosapsn['KodeDiagnosa'];
									}
									
									if ($array_kode_diagnosa[$no] != ''){
										$data_dgs = implode(", ", $array_kode_diagnosa[$no]);
									}else{
										$data_dgs ="<span class='badge badge-danger' style='font-style: italic; padding: 8px;'>Kosong</span>";
									}
									echo $data_dgs;
								?>
							</td>
							<td align="center">
								<?php
									// therapy
									$qrdata_therapy = mysqli_query($koneksi, "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$data[NoRegistrasi]' AND DATE(TanggalResep) IS NOT NULL GROUP BY NoResep, KodeBarang, Pelayanan");
									while($data_therapy = mysqli_fetch_array($qrdata_therapy)){
										$data_obat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbapotikstok` WHERE `KodeBarang` = '$data_therapy[KodeBarang]' GROUP BY KodeBarang"));
										$array_obat[$no][] = $data_obat['NamaBarang'];
									}
									
									if ($array_obat[$no] != ''){
										$data_obt = implode(", ", $array_obat[$no]);
									}else{
										$data_obt ="<span class='badge badge-danger' style='font-style: italic; padding: 8px;'>Kosong</span>";
									}

									echo $data_obt;
								?>		

							</td>
							<td align="center">
								<a href="?page=poli_periksa&idrj=<?php echo $data['IdPasienrj'];?>&no=<?php echo $data['NoRegistrasi'];?>&pelayanan=<?php echo $data['PoliPertama'];?>&status=Antri" target="_blank" class="btn btn-round btn-success"><i class="icon-user-follow"></i></a>
							</td>		
						</tr>
					<?php
					}
					?>
				</tbody>
			</table><hr/>
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
								echo "<li><a href='?page=rekam_medis&h=$i'>$i</a></li>";
							}
						}
					}
				?>	
			</ul>
			<input type="submit" value="APPROVE" onClick="return confirm('Anda yakin data sudah benar dan ingin disimpan...?')" class="btn btn-round btn-success btnsimpan">
		</form>
	</div>
		
	<!--modal-->
	<div class="panel-default hasilmodal"></div>

	<div class="row">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<p>Klik tombol In, jika berkas rekam medis telah dikembalikan	
				</p>	
			</div>
		</div>
	</div>
</div>
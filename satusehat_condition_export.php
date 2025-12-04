<?php
session_start();
include "config/koneksi.php";
include "otoritas.php";
include "config/helper_pasienrj.php";
include "config/helper_satusehat.php";

// ambil dari get data
// $namapuskesmas = $_GET['namapuskesmas'];
// $tbpasienrj = 'tbpasienrj_'.str_replace(' ', '', $namapuskesmas);
?>

<style>
	.blockhitam_aktif{
		background:black;opacity:0.4;z-index:5000;position:absolute;left:0;right:0;top:0;bottom:0;
	}
</style>
<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white fw-bold">Kirim Data Diagnosa (Condition)</h2>
				<!-- <h5 class="text-white op-7"><?php echo $namapuskesmas; ?></h5> -->
			</div>
			<div class="ml-md-auto py-2 py-md-0">
				<?php 
					if($_GET['tgl'] == ''){
						$hariini = date('Y-m-d');
					}else{
						$hariini = date('Y-m-d', strtotime($_GET['tgl']));
					}
					$str_terkirim = "SELECT count(*)AS Jml FROM `$tbpasienrj` WHERE date(TanggalRegistrasi) = '$hariini' AND `IdConditionSatuSehat`!=''";	
					$str_all = "SELECT count(*)AS Jml FROM `$tbpasienrj` WHERE date(TanggalRegistrasi) = '$hariini' AND `IdKunjunganSatuSehat`!=''";	
					$cek_jumlah_encounter = mysqli_fetch_assoc(mysqli_query($koneksi, $str_terkirim));					
					$cek_jumlah_all = mysqli_fetch_assoc(mysqli_query($koneksi, $str_all));					
					if($cek_jumlah_encounter['Jml'] != '0'){ 
				?>
				<button class="btn btn-primary btn-round"><?php echo $cek_jumlah_encounter['Jml']." Data Terikirim dari ".$cek_jumlah_all['Jml']." Encounter"; ?></button>
				<?php } ?>
				<!-- <a href="satusehat_condition_export_proses.php?tgl=<?php echo $_GET['tgl'];?>&namapuskesmas=<?php echo $_GET['namapuskesmas'];?>" class="btn btn-success btn-round btnkirimsatusehat">Kirim Semua</a> -->
				<a href="satusehat_condition_export_proses.php?namapuskesmas=<?php echo $_GET['namapuskesmas'];?>&tgl=<?php echo $_GET['tgl'];?>&tglakhir=<?php echo $_GET['tglakhir'];?>" class="btn btn-success btn-round btnkirimsatusehat">Kirim Semua</a>
			</div>
		</div>
	</div>
</div>

<div class="page-inner mt--5">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<form  class="submit">
						<div class="row">
							<input type="hidden" name="page" value="satusehat_condition_export"/>
							<div class="col-xl-3">
								<select name="namapuskesmas" class="form-control inputan">
									<option value="">--Pilih Puskesmas--</option>
									<?php 
										$query_puskesmas = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmasdetail` ORDER BY NamaPPK ASC");
										while($dtpuskesmas = mysqli_fetch_assoc($query_puskesmas)){
											if($dtpuskesmas['NamaPPK'] == $_GET['namapuskesmas']){
												echo "<option value='$dtpuskesmas[NamaPPK]' SELECTED>$dtpuskesmas[NamaPPK]</option>";
											}else{
												echo "<option value='$dtpuskesmas[NamaPPK]'>$dtpuskesmas[NamaPPK]</option>";
											}
										}
									?>
								</select>
							</div>
							<div class="col-xl-3">
								<input type="text" name="tgl" class="form-control inputan datepicker" value="<?php echo $_GET['tgl'];?>" placeholder = "Pilih Tanggal Awal">
							</div>
							<div class="col-xl-3">
								<input type="text" name="tglakhir" class="form-control inputan datepicker" value="<?php echo $_GET['tglakhir'];?>" placeholder = "Pilih Tanggal Akhir">
							</div>
							<div class="col-xl-3">
								<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
								<a href="?page=satusehat_condition_export" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							</div>
						</div>	
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	$namapuskesmas = $_GET['namapuskesmas'];
	if($namapuskesmas == ''){
		$namapuskesmas = $_SESSION['namapuskesmas'];
		$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
	}else{
		$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
	}

	$tgl = $_GET['tgl'];
	$tglakhir = $_GET['tglakhir'];
	if($tgl == ''){
		$tgl = date('Y-m-d');
	}

	$jumlah_perpage = 50;
		
	if($_GET['h']==''){
		$mulai=0;
	}else{
		$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
	}
				
	if($tgl != null){
		$tgl_str = " date(TanggalRegistrasi) BETWEEN '".date('Y-m-d',strtotime($tgl))."' AND '".date('Y-m-d',strtotime($tglakhir))."'";
	}else{
		$tgl_str = " date(TanggalRegistrasi) BETWEEN '".date('Y-m-d')."' AND '".date('Y-m-d')."'";
	}
		
	$str = "SELECT * FROM `$tbpasienrj` WHERE ".$tgl_str." AND (`Nik`!='0' AND `Nik`!='9999999999999999' AND `Nik`!='-' AND length(Nik) = 16)";		
	$str2 = $str." ORDER BY `NoRegistrasi` DESC LIMIT $mulai,$jumlah_perpage";
	// echo $str2;
				
	if($_GET['h'] == null || $_GET['h'] == 1){
		$no = 0;
	}else{
		$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
	}
	
	$query = mysqli_query($koneksi, $str2);
?>
			
<div class="page-inner mt--5">
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul" width="100%">
					<thead>
						<tr>
							<th width="5%">No.</th>
							<th width="15%">Tanggal Registrasi</th>
							<th width="15%">Nik</th>
							<th width="30%">Nama Pasien</th>
							<th width="10%">Pelayanan</th>
							<th width="10%">Encounter</th>
							<th width="15%">Id Condition</th>
							<th width="10%">#</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$idpasien = $data['IdPasien'];
							$nikps = $data['Nik'];
							$noindex = $data['NoIndex'];
							$nocm = $data['NoCM'];
							$noregistrasi = $data['NoRegistrasi'];
							$kunjungan = $data['StatusKunjungan'];
							$nourutbpjs = strlen($data['NoUrutBpjs']);
							$nobpjs = $data['nokartu'];
							$encounter = $data['IdKunjunganSatuSehat'];
							// echo "No.".$nourutbpjs;
							
							if(substr($data['Asuransi'],0,4) == 'BPJS' AND ($nourutbpjs >= 5 OR $data['NoUrutBpjs'] == "" OR $data['NoUrutBpjs'] == "0" OR $data['NoUrutBpjs'] == "P")){
								$statusbridging = "gagal";
							}else{
								$statusbridging = $data['NoUrutBpjs'];
							}	
							
							// nik pasien
							if($nikps == '1' OR $nikps == '0' OR $nikps == ''){
								$nikpasien = '9999999999999999';
							}else{
								$nikpasien = $nikps;	
							}

							// nobpjs pasien
							if($nobpjs == '' OR $nobpjs == '-' OR $nobpjs == '0'){
								$nomorbpjs = '0';
							}else{
								$nomorbpjs = $nobpjs;	
							}

							// jenis kelamin
							if($data['JenisKelamin'] == 'L'){
								$jeniskelamin = "LAKI-LAKI";
							}else{
								$jeniskelamin = "PEREMPUAN";
							}

							?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo $data['TanggalRegistrasi'];?></td>
								<td><?php echo $data['Nik'];?></td>
								<td><?php echo strtoupper($data['NamaPasien']);?></td>
								<td align="center">
									<?php 
										echo str_replace('POLI','',$data['PoliPertama']);
									?>
								</td>
								<td>
									<?php  echo substr($encounter,0,12);?>
								</td>
								<td align="center">
									<?php if($data['IdConditionSatuSehat'] !=''){ ?>
										<a href="#" class="btnmodalencounter btn btn-sm btn-round btn-success" data-idpasienrj="<?php echo $data['IdPasienrj'];?>" data-idencounter="<?php echo $data['IdConditionSatuSehat'];?>"><?php echo substr($data['IdConditionSatuSehat'],0,8)."xxx";?></a>
									<?php }else{ ?>
										<a href="#" class="btn btn-sm btn-round btn-danger" data-idpasienrj="<?php echo $data['IdPasienrj'];?>"><?php echo "Tidak terkoneksi";?></a>
									<?php } ?>
								</td>
								<td align="center">
									<a href="kirim_reg_condition.php?idrj=<?php echo $data['IdPasienrj'];?>&nikps=<?php echo $data['Nik'];?>&h=<?php echo $_GET['h'];?>&tgl=<?php echo $_GET['tgl'];?>&tglakhir=<?php echo $_GET['tglakhir'];?>&namapkm=<?php echo $_GET['namapuskesmas'];?>" class="btn btn-sm btn-round btn-info" target="_blank">Kirim Condition</a>
								</td>	
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
				<ul class="pagination mt-4 noprint">
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
									echo "<li><a href='?page=satusehat_condition_export&tgl=$tgl&tglakhir=$tglakhir&nama=$key&asalpasien=$_GET[asalpasien]&asuransi=$_GET[asuransi]&h=$i'>$i</a></li>";
								}
							}
						}
					?>	
				</ul>

				<div class="card">
					<div class="card-body">
						<p><b>Perhatikan :</b><br/>
						Terkirim, yang mendapatkan id Diagnosa (Condition)<br/>
						Encounter, yang mendapatkan id Kunjungan (Encounter)<br/>
						Jika terjadi kendala koneksi, silahkan klik menu <a href="index.php?page=satusehat_condition_export" style='color:#005184;font-weight:bold'>"Export Data Satusehat"</a> untuk mengirim kembali data kunjungan pasien ke Satusehat PCare.</p>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="alert-modal-tunggu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" style="text-align:center;padding:0px">
			
			<div class="modal-body ">
				<div style="background: #137ee9; padding: 20px; margin-bottom: 20px; color:#fff;">
					<i class="fa fa-spinner fa-spin fa-6x"></i>
				</div>
				<div class="modalbody-alert">Tunggu ya, kami sedang mengirimkan data ke satusehat...</div>
			
			</div>
		</div>
	</div>
</div>
<div class="blockhitam"></div>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>
	$(".btnkirimsatusehat").click(function(){
		$(".blockhitam").addClass("blockhitam_aktif");
		$("#alert-modal-tunggu").modal('show');
	});
</script>


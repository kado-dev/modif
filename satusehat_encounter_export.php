<?php
session_start();
include "config/koneksi.php";
include "otoritas.php";
include "config/helper_pasienrj.php";
include "config/helper_satusehat.php";

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
				<h2 class="text-white fw-bold">KIRIM DATA KUNJUNGAN (ENCOUNTER)</h2>
			</div>
			<div class="ml-md-auto py-2 py-md-0">
				<?php
					if($_GET['tgl'] == ''){
						$hariini = date('Y-m-d');
					}else{
						$hariini = date('Y-m-d', strtotime($_GET['tgl']));
					}
					$str_terkirim = "SELECT count(*)AS Jml FROM `$tbpasienrj` WHERE date(TanggalRegistrasi) = '$hariini' AND `IdKunjunganSatuSehat`!=''";	
					$str_all = "SELECT count(*)AS Jml FROM `$tbpasienrj` WHERE date(TanggalRegistrasi) = '$hariini' AND (`Nik`!='0' AND `Nik`!='9999999999999999' AND `Nik`!='-' AND length(Nik) = 16)";	
					$cek_jumlah_encounter = mysqli_fetch_assoc(mysqli_query($koneksi, $str_terkirim));					
					$cek_jumlah_all = mysqli_fetch_assoc(mysqli_query($koneksi, $str_all));					
					if($cek_jumlah_encounter['Jml'] != '0'){ 
				?>
				<button class="btn btn-primary btn-round"><?php echo $cek_jumlah_encounter['Jml']." Data Terikirim dari ".$cek_jumlah_all['Jml']." kunjungan"; ?></button>
				<?php } ?>
				<a href="satusehat_encounter_export_proses.php?tgl=<?php echo $_GET['tgl'];?>" class="btn btn-success btn-round btnkirimsatusehat">Kirim Semua</a>
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
							<input type="hidden" name="page" value="satusehat_encounter_export"/>
							<div class="col-xl-3">
								<input type="text" name="tgl" class="form-control inputan datepicker" value="<?php echo $_GET['tgl'];?>" placeholder = "Pilih Tanggal">
							</div>
							<div class="col-xl-5">
								<select name="statuskirim" class="form-control inputan asuransi" required>
									<option value='semua' <?php if($_GET['asuransi'] == 'semua'){echo "SELECTED";}?>>SEMUA</option>
									<option value='semuabpjs' <?php if($_GET['asuransi'] == 'semuabpjs'){echo "SELECTED";}?>>SEMUA BPJS</option>
								</select>
							</div>
							<div class="col-xl-4">
								<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
								<a href="?page=satusehat_encounter_export" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							</div>
						</div>	
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

	$tgl = $_GET['tgl'];
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
		$tgl_str = " date(TanggalRegistrasi) = '".date('Y-m-d',strtotime($tgl))."' ";
	}else{
		$tgl_str = " date(TanggalRegistrasi) = '".date('Y-m-d')."' ";
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
							<th width="5%">NO.</th>
							<th width="15%">TANGGAL REGISTRASI</th>
							<th width="15%">NIK</th>
							<th width="30%">NAMA PASIEN</th>
							<th width="10%">PELAYANAN</th>
							<th width="15%">ID ENCOUNTER</th>
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
								<td align="center">
									<?php if($data['IdKunjunganSatuSehat'] !=''){ ?>
										<a href="#" class="btnmodalencounter btn btn-sm btn-round btn-success" data-idpasienrj="<?php echo $data['IdPasienrj'];?>" data-idencounter="<?php echo $data['IdKunjunganSatuSehat'];?>"><?php echo substr($data['IdKunjunganSatuSehat'],0,8)."xxx";?></a>
									<?php }else{ ?>
										<a href="#" class="btn btn-sm btn-round btn-danger" data-idpasienrj="<?php echo $data['IdPasienrj'];?>"><?php echo "Tidak terkoneksi";?></a>
									<?php } ?>
								</td>
								<td align="center">
									<a href="kirim_reg_encounter.php?idrj=<?php echo $data['IdPasienrj'];?>&nikps=<?php echo $data['Nik'];?>&h=<?php echo $_GET['h'];?>&tgl=<?php echo $_GET['tgl'];?>" class="btn btn-sm btn-round btn-info">Kirim Ulang Encounter</a>
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
									echo "<li><a href='?page=satusehat_encounter_export&tgl=$tgl&nama=$key&asalpasien=$_GET[asalpasien]&asuransi=$_GET[asuransi]&h=$i'>$i</a></li>";
								}
							}
						}
					?>	
				</ul>

				<div class="card">
					<div class="card-body">
						<p><b>Perhatikan :</b><br/>
						Terkirim, yang mendapatkan id encounter<br/>
						Kunjungan, yang nik tidak sama dengan kosong dan memiliki panjang karakter 16 digit<br/>
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


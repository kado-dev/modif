<div class="logologin" align="center">
</div>		
<div>
	<form class="form-inline" method="get" style="margin-bottom:20px;">
		<input type="hidden" name="status" value="<?php echo $_GET['status'];?>">
		<input type="hidden" name="page" value="cari_pasien">
		<table align="center">
		<tr>
			<td width="80%">
				<input type="text" name="nomor" class="form-control nomorjaminan" value="<?php echo $_GET['nomor'];?>" placeholder="Nomor Jaminan">
			</td>
			<td>
				<button type="submit" class="btn btn-sm btn-info">SEARCH</button>
			</td>
		</tr>
		</table>
	</form>
	
<?php
session_start();
$namapuskesmas = $_SESSION['namapuskesmas'];
$status = $_GET['status'];
$nomor = $_GET['nomor'];
$tglhariini = date('Y-m-d');
$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
if(isset($nomor)){
if($status == 'umum'){
	$data = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasien` WHERE `Nik` = '$nomor'"));
	// panggil tbpasien_tahun
	$nocm_psn = substr($data['NoCM'],12,4);
	$dt_psn_thn = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tbpasien_".$nocm_psn." WHERE NoCM = '$data[NoCM]'"));
	
	$qpasienrj = mysqli_query($koneksi,"SELECT * from tbpasienrj WHERE NoIndex = '$data[NoIndex]' AND TanggalRegistrasi = '$tglhariini'");
	$cekpasienrj = mysqli_num_rows($qpasienrj);
	$pasienrj = mysqli_fetch_assoc($qpasienrj);
	$noregistrasi = $pasienrj['NoRegistrasi'];
	if($cekpasienrj > 0){
		echo "<script>";
		echo "document.location.href='index.php?page=etiket&id=$noregistrasi&kodepuskesmas=$kodepuskesmas';";
		echo "</script>";
	}
	$tbkk = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * from `$tbkk` WHERE NoIndex = '$data[NoIndex]'"));

}else{
	include "../config/helper_bpjs.php";
	$data_bpjs = get_data_peserta_bpjs($nomor);
	$data_bpjs_v1 = get_data_peserta_bpjs_v1($nomor);

	$dbpjs = json_decode($data_bpjs,TRUE);
	$dbpjs_v1 = json_decode($data_bpjs_v1,TRUE);//echo $data_bpjs;
	$nokartubpjs = $dbpjs['response']['noKartu'];
			
	//cek no index
	$strceknobpjs = mysqli_query($koneksi, "SELECT `NoIndex`  FROM `$tbpasien` WHERE `NoAsuransi` = '$nokartubpjs'");
	$data_pasienbpjs = mysqli_fetch_assoc($strceknobpjs);
	if($data_pasienbpjs['NoIndex'] == null){
		$data_pasienbpjs['NoIndex'] = 0;
	}
}
}
?>	

	<div class="panel panel-primary col-sm-offset-2 col-sm-8">

		<div class="panel-body" style="min-height:260px">	
			<?php
			if(isset($nomor)){
			if($status == 'umum'){
			?>
			<div class="row">	
				<div class="col-sm-12">	
					<table class="table1" width="100%">
						<tr>
							<td width="32%">NIK</td>
							<td width="3%">:</td>
							<td ><?php echo $data['Nik'];?></td>
						</tr>
						<tr>
							<td>Nama Pasien</td>
							<td>:</td>
							<td><?php echo $data['NamaPasien'];?></td>
						</tr>
						<tr>
							<td>Tanggal Lahir</td>
							<td>:</td>
							<td><?php echo $dt_psn_thn['TanggalLahir'];?></td>
						</tr>
						<tr>
							<td>Jenis Kelamin</td>
							<td>:</td>
							<td><?php echo $dt_psn_thn['JenisKelamin'];?></td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td>:</td>
							<td><?php  if ($tbkk['Alamat'] == null){echo $alamat="-";}else{echo $alamat=$tbkk['Alamat'];}?></td>
						</tr>
					</table>
				</div>	
			</div>	
			<?php
			}else{
			?>	
				<div class="row">	
					<div class="col-sm-12">	
						<table class="table1" width="100%">
							<tr>
								<td width="32%">No Kartu</td>
								<td width="3%">:</td>
								<td><?php echo $nokartubpjs;?></td>
							</tr>
							
							<tr>
								<td>No.Index</td>
								<td >:</td>
								<td><b style="color:green;" class="noindexjquery"><?php echo $data_pasienbpjs['NoIndex'];?></b></td>
							</tr>

							<tr>
								<td>No KTP</td>
								<td>:</td>
								<td><?php 
									$noktp=$dbpjs_v1['response']['noKTP'];
									if($noktp == null){
										$noktps = "0";
									}else{
										$noktps = $noktp;
									}
									echo $noktps;
									?>
								</td>
							</tr>
							<tr>
								<td>Nama</td>
								<td>:</td>
								<td><?php echo $dbpjs['response']['nama'];?></td>
							</tr>	
							<tr>
								<td>Status Peserta</td>
								<td>:</td>
								<td><?php echo $dbpjs['response']['hubunganKeluarga'];?></td>
							</tr>	
							<tr>
								<td>Jenis Peserta</td>
								<td>:</td>
								<td><?php echo $dbpjs['response']['jnsPeserta']['nama'];?></td>
							</tr>	
						

						<tr>
							<td >Tanggal Lahir</td>
							<td>:</td>
							<td><?php echo $dbpjs['response']['tglLahir'];?></td>
						</tr>
						<tr>
							<td>Kelamin</td>
							<td>:</td>
							<td>
							<?php 
							if($dbpjs['response']['sex'] == 'L'){
								$jeniskel = "Laki-laki";
							}else if($dbpjs['response']['sex'] == 'P'){
								$jeniskel = "Perempuan";
							}
							echo $jeniskel;
							?>
							</td>
						</tr>	
						<tr>
							<td>PPK UMUM</td>
							<td>:</td>
							<td><?php echo $dbpjs['response']['kdProviderPst']['kdProvider']." - ".$dbpjs['response']['kdProviderPst']['nmProvider'];?></td>
						</tr>
						<tr>
							<td>Ket. Aktif</td>
							<td>:</td>
							<td>
								<?php 
								$ketaktif = $dbpjs['response']['ketAktif'];
								if($ketaktif == 'AKTIF'){
									echo "<span style='color:green;font-weight:bold'>$ketaktif</span>";
								}else{
									echo "<span style='color:red;font-weight:bold'>$ketaktif</span>";
								}
								?>
							</td>
						</tr>
						<tr>
							<td>Tunggakan</td>
							<td>:</td>
							<td>
							<?php 
								$tunggakan = $dbpjs['response']['tunggakan'];
								if($tunggakan > 0){
									echo "<span style='color:red;font-weight:bold'>$tunggakan</span>";
								}else{
									echo "<span style='color:black;font-weight:bold'>$tunggakan</span>";
								}
							?>
							</td>
						</tr>	
						<tr>
							<td>Peserta BPJS Puskesmas Ini</td>
							<td>:</td>
							<td>
							<?php 
								$kdprov = $dbpjs['response']['kdProviderPst']['kdProvider'];
								if($kdprov == $_COOKIE['kodeppk']){
									echo "<span style='color:black;font-weight:bold'>Ya</span>";
								}else{
									echo "<span style='color:red;font-weight:bold'>Bukan</span>";
								}
							?>
							</td>
						</tr>
					</table>
					</div>
				</div>
			<?php
			}
			}
			?>	
		</div>
	</div>
	<div class="col-sm-12">
		<p align="center">
		<a href="?page=home" class="btn btn-lg btn-primary">HOME</a>
		<a href="?page=data_pasien&status=<?php echo $status;?>&nomor=<?php echo $nomor;?>" class="btn btn-lg btn-info lanjutjaminan">LANJUT</a>
		</p>
	</div>	

</div>

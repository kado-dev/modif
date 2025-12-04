<?php
	include "config/koneksi.php";
	session_start();
	$id = $_POST['id'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
		
	// pasienrj
	$datapasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$id'"));
	$nocm = $datapasienrj['NoCM'];
	
	// tbpasien
	$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `NoCM` = '$nocm'"));
	if ($datapasienrj['Asuransi'] == 'UMUM' || $datapasienrj == 'GRATIS' || $datapasienrj == 'PROGRAM'){
		$noindex = $datapasienrj['NoIndex'];
		$nobpjs = "0";
	}else{
		$noindex = $datapasien['NoIndex'];
		$nobpjs = $datapasienrj['nokartu'];
	}
	
	// tbkk
	$datakk = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbkk` WHERE `NoIndex` = '$datapasien[NoIndex]'"));
?>

<style>
	table, th, td {
		font-family: Poppins;
		font-size: 14px;
	}	
</style>

<!--untuk menampilkan modal-->
<div class="modal fade" id="modalkartupasien" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">
					<i class="icon-user"></i>
					<?php echo $datapasienrj['NamaPasien'];?>
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<table class="table-judul">
					<tr>
						<td class="col-sm-2">NIK</td>
						<td class="col-sm-10"><?php echo $datapasien['Nik'];?></td>
					</tr>
					<tr>
						<td>No.Registrasi</td>
						<td><?php echo $datapasienrj['IdPasienrj'];?></td>
					</tr>
					<?php if($kota =="KABUPATEN BANDUNG"){ ?>
					<tr>
						<td>No.RM</td>
						<td>
							<?php if ($datapasien['NoRM'] != null){ ?>
							<span>
								<?php 
									if($kota == "KABUPATEN BANDUNG"){
										echo substr($datapasien['NoRM'],-8);
									}else{
										echo $datapasien['NoRM'];
									}	
								?>
							</span>
							<?php }else{ ?>
							<span>Belum Terdaftar</span>
							<?php } ?>
						</td>
					</tr>
					<?php } ?>
					<tr>
						<td>No.Index</td>
						<td><?php echo substr($noindex,-10);?></td>
					</tr>
					<tr>
						<td>No.BPJS</td>
						<td><?php echo $nobpjs;?></td>
					</tr>
					<tr>
						<td>Tgl.Lahir</td>
						<td><?php echo $datapasien['TanggalLahir'];?></td>
					</tr>
					<tr>
						<td>Perkiraan Umur</td>
						<td><?php echo $datapasienrj['UmurTahun']." Th ".$datapasienrj['UmurBulan']. " Bl ".$datapasienrj['UmurHari']." Hr";?></td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td><?php echo $datakk['Alamat']." RT.".$datakk['RT']." NO.".$datakk['No']." ".$datakk['Kelurahan']." ".$datakk['Kota'];?></td>
					</tr><br/>
					<tr>
						<td>Petugas Entry</td>
						<td>
							<?php 
								if($datapasienrj['NamaPegawaiSimpan'] != ""){
									echo $datapasienrj['NamaPegawaiSimpan'];
								}else{
							?>		
									<a href="?page=registrasi_data_update_namapegawai&noreg=<?php echo $datapasienrj['NoRegistrasi'];?>" class="btn btn-sm btn-success">UPDATE</a>
							<?php		
								}	
							?>
						</td>
					</tr>
				</table>
			</div>
			<div class="modal-footer noprint">
				<button type="button" class="btn btn-round btn-danger" data-dismiss="modal">Keluar</button>
			</div>
		</div>
	</div>
</div>


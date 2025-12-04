<?php
	include "config/helper_pasienrj.php";
	$id = $_GET['id'];
	$keycari = $_GET['key'];
	$kategori = $_GET['kategori'];

	// tbkk
	$query = mysqli_query($koneksi,"SELECT * FROM `$tbkk` WHERE `NoIndex` = '$id'");
	$datakk = mysqli_fetch_assoc($query);

	// ec_districts
	$dt_dis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `dis_name` FROM `ec_districts` WHERE `dis_id`='$datakk[Kecamatan]'"));
	if($dt_dis['dis_name'] != ''){
		$kecamatan = $dt_dis['dis_name'];
	}else{
		$kecamatan = $datakk['Kecamatan'];
	}

	// ec_subdistricts
	$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
	if($dt_subdis['subdis_name'] != ''){
		$kelurahan = $dt_subdis['subdis_name'];
	}else{
		$kelurahan = $datakk['Kelurahan'];
	}							

	$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
	strtoupper($kelurahan).", ".strtoupper($kecamatan);
	
?>

<style>
.badge {
  padding: 0.75em 0.75em;
}
</style>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=dashboard" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>DATA PASIEN</b></h3>
			<div class="row">
				<div class="col-sm-12">
					<div class="card full-height">
						<div class="card-body">
							<h4 class="judul">
								<i class="icon-user"></i>
								<?php echo $datakk['NamaKK']." - ".substr($datakk['NoIndex'],-10);?>
							</h4>
							<div class="card-category">
								<?php echo $alamat;?><br/>
							</div><hr/>
							<input type="hidden" class="noindex" value="<?php echo $datakk['NoIndex'];?>"/>
							<a href="#" class="btn btn-round btn-info btnmodalkartupasienkk">Kartu Pasien</a>
							<a href="?page=kk_edit&id=<?php echo $datakk['NoIndex'];?>" class="btn btn-round btn-success">Edit</a>
							<a href="?page=kk_delete&id=<?php echo $datakk['NoIndex'];?>" class="btn btn-round btn-danger" onClick="return confirm('Data ingin dihapus...?')">Hapus</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<a href="?page=anggota_insert&noindex=<?php echo $datakk['NoIndex'];?>" class="btn btn-round btn-success btnsimpan">Tambah Anggota Keluarga</a><br/>
	<div class="row">
		<?php	
		$noindex = $datakk['NoIndex'];
		$query = mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE NoIndex = '$noindex'");
		while($data = mysqli_fetch_assoc($query)){
			// ngambil dari nocm
			$dtpasiendetail = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE NoCM = '$data[NoCM]'"));			
			if($data['IdPasien'] != '0'){
		?>
		
		<div class="col-sm-6">
			<div class="formbg">
				<h4 class="judul">
					<i class="icon-people"></i>
					<?php echo $data['NamaPasien'];?>
				</h4>
				<table class="table-judul">
					<tr>
						<td class="col-sm-3">Tanggal Daftar</td>
						<td class="col-sm-9"><?php echo $data['TanggalDaftar'];?></td>
					</tr>
					<tr>
						<td>NIK</td>
						<td><?php echo $data['Nik'];?></td>
					</tr>
					<?php if($kota != "KOTA TARAKAN"){?>
					<tr>
						<td>No.RM</td>
						<td><?php echo substr($data['NoRM'],-8);?></td>
					</tr>
					<?php } ?>
					<tr>
						<td>No.BPJS</td>
						<td><?php echo $dtpasiendetail['NoAsuransi'];?></td>
					</tr>	
					<tr>
						<td>Asuransi</td>
						<td><?php echo $dtpasiendetail['Asuransi'];?></td>
					</tr>
					<tr>
						<td>Tgl.Lahir</td>
						<td><?php echo date('d-m-Y', strtotime($dtpasiendetail['TanggalLahir']));?></td>
					</tr>
					<tr>
						<td>Jenis Kelamin</td>
						<td><?php echo $dtpasiendetail['JenisKelamin'];?></td>
					</tr>
					<tr>
						<td>Status Keluarga</td>
						<td><?php echo $dtpasiendetail['StatusKeluarga'];?></td>
					</tr>							
					<tr>
						<td>Pendidikan</td>
						<td><?php echo $dtpasiendetail['Pendidikan'];?></td>
					</tr>	
					<tr>
						<td>Pekerjaan</td>
						<td><?php echo $dtpasiendetail['Pekerjaan'];?></td>
					</tr>								
				</table><hr/>
				<div align="center">
					<input type="hidden" class="nocm" value="<?php echo $data['NoCM'];?>"/>
					<a href="#" class="btn btn-round btn-info btnmodalkartupasien">Kartu Pasien</a>
					<a href="?page=registrasi&idpasien=<?php echo $data['IdPasien'];?>" class="btn btn-round btn-primary">Registrasi</a>
					<a href="?page=anggota_edit&nocm=<?php echo $data['NoCM'];?>&noindex=<?php echo $data['NoIndex'];?>&id=<?php echo $data['IdPasien'];?>" class="btn btn-round btn-success">Edit</a>
					<a href="?page=anggota_delete&idps=<?php echo $data['IdPasien'];?>&noindex=<?php echo $data['NoIndex'];?>" class="btn btn-round btn-danger" onClick="return confirm('Data ingin dihapus...?')">Hapus</a>
				</div>
			</div>
		</div>			
		<?php
			}
		}
		?>
	</div>
	<div class="hasilmodal"></div>
	<div class="hasilmodalkk"></div>
</div>	
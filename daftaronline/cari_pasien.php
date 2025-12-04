	<?php
	$kode = trim($_POST['kode']);
	$simpus = trim($_POST['simpus']);	
	$id = trim($_POST['id']);
	$getdatasetting = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbantrian_setting` WHERE `KodePuskesmas` = '$kode'"));
	if($id == null){
		$id = trim($_GET['id']);
	}
	if($kode == null){
		$kode = trim($_GET['kode']);
	}
	if($simpus == null){
		$simpus = trim($_GET['simpus']);
	}
	$tbpasienonline = "tbpasienonline_".$kode;
	$tbpasien = 'tbpasien_'.str_replace(' ', '', $simpus);
	// updae 19 maret 2024, di DESC itu agar mengambil idpasien yg terakhir untuk kasus jika diketik nik datanya ada 2 karena keterkaitan nomer index yg terakhir yg akan digunakan
	if(strlen($id) == 13){ // bpjs
		$strcari = "SELECT * FROM `$tbpasien` WHERE `NoAsuransi` = '$id'";
		// echo $strcari;
		$query = mysqli_query($koneksi, $strcari);
		$data = mysqli_fetch_assoc($query);
	}else if(strlen($id) == 16){
		$strcari = "SELECT * FROM `$tbpasien` WHERE `Nik` = '$id' ORDER BY IdPasien DESC Limit 1";
		$query = mysqli_query($koneksi, $strcari);
		$data = mysqli_fetch_assoc($query);	
	}else if(strlen($id) == 10){
		$strcari = "SELECT * FROM `$tbpasien` WHERE SUBSTRING(`NoIndex`,-10) = '$id' ORDER BY IdPasien DESC Limit 10";
		$query = mysqli_query($koneksi, $strcari);
		$data = mysqli_fetch_assoc($query);
	}else if(strlen($id) == 5){ // noindex
		$strcari = "SELECT * FROM `$tbpasien` WHERE SUBSTRING(`NoIndex`,-5) = '$id' ORDER BY IdPasien DESC Limit 10";
		$query = mysqli_query($koneksi, $strcari);
		$data = mysqli_fetch_assoc($query);		
	}else{
		$strcari = "SELECT * FROM `$tbpasien` WHERE `IdPasien` = '$id' ORDER BY IdPasien DESC Limit 1";
		$query = mysqli_query($koneksi, $strcari);
		$data = mysqli_fetch_assoc($query);
		if(mysqli_num_rows($query) == 0){
			echo "<script>";
			echo "alert('Data tidak ditemukan...');";
			echo "window.location='index.php?page=cari&kode=$kode&simpus=$simpus';";
			echo "</script>";
			die();
		}
	}
	// echo $strcari;
	
	if(mysqli_num_rows($query) > 1){
		$query2 = mysqli_query($koneksi, $strcari);
	?>
		<div class="modal" tabindex="-1" role="dialog" id="mdllist">
			<div class="modal-dialog" role="document">
				<div class="modal-content modalku">
					<div class="modal-body">
						<table class="table table-judul table-striped" width="100%">
							<thead class="dark">
								<tr>
									<th>NAMA PASIEN</th>
									<th width="10%" align="center"></th>
								</tr>
							</thead>
							<tbody>
							<?php
								while($dtpasien = mysqli_fetch_assoc($query2)){
							?>
							<tr>
								<td align="left"><?php echo $dtpasien['NamaPasien'];?></td>
								<td align="center"><a href="?page=cari_pasien&id=<?php echo $dtpasien['IdPasien'];?>&kode=<?php echo $kode;?>&simpus=<?php echo $simpus;?>" class="btn btn-sm btn-info btn_smal">PILIH</a></td>
							</tr>
							<?php 
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	<?php	
	}
		
	// echo $strcari;
	// die();
	
	// if(mysqli_num_rows($query) == 1){
	// 	if(strtotime($getdatasetting['WaktuPelayananTutup']) > time()){
	// 		$qcekd = mysqli_query($koneksi,"SELECT * FROM $tbpasienonline WHERE `Nik`='$data[Nik]' AND date(WaktuDaftar) = CURDATE()");
	// 	}else{
	// 		$tglbesok = date('Y-m-d',strtotime("+1 days"));
	// 		$qcekd = mysqli_query($koneksi,"SELECT * FROM $tbpasienonline WHERE `Nik`='$data[Nik]' AND date(WaktuDaftar) = '$tglbesok'");
	// 	}
	// 	//cek pendaftaran
			
	// 	$cekd = mysqli_num_rows($qcekd);
	// 	$dtcekd = mysqli_fetch_assoc($qcekd);
	// 	$IdPasienOnline = $dtcekd['IdPasienOnline'];
	// 	if($cekd > 0){
	// 		echo "<script>";
	// 		echo "window.location='index.php?page=etiket&id=$IdPasienOnline';";
	// 		echo "</script>";
	// 	}
	// }
?>

		<?php
		if(mysqli_num_rows($query) == '0'){
		?>
			<div class="kolomkonten2">
				<form class="form-inline formnik" action="index.php?page=cari_pasien" method="post">
					<input type="hidden" name="kode" value="<?php echo $_POST['kode'];?>"/>
					<input name="id" type="text" value="<?php echo $id;?>" class="form-control input-lg" placeholder="Ketikan Nik / No.BPJS / No.Index"/>
					<button name="button" type="submit" class="btn btn-primary btns">CARI</button>
				</form>
			</div>
			<div class="kolomkonten2" style="padding-top: 20px">
					<div class='alert alert-danger'>Anda belum terdaftar sebagai pasien di puskesmas...</div>
			</div>
		<?php	
		}else{
			
		// cek registrasi 
		$tbpasienrj = "tbpasienrj_".$kode;
		$tgl = date('Y-m-d');
		$qrycek = mysqli_query($koneksi, "SELECT `NoRegistrasi` FROM `$tbpasienrj` WHERE `NoCM` = '$data[NoCM]' AND TanggalRegistrasi = '$tgl'");
		$cek_registrasi = mysqli_num_rows($qrycek);
		if($cek_registrasi > 0){
			$dt_reg = mysqli_fetch_assoc($qrycek);
			$noregistrasi = $dt_reg['NoRegistrasi'];
			echo "<script>";
			echo "document.location.href='index.php?page=registrasi_sukses&id=$noregistrasi';";
			echo "</script>";
			die();
		}
			$kodepuskesmas = substr($data['NoIndex'],2,11);
			$datapkmpasien = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '".$kodepuskesmas."'"));
		?>
		
		<?php 
		if(mysqli_num_rows($query) == 1){
		// echo $str1;
		?>
		<div class="forms" style="display: none">	
			<div class="kolomkonten" style="background: rgba(252, 252, 252, 0.5)">	
			<h3 style="margin-top:0px;margin-bottom:10px">DATA PASIEN</h3>
			<table class="table table-striped">
				<tbody>
				<tr>
					<td class="col-sm-4">No.Kartu</td>
					<td>:</td>
					<td class="col-sm-8"><?php echo substr($data['NoIndex'],-10);?></td>
				</tr>				
				<tr>
					<td>Nama Pasien</td>
					<td>:</td>
					<td><?php echo $data['NamaPasien'];?></td>
				</tr>
				<tr>
					<td>Tgl.Lahir</td>
					<td>:</td>
					<td><?php echo date('d-m-Y',strtotime($data['TanggalLahir']));?></td>
				</tr>
				<tr>
					<td>Faskes (Puskesmas)</td>
					<td>:</td>
					<td><?php echo $datapkmpasien['NamaPuskesmas'];?></td>
				</tr>	
				</tbody>			
			</table>
			</div>	
			<div class="kolomkonten2">
				<a href="?page=isi_form&id=<?php echo $data['IdPasien'];?>&key=<?php echo $id;?>&kode=<?php echo $kode;?>&simpus=<?php echo $simpus;?>" class="btn btn-primary btn-lg btns btn-block">LANJUTKAN</a>
			</div>
			<?php
					}
				}
			?>
			
		</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".forms").slideDown();	
		$('#mdllist').modal('show');
	});
	
</script>
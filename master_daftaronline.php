<style>
	h4{
		font-weight: bold;	
	}	
	.form-check-label{
		margin-right: 12px;
	}
	.form-check-label input{
		position: relative;
		top:2px;
		margin-right: 5px;
	}
</style>
<?php
if($_POST['btn'] == 'simpan'){
	$jml_pel_a = $_POST['jml_pel_a'];
	$jml_pel_b = $_POST['jml_pel_b'];
	$jml_pel_c = $_POST['jml_pel_c'];
	$jml_pel_d = $_POST['jml_pel_d'];
	$jml_pel_e = $_POST['jml_pel_e'];
	$jml_pel_f = $_POST['jml_pel_f'];
	$jml_pel_g = $_POST['jml_pel_g'];
	$jml_pel_h = $_POST['jml_pel_h'];
	$jml_pel_i = $_POST['jml_pel_i'];
	$jml_pel_j = $_POST['jml_pel_j'];
	$jml_pel_k = $_POST['jml_pel_k'];
	
	// tbantrian_pelayanan
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `KuotaOnline`='$jml_pel_a' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='A'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `KuotaOnline`='$jml_pel_b' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='B'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `KuotaOnline`='$jml_pel_c' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='C'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `KuotaOnline`='$jml_pel_d' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='D'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `KuotaOnline`='$jml_pel_e' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='E'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `KuotaOnline`='$jml_pel_f' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='F'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `KuotaOnline`='$jml_pel_g' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='G'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `KuotaOnline`='$jml_pel_h' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='H'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `KuotaOnline`='$jml_pel_i' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='I'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `KuotaOnline`='$jml_pel_j' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='J'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `KuotaOnline`='$jml_pel_k' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='K'");

	//header("location:'index.php'");
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=master_daftaronline';";
	echo "</script>";
}

$datasetting = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_setting` WHERE `KodePuskesmas`='$kodepuskesmas'"));

?>

<style>
	.input-group{
		padding: 5px;
	}
</style>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive" style="font-size:12px">
			<h3 class="judul"><b>DAFTAR ONLINE</b></h3>
			<div class="formbg" style="padding: 30px 30px 30px 30px">
				<form class="form-signin" method="post" enctype="multipart/form-data">
					<input type="hidden" name="page" value="master_antrian_pasien">
					<div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='A'"));
										?>
										<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">A</span></div>
										<input type="text" value="<?php echo $dtpel['Pelayanan'];?>" class="form-control" readonly/>
									</div>
								</div>	
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['KuotaOnline'];?>" name="jml_pel_a" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>	
							<span class="label_a" style="color:red;"></span>
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='B'"));
										?>
										<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">B</span></div>
										<input type="text" value="<?php echo $dtpel['Pelayanan'];?>" class="form-control" readonly/>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['KuotaOnline'];?>" name="jml_pel_b" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>			
							</div>
							<span class="label_b" style="color:red;"></span>	
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='C'"));
										?>
										<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">C</span></div>
										<input type="text" value="<?php echo $dtpel['Pelayanan'];?>" class="form-control" readonly/>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['KuotaOnline'];?>" name="jml_pel_c" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_c" style="color:red;"></span>
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='D'"));
										?>
										<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">D</span></div>
										<input type="text" value="<?php echo $dtpel['Pelayanan'];?>" class="form-control" readonly/>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['KuotaOnline'];?>" name="jml_pel_d" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_d" style="color:red;"></span>
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='E'"));
										?>
										<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">E</span></div>
										<input type="text" value="<?php echo $dtpel['Pelayanan'];?>" class="form-control" readonly/>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['KuotaOnline'];?>" name="jml_pel_e" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_e" style="color:red;"></span>
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='F'"));
										?>
										<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">F</span></div>
										<input type="text" value="<?php echo $dtpel['Pelayanan'];?>" class="form-control" readonly/>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['KuotaOnline'];?>" name="jml_pel_f" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_f" style="color:red;"></span>
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='G'"));
										?>
										<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">G</span></div>
										<input type="text" value="<?php echo $dtpel['Pelayanan'];?>" class="form-control" readonly/>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['KuotaOnline'];?>" name="jml_pel_g" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_g" style="color:red;"></span>

							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='H'"));
										?>
										<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">H</span></div>
										<input type="text" value="<?php echo $dtpel['Pelayanan'];?>" class="form-control" readonly/>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['KuotaOnline'];?>" name="jml_pel_h" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_h" style="color:red;"></span>

							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='I'"));
										?>
										<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">I</span></div>
										<input type="text" value="<?php echo $dtpel['Pelayanan'];?>" class="form-control" readonly/>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['KuotaOnline'];?>" name="jml_pel_i" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_i" style="color:red;"></span>
							
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='J'"));
										?>
										<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">J</span></div>
										<input type="text" value="<?php echo $dtpel['Pelayanan'];?>" class="form-control" readonly/>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['KuotaOnline'];?>" name="jml_pel_j" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_j" style="color:red;"></span>

							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='K'"));
										?>
										<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">K</span></div>
										<input type="text" value="<?php echo $dtpel['Pelayanan'];?>" class="form-control" readonly/>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['KuotaOnline'];?>" name="jml_pel_k" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_k" style="color:red;"></span>

							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='L'"));
										?>
										<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">L</span></div>
										<input type="text" value="<?php echo $dtpel['Pelayanan'];?>" class="form-control" readonly/>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['KuotaOnline'];?>" name="jml_pel_l" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_l" style="color:red;"></span>
						</div>
					</div><hr/>
					<button class="btn btn-round btn-success btnsimpan" name="btn" value="simpan" type="submit">SIMPAN</button>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jquery.js"></script>
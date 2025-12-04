<style>
	.input-group{
		padding: 5px;
	}
</style>
<?php
	include "config/helper_pasienrj.php";
	include "config/helper_satusehat.php";
	$dtauth = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpuskesmasdetail` WHERE `KodePuskesmas`='$kodepuskesmas'"));
	
	if($_POST['btn'] == 'simpan'){
		$clientid = $_POST['clientid'];
		$clientsecret = $_POST['clientsecret'];
		$orgid = $_POST['orgid'];
		mysqli_query($koneksi, "UPDATE `tbpuskesmasdetail` SET `stsehat_clientid`='$clientid', `stsehat_clientsecret`='$clientsecret', `stsehat_orgid`='$orgid' WHERE `KodePuskesmas`='$kodepuskesmas'");
	
		// header("location:'index.php'");
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=satusehat_auth';";
		echo "</script>";
	}
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive" style="font-size:12px">
			<h3 class="judul"><b>AUTH</b></h3>
			<div class="formbg" style="padding: 30px 30px 30px 30px">
				<form class="form-signin" method="post" enctype="multipart/form-data">
					<input type="hidden" name="page" value="master_antrian_pasien">
					<div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Client Key</span></div>
										<input type="text" name="clientid" value="<?php echo $dtauth['stsehat_clientid'];?>" class="form-control"/>
									</div>
								</div>
							</div>	
							<span style="color:red;"></span>
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Secret Key</span></div>
										<input type="text" name="clientsecret" value="<?php echo $dtauth['stsehat_clientsecret'];?>" class="form-control"/>
									</div>
								</div>		
							</div>
							<span style="color:red;"></span>	
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Organization ID</span></div>
										<input type="text" name="orgid" value="<?php echo $dtauth['stsehat_orgid'];?>" class="form-control" >
									</div>
								</div>
							</div>
							<span style="color:red;"></span>
						</div>
					</div><hr/>
					<button class="btn btn-round btn-success btnsimpan" name="btn" value="simpan" type="submit">SIMPAN</button>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jquery.js"></script>
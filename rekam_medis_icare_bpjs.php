<?php
	include "config/helper_jkn.php";
	$tanggal = date('Y-m-d');
	$tahunini = date('Y');

	$idpasien = $_GET['idpasien'];
	$kodedokter = $_GET['kddokter'];
	$getpasien = mysqli_query($koneksi,"SELECT * FROM `$tbpasien` WHERE IdPasien = '$idpasien'");
	$data = mysqli_fetch_assoc($getpasien);

	$nik = '6473014709700004';//$data['Nik'];
	$kodedokter = '135965';

	$geturl = get_riwayat($nik,$kodedokter);
	echo var_dump($geturl);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>Rekam Medis Icare Bpjs</b></h3>
			<div class="formbg">
				<!-- <iframe src="<?php //echo $url;?>" width="1250px" height="650px"></iframe> -->
				<?php
					if($geturl['status'] == 'sukses'){
				?>
				<iframe src="<?php echo $geturl['url'];?>" frameborder="0" style="overflow:hidden;height:650px;width:100%" height="100%" width="650px"></iframe>
				<?php
					}else{
				?>
					<div class="alert alert-danger"><?php echo $geturl['keterangan'];?></div>
				<?php
					}
				?>
			</div>
		</div>
	</div>
</div>
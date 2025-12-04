<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
?>

<!--judul menu-->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Pemeriksaan <small>e-Puskesmas</small>
		</h1>
		<ol class="breadcrumb">
			<li class="active">
				<i class="fa fa-dashboard"></i> Status Login:
				<?php
					echo $_SESSION['kodepuskesmas'].", ".$_SESSION['namapuskesmas'].", ".$_SESSION['kota'];
				  ?>
			</li>
		</ol>
	</div>
</div>

<div class="row">
	<?php
	$query = mysqli_query($koneksi,"select * from `tbpelayanankesehatan` where JenisPelayanan = 'Kunjungan Sakit' order by `Pelayanan` ASC");
	while($data = mysqli_fetch_assoc($query)){
	$antri = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbpasienrj` WHERE `TanggalRegistrasi` = '".date('Y-m-d')."' AND substring(`NoRegistrasi`,1,11) = '$kodepuskesmas' AND `PoliPertama`='".$data['Pelayanan']."' AND `StatusPelayanan` = 'Antri'"));
	//$selesai = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbpasienrj` WHERE `TanggalRegistrasi` = '".date('Y-m-d')."' AND substring(`NoRegistrasi`,1,11) = '$kodepuskesmas' AND `PoliPertama`='".$data['Pelayanan']."' AND `StatusPelayanan` = 'Sudah'"));
	//$jumlah =  $antri + $selesai;
	
	if($data['Pelayanan'] == 'poli anak'){
		$link = 'polianak';
	}else if($data['Pelayanan'] == 'poli gigi'){
		$link = 'poligigi';
	}else if($data['Pelayanan'] == 'poli kia'){
		$link = 'polikia';
	}else if($data['Pelayanan'] == 'poli umum'){
		$link = 'poliumum';
	}
	?>
	<div class="col-sm-3">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h3 class="panel-title"><a href="?page=poli&pelayanan=<?php echo $data['Pelayanan'];?>"><strong><?php echo $data['Pelayanan'];?></strong></a></h3>
		  </div>
		  <div class="panel-body">
			<table class="table">
				<tr>
					<td class="col-sm-4">Antri</td>
					<td>:</td>
					<td class="col-sm-8"><?php echo $antri;?></td>
				</tr>
				<tr>
					<td>Selesai</td>
					<td>:</td>
					<td class="col-sm-8"><?php //echo $selesai;?></td>
				</tr>
				<tr>
					
					<td>Jumlah</td>
					<td>:</td>
					<td class="col-sm-8"><?php //echo $jumlah;?></td>
				</tr>
			</table>
		  </div>
		</div>
	</div>
	<?php
	}
	?>	
</div>
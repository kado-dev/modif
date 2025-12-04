<?php
	session_start();
	include "config/koneksi.php";
	$namapuskesmas = $_SESSION['namapuskesmas'];	
	$id = $_POST['id'];	
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$str = "SELECT * FROM `$tbkk` WHERE NoIndex='$id'";

	$query = mysqli_query($koneksi, $str);
	$data = mysqli_fetch_assoc($query);
	//$dtpasiendetail = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE NoCM = '$data[NoCM]'"));	
	
?>		
<h3>Data Lama</h3>
<table class="table-judul">
	<tr>
		<td class="col-sm-3">NoIndex</td>
		<td class="col-sm-9"><?php echo $data['NoIndex'];?></td>
	</tr>
	<tr>
		<td class="col-sm-3">No.RM</td>
		<td class="col-sm-9"><?php echo substr($data['NoRM'],-8);?></td>
	</tr>
	<tr>
		<td>Nama</td>
		<td><?php echo $data['NamaKK'];?></td>
	</tr>
	<tr>
		<td>Telepon</td>
		<td><?php echo $data['Telepon'];?></td>
	</tr>
	<tr>
		<td>Daerah</td>
		<td><?php echo $data['Daerah'];?></td>
	</tr>
	<tr>
		<td>Wilayah</td>
		<td><?php echo $data['Wilayah'];?></td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td><?php echo $data['Alamat'];?>, RT:<?php echo $data['RT'];?>, RW: <?php echo $data['RW'];?>, Kelurahan: <?php echo $data['Kelurahan'];?></td>
	</tr>
	<tr>
		<td>Kecamatan</td>
		<td><?php echo $data['Kecamatan'];?></td>
	</tr>
	<tr>
		<td>Kota</td>
		<td><?php echo $data['Kota'];?></td>
	</tr>
	<tr>
		<td>Provinsi</td>
		<td><?php echo $data['Provinsi'];?></td>
	</tr>							
</table>
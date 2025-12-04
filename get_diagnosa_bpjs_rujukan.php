<?php
include "config/koneksi.php";

	$query = mysqli_query($koneksi,"select * from `tbdiagnosabpjs` ");

	while($data = mysqli_fetch_assoc($query))
	{

			$kode[]	= $data['KodeDiagnosa'];
	
	}
	echo json_encode($kode);
?>		
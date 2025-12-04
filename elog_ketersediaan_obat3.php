<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
?>

<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Data Ketersediaan Obat <small>Elogistic</small></h1>
		</div>
	</div>
</div>

<!--cari barang-->
<div class="row">
	<div class="col-xs-12 col-sm-12">
		<?php
		$area = $kodepuskesmas;
		$json = '{"dataEnvironment":{ "token":{"username":"tomi4812@yahoo.co.id", "password":"'.base64_encode(87654321).'", "area":"'.substr($area,0,4).'"},"content": {"area": "3204","periode": "07_2018" }}}';
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://bankdataelog.kemkes.go.id/api/availibility/drugs",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $json,
		  CURLOPT_HTTPHEADER => array(
			"Content-Type: application/json"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
			$data = json_decode($response, true);
			// echo var_dump($data);
			$table_indikator =  $data['content']['table'];
		?>
		
			<table class="tableborder" width="100%" style="margin-bottom:10px;">
				<tr>
					<td width="20%">Area</td>
					<td>:</td>
					<td><?php echo $data['content']['area'];?></td>
				</tr>
				<tr>
					<td>Periode</td>
					<td>:</td>
					<td><?php echo $data['content']['periode'];?></td>
				</tr>
				<tr>
					<td>Type</td>
					<td>:</td>
					<td><?php echo $data['content']['type'];?></td>
				</tr>
			</table>
			<table class="table table-bordered table-condensed">
				<tr>
					<th>No</th>
					<th>Kode Obat</th>
					<th>Nama Obat</th>
					<th>Stok</th>
					<th>Jml Penggunaan</th>
					<th>Ketersediaan</th>
					<th>Kelompok</th>
				</tr>
			<?php
				$no = 0;
				foreach($table_indikator as $ti){
				$no = $no + 1;
					echo "<tr>";
					echo "<td>".$no."</td>";	
					echo "<td>".$ti['kode_obat']."</td>";	
					echo "<td>".$ti['nama_obj']."</td>";	
					echo "<td>".$ti['jml_stok']."</td>";	
					echo "<td>".$ti['jml_penggunaan']."</td>";	
					echo "<td>".$ti['cur_mont']."</td>";	
					echo "<td>".$ti['kelompok']."</td>";	
					echo "</tr>";
				}
			?>
			</table>
		<?php	
		}	
		?>
	</div>
</div>

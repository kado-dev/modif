<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
		<?php
			$bulanpost = $_GET['bln'];
			$tahunpost = $_GET['thn'];
			if($bulanpost == '' && $tahunpost == ''){
				$bulanpost = date('m');
				$tahunpost = date('Y');
			}
			if(strlen($kodepuskesmas) > 4){
				$area = substr($kodepuskesmas,1,4);
			}else{
				$area = $kodepuskesmas;
			}
			$periode = $bulanpost."_".$tahunpost;
		?>
		<h3 class="judul"><b>LIHAT KETERSEDIAAN OBAT </b><small>Elogistics</small></h3>
		<div class="formbg" style="padding: 50px 50px 50px 50px;">
			<div class = "row">
				<table class="tableborder table table-condensed" width="100%" style="margin-bottom:10px;">
					<form>
						<tr>
							<td width="10%">Area</td>
							<td width="2%">:</td>
							<td><?php echo substr($kodepuskesmas,0,4);?></td>
						</tr>
						<tr>
							<td>Periode</td>
							<td>:</td>
							<td>
							
							<input type="hidden" name="page" value="elog_ketersediaan_obat">
							<select name="bln" class="" >
								<?php
								for($bln = 1;$bln<=12; $bln ++){
									$j = strlen($bln);
									if($j == 1){
										$bln = "0".$bln;
									}
									
									if($bln == $bulanpost){
										echo "<option value='$bln' SELECTED>$bln</option>";
									}else{
										echo "<option value='$bln'>$bln</option>";
									}
								}
								?>

							</select>
							<select name="thn" class="" >
								<?php
									for($tahun = 2015 ; $tahun <= date('Y'); $tahun++){
									if($tahun == $tahunpost){
								?>
									<option value="<?php echo $tahun;?>" SELECTED><?php echo $tahun;?></option>
								<?php }else{?>	
									<option value="<?php echo $tahun;?>"><?php echo $tahun;?></option>
								<?php 
									}
								}
								?>
							</select>
							
							</td>
						</tr>
						<tr>
							<td>Type</td>
							<td>:</td>
							<td>Ketersedian Obat Instalasi Farmasi</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>
								<input type="submit" class="btn btn-sm btn-info">
								<a href="javascript:print()" class="btn btn-sm btn-success">Print</a>
							</td>
						</tr>
					</form>
				</table>
			</div>	
		</div>	
		
		<?php
		if($periode != ''){
		if ($kota == "KABUPATEN BANDUNG"){
			$json = '{"dataEnvironment":{ "token":{"username":"tomi4812@yahoo.co.id","password":"'.base64_encode(87654321).'", "area":"'.$area.'"},"content": {"area": "'.$area.'","periode": "'.$periode.'" }}}';
			}elseif($kota == "KABUPATEN BOGOR"){
				$json = '{"dataEnvironment":{ "token":{"username":"tomi4812i@gmail.com","password":"'.base64_encode(12345678).'", "area":"'.$area.'"},"content": {"area": "'.$area.'","periode": "'.$periode.'" }}}';
			}elseif($kota == "KABUPATEN BEKASI"){
				$json = '{"dataEnvironment":{ "token":{"username":"uptdfarmasikab.bekasi@gmail.com","password":"'.base64_encode(12345678).'", "area":"'.$area.'"},"content": {"area": "'.$area.'","periode": "'.$periode.'" }}}';
			}
		// $json = '{"dataEnvironment":{ "token":{"username":"tomi4812i@gmail.com", "password":"'.base64_encode(12345678).'", "area": "3204"},"content": {"area": "3204","periode": "'.$periode.'" }}}';
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://bankdataelog.kemkes.go.id/api/availibility/drugs",
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
		// echo $json;
		// echo $response;
		// die();

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
			$data = json_decode($response, true);
			// echo $response;
			// die();
			$table_indikator =  $data['content']['table'];
		?>
		
		
		<?php
			if($table_indikator != 'no data'){
		?>
		<table class="table-judul">
			<thead>
				<tr>
					<th width="3%">No</th>
					<th width="12%">Kode Elog</th>
					<th width="45%">Nama Barang</th>
					<th width="10%">Stok</th>
					<th width="10%">Jml Penggunaan</th>
					<th width="10%">Ketersediaan</th>
				</tr>
			</thead>	
			<?php
				$sortArray = array(); 

				foreach($table_indikator as $person){ 
					foreach($person as $key=>$value){ 
						if(!isset($sortArray[$key])){ 
							$sortArray[$key] = array(); 
						} 
						$sortArray[$key][] = $value; 
					} 
				} 

				$orderby = "nama_obj"; //change this to whatever key you want from the array 

				array_multisort($sortArray[$orderby],SORT_ASC,$table_indikator); 
				
				$no = 0;
				foreach($table_indikator as $ti){
				$no = $no + 1;
					echo "<tr>";
					echo "<td>".$no."</td>";	
					echo "<td>".$ti['kode_obat']."</td>";	
					echo "<td>".strtoupper($ti['nama_obj'])."</td>";	
					echo "<td>".$ti['jml_stok']."</td>";	
					echo "<td>".$ti['jml_penggunaan']."</td>";	
					echo "<td>".$ti['cur_mont']."</td>";
					echo "</tr>";
				}
			?>
		</table>	
		<?php	
			}else{
				echo "<span style='color:red'>Tidak ada data</span>";
			}
		}
		}		
		?>
		</div>
	</div><br/>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p>
					<a href="http://bankdataelog.kemkes.go.id/apps/" target="_blank" style="color: #000; font-weight: bold;">>> Lihat Bank Data Elogistik</a>
				</p>
			</div>
		</div>
	</div>
</div>

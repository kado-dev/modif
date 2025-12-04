<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
?>

<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
	display: none;
	
}
.printheader h4{
	font-size:18px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:18px;
	font-family: "Bookman Old Style";
}
.printbody{
	margin-left:0px;
	margin-right:0px;
	display:none;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	margin-top:10px;
	display:none;
}
.bawahtabel{
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font10{
	font-size:10px;
	font-family: "Tahoma";
}
.font11{
	font-size:11px;
	font-family: "Tahoma";
}
.font14{
	font-size:14px;
	font-family: "Tahoma";
}


@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}
	.printbody{
		display:block;
	}
	.atastabel{
		display:block;
	}
	.bawahtabel{
		display:block;
	}
}
</style>

<div class="tableborderdiv">
	<div class="row noprint">
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

			//echo $area;
			$periode = $bulanpost."_".$tahunpost;
		?>
		<h3 class="judul"><b>LIHAT INDIKATOR OBAT </b><small>Elogistics</small></h3>
		<div class="formbg" style="padding: 50px 50px 50px 50px;">
			<div class = "row">
				<form>
					<table class="tableborder table table-condensed" width="100%" style="margin-bottom:20px;">
						<tr>
							<td width="10%">Area</td>
							<td width="2%">:</td>
							<td>
							<select name="kodearea" class="col-sm-4" >
								<option value="semua">Semua</option>
								<?php
									if($kodepuskesmas == '3204' or $kodepuskesmas == '3201' or $kodepuskesmas == '3216' or $kodepuskesmas == '-'){
									$kota = $_SESSION['kota'];
										$strtbpuskesmas = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` ORDER BY NamaPuskesmas");
										while($tbpus = mysqli_fetch_assoc($strtbpuskesmas)){
										if($_GET['kodearea'] == $tbpus['KodePuskesmas']){
									?>
										<option value="<?php echo $tbpus['KodePuskesmas'];?>" SELECTED><?php echo $tbpus['NamaPuskesmas'];?></option>
										<?php }else{ ?>
										<option value="<?php echo $tbpus['KodePuskesmas'];?>"><?php echo $tbpus['NamaPuskesmas'];?></option>
									<?php 
										}
									}
								}else{
									echo "<option value='$kodepuskesmas'>$_SESSION[namapuskesmas]</option>";
								}
								?>
							</select>
							</td>
						</tr>
						<tr>
							<td>Periode</td>
							<td>:</td>
							<td>
								<input type="hidden" name="page" value="elog_indikator_obat" >
								<select name="bln" class="col-sm-1" style="margin-right: 10px;">
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
								<select name="thn" class="col-sm-1">
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
							<td>Obat Indikator Puskesmas</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>
								<input type="submit" class="btn btn-sm btn-info">
								<a href="javascript:print()" class="btn btn-sm btn-success">Print</a>
							</td>
						</tr>
					</table>
				</form>
			</div>	
			<?php		
			if($area != '' AND $periode != ''){
				if ($kota == "KABUPATEN BANDUNG"){
					$json = '{"dataEnvironment":{ "token":{"username":"tomi4812@yahoo.co.id","password":"'.base64_encode(87654321).'", "area":"'.$area.'"},"content": {"area": "'.$area.'","periode": "'.$periode.'" }}}';
				}elseif($kota == "KABUPATEN BOGOR"){
					$json = '{"dataEnvironment":{ "token":{"username":"tomi4812i@gmail.com","password":"'.base64_encode(12345678).'", "area":"'.$area.'"},"content": {"area": "'.$area.'","periode": "'.$periode.'" }}}';
				}elseif($kota == "KABUPATEN BEKASI"){
					$json = '{"dataEnvironment":{ "token":{"username":"uptdfarmasikab.bekasi@gmail.com","password":"'.base64_encode(12345678).'", "area":"'.$area.'"},"content": {"area": "'.$area.'","periode": "'.$periode.'" }}}';
				}	
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://bankdataelog.kemkes.go.id/api/indicator/drugs",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 100,
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
						<th>No</th>
						<th>Kode Puskesmas</th>
						<th>ID Indikator</th>
						<th>Nama Indikator</th>
						<th>Sedia</th>
					</tr>
				</thead>
				<?php
					$no = 0;
					foreach($table_indikator as $ti){
						if($_GET['kodearea'] == 'semua'){
							$no = $no + 1;
							echo "<tr>";
							echo "<td>".$no."</td>";	
							echo "<td>".$ti['kode_pusk']."</td>";	
							echo "<td>".$ti['id_obatindikator']."</td>";	
							echo "<td>".$ti['nama_indikator']."</td>";	
							echo "<td>".$ti['sedia']."</td>";	
							echo "</tr>";
						}else{
							if($ti['kode_pusk'] == $_GET['kodearea']){
								$no = $no + 1;
								echo "<tr>";
								echo "<td>".$no."</td>";	
								echo "<td>".$ti['kode_pusk']."</td>";	
								echo "<td>".$ti['id_obatindikator']."</td>";	
								echo "<td>".$ti['nama_indikator']."</td>";	
								echo "<td>".$ti['sedia']."</td>";	
								echo "</tr>";
							}
						}
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

	<!--data cara bayar-->
	<div class="printheader">
		<?php
		$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
		$kota1 = $datapuskesmas['Kota'];
		$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` where `Kota` = '$kota1'"));
		?>
			<?php 
			if($kodepuskesmas == 'semua'){
			?>
				<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
				<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
				<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
			<?php
			}else{
			?>
				<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$datapuskesmas['Kota'];?></b></span><br>
				<span class="font14" style="margin:5px;"><b><?php echo $datadinas['NamaDinkes'];?></b></span><br>
				<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$datapuskesmas['NamaPuskesmas'];?></b></span><br>
				<span class="font10" style="margin:5px;"><?php echo $datapuskesmas['Alamat']?></span>
			<?php	
			}
			?>
			<hr style="margin:3px; border:1px solid #000">
			<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN INDIKATOR OBAT</b></span><br>
			<span class="font11" style="margin:1px;">Periode Laporan: <?php echo ($_GET['bln'])."/".($_GET['thn']);?></span>
			<br/>
	</div>

	<div class="atastabel table-responsive font11">
		<?php
			$datakecamatan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
		?>
		<div style="float:left; width:65%; margin-bottom:10px;">
			<table>
				<tr>
					<td style="padding:2px 4px;">Kode Puskesmas</td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"> <?php echo $datakecamatan['KodePuskesmas'];?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Nama Puskesmas</td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"> <?php echo $datakecamatan['NamaPuskesmas'];?></td>
				</tr>
			</table>
		</div>
	</div>

	<div class="printbody table-responsive font10">
		<table style="border:1px solid #000;" width="100%">
			<thead class="font10">
				<tr style="border:1px solid #000;">
					<th style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">No</th>
					<!--<th style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">Kode Puskesmas</th>
					<th style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">ID Indikator</th>-->
					<th style="text-align:center;width:85%;vertical-align:middle; border:1px solid #000; padding:3px;">Nama Indikator</th>
					<th style="text-align:center;width:10%;vertical-align:middle; border:1px solid #000; padding:3px;">Sedia</th>
				</tr>
			</thead>
			
			<!--tbstokbulananapotik-->
			<tbody class="font10">
				<?php
				$no = 0;
				foreach($table_indikator as $ti){
				$no = $no + 1;
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:right;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $no;?></td>	
						<!--echo "<td>".$ti['kode_pusk']."</td>";	
						echo "<td>".$ti['id_obatindikator']."</td>";-->
						<td style="text-align:left;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $ti['nama_indikator'];?></td>	
						<td style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $ti['sedia'];?></td>	
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div><br>

	<div class="bawahtabel">
		<table width="100%">
			<tr>
				<td width="10%"></td>
				<td style="text-align:center;">
				Diterima Oleh
				<br>
				<br>
				<br>
				(...................................)
				</td>
				
				
				<td style="text-align:center;">
				Diserahkan Oleh
				<br>
				<br>
				<br>
				(...................................)
				</td>
			</tr>
		</table>
	</div>
</div>

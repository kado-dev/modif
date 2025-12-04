<?php
	error_reporting(1);
	session_start();
	include "config/helper_pasienrj.php";
	$tanggal = date('Y-m-d');
	$tahunini = date('Y');
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DATA RETENSI</b></h3>
			<div class="formbg">
				<form role="form" class="submit">
					<input type="hidden" name="page" value="rekam_medis_pasien"/>
					<div class = "row">
						<div class="col-xl-5">
							<input type="text" name="key" class="form-control key barcodefocus" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama Pasien / NoIndex / NoRM">
						</div>
						<div class="col-sm-2" style ="width:125px">
							<select name="tahun" class="form-control">
							<option value="Semua" <?php if($_GET['tahun'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<?php
									for($tahun = 2013 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="lamakunjungan" class="form-control asuransi">
								<option value='semua' <?php if ($_GET['lamakunjungan'] == 'semua' || $_GET['lamakunjungan'] == '') { echo 'SELECTED';}?>>Semua</option>
								<option value='less2' <?php if ($_GET['lamakunjungan'] == 'less2') { echo 'SELECTED';}?>>< 2 Tahun</option>
								<option value='less3' <?php if ($_GET['lamakunjungan'] == 'less3') { echo 'SELECTED';}?>>> 2 Tahun</option>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=rekam_medis_pasien" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<?php if($_GET['tahun'] != ''){ ?>
							<a href="rekam_medis_pasien_excel.php?key=<?php echo $_GET['key'];?>&tahun=<?php echo $_GET['tahun'];?>&lamakunjungan=<?php echo $_GET['lamakunjungan'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<?php } ?>	
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
		
	<div class="table-responsive">
		<form action="rm_pasien_retensi_proses.php" method="POST">
			<table class="table-judul">
				<thead>
					<tr>
						<th width="3%">NO</th>
						<th width="10%">TGL DAFTAR</th>
						<th width="10%">NO RM</th>
						<th width="25%">NAMA PASIEN</th>
						<th width="22%">ALAMAT</th>
						<th width="10%">TGL KUNJUNGAN<br/>TERAKHIR</th>
						<th width="5%">JUMLAH<br/>KUNJUNGAN</th>
						<th width="10%">DIAGNOSA</th>
						<th width="10%"><input type="checkbox" class="opsistsretensi"/></th>
						<th width="5%">#</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$jumlah_perpage = 100;
				
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$key = $_GET['key'];
					$tahun = $_GET['tahun'];
					$lamakunjungan = $_GET['lamakunjungan'];
					
					$strlmkunjungan = "";
					if($lamakunjungan !=''){
						if($lamakunjungan == 'less2'){
							$strlmkunjungan = " AND TIMESTAMPDIFF(year,TanggalDaftar, now()) <= 2";
							$strlmkunjungan_rj = " AND TIMESTAMPDIFF(year,TanggalRegistrasi, now()) <= 2";
						}else if($lamakunjungan == 'less3'){
							$strlmkunjungan = " AND TIMESTAMPDIFF(year,TanggalDaftar, now()) >= 2";
							$strlmkunjungan_rj = " AND TIMESTAMPDIFF(year,TanggalRegistrasi, now()) >= 2";
						}	
					}

					if($tahun != 'Semua'){
						$tahuns = " AND SUBSTRING(NoIndex,15,4) = $tahun";
					}else{
						$tahuns = "";	
					}
					$str = "SELECT IdPasien, NoIndex, NoCM, NoRM, NamaPasien, TanggalDaftar, StatusRetensi, Asuransi, NoAsuransi, TIMESTAMPDIFF(year,TanggalDaftar, now()) as lamakunjungan 
					FROM `$tbpasien`
					WHERE (`NamaPasien` like '%$key%' OR `NoIndex` like '%$key%' OR `NoRM` like '%$key%')".$strlmkunjungan.$tahuns;
					$str2 = $str." ORDER BY NoIndex ASC, NamaPasien DESC LIMIT $mulai,$jumlah_perpage";
					// echo $str2;
					
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$query = mysqli_query($koneksi, $str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$idpasien = $data['IdPasien'];
						$noindex = $data['NoIndex'];
						$nocm = $data['NoCM'];
						
						// tbkk
						$dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Alamat`,`RT`,`Kelurahan` FROM `$tbkk` WHERE `NoIndex`='$noindex'"));
						
						// tbpasienrj
						$dttbpasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoRegistrasi`,`TanggalRegistrasi` FROM `$tbpasienrj` WHERE `NoCM`='$nocm' AND `StatusPasien` = '1'".$strlmkunjungan_rj." ORDER BY TanggalRegistrasi DESC Limit 1"));
						$jumlahkunjungan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj)AS Jml FROM `$tbpasienrj` WHERE `NoCM`='$nocm' AND `StatusPasien` = '1' ORDER BY TanggalRegistrasi DESC Limit 1"));
						
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalDaftar']));?></td>
							<td align="center"><?php echo substr($data['NoRM'],-6);?></td>
							<td align="left">
								<?php echo strtoupper($data['NamaPasien']);?>
								<?php if($data['StatusRetensi'] == 'Y'){?>
									<span class="badge badge-danger" style='font-style: italic; padding: 8px;'><?php echo substr($data['NoIndex'],-10);?></span><br/>
								<?php }else{ ?>
									<span class="badge badge-success" style='font-style: italic; padding: 8px;'><?php echo substr($data['NoIndex'],-10);?></span><br/>
								<?php } ?>
								<?php 
									if(substr($data['Asuransi'],0,4) == 'BPJS'){
										echo "<img src='image/bpjs.png' id='hide-option' title='$data[NoAsuransi]'/> ".strtoupper($data['NoAsuransi']);
									}
								?>
							</td>
							<td align="left"><?php echo strtoupper($dtkk['Alamat'].", RT".$dtkk['RT'].", Des/Kel.".$dtkk['Kelurahan']);?></td>
							<td align="center">
								<?php 
									if ($dttbpasienrj['TanggalRegistrasi'] != ''){
										echo date('d-m-Y', strtotime($dttbpasienrj['TanggalRegistrasi']));
									}else{
										echo date('d-m-Y', strtotime($data['TanggalDaftar']));
									}
								?>
							</td>
							<td align="center"><?php echo $jumlahkunjungan['Jml'];?></td>
							<td align="center">
								<?php
									// cek diagnosa pasien
									$noregs = $dttbpasienrj['NoRegistrasi'];
									$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregs' GROUP BY `KodeDiagnosa`";
									$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
									while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
										$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
										$array_data[$no][] = "<b>".$data_diagnosapsn['KodeDiagnosa'];
									}
									if ($array_data[$no] != ''){
										$data_dgs = implode("<br/>", $array_data[$no]);
									}else{
										$data_dgs ="";
									}
									echo strtoupper($data_dgs);
								?>
							</td>
							<td align="center">
								<input type="hidden" name="idpasien[]" value="<?php echo $data['IdPasien']; ?>"/>
								<input type="checkbox" name="stsretensi[<?php echo $data['IdPasien']; ?>]" class="stsretensis" value="Y" <?php if ($data['StatusRetensi'] == 'Y') { echo 'checked="true"';}?>"/>
							</td>
							<td align="center">
								<a href="?page=rekam_medis_pasien_detail_klpcm&key=<?php echo $key;?>&tahun=<?php echo $tahun;?>&lamakunjungan=<?php echo $lamakunjungan;?>&nocm=<?php echo $nocm;?>" class="btn btn-round btn-sm btn-info" target="_blank">LIHAT</a>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table><br/>
			<input type="hidden" name="key" value="<?php echo $key;?>"/>
			<input type="hidden" name="tahun" value="<?php echo $tahun;?>"/>
			<input type="hidden" name="lamakunjungan" value="<?php echo $lamakunjungan;?>"/>
			<input type="hidden" name="halaman" value="<?php echo $_GET['h'];?>"/>
			<input type="submit" name="Retensi" class="btn btn-round btn-success btnsimpan"/>
		</form><hr/>
		<ul class="pagination noprint">
			<?php
				$query2 = mysqli_query($koneksi,$str);
				$jumlah_query = mysqli_num_rows($query2);
				
				if(($jumlah_query % $jumlah_perpage) > 0){
					$jumlah = ($jumlah_query / $jumlah_perpage)+1;
				}else{
					$jumlah = $jumlah_query / $jumlah_perpage;
				}
				for ($i=1;$i<=$jumlah;$i++){
				$max = $_GET['h'] + 5;
				$min = $_GET['h'] - 4;
					if($i <= $max && $i >= $min){
						if($_GET['h'] == $i){
							echo "<li class='active'><span class='current'>$i</span></li>";
						}else{
							echo "<li><a href='?page=rekam_medis_pasien&key=$key&tahun=$tahun&lamakunjungan=$lamakunjungan&h=$i'>$i</a></li>";
						}
					}
				}
			?>	
		</ul>			
	</div>
</div>
<script src="assets/js/jquery.js"></script>
<script>
	$(".opsistsretensi").click(function (){
     if ($(".opsistsretensi").is(':checked')){
        $(".stsretensis").each(function (){
           $(this).prop("checked", true);
           });
        }else{
           $(".stsretensis").each(function (){
                $(this).prop("checked", false);
           });
        }
 });
</script>
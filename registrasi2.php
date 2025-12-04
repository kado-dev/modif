<link rel="stylesheet" type="text/css" href="assets/css/f_registrasi.css?6">
<link rel="stylesheet" type="text/css" href="assets/css/f_tabel.css?2">

<style>
	.clsbgkartu_dua{
		top:0px;
		left:0px;
		right:0px;
		width:290px;
		height:195px;
		text-align: center;
	}
	
	table, td {
		padding: 10px 10px 10px 20px !important;
	}	
	
	.tbnama{
		position:absolute;
		top:298px;
		left:65px;
		z-index:10000;
		font-weight:bold;
		font-size:12px;
		color:#000;
		font-family: "Poppins", Arial, sans-serif;
	}
	.tbalamat{
		position:absolute;
		top:310px;
		left:65px;
		z-index:10000;
		font-weight:bold;
		font-size:12px;
		color:#000;
		font-family: "Poppins", Arial, sans-serif;
	}
	.tbbarcode{
		background:#fff;
		position:absolute;
		top:317px;
		left:65px;
		z-index:10000;
		font-weight:bold;
		font-size:15px;
		color:#000;
		font-family:century gothic;
	}
	.notifbpjs{
		background:#ff5656!important;
		text-align:center;
		border-radius:4px;
		color: #fff;
		font-size: 20px;
		padding : 10px;
		display: block;
		margin-left: auto;
		margin-right: auto;
		margin-bottom: 20px;
		width: 100%;
	}
	.autocomplete-suggestions {
		width:500px !important;
	}
	.table-new{
		background: #fff;
		border-radius: 12px !important;
		font-family: "Poppins", Arial, sans-serif;
	}
	.table-new thead tr th:first-child{
		border-radius: 12px 0px 0px 0px !important;
	}
	.table-new thead tr th:last-child{
		border-radius: 0px 12px 0px 0px !important;
	}	
	.table-new > tbody > tr:last-child > td:last-child{
		border-radius: 0px 0px 12px 0px !important;
	}
	.table-new > tbody > trtd:first-child{
		border-radius: 0px 0px 0px 12px !important;
	}
	.table-new thead tr th{
		background: #707070;
		color:#fff;
		padding: 18px 12px;
	}
	.table-new tbody tr:nth-child(odd) td{
		background: #F5F5F5;
	}
		
	@media print{
		@page {     margin: 0 !important; }
		html,body{			
    		overflow: hidden;
			visibility: hidden;
			width: 9cm;
			height: 5cm;
		}
		.kartu_pasien,.print_etiket{
			visibility: visible;
			position: fixed;
			top:0px;
			left:0px;
			width: 9cm;
			height: 5cm;
		}
		.clsbgkartu_dua{			
			width:340px;
			height:212px;
		}
		.tbnama{
			visibility: visible;
			top:136px;
			left:25px;
			font-size : 10px;
			line-height: 10px;
			font-family: "Poppins", Arial, sans-serif;
		}
		.tbalamat{
			visibility: visible;
			top:146px;
			left:25px;
			font-size : 10px;
			line-height: 10px;
			font-family: "Poppins", Arial, sans-serif;
		}
		.tbbarcode{
			visibility: visible;
			top:155px;
			left:22px;
			width: 4cm;
			height: 0.4cm;
		}
		.fontnama{
			font-size: 10px;
			font-weight: bold;
		}
		.barcode_kartu{
			visibility: visible;
			top:72px;
			left:2px;
			font-size : 10px;
		}		
	}
</style>

<?php
	$kota = $_SESSION['kota'];

	if($kota == "KOTA TARAKAN"){
		date_default_timezone_set('Asia/Ujung_Pandang');
	}else{
		date_default_timezone_set('Asia/Jakarta');
	}
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbantrian_pasien = "tbantrian_pasien_".$kodepuskesmas;
	$tbpasienonline = "tbpasienonline_".$kodepuskesmas;	
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$kodeppk = $_SESSION['kodeppk'];
	$hariini = date("d-m-Y");
	$otoritas = explode(',',$_SESSION['otoritas']);	
	// $nocm = $_GET['nocm'];
	$idpasien = $_GET['idpasien'];
	$tahun = $_GET['tahun'];	
	$kartu = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbkartupasien WHERE KodePuskesmas = '$kodepuskesmas'"));
	
	if(isset($idpasien)){
		$str = "SELECT * FROM `$tbpasien` WHERE `IdPasien` = '".$idpasien."'";
	}else{
		$kategori_pencarian = $_GET['kategori_pencarian'];
		$key = $_GET['key'];
		$jml_key = strlen($key);
				
		if($key == ''){
			alert('gagal','Kata kunci tidak boleh kosong...');
			echo "<script>";
			echo "document.location.href='index.php?page=registrasi_form&kategori_pencarian=".$kategori_pencarian."&key=".$key."';";
			echo "</script>";
		}elseif($jml_key <= 2){
			alert('gagal','Kata kunci harus lebih dari 2 digit...');
			echo "<script>";
			echo "document.location.href='index.php?page=registrasi_form&kategori_pencarian=".$kategori_pencarian."&key=".$key."';";
			echo "</script>";
		}
				
		if(isset($key)){
			if($kategori_pencarian == 'BPJS'){				
				// echo "<div class='notifbpjs' style='background:pink'>Koneksi bridging saat ini dinonaktifkan sementara karena ada perbaikan dan optimalisasi bridging, <br/> 
				// silahkan Pasien & Rujukan BPJS akses melalui PCARE...</div>";
				// die();
				if($jml_key <= 7){
					echo "<script>";
					echo "document.location.href='index.php?page=registrasi_form&kategori_pencarian=".$kategori_pencarian."&key=".$key."&alert=Nomor Peserta BPJS < 13 digit...';";
					echo "</script>";
				}elseif($jml_key > 13){
					echo "<script>";
					echo "document.location.href='index.php?page=registrasi_form&kategori_pencarian=".$kategori_pencarian."&key=".$key."&alert=Nomor Peserta BPJS > 13 digit...';";
					echo "</script>";
				}else{
					if($jml_key < 13){
						$jmlnol = 13 - $jml_key;
							$nol = "";
						for($i = 0 ;$i < $jmlnol; $i++){
							$nol .= "0";
						}
						$key2 = $nol.$key;
					}else{
						$key2 = $key;
					}

					include "config/helper_bpjs_v4.php";	
					$data_bpjs = get_data_peserta_bpjs($key2);
					$dtbpjs = json_decode($data_bpjs,True);
					// echo "Hasil : ".$data_bpjs;
				}					
			}else if($kategori_pencarian == 'NIK'){	
				$jml_key = strlen($key);	
				if($jml_key > 16){
					echo "<script>";
					echo "document.location.href='index.php?page=registrasi_form&kategori_pencarian=".$kategori_pencarian."&key=".$key."&alert=Data tidak ditemukan, NIK Peserta BPJS > 16 digit';";
					echo "</script>";
				}elseif($jml_key < 16){
					echo "<script>";
					echo "document.location.href='index.php?page=registrasi_form&kategori_pencarian=".$kategori_pencarian."&key=".$key."&alert=Data tidak ditemukan, NIK Peserta BPJS < 16 digit';";
					echo "</script>";
				}else{
					/*komen*/
					include "config/helper_bpjs_v4.php";	
					$data_bpjs = get_data_peserta_bpjs_nik($key);
					// echo $data_bpjs;
				}
			}
		}
	}
?>

<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white fw-bold">REGISTRASI PASIEN</h2>
				<h5 class="text-white op-7">SILAHKAN CARI DATA PASIEN</h5>
			</div>
			<div class="ml-md-auto py-2 py-md-0">
				<a href="?page=kk_insert" class="btn btn-success btn-round">Pasien Baru</a>
				<a href="?page=registrasi_data" class="btn btn-info btn-round">Data Registrasi</a>
				<a href="?page=registrasi_online" class="btn btn-round btn-primary">Daftar Online</a>
			</div>
		</div>
	</div>
</div>
<div class="page-inner mt--5">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<form method="get">
						<input type="hidden" name="page" value="registrasi">
						<div class="row">
							<div class="col-xl-2">
								<select name="kategori_pencarian" class="form-control inputan kat_pencarian">
									<?php if($kota == "KOTA TARAKAN"){ ?>
										<option value="NoIndex" <?php if($_GET['kategori_pencarian'] == 'NoIndex'){echo "SELECTED";}?>>INDEX</option>
										<option value="BPJS" <?php if($_GET['kategori_pencarian'] == 'BPJS'){echo "SELECTED";}?>>BPJS</option>
										<option value="NIK" <?php if($_GET['kategori_pencarian'] == 'NIK'){echo "SELECTED";}?>>NIK BPJS</option>
										<option value="NamaPasien" <?php if($_GET['kategori_pencarian'] == 'NamaPasien'){echo "SELECTED";}?>>NAMA PASIEN</option>
										<option value="TanggalLahir" <?php if($_GET['kategori_pencarian'] == 'TanggalLahir'){echo "SELECTED";}?>>PASIEN - THN.LAHIR</option>
										<option value="NamaKK" <?php if($_GET['kategori_pencarian'] == 'NamaKK'){echo "SELECTED";}?>>KEPALA KELUARGA</option>
									<?php }else{ ?>
										<option value="NoIndex" <?php if($_GET['kategori_pencarian'] == 'NoIndex'){echo "SELECTED";}?>>INDEX</option>
										<option value="BPJS" <?php if($_GET['kategori_pencarian'] == 'BPJS'){echo "SELECTED";}?>>BPJS</option>
										<option value="NIK" <?php if($_GET['kategori_pencarian'] == 'NIK'){echo "SELECTED";}?>>NIK</option>
										<option value="NoRM" <?php if($_GET['kategori_pencarian'] == 'NoRM'){echo "SELECTED";}?>>RM</option>
										<option value="NamaPasien" <?php if($_GET['kategori_pencarian'] == 'NamaPasien'){echo "SELECTED";}?>>NAMA PASIEN</option>
										<option value="TanggalLahir" <?php if($_GET['kategori_pencarian'] == 'TanggalLahir'){echo "SELECTED";}?>>PASIEN - THN.LAHIR</option>
										<option value="NamaKK" <?php if($_GET['kategori_pencarian'] == 'NamaKK'){echo "SELECTED";}?>>KEPALA KELUARGA</option>
									<?php } ?>
								</select>	
							</div>
							<div class="col-xl-2 formkey">
								<input type="text" name="key" class="form-control inputan cari" value="<?php echo $_GET['key'];?>" placeholder="Kata kunci" minlength="2">
							</div>
							<div class="col-xl-2 formtgllahir hidden">
								<input type="text" name="thnlahir" class="form-control inputan cari" value="<?php echo $_GET['thnlahir'];?>" placeholder="Tahun Lahir" minlength="4" maxlength="4"/>
							</div>
							<div class="col-xl-2 formalamat hidden">
								<select type="text" name="alamat" class="form-control inputan cari">
									<option value=''>Semua</option>
									<?php
									$qkel = mysqli_query($koneksi,"SELECT * FROM `tbkelurahan` where Kota = '$kota' ORDER BY `Kelurahan`");
									while($dtkel = mysqli_fetch_assoc($qkel)){
										if($dtkel['Kelurahan'] == $_GET['alamat']){
										echo "<option value='$dtkel[Kelurahan]' SELECTED>$dtkel[Kelurahan]</option>";
										}else{
										echo "<option value='$dtkel[Kelurahan]'>$dtkel[Kelurahan]</option>";
										}
									}
									?>
								</select>
							</div>
							<div class="col-xl-4">
								<button type="submit" class="btn btn-warning btn-round btnsubmit"><span class="fa fa-search"></span></button>
								<?php
									$qry = mysqli_query($koneksi,"SELECT * FROM `$tbantrian_pasien` WHERE date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` != 'Selesai' order by NomorAntrian Limit 1");
									if(mysqli_num_rows($qry) > 0){
								?>
								<a href="#" class="btn btn-info btn-round panggilantrian">Panggil</a>
								<?php
									}
								?>	
							</div>
						</div>	
					</form>
				</div>	
			</div>	
		</div>	
	</div>	
</div>	

<div class="page-inner mt--5">
	<div class="row">
		<div class="col-md-12">
			<?php 
				echo $_COOKIE['alert'];
			?>	

			<!--kolom data-->
			<div class="row">
				<?php
				if($kategori_pencarian == 'NoIndex'){
					if(strlen($key) == 5){
						$str = "SELECT * FROM `$tbpasien` WHERE SUBSTRING(NoIndex,-5) = '".$key."' AND `StatusRetensi`='N'"; 
					}else{
						$str = "SELECT * FROM `$tbpasien` WHERE SUBSTRING(NoIndex,-10) = '".$key."' AND `StatusRetensi`='N'"; 
					}
					// echo $str;

					// panjang karakter kurang dari 5
					if(strlen($key) < 5){
					?>
						<div class="col-lg-12">
							<div class="alert alert-block alert-danger fade in">
								<p>Panjang kata kunci minimal harus lima karakter...</p>	
							</div>
						</div>
					<?php	
					die();			
					}else{
						$query_noindex = mysqli_query($koneksi,$str);
						$cek = mysqli_num_rows($query_noindex);
					}

					// cek jika data tidak ditemukan
					if ($cek == 0){
					?>
						<div class="col-lg-12">
							<div class="alert alert-block alert-danger fade in">
								<p>Data tidak ditemukan...</p>	
							</div>
						</div>
					<?php
					}else{
						$jumlah_perpage = 20;
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						$str2 = $str." order by DATE_FORMAT(TanggalLahir, '%d') Limit $mulai,$jumlah_perpage";	
						// echo $str2;	
						
				?>		
					<div class="col-lg-12">
						<div class = "table-responsive">
							<table class="table-judul" width="100%">
								<thead>
									<tr>
										<th width="3%" style="text-align:center;">NO.</th>
										<th width="17%" style="text-align:center;">NAMA PASIEN - KK</th>
										<th width="10%" style="text-align:center;">TANGGAL LAHIR</th>
										<th width="60%" style="text-align:center;" class="col-sm-2">ALAMAT</th>
										<th width="10%" style="text-align:center;">#</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 0;
									$query_noindex = mysqli_query($koneksi,$str2);
									while($data = mysqli_fetch_assoc($query_noindex)){
										$no = $no + 1;
										
										// tbkk
										$strkk = "SELECT `NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan`,`Kota`,`Telepon` FROM `$tbkk` WHERE `NoIndex`= '$data[NoIndex]'";
										$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, $strkk));

										// ec_subdistricts
										$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
										
										// ec_cities
										$dt_citi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `city_name` FROM `ec_cities` WHERE `city_id`='$datakk[Kota]'"));
										
										$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
										strtoupper($dt_subdis['subdis_name']).", ".$dt_citi['city_name'];
									?>
										<tr>
											<input type="hidden" class="nocmreg" value="<?php echo $data['NoCM']?>">
											<td align="center"><?php echo $no;?></td>
											<td class="nama" align="left">
												<?php echo "<span style='font-weight: bold; font-style: italic; font-size: 16px;'>".$data['NamaPasien']."</span>";?>
												<span class="badge badge-success" style='font-style: italic; padding: 8px;'><?php echo substr($data['NoIndex'],-10);?></span><br/>
												<?php echo "KK. ".$datakk['NamaKK'];?><br/>
												<?php echo "NIK. ".$data['Nik'];?>
											</td>
											<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalLahir']));?></td>
											<td align="left"><?php echo strtoupper($alamat);?></td>
											<td align="center">
												<a href="?page=kk_detail&id=<?php echo $data['NoIndex'];?>&kategori=<?php echo $kategori;?>&key=<?php echo $key;?>" class="btn btn-round btn-info"><i class="fa fa-low-vision faicon"></i></a>
												<a href="?page=registrasi&idpasien=<?php echo $data['IdPasien']?>" class='btn btn-round btn-success'><i class="fa fa-user-md (alias) faicon"></i></a>
											</td>
										</tr>
									<?php	
									}
									?>
								</tbody>
							</table><hr/>
							<ul class="pagination mt-4">
								<?php
									$query_noindex = mysqli_query($koneksi,$str);
									$jumlah_query = mysqli_num_rows($query_noindex);
									
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
												echo "<li><a href='?page=registrasi&kategori_pencarian=$kategori_pencarian&key=$key&h=$i'>$i</a></li>";
											}
										}
									}
								?>	
							</ul>
						</div>	
					</div>		
				<?php 
					}
				?>

				<?php
				}else if($kategori_pencarian == 'NoRM'){					
					$str = "SELECT * FROM `$tbpasien` WHERE NoRM LIKE '%".$key."%' AND `StatusRetensi`='N'";
					$query2 = mysqli_query($koneksi,$str);
					$cek = mysqli_num_rows(mysqli_query($koneksi,$str));
					if ($cek == 0){
					?>
						<div class="col-sm-12">
							<div class="alert alert-danger"><strong><i class="ace-icon fa fa-times"></i> Data tidak ditemukan!</strong> Silahkan klik menu Pasien Baru</div>
						</div>
					<?php	
					}else{
						$jumlah_perpage = 30;
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						$str2 = $str." Limit $mulai,$jumlah_perpage";
				?>		
					<div class="col-lg-12">
						<div class = "table-responsive">
							<table class="table-judul" width="100%">
								<thead>
									<tr>
										<th width="3%"style="text-align:center;">NO.</th>
										<th width="25%" style="text-align:center;">NAMA PASIEN</th>
										<th width="15%" style="text-align:center;">KEPALA KELUARGA</th>
										<th width="10%" style="text-align:center;">TGL.LAHIR</th>
										<th width="25%" style="text-align:center;" class="col-sm-2">ALAMAT</th>
										<th width="20%" style="text-align:center;">OPSI</th>
									</tr>
								</thead>
								<tbody style="font-size:11px">
									<?php
									$no = 0;
									$query2 = mysqli_query($koneksi, $str2);
									while($dt_psn = mysqli_fetch_assoc($query2)){
										$no = $no + 1;
										
										// tbkk
										$datakk = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbkk` WHERE `NoIndex`= '$dt_psn[NoIndex]'"));
									?>
										<tr>
											<input type="hidden" class="nocmreg" value="<?php echo $dt_psn['NoCM']?>">
											<td style="text-align:right;"><?php echo $no;?></td>
											<td class="nama">
												<?php echo "<span style='font-weight: bold; font-style: italic; font-size: 16px;'>".$dt_psn['NamaPasien']."</span>";?>
												<span class="badge badge-success" style='font-style: italic; padding: 8px;'><?php echo substr($dt_psn['NoIndex'],-10);?></span><br/>
												<?php echo "KK. ".$datakk['NamaKK'];?><br/>
												<?php echo "NIK. ".$dt_psn['Nik'];?><br/>
												<?php echo "No.RM. ".substr($dt_psn['NoRM'], -6);?>
											</td>
											<td><?php echo $datakk['NamaKK'];?></td>
											<td style="text-align:center;"><?php echo $dt_psn['TanggalLahir'];?></td>
											<td><?php echo $datakk['Alamat'].", ".$datakk['Kelurahan'];?></td>
											<td align="center">
												<a href="?page=kk_detail&id=<?php echo $dt_psn['NoIndex'];?>&kategori=<?php echo $kategori;?>&key=<?php echo $key;?>" class="btn btn-round btn-success"><i class="fa fa-low-vision faicon"></i></a>
												<a href="?page=registrasi&idpasien=<?php echo $dt_psn['IdPasien']?>" class='btn btn-round btn-info'>Registrasi</a>
											</td>
										</tr>
									<?php	
									}
									?>
								</tbody>
							</table>
							<ul class="pagination mt-4">
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
												echo "<li><a href='?page=registrasi&kategori_pencarian=$kategori_pencarian&key=$key&h=$i'>$i</a></li>";
											}
										}
									}
								?>	
							</ul>
						</div>
					</div>	
				<?php
					}
				}else if($kategori_pencarian == 'NamaPasien'){
					if($kategori_pencarian !='' && $key !=''){

						$jumlah_perpage = 30;
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$alamat = $_GET['alamat'];

						if($alamat != ''){
							$strcari = "a.NamaPasien Like '%$key%' AND (b.Kelurahan = '$alamat') AND a.`StatusRetensi`='N'";
							$str = "SELECT * FROM `$tbpasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE ".$strcari;
							$str2 = $str." order by DATE_FORMAT(a.TanggalLahir, '%d') LIMIT $mulai,$jumlah_perpage ";
						}else{
							$strcari = "NamaPasien Like '%$key%' AND `StatusRetensi`='N'";
							$str = "SELECT * FROM `$tbpasien` WHERE ".$strcari;
							$str2 = $str." order by DATE_FORMAT(TanggalLahir, '%d') LIMIT $mulai,$jumlah_perpage ";
						}
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi,$str2);

				?>
				<div class="col-lg-12">
					<?php
						if(mysqli_num_rows($query) > 0){
					?>
					<div class = "table-responsive">
						<table class="table-judul" width="100%">
							<thead>
								<tr>
									<th width="3%"style="text-align:center;">NO.</th>
									<th width="17%" style="text-align:center;">NAMA PASIEN - KK</th>
									<th width="10%" style="text-align:center;">TANGGAL LAHIR</th>
									<th width="50%" style="text-align:center;" class="col-sm-2">ALAMAT</th>
									<th width="10%" style="text-align:center;">#</th>
								</tr>
							</thead>
							<tbody>
							<?php							
							while($data = mysqli_fetch_assoc($query)){
								$no = $no + 1;
								
								// tbkk
								$strkk = "SELECT `NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan`,`Kota`,`Telepon` FROM `$tbkk` WHERE `NoIndex`= '$data[NoIndex]'";
								$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, $strkk));

								// ec_subdistricts
								$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
								
								// ec_cities
								$dt_citi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `city_name` FROM `ec_cities` WHERE `city_id`='$datakk[Kota]'"));
								
								$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
								strtoupper($dt_subdis['subdis_name']).", ".$dt_citi['city_name'];
							?>
								<tr>
									<td align="center"><?php echo $no;?></td>
									<td class="nama">
										<?php echo "<span style='font-weight: bold; font-style: italic; font-size: 16px;'>".$data['NamaPasien']."</span>";?>
										<span class="badge badge-success" style='font-style: italic; padding: 8px;'><?php echo substr($data['NoIndex'],-10);?></span><br/>
										<?php echo "KK. ".$datakk['NamaKK'];?><br/>
										<?php echo "NIK. ".$data['Nik'];?><br/>
										<?php echo "NoRM. ".substr($data['NoRM'],-10);?>
									</td>
									<td style="text-align:center;"><?php echo date('d-m-Y',strtotime($data['TanggalLahir']));?></td>
									<td><?php echo strtoupper($alamat);?></td>
									<td style="text-align:center;">
										<a href="?page=kk_detail&id=<?php echo $data['NoIndex'];?>&kategori=<?php echo $kategori;?>&key=<?php echo $key;?>" class="btn btn-round btn-info"><i class="fa fa-low-vision faicon"></i></a>
										<a href="?page=registrasi&idpasien=<?php echo $data['IdPasien'];?>" class="btn btn-round btn-success btnmodalkartupasien"><i class="fa fa-user-md (alias) faicon"></i></a>
									</td>			
								</tr>
							<?php
							}
							?>
							</tbody>
						</table><hr/>
						<ul class="pagination mt-4">
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
											echo "<li><a href='?page=registrasi&kategori_pencarian=$kategori_pencarian&key=$key&h=$i'>$i</a></li>";
										}
									}
								}
							?>	
						</ul>	
					</div>
					<?php
						}else{
							echo "<div class='alert alert-danger'>tidak ada data yg sesuai dengan kata kunci</div>";
						}
					?>
				</div>
				<?php
					}
				}else if($kategori_pencarian == 'NamaKK'){
					if($kategori_pencarian !='' && $key !=''){
				?>
				<div class="col-lg-12">
					<div class = "table-responsive">
						<table class="table-judul" width="100%">
							<thead>
								<tr>
									<th width="3%"style="text-align:center;">NO.</th>
									<th width="17%" style="text-align:center;">NAMA PASIEN - KK</th>
									<th width="10%" style="text-align:center;">TANGGAL LAHIR</th>
									<th width="50%" style="text-align:center;" class="col-sm-2">ALAMAT</th>
									<th width="10%" style="text-align:center;">#</th>
								</tr>
							</thead>
							<tbody style="font-size:11px">
							<?php
							$jumlah_perpage = 20;
							if($_GET['h']==''){
								$mulai=0;
							}else{
								$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$alamat = $_GET['alamat'];
							if($alamat != ''){
								$strcari = "a.NamaKK Like '%$key%' AND (a.Kelurahan = '$alamat') AND b.`NamaPasien`!=''";
							}else{
								$strcari = "a.NamaKK Like '%$key%' AND b.`NamaPasien`!=''";
							}
							
							$str = "SELECT b.`Nik`, b.`NoRM`, a.`NoIndex`, a.`NamaKK`, a.`Alamat`, a.`RT`, a.`RW`, a.`Kelurahan`, a.`Kota`, b.`IdPasien`, b.`NamaPasien`, b.`TanggalLahir`, b.`NoCM`
							FROM `$tbkk` a LEFT JOIN `$tbpasien` b ON a.NoIndex = b.NoIndex WHERE ".$strcari;
							$str2 = $str." order by DATE_FORMAT(b.TanggalLahir, '%d') LIMIT $mulai,$jumlah_perpage ";
							// echo $str2;
							
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$query = mysqli_query($koneksi,$str2);
							while($data = mysqli_fetch_assoc($query)){
								$no = $no + 1;
								
								// ec_subdistricts
								$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$data[Kelurahan]'"));
								
								// ec_cities
								$dt_citi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `city_name` FROM `ec_cities` WHERE `city_id`='$data[Kota]'"));
								
								$alamat = $data['Alamat'].", RT.".$data['RT'].", RW.".$data['RW'].", ".
								strtoupper($dt_subdis['subdis_name']).", ".$dt_citi['city_name'];
							?>
								<tr>
									<td align="center"><?php echo $no;?></td>
									<td class="nama" align="left">
										<?php echo "<span style='font-weight: bold; font-style: italic; font-size: 16px;'>".$data['NamaPasien']."</span>";?>
										<span class="badge badge-success" style='font-style: italic; padding: 8px;'><?php echo substr($data['NoIndex'],-10);?></span><br/>
										<?php echo "KK. ".$data['NamaKK'];?><br/>
										<?php echo "NIK. ".$data['Nik'];?><br/>
										<?php echo "NoRM. ".substr($data['NoRM'],-10);?>
									</td>
									<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalLahir']));?></td>
									<td align="left"><?php echo strtoupper($alamat);?></td>
									<td align="center">
										<a href="?page=kk_detail&id=<?php echo $data['NoIndex'];?>&kategori=<?php echo $kategori;?>&key=<?php echo $key;?>" class="btn btn-round btn-info"><i class="fa fa-low-vision faicon"></i></a>
										<a href="?page=registrasi&idpasien=<?php echo $data['IdPasien'];?>" class="btn btn-round btn-success btnmodalkartupasien"><i class="fa fa-user-md (alias) faicon"></i></a>
									</td>			
								</tr>
							<?php
							}
							?>
							</tbody>
						</table>
						<ul class="pagination mt-4">
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
											echo "<li><a href='?page=registrasi&kategori_pencarian=$kategori_pencarian&key=$key&h=$i'>$i</a></li>";
										}
									}
								}
							?>	
						</ul>
					</div>
				</div>
				<?php
				}
				}else if($kategori_pencarian == 'TanggalLahir'){
				?>
				<div class="col-lg-12">
					<div class = "table-responsive">
						<table class="table-judul" width="100%">
							<thead>
								<tr>
									<th width="3%"style="text-align:center;">NO.</th>
									<?php if($kota != 'KOTA TARAKAN'){ ?>
									<th width="10%"style="text-align:center;">NO.RM</th>
									<?php } ?>
									<th width="17%" style="text-align:center;">NAMA PASIEN - KK</th>
									<th width="10%" style="text-align:center;">TANGGAL LAHIR</th>
									<th width="50%" style="text-align:center;" class="col-sm-2">ALAMAT</th>
									<th width="10%" style="text-align:center;">#</th>
								</tr>
							</thead>
							<tbody style="font-size:11px">
							<?php					
							$thnlahir = $_GET['thnlahir'];
							$str = "SELECT * FROM `$tbpasien` WHERE `NamaPasien` Like '%$key%' AND YEAR(TanggalLahir) = '$thnlahir'  AND `StatusRetensi`='N' ORDER BY DATE_FORMAT(TanggalLahir, '%d')";
							// echo $str;
							
							$query = mysqli_query($koneksi,$str);
							while($data = mysqli_fetch_assoc($query)){
								$no = $no + 1;
								if($data['TanggalLahir'] != ''){
								
								// tbkk
								$strkk = "SELECT `NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan`,`Kota`,`Telepon` FROM `$tbkk` WHERE `NoIndex`= '$data[NoIndex]'";
								$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, $strkk));

								// ec_subdistricts
								$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
								
								// ec_cities
								$dt_citi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `city_name` FROM `ec_cities` WHERE `city_id`='$datakk[Kota]'"));
								
								$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
								strtoupper($dt_subdis['subdis_name']).", ".$dt_citi['city_name'];
							
							?>
								<tr>
									<td align="center"><?php echo $no;?></td>
									<?php
										if($kota != 'KOTA TARAKAN'){
											if($_SESSION['kota'] == 'KABUPATEN BULUNGAN'){
												$normpasien = substr($data['NoRM'],-6);
											}elseif($_SESSION['kota'] == 'KABUPATEN KUTAI KARTANEGARA'){
												$normpasien = substr($data['NoRM'],-8);
											}else{
												$normpasien = substr($data['NoRM'],-11);
											}
									?>
									<td style="text-align:center;"><?php echo $normpasien;?></td>
									<?php } ?>
									<td class="nama">
										<?php echo "<span style='font-weight: bold; font-style: italic; font-size: 16px;'>".$data['NamaPasien']."</span>";?>
										<span class="badge badge-success" style='font-style: italic; padding: 8px;'><?php echo substr($data['NoIndex'],-10);?></span><br/>
										<?php echo "KK. ".$datakk['NamaKK'];?>
									</td>
									<td style="text-align:center;"><?php echo date('d-m-Y',strtotime($data['TanggalLahir']));?></td>
									<td><?php echo strtoupper($alamat);?></td>
									<td style="text-align:center;">
										<a href="?page=kk_detail&id=<?php echo $data['NoIndex'];?>&kategori=<?php echo $kategori;?>&key=<?php echo $key;?>" class="btn btn-round btn-info"><i class="fa fa-low-vision faicon"></i></a>
										<a href="?page=registrasi&idpasien=<?php echo $data['IdPasien'];?>" class="btn btn-round btn-success btnmodalkartupasien"><i class="fa fa-user-md (alias) faicon"></i></a>
									</td>			
								</tr>
							<?php
								}
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
				<?php
				}else if($kategori_pencarian == 'BPJS' || $kategori_pencarian == 'NIK'){
					if($kategori_pencarian == 'NIK'){
						$alertplus = "No KTP";	
					}else{
						$alertplus = "No BPJS";
					}
					
					$dbpjs = json_decode($data_bpjs,TRUE);
					// echo "Hasil : ".$data_bpjs;
					$nokartubpjs = $dbpjs['response']['noKartu'];			
					if ($dbpjs['metaData']['code'] == 500 || $dbpjs['metaData']['code'] == 401 || $dbpjs['metaData']['code'] == 408 || $dbpjs['metaData']['code'] == 424 || $dbpjs['metaData']['code'] == 204 || $dbpjs['metaData']['code'] == 50000){	
				?>		
						<div class="col-sm-12">
						<div class="alert alert-danger"><strong>Data tidak ditemukan : </strong><br/>- Cek ulang <?php echo $alertplus;?> <br/> - Pastikan sudah update Password BPJS maksimal 2(dua) Bulan Sekali</div>
						</div>	
							
				<?php 
					die();
					} 
				?>	
					<div class="col-sm-12">
						<div class="sidebars">
							<table class="table-judul" width="100%">
								<?php
									// cek noindex/norm, jika tidak dibuat variabel maka nobpjs tidak tampil
									$key = $_GET['key'];
									$str_cek = "SELECT * FROM `$tbpasien` WHERE (`NoAsuransi` like '%$key%' OR `Nik` like '%$key%') ORDER BY IdPasien DESC LIMIT 1";
									$query_cek = mysqli_query($koneksi, $str_cek);
									$data_pasienbpjs = mysqli_fetch_assoc($query_cek);
								?>
								<?php if($kota != "KOTA TARAKAN"){ ?>
								<tr>
									<td width="15%">No.RM</td>
									<td width="85%">
										<?php if ($data_pasienbpjs['NoRM'] != null){ ?>
										<span class="editnormtext" style = "color:black"><?php echo $data_pasienbpjs['NoRM'];?></span>
										<?php }else{ ?>
										<span class="editnormtext" style = "color:red">Belum Terdaftar</span>
										<?php } ?>
									</td>
								</tr>
								<?php } ?>
								<tr>
									<td width="15%">Nama - No.Peserta</td>
									<td width="85%" class="noindexjquery">
										<h5 style="font-weight: bold;">
											<?php 
												echo $dbpjs['response']['nama']." - ".$nokartubpjs;
											?>
										<h5>
									</td>
								</tr>
								<?php if($dbpjs['response']['pstProl'] != '' OR $dbpjs['response']['pstPrb'] != ''){ ?>
								<tr>
									<td>Peserta</td>
									<td >
										<?php if($dbpjs['response']['pstProl'] != ''){ ?>
										<span class="badge badge-danger" style='padding: 10px;'>
										<?php echo "Prolanis : ".$dbpjs['response']['pstProl'];} ?>
										</span>
										<?php if($dbpjs['response']['pstPrb'] != ''){ ?>
										<span class="badge badge-danger" style='padding: 10px;'>
										<?php echo "PRB : ".$dbpjs['response']['pstPrb']; }	?>
										</span>
									</td>
								</tr>
								<?php } ?>
								<tr>
									<td>No.Index</td>
									<td class="noindexjquery">
										<?php if ($data_pasienbpjs['NoIndex'] != null){ ?>
											<span class="editnormtext" style = "color:black"><?php echo $data_pasienbpjs['NoIndex'];?></span>
											<?php if ($data_pasienbpjs['StatusRetensi'] == 'Y'){ ?>
												<span class="badge badge-danger" style='font-style: italic; padding: 8px;'>Retensi Inaktif</span>
											<?php } ?>	
										<?php }else{ ?>
											<span class="editnormtext" style = "color:red">Belum Terdaftar</span>
										<?php } ?>
									</td>
								</tr>
								<tr>
									<td>No.KTP</td>
									<td><?php 
										$noktp=$dbpjs['response']['noKTP'];
										if($noktp == "" OR $noktp == null){
											$noktps = "0";
										}else{
											$noktps = $noktp;
										}
										echo $noktps;
										?>
									</td>
								</tr>
								<tr>
									<td>Status Peserta</td>
									<td><?php echo strtoupper($dbpjs['response']['hubunganKeluarga']);?></td>
								</tr>	
								<tr>
									<td>Jenis Peserta</td>
									<td><?php echo $dbpjs['response']['jnsPeserta']['nama'];?></td>
								</tr>
								<tr>
									<td>Tgl.Mulai Aktif</td>
									<td><?php echo $dbpjs['response']['tglMulaiAktif'];?></td>
								</tr>
								<tr>
									<td>Tgl.Akhir Berlaku</td>
									<td><?php echo $dbpjs['response']['tglAkhirBerlaku'];?></td>
								</tr>	
								<tr>
									<td>Tgl.Lahir</td>
									<td><span class="tgllahir-hitung-umur"><?php echo $dbpjs['response']['tglLahir'];?></span></td>
								</tr>
								<tr>
									<td>Perkiraan Umur</td>
									<td><span class="tgllahir-perkiraan-umur"></span></td>
								</tr>			
								<tr>
									<td>Jenis Kelamin</td>
									<td>
									<?php 
									if($dbpjs['response']['sex'] == 'L'){
										$jeniskel = "Laki-laki";
									}else if($dbpjs['response']['sex'] == 'P'){
										$jeniskel = "Perempuan";
									}
									echo strtoupper($jeniskel);
									?>
									</td>
								</tr>	
								<tr>
									<td>Kode - Provider</td>
									<td>
										<?php 							
										$kdprovider = $dbpjs['response']['kdProviderPst']['kdProvider'];
										$nmprovider = $dbpjs['response']['kdProviderPst']['nmProvider'];
										$sskdprovider = $_SESSION['kodeppk'];
										if($kdprovider == $sskdprovider){
											echo $kdprovider." - ".$nmprovider;
										}else{
											echo "<span style='color:red'>".$kdprovider." - ".$nmprovider."</span>";
										}
										
										?>
									</td>
								</tr>
								<tr>
									<td>Ket. Aktif</td>
									<td>
										<?php 
										$ketaktif = $dbpjs['response']['ketAktif'];
										if($ketaktif == 'AKTIF'){
											echo "<span style='color:black'>$ketaktif</span>";
										}else{
											echo "<span style='color:red;font-weight:bold'>$ketaktif</span>";
										}
										?>
									</td>
								</tr>
								<tr>
									<td>Tunggakan</td>
									<td>
									<?php 
										$tunggakan = $dbpjs['response']['tunggakan'];
										if($tunggakan > 0){
											echo "<span style='color:red;font-weight:bold'>$tunggakan</span>";
										}else{
											echo "<span style='color:black;font-weight:bold'>$tunggakan</span>";
										}
									?>
									</td>
								</tr>
								<?php
									if($data_pasienbpjs['NoIndex'] == null){
								?>	
									<tr class="trbtnsimpankk">
										<td colspan="3"><hr>
										<a href="?page=kk_insert&noasuransi=<?php echo $nokartubpjs;?>" class="btn btn-round btn-success btnsimpan btnmodalinsertkk" style="text-align: center;">Tambah Sebagai Pasien</a>
										</td>
									</tr>
								<?php
									}
								?>
							</table>
						</div>
					</div>
				<?php
				}else{
					// echo $str;
					$query = mysqli_query($koneksi, $str);
					$data = mysqli_fetch_assoc($query);
					$nomorasuransi = $data['NoAsuransi'];

					// tbkk
					$strkk = "SELECT `NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan`,`Kota`,`Telepon` FROM `$tbkk` WHERE `NoIndex`= '$data[NoIndex]'";
					$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, $strkk));

					// ec_subdistricts
					$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
					
					// ec_cities
					$dt_citi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `city_name` FROM `ec_cities` WHERE `city_id`='$datakk[Kota]'"));
					
					$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
					strtoupper($dt_subdis['subdis_name']).", ".$dt_citi['city_name'];
					
					if(mysqli_num_rows($query) != 0){	
				?>
					<div class="col-sm-8 mt-2">	
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">
											<?php echo $data['NamaPasien'];?>
											<span class="badge badge-success" style="padding: 8px 8px 8px 8px; font-size: 16px; font-style: italic;"><?php echo substr($data['NoIndex'], -10);?></span>
										</div>
									</div>
									<div class="card-body">
										<table class="table table-striped" style="margin: auto;">
											<tr>
												<input type="hidden" class="idpasien" value="<?php echo $data['IdPasien']?>">
												<td width="25%">NIK</td>
												<td width="75%">
													<span class="editnik" style = "font-size: 13px; color:black;"><?php echo $data['Nik'];?></span>
													<span class="btn btn-success btn-round btneditnik fas fa-pencil-alt pull-right" style="cursor:pointer"></span>
												</td>
											</tr>
											<?php if($kota != 'KOTA TARAKAN'){ ?>
											<tr>
												<input type="hidden" class="nocmreg" value="<?php echo $data['NoCM']?>">
												<input type="hidden" class="noindexreg" value="<?php echo $data['NoIndex']?>">
												<td>No.RM Lama</td>
												<td>
													<?php
													if($_SESSION['kota'] == 'KABUPATEN BULUNGAN'){
														$norms = substr($data['NoRM'],-6);
													}elseif($_SESSION['kota'] == 'KABUPATEN KUTAI KARTANEGARA'){
														$norms = substr($data['NoRM'],-8);
													}elseif($_SESSION['kota'] == 'KABUPATEN GARUT'){
														$norms = substr($data['NoRM'],-6);
													}else{
														if(strlen($data['NoRM']) == 22){
															$norms = substr($data['NoRM'],-11);
														}elseif(strlen($data['NoRM']) == 20){
															$norms = substr($data['NoRM'],-9);
														}elseif(strlen($data['NoRM']) == 17){
															$norms = substr($data['NoRM'],-6);
														}elseif(strlen($data['NoRM']) == 19){
															$norms = substr($data['NoRM'],-8);
														}
													}
													?> 
													<span class="editnormtext" style = "font-size:14px;"><?php echo $norms;?></span>
													<span class="btn btn-success btn-round btneditnorm fas fa-pencil-alt pull-right" style="cursor:pointer"></span>
												</td>
											</tr>
											<?php 
											}
											if($kota == "KABUPATEN BANDUNG"){ 
											?>
											<tr>
												<input type="hidden" class="nocmreg" value="<?php echo $data['NoCM']?>">
												<input type="hidden" class="noindexreg" value="<?php echo $data['NoIndex']?>">
												<td>New RM</td>
												<td>
													<span style = "font-size:14px;" class="view_newrm"><?php echo $data['NewNoRM'];?></span>
													<?php
														if($data['NewNoRM'] == ''){
													?>
													<button type="button" class="btn btn-round btn-sm btn-info btncreatenewrm" data-stskeluarga="<?php echo $data['StatusKeluarga'];?>" data-desa="<?php echo $datakk['Kelurahan'];?>" data-kota="<?php echo $datakk['Kota'];?>" data-nocm="<?php echo $data['NoCM'];?>" data-noindex="<?php echo $data['NoIndex'];?>">CREATE</button>
													<?php
														}
													?>
												</td>
											</tr>
											<?php } ?>
											<tr>
												<input type="hidden" class="nocmreg" value="<?php echo $data['NoCM']?>">
												<td>No.BPJS</td>
												<td class="editnobpjs">
													<span class="editnobpjstext"><?php echo $data['NoAsuransi'];?></span>
													<span class="btn btn-success btn-round btneditnobpjs fas fa-pencil-alt pull-right" style="cursor:pointer"></span>
												</td>
											</tr>						
											<tr>
												<input type="hidden" class="idpasien" value="<?php echo $data['IdPasien']?>">
												<td>Nama Pasien</td>
												<td class="editnamapsn">
													<span class="editnamapsntext" style="font-size:14px; font-weight: bold;"><?php echo $data['NamaPasien'];?></span>
													<span class="btn btn-success btn-round btnedit fas fa-pencil-alt pull-right" style="cursor:pointer"></span>
												</td>
											</tr>
											<tr>
												<td>Hubungan</td>
												<td><span><?php echo $data['StatusKeluarga'];?></span></td>
											</tr>	
											<tr>
												<td>Tgl.Lahir</td>
												<td><span class="tgllahir-hitung-umur"><?php echo date("d-m-Y",strtotime($data['TanggalLahir']));?></span></td>
											</tr>
											<tr>
												<td>Perkiraan Umur</td>
												<td><span class="tgllahir-perkiraan-umur"></span></td>
											</tr>
											<tr>
												<td>Kelamin</td>
												<td><span><?php if ($data['JenisKelamin'] == 'L'){ echo "LAKI-LAKI"; }else{ echo "PEREMPUAN";}?></span></td>
											</tr>
											<tr>
												<td>Alamat</td>
												<td><span><?php echo $alamat;?></span></td>
											</tr>
											<tr>
												<input type="hidden" class="noindexreg" value="<?php echo $data['NoIndex']?>">
												<td>Telepon Rumah</td>
												<td>
													<span class="editnotelp"><?php echo $datakk['Telepon'];?></span>
													<span class="btn btn-success btn-round btneditnotelp fas fa-pencil-alt pull-right" style="cursor:pointer"></span>
												</td>
											</tr>
											<tr>
												<input type="hidden" class="idpasienreg" value="<?php echo $data['IdPasien']?>">
												<td>Telepon Seluler (HP)</td>
												<td>
													<span class="editnotelpseluler"><?php echo $data['Telpon'];?></span>
													<span class="btn btn-success btn-round btneditnotelpseluler fas fa-pencil-alt pull-right" style="cursor:pointer"></span>
												</td>
											</tr>						
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4 mt-2">
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">
											E-Tiket
										</div>
									</div>
									<div class="card-body">
										<select class="form-control inputan labeloption">						
											<option value="labelpasien">Label Pasien</option>
											<option value="labelkk">Label KK</option>
											<option value="labelmap">Label Map/Folder</option>
											<option value="kartupasien">Kartu Pasien</option>
										</select>
										<br/>
										<select class="form-control inputan etiketoption">
											<option value="noindex">No.Index</option>
											<option value="norm">No.RM</option>
											<option value="newrm">New RM</option>
										</select>
										<br/>
										<div class="print_etiket">
											<p style="margin-bottom:10px; line-height:14px; margin-left: 15px; color: #000;">
												<span id="labelpasien">
													<?php 
														echo "<b>".$data['NamaPasien']."</br></b>";
														if($data['JenisKelamin'] == 'L'){echo 'Laki-laki, ';}else{echo 'Perempuan, ';}; echo date("d-m-Y",strtotime($data['TanggalLahir']))."<br/>";
														echo strtoupper($datakk['Alamat']).", RT.".$datakk['RT'].", RW.".$datakk['RW']."</br>"
														.strtoupper($dt_subdis['subdis_name']).", ".strtoupper($dt_citi['city_name'])."</br>"
														."NIK : ".$data['Nik']."</br>"
														."CARA BAYAR : ".$data['Asuransi'];
													?>
												</span>
												<span id="labelkk" style="display:none">
													<?php
														echo "<b>".$datakk['NamaKK']."</br></b>"
														.$datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW']."</br>"
														.strtoupper($dt_subdis['subdis_name']).", ".strtoupper($dt_citi['city_name']);
													?>
												</span>
												<span id="labelmap" style="display:none">
													<b>
														<?php echo "KK : ".$datakk['NamaKK'];?><br/>
														<?php echo $data['NamaPasien']." (".$data['StatusKeluarga'].")";?><br/>
													</b>	
														<?php echo date("d-m-Y",strtotime($data['TanggalLahir']));?><br/>
														<?php echo $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'];?><br/>
														<?php echo strtoupper($dt_subdis['subdis_name']).", ".strtoupper($dt_citi['city_name']);?>
													<br/>
												</span>	
											</p>
											<img class="barcodebpjs-index" height="55px" style="margin-left: 16px;">
											<img class="barcodebpjs-rm" height="55px" style="display:none; margin-left: 16px;"/>
											<img class="barcodebpjs-newrm" height="55px" style="display:none; margin-left: 16px;"/>
										</div>
										<div class="kartu_pasien" style="display:none;height:200px; margin-bottom:-10px">
											<?php if($kartu['Image'] != ''){?>
												<img src="image/kartupasien/<?php echo $kartu['Image'];?>" class="clsbgkartu_dua">
											<?php }?>
											<p class="tbnama">
												<?php echo $data['NamaPasien'];?><br>
											<p>
											<p class="tbalamat">
												<?php echo tgl_lengkap($data['TanggalLahir']);?>
											<p>	
											<div class="tbbarcode">	
												<img class="barcodebpjs-index barcode_kartu" width="160" height="35px"/>
												<img class="barcodebpjs-rm" height="55px" style="display:none"/>
												<img class="barcodebpjs-newrm" height="55px" style="display:none"/>
											</div>
										</div>
										<br/>
										<a href="javascript:print()" class="btn btn-round btn-success btnsimpan" style="text-align:center">PRINT</a>
										<script>
										JsBarcode(".barcodebpjs-index", "<?php echo substr($data['NoIndex'],14,10);?>",{
											format: "CODE128",
											width:3,
											height:45,
											displayValue: true, 
											fontSize: 26,
											fontOptions: "bold"
										});
										JsBarcode(".barcodebpjs-rm", "<?php echo substr($data['NoRM'],-11);?>",{
											format: "CODE128",
											width:3,
											height:45,
											displayValue: true, 
											fontSize: 26,
											fontOptions: "bold"
										});
										JsBarcode(".barcodebpjs-newrm", "<?php echo $data['NewNoRM'];?>",{
											format: "CODE128",
											width:3,
											height:45,
											displayValue: true, 
											fontSize: 26,
											fontOptions: "bold"
										});		
										</script>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php	
					}
				}	
				?>

				<?php
				if ($_GET['idpasien'] != '' OR ($kategori_pencarian == 'BPJS') AND $_GET['key'] != ''){
				?>
				<div class="col-sm-12 mt-4">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title">
										Rekam Medis Elektronik
									</div>
								</div>
								<div class="card-body">
									<ul class="nav nav-pills nav-secondary  nav-pills-no-bd nav-pills-icons justify-content-left noprint" id="pills-tab-with-icon" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" align="center" href="rekam_medis_blangko_persetujuan.php?id=<?php echo $data['IdPasien'];?>&nocm=<?php echo $data['NoCM'];?>">
												<i class="icon-people"></i>
												Persetujuan <br/> (Form-1)
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" align="center" href="rekam_medis_blangko_hakkewajiban.php?id=<?php echo $data['IdPasien'];?>&nocm=<?php echo $data['NoCM'];?>">
												<i class="icon-people"></i>
												Hak & Kewajiban <br/> (Form-2)
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" align="center" href="rekam_medis_blangko_identitas.php?id=<?php echo $data['IdPasien'];?>&nocm=<?php echo $data['NoCM'];?>&sts=registrasi">
												<i class="icon-people"></i>
												Identitas Pasien <br/> (Form-3)
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>	
				<?php
				}
				?>

				<!---riwayat kunjungan--->
				<?php
				$kodepuskesmas = $_SESSION['kodepuskesmas'];
				$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);

				$jumlah_perpage = 5;
					
				if($_GET['h']==''){
					$mulai=0;
				}else{
					$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}							

				if ($_GET['idpasien'] != '' OR ($kategori_pencarian == 'BPJS') AND $_GET['key'] != ''){
					if($kategori_pencarian == 'BPJS' || $kategori_pencarian == 'NIK'){
						$nokartu = $_GET['key'];
						$str = "SELECT * FROM `$tbpasienrj` WHERE `nokartu`='$nokartu'";
						$str2 = $str." ORDER BY TanggalRegistrasi DESC LIMIT $mulai,$jumlah_perpage";
					}else{
						$keys = $_GET['idpasien'];
						$str = "SELECT * FROM `$tbpasienrj` WHERE `IdPasien`='$keys'";
						$str2 = $str." ORDER BY TanggalRegistrasi DESC LIMIT $mulai,$jumlah_perpage";
					}
					// echo $str;

					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
				?>
				
				<div class="col-sm-12">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title">
										Riwayat Kunjungan
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table-bordered table-judul" width="100%">
											<thead class="thead-dark">
												<tr>
													<th width="15%">TANGGAL KUNJUNGAN</th>
													<th width="15%">LAYANAN</th>
													<th width="15%">CARA BAYAR</th>
													<th width="15%">KUNJUNGAN</th>
													<th width="15%">STATUS PULANG</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$queryriwayat = mysqli_query($koneksi, $str2);
												while($dtriwayat = mysqli_fetch_assoc($queryriwayat)){
													if ($dtriwayat['StatusPulang'] == '3'){$statusplg='Berobat Jalan';}else{$statusplg='Rujuk Lanjut';}
												?>
													<tr>
														<td style="text-align: center;"><?php echo $dtriwayat['TanggalRegistrasi'];?></td>
														<td style="text-align: center;"><?php echo str_replace('POLI','',$dtriwayat['PoliPertama']);?></td>
														<td style="text-align: center;"><?php echo $dtriwayat['Asuransi'];?></td>	
														<td style="text-align: center;"><?php echo strtoupper($dtriwayat['StatusKunjungan']);?></td>	
														<td style="text-align: center;"><?php echo strtoupper($statusplg);?></td>	
													</tr>
												<?php
												}
												?>	
											</tbody>
										</table><br/>
									</div><hr/>
									<ul class="pagination">
										<?php
											$query2 = mysqli_query($koneksi, $str);
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
														echo "<li><a href='?page=registrasi&idpasien=$idpasien&h=$i'>$i</a></li>";
													}
												}
											}
										?>	
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				

				<!---form registrasi--->
				<?php
				if ($_GET['idpasien'] != '' OR ($_GET['kategori_pencarian'] == 'BPJS') AND $_GET['key'] != ''){
				?>

				<div class="col-sm-12">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title">
										Registrasi Pasien
									</div>
								</div>
								<div class="card-body">
									<form class="form-horizontal formsimpanproses" action="registrasi_proses.php" method="post" role="form">
										<?php 
										$data_asuransi = $data['Asuransi'];
										if($kategori_pencarian == 'BPJS' || $kategori_pencarian == 'NIK'){
										?>		
											<input type="hidden" name="kodeprovider" value="<?php echo $dbpjs['response']['kdProviderPst']['kdProvider'];?>">
											<input type="hidden" name="nokartubpjs" value="<?php echo $dbpjs['response']['noKartu'];?>">
											<input type="hidden" name="namapasien" value="<?php echo $dbpjs['response']['nama'];?>">
											<input type="hidden" name="jeniskelamin" value="<?php echo $dbpjs['response']['sex'];?>">
											<input type="hidden" name="ketaktif" value="<?php echo $dbpjs['response']['ketAktif'];?>">
											<?php 
												$format_tgl_bpjs = $dbpjs['response']['tglLahir'];
												$format_tgl_ini = ubah_format_tgl($format_tgl_bpjs);
											?>
											<input type="hidden" name="tanggallahir" value="<?php echo $format_tgl_ini;?>">
											<?php
											// ngecek noindex dan nocm untuk insert ke tbpasienrj
											// outputnya menghasilkan kelurahan
											if($data_pasienbpjs['NoIndex'] == ''){
											?>
												<input type="hidden" name="noindex" value="<?php echo $dbpjs['response']['noKartu'];?>">
												<input type="hidden" name="nocm" value="<?php echo $dbpjs['response']['noKartu'];?>">
												<input type="hidden" name="norm" value="<?php echo $dbpjs['response']['noKartu'];?>">
											<?php
											}else{
											?>
												<input type="hidden" name="idpasien" value="<?php echo $data_pasienbpjs['IdPasien'];?>">
												<input type="hidden" name="noindex" value="<?php echo $data_pasienbpjs['NoIndex'];?>">
												<input type="hidden" name="nocm" value="<?php echo $data_pasienbpjs['NoCM'];?>">
												<input type="hidden" name="norm" value="<?php echo $data_pasienbpjs['NoRM'];?>">
											<?php
											}
										}else{
											?>
												<input type="hidden" name="idpasien" value="<?php echo $data['IdPasien'];?>">
												<input type="hidden" name="kodeprovider" class="kodeprovider" value="<?php echo $data['kdprovider'];?>">
												<input type="hidden" name="nokartubpjs" class="nokartubpjseditjquery" value="<?php echo $data['NoAsuransi'];?>">
												<input type="hidden" name="noindex" value="<?php echo $data['NoIndex'];?>">
												<input type="hidden" name="nocm" value="<?php echo $data['NoCM'];?>">
												<input type="hidden" name="norm" value="<?php echo $data['NoRM'];?>">
												<input type="hidden" name="namapasien" value="<?php echo $data['NamaPasien'];?>">
												<input type="hidden" name="jeniskelamin" value="<?php echo $data['JenisKelamin'];?>">
												<input type="hidden" name="tanggallahir" value="<?php echo $data['TanggalLahir'];?>">
												<input type="hidden" name="pekerjaan" value="<?php echo $data['Pekerjaan'];?>">
												<input type="hidden" name="kelurahan" value="<?php echo $datakk['Kelurahan'];?>">
												<input type="hidden" name="ketaktif" value="null"/>
											<?php 
										}
										?>
										
										<table class="table table-condesed">
											<tr>
												<td width="20%">Tgl.Registrasi</td>
												<td width="80%">
													<div class="row">
														<input type="text" name="tanggalregistrasi" class="form-control inputan datepicker tglreg" value="<?php echo $hariini;?>" autofocus>
													</div>
												</td>
											</tr>
											<tr>
												<td>Shift</td>
												<td>
													<div class="row">
														<select name="waktukunjungan" class="form-control inputan" required>
															<option value="">--Pilih--</option>
															<option value="1" SELECTED>SHIFT 1</option>
															<option value="2">SHIFT 2</option>
															<option value="3">SHIFT 3</option>
														</select>	
													</div>
												</td>
											</tr>
											<tr>
												<td>Kunjungan</td>
												<td>
													<div class="row">
														<?php
															$tahunini = date('y');
															$str_kunj = "SELECT NoRegistrasi FROM `$tbpasienrj` WHERE `IdPasien`='$idpasien'";
															$cek_kunj = mysqli_num_rows(mysqli_query($koneksi, $str_kunj));
															if($cek_kunj == 0){
																$stskunj = 'Baru';
															}else{
																$stskunj = 'Lama';
															}
														?>
														<input type="text" class="form-control inputan" value="<?php echo "Kunjungan : ".$stskunj;?>" readonly>
														<input type="hidden" name="statuskunjungan" class="form-control inputan" value="<?php echo $stskunj;?>" readonly>
													</div>
												</td>
											</tr>
											<tr>
												<td>Perawatan</td>
												<td>
													<div class="radio">
														<label>
															<input type="radio" name="perawatan" value="false" id="rajal" checked onchange="if (this.checked){document.getElementById('kjsehat').disabled=false;}"> Rawat Jalan
														</label>&nbsp &nbsp
														<label>
															<input type="radio" name="perawatan" value="true" id="ranap" onchange="if (this.checked){document.getElementById('kjsehat').disabled=true;}"> Rawat Inap
														</label>
													</div>
												</td>
											</tr>
											<tr>
												<td>Kunjungan</td>
												<td>
													<div class="radio">
													  <label>
															<input type="radio" name="kunjungan" class="statuskunjunganpoli" value="true" id="kjsakit" checked onchange="if (this.checked){document.getElementById('ranap').disabled=false;}"> Kunjungan Sakit
													  </label>&nbsp &nbsp
													  <label>
															<input type="radio" name="kunjungan" class="statuskunjunganpoli" value="false" id="kjsehat" onchange="if (this.checked){document.getElementById('ranap').disabled=true;}"> Kunjungan Sehat
													  </label>
													</div>	
												</td>
											</tr>
											<tr>
												<td>Asal Pasien</td>
												<td>
													<div class="row">
														<select name="asalpasien" class="form-control inputan">
															<option value="1">KELAS BALITA</option>
															<option value="2">KELAS IBU</option>
															<option value="3">PENYULUHAN KELOMPOK</option>
															<option value="4">PENYULUHAN KELUARGA</option>
															<option value="5">POLINDES</option>
															<option value="6">POSBINDU</option>
															<option value="7">POSKESDES</option>
															<option value="8">POSYANDU</option>
															<option value="9">PUSKEL</option>
															<option value="10" SELECTED>PUSKESMAS</option>
															<option value="11">PUSTU</option>
															<option value="12">STBM</option>
															<option value="13">PERKESMAS</option>
														</select>
													</div>
												</td>
											</tr>
											<tr>
												<td>Pelayanan</span></td>
												<td>
													<div class="row">
														<select name="polipertama" class="form-control inputan polipertama" required>
															<option value="">--Pilih--</option>
															<?php
															$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` WHERE JenisPelayanan = 'KUNJUNGAN SAKIT' order by `Pelayanan`");
																while($data = mysqli_fetch_assoc($query)){
																	if($data['Pelayanan'] == $_SESSION['poliantrian']){
																		echo "<option value='$data[Pelayanan]' SELECTED>$data[Pelayanan]</option>";
																	}else{
																		echo "<option value='$data[Pelayanan]'>$data[Pelayanan]</option>";
																	}
																}
															?>
														</select>
													</div>
												</td>
											</tr>
											<tr>
												<td>Dokter BPJS</span></td>
												<td>
													<div class="row">
														<select name="dokterbpjs" class="form-control inputan dokterbpjs">
															<option value="">--dokter bpjs--</option>
															
														</select>
													</div>
												</td>
											</tr>
											<?php
												if($kota == "KOTA TARAKAN"){
											?>
											<tr class="tmpelpecare" style="display: none">
												<td>
													Pelayanan Pcare
													<?php
													if($kategori_pencarian != 'BPJS' && $kategori_pencarian != 'NIK'){	
														include "config/helper_bpjs_v4.php";	
													}
													$dtpolipcare = get_data_poli();
													?>
												</td>
												<td>
													<div class="row">
														<select name="polipcare" class="form-control inputan">
															<option value="">--Pilih--</option>
															<?php
																$arrdtpolipcare = json_decode($dtpolipcare,true);
																foreach ($arrdtpolipcare['response']['list'] as $ve) {
																	if($ve['poliSakit'] == 'true'){
																		echo "<option value='$ve[kdPoli]'>$ve[nmPoli]</option>";
																	}
																}
															?>
														</select>
													</div>	
												</td>
											</tr>
											<?php
												}
											?>
											<tr>
												<td>Asuransi</td>
												<td>
													<div class="row">
														<?php
														if ($kota != 'KABUPATEN BULUNGAN'){
															if($kategori_pencarian == 'BPJS' || $kategori_pencarian == 'NIK'){
																$nokartu123 = $nokartubpjs;
																if($dbpjs['response']['jnsPeserta']['nama'] == 'PBI (APBN)' || $dbpjs['response']['jnsPeserta']['nama'] == 'PBI (APBD)'){
																	$data_asuransi = 'BPJS PBI';
																}else{
																	$data_asuransi = 'BPJS NON PBI';
																}
															}else{
																$nokartu123 = $nomorasuransi;
															}
														}
														
														$jmlnokartu = strlen($nokartu123);
														if ($nokartu123 == null || $nokartu123 == '-' || $nokartu123 == '0' || $jmlnokartu < 13){
														?>
															<select name="asuransi" class="form-control inputan asuransichange" required>
																<option value="">--Pilih--</option>
																<?php
																$query = mysqli_query($koneksi,"SELECT * FROM `tbasuransi` order by `Asuransi`");
																while($data = mysqli_fetch_assoc($query)){
																	if($kota == "KOTA TARAKAN"){
																		echo "<option value='$data[Asuransi]'>$data[Asuransi]</option>";
																	}else{
																		if($data['Asuransi'] != 'BPJS NON PBI' and $data['Asuransi'] != 'BPJS PBI'){
																			echo "<option value='$data[Asuransi]'>$data[Asuransi]</option>";
																		}
																	}	
																}
																?>
															</select>
														<?php
														}else{	
														?>	
															<?php
															$kdprov = $dbpjs['response']['kdProviderPst']['kdProvider'];
															if(($kategori_pencarian == 'BPJS' || $kategori_pencarian == 'NIK') and ($kdprov == $_SESSION['kodeppk']) and ($ketaktif == 'AKTIF')){
															?>
															<input type="text" name="asuransi" class="form-control inputan asuransichange" value="<?php echo $data_asuransi;?>" readonly>
															<?php
															}else{
															?>
															<select name="asuransi" class="form-control inputan asuransichange" required>
																<option value="">--Pilih--</option>
																<?php
																$query = mysqli_query($koneksi,"SELECT * FROM `tbasuransi` order by `Asuransi`");
																while($data = mysqli_fetch_assoc($query)){
																	if($data_asuransi == $data['Asuransi']){
																		echo "<option value='$data[Asuransi]' SELECTED>$data[Asuransi]</option>";
																	}else{
																		echo "<option value='$data[Asuransi]'>$data[Asuransi]</option>";
																	}
																}
																?>
															</select>
														<?php
															}
														}
														?>
													</div>		
												</td>
											</tr>
											<?php if($kota == "KABUPATEN BANDUNG"){ ?>
											<tr>
												<td>Administrasi *</td>
												<td>
													<div class="row">
														<input type="hidden" value="<?php echo $_SESSION['tarifadministrasi'];?>" class="tarifadministrasi">
														<select name="administrasi" class="form-control inputan stsadministrasi" required>
															<option value="Tidak" >Tidak</option>
															<option value="Ya">Ya</option>
														</select>
													</div>
												</td>
											</tr>
											<?php } ?>
											<tr>
												<td>KIR</span></td>
												<td class="parentkir">
													<?php
														$query = mysqli_query($koneksi,"SELECT * FROM `tbkir` order by `JenisKir`");
														while($dtkir = mysqli_fetch_assoc($query)){
															echo "<label stlye='margin-right:20px;'><input type='checkbox' name='kir[]' class='kircls' value='$dtkir[JenisKir]'> $dtkir[JenisKir]</label>&nbsp&nbsp&nbsp";
														}
														?>
												</td>
											</tr>
											<tr>
												<td>Tarif Karcis</td>
												<td>
													<div class="row">
														<input type="text" name="tarifkarcis" class="form-control inputan tarif" value="0" readonly>
													</div>
												</td>
											</tr>
											<tr>
												<td>Tarif Kir</td>
												<td>
													<div class="row">
														<input type="text" name="tarifkir" class="form-control inputan tarifkir" value="0" readonly>														
													</div>
												</td>
											</tr>											
											<tr>
												<td>Total Tarif</td>
												<td>
													<div class="row">
														<input type="text" name="tarif" class="form-control inputan totaltarif" value="0" readonly>
													</div>
												</td>
											</tr>
											<tr>
												<td>No.Antrian Pelayanan</td>
												<td>
													<div class="row">
														<input type="text" name="noantrian" class="form-control inputan" value="<?php echo $_SESSION['nomorantrian'];?>" placeholder="Scan / Ketik nomer antrian pada etiket">
													</div>
												</td>
											</tr>
											<tr class="tenaga_kunj_sehat" style="display:none">
												<td colspan="3"><b>Silahkan pilih tenaga kesehatan.</b></td>
											<tr>
											<tr class="tenaga_kunj_sehat" style="display:none">
												<td>Tenaga 1</td>
												<td>
													<div class="row">
														<select name="namapegawai1" class="form-control inputan namapegawai1">
															<option value="">--Pilih--</option>
															<?php 
																$qrypegawai1 = mysqli_query($koneksi,"SELECT * FROM tbpegawai WHERE KodePuskesmas = '$kodepuskesmas' order by NamaPegawai ASC");
																while($pegawai1 = mysqli_fetch_assoc($qrypegawai1)){
																	echo "<option value='".$pegawai1['NamaPegawai']."'>".$pegawai1['NamaPegawai']."</option>";
																}
															?>
														</select>
														<span class="labeltenagamedis1" style="color:red;"></span>
													</div>
												</td>
											</tr>
											<tr class="tenaga_kunj_sehat" style="display:none">
												<td>Tenaga 2</td>
												<td>
													<div class="row">
														<select name="namapegawai2" class="form-control inputan namapegawai2">
															<option value="">--Pilih--</option>
															<?php 
																$qrypegawai2 = mysqli_query($koneksi,"SELECT * FROM tbpegawai WHERE KodePuskesmas = '$kodepuskesmas' order by NamaPegawai ASC");
																while($pegawai2 = mysqli_fetch_assoc($qrypegawai2)){
																	echo "<option value='".$pegawai2['NamaPegawai']."'>".$pegawai2['NamaPegawai']."</option>";
																}
															?>
														</select>
														<span class="labeltenagamedis2" style="color:red;"></span>
													</div>
												</td>
											</tr>
											<tr class="tenaga_kunj_sehat" style="display:none">
												<td>Tenaga 3</td>
												<td>
													<div class="row">
														<select name="namapegawai3" class="form-control inputan namapegawai3">
															<option value="">--Pilih--</option>
															<?php 
																$qrypegawai3 = mysqli_query($koneksi,"SELECT * FROM tbpegawai WHERE KodePuskesmas = '$kodepuskesmas' order by NamaPegawai ASC");
																while($pegawai3 = mysqli_fetch_assoc($qrypegawai3)){
																	echo "<option value='".$pegawai3['NamaPegawai']."'>".$pegawai3['NamaPegawai']."</option>";
																}
															?>
														</select>
														<span class="labeltenagamedis3" style="color:red;"></span>
													</div>
												</td>
											</tr>
											<tr class="tenaga_kunj_sehat" style="display:none">
												<td>Tenaga 4</td>
												<td>
													<div class="row">
														<select name="namapegawai4" class="form-control inputan namapegawai4">
															<option value="">--Pilih--</option>
															<?php 
																$qrypegawai4 = mysqli_query($koneksi,"SELECT * FROM tbpegawai WHERE KodePuskesmas = '$kodepuskesmas' order by NamaPegawai ASC");
																while($pegawai4 = mysqli_fetch_assoc($qrypegawai4)){
																	echo "<option value='".$pegawai4['NamaPegawai']."'>".$pegawai4['NamaPegawai']."</option>";
																}
															?>
														</select>
														<span class="labeltenagamedis4" style="color:red;"></span>
													</div>
												</td>
											</tr>
											<tr class="tenaga_kunj_sehat" style="display:none">
												<td>Tenaga 5</td>
												<td>
													<div class="row">
														<select name="namapegawai5" class="form-control inputan namapegawai5">
															<option value="">--Pilih--</option>
															<?php 
																$qrypegawai5 = mysqli_query($koneksi,"SELECT * FROM tbpegawai WHERE KodePuskesmas = '$kodepuskesmas' order by NamaPegawai ASC");
																while($pegawai5 = mysqli_fetch_assoc($qrypegawai5)){
																	echo "<option value='".$pegawai5['NamaPegawai']."'>".$pegawai5['NamaPegawai']."</option>";
																}
															?>
														</select>
														<span class="labeltenagamedis5" style="color:red;"></span>
													</div>
												</td>
											</tr>
											<tr class="tenaga_kunj_sehat" style="display:none">
												<td>Tenaga Farmasi</td>
												<td>
													<div class="row">
														<select name="farmasi" class="form-control inputan farmasi">
															<option value="">--Pilih--</option>
															<?php 
																$qrypegawaifarmasi = mysqli_query($koneksi,"SELECT * FROM tbpegawai WHERE KodePuskesmas = '$kodepuskesmas' order by NamaPegawai ASC");
																while($pegawaifarmasi = mysqli_fetch_assoc($qrypegawaifarmasi)){
																	echo "<option value='".$pegawaifarmasi['NamaPegawai']."'>".$pegawaifarmasi['NamaPegawai']."</option>";
																}
															?>
														</select>
														<span class="labeltenagamedisfarmasi" style="color:red;"></span>
													</div>
												</td>
											</tr>
										</table>
										
										<!--Pemeriksaan Laboratorium-->
										<h4 class="formlab" style="display: none"><b>PEMERIKSAAN LABORATORIUM</b></h4><hr/>
										<div class="box border formlab" style="display: none">
											<div class="box-body">
												<div class="table-responsive">
													<table class="table-judul" width="100%">
														<tr>
															<td class="col-sm-1">Tindakan</td>
															<td class="col-sm-11">
																<div class ="col-sm-11">
																	<input type="text" class="form-control inputan tindakanbpjs">
																	<input type="hidden" class="form-control inputan idtindakanbpjs">
																	<input type="hidden" class="form-control inputan kodetindakanbpjs">
																	<input type="hidden" class="form-control inputan namatindakanbpjs">
																	<input type="hidden" class="form-control inputan kelompoktindakanbpjs">
																	<input type="hidden" class="form-control inputan tariftindakanbpjs" name="biayabpjs">
																</div>
																<div class ="col-sm-1">
																	<a type="button" class="btn btn-round btn-success tambah-tindakan-bpjs">Tambah</a>
																</div>
															</td>
														</tr>
													</table>
												</div>
												<br/>
												<div class="table-responsive">
													<table class="table-judul" width="100%">
														<!-- buat simpan data sementara -->
														<thead>
															<tr class="head-table-tindakan-bpjs">
																<th width="5%">Id</th>
																<th width="10%">Kode</th>
																<th width="50%">Tindakan</th>
																<th width="10%">Biaya</th>
																<th width="10%">Opsi</th>
															</tr>
														</thead>
														<tbody>
															<tr class="master-table-tindakan-bpjs" style="display:none">
																<input type="hidden" class="idtindakanbpjs-input">
																<input type="hidden" class="kodetindakanbpjs-input">
																<input type="hidden" class="namatindakanbpjs-input">
																<input type="hidden" class="kelompoktindakanbpjs-input">
																<input type="hidden" class="tariftindakanbpjs-input">
																<input type="hidden" class="keteranganbpjs-input">
																<td style="padding: 5px; border: 1px solid #000; text-align: center;" class="idtindakanbpjs-html"></td>
																<td style="padding: 5px; border: 1px solid #000; text-align: center;" class="kodetindakanbpjs-html"></td>
																<td style="padding: 5px; border: 1px solid #000; text-align: left;" class="namatindakanbpjs-html"></td>
																<td style="padding: 5px; border: 1px solid #000; text-align: right;" class="tariftindakanbpjs-html"></td>
																<td style="padding: 5px; border: 1px solid #000; text-align: center;"><a class="btn btn-xs btn-danger hapus-tindakan-bpjs">Hapus</a></td>
															</tr>
														</tbody>
													</table><br/>
												</div>
											</div>
										</div>
										<?php
											//if(in_array("LOKET", $otoritas) || in_array("OPERATOR", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){
										?>
											<td colspan="3">
												<button type="submit" class="btn btn-round btn-success btnsimpan btnsimpanproses">SIMPAN</button>
											</td>
										<?php
											//}
										?>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php 
				}
				?>
			</div>
		</div>
	</div>
</div>	
				
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script src='https://code.responsivevoice.org/responsivevoice.js'></script>
<script>
$(document).ready(function() {

	$(".polipertama").change(function(){
		var ini = $(this).val();
		var ses = '<?php echo $_SESSION['poliantrian']?>';			
			if(ses != ''){
				if(ini != "POLI KIA" && ini != "POLI KB" && ini != "POLI TB"){
					if(ini != ses){
						alert('Poli tidak sesuai dengan nomor antrian...');
						//$(this).val(ses);
					}
				}			
			}

		var kota = '<?php echo $kota;?>';
		if(kota == "KOTA TARAKAN"){	
			var umur_lengkap = $(".tgllahir-perkiraan-umur").text();
			var umur = umur_lengkap.split(" ")[0];
			if(parseInt(umur) >= 45){
				if(ini == "POLI UMUM"){
					alert('Silahkan registrasi ke Pelayanan Lansia...');
					$(this).val('POLI LANSIA');
				}
			}
		}
		
		if(ini == 'POLI LABORATORIUM'){
			$(".formlab").show();
		}else{
			$(".formlab").hide();
		}	

		if(ini == 'POLI GIZI'){
			$(".tmpelpecare").show();
		}else{
			$(".tmpelpecare").hide();
		}

		$.post( "get_dokter_bpjs_bypelayanan.php", { kodepoli:ini})
				.done(function( data ) {
					$( ".dokterbpjs" ).html( data );
		});

	});	


	var tgllahir = $(".tgllahir-hitung-umur").text();
	$.post( "get_umur.php", { 
		tgllahir: tgllahir
	}).done(function( data ) {
		$(".tgllahir-perkiraan-umur").text(data);
	});
	
	$(".statuskunjunganpoli").click(function(){
		var sts_kunj = $(".statuskunjunganpoli:checked").val();
		if(sts_kunj == 'false'){
			$(".tenaga_kunj_sehat").show();
		}else{
			$(".tenaga_kunj_sehat").hide();
		}
	});
	
	$(".namapegawai1").change(function(){
		var namapegawai1 = $('.namapegawai1 option:selected').html() 
		var namapegawai2 = $(".namapegawai2").val();
		var namapegawai3 = $(".namapegawai3").val();
		var namapegawai4 = $(".namapegawai4").val();
		var namapegawai5 = $(".namapegawai5").val();
		var namapegawaipendaftaran = $(".namapegawaipendaftaran").val();
		var farmasi = $(".farmasi").val();
		if(namapegawai1 == namapegawai2 || namapegawai1 == namapegawai3 || namapegawai1 == namapegawai4 ||
		namapegawai1 == namapegawai5 || namapegawai1 == farmasi || namapegawai1 == namapegawaipendaftaran ){
			$(".labeltenagamedis1").html("Tenaga medis tidak boleh lebih dari satu");
			$(this).val("");
		}else{
			$(".labeltenagamedis1").html("");
		}
	});
	
	$(".namapegawai2").change(function(){
		var namapegawai2 = $('.namapegawai2 option:selected').html() 
		var namapegawai1 = $(".namapegawai1").val();
		var namapegawai3 = $(".namapegawai3").val();
		var namapegawai4 = $(".namapegawai4").val();
		var namapegawai5 = $(".namapegawai5").val();
		var namapegawaipendaftaran = $(".namapegawaipendaftaran").val();
		var farmasi = $(".farmasi").val();
		if(namapegawai2 == namapegawai1 || namapegawai2 == namapegawai3 || namapegawai2 == namapegawai4 ||
		namapegawai2 == namapegawai5 || namapegawai2 == farmasi || namapegawai2 == namapegawaipendaftaran ){
			$(".labeltenagamedis2").html("Tenaga medis tidak boleh lebih dari satu");
			$(this).val("");
		}else{
			$(".labeltenagamedis2").html("");
		}
	});
	
	$(".namapegawai3").change(function(){
		var namapegawai3 = $('.namapegawai3 option:selected').html() 
		var namapegawai1 = $(".namapegawai1").val();
		var namapegawai2 = $(".namapegawai2").val();
		var namapegawai4 = $(".namapegawai4").val();
		var namapegawai5 = $(".namapegawai5").val();
		var namapegawaipendaftaran = $(".namapegawaipendaftaran").val();
		var farmasi = $(".farmasi").val();
		if(namapegawai3 == namapegawai1 || namapegawai3 == namapegawai2 || namapegawai3 == namapegawai4 ||
		namapegawai3 == namapegawai5 || namapegawai3 == farmasi || namapegawai3 == namapegawaipendaftaran ){
			$(".labeltenagamedis3").html("Tenaga medis tidak boleh lebih dari satu");
			$(this).val("");
		}else{
			$(".labeltenagamedis3").html("");
		}
	});	
	
	$(".namapegawai4").change(function(){
		var namapegawai4 = $('.namapegawai4 option:selected').html() 
		var namapegawai1 = $(".namapegawai1").val();
		var namapegawai2 = $(".namapegawai2").val();
		var namapegawai3 = $(".namapegawai3").val();
		var namapegawai5 = $(".namapegawai5").val();
		var namapegawaipendaftaran = $(".namapegawaipendaftaran").val();
		var farmasi = $(".farmasi").val();
		if(namapegawai4 == namapegawai1 || namapegawai4 == namapegawai2 || namapegawai4 == namapegawai3 ||
		namapegawai4 == namapegawai5 || namapegawai4 == farmasi || namapegawai4 == namapegawaipendaftaran ){
			$(".labeltenagamedis4").html("Tenaga medis tidak boleh lebih dari satu");
			$(this).val("");
		}else{
			$(".labeltenagamedis4").html("");
		}
	});		
	
	$(".namapegawai5").change(function(){
		var namapegawai5 = $('.namapegawai5 option:selected').html() 
		var namapegawai1 = $(".namapegawai1").val();
		var namapegawai2 = $(".namapegawai2").val();
		var namapegawai3 = $(".namapegawai3").val();
		var namapegawai4 = $(".namapegawai4").val();
		var namapegawaipendaftaran = $(".namapegawaipendaftaran").val();
		var farmasi = $(".farmasi").val();
		if(namapegawai5 == namapegawai1 || namapegawai5 == namapegawai2 || namapegawai5 == namapegawai3 ||
		namapegawai5 == namapegawai4 || namapegawai5 == farmasi || namapegawai5 == namapegawaipendaftaran ){
			$(".labeltenagamedis5").html("Tenaga medis tidak boleh lebih dari satu");
			$(this).val("");
		}else{
			$(".labeltenagamedis5").html("");
		}
	});	
	
	$(".farmasi").change(function(){
		var farmasi = $('.farmasi option:selected').html() 
		var namapegawai1 = $(".namapegawai1").val();
		var namapegawai2 = $(".namapegawai2").val();
		var namapegawai3 = $(".namapegawai3").val();
		var namapegawai4 = $(".namapegawai4").val();
		var namapegawaipendaftaran = $(".namapegawaipendaftaran").val();
		var namapegawai5 = $(".namapegawai5").val();
		if(farmasi == namapegawai1 || farmasi == namapegawai2 || farmasi == namapegawai3 ||
		farmasi == namapegawai4 || farmasi == namapegawai5 || farmasi == namapegawaipendaftaran ){
			$(".labeltenagamedisfarmasi").html("Tenaga medis tidak boleh lebih dari satu");
			$(this).val("");
		}else{
			$(".labeltenagamedisfarmasi").html("");
		}
	});

	$(".btncreatenewrm").click(function(){
		$(".view_newrm").text("Proses...");
		var nocm = $(this).data('nocm');
		var stskeluarga = $(this).data('stskeluarga');
		var desa = $(this).data('desa');
		var kota = $(this).data('kota');
		var noindex = $(this).data('noindex');
		//alert(desa+"- "+stskeluarga+"-"+noindex);

		$.post( "set_newrm.php",{noindex:noindex,nocm:nocm,stskeluarga:stskeluarga,desa:desa,kota:kota}).done(function( data ) {
			$(".view_newrm").text(data);
			$(".btncreatenewrm").hide();
		});
	});


	$(".panggilantrian").click(function(){
		//responsiveVoice.speak("Antrian pasien Nomor <?php echo $dataantrian['NomorAntrian'];?>","Indonesian Female", {rate: 0.8});
		$.get( "get_modal_panggil_antrian.php").done(function( data ) {
			$(".modaltampil").html(data);
			$('#Modalantrian').modal('show');
		});
	});	
	$.get( "get_modal_panggil_antrian.php?sts=cekdata").done(function( data ) {
		if(data == 0){
			setInterval(function(){
				$.get( "get_modal_panggil_antrian.php?sts=cekdata").done(function( data ) {
					if(data == 1){
						//alert(data);
						window.location.reload(true);
					}
				});
			}, 3000);
		}
	});
	
	$(".etiketoption").change(function(){
		var isi = $(this).val();

		if(isi == 'noindex'){
			$(".barcodebpjs-index").show();
			$(".barcodebpjs-rm").hide();
			$(".barcodebpjs-newrm").hide();
		}else if(isi == 'norm'){
			$(".barcodebpjs-index").hide();
			$(".barcodebpjs-rm").show();
			$(".barcodebpjs-newrm").hide();
		}else{
			$(".barcodebpjs-index").hide();
			$(".barcodebpjs-rm").hide();
			$(".barcodebpjs-newrm").show();	
		}
	});
	
	$(".labeloption").change(function(){
		var isi = $(this).val();
		if(isi == 'kartupasien'){
			$(".print_etiket").hide();
			$(".kartu_pasien").show();
		}else{
			$(".print_etiket").show();
			$(".kartu_pasien").hide();
			if(isi == 'labelpasien'){
				$("#labelpasien").show();
				$("#labelkk").hide();
				$("#labelmap").hide();
			}else if(isi == 'labelkk'){
				$("#labelpasien").hide();
				$("#labelkk").show();
				$("#labelmap").hide();
			}else{
				$("#labelpasien").hide();
				$("#labelkk").hide();
				$("#labelmap").show();	
			}
		}
	});
	
	$('.tindakanbpjs').autocomplete({
		serviceUrl: 'get_tindakan.php?asuransi=<?php echo $data['Asuransi'];?>&keyword=',
		onSelect: function (suggestion) {
			$(this).val(suggestion.value);
			$(this).parent().find(".idtindakanbpjs").val(suggestion.idtindakanbpjs);
			$(this).parent().find(".kodetindakanbpjs").val(suggestion.kodetindakanbpjs);
			$(this).parent().find(".namatindakanbpjs").val(suggestion.namatindakanbpjs);
			$(this).parent().find(".kelompoktindakanbpjs").val(suggestion.kelompoktindakanbpjs);
			$(this).parent().parent().parent().find(".tariftindakanbpjs").val(suggestion.tariftindakanbpjs);
		}
	});

	$(".btneditnotelp").click(function(){
		var isiawal = $(".editnotelp").html();
		$(".btneditnotelp").hide();
		$(".editnotelp").html('<input type="text" class="valnotelp" value="'+isiawal+'" size="25px"> <input type="button" value="Simpan" class="btn btn-round btn-sm btn-info savenotelp">');
		
		$(".savenotelp").click(function(){
			var notelp = $(this).parent().find(".valnotelp").val();
			var noindex = $(this).parent().parent().parent().find(".noindexreg").val();
			//alert(notelp+" -  "+noindex);
			$.post( "edit_notelp_pasien_jquery.php", { notelp: notelp,noindex: noindex}).done(function(data){
				//alert(data);
			});
			$(".editnotelp").html(notelp);
			$(".btneditnotelp").show();
		});
	});

	$(".btneditnotelpseluler").click(function(){
		var isiawalseluler = $(".editnotelpseluler").html();
		$(".btneditnotelpseluler").hide();
		$(".editnotelpseluler").html('<input type="text" class="valnotelpseluler" value="'+isiawalseluler+'" size="25px"> <input type="button" value="Simpan" class="btn btn-round btn-sm btn-info savenotelpseluler">');
		
		$(".savenotelpseluler").click(function(){
			var notelpseluler = $(this).parent().find(".valnotelpseluler").val();
			var idpasien = $(this).parent().parent().parent().find(".idpasienreg").val();
			// alert(notelpseluler+" -  "+idpasien);
			$.post( "edit_notelp_pribadi_pasien_jquery.php", { notelpseluler: notelpseluler,idpasien: idpasien}).done(function(data){
				//alert(data);
			});
			$(".editnotelpseluler").html(notelpseluler);
			$(".btneditnotelpseluler").show();
		});
	});



});
</script>

<div class="modaltampil"></div>

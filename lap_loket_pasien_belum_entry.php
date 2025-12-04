<?php
	include "otoritas.php";
	include "config/helper_pasienrj.php";
	$pel = $_GET['pelayanan'];
	$nama = $_GET['nama'];
	$status = $_GET['status'];
	$asalpasien = $_GET['asalpasien'];
	$tanpatgl = $_GET['tptgl'];
	$tahun = date('Y');
	$bulan = date('m');
?>

<div class="tableborderdiv">
<body onload="window.print()" onafterprint="document.location='index.php?page=poli&pelayanan=<?php echo $pel;?>&status=<?php echo $status;?>&tptgl=No'">
	<h3 class="judul noprint"><b>PASIEN BELUM DIENTRY</b></h3>
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN PASIEN BELUM DIENTRY</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?>
		</span><br/>
	</div>

	<div class="atastabel font11">
		<div style="float:left; width:35%; margin-bottom:10px;">	
			<table>
				<tr>
					<td style="padding:2px 4px;">Kelurahan/Desa</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kelurahan;?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Kecamatan</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kecamatan;?></td>
				</tr>
			</table>
		</div>	
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tgl & Jam Registrasi</th>
							<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.Index</th>
							<th width="20%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Pasien</th>
							<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L/P</th>
							<th width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Umur</th>
							<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pelayanan</th>
							<th width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jaminan</th>
							<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if($_GET['tgl'] == ''){
							$tgl = date('Y-m-d');
						}else{
							$tgl = $_GET['tgl'];
						}		

						$str_1 = "SELECT COUNT(NoRujukan)AS Jml FROM `tbrujukinternal` WHERE SUBSTRING(NoRujukan,1,11)='$kodepuskesmas' AND TanggalRujukan='$tgl' AND `PoliRujukan` = '$pel'";
						$query_str_1 = mysqli_query($koneksi, $str_1);
						$data_str_1 = mysqli_fetch_assoc($query_str_1);
				
						if($status != null){
							if($data_str_1['Jml'] >= 1){
								$status_str = " AND (a.StatusPelayanan = '$status' or b.StatusPemeriksaan = 'Rujuk')";
							}else{
								$status_str = " AND (a.StatusPelayanan = '$status')";
							}
						}else{
							if($data_str_1['Jml'] >= 1){
								$status_str = " AND (a.StatusPelayanan = 'Antri' or b.StatusPemeriksaan = 'Rujuk')";
							}else{
								$status_str = " AND (a.StatusPelayanan = 'Antri')";
							}
						}
						
						if($asalpasien == ''){
							$strasalpasien = '';
						}else{
							$strasalpasien = " AND a.AsalPasien = '$asalpasien' ";
						}
						
						if($tgl != null){
							$tgls = date('Y-m-d',strtotime($tgl));
							$tgl_str = " a.TanggalRegistrasi = '$tgls' AND ";
						}	
						
						if($nama != null AND $tgl != null){
							$tgl_str = " a.TanggalRegistrasi = '$tgls' AND ";
						// }else{
							// $tgl_str = " YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND ";
						}

						if($tanpatgl == 'Yes'){
							$tgl_str = " YEAR(a.TanggalRegistrasi) = '$tahun' AND ";
						}elseif($tanpatgl == 'No'){
							$tgl_str = " YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND ";
						}		
						
						if($nama != null){
							if($status != null){
								$nama_str = " AND a.NamaPasien like '%$nama%'".$status_str;
							}else{
								$nama_str = " AND a.NamaPasien like '%$nama%'";
							}
						}else{
							$nama_str = " ".$status_str;
						}	
						
						if($_GET['orderby'] == '' or $_GET['sort'] == ''){
							if($pel == "POLI LABORATORIUM"){	
								$orderbys = "order by a.TanggalRegistrasi, a.IdPasienrj ASC";
							}else{
								$orderbys = "order by a.TanggalRegistrasi, a.NoAntrianPoli ASC";
							}	
						}else{
							$orderbys = "order by ".$_GET['orderby']." ".$_GET['sort'];
						}						
						
						$str = "SELECT * FROM `$tbpasienrj` a LEFT JOIN `tbrujukinternal` b on a.NoRegistrasi = b.NoRujukan 
						WHERE ".$tgl_str."(a.PoliPertama='$pel' or b.PoliRujukan='$pel')".$nama_str.$strasalpasien." 
						GROUP BY a.NoRegistrasi";
						$str2 = $str." ".$orderbys;
						// echo $str2;
						// die();
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$noindex = $data['NoIndex'];

							if(strlen($noindex) == 24){
								$noindex2 = substr($data['NoIndex'],14);
							}else{
								$noindex2 = $data['NoIndex'];
							}
						?>
							<tr>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TanggalRegistrasi'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $noindex2;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;" class="namakk"><?php echo $data['NamaPasien'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['JenisKelamin'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['UmurTahun'];?> Th <?php echo $data['UmurBulan'];?> Bl  <?php echo $data['UmurHari'];?> Hr</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['PoliPertama'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['Asuransi'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;">
									<?php 
										if($data['PoliRujukan'] != ''){
											echo $data['StatusPemeriksaan'];
										}else{
											echo $data['StatusPelayanan'];
										}
									?>
								</td>	
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>	
</div>
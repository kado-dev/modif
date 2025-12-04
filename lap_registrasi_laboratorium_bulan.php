<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>LAPORAN BULANAN LAB</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_registrasi_laboratorium_bulan"/>
						<div class="col-sm-2">
							<select name="bulan" class="form-control">
								<option value="01" <?php if($_GET['bulan'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulan'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulan'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulan'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulan'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulan'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulan'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulan'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulan'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulan'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulan'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulan'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-sm-1" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_laboratorium_bulan" class="btn btn-success btn-white"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-primary btn-white"><span class="fa fa-print noprint"></span></a>
							<a href="lap_registrasi_laboratorium_bulan_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&kelurahan=<?php echo $_GET['kelurahan'];?>" class="btn btn-info btn-white">Excel</a>
						</div>
					</form>
				</div>
			</div>	
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$kelurahan = $_GET['kelurahan'];

	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "UPT. PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN BULANAN LABORATORIUM</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></span><br/>
	</div>

	<div class="atastabel font11">
		<div style="float:left; width:65%; margin-bottom:10px;">
			<table style="font-size:10px; width:300px;">
				<tr>
					<td style="padding:2px 4px;">Kode Puskesmas</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kodepuskesmas;?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Puskesmas</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $namapuskesmas;?></td>
				</tr>
			</table><p/>
		</div>
		<div style="float:right; width:35%; margin-bottom:10px;">	
			<table style="font-size:10px; width:300px;">
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
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr>
							<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="3" style="text-align:center;width:15%;vertical-align:middle; border:1px solid #000; padding:3px;">Jenis Pemeriksaan</th>
							<th colspan="18" style="text-align:center;width:15%;vertical-align:middle; border:1px solid #000; padding:3px;">Golongan Umur</th>
							<th rowspan="3" colspan="2" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">Total</th>
							<th rowspan="3" style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">Total Kunj</th>
						</tr>
						<tr>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">1-7Hr</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">8-30Hr</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">1Bl-1Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">1-4Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">5-14Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">15-44Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">45-54Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">55-64Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">>65Th</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--1-7Hr-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--8-30Hr-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--1-4Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--5-14Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--15-44Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--45-54Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--55-64Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--65Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Jml-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th><!--Jml-->
						</tr>
					</thead>
					
					<tbody style="font-size:10px;">
						<?php	
						$umur17hrL_total = 0;
						$umur17hrP_total = 0;
						$umur830hrL_total = 0;
						$umur830hrP_total = 0;
						$umur12blnL_total = 0;
						$umur12blnP_total = 0;
						$umur14L_total = 0;
						$umur14P_total = 0;
						$umur59L_total = 0;
						$umur59P_total = 0;
						$umur514L_total = 0;
						$umur514P_total = 0;
						$umur1519L_total = 0;
						$umur1519P_total = 0;
						$umur1544L_total = 0;
						$umur1544P_total = 0;
						$umur4554L_total = 0;
						$umur4554P_total = 0;
						$umur5564L_total = 0;
						$umur5564P_total = 0;
						$umur6069L_total = 0;
						$umur6069P_total = 0;
						$umur65100L_total = 0;
						$umur65100P_total = 0;
						$total_l_total = 0;
						$total_p_total = 0;
						$total_total = 0;
						
						
						
						
						$kategoris = "";
						$kategoris2 = "";
						$str = "SELECT * FROM `tblaboraorium`";
						$str2 = $str."order by `No`";
											
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){								
							$kelompoktindakan = $data['KelompokTindakan'];							
							$tindakan = $data['Tindakan'];			
							$jenistindakan = $data['JenisTindakan'];			
							if($jenistindakan == "-"){
								$jns = " ";
							}else{	
								$jns = "AND `JenisTindakan`='$jenistindakan'";
							}								
							
							$umur17hrL = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='L' AND `UmurTahun`='0' AND `UmurHari` BETWEEN '1' AND '7' ND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi"));
							$umur17hrP = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='P' AND `UmurTahun`='0' AND `UmurHari` BETWEEN '1' AND '7' AND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi"));
							$umur830hrL = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='L' AND `UmurTahun`='0' AND `UmurHari` BETWEEN '8' AND '30' AND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi"));
							$umur830hrP = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='P' AND `UmurTahun`='0' AND `UmurHari` BETWEEN '8' AND '30' AND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi"));
							$umur112L = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='L' AND `UmurTahun`='0' AND `UmurBulan` Between '1' AND '12' AND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi"));
							$umur112P = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='P' AND `UmurTahun`='0' AND `UmurBulan` Between '1' AND '12' AND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi"));
							$umur14L = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='L' AND `UmurTahun` Between '1' AND '4' AND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi"));
							$umur14P = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='P' AND `UmurTahun` Between '1' AND '4' AND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi"));
							$umur514L = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='L' AND `UmurTahun` Between '5' AND '14' AND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi"));
							$umur514P = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='P' AND `UmurTahun` Between '5' AND '14' AND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi"));
							$umur1544L = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='L' AND `UmurTahun` Between '15' AND '44' AND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi"));
							// echo "SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='P' AND `UmurTahun` Between '15' AND '44' AND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi";
							$umur1544P = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='P' AND `UmurTahun` Between '15' AND '44' AND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi"));
							$umur4554L = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='L' AND `UmurTahun` Between '45' AND '54' AND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi"));
							$umur4554P = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='P' AND `UmurTahun` Between '45' AND '54' AND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi"));
							$umur5564L = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='L' AND `UmurTahun` Between '55' AND '64' AND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi"));
							$umur5564P = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='P' AND `UmurTahun` Between '55' AND '64' AND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi"));
							$umur65100L = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='L' AND `UmurTahun` Between '65' AND '100' AND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi"));
							$umur65100P = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `tbtindakanpasiendetail` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `JenisKelamin`='P' AND `UmurTahun` Between '65' AND '100' AND `KelompokTindakan`='$kelompoktindakan'".$jns." GROUP BY NoRegistrasi"));
							$jumlah_l = $umur17hrL + $umur830hrL + $umur830hrL + $umur14L + $umur514L + $umur1544L + 
										$umur4554L +  $umur5564L + $umur65100L;
							$jumlah_p = $umur17hrP + $umur830hrP + $umur830hrP + $umur14P + $umur514P + $umur1544P + 
										$umur4554P + $umur5564P + $umur65100P;
							$total = $jumlah_l + $jumlah_p;
						
							if($kategoris2 != $data['Judul']){
								$kategoris2 = $data['Judul'];
								$no = $no + 1;
							}	
							
							//cek Judul,jika lebih dari satu di echo
							$cekkate = mysqli_num_rows(mysqli_query($koneksi,"SELECT Judul FROM tblaboraorium WHERE Judul = '$data[Judul]'"));
							if($cekkate > 1){
								if($kategoris != $data['Judul']){
									$kategoris = $data['Judul'];
								echo "<tr><td style='text-align:right'>".$no."</td><td colspan = '21'>".$data['Judul']."<td/></tr>";
								}
								$nod = "";
							}else{
								$nod = $no;
							}
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $nod;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['Tindakan'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur17hrL;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur17hrP;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur830hrL;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur830hrP;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur112L;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur112P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14L;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur514L;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur514P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1544L;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1544P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554L;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5564L;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5564P;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur65100L;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur65100P;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $jumlah_l;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $jumlah_p;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total;?></td>
							</tr>
						<?php
						}
						?>
							
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="bawahtabel">
		<table width="100%">
			<tr>
				<td width="5%"></td>
				<td style="text-align:center;">
					MENGETAHUI<br>
					<?php echo "KEPALA UPT ".$datapuskesmas['NamaPuskesmas'];?>
					<br><br><br><br>
					<u><?php echo $datapuskesmas['KepalaPuskesmas'];?></u><br>
					<?php echo "NIP.".$datapuskesmas['Nip'];?>
				</td>
				<td width="10%"></td>
				<td style="text-align:center;">
					<?php echo $kota.", ___ ".strtoupper(nama_bulan($bulan))." ".$tahun;?><br>
					PELAKSANA PROGRAM
					<br><br><br><br>
					(..........................................................)
				</td>
			</tr>
		</table>
	</div>
	<?php
	}
	?>
</div>
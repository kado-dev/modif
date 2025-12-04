<?php
	session_start();
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DAFTAR ONLINE-OFFLINE</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_antrian_daftar_online_offline"/>						
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_antrian_daftar_online_offline" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_antrian_daftar_online_offline_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&asalpasien=<?php echo $_GET['asalpasien'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
	$tahun = $_GET['tahun'];
	$asalpasien = $_GET['asalpasien'];
	if(isset($tahun)){
	?>
	<div class="table-responsive printini" style="overflow: hidden;">
		<div class="row">
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table-judul-laporan" width="100%">
						<thead>
							<tr style="border:1px solid #000;">
								<th width="12%" rowspan="3">Nama Puskesmas</th>
								<th width="10%" colspan="5">Jumlah Kunjungan Pasien ke Puskesmas</th>
								<th width="10%" rowspan="3">Rata-rata Waktu Tunggu Layanan Pendaftaran di Puskesmas</th>
							</tr>
							<tr style="border:1px solid #000;">
								<th width="5%" colspan="2">Daftar Offline</th>
								<th width="5%" colspan="2">Daftar Online</th>
								<th width="5%" rowspan="3">Jumlah Ttl Kunjungan</th>
							</tr>
                            <tr style="border:1px solid #000;">
								<th width="5%" rowspan="3">Umum</th>
								<th width="5%" rowspan="3">Bpjs</th>
                                <th width="5%" rowspan="3">Umum</th>
								<th width="5%" rowspan="3">Bpjs</th>
							</tr>
						</thead>
						<tbody>
							<?php
                                $dt_offline_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(Asuransi,1,4) = 'UMUM'"));
                                $dt_offline_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(Asuransi,1,4) = 'BPJS'"));
                                $dt_onnline_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasien) AS Jml FROM `$tbpasienonline` WHERE YEAR(WaktuDaftar) = '$tahun' AND SUBSTRING(Asuransi,1,4) = 'UMUM'"));
                                $dt_onnline_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasien) AS Jml FROM `$tbpasienonline` WHERE YEAR(WaktuDaftar) = '$tahun' AND SUBSTRING(Asuransi,1,4) = 'BPJS'"));
                            	$ttl_kunjungan = $dt_offline_umum['Jml'] + $dt_offline_bpjs['Jml'] + $dt_onnline_umum['Jml'] + $dt_onnline_bpjs['Jml']; 							
							?>
                            <tr style="border:1px solid #000;">
                                <td align="center"><?php echo $namapuskesmas;?></td>
                                <td align="center"><?php echo $dt_offline_umum['Jml'];?></td>
                                <td align="center"><?php echo $dt_offline_bpjs['Jml'];?></td>
                                <td align="center"><?php echo $dt_onnline_umum['Jml'];?></td>
                                <td align="center"><?php echo $dt_onnline_bpjs['Jml'];?></td>
                                <td align="center"><?php echo $ttl_kunjungan;?></td>
                                <td align="center">5 - 10 Menit</td>
                            </tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>	
	<div class="row noprint">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<p>
					<b>Perhatikan :</b><br/>
					Print laporan silahkan klik tombol Export
				</p>
			</div>
		</div>
	</div>
	
	<?php
	}
	?>
</div>
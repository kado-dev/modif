<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	include "config/helper_yankes.php";
	$token_yankes = $_SESSION['token_yankes'];
	$bulan = ($_GET['bulan'] == null) ? date('m') : $_GET['bulan'];
	$tahun = ($_GET['tahun'] == null) ? date('Y') : $_GET['tahun'];


?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12">
			<?php
				$getapi = get_data_kunjungan($token_yankes,$bulan,$tahun);
				$data_yankes = json_decode($getapi,true);
				
			?>
			<div class="formbg">
				<h3>TABEL 05 <button type="submit" class="btn btn-sm btn-success pull-right btnmodalii"> TAMBAH </button></h3>
				<hr>
				<div class = "row">
					<div class = "col-sm-12">
						<table class="table-judul-laporan">
							<thead>
								<tr>
									<th rowspan="3">NO.</th>
									<th rowspan="3">DESA / KELURAHAN</th>
									<th colspan="6">JUMLAH KUNJUNGAN</th>
									<th colspan="3">KUNJUNGAN GANGGUAN JIWA</th>
								</tr>
								<tr>
									<th colspan="3">RAWAT JALAN</th>
									<th colspan="3">RAWAT INAP</th>
									<th colspan="3">JUMLAH</th>
								</tr>
								<tr>
									<th>L</th>
									<th>P</th>
									<th>L+P</th>
									<th>L</th>
									<th>P</th>
									<th>L+P</th>
									<th>L</th>
									<th>P</th>
									<th>L+P</th>
								</tr>
							</thead>
							<tbody>
								<?php
								// $no = 0;
								// 	$query = mysqli_query($koneksi,"SELECT * FROM `tbkelurahan` ORDER BY `Kelurahan` ASC");
								// 	while($dt = mysqli_fetch_assoc($query)){
								// $no++;

								// $getdata = mysqli_query($koneksi,"SELECT * FROM `eprofil_tb01` WHERE id_datadasar = '$dt[id_datadasar]'");
								// if(mysqli_num_rows($getdata) > 0){
								// 	$dteprofil = mysqli_fetch_assoc($getdata);
								// 	$jml_kunjungan_rj_laki = $dteprofil['jml_kunjungan_rj_laki'];
								// 	$jml_kunjungan_rj_perempuan = $dteprofil['jml_kunjungan_rj_perempuan'];
								// 	$jml_kunjungan_rj_laki_perempuan = $dteprofil['jml_kunjungan_rj_laki_perempuan'];
								// 	$jml_kunjungan_ri_laki = $dteprofil['jml_kunjungan_ri_laki'];
								// 	$jml_kunjungan_ri_perempuan = $dteprofil['jml_kunjungan_ri_perempuan'];
								// 	$jml_kunjungan_ri_laki_perempuan = $dteprofil['jml_kunjungan_ri_laki_perempuan'];
								// 	$kunjungan_gangguan_jiwa_jml_laki = $dteprofil['kunjungan_gangguan_jiwa_jml_laki'];
								// 	$kunjungan_gangguan_jiwa_jml_perempuan = $dteprofil['kunjungan_gangguan_jiwa_jml_perempuan'];
								// 	$kunjungan_gangguan_jiwa_jml_laki_perempuan = $dteprofil['kunjungan_gangguan_jiwa_jml_laki_perempuan'];
								// }else{
								// 	$jml_kunjungan_rj_laki = 0;
								// 	$jml_kunjungan_rj_perempuan = 0;
								// 	$jml_kunjungan_rj_laki_perempuan = 0;
								// 	$jml_kunjungan_ri_laki = 0;
								// 	$jml_kunjungan_ri_perempuan = 0;
								// 	$jml_kunjungan_ri_laki_perempuan = 0;
								// 	$kunjungan_gangguan_jiwa_jml_laki = 0;
								// 	$kunjungan_gangguan_jiwa_jml_perempuan = 0;
								// 	$kunjungan_gangguan_jiwa_jml_laki_perempuan = 0;
								// }
								if($data_yankes['meta']['message'] == 'Success'){
								$no = 0;
								foreach ($data_yankes['data'] as $key) {
								$no++;

									$id_datadasar = $key['id_datadasar'];
									$Kelurahan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbkelurahan` WHERE id_datadasar = '$id_datadasar'"))['Kelurahan'];
									$jml_kunjungan_rj_laki = $key['jml_kunjungan_rj_laki'];
									$jml_kunjungan_rj_perempuan = $key['jml_kunjungan_rj_perempuan'];
									$jml_kunjungan_rj_laki_perempuan = $key['jml_kunjungan_rj_laki_perempuan'];
									$jml_kunjungan_ri_laki = $key['jml_kunjungan_ri_laki'];
									$jml_kunjungan_ri_perempuan = $key['jml_kunjungan_ri_perempuan'];
									$jml_kunjungan_ri_laki_perempuan = $key['jml_kunjungan_ri_laki_perempuan'];
									$kunjungan_gangguan_jiwa_jml_laki = $key['kunjungan_gangguan_jiwa_jml_laki'];
									$kunjungan_gangguan_jiwa_jml_perempuan = $key['kunjungan_gangguan_jiwa_jml_perempuan'];
									$kunjungan_gangguan_jiwa_jml_laki_perempuan = $key['kunjungan_gangguan_jiwa_jml_laki_perempuan'];
								?>
									<tr>
										<td><?php echo $no;?></td>
										<td><?php echo $Kelurahan;?></td>
										<td><?php echo $jml_kunjungan_rj_laki;?></td>
										<td><?php echo $jml_kunjungan_rj_perempuan;?></td>
										<td><?php echo $jml_kunjungan_rj_laki_perempuan;?></td>
										<td><?php echo $jml_kunjungan_ri_laki;?></td>
										<td><?php echo $jml_kunjungan_ri_perempuan;?></td>
										<td><?php echo $jml_kunjungan_ri_laki_perempuan;?></td>
										<td><?php echo $kunjungan_gangguan_jiwa_jml_laki;?></td>
										<td><?php echo $kunjungan_gangguan_jiwa_jml_perempuan;?></td>
										<td><?php echo $kunjungan_gangguan_jiwa_jml_laki_perempuan;?></td>
									</tr>
								<?php
									}
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
	$(".btnmodalii").click(function(){
		$("#modalii").modal('show');
	});
</script>
<div class="modal fade" id="modalii" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel"> Tambah Data</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" action="index.php?page=eprofil_tabel_01_proses" method="post" role="form">
						<table class="table-judul">
							<tr>
								<td class="col-sm-3">Tahun</td>
								<td class="col-sm-9">									
									<select name="tahun" class="form-control">
										<?php
											for($tahun = 2022 ; $tahun <= date('Y'); $tahun++){
											?>
											<option value="<?php echo $tahun;?>" <?php if(date('Y') == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
										<?php }?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Bulan</td>
								<td class="col-sm-9">
									<select name="bulan" class="form-control">
										<option value="01" <?php if(date('m') == '01'){echo "SELECTED";}?>>Januari</option>
										<option value="02" <?php if(date('m') == '02'){echo "SELECTED";}?>>Februari</option>
										<option value="03" <?php if(date('m') == '03'){echo "SELECTED";}?>>Maret</option>
										<option value="04" <?php if(date('m') == '04'){echo "SELECTED";}?>>April</option>
										<option value="05" <?php if(date('m') == '05'){echo "SELECTED";}?>>Mei</option>
										<option value="06" <?php if(date('m') == '06'){echo "SELECTED";}?>>Juni</option>
										<option value="07" <?php if(date('m') == '07'){echo "SELECTED";}?>>Juli</option>
										<option value="08" <?php if(date('m') == '08'){echo "SELECTED";}?>>Agustus</option>
										<option value="09" <?php if(date('m') == '09'){echo "SELECTED";}?>>September</option>
										<option value="10" <?php if(date('m') == '10'){echo "SELECTED";}?>>Oktober</option>
										<option value="11" <?php if(date('m') == '11'){echo "SELECTED";}?>>November</option>
										<option value="12" <?php if(date('m') == '12'){echo "SELECTED";}?>>Desember</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Kelurahan / Desa</td>
								<td class="col-sm-9">
									<select name="kelurahan" class="form-control">
										<?php
											$query = mysqli_query($koneksi,"SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$kodepuskesmas' ORDER by Kelurahan");
											while($dtk = mysqli_fetch_assoc($query)){
												echo "<option value='$dtk[id_datadasar]'>$dtk[Kelurahan]</option>";
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Jml. Kunjungan RJ Laki</td>
								<td class="col-sm-9"><input type="text" name="jml_kunjungan_rj_laki" class="form-control namacls" style="text-transform: uppercase;" maxlength="50"></td>
							</tr>
							<tr>
								<td class="col-sm-3">Jml. Kunjungan RJ Perempuan</td>
								<td class="col-sm-9"><input type="text" name="jml_kunjungan_rj_perempuan" class="form-control namacls" style="text-transform: uppercase;" maxlength="50"></td>
							</tr>
							<tr>
								<td class="col-sm-3">Jml. Kunjungan RI Laki</td>
								<td class="col-sm-9"><input type="text" name="jml_kunjungan_ri_laki" class="form-control namacls" style="text-transform: uppercase;" maxlength="50"></td>
							</tr>
							<tr>
								<td class="col-sm-3">Jml. Kunjungan RI Perempuan</td>
								<td class="col-sm-9"><input type="text" name="jml_kunjungan_ri_perempuan" class="form-control namacls" style="text-transform: uppercase;" maxlength="50"></td>
							</tr>
							<tr>
								<td class="col-sm-3">Jml. Gangguan Jiwa Laki</td>
								<td class="col-sm-9"><input type="text" name="kunjungan_gangguan_jiwa_jml_laki" class="form-control namacls" style="text-transform: uppercase;" maxlength="50"></td>
							</tr>
							<tr>
								<td class="col-sm-3">Jml. Gangguan Jiwa Perempuan</td>
								<td class="col-sm-9"><input type="text" name="kunjungan_gangguan_jiwa_jml_perempuan" class="form-control namacls" style="text-transform: uppercase;" maxlength="50"></td>
							</tr>
						</table><hr>
						<button type="submit" class="btnsimpan">SIMPAN</button>						
					</form>
				</div>
			</div>
		</div>
	</div>
				

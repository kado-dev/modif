<?php
	include "config/helper_pasienrj.php";
	include "config/helper_report.php";
	$pel = $_GET['pelayanan'];
	$tanggal = date('Y-m-d');
	
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>PASIEN GAGAL BRIDGING PEMERIKSAAN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="poli_antri_bridging_bulan_pemeriksaan"/>
						<input type="hidden" name="pelayanan" value="<?php echo $pel;?>"/>
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
						<div class="col-sm-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-4">
							<input type="text" name="nama" class="form-control" value="<?php echo $_GET['nama'];?>" placeholder = "Masukan Nama Pasien">
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=poli_antri_bridging_bulan_pemeriksaan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="3%">NO.</th>
							<th width="12%">TGL.REGISTRASI</th>
							<th width="23%">NAMA PASIEN</th>
							<th width="5%">L/P</th>
							<th width="10%">PELAYANAN</th>
							<th width="10%">NO.JAMINAN</th>
							<th width="10%">NO.URUT</th>
							<th width="10%">BRIDGING</th>
							<th width="20%">KETERANGAN</th>
							<th width="5%">OPSI</th>
						</tr>
					</thead>
					<tbody font="8">
					<?php
					$jumlah_perpage = 50;
					
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$nama = $_GET['nama'];	
					$tanpatgl = $_GET['tptgl'];
					$bulan = $_GET['bulan'];
					$tahun = $_GET['tahun'];
					

					if($nama != null){
						$nama_str = " AND NamaPasien like '%$nama%'";
					}else{
						$nama_str = "";
					}	
					
					
					$str = "SELECT * FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND `Asuransi` like '%BPJS%' AND `StatusPasien` <> '2' AND `StatusPelayanan`='Sudah' AND `StatusPulang`='3' AND (LENGTH(`NoKunjunganBpjs`) != 19)".$nama_str;
							
					$str2 = $str." order by TanggalRegistrasi DESC LIMIT $mulai,$jumlah_perpage";
					// echo $str2;
					// die();
					
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;					
						$noindex = $data['NoIndex'];
						$idpasienrj = $data['IdPasienrj'];
					?>
						<tr>
							<td style="text-align:right;"><?php echo $no;?></td>
							<td style="text-align:center;"><?php echo $data['TanggalRegistrasi'];?></td>
							<td style="text-align:left;"class="namakk">
								<?php echo $data['NamaPasien'];?>
								<span class="badge badge-success" style='font-style: italic; padding: 8px;'><?php echo substr($noindex,-10);?></span><br/>
							</td>
							<td style="text-align:center;"><?php echo $data['JenisKelamin'];?></td>					
							<td style="text-align:center;"><?php echo $data['PoliPertama'];?></td>
							<td style="text-align:center;"><?php echo $data['nokartu'];?></td>
							<td style="text-align:center;"><?php echo $data['NoUrutBpjs'];?></td>
							<td style="text-align:center;">
								<?php 
									if(strlen($data['NoKunjunganBpjs']) == 3 OR $data['NoKunjunganBpjs'] == "" OR $data['NoKunjunganBpjs'] == 0){
										echo "Gagal";
									}else{
										echo "Berhasil";
									}
								?>
							</td>
							<td style="text-align:center;">
								<?php
									// tblogs_api
									$dtlogsapi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `LogPcarePemeriksaan` FROM tblogs_api WHERE `IdPasienrj`='$idpasienrj' AND `Puskesmas`='$namapuskesmas'"));
									echo $dtlogsapi['LogPcarePemeriksaan'];
								?>
							</td>
							<td align="center">
							<?php
							if($data['StatusPelayanan'] == 'Sudah'){
							?>
								<a href="kirim_ulang_pemeriksaan_bpjs.php?idrj=<?php echo $idpasienrj;?>&hal=poli_antri_bridging_bulan_pemeriksaan&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-sm btn-info">Kirim Ulang</a>
								<?php
								if($data['StatusPulang'] == 'Rujuk Lanjut'){
								?>
								<a href="?page=cetak_rujukan_bpjs&no=<?php echo $data['NoRegistrasi'];?>&pelayanan=<?php echo $data['PoliPertama'];?>" class="btn btn-round btn-sm btn-success">Cetak</a>
							<?php 
								}
							}else{ 
							?>	
								<a href="?page=poli_periksa&no=<?php echo $data['NoRegistrasi'];?>&pelayanan=<?php echo $data['PoliPertama'];?>&status=<?php echo $data['StatusPelayanan'];?>&tptgl=<?php echo $data['TanggalRegistrasi'];?>&sts_resep=bulan" class="btn btn-round btn-sm btn-primary"></i>Periksa</a>
							<?php 
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
	<hr class="noprint">
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
						echo "<li><a href='?page=poli_antri_bridging_bulan_pemeriksaan&pelayanan=$pel&bulan=$bulan&tahun=$tahun&nama=$nama&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	// }
	?>


<a href="kirim_ulang_pemeriksaan_semua_bpjs.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&hal=poli_antri_bridging_bulan_pemeriksaan" class="btn btn-round btn-block btn-md btn-info">Kirim Ulang Semua</a>
</div>
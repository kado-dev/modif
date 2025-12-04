<?php
	session_start();
	include"config/koneksi.php";
	include"config/helper_pasienrj.php";
	$tanggal = date('Y-m-d');
?>
<style>
.printheader{
	margin-top:-30px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
	width:100%;
}
.printheader h4{
	font-size:12px;
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.printheader p{
	font-size:10px;
}
.printbody{
	margin-left:0px;
	margin-right:-2px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.atastabel{
	display:none;
	margin-top:10px;
}
.bawahtabel{
	margin-top:20px;
	margin-bottom:10px;
	margin-left:50px;
	display:none;
}
.prints{
	display:hidden;
	visibility:hidden;
}
@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
		visibility:hidden;
	}
	.prints{
		display:block;
		visibility:visible;
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
	.tables{
		border:0px dotted #000;
		border-collapse:collapse;
		width:100%;
		margin-bottom:10px;
		font-size:14px;
	}
	.tables tr{
		border:0px dotted #000;
	}
	.tables td{
		padding:5px 9px;
	}
}
.rotate{
	-ms-transform: rotate(270deg); /* IE 9 */
    -webkit-transform: rotate(270deg); /* Safari */
    transform: rotate(0deg);
}
</style>

<div class="modal fade noprint" id="Modalobat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel"><b>RESEP OBAT</b></h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<form class="form-horizontal" action="apotik_update_status.php" method="post" role="form">
				<input type="hidden" name="status_user" value="dokter">
				<div class="modal-body">
					<?php
					include "config/koneksi.php";				
					$id = $_POST['no'];
					$pelayanan = $_POST['ply'];

					$query2 = mysqli_query($koneksi,"SELECT * FROM `$tbresep` WHERE `NoResep`='$id' AND `Pelayanan`='$pelayanan'");
					$data_resep = mysqli_fetch_assoc($query2);
					
					// tbdiagnosapasien
					$qrdata_kd_diagnosa = mysqli_query($koneksi, "SELECT * FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$data_resep[NoResep]'");
					
					// pasien
					if (strlen($data_resep['NoIndex']) == 24){
						$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `$tbpasien` WHERE `NoIndex` = '$data_resep[NoIndex]'"));
						$noindex = $dt_pasien['NoIndex'];
					}else{
						$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `$tbpasien` WHERE `NoAsuransi` = '$data_resep[NoIndex]'"));
						$noindex = $dt_pasien['NoIndex'];
					}
					
					// tbkk
					$dt_kk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Alamat FROM `$tbkk` WHERE NoIndex='$noindex'"));
					if($dt_kk['Alamat'] != ''){
						$alamat_kk = $dt_kk['Alamat'];
					}else{
						$alamat_kk = "Alamat Belum di Inputkan";
					}				
					
					while($data_kd_diagnosa = mysqli_fetch_assoc($qrdata_kd_diagnosa)){
						$kode_diagnosa[] = $data_kd_diagnosa['KodeDiagnosa'];
						$data_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_kd_diagnosa[KodeDiagnosa]'"));
						$nama_diagnosa[] = $data_diagnosa['Diagnosa'];
					}
					
					?>
					<div class="row">
						<div class="col-lg-12">		
							<table class="table-judul" width="100%">
								<tr>	
									<td width="13%">Tanggal</td>
									<td width="2%">:</td>
									<td width="35%"><?php echo $data_resep['TanggalResep'];?></td>
									<td width="13%">Pelayanan</td>
									<td width="2%">:</td>
									<td width="35%"><?php echo $data_resep['Pelayanan'];?></td>
								</tr>
								<tr>	
									<td>No.Resep</td>
									<td>:</td>
									<td><?php echo substr($data_resep['NoResep'],-10);?></td>
									<td>Cara Bayar</td>
									<td>:</td>
									<td><?php echo $data_resep['StatusBayar'];?></td>
								</tr>
								<tr>	
									<td>Nama Pasien</td>
									<td>:</td>
									<td><?php echo $data_resep['NamaPasien'];?></td>
									<td>Kd.Diagnosa</td>
									<td>:</td>
									<td><?php if($kode_diagnosa != null){echo implode($kode_diagnosa,", ");}else{echo "-";}?></td>
								</tr>
								<tr>	
									<td>Umur</td>
									<td>:</td>
									<td><?php echo $data_resep['UmurTahun']." thn ".$data_resep['UmurBulan']." Bln";?></td>
									<td>Diagnosa</td>
									<td>:</td>
									<td><?php if($nama_diagnosa != null){echo implode($nama_diagnosa,", ");}else{echo "-";}?></td>
								</tr>
								<tr>	
									<td>Alamat</td>
									<td>:</td>
									<td><?php echo $alamat_kk;?></td>
								</tr>
							</table>
						</div>
						
						<!--tbresep-->
						<div class="col-lg-12 mt-4">
							<table class="table-judul">
								<thead>
									<tr>
										<th width="10%">KODE</th>
										<th width="55%">NAMA BARANG</th>
										<th width="10%">JML</th>
										<th width="10%">SIGNA</th>
										<th width="15%">ANJURAN</th>
									</tr>
								</thead>
								<tbody>								
									<?php
										$qresep = mysqli_query($koneksi, "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$id'");						
										while($dtresep = mysqli_fetch_assoc($qresep)){
											$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbgudangpkmstok` WHERE `KodeBarang`='$dtresep[KodeBarang]'"));
											$no = $no + 1;
									?>
									<tr>
										<td align="center"><?php echo $dtresep['KodeBarang'];?></td>
										<td align="left"><?php echo $dtobat['NamaBarang'];?></td>
										<td align="center"><?php echo $dtresep['jumlahobat'];?></td>
										<td align="center"><?php echo $dtresep['signa1'];?> x <?php echo $dtresep['signa2'];?></td>
										<td align="left"><?php echo $dtresep['AnjuranResep'];?></td>
										<!--<td align="center"><a href="index.php?page=etiket&id=<?php //echo $data_resep['NoResep'];?>&kd=<?php //echo $dtresep['KodeBarang'];?>"><i class="ace-icon fa fa-print bigger-130"></i></a></td>-->
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div><br/>
						
						<!--<div class="col-lg-12">
							<?php $pio = explode(',',$data_resep['Pio']);?>
							<table>
								<tr><b>Pelayanan Informasi Obat (PIO), yang diberikan :<b></tr>
								<tr>
									<td width="40%"><input type="checkbox" name="jenis_pio[]" value="Nama Obat" <?php if (in_array("Nama Obat", $pio)) {echo "checked";}?>> Nama Obat</td>
									<td width="40%"><label><input type="checkbox" name="jenis_pio[]" value="Sediaan" <?php if (in_array("Sediaan", $pio)) {echo "checked";}?>> Sediaan</label></td>
								</tr>
								<tr>
									<td><label><input type="checkbox" name="jenis_pio[]" value="Dosis" <?php if (in_array("Dosis", $pio)) {echo "checked";}?>> Dosis</label></td>
									<td><label><input type="checkbox" name="jenis_pio[]" value="Cara Pakai" <?php if (in_array("Cara Pakai", $pio)) {echo "checked";}?>> Cara Pakai</label></td>
								</tr>
								<tr>
									<td><label><input type="checkbox" name="jenis_pio[]" value="Penyimpanan" <?php if (in_array("Penyimpanan", $pio)) {echo "checked";}?>> Penyimpanan</label></td>
									<td><label><input type="checkbox" name="jenis_pio[]" value="Indikasi" <?php if (in_array("Indikasi", $pio)) {echo "checked";}?>> Indikasi</label></td>
								</tr>
								<tr>
									<td><label><input type="checkbox" name="jenis_pio[]" value="Kontra Indikasi" <?php if (in_array("Kontra Indikasi", $pio)) {echo "checked";}?>> Kontra Indikasi</label></td>
									<td><label><input type="checkbox" name="jenis_pio[]" value="Stabilitas" <?php if (in_array("Stabilitas", $pio)) {echo "checked";}?>> Stabilitas</label></td>	
								</tr>
								<tr>
									<td><label><input type="checkbox" name="jenis_pio[]" value="Efek Samping" <?php if (in_array("Efek Samping", $pio)) {echo "checked";}?>> Efek Samping</label></td>		
									<td><label><input type="checkbox" name="jenis_pio[]" value="Interaksi" <?php if (in_array("Interaksi", $pio)) {echo "checked";}?>> Interaksi</label></td>
								</tr>
								
							</table>
						</div>-->
					</div><hr/>
					<div class="row">
						<div class = "col-sm-12">
							<input type="hidden" name="id" value="<?php echo $data_resep['NoResep'];?>">
							<input type="hidden" name="ply" value="<?php echo $data_resep['Pelayanan'];?>">
							<button type="submit" value="submit"class="btn btn-round btn-success btnsimpan">CETAK</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
	
<div class="rotates">	
	<div class="printheader prints">
	<?php
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
	$kota1 = $datapuskesmas['Kota'];
	$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` WHERE `Kota` = '$kota1'"));
	?>
		<?php 
		if($kdpuskesmas == 'semua'){
		?>
			<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
			<h4 style="margin:5px;"><b><?php echo $namapuskesmas;?></b></h4>
			<p style="margin:5px;"><?php echo $alamat;?></p>
		<?php
		}else{
		?>
			<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$datapuskesmas['Kota'];?></b></h4>
			<h4 style="margin:5px;"><b><?php echo $datadinas['NamaDinkes'];?></b></h4>
			<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$datapuskesmas['NamaPuskesmas'];?></b></h4>
			<p style="margin:5px;"><?php echo $datapuskesmas['Alamat']?></p>
		<?php	
		}
		?>
		<hr style="margin:3px; border:1px solid #000">
		<h3 style="margin:15px 5px 0px 5px;"><b>RESEP OBAT</b></h3>
		<br/>
	</div>
	<div class="prints row">
		<div class="col-lg-12">
				
				<table class="tables">
					<tr>	
						<td class="col-sm-2">Tanggal</td>
						<td>:</td>
						<td class="col-sm-3"><?php echo $data_resep['TanggalResep'];?></td>
						
					</tr>
					<tr>	
						<td>No.Resep</td>
						<td>:</td>
						<td><?php echo $data_resep['NoResep'];?></td>
						
					</tr>
					
					<tr>	
						<td>Nama Pasien</td>
						<td>:</td>
						<td><?php echo $data_resep['NamaPasien'];?></td>
						
					</tr>
					<tr>	
						<td>Umur</td>
						<td>:</td>
						<td><?php echo $data_resep['UmurTahun']." thn ".$data_resep['UmurBulan']." Bln";?></td>
					</tr>
					<tr>	
						
						<td class="col-sm-2">Poli / Jaminan</td>
						<td>:</td>
						<td class="col-sm-3"><?php echo $data_resep['Pelayanan'];?> / <?php echo $data_resep['StatusBayar'];?></td>
					</tr>
					
					<tr>	
						
						<td>Kode Diagnosa</td>
						<td>:</td>
						<td><?php if($kode_diagnosa != null){echo implode($kode_diagnosa,", ");}else{echo "-";}?></td>
					</tr>
					<tr>	
						
						<td>Diagnosa</td>
						<td>:</td>
						<td><?php if($nama_diagnosa != null){echo implode($nama_diagnosa,", ");}else{echo "-";}?></td>
					</tr>
				</table>

				<hr style="border:0px dotted #000;margin:20px 0px;"/>
				
				<table class="tables" style="margin-bottom:20px;">
					<tr>
						<th class="col-sm-6">Kode / Nama Barang</th>
						<th>Jml</th>
						<th>Dosis</th>
					</tr>
					<?php
					$query = mysqli_query($koneksi,"SELECT * FROM `tbresepdetail` join `tbgfkstok` on tbresepdetail.Kodebarang = tbgfkstok.Kodebarang  WHERE tbresepdetail.NoResep='$id'");
					while($data = mysqli_fetch_assoc($query)){
					?>
					<tr>
						<td>
							<?php echo $data['KodeBarang'];?>
							<br/>
							<?php echo $data['NamaBarang'];?>
						</td>
						<td><?php echo $data['jumlahobat'];?></td>
						<td><?php echo $data['signa1'];?> x <?php echo $data['signa1'];?></td>
					</tr>
					<?php
					}
					?>
					<tr style="border-top:1px dotted #000;">
						<td colspan="3" style="text-align:center;font-size:12px"><i>"Semoga Lekas Sembuh"</i></td>
					</tr>
				</table>
		</div>
	</div>	
</div>	
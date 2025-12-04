<?php
	$idpasienrj = $_GET['id'];
	$datapdp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolipdp` WHERE `IdPasienrj` = '$idpasienrj'"));	
?>

<div class = "row">
	<div class="col-sm-12">
		<table class="table-judul" width="100%">
			<tr>
				<td class="col-sm-3">
					Anamnesa
					<?php if(substr($data['Asuransi'],0,4) == 'BPJS'){?>
						<span class="badge badge-success" style='padding: 6px; font-size: 14px;'>
							<img src='image/bpjsputih.png'/> 1 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-9"><textarea name="anamnesa" class="anamnesa form-control"><?php echo $datapdp['Anamnesa'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Sekarang</td>
				<td><textarea name="riwayatpenyakitsekarang" class="anamnesa form-control"><?php echo $datapdp['RiwayatPenyakitSekarang'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Terdahulu</td>
				<td><textarea name="riwayatpenyakitdulu" class="anamnesa form-control"><?php echo $datapdp['RiwayatPenyakitDulu'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Keluarga</td>
				<td><textarea name="riwayatpenyakitkeluarga" class="anamnesa form-control"><?php echo $datapdp['RiwayatPenyakitKeluarga'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Alergi Makanan</td>
				<td><textarea name="riwayatalergimakanan" class="anamnesa form-control"><?php echo $datapdp['RiwayatAlergiMakanan'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Alergi Obat</td>
				<td><textarea name="riwayatalergiobat" class="anamnesa form-control"><?php echo $datapdp['RiwayatAlergiObat'];?></textarea></td>
			</tr>
			<tr>
				<td>Anjuran</td>
				<td><input type="text" name ="anjuran" class="form-control" value="<?php echo $datapdp['Anjuran'];?>"></td>
			</tr>
			<tr>
				<td>Hasil Lab.</td>
				<td>
					<?php
					$str_gettbtindakandetail = mysqli_query($koneksi,"SELECT Keterangan FROM $tbtindakanpasien a join tbtindakan b on a.IdTindakan = b.IdTindakan where a.NoRegistrasi = '$noregistrasi'");
					if(mysqli_num_rows($str_gettbtindakandetail) > 0){
						while($dt_lab = mysqli_fetch_assoc($str_gettbtindakandetail)){
							$hasilsx []= $dt_lab['Keterangan'];
						}
						$pem_lab = " ".implode(", ",$hasilsx);
					}else{
						$pem_lab = "";
					}
					?>
					<input type="text" name ="pemeriksaanpenunjanglab" class="form-control" value="<?php echo $datapdp['PemeriksaanHasilLab']."".$pem_lab;?>">
				</td>
			</tr>
			<tr>
				<td>Faktor Resiko Lainnya</td>
				<td>
					<?php
						$arrfaktoresikolain = explode(",",$datapdp['FaktorResikoLainnya']);
					?>
					<div class="row">
						<div class="col-md-4">
							<label><input type="checkbox" name="faktoresikolain[]" value="Apakah Merokok" <?php if(in_array("Apakah Merokok", $arrfaktoresikolain)){echo "CHECKED";}?>> Apakah Merokok</label><br/>
							<label><input type="checkbox" name="faktoresikolain[]" value="Riwayat Alergi Obat" <?php if(in_array("Riwayat Alergi Obat", $arrfaktoresikolain)){echo "CHECKED";}?>> Riwayat Alergi Obat</label><br/>
							<label><input type="checkbox" name="faktoresikolain[]" value="Riwayat Asma" <?php if(in_array("Riwayat Asma", $arrfaktoresikolain)){echo "CHECKED";}?>> Riwayat Asma</label><br/>
							<label><input type="checkbox" name="faktoresikolain[]" value="Makan Sayur & Buah" <?php if(in_array("Makan Sayur & Buah", $arrfaktoresikolain)){echo "CHECKED";}?>> Makan Sayur & Buah</label><br/>
							<label><input type="checkbox" name="faktoresikolain[]" value="Minum Alkohol" <?php if(in_array("Minum Alkohol", $arrfaktoresikolain)){echo "CHECKED";}?>> Minum Alkohol</label><br/>
							<label><input type="checkbox" name="faktoresikolain[]" value="Aktifitas Fisik" <?php if(in_array("Aktifitas Fisik", $arrfaktoresikolain)){echo "CHECKED";}?>> Aktifitas Fisik</label><br/>
						</div>
					</div>
				</td>
			</tr>
		</table>
	</div>	
</div><br/>
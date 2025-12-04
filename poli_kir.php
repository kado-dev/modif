<?php
	$idpasienrj = $_GET['id'];
	$asuransi = $_GET['cb'];
	$dataumum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolikir` WHERE `NoPemeriksaan` = '$noregistrasi'"));	
?>

<div class = "row">
	<div class="col-sm-12">
		<table class="table-judul" width="100%">
			<tr>
				<td class="col-sm-3">
					Anamnesa
					<?php 
						if(substr($asuransi,0,4) == 'BPJS'){?>
						<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
							<img src='image/logo_bpjs_bulet.png' width="30px"/> 1 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-9"><textarea name="anamnesa" class="anamnesa form-control inputan"><?php echo $dataumum['Anamnesa'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Sekarang</td>
				<td><textarea name="riwayatpenyakitsekarang" class="anamnesa form-control inputan"><?php echo $dataumum['RiwayatPenyakitSekarang'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Terdahulu</td>
				<td><textarea name="riwayatpenyakitdulu" class="anamnesa form-control inputan"><?php echo $dataumum['RiwayatPenyakitDulu'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Keluarga</td>
				<td><textarea name="riwayatpenyakitkeluarga" class="anamnesa form-control inputan"><?php echo $dataumum['RiwayatPenyakitKeluarga'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Alergi Makanan</td>
				<td><textarea name="riwayatalergimakanan" class="anamnesa form-control inputan"><?php echo $dataumum['RiwayatAlergiMakanan'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Alergi Obat</td>
				<td><textarea name="riwayatalergiobat" class="anamnesa form-control inputan"><?php echo $dataumum['RiwayatAlergiObat'];?></textarea></td>
			</tr>
			<tr>
				<td>Anjuran</td>
				<td><input type="text" name ="anjuran" class="form-control inputan" value="<?php echo $dataumum['Anjuran'];?>"></td>
			</tr>
			<tr>
				<td>Hasil Lab.</td>
				<td>
					<?php
					$str_gettbtindakandetail = mysqli_query($koneksi, "SELECT b.Tindakan, a.Keterangan FROM $tbtindakanpasien a join tbtindakan b on a.IdTindakan = b.IdTindakan where a.IdPasienrj = '$idpasienrj'");
					if(mysqli_num_rows($str_gettbtindakandetail) > 0){
						while($dt_lab = mysqli_fetch_assoc($str_gettbtindakandetail)){
							$hasilsx []= $dt_lab['Tindakan'].": ".$dt_lab['Keterangan'];
						}
						$pem_lab = "".implode(", ",$hasilsx);
					}else{
						$pem_lab = "";
					}
					?>
					<input type="text" name ="pemeriksaanpenunjanglab" class="form-control inputan" value="<?php echo $pem_lab;?>"> <?php //echo $dataumum['PemeriksaanHasilLab']."".$pem_lab;?>
				</td>
			</tr>
			<tr>
				<td>Faktor Resiko Lainnya</td>
				<td>
					<?php
						$arrfaktoresikolain = explode(",",$dataumum['FaktorResikoLainnya']);
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
</div>
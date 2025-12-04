<?php
	$idpasienrj = $_GET['id'];
	$dataugd = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpolitindakan` WHERE `NoPemeriksaan` = '$noregistrasi'"));

	// vital sign
	$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj'";
	$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
?>

<div class = "row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table-judul" width="100%">
				<tr>
					<td class="col-sm-2">Anamnesa</td>
					<td class="col-sm-10"><textarea name="anamnesa" class="form-control"><?php echo $dtvs['Anamnesa'];?></textarea></td>
				</tr>
				<tr>
					<td>Anjuran</td>
					<td><input type ="text" name ="anjuran" class="form-control" value="<?php echo $dataugd['Anjuran'];?>"></text></td>
				</tr>
				<tr>
					<td>Hasil Lab.</td>
					<td>
					<?php
					$str_gettbtindakandetail = mysqli_query($koneksi,"SELECT Keterangan from tbtindakanpasiendetail a join tbtindakan b on a.KodeTindakan = b.KodeTindakan where a.NoRegistrasi = '$noregistrasi'");
					if(mysqli_num_rows($str_gettbtindakandetail) > 0){
						while($dt_lab = mysqli_fetch_assoc($str_gettbtindakandetail)){
							$hasilsx []= $dt_lab['Keterangan'];
						}
						$pem_lab = " ".implode(", ",$hasilsx);
					}else{
						$pem_lab = "";
					}
					?>
						<input type="text" name ="pemeriksaanpenunjanglab" class="form-control" value="<?php echo $datagizi['PemeriksaanHasilLab']."".$pem_lab;?>">
					</td>
				</tr>
			</table>
		</div>	
	</div>
</div>
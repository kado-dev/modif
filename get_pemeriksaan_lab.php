<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	$idpsnrj = $_POST['idpsnrj'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbtindakanpasien = "tbtindakanpasien_".str_replace(' ', '', $namapuskesmas);
?>

<!-- <style>
.table-judul>thead>tr>th {
	padding-top:15px;
	padding-bottom:15px;
	background:#424242;
	color:#fff;
	border-color:#000;
	font-size: 12px;
	font-family: "Poppins", sans-serif;
	text-align: center;
}
</style> -->

<?php if($_POST['pelayanan'] != "POLI LABORATORIUM"){ ?>
<table class="table-judul" width="100%">
	<h3 class="judul"><b>Pemeriksaan Laboratorium</b></h3>
	<tr>
		<td>
			<table class="table-judul">
				<tr>
					<th>NO.</th>
					<th>JENIS TINDAKAN</th>
					<th>KELOMPOK TINDAKAN</th>
					<th>TARIF</th>
					<th>#</th>
				</tr>
			<?php
				$qry = mysqli_query($koneksi,"SELECT * FROM `tbtindakan` WHERE `KelompokTindakan` = 'Laboratorium' ORDER BY Tindakan ASC");
				if(mysqli_num_rows($qry) > 0){
					$no = 0;
					while($dt = mysqli_fetch_assoc($qry)){
						$no++;
						if($idpsnrj){
							$cekdata = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `$tbtindakanpasien` WHERE `IdPasienrj` = '$idpsnrj' AND IdTindakan = '$dt[IdTindakan]'"));

							$gettindakan = mysqli_query($koneksi, "SELECT * FROM `$tbtindakanpasien` WHERE `IdPasienrj` = '$idpsnrj' AND IdTindakan = '$dt[IdTindakan]'");
							if(mysqli_num_rows($gettindakan) == 0){
								$datatindakan_keterangan = "";
							}else{
								$datatindakan = mysqli_fetch_assoc($gettindakan);
								$datatindakan_keterangan = $datatindakan['Keterangan'];
							}

						}else{
							$cekdata = 0;
							$datatindakan_keterangan = "";
						}
						

						
						

			?>

				<tr>
					<td align="center"><?php echo $no;?></td>
					<td align="left">
						<?php 
							if($datatindakan_keterangan != ""){
								$hasil = "<span style='color:red;'> Hasil :".$datatindakan_keterangan."</span>";
							}else{
								$hasil = "";
							}
							echo $dt['Tindakan'].$hasil;
						?>
					</td>
					<td align="center"><?php echo $dt['KelompokTindakan'];?></td>
					<td align="right"><?php echo rupiah($dt['Tarif']);?></td>
					<td align="center">
						<input type="checkbox" name="tindakanlabs[]" value="<?php echo $dt['IdTindakan'];?>" <?php if ($cekdata > 0){ echo 'checked';}?>/>
					</td>
				</tr>
			<?php
					}
				}
			?>	
			</table>
		</td>
	</tr>
</table>
<?php } ?>
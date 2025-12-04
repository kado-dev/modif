<?php
	session_start();
	include"config/koneksi.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota1 = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$tanggal = date('Y-m-d');
?>
			
<div class="modal fade noprint" id="Modalrm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Bank RM</h4>
			</div>
			<div class="modal-body">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="30%">No.RM</th>
							<th width="40%">Nama Pasien</th>
							<th width="30%">Tgl.Lahir</th>
						</tr>
					</thead>
					<tbody>
						<?php
						    // bagaimana cara bikin where berdasarkan kelurahan...?
							$str_pasien = "SELECT `NewNoRM`,`NamaPasien`,`TanggalLahir` FROM `tbpasien` WHERE SUBSTRING(NoCM,1,11)='$kodepuskesmas' 
							ORDER BY IdPasien DESC LIMIT 10";
							$query_pasien = mysqli_query($koneksi, $str_pasien);
							while($data_pasien = mysqli_fetch_assoc($query_pasien)){
								$norm = $data_pasien['NewNoRM'];
								$namapasien = $data_pasien['NamaPasien'];
								$tgllahir = $data_pasien['TanggalLahir'];
						?>
							<tr>
								<td align="center"><?php echo $norm;?></td>
								<td align="left"><?php echo $namapasien;?></td>
								<td align="center"><?php echo $tgllahir;?></td>
							</tr>
						<?php
							}
						?>
					</tbody>					
				</table>
			</div>
		</div>
	</div>
</div>
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
				<h4 class="modal-title" id="myModalLabel">Bank Data RM</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered table-hover table-condensed">
					<div class = "row">
						<div class="col-sm-12">
							<select name="kelurahan" class="form-control">
								<option value='semua'>Semua</option>
								<?php
								$kota = $_SESSION['kota'];
								$queryp = mysqli_query($koneksi,"SELECT * FROM `tbkelurahan` 
								WHERE `KodePuskesmas`='$kodepuskesmas'
								ORDER BY Kelurahan");
								while($data3 = mysqli_fetch_assoc($queryp)){
									echo "<option value='$data3[Kelurahan]'>$data3[Kelurahan]</option>";
								}
								?>
							</select>
						</div>
					</div><br/>
					<thead>
						<tr>
							<th width="10%">No.RM</th>
							<th width="50%">Nama Pasien</th>
						</tr>
					</thead>
					<tbody>
						<?php
						    // bagaimana cara bikin where berdasarkan kelurahan...?
							$str_pasien = "SELECT `NoRM`, `NamaPasien` FROM `tbpasien` WHERE SUBSTRING(NoCM,1,11)='$kodepuskesmas' 
							ORDER BY NoRM DESC LIMIT 10";
							$query_pasien = mysqli_query($koneksi, $str_pasien);
							while($data_pasien = mysqli_fetch_assoc($query_pasien)){
								$norm = $data_pasien['NoRM'];
								$namapasien = $data_pasien['NamaPasien'];
						?>
							<tr>
								<td align="center">
								<?php
									if($_SESSION['kota'] == 'KABUPATEN BULUNGAN'){
										$norms = substr($data_pasien['NoRM'],-6);
									}elseif($_SESSION['kota'] == 'KABUPATEN KUTAI KARTANEGARA'){
										$norms = substr($data_pasien['NoRM'],-6);
									}
									echo $norms;
								?>
								</td>
								<td align="left"><?php echo $namapasien;?></td>
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
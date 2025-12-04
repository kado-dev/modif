<?php
include "config/helper_report.php";
include "config/helper_pasienrj.php";
$tanggal = $_GET['tgl'];
$kodebarang = $_GET['kdbrg'];
$statusdepot = $_GET['sts'];
$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);

?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>DETAIL PEMAKAIAN</b></h3>
			<div class="formbg">
				<div class = "row">
					<table class="table-judul">
						<thead>
							<tr>
								<th width="5%">NO.</th>
								<th width="15%">TGL.RESEP</th>
								<th width="10%">NO.RESEP</th>
								<th width="50%">NAMA PASIEN</th>
								<th width="10%">PELAYANAN</th>
								<th width="10%">JML.OBAT</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$no = 0;
							$str = "SELECT `TanggalResep`,`NoResep`, `jumlahobat`, `Pelayanan` FROM `$tbresepdetail` WHERE date(TanggalResep) = '$tanggal' AND `Depot`='$statusdepot' AND `KodeBarang`='$kodebarang'";
							$str2 = $str." GROUP BY `NoResep`,`Pelayanan` ORDER BY `IdResepDetail` ASC LIMIT 200";
							// echo $str2;
							// die();
											
							$query = mysqli_query($koneksi,$str2);
							while($data = mysqli_fetch_assoc($query)){
								$no = $no + 1;
								
								// tbpasienrj
								$dtpasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPasien` FROM `$tbpasienrj` WHERE `NoRegistrasi`='$data[NoResep]'"));
								if($dtpasienrj['NamaPasien'] == ''){
									$dtresep = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPasien` FROM `$tbresep` WHERE `NoResep`='$data[NoResep]'"));	
									$namapasien = $dtresep['NamaPasien'];
								}else{
									$namapasien = $dtpasienrj['NamaPasien'];
								}	
								
							?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo $data['TanggalResep'];?></td>
								<td align="center"><?php echo $data['NoResep'];?></td>
								<td align="left"><?php echo $namapasien;?></td>
								<td align="left"><?php echo $data['Pelayanan'];?></td>
								<td align="right"><?php echo $data['jumlahobat'];?></td>
							</tr>
						<?php
							$total = $total +  $data['jumlahobat'];
						}
						?>
							<tr>
								<td align="center" colspan="5">TOTAL</td>
								<td align="right"><?php echo $total;?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>	
	</div>	
</div>	
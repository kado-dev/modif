<?php
    session_start();	
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";	
	include "config/helper_bpjs_antrean_v2.php";
	// $data_medis = get_data_dokter_antrean_fktp('001','2025-05-30');
    // $dmedis = json_decode($data_medis,True);
    // $list = $dmedis['response']['list'];
    // echo "hasil : ".get_data_dokter_antrean_fktp();
    // die();
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>Jadwal Tenaga Medis</b></h3>
			<?php echo $_COOKIE['alert'];?>
			<table class="table-judul">
				<thead>
					<tr>
						<th width="10%">Kode</th>
						<th width="45%">Tenaga Medis</th>
						<th width="15%">Layanan</th>
                        <th width="20%">Jam Praktek</th>
                        <th width="10%">Kapasitas</th>
					</tr>
				</thead>
				<tbody font="8">
					<?php
					$kodepuskesmas = $_SESSION['kodepuskesmas'];
					$query = mysqli_query($koneksi,"SELECT * FROM `tbpegawaibpjsjadwal` WHERE kdpuskesmas = '$kodepuskesmas' order by `namadokter`");
					$no = 0;
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$kdpoli = $data['kodepoli'];

						// dtpelayanan
						$dtpelayanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Pelayanan` FROM `tbpelayanankesehatan` WHERE `kdPoli`='$kdpoli'"));
					?>
						<tr>
							<td align="center"><?php echo $data['kodedokter'];?></td>
							<td align="left"><?php echo $data['namadokter'];?></td>
                            <td align="left"><?php echo str_replace('POLI','LAYANAN',$dtpelayanan['Pelayanan']);?></td>
                            <td align="center"><?php echo $data['jampraktek'];?></td>
                            <td align="center"><?php echo $data['kapasitas'];?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div><br/>
	<div class="row">
		<div class="col-sm-12">
			<a href="import_pegawai_bpjs_jadwal.php" class="btnsimpan">Update Pelayanan Umum</a>
		</div><br/>
		<div class="col-sm-12 mt-2">
			<a href="import_pegawai_bpjs_jadwal_lansia.php" class="btnsimpan">Update Pelayanan Lansia</a>
		</div><br/>
		<div class="col-sm-12 mt-2">
			<a href="import_pegawai_bpjs_jadwal_gigi.php" class="btnsimpan">Update Pelayanan Gigi</a>
		</div><br/>
		<div class="col-sm-12 mt-2">
			<a href="import_pegawai_bpjs_jadwal_kia.php" class="btnsimpan">Update Pelayanan Kia</a>
		</div><br/>
		<div class="col-sm-12 mt-2">
			<a href="import_pegawai_bpjs_jadwal_kb.php" class="btnsimpan">Update Pelayanan Kb</a>
		</div><br/>
		<div class="col-sm-12 mt-2">
			<a href="import_pegawai_bpjs_jadwal_tb.php" class="btnsimpan">Update Pelayanan Tb</a>
		</div>
	</div>
</div>

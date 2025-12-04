<!--riwayat kunjungan-->
<?php
	if($kategori_pencarian == 'BPJS' || $kategori_pencarian == 'Nikbpjs'){
		if($data_pasienbpjs['NoIndex'] == 0){
			$nocm_kunj = $dbpjs['response']['noKartu'];
		}else{
			$nocm_kunj = $data_pasienbpjs['NoCM'];
		}
	}else{
		$nocm_kunj = $data['NoCM'];
	}
	
	$str_riwayat = "SELECT `NoRegistrasi` FROM `tbpasienrj` WHERE NoCM='$nocm_kunj' ORDER BY TanggalRegistrasi DESC LIMIT 3";
	$cek_riwayat = mysqli_num_rows(mysqli_query($koneksi,$str_riwayat));

	if ($nocm_kunj != null){
		if($cek_riwayat > 0){
		?>
			<div class="box border black" style="margin-top:-20px;">
				<div class="row">
					<div class="col-sm-12">
						<div class="widget-box transparent">
							<div class="widget-header widget-header-large">
								<h3 class="widget-title grey lighter">
									<i class="ace-icon fa fa-leaf green"></i>
									Riwayat Kunjungan Pasien
								</h3>
							</div>
						</div>
						<div class="table-responsive">
							<table class="tabel_judul table-bordered" width="100%">
								<thead align="center">
									<tr>
										<th>Tgl.Kunjungan</th>
										<th>Poli</th>
										<th>Jaminan</th>
										<th>Kunjungan</th>
										<th>Status Pulang</th>
									</tr>
								</thead>
								<tbody class="tabel_isi">
									<?php
									$queryriwayat = mysqli_query($koneksi,$str_riwayat);
									while($riwayat = mysqli_fetch_assoc($queryriwayat)){
										$noregs = $riwayat['NoRegistrasi'];
										$tbparj = 'tbpasienrj_'.substr($noregs,14,2);
										$detailriwayat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `TanggalRegistrasi`, `PoliPertama`, `Asuransi`, `StatusKunjungan`, `StatusPulang` FROM $tbparj WHERE `NoRegistrasi` = '$noregs'"));
										if ($detailriwayat['StatusPulang'] == '3'){$statusplg='Berobat Jalan';}else{$statusplg='Rujuk Lanjut';}
									?>
										<tr>
											<td style="border-bottom:1px solid #dbdbdb;"><?php echo date('d-m-Y', strtotime($detailriwayat['TanggalRegistrasi']));?></td>
											<td style="border-bottom:1px solid #dbdbdb;"><?php echo $detailriwayat['PoliPertama'];?></td>
											<td style="border-bottom:1px solid #dbdbdb;"><?php echo $detailriwayat['Asuransi'];?></td>	
											<td style="border-bottom:1px solid #dbdbdb;"><?php echo $detailriwayat['StatusKunjungan'];?></td>	
											<td style="border-bottom:1px solid #dbdbdb;"><?php echo $statusplg;?></td>	
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
		<?php
		}
	}
?>	
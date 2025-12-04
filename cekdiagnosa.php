<div class="widget-box transparent">
						<h3 class="judul"><b>RIWAYAT PASIEN</b></h3>
						<div class="table-responsive">
							<table class="table-judul" width="100%">
								<thead>
									<tr>
										<th width="10%">KODE</th>
										<th width="90%">DIAGNOSA</th>
									</tr>
								</thead>
								<tbody class="tabel_isi">
									<?php
									$no = 0;
									// cek diagnosa pasien
									include "config/koneksi.php";
									$tbdiagnosapasien = "tbdiagnosapasien_".str_replace(' ', '', $namapuskesmas);
									$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` GROUP BY KodeDiagnosa";
									echo $str_diagnosapsn;
									
									$query_diagnosapsn = mysqli_query($koneksi, $str_diagnosapsn);
									while($data = mysqli_fetch_array($query_diagnosapsn)){
										$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data[KodeDiagnosa]'"));
										
									
									
									
									?>
										<tr>
											<td><?php echo $data['KodeDiagnosa'];?></td>
											<td><?php echo $dtdiagnosa['Diagnosa'];?></td>
										</tr>
									<?php
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
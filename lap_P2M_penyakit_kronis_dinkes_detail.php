<?php
include "config/helper_report.php";
include "config/helper_pasienrj.php";
include "config/helper_bpjs_v4_dinkes.php";
$tanggal = $_GET['tgl'];
$kodebarang = $_GET['kdbrg'];
$sts = $_GET['sts'];
$namapuskesmas = $_GET['pkm'];
$bulan = $_GET['bln'];
$tahun = $_GET['thn'];

?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DETAIL DIAGNOSA <?php echo strtoupper($sts)." "."(".$namapuskesmas.")"?></b></h3>
			<div class="formbg">
				<div class = "row">
					<table class="table-judul" width="100%">
						<thead>
							<tr>
								<th width="3%">NO.</th>
								<th width="7%">Tanggal.Periksa</th>
								<th width="10%">Nik</th>
								<th width="10%">No.Bpjs</th>
								<th width="15%">Nama Pasien</th>
								<th width="20%">Jenis Peserta</th>
								<th width="35%">Diagnosa</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$no = 0;	
                            $tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
                            $tbpasienrj = 'tbpasienrj_'.str_replace(' ', '', $namapuskesmas);
                            $waktu = "YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan'";

                            // kode diagnosa
                            $kodedgs_hipertensi = " AND (`KodeDiagnosa` like '%I10%')";
                            $kodedgs_jantung = " AND (`KodeDiagnosa` like '%I25%' OR `KodeDiagnosa` like '%I50%')";
                            $kodedgs_tbc_paru = " AND (`KodeDiagnosa` like '%J44%' OR `KodeDiagnosa` like '%J45%' OR `KodeDiagnosa` like '%A15%')";
                            $kodedgs_tbc_saraf = " AND (`KodeDiagnosa` like '%A17%' OR `KodeDiagnosa` like '%A18%' OR `KodeDiagnosa` like '%A19%')";
                            $kodedgs_diabet = " AND (`KodeDiagnosa` like '%E10%' OR `KodeDiagnosa` like '%E11%' OR `KodeDiagnosa` like '%E14%')";
                            $kodedgs_ginjal = " AND (`KodeDiagnosa` like '%N18%')";
                            $kodedgs_mental = " AND (`KodeDiagnosa` like '%F20%' OR `KodeDiagnosa` like '%F32%' OR `KodeDiagnosa` like '%F33%')";
                            $kodedgs_thalasemi = " AND (`KodeDiagnosa` like '%D56%')";
                            $kodedgs_sistemsaraf = " AND (`KodeDiagnosa` like '%A17%')";

                            if($sts == 'hipertensi'){
                                $str2 = "SELECT * FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs_hipertensi";
                            }elseif($sts == 'jantung'){
                                $str2 = "SELECT * FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs_jantung";
                            }elseif($sts == 'tbcparu'){
                                $str2 = "SELECT * FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs_tbc_paru";
                            }elseif($sts == 'tbcsaraf'){
                                 $str2 = "SELECT * FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs_tbc_saraf";       
                            }elseif($sts == 'diabet'){
                                $str2 = "SELECT * FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs_diabet";
                            }elseif($sts == 'ginjal'){
                                $str2 = "SELECT * FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs_ginjal";
                            }elseif($sts == 'mental'){
                                $str2 = "SELECT * FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs_mental";
                            }elseif($sts == 'thalasemi'){
                                $str2 = "SELECT * FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs_thalasemi";
                            }elseif($sts == 'sistemsaraf'){
                                $str2 = "SELECT * FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs_sistemsaraf";
                            }
                            // echo $str2;
                            
							$query = mysqli_query($koneksi, $str2);
							while($data = mysqli_fetch_assoc($query)){
								$no = $no + 1;
								$idpasienrj = $data['IdPasienrj'];
								
								
								// tbpasienrj
								$dtpasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `TanggalRegistrasi`,`Nik`,`NamaPasien`,`PoliPertama`,`nokartu` FROM `$tbpasienrj` WHERE `IdPasienrj`='$idpasienrj'"));
                                $noka = $dtpasienrj['nokartu'];

								// tbdiagnosa
								$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa`='$data[KodeDiagnosa]'"));
                                
                                // update cara bayar                                						
                                $data_bpjs = get_data_peserta_bpjs($noka);
                                $dtbpjs = json_decode($data_bpjs,True);
                                $jenispeserta = $dtbpjs['response']['jnsPeserta']['nama'];
                                // echo "Hasil : ".$jenispeserta;
                                // echo "Hasil : ".$data_bpjs;			
							?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo date('d-m-Y', strtotime($dtpasienrj['TanggalRegistrasi']));?></td>
								<td align="center"><?php echo $dtpasienrj['Nik'];?></td>
								<td align="center"><?php echo $dtpasienrj['nokartu'];?></td>
								<td align="left"><?php echo $dtpasienrj['NamaPasien'];?></td>
								<td align="left">
                                    <?php echo $jenispeserta;?>
                                </td>
								<td align="left"><?php echo $data['KodeDiagnosa']." - ".$dtdiagnosa['Diagnosa'];?></td>
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
</div>	
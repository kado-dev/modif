<?php
session_start();
include "config/koneksi.php";
include "config/helper.php";
include "config/helper_report.php";
include "config/helper_pasienrj.php";
$tanggal = date('Y-m-d');
$nocm = $_POST['cm'];
$id = $_POST['no'];
$pel = $_POST['pel'];

// tbpasienrj
$dt_pasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi`='$id' AND `PoliPertama`='$pel'"));

$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);

$tbtindakanpasien = "tbtindakanpasien_".str_replace(' ', '', $namapuskesmas);
$tbpasienperpegawai = 'tbpasienperpegawai_'.$kodepuskesmas;
$data_pemeriksa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` WHERE `NoRegistrasi` = '$id'"));

// rujuk internal
$dt_rujukinternal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbrujukinternal` WHERE `NoRujukan` = '$id'"));

$pelayanan = $dt_pasienrj['PoliPertama'];
if($pelayanan == 'POLI UMUM'){
	$tbpoliumum = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
	$poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpoliumum` WHERE `NoPemeriksaan` = '$id' AND `NoCM`='$nocm'"));
}else{
	$pelayanan = "tb".strtolower(str_replace(' ', '', $pelayanan));
	$poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$pelayanan` WHERE `NoPemeriksaan` = '$id' AND `NoCM`='$nocm'"));
}

// vitalsign
$suhu = $poli['SuhuTubuh'];

?>
<style>
	
	.prints{
		margin-top: 0px;
		display:none;
	}
	.arsip{
		display:none;
	}
	.tables{
		line-height: 20px !important;
	}	
	
	@media print{
		body{
			font-family: "Arial Narrow", "Arial", "sans-serif";
			font-size: 14px;
			visibility: hidden;
		}
		.noprint{
			display:none;
		}
		.tr, td{
			line-height:0px !important;
		}
		.printheader{
			display:block;
			visibility:visible;
			margin-top: 15px;
		}
		.prints{
			display: block;
			position: relative;
			border: 1px solid #000;
			padding: 0px 20px 0 20px;
			visibility: visible;
		}
		.arsip{
			display:block;
			visibility:visible;
			margin-top:5px;
		}		
	}
</style>


<div class="prints" style="margin-top: -10px;">
	<div class="printheader">
		<span style="font-size: 16px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br/>
		<span style="font-size: 22px; line-height: 25px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br/>
		<p style="font-size: 12px; font-family: 'Arial Narrow', 'Arial', 'sans-serif'">
			<?php echo $alamat;?><br/>
			<?php echo "Email : ".$email.", Telp.".$telepon;?>
		</p>	
		<hr style="margin:10px; border:1px solid #000">
		<span style="font-size: 16px;"><b>REKAM MEDIS PASIEN</b></span><br/>
	</div>
	<div style="margin-top: 10px;">
		<table class="table" width="100%">
			<tr>	
				<td width="20%">Tgl.Periksa</td>
				<td width="3%">:</td>
				<td width="17%"><?php echo date('d-m-Y',strtotime($dt_pasienrj['TanggalRegistrasi']));?></td>
				<td width="10%"></td>
				<td width="15%">No.Index</td>
				<td width="3%">:</td>
				<td width="42%"><?php echo substr($dt_pasienrj['NoIndex'],-10);?></td>
				
			</tr>
			<tr>	
				<td>Nama Pasien</td>
				<td>:</td>
				<td><?php echo $dt_pasienrj['NamaPasien'];?></td>
				<td></td>
				<td>No.RM</td>
				<td>:</td>
				<td><?php echo $dt_pasienrj['NoRM'];?></td>
			</tr>
			<tr>	
				<td>Usia</td>
				<td>:</td>
				<td><?php echo $dt_pasienrj['UmurTahun']." Th ".$dt_pasienrj['UmurBulan']." Bl";?></td>
				<td></td>
				<td >Jaminan</td>
				<td>:</td>
				<td><?php echo $dt_pasienrj['Asuransi'];?></td>
			</tr>
		</table>
	</div>
	<div style="margin-top: -10px;">	
		<b>&nbsp Vital Sign dan Pemeriksaan Dasar</b>
		<table class="table" width="100%" style="margin-top: 5px;">									
			<tr>
				<td width="20%">Sistole, Diastole</td>
				<td width="3%">:</td>
				<td width="17%"><?php echo $poli['Sistole']." / ".$poli['Diastole'];?></td>
				<td width="10%"></td>
				<td width="15%">Anamnesa</td>
				<td width="3%">:</td>
				<td width="42%"><?php echo $poli['Anamnesa'];?></td>
			</tr>
			<tr>
				<td>Suhu Tubuh</td>
				<td>:</td>
				<td><?php echo $poli['SuhuTubuh'];?></td>
				<td></td>
				<td>Anjuran</td>
				<td>:</td>
				<td><?php echo $poli['Anjuran'];?></td>
			</tr>
			<tr>
				<td>BB, TB</td>
				<td>:</td>
				<td><?php echo $poli['BeratBadan']." Kg , ".$poli['TinggiBadan']." Cm";?></td>
				<td></td>
				<td>Prk.Penunjang</td>
				<td>:</td>
				<td><?php echo $poli['PemeriksaanPenunjang'];?></td>
			</tr>
			<tr>
				<td>Heart Rate</td>
				<td>:</td>
				<td><?php echo $poli['DetakNadi'];?></td>
			</tr>
			<tr>
				<td>Respiratory Rate</td>
				<td>:</td>
				<td><?php echo $poli['RR'];?></td>
			</tr>
		</table>
	</div>	
	<div style="margin-top: -10px;">
		<b>&nbsp Diagnosa</b>
		<table class="table" style="margin-top: 5px;">		
			<?php
				$no = 0;
				$qdiag = mysqli_query($koneksi,"SELECT * FROM `$tbdiagnosapasien` a join `tbdiagnosabpjs` b on a.KodeDiagnosa = b.KodeDiagnosa WHERE a.NoRegistrasi = '$id'");
				while($ddiag = mysqli_fetch_assoc($qdiag)){
			?>
			<tr>
				<td width="20%">
					<span><?php echo $ddiag['KodeDiagnosa'].", ".$ddiag['Diagnosa'].", (Kasus ". $ddiag['Kasus'].")";?>
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>
	<?php
		$cekresep = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `$tbresep` WHERE `NoResep`='$id'"));
		if($cekresep > 0){
	?>
	<div style="margin-top: -10px;">
		<b>&nbsp Therapy</b>
		<table class="table" style="margin-top: 5px;">	
			<?php
				$no = 0;
				$qresep = mysqli_query($koneksi, "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$id'");						
				while($dtresep = mysqli_fetch_assoc($qresep)){
					$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbgudangpkmstok` WHERE `KodeBarang`='$dtresep[KodeBarang]'"));
			?>
			<tr>
				<td width="20%">
					<span><?php echo $dtobat['NamaBarang'].", Jml:".$dtresep['jumlahobat'].", Signa ". $dtresep['signa1']."x".$dtresep['signa2'];?>
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>
	<?php } ?>
</div>
<div class="arsip">*Harap disimpan dengan baik.</div>

<!--modal-->
<div class="modal fade noprint" id="ModalRiwayat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body noprint">
				<div class="text-center">
					<p style="font-weight: bold; font-size: 18px;"><?php echo $dt_pasienrj['NamaPasien'];?><br/>
						<h6 style="line-height: 0px;"><?php echo "Usia : ".$dt_pasienrj['UmurTahun']." Th, ".$dt_pasienrj['UmurBulan']." Bl";?></h6>
					</p>
				</div><hr/>
				<div class="row noprint">						
					<div class="col-sm-12">						
						<div class="col-sm-12">	
							<b>PENDAFTARAN</b>
							<table class="tables" width="100%">									
								<tr>
									<td width="22%">Tanggal Registrasi</td>
									<td width="3%">:</td>
									<td width="75%"><?php echo date('d-m-Y',strtotime($dt_pasienrj['TanggalRegistrasi']));?></td>
								</tr>
								<tr>
									<td>Ruang Pemeriksaan</td>
									<td>:</td>
									<td><?php echo $dt_pasienrj['PoliPertama'];?></td>
								</tr>
							</table><br/>
							
							<b>VITAL SIGN</b>
							<table class="tables" width="100%">									
								<tr>
									<td width="17%">Sistole, Diastole</td>
									<td width="3%">:</td>
									<td width="80%"><?php echo $poli['Sistole']." / ".$poli['Diastole'];?></td>
								</tr>
								<tr>
									<td>Suhu Tubuh</td>
									<td>:</td>
									<td><?php echo $suhu;?></td>
								</tr>
								<tr>
									<td>BB / TB</td>
									<td>:</td>
									<td><?php echo $poli['BeratBadan']." Kg , ".$poli['TinggiBadan']." Cm";?></td>
								</tr>
								<tr>
									<td>Heart Rate</td>
									<td>:</td>
									<td><?php echo $poli['DetakNadi'];?></td>
								</tr>
								<tr>
									<td>Respiratory Rate</td>
									<td>:</td>
									<td><?php echo $poli['RR'];?></td>
								</tr>
							</table><br/>
							
							<b>RUANG PEMERIKSAAN <?php echo "(".str_replace('POLI ','',$dt_pasienrj['PoliPertama']).")";?></b>
														
							<?php 
								// ngebaca jika poli gigi, indikator pemeriksaannya beda
								if($dt_pasienrj['PoliPertama'] == "POLI GIGI"){ 
							?>
							Pemeriksaan Penunjang
							<table class="tables" width="100%">
								<tr>
									<td width="17%">Rencana Therapy</td>
									<td width="3%">:</td>
									<td width="80%"><?php echo $poli['RencanaTerapi'];?></td>
								</tr>
								<tr>
									<td>Tindakan</td>
									<td>:</td>
									<td><?php echo $poli['Tindakan'];?></td>
								</tr>
								<tr>
									<td>Informed Consent</td>
									<td>:</td>
									<td><?php echo $poli['InformedConsent'];?></td>
								</tr>
								<tr>
									<td>Tindak Lanjut ke-1</td>
									<td>:</td>
									<td><?php echo $poli['TindakLanjut1'];?></td>
								</tr>
								<tr>
									<td>Tindak Lanjut ke-2</td>
									<td>:</td>
									<td><?php echo $poli['TindakLanjut2'];?></td>
								</tr>
								<tr>
									<td>Anjuran Kunj.Ulang</td>
									<td>:</td>
									<td><?php echo $poli['KunjunganUlang'];?></td>
								</tr>
								<tr>
									<td>Jika Rujuk ke</td>
									<td>:</td>
									<td><?php echo $poli['TindakLanjutRujuk'];?></td>
								</tr>
								<tr>
									<td>Kunjungan Gigi</td>
									<td>:</td>
									<td><?php echo $poli['KunjunganGigi'];?></td>
								</tr>
								<tr>
									<td>Terima Rujukan</td>
									<td>:</td>
									<td><?php echo $poli['TerimaRujukan'];?></td>
								</tr>
							</table><br/>
							<?php } ?>

							<?php 
								// PELAYANAN KIA
								if($dt_pasienrj['PoliPertama'] == "POLI KIA"){ 
							?>
							<table class="tables" width="100%">
								<tr>
									<td width="22%">Anamnesa</td>
									<td width="3%">:</td>
									<td width="75%"><?php echo $poli['Anamnesa'];?></td>
								</tr>
								<tr>
									<td>Usia Kehamilan</td>
									<td>:</td>
									<td><?php echo $poli['UsiaKehamilan'];?></td>
								</tr>
								<tr>
									<td>TFU</td>
									<td>:</td>
									<td><?php echo $poli['Tfu'];?></td>
								</tr>
								<tr>
									<td>LILA</td>
									<td>:</td>
									<td><?php echo $poli['Lila'];?></td>
								</tr>
								<tr>
									<td>Status Gizi</td>
									<td>:</td>
									<td><?php echo $poli['StatusGizi'];?></td>
								</tr>
								<tr>
									<td>Refleks Patella</td>
									<td>:</td>
									<td><?php echo $poli['RefleksPatella'];?></td>
								</tr>
								<tr>
									<td>Riwayat SC</td>
									<td>:</td>
									<td><?php echo $poli['RiwayatSc'];?></td>
								</tr>
								<tr>
									<td>TT</td>
									<td>:</td>
									<td><?php echo $poli['TT'];?></td>
								</tr>
								<tr>
									<td>FE</td>
									<td>:</td>
									<td><?php echo $poli['FE'];?></td>
								</tr>
								<tr>
									<td>Kunj.Kehamilan</td>
									<td>:</td>
									<td><?php echo $poli['KunjunganKehamilan'];?></td>
								</tr>
								<tr>
									<td>Deteksi Resiko</td>
									<td>:</td>
									<td><?php echo $poli['DeteksiResiko'];?></td>
								</tr>
								<tr>
									<td>Komplikasi di Tangani</td>
									<td>:</td>
									<td><?php echo $poli['KomplikasiDitanganiIbuHamil'];?></td>
								</tr>
								<tr>
									<td>P4K</td>
									<td>:</td>
									<td><?php echo $poli['P4K'];?></td>
								</tr>
							</table><br/>
							<?php } ?>

							<?php 
								// PELAYANAN UMUM
								if($dt_pasienrj['PoliPertama'] == "POLI UMUM"){ 
							?>			
							<table class="tables" width="100%">
								<tr>
									<td width="17%">Anamnesa</td>
									<td width="3%">:</td>
									<td width="80%"><?php echo $poli['Anamnesa'];?></td>
								</tr>
								<tr>
									<td>Anjuran</td>
									<td>:</td>
									<td><?php echo $poli['Anjuran'];?></td>
								</tr>
								<tr>
									<td>Hasil. Lab</td>
									<td>:</td>
									<td><?php echo $poli['PemeriksaanHasilLab'];?></td>
								</tr>
							</table><br/>
							<?php } ?>	
							
							<?php if($dt_rujukinternal['PoliRujukan'] != ""){?>
							<b>RUJUK INTERNAL (1) <?php echo "(".$dt_rujukinternal['PoliRujukan'].")";?></b>
							<?php
								$pelayanan = "tb".strtolower(str_replace(' ', '', $dt_rujukinternal['PoliRujukan']));
								$pemeriksa_lanjut = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$pelayanan` WHERE `NoPemeriksaan` = '$id'"));
							?>
							<table class="tables" width="100%">
								<tr>
									<td width="17%">Anamnesa</td>
									<td width="3%">:</td>
									<td width="80%"><?php echo $pemeriksa_lanjut['Anamnesa'];?></td>
								</tr>
								<tr>
									<td>Anjuran</td>
									<td>:</td>
									<td><?php echo $pemeriksa_lanjut['Anjuran'];?></td>
								</tr>
								<tr>
									<td>Hasil. Lab</td>
									<td>:</td>
									<td><?php echo $pemeriksa_lanjut['PemeriksaanHasilLab'];?></td>
								</tr>
								<?php if($dt_rujukinternal['PoliRujukan'] == "POLI GIGI"){ ?>
								<tr>
									<td width="17%">Rencana Therapy</td>
									<td width="3%">:</td>
									<td width="80%"><?php echo $pemeriksa_lanjut['RencanaTerapi'];?></td>
								</tr>
								<tr>
									<td width="17%">Tindakan</td>
									<td width="3%">:</td>
									<td width="80%"><?php echo $pemeriksa_lanjut['Tindakan'];?></td>
								</tr>
								<tr>
									<td width="17%">Tindak Lanjut (1)</td>
									<td width="3%">:</td>
									<td width="80%"><?php echo $pemeriksa_lanjut['TindakLanjut1'];?></td>
								</tr>
								<tr>
									<td width="17%">Tindak Lanjut (2)</td>
									<td width="3%">:</td>
									<td width="80%"><?php echo $pemeriksa_lanjut['TindakLanjut2'];?></td>
								</tr>
								<?php } ?>
							</table><br/>	
							<?php } ?>
						</div>
					</div>
				</div>
			</div>	
			<div style="padding: 0 25px 0 25px; margin-top: 0px;">			
				<b>DIAGNOSA</b>
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="5%">No.</th>
							<th width="10%">Kode</th>
							<th width="75%">Nama Diagnosa</th>
							<th width="10%">Kasus</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$no = 0;
							$qdiag = mysqli_query($koneksi,"SELECT * FROM `$tbdiagnosapasien` a join `tbdiagnosabpjs` b on a.KodeDiagnosa = b.KodeDiagnosa WHERE a.NoRegistrasi = '$id'");
							while($ddiag = mysqli_fetch_assoc($qdiag)){
								$no = $no + 1;
						?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo $ddiag['KodeDiagnosa'];?></td>
							<td align="left"><?php echo $ddiag['Diagnosa'];?></td>
							<td align="center"><?php echo $ddiag['Kasus'];?></td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table><br/>

				<?php
					// cek therapy (ada / kosong)
					$cekresep = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `$tbresep` WHERE `NoResep`='$id'"));
					if($cekresep > 0){
				?>
				<b>THERAPY</b>
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="5%">NO.</th>
							<th width="10%">KODE</th>
							<th width="55%">NAMA OBAT</th>
							<th width="10%">JML</th>
							<th width="10%">RACIKAN</th>
							<th width="10%">DOSIN</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$no = 0;
							$qresep = mysqli_query($koneksi, "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$id'");						
							while($dtresep = mysqli_fetch_assoc($qresep)){
								$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbapotikstok` WHERE `KodeBarang`='$dtresep[KodeBarang]'"));
								$no = $no + 1;
						?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo $dtresep['KodeBarang'];?></td>
							<td align="left"><?php echo $dtobat['NamaBarang'];?></td>
							<td align="center"><?php echo $dtresep['jumlahobat'];?></td>
							<td align="center"><?php echo $dtresep['racikan'];?></td>
							<td align="center"><?php echo $dtresep['signa1']." x ".$dtresep['signa2'];?></td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table><br/>
				<?php
					}
					
					// cek tindakan (ada / kosong)
					$cektindakan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `$tbtindakanpasien` WHERE `NoRegistrasi`='$id'"));
					if($cektindakan > 0){
				?>
				<b>Tindakan</b>
				<table class="table-judul-laporan">
					<thead>
						<tr>
							<th width="5%">No.</th>
							<th width="10%">Kode</th>
							<th width="50%">Jenis Tindakan</th>
							<th width="10%">Tarif</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$no = 0;
							$qtindakan = mysqli_query($koneksi,"SELECT * FROM `$tbtindakanpasien` WHERE `NoRegistrasi`='$id'");
							while($dtindakan = mysqli_fetch_assoc($qtindakan)){
								$no = $no + 1;
								
								// tbtindakan
								$dttindakan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbtindakan` WHERE `IdTindakan`='$dtindakan[IdTindakan]'"));
						?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo $dtindakan['IdTindakan'];?></td>
							<td align="left"><?php echo $dttindakan['Tindakan'];?></td>
							<td align="right"><?php echo rupiah($dtindakan['Tarif']);?></td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table><br/>
				<?php } ?>				
			</div>	
			<div class="modal-footer noprint">
				<a href="javascript:print()" class="btn btn-info noprint">PRINT</a>
			</div>	
		</div>
	</div>
</div>
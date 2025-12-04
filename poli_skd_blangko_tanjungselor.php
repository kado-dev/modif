<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_report.php";
	$nopemeriksaan = $_GET['id'];
	$nocm = $_GET['nocm'];
	$noindex = $_GET['noindex'];
	$tahun = date('Y');
	
if($_GET['sts'] == 'editnama'){
	$namabaru = $_POST['namabaru'];
	$nocm = $_POST['nocm'];
	$tbpasien = 'tbpasien_'.substr($nocm,12,4);
	mysqli_query($koneksi,"UPDATE `tbpasien` SET `NamaPasien`='$namabaru' WHERE `NoCM` = '$nocm'");
	mysqli_query($koneksi,"UPDATE `$tbpasien` SET `NamaPasien`='$namabaru' WHERE `NoCM` = '$nocm'");
}elseif($_GET['sts'] == 'editpekerjaan'){
	$pekerjaanbaru = $_POST['pekerjaanbaru'];
	$nocm = $_POST['nocm'];
	$tbpasien = 'tbpasien_'.substr($nocm,12,4);
	mysqli_query($koneksi,"UPDATE `$tbpasien` SET `Pekerjaan`='$pekerjaanbaru' WHERE `NoCM` = '$nocm'");
}elseif($_GET['sts'] == 'editalamat'){
	$alamatbaru = $_POST['alamatbaru'];
	$nocm = $_POST['nocm'];
	$tbpasien = 'tbpasien_'.substr($nocm,12,4);
	mysqli_query($koneksi,"UPDATE `$tbpasien` SET `Alamat`='$alamatbaru' WHERE `NoCM` = '$nocm'");
}else{	
?>
<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
<style type="text/css">

body{
	font-size: 12px;
	font-family: 'Ubuntu', sans-serif;	
}
.middlecol tr, .middlecol td{
	border: 1px solid #000;
	padding: 0px 5px 0px 5px;
}

.page-content {
    background-color: transparent;
}	
.imgbackground{
	width:70%;
	margin:auto;
	left:0px;right:0px;top:100px;
	position:absolute;
	z-index:-1;
}

.middlecol table {
	max-width:100% !important;
}

@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}
	.printbody{
		display:block;
	}
	.atastabel{
		display:block;
	}
	.bawahtabel{
		display:block;
	}	
}
</style>
	<a href="#" class="btn btn-sm btn-info btnmodalpasien pull-right noprint" style="margin-bottom: 20px;" data-nocm="<?php echo $nocm;?>" data-noreg="<?php echo $nopemeriksaan;?>">Edit Data</a>
	<div id="test">
	<div class="middlecol">
	<img src="image/logo_puskesmas_ts.png" class="imgbackground"/>
		<center>
			<?php
				$tbpasien = 'tbpasien_'.substr($nocm,12,4);
				$strpasien = "SELECT * 
				FROM `$tbpasien`
				WHERE `NoCM`='$nocm'";
				$dtpasien = mysqli_fetch_assoc(mysqli_query($koneksi, $strpasien));
									
				// tbkk
				$strkk = "SELECT `Alamat`,`RT`,`Kelurahan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
				$dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, $strkk));
				
				// tbpoliskd
				$strpoliskd = "SELECT * FROM `tbpoliskd` WHERE `NoPemeriksaan` = '$nopemeriksaan'";
				$dtpoliskd = mysqli_fetch_assoc(mysqli_query($koneksi, $strpoliskd));
				
				// tbpegawai
				$strpegawai = "SELECT * FROM `tbpegawai` WHERE `NamaPegawai` = '$dtpoliskd[NamaDokter]'";
				$dtpegawai = mysqli_fetch_assoc(mysqli_query($koneksi, $strpegawai));
			?>
			<table width="100%" style="line-height: 12px;">
				<tr>
					<td rowspan="4" align="center"><img src="image/bulungan.png" width="40px"></td>
					<td rowspan="2" align="center"  width="40%" style="font-size: 14px;"><strong><?php echo "UPT PUSKESMAS ".$namapuskesmas;?></strong></td>
					<td>No.Dokumen</td>
					<td>DOK/INT/PKM-TS/005/14</td>
				</tr>
				<tr>
					<td>Revisi</td>
					<td>00</td>
				</tr>
				<tr>
					<td align="center">DAFTAR INDUK DOKUMEN INTERNAL</td>
					<td>Tgl.Dokumen</td>
					<td>11 November 2014</td>
				</tr>
				<tr>
					<td align="center">TAHUN 2015</td>
					<td>Halaman</td>
					<td>1</td>
				</tr>
			</table><br/>
			<p style="font-size:14px; font-weight:bold; margin-top: -10px;"><u>SURAT KETERANGAN KESEHATAN</u><p>
			<p style="font-size:14px; margin-top: -15px;">
				<?php 
					$bulan = date("m");
					if($bulan == "01"){
						$bulans = "I";
					}elseif ($bulan == "02"){
						$bulans = "II";
					}elseif ($bulan == "03"){
						$bulans = "III";
					}elseif ($bulan == "04"){
						$bulans = "IV";
					}elseif ($bulan == "05"){
						$bulans = "V";
					}elseif ($bulan == "06"){
						$bulans = "VI";
					}elseif ($bulan == "07"){
						$bulans = "VII";
					}elseif ($bulan == "08"){
						$bulans = "VIII";
					}elseif ($bulan == "09"){
						$bulans = "IX";
					}elseif ($bulan == "10"){
						$bulans = "X";
					}elseif ($bulan == "11"){
						$bulans = "XI";
					}elseif ($bulan == "12"){
						$bulans = "XII";
					}
					echo "Nomor : 812/".$dtpoliskd['NoSurat']."/TU/PKM-TS/".$bulans."/".$tahun;
				?>
			<p>
			<p align="left" style="font-size:12px; margin-top: 25px;">
			Yang bertanda tangan di bawah ini, <?php echo $dtpoliskd['NamaDokter'];?> dokter Penguji Kesehatan pada Pusat Kesehatan Masyarakat
			Tanjung Selor, pada tanggal <?php echo tgl_lengkap(date("Y-m-d", strtotime($dtpoliskd['TanggalPeriksa'])));?>, telah memeriksa dengan seksama atas pasien :
			<p>
			<table width="100%" style="margin-top: 5px; line-height: 16px;">
				<tr style="border: none">
					<td width="20%" style="border: none">Nama</td>
					<td width="2%" style="border: none">:</td>
					<td width="75%" style="border: none; font-weight: bold;"><span data-nocm="<?php echo $nocm;?>" class="editnamas"><?php echo $dtpasien['NamaPasien'];?></span></td>
				</tr>
				<tr style="border: none">
					<td style="border: none">Tgl.Lahir</td>
					<td style="border: none">:</td>
					<td style="border: none"><?php echo date('d-m-Y', strtotime($dtpasien['TanggalLahir']));?></td>
				</tr>
				<tr style="border: none">
					<td style="border: none">Jenis Kelamin</td>
					<td style="border: none">:</td>
					<td style="border: none"><?php if ($dtpasien['JenisKelamin'] == 'L'){ echo "Laki-laki";}else{echo "Perempuan";}?></td>
				</tr>
				<tr style="border: none">
					<td style="border: none">Agama</td>
					<td style="border: none">:</td>
					<td style="border: none"><?php echo $dtpasien['Agama'];?></td>
				</tr>
				<tr style="border: none">
					<td style="border: none">Pekerjaan</td>
					<td style="border: none">:</td>
					<td style="border: none"><span data-nocm="<?php echo $nocm;?>" class="editpekerjaans"><?php echo $dtpasien['Pekerjaan'];?></span></td>
				</tr>
				<tr style="border: none">
					<td style="border: none">Alamat</td>
					<td style="border: none">:</td>
					<td style="border: none"><span data-nocm="<?php echo $nocm;?>" class="editalamats">
					<?php 
					if($dtkk['RT'] == ''){
						$rt = "-"; 
					}else{
						$rt = $dtkk['RT'];
					}
					echo strtoupper($dtkk['Alamat'])." RT.".$rt.", Kel.".strtoupper($dtkk['Kelurahan']);
					?>
					</span></td>
				</tr>
				<tr style="border: none">
					<td width="20%" style="border: none">Atas Permintaan</td>
					<td width="2%" style="border: none">:</td>
					<td width="75%" style="border: none">Sendiri</td>
				</tr>
				<tr style="border: none">
					<td style="border: none">Dengan Surat</td>
					<td style="border: none">:</td>
					<td style="border: none"></td>
				</tr>
				<tr style="border: none">
					<td style="border: none">Tujuan Untuk</td>
					<td style="border: none">:</td>
					<td style="border: none">
						<?php 
							if($dtpoliskd['TujuanKir'] == '10'){
								echo $dtpoliskd['TujuanKirLainnya'];
							}else{
								if($dtpoliskd['TujuanKir'] == '1'){
									$tujuankir = "Perpanjang Kontrak Kerja";
								}elseif($dtpoliskd['TujuanKir'] == '2'){
									$tujuankir = "Melamar Pekerjaan";
								}elseif($dtpoliskd['TujuanKir'] == '3'){
									$tujuankir = "Mengikuti Tes TNI/POLRI";
								}elseif($dtpoliskd['TujuanKir'] == '4'){
									$tujuankir = "Membuat/Perpanjang SIM";
								}elseif($dtpoliskd['TujuanKir'] == '5'){
									$tujuankir = "Keterangan Catin";
								}elseif($dtpoliskd['TujuanKir'] == '6'){
									$tujuankir = "Melanjutkan Pendidikan";
								}elseif($dtpoliskd['TujuanKir'] == '7'){
									$tujuankir = "Mengikuti Lomba";
								}elseif($dtpoliskd['TujuanKir'] == '8'){
									$tujuankir = "Surat Tanda Registrasi";
								}elseif($dtpoliskd['TujuanKir'] == '9'){
									$tujuankir = "Surat Ijin Usaha";
								}elseif($dtpoliskd['TujuanKir'] == '10'){
									$tujuankir = "Lainnya";
								}
								echo $tujuankir;
							}
							
						?>
					</td>
				</tr>
			</table>
			<br/>
			<p align="left">Berdasarkan hasil pemeriksaan kami meliputi :</p>
			<table width="100%" style="line-height: 16px;">
				<tr style="text-align: center; font-weight: bold;">
					<td width="20%">Tanda Vital</td>
					<td width="25%">Organ Utama</td>
					<td width="15%">Laboratorium</td>
					<td width="25%">Pemeriksaan Lain</td>
					<td width="10%">Ket</td>
				</tr>
				<tr>
					<td valign="top">
					- TD = <?php echo $dtpoliskd['Sistole']." / ".$dtpoliskd['Diastole']." mmHg";?><br/>
					- TB = <?php echo $dtpoliskd['TinggiBadan']." Cm";?><br/>
					- BB = <?php echo $dtpoliskd['BeratBadan']." Kg";?><br/>
					- Nadi = <?php echo $dtpoliskd['DetakNadi']." x/mnt";?><br/>
					- Suhu = <?php echo $dtpoliskd['SuhuTubuh']." C";?><br/>
					- Resp = <?php echo $dtpoliskd['RR']." x/mnt";?><br/>
					</td>
					<td valign="top">
					- Jantung = <?php echo $dtpoliskd['Jantung'];?><br/>
					- Lympa = <?php echo $dtpoliskd['Lympa'];?><br/>
					- Hati = <?php echo $dtpoliskd['Hati'];?><br/>
					- Paru = <?php echo $dtpoliskd['Paru'];?><br/>
					- Saraf = <?php echo $dtpoliskd['Saraf'];?><br/>
					- Kejiwaan = <?php echo $dtpoliskd['Kejiwaan'];?><br/>
					- Visus Mata OD = <?php echo $dtpoliskd['VisusMataOD'];?><br/>
					- Visus Mata OS = <?php echo $dtpoliskd['VisusMataOS'];?><br/>
					<td valign="top"><?php echo $dtpoliskd['PemeriksaanLab'];?></td>
					<td valign="top"><?php echo $dtpoliskd['PemeriksaanLainnya'];?></td>
					<td valign="top"></td>
				</tr>
			</table><br/>
			<p align="left" style="margin-top:-10px;"> Menyimpulkan bahwa pasien tersebut kami nyatakan <span style="font-size: 14px; font-weight: bold;"><?php echo $dtpoliskd['StatusKesehatan'];?></span></p>
			<p align="left" style="margin-top:-10px;"> 
			Surat keterangan ini dibuat untuk melengkapi persyaratan <span style="font-size: 14px; font-weight: bold;">
			<?php
				if($dtpoliskd['TujuanKir'] == '1'){
					$tujuankir = "Perpanjang Kontrak Kerja";
				}elseif($dtpoliskd['TujuanKir'] == '2'){
					$tujuankir = "Melamar Pekerjaan";
				}elseif($dtpoliskd['TujuanKir'] == '3'){
					$tujuankir = "Mengikuti Tes TNI/POLRI";
				}elseif($dtpoliskd['TujuanKir'] == '4'){
					$tujuankir = "Membuat/Perpanjang SIM";
				}elseif($dtpoliskd['TujuanKir'] == '5'){
					$tujuankir = "Keterangan Catin";
				}elseif($dtpoliskd['TujuanKir'] == '6'){
					$tujuankir = "Melanjutkan Pendidikan";
				}elseif($dtpoliskd['TujuanKir'] == '7'){
					$tujuankir = "Mengikuti Lomba";
				}elseif($dtpoliskd['TujuanKir'] == '8'){
					$tujuankir = "Surat Tanda Registrasi";
				}elseif($dtpoliskd['TujuanKir'] == '9'){
					$tujuankir = "Surat Ijin Usaha";
				}elseif($dtpoliskd['TujuanKir'] == '10'){
					$tujuankir = "Lainnya";
				}
				echo $tujuankir;
			?></span><br/>
			Demikian surat keterangan ini kami buat dengan sebenar-benarnya berdasarkan Keilmuan, Etika dan Sumpah Jabatan<br/>
			kami sebagai DOKTER.
			</p><br/>
			<p align="left">KETERANGAN :<br/>
				<?php echo $dtpoliskd['KeteranganTambahan'];?>
			</p>
			<table width="100%" style="text-align: center; margin-top: -30px;">
				<tr style="border: none">
					<td width="30%" style="border: none"></td>
					<td width="30%" style="border: none"></td>
					<td width="40%" style="border: none">
					<?php 
						if($kota = "KABUPATEN BULUNGAN"){
							echo "Tanjung Selor, ".tgl_lengkap(date('Y-m-d', strtotime($dtpoliskd['TanggalPeriksa'])));					
						}elseif(($kota = "KABUPATEN BANDUNG")){
							echo "Soreang, ".tgl_lengkap(date('Y-m-d', strtotime($dtpoliskd['TanggalPeriksa'])));	
						}elseif(($kota = "KOTA BANDUNG")){
							echo "Bandung, ".tgl_lengkap(date('Y-m-d', strtotime($dtpoliskd['TanggalPeriksa'])));	
						}
					?>
					</td>
				</tr>
				<tr style="border: none">
					<td style="border: none"></td>
					<td style="border: none"></td>
					<td style="border: none">Dokter Penguji</td>
				</tr>
				<tr style="border: none">
					<td style="border: none"></td>
					<td style="border: none"></td>
					<td style="border: none">
						<p style="padding-top:80px;"><u>
						<?php echo $dtpoliskd['NamaDokter'];?></u><br/>
						<?php 
							
							echo $dtpegawai['Nip'];
						?></u>
						</p>
					</td>
				</tr>
			</table><br/><br/>
			<p style="font-weight:bold; font-size:14px;">* Surat Keterangan ini Berlaku selama 3 (Tiga) Bulan sejak dikeluarkan</p>
		</center>
	</div><br/>
	</div>
	<a href="javascript:print()" class="btn btn-lg btn-success noprint"style="position: absolute; right: 0px; margin-top: -20px;">Print</a><br/><br/>
<div class="hasilmodal"></div>
<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
		$('.btnmodalpasien').click(function(){
			var nocm = $(this).data('nocm');
			var noregistrasi = $(this).data('noreg');
			// alert(nocm);
			$.post( "get_modal_pasien.php", { no: nocm, noreg: noregistrasi})
			  .done(function( data ) {
				 $( ".hasilmodal" ).html( data );
				 $('#ModalPasien').modal('show');
				 
					$('.datepicker').datepicker({
						format: 'dd-mm-yyyy',
					});
					
					$('.kelurahan').autocomplete({
						serviceUrl: 'get_kelurahan.php',
						onSelect: function (suggestion){
							$(this).val(suggestion.value);
						}
					});
					
			});
		});


	$(".editnamas").dblclick(function(){
		var nama = $(this).text();
		var nocm = $(this).data('nocm');
		$(this).html("<input type='text' class='editform' value='"+nama+"'>");
		$('.editform').focusout(function(){
			var namabaru = $(this).val();
			$.post( "poli_skd_blangko.php?sts=editnama", { nocm:nocm,namabaru:namabaru});
			$(this).parent().html(namabaru);
		});
	});
	$(".editpekerjaans").dblclick(function(){
		var pekerjaan = $(this).text();
		var nocm = $(this).data('nocm');
		$(this).html("<input type='text' class='editform' value='"+pekerjaan+"'>");
		$('.editform').focusout(function(){
			var pekerjaanbaru = $(this).val();
			$.post( "poli_skd_blangko.php?sts=editpekerjaan", { nocm:nocm,pekerjaanbaru:pekerjaanbaru});
			$(this).parent().html(pekerjaanbaru);
		});
	});
	$(".editalamats").dblclick(function(){
		var alamat = $(this).text();
		var nocm = $(this).data('nocm');
		$(this).html("<input type='text' class='editform' value='"+alamat+"'>");
		$('.editform').focusout(function(){
			var alamatbaru = $(this).val();
			$.post( "poli_skd_blangko.php?sts=editalamat", { nocm:nocm,alamatbaru:alamatbaru});
			$(this).parent().html(alamatbaru);
		});
	});
</script>
<?php
}
?>
<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kodepuskesmas = $_GET['kd'];
	$kota = $_SESSION['kota'];
	$kecamatan = $_SESSION['kecamatan'];
	$kelurahan = $_SESSION['kelurahan'];
	$alamat = $_SESSION['alamat'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['op'];
	$pegawai = $_GET['pg'];

	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Kegiatan Harian Tenaga Kesehatan (".$namapuskesmas." ".$bulan." ".$tahun.").xls");
	if(isset($bulan) and isset($tahun)){
?>

<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:-15px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
	display: none;
}
.printheader h4{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printbody{
	margin-left:-10px;
	margin-right:-10px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	display:none;
	margin-top:10px;
}
.bawahtabel{
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font10{
	font-size:10px;
	font-family: "Tahoma";
}
.font11{
	font-size:11px;
	font-family: "Tahoma";
}
.font12{
	font-size:12px;
	font-family: "Tahoma";
}
.font14{
	font-size:14px;
	font-family: "Tahoma";
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

<div class="printheader">
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN KEGIATAN HARIAN TENAGA KESEHATAN</b></h4>
	<p style="margin:1px;">
		<?php if($opsiform == 'bulan'){ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></p>
		<?php }else{ ?>
			<p style="margin:1px;">Periode Laporan:<?php echo date('d-m-Y',strtotime($keydate1))." s/d ".date('d-m-Y',strtotime($keydate2));?></p>
		<?php } ?>
	</p>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px dashed #000;">
					<th rowspan="3">No.</th>
					<th rowspan="3">No.Index</th>
					<th rowspan="3">Nama Pasien</th>
					<th rowspan="3">Umur</th>
					<th colspan="17">Isi salah satu kolom dengan tanda <i class="ace-icon glyphicon glyphicon-ok"></i></th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th rowspan="2">Rawat Jalan TK I</th>
					<th rowspan="2">Konsul Pertama</th>
					<th colspan="2">Tindakan Khusus</th>
					<th colspan="2">Tindakan P3K</th>
					<th rowspan="2">Visit Pasien R.Inap</th>
					<th rowspan="2">Pemulihan Mental/Fisik</th>
					<th colspan="4">Pemeliharaan Kesehatan</th>
					<th rowspan="2">Pelayanan KB</th>
					<th rowspan="2">Pelayanan Imunisasi</th>
					<th rowspan="2">Menerima Konsultasi</th>
					<th rowspan="2">Menguji Kesehatan</th>
					<th rowspan="2">Lain-lain (Visum, Saksi Ahli, dll)</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th>Sederhana</th>
					<th>Sedang</th>
					<th>Sederhana</th>
					<th>Sedang</th>
					<th>KK</th>
					<th>Ibu</th>
					<th>Bayi/Balita</th>
					<th>Anak</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th>1</th>
					<th>2</th>
					<th>3</th>
					<th>4</th>
					<th>5</th>
					<th>6</th>
					<th>7</th>
					<th>8</th>
					<th>9</th>
					<th>10</th>
					<th>11</th>
					<th>12</th>
					<th>13</th>
					<th>14</th>
					<th>15</th>
					<th>16</th>
					<th>17</th>
					<th>18</th>
					<th>19</th>
					<th>20</th>
					<th>21</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
				if ($tahun == $tahunini){
					$tbpasienrj = $tbpasienrj;
				}else{
					$tbpasienrj = 'tbpasienrj_'.str_replace(' ', '', $namapuskesmas)."_RETENSI";
				}

				if($opsiform == 'bulan'){
					$waktu = "YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan'";
					$tbpasienperpegawai = 'tbpasienperpegawai_'.$kodepuskesmas;
				}else{
					$waktu = "TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2'";
					$tbpasienperpegawai = 'tbpasienperpegawai_'.$kodepuskesmas;
				}
				
				$str = "SELECT * FROM `$tbpasienperpegawai` WHERE $waktu AND (`Pendaftaran`='$pegawai' 
				OR `NamaPegawai1`='$pegawai'
				OR `NamaPegawai2`='$pegawai'
				OR `NamaPegawai3`='$pegawai'
				OR `NamaPegawai4`='$pegawai'
				OR `NamaPegawai5`='$pegawai'
				OR `Lab`='$pegawai'
				OR `Farmasi`='$pegawai')";
				$str2 = $str." order by Tanggalregistrasi, NoRegistrasi";
				// echo $str2;
				// die();
								
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noregistrasi = $data['NoRegistrasi'];
					// $tbpasienrj
					$data_rj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$data[NoRegistrasi]'"));
					$noindex = $data_rj['NoIndex'];
				?>
					<tr style="border:1px dashed #000;">
						<td><?php echo $no;?></td>
						<td><?php echo substr($noindex,-10);?></td>
						<td><?php echo $data_rj['NamaPasien'];?></td>
						<td><?php echo $data_rj['UmurTahun'];?></td>
						<td><?php if ($data_rj['JenisKunjungan'] == '1'){echo "Ya"; }else{echo "Tidak";}?></td>
						<td><?php echo $data_rj['PoliPertama'];?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>
							<?php 
								if ($data_rj['JenisKelamin'] == 'L'){
									if ($data_rj['UmurTahun'] >= '17'){
										echo "Ya";
									}else{
										echo "-";
									}
									?>
							<?php
								}else{
									echo "-";
								}
							?>
						</td>
						<td>
							<?php 
								if ($data_rj['JenisKelamin'] == 'P'){
									if ($data_rj['UmurTahun'] >= '17'){
										echo "Ya";
									}else{
										echo "-";
									}
									?>
							<?php
								}else{
									echo "-";
								}
							?>
						</td>
						<td>
							<?php 
								if ($data_rj['UmurTahun'] <= '5'){ 
									echo "Ya";
								}else{
									echo "-";
								}
							?>
						</td>
						<td>
							<?php 
								if ($data_rj['UmurTahun'] >= '6' AND $data_rj['UmurTahun'] <= '16'){
									echo "Ya";
								}else{
									echo "-";
								}
							?>
						</td>
						<td><?php echo $umur1830hrL['Jml'];?></td>
						<td><?php echo $umur1830hrL['Jml'];?></td>
						<td><?php echo $umur1830hrL['Jml'];?></td>
						<td><?php echo $umur1830hrL['Jml'];?></td>
						<td><?php echo $umur1830hrL['Jml'];?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
}
?>
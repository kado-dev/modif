<?php
	// error_reporting(1);
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	include_once('config/koneksi.php');
	
	$hariini = date('d-m-Y');
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$tbwaktupelayanan = "tbwaktupelayanan_".$kodepuskesmas;
	
	// get
	$tanggal = $_GET['tanggal'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Waktu Pelayanan (".$hariini.").xls");
	if(isset($tanggal)){
?>
<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
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
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN WAKTU PELAYANAN DAN TUNGGU</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $tanggal;?></p></p><br/>
</div>

<div class="atastabel font14">
	<div style="float:left; width:35%; margin-bottom:10px;">	
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kelurahan/Desa</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".strtoupper($kelurahan);?></h5></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kecamatan</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".strtoupper($kecamatan);?></h5></td>
			</tr>
		</table>
	</div>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
		<thead>
			<tr>
				<th rowspan="2" width="3%">NO</th>
				<th rowspan="2" width="14%">NAMA PASIEN</th>
				<th rowspan="2" width="7%">PELAYANAN</th>
				<th colspan="3" width="20%">PENDAFTARAN</th>
				<th colspan="2" width="10%">PEMERIKSAAN</th>
				<th colspan="2" width="10%">FARMASI</th>
				<th colspan="3" width="18%">HASIL WAKTU PELAYANAN</th>
				<th colspan="3" width="18%">HASIL WAKTU TUNGGU</th>
			</tr>
			<tr>
				<th>AMBIL ANTRIAN</th>
				<th>PANGGIL PENDAFTARAN</th>
				<th>SELESAI PENDAFTARAN</th>
				<th>PANGGIL PEMERIKSAAN</th>
				<th>SELESAI PEMERIKSAAN</th>
				<th>PENERIMAAN OBAT</th>
				<th>PEMBERIAN OBAT</th>
				<th>PENDAFTARAN</th>
				<th>PEMERIKSAAN</th>
				<th>FARMASI</th>
				<th>PENDAFTARAN</th>
				<th>PEMERIKSAAN</th>
				<th>FARMASI</th>
			</tr>
		</thead>
		<tbody style="font-size:11px;">
			<?php
			
			if($tanggal != null){
				$tgl_str = " WHERE DATE(PanggilAntrian) = '$tanggal'";
			}else{
				$tgl_str = " WHERE DATE(PanggilAntrian) = DATE(CURDATE())";
			}

			$str = "SELECT * FROM `$tbwaktupelayanan`".$tgl_str;
			$str2 = $str." GROUP BY `NoRegistrasi` ORDER BY `AmbilAntrian` ASC";
			// echo $str2;
						
			$query = mysqli_query($koneksi,$str2);
			while ($data = mysqli_fetch_assoc($query)) {
			$no = $no + 1;		
			?>
			<tr>
				<td><?php echo $no;?></td>
				<td><?php echo $data['NamaPasien'];?></td>
				<td align="center">
				<?php
					$dtlayanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `KodePelayanan` FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Pelayanan`='$data[PoliPertama]'"));
					echo $data['PoliPertama']." - ".$dtlayanan['KodePelayanan'].$data['NomorAntrianPoli'];
					?>
				</td>
				<td align="center"><?php echo date('H:i:s',strtotime($data['AmbilAntrian']));?></td>
				<td align="center"><?php echo date('H:i:s',strtotime($data['PanggilAntrian']));?></td>
				<td align="center"><?php echo date('H:i:s',strtotime($data['SelesaiPendaftaran']));?></td>
				<td align="center"><?php echo date('H:i:s',strtotime($data['PemeriksaanAwal']));?></td>
				<td align="center"><?php echo date('H:i:s',strtotime($data['PemeriksaanAkhir']));?></td>
				<td align="center"><?php echo date('H:i:s',strtotime($data['FarmasiAwal']));?></td>
				<td align="center"><?php echo date('H:i:s',strtotime($data['FarmasiAkhir']));?></td>
				<td align="right"><?php echo hitung_menit($data['PanggilAntrian'],$data['SelesaiPendaftaran']);?></td>
				<td align="right"><?php echo hitung_menit($data['PemeriksaanAwal'],$data['PemeriksaanAkhir']);?></td>
				<td align="right"><?php echo hitung_menit($data['FarmasiAwal'],$data['FarmasiAkhir']);?></td>
				<td align="right"><?php echo hitung_menit($data['AmbilAntrian'],$data['SelesaiPendaftaran']);?></td>
				<td align="right"><?php echo hitung_menit($data['SelesaiPendaftaran'],$data['PemeriksaanAkhir']);?></td>
				<td align="right"><?php echo hitung_menit($data['PemeriksaanAkhir'],$data['FarmasiAkhir']);?></td>
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
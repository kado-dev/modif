<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$kota = $_SESSION['kota'];
	$id = $_GET['id'];
	$nf = $_GET['nf'];
	$tahun = date('Y');
	
	// tbgfkpengeluaran
	$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkpengeluaran` WHERE `NoFaktur`='$nf'"));
	
	// tb_user_profil_sbbk
	$dtsbbk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tb_user_profil_sbbk` WHERE `Periode`='3'"));
	
	// tb_user_profil_sbbk_penerima
	$dtpenerima = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tb_user_profil_sbbk_penerima` WHERE `NamaPegawai`='$dtpengeluaran[PetugasPenerima]'"));
?>
<link href="https://fonts.googleapis.com/css?family=Gelasio&display=swap" rel="stylesheet">
<style type="text/css">

body{
	font-size: 16px;
	font-family: 'Gelasio', serif;	
	padding:50px;
}

.page-content {
    background-color: transparent;
}	

@media print{
	body{
		padding:20px;
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

<body onload="window.print()" onafterprint="document.location = 'index.php?page=gudang_besar_pengeluaran_lihat_manual&id=<?php echo $id;?>&nf=<?php echo $nf;?>'">
<div class="body">
	<img src="image/bekasikab.png" class="logokab" style="width:110px; margin: 0px 0px -90px 0px;">
	<center>
	<div class="printheader" style="margin-top: -15px;">
		<span style="font-size: 18px;" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br/>
		<span style="font-size: 28px;" style="margin:5px;"><b>UPTD FARMASI</b></span><br/>
		<span style="font-size: 14px; margin:5px;"><?php echo substr($alamat,0,62);?></span><br/>
		<span style="font-size: 14px; margin:5px;">Kabupaten Bekasi, 17510 Jawa Barat</span><br/>
		<span style="font-size: 14px; margin:5px;"><b>e-mail : laporangudangtambun@gmail.com Telp. </b><?php echo $telepon?></span>
		<hr style="margin:10px 5px 5px 5px; border:2px solid #000">
	</div>
	<br/>
		<p style="font-size:18px; font-weight:bold; margin-top: -10px;">
		BERITA ACARA SERAH TERIMA<br/>
		OBAT DAN PERBEKALAN KESEHATAN<br/>
		<span style="font-size:14px; margin-top: -10px;">Nomor : <?php echo $dtpengeluaran['NoFakturManual'];?></span>
		</p>
		
		<p align="left" style="margin-top: 25px;">
		Pada hari ini <?php echo hari_ini_val(date("D", strtotime($dtpengeluaran['TanggalPengeluaran'])));?> Tanggal <b><?php echo penyebut(date("d", strtotime($dtpengeluaran['TanggalPengeluaran'])));?></b> Bulan <b><?php echo nama_bulan(date("m", strtotime($dtpengeluaran['TanggalPengeluaran'])));?></b> Tahun <b><?php echo penyebut(date("Y", strtotime($dtpengeluaran['TanggalPengeluaran'])));?></b> kami yang bertanda tangan di bawah ini :
		<p>
		<table width="100%" style="margin-top: 5px; line-height: 16px;">
			<tr style="border: none">
				<td width="20%" style="border: none">Nama</td>
				<td width="2%" style="border: none">:</td>
				<td width="75%" style="border: none; font-weight: bold;"><?php echo $dtsbbk['nama_pemberi'];?></span></td>
			</tr>
			<tr style="border: none">
				<td style="border: none">NIP</td>
				<td style="border: none">:</td>
				<td style="border: none"><?php echo $dtsbbk['nip_pemberi'];?></td>
			</tr>
			<tr style="border: none">
				<td style="border: none">Jabatan</td>
				<td style="border: none">:</td>
				<td style="border: none"><?php echo $dtsbbk['jabatan_pemberi'];?></td>
			</tr>
			<tr style="border: none">
				<td style="border: none">Instansi</td>
				<td style="border: none">:</td>
				<td style="border: none">UPTD Farmasi</td>
			</tr>
		</table>
		<p align="left">Dengan ini menyatakan telah melaksanakan serah terima Obat dan Perbekalan Kesehatan sesuai yang tercantum dalam Laporan Pemakaian dan Permintaan Obat (LPLPO) atau Permintaan Obat Program Pemerintah Bulan <?php echo nama_bulan(date("m", strtotime($dtpengeluaran['TanggalPengeluaran'])));?> Tahun <?php echo date("Y", strtotime($dtpengeluaran['TanggalPengeluaran']));?> kepada :</p>
		<table width="100%" style="margin-top: 5px; line-height: 16px;">
			<tr style="border: none">
				<td width="20%" style="border: none">Nama</td>
				<td width="2%" style="border: none">:</td>
				<td width="75%" style="border: none; font-weight: bold;"><?php echo $dtpengeluaran['PetugasPenerima'];?></span></td>
			</tr>
			<tr style="border: none">
				<td style="border: none">NIP</td>
				<td style="border: none">:</td>
				<td style="border: none"><?php echo $dtpenerima['Nip'];?></td>
			</tr>
			<tr style="border: none">
				<td style="border: none">Jabatan</td>
				<td style="border: none">:</td>
				<td style="border: none"><?php echo $dtpenerima['Jabatan'];?></td>
			</tr>
			<tr style="border: none">
				<td style="border: none">Puskesmas / Rumah Sakit</td>
				<td style="border: none">:</td>
				<td style="border: none"><?php echo $dtpengeluaran['Penerima'];?></td>
			</tr>
		</table><br/>
		<p align="left" style="margin-top:-10px;">Serah terima berdasar Surat Bukti Barang Keluar (SBBK) dari Dinas Kesehatan Kabupaten Bekasi (terlampir).</p>
		<p align="left" style="margin-top:-10px;">Demikian Berita Acara Serah Terima ini dibuat dengan sebenarnya sebanyak tiga (3) rangkap, untuk dipergunakan sebagaimana mestinya.</p>
		<br/>
		<div class="bawahtabel font10">
			<table width="100%">
				<tr>
					<td style="text-align:center;">
					Yang Menerima,<br/>
					<br>
					<br>
					<br>
					<br>
					<br>
					<u><?php echo $dtpengeluaran['PetugasPenerima'];?><br/></u>
					<?php echo $dtpenerima['Nip'];?>
					</td>			
					
					<td width="10%"></td>
					<td style="text-align:center;">
					Yang Menyerahkan,<br/>
					<?php echo strtoupper($dtsbbk['jabatan_pemberi']);?>
					<br>
					<br>
					<br>
					<br>
					<br>
					<u><?php echo $dtsbbk['nama_pemberi'];?><br/></u>
					<?php echo $dtsbbk['nip_pemberi'];?>
					</td>
				</tr>
				<tr>
					<td width="10%" colspan="3" align="center" style="padding-top: 20px;">
						Mengetahui,<br/>
						<?php echo strtoupper($dtsbbk['jabatan_kasie']);?>
						<br>
						<br>
						<br>
						<br>
						<br>
						<u><?php echo $dtsbbk['nama_kasie'];?><br/></u>
						<?php echo $dtsbbk['nip_kasie'];?>
					</td>
				</tr>
			</table>
		</div>
	</center>
</div>
</body>
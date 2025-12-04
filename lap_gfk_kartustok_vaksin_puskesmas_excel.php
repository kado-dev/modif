<?php
	session_start();
	error_reporting(0);
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_pasienrj.php');
	
	// get
	$hariini = date('d-m-Y');
	$key = $_GET['key'];
	$tahun = 2021;
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Kartu_Stok_Vaksin (".$hariini.").xls");	
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
	<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
	<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN KARTU STOK VAKSIN</b></span><br>
	<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($hariini));?></span>
</div><br/>

<div class="row ">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table table-condensed" border="1">
				<thead>
					<tr>
						<th width="3%">NO.</th>
						<th width="6%">KODE</th>
						<th width="25%">NAMA BARANG</th>
						<th width="8%">STOK AWAL</th>
						<th width="8%">PENERIMAAN</th>
						<th width="8%">PENGELUARAN</th>
						<th width="8%">SISA STOK</th>
						<th width="8%">HARGA SATUAN</th>
						<th width="12%">SALDO</th>
						<!--<th width="5%">Opsi</th>-->
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 0;				
				$str = "SELECT * FROM `tbgudangpkmvaksinstok` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%') AND `KodePuskesmas`='$kodepuskesmas'";	
				$str2 = $str." GROUP BY `KodeBarang` ORDER BY `IdBarangGdgPkm` DESC";	
				// echo $str2;
				
				$query = mysqli_query($koneksi, $str2);	
				while($dtobat=mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$nomorpembukuan = $dtobat['NoFakturTerima'];
					$kodebarang = $dtobat['KodeBarang'];
					$namaobat = $dtobat['NamaBarang'];
					$nobatch = $dtobat['NoBatch'];
					$stok = $dtobat['Stok'];
					$harga = $dtobat['HargaBeli'];
					
					// tbstokopnam_puskesmas_bogorkab
					$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokopnam_puskesmas_bogorkab` WHERE `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
																	
					// tahap1, stok awal ini ngambil tbstokopnam_puskesmas_bogorkab
					$stokawal = $dtstokopname['StokAwalApbd'] + $dtstokopname['StokAwalJkn'];
					if ($stokawal != null){
						$stokawal = $stokawal;
					}else{
						$stokawal = '0';
					}
					$stokawal_total = $stokawal;
					$stokawal_rupiah = $stokawal_total * $harga;
					
					// tahap2, panggil tanggal terima
					$str_penerimaan = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluarandetail` a JOIN `tbgfk_vaksin_pengeluaran` b
					ON a.NoFaktur = b.NoFaktur
					WHERE a.`KodeBarang`='$kodebarang' AND b.`KodePenerima`='$kodepuskesmas'";
					$dt_penerimaan_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_penerimaan));
					if ($dt_penerimaan_dtl['Jumlah'] != null){
						$penerimaan = $dt_penerimaan_dtl['Jumlah'];
					}else{
						$penerimaan = '0';
					}
					
					// tahap3, pengeluaran detail
					// $str_pengeluaran = "SELECT SUM(Jumlah) AS Jml FROM `tbgfk_vaksin_pengeluarandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nomorpembukuan'";
					// $dt_pengeluaran_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran));
					// if ($dt_pengeluaran_dtl['Jml'] != null){
						// $pengeluaran = $dt_pengeluaran_dtl['Jml'];
					// }else{
						// $pengeluaran = '0';
					// }
					
					// tahap 4, pengeluaran 
					$penerimaan_apbd_01 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='01' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_02 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='02' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_03 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='03' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_04 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='04' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_05 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='05' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_06 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='06' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_07 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='07' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_08 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='08' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_09 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='09' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='10' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='11' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='12' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					
					// jika januari rumusnya stok awal (des 2020) + penerimaan (jan 2021) - sisa stok (jan 2021)
					$bln_pengeluaran_apbd_01 = $dtstokopname['StokAwalApbd'] + $penerimaan_apbd_01['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_01'] - $dtstokopname['Sisastok_Depot_Apbd_01'] - $dtstokopname['Sisastok_Igd_Apbd_01'] - $dtstokopname['Sisastok_Ranap_Apbd_01'] - $dtstokopname['Sisastok_Poned_Apbd_01'] - $dtstokopname['Sisastok_Pustu_Apbd_01'] - $dtstokopname['Sisastok_Pusling_Apbd_01'] - $dtstokopname['Sisastok_Poli_Apbd_01'] - $dtstokopname['Sisastok_Lainnya_Apbd_01'];
					$bln_pengeluaran_jkn_01 = $dtstokopname['StokAwalJkn'] + $dtstokopname['PenerimaanJkn_01'] - $dtstokopname['Sisastok_Gudang_Jkn_01'] - $dtstokopname['Sisastok_Depot_Jkn_01'] - $dtstokopname['Sisastok_Igd_Jkn_01'] - $dtstokopname['Sisastok_Ranap_Jkn_01'] - $dtstokopname['Sisastok_Poned_Jkn_01'] - $dtstokopname['Sisastok_Pustu_Jkn_01'] - $dtstokopname['Sisastok_Pusling_Jkn_01'] - $dtstokopname['Sisastok_Poli_Jkn_01'] - $dtstokopname['Sisastok_Lainnya_Jkn_01'];
					$bln_pengeluaran_01 = $bln_pengeluaran_apbd_01 + $bln_pengeluaran_jkn_01;
					
					// jika februari s/d desember (2021) rumusnya, sisa stok bulan sebelumnya (jan 2021) + penerimaan (bulan berjalan) - sisa stok (bulan berjalan)
					$bln_pengeluaran_apbd_02 = $dtstokopname['Sisastok_Gudang_Apbd_01'] + $penerimaan_apbd_02['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_02'] - $dtstokopname['Sisastok_Depot_Apbd_02'] - $dtstokopname['Sisastok_Igd_Apbd_02'] - $dtstokopname['Sisastok_Ranap_Apbd_02'] - $dtstokopname['Sisastok_Poned_Apbd_02'] - $dtstokopname['Sisastok_Pustu_Apbd_02'] - $dtstokopname['Sisastok_Pusling_Apbd_02'] - $dtstokopname['Sisastok_Poli_Apbd_02'] - $dtstokopname['Sisastok_Lainnya_Apbd_02'];
					$bln_pengeluaran_jkn_02 = $dtstokopname['Sisastok_Gudang_Jkn_01'] + $dtstokopname['PenerimaanJkn_02'] - $dtstokopname['Sisastok_Gudang_Jkn_02'] - $dtstokopname['Sisastok_Depot_Jkn_02'] - $dtstokopname['Sisastok_Igd_Jkn_02'] - $dtstokopname['Sisastok_Ranap_Jkn_02'] - $dtstokopname['Sisastok_Poned_Jkn_02'] - $dtstokopname['Sisastok_Pustu_Jkn_02'] - $dtstokopname['Sisastok_Pusling_Jkn_02'] - $dtstokopname['Sisastok_Poli_Jkn_02'] - $dtstokopname['Sisastok_Lainnya_Jkn_02'];
					$bln_pengeluaran_02 = $bln_pengeluaran_apbd_02 + $bln_pengeluaran_jkn_02;
					
					$bln_pengeluaran_apbd_03 = $dtstokopname['Sisastok_Gudang_Apbd_02'] + $penerimaan_apbd_03['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_03'] - $dtstokopname['Sisastok_Depot_Apbd_03'] - $dtstokopname['Sisastok_Igd_Apbd_03'] - $dtstokopname['Sisastok_Ranap_Apbd_03'] - $dtstokopname['Sisastok_Poned_Apbd_03'] - $dtstokopname['Sisastok_Pustu_Apbd_03'] - $dtstokopname['Sisastok_Pusling_Apbd_03'] - $dtstokopname['Sisastok_Poli_Apbd_03'] - $dtstokopname['Sisastok_Lainnya_Apbd_03'];
					$bln_pengeluaran_jkn_03 = $dtstokopname['Sisastok_Gudang_Jkn_02'] + $dtstokopname['PenerimaanJkn_03'] - $dtstokopname['Sisastok_Gudang_Jkn_03'] - $dtstokopname['Sisastok_Depot_Jkn_03'] - $dtstokopname['Sisastok_Igd_Jkn_03'] - $dtstokopname['Sisastok_Ranap_Jkn_03'] - $dtstokopname['Sisastok_Poned_Jkn_03'] - $dtstokopname['Sisastok_Pustu_Jkn_03'] - $dtstokopname['Sisastok_Pusling_Jkn_03'] - $dtstokopname['Sisastok_Poli_Jkn_03'] - $dtstokopname['Sisastok_Lainnya_Jkn_03'];
					$bln_pengeluaran_03 = $bln_pengeluaran_apbd_03 + $bln_pengeluaran_jkn_03;
					
					$bln_pengeluaran_apbd_04 = $dtstokopname['Sisastok_Gudang_Apbd_03'] + $penerimaan_apbd_04['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_04'] - $dtstokopname['Sisastok_Depot_Apbd_04'] - $dtstokopname['Sisastok_Igd_Apbd_04'] - $dtstokopname['Sisastok_Ranap_Apbd_04'] - $dtstokopname['Sisastok_Poned_Apbd_04'] - $dtstokopname['Sisastok_Pustu_Apbd_04'] - $dtstokopname['Sisastok_Pusling_Apbd_04'] - $dtstokopname['Sisastok_Poli_Apbd_04'] - $dtstokopname['Sisastok_Lainnya_Apbd_04'];
					$bln_pengeluaran_jkn_04 = $dtstokopname['Sisastok_Gudang_Jkn_03'] + $dtstokopname['PenerimaanJkn_04'] - $dtstokopname['Sisastok_Gudang_Jkn_04'] - $dtstokopname['Sisastok_Depot_Jkn_04'] - $dtstokopname['Sisastok_Igd_Jkn_04'] - $dtstokopname['Sisastok_Ranap_Jkn_04'] - $dtstokopname['Sisastok_Poned_Jkn_04'] - $dtstokopname['Sisastok_Pustu_Jkn_04'] - $dtstokopname['Sisastok_Pusling_Jkn_04'] - $dtstokopname['Sisastok_Poli_Jkn_04'] - $dtstokopname['Sisastok_Lainnya_Jkn_04'];
					$bln_pengeluaran_04 = $bln_pengeluaran_apbd_04 + $bln_pengeluaran_jkn_04;
					
					$bln_pengeluaran_apbd_05 = $dtstokopname['Sisastok_Gudang_Apbd_04'] + $penerimaan_apbd_05['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_05'] - $dtstokopname['Sisastok_Depot_Apbd_05'] - $dtstokopname['Sisastok_Igd_Apbd_05'] - $dtstokopname['Sisastok_Ranap_Apbd_05'] - $dtstokopname['Sisastok_Poned_Apbd_05'] - $dtstokopname['Sisastok_Pustu_Apbd_05'] - $dtstokopname['Sisastok_Pusling_Apbd_05'] - $dtstokopname['Sisastok_Poli_Apbd_05'] - $dtstokopname['Sisastok_Lainnya_Apbd_05'];
					$bln_pengeluaran_jkn_05 = $dtstokopname['Sisastok_Gudang_Jkn_04'] + $dtstokopname['PenerimaanJkn_05'] - $dtstokopname['Sisastok_Gudang_Jkn_05'] - $dtstokopname['Sisastok_Depot_Jkn_05'] - $dtstokopname['Sisastok_Igd_Jkn_05'] - $dtstokopname['Sisastok_Ranap_Jkn_05'] - $dtstokopname['Sisastok_Poned_Jkn_05'] - $dtstokopname['Sisastok_Pustu_Jkn_05'] - $dtstokopname['Sisastok_Pusling_Jkn_05'] - $dtstokopname['Sisastok_Poli_Jkn_05'] - $dtstokopname['Sisastok_Lainnya_Jkn_05'];
					$bln_pengeluaran_05 = $bln_pengeluaran_apbd_05 + $bln_pengeluaran_jkn_05;
					
					$bln_pengeluaran_apbd_06 = $dtstokopname['Sisastok_Gudang_Apbd_05'] + $penerimaan_apbd_06['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_06'] - $dtstokopname['Sisastok_Depot_Apbd_06'] - $dtstokopname['Sisastok_Igd_Apbd_06'] - $dtstokopname['Sisastok_Ranap_Apbd_06'] - $dtstokopname['Sisastok_Poned_Apbd_06'] - $dtstokopname['Sisastok_Pustu_Apbd_06'] - $dtstokopname['Sisastok_Pusling_Apbd_06'] - $dtstokopname['Sisastok_Poli_Apbd_06'] - $dtstokopname['Sisastok_Lainnya_Apbd_06'];
					$bln_pengeluaran_jkn_06 = $dtstokopname['Sisastok_Gudang_Jkn_05'] + $dtstokopname['PenerimaanJkn_06'] - $dtstokopname['Sisastok_Gudang_Jkn_06'] - $dtstokopname['Sisastok_Depot_Jkn_06'] - $dtstokopname['Sisastok_Igd_Jkn_06'] - $dtstokopname['Sisastok_Ranap_Jkn_06'] - $dtstokopname['Sisastok_Poned_Jkn_06'] - $dtstokopname['Sisastok_Pustu_Jkn_06'] - $dtstokopname['Sisastok_Pusling_Jkn_06'] - $dtstokopname['Sisastok_Poli_Jkn_06'] - $dtstokopname['Sisastok_Lainnya_Jkn_06'];
					$bln_pengeluaran_06 = $bln_pengeluaran_apbd_06 + $bln_pengeluaran_jkn_06;
					
					$bln_pengeluaran_apbd_07 = $dtstokopname['Sisastok_Gudang_Apbd_06'] + $penerimaan_apbd_07['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_07'] - $dtstokopname['Sisastok_Depot_Apbd_07'] - $dtstokopname['Sisastok_Igd_Apbd_07'] - $dtstokopname['Sisastok_Ranap_Apbd_07'] - $dtstokopname['Sisastok_Poned_Apbd_07'] - $dtstokopname['Sisastok_Pustu_Apbd_07'] - $dtstokopname['Sisastok_Pusling_Apbd_07'] - $dtstokopname['Sisastok_Poli_Apbd_07'] - $dtstokopname['Sisastok_Lainnya_Apbd_07'];
					$bln_pengeluaran_jkn_07 = $dtstokopname['Sisastok_Gudang_Jkn_06'] + $dtstokopname['PenerimaanJkn_07'] - $dtstokopname['Sisastok_Gudang_Jkn_07'] - $dtstokopname['Sisastok_Depot_Jkn_07'] - $dtstokopname['Sisastok_Igd_Jkn_07'] - $dtstokopname['Sisastok_Ranap_Jkn_07'] - $dtstokopname['Sisastok_Poned_Jkn_07'] - $dtstokopname['Sisastok_Pustu_Jkn_07'] - $dtstokopname['Sisastok_Pusling_Jkn_07'] - $dtstokopname['Sisastok_Poli_Jkn_07'] - $dtstokopname['Sisastok_Lainnya_Jkn_07'];
					$bln_pengeluaran_07 = $bln_pengeluaran_apbd_07 + $bln_pengeluaran_jkn_07;
					
					$bln_pengeluaran_apbd_08 = $dtstokopname['Sisastok_Gudang_Apbd_07'] + $penerimaan_apbd_08['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_08'] - $dtstokopname['Sisastok_Depot_Apbd_08'] - $dtstokopname['Sisastok_Igd_Apbd_08'] - $dtstokopname['Sisastok_Ranap_Apbd_08'] - $dtstokopname['Sisastok_Poned_Apbd_08'] - $dtstokopname['Sisastok_Pustu_Apbd_08'] - $dtstokopname['Sisastok_Pusling_Apbd_08'] - $dtstokopname['Sisastok_Poli_Apbd_08'] - $dtstokopname['Sisastok_Lainnya_Apbd_08'];
					$bln_pengeluaran_jkn_08 = $dtstokopname['Sisastok_Gudang_Jkn_07'] + $dtstokopname['PenerimaanJkn_08'] - $dtstokopname['Sisastok_Gudang_Jkn_08'] - $dtstokopname['Sisastok_Depot_Jkn_08'] - $dtstokopname['Sisastok_Igd_Jkn_08'] - $dtstokopname['Sisastok_Ranap_Jkn_08'] - $dtstokopname['Sisastok_Poned_Jkn_08'] - $dtstokopname['Sisastok_Pustu_Jkn_08'] - $dtstokopname['Sisastok_Pusling_Jkn_08'] - $dtstokopname['Sisastok_Poli_Jkn_08'] - $dtstokopname['Sisastok_Lainnya_Jkn_08'];
					$bln_pengeluaran_08 = $bln_pengeluaran_apbd_08 + $bln_pengeluaran_jkn_08;
					
					$bln_pengeluaran_apbd_09 = $dtstokopname['Sisastok_Gudang_Apbd_08'] + $penerimaan_apbd_09['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_09'] - $dtstokopname['Sisastok_Depot_Apbd_09'] - $dtstokopname['Sisastok_Igd_Apbd_09'] - $dtstokopname['Sisastok_Ranap_Apbd_09'] - $dtstokopname['Sisastok_Poned_Apbd_09'] - $dtstokopname['Sisastok_Pustu_Apbd_09'] - $dtstokopname['Sisastok_Pusling_Apbd_09'] - $dtstokopname['Sisastok_Poli_Apbd_09'] - $dtstokopname['Sisastok_Lainnya_Apbd_09'];
					$bln_pengeluaran_jkn_09 = $dtstokopname['Sisastok_Gudang_Jkn_08'] + $dtstokopname['PenerimaanJkn_09'] - $dtstokopname['Sisastok_Gudang_Jkn_09'] - $dtstokopname['Sisastok_Depot_Jkn_09'] - $dtstokopname['Sisastok_Igd_Jkn_09'] - $dtstokopname['Sisastok_Ranap_Jkn_09'] - $dtstokopname['Sisastok_Poned_Jkn_09'] - $dtstokopname['Sisastok_Pustu_Jkn_09'] - $dtstokopname['Sisastok_Pusling_Jkn_09'] - $dtstokopname['Sisastok_Poli_Jkn_09'] - $dtstokopname['Sisastok_Lainnya_Jkn_09'];
					$bln_pengeluaran_09 = $bln_pengeluaran_apbd_09 + $bln_pengeluaran_jkn_09;
					
					$bln_pengeluaran_apbd_10 = $dtstokopname['Sisastok_Gudang_Apbd_09'] + $penerimaan_apbd_10['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_10'] - $dtstokopname['Sisastok_Depot_Apbd_10'] - $dtstokopname['Sisastok_Igd_Apbd_10'] - $dtstokopname['Sisastok_Ranap_Apbd_10'] - $dtstokopname['Sisastok_Poned_Apbd_10'] - $dtstokopname['Sisastok_Pustu_Apbd_10'] - $dtstokopname['Sisastok_Pusling_Apbd_10'] - $dtstokopname['Sisastok_Poli_Apbd_10'] - $dtstokopname['Sisastok_Lainnya_Apbd_10'];
					$bln_pengeluaran_jkn_10 = $dtstokopname['Sisastok_Gudang_Jkn_09'] + $dtstokopname['PenerimaanJkn_10'] - $dtstokopname['Sisastok_Gudang_Jkn_10'] - $dtstokopname['Sisastok_Depot_Jkn_10'] - $dtstokopname['Sisastok_Igd_Jkn_10'] - $dtstokopname['Sisastok_Ranap_Jkn_10'] - $dtstokopname['Sisastok_Poned_Jkn_10'] - $dtstokopname['Sisastok_Pustu_Jkn_10'] - $dtstokopname['Sisastok_Pusling_Jkn_10'] - $dtstokopname['Sisastok_Poli_Jkn_10'] - $dtstokopname['Sisastok_Lainnya_Jkn_10'];
					$bln_pengeluaran_10 = $bln_pengeluaran_apbd_10 + $bln_pengeluaran_jkn_10;
					
					$bln_pengeluaran_apbd_11 = $dtstokopname['Sisastok_Gudang_Apbd_10'] + $penerimaan_apbd_11['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_11'] - $dtstokopname['Sisastok_Depot_Apbd_11'] - $dtstokopname['Sisastok_Igd_Apbd_11'] - $dtstokopname['Sisastok_Ranap_Apbd_11'] - $dtstokopname['Sisastok_Poned_Apbd_11'] - $dtstokopname['Sisastok_Pustu_Apbd_11'] - $dtstokopname['Sisastok_Pusling_Apbd_11'] - $dtstokopname['Sisastok_Poli_Apbd_11'] - $dtstokopname['Sisastok_Lainnya_Apbd_11'];
					$bln_pengeluaran_jkn_11 = $dtstokopname['Sisastok_Gudang_Jkn_10'] + $dtstokopname['PenerimaanJkn_11'] - $dtstokopname['Sisastok_Gudang_Jkn_11'] - $dtstokopname['Sisastok_Depot_Jkn_11'] - $dtstokopname['Sisastok_Igd_Jkn_11'] - $dtstokopname['Sisastok_Ranap_Jkn_11'] - $dtstokopname['Sisastok_Poned_Jkn_11'] - $dtstokopname['Sisastok_Pustu_Jkn_11'] - $dtstokopname['Sisastok_Pusling_Jkn_11'] - $dtstokopname['Sisastok_Poli_Jkn_11'] - $dtstokopname['Sisastok_Lainnya_Jkn_11'];
					$bln_pengeluaran_11 = $bln_pengeluaran_apbd_11 + $bln_pengeluaran_jkn_11;
					
					$bln_pengeluaran_apbd_12 = $dtstokopname['Sisastok_Gudang_Apbd_11'] + $penerimaan_apbd_12['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_12'] - $dtstokopname['Sisastok_Depot_Apbd_12'] - $dtstokopname['Sisastok_Igd_Apbd_12'] - $dtstokopname['Sisastok_Ranap_Apbd_12'] - $dtstokopname['Sisastok_Poned_Apbd_12'] - $dtstokopname['Sisastok_Pustu_Apbd_12'] - $dtstokopname['Sisastok_Pusling_Apbd_12'] - $dtstokopname['Sisastok_Poli_Apbd_12'] - $dtstokopname['Sisastok_Lainnya_Apbd_12'];
					$bln_pengeluaran_jkn_12 = $dtstokopname['Sisastok_Gudang_Jkn_11'] + $dtstokopname['PenerimaanJkn_12'] - $dtstokopname['Sisastok_Gudang_Jkn_12'] - $dtstokopname['Sisastok_Depot_Jkn_12'] - $dtstokopname['Sisastok_Igd_Jkn_12'] - $dtstokopname['Sisastok_Ranap_Jkn_12'] - $dtstokopname['Sisastok_Poned_Jkn_12'] - $dtstokopname['Sisastok_Pustu_Jkn_12'] - $dtstokopname['Sisastok_Pusling_Jkn_12'] - $dtstokopname['Sisastok_Poli_Jkn_12'] - $dtstokopname['Sisastok_Lainnya_Jkn_12'];
					$bln_pengeluaran_12 = $bln_pengeluaran_apbd_12 + $bln_pengeluaran_jkn_12;
					
					$pengeluaran = $bln_pengeluaran_01 + $bln_pengeluaran_02 + $bln_pengeluaran_03 + $bln_pengeluaran_04 + $bln_pengeluaran_05 + $bln_pengeluaran_06 + $bln_pengeluaran_07 + $bln_pengeluaran_08 + $bln_pengeluaran_09 + $bln_pengeluaran_10 + $bln_pengeluaran_11 + $bln_pengeluaran_12;
					
					// 4. sisastok
					$sisastok = ($stokawal + $penerimaan) - $pengeluaran;
					$saldo = $sisastok * $harga;	
					
				?>
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo $kodebarang;?></td>
						<td align="left">
							<?php 
							
							// penerimaan
							// $nopembukuan = $dt_penerimaan_dtl['NomorPembukuan'];
							$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_pengeluaran` WHERE `NoFaktur`='$nomorpembukuan'"));
							$dtsupplier = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_pabrik` WHERE `id`='$dtpenerimaan[KodeSupplier]'"));
													
							echo "<b>".$namaobat."</b><br/>".
							"No.Batch : ".$nobatch."<br/>".
							"Expire : ".date('d-m-Y', strtotime($dtobat['Expire']))."<br/>".
							"Sumber : ".$dtobat['SumberAnggaran'];
							?>
						</td>
						<td align="right"><?php echo rupiah($stokawal);?></td>
						<td align="right"><?php echo rupiah($penerimaan);?></td>
						<td align="right"><?php echo rupiah($pengeluaran);?></td>
						<td align="right"><?php echo rupiah($sisastok);?></td>
						<td align="right"><?php echo number_format($harga,2,",",".");?></td>
						<td align="right"><?php echo rupiah($saldo);?></td>
						<!--<td style="text-align:center; vertical-align:middle; padding:5px;"><a href="?page=lap_gfk_kartustok_vaksin_puskesmas_lihat&nf=<?php echo $nomorpembukuan;?>&kd=<?php echo $dtobat['KodeBarang'];?>&batch=<?php echo $dtobat['NoBatch'];?>&key=<?php echo $key;?>" class="btn btn-sm btn-info btn-white">Lihat</a></td>-->
					</tr>
				<?php
					$totalstokawal = $totalstokawal + $stokawal;
					$totalpenerimaan = $totalpenerimaan + $penerimaan;
					$totalpengeluaran = $totalpengeluaran + $pengeluaran;
					$totalsisastok = $totalsisastok + $sisastok;
				}
				?>		
					<tr>
						<td align="center" colspan="3">TOTAL</td>
						<td align="right"><?php echo rupiah($totalstokawal);?></td>
						<td align="right"><?php echo rupiah($totalpenerimaan);?></td>
						<td align="right"><?php echo rupiah($totalpengeluaran);?></td>
						<td align="right"><?php echo rupiah($totalsisastok);?></td>
						<td align="right"></td>
						<td align="right"></td>
						<!--<td align="right"></td>-->
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
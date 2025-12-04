<?php
	error_reporting(0);
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$hariini = date('d-m-Y');
    $tahun = $_GET['tahun'];
	$tahun1 = $tahun - 2;	
    $namaprogram = $_GET['namaprogram'];
	$tbstokopnam = 'tbstokopnam_puskesmas_'.str_replace(' ', '', $namapuskesmas);

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=RKO ".$namapuskesmas." (".$tahun.").xls");
	if(isset($tahun)){
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
	font-size:24px;
	font-family: "Roboto Condensed", Arial, sans-serif;
}
.printheader p{
	font-size:24px;
	font-family: "Roboto Condensed", Arial, sans-serif;
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
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>RKO PUSKESMAS</b></span><br>
	<span class="font12" style="margin:15px 5px 5px 5px;">Periode Laporan: <?php echo $tahun;?></span><br>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
    <table id="" class="table-judul-form" border="1">
        <thead>
			<tr>
				<th width="3%" rowspan="2">NO.</th>
				<th width="22%" rowspan="2">NAMA BARANG</th>
				<th width="5%" rowspan="2">SATUAN</th>
				<th width="5%" rowspan="2">HARGA<br/>SATUAN</th>
				<th width="5%" rowspan="2">STOK AWAL <br/> <?php echo "(DESEMBER ".$tahun1.")"?></th>
				<th width="5%" rowspan="2"><?php echo "PENERIMAAN <br/>".$tahun1?></th>
				<th width="5%" rowspan="2">TOTAL <br/>PERSEDIAAN</th>
				<th width="5%" rowspan="2"><?php echo "PENGELUARAN <br/>".$tahun1?></th>
				<th width="5%" rowspan="2">SISA STOK</th>
				<th width="5%" rowspan="2">JUMLAH BULAN <br/>PENGELUARAN</th>
				<th width="5%" rowspan="2">PEMAKAIAN <br/>RATA2 PER-BULAN</th>
				<th width="5%" rowspan="2">JUMLAH <br/>KEBUTUHAN</th>
				<th width="5%" colspan="2">RENCANA KEBUTUHAN <br/> OBAT</th>
				<th width="5%" colspan="2">TOTAL <br/>RUPIAH RKO</th>
				<th width="5%" rowspan="2">RENCANA <br/>PEMBELIAN</th>
				<th width="5%" rowspan="2">TOTAL <br/>RUPIAH PEMBELIAN</th>
			</tr>
			<tr>
				<th>APBD</th><!--Rencana Kebutuhan Obat-->
				<th>JKN</th>
				<th>APBD</th><!--Total Rupiah-->
				<th>JKN</th>
			</tr>
		</thead>								
		<tbody>
		<?php
			if($namaprogram == "Semua" || $namaprogram == ""){
				$program = "";
			}else{
				$program = "AND `NamaProgram`='$namaprogram'";
			}
				
			// tahap1, tbgfkstok karena berdasarkan ketersediaan real jangan pakai ref_obat_lplpo
			$str = "SELECT * FROM `ref_obat_lplpo` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%') ".$program;
			$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC";
			// echo $str2;
			
			$query = mysqli_query($koneksi,$str2);
			while($data = mysqli_fetch_assoc($query)){
				if($namaprogram != $data['NamaProgram']){
					if($data['NamaProgram'] == "PKD"){
						$prg = "OBAT (PKD)";	
					}else{
						$prg = $data['NamaProgram'];
					}	
					echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='18'>$prg</td></tr>";
					$namaprogram = $data['NamaProgram'];
				}
				
				$no = $no + 1;
				$kodebarang = $data['KodeBarang'];
				$namabarang = $data['NamaBarang'];
				$nobatch = $data['NoBatch'];
				
				// $tbstokopnam
				$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbstokopnam` WHERE `KodeBarang`='$kodebarang' AND `Tahun`='$tahun1'"));
				
				// hargabeli
				$hargabeli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' ORDER BY `IdBarang` DESC"));
				
				// tahap 1, stok awal
				$strsopkm = "SELECT * FROM `$tbstokopnam` WHERE `Tahun`='$tahun1' AND `KodeBarang`='$kodebarang'";
				$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, $strsopkm));
				$stokawal = $dtstokopname['StokAwalApbd'] + $dtstokopname['StokAwalJkn'];
				
				// tahap 2, penerimaan
				if($data['NamaProgram'] != "VAKSIN"){
					$penerimaan_apbd_01 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='01' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_02 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='02' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_03 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='03' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_04 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='04' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_05 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='05' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_06 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='06' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_07 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='07' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_08 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='08' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_09 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='09' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='10' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='11' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='12' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
				}else{
					$penerimaan_apbd_01 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='01' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_02 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='02' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_03 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='03' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_04 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='04' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_05 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='05' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_06 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='06' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_07 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='07' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_08 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='08' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_09 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='09' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='10' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='11' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$penerimaan_apbd_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun1' AND MONTH(a.`TanggalPengeluaran`)='12' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
				}
				
				$total_penerimaan_apbd = $penerimaan_apbd_01['Jumlah'] + $penerimaan_apbd_02['Jumlah'] + $penerimaan_apbd_03['Jumlah'] + $penerimaan_apbd_04['Jumlah'] + $penerimaan_apbd_05['Jumlah'] + $penerimaan_apbd_06['Jumlah'] + $penerimaan_apbd_07['Jumlah'] + $penerimaan_apbd_08['Jumlah'] + $penerimaan_apbd_09['Jumlah'] + $penerimaan_apbd_10['Jumlah'] + $penerimaan_apbd_11['Jumlah'] + $penerimaan_apbd_12['Jumlah'];
				$total_penerimaan_jkn = $dtstokopname['PenerimaanJkn_01'] + $dtstokopname['PenerimaanJkn_02'] + $dtstokopname['PenerimaanJkn_03'] + $dtstokopname['PenerimaanJkn_04'] + $dtstokopname['PenerimaanJkn_05'] + $dtstokopname['PenerimaanJkn_06'] + $dtstokopname['PenerimaanJkn_07'] + $dtstokopname['PenerimaanJkn_08'] + $dtstokopname['PenerimaanJkn_09'] + $dtstokopname['PenerimaanJkn_10'] + $dtstokopname['PenerimaanJkn_11'] + $dtstokopname['PenerimaanJkn_12'];
				$total_penerimaan = $total_penerimaan_apbd + $total_penerimaan_jkn;
				
				// total sisastok
				$total_sisastok_apbd_01 = $dtstokopname['Sisastok_Gudang_Apbd_01'] + $dtstokopname['Sisastok_Depot_Apbd_01'] + $dtstokopname['Sisastok_Igd_Apbd_01'] + $dtstokopname['Sisastok_Ranap_Apbd_01'] + $dtstokopname['Sisastok_Poned_Apbd_01'] + $dtstokopname['Sisastok_Pustu_Apbd_01'] + $dtstokopname['Sisastok_Pusling_Apbd_01'] + $dtstokopname['Sisastok_Poli_Apbd_01'] + $dtstokopname['Sisastok_Lainnya_Apbd_01'];
				$total_sisastok_apbd_02 = $dtstokopname['Sisastok_Gudang_Apbd_02'] + $dtstokopname['Sisastok_Depot_Apbd_02'] + $dtstokopname['Sisastok_Igd_Apbd_02'] + $dtstokopname['Sisastok_Ranap_Apbd_02'] + $dtstokopname['Sisastok_Poned_Apbd_02'] + $dtstokopname['Sisastok_Pustu_Apbd_02'] + $dtstokopname['Sisastok_Pusling_Apbd_02'] + $dtstokopname['Sisastok_Poli_Apbd_02'] + $dtstokopname['Sisastok_Lainnya_Apbd_02'];
				$total_sisastok_apbd_03 = $dtstokopname['Sisastok_Gudang_Apbd_03'] + $dtstokopname['Sisastok_Depot_Apbd_03'] + $dtstokopname['Sisastok_Igd_Apbd_03'] + $dtstokopname['Sisastok_Ranap_Apbd_03'] + $dtstokopname['Sisastok_Poned_Apbd_03'] + $dtstokopname['Sisastok_Pustu_Apbd_03'] + $dtstokopname['Sisastok_Pusling_Apbd_03'] + $dtstokopname['Sisastok_Poli_Apbd_03'] + $dtstokopname['Sisastok_Lainnya_Apbd_03'];
				$total_sisastok_apbd_04 = $dtstokopname['Sisastok_Gudang_Apbd_04'] + $dtstokopname['Sisastok_Depot_Apbd_04'] + $dtstokopname['Sisastok_Igd_Apbd_04'] + $dtstokopname['Sisastok_Ranap_Apbd_04'] + $dtstokopname['Sisastok_Poned_Apbd_04'] + $dtstokopname['Sisastok_Pustu_Apbd_04'] + $dtstokopname['Sisastok_Pusling_Apbd_04'] + $dtstokopname['Sisastok_Poli_Apbd_04'] + $dtstokopname['Sisastok_Lainnya_Apbd_04'];
				$total_sisastok_apbd_05 = $dtstokopname['Sisastok_Gudang_Apbd_05'] + $dtstokopname['Sisastok_Depot_Apbd_05'] + $dtstokopname['Sisastok_Igd_Apbd_05'] + $dtstokopname['Sisastok_Ranap_Apbd_05'] + $dtstokopname['Sisastok_Poned_Apbd_05'] + $dtstokopname['Sisastok_Pustu_Apbd_05'] + $dtstokopname['Sisastok_Pusling_Apbd_05'] + $dtstokopname['Sisastok_Poli_Apbd_05'] + $dtstokopname['Sisastok_Lainnya_Apbd_05'];
				$total_sisastok_apbd_06 = $dtstokopname['Sisastok_Gudang_Apbd_06'] + $dtstokopname['Sisastok_Depot_Apbd_06'] + $dtstokopname['Sisastok_Igd_Apbd_06'] + $dtstokopname['Sisastok_Ranap_Apbd_06'] + $dtstokopname['Sisastok_Poned_Apbd_06'] + $dtstokopname['Sisastok_Pustu_Apbd_06'] + $dtstokopname['Sisastok_Pusling_Apbd_06'] + $dtstokopname['Sisastok_Poli_Apbd_06'] + $dtstokopname['Sisastok_Lainnya_Apbd_06'];
				$total_sisastok_apbd_07 = $dtstokopname['Sisastok_Gudang_Apbd_07'] + $dtstokopname['Sisastok_Depot_Apbd_07'] + $dtstokopname['Sisastok_Igd_Apbd_07'] + $dtstokopname['Sisastok_Ranap_Apbd_07'] + $dtstokopname['Sisastok_Poned_Apbd_07'] + $dtstokopname['Sisastok_Pustu_Apbd_07'] + $dtstokopname['Sisastok_Pusling_Apbd_07'] + $dtstokopname['Sisastok_Poli_Apbd_07'] + $dtstokopname['Sisastok_Lainnya_Apbd_07'];
				$total_sisastok_apbd_08 = $dtstokopname['Sisastok_Gudang_Apbd_08'] + $dtstokopname['Sisastok_Depot_Apbd_08'] + $dtstokopname['Sisastok_Igd_Apbd_08'] + $dtstokopname['Sisastok_Ranap_Apbd_08'] + $dtstokopname['Sisastok_Poned_Apbd_08'] + $dtstokopname['Sisastok_Pustu_Apbd_08'] + $dtstokopname['Sisastok_Pusling_Apbd_08'] + $dtstokopname['Sisastok_Poli_Apbd_08'] + $dtstokopname['Sisastok_Lainnya_Apbd_08'];
				$total_sisastok_apbd_09 = $dtstokopname['Sisastok_Gudang_Apbd_09'] + $dtstokopname['Sisastok_Depot_Apbd_09'] + $dtstokopname['Sisastok_Igd_Apbd_09'] + $dtstokopname['Sisastok_Ranap_Apbd_09'] + $dtstokopname['Sisastok_Poned_Apbd_09'] + $dtstokopname['Sisastok_Pustu_Apbd_09'] + $dtstokopname['Sisastok_Pusling_Apbd_09'] + $dtstokopname['Sisastok_Poli_Apbd_09'] + $dtstokopname['Sisastok_Lainnya_Apbd_09'];
				$total_sisastok_apbd_10 = $dtstokopname['Sisastok_Gudang_Apbd_10'] + $dtstokopname['Sisastok_Depot_Apbd_10'] + $dtstokopname['Sisastok_Igd_Apbd_10'] + $dtstokopname['Sisastok_Ranap_Apbd_10'] + $dtstokopname['Sisastok_Poned_Apbd_10'] + $dtstokopname['Sisastok_Pustu_Apbd_10'] + $dtstokopname['Sisastok_Pusling_Apbd_10'] + $dtstokopname['Sisastok_Poli_Apbd_10'] + $dtstokopname['Sisastok_Lainnya_Apbd_10'];
				$total_sisastok_apbd_11 = $dtstokopname['Sisastok_Gudang_Apbd_11'] + $dtstokopname['Sisastok_Depot_Apbd_11'] + $dtstokopname['Sisastok_Igd_Apbd_11'] + $dtstokopname['Sisastok_Ranap_Apbd_11'] + $dtstokopname['Sisastok_Poned_Apbd_11'] + $dtstokopname['Sisastok_Pustu_Apbd_11'] + $dtstokopname['Sisastok_Pusling_Apbd_11'] + $dtstokopname['Sisastok_Poli_Apbd_11'] + $dtstokopname['Sisastok_Lainnya_Apbd_11'];
				$total_sisastok_apbd_12 = $dtstokopname['Sisastok_Gudang_Apbd_12'] + $dtstokopname['Sisastok_Depot_Apbd_12'] + $dtstokopname['Sisastok_Igd_Apbd_12'] + $dtstokopname['Sisastok_Ranap_Apbd_12'] + $dtstokopname['Sisastok_Poned_Apbd_12'] + $dtstokopname['Sisastok_Pustu_Apbd_12'] + $dtstokopname['Sisastok_Pusling_Apbd_12'] + $dtstokopname['Sisastok_Poli_Apbd_12'] + $dtstokopname['Sisastok_Lainnya_Apbd_12'];
				$total_sisastok_jkn_01 = $dtstokopname['Sisastok_Gudang_Jkn_01'] + $dtstokopname['Sisastok_Depot_Jkn_01'] + $dtstokopname['Sisastok_Igd_Jkn_01'] + $dtstokopname['Sisastok_Ranap_Jkn_01'] + $dtstokopname['Sisastok_Poned_Jkn_01'] + $dtstokopname['Sisastok_Pustu_Jkn_01'] + $dtstokopname['Sisastok_Pusling_Jkn_01'] + $dtstokopname['Sisastok_Poli_Jkn_01'] + $dtstokopname['Sisastok_Lainnya_Jkn_01'];
				$total_sisastok_jkn_02 = $dtstokopname['Sisastok_Gudang_Jkn_02'] + $dtstokopname['Sisastok_Depot_Jkn_02'] + $dtstokopname['Sisastok_Igd_Jkn_02'] + $dtstokopname['Sisastok_Ranap_Jkn_02'] + $dtstokopname['Sisastok_Poned_Jkn_02'] + $dtstokopname['Sisastok_Pustu_Jkn_02'] + $dtstokopname['Sisastok_Pusling_Jkn_02'] + $dtstokopname['Sisastok_Poli_Jkn_02'] + $dtstokopname['Sisastok_Lainnya_Jkn_02'];
				$total_sisastok_jkn_03 = $dtstokopname['Sisastok_Gudang_Jkn_03'] + $dtstokopname['Sisastok_Depot_Jkn_03'] + $dtstokopname['Sisastok_Igd_Jkn_03'] + $dtstokopname['Sisastok_Ranap_Jkn_03'] + $dtstokopname['Sisastok_Poned_Jkn_03'] + $dtstokopname['Sisastok_Pustu_Jkn_03'] + $dtstokopname['Sisastok_Pusling_Jkn_03'] + $dtstokopname['Sisastok_Poli_Jkn_03'] + $dtstokopname['Sisastok_Lainnya_Jkn_03'];
				$total_sisastok_jkn_04 = $dtstokopname['Sisastok_Gudang_Jkn_04'] + $dtstokopname['Sisastok_Depot_Jkn_04'] + $dtstokopname['Sisastok_Igd_Jkn_04'] + $dtstokopname['Sisastok_Ranap_Jkn_04'] + $dtstokopname['Sisastok_Poned_Jkn_04'] + $dtstokopname['Sisastok_Pustu_Jkn_04'] + $dtstokopname['Sisastok_Pusling_Jkn_04'] + $dtstokopname['Sisastok_Poli_Jkn_04'] + $dtstokopname['Sisastok_Lainnya_Jkn_04'];
				$total_sisastok_jkn_05 = $dtstokopname['Sisastok_Gudang_Jkn_05'] + $dtstokopname['Sisastok_Depot_Jkn_05'] + $dtstokopname['Sisastok_Igd_Jkn_05'] + $dtstokopname['Sisastok_Ranap_Jkn_05'] + $dtstokopname['Sisastok_Poned_Jkn_05'] + $dtstokopname['Sisastok_Pustu_Jkn_05'] + $dtstokopname['Sisastok_Pusling_Jkn_05'] + $dtstokopname['Sisastok_Poli_Jkn_05'] + $dtstokopname['Sisastok_Lainnya_Jkn_05'];
				$total_sisastok_jkn_06 = $dtstokopname['Sisastok_Gudang_Jkn_06'] + $dtstokopname['Sisastok_Depot_Jkn_06'] + $dtstokopname['Sisastok_Igd_Jkn_06'] + $dtstokopname['Sisastok_Ranap_Jkn_06'] + $dtstokopname['Sisastok_Poned_Jkn_06'] + $dtstokopname['Sisastok_Pustu_Jkn_06'] + $dtstokopname['Sisastok_Pusling_Jkn_06'] + $dtstokopname['Sisastok_Poli_Jkn_06'] + $dtstokopname['Sisastok_Lainnya_Jkn_06'];
				$total_sisastok_jkn_07 = $dtstokopname['Sisastok_Gudang_Jkn_07'] + $dtstokopname['Sisastok_Depot_Jkn_07'] + $dtstokopname['Sisastok_Igd_Jkn_07'] + $dtstokopname['Sisastok_Ranap_Jkn_07'] + $dtstokopname['Sisastok_Poned_Jkn_07'] + $dtstokopname['Sisastok_Pustu_Jkn_07'] + $dtstokopname['Sisastok_Pusling_Jkn_07'] + $dtstokopname['Sisastok_Poli_Jkn_07'] + $dtstokopname['Sisastok_Lainnya_Jkn_07'];
				$total_sisastok_jkn_08 = $dtstokopname['Sisastok_Gudang_Jkn_08'] + $dtstokopname['Sisastok_Depot_Jkn_08'] + $dtstokopname['Sisastok_Igd_Jkn_08'] + $dtstokopname['Sisastok_Ranap_Jkn_08'] + $dtstokopname['Sisastok_Poned_Jkn_08'] + $dtstokopname['Sisastok_Pustu_Jkn_08'] + $dtstokopname['Sisastok_Pusling_Jkn_08'] + $dtstokopname['Sisastok_Poli_Jkn_08'] + $dtstokopname['Sisastok_Lainnya_Jkn_08'];
				$total_sisastok_jkn_09 = $dtstokopname['Sisastok_Gudang_Jkn_09'] + $dtstokopname['Sisastok_Depot_Jkn_09'] + $dtstokopname['Sisastok_Igd_Jkn_09'] + $dtstokopname['Sisastok_Ranap_Jkn_09'] + $dtstokopname['Sisastok_Poned_Jkn_09'] + $dtstokopname['Sisastok_Pustu_Jkn_09'] + $dtstokopname['Sisastok_Pusling_Jkn_09'] + $dtstokopname['Sisastok_Poli_Jkn_09'] + $dtstokopname['Sisastok_Lainnya_Jkn_09'];
				$total_sisastok_jkn_10 = $dtstokopname['Sisastok_Gudang_Jkn_10'] + $dtstokopname['Sisastok_Depot_Jkn_10'] + $dtstokopname['Sisastok_Igd_Jkn_10'] + $dtstokopname['Sisastok_Ranap_Jkn_10'] + $dtstokopname['Sisastok_Poned_Jkn_10'] + $dtstokopname['Sisastok_Pustu_Jkn_10'] + $dtstokopname['Sisastok_Pusling_Jkn_10'] + $dtstokopname['Sisastok_Poli_Jkn_10'] + $dtstokopname['Sisastok_Lainnya_Jkn_10'];
				$total_sisastok_jkn_11 = $dtstokopname['Sisastok_Gudang_Jkn_11'] + $dtstokopname['Sisastok_Depot_Jkn_11'] + $dtstokopname['Sisastok_Igd_Jkn_11'] + $dtstokopname['Sisastok_Ranap_Jkn_11'] + $dtstokopname['Sisastok_Poned_Jkn_11'] + $dtstokopname['Sisastok_Pustu_Jkn_11'] + $dtstokopname['Sisastok_Pusling_Jkn_11'] + $dtstokopname['Sisastok_Poli_Jkn_11'] + $dtstokopname['Sisastok_Lainnya_Jkn_11'];
				$total_sisastok_jkn_12 = $dtstokopname['Sisastok_Gudang_Jkn_12'] + $dtstokopname['Sisastok_Depot_Jkn_12'] + $dtstokopname['Sisastok_Igd_Jkn_12'] + $dtstokopname['Sisastok_Ranap_Jkn_12'] + $dtstokopname['Sisastok_Poned_Jkn_12'] + $dtstokopname['Sisastok_Pustu_Jkn_12'] + $dtstokopname['Sisastok_Pusling_Jkn_12'] + $dtstokopname['Sisastok_Poli_Jkn_12'] + $dtstokopname['Sisastok_Lainnya_Jkn_12'];
														
				// tahap 3, pengeluaran
				// jika januari rumusnya stok awal (des 2020) + penerimaan (jan 2021) - sisa stok (jan 2021)
				$pemakaian_apbd_01 = $dtstokopname['StokAwalApbd'] + $penerimaan_apbd_01['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_01'] - $dtstokopname['Sisastok_Depot_Apbd_01'] - $dtstokopname['Sisastok_Igd_Apbd_01'] - $dtstokopname['Sisastok_Ranap_Apbd_01'] - $dtstokopname['Sisastok_Poned_Apbd_01'] - $dtstokopname['Sisastok_Pustu_Apbd_01'] - $dtstokopname['Sisastok_Pusling_Apbd_01'] - $dtstokopname['Sisastok_Poli_Apbd_01'] - $dtstokopname['Sisastok_Lainnya_Apbd_01'];
				$pemakaian_jkn_01 = $dtstokopname['StokAwalJkn'] + $dtstokopname['PenerimaanJkn_01'] - $dtstokopname['Sisastok_Gudang_Jkn_01'] - $dtstokopname['Sisastok_Depot_Jkn_01'] - $dtstokopname['Sisastok_Igd_Jkn_01'] - $dtstokopname['Sisastok_Ranap_Jkn_01'] - $dtstokopname['Sisastok_Poned_Jkn_01'] - $dtstokopname['Sisastok_Pustu_Jkn_01'] - $dtstokopname['Sisastok_Pusling_Jkn_01'] - $dtstokopname['Sisastok_Poli_Jkn_01'] - $dtstokopname['Sisastok_Lainnya_Jkn_01'];
				
				// jika februari s/d desember (2021) rumusnya, sisa stok bulan sebelumnya (jan 2021) + penerimaan (bulan berjalan) - sisa stok (bulan berjalan)
				$pemakaian_apbd_02 = $total_sisastok_apbd_01 + $penerimaan_apbd_02['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_02'] - $dtstokopname['Sisastok_Depot_Apbd_02'] - $dtstokopname['Sisastok_Igd_Apbd_02'] - $dtstokopname['Sisastok_Ranap_Apbd_02'] - $dtstokopname['Sisastok_Poned_Apbd_02'] - $dtstokopname['Sisastok_Pustu_Apbd_02'] - $dtstokopname['Sisastok_Pusling_Apbd_02'] - $dtstokopname['Sisastok_Poli_Apbd_02'] - $dtstokopname['Sisastok_Lainnya_Apbd_02'];
				$pemakaian_jkn_02 = $total_sisastok_jkn_01 + $dtstokopname['PenerimaanJkn_02'] - $dtstokopname['Sisastok_Gudang_Jkn_02'] - $dtstokopname['Sisastok_Depot_Jkn_02'] - $dtstokopname['Sisastok_Igd_Jkn_02'] - $dtstokopname['Sisastok_Ranap_Jkn_02'] - $dtstokopname['Sisastok_Poned_Jkn_02'] - $dtstokopname['Sisastok_Pustu_Jkn_02'] - $dtstokopname['Sisastok_Pusling_Jkn_02'] - $dtstokopname['Sisastok_Poli_Jkn_02'] - $dtstokopname['Sisastok_Lainnya_Jkn_02'];
				$pemakaian_apbd_03 = $total_sisastok_apbd_02 + $penerimaan_apbd_03['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_03'] - $dtstokopname['Sisastok_Depot_Apbd_03'] - $dtstokopname['Sisastok_Igd_Apbd_03'] - $dtstokopname['Sisastok_Ranap_Apbd_03'] - $dtstokopname['Sisastok_Poned_Apbd_03'] - $dtstokopname['Sisastok_Pustu_Apbd_03'] - $dtstokopname['Sisastok_Pusling_Apbd_03'] - $dtstokopname['Sisastok_Poli_Apbd_03'] - $dtstokopname['Sisastok_Lainnya_Apbd_03'];
				$pemakaian_jkn_03 = $total_sisastok_jkn_02 + $dtstokopname['PenerimaanJkn_03'] - $dtstokopname['Sisastok_Gudang_Jkn_03'] - $dtstokopname['Sisastok_Depot_Jkn_03'] - $dtstokopname['Sisastok_Igd_Jkn_03'] - $dtstokopname['Sisastok_Ranap_Jkn_03'] - $dtstokopname['Sisastok_Poned_Jkn_03'] - $dtstokopname['Sisastok_Pustu_Jkn_03'] - $dtstokopname['Sisastok_Pusling_Jkn_03'] - $dtstokopname['Sisastok_Poli_Jkn_03'] - $dtstokopname['Sisastok_Lainnya_Jkn_03'];
				$pemakaian_apbd_04 = $total_sisastok_apbd_03 + $penerimaan_apbd_04['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_04'] - $dtstokopname['Sisastok_Depot_Apbd_04'] - $dtstokopname['Sisastok_Igd_Apbd_04'] - $dtstokopname['Sisastok_Ranap_Apbd_04'] - $dtstokopname['Sisastok_Poned_Apbd_04'] - $dtstokopname['Sisastok_Pustu_Apbd_04'] - $dtstokopname['Sisastok_Pusling_Apbd_04'] - $dtstokopname['Sisastok_Poli_Apbd_04'] - $dtstokopname['Sisastok_Lainnya_Apbd_04'];
				$pemakaian_jkn_04 = $total_sisastok_jkn_03 + $dtstokopname['PenerimaanJkn_04'] - $dtstokopname['Sisastok_Gudang_Jkn_04'] - $dtstokopname['Sisastok_Depot_Jkn_04'] - $dtstokopname['Sisastok_Igd_Jkn_04'] - $dtstokopname['Sisastok_Ranap_Jkn_04'] - $dtstokopname['Sisastok_Poned_Jkn_04'] - $dtstokopname['Sisastok_Pustu_Jkn_04'] - $dtstokopname['Sisastok_Pusling_Jkn_04'] - $dtstokopname['Sisastok_Poli_Jkn_04'] - $dtstokopname['Sisastok_Lainnya_Jkn_04'];
				$pemakaian_apbd_05 = $total_sisastok_apbd_04 + $penerimaan_apbd_05['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_05'] - $dtstokopname['Sisastok_Depot_Apbd_05'] - $dtstokopname['Sisastok_Igd_Apbd_05'] - $dtstokopname['Sisastok_Ranap_Apbd_05'] - $dtstokopname['Sisastok_Poned_Apbd_05'] - $dtstokopname['Sisastok_Pustu_Apbd_05'] - $dtstokopname['Sisastok_Pusling_Apbd_05'] - $dtstokopname['Sisastok_Poli_Apbd_05'] - $dtstokopname['Sisastok_Lainnya_Apbd_05'];
				$pemakaian_jkn_05 = $total_sisastok_jkn_04 + $dtstokopname['PenerimaanJkn_05'] - $dtstokopname['Sisastok_Gudang_Jkn_05'] - $dtstokopname['Sisastok_Depot_Jkn_05'] - $dtstokopname['Sisastok_Igd_Jkn_05'] - $dtstokopname['Sisastok_Ranap_Jkn_05'] - $dtstokopname['Sisastok_Poned_Jkn_05'] - $dtstokopname['Sisastok_Pustu_Jkn_05'] - $dtstokopname['Sisastok_Pusling_Jkn_05'] - $dtstokopname['Sisastok_Poli_Jkn_05'] - $dtstokopname['Sisastok_Lainnya_Jkn_05'];
				$pemakaian_apbd_06 = $total_sisastok_apbd_05 + $penerimaan_apbd_06['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_06'] - $dtstokopname['Sisastok_Depot_Apbd_06'] - $dtstokopname['Sisastok_Igd_Apbd_06'] - $dtstokopname['Sisastok_Ranap_Apbd_06'] - $dtstokopname['Sisastok_Poned_Apbd_06'] - $dtstokopname['Sisastok_Pustu_Apbd_06'] - $dtstokopname['Sisastok_Pusling_Apbd_06'] - $dtstokopname['Sisastok_Poli_Apbd_06'] - $dtstokopname['Sisastok_Lainnya_Apbd_06'];
				$pemakaian_jkn_06 = $total_sisastok_jkn_05 + $dtstokopname['PenerimaanJkn_06'] - $dtstokopname['Sisastok_Gudang_Jkn_06'] - $dtstokopname['Sisastok_Depot_Jkn_06'] - $dtstokopname['Sisastok_Igd_Jkn_06'] - $dtstokopname['Sisastok_Ranap_Jkn_06'] - $dtstokopname['Sisastok_Poned_Jkn_06'] - $dtstokopname['Sisastok_Pustu_Jkn_06'] - $dtstokopname['Sisastok_Pusling_Jkn_06'] - $dtstokopname['Sisastok_Poli_Jkn_06'] - $dtstokopname['Sisastok_Lainnya_Jkn_06'];
				$pemakaian_apbd_07 = $total_sisastok_apbd_06 + $penerimaan_apbd_07['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_07'] - $dtstokopname['Sisastok_Depot_Apbd_07'] - $dtstokopname['Sisastok_Igd_Apbd_07'] - $dtstokopname['Sisastok_Ranap_Apbd_07'] - $dtstokopname['Sisastok_Poned_Apbd_07'] - $dtstokopname['Sisastok_Pustu_Apbd_07'] - $dtstokopname['Sisastok_Pusling_Apbd_07'] - $dtstokopname['Sisastok_Poli_Apbd_07'] - $dtstokopname['Sisastok_Lainnya_Apbd_07'];
				$pemakaian_jkn_07 = $total_sisastok_jkn_06 + $dtstokopname['PenerimaanJkn_07'] - $dtstokopname['Sisastok_Gudang_Jkn_07'] - $dtstokopname['Sisastok_Depot_Jkn_07'] - $dtstokopname['Sisastok_Igd_Jkn_07'] - $dtstokopname['Sisastok_Ranap_Jkn_07'] - $dtstokopname['Sisastok_Poned_Jkn_07'] - $dtstokopname['Sisastok_Pustu_Jkn_07'] - $dtstokopname['Sisastok_Pusling_Jkn_07'] - $dtstokopname['Sisastok_Poli_Jkn_07'] - $dtstokopname['Sisastok_Lainnya_Jkn_07'];
				$pemakaian_apbd_08 = $total_sisastok_apbd_07 + $penerimaan_apbd_08['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_08'] - $dtstokopname['Sisastok_Depot_Apbd_08'] - $dtstokopname['Sisastok_Igd_Apbd_08'] - $dtstokopname['Sisastok_Ranap_Apbd_08'] - $dtstokopname['Sisastok_Poned_Apbd_08'] - $dtstokopname['Sisastok_Pustu_Apbd_08'] - $dtstokopname['Sisastok_Pusling_Apbd_08'] - $dtstokopname['Sisastok_Poli_Apbd_08'] - $dtstokopname['Sisastok_Lainnya_Apbd_08'];
				$pemakaian_jkn_08 = $total_sisastok_jkn_07 + $dtstokopname['PenerimaanJkn_08'] - $dtstokopname['Sisastok_Gudang_Jkn_08'] - $dtstokopname['Sisastok_Depot_Jkn_08'] - $dtstokopname['Sisastok_Igd_Jkn_08'] - $dtstokopname['Sisastok_Ranap_Jkn_08'] - $dtstokopname['Sisastok_Poned_Jkn_08'] - $dtstokopname['Sisastok_Pustu_Jkn_08'] - $dtstokopname['Sisastok_Pusling_Jkn_08'] - $dtstokopname['Sisastok_Poli_Jkn_08'] - $dtstokopname['Sisastok_Lainnya_Jkn_08'];
				$pemakaian_apbd_09 = $total_sisastok_apbd_08 + $penerimaan_apbd_09['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_09'] - $dtstokopname['Sisastok_Depot_Apbd_09'] - $dtstokopname['Sisastok_Igd_Apbd_09'] - $dtstokopname['Sisastok_Ranap_Apbd_09'] - $dtstokopname['Sisastok_Poned_Apbd_09'] - $dtstokopname['Sisastok_Pustu_Apbd_09'] - $dtstokopname['Sisastok_Pusling_Apbd_09'] - $dtstokopname['Sisastok_Poli_Apbd_09'] - $dtstokopname['Sisastok_Lainnya_Apbd_09'];
				$pemakaian_jkn_09 = $total_sisastok_jkn_08 + $dtstokopname['PenerimaanJkn_09'] - $dtstokopname['Sisastok_Gudang_Jkn_09'] - $dtstokopname['Sisastok_Depot_Jkn_09'] - $dtstokopname['Sisastok_Igd_Jkn_09'] - $dtstokopname['Sisastok_Ranap_Jkn_09'] - $dtstokopname['Sisastok_Poned_Jkn_09'] - $dtstokopname['Sisastok_Pustu_Jkn_09'] - $dtstokopname['Sisastok_Pusling_Jkn_09'] - $dtstokopname['Sisastok_Poli_Jkn_09'] - $dtstokopname['Sisastok_Lainnya_Jkn_09'];
				$pemakaian_apbd_10 = $total_sisastok_apbd_09 + $penerimaan_apbd_10['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_10'] - $dtstokopname['Sisastok_Depot_Apbd_10'] - $dtstokopname['Sisastok_Igd_Apbd_10'] - $dtstokopname['Sisastok_Ranap_Apbd_10'] - $dtstokopname['Sisastok_Poned_Apbd_10'] - $dtstokopname['Sisastok_Pustu_Apbd_10'] - $dtstokopname['Sisastok_Pusling_Apbd_10'] - $dtstokopname['Sisastok_Poli_Apbd_10'] - $dtstokopname['Sisastok_Lainnya_Apbd_10'];
				$pemakaian_jkn_10 = $total_sisastok_jkn_09 + $dtstokopname['PenerimaanJkn_10'] - $dtstokopname['Sisastok_Gudang_Jkn_10'] - $dtstokopname['Sisastok_Depot_Jkn_10'] - $dtstokopname['Sisastok_Igd_Jkn_10'] - $dtstokopname['Sisastok_Ranap_Jkn_10'] - $dtstokopname['Sisastok_Poned_Jkn_10'] - $dtstokopname['Sisastok_Pustu_Jkn_10'] - $dtstokopname['Sisastok_Pusling_Jkn_10'] - $dtstokopname['Sisastok_Poli_Jkn_10'] - $dtstokopname['Sisastok_Lainnya_Jkn_10'];
				$pemakaian_apbd_11 = $total_sisastok_apbd_10 + $penerimaan_apbd_11['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_11'] - $dtstokopname['Sisastok_Depot_Apbd_11'] - $dtstokopname['Sisastok_Igd_Apbd_11'] - $dtstokopname['Sisastok_Ranap_Apbd_11'] - $dtstokopname['Sisastok_Poned_Apbd_11'] - $dtstokopname['Sisastok_Pustu_Apbd_11'] - $dtstokopname['Sisastok_Pusling_Apbd_11'] - $dtstokopname['Sisastok_Poli_Apbd_11'] - $dtstokopname['Sisastok_Lainnya_Apbd_11'];
				$pemakaian_jkn_11 = $total_sisastok_jkn_10 + $dtstokopname['PenerimaanJkn_11'] - $dtstokopname['Sisastok_Gudang_Jkn_11'] - $dtstokopname['Sisastok_Depot_Jkn_11'] - $dtstokopname['Sisastok_Igd_Jkn_11'] - $dtstokopname['Sisastok_Ranap_Jkn_11'] - $dtstokopname['Sisastok_Poned_Jkn_11'] - $dtstokopname['Sisastok_Pustu_Jkn_11'] - $dtstokopname['Sisastok_Pusling_Jkn_11'] - $dtstokopname['Sisastok_Poli_Jkn_11'] - $dtstokopname['Sisastok_Lainnya_Jkn_11'];
				$pemakaian_apbd_12 = $total_sisastok_apbd_11 + $penerimaan_apbd_12['Jumlah'] - $dtstokopname['Sisastok_Gudang_Apbd_12'] - $dtstokopname['Sisastok_Depot_Apbd_12'] - $dtstokopname['Sisastok_Igd_Apbd_12'] - $dtstokopname['Sisastok_Ranap_Apbd_12'] - $dtstokopname['Sisastok_Poned_Apbd_12'] - $dtstokopname['Sisastok_Pustu_Apbd_12'] - $dtstokopname['Sisastok_Pusling_Apbd_12'] - $dtstokopname['Sisastok_Poli_Apbd_12'] - $dtstokopname['Sisastok_Lainnya_Apbd_12'];
				$pemakaian_jkn_12 = $total_sisastok_jkn_11 + $dtstokopname['PenerimaanJkn_12'] - $dtstokopname['Sisastok_Gudang_Jkn_12'] - $dtstokopname['Sisastok_Depot_Jkn_12'] - $dtstokopname['Sisastok_Igd_Jkn_12'] - $dtstokopname['Sisastok_Ranap_Jkn_12'] - $dtstokopname['Sisastok_Poned_Jkn_12'] - $dtstokopname['Sisastok_Pustu_Jkn_12'] - $dtstokopname['Sisastok_Pusling_Jkn_12'] - $dtstokopname['Sisastok_Poli_Jkn_12'] - $dtstokopname['Sisastok_Lainnya_Jkn_12'];
				
				// total pemakaian apbd	
				$pemakaian_apbd = $pemakaian_apbd_01 + $pemakaian_apbd_02 + $pemakaian_apbd_03 + $pemakaian_apbd_04 + $pemakaian_apbd_05 + $pemakaian_apbd_06 + $pemakaian_apbd_07 + $pemakaian_apbd_08 + $pemakaian_apbd_09 + $pemakaian_apbd_10 + $pemakaian_apbd_11 + $pemakaian_apbd_12;
				$pemakaian_jkn = $pemakaian_jkn_01 + $pemakaian_jkn_02 + $pemakaian_jkn_03 + $pemakaian_jkn_04 + $pemakaian_jkn_05 + $pemakaian_jkn_06 + $pemakaian_jkn_07 + $pemakaian_jkn_08 + $pemakaian_jkn_09 + $pemakaian_jkn_10 + $pemakaian_jkn_11 + $pemakaian_jkn_12;
				$jumlahkeluar = $pemakaian_apbd + $pemakaian_jkn;
				
				// persediaan
				$persediaan = $total_penerimaan + $dtstokopname['StokAwalApbd'] + $dtstokopname['StokAwalJkn'];
				
				// sisa stok
				$sisastok = $persediaan - $jumlahkeluar;
				
				// bulan pemakaian							
				$bulanpemakaian_01 = $total_sisastok_apbd_01 + $total_sisastok_jkn_01;
				$bulanpemakaian_02 = $total_sisastok_apbd_02 + $total_sisastok_jkn_02;
				$bulanpemakaian_03 = $total_sisastok_apbd_03 + $total_sisastok_jkn_03;
				$bulanpemakaian_04 = $total_sisastok_apbd_04 + $total_sisastok_jkn_04;
				$bulanpemakaian_05 = $total_sisastok_apbd_05 + $total_sisastok_jkn_05;
				$bulanpemakaian_06 = $total_sisastok_apbd_06 + $total_sisastok_jkn_06;
				$bulanpemakaian_07 = $total_sisastok_apbd_07 + $total_sisastok_jkn_07;
				$bulanpemakaian_08 = $total_sisastok_apbd_08 + $total_sisastok_jkn_08;
				$bulanpemakaian_09 = $total_sisastok_apbd_09 + $total_sisastok_jkn_09;
				$bulanpemakaian_10 = $total_sisastok_apbd_10 + $total_sisastok_jkn_10;
				$bulanpemakaian_11 = $total_sisastok_apbd_11 + $total_sisastok_jkn_11;
				$bulanpemakaian_12 = $total_sisastok_apbd_12 + $total_sisastok_jkn_12;
				if($bulanpemakaian_01 > 0){ $bulanpemakaian_01 = 1; }else{ $bulanpemakaian_01 = 0; }
				if($bulanpemakaian_02 > 0){ $bulanpemakaian_02 = 1; }else{ $bulanpemakaian_02 = 0; }
				if($bulanpemakaian_03 > 0){ $bulanpemakaian_03 = 1; }else{ $bulanpemakaian_03 = 0; }
				if($bulanpemakaian_04 > 0){ $bulanpemakaian_04 = 1; }else{ $bulanpemakaian_04 = 0; }
				if($bulanpemakaian_05 > 0){ $bulanpemakaian_05 = 1; }else{ $bulanpemakaian_05 = 0; }
				if($bulanpemakaian_06 > 0){ $bulanpemakaian_06 = 1; }else{ $bulanpemakaian_06 = 0; }
				if($bulanpemakaian_07 > 0){ $bulanpemakaian_07 = 1; }else{ $bulanpemakaian_07 = 0; }
				if($bulanpemakaian_08 > 0){ $bulanpemakaian_08 = 1; }else{ $bulanpemakaian_08 = 0; }
				if($bulanpemakaian_09 > 0){ $bulanpemakaian_09 = 1; }else{ $bulanpemakaian_09 = 0; }
				if($bulanpemakaian_10 > 0){ $bulanpemakaian_10 = 1; }else{ $bulanpemakaian_10 = 0; }
				if($bulanpemakaian_11 > 0){ $bulanpemakaian_11 = 1; }else{ $bulanpemakaian_11 = 0; }
				if($bulanpemakaian_12 > 0){ $bulanpemakaian_12 = 1; }else{ $bulanpemakaian_12 = 0; }
				$bulanpemakaian = $bulanpemakaian_01 + $bulanpemakaian_02 + $bulanpemakaian_03 + $bulanpemakaian_04 + $bulanpemakaian_05 + $bulanpemakaian_06 + $bulanpemakaian_07 + $bulanpemakaian_08 + $bulanpemakaian_09 + $bulanpemakaian_10 + $bulanpemakaian_11 + $bulanpemakaian_12;
				// echo $bulanpemakaian;
				
				// pemakaian rata-rata
				$pemakaianrata = $jumlahkeluar / $bulanpemakaian;
				
				// jumlah kebutuhan
				$jumlahkebutuhan = $pemakaianrata * 18 - $sisastok;
				
				// rencana kebutuhan
				if($jumlahkebutuhan == 0){
					$rencanakebutuhan_apbd = $sisastok;
					$rencanakebutuhan_jkn = $sisastok;
				}else{	
					$rencanakebutuhan_apbd = $jumlahkebutuhan * 30 / 100;
					$rencanakebutuhan_jkn = $jumlahkebutuhan * 70 / 100;
				}
				
				// total rupiah rko
				$totalrupiahrko_apbd = $rencanakebutuhan_apbd * $hargabeli['HargaBeli'];
				$totalrupiahrko_jkn = $rencanakebutuhan_jkn * $hargabeli['HargaBeli'];
				
				?>
				<tr>
					<td style="text-align:right;"><?php echo $no;?></td>
					<td style="text-align:left;" class="namabarangcls"><?php echo strtoupper($namabarang);?></td>
					<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
					<td style="text-align:right;"><?php echo rupiah($hargabeli['HargaBeli']);?></td>
					<td style="text-align:right;"><?php echo rupiah($stokawal);?></td><!--Stokawal-->
					<td style="text-align:right;"><?php echo rupiah($total_penerimaan);?></td><!--Penerimaan-->
					<td style="text-align:right;">
					<?php 
						// persediaan
						$persediaan = $total_penerimaan + $dtstokopname['StokAwalApbd'] + $dtstokopname['StokAwalJkn'];
						if($persediaan != 0){
							echo rupiah($persediaan);
						}else{
							echo "";
						}
					?>
					</td>
					<td style="text-align:right;"><?php echo rupiah($jumlahkeluar);?></td><!--Pemakaian-->
					<td style="text-align:right;"><?php echo rupiah($sisastok);?></td><!--Sisa Stok-->
					<td style="text-align:right;"><?php echo $bulanpemakaian;?></td><!--Jumlah Bulan Pemakaian-->
					<td style="text-align:right;"><?php echo rupiah(ceil($pemakaianrata));?></td><!--Pemakaian Rata2 PerBulan-->
					<td style="text-align:right;"><?php echo rupiah(ceil($jumlahkebutuhan));?></td><!--Jumlah Kebutuhan-->
					<td style="text-align:right;"><?php echo rupiah(ceil($rencanakebutuhan_apbd));?></td><!--Rencana Kebutuhan Obat-->
					<td style="text-align:right;"><?php echo rupiah(ceil($rencanakebutuhan_jkn));?></td>
					<td style="text-align:right;"><?php echo rupiah($totalrupiahrko_apbd);?></td><!--Total Rupiah RKO-->
					<td style="text-align:right;"><?php echo rupiah($totalrupiahrko_jkn);?></td>
					<td style="text-align:right;"><!--Rencana Pembelian-->
						<?php
							$tbrko = "tbrko_puskesmas_".str_replace(' ', '', $namapuskesmas);
							$datarko = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbrko` WHERE `Tahun`='$tahun' AND `KodeBarang`='$data[KodeBarang]'"));
							echo $datarko['RencanaPembelian'];
						?>
					</td>
					<td style="text-align:right;">
						<?php
							 $totalrupiah = $datarko['RencanaPembelian'] * $hargabeli['HargaBeli'];
							 echo rupiah($totalrupiah);
						?>
					</td>
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
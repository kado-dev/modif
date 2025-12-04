<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$hariini = date('d-m-Y');
	$bulan = mysqli_real_escape_string($koneksi, $_GET['bulan']);
	$tahun = mysqli_real_escape_string($koneksi, $_GET['tahun']);
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
	
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Bulanan Pelayanan Kefarmasian (".$namapuskesmas.").xls");
	if(isset($bulan)){
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
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN BULANAN PELAYANAN KEFARMASIAN</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></p>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table-judul-form" border="1">
			<thead>
				<tr>
					<th rowspan="2" width="3%">NO.</th>
					<th rowspan="2" width="17%">TANGGAL</th>
					<th colspan="3" width="35%">JUMLAH LEMBAR RESEP</th>
					<th rowspan="2" width="15%">KONSELING</th>
					<th rowspan="2" width="15%">INFORMASI OBAT</th>
					<th rowspan="2" width="15%">JML ITEM OBAT</th>
				</tr>
				<tr>
					<th>RAWAT JALAN</th>
					<th>RAWAT INAP</th>
					<th>JUMLAH</th>
				</tr>
			</thead>							
			<tbody>
				<?php
				// OPTIMASI: Gunakan date range untuk index
				$date_start = "$tahun-$bulan-01";
				$date_end = date('Y-m-t', strtotime($date_start));
				
				// Query 1: Rawat Jalan per tanggal (SIMPLE - tanpa JOIN)
				$str_rj = "SELECT DATE(TanggalResep) as TglResep, COUNT(IdPasienrj) As Jml 
				FROM `$tbresep`
				WHERE TanggalResep BETWEEN '$date_start' AND '$date_end 23:59:59'
				GROUP BY DATE(TanggalResep)
				ORDER BY DATE(TanggalResep)";
				
				$rj_data = [];
				$query_rj = mysqli_query($koneksi, $str_rj);
				if($query_rj){
					while($row = mysqli_fetch_assoc($query_rj)){
						$rj_data[$row['TglResep']] = $row['Jml'];
					}
				}
				
				// Query 2: PIO per tanggal (SIMPLE - tanpa JOIN)
				$str_pio_batch = "SELECT DATE(TanggalResep) as TglResep, COUNT(IdPasienrj) As Jml 
				FROM `$tbresep`
				WHERE TanggalResep BETWEEN '$date_start' AND '$date_end 23:59:59'
				AND Pio <> '' AND Pio IS NOT NULL
				GROUP BY DATE(TanggalResep)";
				
				$pio_data = [];
				$query_pio = mysqli_query($koneksi, $str_pio_batch);
				if($query_pio){
					while($row = mysqli_fetch_assoc($query_pio)){
						$pio_data[$row['TglResep']] = $row['Jml'];
					}
				}
				
				// Query 3: Item Obat per tanggal (SIMPLE - hanya dari resepdetail)
				$str_itemobat_batch = "SELECT DATE(TanggalResep) as TglResep, COUNT(KodeBarang) As Jml 
				FROM `$tbresepdetail`
				WHERE TanggalResep BETWEEN '$date_start' AND '$date_end 23:59:59'
				GROUP BY DATE(TanggalResep)";
				
				$itemobat_data = [];
				$query_itemobat = mysqli_query($koneksi, $str_itemobat_batch);
				if($query_itemobat){
					while($row = mysqli_fetch_assoc($query_itemobat)){
						$itemobat_data[$row['TglResep']] = $row['Jml'];
					}
				}
				
				// Loop hanya untuk display
				$no = 0;
				foreach($rj_data as $tglresep => $rawatjalan){
					$no++;
					$rawatinap = 0;
					$jumlah = $rawatjalan + $rawatinap;
					$jml_pio = isset($pio_data[$tglresep]) ? $pio_data[$tglresep] : 0;
					$jml_itemobat = isset($itemobat_data[$tglresep]) ? $itemobat_data[$tglresep] : 0;
				?>
					<tr style="border:1px solid #000;">
						<td><?php echo $no;?></td>	
						<td><?php echo $tglresep;?></td>	
						<td><?php echo $rawatjalan;?></td>	
						<td>0</td>	
						<td><?php echo $jumlah;?></td>
						<td>0</td>	
						<td><?php echo $jml_pio;?></td>	
						<td><?php echo $jml_itemobat;?></td>	
					</tr>
				<?php
					}
				?>
			</tbody>
		</table><br/>
		
	</div>
</div>

<?php
}
?>

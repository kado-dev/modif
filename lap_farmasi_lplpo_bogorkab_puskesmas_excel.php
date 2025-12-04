<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	
	// get
	$kd = $_GET['kd'];
	$namaprg = $_GET['namaprg'];
	
	$bulan = $_GET['bulan'];
	$bulanlalu = "0".$bulan - 1;
	$tahun = $_GET['tahun'];	
	
	if(strlen($bulanlalu) == 1){		
		$bulanlalu = '0'.$bulanlalu;
		if($bulanlalu == "00"){
			$bulanlalu = '12';
		}	
	}	
		
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Pemakaian & Lembar_Permintaan_Obat (".$namapuskesmas." - ".$bulan." - ".$tahun.").xls");
	if(isset($bulan) and isset($tahun)){
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
</style>

<?php
$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];
?>

<div class="printheader">
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN PEMAKAIAN DAN LEMBAR PERMINTAAN OBAT (LPLPO) <?php echo $sumberanggarans?></b></span><br>
	<span class="font12" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></span>
	<br/>
</div>

<div class="atastabel font11">
	<div style="float:left; width:65%; margin-bottom:10px;">
		<table>
			<tr>
				<td colspan="2">Kode Puskesmas </td>
				<td> : <?php echo $kodepuskesmas?></td>
			</tr>
			<tr>
				<td colspan="2">Nama Puskesmas </td>
				<td> : <?php echo $namapuskesmas?></td>
			</tr>
		</table>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table>
			<tr>
				<td colspan="2">Pelaporan Bulan</td>
				<td> : <?php echo nama_bulan($bulan);?></td>
			</tr>
			<tr>
				<td colspan="2">Permintaan Bulan</td>
				<td> : 
				<?php
				if($bulan < 12){		
					$bulandepan = $bulan + 1;
				}else{
					$bulandepan = 1;
				}	
					echo nama_bulan($bulandepan);
				?>
				</td>
			</tr>
		</table>
	</div>	
</div><br/>

<div class="row noprint">
	<div class="table-responsive text-nowrap noprint">
		<table class="table table-condensed table-fixed" border="1">
			<thead>
				<tr>
					<th rowspan="2">No.</th>
					<th rowspan="2">Kode</th>
					<th rowspan="2">Nama Barang</th>
					<th rowspan="2">Satuan</th>
					<th rowspan="2">Harga<br/>Satuan</th>
					<th colspan="2">Stok Awal</th>
					<th colspan="2">Penerimaan</th>
					<th colspan="2">Persediaan</th>
					<th colspan="2">Pemakaian</th>
					<th colspan="2">Stok Akhir</th>
					<th colspan="2">Permintaan</th>
					<th colspan="2">Pemberian</th>
				</tr>
				<tr>
					<th>APBD</th><!--Stok Awal-->
					<th>JKN</th>
					<th>APBD</th><!--Penerimaan-->
					<th>JKN</th>
					<th>APBD</th><!--Persediaan-->
					<th>JKN</th>
					<th>APBD</th><!--Pemakaian-->
					<th>JKN</th>
					<th>APBD</th><!--Stok Akhir-->
					<th>JKN</th>
					<th>APBD</th><!--Permintaan-->
					<th>JKN</th>
					<th>APBD</th><!--Pemberian-->
					<th>JKN</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($namaprg == "Semua" || $namaprg == ""){
					$namaprg = "";
				}else{
					$namaprg = "WHERE NamaProgram = '$namaprg'";
				}
				
				$str = "SELECT * FROM `ref_obat_lplpo`".$namaprg;
				$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC";
				// echo $str2;
										
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					if($namaprogram != $data['NamaProgram']){
						echo "<tr style='border:1px sollid #000; font-weight: bold;'><td colspan='19'>$data[NamaProgram]</td></tr>";
						$namaprogram = $data['NamaProgram'];
					}	
					
					$no = $no + 1;
					$kodebarang = $data['KodeBarang'];
				
					// tbgfkstok
					$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' ORDER BY IdBarang DESC"));
					
					// tbstokopnam_puskesmas_detail
					$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokopnam_puskesmas_detail` WHERE `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
								
					// tbgudangpkmlplpomanual
					$dtlplpomanual = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmlplpomanual` WHERE `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun' AND `Bulan`='$bulanlalu'"));
												
					// stokawal
					if($bulan == "01"){
						$stokawal_apbd = $dtstokopname['StokAwalApbd'];
						$stokawal_jkn = $dtstokopname['StokAwalJkn'];
					}else{
						$stokawal_apbd = $dtlplpomanual['SisaAkhirApbd'];
						$stokawal_jkn = $dtlplpomanual['SisaAkhirJkn'];
					}	
					
					// penerimaan	
					$penerimaan_apbd = $dtstokopname['PenerimaanApbd_'.$bulan];
					$penerimaan_jkn= $dtstokopname['PenerimaanJkn_'.$bulan];
					
					// persediaan
					$persediaan_apbd = $stokawal_apbd + $penerimaan_apbd;
					$persediaan_jkn= $stokawal_jkn + $penerimaan_jkn;
					
					// pemakaian
					$total_gudang_apbd = $dtstokopname['Pemakaian_Gudang_Apbd_'.$bulan];
					$total_gudang_jkn = $dtstokopname['Pemakaian_Gudang_Jkn_'.$bulan];
					$total_depot_apbd = $dtstokopname['Pemakaian_Depot_Apbd_'.$bulan];
					$total_depot_jkn = $dtstokopname['Pemakaian_Depot_Jkn_'.$bulan];
					$total_igd_apbd = $dtstokopname['Pemakaian_Igd_Apbd_'.$bulan];
					$total_igd_jkn = $dtstokopname['Pemakaian_Igd_Jkn_'.$bulan];
					$total_ranap_apbd = $dtstokopname['Pemakaian_Ranap_Apbd_'.$bulan];
					$total_ranap_jkn = $dtstokopname['Pemakaian_Ranap_Jkn_'.$bulan];
					$total_poned_apbd = $dtstokopname['Pemakaian_Poned_Apbd_'.$bulan];
					$total_poned_jkn = $dtstokopname['Pemakaian_Poned_Jkn_'.$bulan];
					$total_pustu_apbd = $dtstokopname['Pemakaian_Pustu_Apbd_'.$bulan];
					$total_pustu_jkn = $dtstokopname['Pemakaian_Pustu_Jkn_'.$bulan];
					$total_pusling_apbd = $dtstokopname['Pemakaian_Pusling_Apbd_'.$bulan];
					$total_pusling_jkn = $dtstokopname['Pemakaian_Pusling_Jkn_'.$bulan];
					$total_poli_apbd = $dtstokopname['Pemakaian_Poli_Apbd_'.$bulan];
					$total_poli_jkn = $dtstokopname['Pemakaian_Poli_Jkn_'.$bulan];
					$total_lainnya_apbd = $dtstokopname['Pemakaian_Lainnya_Apbd_'.$bulan];
					$total_lainnya_jkn = $dtstokopname['Pemakaian_Lainnya_Jkn_'.$bulan];
					$pemakaian_apbd = $total_gudang_apbd + $total_depot_apbd + $total_igd_apbd + $total_ranap_apbd + $total_poned_apbd + $total_pustu_apbd + $total_pusling_apbd + $total_poli_apbd + $total_lainnya_apbd;
					$pemakaian_jkn = $total_gudang_jkn + $total_depot_jkn + $total_igd_jkn + $total_ranap_jkn + $total_poned_jkn + $total_pustu_jkn + $total_pusling_jkn + $total_poli_jkn + $total_lainnya_jkn;
					
					// stok akhir
					$stokakhir_apbd = $persediaan_apbd - $pemakaian_apbd;
					$stokakhir_jkn= $persediaan_jkn - $pemakaian_jkn;
					
					// permintaan
					$permintaan_apbd_persen = $pemakaian_apbd * 30 / 100;
					$permintaan_apbd = $pemakaian_apbd + $permintaan_apbd_persen;
					$permintaan_jkn_persen = $pemakaian_jkn * 30 / 100;
					$permintaan_jkn = $pemakaian_jkn + $permintaan_jkn_persen;
					
				
				
					
				?>
					<tr style="border:1px sollid #000;">
						<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center; border:1px sollid #000; padding:3px;" class="kodecls"><?php echo $data['KodeBarang'];?></td>
						<td style="text-align:left; border:1px sollid #000; padding:3px;"><?php echo $data['NamaBarang'];?></td>
						<td style="text-align:center; border:1px sollid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
						<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php  echo $dtgfk['HargaBeli'];?></td>
						<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $stokawal_apbd;?></td><!--Stok Awal-->								
						<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $stokawal_jkn;?></td>
						<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $penerimaan_apbd;?></td><!--Penerimaan-->
						<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $penerimaan_jkn;?></td>
						<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $persediaan_apbd;?></td><!--Persediaan-->
						<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $persediaan_jkn;?></td>
						<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $pemakaian_apbd;?></td><!--Pemakaian-->
						<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $pemakaian_jkn;?></td>
						<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $stokakhir_apbd;?></td><!--Stok AKhir-->
						<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $stokakhir_jkn;?></td>
						<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $permintaan_apbd;?></td><!--Permintaan-->
						<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $permintaan_jkn;?></td>
						<td style="text-align:right; border:1px sollid #000; padding:3px;">-</td><!--Pemberian-->
						<td style="text-align:right; border:1px sollid #000; padding:3px;">-</td>
					</tr>
				<?php
					}
				?>		
			</tbody>
		</table>
	</div>
</div><br/>
<div class="bawahtabel">
	<table width="100%">
		<tr>
			<td></td>
			<td colspan="3" style="text-align:center;">
				<b>YANG MEMINTA <br/>
				KEPALA PUSKESMAS</b>
				<br>
				<br>
				<br>
				<br>
				<br>
				(_________________________________________)
			</td>
			<td></td>
			<td colspan="3" style="text-align:center;"></td>
			<td></td>
			<td colspan="3" style="text-align:center;">
				<b>YANG MENERIMA <br/>
				PENGELOLA OBAT PUSKESMAS <?php echo $namapuskesmas;?></b>
				<br>
				<br>
				<br>
				<br>
				<br>
				(_________________________________________)
			</td>
			<td></td>
			<td></td>
		</tr>
	</table>
</div>
<?php
}
?>
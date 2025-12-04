<?php
	error_reporting(0);
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	include_once('config/helper_pasienrj.php');
	session_start();
	$hariini = date('d-m-Y');
	
	// get data
	$bulanawal = $_GET['bulanawal'];
	$bulanakhir = $_GET['bulanakhir'];
	$tahunakhir = $_GET['tahunakhir'];
	$namaprogram = $_GET['namaprogram'];
	$key = $_GET['key'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Penerimaan_Item_Barang (".$kota." ".$hariini.").xls");	
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
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN PENERIMAAN ITEM BARANG</b></span><br>
	<span class="font12" style="margin:1px;">Periode Laporan: <?php echo nama_bulan(date('m'))." ".date('Y');?></span>
</div><br/>

<?php						
	if($key != ""){
		$namabarang = " AND `NamaBarang` like '%$key%'";
	}else{
		$namabarang = "";
	}
	
	if($namaprogram == "semua"){
		$str = "SELECT * FROM `ref_obat_lplpo` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%')";
	}else{
		$str = "SELECT * FROM `ref_obat_lplpo` WHERE `NamaProgram`='$namaprogram'".$namabarang;
	}
	$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC";
	
	// if(isset($bulanawal) and isset($tahunawal)){
	if(isset($bulanawal) and isset($tahunakhir)){
	$array_bln = array('00','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des');
?>
<div class="row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table table-condensed" border="1">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="17%">Nama Obat & BMHP</th>
						<th>Tahun<br/>Pengadaan</th>
						<th>Batch</th>
						<th width="8%">ED</th>
						<th width="7%">Harga<br/>Satuan</th>
						<?php
							for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
								echo "<th width='4%'>".$array_bln[$b]."</th>";
							}
						?>
						<th>Total Penerimaan</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					if($namaprogram != $data['NamaProgram']){
						if($data['NamaProgram'] == "PKD"){
							$prg = "OBAT (PKD)";	
						}
						echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='20'>$prg</td></tr>";
						$namaprogram = $data['NamaProgram'];
					}
					
					$no = $no + 1;
					$kodebarang = $data['KodeBarang'];
					$nobatch = $data['NoBatch'];
					
					// Penerimaan bulan
					$bln['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE (MONTH(a.TanggalPenerimaan)>='01' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='01' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
					$bln['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE (MONTH(a.TanggalPenerimaan)>='02' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='02' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
					$bln['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE (MONTH(a.TanggalPenerimaan)>='03' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='03' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
					$bln['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE (MONTH(a.TanggalPenerimaan)>='04' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='04' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
					$bln['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE (MONTH(a.TanggalPenerimaan)>='05' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='05' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
					$bln['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE (MONTH(a.TanggalPenerimaan)>='06' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='06' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
					$bln['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE (MONTH(a.TanggalPenerimaan)>='07' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='07' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
					$bln['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE (MONTH(a.TanggalPenerimaan)>='08' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='08' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
					$bln['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE (MONTH(a.TanggalPenerimaan)>='09' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='09' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
					$bln['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE (MONTH(a.TanggalPenerimaan)>='10' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='10' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
					$bln['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE (MONTH(a.TanggalPenerimaan)>='11' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='11' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
					$bln['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE (MONTH(a.TanggalPenerimaan)>='12' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND (MONTH(a.TanggalPenerimaan)<='12' AND YEAR(a.TanggalPenerimaan)='$tahunakhir') AND b.KodeBarang = '$kodebarang'"));
				
				?>
					<tr>
						<td align="center"><?php echo $no;?></td>												
						<td align="left">
							<?php 
								echo "<b>".strtoupper($data['NamaBarang'])."</b>".$data['KodeBarang'];
							?>
						</td>									
						<td align="center">
							<?php 
								$noth = 0;
								$str_ta = "SELECT `TahunAnggaran` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'";
								$query_ta = mysqli_query($koneksi,$str_ta);
								while($datata = mysqli_fetch_assoc($query_ta)){
									$noth = $noth + 1;
									// echo $datata['TahunAnggaran']."<br/>";
									echo str_replace(".", "| ", $noth.". ".$datata['TahunAnggaran'])."<br/>";
								}
							?>
						</td>							
						<td align="left">
							<?php 
								$nobt = 0;
								$str_batch = "SELECT `NoBatch` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'";
								$query_batch = mysqli_query($koneksi,$str_batch);
								while($databatch = mysqli_fetch_assoc($query_batch)){
									$nobt = $nobt + 1;
									echo str_replace(".", "| ", $nobt.". ".$databatch['NoBatch'])."<br/>";
								}
							?>
						</td>							
						<td align="center">
							<?php 
								$noed = 0;
								$str_ed = "SELECT `Expire` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'";
								$query_ed = mysqli_query($koneksi,$str_ed);
								while($dataed = mysqli_fetch_assoc($query_ed)){
									$noed = $noed + 1;
									echo str_replace(".", "| ", $noed.". ".date("d-m-Y", strtotime($dataed['Expire'])))."<br/>";
								}
							?>
						</td>
						<td align="left">
							<?php 
								$nohb = 0;
								$str_hb = "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'";
								$query_hb = mysqli_query($koneksi,$str_hb);
								while($datahb = mysqli_fetch_assoc($query_hb)){
									$nohb = $nohb + 1;
									echo rupiah($datahb['HargaBeli'])."<br/>";
								}
							?>
						</td>		
						<?php
						for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
							$total[$no][] = $bln[$b]['Jumlah'];
						?>		
						<td align="right">
							<?php 
								if($bln[$b]['Jumlah'] == ""){
									echo "0";
								}else{
									echo rupiah($bln[$b]['Jumlah']);
								}
							?>
						</td>	
						<?php
							}
							$total = array_sum($total[$no]);
						?>							
						<td align="right"><?php echo rupiah($total);?></td>							
					</tr>
				<?php
				}
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
	}
?>
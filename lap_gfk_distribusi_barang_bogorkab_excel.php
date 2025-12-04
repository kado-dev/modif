<?php
	error_reporting(0);
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	include_once('config/helper_pasienrj.php');
	session_start();
	$hariini = date('d-m-Y');
	
	// get data
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$namaprg = $_GET['namaprg'];
	$key = $_GET['key'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Distribusi_Item_Barang (".$kota." ".$hariini.").xls");	
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
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN DISTRIBUSI ITEM BARANG</b></span><br>
	<span class="font12" style="margin:1px;">Periode Laporan: <?php echo nama_bulan(date('m'))." ".date('Y');?></span>
</div><br/>

<?php
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];	
	$namaprg = $_GET['namaprg'];
	$key = $_GET['key'];
						
	if($key != ""){
		$namabarang = " AND `NamaBarang` like '%$key%'";
	}else{
		$namabarang = "";
	}
	
	if($namaprg == "semua"){
		$str = "SELECT * FROM `ref_obat_lplpo` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%')";
	}else{
		$str = "SELECT * FROM `ref_obat_lplpo` WHERE `NamaProgram`='$namaprg'".$namabarang;
	}
	$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC";
	
	if(isset($keydate1) and isset($keydate2)){
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
						<th width="5%">Tahun<br/>Pengadaan</th>
						<th width="10%">Batch</th>
						<th width="10%">ED</th>
						<th width="8%">Harga<br/>Satuan</th>
						<th width="12%">Sumber</br>Anggaran</th>
						<th width="8%">Saldo</br>Awal</th>
						<th>Penerimaan</th>
						<?php
							$bulanawal = date('m', strtotime($keydate1));
							$bulanakhir = date('m', strtotime($keydate2));
							for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
								echo "<th width='3%'>".$array_bln[$b]."</th>";
							}
						?>
						<th width="10%">Total Pemakaian</th>
						<th width="10%">Saldo Akhir</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					if($namaprograms != $data['NamaProgram']){
						if($data['NamaProgram'] == "PKD"){
							$prg = "OBAT (PKD)";	
						}
						echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='23'>$prg</td></tr>";
						$namaprograms = $data['NamaProgram'];
					}
					
					$no = $no + 1;
					$kodebarang = $data['KodeBarang'];
					
					// pengeluaran bulan
					$bln['1']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
					$bln['2']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
					$bln['3']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
					$bln['4']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
					$bln['5']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
					$bln['6']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
					$bln['7']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
					$bln['8']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
					$bln['9']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
					$bln['10']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
					$bln['11']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
					$bln['12']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
								WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
				
				?>
					<tr>
						<td align="center"><?php echo $no;?></td>									
						<td align="left">
							<?php 
								echo "<b>".strtoupper($data['NamaBarang'])."</b><br/>".$data['KodeBarang'];
							?>
						</td>									
						<td align="center">
							<?php 
								$noth = 0;
								$str_ta = "SELECT `TahunAnggaran` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$data[NamaProgram]'";
								$query_ta = mysqli_query($koneksi,$str_ta);
								while($datata = mysqli_fetch_assoc($query_ta)){
									$noth = $noth + 1;
									echo str_replace(",", ", ", "(".$noth.") ".$datata['TahunAnggaran'])."<br/>";
								}
							?>
						</td>							
						<td align="left">
							<?php 
								$nobt = 0;
								$str_batch = "SELECT `NoBatch` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$data[NamaProgram]'";
								$query_batch = mysqli_query($koneksi,$str_batch);
								while($databatch = mysqli_fetch_assoc($query_batch)){
									$nobt = $nobt + 1;
									$nobatcharr[$no][] = $databatch['NoBatch'];
									echo str_replace(",", "<br/> ", "(".$nobt.") ".$databatch['NoBatch'])."<br/>";
								}
							?>
						</td>							
						<td align="center">
							<?php 
								$noed = 0;
								$str_ed = "SELECT `Expire` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$data[NamaProgram]'";
								$query_ed = mysqli_query($koneksi,$str_ed);
								while($dataed = mysqli_fetch_assoc($query_ed)){
									$noed = $noed + 1;
									echo str_replace(",", ", ", "(".$noed.") ".date("d-m-Y", strtotime($dataed['Expire'])))."<br/>";
								}
							?>
						</td>
						<td align="left">
							<?php 
								$nohb = 0;
								$str_hb = "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$data[NamaProgram]'";
								$query_hb = mysqli_query($koneksi,$str_hb);
								while($datahb = mysqli_fetch_assoc($query_hb)){
									$nohb = $nohb + 1;
									echo str_replace(",", ", ", "(".$nohb.") ".rupiah($datahb['HargaBeli']))."<br/>";
								}
							?>
						</td>		
						<td align="left">
							<?php 
								$nosb = 0;
								$str_sb = "SELECT `SumberAnggaran` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$data[NamaProgram]'";
								$query_sb = mysqli_query($koneksi,$str_sb);
								while($datasb = mysqli_fetch_assoc($query_sb)){
									$nosb = $nosb + 1;
									echo str_replace(",", ", ", "(".$nosb.") ".$datasb['SumberAnggaran'])."<br/>";
								}
							?>
						</td>
						<td align="right">
							<?php
							// tahap2, menentukan stok awal stok / saldo awal (update 29 Juli 2021)
							$str_stokawal = "SELECT SUM(Stok) AS Stok FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$data[NamaProgram]'";
							// echo $str_stokawal;
							$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
							if ($dt_stokawal_dtl['Stok'] != ''){
								$stokawal = $dt_stokawal_dtl['Stok'];
							}else{
								$stokawal = '0';
							}
															
							// tahap2.1 cek jika 0, hitung jumlah penerimaan bulan sebelumnya
							$str_terima_lalu = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah 
							FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
							WHERE a.`KodeBarang`='$kodebarang' AND a.`NamaProgram`='$data[NamaProgram]' AND b.TanggalPenerimaan < '$keydate1'";
							// echo $str_terima_lalu;
							$dt_terima_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_terima_lalu));									
							if ($dt_terima_lalu['Jumlah'] != null || $dt_terima_lalu['Jumlah'] != 0){
								$penerimaan_lalu = $dt_terima_lalu['Jumlah'];
							}else{
								$penerimaan_lalu = '0';
							}

							// tahap2.2 cek pengeluaran sebelumnya
							$str_pengeluaran_lalu = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
							JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
							WHERE a.`KodeBarang`='$kodebarang' AND a.`NamaProgram`='$data[NamaProgram]' AND b.TanggalPengeluaran < '$keydate1'";	
							// echo $str_pengeluaran_lalu;
							$dt_pengeluaran_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu));									
							if ($dt_pengeluaran_lalu['Jumlah'] != null){
								$pengeluaran_lalu = $dt_pengeluaran_lalu['Jumlah'];
							}else{
								$pengeluaran_lalu = '0';
							}	
							
							$stokawal_total = $stokawal + $penerimaan_lalu - $pengeluaran_lalu;
							echo rupiah($stokawal_total)."<br/>";
							// echo "Stok Awal : ".$stokawal."<br/>";
							// echo "Terima : ".$penerimaan_lalu."<br/>";
							// echo "Keluar : ".$pengeluaran_lalu."<br/>";
							?>
						</td>
						<td align="right">
							<?php
								$strpenerimaan = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` a
								JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NamaProgram`='$data[NamaProgram]' AND b.TanggalPenerimaan BETWEEN '$keydate1' AND '$keydate2'";
								$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
								if ($dtpenerimaan['Jumlah'] != null || $dtpenerimaan['Jumlah'] != 0){
									$penerimaan = $dtpenerimaan['Jumlah'];
								}else{
									$penerimaan = '0';
								}	
								echo rupiah($penerimaan);
							?>
						</td>
						<?php
						$bulanawal = date('m', strtotime($keydate1));
						$bulanakhir = date('m', strtotime($keydate2));
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
							// $total = array_sum($total[$no]);
							$arrbatch = $nobatcharr[$no];
						?>							
						<td align="right"><?php echo rupiah(array_sum($total[$no]));?></td>	
						<td align="right">								
							<?php
								$pengeluaran_total = array_sum($total[$no]);
								$sisaakhir = $stokawal_total + $penerimaan - $pengeluaran_total;
								echo $sisaakhir;
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
</div>
<?php
	}
?>
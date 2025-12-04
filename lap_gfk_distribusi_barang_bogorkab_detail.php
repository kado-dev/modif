<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	// include "config/helper.php";
	include "config/helper_report.php";
	$tanggal = date('d-m-Y');
	$kodebarang = $_GET['kd'];
	$namabarang = $_GET['namabrg'];
	$nobatch = $_GET['batch'];
	$namaprogram = $_GET['namaprg'];
	$namaprogram2 = $_GET['namaprg2'];
	$key = $_GET['key'];
	$keydatesatu = $_GET['keydate1'];
	$keydatedua = $_GET['keydate2'];
	$bulanawal = date('m', strtotime($_GET['keydate1']));
	$bulanakhir = date('m', strtotime($_GET['keydate2']));	
	$tahun = date('Y', strtotime($_GET['keydate1']));	
	// echo "tahun : ".$tahun;
	
?>
<style>
.table-judul-laporan>thead>tr>th {
	padding-top:15px;
	padding-bottom:15px;
	background:#939393;
	color:#fff;
	text-align:center;
	vertical-align:middle;
	border:1px solid #000;
	font-size: 12px;
	font-family: "Poppins", sans-serif;
}
.table-judul-laporan>tbody>tr>td {
	background:#fff;
	padding:5px;			
	border: 1px solid;  
	border-color:#000;
}
</style>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<a href="index.php?page=lap_gfk_distribusi_barang_bogorkab&keydate1=<?php echo $keydatesatu;?>&keydate2=<?php echo $keydatedua;?>&namaprg=<?php echo $namaprogram2;?>&key=<?php echo $key;?>" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>DETAIL DISTRIBUSI BARANG</b></h3>
			<a href="lap_gfk_distribusi_barang_bogorkab_detail_excel.php?kd=<?php echo $kodebarang;?>&keydate1=<?php echo $keydatesatu;?>&keydate2=<?php echo $keydatedua;?>&namaprg=<?php echo $namaprogram;?>&key=<?php echo $key;?>&namabrg=<?php echo $namabarang;?>" class="btn btn-sm btn-info pull-right" style="margin-bottom: 15px;">Excel</a>
			<div class="row font10">
				<div class="col-sm-12">
					<div class="table-responsive">
						<table class="table-judul-laporan" width="100%">
							<thead>
								<tr>
									<th width="2%">No.</th>
									<th width="5%">Kode</th>
									<th width="25%">Nama Barang</th>
									<th width="10%">Penerimaan</th>
								</tr>
							</thead>
							<tbody style="font-size: 12px;">
							<?php
							// tahap 1, panggil tbgfkstok
							$str = "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'";
							$query = mysqli_query($koneksi,$str);
							$data = mysqli_fetch_assoc($query);	
							
							// tahap2, menentukan stok awal stok / saldo awal (update 13 Agustus 2021)
							$str_stokawal = "SELECT SUM(Stok) AS Stok FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang'";
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
							WHERE a.`KodeBarang`='$kodebarang' AND a.`NamaProgram`='$namaprogram' AND b.TanggalPenerimaan < '$keydatesatu'";								
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
							WHERE a.`KodeBarang`='$kodebarang' AND a.`NamaProgram`='$namaprogram' AND b.TanggalPengeluaran < '$keydatesatu'";
								
							// echo $str_pengeluaran_lalu;
							$dt_pengeluaran_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu));									
							if ($dt_pengeluaran_lalu['Jumlah'] != null){
								$pengeluaran_lalu = $dt_pengeluaran_lalu['Jumlah'];
							}else{
								$pengeluaran_lalu = '0';
							}	
							
							$stokawal_total = $stokawal + $penerimaan_lalu - $pengeluaran_lalu;	
							// echo "Stok Awal : ".$stokawal."<br/>";
							// echo "Terima : ".$penerimaan_lalu."<br/>";
							// echo "Keluar : ".$pengeluaran_lalu."<br/>";				
							
							// penerimaan tahun ini
							$strterima = "SELECT a.TanggalPenerimaan, b.KodeBarang, SUM(b.Jumlah)AS Jumlah 
							FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
							WHERE (MONTH(a.TanggalPenerimaan)>='$bulanawal' AND YEAR(a.TanggalPenerimaan)='$tahun') AND 
							(MONTH(a.TanggalPenerimaan)<='$bulanakhir' AND YEAR(a.TanggalPenerimaan)='$tahun') AND b.KodeBarang = '$kodebarang'";
							$dtterima = mysqli_fetch_assoc(mysqli_query($koneksi, $strterima));
							
							$jmlpenerimaan = $stokawal_total + $dtterima['Jumlah'];
							?>
								<tr>
									<td align="center"></td>							
									<td align="center"><?php echo $data['KodeBarang'];?></td>									
									<td align="left"><?php echo $data['NamaBarang'];?></td>			
									<td align="right"><?php echo rupiah($jmlpenerimaan);?></td>	
								</tr>
								<tr style="background: #ddd">
									<td align="center"></td>							
									<td colspan="2" align="center"><b>UNIT PENERIMA</b></td>		
									<td colspan="1" align="center"><b>JUMLAH</b></td>	
								</tr>
							<?php
								$no = 0;
								$str2 = "SELECT b.Penerima, SUM(a.Jumlah) as Jumlah FROM `tbgfkpengeluarandetail` a 
								JOIN `tbgfkpengeluaran` b ON a.IdDistribusi = b.IdDistribusi 
								WHERE a.KodeBarang = '$data[KodeBarang]' AND YEAR(b.TanggalPengeluaran) = '$tahun'
								AND MONTH(b.TanggalPengeluaran) BETWEEN '$bulanawal' AND '$bulanakhir' GROUP BY b.Penerima";
								// echo $str2;
								$query2 = mysqli_query($koneksi,$str2);
								while($data2 = mysqli_fetch_assoc($query2)){	
									$no = $no + 1;
							?>
								<tr style="background: aqua">
									<td align="center"><?php echo $no;?></td>							
									<td colspan="2" align="left"><?php echo $data2['Penerima'];?></td>		
									<td colspan="1" align="right"><?php echo $data2['Jumlah'];?></td>
								</tr>
							<?php
								$jmlpenrimas[] = $data2['Jumlah'];
									}
							//}	
							?>
								<tr style="font-weight:bold;">
									<td align="center"></td>							
									<td colspan="2" align="center">JUMLAH</td>		
									<td colspan="1" align="right"><?php echo rupiah(array_sum($jmlpenrimas));?></td>	
								</tr>
								<tr style="font-weight:bold;">
									<td align="center"></td>							
									<td colspan="2" align="center">SISA</td>		
									<td colspan="1" align="right"><?php echo rupiah($jmlpenerimaan - array_sum($jmlpenrimas));?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
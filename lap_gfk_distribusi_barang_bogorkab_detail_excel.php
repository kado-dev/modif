<?php
	error_reporting(0);
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
	// get data
	$kodebarang = $_GET['kd'];
	$namabarang = $_GET['namabrg'];
	$nobatch = $_GET['batch'];
	$namaprogram = $_GET['namaprg'];
	$key = $_GET['key'];
	$keydatesatu = $_GET['keydate1'];
	$keydatedua = $_GET['keydate2'];
	$bulanawal = date('m', strtotime($_GET['keydate1']));
	$bulanakhir = date('m', strtotime($_GET['keydate2']));	
	$tahun = date('Y', strtotime($_GET['keydate1']));
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Distribusi_Barang (".strtoupper($namabarang).").xls");
	// if(isset($bulanawal) and isset($tahunakhir)){
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
.font22{
	font-size:22px;
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
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>DETAIL DISTRIBUSI BARANG </b></span><br>
	<!--<span class="font12" style="margin:1px;">
		Periode Laporan: <?php echo nama_bulan($bulanawal)." s/d ".nama_bulan($bulanakhir)." ".$tahunakhir;?>
	</span>-->
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1" width="100%">
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
		</table><br/>
	</div>
</div>
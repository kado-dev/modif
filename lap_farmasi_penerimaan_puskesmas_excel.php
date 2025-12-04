<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$tahunini = date('Y');
	// get
	$namaprg = $_GET['namaprg'];
	$bulanawal = $_GET['bulanawal'];
	$bulanakhir = $_GET['bulanakhir'];
	$tahun = $_GET['tahun'];
	$tbstokopnam = 'tbstokopnam_puskesmas_'.str_replace(' ', '', $namapuskesmas);	
		
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Penerimaan_Obat (".$namapuskesmas." ".$bulanawal." sd ".$bulanakhir." ".$tahun.").xls");
	if(isset($bulanawal) and isset($tahun)){
	$array_bln = array('00','JAN','FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES');
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

<div class="printheader">
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN PENERIMAAN OBAT & PERBEKALAN KESEHATAN</b></span><br>
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>TAHUN ANGGARAN <?php echo $tahunawal;?></b></span><br>
	<span class="font12" style="margin:1px;">Periode Laporan: <?php echo $tahunini;?></span>
</div><br/>

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
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="3%" rowspan="2">NO.</th>
					<?php if($bulanakhir > 6){ ?>
						<th width="12%" rowspan="2">NAMA OBAT & BMHP</th>
					<?php }else{ ?>
						<th width="20%" rowspan="2">NAMA OBAT & BMHP</th>
					<?php }?>
					<th rowspan="2">SATUAN</th>
					<th rowspan="2">HARGA<br/>SATUAN</th>
					<?php
						for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
							echo "<th colspan='2'>".$array_bln[$b]."</th>";
						}
					?>
					<th colspan="2" width="10%">TOTAL</th>
					<th rowspan="2" width="10%">TOTAL<br/>PENERIMAAN</th>
					<th rowspan="2" width="10%">TOTAL<br/>HARGA</th>
				</tr>
				<tr>
					<?php
						for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
							echo "<th>"."APBD"."</th>";
							echo "<th>"."JKN"."</th>";
						}
					?>
					<th>APBD</th>
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
				
				// ref_obat_lplpo 					
				$str = "SELECT * FROM `ref_obat_lplpo`".$namaprg;
				$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC";
				// echo $str2;
														
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					if($namaprogram != $data['NamaProgram']){
						echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='32'>$data[NamaProgram]</td></tr>";
						$namaprogram = $data['NamaProgram'];
					}	
				
					$no = $no + 1;
					$kodebarang = $data['KodeBarang'];
					$namabarang = $data['NamaBarang'];
					$satuan = $data['Satuan'];
					
					// tbgfkstok
					$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli`,`Expire`,`NoBatch` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' ORDER BY IdBarang DESC"));
					$harga = $dtgfk['HargaBeli'];
					if(empty($harga)){$harga = "0";}								
					
					// penerimaan
					if($data['NamaProgram'] != "VAKSIN"){
					$bln_penerimaan_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='01' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='02' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='03' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='04' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='05' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='06' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='07' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='08' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='09' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='10' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='11' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluaran` a JOIN `tbgfkpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='12' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					}else{
					$bln_penerimaan_apbd['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='01' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='02' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='03' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='04' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='05' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='06' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='07' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='08' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='09' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='10' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='11' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					$bln_penerimaan_apbd['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluaran` a JOIN `tbgfk_vaksin_pengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE YEAR(a.`TanggalPengeluaran`)='$tahun' AND MONTH(a.`TanggalPengeluaran`)='12' AND a.`KodePenerima`='$kodepuskesmas' AND b.`KodeBarang`='$kodebarang'"));
					}
					// penerimaan jkn
					$bln_penerimaan_jkn['1'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_01 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
					$bln_penerimaan_jkn['2'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_02 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
					$bln_penerimaan_jkn['3'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_03 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
					$bln_penerimaan_jkn['4'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_04 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
					$bln_penerimaan_jkn['5'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_05 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
					$bln_penerimaan_jkn['6'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_06 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
					$bln_penerimaan_jkn['7'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_07 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
					$bln_penerimaan_jkn['8'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_08 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
					$bln_penerimaan_jkn['9'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_09 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
					$bln_penerimaan_jkn['10'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_10 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
					$bln_penerimaan_jkn['11'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_11 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
					$bln_penerimaan_jkn['12'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT PenerimaanJkn_12 AS Jumlah FROM `$tbstokopnam` WHERE KodeBarang = '$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));	
					
					
				?>
					<tr>
						<td align="center"><?php echo $no;?></td>			
						<td class="namabarangcls" align="left"><?php echo strtoupper($namabarang);?></td>								
						<td align="center"><?php echo $satuan;?></td>
						<td align="right"><?php echo rupiah($harga);?></td>
						<?php
						for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
							$totalapbd[$no][] = $bln_penerimaan_apbd[$b]['Jumlah'];
							$totaljkn[$no][] = $bln_penerimaan_jkn[$b]['Jumlah'];
						?>		
						<td align="right">
							<?php 
								if($bln_penerimaan_apbd[$b]['Jumlah'] == ""){
									echo "0";
								}else{
									echo rupiah($bln_penerimaan_apbd[$b]['Jumlah']);
								}
							?>
						</td>
						<td align="right">
							<?php 
								if($bln_penerimaan_jkn[$b]['Jumlah'] == ""){
									echo "0";
								}else{
									echo rupiah($bln_penerimaan_jkn[$b]['Jumlah']);
								}
							?>
						</td>
						<?php
							}
							$total_apbd = array_sum($totalapbd[$no]);
							$total_jkn = array_sum($totaljkn[$no]);
							$total = $total_apbd + $total_jkn;
							$totalrupiah = $total * $harga;
						?>
						<td align="right"><?php echo rupiah($total_apbd);?></td>
						<td align="right"><?php echo rupiah($total_jkn);?></td>								
						<td align="right"><?php echo rupiah($total);?></td>		
						<td align="right"><?php echo rupiah($totalrupiah);?></td>			
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
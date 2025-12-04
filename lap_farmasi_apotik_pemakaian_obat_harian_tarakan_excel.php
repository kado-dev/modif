<?php
	error_reporting(0);
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$namapuskesmas = $_SESSION['namapuskesmas'];	
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
	$ref_obat_lplpo = "ref_obat_lplpo_".str_replace(' ', '', $namapuskesmas);
	$hariini = date('d-m-Y');
	// get
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$loketobat = $_GET['loketobat'];

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=PEMAKAIAN OBAT HARIAN (".$bulan." ".$tahun.").xls");
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
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN PEMAKAIAN OBAT HARIAN</b></span><br>
	<span class="font12" style="margin:15px 5px 5px 5px;">Periode Laporan: <?php echo $tahun;?></span><br>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th>NO.</th>
					<th>NAMA BARANG</th>
					<th>SATUAN</th>
					<?php
						$bln = $_GET['bulan'];
						$thn = $_GET['tahun'];
						$mulai = 1;
						$selesai = 31;
						for($d = $mulai;$d <= $selesai; $d++){	
					?>
						<th><?php echo $d;?></th>
					<?php
						}
					?>
					<th>JUMLAH</th>
				</tr>
			</thead>
			<tbody style="font-size: 12px;">
				<?php				
				$str = "SELECT * FROM `$ref_obat_lplpo`";
				$str2 = $str." ORDER BY `NamaBarang` ASC";
				// echo $str2;
								
				if($loketobat == 'semua'){
					$loketobats = "";
				}elseif($loketobat == 'LOKET LANSIA'){
					$loketobats = " AND Depot = 'LOKET LANSIA'";
				}elseif($loketobat == 'LOKET OBAT'){
					$loketobats = " AND Depot = 'LOKET OBAT'";
				}
				
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
				?>
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo $data['KodeBarang'];?></td>
						<td align="left"><?php echo strtoupper($data['NamaBarang']);?></td>
						<td align="center"><?php echo strtoupper($data['Satuan']);?></td>
						<?php
							$jml2 = 0;	
							for($d2= $mulai;$d2 <= $selesai; $d2++){	
								$tanggal = $thn."-".$bln."-".$d2;
								$strs = "SELECT SUM(jumlahobat) as jumlah FROM `$tbresepdetail`
								WHERE `KodeBarang` = '$data[KodeBarang]' AND date(TanggalResep) = '$tanggal'".$loketobats;
								// echo $strs;
								$jml = mysqli_fetch_assoc(mysqli_query($koneksi,$strs));
								$jml2 = $jml2 + $jml['jumlah'];
						?>	
							<td align="right"><a href="?page=lap_farmasi_apotik_pemakaian_obat_harian_tarakan_detail&tgl=<?php echo $tanggal;?>&kdbrg=<?php echo $data['KodeBarang'];?>&sts=<?php echo $loketobat;?>" style="color: black" target="_blank"><?php echo number_format($jml['jumlah']);?></a></td>
						<?php
							}
						?>
						<td align="right"><?php echo number_format($jml2);?></td>
					</tr>
				<?php
				}
				?>
					<tr>
						<td>#</td>
						<td colspan="2">Total</td>
					<?php
						$jmls = 0;
						for($d3= $mulai;$d3 <= $selesai; $d3++){	
							$tanggal = $thn."-".$bln."-".$d3;
							$strs2 = "SELECT SUM(jumlahobat) as jumlah FROM `$tbresepdetail` WHERE date(TanggalResep) = '$tanggal'".$loketobats." GROUP BY `NoResep`,`Pelayanan`";
							$countall = mysqli_fetch_assoc(mysqli_query($koneksi,$strs2));		
							$jmls = $jmls + $countall['jumlah'];
					?>	
						<td align="right"><?php echo number_format($countall['jumlah']);?></td>
					<?php
						}
					?>	
						<td align="right"><?php echo number_format($jmls);?></td>
					</tr>
			</tbody>
		</table>
	</div>
</div>
<?php
}
?>
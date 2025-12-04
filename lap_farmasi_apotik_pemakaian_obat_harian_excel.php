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
					<th>No.</th>
					<th>Kode</th>
					<th>Nama Barang</th>
					<th>Sumber Anggaran</th>
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
					<th>Jumlah</th>
				</tr>
			</thead>
			<tbody style="font-size: 12px;">
				<?php
				if($kota == "KOTA TARAKAN"){
					$str1 = "SELECT a.TanggalResep, a.KodeBarang, b.NamaBarang, b.Satuan, c.NamaObatJkn FROM `$tbresepdetail` a 
					LEFT JOIN `$ref_obat_lplpo` b ON a.KodeBarang = b.KodeBarang
					LEFT JOIN `ref_obat_jkn` c ON a.KodeBarang = c.KodeObatJkn
					WHERE YEAR(a.Tanggalresep)='$tahun' AND MONTH(a.Tanggalresep)='$bulan' AND b.NamaBarang != ''";
					$str2 = $str1." GROUP BY `KodeBarang` ORDER BY `KodeBarang` ASC";
				}else{
					$str1 = "SELECT * FROM `$tbresepdetail`
					WHERE YEAR(Tanggalresep)='$tahun' AND MONTH(Tanggalresep)='$bulan'";
					$str2 = $str1." GROUP BY `KodeBarang` ORDER BY `KodeBarang` ASC";
				}	
				// echo $str2;
				
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					if(substr($data['KodeBarang'],0,3) == "JKN"){
						$dtbarang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_obat_jkn` WHERE `KodeObatJkn`='$data[KodeBarang]'"));
						$namabarang = $dtbarang['NamaObatJkn'];
						$sumberanggaran = 'JKN';
					}else{
						$dtbarang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbapotikstok` WHERE `KodeBarang`='$data[KodeBarang]'"));
						$namabarang = $dtbarang['NamaBarang'];
						$sumberanggaran = $dtbarang['SumberAnggaran'];
					}

				?>
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo $data['KodeBarang'];?></td>
						<td align="left"><?php echo strtoupper($namabarang);?></td>
						<td align="center"><?php echo $sumberanggaran;?></td>
						<?php
							$jml2 = 0;	
							for($d2= $mulai;$d2 <= $selesai; $d2++){	
								$tanggal = $thn."-".$bln."-".$d2;
								$strs = "SELECT SUM(jumlahobat) as jumlah FROM `tbresepdetail_replika`
								WHERE `KodeBarang` = '$data[KodeBarang]' AND date(TanggalResep) = '$tanggal'";
								// echo $strs;
								$jml = mysqli_fetch_assoc(mysqli_query($koneksi,$strs));
								$jml2 = $jml2 + $jml['jumlah'];
						?>	
							<td align="right" style="color: black"><?php echo $jml['jumlah'];?></a></td>
						<?php
							}
						?>
						<td align="right"><?php echo $jml2;?></td>
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
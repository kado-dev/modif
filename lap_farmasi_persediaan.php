<?php
session_start();
include "config/koneksi.php";
include "config/helper_report.php";
include "otoritas.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$namapuskesmas = $_SESSION['namapuskesmas'];	
$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
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
	display: none;
	font-family: 'Ubuntu', sans-serif;
}
.printheader h4{
	font-size:18px;
	font-family: 'Ubuntu', sans-serif;
}
.printheader p{
	font-size:18px;
	font-family: 'Ubuntu', sans-serif;
}
.printbody{
	margin-left:0px;
	margin-right:0px;
	
}
.table-responsive{
	font-family: 'Ubuntu', sans-serif;
}
.atastabel{
	display:none;
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
	font-family: 'Ubuntu', sans-serif;
}
.font11{
	font-size:11px;
	font-family: 'Ubuntu', sans-serif;
}
.font12{
	font-size:12px;
	font-family: 'Ubuntu', sans-serif;
}
.font16{
	font-size:16px;
	font-family: 'Ubuntu', sans-serif;
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

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>PERSEDIAAN BARANG</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_persediaan"/>
						<div class="col-sm-1 bulanformcari" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2018 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="sumberanggaran" class="form-control">
								<option value="">Semua</option>
								<option value="APBD" <?php if($_GET['sumberanggaran'] == 'APBD'){echo "SELECTED";}?>>APBD</option>
								<option value="APBN" <?php if($_GET['sumberanggaran'] == 'APBN'){echo "SELECTED";}?>>APBN</option>
								<option value="BLUD" <?php if($_GET['sumberanggaran'] == 'BLUD'){echo "SELECTED";}?>>BLUD</option>
							</select>
						</div>
						<?php
						if($_SESSION['kodepuskesmas'] == '-'){
						?>
							<div class="col-sm-2">
								<select name="kodepuskesmas" class="form-control">
								<option value='semua'>Semua</option>
								<?php
								$kota = $_SESSION['kota'];
								$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `Kota`='$kota' order by `NamaPuskesmas`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
								}
								?>
								</select>
							</div>
						<?php
						}
						?>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_persediaan" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="lap_farmasi_persediaan_excel.php?tahun=<?php echo $_GET['tahun'];?>&sumberanggaran=<?php echo $_GET['sumberanggaran'];?>" class="btn btn-sm btn-info">Excel</a>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>

	<?php
	$tahun = $_GET['tahun'];
	$tahunlalu = $_GET['tahun'] - 1;
	$thn = substr($tahun,-2);
	$sumberanggaran = $_GET['sumberanggaran'];
	if($sumberanggaran != ''){
		$sumberanggarans = "(".$sumberanggaran.")";
	}else{
		$sumberanggarans = "";
	}

	if(isset($tahun)){
	?>

	<div class="printheader">
		<span class="font16" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN PERSEDIAAN BARANG <?php echo $sumberanggarans?></b></span><br>
		<span class="font12" style="margin:1px;">Periode Laporan: <?php echo $tahun;?></span>
		<br/>
	</div>

	<div class="table-responsive noprint">
		<table class="table-judul-laporan">
			<thead>
				<tr>
					<th width="3%" rowspan="2">No.</th>
					<th width="5%" rowspan="2">Kode</th>
					<th width="20%" rowspan="2">Nama Barang</th>
					<th width="5%" rowspan="2">Satuan</th>
					<th width="10%" rowspan="2">Stok Awal</th>
					<th width="10%" rowspan="2">Penerimaan</th>
					<th colspan="2">Ketersediaan</th>
					<th width="10%" rowspan="2">Persediaan</th>
					<th width="10%" rowspan="2">Pemakaian</th>
					<!--<th width="10%">Sisa Stok</th>-->
				</tr>
				<tr>
					<th width="10%">Gudan<br/>Obat</th>
					<th width="10%">Depot<br/>Obat</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$jumlah_perpage = 20;
							
				if($_GET['h']==''){
					$mulai=0;
				}else{
					$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
				
				$str = "SELECT * FROM `ref_obat_lplpo`";
				$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang`";
				// echo $str2;
				
				if($_GET['h'] == null || $_GET['h'] == 1){
					$no = 0;
				}else{
					$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
				
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					if($namaprogram != $data['NamaProgram']){
						echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='11'>$data[NamaProgram]</td></tr>";
						$namaprogram = $data['NamaProgram'];
					}
					$no = $no + 1;
					$kodebarang = $data['KodeBarang'];
					$namabarang = $data['NamaBarang'];
					$satuan = $data['Satuan'];
					
					// stok awal
					$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Jumlah FROM `tbrko_pkm_sisastok` WHERE KodePuskesmas = '$kodepuskesmas' AND KodeBarang = '$kodebarang' AND Tahun = '$tahunlalu'"))['Jumlah'];
										
					// penerimaan & pengadaan
					$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jml FROM `tbgudangpkmpenerimaan` a JOIN `tbgudangpkmpenerimaandetail` b ON a.NoFaktur = b.NoFaktur WHERE a.`KodePuskesmas`='$kodepuskesmas' AND b.`KodeBarang` = '$kodebarang' AND YEAR(a.TanggalPenerimaan) = '$tahun'"));
					
					// persediaan
					$dtpersediaan = $dtstokawal + $dtpenerimaan['Jml'];
					
					// pemakaian
					$dtpemakaian = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jml FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur WHERE a.`KodePuskesmas`='$kodepuskesmas' AND b.`KodeBarang` = '$kodebarang' AND YEAR(a.TanggalPengeluaran) = '$tahun'"));
					$dtresep = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlahobat) AS Jml FROM `$tbresepdetail` WHERE SUBSTRING(NoResep,1,11)='$kodepuskesmas' AND `KodeBarang` = '$kodebarang' AND SUBSTRING(NoResep,13,2) = '$thn'"));
					$pemakaian_total = $dtpemakaian['Jml'] + $dtresep['Jml'];
					
					// stok
					$gudangobat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Jml FROM `tbgudangpkmstok` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'")); 
					$depotobat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Stok) AS Jml FROM `tbapotikstok` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'")); 
				?>
					<tr style="border:1px solid #000;">
						<td align="left"><?php echo $no;?></td>
						<td align="center"><?php echo $kodebarang;?></td>
						<td align="left"><?php echo $namabarang;?></td>
						<td align="center"><?php echo $satuan;?></td>
						<td align="right"><!--stok awal-->
							<?php
								if($dtstokawal != ""){
									echo rupiah($dtstokawal);
								}else{
									echo 0;
								}
							?>
						</td>
						<td align="right"><!--Penerimaan-->
							<?php
								if($dtpenerimaan['Jml'] != ""){
									echo rupiah($dtpenerimaan['Jml']);
								}else{
									echo 0;
								}
							?>
						</td>
						<td align="right"><?php echo rupiah($gudangobat['Jml']);?></td><!--Gudang Obat-->
						<td align="right"><?php echo rupiah($depotobat['Jml']);?></td><!--Depot Obat-->
						<td align="right"><?php echo rupiah($dtpersediaan);?></td><!--Persediaan-->
						<td align="right"><?php echo rupiah($pemakaian_total);?></td><!--Pemakaian-->
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<div class="bawahtabel font10">
		<table width="100%">
			<tr>
				<td width="10%"></td>
				<td style="text-align:left;">
				Mengetahui<br>
				Kepala UPT/Puskesmas
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				(...................................................................................)<br>
				</td>
				
				
				<td width="10%"></td>
				<td style="text-align:left;">
				Soreang,&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 2018<br>
				Pengurus Barang
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				(...................................................................................)<br>
				</td>
			</tr>
		</table>
	</div>
	<br/>

	<hr class="noprint"><!--css-->
	<ul class="pagination noprint">
		<?php
			$bulan = $_GET['bulan'];
			$tahun = $_GET['tahun'];
			$query2 = mysqli_query($koneksi,$str);
			$jumlah_query = mysqli_num_rows($query2);
			
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = ($jumlah_query / $jumlah_perpage)+1;
			}else{
				$jumlah = $jumlah_query / $jumlah_perpage;
			}
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=lap_farmasi_persediaan&bulan=$bulan&tahun=$tahun&sumberanggaran=$sumberanggaran&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
		}
	?>
</div>	


<div class="hasilmodal"></div>

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.opsiform').change(function(){
		if($(this).val() == 'bulan'){
			$(".bulanformcari").show();
			$(".tanggalformcari").hide();
		}else{	
			$(".bulanformcari").hide();
			$(".tanggalformcari").show();
		}
	});	
});
</script>
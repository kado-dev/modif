<?php
	session_start();
	include "otoritas.php";
	include "config/koneksi.php";
	include "config/helper_report.php";
	if($_GET['sts'] == 'simpan3'){
		$kodeobat = $_POST['kode']; 
		$jml = $_POST['isi']; 
		$kodepuskesmas = $_SESSION['kodepuskesmas'];
		$bulan = $_POST['bulan'];
		if(strlen($bulan) == 1){
			$bulan = '0'.$bulan;
		}
		$tahun = $_POST['tahun'];
		mysqli_query($koneksi,"REPLACE INTO `tbgudangpkmpermintaan`(`Bulan`, `Tahun`, `KodePuskesmas`, `KodeBarang`, `Jumlah`)
		VALUES ('$bulan','$tahun','$kodepuskesmas','$kodeobat','$jml')");
	}else{
		include "otoritas.php";
		$kodepuskesmas = $_SESSION['kodepuskesmas'];
		$namapuskesmas = $_SESSION['namapuskesmas'];
		$kota = $_SESSION['kota'];
		$alamat = $_SESSION['alamat'];
		$tanggal = date('Y-m-d');
	}
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
	/*display: none;*/
}
.printheader h4{
	font-size:18px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:18px;
	font-family: "Bookman Old Style";
}
.printbody{
	margin-left:0px;
	margin-right:0px;
	/*display: none;*/
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	margin-top:10px;
	/*display: none;*/
}
.bawahtabel{
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font9{
	font-size:9px;
	font-family: "Tahoma";
}
.font10{
	font-size:10px;
	font-family: "Tahoma";
}
.font11{
	font-size:11px;
	font-family: "Tahoma";
}
.font12{
	font-size:12px;
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

<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>LPLPO</h1>
		</div>
	</div>
</div>

<!--cari data-->
<div class="row noprint">
	<div class="col-xs-12 col-sm-12">
		<div class="search-area well well-sm">
			<div class = "row">
				<form role="form">
					<input type="hidden" name="page" value="lap_farmasi_lplpo"/>
					<div class="col-sm-2">
						<SELECT name="opsiform" class="form-control opsiform">
							<option value="bulan" <?php if($_GET['opsi'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
							<option value="tanggal" <?php if($_GET['opsi'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
						</SELECT>	
					</div>

					<div class="col-sm-3 tanggalformcari" style="display:none">
						<div class="tampilformdate">
							<input type="text" name="keydate1" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" placeholder = "Tanggal Awal"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" placeholder = "Tanggal Akhir">
						</div>
					</div>	
				
					<div class="col-sm-2 bulanformcari">
						<select name="bulan" class="form-control">
							<option value="01" <?php if($_GET['bulan'] == '01'){echo "SELECTED";}?>>Januari</option>
							<option value="02" <?php if($_GET['bulan'] == '02'){echo "SELECTED";}?>>Februari</option>
							<option value="03" <?php if($_GET['bulan'] == '03'){echo "SELECTED";}?>>Maret</option>
							<option value="04" <?php if($_GET['bulan'] == '04'){echo "SELECTED";}?>>April</option>
							<option value="05" <?php if($_GET['bulan'] == '05'){echo "SELECTED";}?>>Mei</option>
							<option value="06" <?php if($_GET['bulan'] == '06'){echo "SELECTED";}?>>Juni</option>
							<option value="07" <?php if($_GET['bulan'] == '07'){echo "SELECTED";}?>>Juli</option>
							<option value="08" <?php if($_GET['bulan'] == '08'){echo "SELECTED";}?>>Agustus</option>
							<option value="09" <?php if($_GET['bulan'] == '09'){echo "SELECTED";}?>>September</option>
							<option value="10" <?php if($_GET['bulan'] == '10'){echo "SELECTED";}?>>Oktober</option>
							<option value="11" <?php if($_GET['bulan'] == '11'){echo "SELECTED";}?>>November</option>
							<option value="12" <?php if($_GET['bulan'] == '12'){echo "SELECTED";}?>>Desember</option>
						</select>
					</div>
					<div class="col-sm-1 bulanformcari" style ="width:125px">
						<select name="tahun" class="form-control">
							<?php
								for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
								?>
								<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
							<?php }?>
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
						<a href="?page=lap_farmasi_lplpo" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
						<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];
$keydate1 = $_GET['keydate1'];
$keydate2 = $_GET['keydate2'];
$opsiform = $_GET['opsiform'];

if($_SESSION['kodepuskesmas'] == '-'){
	$kdpuskesmas = $_GET['kodepuskesmas'];
	if($kdpuskesmas == 'semua'){
		$semua = " ";
	}else{
		$semua = " AND substring(a.NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
	}
}else{
	$kdpuskesmas = $_SESSION['kodepuskesmas'];
	$semua = " AND substring(a.NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
}
if(isset($bulan) and isset($tahun)){
?>

<div class="printheader">
	<span class="font16" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN PEMAKAIAN DAN LEMBAR PERMINTAAN OBAT (LPLPO)</b></span><br>
	<?php if($opsiform == 'bulan'){ ?>
		<span class="font12" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></span>
	<?php }else{ ?>
		<span class="font12" style="margin:1px;">Periode Laporan: <?php echo $keydate1." s/d ".$keydate2;?></span>
	<?php } ?>
	<br/>
</div>

<?php  
$tanggal = date('d-m-Y');
$tgl = explode("-",$tanggal);
$tgllaporan = $tgl[1] - 1;
$tglpermintaan = $tgl[1];
?>
<div class="atastabel font11">
	<div style="float:left; width:65%; margin-bottom:10px;">
		<table><!--style="margin-top:20px;"-->
			<?php
				$datakecamatan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
			?>
			<tr>
				<td style="padding:2px 4px;">Kode Puskesmas </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $datakecamatan['KodePuskesmas'];?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Nama Puskesmas </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $datakecamatan['NamaPuskesmas'];?></td>
			</tr>
		</table>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table>
			<tr>
				<td style="padding:2px 4px;">Pelaporan Bulan</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"><?php echo nama_bulan($tgllaporan)." ".$tgllaporan[0];?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Permintaan Bulan</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"><?php echo nama_bulan($tglpermintaan)." ".$tgllaporan[0];?></td>
			</tr>
		</table>
	</div>	
</div>

<!--tabel view-->
<div class="printbody font10">	
	<table class="table table-striped table-condensed">
		<thead class="font9">
			<tr>
				<th width="5%"; style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
				<th width="5%"; style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Kode</th>
				<th width="30%"; style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Barang</th>
				<th width="7%"; style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Satuan</th>
				<th width="7%"; style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Stok Awal</th>
				<th width="7%"; style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Penerimaan</th>
				<th width="7%"; style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Persediaan</th>
				<th width="6%"; style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Pemakaian</th>
				<th width="6%"; style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Sisa Akhir</th>
				<th width="6%"; style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Stok Optimum</th>
				<th width="6%"; style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Permintaan</th>
				<th width="10%"; style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Pemberian</th>
				<th width="5%"; style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Ket.</th>
			</tr>
		</thead>
		
		<tbody class="font9">
			<?php
			$jumlah_perpage = 100;
			
			// if($opsiform == 'bulan'){
				// $waktu = "YEAR(TanggalRegistrasi) = '$tahun'";
				// $tbpasienrj = 'tbpasienrj_'.$bulan;
				// $tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
			// }else{
				// $waktu = "TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2'";
				// $tbdiagnosapasien = 'tbdiagnosapasien';
				// $str1 = mysqli_query($koneksi, "SELECT * FROM `tbdiagnosapasien` WHERE TanggalDiagnosa BETWEEN '$keydate1' AND '$keydate2'");
				// while($data = mysqli_fetch_assoc($str1)){
					// $bln = substr($data['NoRegistrasi'],14,2);
					// $tbpasienrj = 'tbpasienrj_'.$bln;
					// // echo $tbpasienrj;
				// }
			// }
			
			if($_GET['h']==''){
				$mulai=0;
			}else{
				$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$str = "SELECT * FROM `tbgudangpkmstok` a 
			JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang JOIN `tbobatkelompok` c ON b.GolonganFungsi = c.KelompokObat
			WHERE a.KodePuskesmas='$kodepuskesmas'";
			$str2 = $str." order by c.`KodeKelompok`,b.NamaBarang ASC limit $mulai,$jumlah_perpage";
			
			if($_GET['h'] == null || $_GET['h'] == 1){
				$no = 0;
			}else{
				$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			$golonganfungsi = "";
			
			$query = mysqli_query($koneksi,$str2);
			while($data = mysqli_fetch_assoc($query)){
			if($golonganfungsi != $data['GolonganFungsi']){
				echo "<tr style='border:1px dashed #000;'><td colspan='13'>$data[GolonganFungsi]</td></tr>";
				$golonganfungsi = $data['GolonganFungsi'];
			}
			
			$no = $no + 1;
			$kodebarang = $data['KodeBarang'];
			
			// untuk awal ngambil dari tbstokbulanangop dan tbstokbulananapotik
			// bulan selanjutnya ngambil di tbstokbulananpuskesmas
			// stok awal gudang obat puskesmas
			$stokawalpuskesmas = mysqli_query($koneksi, "SELECT Stok FROM `tbstokbulananpuskesmas` WHERE KodePuskesmas='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun' AND KodeBarang='$kodebarang'");
			if(mysqli_num_rows($stokawalpuskesmas) == 0){
					$stokawal_gop = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Stok FROM `tbstokbulanangop` WHERE KodePuskesmas='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun' AND KodeBarang='$kodebarang'"));
					if($stokawal_gop['Stok'] != ''){
						$stok_gop = $stokawal_gop['Stok'];
					}else{
						$stok_gop = 0;
					}
					// stok awal apotik/loketobat
					$stokawal_apotik = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Stok FROM `tbstokbulananapotik` WHERE KodePuskesmas='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun' AND KodeBarang='$kodebarang'"));
					if($stokawal_apotik['Stok'] != ''){
						$stok_apotik = $stokawal_apotik['Stok'];
					}else{
						$stok_apotik = 0;
					}
					$ttlstokawal = $stok_gop + $stok_apotik;
			}else{
				$ttlstokawal = mysqli_fetch_assoc($stokawalpuskesmas)['Stok'];
			}
			// penerimaan
			$penerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Jumlah FROM `tbgudangpkmpenerimaandetail` a join tbgudangpkmpenerimaan b on a.NoFaktur = b.NoFaktur WHERE MONTH(b.TanggalPenerimaan) = '$bulan' AND YEAR(b.TanggalPenerimaan) = '$tahun' AND a.KodePuskesmas='$kodepuskesmas' AND a.KodeBarang='$kodebarang'"));
			if($penerimaan['Jumlah'] != ''){
				$terima = $penerimaan['Jumlah'];
			}else{
				$terima = 0;
			}
			
			// persediaan
			$persediaan = $ttlstokawal + $terima;
						
			// pemakaian
			$tahun_2digit = substr($tahun,2,2);
			$pemakaian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(jumlahobat)AS jml FROM tbresepdetail 
			WHERE SUBSTRING(Noresep,1,11)='$kodepuskesmas' AND SUBSTRING(NoResep,13,2)='$tahun_2digit' 
			AND SUBSTRING(NoResep,15,2)='$bulan' AND KodeBarang='$kodebarang'"));
			
			// sisa
			$sisa = $persediaan - $pemakaian['jml'];
			$stokoptimum = $sisa * 1.6;
			
			// permintaan
			$st3 = "SELECT `Jumlah` as jml FROM `tbgudangpkmpermintaan` WHERE `Bulan` = '$bulan' AND `Tahun` = '$tahun' AND `KodePuskesmas` = '$kodepuskesmas' AND `KodeBarang` = '$kodebarang'";
			$permintaan = mysqli_fetch_assoc(mysqli_query($koneksi,$st3));
			
			if($permintaan['jml'] != ''){
				$permintaans = $permintaan['jml'];
			}else{
				$permintaans = 0;
			}
			
			//insert ket tbstok awal
				if($bulan == 12){
					$blnberikutnya = 01;
					$thnberikutnya = $tahun+1;
				}else{
					$blnberikutnya = $bulan+1;
					if(strlen($blnberikutnya) == 1){
						$blnberikutnya = '0'.$blnberikutnya;
					}
					$thnberikutnya = $tahun;
				}
				mysqli_query($koneksi,"REPLACE INTO `tbstokbulananpuskesmas`(`Bulan`, `Tahun`, `KodePuskesmas`, `KodeBarang`, `Stok`)
				VALUES ('$blnberikutnya','$thnberikutnya','$kodepuskesmas','$data[KodeBarang]','$sisa')");
			?>
				<tr style="border:1px dashed #000;">
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;" class="kodecls"><?php echo $data['KodeBarang'];?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['NamaBarang'];?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['Satuan'];?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $ttlstokawal;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $terima;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $persediaan;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $pemakaian['jml'];?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $sisa;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $stokoptimum;?></td>
					<td style="text-align:right; border:1px dashed #000; padding:3px; background-color:#dbf7ff;" class="permintaancls"><?php echo $permintaans;?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['SumberAnggaran'];?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;">-</td>
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
			<td style="text-align:center;">
			Diterima Oleh
			<br>
			<br>
			<br>
			(..............................)
			</td>
			
			
			<td width="10%"></td>
			<td style="text-align:center;">
			Diserahkan Oleh
			<br>
			<br>
			<br>
			(..............................)
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
					echo "<li><a href='?page=lap_farmasi_lplpo&keydate1=$keydate1&keydate2=$keydate2&opsiform=$opsiform&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
				}
			}
		}
	?>	
</ul>
<?php
}
?>

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
$('.opsiform').change(function(){
	if($(this).val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}else{	
		$(".bulanformcari").hide();
		$(".tanggalformcari").show();
	}
});	

$(".permintaancls").dblclick(function(){
	var isi = $(this).text();
	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var bulan = <?php echo $_GET['bulan'];?>;
		var tahun = <?php echo $_GET['tahun'];?>;
		var isi = $(this).val();
			
		var kode = $(this).parent().parent().find(".kodecls").text();
		$.post( "lap_farmasi_lplpo.php?sts=simpan3", { isi:isi,kode:kode,tahun:tahun,bulan:bulan});
		$(this).parent().html(isi);
	});
});
</script>
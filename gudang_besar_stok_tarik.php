<?php
	include "otoritas.php";
	$tanggal = date('d-m-Y');
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
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
}
.printheader h4{
	font-size:16px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:16px;
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

<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Tarik Stok Awal Gudang Besar</h1>
		</div>
	</div>
</div>

<!--cari data-->
<div class="row noprint">
	<div class="col-xs-12 col-sm-12">
		<div class="search-area well well-sm">
			<div class="search-filter-header bg-primary">
				<h4 class="panel-title"><i class="fa fa-search"></i> Cari Data</h4>
			</div>
			<div class="space-10"></div>
			<div class = "row">
				<form role="form">
					<input type="hidden" name="page" value="gudang_besar_stok_tarik"/>
					<div class="col-sm-2">
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
					<div class="col-sm-2">
						<select name="tahun" class="form-control">
							<?php
								for($tahun = 2015 ; $tahun <= date('Y'); $tahun++){
								?>
								<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
							<?php }?>
						</select>
					</div>
					<div class="col-sm-4">
						<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
						<a href="?page=gudang_besar_stok_tarik" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
						<a href="?page=gudang_besar_stok_tarik_proses" class="btn btn-sm btn-danger">Eksport</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];

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
	<?php
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `KodePuskesmas` = '$kodepuskesmas'"));
	$kota1 = $datapuskesmas['Kota'];
	$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` where `Kota` = '$kota1'"));
	?>
		<?php 
		if($kdpuskesmas == 'semua'){
		?>
			<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
			<h4 style="margin:5px;"><b><?php echo $namapuskesmas;?></b></h4>
			<p style="margin:5px;"><?php echo $alamat;?></p>
		<?php
		}else{
		?>
			<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$datapuskesmas['Kota'];?></b></h4>
			<h4 style="margin:5px;"><b><?php echo $datadinas['NamaDinkes'];?></b></h4>
			<h4 style="margin:5px;"><b><?php echo $datapuskesmas['NamaPuskesmas'];?></b></h4>
			<p style="margin:5px;"><?php echo $datapuskesmas['Alamat']?></p>
		<?php	
		}
		?>
		<hr style="margin:3px; border:1px solid #000">
		<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN PSIKOTROPIKA</b></h4>
		<p style="margin:1px;">Periode Laporan: <?php echo $tanggal?></p>
		<br/>
</div>
<div class="row font10">
	<div class="col-sm-12">
		<table class="table table-condensed">
			<thead style="font-size:10px;">
				<tr style="border:1px dashed #000;">
					<th rowspan="2" style="text-align:center;width:0.2%;vertical-align:middle; border:1px dashed #000; padding:3px;">No</th>
					<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Kode</th>
					<th rowspan="2" style="text-align:center;width:3.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Barang</th>
					<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Satuan</th>
					<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Sumber</th>
					<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Stok Awal</th>
					<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Pemasukan</th>
					<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Persediaan</th>
					<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Pemakaian</th>
					<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">Sisa Stok</th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
			<?php
				// gudang besar
				// $str = "SELECT * FROM `tbgfkstok` WHERE `GolonganFungsi` like '%PSIKOTROPIKA%'";
				$str = "SELECT * FROM `tbgfkstok` WHERE `KelasTherapy` = 'OBAT' AND `SumberAnggaran` like '%APBD%'";
				$str2 = $str." order by NamaBarang";
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kodebarang = $data['KodeBarang'];
					$namabarang = $data['NamaBarang'];
					$stok_gb = $data['Stok'];
					
					$stokawal = 0;
					$persediaan = 0;
					$pemasukan = 0;
					
					// stokawal
					$str_stokawal = "SELECT `Stok` FROM tbstokbulanangudangbsr
					WHERE Bulan='$bulan' AND Tahun='$tahun' AND KodeBarang='$kodebarang'";
					$query_stokawal = mysqli_query($koneksi, $str_stokawal);
					$dt_stokawal = mysqli_fetch_assoc($query_stokawal);
					if ($dt_stokawal['Stok'] != ''){$stokawal = $dt_stokawal['Stok'];}else{$stokawal = 0;}
					
					// penerimaan atau pemasukan
					$str_terima = "SELECT `Jumlah` FROM tbgfkpenerimaandetail a JOIN tbgfkpenerimaan b ON a.NomorPembukuan = b.NomorPembukuan
					WHERE MONTH(b.TanggalPenerimaan)='$bulan' AND YEAR(b.TanggalPenerimaan)='$tahun' AND a.KodeBarang='$kodebarang'";
					$query_terima = mysqli_query($koneksi, $str_terima);
					$dt_terima = mysqli_fetch_assoc($query_terima);
					if ($dt_terima['Jumlah'] != ''){
						$pemasukan = $dt_terima['Jumlah'];
					}else{
						$pemasukan = 0;
					}
					$persediaan = $stokawal + $pemasukan;
					
					// pemakaian
					$str_pakai = "SELECT SUM(`Jumlah`)AS Jumlah FROM tbgfkpengeluarandetail a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur
					WHERE MONTH(b.TanggalPengeluaran)='$bulan' AND YEAR(b.TanggalPengeluaran)='$tahun' AND a.KodeBarang='$kodebarang'";
					$query_pakai = mysqli_query($koneksi, $str_pakai);
					$dt_pakai= mysqli_fetch_assoc($query_pakai);
					if ($dt_pakai['Jumlah'] != ''){$pemakaian = $dt_pakai['Jumlah'];}else{$pemakaian = 0;}				
					$sisastok = $persediaan - $pemakaian;
					
					// tbstokbulanangudangbsr
					$bulan1 = $bulan + 1;
					if($bulan1 <= 12){
						if (strlen($bulan1)=='2'){
							$bulan2 = $bulan1;
						}else{
							$bulan2 = "0".$bulan1;
						}
						$tahun2 = $tahun;
					}else{
						$bulan2 = "01";
						$tahun2 = $tahun + 1;
					}					
															
					$str_obat = "INSERT INTO `tbstokbulanangudangbsr`(`Bulan`,`Tahun`,`KodeBarang`,`Stok`)
					values  ('$bulan2','$tahun2','$kodebarang','$sisastok')";//$pemasukan
					mysqli_query($koneksi,$str_obat);
					?>
					<tr>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $kodebarang;?></td>
						<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $namabarang;?></td>
						<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Satuan'];?></td>
						<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['SumberAnggaran'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $stokawal;?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $pemasukan;?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $persediaan;?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $pemakaian;?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $sisastok;?></td><!--$pemasukan-->
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

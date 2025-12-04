
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

<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Stok Awal <small> GO Puskesmas</small></h1>
		</div>
	</div>
</div>

<!--cari data-->
<div class="row noprint">
	<div class="col-xs-12 col-sm-12">
		<div class="search-area well well-sm">
			<div class = "row">
				<form role="form">
					<input type="hidden" name="page" value="lap_farmasi_gudangpuskesmas_stok_awal"/>
					<div class="col-sm-4">
						<input type="text" name="namabarang" class="form-control nama_barang_gudang_puskesmas" placeholder="Ketikan Nama Barang">
						<input type="hidden" name="kodebarang" class="form-control kodebarang" readonly>			
					</div>
					<div class="col-sm-1" style ="width:125px">
						<select name="tahun" class="form-control">
							<?php
								for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
								?>
								<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
							<?php }?>
						</select>
					</div>
					<div class="col-sm-6">
						<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
						<a href="?page=lap_farmasi_gudangpuskesmas_stok_awal" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
						<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>

<?php
$namabarang = $_GET['namabarang'];
$kodebarang = $_GET['kodebarang'];
$tahun = $_GET['tahun'];
if($namabarang != null){
?>

<!--data cara bayar-->
<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namauskesmas;?></b></span><br>
		<span class="font11" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN STOK OBAT PUSKESMAS</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
		<br/>
</div>

<div class="atastabel font11">
	<?php
		$datakecamatan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
	?>
	<div style="float:left; width:65%; margin-bottom:10px;">
		<table>
			<tr>
				<td style="padding:2px 4px;">Kode Puskesmas</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $kodepuskesmas;?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Nama Puskesmas</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $namapuskesmas;?></td>
			</tr>
		</table>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table>
			<tr>
				<td style="padding:2px 4px;">Kelurahan</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"><?php echo $kelurahan;?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Kecamatan</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"><?php echo $kecamatan;?></td>
			</tr>
		</table>
	</div>	
</div>

<div class="printbody font10">
	<table class="table table-condensed">
		<thead style="font-size:10px;">
			<tr style="border:1px solid #000;">
				<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
				<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kode Barang</th>
				<th width="35%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Barang</th>
				<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Satuan</th>
				<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Periode</th>
				<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
			</tr>
		</thead>
		
		<!--tbstokbulananapotik-->
		<tbody style="font-size:10px;">
			<?php
			$str = "SELECT a.KodeBarang, b.NamaBarang, b.Satuan, a.Bulan, a.Tahun, a.Stok
			FROM `tbstokbulananpuskesmas` a
			JOIN `tbgfkstok` b ON a.KodeBarang =  b.KodeBarang
			WHERE a.KodePuskesmas = '$kodepuskesmas' AND a.`KodeBarang` = '$kodebarang' AND a.`Tahun` = '$tahun'
			ORDER BY b.NamaBarang, a.Bulan";
			// echo $str;
			$query = mysqli_query($koneksi,$str);
			
			while($data = mysqli_fetch_assoc($query)){
			$no = $no + 1;
			?>
				<tr style="border:1px solid #000;">
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['KodeBarang'];?></td>	
					<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaBarang'];?></td>	
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Satuan'];?></td>	
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Bulan']." - ".$data['Tahun'];?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($data['Stok']);?></td>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
<?php
}
?>
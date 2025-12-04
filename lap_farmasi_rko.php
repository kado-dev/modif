<?php
include "config/koneksi.php";
session_start();
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$kodeobat = $_POST['kode']; 
$jml = $_POST['isi']; 
$tahun = $_POST['tahun'];
	
if($_GET['sts'] == 'simpan_sisastok'){
	mysqli_query($koneksi,"REPLACE INTO `tbrko_pkm_sisastok`(`KodePuskesmas`, `Tahun`, `KodeBarang`, `Jumlah`)
	VALUES ('$kodepuskesmas','$tahun','$kodeobat','$jml')");
}else if($_GET['sts'] == 'simpan_pemakaianrata'){
	mysqli_query($koneksi,"REPLACE INTO `tbrko_pkm_pemakaianrata`(`KodePuskesmas`, `Tahun`, `KodeBarang`, `Jumlah`)
	VALUES ('$kodepuskesmas','$tahun','$kodeobat','$jml')");
}else if($_GET['sts'] == 'simpan_pengadaan'){
	mysqli_query($koneksi,"REPLACE INTO `tbrko_pkm_rencana`(`KodePuskesmas`, `Tahun`, `KodeBarang`, `Jumlah`)
	VALUES ('$kodepuskesmas','$tahun','$kodeobat','$jml')");
}else if($_GET['sts'] == 'simpan_realisasi'){
	mysqli_query($koneksi,"REPLACE INTO `tbrko_pkm_realisasi`(`KodePuskesmas`, `Tahun`, `KodeBarang`, `Jumlah`)
	VALUES ('$kodepuskesmas','$tahun','$kodeobat','$jml')");
}else{
	$tanggal = date('d-m-Y');
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
?>
<link rel="stylesheet" type="text/css" href="assets/css/f_laporan.css">

<div class="tableborderdiv">
	<div class="row search-page noprint" id="search-page-1">
		<div class="col-xs-12">
			<h3 class="judul">RKO PUSKESMAS</h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_rko"/>
						<div class="col-sm-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2018 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
									<!--<option value="2020" <?php //if($_GET['tahun'] == '2020'){echo "SELECTED";}?>>2020</option>-->
							</select>	
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_rko" class="btn btn-success btn-white"><span class="fa fa-refresh"></span></a>
							<a href="lap_farmasi_rko_excel.php?tahun=<?php echo $_GET['tahun'];?>" class="btn btn-info btn-white">Excel</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
	$tahun = $_GET['tahun'];
	$tahun1 = $tahun - 1;

	if(isset($tahun)){
	?>

	<div class="row font10">
		<div class="col-sm-12">
			<table class="table-judul-laporan" width="100%">
				<thead style="font-size:12px;">
					<tr style="border:1px sollid #000;">
						<th rowspan="2">No</th>
						<th rowspan="2">Kode</th>
						<th rowspan="2">Nama Barang</th>
						<th rowspan="2">Satuan</th>
						<th>Sisa Stok per 31 Desember <?php echo $tahun1?></th>
						<th>Pemakaian Rata2 Per Bulan Tahun <?php echo $tahun1?></th>
						<th>Jumlah Kebutuhan Tahun <?php echo $tahun?></th>
						<th>Rencana Kebutuhan Tahun <?php echo $tahun?></th>
						<th>Rencana Pengadaan Tahun <?php echo $tahun?></th>
						<th>Realisasi Pengadaan Tahun <?php echo $tahun1?></th>
						<th>Keterangan</th>
					</tr>
					<tr style="border:1px sollid #000;">
						<th>(a)</th>
						<th style="text-align:center;width:0.4%;vertical-align:middle; border:1px sollid #000; padding:3px;">(b)</th>
						<th>(c) = (b) x 18</th>
						<th>(d) = (c) - (a)</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody style="font-size:12px;">
				<?php
					// gudang obat puskesmas
					// $str = "SELECT * FROM `tbgudangpkmstok`a JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang
					// WHERE b.`SumberAnggaran` <> 'BLUD' AND a.`KodePuskesmas`='$kodepuskesmas' GROUP BY b.NamaBarang";
					// $str2 = $str." order by b.NamaBarang";
					
					$str = "SELECT * FROM `ref_obat_lplpo`";
					$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang`";
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						if($namaprogram != $data['NamaProgram']){
							echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='11'>$data[NamaProgram]</td></tr>";
							$namaprogram = $data['NamaProgram'];
						}	
						$no = $no + 1;
						$kodebarang = $data['KodeBarang'];
						$namabarang = $data['NamaBarang'];
					
						// Sisa Stok 1 Tahun Sebelumnya
						$sisa_stok = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Jumlah FROM `tbrko_pkm_sisastok` WHERE KodePuskesmas = '$kodepuskesmas' AND KodeBarang = '$kodebarang' AND Tahun = '$tahun1'"))['Jumlah'];
						
						// pemakaian rata2 1 Tahun Sebelumnya
						$pemakaian_rata = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Jumlah FROM `tbrko_pkm_pemakaianrata` WHERE KodePuskesmas = '$kodepuskesmas' AND KodeBarang = '$kodebarang' AND Tahun = '$tahun1'"))['Jumlah'];
						$jumlah_kebutuhan = $pemakaian_rata * 18;
						$rencana_kebutuhan = $jumlah_kebutuhan - $sisa_stok;
						
						$rencana_pengadaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Jumlah FROM `tbrko_pkm_rencana` WHERE KodePuskesmas = '$kodepuskesmas' AND KodeBarang = '$kodebarang' AND Tahun = '$tahun'"))['Jumlah'];
						$rencana_realisasi = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Jumlah FROM `tbrko_pkm_realisasi` WHERE KodePuskesmas = '$kodepuskesmas' AND KodeBarang = '$kodebarang' AND Tahun = '$tahun1'"))['Jumlah'];
					?>
						<tr>
							<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px sollid #000; padding:3px;" class="kodebarangs"><?php echo $kodebarang;?></td>
							<td style="text-align:left; border:1px sollid #000; padding:3px;"><?php echo $namabarang;?></td>
							<td style="text-align:center; border:1px sollid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
							<td style="text-align:right; border:1px sollid #000; padding:3px; background-color:#dbf7ff;" class="sisastok"><?php echo $sisa_stok;?></td>
							<td style="text-align:right; border:1px sollid #000; padding:3px; background-color:#dbf7ff;" class="pemakaianrata"><?php echo $pemakaian_rata;?></td>
							<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $jumlah_kebutuhan;?></td>
							<td style="text-align:right; border:1px sollid #000; padding:3px;"><?php echo $rencana_kebutuhan;?></td>
							<td style="text-align:right; border:1px sollid #000; padding:3px; background-color:#dbf7ff;" class="rencanapengadaan"><?php echo $rencana_pengadaan;?></td>
							<td style="text-align:right; border:1px sollid #000; padding:3px; background-color:#dbf7ff;" class="rencanarealisasi"><?php echo $rencana_realisasi;?></td>
							<td style="text-align:center; border:1px sollid #000; padding:3px;">-</td>
						</tr>
				<?php
				}
				?>
				</tbody>
			</table>
		</div>
	</div><br/>
	<div class="row noprint">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p><b>Perhatikan :</b> Setelah input data RKO jangan lupa export data Excel</p>
			</div>
		</div>
	</div>
	<?php
		}
	}
	?>
</div>	

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
$(".sisastok").dblclick(function(){
	var isi = $(this).text();
	var lokasi = $(this).parent();

	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var tahun = <?php echo $tahun1;?>;
		var isi = $(this).val();
	
		var kode = $(this).parent().parent().find(".kodebarangs").text();
		$.post( "lap_farmasi_rko.php?sts=simpan_sisastok", { isi:isi,kode:kode,tahun:tahun});
		$(this).parent().html(isi);
	});
});

$(".pemakaianrata").dblclick(function(){
	var isi = $(this).text();
	var lokasi = $(this).parent();

	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var tahun = <?php echo $tahun1;?>;
		var isi = $(this).val();
	
		var kode = $(this).parent().parent().find(".kodebarangs").text();
		$.post( "lap_farmasi_rko.php?sts=simpan_pemakaianrata", { isi:isi,kode:kode,tahun:tahun});
		$(this).parent().html(isi);
	});
});

$(".rencanapengadaan").dblclick(function(){
	var isi = $(this).text();
	var lokasi = $(this).parent();

	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var tahun = <?php echo $tahun;?>;
		var isi = $(this).val();
	
		var kode = $(this).parent().parent().find(".kodebarangs").text();
		$.post( "lap_farmasi_rko.php?sts=simpan_pengadaan", { isi:isi,kode:kode,tahun:tahun});
		$(this).parent().html(isi);
	});
});

$(".rencanarealisasi").dblclick(function(){
	var isi = $(this).text();
	var lokasi = $(this).parent();

	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var tahun = <?php echo $tahun1;?>;
		var isi = $(this).val();
	
		var kode = $(this).parent().parent().find(".kodebarangs").text();
		$.post( "lap_farmasi_rko.php?sts=simpan_realisasi", { isi:isi,kode:kode,tahun:tahun});
		$(this).parent().html(isi);
	});
});
</script>
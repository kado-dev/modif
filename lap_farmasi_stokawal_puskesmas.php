<?php
	session_start();
	include "config/helper_report.php";
	include "config/koneksi.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$kodeobat = $_POST['kode'];
	$bulan = '09';	
	$tahun = $_POST['tahun'];	
	$Jumlahisi = $_POST['isi'];
	
	if($_GET['sts'] == 'simpan_apbd'){
		mysqli_query($koneksi,"UPDATE `tbstokopnam_puskesmas_detail` SET `StokAwalApbd`='$Jumlahisi' WHERE `KodeBarang`='$kodeobat' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'");
	}else if($_GET['sts'] == 'simpan_jkn'){
		mysqli_query($koneksi,"UPDATE `tbstokopnam_puskesmas_detail` SET `StokAwalJkn`='$Jumlahisi' WHERE `KodeBarang`='$kodeobat' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'");
	}
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>STOK AWAL</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_stokawal_puskesmas"/>
						<div class="col-sm-3">
							<div class="input-group">
								<select name="namaprogram" class="form-control">
									<option value="PKD" <?php if($_GET['bulan'] == 'PKD'){echo "SELECTED";}?>>PKD</option>
									<option value="BMHP" <?php if($_GET['bulan'] == 'BMHP'){echo "SELECTED";}?>>BMHP</option>
								</select>	
								<span class="input-group-addon">Program</span>
							</div>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_stokawal_puskesmas" class="btn btn-success btn-white"><span class="fa fa-refresh"></span></a>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>
	
	<?php		
		$tahun = date('Y');
		$tahunlalu = $tahun - 1;
		$kodepuskesmas = $_SESSION['kodepuskesmas'];
		$namaprogram = $_GET['namaprogram'];
		
		if(isset($tahun)){
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr>
							<th width="2%" rowspan="2">No.</th>
							<th width="3%" rowspan="2">Kode</th>
							<th width="15%" rowspan="2">Nama Obat & BMHP</th>
							<th width="5%" rowspan="2">Satuan</th>
							<th colspan="2">Stok Awal (31 Desember <?php echo $tahunlalu;?>)</th>
						</tr>
						<tr>
							<th width="5%">APBD</th><!--Jan-->
							<th width="5%">JKN</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// ini buat insert pertama kali saja
						$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbstokopnam_puskesmas_detail` WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas'"));
						if ($cek == 0){			
							$query1 = mysqli_query($koneksi, "SELECT * FROM `ref_obat_lplpo`");
							while($data = mysqli_fetch_assoc($query1)){
								$str1 = "INSERT INTO `tbstokopnam_puskesmas_detail`(`Bulan`,`Tahun`,`KodePuskesmas`,`KodeBarang`,`StokAwalApbd`,`StokAwalJkn`,
								`PenerimaanApbd_01`,`PenerimaanJkn_01`,`PenerimaanApbd_02`,`PenerimaanJkn_02`,`PenerimaanApbd_03`,`PenerimaanJkn_03`,
								`PenerimaanApbd_04`,`PenerimaanJkn_04`,`PenerimaanApbd_05`,`PenerimaanJkn_05`,`PenerimaanApbd_06`,`PenerimaanJkn_06`,
								`PenerimaanApbd_07`,`PenerimaanJkn_07`,`PenerimaanApbd_08`,`PenerimaanJkn_08`,`PenerimaanApbd_09`,`PenerimaanJkn_09`,
								`PenerimaanApbd_10`,`PenerimaanJkn_10`,`PenerimaanApbd_11`,`PenerimaanJkn_11`,`PenerimaanApbd_12`,`PenerimaanJkn_12`,
								`PenerimaanApbd_12_total`,`PenerimaanJkn_12_total`,`Penerimaan_total`,
								`PemakaianApbd`,`PemakaianJkn`,`StokLaluGudang`,`StokLaluDepot`,`StokLaluPoli`,`StokLaluIgd`,`StokLaluRanap`,
								`StokLaluPoned`,`StokLaluPustu`,`StokGudang`,`StokDepot`,`StokPoli`,`StokIgd`,`StokRanap`,`StokPoned`,`StokPustu`,`TotalSisaStokApbd`,
								`TotalSisaStokJkn`,`TotalRupiahApbd`,`TotalRupiahJkn`) 
								VALUES ('$bulan','$tahun','$kodepuskesmas','$data[KodeBarang]','0','0',
								'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0',
								'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0')";
								mysqli_query($koneksi, $str1);
							}
						}
						
						$jumlah_perpage = 20;
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}								
						
						if($namaprogram == "semua" || $namaprogram == ""){
							$program = "";
						}else{
							$program = "WHERE NamaProgram = '$namaprogram'";
						}
						
						$str = "SELECT * FROM `ref_obat_lplpo`".$program;
						$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
												
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							if($namaprogram != $data['NamaProgram']){
								echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='6'>$data[NamaProgram]</td></tr>";
								$namaprogram = $data['NamaProgram'];
							}		
						
							$no = $no + 1;
							$kodebarang = $data['KodeBarang'];
							
							// tbgfkstok
							$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'"));
							
							// stok awal
							$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `StokAwalApbd`,`StokAwalJkn` FROM `tbstokopnam_puskesmas_detail` WHERE `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
								
						?>
							<tr>
								<td align="right"><?php echo $no;?></td>							
								<td align="center" class="kodecls"><?php echo $data['KodeBarang'];?></td>									
								<td align="left"><?php echo $data['NamaBarang'];?></td>									
								<td align="center"><?php echo $data['Satuan'];?></td>							
								<td align="center" style="background-color:#f8d7da;" class="stokawal_apbd" data-isi="<?php echo $dtstokawal['StokAwalApbd'];?>">
									<?php 
										if($dtstokawal['StokAwalApbd'] != 0){
											echo rupiah($dtstokawal['StokAwalApbd']);
										}else{
											echo "-";
										}
									?>
								</td>
								<td align="center" style="background-color:#f8d7da;" class="stokawal_jkn" data-isi="<?php echo $dtstokawal['StokAwalJkn'];?>">
									<?php 
										if($dtstokawal['StokAwalJkn'] != 0){
											echo rupiah($dtstokawal['StokAwalJkn']);
										}else{
											echo "-";
										}
									?>
								</td>						
							</tr>
						<?php	
						}	
						?>
					</tbody>
				</table>
			</div>
		</div>	
	</div><hr/>
	<ul class="pagination">
		<?php
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
						echo "<li><a href='?page=lap_farmasi_stokawal_puskesmas&tahun=$tahun&namaprogram=$namaprogram&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>	
	<?php
		}
	?>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p>
					<b>Keterangan :</b><br/>
					- Silahkan download excel<br/>
					- Buka file excel, lalu isi kolom yang berwarna merah
				</p>
			</div>
		</div>
	</div>
</div>	


<script src="assets/js/jquery.js"></script>
<script type="text/javascript">

$(".stokawal_apbd").dblclick(function(){
	var isi = $(this).text().replace(/[.]/g, "");
	if(isi == "-"){
		isi = "";
	}
	
	var isisebelumnya = parseInt($(this).data('isi'));
	var lokasi = $(this).parent();
	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var tahun = <?php echo $tahun;?>;
		var isi = $(this).val();		
		var kode = $(this).parent().parent().find(".kodecls").text();
		$.post( "lap_farmasi_stokawal_puskesmas.php?sts=simpan_apbd", {isi:isi,kode:kode,tahun:tahun});
		lokasi.find(".stokawal_apbd").data('isi', isi);
		lokasi.find(".stokawal_apbd").html(addCommas(isi));
	});
});	

$(".stokawal_jkn").dblclick(function(){
	var isi = $(this).text().replace(/[.]/g, "");
	if(isi == "-"){
		isi = "";
	}
	
	var isisebelumnya = parseInt($(this).data('isi'));
	var lokasi = $(this).parent();
	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var tahun = <?php echo $tahun;?>;
		var isi = $(this).val();		
		var kode = $(this).parent().parent().find(".kodecls").text();
		$.post( "lap_farmasi_stokawal_puskesmas.php?sts=simpan_jkn", {isi:isi,kode:kode,tahun:tahun});
		lokasi.find(".stokawal_jkn").data('isi', isi);
		lokasi.find(".stokawal_jkn").html(addCommas(isi));
	});
});	

function addCommas(nStr){
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + '.' + '$2');
	}
	return x1 + x2;
}

</script>

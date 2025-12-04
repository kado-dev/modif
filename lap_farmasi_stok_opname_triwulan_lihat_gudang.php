<?php
	session_start();
	include "config/helper_report.php";
	include "config/koneksi.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$nf = $_GET['nf'];
	$unit = $_GET['unit'];
	$bulan = $_GET['bl'];
	$tahun = $_GET['th'];		
	$tahunlalu = $_GET['th'] - 1;		
	$triwulan = $_GET['triwulan'];		
	$bln = $_POST['bulan'];		
	$thn = $_POST['tahun'];		
	$kodeobat = $_POST['kode']; 
	$nobatch = $_POST['batch']; 
	$Jumlahisi = $_POST['isi']; 
	if(strlen($bln) == 1){
		$bln = '0'.$bln;
	}
		
	if($_GET['sts'] == 'simpan'){
		mysqli_query($koneksi,"UPDATE `tbstokopnam_puskesmas_detail` SET `StokGudang`='$Jumlahisi' WHERE `KodeBarang`='$kodeobat' AND `KodePuskesmas`='$kodepuskesmas'");
		// update tbgudangpkmstok
		mysqli_query($koneksi, "UPDATE `tbgudangpkmstok` SET `Stok`='$Jumlahisi' WHERE `KodeBarang`='$kodeobat'  AND `KodePuskesmas`='$kodepuskesmas'");
	}else if($_GET['sts'] == 'simpandepot'){
		mysqli_query($koneksi,"UPDATE `tbstokopnam_puskesmas_detail` SET `StokDepot`='$Jumlahisi' WHERE `KodeBarang`='$kodeobat' AND `KodePuskesmas`='$kodepuskesmas'");
	}else if($_GET['sts'] == 'simpanpoli'){
		mysqli_query($koneksi,"UPDATE `tbstokopnam_puskesmas_detail` SET `StokPoli`='$Jumlahisi' WHERE `KodeBarang`='$kodeobat' AND `KodePuskesmas`='$kodepuskesmas'");	
	}else if($_GET['sts'] == 'simpanigd'){
		mysqli_query($koneksi,"UPDATE `tbstokopnam_puskesmas_detail` SET `StokIgd`='$Jumlahisi' WHERE `KodeBarang`='$kodeobat' AND `KodePuskesmas`='$kodepuskesmas'");	
	}else if($_GET['sts'] == 'simpanranap'){
		mysqli_query($koneksi,"UPDATE `tbstokopnam_puskesmas_detail` SET `StokRanap`='$Jumlahisi' WHERE `KodeBarang`='$kodeobat' AND `KodePuskesmas`='$kodepuskesmas'");	
	}else if($_GET['sts'] == 'simpanponed'){
		mysqli_query($koneksi,"UPDATE `tbstokopnam_puskesmas_detail` SET `StokPoned`='$Jumlahisi' WHERE `KodeBarang`='$kodeobat' AND `KodePuskesmas`='$kodepuskesmas'");	
	}else if($_GET['sts'] == 'simpanpustu'){
		mysqli_query($koneksi,"UPDATE `tbstokopnam_puskesmas_detail` SET `StokPustu`='$Jumlahisi' WHERE `KodeBarang`='$kodeobat' AND `KodePuskesmas`='$kodepuskesmas'");			
	}else{
		$kodepuskesmas = $_SESSION['kodepuskesmas'];
		$namapuskesmas = $_SESSION['namapuskesmas'];
		$kota = $_SESSION['kota'];
		$alamat = $_SESSION['alamat'];
		$tanggal = date('Y-m-d');
	
?>

<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=lap_farmasi_stok_opname_triwulan" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>DATA STOK OPNAME (TRIWULAN)</b></h3>
			<form class="form-inline" method="post" enctype="multipart/form-data" action="lap_farmasi_stok_opname_triwulan_lihat_gudang_import.php">
				<table width="100%" style="margin-bottom: 10px;">	
					<tr>
						<td width="12%">
							Upload data (Excel): 
						</td>
						<td width="12%">
							<input type="hidden" name="link" value="nf=<?php echo $nf;?>&bl=<?php echo $bulan;?>&th=<?php echo $tahun;?>">
							<input name="fileexcel" type="file" required="required"> 
						</td>
						<td>
							<input type="hidden" name="bulan" value="<?php echo $bulan;?>">
							<input type="hidden" name="tahun" value="<?php echo $tahun;?>">
							<input name="upload" type="submit" value="Import">
						</td>
					</tr>
				</table>	
			</form>
			<div class="table-responsive">
				<table class="table-judul" wiidth="100%">
					<thead>
						<tr>
							<th width="10%">No.Faktur</th>
							<th width="10%">Bulan</th>
							<th width="10%">Tahun</th>
							<th width="10%">Triwulan</th>
							<th width="20%" colspan="2">Opsi</th>
						</tr>
					</thead>
					<tbody>
						<tr style="font-size: 18px; font-weight: bold;">
							<td align="center" class="nofakturcls"><?php echo $nf;?></td>
							<td align="center"><?php echo nama_bulan($bulan);?></td>
							<td align="center"><?php echo $tahun;?></td>
							<td align="center">
								<?php 
									if($bulan == '01' OR $bulan == '02' OR $bulan == '03'){
										echo "Triwulan 01";
									}elseif($bulan == '04' OR $bulan == '05' OR $bulan == '06'){
										echo "Triwulan 02";	
									}elseif($bulan == '07' OR $bulan == '08' OR $bulan == '09'){
										echo "Triwulan 03";	
									}elseif($bulan == '10' OR $bulan == '11' OR $bulan == '12'){
										echo "Triwulan 04";		
									}	
								?>
							</td>
							<!--<td align="center"><a href="lap_farmasi_stok_opname_lihat_gudang_print.php?nf=<?php echo $nf?>&bl=<?php echo $_GET['bl']?>&th=<?php echo $_GET['th']?>&sa=<?php echo $_GET['sa']?>&unit=<?php echo $unit;?>" class="btnsimpan">Print</a></td>-->
							<td align="center"><a href="lap_farmasi_stok_opname_triwulan_lihat_gudang_excel.php?nf=<?php echo $nf?>&bl=<?php echo $_GET['bl']?>&th=<?php echo $_GET['th']?>&triwulan=<?php echo $_GET['triwulan']?>" class="btnsimpan">Download Excel</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>	
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr>
							<th width="4%" rowspan="2">Kode</th>
							<th width="12%" rowspan="2">Nama Barang</th>
							<th width="4%" rowspan="2">Satuan</th>
							<th width="8%" colspan="2">Harga Satuan</th>
							<th width="8%" colspan="2">Stok Awal <br/>(31 Des <?php echo $tahunlalu?>)</th>
							<th width="8%" colspan="2">Penerimaan</th>
							<th width="8%" colspan="2">Pemakaian</th>
							<th width="30%" colspan="7">Sisa Stok Per <?php echo nama_bulan($bulan)." ".$tahun?></th>
							<th width="8%" colspan="2">Total Sisa Stok</th>
							<th width="8%" colspan="2">Total Rupiah</th>
						</tr>
						<tr>
							<th>APBD</th><!--Harga-->
							<th>JKN</th>
							<th>APBD</th><!--Stok Awal-->
							<th>JKN</th>
							<th>APBD</th><!--Penerimaan-->
							<th>JKN</th>
							<th>APBD</th><!--Penerimaan-->
							<th>JKN</th>
							<th>Gudang</th>
							<th>Depot</th>
							<th>Poli</th>
							<th>IGD</th>
							<th>Ranap</th>
							<th>Poned</th>
							<th>Pustu</th>
							<th>APBD</th><!--Total Sisa Stok-->
							<th>JKN</th>
							<th>APBD</th><!--Total Rupiah-->
							<th>JKN</th>
						</tr>									
					</thead>								
					<tbody>
						<?php
						// ini buat insert pertama kali saja
						$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT KodeBarang FROM `tbstokopnam_puskesmas_detail` WHERE `Bulan`='$bulan' AND `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas'"));
						if ($cek == 0){			
							// $query1 = mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmstok` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Stok` > '0'");
							$query1 = mysqli_query($koneksi, "SELECT * FROM `ref_obat_lplpo`");
							while($data = mysqli_fetch_assoc($query1)){
								//get stok gudangpkm
								$dtgudang = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(Stok) as Stok FROM `tbgudangpkmstok` WHERE KodeBarang = '$data[KodeBarang]' And KodePuskesmas = '$kodepuskesmas'"));
								//get stok depot
								$dtdepot = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(Stok) as Stok FROM `tbapotikstok` WHERE KodeBarang = '$data[KodeBarang]' And KodePuskesmas = '$kodepuskesmas'"));
								
								$str1 = "INSERT INTO `tbstokopnam_puskesmas_detail`(`NoFaktur`,`Bulan`,`Tahun`,`KodePuskesmas`,`KodeBarang`,`StokLaluGudang`,`StokLaluDepot`) 
								VALUES ('$nf','$bulan','$tahun','$kodepuskesmas','$data[KodeBarang]','$dtgudang[Stok]','$dtdepot[Stok]')";
								
								mysqli_query($koneksi, $str1);
							}
						}
						
						$jumlah_perpage = 20;
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}

						$str = "SELECT * FROM `ref_obat_lplpo`";
						$str2 = $str." ORDER BY IdLplpo, NamaBarang ASC LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){	
							if($namaprogram != $data['NamaProgram']){
								echo "<tr style='border:1px sollid #000; font-weight: bold;'><td colspan='23'>$data[NamaProgram]</td></tr>";
								$namaprogram = $data['NamaProgram'];
							}
							$no = $no + 1;
							$kodebarang = $data['KodeBarang'];
							$namabarang = $data['NamaBarang'];
							$stok = $data['Stok'];				

							if($data['SumberAnggaran'] == "APBD KAB/KOTA"){
								$sumber = "APBD";
							}else{
								$sumber = $data['SumberAnggaran'];
							}			
							
							// tbstokopnam_puskesmas_detail
							$dtstokpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbstokopnam_puskesmas_detail` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `Tahun`='$tahun' AND `Bulan`='$bulan'"));
						
							// tbgudangpkmstok
							$dtgudangpkm_apbd = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `HargaSatuan` FROM `tbgudangpkmstok` WHERE `KodeBarang`='$kodebarang' AND `SumberAnggaran`='APBD KAB/KOTA'"));
							$dtgudangpkm_jkn = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `HargaSatuan` FROM `tbgudangpkmstok` WHERE `KodeBarang`='$kodebarang' AND `SumberAnggaran`='JKN'"));
						
							// total sisa stok
							$totalsisastok_apbd = $dtstokpuskesmas['StokAwalApbd'] + $dtstokpuskesmas['PenerimaanApbd'] - $dtstokpuskesmas['PemakaianApbd'];
							$totalsisastok_jkn = $dtstokpuskesmas['StokAwalJkn'] + $dtstokpuskesmas['PenerimaanJkn'] - $dtstokpuskesmas['PemakaianJkn'];
							
							// total hargasatuan
							$totalharga_apbd = $totalsisastok_apbd * $dtgudangpkm_apbd['HargaSatuan'];
							$totalharga_jkn = $totalsisastok_jkn * $dtgudangpkm_jkn['HargaSatuan'];
						?>
						
							<tr style="border:1px solid #000;">
								<td align="center" class="kodecls"><?php echo $data['KodeBarang'];?></td>
								<td align="left"><?php echo $data['NamaBarang'];?></td>
								<td align="center"><?php echo $data['Satuan'];?></td>
								
								<!--Harga-->
								<td align="right" class="hargasatuan"><?php echo rupiah($dtgudangpkm_apbd['HargaSatuan']);?></td>
								<td align="right" class="hargasatuan"><?php echo rupiah($dtgudangpkm_jkn['HargaSatuan']);?></td>
								
								<!--Stok Awal-->
								<td align="right" style="background-color:#f8d7da;">
									<?php
										if($dtstokpuskesmas['StokAwalApbd'] != 0){
											echo rupiah($dtstokpuskesmas['StokAwalApbd']);
										}else{
											echo "-";												
										}
									?>
								</td>
								<td align="right" style="background-color:#f8d7da;">
									<?php
										if($dtstokpuskesmas['StokAwalJkn'] != 0){
											echo rupiah($dtstokpuskesmas['StokAwalJkn']);
										}else{
											echo "-";												
										}
									?>
								</td>
								
								<!--Penerimaan-->
								<td align="right" style="background-color:#f8d7da;">
									<?php
										if($dtstokpuskesmas['PenerimaanApbd'] != 0){
											echo rupiah($dtstokpuskesmas['PenerimaanApbd']);
										}else{
											echo "-";												
										}
									?>
								</td>
								<td align="right" style="background-color:#f8d7da;">
									<?php
										if($dtstokpuskesmas['PenerimaanJkn'] != 0){
											echo rupiah($dtstokpuskesmas['PenerimaanJkn']);
										}else{
											echo "-";												
										}
									?>
								</td>
								
								<!--Pemakaian-->
								<td align="right" style="background-color:#f8d7da;">
									<?php
										if($dtstokpuskesmas['PemakaianApbd'] != 0){
											echo rupiah($dtstokpuskesmas['PemakaianApbd']);
										}else{
											echo "-";												
										}
									?>
								</td>
								<td align="right" style="background-color:#f8d7da;">
									<?php
										if($dtstokpuskesmas['PemakaianJkn'] != 0){
											echo rupiah($dtstokpuskesmas['PemakaianJkn']);
										}else{
											echo "-";												
										}
									?>
								</td>
								
								<!--sisa stok gudang-->
								<td align="center" style="background-color:#f8d7da;" class="StokGudang jml-real" data-isi="<?php echo $dtstokpuskesmas['StokGudang'];?>">
									<?php
										if($dtstokpuskesmas['StokGudang'] != 0){
											echo rupiah($dtstokpuskesmas['StokGudang']);
										}else{
											echo "-";												
										}
									?>
								</td>
								<!--sisa stok depot-->
								<td align="center" data-isi="<?php echo $dtstokpuskesmas['StokDepot'];?>" style="background-color:#f8d7da;" class="depot jml-real">
									<?php
										if($dtstokpuskesmas['StokDepot'] != 0){
											echo rupiah($dtstokpuskesmas['StokDepot']);
										}else{
											echo "-";												
										}
									?>
								</td>
								<!--sisa stok poli-->
								<td align="center" data-isi="<?php echo $dtstokpuskesmas['StokPoli'];?>" style="background-color:#f8d7da;" class="poli jml-real">
									<?php
										if($dtstokpuskesmas['StokPoli'] != 0){
											echo rupiah($dtstokpuskesmas['StokPoli']);
										}else{
											echo "-";												
										}
									?>
								</td>
								<!--sisa stok igd-->
								<td align="center" data-isi="<?php echo $dtstokpuskesmas['StokIgd'];?>" style="background-color:#f8d7da;" class="igd jml-real">
									<?php
										if($dtstokpuskesmas['StokIgd'] != 0){
											echo rupiah($dtstokpuskesmas['StokIgd']);
										}else{
											echo "-";												
										}
									?>
								</td>
								<!--sisa stok ranap-->
								<td align="center" data-isi="<?php echo $dtstokpuskesmas['StokRanap'];?>" style="background-color:#f8d7da;" class="ranap jml-real">
									<?php
										if($dtstokpuskesmas['StokRanap'] != 0){
											echo rupiah($dtstokpuskesmas['StokRanap']);
										}else{
											echo "-";												
										}
									?>
								</td>
								<!--sisa stok poned-->
								<td align="center" data-isi="<?php echo $dtstokpuskesmas['StokPoned'];?>" style="background-color:#f8d7da;" class="poned jml-real">
									<?php
										if($dtstokpuskesmas['StokPoned'] != 0){
											echo rupiah($dtstokpuskesmas['StokPoned']);
										}else{
											echo "-";												
										}
									?>
								</td>
								<!--sisa stok pustu-->
								<td align="center" data-isi="<?php echo $dtstokpuskesmas['StokPustu'];?>" style="background-color:#f8d7da;" class="pustu jml-real">
									<?php
										if($dtstokpuskesmas['StokPustu'] != 0){
											echo rupiah($dtstokpuskesmas['StokPustu']);
										}else{
											echo "-";												
										}
									?>
								</td>
								
								<!--Total Sisa Stok-->
								<td align="right" class="totalreal"><?php echo rupiah($totalsisastok_apbd);?></td>
								<td align="right" class="totalreal"><?php echo rupiah($totalsisastok_jkn);?></td>
								
								<!--Total Rupiah-->
								<td align="right" class="totalhargareal"><?php echo rupiah($totalharga_apbd);?></td>
								<td align="right" class="totalhargareal"><?php echo rupiah($totalharga_jkn);?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
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
						echo "<li><a href='?page=lap_farmasi_stok_opname_triwulan_lihat_gudang&nf=$nf&bl=$bulan&th=$tahun&triwulan=$triwulan&h=$i'>$i</a></li>";
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
					<b>Perhatikan :</b><br/>
					- Silahkan download template excel<br/>	
					- Silahkan isi data pada kolom (merah)<br/>	
				</p>
			</div>
		</div>
	</div>
</div>

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">

$(".StokGudang").dblclick(function(){
	var isi = $(this).text().replace(/[.]/g, "");
	if(isi == "-"){
		isi = "";
	}
	
	var isisebelumnya = parseInt($(this).data('isi'));
	var totalreal = parseInt($(this).parent().find(".totalreal").text().replace(/[.]/g, ""));
	var lokasi = $(this).parent();
	var stoklalu = $(this).parent().find(".stoklalu").data('isi');
	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var bulan = <?php echo $_GET['bl'];?>;
		var tahun = <?php echo $_GET['th'];?>;
		var isi = $(this).val();
		//var selisih = parseInt(stoklalu) - parseInt(isi);			
		var kode = $(this).parent().parent().find(".kodecls").text();
		var batch = $(this).parent().parent().find(".batchcls").text();
		$.post( "lap_farmasi_stok_opname_lihat_gudang.php?sts=simpan", {isi:isi,kode:kode,batch:batch,tahun:tahun,bulan:bulan});
		lokasi.find(".StokGudang").html(addCommas(isi));
		//lokasi.find(".selisih").html(selisih);

		lokasi.find(".totalreal").html(addCommas((totalreal - isisebelumnya) + parseInt(isi)));
		lokasi.find(".StokGudang").data('isi', isi);//kurang ini
		totalharga_real(lokasi);
	});
});

$(".depot").dblclick(function(){
	var isi = $(this).text().replace(/[.]/g, "");
	if(isi == "-"){
		isi = "";
	}
	
	var isisebelumnya = parseInt($(this).data('isi'));
	var totalreal = parseInt($(this).parent().find(".totalreal").text().replace(/[.]/g, ""));
	var lokasi = $(this).parent();
	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var bulan = <?php echo $_GET['bl'];?>;
		var tahun = <?php echo $_GET['th'];?>;
		var isi = $(this).val();				
		var kode = $(this).parent().parent().find(".kodecls").text();
		$.post( "lap_farmasi_stok_opname_lihat_gudang.php?sts=simpandepot", {isi:isi,kode:kode,tahun:tahun,bulan:bulan});
		$(this).parent().html(addCommas(isi));

		lokasi.find(".totalreal").html(addCommas((totalreal - isisebelumnya) + parseInt(isi)));
		lokasi.find(".depot").data('isi', isi);
		totalharga_real(lokasi);
	});
});

$(".poli").dblclick(function(){
	var isi = $(this).text().replace(/[.]/g, "");
	if(isi == "-"){
		isi = "";
	}
	
	var isisebelumnya = parseInt($(this).data('isi'));
	var totalreal = parseInt($(this).parent().find(".totalreal").text().replace(/[.]/g, ""));
	var lokasi = $(this).parent();
	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var bulan = <?php echo $_GET['bl'];?>;
		var tahun = <?php echo $_GET['th'];?>;
		var isi = $(this).val();				
		var kode = $(this).parent().parent().find(".kodecls").text();
		$.post( "lap_farmasi_stok_opname_lihat_gudang.php?sts=simpanpoli", {isi:isi,kode:kode,tahun:tahun,bulan:bulan});
		$(this).parent().html(isi);
		
		lokasi.find(".totalreal").html(addCommas((totalreal - isisebelumnya) + parseInt(isi)));
		lokasi.find(".poli").data('isi', isi);
		totalharga_real(lokasi);
	});
});

$(".igd").dblclick(function(){
	var isi = $(this).text().replace(/[.]/g, "");
	if(isi == "-"){
		isi = "";
	}
	
	var isisebelumnya = parseInt($(this).data('isi'));
	var totalreal = parseInt($(this).parent().find(".totalreal").text().replace(/[.]/g, ""));
	var lokasi = $(this).parent();
	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var bulan = <?php echo $_GET['bl'];?>;
		var tahun = <?php echo $_GET['th'];?>;
		var isi = $(this).val();				
		var kode = $(this).parent().parent().find(".kodecls").text();
		$.post( "lap_farmasi_stok_opname_lihat_gudang.php?sts=simpanigd", {isi:isi,kode:kode,tahun:tahun,bulan:bulan});
		$(this).parent().html(isi);
		
		lokasi.find(".totalreal").html(addCommas((totalreal - isisebelumnya) + parseInt(isi)));
		lokasi.find(".igd").data('isi', isi);
		totalharga_real(lokasi);
	});
});

$(".ranap").dblclick(function(){
	var isi = $(this).text().replace(/[.]/g, "");
	if(isi == "-"){
		isi = "";
	}

	var isisebelumnya = parseInt($(this).data('isi'));
	var totalreal = parseInt($(this).parent().find(".totalreal").text().replace(/[.]/g, ""));
	var lokasi = $(this).parent();
	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var bulan = <?php echo $_GET['bl'];?>;
		var tahun = <?php echo $_GET['th'];?>;
		var isi = $(this).val();				
		var kode = $(this).parent().parent().find(".kodecls").text();
		$.post( "lap_farmasi_stok_opname_lihat_gudang.php?sts=simpanranap", {isi:isi,kode:kode,tahun:tahun,bulan:bulan});
		$(this).parent().html(isi);
		
		lokasi.find(".totalreal").html(addCommas((totalreal - isisebelumnya) + parseInt(isi)));
		lokasi.find(".ranap").data('isi', isi);
		totalharga_real(lokasi);
	});
});

$(".poned").dblclick(function(){
	var isi = $(this).text().replace(/[.]/g, "");
	if(isi == "-"){
		isi = "";
	}

	var isisebelumnya = parseInt($(this).data('isi'));
	var totalreal = parseInt($(this).parent().find(".totalreal").text().replace(/[.]/g, ""));
	var lokasi = $(this).parent();
	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var bulan = <?php echo $_GET['bl'];?>;
		var tahun = <?php echo $_GET['th'];?>;
		var isi = $(this).val();				
		var kode = $(this).parent().parent().find(".kodecls").text();
		$.post( "lap_farmasi_stok_opname_lihat_gudang.php?sts=simpanponed", {isi:isi,kode:kode,tahun:tahun,bulan:bulan});
		$(this).parent().html(isi);
		
		lokasi.find(".totalreal").html(addCommas((totalreal - isisebelumnya) + parseInt(isi)));
		lokasi.find(".poned").data('isi', isi);
		totalharga_real(lokasi);
	});
});

$(".pustu").dblclick(function(){
	var isi = $(this).text().replace(/[.]/g, "");
	if(isi == "-"){
		isi = "";
	}

	var isisebelumnya = parseInt($(this).data('isi'));
	var totalreal = parseInt($(this).parent().find(".totalreal").text().replace(/[.]/g, ""));
	var lokasi = $(this).parent();
	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var bulan = <?php echo $_GET['bl'];?>;
		var tahun = <?php echo $_GET['th'];?>;
		var isi = $(this).val();				
		var kode = $(this).parent().parent().find(".kodecls").text();
		$.post( "lap_farmasi_stok_opname_lihat_gudang.php?sts=simpanpustu", {isi:isi,kode:kode,tahun:tahun,bulan:bulan});
		$(this).parent().html(isi);
		
		lokasi.find(".totalreal").html(addCommas((totalreal - isisebelumnya) + parseInt(isi)));
		lokasi.find(".pustu").data('isi', isi);
		totalharga_real(lokasi);
	});
});

function totalharga_real(lokasi){
	//menghitung totalharga 
	var hargasatuan = parseInt(lokasi.find(".hargasatuan").text().replace(/[.]/g, ""));
	var totalreal = parseInt(lokasi.find(".totalreal").text().replace(/[.]/g, ""));
	lokasi.find(".totalhargareal").html(addCommas(hargasatuan * totalreal));
	//menampilkan selisih
	var totalsistem = parseInt(lokasi.find(".totalsistem").text().replace(/[.]/g, ""));
	lokasi.find(".selisih").html(addCommas(totalreal - totalsistem));
}

function addCommas(nStr) {
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

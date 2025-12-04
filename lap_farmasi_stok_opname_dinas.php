<?php
session_start();
include "config/helper_report.php";
include "config/koneksi.php";
$kodeobat = $_POST['kode']; 
$jml = $_POST['isi']; 
$bulan = $_POST['bulan'];
$sisastok = $_POST['sisa'];
$keterangan = $_POST['ket'];
if(strlen($bulan) == 1){
	$bulan = '0'.$bulan;
}
$tahun = $_POST['tahun'];
	
if($_GET['sts'] == 'simpan'){
	mysqli_query($koneksi,"REPLACE INTO `tbstokbulanandinas`(`Bulan`,`Tahun`,`KodeBarang`,`Stok`)
	VALUES ('$bulan','$tahun','$kodeobat','$jml')");
}else if($_GET['sts'] == 'simpan_keterangan'){
	//mysqli_query($koneksi,"UPDATE `tbstokbulanandinas` SET `Bulan`='$bulan',`Tahun`='$tahun',`KodeBarang`='$kodeobat',`Keterangan`='$keterangan'";
}else{
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$tanggal = date('Y-m-d');
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>STOK OPNAME </b><small>Gudang Besar</small></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_stok_opname_dinas"/>
						<div class="col-sm-2">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsi'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsi'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</select>	
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
	$sumberanggaran = $_GET['sumberanggaran'];
	if($sumberanggaran != ''){
		$sumberanggarans = "(".$sumberanggaran.")";
	}else{
		$sumberanggarans = "";
	}

	if(isset($bulan) and isset($tahun)){
	?>
	
	<div class="table-responsive">	
		<table class="table-judul-laporan">
			<thead class="font9">
				<tr>
					<th rowspan="2" width="3%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
					<th rowspan="2" width="5%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kode</th>
					<th rowspan="2" width="20%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Barang</th>
					<th rowspan="2" width="6%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Merk/Type</th>
					<th rowspan="2" width="5%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Satuan</th>
					<th rowspan="2" width="5%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.Batch</th>
					<th rowspan="2" width="5%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Harga Satuan</th>
					<th rowspan="2" width="12%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tahun Pengadaan/Pembelian</th>
					<th colspan="3" width="15%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Stok Tercatat</th>
					<th rowspan="2" width="5%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Sisa Akhir</th>
					<th rowspan="2" width="5%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Ket</th>
				</tr>
				<tr>
					<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Gudang Besar</th>
					<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Gudang Pelayanan</th>
					<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Total</th>
				</tr>
			</thead>
			
			<tbody class="font9">
				<?php
				$jumlah_perpage = 20;
							
				if($_GET['h']==''){
					$mulai=0;
				}else{
					$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
				
				if($sumberanggaran == 'APBD'){
					$sumber = " WHERE SumberAnggaran like '%APBD%'";
				}else if ($sumberanggaran == 'APBN'){
					$sumber = " WHERE SumberAnggaran like '%APBN%'";
				}else if ($sumberanggaran == 'BLUD'){
					$sumber = " WHERE SumberAnggaran = 'BLUD'";
				}else{
					$sumber = " WHERE SumberAnggaran <> 'BPJS'";
				}
				
				$str = "SELECT * FROM `tbgfkstok`".$sumber;
				$str2 = $str." ORDER BY `NamaBarang` limit $mulai,$jumlah_perpage";
				// echo $str2;
				
				if($_GET['h'] == null || $_GET['h'] == 1){
					$no = 0;
				}else{
					$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
				
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kodebarang = $data['KodeBarang'];
					$namabarang = $data['NamaBarang'];
					$stok_gb = $data['Stok'];
					
					// stok awal gudang obat puskesmas
					$dtstok_gp= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang` = '$kodebarang'"));
					if($dtstok_gp['Stok'] != ''){
						$stok_gp = $dtstok_gp['Stok'];
					}else{
						$stok_gp = 0;
					}
					
					$total = $stok_gb + $stok_gp;
					
					// sisaakhir
					$sisaakhir = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok`,`Keterangan` FROM `tbstokbulanandinas` WHERE `KodeBarang`='$kodebarang' AND `Tahun`='$tahun' AND `Bulan`='$bulan'"))['Stok'];
				?>
				
					<tr style="border:1px solid #000;">
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;" class="kodecls"><?php echo $data['KodeBarang'];?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaBarang'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['KelasTherapy'];?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NoBatch'];?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($data['HargaBeli']);?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['SumberAnggaran']." - ".$data['TahunAnggaran'];?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($stok_gb);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($stok_gp);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($total);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px; background-color:#dbf7ff;" class="sisaakhir"><?php echo rupiah($sisaakhir);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;" class="keterangan"></td>
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
						echo "<li><a href='?page=lap_farmasi_stok_opname_dinas&opsiform=$opsiform&keydate1=$keydate1&keydate2=$keydate2&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
		}
	}
	?>
</div>	

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">

$(".sisaakhir").dblclick(function(){
	var isi = $(this).text();
	var lokasi = $(this).parent();

	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var bulan = <?php echo $_GET['bulan'];?>;
		var tahun = <?php echo $_GET['tahun'];?>;
		var isi = $(this).val();
			
		var kode = $(this).parent().parent().find(".kodecls").text();
		$.post( "lap_farmasi_stok_opname_dinas.php?sts=simpan", {isi:isi,kode:kode,tahun:tahun,bulan:bulan});
		$(this).parent().html(isi);
	});
	
});

$(".keterangan").dblclick(function(){
	var ket = $(this).text();
	var lokasi = $(this).parent();

	var form = "<input type='text' class='frmcls' value='"+ket+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var bulan = <?php echo $_GET['bulan'];?>;
		var tahun = <?php echo $_GET['tahun'];?>;
		var ket = $(this).val();
			
		var kode = $(this).parent().parent().find(".kodecls").text();
		$.post( "lap_farmasi_stok_opname_dinas.php?sts=simpan_keterangan", {ket:ket,kode:kode,tahun:tahun,bulan:bulan});
		$(this).parent().html(ket);
	});
	
});

$('.opsiform').change(function(){
	if($(this).val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}else{	
		$(".bulanformcari").hide();
		$(".tanggalformcari").show();
	}
});	
</script>
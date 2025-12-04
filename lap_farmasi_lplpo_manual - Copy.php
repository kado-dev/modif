<?php
session_start();
include "config/koneksi.php";
include "config/helper_report.php";
// include "otoritas.php";

if($_GET['sts'] == 'simpan'){
	$kodeobat = $_POST['kode']; 
	$jml = $_POST['isi']; 
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$bulan = $_POST['bulan'];
	$sisastok = $_POST['sisa'];
	if(strlen($bulan) == 1){
		$bulan = '0'.$bulan;
	}
	$tahun = $_POST['tahun'];
	mysqli_query($koneksi,"REPLACE INTO `tbpemakaianobatpuskesmas`(`Bulan`, `Tahun`, `KodePuskesmas`, `KodeBarang`, `Jumlah`)
	VALUES ('$bulan','$tahun','$kodepuskesmas','$kodeobat','$jml')");
	
	// insert sisa ke stok awal bulan berikutnya
	if($bulan == 12){
		$blnberikutnya = '01';
		$thnberikutnya = $tahun+1;
	}else{
		$blnberikutnya = $bulan+1;
		if(strlen($blnberikutnya) == 1){
			$blnberikutnya = '0'.$blnberikutnya;
		}
		$thnberikutnya = $tahun;
	}
	
	mysqli_query($koneksi,"REPLACE INTO `tbstokbulananpuskesmas`(`Bulan`, `Tahun`, `KodePuskesmas`, `KodeBarang`, `Stok`)
	VALUES ('$blnberikutnya','$thnberikutnya','$kodepuskesmas','$kodeobat','$sisastok')");
	
}else if($_GET['sts'] == 'simpan2'){
	$kodeobat = $_POST['kode']; 
	$jml = $_POST['isi']; 
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$bulan = $_POST['bulan'];
	$sisastok = $_POST['sisa'];
	if(strlen($bulan) == 1){
		$bulan = '0'.$bulan;
	}
	$tahun = $_POST['tahun'];
		
	mysqli_query($koneksi,"REPLACE INTO `tbstokbulananpuskesmas`(`Bulan`, `Tahun`, `KodePuskesmas`, `KodeBarang`, `Stok`)
	VALUES ('$bulan','$tahun','$kodepuskesmas','$kodeobat','$jml')");
	
	// insert sisa ke stok awal bulan berikutnya
	if($bulan == 12){
		$blnberikutnya = '01';
		$thnberikutnya = $tahun+1;
	}else{
		$blnberikutnya = $bulan+1;
		if(strlen($blnberikutnya) == 1){
			$blnberikutnya = '0'.$blnberikutnya;
		}
		$thnberikutnya = $tahun;
	}
	mysqli_query($koneksi,"REPLACE INTO `tbstokbulananpuskesmas`(`Bulan`, `Tahun`, `KodePuskesmas`, `KodeBarang`, `Stok`)
	VALUES ('$blnberikutnya','$thnberikutnya','$kodepuskesmas','$kodeobat','$sisastok')");
	
}else if($_GET['sts'] == 'simpan3'){
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
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$tanggal = date('Y-m-d');
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>LPLPO MANUAL</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_lplpo_manual"/>
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
								<option value="APBD KAB/KOTA" <?php if($_GET['sumberanggaran'] == 'APBD'){echo "SELECTED";}?>>APBD</option>
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
								$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `Kota`='$kota' order by `NamaPuskesmas`");
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
							<a href="lap_farmasi_lplpo_manual_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&sumberanggaran=<?php echo $_GET['sumberanggaran'];?>" class="btn btn-sm btn-info">Excel</a>
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

	if(isset($bulan) and isset($tahun)){
	?>

	<div class="font10">	
		<table class="table-judul-laporan">
			<thead class="font9">
				<tr>
					<th width="5%"; style="text-align:center; vertical-align:middle; solid:1px dashed #000; padding:3px;">No.</th>
					<th width="5%"; style="text-align:center; vertical-align:middle; solid:1px dashed #000; padding:3px;">Kode</th>
					<th width="30%"; style="text-align:center; vertical-align:middle; solid:1px dashed #000; padding:3px;">Nama Barang</th>
					<th width="7%"; style="text-align:center; vertical-align:middle; solid:1px dashed #000; padding:3px;">Satuan</th>
					<th width="7%"; style="text-align:center; vertical-align:middle; solid:1px dashed #000; padding:3px;">Stok Awal</th>
					<th width="7%"; style="text-align:center; vertical-align:middle; solid:1px dashed #000; padding:3px;">Penerimaan</th>
					<th width="7%"; style="text-align:center; vertical-align:middle; solid:1px dashed #000; padding:3px;">Persediaan</th>
					<th width="6%"; style="text-align:center; vertical-align:middle; solid:1px dashed #000; padding:3px;">Pemakaian</th>
					<th width="6%"; style="text-align:center; vertical-align:middle; solid:1px dashed #000; padding:3px;">Sisa Akhir</th>
					<th width="6%"; style="text-align:center; vertical-align:middle; solid:1px dashed #000; padding:3px;">Stok Optimum</th>
					<th width="6%"; style="text-align:center; vertical-align:middle; solid:1px dashed #000; padding:3px;">Permintaan</th>
					<th width="10%"; style="text-align:center; vertical-align:middle; solid:1px dashed #000; padding:3px;">Pemberian</th>
					<th width="5%"; style="text-align:center; vertical-align:middle; solid:1px dashed #000; padding:3px;">Ket.</th>
				</tr>
			</thead>
			
			<tbody class="font9">
				<?php
				$jumlah_perpage = 100;
							
				if($_GET['h']==''){
					$mulai=0;
				}else{
					$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
				
				if ($sumberanggaran != ''){
					$sumber = " AND c.SumberAnggaran like '%$sumberanggaran%'";
				}else{
					$sumber = "";
				}			
				
				
				if ($sumberanggaran != 'BLUD' AND $sumberanggaran != 'APBN'){
					// ini ngambil dari pengeluaran dinas, karena klo ngambil dari gudang puskesmas kendala tdk diceklis
					$str = "SELECT * FROM `tbgfkpengeluarandetail` a 
					JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur
					JOIN `tbgfkstok` c ON a.KodeBarang = c.KodeBarang
					WHERE b.KodePenerima='$kodepuskesmas'".$sumber." GROUP BY c.NamaBarang";
					$str2 = $str." ORDER BY c.NamaBarang LIMIT $mulai,$jumlah_perpage";
				}elseif($sumberanggaran == 'APBN'){
					// ini obat blud ngambil dari tbgudangpkmstok
					$str = "SELECT * FROM `tbgudangpkmstok`
					WHERE `KodePuskesmas`='$kodepuskesmas' AND `SumberAnggaran` = 'APBN' GROUP BY NamaBarang";
					$str2 = $str." ORDER BY NamaBarang ASC LIMIT $mulai,$jumlah_perpage";
				}else{
					// ini obat blud ngambil dari tbgudangpkmstok
					$str = "SELECT * FROM `tbgudangpkmstok`
					WHERE `KodePuskesmas`='$kodepuskesmas' AND `SumberAnggaran` = 'BLUD' GROUP BY NamaBarang";
					$str2 = $str." ORDER BY NamaBarang ASC LIMIT $mulai,$jumlah_perpage";
				}						
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
					
					// stok awal gudang obat puskesmas, wajib berdasarkan sumber anggaran
					$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.Stok 
					FROM `tbstokbulananpuskesmas` a
					JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang
					WHERE a.`Bulan`='$bulan' AND a.`Tahun`='$tahun' AND a.KodePuskesmas='$kodepuskesmas' AND b.NamaBarang='$namabarang' AND b.SumberAnggaran='$sumberanggaran'"));
								
					if($dtstokawal['Stok'] != ''){
						$ttlstokawal = $dtstokawal['Stok'];
					}else{
						$ttlstokawal = 0;
					}
					
					// penerimaan--> digroup berdasar nama barang agar jika stoknya ada lebih dari 1 batch dia ngejumlahin
					$penerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah
					FROM `tbgudangpkmpenerimaandetail` a
					JOIN tbgudangpkmpenerimaan b on a.NoFaktur = b.NoFaktur
					JOIN tbgfkstok c ON a.KodeBarang = c.KodeBarang 
					WHERE MONTH(b.TanggalPenerimaan) = '$bulan' AND YEAR(b.TanggalPenerimaan) = '$tahun' AND a.KodePuskesmas='$kodepuskesmas'
					AND c.NamaBarang='$namabarang'"));
					if($penerimaan['Jumlah'] != ''){
						$terima = $penerimaan['Jumlah'];
					}else{
						$terima = 0;
					}
					
					// pengadaan blud
					$pengadaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah
					FROM `tbgudangpkmpengadaandetail` a
					JOIN `tbgudangpkmpengadaan` b on a.NoFaktur = b.NoFaktur
					JOIN tbgfkstok c ON a.KodeBarang = c.KodeBarang 
					WHERE MONTH(b.TanggalPengadaan) = '$bulan' AND YEAR(b.TanggalPengadaan) = '$tahun' AND a.KodePuskesmas='$kodepuskesmas'
					AND c.NamaBarang='$namabarang'"));
					
					if($pengadaan['Jumlah'] != ''){
						$adaan = $pengadaan['Jumlah'];
					}else{
						$adaan = 0;
					}
					
					// persediaan
					$persediaan = $ttlstokawal + $terima + $adaan;
					
					// pemakaian
					$st2 = "SELECT a.`Jumlah` as jml 
					FROM `tbpemakaianobatpuskesmas` a
					JOIN `tbgfkstok` b ON a.KodeBarang = b.kodebarang
					WHERE a.`Bulan` = '$bulan' AND a.`Tahun` = '$tahun' AND a.`KodePuskesmas` = '$kodepuskesmas' AND b.`NamaBarang` = '$namabarang'";
					$pemakaian = mysqli_fetch_assoc(mysqli_query($koneksi,$st2));
					
					if($pemakaian['jml'] != ''){
						$pemakaians = $pemakaian['jml'];
					}else{
						$tahun_2digit = substr($tahun,2,2);
						$pakai1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(jumlahobat)AS jml FROM tbresepdetail 
						WHERE SUBSTRING(Noresep,1,11)='$kodepuskesmas' AND SUBSTRING(NoResep,13,2)='$tahun_2digit' 
						AND SUBSTRING(NoResep,15,2)='$bulan' AND KodeBarang='$kodebarang'"));
						$pemakaians = $pakai1['jml'];
						//$pemakaians = 0;
					}
					
					// sisa
					$sisa = $persediaan - $pemakaian['jml'];
					$stokoptimum = $sisa * 1.6;
									
					// permintaan
					$st3 = "SELECT a.`Jumlah` as jml 
					FROM `tbgudangpkmpermintaan` a
					JOIN `tbgfkstok` b ON a.KodeBarang = b.kodebarang
					WHERE a.`Bulan` = '$bulan' AND a.`Tahun` = '$tahun' AND a.`KodePuskesmas` = '$kodepuskesmas' AND b.`NamaBarang` = '$namabarang'";
					$permintaan = mysqli_fetch_assoc(mysqli_query($koneksi,$st3));
					
					if($permintaan['jml'] != ''){
						$permintaans = $permintaan['jml'];
					}else{
						$permintaans = 0;
					}
					
					// insert ket tbstok awal
					if($bulan == 12){
						$blnberikutnya = '01';
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
					<tr style="solid:1px dashed #000;">
						<td style="text-align:right; solid:1px dashed #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center; solid:1px dashed #000; padding:3px;" class="kodecls"><?php echo $data['KodeBarang'];?></td>
						<td style="text-align:left; solid:1px dashed #000; padding:3px;"><?php echo $data['NamaBarang'];?></td>
						<td style="text-align:left; solid:1px dashed #000; padding:3px;"><?php echo $data['Satuan'];?></td>
						<td style="text-align:right; solid:1px dashed #000; padding:3px; background-color:#dbf7ff;" class="stokawalcls"><?php echo $ttlstokawal;?></td>
						<td style="text-align:right; solid:1px dashed #000; padding:3px;" class="penerimaancls">
						<?php 
						if($sumberanggaran != 'BLUD'){
							echo $terima;
						}else{
							echo $adaan;
						}
						
						?></td>
						<td style="text-align:right; solid:1px dashed #000; padding:3px;" class="persediaancls"><?php echo $persediaan;?></td>
						<td style="text-align:right; solid:1px dashed #000; padding:3px; background-color:#dbf7ff;" class="pemakaiancls"><?php echo $pemakaians;?></td>
						<td style="text-align:right; solid:1px dashed #000; padding:3px;" class="sisacls"><?php echo $sisa;?></td>
						<td style="text-align:right; solid:1px dashed #000; padding:3px;" class="stokoptimumcls"><?php echo $stokoptimum;?></td>
						<td style="text-align:right; solid:1px dashed #000; padding:3px; background-color:#dbf7ff;" class="permintaancls"><?php echo $permintaans;?></td>
						<td style="text-align:center; solid:1px dashed #000; padding:3px;"><?php echo $data['SumberAnggaran'];?></td>
						<td style="text-align:center; solid:1px dashed #000; padding:3px;">-</td>
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
						echo "<li><a href='?page=lap_farmasi_lplpo_manual&opsiform=$opsiform&keydate1=$keydate1&keydate2=$keydate2&bulan=$bulan&tahun=$tahun&sumberanggaran=$sumberanggaran&h=$i'>$i</a></li>";
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

$(".pemakaiancls").dblclick(function(){
	var isi = $(this).text();
	var lokasi = $(this).parent();
	var persediaan = lokasi.find(".persediaancls").text();

	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var bulan = <?php echo $_GET['bulan'];?>;
		var tahun = <?php echo $_GET['tahun'];?>;
		var isi = $(this).val();
		
		var sisa = parseInt(persediaan) - parseInt(isi);
		var stokoptimum = sisa * 1.6;
	
		var kode = $(this).parent().parent().find(".kodecls").text();
		$.post( "lap_farmasi_lplpo_manual.php?sts=simpan", { isi:isi,sisa:sisa,kode:kode,tahun:tahun,bulan:bulan});
		$(this).parent().html(isi);
		
		lokasi.find(".sisacls").html(sisa);
		lokasi.find(".stokoptimumcls").html(stokoptimum);
	});
});

$(".stokawalcls").dblclick(function(){
	var isi = $(this).text();
	var lokasi = $(this).parent();
	var penerimaan = lokasi.find(".penerimaancls").text();
	var pemakaian = lokasi.find(".pemakaiancls").text();

	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var bulan = <?php echo $_GET['bulan'];?>;
		var tahun = <?php echo $_GET['tahun'];?>;
		var isi = $(this).val();
		
		var persediaan = parseInt(isi) + parseInt(penerimaan);
		var sisa = parseInt(persediaan) - parseInt(pemakaian);
		var stokoptimum = sisa * 1.6;
	
		var kode = $(this).parent().parent().find(".kodecls").text();
		$.post( "lap_farmasi_lplpo_manual.php?sts=simpan2", { isi:isi,sisa:sisa,kode:kode,tahun:tahun,bulan:bulan});
		$(this).parent().html(isi);
		
		lokasi.find(".persediaancls").html(persediaan);
		lokasi.find(".sisacls").html(sisa);
		lokasi.find(".stokoptimumcls").html(stokoptimum);
	});
});

$(".permintaancls").dblclick(function(){
	var isi = $(this).text();
	// var lokasi = $(this).parent();
	// var persediaan = lokasi.find(".persediaancls").text();

	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var bulan = <?php echo $_GET['bulan'];?>;
		var tahun = <?php echo $_GET['tahun'];?>;
		var isi = $(this).val();
		
		// var sisa = parseInt(persediaan) - parseInt(isi);
		// var stokoptimum = sisa * 1.6;
	
		var kode = $(this).parent().parent().find(".kodecls").text();
		$.post( "lap_farmasi_lplpo_manual.php?sts=simpan3", { isi:isi,kode:kode,tahun:tahun,bulan:bulan});
		$(this).parent().html(isi);
		
		// lokasi.find(".sisacls").html(sisa);
		// lokasi.find(".stokoptimumcls").html(stokoptimum);
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
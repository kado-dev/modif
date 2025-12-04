<?php
	session_start();
	include "config/helper_report.php";
	include "config/koneksi.php";
	$nf = $_GET['nf'];
	$sumberanggaran = $_GET['sa'];
	$bulan = $_GET['bl'];
	$tahun = $_GET['th'];		
	$bln = $_POST['bulan'];		
	$thn = $_POST['tahun'];		
	$kodeobat = $_POST['kode']; 
	$nobatch = $_POST['batch']; 
	$jml = $_POST['isi']; 
	$keterangan = $_POST['ket'];
	$nofk = $_POST['nofk'];
	if(strlen($bln) == 1){
		$bln = '0'.$bln;
	}
		
	if($_GET['sts'] == 'simpan'){
		// update tbstokbulananpuskesmas
		mysqli_query($koneksi,"UPDATE `tbstokbulananpuskesmas` SET `Stok`='$jml', `Selisih` = (StokLalu - $jml) WHERE `NoFaktur`='$nofk' AND `Bulan`='$bln' AND `Tahun`='$thn' AND `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch'");
		// update tbgudangpkmstok
		mysqli_query($koneksi, "UPDATE `tbgudangpkmstok` SET `Stok`='$jml',`TanggalUpdateStok`=curdate() WHERE `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch'"); 
	}else if($_GET['sts'] == 'simpan_keterangan'){
		mysqli_query($koneksi,"UPDATE `tbstokbulananpuskesmas` SET `Keterangan`='$keterangan' WHERE `Bulan`='$bln' AND `Tahun`='$thn' AND `KodeBarang`='$kodeobat' AND `NoBatch`='$nobatch'");
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
			<a href="index.php?page=gudang_puskesmas_opnam" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>DATA STOK OPNAME</b></h3>
			<div class="table-responsive">
				<table class="table-judul" wiidth="100%">
					<thead>
						<tr>
							<th width="20%">No.Faktur</th>
							<th width="20%">Sumber Anggaran</th>
							<th width="20%">Bulan</th>
							<th width="10%">Tahun</th>
							<th width="20%">Opsi</th>
						</tr>
					</thead>
					<tbody>
						<tr style="font-size: 18px; font-weight: bold;">
							<td align="center" class="nofakturcls"><?php echo $nf;?></td>
							<td align="center"><?php echo $sumberanggaran;?></td>
							<td align="center"><?php echo nama_bulan($bulan);?></td>
							<td align="center"><?php echo $tahun;?></td>
							<td align="center"><a href="gudang_puskesmas_opname_lihat_print.php?nf=<?php echo $nf?>&bl=<?php echo $_GET['bl']?>&th=<?php echo $_GET['th']?>&sa=<?php echo $_GET['sa']?>" class="btnsimpan">Print</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>
	
	<?php
	if(isset($bulan) and isset($tahun)){
	?>
	
	<div class="table-responsive">	
		<table class="table-judul-laporan" width="100%">
			<thead>
				<tr>
					<th rowspan="2" width="3%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">No.</th>
					<th rowspan="2" width="6%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Kode</th>
					<th rowspan="2" width="22%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Nama Barang</th>
					<th rowspan="2" width="6%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Satuan</th>
					<th rowspan="2" width="8%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Batch</th>
					<th rowspan="2" width="5%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Tahun Anggaran</th>
					<th rowspan="2" width="8%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Expire</th>
					<th rowspan="2" width="10%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Program</th>
					<th rowspan="2" width="8%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Stok Sistem</th>
					<th rowspan="2" width="8%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Stok Fisik</th>
					<th rowspan="2" width="8%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Selisih</th>
					<th rowspan="2" width="10%"; style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Keterangan</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
				// ini buat insert pertama kali saja
				$cek = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoFaktur) AS Jml FROM `tbstokbulananpuskesmas` WHERE `Bulan`='$bulan' AND `Tahun`='$tahun'"));
				if ($cek['Jml'] == 0){
					$strstok = "SELECT * FROM `tbgudangpkmstok`";
					$querystok = mysqli_query($koneksi,$strstok);
					while($dt_stok = mysqli_fetch_assoc($querystok)){
						mysqli_query($koneksi,"INSERT INTO `tbstokbulananpuskesmas`(`NoFaktur`,`Bulan`,`Tahun`,`KodeBarang`,`NoBatch`,`StokLalu`) 
						VALUES ('$nf','$bulan','$tahun','$dt_stok[KodeBarang]','$dt_stok[NoBatch]','$dt_stok[Stok]')");
					}	
				}	
								
				$jumlah_perpage = 20;							
				if($_GET['h']==''){
					$mulai=0;
				}else{
					$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
								
				$str = "SELECT * FROM `tbgudangpkmstok` WHERE `KodePuskesmas`='$kodepuskesmas'";
				$str2 = $str." ORDER BY KodeBarang ASC LIMIT $mulai,$jumlah_perpage";
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
					$nobatch = $data['NoBatch'];
					$namabarang = $data['NamaBarang'];
					$stok = $data['Stok'];					
															
					// sisaakhir tbstokbulananpuskesmas
					$dtstoksinkes = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StokLalu`,`Stok`,`Selisih`,`Keterangan` FROM `tbstokbulananpuskesmas` WHERE `NoFaktur`='$nf' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `Tahun`='$tahun' AND `Bulan`='$bulan'"));
				?>
				
					<tr style="border:1px solid #000;">
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px; display: none;" class="nofakturcls"><?php echo $nf;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;" class="kodecls"><?php echo $data['KodeBarang'];?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaBarang'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;" class="batchcls"><?php echo $data['NoBatch'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TahunAnggaran'];?></td>	
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Expire'];?></td>	
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['NamaProgram'];?></td>	
						<td style="text-align:right; border:1px solid #000; padding:3px; color:red;font-weight:bold" class="stoklalu" data-isi="<?php echo $dtstoksinkes['StokLalu'];?>"><b><?php echo rupiah($dtstoksinkes['StokLalu']);?></b></td><!--stok sistem-->
						<td style="text-align:right; border:1px solid #000; padding:3px; background-color:#dbf7ff;" class="sisaakhir"><?php echo rupiah($dtstoksinkes['Stok']);?></td><!--stok fisik-->
						<td style="text-align:right; border:1px solid #000; padding:3px;" class="selisih"><?php echo rupiah($dtstoksinkes['Selisih']);?></td><!--selisih-->
						<td style="text-align:center; border:1px solid #000; padding:3px;" class="keterangan"><?php echo $dtstoksinkes['Keterangan'];?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<hr class="noprint">
	<ul class="pagination noprint">
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
						echo "<li><a href='?page=gudang_puskesmas_opnam_lihat&nf=$nf&bl=$bulan&th=$tahun&sa=$sumberanggaran&h=$i'>$i</a></li>";
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
	var stoklalu = $(this).parent().find(".stoklalu").data('isi');
	var form = "<input type='text' class='frmcls' value='"+isi+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var bulan = <?php echo $_GET['bl'];?>;
		var tahun = <?php echo $_GET['th'];?>;
		// var nofk = <?php echo $_GET['nf'];?>;
		var isi = $(this).val();
		
		var selisih = parseInt(stoklalu) - parseInt(isi);
			
		var kode = $(this).parent().parent().find(".kodecls").text();
		var batch = $(this).parent().parent().find(".batchcls").text();
		var nofk = $(this).parent().parent().find(".nofakturcls").text();
		$.post( "gudang_puskesmas_opnam_lihat.php?sts=simpan", {nofk:nofk,isi:isi,kode:kode,batch:batch,tahun:tahun,bulan:bulan});
		$(this).parent().html(isi);
		lokasi.find(".selisih").html(selisih);
	});
});

$(".keterangan").dblclick(function(){
	var ket = $(this).text();
	var lokasi = $(this).parent();

	var form = "<input type='text' class='frmcls' value='"+ket+"'>";
	$(this).html(form);
	
	$(".frmcls").focusout(function(){
		var bulan = <?php echo $_GET['bl'];?>;
		var tahun = <?php echo $_GET['th'];?>;
		var ket = $(this).val();
			
		var kode = $(this).parent().parent().find(".kodecls").text();
		var batch = $(this).parent().parent().find(".batchcls").text();
		$.post( "gudang_puskesmas_opnam_lihat.php?sts=simpan_keterangan", {ket:ket,kode:kode,batch:batch,tahun:tahun,bulan:bulan});
		$(this).parent().html(ket);
	});
	
});

</script>

<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	$hariini = date('d-m-Y');
    $nf = $_GET['nf'];
	$unit = $_GET['unit'];
	$bulan = $_GET['bl'];
    $tahun = $_GET['th'];
    $sumberanggaran = $_GET['sa'];
    $namapuskesmas = $_SESSION['namapuskesmas'];
    $kodepuskesmas = $_SESSION['kodepuskesmas'];
	$kota = $_SESSION['kota'];
	$kecamatan = $_SESSION['kecamatan'];
	$kelurahan = $_SESSION['kelurahan'];
	$alamat = $_SESSION['alamat'];

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=Stok Opname (".$namapuskesmas." ".$bulan." ".$tahun.").xls");
	if(isset($bulan) and isset($tahun)){
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
}
.printheader h4{
	font-size:24px;
	font-family: "Roboto Condensed", Arial, sans-serif;
}
.printheader p{
	font-size:24px;
	font-family: "Roboto Condensed", Arial, sans-serif;
}
.printbody{
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
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

<div class="printheader">
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>STOK OPNAME PUSKESMAS</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
    <table class="table-judul-form" border="1">
        <thead>
			<tr>
				<th width="3%" rowspan="2">No.</th>
				<th width="5%" rowspan="2">Kode</th>
				<th width="12%" rowspan="2">Nama Barang</th>
				<th width="5%" rowspan="2">Expire</th>
				<th width="40%" colspan="8">Sisa Stok</th>
				<th width="5%" rowspan="2">Total<br/> Stok</th>
				<th width="6%" rowspan="2">Total<br/> Harga</th>
			</tr>
			<tr>
				<th>Gudang<br/> Obat</th>
				<th>Depot<br/> Obat</th>
				<th>Poli</th>
				<th>IGD</th>
				<th>Ranap</th>
				<th>Poned</th>
				<th>Pustu</th>
				<th>Pusling</th>
			</tr>										
		</thead>								
        <tbody>
			<?php
			// ini buat insert pertama kali saja
			$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `Bulan`='$bulan' AND `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas'"));
			if ($cek == 0){	
				// jangan menggunakan ref_obat_lplpo, mengantisipasi jika ada item obat sama beda batch
				$query1 = mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmstok` WHERE `KodePuskesmas`='$kodepuskesmas'");
				
				while($data = mysqli_fetch_assoc($query1)){
					// stok gudangpkm
					$dtgudang= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbgudangpkmstok` WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND KodePuskesmas = '$kodepuskesmas'"));
					// stok depot
					$dtdepot = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbapotikstok` WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='LOKET OBAT'"));
					$dtdepot_poli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbapotikstok` WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='POLI LANSIA'"));
					$dtdepot_igd = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbapotikstok` WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='POLI IGD'"));
					$dtdepot_ranap = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbapotikstok` WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='RAWAT INAP'"));
					$dtdepot_poned = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbapotikstok` WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='PONED'"));
					$dtdepot_pustu = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbapotikstok` WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='PUSTU'"));
					$dtdepot_pusling = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbapotikstok` WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='PUSLING'"));
					// insert
					$str1 = "INSERT INTO `tbstokopnam_puskesmas_detail_fisik`(`Bulan`,`Tahun`,`KodePuskesmas`,`KodeBarang`,`NamaBarang`,`Satuan`,`NoBatch`,`Expire`,`HargaSatuan`,`IdProgram`,`NamaProgram`,`StokGudang`,`StokDepot`,`StokPoli`,`StokIgd`,`StokRanap`,`StokPoned`,`StokPustu`,`StokPusling`) 
					VALUES ('$bulan','$tahun','$kodepuskesmas','$data[KodeBarang]','$data[NamaBarang]','$data[Satuan]','$data[NoBatch]','$data[Expire]','$data[HargaSatuan]','$data[IdProgram]','$data[NamaProgram]','$dtgudang[Stok]','$dtdepot[Stok]','$dtdepot_poli[Stok]','$dtdepot_igd[Stok]','$dtdepot_ranap[Stok]','$dtdepot_poned[Stok]','$dtdepot_pustu[Stok]','$dtdepot_pusling[Stok]')";	
					mysqli_query($koneksi, $str1);
				}
			}
			
			$jumlah_perpage = 150;
			if($_GET['h']==''){
				$mulai=0;
			}else{
				$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$key = $_GET['key'];
			$namaprg = $_GET['namaprg'];
			
			if($key !=''){
				$strcari = " AND (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%')";
			}else{
				$strcari = " ";
			}
			
			if($namaprg != ''){
				$namaprg = " AND `NamaProgram` = '$namaprg'";
			}else{
				$namaprg = " ";
			}
			
			// syaratnya gudang, depot <> 0, jika salahsatunya ada isi maka obat tetap ditampilkan
			$str = "SELECT * FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun'
			AND (StokGudang <> '0' OR StokDepot <> '0' OR StokPoli <> '0' OR StokIgd <> '0' OR StokRanap <> '0' OR StokPoned <> '0' 
			OR StokPustu <> '0')".$strcari.$namaprg;
			$str2 = $str." ORDER BY `IdProgram`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
			// echo $str2;
			
			if($_GET['h'] == null || $_GET['h'] == 1){
				$no = 0;
			}else{
				$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$query = mysqli_query($koneksi,$str2);
			while($data = mysqli_fetch_assoc($query)){	
				if($namaprogram != $data['NamaProgram']){
					echo "<tr style='border:1px sollid #000; font-weight: bold;'><td colspan='14'>$data[NamaProgram]</td></tr>";
					$namaprogram = $data['NamaProgram'];
				}	
				$no = $no + 1;
				$IdBarangPkm = $data['IdStokBulan'];
				$kodebarang = $data['KodeBarang'];
				$namabarang = $data['NamaBarang'];
				$nobatch = $data['NoBatch'];						
				$harga = $data['HargaSatuan'];
				$expire = $data['Expire'];
				
				if($data['SumberAnggaran'] == "APBD KAB/KOTA"){
					$sumber = "APBD";
				}else{
					$sumber = $data['SumberAnggaran'];
				}			
				
				// tbstokopnam_puskesmas_detail_fisik
				$dtgudang= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `KodePuskesmas`='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun'"));
				
				// total stok
				$ttl_stok = $dtgudang['StokGudang'] + $dtgudang['StokDepot'] + $dtgudang['StokPoli'] + $dtgudang['StokIgd'] + $dtgudang['StokRanap'] + $dtgudang['StokPoned'] + $dtgudang['StokPustu'];
				$ttl_rupiah = $ttl_stok * $harga;
				
				// tbgfk_vaksin 
				$dtgfkstok_vaksin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kodebarang'"));
			?>
			
				<tr style="border:1px solid #000;">
					<td align="center"><?php echo $no;?></td>
					<td align="center" class="kodebarangcls">
						<input type="hidden" name="kodebarang[<?php echo $IdBarangPkm;?>]" value="<?php echo $data['KodeBarang'];?>"/>
						<input type="hidden" name="idbarang[<?php echo $IdBarangPkm;?>]" value="<?php echo $data['IdStokBulan'];?>"/>
						<input type="hidden" name="namabarang[<?php echo $IdBarangPkm;?>]" value="<?php echo $data['NamaBarang'];?>"/>
						<input type="hidden" name="expire[<?php echo $IdBarangPkm;?>]" value="<?php echo $data['Expire'];?>"/>
						<input type="hidden" name="hargasatuan[<?php echo $IdBarangPkm;?>]" value="<?php echo $data['HargaSatuan'];?>"/>
						<input type="hidden" name="idprogram[<?php echo $IdBarangPkm;?>]" value="<?php echo $data['IdProgram'];?>"/>
						<input type="hidden" name="namaprogram[<?php echo $IdBarangPkm;?>]" value="<?php echo $data['NamaProgram'];?>"/>
						<?php echo $kodebarang;?>
					</td>
					<td align="left" class="namabarangcls"><?php echo $namabarang;?></td>
					<td align="center"><?php echo $expire;?></td>
										
					<!--sisa stok gudang-->
					<td align="center" style="background-color:#dbf7ff;">
						<?php 
							$dtgudang= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StokGudang` FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `KodePuskesmas`='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun'"));
						?>
						<input type="number" class="ipt" name="gudangobat[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;; text-align:right;" value="<?php echo $dtgudang['StokGudang'];?>"/>
					</td>
					
					<!--sisa stok depot-->
					<td align="center" style="background-color:#dbf7ff;">
						<?php
							$dtdepot= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StokDepot` FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `KodePuskesmas`='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun'"));
						?>
						<input type="number" class="ipt" name="depotobat[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;" value="<?php echo $dtdepot['StokDepot'];?>"/>
					</td>
					
					<!--sisa stok poli-->
					<td align="center" style="background-color:#dbf7ff;">
						<input type="number" class="ipt" name="depotpoli[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;" value="<?php echo rupiah($dtgudang['StokPoli']);?>"/>
					</td>
					
					<!--sisa stok igd-->
					<td align="center" style="background-color:#dbf7ff;">
						<input type="number" class="ipt" name="depotigd[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;" value="<?php echo rupiah($dtgudang['StokIgd']);?>"/>
					</td>
					
					<!--sisa stok ranap-->
					<td align="center" style="background-color:#dbf7ff;">
						<input type="number" class="ipt" name="depotranap[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;" value="<?php echo rupiah($dtgudang['StokRanap']);?>"/>
					</td>
					
					<!--sisa stok poned-->
					<td align="center" style="background-color:#dbf7ff;">
						<input type="number" class="ipt" name="depotponed[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;" value="<?php echo rupiah($dtgudang['StokPoned']);?>"/>
					</td>
					
					<!--sisa stok pustu-->
					<td align="center" style="background-color:#dbf7ff;">
						<input type="number" class="ipt" name="depotpustu[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;" value="<?php echo rupiah($dtgudang['StokPustu']);?>"/>
					</td>
					
					<!--sisa stok pusling-->
					<td align="center" style="background-color:#dbf7ff;">
						<input type="number" class="ipt" name="depotpusling[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;" value="<?php echo rupiah($dtgudang['StokPusling']);?>"/>
					</td>
					
					<!--total-->
					<td align="right"><?php echo rupiah($ttl_stok);?></td>
					
					<!--total harga-->
					<td align="right">
						<?php
							// cek jika ada koma
							$cekkoma = strpos($ttl_rupiah,".");
							if ($cekkoma > 1){;
								echo number_format($ttl_rupiah,2,",",".");
							}else{
								echo rupiah($ttl_rupiah);
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
<?php
}
?>
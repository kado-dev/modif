<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	$hariini = date('d-m-Y');
    $nf = $_GET['nf'];
	$bulan = $_GET['bl'];
    $tahun = $_GET['th'];
    $tahunlalu = $_GET['th'] - 1;
    $triwulan = $_GET['triwulan'];
    $namapuskesmas = $_SESSION['namapuskesmas'];
    $kodepuskesmas = $_SESSION['kodepuskesmas'];
	$kota = $_SESSION['kota'];
	$kecamatan = $_SESSION['kecamatan'];
	$kelurahan = $_SESSION['kelurahan'];
	$alamat = $_SESSION['alamat'];

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=Stok Opname (".$triwulan." ".$tahun." ".$namapuskesmas.").xls");
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
	<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b>DINAS KESEHATAN</b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>STOK OPNAME TRIWULAN PUSKESMAS</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
    <table id="" class="table-judul-form" border="1">
        <thead>
			<tr>
				<th width="4%" rowspan="2">Kode</th>
				<th width="12%" rowspan="2">Nama Barang</th>
				<th width="4%" rowspan="2">Satuan</th>
				<th width="8%" colspan="2">Harga Satuan</th>
				<th width="8%" colspan="2">Stok Awal <br/>(31 Des <?php echo $tahunlalu?>)</th>
				<th width="8%" colspan="2">Penerimaan</th>
				<th width="8%" colspan="2">Pemakaian</th>
				<th width="30%" colspan="7">Sisa Stok Per <?php echo nama_bulan($bulan)." ".$tahun;?></th>
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
			
			$str = "SELECT * FROM `ref_obat_lplpo`";
			$str2 = $str." ORDER BY IdLplpo, NamaBarang ASC";
			// echo $str2;
						
			$query = mysqli_query($koneksi,$str2);
			while($data = mysqli_fetch_assoc($query)){	
				if($namaprogram != $data['NamaProgram']){
					echo "<tr style='border:1px sollid #000; font-weight: bold;'><td colspan='22'>$data[NamaProgram]</td></tr>";
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
			
				//$totalreal = $dtstokpuskesmas['StokGudang'] + $dtstokpuskesmas['StokDepot'] + $dtstokpuskesmas['StokPoli'] + $dtstokpuskesmas['StokIgd'] + $dtstokpuskesmas['StokRanap'] + $dtstokpuskesmas['StokPoned'] + $dtstokpuskesmas['StokPustu'];
				//$totalhargareal = $totalreal * $dtgudangpkm['HargaSatuan'];
			?>
			
				<tr style="border:1px solid #000;">
					<td align="center" class="kodecls"><?php echo $data['KodeBarang'];?></td>
					<td align="left"><?php echo $data['NamaBarang'];?></td>
					<td align="center"><?php echo $data['Satuan'];?></td>
					<!--Harga-->
					<td align="right" class="hargasatuan"><?php echo rupiah($dtgudangpkm_apbd['HargaSatuan']);?></td>
					<td align="right" class="hargasatuan"><?php echo rupiah($dtgudangpkm_jkn['HargaSatuan']);?></td>
					
					<!--Stok Awal-->
					<td align="right" style="background-color:#f8d7da;"></td>
					<td align="right" style="background-color:#f8d7da;"></td>
					
					<!--Penerimaan-->
					<td align="right" style="background-color:#f8d7da;"></td>
					<td align="right" style="background-color:#f8d7da;"></td>
					
					<!--Pemakaian-->
					<td align="right" style="background-color:#f8d7da;"></td>
					<td align="right" style="background-color:#f8d7da;"></td>
					
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
					<td align="right" class="totalreal"><?php //echo rupiah($totalreal);?></td>
					<td align="right" class="totalreal"><?php //echo rupiah($totalreal);?></td>
					
					<!--Total Rupiah-->
					<td align="right" class="totalhargareal"><?php //echo rupiah($totalhargareal);?></td>
					<td align="right" class="totalhargareal"><?php //echo rupiah($totalhargareal);?></td>
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
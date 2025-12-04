<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	include_once('config/helper_pasienrj.php');
	$hariini = date('d-m-Y');
	$namaprg = $_GET['namaprg'];
	$sumberanggaran = $_GET['sumberanggaran'];
	$jmltersedia = $_GET['jmltersedia'];
	$key = $_GET['key'];
		
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Stok_Gudang_Obat_Puskesmas (".$hariini.").xls");
	if(isset($key)){
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
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:14px;
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN STOK GUDANG OBAT PUSKESMAS</b></h4>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
		<thead>
			<tr>
				<th width="3%">NO.</th>
				<th width="6%">KODE</th>
				<th width="20%">NAMA BARANG</th>
				<th width="8%">SATUAN</th>
				<th width="10%">BATCH</th>
				<th width="8%">EXPIRE</th>
				<th width="15%">SUMBER</th>
				<th width="6%">STOK</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if($namaprg == 'Semua' || $namaprg == ''){
				$namaprogram = "";
			}else{
				$namaprogram = " AND `NamaProgram` = '$namaprg'";
			}

			if($sumberanggaran == 'Semua' || $sumberanggaran == ''){
				$sbanggaran = "";
			}else{
				$sbanggaran = " AND `SumberAnggaran` = '$sumberanggaran'";
			}

			if($jmltersedia == 'Keseluruhan'){
				$stoks = "";
			}elseif($jmltersedia == 'Expire'){
				$stoks = "`Stok` > '0' AND `Expire` < '$hariini' AND `NamaProgram` != 'VAKSIN' AND";
			}else{
				$stoks = "`Stok` > '0' AND";
			}						
						
			if($key != ''){
				$strcari = "(`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%' OR `SumberAnggaran` like '%$key%' OR `NamaProgram` like '%$key%')";
			}else{
				$strcari = " `SumberAnggaran` != 'BLUD'";
			}
			
			$str = "SELECT * FROM `$tbgudangpkmstok` WHERE".$stoks.$strcari.$namaprogram.$sbanggaran;			
			$str2 = $str." ORDER BY NamaBarang";						
			// echo $str2;

			$query = mysqli_query($koneksi,$str2);
			while($data = mysqli_fetch_assoc($query)){
				$no = $no + 1;
				$kdbrg = $data['KodeBarang'];
				$nobatch = $data['NoBatch'];
				$Expire = $data['Expire'];
				$program = $data['NamaProgram'];

				// mencari jumlah hari sebelum expire
				$wl = explode("-",$Expire);
				$waktu_expire = mktime(0,0,0,$wl[1],$wl[2],$wl[0]);
				$now = mktime(0,0,0,date("m"),date("d"),date("Y"));
				$selisih = $waktu_expire - $now;
				$day = floor($selisih/86400);
			
				if($day < 180){	
					if($day > 0){
						$warna = 'yellow';
					}else{
						$warna = 'pink';
					}
				}elseif($data['Stok'] <= $data['MinimalStok']){
					$warna = 'lightblue';
				}else{
					$warna = 'white';
				}
				
				// tbgfkstok
				$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kdbrg'"));
				
				// tbgfk_vaksin 
				$dtgfkstok_vaksin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kdbrg'"));
			?>
				
				<tr style="background:<?php echo $warna;?>;" data-idbarang="<?php echo $datapenerimaan['IdBarangGdgPkm'];?>">
					<td align="right"><?php echo $no;?></td>
					<td align="center"><?php echo $data['KodeBarang'];?></td>
					<td align="left" class="nama">
						<?php 
							if($data['NamaBarang'] != ""){
								echo strtoupper($data['NamaBarang']);
							}elseif($dtgfkstok['NamaBarang'] != ""){
								echo strtoupper($dtgfkstok['NamaBarang']);
							}else{
								echo strtoupper($dtgfkstok_vaksin['NamaBarang']);
							}
							
						?>
						<span class="badge badge-success" style='padding: 4px;'><?php echo $program;?></span>
					</td>
					<td align="center">
						<?php 
							if($data['Satuan'] != ""){
								echo strtoupper($data['Satuan']);
							}elseif($dtgfkstok['Satuan'] != ""){
								echo $dtgfkstok['Satuan'];
							}else{
								echo $dtgfkstok_vaksin['Satuan'];
							}	
						?>
					</td>
					<td align="center"><?php echo str_replace(",", ", ", $data['NoBatch']);?></td>
					<td align="center"><?php echo $data['Expire'];?></td>
					<td align="center">
						<?php 
							if($data['SumberAnggaran'] == "APBD KAB/KOTA"){
								$sumber = "APBD";
							}else{
								$sumber = $data['SumberAnggaran'];
							}										
							echo $sumber." - ".$data['TahunAnggaran'];
						?>
					</td>
					<td align="right" style="color:red;font-weight:bold"><?php echo $data['Stok'];?></td>
					<?php
						if (in_array("PROGRAMMER", $otoritas) || in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){
					?>
					<td align="center">
						<a href="?page=apotik_gudang_stok_edit&kd=<?php echo $data['KodeBarang'];?>&pkm=<?php echo $data['KodePuskesmas'];?>&nb=<?php echo $data['NoBatch'];?>" class="btn btn-sm btn-round btn-info">CEK STOK</a>
						<a href="?page=apotik_gudang_stok_lihat&id=<?php echo $data['IdBarangGdgPkm'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-sm btn-round btn-primary">DETAIL</a>
						<!--<a href="?page=apotik_gudang_stok_delete&id=<?php echo $data['IdBarangGdgPkm'];?>&key=<?php echo $_GET['key'];?>&h=<?php echo $_GET['h'];?>" class="btn btn-sm btn-danger" onClick="return confirm('Anda yakin data ingin dikosongkan...?')">Habis</a>-->
					</td>	
					<?php
						}
					?>
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
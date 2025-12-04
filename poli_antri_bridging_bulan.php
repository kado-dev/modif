<?php
	include "config/helper_pasienrj.php";
	$pel = $_GET['pelayanan'];
	$tanggal = date('Y-m-d');
	
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
	display: none;
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
	display: none;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	display:none;
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

<!--cari data-->
<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>PASIEN GAGAL BRIDGING</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="poli_antri_bridging_bulan"/>
						<input type="hidden" name="pelayanan" value="<?php echo $pel;?>"/>
						<div class="col-sm-2">
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
						<div class="col-sm-1">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-5">
							<input type="text" name="nama" class="form-control" value="<?php echo $_GET['nama'];?>" placeholder = "Masukan Nama Pasien">
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=poli_antri_bridging_bulan" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
	
	<!--data pasien-->
	<div class="table-responsive noprint">
		<table class="table-judul-laporan">
			<thead>
				<tr>
					<th width="3%">NO.</th>
					<th width="8%">TANGGAL</th>
					<th width="8%">NO.INDEX</th>
					<th width="15%">NAMA PASIEN</th>
					<th width="5%">L/P</th>
					<th width="10%">PELAYANAN</th>
					<th width="10%">NO.JAMINAN</th>
					<th width="8%">BRIDGING</th>
					<th>KETERANGAN</th>
					<th width="5%">#</th>
				</tr>
			</thead>
			<tbody font="8">
			<?php
			$jumlah_perpage = 50;
			
			if($_GET['h']==''){
				$mulai=0;
			}else{
				$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$nama = $_GET['nama'];	
			$tanpatgl = $_GET['tptgl'];
			$bulan = $_GET['bulan'];
			$tahun = $_GET['tahun'];
			$plhbulan = $_GET['plhbulan'];
			$plhtahun = date('Y');
			$bulanini = date('m');

			if($nama != null){
				$nama_str = " AND NamaPasien like '%$nama%'";
			}else{
				$nama_str = "";
			}	
			
			if($plhbulan != ''){
				$str = "SELECT * FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi)='$plhbulan' AND YEAR(TanggalRegistrasi)='$plhtahun' AND `Asuransi` like '%BPJS%' AND `StatusPasien` <> '2' AND `StatusPelayanan`='Sudah' AND `StatusPulang`='3' AND `PoliPertama`='$pel' AND (LENGTH(`NoKunjunganBpjs`) < 15)".$nama_str;
			}else{
				$str = "SELECT * FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND `Asuransi` like '%BPJS%' AND `StatusPasien` <> '2' AND `StatusPelayanan`='Sudah' AND `StatusPulang`='3' AND (LENGTH(`NoKunjunganBpjs`) < 15)".$nama_str;
			}			
			$str2 = $str." order by TanggalRegistrasi DESC LIMIT $mulai,$jumlah_perpage";
			// echo $str2;
			// die();
			
			if($_GET['h'] == null || $_GET['h'] == 1){
				$no = 0;
			}else{
				$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$query = mysqli_query($koneksi,$str2);
			while($data = mysqli_fetch_assoc($query)){
			$no = $no + 1;
			
			$noindex = $data['NoIndex'];

			if(strlen($noindex) == 24){
				$noindex2 = substr($data['NoIndex'],14);
			}else{
				$noindex2 = $data['NoIndex'];
			}
			?>
				<tr>
					<td style="text-align:right;"><?php echo $no;?></td>
					<td style="text-align:center;"><?php echo $data['TanggalRegistrasi'];?></td>
					<td style="text-align:center;"><?php echo $noindex2;?></td>
					<td style="text-align:left;"class="namakk"><?php echo $data['NamaPasien'];?></td>
					<td style="text-align:center;"><?php echo $data['JenisKelamin'];?></td>					
					<td style="text-align:center;"><?php echo $data['PoliPertama'];?></td>
					<td style="text-align:center;"><?php echo $data['nokartu'];?></td>
					<td style="text-align:center;">
						<?php 
							// if(substr($data['Asuransi'],0,4) == "BPJS" AND $data['StatusPelayanan'] == "Sudah"){
								if(strlen($data['NoKunjunganBpjs']) == 3 OR $data['NoKunjunganBpjs'] == "" OR $data['NoKunjunganBpjs'] == 0){
									echo "GAGAL";
								}else{
									echo "BERHASIL";
								}
							// }else{
								// echo "-";
							// }	
						?>
					</td>
					<td style="text-align:center;"><?php echo $data['KeteranganBridging'];?></td>
					<td align="center">
					<?php
					if($data['StatusPelayanan'] == 'Sudah'){
					?>
						<a href="?page=poli_periksa_edit&no=<?php echo $data['NoRegistrasi'];?>&pelayanan=<?php echo $data['PoliPertama'];?>" class="btn btn-xs btn-info">Edit</a>
						<?php
						if($data['StatusPulang'] == 'Rujuk Lanjut'){
						?>
						<a href="?page=cetak_rujukan_bpjs&no=<?php echo $data['NoRegistrasi'];?>&pelayanan=<?php echo $data['PoliPertama'];?>" class="btn btn-xs btn-success">Cetak</a>
					<?php 
						}
					}else{ 
					?>	
						<a href="?page=poli_periksa&no=<?php echo $data['NoRegistrasi'];?>&pelayanan=<?php echo $data['PoliPertama'];?>&status=<?php echo $data['StatusPelayanan'];?>&tptgl=<?php echo $data['TanggalRegistrasi'];?>&sts_resep=bulan" class="btn btn-xs btn-primary"></i>Periksa</a>
					<?php 
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
						echo "<li><a href='?page=poli_antri_bridging_bulan&plhbulan=$bulanini&pelayanan=$pel&bulan=$bulan&tahun=$tahun&nama=$nama&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	// }
	?>
</div>

<!--tabel report-->
<div class="printheader">
	<?php
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
	$kota1 = $datapuskesmas['Kota'];
	$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` WHERE `Kota` = '$kota1'"));
	?>
	<?php 
	if($kdpuskesmas == 'semua'){
	?>
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
	<?php
	}else{
	?>
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$datapuskesmas['Kota'];?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $datadinas['NamaDinkes'];?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$datapuskesmas['NamaPuskesmas'];?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $datapuskesmas['Alamat']?></span>
	<?php	
	}
	?>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN DATA PASIEN BELUM DIENTRY</b></span><br>
	<br/>
</div>

<div class="atastabel font11">
	<div style="float:left; width:65%; margin-bottom:10px;">
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;">Kode Puskesmas</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo$datapuskesmas['KodePuskesmas'];?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Puskesmas</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo$datapuskesmas['NamaPuskesmas'];?></td>
			</tr>
		</table><p/>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table>
			<tr>
				<td style="padding:2px 4px;">Kelurahan/Desa</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo$datapuskesmas['Kelurahan'];?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Kecamatan</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo$datapuskesmas['Kecamatan'];?></td>
			</tr>
		</table>
	</div>	
</div>

<div class="printbody">
	<table class="table table-condensed">
		<thead style="font-size:10px;">
			<tr style="border:1px dashed #000;">
				<th style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
				<th style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Tanggal</th>
				<th style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.Reg</th>
				<th style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.Index</th>
				<th style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Pasien</th>
				<th style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">L/P</th>
				<th style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Umur</th>
				<th style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Poli Pertama</th>
				<th style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Jaminan</th>
				<th style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Status</th>
				<th class="noprint">Opsi</th>
			</tr>
		</thead>
		<tbody style="font-size:10px;">
			<?php			
			$nama = $_GET['nama'];	
			$tanpatgl = $_GET['tptgl'];
			$no = 0;

			if($nama != null){
				$nama_str = " AND NamaPasien like '%$nama%'";
			}else{
				$nama_str = "";
			}	
			
			$str = "SELECT * FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi)='$bulan' and YEAR(TanggalRegistrasi)='$tahun' and substring(NoRegistrasi,1,11) = '$kodepuskesmas' and StatusPelayanan='Antri'".$nama_str;
			$str2 = $str." order by TanggalRegistrasi";
			
			$query = mysqli_query($koneksi,$str2);
			while($data = mysqli_fetch_assoc($query)){
			$no = $no + 1;
			$noindex = $data['NoIndex'];

			if(strlen($noindex) == 24){
				$noindex2 = substr($data['NoIndex'],14);
			}else{
				$noindex2 = $data['NoIndex'];
			}
			?>
				<tr>
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['TanggalRegistrasi'];?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo substr($data['NoRegistrasi'],19);?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $noindex2;?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;" class="namakk"><?php echo $data['NamaPasien'];?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['JenisKelamin'];?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['UmurTahun'];?> Thn, <?php echo $data['UmurBulan'];?> Bln,  <?php echo $data['UmurHari'];?> Hri</td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['PoliPertama'];?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Asuransi'];?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['StatusPelayanan'];?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;" class="noprint">
					<?php
					if($data['StatusPelayanan'] == 'Sudah'){
					?>
						<a href="?page=poli_periksa_edit&no=<?php echo $data['NoRegistrasi'];?>&pelayanan=<?php echo $pel;?>"><i class="ace-icon fa fa-pencil-square-o bigger-130"></i> Edit</a>
						<?php
						if($data['StatusPulang'] == 'Rujuk Lanjut'){
						?>
						<a href="?page=cetak_rujukan_bpjs&no=<?php echo $data['NoRegistrasi'];?>&pelayanan=<?php echo $pel;?>"><i class="ace-icon fa fa-print bigger-130"></i> Cetak</a>
					<?php 
						}
					}else{ 
					?>	
						<a href="?page=poli_periksa&no=<?php echo $data['NoRegistrasi'];?>&pelayanan=<?php echo $data['PoliPertama'];?>&status=<?php echo $data['StatusPelayanan'];?>&tptgl=<?php echo $data['TanggalRegistrasi'];?>&sts_resep=bulan"><i class="ace-icon fa fa-folder-open bigger-130"></i> Periksa</a>
					<?php 
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

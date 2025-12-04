<?php
	include "config/helper_report.php";
	$otoritas = explode(',',$_SESSION['otoritas']);
	$kota = $_SESSION['kota'];
?>

<style>
.tr, th{
	text-align:center;
}

.kotak_retribusi{
   	background: #c6efe8;
    padding: 10px 15px;	
    margin: 5px 0px;
	font-family: Sans-Serif;
	text-align:center;
	color:#3BAC9B;
	border-radius:5px;
}

.font30_bold{
	font-family: Sans-Serif;
	font-size: 30px;
	font-weight: bold;
	text-align: left;
	color:#3BAC9B;
}

@media screen and (max-width: 992px) {
	.kotak_retribusi{
		width: 100%;
		margin-bottom:15px;
	}
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

<?php
$tahun = date('Y');
$jumlah_faktur = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM tbgudangpkmpenerimaandetail a JOIN tbgudangpkmpenerimaan b ON a.NoFaktur = b.NoFaktur WHERE a.KodePuskesmas = '$kodepuskesmas' AND YEAR(b.TanggalPenerimaan)='$tahun' GROUP BY a.NoFaktur"));
$belum_validasi = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM tbgudangpkmpenerimaandetail a JOIN tbgudangpkmpenerimaan b ON a.NoFaktur = b.NoFaktur WHERE a.KodePuskesmas = '$kodepuskesmas' AND YEAR(b.TanggalPenerimaan)='$tahun' AND b.StatusValidasi='Belum' GROUP BY a.NoFaktur"));
// obat
$grand_total_obat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah FROM tbgfkpengeluarandetail a JOIN tbgfkpengeluaran b ON a.NoFaktur= b.NoFaktur WHERE b.KodePenerima='$kodepuskesmas' AND YEAR(b.TanggalPengeluaran) = '$tahun'"));

// vaksin
$grand_total_vaksin = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(a.Jumlah * a.Harga) AS Jumlah FROM `tbgfk_vaksin_pengeluarandetail` a JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE b.Penerima = '$namapuskesmas' AND YEAR(b.TanggalPengeluaran)='$tahun'"));
$grand_total = $grand_total_obat['Jumlah'] + $grand_total_vaksin['Jumlah']
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<?php echo $_GET['msg']; ?>
			<a href="index.php?page=dashboard" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>PENERIMAAN </b><small>Gudang Obat Puskesmas</small></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="apotik_gudang_penerimaan"/>
						<div class="col-sm-6">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder ="Ketikan Nama Barang / No.Faktur">
						</div>
						<div class="col-sm-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=apotik_gudang_penerimaan" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print"></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!--data barang-->
	<div class="row noprint">	
		<div class="col-sm-12">	
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<th>Jumlah Faktur</th>
						<th>Belum di Validasi</th>
						<th>Total Obat <?php echo date('Y');?></th>
						<th>Total Vaksin <?php echo date('Y');?></th>
					</thead>
					<tbody style="font-size: 22px;">
						<td align="center"><?php echo $jumlah_faktur;?></td>
						<td align="center"><?php echo $belum_validasi;?></td>
						<td align="center"><?php echo "Rp. ".rupiah($grand_total_obat['Jumlah']);?></td>
						<td align="center"><?php echo "Rp. ".rupiah($grand_total_vaksin['Jumlah']);?></td>
					</tbody>
				</table><br/>
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="3%">No</th>
							<th width="8%">Tanggal</th>
							<th width="10%">No.Faktur</th>
							<th width="10%">Terima Dari</th>
							<th width="10%">Grand Total</th>
							<th width="12%">Status Barang</th>
							<?php if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>
							<th width="5%">Aksi</th>
							<?php }?>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 20;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$kategori = $_GET['kategori'];		
						$key = $_GET['key'];	
						$tahun = $_GET['tahun'];	
						$tahunini = date('Y');	
						
						if($tahun == ''){
							$strcari = "AND (SUBSTRING(a.NoFaktur,8,4)='$tahunini' OR SUBSTRING(a.NoFaktur,10,4)='$tahunini')";
						}else{
							$strcari = "AND (SUBSTRING(a.NoFaktur,8,4)='$tahun' OR SUBSTRING(a.NoFaktur,10,4)='$tahun')";
						}
						
						if($key != ''){
							$namabarang = " AND (a.NoFaktur like '%$key%' OR b.NamaBarang like '%$key%')";
						}else{
							$namabarang = "";
						}		
						
						$str = "SELECT * FROM tbgudangpkmpenerimaandetail a LEFT JOIN tbgudangpkmstok b ON a.KodeBarang = b.KodeBarang
						WHERE a.KodePuskesmas = '$kodepuskesmas'".$strcari.$namabarang;
						$str2 = $str." GROUP BY NoFaktur ORDER BY Id DESC LIMIT $mulai,$jumlah_perpage";
						echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;						
							$nofaktur = $data['NoFaktur'];						
							$kodepuskesmas= $data['KodePuskesmas'];
							
							// tbgudangpkmpenerimaan
							$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `TanggalPenerimaan`,`JamPenerimaan` FROM `tbgudangpkmpenerimaan` WHERE `NoFaktur`='$nofaktur'"));
						
							// jml item
							$jmlitem = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbgudangpkmpenerimaandetail` WHERE `NoFaktur`='$nofaktur'"));
							$validasi_belum = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbgudangpkmpenerimaandetail` WHERE `NoFaktur`='$data[NoFaktur]' AND `StatusValidasi`='Belum'"));
						?>
							<tr>
								<td align="right"><?php echo $no;?></td>
								<td align="center"><?php echo $dtpenerimaan['TanggalPenerimaan'].", ".$dtpenerimaan['JamPenerimaan'];?></td>
								<td align="center"><?php echo $data['NoFaktur'];?></td>
								<td align="center">
								<?php 
									if(substr($nofaktur, -9) == "IMUNISASI"){
										echo "GUDANG VAKSIN";
									}else{
										echo "GUDANG OBAT";
									}	
								?>
								</td>
								<td align="right">
									<b>
										<?php 
											$strgt = "SELECT SUM(a.Jumlah * a.HargaBeli) AS Jumlah 
											FROM tbgudangpkmpenerimaandetail a JOIN tbgudangpkmpenerimaan b ON a.NoFaktur = b.NoFaktur
											WHERE a.NoFaktur = '$data[NoFaktur]'";
											$dtgt = mysqli_fetch_assoc(mysqli_query($koneksi, $strgt));
											echo rupiah($dtgt['Jumlah']);
										?>
									</b>
								</td>
								<td align="center">
									<span class="badge badge-success" style="padding: 5px 10px;"><?php echo $jmlitem." Item";?></span>
									<?php if($validasi_belum > 0){?>
									<span class="badge badge-danger" style="padding: 5px 10px;"><?php echo $validasi_belum." Blm Validasi";?></span>
									<?php } ?>
								</td>
								<?php if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>
								<td align="center">
									<a href="?page=apotik_gudang_penerimaan_lihat&id=<?php echo $data['NoFaktur'];?>" class="btn btn-xs btn-info btn-white">Lihat</a>
								</td>	
								<?php }?>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

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
						echo "<li><a href='?page=apotik_gudang_penerimaan&key=$key&tahun=$tahun&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul> 

	<div class="row noprint">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<p><b>Keterangan : </b></br>
				Penerimaan Gudang Obat Puskesmas bersumber dari UPT Farmasi Dinas Kesehatan Kab/Kota.</p>	
			</div>
		</div>
	</div>
</div>

<!--tabel report-->
<div class="printheader">
	<span class="font14" style="margin:5px; font-weight:bold;">PEMERINTAH <?php echo $kota;?></span><br>
	<span class="font14" style="margin:5px; font-weight:bold;">DINAS KESEHATAN</span><br>
	<span class="font10" style="margin:5px;"><?php echo $alamat;?></span><br>
	<hr style="margin:3px; border:1.5px solid #000">
	<span class="font11" style="margin:15px 5px 5px 5px; font-weight:bold;">LAPORAN PENERIMAAN BARANG (APBD)</span><br>
</div>

<div class="atastabel font11">
	<div style="float:left; width:65%; margin-bottom:10px;">
		<table>
			<tr>
				<td style="padding:2px 4px;">Kode Puskesmas</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $kodepuskesmas;?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Nama Puskesmas</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $namapuskesmas;?></td>
			</tr>
		</table>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table>
			<tr>
				<td style="padding:2px 4px;">Kelurahan </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $kelurahan;?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Kecamatan </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $kecamatan;?></td>
			</tr>
		</table>
	</div>
</div>

<div class="printbody font10">
	<table><!--table-condensed pada bootstrap.min.css ".table-condensed>tfoot>tr>td{padding:3px}"-->
		<thead>
			<tr>
				<th width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No</th>
				<th width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tanggal</th>
				<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.Faktur</th>
				<th width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Puskesmas</th>
				<th width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Terima Dari</th>
				<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Grand Total</th>
				<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Validasi</th>
			</tr>
		</thead>
		<tbody class="font10">
			<?php
			$kategori = $_GET['kategori'];		
			$key = $_GET['key'];
			$tahun = date('Y');
			if($kategori != '' && $key != ''){
				if($kategori == 'Tahun'){
					$strcari = "AND YEAR(TanggalPenerimaan) = '$key'";
				}else if($kategori == 'NoFaktur' || $kategori == 'TerimaDari'){
					$strcari = "AND ".$kategori." Like '%$key%'";
				}else{
					$strcari = "AND YEAR(TanggalPenerimaan) ='$tahun' AND ".$kategori." Like '%$key%'";
				}
			}else{
				$strcari = " AND YEAR(TanggalPenerimaan)='$tahun'";
			}
			
			$str_report = "SELECT * FROM `tbgudangpkmpenerimaan` WHERE `KodePuskesmas` = '$kodepuskesmas'".$strcari." order by `TanggalPenerimaan` DESC";
			$query_report = mysqli_query($koneksi,$str_report);
			while($data_report = mysqli_fetch_assoc($query_report)){
			$no = $no + 1;
			?>
				<tr>
					<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $no;?></td>
					<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $data_report['TanggalPenerimaan'];?></td>
					<td style="text-align:center; padding:3px;border:1px solid #000;"><?php echo $data_report['NoFaktur'];?></td>
					<?php
						$kodepuskesmas= $data_report['KodePuskesmas'];
						$strdatapkm = "SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas`='$kodepuskesmas'";
						$querypkm=mysqli_query($koneksi,$strdatapkm);
						$datapkm = mysqli_fetch_assoc($querypkm)
					?>
					<td class="nama" style="text-align:left; padding:3px;border:1px solid #000;"><?php echo $datapkm['NamaPuskesmas'];?></td>
					<td style="text-align:left; padding:3px;border:1px solid #000;"><?php echo $data_report['TerimaDari'];?></td>
					<?php
						// tbgfkpengeluaran, buat ngambil grandtotal
						$dt_gfkp = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `GrandTotal` FROM `tbgfkpengeluaran` WHERE `NoFaktur` = '$data_report[NoFaktur]'"));
					?>
					<td style="text-align:right; padding:3px;border:1px solid #000;"><?php echo rupiah($dt_gfkp['GrandTotal']);?></td>
					<td style="text-align:center; padding:3px;border:1px solid #000;">
					<?php 
						if($data_report['StatusValidasi'] == 'Belum'){
							?><span style="color:red;"><?php echo $data_report['StatusValidasi'];?></span><?php
						}else{
							?><span style="color:black;"><?php echo $data_report['StatusValidasi'];?></span><?php
						}
					?>
				</tr>
			<?php
			}
			?>
			<tr style="border:1px solid #000; padding:3px;">
				<td colspan="7" style="text-align:center; padding:3px; font-weight:bold; font-size:14px;"><?php echo "Total Keseluruhan = ".rupiah($grand_total);?></td>
			</tr>
		</tbody>
	</table>
</div>	

<div class="bawahtabel">
	<table width="100%">
		<tr>
			<td width="70%"></td>
			<td width="30%"style="text-align:center;">
			Petugas
			<br>
			<br>
			<br>
			(................................)
			</td>
		</tr>
	</table>
</div>

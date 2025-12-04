<?php
	include "otoritas.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$tanggal = date('Y-m-d');
?>
<style>

.printheader{
	margin-top:-30px;
	margin-left:px;
	margin-right:0px;
	text-align:center;
	display:none;
}
.printheader h4{
	font-size:12px;
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.printheader p{
	font-size:10px;
}
.printbody{
	margin-left:0px;
	margin-right:0px;
	display: none;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.atastabel{
	display:none;
	margin-top:10px;
}
.bawahtabel{
	margin-top:20px;
	margin-bottom:10px;
	margin-left:50px;
	display:none;
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

<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Laporan Pemantauan Imunisasi</h1>
		</div>
	</div>
</div>

<!--cari pasien-->
<div class="row noprint">
	<div class="col-xs-12 col-sm-12">
		<div class="search-area well well-sm">
			<div class="search-filter-header bg-primary">
				<h4 class="panel-title"><i class="fa fa-search"></i> Cari Berdasar</h4>
			</div>
			<div class="space-10"></div>
			<div class = "row">
				<form role="form">
					<input type="hidden" name="page" value="lap_imunisasi_pemantauan"/>
					<div class="col-sm-2">
						<SELECT name="bulan" class="form-control">
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
						</SELECT>
					</div>
					<div class="col-sm-1" style ="width:125px">
						<SELECT name="tahun" class="form-control">
							<?php
								for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
								?>
								<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
							<?php }?>
						</SELECT>
					</div>
					<?php
					if($_SESSION['kodepuskesmas'] == '-'){
					?>
						<div class="col-sm-2">
							<SELECT name="kodepuskesmas" class="form-control">
							<option value='semua'>Semua</option>
							<?php
							$kota = $_SESSION['kota'];
							$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `Kota`='$kota' order by `NamaPuskesmas`");
							while($data3 = mysqli_fetch_assoc($queryp)){
								echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
							}
							?>
							</SELECT>
						</div>
					<?php
					}
					?>
					<div class="col-sm-5">
						<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
						<a href="?page=lap_imunisasi_pemantauan" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
						<a href="lap_imunisasi_pemantauan_print.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>" target="_blank" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						<?php if ($kodepuskesmas != '-'){?>
							<a href="?page=laporan_pemeriksaan" class="btn btn-sm btn-purple"><span class="fa fa-arrow-circle-left"></span></a>
						<?php }else{ ?>
							<a href="?page=laporan_imunisasi" class="btn btn-sm btn-purple"><span class="fa fa-arrow-circle-left"></span></a>
						<?php }?>
					</div>
				</form>	
			</div>
		</div>
	</div>	
</div>
<?php
$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];
$tbpasienrj = 'tbpasienrj_'.$bulan;
if($_SESSION['kodepuskesmas'] == '-'){
	$kdpuskesmas = $_GET['kodepuskesmas'];
	if($kdpuskesmas == 'semua'){
		$semua = " ";
	}else{
		$semua = " AND substring(NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
	}
}else{
	$kdpuskesmas = $_SESSION['kodepuskesmas'];
	$semua = " AND substring(NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
}
if(isset($bulan) and isset($tahun)){
?>

<!--data registrasi-->
<div class="table-responsive noprint">
	<table class="table table-condensed">
		<thead style="font-size:10px;">
			<tr style="border:1px dashed #000;">
				<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
				<th rowspan="2" style="text-align:center;width:1%;vertical-align:middle; border:1px dashed #000; padding:3px;">No.Index</th>
				<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Bayi</th>
				<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px dashed #000; padding:3px;">Nama KK</th>
				<th rowspan="2" style="text-align:center;width:1%;vertical-align:middle; border:1px dashed #000; padding:3px;">L/P</th>
				<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px dashed #000; padding:3px;">Alamat</th>
				<th colspan="13" style="text-align:center;width:2%;vertical-align:middle; border:1px dashed #000; padding:3px;">Jenis Imunisasi Diberikan</th>
				<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px dashed #000; padding:3px;">Ket</th>
			</tr>
			<tr style="border:1px dashed #000;">
				<th valign="middle" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">HBO</th>
				<th valign="middle" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Bcg</th>
				<th valign="middle" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">DPT HB HIB1</th>
				<th valign="middle" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">DPT HB HIB2</th>
				<th valign="middle" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">DPT HB HIB3</th>
				<th valign="middle" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Polio1</th>
				<th valign="middle" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Polio2</th>
				<th valign="middle" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Polio3</th>
				<th valign="middle" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Polio4</th>
				<th valign="middle" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">IPV</th>
				<th valign="middle" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Campak Rubella</th>
				<th valign="middle" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Booster DPT HB HIB</th>
				<th valign="middle" style="text-align:center;width:2%; border:1px dashed #000; padding:3px;">Booster Campak Rubella</th>
			</tr>
		</thead>
		<tbody style="font-size:10px;">
			<!--paging-->
			<?php
			$jumlah_perpage = 50;
			
			if($_GET['h']==''){
				$mulai=0;
			}else{
				$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$str = "SELECT a.NoCM, a.NoIndex, b.NamaPasien, a.NoPemeriksaan,a.Anamnesa, b.JenisKelamin,a.TanggalPeriksa,b.UmurTahun  FROM `tbpoliimunisasi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE MONTH(a.TanggalPeriksa) = '$bulan' and YEAR(a.TanggalPeriksa) = '$tahun' and substring(a.NoPemeriksaan,1,11) = '$kdpuskesmas'";
			$str2 = $str." GROUP BY a.NoCM ORDER BY a.TanggalPeriksa Desc limit $mulai,$jumlah_perpage";
			//echo ($str2);
			// die();
			
			if($_GET['h'] == null || $_GET['h'] == 1){
				$no = 0;
			}else{
				$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$query = mysqli_query($koneksi,$str2);
			
			while($data = mysqli_fetch_assoc($query)){
			$no = $no + 1;
			$noregistrasi = $data['NoPemeriksaan'];
			$noindex = $data['NoIndex'];
			$anamnesa = $data['Anamnesa'];
			$kelamin = $data['JenisKelamin'];
			
			if(strlen($noindex) == 24){
				$noindex2 = substr($data['NoIndex'],14);
			}else{
				$noindex2 = $data['NoIndex'];
			}
			
			// tbkk
			$str_kk = "SELECT `Alamat`, `RT`, `RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
			$query_kk = mysqli_query($koneksi,$str_kk);
			$data_kk = mysqli_fetch_assoc($query_kk);
			
			
			// cek umur kelamin
			if ($kelamin == 'L'){
				$umur_l = $data['UmurTahun']." thn";
				$umur_p = "-";
			}else{
				$umur_l = "-";
				$umur_p = $data['UmurTahun']." thn";
			}
			
			if($alamat != null){
				$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];
			}else{
				$alamat = "-";
			}
			
			$str_imun = mysqli_query($koneksi,"SELECT ImunisasiSekarang,TanggalPeriksa from tbpoliimunisasi Where `NoCM` = '$data[NoCM]'");
			while( $dtimun = mysqli_fetch_assoc($str_imun)){
				$dtaimunisasi[$no][] = $dtimun['ImunisasiSekarang'];
				$dtaimunisasi_tgl[$no][] = $dtimun['TanggalPeriksa'];
			}
			
			// echo var_dump(implode(", ",$dtaimunisasi[$no]));
			$dtaimunisasi_tgl_gabung = implode(",",$dtaimunisasi_tgl[$no]);
			$dtimunisasi_gabung = implode(",",$dtaimunisasi[$no]);
			
			$dtimunisasi_tgl = explode(",",$dtaimunisasi_tgl_gabung);
			$dtimunisasi = explode(",",$dtimunisasi_gabung);
			
			echo $dtimunisasi_gabung;
			echo "  ";
			echo $dtaimunisasi_tgl_gabung;
			echo "<br/>";
			?>
				<tr style="border:1px dashed #000;">
					<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $noindex2;?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $umur_l;?></td>
					<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $alamat;?></td>
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php if(in_array('HBO',$dtimunisasi)){echo $dtimunisasi_tgl[array_search('HBO', $dtimunisasi)];}?></td><!--hbo date("dmy",strtotime($data['TanggalPeriksa']))-->
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php if(in_array('BCG',$dtimunisasi)){echo $dtimunisasi_tgl[array_search('BCG', $dtimunisasi)];}?></td><!--bcg-->
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php if(in_array('DPT HB HiB 1',$dtimunisasi)){echo $dtimunisasi_tgl[array_search('DPT HB HiB 1', $dtimunisasi)];}?></td><!--dpthib1-->
					<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php if(in_array('DPT HB HiB 2',$dtimunisasi)){echo $dtimunisasi_tgl[array_search('DPT HB HiB 2', $dtimunisasi)];}?></td><!--dpthib2-->
					<td style="text-align:center; border:1px dashed #000; padding:3px;"></td><!--dpthib3-->
					<td style="text-align:center; border:1px dashed #000; padding:3px;"></td><!--polio1-->
					<td style="text-align:center; border:1px dashed #000; padding:3px;"></td><!--polio2-->
					<td style="text-align:center; border:1px dashed #000; padding:3px;"></td><!--polio3-->
					<td style="text-align:center; border:1px dashed #000; padding:3px;"></td><!--polio4-->
					<td style="text-align:center; border:1px dashed #000; padding:3px;"></td><!--ipv-->
					<td style="text-align:center; border:1px dashed #000; padding:3px;"></td><!--campak-->
					<td style="text-align:center; border:1px dashed #000; padding:3px;"></td><!--bosterdpt-->
					<td style="text-align:center; border:1px dashed #000; padding:3px;"></td><!--bostercampak-->
					<td style="text-align:center; border:1px dashed #000; padding:3px;"></td><!--ket-->
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
<br>
<hr class="noprint"><!--css-->
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
					echo "<li><a href='?page=lap_imunisasi_pemantauan&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
				}
			}
		}
	?>	
</ul>
<?php
}
?>



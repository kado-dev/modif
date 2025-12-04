<?php
	include "otoritas.php";
	include "config/helper_report.php";
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
?>	

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul">RESEP (CARA BAYAR)</h3>
			<div class="formbg">	
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_farmasi_apotik_resep_cara_bayar"/>
						<div class="col-xl-2">
							<select name="bulan" class="form-control">
								<option value="01">Januari</option>
								<option value="02">Februari</option>
								<option value="03">Maret</option>
								<option value="04">April</option>
								<option value="05">Mei</option>
								<option value="06">Juni</option>
								<option value="07">Juli</option>
								<option value="08">Agustus</option>
								<option value="09">September</option>
								<option value="10">Oktober</option>
								<option value="11">November</option>
								<option value="12">Desember</option>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_apotik_resep_cara_bayar" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	if($bulan != null AND $tahun != null){
	?>

	<!--data cara bayar-->
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font11" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border: 0.5px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN RESEP (CARA BAYAR)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
		<br/>
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
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr>
							<th width="3%">NO.</th>
							<th width="12%">CARA BAYAR</th>
							<?php
								$bln = $_GET['bulan'];
								$thn = $_GET['tahun'];
								$mulai = 1;
								$selesai = 31;
								for($d = $mulai;$d <= $selesai; $d++){
							?>
								<th><?php echo $d;?></th>
							<?php
								}
							?>
							<th>JUMLAH</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$query = mysqli_query($koneksi,"SELECT * from tbasuransi order by Asuransi");
						while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$asuransi = $data['Asuransi'];
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="left"><?php echo $data['Asuransi'];?></td>
									<?php
										$jml2 = 0;	
										for($d2= $mulai;$d2 <= $selesai; $d2++){	
										$tanggal = $thn."-".$bln."-".$d2;
										$strs = "SELECT COUNT(NoResep) as jumlah FROM `$tbresep` WHERE date(TanggalResep) = '$tanggal' AND `StatusBayar` = '$asuransi'";
										$jml = mysqli_fetch_assoc(mysqli_query($koneksi,$strs));
										$jml2 = $jml2 + $jml['jumlah'];
										// echo $strs;
									?>	
								<td align="right"><?php echo round($jml['jumlah'],0);?></td>
									<?php
										}
									?>
								<td align="right"><?php echo round($jml2,0);?></td>
							</tr>
						<?php
						}
						?>
							<tr style="font-weight: bold;">
								<td align="center">#</td>
								<td align="center">TOTAL</td>
							<?php
								$jmls = 0;
								for($d3= $mulai;$d3 <= $selesai; $d3++){	
								$tanggal = $thn."-".$bln."-".$d3;
								$strs2 = "select COUNT(NoResep) as jumlah from `$tbresep` where date(TanggalResep) = '$tanggal'";	
								$countall = mysqli_fetch_assoc(mysqli_query($koneksi,$strs2));		
								$jmls = $jmls + $countall['jumlah'];
							?>	
								<td align="right"><?php echo round($countall['jumlah'],0);?></td>
							<?php
								}
							?>	
								<td align="right"><?php echo round($jmls,0);?></td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>
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
	<?php
	}
	?>
</div>	
<?php
	$bulan = date('m');
	$tahun = date('Y');	
	
	// distribusi
	$dt_ttl_pengadaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(GrandTotal) AS Jumlah FROM `tbgfkpenerimaan` WHERE YEAR(TanggalPenerimaan)='$tahun'"));
	$dt_ttl_distribusi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
	FROM tbgfkpengeluarandetail a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur
	WHERE YEAR(b.TanggalPengeluaran) = '$tahun'"));

	function progress_green($x,$tot){
		$persen = ($x * 100) / $tot;
		echo "<div class='progress'><div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='width: ".$persen."%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div></div>";
	}

	function progress_red($x,$tot){
		$persen = ($x * 100) / $tot;
		echo "<div class='progress'><div class='progress-bar progress-bar-striped bg-danger' role='progressbar' style='width: ".$persen."%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div></div>";
	}
?>

<style>	
	.modalku{
		width: 1000px;
		height: 500px;
		position: fixed;
		left: 50%;
		margin-top: 50%;
		transform: translate(-50%, -50%);
	}		
	.kotak_panel{
		padding: 50px 20px;
		border-radius: 6px;
	}
	.reds{
		background: rgb(150,59,61);
		background: linear-gradient(90deg, rgba(150,59,61,1) 0%, rgba(199,79,82,1) 50%, rgba(255,101,104,1) 100%);
	}
	.greens{
		// background: #41A186;
		// background: linear-gradient(90deg, rgba(15,154,134,1) 0%, rgba(35,193,134,1) 32%, rgba(53,233,127,1) 100%);
		background: rgb(55,124,55);
		background: linear-gradient(90deg, rgba(55,124,55,1) 0%, rgba(70,163,70,1) 50%, rgba(0,201,0,1) 100%);
	}
	.kotak_panel i{
		color: #f5f5f5;
		border:7px solid #f2f2f2;
		padding:5px 8px;
		border-radius: 50%;
		margin-top:-15px;
	}
	.font30{
		font-size: 30px;
		position: absolute;
		top:10px;
		left:120px;
		color: #fff;
		font-weight: bold;
		margin-top: 15px;
	}
	.kotak_panel .ket{
		font-size: 14px;color: #f9f9f9;
		position: absolute;
		top:65px;
		left:120px;
	}
	.kotakgrafik{
		background: #f5f5f5;padding: 10px;
	}
	.divscroll{
		background: #f3f3f3;
		height: 300px; 
		margin: 10px 4px;
		box-shadow:0px 0px 12px #9e9e9e;
		overflow: auto;
	}
	.kotak_panel_detail{
		width: 100%;
		background: #fff;		
	}
	.kotak_panel_detail tr td{
		padding: 4px 10px;font-size: 13px;
	}
	.kotak_panel_detail tr:first-child td{
		padding-top: 10px
	}
	.kotak_panel_detail tr:last-child td{
		padding-bottom: 15px
	}
	.kotak_panel_detail tr td:first-child{font-weight: bold;vertical-align: bottom; }
	.kotak_panel_detail tr td:last-child{color: #454545;}
	.kotak_panel_detail tr td p{
		text-align: right;
	}
	.progress{
		margin-bottom: 0px;height: 12px
	}
	.kotakgrafik {
		box-shadow: 0px 0px 8px 0px #d1d1d1;
		padding: 40px;
		padding-right: 35px;
		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;
		border-radius: 10px;
		background: #fff;
		overflow: hidden;
	}	
	.table, tr, th, a {
		color: #606060;
		font-size: 14px;
		font-family: 'Poppins', sans-serif; 
	}
	.kolom_danger{
		background: #fbff3f;
		border-radius: 8px;
		padding: 12px 12px;
		margin-bottom: 10px;
		font-size: 16px;
		-webkit-animation: myanimation 1s infinite;  /* Safari 4+ */
		  -moz-animation: myanimation 1s infinite;  /* Fx 5+ */
		  -o-animation: myanimation 1s infinite;  /* Opera 12+ */
		  animation: myanimation 1s infinite;
	}
	.panel_update{
		padding:38px 20px;text-align: left;font-weight: normal;font-size: 22px;
		margin-bottom: 0px;border-radius: 10px 10px 0px 0px;margin-top: 20px;color: #fff;
		background: linear-gradient(0deg, rgba(49, 89, 253, 0.9), rgba(49, 89, 253, 0.9)), url('image/bg-title-01.jpg');
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
	}
	.update_list{
		border-bottom: 1px solid #eee;
		padding: 22px 30px;background: #fff;
	}
	.update_list:hover{
		background: #f9f9f9;
	}
	.update_list.biru{
		border-left:4px solid #009ac8;
	}
	.update_list.kuning{
		border-left:4px solid #ffe66b;
	}
	.update_list.merah{
		border-left:4px solid #ff6696;
	}
	.update_list.ijo{
		border-left:4px solid #40a05e;
	}
	.update_list p{
		margin-bottom: 0px;font-size: 14px;color:#545454;
	}
	.update_list span{
		font-size: 16px; font-weight: bold;
	}
	
	@-webkit-keyframes myanimation {
	  0%, 49% {
	    background: #fff;
	  }
	  50%, 100% {
	    background: #fbff3f;
	  }
	}
	
	@media only screen and (max-width: 479px){
		.font30{
			font-size: 26px;
			position: absolute;
			top:15px;
			left:110px;
			color: #fff;
			font-weight: bold;
			margin-top: 15px;
		}
		.kotak_panel .ket{
			font-size: 12px;color: #f9f9f9;
			position: absolute;
			top:65px;
			left:110px;
		}
	}	
}
</style>

<?php
	// cek obat ED
	$hariiini = date('Y-m-d');
	$strobated = "SELECT COUNT(KodeBarang) AS Jumlah FROM `tbgfkstok` WHERE`Stok` > '0' AND `Expire` < '$hariiini' AND `NamaProgram` != 'VAKSIN' AND `SumberAnggaran` != 'BLUD' AND `StatusKarantina`='N' order by NamaBarang ASC LIMIT 0,20";
	$dtobated = mysqli_fetch_assoc(mysqli_query($koneksi, $strobated));
	if($dtobated['Jumlah'] != '0'){
?>

<div class="tableborderdiv">
	<div class ="row">
		<div class="col-sm-12">
			<div class="col-sm-12 kolom_danger btndetail_bulan_lalu" style="cursor:pointer;"><i class="fa fa-arrow-down">&nbsp&nbsp</i><?php echo round($dtobated['Jumlah'],0)." Barang sudah Expire, silahkan lakukan karantina."?></div>
			<div class="detail_bulan_lalu" style="display:none;clear:both">
				<div class="formbg" style="padding: 0px 20px 0px 20px;">
					<div class="table-responsive"><br/>
						<form action="?page=gudang_karantina_tambah_proses" method="post">
							<input type="hidden" name="sts" class="form-control" value="1">
							<table class="table-judul" width="100%">
								<thead>
									<tr>
										<th width="3%">NO.</th>
										<th width="5%">KODE</th>
										<th width="20%">NAMA BARANG</th>
										<th width="10%">NAMA PROGRAM</th>
										<th width="20%">BATCH</th>
										<th width="10%">JUMLAH</th>
										<th width="5%">#</th>
									</tr>
								</thead>
								<tbody>
									
										<?php
											$no = 0;
											$str = "SELECT * FROM `tbgfkstok` WHERE `Stok` > '0' AND `Expire` < '$hariiini' AND `NamaProgram` != 'VAKSIN' AND `SumberAnggaran` != 'BLUD' AND `StatusKarantina`='N' ORDER BY NamaBarang ASC";
											$query = mysqli_query($koneksi,$str);
											while($data = mysqli_fetch_assoc($query)){
												$no = $no + 1;
										?>
										<tr>
											<td width="3%" align="center"><?php echo $no;?></td>
											<td width="5%" align="left"><?php echo $data['KodeBarang'];?></td>
											<td width="22%" align="left"><?php echo strtoupper($data['NamaBarang']);?></td>
											<td align="center"><?php echo strtoupper($data['NamaProgram']);?></td>
											<td width="15%" align="center"><?php echo strtoupper($data['NoBatch']);?></td>
											<td align="right"><?php echo rupiah($data['Stok']);?></td>
											<td align="center"><a href="?page=gudang_besar_karantina&kd=<?php echo $data['KodeBarang'];?>&batch=<?php echo $data['NoBatch'];?>&faktur=<?php echo $data['NoFakturTerima'];?>&stsgudang=GUDANG BESAR" class="btn btn-sm btn-success">Karantina</a></td>
										</tr>
										<?php
											}
										?>	
								</tbody>
							</table><hr/>
							<!--<button type="submit" class="btnsimpan">BUAT KARANTINA</button><br/>-->
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
		}
	?>

	<div class="row">
		<div class="col-sm-6">
			<div class="kotak_panel greens">
				<div data-toggle="modal" data-target="#modalpenerimaan">
					<i class="fa fa-arrow-down fa-3x"></i>
					<div class="font30"><?php echo rupiah($dt_ttl_pengadaan['Jumlah']);?></div>
					<div class="ket">Total Penerimaan Tahun <?php echo date('Y');?></div>
				</div>
			</div>
			<div class="divscroll">
				<table class="kotak_panel_detail">
					<?php
					$str_obat = "SELECT a.KodeBarang, a.NamaProgram, SUM(a.Jumlah * a.Harga) AS Jumlah 
					FROM tbgfkpenerimaandetail a JOIN tbgfkpenerimaan b ON a.NomorPembukuan = b.NomorPembukuan
					WHERE YEAR(b.TanggalPenerimaan)= '$tahun'
					GROUP BY a.NamaProgram ORDER BY Jumlah DESC LIMIT 10";	
					$no = 0;
					$query_obat = mysqli_query($koneksi,$str_obat);
					while($data = mysqli_fetch_assoc($query_obat)){
						$no = $no +1;
						$kodebarang = $data['KodeBarang'];
						$namaprogram = $data['NamaProgram'];
						$jumlahbarang = $data['Jumlah'];			
					?>
					<tr>
						<td width="50%"><?php echo $namaprogram;?></td>
						<td>
							<p><?php echo "Rp. ".rupiah($jumlahbarang);?></p>
							<?php progress_green($jumlahbarang,$dt_ttl_pengadaan['Jumlah'])?>
						</td>
					</tr>
					<?php
						}
					?>	
				</table>
			</div>	
		</div>
		
		<div class="col-sm-6">
			<div class="kotak_panel reds">
				<div data-toggle="modal" data-target="#modaldistribusi">
					<i class="fa fa-arrow-up fa-3x"></i>
					<div class="font30">
						<?php echo rupiah($dt_ttl_distribusi['Jumlah']);?>
					</div>
					<div class="ket">Total Distribusi Tahun <?php echo date('Y');?></div>
				</div>
			</div>
			<div class="divscroll">
			<table class="kotak_panel_detail">
				<?php
					$str_obat = "SELECT a.KodeBarang, a.NamaProgram, SUM(a.Jumlah * a.Harga) AS Jumlah 
					FROM tbgfkpengeluarandetail a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur
					WHERE YEAR(b.TanggalPengeluaran)= '$tahun'
					GROUP BY a.NamaProgram ORDER BY Jumlah DESC LIMIT 10";
					// echo $str_obat;
				
					$no = 0;
					$query_obat = mysqli_query($koneksi,$str_obat);
					while($data = mysqli_fetch_assoc($query_obat)){
						$no = $no +1;
						$kodebarang = $data['KodeBarang'];
						$namaprogram = $data['NamaProgram'];
						$jumlahbarang = $data['Jumlah'];			
				?>
				<tr>
					<td width="50%"><?php echo $namaprogram;?></td>
					<td>
						<p><?php echo "Rp. ".rupiah($jumlahbarang);?></p>
						<?php progress_red($jumlahbarang,$dt_ttl_distribusi['Jumlah']);?>
					</td>
				</tr>
				<?php
					}
				?>	
			</table>
			</div>
		</div>
		
		<!--<div class="col-sm-6">
			<div class="kotak_panel reds">
				<div data-toggle="modal" data-target="#modaldistribusi">
					<i class="fa fa-arrow-up fa-3x"></i>
					<div class="font30">
						<?php
							if($kota == "KABUPATEN BANDUNG"){
								echo rupiah($dt_ttl_distribusi_gp['Jumlah']);
							}else{	
								echo rupiah($dt_ttl_distribusi['Jumlah']);
							}
						?>
					</div>
					<div class="ket">Total Distribusi Tahun <?php echo date('Y');?></div>
				</div>
			</div>
			<table class="kotak_panel_detail">
				<?php				
					$no = 0;
					$str_obat = "SELECT Penerima, SUM(GrandTotal) AS Jumlah FROM tbgfkpengeluaran
					WHERE YEAR(TanggalPengeluaran)='$tahun'
					GROUP BY Penerima ORDER BY Jumlah DESC LIMIT 5";			
					$query_obat = mysqli_query($koneksi,$str_obat);
					while($data = mysqli_fetch_assoc($query_obat)){
						$no = $no +1;
						$penerima = $data['Penerima'];
						$jumlahbarang = $data['Jumlah'];			
				?>
				<tr>
					<td width="50%"><?php echo $penerima;?></td>
					<td>
						<p><?php echo "Rp. ".rupiah($jumlahbarang);?></p>
						<?php progress_red($jumlahbarang,$dt_ttl_distribusi['Jumlah']);?>
					</td>
				</tr>
				<?php
					}
				?>	
			</table>
		</div>-->
	</div>

	<div class="row">
		<?php //if($kota == "KABUPATEN BEKASI"){ ?>
			<!--<a href="?page=uptd_gudang_sisa_aset">
				<div class="col-sm-4">
					<div class="kotak_panel">
						<i class="fa fa-newspaper-o fa-3x fa-gradient"></i>
						<div class="font30">
							<?php 
								// $str = "SELECT * FROM `tbgfkstok` WHERE `Stok` > '0' GROUP BY KodeBarang, IdBarang";
								// $str_obat = $str." order by NamaBarang";
								// echo $str_obat;
								
								// $query_obat = mysqli_query($koneksi,$str_obat);
								// while($data = mysqli_fetch_assoc($query_obat)){
									// $no = $no +1;
									// $kodebarang = $data['KodeBarang'];
									// $kodebaranggroup = $data['KodeBarangGroup'];
									// $idbarangs = $data['IdBarang'];
									// $namabarang = $data['NamaBarang'];
									
									// $dt_2016= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Stok`, `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `IdBarang`='$idbarangs' AND SUBSTRING(SumberAnggaran,1,4)='APBD' AND `TahunAnggaran`='2016' AND Stok > '0'"));
									// $dt_2017= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Stok`, `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `IdBarang`='$idbarangs' AND SUBSTRING(SumberAnggaran,1,4)='APBD' AND `TahunAnggaran`='2017' AND Stok > '0'"));
									// $dt_2018= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Stok`, `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `IdBarang`='$idbarangs' AND SUBSTRING(SumberAnggaran,1,4)='APBD' AND `TahunAnggaran`='2018' AND Stok > '0'"));
									// $dt_2019= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Stok`, `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `IdBarang`='$idbarangs' AND SUBSTRING(SumberAnggaran,1,4)='APBD' AND `TahunAnggaran`='2019' AND Stok > '0'"));
									// $jml_akhir = $dt_2016['Stok'] + $dt_2017['Stok'] + $dt_2018['Stok'] + $dt_2019['Stok'];			
									// $saldo_akhir = ($dt_2016['Stok'] * $dt_2016['HargaBeli']) + ($dt_2017['Stok'] * $dt_2017['HargaBeli']) + ($dt_2018['Stok'] * $dt_2018['HargaBeli']) + ($dt_2019['Stok'] * $dt_2019['HargaBeli']);			
									// $total = $total + $saldo_akhir;
								// }	
								// echo number_format("$total",2,",",".");
							?>
						</div>
						<div>Sisa Aset <?php // echo date('Y');?></div>
					</div>
				</div>
			</a>-->
		<?php //} ?>
	</div>

	<!--Modal-->
	<div class="modal fade" id="modaldistribusi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content modalku">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Data Distribusi Tahun <?php echo $tahun?></h4>
				</div>
				<canvas id="Grafik_Distribusi" style="padding: 10px 30px 80px 30px;"></canvas>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modalpenerimaan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content modalku">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Data Penerimaan Tahun <?php echo $tahun?></h4>
				</div>
				<canvas id="Grafik_Penerimaan" style="padding: 10px 30px 80px 30px;"></canvas>
			</div>
		</div>
	</div>

	<!--GrafikDistribusi PerPuskesmas-->
	<div class="kotakgrafik m-b-30">
		<div class="au-card-inner"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
			<h3 class="title-2 m-b-40">Distribusi (Penerima)</h3>
			<div class="col-lg-12 col-md-12">
				<canvas id="Grafik_Distribusi_PerPuskesmas" height="400px"></canvas>
			</div>
		</div>
	</div>
	<div class="hasilmodal"></div>

	<!--Tabel Pemakaian Obat-->
	<div class="detailgrafik_distribusi" style="display:none;clear:both">
		<div class="table-responsive">
			<table class="table-judul" width="100%">
				<thead>
					<tr>
						<th width='5%'>No.</td>
						<th width='10%'>Kode</td>
						<th width='63%'>Penerima</td>
						<th width='15%'>Grand Total (Rp.)</td>
						<th width='7%'>Aksi</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 0;
					$str_obat = "SELECT KodePenerima, Penerima, SUM(GrandTotal)As Jumlah 
						FROM `tbgfkpengeluaran` WHERE YEAR(TanggalPengeluaran)='$tahun' AND `Penerima`!='GUDANG PELAYANAN' GROUP BY Penerima 
						ORDER BY Jumlah DESC limit 0,10";
					// echo $str_obat;
					
					$query_obat = mysqli_query($koneksi,$str_obat);
					while($data = mysqli_fetch_assoc($query_obat)){
						$no = $no +1;
						$kdpenerima = $data['KodePenerima'];
						$penerima = $data['Penerima'];
						$jumlahs = $data['Jumlah'];
						?>
						<tr>
							<td style="text-align:center;"><?php echo $no;?></td>
							<td style="text-align:center;" class="kdpenerima"><?php echo $kdpenerima;?></td>
							<td style="text-align:left;"><?php echo $penerima;?></td>
							<td style="text-align:right;"><?php echo rupiah($jumlahs);?></td>
							<td style="text-align:center;">
								<button href="#" class="btnmodalobatdistribusi" class="btn btn-white">Lihat</button>
							</td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>	

	<!--Grafik Pemakaian Obat-->
	<div class="kotakgrafik m-b-30">
		<div class="au-card-inner"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
			<h3 class="title-2 m-b-40">Distribusi (Barang)</h3>
			<div class="col-lg-12 col-md-12">
				<canvas id="Grafik_Obat" height="400px"></canvas>
			</div>
			<button type="button" class="btndetailgrafik btn btn-white" style="text-decoration:none; margin:10px -20px 0px; float:right; cursor:pointer">Detail Pemakaian Obat</button>
		</div>
	</div><br/>

	<!--Tabel Pemakaian Obat-->
	<div class="detailgrafik" style="display:none;clear:both">
		<div class="table-responsive">
			<table class="table-judul" width="100%">
				<thead>
					<tr>
						<th width='5%'>No.</td>
						<th width='8%'>Kode</td>
						<th>Nama Obat</td>
						<th width='12%'>Satuan</td>
						<th width='12%'>Jumlah</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 0;
					if($kota == "KABUPATEN BOGOR"){
						$str_obat = "SELECT KodeBarang, SUM(Jumlah)As Jumlah 
						FROM `tbgfkpengeluarandetail` WHERE SUBSTRING(NoFaktur,7,2)='$bulan' AND SUBSTRING(NoFaktur,10,4)='$tahun' GROUP BY KodeBarang 
						ORDER BY Jumlah DESC LIMIT 0,10";
					}else{
						$str_obat = "SELECT b.KodeBarang, SUM(b.Jumlah)As Jumlah FROM tbgfkpengeluaran a
						JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
						WHERE MONTH(a.TanggalPengeluaran)='$bulan' AND YEAR(a.TanggalPengeluaran)='$tahun' 
						GROUP BY b.KodeBarang ORDER BY Jumlah DESC LIMIT 0,10";
					}				
					$query_obat = mysqli_query($koneksi,$str_obat);
					while($data = mysqli_fetch_assoc($query_obat)){
						$no = $no +1;
						$kodebarang = $data['KodeBarang'];
						$tbgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfkstok` WHERE KodeBarang = '$kodebarang'"));
						?>
						<tr>
							<td style="text-align:center;"><?php echo $no;?></td>
							<td style="text-align:center;"><?php echo $data['KodeBarang'];?></td>
							<td style="text-align:left;"><?php echo $tbgfkstok['NamaBarang'];?></td>
							<td style="text-align:center;"><?php echo $tbgfkstok['Satuan'];?></td>
							<td style="text-align:right;"><?php echo rupiah($data['Jumlah']);?></td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>

	<div class ="row">
		<div class="col-sm-12">
			<h4 class="panel_update"><i class="fa fa-calendar"></i> Update & Maintenance Aplikasi</h4>
			<?php
				$no = 0;
				$warna = array('merah','biru','kuning','ijo');
				$strberita = "SELECT * FROM `tbupdatesimpus`";
				$strberita2 = $strberita." order by `TanggalUpdate` DESC LIMIT 3";
				
				$queryberita = mysqli_query($koneksi,$strberita2);
				while($databerita = mysqli_fetch_assoc($queryberita)){
			?>
				<div class="update_list <?php echo $warna[$no];?>">
					<span style=""><?php echo strtoupper($databerita['Judul']).", V.".$databerita['Versi'];?></span>
					<p><?php echo "(".strtoupper($databerita['Kategori'].") ".date("d-m-Y", strtotime($databerita['TanggalUpdate'])));?></p>
					<p><?php echo str_replace('-','<br/> - ',$databerita['Deskripsi']);?></p>					
				</div>
			<?php
				$no = $no + 1;
				if($no == 4){
					$no = 0;
				}
			}
			?>
			<div class="update_list">
				<a href="?page=adm_update_simpus" class="btndefault" style="width:200px; margin:0 auto;">Detail</a>
			</div>
		</div>
	</div>
</div>	
		
<!--grafik 3D-->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<!--end grafik 3D-->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/chartjsorg.js"></script>

<script>
$(".btndetail_bulan_lalu").click(function(){
	if ( $( ".detail_bulan_lalu" ).is( ":hidden" ) ) {
		$(".detail_bulan_lalu").slideDown();
	}else{
		$(".detail_bulan_lalu").slideUp();
	}
});

$(".btndetailgrafik").click(function(){
	if ( $( ".detailgrafik" ).is( ":hidden" ) ) {
		$(".detailgrafik").slideDown();
	}else{
		$(".detailgrafik").slideUp();
	}
});

$(".btndetailgrafik_distribusi").click(function(){
	if ( $( ".detailgrafik_distribusi" ).is( ":hidden" ) ) {
		$(".detailgrafik_distribusi").slideDown();
	}else{
		$(".detailgrafik_distribusi").slideUp();
	}
});

var ctx = document.getElementById("Grafik_Obat").getContext('2d');
var Grafik_Obat = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: [
				<?php
					$str_obat = "SELECT b.KodeBarang, SUM(b.Jumlah)As Jumlah FROM tbgfkpengeluaran a
					JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
					WHERE MONTH(a.TanggalPengeluaran)='$bulan' AND YEAR(a.TanggalPengeluaran)='$tahun' 
					GROUP BY b.KodeBarang ORDER BY Jumlah DESC LIMIT 0,10";
					
					$query_obat= mysqli_query($koneksi, $str_obat) or die(mysqli_error());
					while($ambil = mysqli_fetch_array($query_obat)){
						$kodebarang = $ambil['KodeBarang'];
						
						// tbgfkstok
						$str_barang = "SELECT * FROM `tbgfkstok` WHERE `KodeBarang` = '$kodebarang'";
						$query_barang = mysqli_query($koneksi, $str_barang);
						$dt_barang = mysqli_fetch_assoc($query_barang);
						echo '"'.$dt_barang['KodeBarang'].'", ';
					}
				?>
				],
		datasets: [{
			label: 'Pemakaian Obat Terbanyak Bulan <?php echo nama_bulan(date('m'));?>',
			data:[
				<?php
					$query_obat= mysqli_query($koneksi, $str_obat) or die(mysqli_error());
					while($ambil = mysqli_fetch_array($query_obat)){
						$kodebarang = $ambil['KodeBarang'];
						$str_barang = "SELECT * FROM `tbgfkstok` WHERE `KodeBarang` = '$kodebarang'";
						$query_barang = mysqli_query($koneksi, $str_barang);
						$dt_barang = mysqli_fetch_assoc($query_barang);
						echo '"'.$ambil['Jumlah'].'", ';
					}			
				?>
				],
				backgroundColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query_obat); $i++){
				?>
					'rgba(175, 238, 247, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i =0; $i < mysqli_num_rows($query_obat); $i++){
			?>
				'rgba(114, 211, 224, 1)',
			<?php
			}
			?>
			],
			borderWidth: 2
		}]
	},
	options: {
		responsive: true,
		maintainAspectRatio: false,
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true
				}
			}]
		}
	}
});

var ctx = document.getElementById("Grafik_Distribusi_PerPuskesmas").getContext('2d');
var Grafik_Distribusi_PerPuskesmas = new Chart(ctx, {
	type: 'line',
	data: {
		labels: [
				<?php
					$str_ds = "SELECT KodePenerima, Penerima, SUM(GrandTotal)As GrandTtl 
								FROM `tbgfkpengeluaran`
								WHERE YEAR(TanggalPengeluaran)='2019' AND Penerima != 'GUDANG PELAYANAN'
								GROUP BY Penerima 
								ORDER BY GrandTtl DESC LIMIT 7";
					$query_ds= mysqli_query($koneksi, $str_ds) or die(mysqli_error());
					while($ambil = mysqli_fetch_array($query_ds)){
						echo '"'.$ambil['Penerima'].'", ';
					}
				?>
				],
		datasets: [{
			label: 'Distribusi Terbanyak Tahun <?php echo date('Y');?> (Internal Puskesmas & Unit Eksternal)',
			data:[
				<?php
					$query_ds= mysqli_query($koneksi, $str_ds) or die(mysqli_error());
					while($ambil = mysqli_fetch_array($query_ds)){
						echo '"'.$ambil['GrandTtl'].'", ';
					}			
				?>
				],
				backgroundColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query_ds); $i++){
				?>
					'rgba(211, 255, 222, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i =0; $i < mysqli_num_rows($query_ds); $i++){
			?>
				'rgba(98, 201, 124, 1)',
			<?php
			}
			?>
			],
			borderWidth: 2.5
		}]
	},
	options: {
		responsive: true,
		maintainAspectRatio: false,
		tooltips: {
           mode: 'label',
           label: 'mylabel',
           callbacks: {
               label: function(tooltipItem, data) {
                   return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
        },
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true
				}
			}]
		}
	}
});

var ctx = document.getElementById("Grafik_Distribusi").getContext('2d');
var Grafik_Distribusi = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: [
				<?php
					$array_bln = array(
						"Jan"=>"01",
						"Feb"=>"02",
						"Mar"=>"03",
						"Apr"=>"04",
						"Mei"=>"05",
						"Jun"=>"06",
						"Jul"=>"07",
						"Ags"=>"08",
						"Sep"=>"09",
						"Okt"=>"10",
						"Nov"=>"11",
						"Des"=>"12"
						);
					foreach($array_bln as $key => $val){
						echo '"'.$key.'", ';
					}
				?>
				],
		datasets: [{
			label: 'Jumlah Distribusi Tahun <?php echo date('Y');?>',
			data:[
				<?php
					$array_bln = array(
						"Jan"=>"01",
						"Feb"=>"02",
						"Mar"=>"03",
						"Apr"=>"04",
						"Mei"=>"05",
						"Jun"=>"06",
						"Jul"=>"07",
						"Ags"=>"08",
						"Sep"=>"09",
						"Okt"=>"10",
						"Nov"=>"11",
						"Des"=>"12"
						);
					foreach($array_bln as $key => $val){
						$query_distribusi = mysqli_query($koneksi,"SELECT SUM(GrandTotal) AS JumlahDistribusi FROM `tbgfkpengeluaran` WHERE MONTH(`TanggalPengeluaran`) = '$val' AND YEAR(TanggalPengeluaran)='$tahun'");
						$jml = mysqli_fetch_assoc($query_distribusi);
						echo '"'.$jml['JumlahDistribusi'].'", ';
					}		
				?>
				],
				backgroundColor: [
				<?php
				for($i =0; $i <= $val; $i++){
				?>
					'rgba(175, 238, 247, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i =0; $i <= $val; $i++){
			?>
				'rgba(114, 211, 224, 1)',
			<?php
			}
			?>
			],
			borderWidth: 1
		}]
	},
	options: {
		responsive: true,
		maintainAspectRatio: false,
		tooltips: {
           mode: 'label',
           label: 'mylabel',
           callbacks: {
               label: function(tooltipItem, data) {
                   return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
        },
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true
				}
			}]
		}
	}
});

var ctx = document.getElementById("Grafik_Penerimaan").getContext('2d');
var Grafik_Penerimaan = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: [
				<?php
					$array_bln = array(
						"Jan"=>"01",
						"Feb"=>"02",
						"Mar"=>"03",
						"Apr"=>"04",
						"Mei"=>"05",
						"Jun"=>"06",
						"Jul"=>"07",
						"Ags"=>"08",
						"Sep"=>"09",
						"Okt"=>"10",
						"Nov"=>"11",
						"Des"=>"12"
						);
					foreach($array_bln as $key => $val){
						echo '"'.$key.'", ';
					}
				?>
				],
		datasets: [{
			label: 'Jumlah Penerimaan Tahun <?php echo date('Y');?>',
			data:[
				<?php
					$array_bln = array(
						"Jan"=>"01",
						"Feb"=>"02",
						"Mar"=>"03",
						"Apr"=>"04",
						"Mei"=>"05",
						"Jun"=>"06",
						"Jul"=>"07",
						"Ags"=>"08",
						"Sep"=>"09",
						"Okt"=>"10",
						"Nov"=>"11",
						"Des"=>"12"
						);
					foreach($array_bln as $key => $val){
						$query_penerimaan = mysqli_query($koneksi,"SELECT SUM(GrandTotal) AS JumlahTerima FROM `tbgfkpenerimaan` WHERE MONTH(`TanggalPenerimaan`) = '$val' AND YEAR(TanggalPenerimaan)='$tahun'");
						$jml = mysqli_fetch_assoc($query_penerimaan);
						echo '"'.$jml['JumlahTerima'].'", ';
					}		
				?>
				],
				backgroundColor: [
				<?php
				for($i =0; $i <= $val; $i++){
				?>
					'rgba(175, 238, 247, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i =0; $i <= $val; $i++){
			?>
				'rgba(114, 211, 224, 1)',
			<?php
			}
			?>
			],
			borderWidth: 1
		}]
	},
	options: {
		responsive: true,
		maintainAspectRatio: false,
		tooltips: {
           mode: 'label',
           label: 'mylabel',
           callbacks: {
               label: function(tooltipItem, data) {
                   return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
        },
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true
				}
			}]
		}
	}
});
</script>
<?php
	include "config/helper_pasienrj.php";
	$bulan = date('m');	
	$tahun = date('Y');	
	$hariini = date('Y-m-d');
	$hariini2 = date('ymd');
	$hariini3 = date('ym');
	$tbtindakanpasien = "tbtindakanpasien_".str_replace(' ', '', $namapuskesmas);
	
	if($_GET['bulan'] == null){
		$bln = date('m');
	}else{
		$bln = $_GET['bulan'];
	}	

	// karcis, sengaja tidak disum karena sewaktu waktu ada duplikasi nama pasien
	$strkarcis = "SELECT TarifKarcis FROM `$tbpasienrj` WHERE DATE(`TanggalRegistrasi`)=curdate() AND `Asuransi`='UMUM' GROUP BY NamaPasien";
	$qkarcis = mysqli_query($koneksi, $strkarcis);
	while($dt_karcis = mysqli_fetch_assoc($qkarcis)){
		$jmlkarcis_hr = $jmlkarcis_hr + $dt_karcis['TarifKarcis'];
	}		
	
	$jmlkarcis_bl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(TarifKarcis) AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND `Asuransi`='UMUM'"));
	$jmlkarcis_th = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(TarifKarcis) AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND `Asuransi`='UMUM'"));
	$tarif_hr = $jmlkarcis_hr;
	$tarif_bl = $jmlkarcis_bl['Jml'];
	$tarif_th = $jmlkarcis_th['Jml'];
	
	// kir
	$jmlkir_hr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(TarifKir) AS Jml FROM `$tbpasienrj` WHERE DATE(`TanggalRegistrasi`)=curdate() AND `Kir`<>''"));
	$jmlkir_bl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(TarifKir) AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND `Kir`<>''"));
	$jmlkir_th = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(TarifKir) AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND `Kir`<>''"));
	$tarif_kir_hr = $jmlkir_hr['Jml'];
	$tarif_kir_bl = $jmlkir_bl['Jml'];
	$tarif_kir_th = $jmlkir_th['Jml'];
			
	// tindakan
	$jmltindakan_hr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Tarif) AS Jml FROM `$tbtindakanpasien` WHERE DATE(TanggalTindakan)='$hariini'"));
	$jmltindakan_bl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Tarif) AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan)='$tahun' AND MONTH(TanggalTindakan)='$bulan'"));
	$jmltindakan_th = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Tarif) AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan)='$tahun'"));
	$tarif_tindakan_hr = $jmltindakan_hr['Jml'];
	$tarif_tindakan_bl = $jmltindakan_bl['Jml'];
	$tarif_tindakan_th = $jmltindakan_th['Jml'];
	
	// jumlah retribusi tahun
	$ttl_retribusi_thn = $tarif_th + $tarif_kir_th + $tarif_tindakan_th;
?>

<style>
	.kotak_panels{
		padding: 25px 20px;
		border-radius: 6px;
		margin-top: 15px;
		margin-bottom: 15px;
	}
	.bg{
		background: linear-gradient(0deg, rgba(178, 212, 255, 0.7), rgba(255, 255, 255, 0.9));
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
		box-shadow: 0 5px 10px -5px #848484;
	}
	.greens{
		background: linear-gradient(0deg, rgba(28, 126, 255, 0.9), rgba(0, 87, 201, 0.9));
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
		box-shadow: 0 5px 10px -5px #848484;
	}
	.fontpanel{
		font-size: 30px;
		color: #fff;
		font-weight: bold;
	}
	.fontpanel-min{
		font-size: 16px;
		color: #fff;
	}
</style>

<div class="tableborderdiv">
	<!--grafik kasir-->
	<div class="row noprint" style="margin-top: -20px;">
		<div class="col-sm-12">
			<div class="kotak_panels bg">
				<div class="row noprint">
					<div class="col-sm-3">
						<a href="#" style="cursor:pointer; text-decoration: none;" class="btndetail_karcis">
							<div class="kotak_panel greens">
								<div class="fontpanel"><?php echo rupiah($tarif_hr);?></div>
								<div class="fontpanel-min">Retribusi Karcis Hari Ini</div>
							</div>
						</a>
					</div>
					<div class="col-sm-3">
						<a href="#" style="cursor:pointer; text-decoration: none;" class="btndetail_kir">
							<div class="kotak_panel greens">				
								<div class="fontpanel"><?php echo rupiah($tarif_kir_hr);?></div>
								<div class="fontpanel-min">Retribusi KIR Hari Ini</div>
							</div>
						</a>
					</div>
					<div class="col-sm-3">
						<a href="#" style="cursor:pointer; text-decoration: none;" class="btndetail_tindakan">
							<div class="kotak_panel greens">	
								<div class="fontpanel"><?php echo rupiah($jmltindakan_hr['Jml']);?></div>
								<div class="fontpanel-min">Retribusi Tindakan Hari Ini</div>
							</div>	
						</a>	
					</div>
					<div class="col-sm-3">
						<div class="kotak_panel greens">	
							<div class="fontpanel"><?php echo rupiah($tarif_hr + $tarif_kir_hr + $tarif_tindakan_hr);?></div>
							<div class="fontpanel-min">Total Retribusi Hari Ini</div>
						</div>	
					</div>
				</div><br/>
				
				<!--tabel karcis-->
				<div class="detailretribusi_karcis col-lg-12" style="<?php if($_GET['tglreg1'] == null){echo 'display:none;';}?>clear:both">
					<div class="formbg">
						<form role="form noprint">
							<div class = "row">
								<input name="page" type="hidden" value="dashboard_puskesmas_kasir">
								<div class="col-xl-6">
									<?php
										if($_GET['tglreg1'] != ''){
											$gettgl = $_GET['tglreg1'];
										}else{
											$gettgl =  date('Y-m-d');
										}
									?>
									<input name="tglreg1" type="date" class="form-control" value="<?php echo $gettgl;?>">
								</div>
								<div class="col-xl-6">
									<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
									<a href="javascript:print()" class="btn btn-round btn-info"><span class="fa fa-print"></a>
									<a href="dashboard_puskesmas_kasir_excel.php?&tgl=<?php echo $_GET['tglreg1'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
								</div>
							</div>
						</form>		
					</div>
					<div class="row">
						<div class="table-responsive">
							<div class="printheader">
								<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
								<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
								<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
								<hr style="margin:3px; border:1px solid #000">
								<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN RETRIBUSI KARCIS HARIAN</b></span><br>
								<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d')." ".nama_bulan(date('m'))." ".date('Y');?> <?php echo $_GET['tahun'];?></span>
								<br/>
							</div>
							<table class="table-judul" width="100%">
								<thead>
									<tr>
										<th width="5%">NO.</th>
										<th width="30%">NAMA PASIEN</th>
										<th width="10%">PELAYANAN</th>
										<th width="10%">CARA BAYAR</th>
										<th width="10%">TARIF</th>
										<th width="25%">OPERATOR</th>
										<th width="5%">#</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$jumlah_perpage = 50;
									$tglreg1 = $_GET['tglreg1'];
									if($_GET['h']==''){
										$mulai=0;
									}else{
										$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
									}
									
									if($_GET['tglreg1']==''){
										$caritanggal = " AND date(TanggalRegistrasi) = curdate()"; 
									}else{
										$caritanggal = " AND date(TanggalRegistrasi)= '$_GET[tglreg1]'";
									}	
									
									$s_karcis = "SELECT `NoRegistrasi`,`NamaPasien`,`PoliPertama`,`Asuransi`,`TarifKarcis`,`StatusBayar`,`NamaPegawaiSimpan` FROM `$tbpasienrj`
									WHERE `Asuransi` = 'UMUM'".$caritanggal;
									$str2 = $s_karcis."GROUP BY NamaPasien ORDER BY `NamaPasien` LIMIT $mulai,$jumlah_perpage";
															
									if($_GET['h'] == null || $_GET['h'] == 1){
										$no = 0;
									}else{
										$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
									}
									
									$query = mysqli_query($koneksi,$str2);
									while($dt_karcis = mysqli_fetch_assoc($query)){
										$no = $no + 1;
										$noregistrasi = $dt_karcis['NoRegistrasi'];
										$namapasien = $dt_karcis['NamaPasien'];
										$polipertama = $dt_karcis['PoliPertama'];
										$asuransi = $dt_karcis['Asuransi'];
										$operator = $dt_karcis['NamaPegawaiSimpan'];
										$tarifkarcis = $dt_karcis['TarifKarcis'];
										$status = $dt_karcis['StatusBayar'];
										
										// tbpelayanankesehatan
										// $dttarif = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Tarif` FROM `tbpelayanankesehatan` WHERE `Pelayanan`='$polipertama'"));
										// $tarif = $dttarif['Tarif'];
									?>	
									<tr>
										<td align="center"><?php echo $no;?></td>
										<td align="left"><?php echo $namapasien;?></td>
										<td align="left"><?php echo str_replace('POLI','',$polipertama);?></td>
										<td align="left"><?php echo $asuransi;?></td>
										<td align="center"><?php echo rupiah($tarifkarcis);?></td>
										<td align="left"><?php echo $operator;?></td>
										<td align="center">
											<?php if($status == "N"){ ?>
											<button class="btn btn-round btn-info btnaksi" data-noreg="<?php echo $noregistrasi;?>" data-pkm="<?php echo $namapuskesmas;?>"  data-sts="dskasir">LIHAT</button>
											<?php }else{ ?>
											<a href="get_tindakan_pasien_print.php?noreg=<?php echo $noregistrasi;?>&sts=dskasir" class="btn btn-round btn-success">e-KWITANSI</a>
											<?php } ?>
										</td>
									</tr>
									<?php
									}						
									?>
								</tbody>
							</table>
						</div>
						<ul class="pagination noprint"><hr/>
							<?php
								$query2 = mysqli_query($koneksi,$s_karcis);
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
											echo "<li><a href='?page=dashboard_puskesmas_kasir&tglreg1=$tglreg1&h=$i'>$i</a></li>";
										}
									}
								}
							?>	
						</ul>
					</div><br/>	
				</div>
				
				<!--menghitung kir-->
				<div class="detailretribusi_kir col-lg-12" style="<?php if($_GET['tglreg'] == null){echo 'display:none;';}?>clear:both">
					<div class="row"><br/>
						<div class="table-responsive">
							<form class="form-inline pull-right" style="margin-bottom:10px">
								<input name="page" type="hidden" value="dashboard_puskesmas_kasir">
								<input name="tglreg" type="date" class="form-control" value="<?php echo $_GET['tglreg'];?>">
								<input type="submit" class="btn btn-round btn-info ml-2" value="Cari"/>
							</form>
							<table class="table-judul" width="100%">
								<thead>
									<tr>
										<th width='5%'>NO.</td>
										<th width='30%'>NAMA PASIEN</td>
										<th width='10%'>PELAYANAN</td>
										<th width='10%'>JENIS KIR</td>
										<th width='10%'>TARIF</td>
										<th width='30%'>OPERATOR</td>
									</tr>
								</thead>
								<tbody>
									<?php 
									$no = 0;
									
									if($_GET['tglreg']==''){
										$caritanggal = " AND date(TanggalRegistrasi) = curdate()"; 
									}else{
										$caritanggal = " AND date(TanggalRegistrasi) = '$_GET[tglreg]'";
									}	
				
									$s_karcis = "SELECT `NamaPasien`,`PoliPertama`, Kir, TarifKir, NamaPegawaiSimpan FROM `$tbpasienrj`
									WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Asuransi` = 'KIR'".$caritanggal;
									// echo $s_karcis;
									// die();
									
									$q_karcis = mysqli_query($koneksi, $s_karcis);
									while($dt_karcis = mysqli_fetch_assoc($q_karcis)){
										$no = $no + 1;
										$namapasien = $dt_karcis['NamaPasien'];
										$polipertama = $dt_karcis['PoliPertama'];
										$jeniskir = $dt_karcis['Kir'];
										$tarif = $dt_karcis['TarifKir'];
										$operator = $dt_karcis['NamaPegawaiSimpan'];
									?>	
									<tr>
										<td style="text-align:center;"><?php echo $no;?></td>
										<td><?php echo $namapasien;?></td>
										<td><?php echo str_replace('POLI','',$polipertama);?></td>
										<td><?php echo $jeniskir;?></td>
										<td align="center"><?php echo rupiah($tarif);?></td>
										<td align="left"><?php echo $operator;?></td>
									</tr>
									<?php
									}						
									?>
								</tbody>
							</table>
						</div>
					</div><br/>
				</div>
					
				<!--menghitung tindakan-->
				<div class="detailretribusi_tindakan col-lg-12" style="<?php if($_GET['tglreg3'] == null){echo 'display:none;';}?>clear:both">
					<div class="row"><br/>
						<div class="table-responsive">
							<form class="form-inline pull-right" style="margin-bottom:10px">
								<input name="page" type="hidden" value="dashboard_puskesmas_kasir">
								<input name="tglreg3" type="date" class="form-control" value="<?php echo $_GET['tglreg3'];?>">
								<input type="submit" class="btn btn-sm" value="Cari"/>
							</form>
							<table class="table-judul" width="100%">
								<thead>
									<tr>
										<th width='5%'>NO.</td>
										<th width='20%'>NAMA PASIEN</td>
										<th width='10%'>PELAYANAN</td>
										<th width='20%'>JENIS TINDAKAN</td>
										<th width='10%'>CARA BAYAR</td>
										<th width='10%'>TARIF</td>
										<th width='5%'>STS.BAYAR</td>
										<th width='20%'>OPERATOR</td>
										<th width='10%'>#</td>
									</tr>
								</thead>
								<tbody>
									<?php 
									$no = 0;
									
									if($_GET['tglreg3']==''){
										$caritanggal = " WHERE date(`TanggalTindakan`) = curdate()"; 
									}else{
										$caritanggal = " WHERE date(`TanggalTindakan`) = '$_GET[tglreg3]'";
									}	
									
									$s_tindakan = "SELECT * FROM `$tbtindakanpasien` ".$caritanggal."  GROUP BY `NoRegistrasi`,`IdTindakan`,`PoliAsal`,`NamaPegawaiSimpan`";
									$q_tindakan = mysqli_query($koneksi, $s_tindakan);
									while($dt_tindakan = mysqli_fetch_assoc($q_tindakan)){
										$no = $no + 1;
										$namapasien = $dt_tindakan['NamaPasien'];
										$pelayanan = $dt_tindakan['PoliAsal'];
										$carabayar = $dt_tindakan['CaraBayar'];
										$idtindakan = $dt_tindakan['IdTindakan'];
										$tarif = $dt_tindakan['Tarif'];
										$status = $dt_tindakan['StatusBayar'];
										$operator = $dt_tindakan['NamaPegawaiSimpan'];
										
										// tbtindakan
										$dt_tdk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Tindakan` FROM `tbtindakan` WHERE `IdTindakan`='$idtindakan'"));
										$jenistindakan = $dt_tdk['Tindakan'];
									?>	
									<tr>
										<td align="center"><?php echo $no;?></td>
										<td align="left"><?php echo $namapasien;?></td>
										<td align="left"><?php echo str_replace('POLI','',$pelayanan);?></td>
										<td align="left"><?php echo strtoupper($jenistindakan);?></td>
										<td align="left"><?php echo $carabayar;?></td>
										<td align="center"><?php echo rupiah($tarif);?></td>
										<td align="center"><?php echo $status;?></td>
										<td align="left"><?php echo $operator;?></td>
										<td align="center">
											<?php if($status == "BELUM"){ ?>
											<a onClick="return confirm('Data ingin diproses...?')" href="?page=kasir_bayar&noreg=<?php echo $dt_tindakan['NoRegistrasi'];?>&tgl=<?php echo date('Y-m-d', strtotime($dt_tindakan['TanggalTindakan']));?>" class="btn btn-xs btn-info">BAYAR</a>
											<?php }else{ ?>
											<a href="etiket_tindakan.php?noreg=<?php echo $dt_tindakan['NoRegistrasi'];?>&tgl=<?php echo date('Y-m-d', strtotime($dt_tindakan['TanggalTindakan']));?>" class="btn btn-xs btn-success">e-KWITANSI</a>
											<?php } ?>
										</td>
									</tr>
									<?php
									}						
									?>
								</tbody>
							</table>
						</div>
					</div><br/>
				</div>
				<br/>
				<form class="form-inline formcari">
					<input type="hidden" name="page" value="dashboard_puskesmas_kasir"/>
					<select name="bulan" class="form-control" onchange="this.form.submit();" >
						<option value="01" <?php if($bln == '01'){echo "SELECTED";}?>>Januari</option>
						<option value="02" <?php if($bln == '02'){echo "SELECTED";}?>>Februari</option>
						<option value="03" <?php if($bln == '03'){echo "SELECTED";}?>>Maret</option>
						<option value="04" <?php if($bln == '04'){echo "SELECTED";}?>>April</option>
						<option value="05" <?php if($bln == '05'){echo "SELECTED";}?>>Mei</option>
						<option value="06" <?php if($bln == '06'){echo "SELECTED";}?>>Juni</option>
						<option value="07" <?php if($bln == '07'){echo "SELECTED";}?>>Juli</option>
						<option value="08" <?php if($bln == '08'){echo "SELECTED";}?>>Agustus</option>
						<option value="09" <?php if($bln == '09'){echo "SELECTED";}?>>September</option>
						<option value="10" <?php if($bln == '10'){echo "SELECTED";}?>>Oktober</option>
						<option value="11" <?php if($bln == '11'){echo "SELECTED";}?>>November</option>
						<option value="12" <?php if($bln == '12'){echo "SELECTED";}?>>Desember</option>
					</select>
				</form>
				<div class="au-card m-b-30">
					<div class="au-card-inner">
						<canvas id="Grafik_Retribusi" height="270px"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--grafik bulan-->
	<div class="row noprint" style="margin-top: -20px;">
		<div class="col-sm-12">
			<div class="kotak_panels bg">
				<div class="row noprint">
					<div class="col-sm-6">
						<div class="kotak_panel greens">
							<div class="fontpanel"><?php echo rupiah($tarif_bl + $tarif_kir_bl + $tarif_tindakan_bl);?></div>
							<div class="fontpanel-min">Total Retribusi Bulan <?php echo nama_bulan(date('m'));?></div>
						</div>	
					</div>
					<div class="col-sm-6">
						<div class="kotak_panel greens">	
							<div class="fontpanel"><?php echo rupiah($ttl_retribusi_thn);?></div>
							<div class="fontpanel-min">Total Retribusi Tahun <?php echo date('Y');?></div>
						</div>
					</div>
				</div><br/>
					
				<div class="au-card m-b-30">
					<div class="au-card-inner">
						<canvas id="Grafik_Bulan" height="270px"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--modal tindakan detail-->
<div class="modal" id="modalkarcis" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Tindakan</h5>
      </div>
      <div class="detailtindakan"></div>
    </div>
  </div>
</div>

<!--end grafik 3D-->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/chartjsorg.js"></script>
<script>

$(".btndetail_karcis").click(function(){
	$( ".detailretribusi_kir" ).hide();
	$( ".detailretribusi_tindakan" ).hide();
	if ( $( ".detailretribusi_karcis" ).is( ":hidden" ) ) {
		$(".detailretribusi_karcis").slideDown();
	}else{
		$(".detailretribusi_karcis").slideUp();
	}
});

$(".btndetail_kir").click(function(){
	$( ".detailretribusi_karcis" ).hide();
	$( ".detailretribusi_tindakan" ).hide();
	if ( $( ".detailretribusi_kir" ).is( ":hidden" ) ) {
		$(".detailretribusi_kir").slideDown();
	}else{
		$(".detailretribusi_kir").slideUp();
	}
});

$(".btndetail_tindakan").click(function(){
	$( ".detailretribusi_karcis" ).hide();
	$( ".detailretribusi_kir" ).hide();
	if ( $( ".detailretribusi_tindakan" ).is( ":hidden" ) ) {
		$(".detailretribusi_tindakan").slideDown();
	}else{
		$(".detailretribusi_tindakan").slideUp();
	}
});

var ctx = document.getElementById("Grafik_Retribusi").getContext('2d');
var Grafik_Retribusi = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: [
				<?php
				$hari_ini = date('Y')."-".$bln."-01";
					$mulai = 1;
					$selesai = date('t', strtotime($hari_ini));
					for($d = $mulai; $d <= $selesai; $d++){	
						echo '"'.$d.'", ';
					}
				?>
				],
		datasets: [{
			label: 'Jumlah Retribusi Harian',
			data:[
				<?php
					$jml = 0;		
									
					for($d = $mulai; $d <= $selesai; $d++){	
						$tanggal = $tahun."-".$bln."-".$d;
						$query_retribusi = mysqli_query($koneksi,"SELECT SUM(`TotalTarif`) AS JumlahTarif FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tanggal'");
						$jml = mysqli_fetch_assoc($query_retribusi);
						if ($jml['JumlahTarif'] == 0){
							$jml_retribusi =  $jml['JumlahTarif'];
						}else{
							$jml_retribusi =  $jml['JumlahTarif'] + $jmltindakan_hr['JumlahTindakan'];
						}
						echo '"'.$jml_retribusi.'", ';
					}		
				?>
				],
				backgroundColor: [
				<?php
				for($i = $mulai; $i <= $selesai; $i++){
				?>
					'rgba(98, 165, 247, 0.9)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i = $mulai; $i <= $selesai; $i++){
			?>
				'rgba(10, 84, 175, 1)',
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
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true
				}
			}]
		}
	}
});


var ctx = document.getElementById("Grafik_Bulan").getContext('2d');
var Grafik_Bulan = new Chart(ctx, {
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
			label: 'Jumlah Retribusi Bulanan',
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
						$jumlah_karcis = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(`TarifKarcis`) AS Jumlah FROM `$tbpasienrj` WHERE MONTH(`TanggalRegistrasi`) = '$val' AND YEAR(`TanggalRegistrasi`) = '$tahun'"));
						$jumlah_kir = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(`TarifKir`) AS Jumlah FROM `$tbpasienrj` WHERE MONTH(`TanggalRegistrasi`) = '$val' AND YEAR(`TanggalRegistrasi`) = '$tahun'"));
						$jumlah_tindakan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(`Tarif`) AS Jumlah FROM `$tbtindakanpasien` WHERE MONTH(`TanggalTindakan`) = '$val' AND YEAR(`TanggalTindakan`) = '$tahun'"));
						$jumlah = $jumlah_karcis['Jumlah'] + $jumlah_kir['Jumlah'] + $jumlah_tindakan['Jumlah'];
						echo '"'.$jumlah.'", ';
					}		
				?>
				],
				backgroundColor: [
				<?php
				for($i = $mulai; $i <= $val; $i++){
				?>
					'rgba(98, 165, 247, 0.9)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i = $mulai; $i <= $val; $i++){
			?>
				'rgba(10, 84, 175, 1)',
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
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true
				}
			}]
		}
	}
});

$(".btnaksi").click(function(){
	var noreg = $(this).data("noreg");
	var pkm = $(this).data("pkm");
	var sts = $(this).data("sts");
	//$(".noregmodal").val(noreg);
	$.post( "get_tindakan_pasien.php", {noreg: noreg, pkm: pkm, sts: sts}).done(function( data ) {
			$(".detailtindakan").html(data);
		});
	$("#modalkarcis").modal('show');
});

</script>
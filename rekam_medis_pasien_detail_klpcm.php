<?php
	include "config/helper_pasienrj.php";
    $key = $_GET['key'];
    $tahun = $_GET['tahun'];
    $lamakunjungan = $_GET['lamakunjungan'];
	$nocm = $_GET['nocm'];
	$dtpasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `IdPasien`,`NamaPasien` FROM `$tbpasienrj` WHERE `NoCM`='$nocm'"));
   
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=rekam_medis_pasien&key=<?php echo $key;?>&tahun=<?php echo $tahun;?>&lamakunjungan=<?php echo $lamakunjungan;?>" class="btn btn-round btn-info mt-0" style="float:right;">KEMBALI</a>
			<h3 class="judul mt-2"><b><?php echo $dtpasienrj['NamaPasien'];?></b></h3>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table-judul">
			<thead>
				<tr>
					<th width="3%">NO.</th>
					<th width="22%">SUBJEKTIVE</th>
					<th width="30%">OBJEKTIVE</th>
					<th width="20%">ASSESMENT</th>
					<th width="15%">PLANNING</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$jumlah_perpage = 5;
				
				if($_GET['h']==''){
					$mulai=0;
				}else{
					$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}

				$str = "SELECT * FROM `$tbpasienrj` WHERE `NoCM` = '$nocm'";		
				$str2 = $str." order by IdPasienrj DESC LIMIT $mulai,$jumlah_perpage";
				// echo $str2;

				if($_GET['h'] == null || $_GET['h'] == 1){
					$no = 0;
				}else{
					$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}

				$query = mysqli_query($koneksi, $str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noindex = $data['NoIndex'];
					$noreg = $data['NoRegistrasi'];
					
					if($data['PoliPertama'] == 'POLI Anak'){
						$tbpoliks = 'tbpolianak';	
					}elseif($data['PoliPertama'] == 'POLI GIZI'){
						$tbpoliks = 'tbpoligizi';
					}elseif($data['PoliPertama'] == 'POLI GIGI'){
						$tbpoliks = "tbpoligigi_".str_replace(' ', '', $namapuskesmas);	
					}elseif($data['PoliPertama'] == 'POLI IMUNISASI'){
						$tbpoliks = 'tbpoliimunisasi';	
					}elseif($data['PoliPertama'] == 'POLI ISOLASI'){
						$tbpoliks = 'tbpoliisolasi';		
					}elseif($data['PoliPertama'] == 'POLI KB'){
						$tbpoliks = 'tbpolikb';
					}elseif($data['PoliPertama'] == 'POLI KIA'){
						$tbpoliks = "tbpolikia_".str_replace(' ', '', $namapuskesmas);
					}elseif($data['PoliPertama'] == 'POLI LABORATORIUM'){
						$tbpoliks = 'tbpolilaboratorium';
					}elseif($data['PoliPertama'] == 'POLI LANSIA'){
						$tbpoliks = "tbpolilansia_".str_replace(' ', '', $namapuskesmas);
					}elseif($data['PoliPertama'] == 'POLI MTBS'){
						$tbpoliks = "tbpolimtbs_".str_replace(' ', '', $namapuskesmas);
					}elseif($data['PoliPertama'] == 'POLI PANDU PTM'){
						$tbpoliks = 'tbpolipanduptm';	
					}elseif($data['PoliPertama'] == 'POLI INFEKSIUS'){
						$tbpoliks = 'tbpoliinfeksius';
					}elseif($data['PoliPertama'] == 'POLI SCREENING'){
						$tbpoliks = 'tbpoliscreening';	
					}elseif($data['PoliPertama'] == 'POLI SKD'){
						$tbpoliks = 'tbpoliskd';		
					}elseif($data['PoliPertama'] == 'POLI TB DOTS'){
						$tbpoliks = 'tbpolitbdots';	
					}elseif($data['PoliPertama'] == 'POLI UMUM'){
						$tbpoliks = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
					}
					$queryks = mysqli_query($koneksi, "SELECT * FROM `$tbpoliks` WHERE `NoPemeriksaan` = '$noreg'");
					$dtks = mysqli_fetch_assoc($queryks);

					// vitalsign
					$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$data[IdPasienrj]'";
					$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
					$dtsistole = $dtvs['Sistole'];
					$dtdiastole = $dtvs['Diastole'];
					$dtsuhutubuh = $dtvs['SuhuTubuh'];
					$dttinggiBadan = $dtvs['TinggiBadan'];
					$dtberatBadan = $dtvs['BeratBadan'];
					$dtheartRate = $dtvs['HeartRate'];
					$dtrespRate = $dtvs['RespiratoryRate'];
					$dtLingkarPerut = $dtvs['LingkarPerut'];
					$imt = $dtvs['IMT'];
					
					if($dtsistole != ''){$dtsistole = $dtsistole;}else{$dtsistole = $dtks['Sistole'];}
					if($dtdiastole != ''){$dtdiastole = $dtdiastole;}else{$dtdiastole = $dtks['Diastole'];}
					if($dtsuhutubuh != ''){$dtsuhutubuh = $dtsuhutubuh;}else{$dtsuhutubuh = $dtks['SuhuTubuh'];}
					if($dttinggiBadan != ''){$dttinggiBadan = $dttinggiBadan;}else{$dttinggiBadan = $dtks['TinggiBadan'];}
					if($dtberatBadan != ''){$dtberatBadan = $dtberatBadan;}else{$dtberatBadan = $dtks['BeratBadan'];}
					if($dtheartRate != ''){$dtheartRate = $dtheartRate;}else{$dtheartRate = $dtks['DetakNadi'];}
					if($dtrespRate != ''){$dtrespRate = $dtrespRate;}else{$dtrespRate = $dtks['RR'];}
					if($dtLingkarPerut != ''){$dtLingkarPerut = $dtLingkarPerut;}else{$dtLingkarPerut = $dtks['LingkarPerut'];}
					if($imt != ''){$imt = $imt;}else{$imt = $dtks['Imt'];}
					
					// tbpasienperpegawai
					$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
					$dtpspegawai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienperpegawai` WHERE NoRegistrasi='$noreg'"));
					if($dttherapy['KodeBarang'] != ""){
						$trp = $dttherapy['KodeBarang'];
					}else{
						$trp = "-";
					}				
			?>
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="left">
							<?php 
								if($dtpspegawai['NamaPegawai1'] != ""){
									$pgw = strtoupper($dtpspegawai['NamaPegawai1']);
								}else{
									$pgw = strtoupper($dtpspegawai['NamaPegawai2']);
								}
								
								if($data['StatusPelayanan'] == 'Sudah'){
								echo	
								'<i class="icon-calendar"></i>&nbsp'.strtoupper($data['TanggalRegistrasi'])."<br/>".
								'<i class="icon-home"></i>&nbsp'.str_replace('POLI','PELAYANAN',$data['PoliPertama'])."<br/>".
								'<i class="icon-user"></i>&nbsp'.$pgw."<br/>".
								"<b>Anamnesa : </b>".$dtks['Anamnesa']."<br/>".
								"<b>Anjuran : </b>".$dtks['Anjuran'];
								}else{
								echo	
								'<i class="icon-calendar"></i>&nbsp'.strtoupper($data['TanggalRegistrasi'])."<br/>".
								'<i class="icon-home"></i>&nbsp'.str_replace('POLI','PELAYANAN',$data['PoliPertama'])."<br/>";
								}
							?>
						</td>
						<td align="left">
							<?php if($dtks['Anamnesa'] != ''){ ?>
								<table width="100%">
									<tr><td colspan="3"><b>Vital Sign :</b></td></tr>
									<tr><td width="30%">Tensi</td><td width="5%">:</td><td width="65%"><?php echo $dtsistole." / ".$dtdiastole;?></td></tr>
									<tr><td width="30%">Suhu Tubuh</td><td width="5%">:</td><td width="65%"><?php echo $dtsuhutubuh;?></td></tr>
									<tr><td width="30%">BB / TB</td><td width="5%">:</td><td width="65%"><?php echo $dtberatBadan." Kg / ".$dttinggiBadan." Cm";?></td></tr>
									<tr><td width="30%">HR / RR</td><td width="5%">:</td><td width="65%"><?php echo $dtheartRate." / ".$dtrespRate;?></td></tr>
									<tr><td width="30%">Lingkar Perut</td><td width="5%">:</td><td width="65%"><?php echo $dtLingkarPerut;?></td></tr>
									<tr><td width="30%">Imt</td><td width="5%">:</td><td width="65%"><?php echo $imt;?></td></tr>
								</table>								
							<?php }else{ ?>
								<span class='badge badge-warning' style='font-style: italic; padding: 8px;'>Belum Diinputkan</span>
							<?php } ?>	
						</td>
						<td align="left">
							<?php
								// diagnosa
								$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noreg' AND `NoIndex` = '$noindex'";
								$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
								while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
									$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
									$array_data[$no][] = "<b>".$data_diagnosapsn['KodeDiagnosa']."</b> ".$dtdiagnosa['Diagnosa'];
								}
								if ($array_data[$no] != ''){
									$data_dgs = implode("<br/>", $array_data[$no]);
									echo $data_dgs;
								}else{
							?>
									<span class='badge badge-danger' style='padding: 4px;'><i class='icon-close fa-3x'></i></span>
							<?php 
								} 
							?>
						</td>
						<td align="left">
							<?php
								// therapy
								$str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `NoResep` = '$noreg'";
								$query_therapy = mysqli_query($koneksi, $str_therapy);
								while($dt_therapy = mysqli_fetch_array($query_therapy)){
									$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `NamaBarang` FROM `$tbgudangpkmstok` WHERE `KodeBarang` = '$dt_therapy[KodeBarang]'"));
									$array_therapy[$no][] = $dtobat['NamaBarang']." (".$dt_therapy['jumlahobat'].")";
								}
								if ($array_therapy[$no] != ''){
									$data_trp = implode("<br/>", $array_therapy[$no]);
									echo $data_trp;
								}else{
							?>		
								<span class='badge badge-danger' style='padding: 4px;'><i class='icon-close fa-3x'></i></span>
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
	</div><hr/>
	<ul class="pagination noprint">
		<?php
			$query2 = mysqli_query($koneksi, $str);
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
						echo "<li><a href='?page=rekam_medis_pasien&key=$key&tahun=$tahun&lamakunjungan=$lamakunjungan&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>	
</div>
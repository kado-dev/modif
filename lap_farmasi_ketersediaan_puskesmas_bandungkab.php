<?php
	session_start();
	include "config/helper_report.php";
	include "config/koneksi.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KETERSEDIAAN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_farmasi_ketersediaan_puskesmas_bandungkab"/>
						<div class="col-xl-3">
							<select name="namaprg" class="form-control">
								<option value='Semua'>Semua</option>
								<option value='JKN'>JKN</option>
								<?php
								$queryp = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` order by `nama_program`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									if($_GET['namaprg'] == $data3['nama_program']){
										echo "<option value='$data3[nama_program]' SELECTED>$data3[nama_program]</option>";
									}else{
										echo "<option value='$data3[nama_program]'>$data3[nama_program]</option>";
									}
								}
								?>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="bulanawal" class="form-control">
								<option value="01" <?php if($_GET['bulanawal'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulanawal'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulanawal'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulanawal'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulanawal'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulanawal'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulanawal'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulanawal'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulanawal'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulanawal'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulanawal'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulanawal'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="bulanakhir" class="form-control">
								<option value="01" <?php if($_GET['bulanakhir'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulanakhir'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulanakhir'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulanakhir'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulanakhir'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulanakhir'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulanakhir'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulanakhir'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulanakhir'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulanakhir'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulanakhir'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulanakhir'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-2">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_ketersediaan_puskesmas_bandungkab" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
	
	<?php		
		$bulanawal = $_GET['bulanawal'];
		$bulanakhir = $_GET['bulanakhir'];
		$tahun = $_GET['tahun'];				
		
		if(isset($bulanawal) and isset($tahun)){
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" style="width:2500px;">
					<thead>
						<tr>
							<th width="1%" rowspan="3">No.</th>
							<th width="2%" rowspan="3">Kode</th>
							<th width="5%" rowspan="3">Nama Barang</th>
							<th width="2%" rowspan="3">Satuan</th>
							<th width="2%" rowspan="3">Harga<br/>Satuan</th>
							<th width="2%" rowspan="3">Expire</th>
							<th width="2%" rowspan="3">No.Batch</th>
							<th colspan="2">Stok Awal</th>
							<th colspan="2">Penerimaan</th>
							<th colspan="2">Ttl.Persediaan</th>
							<th colspan="24">Ketersediaan Bulan <?php echo $bulanawal." s/d ".$bulanakhir." ".$tahun;?></th>
							<th width="2%" rowspan="3">Pemakaian<br/>Rata-rata<br/>Per-Bulan</th>
							<th width="2%" rowspan="3">Tingkat<br/>Kecukupan</th>
							<th colspan="2">Total Distribusi</th>
							<th colspan="2">Total Pemakaian</th>
							<th colspan="2">Total Sisa Stok</th>
						</tr>
						<tr>
							<th width="1%" rowspan="2">Jml<br/>Fisik</th><!--StokAwal-->
							<th width="1%" rowspan="2">Jml<br/>Rupiah</th>
							<th width="1%" rowspan="2">Jml<br/>Fisik</th><!--Penerimaan-->
							<th width="1%" rowspan="2">Jml<br/>Rupiah</th>
							<th width="1%" rowspan="2">Jml<br/>Fisik</th><!--Persediaan-->
							<th width="1%" rowspan="2">Jml<br/>Rupiah</th>
							<th colspan="3">Gudang</th><!--Penerima Barang-->
							<th colspan="3">Depot</th>
							<th colspan="3">IGD</th>
							<th colspan="3">Ranap</th>
							<th colspan="3">Poned</th>
							<th colspan="3">Pustu</th>
							<th colspan="3">Pusling</th>
							<th colspan="3">Poli</th>
							<th width="1%" rowspan="2">Jml<br/>Fisik</th><!--Total Distribusi-->
							<th width="1%" rowspan="2">Jml<br/>Rupiah</th>
							<th width="1%" rowspan="2">Jml<br/>Fisik</th><!--Total Pemakaian-->
							<th width="1%" rowspan="2">Jml<br/>Rupiah</th>
							<th width="1%" rowspan="2">Jml<br/>Fisik</th><!--Total Sisa Stok-->
							<th width="1%" rowspan="2">Jml<br/>Rupiah</th>
						</tr>
						<tr>
							<th width="1%">D</th><!--Gudang-->
							<th width="1%">P</th>
							<th width="1%">S</th>
							<th width="1%">D</th><!--Depot-->
							<th width="1%">P</th>
							<th width="1%">S</th>
							<th width="1%">D</th><!--IGD-->
							<th width="1%">P</th>
							<th width="1%">S</th>
							<th width="1%">D</th><!--Ranap-->
							<th width="1%">P</th>
							<th width="1%">S</th>
							<th width="1%">D</th><!--Poned-->
							<th width="1%">P</th>
							<th width="1%">S</th>
							<th width="1%">D</th><!--Pustu-->
							<th width="1%">P</th>
							<th width="1%">S</th>
							<th width="1%">D</th><!--Pusling-->
							<th width="1%">P</th>
							<th width="1%">S</th>
							<th width="1%">D</th><!--Poli-->
							<th width="1%">P</th>
							<th width="1%">S</th>
						</tr>
						<tr>
							<th width="1%">1</th>
							<th width="1%">2</th>
							<th width="1%">3</th>
							<th width="1%">4</th>
							<th width="1%">5</th>
							<th width="1%">6</th>
							<th width="1%">7</th>
							<th width="1%">8</th>
							<th width="1%">9</th>
							<th width="1%">10</th>
							<th width="1%">21</th>
							<th width="1%">22</th>
							<th width="1%">23</th>
							<th width="1%">24</th>
							<th width="1%">25</th>
							<th width="1%">26</th>
							<th width="1%">27</th>
							<th width="1%">28</th>
							<th width="1%">29</th>
							<th width="1%">30</th>
							<th width="1%">31</th>
							<th width="1%">32</th>
							<th width="1%">33</th>
							<th width="1%">34</th>
							<th width="1%">35</th>
							<th width="1%">36</th>
							<th width="1%">37</th>
							<th width="1%">38</th>
							<th width="1%">39</th>
							<th width="1%">40</th>
							<th width="1%">41</th>
							<th width="1%">42</th>
							<th width="1%">43</th>
							<th width="1%">44</th>
							<th width="1%">45</th>
							<th width="1%">46</th>
							<th width="1%">47</th>
							<th width="1%">48</th>
							<th width="1%">49</th>
							<th width="1%">50</th>
							<th width="1%">51</th>
							<th width="1%">52</th>
							<th width="1%">53</th>
							<th width="1%">54</th>
							<th width="1%">55</th>
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
						
						$key = $_GET['key'];
						$namaprg = $_GET['namaprg'];
						
						if($key !=''){
							$strcari = " AND (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%')";
						}else{
							$strcari = " ";
						}
						
						if($namaprg == "Semua" OR $namaprg == ""){
							$namaprg = " ";
						}else{
							$namaprg = " AND `NamaProgram` = '$namaprg'";
						}	
						
						// ref_obat_lplpo
						$str = "SELECT * FROM `ref_obat_lplpo`";
						$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";						
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
												
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							if($namaprogram != $data['NamaProgram']){
								echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='45'>$data[NamaProgram]</td></tr>";
								$namaprogram = $data['NamaProgram'];
							}		
						
							$no = $no + 1;
							$kodebarang = $data['KodeBarang'];
							
							// tbgfkstok
							$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'"));
							$harga = $dtgfk['HargaBeli'];
							
							// tbstokawal
							$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokopnam_puskesmas_detail` 
							WHERE `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
							$stokawal = $dtstokopname['StokAwalApbd'] + $dtstokopname['StokAwalJkn'];
							$stokawal_rupiah = $stokawal * $harga;
							
							// penerimaan
							$penerimaans[1] = $dtstokopname['PenerimaanApbd_01'] + $dtstokopname['PenerimaanJkn_01'];
							$penerimaans[2] = $dtstokopname['PenerimaanApbd_02'] + $dtstokopname['PenerimaanJkn_02'];
							$penerimaans[3] = $dtstokopname['PenerimaanApbd_03'] + $dtstokopname['PenerimaanJkn_03'];
							$penerimaans[4] = $dtstokopname['PenerimaanApbd_04'] + $dtstokopname['PenerimaanJkn_04'];
							$penerimaans[5] = $dtstokopname['PenerimaanApbd_05'] + $dtstokopname['PenerimaanJkn_05'];
							$penerimaans[6] = $dtstokopname['PenerimaanApbd_06'] + $dtstokopname['PenerimaanJkn_06'];
							$penerimaans[7] = $dtstokopname['PenerimaanApbd_07'] + $dtstokopname['PenerimaanJkn_07'];
							$penerimaans[8] = $dtstokopname['PenerimaanApbd_08'] + $dtstokopname['PenerimaanJkn_08'];
							$penerimaans[9] = $dtstokopname['PenerimaanApbd_09'] + $dtstokopname['PenerimaanJkn_09'];
							$penerimaans[10] = $dtstokopname['PenerimaanApbd_10'] + $dtstokopname['PenerimaanJkn_10'];
							$penerimaans[11] = $dtstokopname['PenerimaanApbd_11'] + $dtstokopname['PenerimaanJkn_11'];
							$penerimaans[12] = $dtstokopname['PenerimaanApbd_12'] + $dtstokopname['PenerimaanJkn_12'];

							//berdasar bulan dipilih 
							for($i = intval($bulanawal); $i <= intval($bulanakhir); $i++){
								$penerimaans_dipilih[$no][] = $penerimaans[$i];
							}

							$penerimaan_jmlfisik = array_sum($penerimaans_dipilih[$no]);// echo $penerimaan_jmlfisik;
							$penerimaan_jmlfisik_harga = $penerimaan_jmlfisik * $harga;
							
							// Total Persediaan
							$ttl_persediaan = $stokawal + $penerimaan_jmlfisik;
							$ttl_persediaan_harga = $ttl_persediaan * $harga;
							
							// Ketersediaan Gudang
							
							
						?>
							<tr>
								<td align="right"><?php echo $no;?></td>							
								<td align="center"><?php echo $data['KodeBarang'];?></td>									
								<td align="left"><?php echo $data['NamaBarang'];?></td>									
								<td align="center"><?php echo $data['Satuan'];?></td>
								<td align="right"><?php  echo rupiah($harga);?></td>									
								<td align="center"></td>									
								<td align="center"></td>	
								<!--stok awal-->
								<td align="right"><?php echo $stokawal;?></td>	
								<td align="right"><?php echo rupiah($stokawal_rupiah);?></td>
								<!--penerimaan-->
								<td align="right"><?php echo $penerimaan_jmlfisik;?></td>	
								<td align="right"><?php echo rupiah($penerimaan_jmlfisik_harga)?></td>
								<!--persediaan-->
								<td align="right"><?php echo $ttl_persediaan;?></td>	
								<td align="right"><?php echo rupiah($ttl_persediaan_harga);?></td>
								<!--ketersediaan gudang-->
								<td align="right">
								
								</td>	
								<td align="right"></td>	
								<td align="right"></td>	
								<!--ketersediaan depot-->
								<td align="right"></td>	
								<td align="right"></td>	
								<td align="right"></td>	
								<!--ketersediaan igd-->
								<td align="right"></td>	
								<td align="right"></td>	
								<td align="right"></td>	
								<!--ketersediaan ranap-->
								<td align="right"></td>	
								<td align="right"></td>	
								<td align="right"></td>	
								<!--ketersediaan poned-->
								<td align="right"></td>	
								<td align="right"></td>	
								<td align="right"></td>	
								<!--ketersediaan pustu-->
								<td align="right"></td>	
								<td align="right"></td>	
								<td align="right"></td>	
								<!--ketersediaan pusling-->
								<td align="right"></td>	
								<td align="right"></td>	
								<td align="right"></td>	
								<!--ketersediaan poli-->
								<td align="right"></td>	
								<td align="right"></td>	
								<td align="right"></td>	
								<!--pemakaian rata2-->
								<td align="right"></td>	
								<!--tingkat kecukupan-->
								<td align="right"></td>	
								<!--total distribusi-->
								<td align="right"></td>
								<td align="right"></td>
								<!--total pemakaian-->
								<td align="right"></td>
								<td align="right"></td>
								<!--total sisa stok-->
								<td align="right"></td>
								<td align="right"></td>
							</tr>
						<?php	
						}	
						?>
					</tbody>
				</table>
			</div>
		</div>	
	</div><hr/>
	<ul class="pagination">
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
						$namaprgs = $_GET['namaprg'];
						echo "<li><a href='?page=lap_farmasi_ketersediaan_puskesmas_bandungkab&namaprg=$namaprgs&bulanawal=$bulanawal&bulanakhir=$bulanakhir&tahun=$tahun&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>	
	<?php
		}
	?>
	<!--<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p>
					<b>Keterangan :</b><br/>
					- Silahkan download excel<br/>
					- Buka file excel, lalu isi kolom yang berwarna merah
				</p>
			</div>
		</div>
	</div>-->
</div>	


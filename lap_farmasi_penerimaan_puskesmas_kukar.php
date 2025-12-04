<?php
	session_start();
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	include "config/koneksi.php";
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>PENERIMAAN</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_penerimaan_puskesmas_kukar"/>
						<div class="col-sm-1" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-info btn-white">Lihat</button>
							<a href="?page=lap_farmasi_penerimaan_puskesmas_kukar" class="btn btn-success btn-white"><span class="fa fa-refresh"></span></a>
							<a href="lap_farmasi_penerimaan_puskesmas_kukar_print.php?namaprogram=<?php echo $_GET['namaprg'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-primary btn-white"><span class="fa fa-print"></span></a>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>
	
	<?php			
		$tahun = $_GET['tahun'];
		$namaprg = $_GET['namaprg'];
		
		if(isset($tahun)){
		$array_bln = array('00','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des');	
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%"><!--style="width:1600px;"-->
					<thead>
						<tr>
							<th width="3%">No.</th>
							<th width="7%">Bulan</th>
							<th width="10%">Tgl.Penerimaan</th>
							<th width="10%">No.SBBK</th>
							<th width="10%">Jumlah<br/>Item</th>
							<th width="10%">Total Harga<br/>Per Faktur</th>
							<th width="10%">Total Harga<br/>Per Bulan</th>
							<th width="10%">Total Harga<br/>Per Triwulan</th>
							<th width="10%">Keterangan</th>
						</tr>
						
					</thead>
					<tbody>
						<?php
						$blns = "";
						$str = "SELECT * FROM `tbgudangpkmpenerimaandetail` a JOIN `tbgudangpkmpenerimaan` b ON a.NoFaktur = b.NoFaktur
						WHERE a.`KodePuskesmas`='$kodepuskesmas' AND YEAR(b.TanggalPenerimaan) = '$tahun'";
						$str2 = $str." GROUP BY a.NoFaktur Order BY TanggalPenerimaan";
						// echo $str2;
												
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$bulan = date('m',strtotime($data['TanggalPenerimaan']));
							
							// tbgudangpkmpenerimaandetail
							$dtitem = mysqli_num_rows(mysqli_query($koneksi, "SELECT `Id` FROM `tbgudangpkmpenerimaandetail` WHERE `NoFaktur`='$data[NoFaktur]'"));
														
							// jumlah item
							$strgt = "SELECT SUM(Jumlah * HargaBeli) AS Jumlah 
							FROM tbgudangpkmpenerimaandetail
							WHERE NoFaktur='$data[NoFaktur]'";
							$dtgt = mysqli_fetch_assoc(mysqli_query($koneksi, $strgt));	

							$strgtperbulan = "SELECT SUM(a.Jumlah * a.HargaBeli) AS Jumlah 
							FROM tbgudangpkmpenerimaandetail a JOIN `tbgudangpkmpenerimaan` b ON a.NoFaktur = b.NoFaktur WHERE a.NoFaktur='$data[NoFaktur]' AND YEAR(b.TanggalPenerimaan) = '$tahun' AND MONTH(b.TanggalPenerimaan) = '$bulan'";
							// echo $strgtperbulan;
							$dtgtperbulan = mysqli_fetch_assoc(mysqli_query($koneksi, $strgtperbulan));

							
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<?php
									if($bulan != $blns){
										$jmlbulan = mysqli_num_rows(mysqli_query($koneksi,"SELECT a.NoFaktur FROM `tbgudangpkmpenerimaandetail` a JOIN `tbgudangpkmpenerimaan` b ON a.NoFaktur = b.NoFaktur WHERE a.`KodePuskesmas`='$kodepuskesmas' AND YEAR(b.TanggalPenerimaan) = '$tahun' AND MONTH(b.TanggalPenerimaan) = '$bulan' GROUP BY a.NoFaktur"));
										echo '<td align="center" rowspan="'.$jmlbulan.'">'.nama_bulan($bulan).'</td>';
									}else{
										echo '';
									}
									
								?>
								<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalPenerimaan']));?></td>								
								<td align="center"><?php echo $data['NoSbbkManual'];?></td>								
								<td align="center"><?php echo $dtitem;?></td>								
								<td align="right"><?php echo rupiah($dtgt['Jumlah']);?></td>						
								<?php
									if($bulan != $blns){
										echo '<td align="left" rowspan="'.$jmlbulan.'">'.rupiah($dtgtperbulan['Jumlah']).'</td>';
									}else{
										echo '';
									}
									
								?>										
								<td align="left"></td>								
								<td align="left"><?php echo $data['Keterangan'];?></td>	
							</tr>
						<?php	
							$blns = $bulan;
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
						echo "<li><a href='?page=lap_farmasi_penerimaan_puskesmas_kukar&tahun=$tahun&namaprogram=$namaprogram&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>	
	<?php
		}
	?>
</div>	


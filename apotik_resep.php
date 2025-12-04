<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$pel = $_GET['pelayanan'];
	$tanggal = date('Y-m-d');
?>

<div class="tableborderdiv">
	<div class="row search-page" id="search-page-1">
		<div class="col-xs-12">
			<h3 class="judul">RESEP MANUAL</h3>
			<div class="formbg">
				<div class="row">
					<form role="form">
						<input type="hidden" name="page" value="apotik_resep"/>
						<div class="col-sm-2">
							<input type="text" name="tgl" class="form-control datepicker" value="<?php echo $_GET['tgl'];?>" placeholder = "Pilih Tanggal">
						</div>
						<div class="col-sm-4">
							<input type="text" name="nama" class="form-control" value="<?php echo $_GET['nama'];?>" placeholder = "Masukan Nama Pasien">
						</div>

						<div class="col-sm-2">
							<button type="submit" class="btn btn-sm btn-warning">Cari</button>
							<a href="?page=apotik_resep" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-refresh"></span></a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>

	<!--kolom data-->
	<div class="row search-page" id="search-page-1">	
		<div class="col-xs-12">
			<div class="row">	
				<div class="col-sm-12 table-responsive" style="font-size:12px">
					<table class="table-judul-laporan">
						<thead>
							<tr>
								<th width="4%">No.</th>
								<th width="8%">Tanggal</th>
								<th width="6%">No.Reg</th>
								<th width="20%">Nama Pasien</th>
								<th width="4%">L/P</th>
								<th width="9%">Umur</th>
								<th width="12%">Poli Pertama</th>
								<th width="10%">Jaminan</th>
								<th width="6%">Status</th>
								<th width="5%">Opsi</th>
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
							
							$status = 'Antri';		
							$tgl = $_GET['tgl'];				
							$nama = $_GET['nama'];	

							if($tgl != null){
								$tgls = date('Y-m-d',strtotime($tgl));
								
								$tgl_str = " TanggalRegistrasi = '$tgls' AND ";
							}else{
								$tgl_str = " TanggalRegistrasi = '".date('Y-m-d')."' AND ";
							}		
							
							if($nama != null){
								$nama_str = " AND NamaPasien like '%$nama%'";
							}else{
								$nama_str = "";
							}	
							
							$bulan = date("m");
							$tbpasienrj = 'tbpasienrj_'.$bulan;
							$str = "SELECT * FROM `$tbpasienrj` WHERE ".$tgl_str."substring(NoRegistrasi,1,11) = '$kodepuskesmas' ".$nama_str;
							$str2 = $str." order by NamaPasien ASC limit $mulai,$jumlah_perpage";
							
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$query = mysqli_query($koneksi,$str2);
							while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							?>
								<tr>
									<td style="text-align: center;"><?php echo $no;?></td>
									<td style="text-align: center;"><?php echo $data['TanggalRegistrasi'];?></td>
									<td style="text-align: center;"><?php echo substr($data['NoRegistrasi'],-3);?></td>
									<td style="text-align: left;"class="namakk"><?php echo $data['NamaPasien'];?></td>
									<td style="text-align: center;"><?php echo $data['JenisKelamin'];?></td>
									<td style="text-align: left;"><?php echo $data['UmurTahun'];?> Th, <?php echo $data['UmurBulan'];?> Bl,  <?php echo $data['UmurHari'];?> Hr</td>
									<td style="text-align: center;"><?php echo $data['PoliPertama'];?></td>
									<td style="text-align: center;"><?php echo $data['Asuransi'];?></td>
									<td style="text-align: center;"><?php echo $data['StatusPelayanan'];?></td>
									<td style="text-align: center;">
									<?php if($data['StatusPelayanan'] == 'Sudah'){ ?>
										<a href="?page=poli_periksa_edit&no=<?php echo $data['NoRegistrasi'];?>&pelayanan=<?php echo $data['PoliPertama'];?>" target="_blank"class="btn btn-xs btn-info btn-white"> Edit</a>
									<?php }else{ ?>	
										<a href="?page=poli_periksa&no=<?php echo $data['NoRegistrasi'];?>&pelayanan=<?php echo $data['PoliPertama'];?>&sts_resep=apotik_resep" class="btn btn-xs btn-info btn-white">Periksa</a>
									<?php }	?>	
									</td>			
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div><hr>
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
						echo "<li><a href='?page=apotik_resep&pelayanan=$pel&tgl=$tgl&nama=$nama&status=$status&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>	
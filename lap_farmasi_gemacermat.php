<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>GEMA CERMAT</b></h3>
		</div>
	</div>
	<?php
		$bulan = date('m');	
		$tahun = date('y');	
		$namapuskesmas = $_SESSION['namapuskesmas'];
		
		if($kategori == "Tempat"){
			$kategori = " AND `Tempat` like '%$key%'";
		}elseif($kategori == "Sumber Dana"){	
			$kategori = " AND `SumberDana` like '%$key%'";
		}else{
			$kategori = "";
		}	
		
		$str = "SELECT * FROM `tbgfkgemacermat` WHERE `Penyelenggara`='$namapuskesmas'".$kategori;
		$str2 = $str." ORDER BY `IdKegiatan` DESC";
		// echo $str2;
	?>		
	
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<table class="table-judul-laporan">
				<thead>
					<tr>
						<th width="3%" rowspan="2">No.</th>
						<th width="7%" rowspan="2">Tgl.<br/>Kegiatan</th>
						<th width="12%" rowspan="2">Tempat</th>
						<th width="6%" rowspan="2">Sumber<br/>Dana</th>
						<th width="10%" rowspan="2">Peserta Pertemuan</th>
						<th width="25%" colspan="5">Jumlah Peserta</th>
						<th width="10%" rowspan="2">Hasil Pelaksanaan<br/>Kegiatan</th>
						<th width="10%" rowspan="2">Rencana Tindak<br/>Lanjut</th>
						<th width="10%" rowspan="2">Aksi</th>
					</tr>
					<tr>
						<th>Apoteker</th>
						<th>Nakes Lainnya</th>
						<th>Kader</th>
						<th>Masyarakat<br/>Umum</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$ttl_peserta = $data['JumlahApoteker'] + $data['JumlahNakesLain'] + $data['JumlahKader'] + $data['JumlahMasyarakat'];
				?>
					<tr>
						<td align="right"><?php echo $no;?></td>		
						<td align="center"><?php echo $data['TanggalKegiatan'];?></td>		
						<td align="left"><?php echo strtoupper($data['Tempat']);?></td>		
						<td align="center"><?php echo $data['SumberDana'];?></td>		
						<td align="left"><?php echo strtoupper($data['Peserta']);?></td>		
						<td align="center"><?php echo $data['JumlahApoteker'];?></td>		
						<td align="center"><?php echo $data['JumlahNakesLain'];?></td>		
						<td align="center"><?php echo $data['JumlahKader'];?></td>		
						<td align="center"><?php echo $data['JumlahMasyarakat'];?></td>		
						<td align="center"><?php echo $ttl_peserta;?></td>	
						<td align="left"><?php echo strtoupper($data['HasilKegiatan']);?></td>		
						<td align="left"><?php echo strtoupper($data['RencanaTindakLanjut']);?></td>	
						<td align="center">
							<a href="?page=gudang_besar_gemacermat_edit&id=<?php echo $data['IdKegiatan'];?>" class="btn btn-xs btn-success btn-white"> Edit</a>
							<a href="?page=gudang_besar_gemacermat_print&id=<?php echo $data['IdKegiatan'];?>&nf=<?php echo $data['NoFakturKegiatan'];?>" class="btn btn-xs btn-info btn-white"> Print</a>
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

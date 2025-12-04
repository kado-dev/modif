<?php
	$tanggal = $_GET['tgl'];
	$kodepuskesmas = $_GET['pkm'];
?>

<!--judul menu-->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Data Registrasi <small>e-Puskesmas</small>
		</h1>
		<ol class="breadcrumb">
			<li class="active">
				<i class="fa fa-dashboard"></i> Puskesmas:
				<?php
					$str_puskesmas = "select `NamaPuskesmas` from `tbpuskesmas` where `KodePuskesmas`='$kodepuskesmas'";
					$query_puskesmas = mysqli_query($koneksi,$str_puskesmas);
					$data_puskesmas = mysqli_fetch_assoc($query_puskesmas);
					echo $data_puskesmas['NamaPuskesmas'];
				  ?>
			</li>
		</ol>
	</div>
</div>

<!--cari pasien-->
<div class="panel panel-default noprint">
	<div class="panel-heading">
		<div class="row">
			<div class="col-sm-12">
				<h4><span class="glyphicon glyphicon-search"></span>  Cari Berdasar</h4>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<div class="row">
			<form role="form">
				<input type="hidden" name="page" value="registrasi_data_dinkes"/>
				<div class="col-sm-2">
					<select name="kategori" class="form-control lap_loket">
						<option value="">--Pilih--</option>
						<option value="NamaPasien" <?php if($_GET['kategori'] == 'NamaPasien'){echo "SELECTED";}?>>Nama Pasien</option>
						<option value="PoliPertama" <?php if($_GET['kategori'] == 'PoliPertama'){echo "SELECTED";}?>>Poli</option>
						<option value="Asuransi" <?php if($_GET['kategori'] == 'Asuransi'){echo "SELECTED";}?>>Jaminan</option>
						<option value="TanggalRegistrasi" <?php if($_GET['kategori'] == 'TanggalRegistrasi'){echo "SELECTED";}?>>Tgl.Registrasi</option>
					</select>
				</div>
				<div class="col-sm-8">
					<input type="text" name="key" class="form-control key" value="<?php echo $_GET['key'];?>" required>
					<div class="tampilformdate hiddens">
						<input type="text" name="keydate1" class="form-control datepicker2" style="width:180px;float:left;margin-right:30px;"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:180px;float:left">
					</div>
				</div>
				<div class="col-sm-2">
					<button type="submit" class="btn btn-md btn-primary">Cari</button>
					<!--<a href="?page=registrasi_data_dinkes&tgl=$tanggal&pkm=$kodepuskesmas" class="btn btn-md btn-success"><span class="glyphicon glyphicon-refresh"></span></a>-->
					<a href="?page=registrasi_data_dinkes" class="btn btn-md btn-success"><span class="glyphicon glyphicon-refresh"></span></a>
				</div>
			</form>	
		</div>
	</div>
</div>

<!--data registrasi-->
<div class="table-responsive">
	<table class="table table-striped table-condensed"><!-- table-condensed pada bootstrap.min.css ".table-condensed>tfoot>tr>td{padding:3px}"-->
		<thead>
			<tr>
				<th>No.</th>
				<th>Tanggal</th>
				<th>No.Index</th>
				<th>Nama Pasien</th>
				<th>L/P</th>
				<th>Poli</th>
				<th>Jaminan</th>
				<th>Status</th>
			</tr>
		</thead>
		<!--tbpasienrj-->
		<tbody font="8">
			<!--paging-->
			<?php
			$jumlah_perpage = 20;
			
			if($_GET['h']==''){
				$mulai=0;
			}else{
				$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$kategori = $_GET['kategori'];		
			$key = $_GET['key'];		
			
			if($kategori !='' && $key !=''){
				$strcari = " AND ".$kategori." Like '%$key%'";
			}else{
				$strcari = " ";
			}
			
			//$tanggal = date('Y-m-d');//H:i:s
			$str = "select `TanggalRegistrasi`,`NoRegistrasi`,`NoIndex`,`NamaPasien`,`JenisKelamin`,`PoliPertama`,`Asuransi`,`StatusPelayanan` from `tbpasienrj` where `TanggalRegistrasi`='$tanggal' AND substring(NoRegistrasi,1,11) = '$kodepuskesmas'".$strcari;
			$str2 = $str."order by `NoRegistrasi` Desc limit $mulai,$jumlah_perpage";
			//echo var_dump($str);
			//die();
			
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
					<td><?php echo $no;?></td>
					<td><?php echo $data['TanggalRegistrasi'];?></td>
					<td><?php echo $data['NoIndex'];?></td>
					<td class="noreg" style="display:none"><?php echo $data['NoRegistrasi'];?></td>
					<td><?php echo $data['NamaPasien'];?></td>
					<td><?php echo $data['JenisKelamin'];?></td>
					<td><?php echo $data['PoliPertama'];?></td>
					<td><?php echo $data['Asuransi'];?></td>
					<td><?php echo $data['StatusPelayanan'];?></td>		
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
<hr>
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
					echo "<li><a href='?page=registrasi_data_dinkes&tgl=$tanggal&pkm=$kodepuskesmas&h=$i'>$i</a></li>";
				}
			}
		}
	?>	
</ul>

<!--untuk menampilkan modal-->
<div class="panel panel-default hasilmodal">
	
</div>
<!--akhir modal-->
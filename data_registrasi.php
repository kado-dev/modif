<div class="breadcrumb">
  <h3><b><span class="glyphicon glyphicon-list-alt"></span> Data Kepala Keluarga</b>
  <a href="?page=daftar" class="btn btn-md btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Tambah </a>
  <a href="?page=registrasi" class="btn btn-md btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Registrasi </a>
  </h3>
</div>
		<table class="table table-striped table-condensed"><!-- table-condensed pada bootstrap.min.css ".table-condensed>tfoot>tr>td{padding:3px}"-->
			<thead>
				<tr>
					<th class="col-sm-1">No Index</th>
					<th>NoKK</th>
					<th>Nama</th>
					<th>Alamat</th>			
					<th>Opsi</th>
				</tr>
			</thead>
			<tbody font="8">
			<?php
			$query = mysqli_query($koneksi,"select * from `$tbkk`");
			while($data = mysqli_fetch_assoc($query)){
			?>
				<tr>
					<td><?php echo $data['NoIndex'];?></td>
					<td><?php echo $data['NoKK'];?></td>
					<td class="namakk"><?php echo $data['NamaKK'];?></td>
					<td><?php echo $data['Daerah'];?></td>
					<td>
						<a href="?page=datakk_detail&id=<?php echo $data['NoIndex'];?>" class="btn btn-xs btn-info">Detail</a>
						<a href="?page=datakk_edit&id=<?php echo $data['NoIndex'];?>" class="btn btn-xs btn-info">edit</a>
						<a href="?page=datakk_hapus&id=<?php echo $data['NoIndex'];?>"  class="btn btn-xs btn-danger btnhapus">hapus</a>
					</td>			
				</tr>
			<?php
			}
			?>
			</tbody>
		</table>


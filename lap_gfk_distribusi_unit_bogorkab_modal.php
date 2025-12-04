<?php
	include("config/koneksi.php");
	include("config/helper.php");
?>

<div class="modal" id="modaldetails" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="exampleModalLongTitle">DATA BARANG</h4>
      </div>
      <div class="modal-body">
        <!--<h3 class="judul"><b>DATA BARANG</b></h3>-->
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr>
							<th width="2%">No.</th>
							<th width="5%">Kode</th>
							<th width="20%">Nama Barang</th>
							<th width="8%">Satuan</th>
							<th width="8%">Batch</th>
							<th width="8%">Expire</th>
							<th width="6%">Jumlah</th>
							<th width="6%">Harga Sat.</th>
							<th width="10%">Total</th>
						</tr>
					</thead>
					<tbody font="8">
						<?php
							$id = $_POST['id'];
							$no = 0;
							$str = "SELECT * FROM `tbgfkpengeluarandetail` WHERE `NoFaktur` ='$id'";
							$query = mysqli_query($koneksi,$str);
							while ($dt_brg = mysqli_fetch_assoc($query)){
								$no = $no + 1;
								$kdbrg = $dt_brg['KodeBarang'];
								$batch = $dt_brg['NoBatch'];
								$jmlbrg = $dt_brg['Jumlah'];
								$harga = $dt_brg['Harga'];
								$totalhrg = $jmlbrg * $harga;
								
								// tbgfkstok
								$dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$batch'"));
									
							?>
							<tr>
								<td align="right"><?php echo $no;?></td>
								<td align="center"><?php echo $kdbrg;?></td>
								<td align="left"><?php echo $dtgfk['NamaBarang'];?></td>
								<td align="center"><?php echo $dtgfk['Satuan'];?></td>
								<td align="center"><?php echo $dtgfk['NoBatch'];?></td>
								<td align="center"><?php echo $dtgfk['Expire'];?></td>
								<td align="center"><?php echo $jmlbrg;?></td>
								<td align="right"><b><?php echo rupiah($harga);?></b></td>
								<td align="right"><b><?php echo rupiah($totalhrg);?></b></td>
							</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</div>
      </div>

    </div>
  </div>
</div>
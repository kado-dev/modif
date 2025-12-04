<?php
	session_start();
	include"config/koneksi.php";
	include "config/helper.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];

?>
<!--untuk menampilkan modal-->
<div class="modal fade" id="btnmodalpengadaanobat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"> Data Pengadaan / Penerimaan</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="index.php?page=master_pegawai_proses" method="post" enctype="multipart/form-data" role="form">
					<table class="table table-condensed">
						<thead style="font-size:10px;">
							<tr style="border:1px solid #000;">
								<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
								<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tanggal</th>
								<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NoFaktur</th>
								<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kode Barang</th>
								<th width="25%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Barang</th>
								<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
							</tr>
						</thead>
						
						<!--tbstokbulananapotik-->
						<tbody style="font-size:10px;">
							<?php
							$kodebarang = $_POST['kodebarang'];
							$str = "SELECT *
							FROM `tbgfkpengeluarandetail` a 
							join tbgfkpengeluaran b on a.NoFaktur = b.NoFaktur
							join tbgfkstok c on a.KodeBarang = c.KodeBarang
							WHERE a.KodeBarang = '$kodebarang' AND b.KodePenerima = '$kodepuskesmas'";
							//echo $str;
							$query = mysqli_query($koneksi,$str);
							
							while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							?> 
								<tr style="border:1px solid #000;">
									<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
									<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TanggalPengeluaran'];?></td>
									<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['NoFaktur'];?></td>
									<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['KodeBarang'];?></td>
									<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaBarang'];?></td>
									<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($data['Jumlah']);?></td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
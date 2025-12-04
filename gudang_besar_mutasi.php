<style>
	.kertas {
		text-align:center;
		background: white;
	}
	
	.print{
		display:none;
		margin:auto; 
		background:white;
	}
	#barcode{
		width:100%;
		height:90px;
		margin:0px;
		margin-top:0px;
		float:center;
	}
	.tbrowbarcode td{
		text-align:center;
		font-size:8px;
	}

@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.print{
		display:block;
	}
}
</style>
<script>
	function printWindow(){
	   bV = parseInt(navigator.appVersion)
	   if (bV >= 4) window.print()
	}
</script>

<?php
	$kodebarang = $_GET['kd'];
	$nobatch = $_GET['batch'];
	$str = "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_array($query);
?>



<div class="tableborderdiv noprint">
	<div class="row">
		<form class="form-horizontal" action="index.php?page=gudang_besar_mutasi_proses" method="post" enctype="multipart/form-data" role="form">
			<div class="col-xs-6">
				<h3 class="judul"><b>Data Awal</b></h3>
				<div class="formbg">
					<div class = "row">
						<div class="box-body">
							<table class="table table-striped">
								<tr>
									<td><input type="text" name="namabarang_awal" class="form-control nama_barang_mutasi_awal" placeholder="Ketikan Kode/Nama Barang"></td>
								</tr>
							</table>
							<table class="table table-striped">
								<tr>
									<td width="30%">Kode Barang</td>
									<td width="70%"><input type="text" name="kodebarang_awal" class="form-control kodebarang_awal" readonly></td>
								</tr>
								<tr>
									<td>Batch</td>
									<td><input type="text" name="nobatch_awal" class="form-control nobatch_awal" readonly></td>
								</tr>
								<tr>
									<td>No.Faktur Terima</td>
									<td><input type="text" name="nofaktur_awal" class="form-control nofaktur_awal" readonly></td>
								</tr>
								<tr>
									<td>Program</td>
									<td><input type="text" name="satuan_awal" class="form-control namaprogram_awal" readonly></td>
								</tr>
							</table>
						</div>
					</div>	
				</div>
			</div>	
			<div class="col-xs-6">
				<h3 class="judul"><b>Data Akhir</b></h3>
				<div class="formbg">
					<div class = "row">
						<div class="box-body">
							<table class="table table-striped">
								<tr>
									<td><input type="text" name="namabarang_akhir" class="form-control nama_barang_mutasi_akhir" placeholder="Ketikan Kode/Nama Barang"></td>
								</tr>
							</table>
							<table class="table table-striped">
								<tr>
									<td width="30%">Kode Barang</td>
									<td width="70%"><input type="text" name="kodebarang_akhir" class="form-control kodebarang_akhir" readonly></td>
								</tr>
								<tr>
									<td>Batch</td>
									<td><input type="text" name="nobatch_akhir" class="form-control nobatch_akhir" readonly></td>
								</tr>
								<tr>
									<td>No.Faktur Terima</td>
									<td><input type="text" name="nofaktur_akhir" class="form-control nofaktur_akhir" readonly></td>
								</tr>
								<tr>
									<td>Program</td>
									<td><input type="text" name="satuan_akhir" class="form-control namaprogram_akhir" readonly></td>
								</tr>
							</table>
						</div>
					</div>	
				</div>
			</div>
		</form>			
	</div>
	<button type="submit" class="btnsimpan">Proses</button>
</div>
<script src="assets/js/jquery.js"></script>
<script>
$(".opsicode").change(function(){
	if($(this).val() == 'Qrcode'){
		$(".barcodeprint").hide();
		$(".qrcodeprint").show();
	}else{
		$(".barcodeprint").show();
		$(".qrcodeprint").hide();
	}
});
</script>

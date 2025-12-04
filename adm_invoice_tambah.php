<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
?>

<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Tambah Invoice</h1>
		</div>
	</div>
</div>

<?php
	$bulan=date('m');
	$tahun=date('Y');
	$sql_cek='SELECT max(NoInvoice)as maxno FROM `tbadm_invoice` WHERE substring(NoInvoice,7,4)=YEAR(now())';
	$query_cek=mysqli_query($koneksi,$sql_cek);
	$datareg=mysqli_fetch_array($query_cek);
		$no=substr($datareg['maxno'],-3);
		$no_next=$no+1;
			if(strlen($no_next)==1)
			{
				$no="00".$no_next;
			}
			elseif(strlen($no_next)==2)
			{
				$no="0".$no_next;
			}
			else
			{
				$no=$no_next;
			}
	$nofaktur = "INV/".$bulan.$tahun."/".$no;
?>
	
<!--data barang-->
<div class="row">	
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bars"></i> Invoice</h3>
			</div>
			<div class="panel-body">
				<form action="?page=adm_invoice_tambah_proses" method="post">
					<div class="table-responsive" style="font-size:12px">
						<table class="table table-hover table-condensed">
							<tbody>
								<tr>
									<td class="col-sm-2">No.Invoice</td>
									<td>:</td>
									<td class="col-sm-10">
										<input type="text" name="noinvoice" class="form-control" value="<?php echo $nofaktur;?>" readonly>
									</td>
								</tr>		
								<tr>
									<td class="col-sm-2">Tgl.Invoice</td>
									<td>:</td>
									<td class="col-sm-10">
										<div class="input-group">
											<span class="input-group-addon tesdate">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<?php
												$tgle = explode("-",date ('Y-m-d'));
											?>
											<input type="text" name="tanggalinvoice" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>">
										</div>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Ditujukan</td>
									<td>:</td>
									<td class="col-sm-10">
										<input  type="text" name="ditujukan" style="text-transform: uppercase;" class="form-control puyer" required>								
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Jumlah Tagihan</td>
									<td>:</td>
									<td class="col-sm-4">
										<input  type="number" name="jumlahtagihan" class="form-control puyer" required>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Keterangan</td>
									<td>:</td>
									<td class="col-sm-4">
										<input  type="text" name="keterangan" style="text-transform: uppercase;" class="form-control puyer" required>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2"></td>
									<td></td>
									<td class="col-sm-4">
										<input type="submit" value="Simpan" class="btn btn-info">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>




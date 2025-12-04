<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
?>

<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Pengeluaran Barang <small>Gudang Obat UPTD</small></h1>
		</div>
	</div>
</div>

<?php
$tahun=date('Y');
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$sql_cek="SELECT max(NoFaktur)as maxno from tbgudanguptdpengeluaran WHERE substring(NoFaktur,13,4)=YEAR(now()) AND substring(NoFaktur,1,11)='$kodepuskesmas'";
// echo $sql_cek;
// die();
$query_cek=mysqli_query($koneksi,$sql_cek);
$datareg=mysqli_fetch_array($query_cek);
	$no=substr($datareg['maxno'],-5);
	$no_next=$no+1;
		if(strlen($no_next)==1)
		{
			$no="0000".$no_next;
		}
		elseif(strlen($no_next)==2)
		{
			$no="000".$no_next;
		}
		elseif(strlen($no_next)==3)
		{
			$no="00".$no_next;
		}
		elseif(strlen($no_next)==4)
		{
			$no="0".$no_next;
		}
		else
		{
			$no=$no_next;
		}
$nofaktur = $kodepuskesmas."/".$tahun."/".$no;
?>
	
<!--data barang-->
<div class="row">	
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="panel-title"><i class="fa fa-pencil"></i> Entry Barang</h4>
			</div>
			<div class="box-body">
				<form action="?page=uptd_gudang_pengeluaran_tambah_proses" method="post">
					<div class="table-responsive" style="font-size:12px">
						<table class="table table-hover table-condensed">
							<tbody>
								<tr>
									<td class="col-sm-2">No.Fatur</td>
									<td>:</td>
									<td class="col-sm-10">
										<input type="text" name="nofaktur" class="form-control" value="<?php echo $nofaktur;?>" readonly>
									</td>
								</tr>		
								<tr>
									<td class="col-sm-2">Tgl.Pengeluaran</td>
									<td>:</td>
									<td class="col-sm-10">
										<div class="input-group">
											<span class="input-group-addon tesdate">
												<span class="fa fa-calendar"></span>
											</span>
											<?php
												$tgle = explode("-",date ('Y-m-d'));
											?>
											<input type="text" name="tanggalpengeluaran" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>">
										</div>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Puskesmas</td>
									<td>:</td>
									<td class="col-sm-10">
										<input type="text" name="puskesmas" class="form-control puskesmas" placeholder="Ketikan Nama puskesmas" required>
										<input type="hidden" name="kodepuskesmas" class="form-control kodepuskesmas">
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Keterangan</td>
									<td>:</td>
									<td class="col-sm-4">
										<input  type="text" name="keterangan" class="form-control puyer" value="-">
									</td>
								</tr>
								<tr>
									<td class="col-sm-2"></td>
									<td></td>
									<td class="col-sm-4">
										<input type="submit" value="Simpan" class="btn btn-md btn-success">
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




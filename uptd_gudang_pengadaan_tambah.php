<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Entry Pengadaan <small>Gudang Obat UPTD</small></h1>
		</div>
	</div>
</div>

<?php
	$tahun=date('Y');
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$sql_cek="SELECT max(NoFaktur)as maxno from tbgudanguptdpengadaan WHERE substring(NoFaktur,1,11)='$kodepuskesmas' and substring(NoFaktur,13,4)= '$tahun'";
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
	$nopembukuan=$kodepuskesmas."/".$tahun."/".$no;
?>

<!--data barang-->
<div class="row">	
	<div class="col-lg-12">
		<form action="?page=uptd_gudang_pengadaan_tambah_proses" method="post">	
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title"><i class="fa fa-bars"></i> Pengadaan Barang</h4>
				</div>
				<div class="box-body">
					<div class="table-responsive" style="font-size:12px">
							<table class="table table-striped table-condensed">
								<tr>
									<td class="col-sm-2">No.Faktur</td>
									<td>:</td>
									<td class="col-sm-10">
										<input type="text" name="nomorfaktur" class="form-control" value="<?php echo $nopembukuan;?>" readonly>
									</td>
								</tr>		
								<tr>
									<td class="col-sm-2">Tgl.Pengadaan</td>
									<td>:</td>
									<td class="col-sm-10">
										<div class="input-group">
											<span class="input-group-addon tesdate">
												<span class="fa fa-calendar"></span>
											</span>
											<?php
												$tgle = explode("-",date ('Y-m-d'));
											?>
											<input type="text" name="tanggalpenerimaan" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>">
										</div>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Sumber Anggaran</td>
									<td>:</td>
									<td class="col-sm-10">
										<select name="sumberanggaran" class="form-control">
											<option value="-">--Pilih--</option>
											<option value="APBD PROV">APBD PROV</option>
											<option value="APBD KAB">APBD KAB</option>
											<option value="APBN">APBN</option>
											<option value="BLUD">BLUD</option>
											<option value="LAINNYA">LAINNYA</option>
										</select>								
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Tahun</td>
									<td>:</td>
									<td class="col-sm-10">
										<select name="tahunanggaran" class="form-control">
											<option value="-">--Pilih--</option>
											<option value="2015">2015</option>
											<option value="2016">2016</option>
											<option value="2017">2017</option>
											<option value="2018">2018</option>
											<option value="2019">2019</option>
											<option value="2020">2020</option>
										</select>								
									</td>
								</tr>
								<tr>
									<td class="col-sm-2"></td>
									<td></td>
									<td class="col-sm-4"><input type="submit" value="Simpan" class="btn btn-md btn-info"></td>
								</tr>
							</table>
						
					</div>
				</div>
			</div>
		</form>	
	</div>
</div>

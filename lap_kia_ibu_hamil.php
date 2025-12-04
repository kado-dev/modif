<?php
	// include "otoritas.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$tanggal = date('Y-m-d');
	$bulan = date('m');
	$tahun = date('Y');
?>
<style>
.printheader{
	margin-top:-30px;
	margin-left:px;
	margin-right:0px;
	text-align:center;
	display:none;
}
.printheader h4{
	font-size:12px;
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.printheader p{
	font-size:10px;
}
.printbody{
	margin-left:0px;
	margin-right:0px;
	display: none;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.atastabel{
	display:none;
	margin-top:10px;
}
.bawahtabel{
	margin-top:20px;
	margin-bottom:10px;
	margin-left:50px;
	display:none;
}

@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}
	.printbody{
		display:block;
	}
	.atastabel{
		display:block;
	}
	.bawahtabel{
		display:block;
	}
}
</style>

<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Laporan Ibu Hamil</h1>
		</div>
	</div>
</div>	

<!--cari pasien-->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="panel-title"><i class="fa fa-pencil"></i> Data Ibu Hamil</h4>
			</div>
			<div class="box-body">
				<div class="table-responsive" style="font-size:12px">
					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>No.</th>
								<th>Kode</th>
								<th>Puskesmas</th>
								<th>Jumlah</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php			 					
							$str = "select substring(NoRegistrasi,1,11) AS KodePuskesmas, COUNT(Noregistrasi) AS Jumlah from `tbpolikia` where MONTH(TanggalPeriksa)='$bulan' AND YEAR(TanggalPeriksa)='$tahun' GROUP BY KodePuskesmas order By jumlah DESC";
							$no = 0;
							$query = mysqli_query($koneksi,$str);
							while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$dt_puskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"select NamaPuskesmas from `tbpuskesmas` where KodePuskesmas = '$data[KodePuskesmas]'"));
							?>
								<tr>
									<td width="5%" align="right"><?php echo $no?></td>
									<td width="10%" align="center" class="kodepuskesmas"><?php echo $data['KodePuskesmas'];?></td>
									<td width="75%"><?php echo $dt_puskesmas['NamaPuskesmas'];?></td>
									<td width="5%" align="right"><?php echo $data['Jumlah'];?></td>
									<td width="5%">
										<button type="submit" class="btn btn-xs btn-info btnmodalpkmbumil">Lihat</button>
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
	</div>
</div>

<div class="hasilmodal"></div>
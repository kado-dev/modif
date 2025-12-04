<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DIAGNOSA NON SPESIALIS</b></h3>
			<a href="javascript:print()" class="btn btn-round btn-info" style="margin-top: 0px;">Print</a>
			<table class="table-judul">
				<thead>
					<tr>
						<th width="5%">NO.</th>
						<th width="15%">KODE DIAGNOSA</th>
						<th width="80%">NAMA DIAGNOSA</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$query = mysqli_query($koneksi,"select * from `tbdiagnosabpjs` WHERE NonSpesialis = 'true' order by `KodeDiagnosa`");
					$no = 0;
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo $data['KodeDiagnosa'];?></td>
							<td align="left" class="nama"><?php echo $data['Diagnosa'];?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>

	<!--tabel report-->
	<div class="printheader">
		<?php
		$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `KodePuskesmas` = '$kodepuskesmas'"));
		$kota1 = $datapuskesmas['Kota'];
		$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` where `Kota` = '$kota1'"));
		?>
		<br/>
		<?php 
		if($kodepuskesmas == 'semua'){
		?>
			<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
			<h4 style="margin:5px;"><b><?php echo $namapuskesmas;?></b></h4>
			<p style="margin:5px;"><?php echo $alamat;?></p>
		<?php
		}else{
		?>
			<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$datapuskesmas['Kota'];?></b></h4>
			<h4 style="margin:5px;"><b><?php echo $datadinas['NamaDinkes'];?></b></h4>
			<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$datapuskesmas['NamaPuskesmas'];?></b></h4>
			<p style="margin:5px;"><?php echo $datapuskesmas['Alamat']?></p>
		<?php	
		}
		?>
		<hr style="margin:3px; border:1px solid #000">
		<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN DIAGNOSA NONSPESIALIS</b></h4>
		<br/>
	</div>

	<div class="row printbody">
		<div class="col-lg-12">
			<table class="table table-condensed" >
				<thead style="font-size:12px;">
					<tr style="border:1px dashed #000;" >
						<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
						<th width="15%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">Kode</th>
						<th width="1000" rowspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">Diagnosa</th>
					</tr>
				</thead>
				
				<tbody style="font-size:12px;">				
					<?php
						$query = mysqli_query($koneksi,"select * from `tbdiagnosabpjs` WHERE NonSpesialis = 'true' order by `KodeDiagnosa`");
						$no = 0;
						while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
					?>
						<tr style="border:1px dashed #000;">
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['KodeDiagnosa'];?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['Diagnosa'];?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
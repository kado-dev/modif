<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DIAGNOSA KEPERAWATAN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="master_diagnosa_keperawatan"/>
						<div class="col-xl-4">
							<input type="text" name="key" class="form-control key" placeholder="Ketikan Nama Diagnosa" value="<?php echo $_GET['key'];?>">
						</div>
						<div class="col-xl-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=master_diagnosa_keperawatan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="master_diagnosa_keperawatan_excel.php?key=<?php echo $_GET['key'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>		
				</form>
			</div>
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
					$no = 0;
					$key = $_GET['key'];
					$strdiagnosa = "SELECT * FROM `tbdiagnosakeperawatan` WHERE `NamaDiagnosa` like '%$key%' ORDER BY `KodeDiagnosa` ";
					// echo $strdiagnosa;
					$query = mysqli_query($koneksi, $strdiagnosa);
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo $data['KodeDiagnosa'];?></td>
							<td class="nama"><?php echo strtoupper($data['NamaDiagnosa']);?></td>
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
		<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
		<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN";?></b></h4>
		<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
		<p style="margin:5px;"><?php echo $alamat?></p>
		<hr style="margin:3px; border:1px solid #000">
		<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN DIAGNOSA KEPERAWATAN</b></h4>
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
						$query = mysqli_query($koneksi,"SELECT * FROM `tbdiagnosakeperawatan` ORDER BY `KodeDiagnosa`");
						$no = 0;
						while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
					?>
						<tr style="border:1px dashed #000;">
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['KodeDiagnosa'];?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['NamaDiagnosa'];?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
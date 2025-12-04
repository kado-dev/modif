<div class="modal-body">
	<table class="table-judul">
		<thead>
			<tr>
				<th width='5%'>No.</th>
				<th width='55%'>Keterangan</th>
				<th width='20%'>Status</th>
				<th width='10%'>Tarif</th>
				<th width='10%'>#</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				include "config/koneksi.php";
				include "config/helper.php";				
				$namapuskesmas = $_POST['pkm'];
				$noreg = $_POST['noreg'];
				$idpasienrj = $_POST['idprj'];
				$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
			
				// retribusi karcis
				$dtpasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj`='$idpasienrj'"));
				$asuransi = $dtpasienrj['Asuransi'];
				$karcis = $dtpasienrj['TarifKarcis'];
				$kir = $dtpasienrj['Kir'];
				
			?>
			
			<tr>
				<td style="text-align:center;">1</td>
				<td>Retribusi Pendaftaran</td>
				<td>Proses</td>
				<td align="right"><?php echo rupiah($karcis);?></td>
				<td align="center">
					<a href='#' class='btn btn-danger btn-xs deltindakan' data-idtindakan='<?php echo $data['IdTindakan'];?>'>HAPUS</a>
				</td>
			</tr>
			<?php if($kir != ''){ ?>
			<tr>
				<td style="text-align:center;">1</td>
				<td>Retribusi Kir</td>
				<td>Proses</td>
				<td align="right"><?php echo rupiah($kir);?></td>
				<td align="center">
					<a href='#' class='btn btn-danger btn-xs deltindakan' data-idtindakan='<?php echo $data['IdTindakan'];?>'>HAPUS</a>
				</td>
			</tr>
			<?php } ?>
			
			<?php
				// tbtindakanpasien
				$tbtindakanpasien = "tbtindakanpasien_".str_replace(' ', '', $namapuskesmas);
				$data_tindakan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbtindakanpasien` WHERE `NoRegistrasi`='$noreg'"));
				$tindakan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbtindakan` WHERE `IdTindakan`='$data_tindakan[IdTindakan]'"));
				$total_retribusi = $karcis + $kir + $data_tindakan['Tarif'];
				
				if($data_tindakan['IdTindakanPasienDetail'] != ""){
			?>
			<tr>
				<td style="text-align:center;">2</td>
				<td><?php echo strtoupper($tindakan['Tindakan']);?></td>
				<td>Proses</td>
				<td align="right"><?php echo rupiah($data_tindakan['Tarif']);?></td>
				<td align="center">
					<a href='#' class='btn btn-danger btn-xs deltindakan' data-idtindakan='<?php echo $data['IdTindakan'];?>'>HAPUS</a>
				</td>
			</tr>
			<?php } ?>
			
			<?php	
			$no = 1;
			$s_tind = "SELECT a.IdTindakan,b.IdTindakan, b.JenisTindakan, b.Tarif, b.status FROM tbtindakanpasiendetail a JOIN tbtindakan b on a.IdTindakan = b.IdTindakan WHERE a.NoRegistrasi = '$noreg'";
			$query = mysqli_query($koneksi,$s_tind);
			while($data = mysqli_fetch_assoc($query)){
				$no = $no + 1;
			?>	
			<tr>
				<td style="text-align:center;"><?php echo $no;?></td>
				<td><?php echo $data['JenisTindakan'];?></td>
				<td><?php echo $data['status'];?></td>
				<td align="right"><?php echo rupiah($data['Tarif']);?></td>
				<td align="center">
					<a href='#' class='btn btn-danger btn-xs deltindakan' data-idtindakan='<?php echo $data['IdTindakan'];?>'>HAPUS</a>
				</td>
			</tr>
			<?php
			}						
			?>
			<tr>
				<td colspan="3" style="text-align: center;font-weight: bold">TOTAL</td>
				<td style="font-weight: bold" align="right">
					<?php echo rupiah($total_retribusi);?>
				</td>
			</tr>
		</tbody>
	</table>  		      
</div>
<div class="modal-footer">
	<input type="hidden" class="noregmodal" value="<?php echo $noreg;?>"/>  
	<a href="get_tindakan_pasien_print.php?noreg=<?php echo $noreg;?>&idprj=<?php echo $idpasienrj;?>" class="btn btn-success btnprint">PRINT & BAYAR</a>     
	<!--<button type="button" class="btn btn-primary btnbayar">BAYAR</button>-->
	<button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
</div>
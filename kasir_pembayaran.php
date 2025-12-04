<?php
$hariini = date('Y-m-d');
if($_GET['sts'] == 'update'){
	session_start();
	include "config/koneksi.php";
	$idpasienrj = $_POST['idprj'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbpasienrj = "tbpasienrj_".$kodepuskesmas;
	$tbtindakanpasien = "tbtindakanpasien_".str_replace(' ', '', $namapuskesmas);	
	
	mysqli_query($koneksi, "Update $tbpasienrj SET StatusBayar = 'Y' WHERE `IdPasienrj` = '$idpasienrj'");
	mysqli_query($koneksi, "Update $tbtindakanpasien SET StatusBayar = 'Y' WHERE `IdPasienrj` = '$idpasienrj'");
}else if($_GET['sts'] == 'deltindakan'){
	session_start();
	include "config/koneksi.php";
	$idtindakan = $_POST['idtindakan'];

	mysqli_query($koneksi, "DELETE FROM tbtindakanpasiendetail WHERE `IdTindakan` = '$idtindakan'");
}else{
	$tglreg1 = $_GET['tglreg1'];
	if($tglreg1 == null){
		$tglreg1 = date('Y-m-d');
	}
	$key = $_GET['key'];
	
?>	

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive"><br/>
			<h3 class="judul">KASIR</h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input name="page" type="hidden" value="kasir_pembayaran">
						<div class="col-xl-2">
							<input name="tglreg1" type="date" class="form-control" value="<?php echo $tglreg1;?>">
						</div>
						<div class="col-xl-2">
							<input name="key" type="text" placeholder="Ketik nama pasien" class="form-control" value="<?php echo $key;?>">
						</div>
						<div class="col-xl-2">
							<select name="pelayanan" class="form-control" required>
								<option value="Semua">Semua</option>
								<?php
								$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` WHERE JenisPelayanan = 'KUNJUNGAN SAKIT' order by `Pelayanan`");
									while($data = mysqli_fetch_assoc($query)){
										if($data['Pelayanan'] == $_SESSION['poliantrian']){
											echo "<option value='$data[Pelayanan]' SELECTED>$data[Pelayanan]</option>";
										}else{
											echo "<option value='$data[Pelayanan]'>$data[Pelayanan]</option>";
										}
									}
								?>
							</select>
						</div>
						<div class="col-xl-6">	
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=kasir_pembayaran" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>
	<table class="table-judul" id="">
		<thead>
			<tr>
				<th width='5%'>NO.</th>
				<th width='15%'>TGL.DAFTAR</th>
				<th width='35%'>NAMA PASIEN</th>
				<th width='10%'>PELAYANAN</th>
				<th width='10%'>CARA BAYAR</th>
				<th width='5%'>TARIF</th>
				<th width='10%'>STS.BAYAR</th>
				<th width='10%'>#</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			
			if($_GET['tglreg1']==''){
				$caritanggal = " AND date(TanggalRegistrasi) = '$hariini'"; 
			}else{
				$caritanggal = " AND date(TanggalRegistrasi) = '$_GET[tglreg1]'";
			}	

			if($_GET['key']==''){
				$carinama = ""; 
			}else{
				$carinama = " AND NamaPasien LIKE '%$key%'";
			}
			
			if($_GET['pelayanan'] == 'Semua' || $_GET['pelayanan'] == ""){
				$pelayanan = ""; 
			}else{
				$pelayanan = " AND PoliPertama = '$_GET[pelayanan]'";
			}
			
			$s_karcis = "SELECT * FROM `$tbpasienrj` WHERE `AsalPasien` = '10' AND (`PoliPertama`!='KONSELING' AND `PoliPertama`!='PENYULUHAN')".$caritanggal.$carinama.$pelayanan;
			$str2 = $s_karcis." ORDER BY `IdPasienrj` DESC";
			// echo $str2;
				
			$no = 0;
			$query = mysqli_query($koneksi,$str2);
			while($dt_karcis = mysqli_fetch_assoc($query)){
				$no = $no + 1;
				$idpasienrj = $dt_karcis['IdPasienrj'];
				$noregistrasi = $dt_karcis['NoRegistrasi'];
				$namapasien = strtoupper($dt_karcis['NamaPasien']);
				$polipertama = $dt_karcis['PoliPertama'];
				$asuransi = $dt_karcis['Asuransi'];
				$waktu = $dt_karcis['TanggalRegistrasi'];

				//get tarif dan status di tagihan
				$getTarifStat = mysqli_query($koneksi,"SELECT b.StatusBayar, SUM(b.SubTotal) as totaltarif FROM tbtagihan a JOIN tbtagihan_detail b ON a.IdTagihan = b.IdTagihan WHERE a.IdPasienrj = '$idpasienrj'");
				$statusBayar = '0';
				$tarif_total = '0';
				if(mysqli_num_rows($getTarifStat) > 0){
					$dttars = mysqli_fetch_assoc($getTarifStat);

					$statusBayar = $dttars['StatusBayar'];
					$tarif_total = $dttars['totaltarif'];
				}
				//$status = $dt_karcis['StatusBayar'];

				// $tarif_karcis = $dt_karcis['TarifKarcis'];
				// $tarif_kir = $dt_karcis['TarifKir'];
				// $tarif_tindakan = $dt_karcis['TarifTindakan'];
				// $tarif_total = $tarif_karcis + $tarif_kir + $tarif_tindakan;
			?>	
			<tr>
				<td align="center"><?php echo $no;?></td>
				<td align="left"><?php echo $waktu;?></td>
				<td align="left">
					<?php 
						echo $namapasien;
						// cek tindakan
						$tbtindakanpasien = "tbtindakanpasien_".str_replace(' ', '', $namapuskesmas);
						$cektindakan = mysqli_num_rows(mysqli_query($koneksi, "SELECT `IdTindakanPasienDetail` FROM `$tbtindakanpasien` WHERE `IdPasienrj`='$idpasienrj'"));
						if($cektindakan > 0){
					?>
						<span class="badge badge-warning" style='font-size:12px; font-style: italic; padding: 6px;'><?php echo "Tindakan";?></span>
					<?php 
						}
					?>
				</td>
				<td align="left"><?php echo str_replace('POLI ','',$polipertama);?></td>
				<td align="left"><?php echo $asuransi;?></td>
				<td align="right"><?php echo rupiah($tarif_total);?></td>
				<td align="center" class="statusbayar" data-urutan="<?php echo str_replace("/", "", $noregistrasi);?>">
					<?php 
						$sta = ($statusBayar == '1') ? 'Lunas' : 'Proses';
						echo $sta;
					?>
				</td>
				<td style="text-align:center;">
					<?php if($statusBayar != '1'){ ?>
					<button class="btn btn-round btn-info btnaksi" data-noreg="<?php echo $noregistrasi;?>" data-pkm="<?php echo $namapuskesmas;?>" data-idprj="<?php echo $idpasienrj;?>">Lihat</button>
					<?php }else{ ?>
					<a href="get_tindakan_pasien_print.php?idprj=<?php echo $idpasienrj;?>" class="btn btn-round btn-success">e-KWITANSI</a>
					<?php } ?>
				</td>
			</tr>
			<?php
				// }
			}						
			?>
		</tbody>
	</table>
</div>
<div class="modal" id="modalkarcis" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Tindakan</h5>
      </div>
      <div class="detailtindakan"></div>
    </div>
  </div>
</div>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>
	$(".btnaksi").click(function(){
		var noreg = $(this).data("noreg");
		var pkm = $(this).data("pkm");
		var idprj = $(this).data("idprj");
		//$(".noregmodal").val(noreg);
		// alert(idprj);
		$.post( "get_tindakan_pasien.php", {noreg: noreg, pkm: pkm, idprj: idprj}).done(function( data ) {
				$(".detailtindakan").html(data);
			});
		$("#modalkarcis").modal('show');
	});

	$(document).on("click",".btnbayar",function(){	
		var conf = confirm("Data ingin diproses...");
		if(conf){			
			var noreg = $(".noregmodal").val();
			var lokasi = $("[data-urutan="+noreg.split("/").join("")+"]");
			$.post( "kasir_pembayaran.php?sts=update", {noreg: noreg}).done(function( data ) {				
				$("#modalkarcis").modal('hide');
			});
			lokasi.html("Lunas");
		}
	});	

	$(document).on("click",".deltindakan",function(){
		var conf = confirm("Anda yakin data dihapus!");
		if(conf){
			var lokasi = $(this).parent().parent();
			var idtindakan = $(this).data("idtindakan");
			$.post( "kasir_pembayaran.php?sts=deltindakan", {idtindakan: idtindakan}).done(function( data ) {
				lokasi.remove();
			});
		}
	});	
</script>
<?php
}
?>			
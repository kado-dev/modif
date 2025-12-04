<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	$noantrian = $_GET['noa'];
	$time = date('Y-m-d G:i:s');
	$poli = $_GET['poli'];

	$sts = $_GET['sts'];
	if($sts == 'selesai'){
		$noreg = $_POST['noreg'];
		//update sts
		mysqli_query($koneksi,"UPDATE $tbpasienrj SET `StatusAntrianPoli` = 'Y' WHERE NoRegistrasi = '$noreg'");

		//update view(hapus)
		$viewpoli = $_POST['clview'];
		mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `Display` = '', Waktu = '$time' WHERE KodePuskesmas = '$kodepuskesmas' AND Pelayanan = '$viewpoli'");
		echo "selesai";
	}else{
		$qry = mysqli_query($koneksi, "Select `NamaPasien`,`Asuransi`,`PoliPertama`,`NoRegistrasi`,`NoAntrianPoli`,`dokterBpjs` from `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = CURDATE() AND NoAntrianPoli = '$noantrian' AND `StatusAntrianPoli` = 'N'");
		$dt = mysqli_fetch_array($qry);

		// insert view
		$dtpoli = $dt['PoliPertama'];
		if($dtpoli == 'POLI ANAK'){
			$viewpoli = 'ANAK';
		}else if($dtpoli == 'POLI MTBS'){
			$viewpoli = 'MTBS';	
		}else if($dtpoli == 'POLI GIGI'){
			$viewpoli = 'GIGI';
		}else if($dtpoli == 'POLI LANSIA'){
			$viewpoli = 'LANSIA';
		}else if($dtpoli == 'POLI UMUM'){
			$viewpoli = 'UMUM';
		}else if($dtpoli == 'POLI KIA' or $dtpoli == 'POLI KB'){
			$viewpoli = 'KIA KB';
		}else if($dtpoli == 'POLI IMUNISASI'){
			$viewpoli = 'IMUNISASI';
		}else if($dtpoli == 'POLI TB'){
			$viewpoli = 'TB DOTS';
		}else if($dtpoli == 'POLI UGD'){
			$viewpoli = 'UGD';			
		}
		$dokterbpjs = $dt['dokterBpjs'];
		mysqli_query($koneksi, "UPDATE `tbantrian_pelayanan` SET `Display` = '$noantrian', `dokterBpjs` = '$dokterbpjs', Waktu = '$time' WHERE `kodepuskesmas` = '$kodepuskesmas' AND Pelayanan = '$viewpoli'");
		//echo "UPDATE tbantrian_view SET $viewpoli = '$noantrian' where kodepuskesmas = '$kodepuskesmas' ";
?>

<style>
	td li{
		list-style:none;
		cursor:pointer;
		padding:5px;
		border-bottom:1px solid #ddd;
	}
	td li:last-child{
		border-bottom:none;
	}
	.btnantrian{
		background:#ddd;
		color:#545454;
		padding:8px 10px;
		border-radius:3px;
		margin-left:15px;
		border:none;
	}
	.btns{
		border-radius:6px;
	}
	.tbl tr td{
		padding: 5px 5px;
	}
</style>
<div class="modal fade noprint" id="Modalantrian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">PANGGIL ANTRIAN</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<input type="hidden" class="idantrian" value="<?php echo $dt['NoRegistrasi']?>">
				<h3 style="text-align:center;margin:0px;background-color: #c0edc3;padding:10px;border:1px solid #59bd60">
					<!--<span style="font-size:18px">Nomor Antrian</span><br/>-->
					<span style="font-size:39px" class="viewantrian"><?php echo $dt['NoAntrianPoli']?></span>
				</h3>
				<div class="row">	
					<div class="col-md-12" style="padding: 5px 25px">
						<table class="tbl" width="250px">
							<tr>
								<td width="85px">Nama</td>
								<td width="10px">:</td>
								<td><?php echo $dt['NamaPasien'];?></td>
							</tr>
							<tr>
								<td width="85px">Jaminan</td>
								<td width="10px">:</td>
								<td><?php echo $dt['Asuransi'];?></td>
							</tr>
						</table>
					</div>				
					<div class="col-md-12">
						<a href="#" class="btn btn-primary btn-block selesaibtn btns" data-noreg="<?php echo $dt['NoRegistrasi'];?>" data-clview="<?php echo $viewpoli;?>">Selesai</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>	
	$(".selesaibtn").click(function(){
		var clview = $(this).data('clview');
		var noreg = $(this).data('noreg');
		$.post( "get_modal_panggil_antrian_poli.php?sts=selesai", { clview: clview, noreg: noreg}).done(function( data ) {
			//alert(data);
			if(data == 'selesai'){
				document.location.href='index.php?page=poli&pelayanan=<?php echo $poli;?>';
			}else{
				alert('error');				
			}
		});
	});	
</script>
<?php 
	}	
?>
<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	$id = $_POST['id'];	
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
	
	// tbpasien
	$strps = "SELECT a.NoIndex, a.NamaPasien, a.TanggalLahir, a.NoCM, a.JenisKelamin, b.Alamat 
	FROM `$tbpasien` a JOIN `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.`NoCM` = '$id'";
	$queryps = mysqli_query($koneksi,$strps);
	$data = mysqli_fetch_assoc($queryps);
	$kartu = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbkartupasien` WHERE `KodePuskesmas` = '$kodepuskesmas'"));

?>

<!--untuk menampilkan modal-->
<div class="modal fade" id="modalkartupasien" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Kartu Pasien</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="kartu">
					<?php if($kartu['Image'] != ''){?>
						<img src="image/kartupasien/<?php echo $kartu['Image'];?>" class="clsbgkartu">
					<?php }?>
					<p class="tbnama">
						<?php echo $data['NamaPasien'];?><br/>
						<?php echo tgl_lengkap($data['TanggalLahir']);?>
					<p>	
					</table>
					<div class="tbbarcode">	
						<img id="barcode1" width="170px" height="35px"/>
						<script>
						JsBarcode("#barcode1", "<?php echo substr($data['NoIndex'],-10);?>",{
							format: "CODE128",
							width:3,
							height:45,
							displayValue: true, 
							fontSize: 26,
							fontOptions: "bold"
						});
						</script>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="javascript:print()" type="button" class="btn btn-round btn-primary">Cetak</a>
				<button type="button" class="btn btn-round btn-danger" data-dismiss="modal">Keluar</button>
			</div>
		</div>
	</div>
</div>

<style>
	.kartu{
		padding:0px;
		width:487px;
		height:310px;
	}
	.clsbgkartu{
		position:absolute;
		top:0px;
		z-index:1;
		width:487px;
		height:310px;
	}	
	.tbnama{
		position:absolute;
		top:200px;
		left:50px;
		z-index:10000;
		font-weight:bold;
		font-size:16px;
		color:#000;
		font-family: "Roboto Condensed", Arial, sans-serif;
		margin-top: -3px;
		line-height: 15px;
	}
	.tbbarcode{
		background:#fff;
		position:absolute;
		top:230px;
		left:47px;
		z-index:10000;
		font-weight:bold;
		font-size:15px;
		color:#000;
		font-family:century gothic;
	}
	@media print{
		@page {     margin: 0 !important; }
		html,body{			
    		overflow: hidden;
			visibility: hidden;
			width: 9cm;
			height: 5cm;
		}
		.kartu{
			visibility: visible;
			position: fixed;
			top: -10px;
			left: -10px;
			width: 9cm;
			height: 5cm;
		}
		.clsbgkartu{
			/** visibility:hidden; **/
			// width: 9cm;
			// height: 5.6cm;
			width:487px;
			height:213px;
		}
		.tbnama{
			visibility: visible;
			top:138px;
			left:25px;
			font-size : 10px;
			line-height: 10px;
			font-family: "Roboto Condensed", Arial, sans-serif;
		}
		.tbbarcode{
			visibility: visible;
			top:155px;
			left:22px;
			width: 4cm;
			height: 0.4cm;
		}
	}
</style>

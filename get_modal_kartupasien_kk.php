<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	$id = $_POST['id'];	
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	
	// tbkk
	$strps = "SELECT * FROM `$tbkk` WHERE `NoIndex` = '$id'";
	$queryps = mysqli_query($koneksi,$strps);
	$data = mysqli_fetch_assoc($queryps);
	$kartu = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbkartupasien` WHERE KodePuskesmas = '$kodepuskesmas'"));
	
	// ec_subdistricts
	$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$data[Kelurahan]'"));
										
	// ec_districts
	$dt_districts = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `dis_name` FROM `ec_districts` WHERE `dis_id`='$data[Kecamatan]'"));
?>

<!--untuk menampilkan modal-->
<div class="modal fade" id="modalkartupasienkk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Kartu Pasien</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div class="kartu">
					<?php if($kartu['Image'] != ''){?>
						<img src="image/kartupasien/<?php echo $kartu['Image'];?>" class="clsbgkartu">
					<?php }?>
					<p class="tbnama">
						<?php echo $data['NamaKK'];?><br/>
					<p>	
					<p class="tbalamat">
						<?php 
							echo $data['Alamat'].", RT.".$data['RT'].", RW.".$data['RW']."<br/> Ds.".$dt_subdis['subdis_name']." Kec.".$dt_districts['dis_name'];
						?>
					<p>	
					</table>
					<div class="tbbarcode">	
						<img id="barcode1" width="170px" height="30px"/>
						<script>
						JsBarcode("#barcode1", "<?php echo substr($data['NoIndex'],-10);?>",{
							format: "CODE128",
							width:3,
							height:40,
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
		top:195px;
		left:50px;
		z-index:10000;
		font-weight:bold;
		font-size:16px;
		color:#000;
		font-family:malgun gothic;
		margin-top: -3px;
		line-height: 17px;
	}
	.tbalamat{
		position:absolute;
		top:213px;
		left:50px;
		z-index:10000;
		font-weight:bold;
		font-size:12px;
		color:#000;
		font-family:malgun gothic;
		margin-top: -3px;
		line-height: 12px;
	}
	.tbbarcode{
		background:#fff;
		position:absolute;
		top:235px;
		left:47px;
		z-index:10000;
		font-weight:bold;
		font-size:22px;
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
			width: 9cm;
			height: 5.6cm;
		}
		.tbnama{
			position: fixed;
			top:120px;
			left:15px;
			font-size : 10px;
			font-family : malgun gothic;
		}
		.tbalamat{
			position: fixed;
			top:135px;
			left:15px;
			font-size : 7px;
			font-family : malgun gothic;
			line-height: 7px;
		}
		.tbbarcode{
			visibility: visible;
			position: fixed;
			top:146px;
			left:12px;
			width: 4cm;
			
			// visibility: visible;
			// top:4cm;
			// left:0.6cm;
			// width: 3cm;
			// height: 0.4cm;
		}
	}
</style>

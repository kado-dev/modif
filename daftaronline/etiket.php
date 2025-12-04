<style>
	/**
	.btnlengkung{
		border-radius:20px;
	}
	.bggreen{
		background:green;
		padding:15px 40px;
		min-height:650px;
	}
	**/
	.qrcodes{
		padding:20px;box-shadow: 0px 0px 10px #ccc;border-radius: 10px;margin:10px;width: 12vw;margin: auto;margin-bottom: 20px;margin-top: 20px
	}
	.etiket{
		font-size: 1.8vw;
	}
	.nomorantrian{
		font-size: 2.4vw;
		font-weight: bold;
	}
	.nama{
		font-size: 1.6vw;
	}
	.nik{
		font-size: 1.5vw;
	}

	.alertt{
		font-size:16px;width:42vw;margin:auto;margin-top: 20px;text-align: center;color:#000
	}
	@media (max-width: 576px) {
		.qrcodes{
			padding:20px;box-shadow: 0px 0px 10px #ccc;border-radius: 10px;margin:10px;width: 32vw;margin: auto;margin-bottom: 20px;margin-top: 20px
		}
		.etiket{
			font-size: 3.8vw;
		}
		.nomorantrian{
			font-size: 4.5vw;margin-bottom: 5vh
		}
		.nama{
			font-size: 3.5vw;margin-bottom: 5vh
		}
		.nik{
			font-size: 3.2vw;
		}

		.alertt{
			font-size:14px;width:72vw;margin:auto;margin-top: 20px;text-align: center;color:#000
		}
	}
</style>
<?php
	$id = $_GET['id'];
	$kode = $_GET['kode'];
	$simpus = $_GET['simpus'];
	$tbpasienonline = "tbpasienonline_".$kode;
	$str1 = "SELECT * FROM `$tbpasienonline` WHERE `IdPasienOnline` = '$id'";
	$query = mysqli_query($koneksi, $str1);
	$data = mysqli_fetch_assoc($query);

	$tbantrian_pasien = "tbantrian_pasien_".$data['KodePuskesmas'];
	$dtantrianpasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT EstimasiWaktu FROM `$tbantrian_pasien` WHERE IdPasienOnline = '$id'"));
	// untuk reload pilih poli melalui antrian setting
	mysqli_query($koneksi, "UPDATE tbantrian_setting SET Waktu = CURRENT_TIMESTAMP() WHERE `KodePuskesmas` = '$data[KodePuskesmas]'");
	
	// kode pelayanan antrian
	$poli = str_replace('POLI ','', $data['PoliPertama']);
	$kodeantrian = mysqli_fetch_assoc(mysqli_query($koneksi , "SELECT * FROM `tbantrian_pelayanan` WHERE `Pelayanan` = '$poli' AND `KodePuskesmas` ='$data[KodePuskesmas]'"));
	$nomor_antrian_poli2 =  $kodeantrian['KodePelayanan'].$data['NomorAntrianPoli'];

	// tbantrian_setting
	$dtantrianset =  mysqli_fetch_assoc(mysqli_query($koneksi , "SELECT `TampilNoAntrian` FROM `tbantrian_setting` WHERE `KodePuskesmas` = '$data[KodePuskesmas]'"));
?>
<script src="../assets/js/qrcode.min.js?4"></script>

		<div class="kolomkonten2" style="padding: 20px;background: #fff" id="MyHTMLCODE">
		<?php
		if(mysqli_num_rows($query) == '0'){
			echo "<div class='alert alert-info'>Anda belum terdaftar sebagai pasien di puskesmas.</div>";
		}else{
		?>
		<h3 class="etiket" style="text-align:center">ETIKET PENDAFTARAN ONLINE</h3>
		<h3 class="etiket" style="text-align:center"><?php echo $_GET['simpus'];?></h3>
		<div class="qrcodes">
			<div id="qrcode" style="padding:6px 0px; width: 80px; margin:auto"></div>
		</div>
			<h3 style="margin:0px;text-align:center;" class="nomorantrian"><?php echo $nomor_antrian_poli2;?></h3>
			<h3 style="margin:0px;text-align:center;" class="nama"><?php echo $data['NamaPasien'];?></h3>
			<h3 style="margin:0px;text-align:center;" class="nik">
				<?php 
					if($data['Nik'] == '0'){
						echo "";
					}else{	
						echo $data['Nik'];
					}	
				?>
			</h4>
			<h3 style="margin:0px;text-align:center;">
				<?php 
					// if($dtantrianset['TampilNoAntrian'] == "Y"){
						echo "No.Pendaftaran : ".$data['NomorAntrian'];
					// }
				?>
			</h3>
		<div class='alert alert-success alertt'>
			Estimasi waktu antrian <?php echo date('d-m-Y H:i:s',strtotime($dtantrianpasien['EstimasiWaktu'])); ?><br/>Silahkan datang lebih awal
		</div>
		<script type="text/javascript">		

		var qrcode = new QRCode(document.getElementById("qrcode"), {
			width : 80,
			height : 80
		});
		var elText = "<?php echo $data['IdPasienOnline'];?>";
		qrcode.makeCode(elText);
 
		</script>		
		<?php
			}
		?>
			
		</div>
		
		<div class="kolomkonten2" style="text-align: center;">
				<a href="?page=cari&kode=<?php echo $kode;?>&simpus=<?php echo $simpus;?>" class="btn btn-primary btn-lg btns">KEMBALI</a>
				<a href="#" download="doc_antrian.jpeg" class="btn btn-success btn-lg btns" id="btnSave">DOWNLOAD</a>
		</div>
<canvas id="canvas"></canvas>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script type="text/javascript">
 
html2canvas($('#MyHTMLCODE'), {
    onrendered: function(canvas) {
        //$('#canvas').replaceWith(canvas);//kalau mau ditampilkan imgnya
        //$('#MyHTMLCODE').hide();
        $('#btnSave').attr('href',canvas.toDataURL("image/jpeg"));
    },
    //width: 200,
    //height: 200
});

</script>	

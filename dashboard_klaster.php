<!doctype html>
<html lang="en">
<head>
	<style>	
	.kotak_panels{
		padding: 25px 20px;
		border-radius: 6px;
		margin-top: 15px;
		margin-bottom: 15px;
	}
	.bg{
		background: linear-gradient(0deg, rgba(178, 212, 255, 0.7), rgba(255, 255, 255, 0.9));
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
		box-shadow: 0 5px 10px -5px #848484;
	}
	.kotak_panels i{
		color: #f5f5f5;
		border:7px solid #f2f2f2;
		padding:5px 8px;
		border-radius: 50%;
	}
	.kotak_panels .ket{
		font-size: 14px;color: #f9f9f9;
		position: absolute;
		top:65px;
		left:120px;
	}
	.greens{
		background: linear-gradient(0deg, rgba(28, 126, 255, 0.9), rgba(0, 87, 201, 0.9));
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
		box-shadow: 0 5px 10px -5px #848484;
	}
	.divscroll{
		background: #f3f3f3;
		margin: 10px 4px;
		box-shadow:0px 0px 12px #9e9e9e;
		overflow: auto;
	}
	.kotak_panel_detail{
		width: 100%;
		background: #fff;
		margin-top: 0px;	
	}
	.kotak_panel_detail tr td{
		padding: 4px 10px;font-size: 13px;
	}
	.kotak_panel_detail tr:first-child td{
		padding-top: 10px;
	}
	.kotak_panel_detail tr:last-child td{
		padding-bottom: 15px;
	}
	.kotak_panel_detail tr td:first-child{font-weight: bold;vertical-align: bottom; }
	.kotak_panel_detail tr td:last-child{color: #454545;}
	.kotak_panel_detail tr td p{
		text-align: right;
	}
	.progress{
		margin-bottom: 0px;height: 12px
	}
	.fontpanel{
		font-size: 30px;
		position: absolute;
		top:10px;
		left:120px;
		color: #fff;
		font-weight: bold;
		margin-top: 15px;
	}
	.panel_update{
		padding:38px 20px;text-align: left;font-weight: normal;font-size: 22px;
		margin-bottom: 0px;border-radius: 10px 10px 0px 0px;margin-top: 20px;color: #fff;
		background: linear-gradient(0deg, rgba(49, 89, 253, 0.9), rgba(49, 89, 253, 0.9)), url('image/bg-title-01.jpg');
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
	}
	.update_list{
		border-bottom: 1px solid #eee;
		padding: 22px 30px;background: #fff;
	}
	.update_list:hover{
		background: #f9f9f9;
	}
	.update_list.biru{
		border-left:4px solid #009ac8;
	}
	.update_list.kuning{
		border-left:4px solid #ffe66b;
	}
	.update_list.merah{
		border-left:4px solid #ff6696;
	}
	.update_list.ijo{
		border-left:4px solid #40a05e;
	}
	.update_list p{
		margin-bottom: 0px;font-size: 14px;color:#545454;
	}
	.update_list span{
		font-size: 16px; font-weight: bold;
	}
	.widget-header{
		margin-bottom: 10px
	}
	.panel_informasi{
		padding:38px 20px;text-align: left;font-weight: normal;font-size: 22px;
		margin-bottom: 0px;border-radius: 10px 10px 0px 0px;margin-top: 20px;color: #fff;
		background: linear-gradient(0deg, rgba(219, 52, 55, 0.8), rgba(219, 52, 55, 0.8)), url('image/bg-title-02.jpg');
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
	}
	.panel_jadwal{
		padding:38px 20px;text-align: left;font-weight: normal;font-size: 22px;
		margin-bottom: 0px;border-radius: 10px 10px 0px 0px;margin-top: 20px;color: #fff;
		background: linear-gradient(0deg, rgba(77, 158, 55, 0.8), rgba(77, 158, 55, 0.8)), url('image/bg-title-02.jpg');
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
	}
	.kolom_warning{
		background: #edc9c9;
		border-radius: 8px;
		padding: 12px 12px;
		margin-bottom: 10px;
		font-size: 16px;
	}
	.kolom_danger{
		background: #fbff3f;
		border-radius: 8px;
		padding: 12px 12px;
		margin-bottom: 10px;
		font-size: 16px;
		-webkit-animation: myanimation 1s infinite;  /* Safari 4+ */
		  -moz-animation: myanimation 1s infinite;  /* Fx 5+ */
		  -o-animation: myanimation 1s infinite;  /* Opera 12+ */
		  animation: myanimation 1s infinite;
	}
	@-webkit-keyframes myanimation {
	  0%, 49% {
	    background: #fff;
	  }
	  50%, 100% {
	    background: #fbff3f;
	  }
	}
	</style>
</head>
<body>
<?php
	session_start();
	error_reporting(1);

	date_default_timezone_set('Asia/Jakarta');
	include "config/helper_pasienrj.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kodeppk = $_SESSION['kodeppk'];
	$kota = $_SESSION['kota'];
	
	
	if($_GET['bulan'] == null){
		$bln = date('m');
	}else{
		$bln = $_GET['bulan'];
	}	

    if($_GET['tahun'] == null){
		$thn = date('Y');
	}else{
		$thn = $_GET['tahun'];
	}	
	
	
    $strfilterklaster = "";
    if($_GET['klaster'] != null && $_GET['siklushidup'] != null){
        $strfilterklaster = " AND b.Klaster = '$_GET[klaster]' AND b.SiklusHidup = '$_GET[siklushidup]'";
    }

?>

<div class="tableborderdiv">
	<!--grafik kasir-->
	<div class="row noprint" style="margin-top: -20px;">
		<div class="col-sm-12">
			<div class="kotak_panels bg">
                <h3 class="text-black fw-bold">Grafik Skrining ILP</h3>
                <form class="formcari">
				<div class="row noprint">
                    
					<div class="col-sm-2">	
                        <input type="hidden" name="page" value="dashboard_klaster"/>
                        <select name="bulan" class="form-control" onchange="this.form.submit();" >
                            <option value="01" <?php if($bln == '01'){echo "SELECTED";}?>>Januari</option>
                            <option value="02" <?php if($bln == '02'){echo "SELECTED";}?>>Februari</option>
                            <option value="03" <?php if($bln == '03'){echo "SELECTED";}?>>Maret</option>
                            <option value="04" <?php if($bln == '04'){echo "SELECTED";}?>>April</option>
                            <option value="05" <?php if($bln == '05'){echo "SELECTED";}?>>Mei</option>
                            <option value="06" <?php if($bln == '06'){echo "SELECTED";}?>>Juni</option>
                            <option value="07" <?php if($bln == '07'){echo "SELECTED";}?>>Juli</option>
                            <option value="08" <?php if($bln == '08'){echo "SELECTED";}?>>Agustus</option>
                            <option value="09" <?php if($bln == '09'){echo "SELECTED";}?>>September</option>
                            <option value="10" <?php if($bln == '10'){echo "SELECTED";}?>>Oktober</option>
                            <option value="11" <?php if($bln == '11'){echo "SELECTED";}?>>November</option>
                            <option value="12" <?php if($bln == '12'){echo "SELECTED";}?>>Desember</option>
                        </select>
					</div>
                    <div class="col-sm-2">	
                        <select name="tahun" class="form-control" onchange="this.form.submit();" >
                            <option value="2024" <?php if($thn == '2024'){echo "SELECTED";}?>>2024</option>
                            <option value="2025" <?php if($thn == '2025'){echo "SELECTED";}?>>2025</option>
                        </select>
					</div>
                    <div class="col-sm-4">
                        <select name="klaster" class="form-control Klaster" onchange="this.form.submit();">
                            <?php
                                $getklaster = mysqli_query($koneksi,"SELECT DISTINCT(`Klaster`) as klaster FROM `ref_siklushidup`");
                                while($dtklaster = mysqli_fetch_assoc($getklaster)){
                                    $selected = "";
                                    if($_GET['klaster'] == $dtklaster['klaster']){
                                        $selected = "SELECTED";
                                    }

                                    echo "<option value='$dtklaster[klaster]' $selected>$dtklaster[klaster]</option>";
                                }
                            ?>
                        </select>
					</div>
					<div class="col-sm-4">						
                        <select name="siklushidup" class="form-control siklus_hidup" onchange="this.form.submit();"  >
                            <option value="Ibu Hamil, Bersalin, dan Nifas" <?php if($_GET['siklushidup'] == 'Ibu Hamil, Bersalin, dan Nifas'){echo "SELECTED";}?>>Ibu Hamil, Bersalin, dan Nifas</option>
                            <option value="Balita dan Anak Pra Sekolah" <?php if($_GET['siklushidup'] == 'Balita dan Anak Pra Sekolah'){echo "SELECTED";}?>>Balita dan Anak Pra Sekolah</option>
                            <option value="Anak Usia Sekolah dan Remaja" <?php if($_GET['siklushidup'] == 'Anak Usia Sekolah dan Remaja'){echo "SELECTED";}?>>Anak Usia Sekolah dan Remaja</option>
                        </select>
					</div>
                    
                </div>    
                </form>

				<div class="row">

					<div class="col-sm-12">
						<div class="kotakgrafik" style="margin-top: 5px;">
							<div class="au-card m-b-30">
								<div class="au-card-inner">
									<canvas id="Grafik_Kunjungan" height="370px"></canvas>
								</div>
							</div>
						</div>
					</div>
								
				</div>

			</div>										
		</div>
	</div>
</div>		


</body>
</html>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/chartjsorg.js"></script>

<script>
    set_siklushidup();
	$(".Klaster").change(function(){
		set_siklushidup();
	});

	function set_siklushidup(){
		
		var klaster = $(".Klaster option:selected").val();//.toLowerCase()
		var siklushidup = '<?php echo $_GET['siklushidup'];?>';

        $.post( "get_siklushidup.php", { klaster: klaster, siklushidup: siklushidup })
            .done(function( data ) {
            if(data != ''){
                $('.siklus_hidup').html(data);
            }
        });	
	}

var ctx = document.getElementById("Grafik_Kunjungan").getContext('2d');
var Grafik_Kunjungan = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: [
				<?php
                //get ref_skrining
                $getref_skrining = mysqli_query($koneksi,"SELECT NamaFIle FROM `ref_skrining` ORDER BY IdSkrining ASC ");
				while($dtskrining = mysqli_fetch_assoc($getref_skrining)){
                    $nama_skrining = str_replace("skrining_","",$dtskrining['NamaFIle']);
					echo '"'.strtoupper($nama_skrining).'", ';
				}
				?>
				],
		datasets: [{
			label: 'Jumlah di Bulan: <?php echo nama_bulan($bln);?>',
			data:[
				<?php
					$jml = 0;
                    $getref_skrining2 = mysqli_query($koneksi,"SELECT * FROM `ref_skrining` ORDER BY IdSkrining ASC ");
					while($dtskrining = mysqli_fetch_assoc($getref_skrining2)){
						$tbskrining = "tb".$dtskrining['NamaFile']."_".strtoupper($namapuskesmas);
                        $strjml = "SELECT a.IdPasienrj FROM `$tbskrining` a JOIN $tbpasienrj b ON a.IdPasienrj = b.IdPasienrj WHERE MONTH(b.`TanggalRegistrasi`) = '$bln' AND YEAR(b.`TanggalRegistrasi`) = '$thn'".$strfilterklaster;
                        //echo $strjml;
                        $cektable = mysqli_query($koneksi,"SHOW TABLES LIKE '$tbskrining'");
                        if(mysqli_num_rows($cektable) > 0)
                        {
                            $getquery = mysqli_query($koneksi,$strjml);
                            $jml_kunj = mysqli_num_rows($getquery);
                        }else{
                            $jml_kunj = 0;
                        }
						echo '"'.$jml_kunj.'", ';
					}		
				?>
				],
				backgroundColor: [
				<?php
                 $getref_skrining3 = mysqli_query($koneksi,"SELECT NamaSkrining FROM `ref_skrining` ORDER BY IdSkrining ASC ");
				while($dtskrining = mysqli_fetch_assoc($getref_skrining3)){
				?>
					'rgba(14, 186, 46, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
            $getref_skrining4 = mysqli_query($koneksi,"SELECT NamaSkrining FROM `ref_skrining` ORDER BY IdSkrining ASC ");
			while($dtskrining = mysqli_fetch_assoc($getref_skrining4)){
			?>
				'rgba(0, 127, 23, 1)',
			<?php
			}
			?>
			],
			borderWidth: 1
		}]
	},
	options: {
		responsive: true,
		maintainAspectRatio: false,
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true
				}
			}]
		}
	}
});

</script>



<?php
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$dtworkshop = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbregistrasi_workshop` WHERE `Puskesmas`='$namapuskesmas'"));
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>E-SERTIFIKAT</b></h3>
			<div class="formbg">                
                        <span class="profile-picture imgcenter">
						<div style="position:relative;top:225px;left:30px;text-align:center;width:1000px;font-weight:bold;font-size:14px;"><?php echo $dtworkshop['IdRegWorkshop']."-DPD-PORMIKIJABAR";?></div>
                        	<div style="position:relative;top:290px;left:30px;text-align:center;width:1000px;font-weight:bold;font-size:26px;"><?php echo $dtworkshop['NamaPegawai'];?></div>
                            <img id="avatar" class="editable img-responsive editable-click editable-empty" src="image/esertifikat_ws_rme_2023.jpg" width="1000px">
                        </span>
                        <canvas id="myCanvas" width="1120px" height="791px"></canvas>
                        <br/>
                        <button type="button" class="downloadcvs btn btn-info">Download</button>
						<button type="button" class="btn btn-warning"><a href="workshop/sukabumi/<?php echo $dtworkshop['Kwitansi'];?>" target="_blank">Kwitansi</a></button>

                        <script src="assets/js/jquery-2.1.4.min.js"></script>
					    <script>
					      	var canvas = document.getElementById('myCanvas');
					      	var context = canvas.getContext('2d');
					      	var imageObj = new Image();

						    imageObj.onload = function() {
						        context.drawImage(imageObj, 0, 0, canvas.width, canvas.height);

						        context.font = "16pt Calibri";
						        context.fillStyle = "#313a3f";
						        context.textAlign = 'center';
         						// context.fillText("<?php echo $dtworkshop['IdRegWorkshop']."-RME-SUKABUMI";?>", 600, 200);

						        context.font = "26pt Calibri";
						        context.textAlign = 'center';
         						context.fillText("<?php echo $dtworkshop['NamaPegawai'];?>", 565, 320);
						    };
					      	imageObj.src = 'image/esertifikat_ws_rme_2024_sukabumi.jpg';


					      $(".downloadcvs").click(function(){
					      		var canvas = document.getElementById("myCanvas");
							    // var img    = canvas.toDataURL("image/png");
							    // document.write('<img src="'+img+'"/>')
							    var anchor = document.createElement("a");
								anchor.href = canvas.toDataURL("image/png");
								anchor.download = "<?php echo $dtworkshop['NamaPegawai']."-".$dtworkshop['IdRegWorkshop']."-DPD-PORMIKIJABAR";?>.PNG";
								anchor.click();
					      });
					      	
					    </script>
                    
			</div>
		</div>
	</div>
</div>	
	
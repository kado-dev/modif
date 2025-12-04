<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Peta Geografis Puskesmas</h1>
		</div>
	</div>
</div>

<div id="map" style="width:100%; height: 400px;"></div>
	<!--<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>-->
	<script src="https://maps.google.com/maps/api/js?key=AIzaSyBs8n-DXljgnggJyY6L0UAiqU22tKDo3f0" type="text/javascript"></script>
	<script type="text/javascript">
		var locations = [
			<?php
				include "config/koneksi.php";
				$query = mysqli_query($koneksi,"select * from `tbpuskesmas` where Kota = '".$_SESSION['kota']."'");
				while($data=mysqli_fetch_assoc($query)){
					$hariini = date('Y-m-d');
					//$kunjungan = mysqli_num_rows(mysqli_query($koneksi,"SELECT count(NoRegistrasi) FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$hariini' AND substring(`NoRegistrasi`,1,11) = '".$data['KodePuskesmas']."' "));
					$img = '<img src="image/'.$data['Img'].'" width="200px"/>';
					$txt = $img."<br/><table><tr><td>Nama</td><td>:</td><td>".$data['NamaPuskesmas']."</td></tr><tr><td>Alamat</td><td>:</td><td>".$data['Alamat']."</td></tr><tr><td>Telp</td><td>:</td><td>".$data['Telepon']."</td></tr><tr><td>Long</td><td>:</td><td>".$data['Long']."</td></tr><tr><td>Lat</td><td>:</td><td>".$data['Lat']."</td></tr><tr><td>Kpl.Pusk</td><td>:</td><td>".$data['KepalaPuskesmas']."</td></tr></tr></table>";
					$long = $data['Long'];
					$lat = $data['Lat'];
			?>
				['<?php echo $txt;?>',<?php echo $long;?>,<?php echo $lat;?>],
			<?php	
				}
			?>		
		];

		var map = new google.maps.Map(document.getElementById('map'), {
		  zoom: 10,
		  center: new google.maps.LatLng(-7.0510666,107.6901423),
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		});

		var infowindow = new google.maps.InfoWindow();
		var marker, i;

		for (i = 0; i < locations.length; i++) {  
			marker = new google.maps.Marker({
			position: new google.maps.LatLng(locations[i][1], locations[i][2]),
			map: map
		});

		google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
			  infowindow.setContent(locations[i][0]);
			  infowindow.open(map, marker);
			}
		  })(marker, i));
		}
	</script>
	<br/>
	<br/>
 
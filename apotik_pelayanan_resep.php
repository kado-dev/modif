<?php
	// error_reporting(1);
	include "config/koneksi.php";
	$statusloket = $_GET['statusloket'];
?>

<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white fw-bold">PELAYANAN RESEP <?php echo "(".strtoupper($statusloket).")";?></h2>
				<h5 class="text-white op-7">SILAHKAN CARI DATA PASIEN</h5>
			</div>
			<div class="ml-md-auto py-2 py-md-0 mr-2">
				<?php if($kota == "KOTA TARAKAN"){?>	
					<a href="?page=apotik_pelayanan_resep_manual_tambah_tarakan&statusloket=<?php echo $statusloket;?>" class="btn btn-round btn-success">Entry Resep</a>
				<?php }else{?>
					<a href="?page=apotik_pelayanan_resep_manual_tambah&statusloket=<?php echo $statusloket;?>" class="btn btn-round btn-success">Entry Resep</a>
				<?php }?>
			</div>
			<button onclick="pauseAudio()" class="btn btn-round btn-danger" type="button">Mute Audio</button>			
		</div>
	</div>
</div>

<div class="page-inner mt--5">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<form method="get">
						<div class="row">
							<input type="hidden" name="page" value="apotik_pelayanan_resep"/>
							<input type="hidden" name="status" value="<?php echo $_GET['status'];?>"/>
							<input type="hidden" name="statusloket" value="<?php echo $_GET['statusloket'];?>"/>
							<div class="col-sm-2">
								<div class="tampilformdate">
									<input type="text" name="tgl1" class="form-control datepicker2" value="<?php echo $_GET['tgl1'];?>" placeholder = "Tanggal Awal">
								</div>
							</div>
							<div class="col-sm-2">
								<div class="tampilformdate">
									<input type="text" name="tgl2" class="form-control datepicker2" value="<?php echo $_GET['tgl2'];?>" placeholder = "Tanggal Akhir">
								</div>
							</div>
							<div class="col-sm-2">
								<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketik Nama Pasien">
							</div>
							<?php
								if ($kota == "KABUPATEN BULUNGAN"){
							?>
							<div class="col-sm-2">
								<select name="loketobat" class="form-control">
									<option value="semua" <?php if($_GET['loketobat'] == "semua"){echo "SELECTED";}?>>Semua</option>
									<option value="LOKET OBAT" <?php if($_GET['loketobat'] == "LOKET UMUM"){echo "SELECTED";}?>>LOKET UMUM</option>
									<option value="POLI LANSIA" <?php if($_GET['loketobat'] == "POLI LANSIA"){echo "SELECTED";}?>>LOKET LANSIA</option>
								</select> 
							</div>
							<?php
								}
							?>
							<div class="col-sm-2">
								<?php
									if($kota == 'KABUPATEN BOGOR'){
								?>
								<select name="statusdilayani" class="form-control">
									<option value="SEMUA" <?php if($_GET['statusdilayani'] == "SEMUA"){echo "SELECTED";}?>>Semua</option>
									<option value="BELUM" <?php if($_GET['statusdilayani'] == "BELUM"){echo "SELECTED";}?>>BELUM</option>
									<option value="SUDAH" <?php if($_GET['statusdilayani'] == "SUDAH"  or $_GET['statusdilayani'] == ""){echo "SELECTED";}?>>SUDAH</option>
								</select> 
								<?php
									}else{
								?>
								<select name="statusdilayani" class="form-control">
									<option value="SEMUA" <?php if($_GET['statusdilayani'] == "SEMUA"){echo "SELECTED";}?>>Semua</option>
									<option value="BELUM" <?php if($_GET['statusdilayani'] == "BELUM" or $_GET['statusdilayani'] == ""){echo "SELECTED";}?>>BELUM</option>
									<option value="SUDAH" <?php if($_GET['statusdilayani'] == "SUDAH"){echo "SELECTED";}?>>SUDAH</option>
								</select> 
								<?php
									}
								?>
							</div>
							<div class="col-sm-4">
								<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
								<a href="?page=apotik_pelayanan_resep&statusloket=<?php echo $statusloket;?>" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
								<a href="apotik_pelayanan_resep_excel.php?tgl1=<?php echo $_GET['tgl1'];?>&tgl2=<?php echo $_GET['tgl2'];?>&key=<?php echo $_GET['key'];?>&statusdilayani=<?php echo $_GET['statusdilayani'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
								<!--<a href="?page=apotik_resep" class="btn btn-round btn-success">Resep Manual</a> data-toggle="modal" data-target="#modalresep"-->
								<?php
								$tbantrian_farmasi = "tbantrian_farmasi_".str_replace(' ', '', $namapuskesmas);
									$qry = mysqli_query($koneksi,"SELECT * FROM `$tbantrian_farmasi` WHERE date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` != 'Selesai' order by NomorAntrian Limit 1");
									if(mysqli_num_rows($qry) > 0){
								?>
								<a href="#" class="btn btn-round btn-info panggilantrian">Panggil</a>
								<?php
									}
								?>
							</div>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	if($_GET['sort'] == 'ASC'){
		$sorts = 'DESC';
	}else{
		$sorts = 'ASC';
	}
?>	

<div class="page-inner mt--5">
	<div class="row">
		<div class="col-md-12">
			<table class="table-judul">
				<thead>
					<tr>
						<th width="4%">NO.</th>
						<th width="12%"><a href="?page=apotik_pelayanan_resep&statusloket=<?php echo $statusloket;?>&orderby=TanggalResep&sort=<?php echo $sorts;?>&h=<?php echo $_GET['h'];?>">TGL.RESEP <?php echo iconsort("TanggalResep",$sorts);?></a></th>
						<th width="25%"><a href="?page=apotik_pelayanan_resep&statusloket=<?php echo $statusloket;?>&orderby=NamaPasien&sort=<?php echo $sorts;?>&h=<?php echo $_GET['h'];?>">NAMA PASIEN <?php echo iconsort("NamaPasien",$sorts);?></a></th>
						<th width="6%">UMUR</th>
						<th width="12%"><a href="?page=apotik_pelayanan_resep&statusloket=<?php echo $statusloket;?>&orderby=Pelayanan&sort=<?php echo $sorts;?>&h=<?php echo $_GET['h'];?>">PELAYANAN <?php echo iconsort("Pelayanan",$sorts);?></a></th>
						<th width="10%">CARA BAYAR</th>
						<th width="8%">STATUS</th>
						<?php if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>
						<th width="10%">OPSI</th>
						<?php }?>
					</tr>
				</thead>
				<tbody>
					<?php							
					$statusdilayani = $_GET['statusdilayani'];

					if($statusdilayani == ''){
						if($kota == 'KABUPATEN BOGOR'){
							$statusdilayani = 'SUDAH';
						}else{
							$statusdilayani = 'BELUM';
						}								
					}

					$tgl1 = $_GET['tgl1'];
					$tgl2 = $_GET['tgl2'];
					$hariini = date('Y-m-d');
					$key = $_GET['key'];
					
					if($tgl1 == null){
						$tglresep = " AND DATE(TanggalResep) = '$hariini'";
					}else{								
						$tglresep = " AND DATE(TanggalResep) BETWEEN '$tgl1' AND '$tgl2'";
					}
					
					if($key !=''){
						$strcari = " AND (`NamaPasien` Like '%$key%' OR `NoResep` Like '%$key%')";
					}else{
						$strcari = " ";
					}
					
					if($statusdilayani != 'SEMUA'){
						$statusdilayanis = " AND `Status`='$statusdilayani'";
					}else{
						$statusdilayanis = " ";
					}
					
					// if($loketobat == 'semua'){
					// 	$loketobats = "";
					// }elseif($loketobat == 'LOKET OBAT'){
					// 	$loketobats = " AND Pelayanan <> 'POLI LANSIA'";
					// }elseif($loketobat == 'POLI LANSIA'){
					// 	$loketobats = " AND Pelayanan = 'POLI LANSIA'";
					// }
									
					if($_GET['orderby'] == '' or $_GET['sort'] == ''){
						$orderbys = "order by TanggalResep ASC";
					}else{
						$orderbys = "order by ".$_GET['orderby']." ".$_GET['sort'];
					}
					
					// menampilkan opsi resepnya (diberikan resep)
					$str = "SELECT `IdResep`,`TanggalResep`,`NoResep`,`NoIndex`,`IdPasienrj`,`NamaPasien`,`UmurTahun`,`StatusBayar`,`Pelayanan`,`Status`,`StatusLoket` FROM `$tbresep` WHERE (OpsiResep = 'diberikan resep' OR OpsiResep = '') AND `StatusLoket`='$statusloket'".$tglresep.$strcari.$statusdilayanis;
					$str2 = $str." ".$orderbys;
					// echo $str2;
												
					$query = mysqli_query($koneksi,$str2);
					$jmldata = mysqli_num_rows($query);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$idpasienrj = $data['IdPasienrj'];
						$noindex = $data['NoIndex'];
						$noresep = $data['NoResep'];
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo $data['TanggalResep'];?></td>
							<td align="center" class="noresep" style="display: none;"><?php echo $data['NoResep'];?></td>
							<td align="left" class="namakk">
								<b>
								<?php 
									echo $data['NamaPasien'];
									if(substr($data['NoResep'], -5,1) == "m"){
								?>
									<span class="badge badge-warning" style='font-size:10px; font-style: italic; padding: 4px;'><?php echo "Offline";?></span>
								<?php } ?>
								</b>
							</td>
							<td align="right">
								<?php 
									if($data['UmurTahun'] == '0'){
										echo $data['UmurBulan']." Bl";
									}else{
										echo $data['UmurTahun']." Th";
									}	
								?>
							</td>
							<td align="center" class="pelayanan"><?php echo str_replace('POLI','', $data['Pelayanan']);?></td>
							<td align="center"><?php echo $data['StatusBayar'];?></td>
							<td align="center"><?php echo $data['Status'];?></td>
							<td align="center">
								<!--<a href="?page=apotik_resep_input&status=<?php echo $_GET['status'];?>" class="btn btn-xs btn-danger">Input</a>-->
								<!--<a href="#" class="btn btn-xs btn-info btn-white <?php if($data['Status'] == 'Sudah'){echo 'btn-danger';}else{echo 'btn-info';};?> btnmodalobat">Proses</a>-->
								<?php if($kota == "KABUPATEN GARUT"){?>
									<a href="?page=apotik_pelayanan_resep_manual_lihat_garutkab&status=<?php echo $_GET['status'];?>&norsp=<?php echo $data['NoResep'];?>&statusloket=<?php echo $statusloket;?>" class="btn btn-round btn-sm btn-info">LIHAT</a>
								<?php }elseif($kota == "KOTA TARAKAN"){ ?>
									<a href="?page=apotik_pelayanan_resep_manual_lihat_tarakan&status=<?php echo $_GET['status'];?>&norsp=<?php echo $data['NoResep'];?>&noid=<?php echo $data['NoIndex'];?>&statusloket=<?php echo $statusloket;?>&tgl1=<?php echo $tgl1;?>&tgl2=<?php echo $tgl2;?>&key=<?php echo $key;?>&statusdilayani=<?php echo $statusdilayani;?>" class="btn btn-round btn-sm btn-info">LIHAT</a>
								<?php }elseif($kota == "KABUPATEN SUKABUMI"){ ?>
									<a href="?page=apotik_pelayanan_resep_manual_lihat_sukabumi&status=<?php echo $_GET['status'];?>&norsp=<?php echo $data['NoResep'];?>&noid=<?php echo $data['NoIndex'];?>&statusloket=<?php echo $statusloket;?>&tgl1=<?php echo $tgl1;?>&tgl2=<?php echo $tgl2;?>&key=<?php echo $key;?>&statusdilayani=<?php echo $statusdilayani;?>" class="btn btn-round btn-sm btn-info">LIHAT</a>
								<?php }elseif($kota == "KABUPATEN BANDUNG" OR $kota == "BANDUNG"){ ?>
									<?php if($idpasienrj=='0' OR $idpasienrj==''){ ?>
										<a href="?page=apotik_pelayanan_resep_manual_lihat_offline&status=<?php echo $_GET['status'];?>&idrj=<?php echo $data['IdPasienrj'];?>&norsp=<?php echo $data['NoResep'];?>&noid=<?php echo $data['NoIndex'];?>&statusloket=<?php echo $statusloket;?>" class="btn btn-round btn-sm btn-info">LIHAT</a>
									<?php }else{ ?>
										<a href="?page=apotik_pelayanan_resep_manual_lihat&status=<?php echo $_GET['status'];?>&idrj=<?php echo $data['IdPasienrj'];?>&norsp=<?php echo $data['NoResep'];?>&noid=<?php echo $data['NoIndex'];?>&statusloket=<?php echo $statusloket;?>" class="btn btn-round btn-sm btn-info">LIHAT</a>
									<?php } ?>
								<?php } ?>
								<?php
									$cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM `$tbresepdetail` WHERE `NoResep` = '$data[NoResep]'"));
									if($cek == 0){											
								?>	
									<a href="?page=apotik_pelayanan_resep_hapus&id=<?php echo $data['NoResep'];?>&statusdilayani=<?php echo $_GET['statusdilayani'];?>&statusloket=<?php echo $statusloket;?>" class="btn btn-round btn-sm btn-danger">HAPUS</a>
								<?php
									}
								?>
							</td>		
						</tr>
					<?php
					}
					?>	
				</tbody>
			</table>
		</div>	
	</div>
</div>
<!--modal-->
<div class="hasilmodal" id="result">
	
</div>

<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>
if(typeof(EventSource) !== "undefined") {
  var jmldata = <?php echo $jmldata;?>;
  var source = new EventSource("apotik_pelayanan_resep_autoload.php?statusloket=<?php echo $_GET['statusloket'];?>&tgl1=<?php echo $_GET['tgl1'];?>&tgl2=<?php echo $_GET['tgl2'];?>&key=<?php echo $_GET['key'];?>&statusdilayani=<?php echo $_GET['statusdilayani'];?>");
  source.onmessage = function(event) {
    //console.log(event.data);
    //if(jmldata <= 5){
	    if(event.data > jmldata){
            var audio = new Audio('https://ciluluk.puskesmasbandung.id/antrian/Suara/sound.wav');
            audio.play();			
	    	location.reload();
	    }
	//}
  };
} else {
  document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
}

var statusdilayani = '<?php echo $_GET['statusdilayani'];?>';
if(jmldata > 0 && (statusdilayani == 'BELUM' || statusdilayani == '')){
 var audio = new Audio('https://sukabumisehat.com/antrian/Suara/sound.wav');
 audio.loop = true;
 audio.play();    
    var isPlaying = false;
    function pauseAudio() {
      isPlaying ? audio.pause() : audio.play();
    };    
    audio.onplaying = function() {
      isPlaying = true;
    };
    audio.onpause = function() {
      isPlaying = false;
    };
}

$(".panggilantrian").click(function(){
	$.get( "get_modal_panggil_antrian_farmasi.php").done(function( data ) {
		$(".hasilmodal").html(data);
		$('#Modalantrian').modal('show');
	});
});	

// if(typeof(EventSource) !== "undefined") {
//   var source = new EventSource("apotik_pelayanan_resep_autoload.php");
//   source.onmessage = function(event) {
//     console.log(event.data);
//     // if(event.data != <?php //echo $jmldata;?>){
//     // 	location.reload();
//     // }
//   };
// } else {
//   document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
// }
</script>
<?php
function iconsort($nmkolom,$sorttype){
	$sorticon = "<i class='fa fa-sort'></i>";
	$downs = "<i class='fa fa-sort-down'></i>";
	$ups = "<i class='fa fa-sort-up'></i>";
	if(isset($_GET["sort"])){
		if($nmkolom == $_GET['orderby']){
			if($sorttype == 'ASC'){
				$h = $downs;
			}else{
				$h = $ups;
			}
		}else{
			$h = $sorticon;
		}
	}else{
		$h = $sorticon;
	}
	return $h;
}
?>
<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	// $thn = $_GET['thn'];
	// $bln = $_GET['bln'];
	// function bln_sebelumnya($b,$t,$x){
	// 	$bln = $b - $x;
	// 	if($bln == 0){
	// 		$blns = 12;
	// 	}else if($bln == -1){
	// 		$blns = 11;
	// 	}else if($bln == -2){
	// 		$blns = 10;
	// 	}else{
	// 		$blns = $bln;
	// 	}
	// 	if(strlen($blns) == 1){
	// 		$x = "0".$blns;
	// 	}else{
	// 		$x = $blns;
	// 	}
	// 	return $x;
	// }
	
	// function thn_sebelumnya($b,$t,$x){
	// 	$bln = $b - $x;
	// 	if($bln <= 0){
	// 		$thn = $t - 1;
	// 	}else{
	// 		$thn = $t;
	// 	}
	// 	return $thn;
	// }	
	// if($thn != '' and $bln != ''){
	// echo bln_sebelumnya($bln,$thn,1)." | ".thn_sebelumnya($bln,$thn,1)."<br/>";
	// echo bln_sebelumnya($bln,$thn,2)." | ".thn_sebelumnya($bln,$thn,2)."<br/>";
	// echo bln_sebelumnya($bln,$thn,3)." | ".thn_sebelumnya($bln,$thn,3)."<br/>";
	// }
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>KIRIM KETERSEDIAAN OBAT </b><small>Elogistics</small></h3>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<div class = "row">
					<table class="tableborder table table-condensed" width="100%" style="margin-bottom:20px;">
						<form action="elog_ketersediaan_kirim_proses.php" method="post">
						<tr>
							<td width="10%">Area</td>
							<td width="2%">:</td>
							<td><?php echo substr($kodepuskesmas,0,4);?></td>
						</tr>
						<tr>
							<td>Periode</td>
							<td>:</td>
							<td>
								<select name="bln" class="col-sm-1" style="margin-right: 10px;">
									<?php
									for($bln = 1;$bln<=12; $bln ++){
										$j = strlen($bln);
										if($j == 1){
											$bln = "0".$bln;
										}
										if($bln == $_GET['bln']){
											echo "<option value='$bln' SELECTED>$bln</option>";
										}else{
											echo "<option value='$bln'>$bln</option>";
										}
									}
									?>
					
								</select>
								<select name="thn" class="col-sm-1">
									<?php
										for($tahun = 2015 ; $tahun <= date('Y'); $tahun++){
										if($tahun == $_GET['thn']){
									?>
										<option value="<?php echo $tahun;?>" SELECTED><?php echo $tahun;?></option>
									<?php }else{?>	
										<option value="<?php echo $tahun;?>"><?php echo $tahun;?></option>
									<?php 
										}
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Type</td>
							<td>:</td>
							<td><?php echo "Ketersediaan Obat";?></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td><input type="submit" class="btn btn-sm btn-info" value="Kirim"></td>
						</tr>
						</form>
					</table>
				</div>	
			</div>	
		</div>
	</div>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p>
					<a href="http://bankdataelog.kemkes.go.id/apps/" target="_blank" style="color: #000; font-weight: bold;">>> Lihat Bank Data Elogistik</a>
				</p>
			</div>
		</div>
	</div>
</div>

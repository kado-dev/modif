<?php
	include "config/helper_pasienrj.php";
   	
    // tbkk
	$query = mysqli_query($koneksi,"SELECT * FROM `$tbkk` WHERE `NoIndex` = '$id'");
	$data = mysqli_fetch_assoc($query);
    $id = $_GET['id'];
	$tahun = $_GET['th'];
	$orderby = $_GET['od'];
    $key = $_GET['key'];
?>



<div class="tableborderdiv">
    <form class="form-horizontal" action="rm_bankdata_detail_proses.php" method="post" role="form">
	<div class="row">
		<?php
		$query = mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `IdPasien` = '$id'");
		while($data = mysqli_fetch_assoc($query)){
		?>
        		
		<div class="col-sm-12">
			<div class="formbg">
                <h4 class="judul">
					<i class="icon-people"></i>
					<?php echo $data['NamaPasien'];?>
                    <span class="badge badge-success" style='font-style: italic; padding: 8px;'><?php echo substr($data['NoIndex'],-10);?></span><br/>
				</h4>
				<table class="table-judul">
					<tr>
						<td class="col-sm-2">NIK</td>
						<td class="col-sm-10"><?php echo $data['Nik'];?></td>
					</tr>
					<?php if($kota != "KOTA TARAKAN"){?>
					<tr>
						<td class="col-sm-2">No.RM</td>
						<td class="col-sm-10"><?php echo substr($data['NoRM'],-8);?></td>
					</tr>
					<?php } ?>
					<tr>
						<td>No.BPJS</td>
						<td><?php echo $data['NoAsuransi'];?></td>
					</tr>	
					<tr>
						<td>Asuransi</td>
						<td><?php echo $data['Asuransi'];?></td>
					</tr>
					<tr>
						<td>Tgl.Lahir</td>
						<td><?php echo date('d-m-Y', strtotime($data['TanggalLahir']));?></td>
					</tr>
					<tr>
						<td>Status Keluarga</td>
						<td><?php echo $data['StatusKeluarga'];?></td>
					</tr>							
					<tr>
						<td>Pendidikan</td>
						<td><?php echo $data['Pendidikan'];?></td>
					</tr>	
					<tr>
						<td>Pekerjaan</td>
						<td><?php echo $data['Pekerjaan'];?></td>
					</tr>								
				</table><hr/>
                <input type="hidden" name="idpasien" class="form-control" value="<?php echo $id;?>">
                <input type="hidden" name="nocm" class="form-control" value="<?php echo $data['NoCM'];?>">
				<input type="hidden" name="tahun" class="form-control" value="<?php echo $_GET['th'];?>">
				<input type="hidden" name="orderby" class="form-control" value="<?php echo $_GET['od'];?>">
				<input type="hidden" name="keys" class="form-control" value="<?php echo $_GET['key'];?>">
				<div align="center">
					<a href="?page=rm_bankdata&tahun=<?php echo $tahun;?>&orderby=<?php echo $orderby;?>&key=<?php echo $key;?>" class="btn btn-round btn-info btnmodalkartupasien">Kembali</a>
				</div>
			</div>
		</div>
        
        <div class="col-sm-12">
			<div class="formbg">
             <div class="row">
                    <div class="col-xl-12">
					    <input type="text" name="key" class="form-control pasien" placeholder="Ketikan Nama / NoIndex Pasien" minlenght="2">
                    </div>
                </div>
                <hr/>
				<h4 class="judul">
					<i class="icon-people mr-3"></i><span class="namapasien"></span>
               </h4>
				<table class="table-judul">
					<tr>
						<td class="col-sm-2">NIK</td>
						<td class="col-sm-10"><span class="nik"></td>
					</tr>
					<?php if($kota != "KOTA TARAKAN"){?>
					<tr>
						<td class="col-sm-2">No.RM</td>
						<td class="col-sm-10"><span class="norm"></td>
					</tr>
					<?php } ?>
					<tr>
						<td>No.BPJS</td>
						<td><span class="noasuransi"></td>
					</tr>	
					<tr>
						<td>Asuransi</td>
						<td><span class="asuransi"></td>
					</tr>
					<tr>
						<td>Tgl.Lahir</td>
						<td><span class="tanggallahir"></td>
					</tr>
					<tr>
						<td>Status Keluarga</td>
						<td><span class="statuskeluarga"></td>
					</tr>							
					<tr>
						<td>Pendidikan</td>
						<td><span class="pendidikan"></td>
					</tr>	
					<tr>
						<td>Pekerjaan</td>
						<td><span class="pekerjaan"></td>
					</tr>								
				</table><hr/>
			</div>
		</div>
		<?php
		}
		?>
	</div>
    <input type="hidden" name="noindex" class="form-control noindex">
    <button type="submit" class="btn btn-round btn-success btnsimpan">Pindah Data Pasien</button><br/>
    </form>
    <div class="hasilmodal"></div>
	<div class="hasilmodalkk"></div>
</div>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/jquery.autocomplete.js?2"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.pasien').autocomplete({
            serviceUrl: 'get_pasien.php?keyword=',
            onSelect: function (suggestion) {
                $(this).val(suggestion.namapasien);
                $(".namapasien").text(suggestion.namapasien);
                $(".idpasien").val(suggestion.idpasien);
                $(".noindex").val(suggestion.noindex);
				$(".nik").text(suggestion.nik);
				$(".norm").text(suggestion.norm);
				$(".noasuransi").text(suggestion.noasuransi);
				$(".asuransi").text(suggestion.asuransi);
				$(".tanggallahir").text(suggestion.tanggallahir);
				$(".statuskeluarga").text(suggestion.statuskeluarga);
				$(".pendidikan").text(suggestion.pendidikan);
				$(".pekerjaan").text(suggestion.pekerjaan);
                alert(nik);            
            }
        });
    });	
</script>	
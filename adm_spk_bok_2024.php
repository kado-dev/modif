<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>SPJ BOK 2024</b></h3>
		<div class="formbg">
			<form role="form">
				<div class = "row">
					<input type="hidden" name="page" value="adm_spk_bok_2024"/>
					<div class="col-xl-4">
						<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" Placeholder="Ketikan nama puskesmas">
					</div>
					<div class="col-xl-4">
						<select name="status" class="form-control inputan" required>
							<option value='Sudah' <?php if($_GET['status'] == 'Sudah'){echo "SELECTED";}?>>Sudah</option>
							<option value='Belum' <?php if($_GET['status'] == 'Belum'){echo "SELECTED";}?>>Belum</option>
						</select>
					</div>
					<div class="col-xl-4">
						<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
						<a href="?page=adm_spk_bok_2024" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
					</div>
				</div>	
			</form>
		</div>
	</div>
	
	<div class="col-sm-12 table-responsive">
		<table class="table-judul">
			<thead>
				<tr>
					<th width="5%">No.</th>
					<th width="15%">Puskesmas</th>
					<th width="10%">Kuitansi</th>
					<th width="10%">e-Faktur</th>
                    <th width="10%">e-biling</th>
					<th width="10%">Bukti Tf</th>
			</thead>
			
			<tbody>
				<?php	
				$key = $_GET['key'];
				$status = $_GET['status'];

				if($status == 'Sudah' OR $status == ''){
					$sts = " AND `Bok2024`='Sudah'";
				}else{
					$sts = " AND `Bok2024`='Belum'";
				}

				$str = "SELECT * FROM `tbpuskesmas` WHERE (`NamaPuskesmas`!= 'DINAS KESEHATAN' AND `NamaPuskesmas`!= 'UPTD FARMASI') AND `NamaPuskesmas` like '%$key%'".$sts;
				$str2 = $str." ORDER BY `NamaPuskesmas` ASC";
				// echo $str2;								
				$query = mysqli_query($koneksi, $str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					// $namagambar = json_decode($data['Gambar'],true);
					$kodepuskesmas = $data['KodePuskesmas'];
					$namapuskesmas = $data['NamaPuskesmas'];
					$statusbok = $data['Bok2024'];
				?>
					
					<form class="form-signin" method="post" enctype="multipart/form-data">
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="left"><?php echo $namapuskesmas;?></td>
						<td align="left"><?php if($statusbok == 'Sudah'){ ?><a href="dok/bok2024/kuitansi/<?php echo strtolower(str_replace(' ', '', $namapuskesmas));?>.pdf" style="color:#000" class="btn btn-round btn-success" target="_blank"><span class="fa fa-download"></span> Download</a><?php }else{ ?><a href="" style="color:#000" class="btn btn-round btn-danger" target="_blank"><span class="fa fa-download"></span> Belum Lengkap</a><?php } ?></td>
						<td align="left"><?php if($statusbok == 'Sudah'){ ?><a href="dok/bok2024/efaktur/<?php echo strtolower(str_replace(' ', '', $namapuskesmas));?>.pdf" style="color:#000" class="btn btn-round btn-success" target="_blank"><span class="fa fa-download"></span> Download</a><?php }else{ ?><a href="" style="color:#000" class="btn btn-round btn-danger" target="_blank"><span class="fa fa-download"></span> Belum Lengkap</a><?php } ?></td>
						<td align="left"><?php if($statusbok == 'Sudah'){ ?><a href="dok/bok2024/ebilling/<?php echo strtolower(str_replace(' ', '', $namapuskesmas));?>.pdf" style="color:#000" class="btn btn-round btn-success" target="_blank"><span class="fa fa-download"></span> Download</a><?php }else{ ?><a href="" style="color:#000" class="btn btn-round btn-danger" target="_blank"><span class="fa fa-download"></span> Belum Lengkap</a><?php } ?></td>
						<td align="left"><?php if($statusbok == 'Sudah'){ ?><a href="dok/bok2024/buktitf/<?php echo strtolower(str_replace(' ', '', $namapuskesmas));?>.pdf" style="color:#000" class="btn btn-round btn-success" target="_blank"><span class="fa fa-download"></span> Download</a><?php }else{ ?><a href="" style="color:#000" class="btn btn-round btn-danger" target="_blank"><span class="fa fa-download"></span> Belum Lengkap</a><?php } ?></td>
					</tr>
					</form>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<hr/>
<ul class="pagination">
    <?php
        $query2 = mysqli_query($koneksi,$str);
        $jumlah_query = mysqli_num_rows($query2);
        
        if(($jumlah_query % $jumlah_perpage) > 0){
            $jumlah = ($jumlah_query / $jumlah_perpage)+1;
        }else{
            $jumlah = $jumlah_query / $jumlah_perpage;
        }
        for ($i=1;$i<=$jumlah;$i++){
        $max = $_GET['h'] + 5;
        $min = $_GET['h'] - 4;
            if($i <= $max && $i >= $min){
                if($_GET['h'] == $i){
                    echo "<li class='active'><span class='current'>$i</span></li>";
                }else{
                    echo "<li><a href='?page=adm_spk_bok_2024&key=$key&puskesmas=$pkm&h=$i'>$i</a></li>";
                }
            }
        }
    ?>	
</ul>
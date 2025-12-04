<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$otoritas = explode(',',$_SESSION['otoritas']);
	$kota = $_SESSION['kota'];
	
?>

<style>
.tr, th{
	text-align:center;
}

.kotak_retribusi{
   	background: #c6efe8;
    padding: 10px 15px;	
    margin: 5px 0px;
	font-family: Sans-Serif;
	text-align:center;
	color:#3BAC9B;
	border-radius:5px;
}

.font30_bold{
	font-family: Sans-Serif;
	font-size: 30px;
	font-weight: bold;
	text-align: left;
	color:#3BAC9B;
}

@media screen and (max-width: 992px) {
	.kotak_retribusi{
		width: 100%;
		margin-bottom:15px;
	}
}

.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
	display: none;
	
}
.printheader h4{
	font-size:18px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:18px;
	font-family: "Bookman Old Style";
}
.printbody{
	margin-left:0px;
	margin-right:0px;
	display: none;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	display:none;
	margin-top:10px;
}
.bawahtabel{
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font10{
	font-size:10px;
	font-family: "Tahoma";
}
.font11{
	font-size:11px;
	font-family: "Tahoma";
}
.font14{
	font-size:14px;
	font-family: "Tahoma";
}
.apibadge{
	background:#f70000;padding:3px 15px;border-radius:12px;font-size:13px;color:#fff;
}
@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}
	.printbody{
		display:block;
	}
	.atastabel{
		display:block;
	}
	.bawahtabel{
		display:block;
	}
}
</style>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<?php echo $_GET['msg']; ?>
			<h3 class="judul"><b>PENERIMAAN</b>
			<span class="pull-right apibadge"><i class="fas fa-cloud-download-alt"></i> API</span>
			</h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="apotik_gudang_penerimaan"/>
						<div class="col-sm-4">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder ="Ketikan Nama Barang / No.Faktur">
						</div>
						<div class="col-sm-2">
							<select name="bulan" class="form-control">
								<?php
								$nama_bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
								$i = 1;
									foreach($nama_bulan as $nmbul){
										$bln = str_pad($i, 2, "0", STR_PAD_LEFT); 
								?>
									<option value="<?php echo $bln;?>" <?php if($_GET['bulan'] == $bln){echo "SELECTED";}?>><?php echo $nmbul;?></option>
								<?php 
									$i++;
								}
								?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="tahun" class="form-control">
								<?php
									if($kota == "KABUPATEN BOGOR"){
										$tahuns = 2021;
									}else{
										$tahuns = 2019;
									}	
									for($tahun = $tahuns ; $tahun <= date('Y'); $tahun++){
								?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=apotik_gudang_penerimaan" class="btn btn-round btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print"></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<div class="row noprint">	
		<div class="col-sm-12 table-responsive">
			<?php
				if($_GET['tahun'] == ''){
					$tahun = date('Y');
				}else{
					$tahun = $_GET['tahun'];
				}

				$bulan = $_GET['bulan'];

				include "config/helper_dashkesehatan.php";
				//get apikey 
				$qryapikey = mysqli_query($koneksi,"select Username, Password FROM tbapikey WHERE Kodepuskesmas = '$kodepuskesmas'");
				$dtapikey = mysqli_fetch_assoc($qryapikey);

				$usernameapi = $dtapikey['Username'];
				$passwordapi = $dtapikey['Password'];
				// echo "User".$usernameapi;
				// echo "Pass".$passwordapi;
				$get_token_dashkesehatan = get_token_dashkesehatan($usernameapi,$passwordapi);
				$get_data_pengeluaran_dinkes = get_data_pengeluaran_obat_dinkes($usernameapi,$get_token_dashkesehatan,$tahun,$bulan);
				// echo "Hasil : ".$get_data_pengeluaran_dinkes;
				$getdtjson = json_decode($get_data_pengeluaran_dinkes,true);
				$dtjson = $getdtjson['metadata'];
				$dtjson_list = $dtjson['data']['List'];
			?>
			<table class="table-judul">
				<thead>
					<th>Jumlah Faktur</th>
					<th>Belum di Validasi</th>
					<th>Total Penerimaan <?php echo date('Y');?></th>
				</thead>
				<tbody style="font-size: 22px;">
					<td align="center"><?php echo $dtjson['jumlah_faktur'];?></td>
					<td align="center"><?php echo $dtjson['belum_validasi'];?></td>
					<td align="center"><?php echo "Rp. ".rupiah($dtjson['grand_total']);?></td>
				</tbody>
			</table><br/>
				
			<?php
			/* catatan (update 29 juli 2021) :
			tarik dari distribusi dinkes saja tbgfkpengeluarandetail
			jangan menggunakan tbgudangpkmpenerimaan dan tbgudangpkmpenerimaandetail
			agar lebih ringkas*/
			// echo "tes4";
			// die();
			?>

			<table class="table-judul-laporan" width="100%">
				<thead>
					<tr>
						<th width="3%">NO</th>
						<th width="8%">TANGGAL</th>
						<th width="10%">NO.FAKTUR</th>
						<th width="10%">PENERIMA</th>
						<th width="10%">GRAND TOTAL</th>
						<th width="12%">STATUS BARANG</th>
						<?php if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>
						<th width="5%">AKSI</th>
						<?php }?>
					</tr>
				</thead>
				<tbody>
					<?php
					
					foreach($dtjson_list as $data){
						$no = $no + 1;						
						$nofaktur = $data['NoFaktur'];						
						$kodepuskesmas= $data['KodePenerima'];
						
						// // jml item	
						
													
					?>
						<tr>
							<td align="right"><?php echo $no;?></td>
							<td align="center"><?php echo $data['TanggalPengeluaran'].", ".$data['JamPengeluaran'];?></td>
							<td align="center"><?php echo $data['NoFaktur'];?></td>
							<td align="center"><?php echo $data['Penerima'];?></td>
							<td align="right">
								<b>
									<?php 
										echo rupiah($data['grandtotal']);
									?>
								</b>
							</td>
							<td align="center">
								<span class="badge badge-success" style="padding: 5px 10px;"><?php echo $data['jmlitem']." Item";?></span>
								<?php if($data['validasi_belum'] > 0){?>
								<span class="badge badge-danger" style="padding: 5px 10px;"><?php echo $data['validasi_belum']." Blm Validasi";?></span>
								<?php } ?>
							</td>
							<?php if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>
							<td align="center">
								<a href="?page=apotik_gudang_penerimaan_lihat&id=<?php echo $data['NoFaktur'];?>&key=<?php echo $key;?>&tahun=<?php echo $tahun;?>" class="btn btn-xs btn-info">Lihat</a>
							</td>	
							<?php }?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div><hr/>

	<ul class="pagination noprint">
		<?php
			
		?>	
	</ul> 

	<div class="row noprint">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<p><b>Keterangan : </b></br>
				Penerimaan Gudang Obat Puskesmas bersumber dari UPT Farmasi Dinas Kesehatan Kab/Kota.</p>	
			</div>
		</div>
	</div>
</div>


<?php
	// include "config/koneksi.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$kota = $_SESSION['kota'];
	$profinsi = $_SESSION['profinsi'];
	$kecamatan = $_SESSION['kecamatan'];
	$otoritas = explode(',',$_SESSION['otoritas']);
	$noasuransi = $_GET['noasuransi'];
	$hariini = date("d-m-Y");
	$bulanini = date("m-Y");
?>

<style type="text/css">
	.tbdetailform{
		background: #dbf7ff;
		border-radius: 8px;
		margin-top: 15px;
		padding:15px 20px;
	}
	.tbdetail tr td{
		padding: 0px 5px;
	}
	.hed{
		background-color: #69D0EA;padding:8px;margin:-15px -20px 5px;text-align: center;
		border-radius: 8px 8px 0px 0px;
	}
	.hed h2{
		margin:0px;font-size: 26px;
	}
	.hed p{
		margin:0px;font-size: 14px;
	}
</style>

<!--DATE PICKER GINTING-->
<link href="assets/bootstrapdatepicker/css/bootstrap-datepicker.min.css" rel="stylesheet"><!--ini css bootstrapdatepicker-->
<link rel="stylesheet" type="text/css" href="assets/js/jquery-todo/css/styles.css" />

<div class="row">	
	<div class="col-lg-12">
		<?php 
			echo $_COOKIE['alert'];
		?>	
		<div class="tableborderdiv">
			<div class = "formbg">
				<div class="tableborder">
					<form class="form-horizontal" action="bpjs_kegiatan_kelompok_proses.php" method="post" role="form">
						<table class="table table-condensed" width="100%">							
							<h3 class="judul">ENTRI KEGIATAN KELOMPOK</h3>
							<tr>
								<td width="20%">Tanggal Pelaksanaan</td>
								<td width="80%">
									<div class="input-group">
										<span class="input-group-addon tesdate">
											<span class="fa fa-calendar"></span>
										</span>
										<input type="text" name="tangalpelaksanaan" class="form-control datepicker" data-date-end-date="0d" value="<?php echo $hariini;?>" autofocus>
									</div>
								</td>
							</tr>
							<tr>
								<td>Jenis Kelompok</td>
								<td>
									<select name="jeniskelompok" class="form-control jeniskelompok" required>
										<option value="03">Non Prolanis</option>
										<?php
										$query = mysqli_query($koneksi, "SELECT * FROM `tbbpjs_kelompok` ORDER BY `kdProgram`");
											while($data = mysqli_fetch_assoc($query)){
												echo "<option value='$data[kdProgram]'>$data[nmProgram]</option>";
											}
										?>
									</select>
								</td>
							</tr>
							<tr class="clubprolanis" style="display: none">
								<td>Club Prolanis</td>
								<td>
									<select name="clubprolanis" class="form-control select-clubprolanis">
										<option value="">-</option>
									</select>
									<input type="hidden" name="clubprolanisnama" class="form-control clubprolanisnama">
								</td>
							</tr>
							<tr>
								<td>Jenis Kegiatan</td>
								<td>
									<select name="jeniskegiatan" class="form-control" required>
										<?php
										$query = mysqli_query($koneksi, "SELECT * FROM `tbbpjs_kegiatan` ORDER BY `kdProgram`");
											while($data = mysqli_fetch_assoc($query)){
												echo "<option value='$data[kdProgram]'>$data[nmProgram]</option>";
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>Materi</td>
								<td>
									<input type="text" name="materi" style="text-transform: uppercase;" class="form-control" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
								</td>
							</tr>
							<tr>
								<td>Pembicara</td>
								<td>
									<input type="text" name="pembicara" style="text-transform: uppercase;" class="form-control" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
								</td>
							</tr>
							<tr>
								<td>Lokasi</td>
								<td>
									<input type="text" name="lokasi" style="text-transform: uppercase;" class="form-control" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
								</td>
							</tr>
							<tr>
								<td>Biaya Honor Internal</td>
								<td>
									<input type="text" name="biayahonorinternal" style="text-transform: uppercase;" class="form-control number" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
								</td>
							</tr>
							<tr>
								<td>Biaya Honor Eksternal</td>
								<td>
									<input type="text" name="biayahonoreksternal" style="text-transform: uppercase;" class="form-control number" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
								</td>
							</tr>
							<tr>
								<td>Biaya Lain-Lain</td>
								<td>
									<input type="text" name="biayalainlain" style="text-transform: uppercase;" class="form-control number" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
								</td>
							</tr>
							<tr>
								<td>Total Biaya</td>
								<td>
									<input type="text" name="totalbiaya" style="text-transform: uppercase;" class="form-control number" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
								</td>
							</tr>
							<tr>
								<td>Keterangan</td>
								<td>
									<textarea name="keterangan" style="text-transform: uppercase;" class="form-control" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')"></textarea>
								</td>
							</tr>
						</table><hr>
						<button type="submit" class="btnsimpan">SIMPAN</button>
					</form>
				</div>
			</div>		
		</div>
	</div>
</div>

<div class="row">	
	<div class="col-lg-12">
		<div class="tableborderdiv">
			<div class = "formbg">
				<h3 class="judul">RIWAYAT KEGIATAN KELOMPOK</h3>
				<div class="row">
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon tesdate">
								<span class="fa fa-calendar"></span>
							</span>
							<input type="text" class="form-control" id="datepicker" value="<?php echo $bulanini;?>">
						</div>
					</div>
					<div class="col-sm-2"><button type="button" class="btn-sm btn btn-primary">Cari</button></div>
				</div>
				<br/>
				<div class="table-responsive">
					<table class="table-judul">
						<thead>
							<tr>
								<th width="5%">NO.</th>
								<th width="10%">KEGIATAN</th>
								<th width="15%">TANGGAL PELAYANAN</th>
								<th width="35%">CLUB PROLANIS</th>
								<th width="30%">MATERI</th>
								<th width="5%">HAPUS</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tahun = date('Y');
								$bulan = date('m');
								$str = "SELECT * FROM `tbbpjs_kegiatan_kelompok` a JOIN tbbpjs_kegiatan b on a.JenisKegiatan = b.kdProgram WHERE YEAR(TanggalPelaksanaan)='$tahun' AND MONTH(TanggalPelaksanaan)='$bulan' ORDER by IdKegiatan DESC";
								$query = mysqli_query($koneksi, $str);
								while($data = mysqli_fetch_assoc($query)){
									$no = $no + 1;
								
							?>
								<tr <?php echo $stylewarna;?>>
									<td style="text-align:center;"><?php echo $no;?></td>
									<td style="text-align:center;"><a href="#" class="btn btn-info pilihkegiatan" data-eduid="<?php echo $data['eduId'];?>"><?php echo $data['nmProgram'];?></a></td>
									<td style="text-align:center;"><?php echo date('d-m-Y',strtotime($data['TanggalPelaksanaan']));?></td>
									<td style="text-align:left;"><?php echo $data['ClubProlanisNama'];?></td>
									<td style="text-align:left;"><?php echo $data['Materi'];?></td></td>			
									<td style="text-align:center;">
										<a onClick="return confirm('Data ingin dihapus...?')" href="?page=bpjs_kegiatan_kelompok_delete&id=<?php echo $data['IdKegiatan'];?>&eduid=<?php echo $data['eduId'];?>" class="btn btn-md btn-danger">HAPUS</a>
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
	</div>
</div>

<div class="row">	
	<div class="col-lg-12">
		<div class="tableborderdiv">
			<div class = "formbg">
				<h3 class="judul">DAFTAR HADIR PESERTA</h3>
				<div class="row">
					<div class="col-sm-4">
						<input type="text" class="form-control" placeholder="Ketikan No.Kartu/Nama Peserta">
					</div>
					<div class="col-sm-8">
						<button type="button" class="btn-sm btn btn-primary">Cari</button>
						<a href="#" class="btn-sm btn btn-success add_peserta_kegiatan">Tambah Data Pasien</a>
					</div>
				</div>
				<br/>				
				<div class="table-responsive">
					<table class="table-judul">
						<thead>
							<tr>
								<th width="3%">No.</th>
								<th width="12%">Tanggal Input</th>
								<th width="10%">No.Kartu</th>
								<th width="20%">Nama Peserta</th>
								<th width="5%">SEX</th>
								<th width="10%">Jenis Peserta</th>
								<th width="10%">Tgl. Lahir</th>
								<th width="5%">Usia</th>
								<th width="10%">Prolanis</th>
								<th width="5%">Hapus</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$no = 0;
								$str = "SELECT * FROM `tbbpjs_kegiatan_kelompok_addanggota` WHERE YEAR(TanggalInput)='$tahun' AND MONTH(TanggalInput)='$bulan' ORDER by IdInput DESC";
								$query = mysqli_query($koneksi, $str);
								while($data = mysqli_fetch_assoc($query)){
									$no = $no + 1;
								
							?>
								<tr <?php echo $stylewarna;?>>
									<td style="text-align:center;"><?php echo $no;?></td>
									<td style="text-align:center; display: none;"><?php echo $data['IdInput'];?></td>
									<td style="text-align:center;"><?php echo date('d-m-Y',strtotime($data['TanggalInput']));?></td>
									<td style="text-align:center;"><?php echo $data['noKartu'];?></td>
									<td style="text-align:left;"><?php echo $data['nama'];?></td>
									<td style="text-align:center;"><?php echo $data['sex'];?></td>
									<td style="text-align:left;"><?php echo $data['hubunganKeluarga'];?></td>
									<td style="text-align:center;"><?php echo $data['tglLahir'];?></td>
									<td style="text-align:center;"><?php echo $data['usia'];?></td>
									<td style="text-align:center;"><?php echo $data['Prolanis'];?></td>
									<td style="text-align:center;">
										<a onClick="return confirm('Data ingin dihapus...?')" href="?page=bpjs_kegiatan_kelompok_peserta_delete&id=<?php echo $data['IdInput'];?>&eduid=<?php echo $data['eduId'];?>&noka=<?php echo $data['noKartu'];?>" class="btn btn-md btn-danger">HAPUS</a>
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
	</div>
</div>

<!--untuk menampilkan modal-->
<div class="modal fade" id="modaladdpeserta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">TAMBAH PESERTA</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="bpjs_kegiatan_kelompok_addpeserta_proses.php" method="post" role="form">
					<input type="hidden" name="eduid" class="eduid"/>
					<table class="table">
						<tr>
							<td class="col-sm-3">Tanggal</td>
							<td class="col-sm-9">
								<div class="input-group">
									<span class="input-group-addon tesdate">
										<span class="fa fa-calendar"></span>
									</span>
									<input type="text" name="tanggalinput" class="form-control datepicker" data-date-end-date="0d" value="<?php echo $hariini;?>" autofocus>
								</div>
							</td>
						</tr>
						<tr>
							<td>Pendaftaran</td>
							<td>
								<div class="radio">
								  <label>
										<input type="radio" name="statusdaftar" value="BARU" id="baru">BARU
								  </label>
								  <label>
										<input type="radio" name="statusdaftar" value="RUJUKAN" id="rujukan">RUJUKAN
								  </label>
								</div>	
							</td>
						</tr>
						<tr>
							<td>Prolanis</td>
							<td>
								<div class="radio">
								  <label>
										<input type="radio" name="prolanis" value="YA" id="baru">YA
								  </label>
								  <label>
										<input type="radio" name="prolanis" value="TIDAK" id="rujukan">TIDAK
								  </label>
								</div>	
							</td>
						</tr>
						<tr>
							<td>No.Pencarian</td>
							<td>
								<div class="row">
									<div class="col-sm-10"><input type="text" name="nobpjs" class="form-control nobpjs"></div>
									<div class="col-sm-2"><button type="button" class="btn-sm btn btn-primary btncaridtbpjs">Cari</button></div>
								</div>
							</td>
						</tr>
					</table>
					<div class="dtpesertabpjs"></div>
					<button type="submit" class="btn btn-success btnsimpan">Simpan</button>
				</form>
			</div>
		</div>
	</div>
</div>
		
<script src="assets/js/jquery.js"></script>

<!--DATE PICKER GINTING-->
<script src="assets/bootstrapdatepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="assets/js/jQuery-slimScroll-1.3.0/slimScrollHorizontal.min.js"></script>

<script>
$(document).ready(function() {
	$(".jeniskelompok").change(function(){
		var isi = $(this).val();
		if(isi == '03'){
			$(".clubprolanis").hide();
		}else{
			$( ".select-clubprolanis" ).html( '<option value="">-</option>' );
			$.post( "get_kelompok_prolanis.php", {kode:isi})
			.done(function( data ) {
				$( ".select-clubprolanis" ).html( data );
				var text = $(".select-clubprolanis option:selected").text();
				$(".clubprolanisnama").val(text);
			});
			$(".clubprolanis").show();
		}
	});
	
	$(".select-clubprolanis").change(function(){
		var text = $(".select-clubprolanis option:selected").text();
		$(".clubprolanisnama").val(text);
	});
	
});

$(".number").keyup(function(){
  var val = this.value;
  val = val.replace(/[^0-9\.]/g,'');
  
  if(val != "") {
    valArr = val.split('.');
    valArr[0] = (parseInt(valArr[0],10)).toLocaleString();
    val = valArr.join('.');
  }
  
  this.value = val;
});

$(".pilihkegiatan").click(function(){
	var eduid = $(this).data('eduid');
	$(".eduid").val(eduid);
});

$(".add_peserta_kegiatan").click(function(){
	var eduidmodal = $(".eduid").val();
	if(eduidmodal != ''){
		$("#modaladdpeserta").modal('show');
	}
});

$(".btncaridtbpjs").click(function(){
	var nobpjs = $(".nobpjs").val();
	$.post( "get_no_bpjs.php", {no:nobpjs})
	.done(function( data ) {
		//var obj = json.parse(data);
		$(".dtpesertabpjs").html(data);
	});
});

var date = new Date('January 1, 2018');
$('#datepicker').datepicker({
      format: "mm-yyyy",
      minViewMode: 'months',
      autoclose: true,
      startDate: date
});

</script>
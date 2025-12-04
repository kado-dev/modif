<?php
    session_start();
    error_reporting(0);
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";
    $otoritas = explode(',',$_SESSION['otoritas']);
    $idpasienrj = $_GET['idrj'];
  

    // tbpasienrj
    $query = mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'");
    if(mysqli_num_rows($query ) > 0){
        $data = mysqli_fetch_assoc($query);
        $idpasien = $data['IdPasien'];
        $nocm = $data['NoCM'];
        $noindex = $data['NoIndex'];
        $noregistrasi = $data['NoRegistrasi'];
        $jeniskunjungan = $data['JenisKunjungan'];
        $kdprovider = $data['kdprovider'];
        $pelayanan = $data['PoliPertama'];

        // tbkk
        $datakk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbkk` WHERE `NoIndex` = '$noindex'"));

        // tbpasien
        $datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `IdPasien` = '$idpasien'"));

?>


<style>
   <style>	
	.kotak_panels{
		padding: 25px 20px;
		border-radius: 6px;
		margin-bottom: 15px;
	}
	.kotak_panels i{
		color: #f5f5f5;
		border:7px solid #f2f2f2;
		padding:10px 12px;
		/* border-radius: 50%; */
        margin: 15px !important;
	}
	.greens{
		background: linear-gradient(0deg, rgba(21, 114, 232, 0.9), rgba(174, 228, 213, 0.9)), url('image/bgpanel.jpg');
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
		box-shadow: 0 5px 10px -3px #7f7f7f;
	}
    .fontpanel{
		font-size: 30px;
		position: absolute;
		top:15px;
		left:120px;
		color: #fff;
		font-weight: bold;
		margin-top: 15px;
	}
</style>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <!-- <div class="card">
                <div class="card-body"> -->
                    <div class ="row">
                        <div class="col-sm-4">
                            <div class="kotak_panels greens">
                                <a href="?page=pemeriksaan_surat_sehat&idrj=<?php echo $idpasienrj;?>">
                                    <div data-toggle="modal" data-target="#modalpenerimaan">
                                        <i class="fas fa-print fa-3x" style="margin-top: 0px;"></i>
                                        <div class="fontpanel">Kir Sehat</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="kotak_panels greens">
                                <a href="?page=pemeriksaan_surat_sakit&idrj=<?php echo $idpasienrj;?>">
                                    <div data-toggle="modal" data-target="#modalpenerimaan">
                                        <i class="fas fa-print fa-3x" style="margin-top: 0px;"></i>
                                        <div class="fontpanel">Kir Sakit</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="kotak_panels greens">
                                <a href="?page=pemeriksaan_surat_berobat&idrj=<?php echo $idpasienrj;?>">
                                    <div data-toggle="modal" data-target="#modalpenerimaan">
                                        <i class="fas fa-print fa-3x" style="margin-top: 0px;"></i>
                                        <div class="fontpanel">Kir Berobat</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <div class="kotak_panels greens">
                                <a href="?page=pemeriksaan_mata&idrj=<?php echo $idpasienrj;?>">
                                    <div data-toggle="modal" data-target="#modalpenerimaan">
                                        <i class="fas fa-print fa-3x" style="margin-top: 0px;"></i>
                                        <div class="fontpanel">Kir Buta Warna</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <div class="kotak_panels greens">
                                <a onClick="return confirm('Masih proses diupdate..')" href="#">
                                    <div data-toggle="modal" data-target="#modalpenerimaan">
                                        <i class="fas fa-print fa-3x" style="margin-top: 0px;"></i>
                                        <div class="fontpanel">Kir Haji</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <div class="kotak_panels greens">
                                <a onClick="return confirm('Masih proses diupdate..')" href="#">
                                    <div data-toggle="modal" data-target="#modalpenerimaan">
                                        <i class="fas fa-print fa-3x" style="margin-top: 0px;"></i>
                                        <div class="fontpanel">Kir Catin</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                <!-- </div>
            </div> -->
        </div>
    </div>
</div>

<?php
    }
?>
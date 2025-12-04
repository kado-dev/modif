<h3 class="judul"><b>Therapy (Planning)</b></h3>
<div class="row" style="margin-left: 10px;">
    <div class="form-check" style="margin-bottom:0px;padding-bottom:0px">
        <input class="form-check-input opsiterapi" type="radio" name="opsiresep" id="opsiterapi" value="diberikan resep" checked>
        <label class="form-check-label" for="opsiterapi" style="margin-bottom:0px">
            Diberikan Resep
        </label>
    </div>
    <div class="form-check" style="margin-bottom:0px;padding-bottom:0px">
        <input class="form-check-input opsiterapi" type="radio" name="opsiresep" id="opsiterapi1" value="konseling">
        <label class="form-check-label" for="opsiterapi1" style="margin-bottom:0px">
            Konseling
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input opsiterapi" type="radio" name="opsiresep" id="opsiterapi2" value="resep luar">
        <label class="form-check-label" for="opsiterapi2">
            Resep Luar
        </label>
    </div>
    <input type="text" name="ket_resep_luar" class="form-control terapi_luar_text" placeholder="Tulisakan keterangan therapy luar" style="display:none"/>
</div>

<div class="terapi_konseling_div">
    <table class="table-judul">
        <tr>
            <th width="9%">RACIKAN</th>
            <th width="50%">NAMA OBAT</th>
            <th class="shows">SIGNA</th>
            <th width="7%">JUMLAH</th>
            <th>ANJURAN</th>
            <th width="5%"></th>
        </tr>
        <tr>
            <td width="9%">
                <select class="form-control status_racikan_bpjs" name="status_racikan">
                    <option value="false">Tidak</option>
                    <option value="true">Ya</option>										
                </select>
            </td>
            <td width="35%">
                <input type="text" class="form-control therapybpjs">
                <input type="hidden" class="form-control kodeobatlokal">
                <input type="hidden" class="form-control kodeobatbpjs">
                <input type="hidden" class="form-control nobatch">
                <input type="hidden" class="form-control namaobatbpjs">
                <input type="hidden" class="form-control sediaobatbpjs">
                <input type="hidden" name="catatanterapibpjs" class="form-control catatan-therapy-bpjs" readonly></textarea>
            </td>
            <td width="15%" class="shows">
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" name="dosisbpjs1" class="form-control dosisbpjs1" maxlength="3">					
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="dosisbpjs2" class="form-control dosisbpjs2" maxlength="5">								
                    </div>
                </div>	
            </td>
            <td width="10%">
                <input  type="number" name="jumlahbpjs" class="form-control jumlahbpjs">
            </td>
            <td class="shows">
                <select class="form-control anjuranterapi chosenselect">
                    <option value="">--Pilih--</option>
                    <option value="Lainnya">Lainnya</option>
                    <?php
                    $dtanjuranary = mysqli_query($koneksi, "SELECT Anjuran FROM `tbapotikanjuran` order by IdAnjuran");
                    while($dtanjuran = mysqli_fetch_assoc($dtanjuranary)){
                        echo "<option value='$dtanjuran[Anjuran]'>$dtanjuran[Anjuran]</option>";
                    }
                    ?>
                </select>
            </td>
            <td colspan="2" style="display: none;" class="ket_racikantr">
                <input type="text" class="form-control ket_racikan" name="ket_racikan" placeholder="m.f.pulv"/>
            </td>
            <td  width="5%" align="center">
                <button type="button" class="btn btn-round btn-success tambah-therapy-bpjs"><i class="fa fa-plus btnadd"></i></button>
            </td>
        </tr>
        <tr style="display: none" class="formanjuranlainnya">
            <td colspan="5"><input type="text" class="form-control anjuranterapilain"></td>
        </tr>						
    </table>
    <br/>
    <div class="table-responsive">
        <table class="table-judul" width="100%">
            <thead>
                <tr class="head-table-therapy-bpjs">
                    <th class="col-sm-1">Kode</th>	
                    <th class="col-sm-1">Racikan</th>	
                    <th class="col-sm-3">Nama Obat</th>						
                    <th class="col-sm-1">NoBatch</th>																		
                    <th class="col-sm-1">Jml</th>
                    <th class="col-sm-1">Dosis</th>
                    <th class="col-sm-2">Anjuran</th>
                    <th class="col-sm-1">Opsi</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                // tbresepdetail
                $kodepuskesmas = $_SESSION['kodepuskesmas'];
                $namapuskesmas = $_SESSION['namapuskesmas'];
                $tbapotikstok = "tbapotikstok_".str_replace(' ', '', $namapuskesmas);
                if($kota == 'KABUPATEN SUKABUMI'){
                    $strresep = "SELECT * FROM `$tbresepdetail` WHERE `IdPasienrj`='$idpasienrj' AND `Pelayanan`='$pelayanan'";
                }else{
                    $strresep = "SELECT * FROM `$tbresepdetail` WHERE `IdPasienrj`='$idpasienrj' AND `Pelayanan`='$pelayanan' GROUP BY NoResep, KodeBarang";
                }
                // echo $strresep;
                $query_resep = mysqli_query($koneksi, $strresep);
                while($dtresep = mysqli_fetch_assoc($query_resep)){	
                    $kdbarang = $dtresep['KodeBarang'];
                    $nobatch = $dtresep['NoBatch'];
                    
                    $strobat = "SELECT * FROM `$tbapotikstok` WHERE `KodeBarang`='$kdbarang'";
                    $dtgfk = mysqli_fetch_assoc(mysqli_query($koneksi, $strobat));
                    $dtkdbarangbpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT KodeBarangBpjs FROM `tbgfkstok` WHERE `KodeBarang` = '$kdbarang' AND `NoBatch`='$nobatch'"));
                ?>
                <tr>
                    <input type="hidden" class="kodeobatlokal-input" value="<?php echo $dtresep['KodeBarang'];?>"> <!--name="kodeobatlokal"-->
                    <input type="hidden" class="kodeobatbpjs-input" value="<?php echo $dtkdbarangbpjs['KodeBarangBpjs'];?>">
                    <input type="hidden" class="kodeobatskbpjs-input" value="<?php echo $dtresep['KdObatSk'];?>">
                    <input type="hidden" class="anjuranterapi-input" value="<?php echo $dtresep['AnjuranResep'];?>">
                    <input type="hidden" class="namaobatbpjs-input" value="<?php echo $dtgfk['NamaBarang'];?>">
                    <input type="hidden" class="ket_racikan-input" value="<?php echo $dtresep['KeteranganRacikan'];?>">
                    <input type="hidden" class="nobatch-input" value="<?php echo $dtresep['NoBatch'];?>">
                    <td align="center" class="kodeobatlokal-html"><?php echo $dtgfk['KodeBarang'];?></td>
                    <td align="left" class="status_racikan_bpjs-html">
                        <?php 
                            if($dtresep['racikan'] == 'true'){
                                echo "Ya";
                            }else{
                                echo "Tidak";
                            }										
                        ?>											
                    </td>
                    <td align="left" class="namaobatbpjs-html"><?php echo $dtgfk['NamaBarang'];?>, Ket: <?php echo $dtresep['KeteranganRacikan'];?></td>
                    <td align="left" class="nobatch-html"><?php echo $dtgfk['NoBatch'];?></td>									
                    <td align="right" class="jumlahbpjs-html"><?php echo $dtresep['jumlahobat'];?></td>
                    <td align="center" class="dosisbpjs-html"><?php echo $dtresep['signa1']." X ".$dtresep['signa2'];?></td>
                    <td align="left" class="anjuranterapi-html"><?php echo $dtresep['AnjuranResep'];?></td>
                    <td align="center">
                        <button class="btn btn-round btn-danger hapus-therapy-bpjs"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                <?php
                }
                ?>

                <!-- buat simpan data sementara -->
                <tr class="master-table-therapy-bpjs" style="display:none">
                    <input type="hidden" class="kodeobatlokal-input">
                    <input type="hidden" class="kodeobatbpjs-input">
                    <input type="hidden" class="nobatch-input">
                    <input type="hidden" class="status_racikan_bpjs-input">
                    <input type="hidden" class="namaobatbpjs-input">
                    <input type="hidden" class="namaobatnonbpjs-input">
                    <input type="hidden" class="jumlahbpjs-input">
                    <input type="hidden" class="dosisbpjs1-input">
                    <input type="hidden" class="dosisbpjs2-input">
                    <input type="hidden" class="anjuranterapi-input">
                    <input type="hidden" class="ket_racikan-input">
                    <td align="center" class="kodeobatlokal-html"></td>
                    <td align="center" class="status_racikan_bpjs-html"></td>
                    <td align="left" class="namaobatbpjs-html"></td>
                    <td align="center" class="nobatch-html"></td>
                    <td align="right" class="jumlahbpjs-html"></td>
                    <td align="center" class="dosisbpjs-html"></td>
                    <td align="center" class="anjuranterapi-html"></td>
                    <td align="center" >
                        <button class="btn btn-round btn-danger hapus-therapy-bpjs"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>

                <input type="hidden" name="kdobathapus" class="hapusobat">
                <input type="hidden" name="kdobathapusbpjs" class="hapusobatbpjs">
            </tbody>	
        </table>
    </div><hr/>
</div>
<hr/>
<!--planning-->
<p style="font-size: 20px; font-weight: bold;" class="judul">Rencana Pengelolaan (Planning)</p>
<table class="table-judul" width="100%">
    <tr>
        <td class="col-sm-3">Rencana Pengelolaan</td>
        <td class="col-sm-9"><textarea name="rencanapengelolaan" class="form-control inputan onfocusoutvalidation"><?php echo "Tidak Ada"?></textarea></td>
    </tr>
    <tr>
        <td>Informasi ESO</td>
        <td><textarea name="informasieso" class="form-control inputan onfocusoutvalidation"><?php echo "Tidak Ada"?></textarea></td>
    </tr>
    <tr>
        <td>Edukasi</td>
        <td><textarea name="edukasi" class="form-control inputan onfocusoutvalidation"><?php echo "Tidak Ada"?></textarea></td>
    </tr>
    <tr>
        <td>
            Terapi Obat
            <?php if(substr($datapasienrj['Asuransi'],0,4) == 'BPJS'){?>
                <span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
                <img src='image/logo_bpjs_bulet.png' width="30px"/> 9 
                </span>
            <?php } ?>
        </td>
        <td><textarea name="terapiobat" class="form-control inputan onfocusoutvalidation terapiobat_planing"><?php echo "Tidak Ada"?></textarea></td>
    </tr>
    <tr>
        <td>
            Terapi Non Obat
            <?php if(substr($datapasienrj['Asuransi'],0,4) == 'BPJS'){?>
                <span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
                <img src='image/logo_bpjs_bulet.png' width="30px"/> 10 
                </span>
            <?php } ?>
        </td>
        <td><textarea name="terapinonobat" class="form-control inputan onfocusoutvalidation"><?php echo "Tidak Ada"?></textarea></td>
    </tr>
    <tr>
        <td>
            Bmhp
            <?php if(substr($datapasienrj['Asuransi'],0,4) == 'BPJS'){?>
                <span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
                <img src='image/logo_bpjs_bulet.png' width="30px"/> 11
                </span>
            <?php } ?>
        </td>
        <td><textarea name="bmhp" class="form-control inputan onfocusoutvalidation"><?php echo "Tidak Ada"?></textarea></td>
    </tr>
</table>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/jquery.autocomplete.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
        // var opsiterapi = $("input[name='opsiresep']:checked").val();
        // if(opsiterapi == 'diberikan resep'){
        //     var kodeobatlokal = $(".kodeobatlokal-input").val();
        //     if(kodeobatlokal == ''){
        //         $(".modalbody-alert").text('Silahkan isi Therapy terlebih dahulu...');
        //         $("#alert-modal").modal('show');
        //         $("#pemeriksaan1").click();
        //         $(".anamnesa").focus();
        //         return false;
        //     }
        // }else if(opsiterapi == 'resep luar'){
        //     var terapi_luar_text = $(".terapi_luar_text").val();
        //     if(terapi_luar_text == ''){
        //         $(".modalbody-alert").text('Silahkan isi Therapy, Keterangan Resep Luar terlebih dahulu...');
        //         $("#alert-modal").modal('show');
        //         $("#pemeriksaan1").click();
        //         $(".anamnesa").focus();
        //         return false;
        //     }
        // }	
        
        // $(".opsiterapi").change(function(){
		// 	var isi = $(this).val();
		// 	if(isi == 'konseling'){
		// 		$(".terapi_luar_text").hide();
		// 		$(".terapi_konseling_div").hide();
		// 	}else if(isi == 'resep luar'){
		// 		$(".terapi_konseling_div").hide();
		// 		$(".terapi_luar_text").show();
		// 	}else{
		// 		$(".terapi_konseling_div").show();
		// 		$(".terapi_luar_text").hide();
		// 	}		
		// });
    });
</script>
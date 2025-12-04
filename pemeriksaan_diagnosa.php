<h3 class="judul"><b>Diagnosa (Assesment)</b></h3>
    <div class="table-responsive">
        <table class="table-konten" width="100%">
            <tr>
                <td class="col-sm-8">
                    <input type="text" class="form-control diagnosabpjs inputan" placeholder="Ketikan Kode / Nama Diagnosa">
                    <input type="hidden" class="form-control kodebpjs">
                    <input type="hidden" class="form-control diagnosahiddenbpjs">
                    <input type="hidden" class="form-control spesialisbpjs">
                </td>
                <td class="col-sm-2">
                    <select name="kasus" class="form-control kasusbpjs inputan">
                        <option value="">--Kasus--</option>
                        <option value="Baru">Baru</option>
                        <option value="Lama">Lama</option>
                    </select>
                </td>
                <td class="col-sm-2">
                    <select name="kelompok" class="form-control kelompok inputan">
                        <option value="">--Kelompok--</option>
                        <option value="1">Primary</option>
                        <option value="2">Sekunder 1</option>
                        <option value="3">Sekunder 2</option>
                        <option value="4">Sekunder 3</option>
                        <option value="5">Komplikasi</option>
                    </select>
                </td>
                <td><buttom type="button" class="btn btn-success tambah-diagnosa-bpjs"><i class="fa fa-plus"></i></buttom></td>
            </tr>
        </table>
    </div><br/>
    <div class="table-responsive">
        <table class="table-judul" width="100%">
            <thead>
                <tr class="head-table-bpjs">
                    <th width="8%">Kode</th>
                    <th width="30%">Diagnosa</th>
                    <th width="10%">Kasus</th>
                    <th width="10%">Kelompok</th>
                    <th width="6%">#</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                // tbdiagnosapasien
                $tbdiagnosapasien = "tbdiagnosapasien_".str_replace(' ', '', $namapuskesmas);	
                $kasus_diagnosa = "SELECT b.NonSpesialis, a.Kelompok as Kelompok, a.KodeDiagnosa as KodeDiagnosa, b.Diagnosa as NamaDiagnosa, a.Kasus as Kasus 
                FROM `$tbdiagnosapasien` a join tbdiagnosabpjs b on a.KodeDiagnosa = b.KodeDiagnosa 
                WHERE a.IdPasienrj = '$idpasienrj'  GROUP BY a.KodeDiagnosa";
                // echo $kasus_diagnosa;
                
                $query_kasus_diagnosa = mysqli_query($koneksi,$kasus_diagnosa);
                while($dtdiagnosa = mysqli_fetch_assoc($query_kasus_diagnosa)){
                if($dtdiagnosa['Kelompok'] == 1){
                    $kelompokname = 'Primary';
                }else if($dtdiagnosa['Kelompok'] == 2){
                    $kelompokname = 'Sekunder 1';
                }else if($dtdiagnosa['Kelompok'] == 3){
                    $kelompokname = 'Sekunder 2';	
                }else if($dtdiagnosa['Kelompok'] == 4){
                    $kelompokname = 'Sekunder 3';	
                }else{
                    $kelompokname = 'Komplikasi';
                }
                
                //array kode diagnosa
                $arraykodediagnosa[] = $dtdiagnosa['KodeDiagnosa'];
                
                //pernafasan
                if($dtdiagnosa['KodeDiagnosa'] == 'J18.9'){
                    $class = 'pernafasan';
                }else if($dtdiagnosa['KodeDiagnosa'] == 'J06.0'){
                    $class = 'pernafasan';
                //diare	
                }else if($dtdiagnosa['KodeDiagnosa'] == 'A03.0'){
                    $class = 'diare';
                }else if($dtdiagnosa['KodeDiagnosa'] == 'A09.0'){
                    $class = 'diare';
                }else if($dtdiagnosa['KodeDiagnosa'] == 'A09.0'){
                    $class = 'diare';
                //demam		
                }else if($dtdiagnosa['KodeDiagnosa'] == 'J00'){
                    $class = 'demam';
                }else if($dtdiagnosa['KodeDiagnosa'] == 'R50.0'){
                    $class = 'demam';
                    }
                ?>
                <tr class="newbaris <?php echo $class;?>">
                    <input type="hidden" class="kode-diagnosa-input" name="kodediagnosabpjs[]" value="<?php echo $dtdiagnosa['KodeDiagnosa'];?>">
                    <input type="hidden" class="nama-diagnosa-input" name="namadiagnosabpjs[]" value="<?php echo $dtdiagnosa['NamaDiagnosa'];?>">
                    <input type="hidden" class="kasus-diagnosa-input" name="kasusdiagnosabpjs[]" value="<?php echo $dtdiagnosa['Kasus'];?>">
                    <input type="hidden" class="kelompok-diagnosa-input" name="kelompokdiagnosa[]" value="<?php echo $dtdiagnosa['Kelompok'];?>">
                    <input type="hidden" class="spesialis-diagnosa-input"  value="<?php echo $dtdiagnosa['NonSpesialis'];?>">
                    <td align="center" class="kode-html"><?php echo $dtdiagnosa['KodeDiagnosa'];?></td>
                    <td align="left" class="diagnosa-html"><?php echo strtoupper($dtdiagnosa['NamaDiagnosa']);//get_nama_diagnosa($dtdiagnosa['KodeDiagnosa']);?></td>
                    <td align="center" class="kasus-html"><?php echo strtoupper($dtdiagnosa['Kasus']);?></td>
                    <td align="center" class="kelompok-html"><?php echo strtoupper($kelompokname);?></td>
                    <td align="center">
                        <button class="btn btn-round btn-danger hapus-diagnosa-edit"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                <?php
                }
                ?>

                <!-- buat simpan data sementara -->
                <tr class="master-table-bpjs" style="display:none">
                    <input type="hidden" name="kode" class="kode-diagnosa-input">
                    <input type="hidden" class="nama-diagnosa-input">
                    <input type="hidden" class="kasus-diagnosa-input">
                    <input type="hidden" class="kelompok-diagnosa-input">
                    <input type="hidden" class="spesialis-diagnosa-input">
                    <td align="center" class="kode-html"></td>
                    <td align="left" class="diagnosa-html"></td>
                    <td align="center" class="kasus-html"></td>
                    <td align="center" class="kelompok-html"></td>
                    <td align="center">
                        <button class="btn btn-round btn-danger hapus-diagnosa"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div><br/>
    <div class="form_tambahan">
    <?php
    if(isset($arraykodediagnosa)){
        if(in_array("A03.0", $arraykodediagnosa) || in_array("A06.0", $arraykodediagnosa) || in_array("A09", $arraykodediagnosa)){
            $datadiare = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosadiare` where NoRegistrasi = '$noregistrasi'"));
            include "form_diare.php";
        }else if(in_array("J18.0", $arraykodediagnosa) || in_array("J18.9", $arraykodediagnosa)|| in_array("J00", $arraykodediagnosa)|| in_array("J06.9", $arraykodediagnosa)){
            include "form_ispa.php";
        }else if(in_array("B05.9", $arraykodediagnosa)){
            include "form_campak.php";
        }else if(in_array("I10", $arraykodediagnosa) || in_array("I23", $arraykodediagnosa) || in_array("I64", $arraykodediagnosa) || in_array("E14.0", $arraykodediagnosa) || in_array("C53.9", $arraykodediagnosa)){
            $dataptm = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosaptm` where NoRegistrasi = '$noregistrasi'"));
            include "form_ptm.php";
        }
    }	
    ?>
    </div>
<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";
    $namapegawai = $_SESSION['nama_petugas'];
    $hariini = date('Y-m-d');

    // tbpuskesmas
    $dtpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas`='$kodepuskesmas'"));

    if($_POST['btnsimpan'] == 'simpan'){
       

        include "config/helper.php";
        $idpasien = $_POST['idpasien'];
        $idpasienrj  = $_POST['idpasienrj'];
        $tanggalawal = date('Y-m-d', strtotime($_POST['tanggalawal']))." ".date('G:i:s');
        $tanggalakhir = date('Y-m-d', strtotime($_POST['tanggalakhir']))." ".date('G:i:s');
        $nomorsurat = $_POST['nomorsurat'];
        $ditujukan = $_POST['ditujukan'];
        $diagnosa = $_POST['diagnosa'];
        $tindakan = $_POST['tindakan'];
        $keterangan = $_POST['keterangan'];
        $namadokter = $_POST['namadokter'];	

        // if($_POST['tanggalawal'] == $_POST['tanggalakhir']){
        //     alert_swal('gagal','Data gagal disimpan, Tanggal tidak boleh sama!');
        //     echo "<script>";
        //     echo "document.location.href='index.php?page=pemeriksaan_surat_sakit&idrj=$idpasienrj';";
        //     echo "</script>";
        //     die();
        // }

        if($_POST['tanggalawal'] > $_POST['tanggalakhir']){
            alert_swal('gagal','Data gagal disimpan, Tanggal tidak valid!');
            echo "<script>";
            echo "document.location.href='index.php?page=pemeriksaan_surat_sakit&idrj=$idpasienrj';";
            echo "</script>";
            die();
        }
        
        // tbpasienrj
        $dataregistrasi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'"));	
        $pelayanan = $dataregistrasi['Poli'];  

        // tbsurat
        $str = "INSERT INTO `$tbsuratsakit`(`IdPasienrj`, `IdPasien`, `TanggalPeriksa`, `TanggalAkhir`, `NomorSurat`,
        `Ditujukan`, `Diagnosa`, `Tindakan`, `Keterangan`, `NamaDokter`) 
        VALUES ('$idpasienrj','$idpasien','$tanggalawal','$tanggalakhir','$nomorsurat','$ditujukan','$diagnosa',
        '$tindakan','$keterangan','$namadokter')";
        $query = mysqli_query($koneksi,$str);
        $idsurat = mysqli_insert_id($koneksi);

        // update nomorsurat
        $nomorsurat = $idsurat."/".$dtpuskesmas['NomorSuratSakit'];    
        mysqli_query($koneksi, "UPDATE $tbsuratsakit SET `NomorSurat`='$nomorsurat' WHERE `IdSuratSakit`='$idsurat'");

        if($query){
            alert_swal('sukses','Data berhasil disimpan..');
            echo "<script>";
            echo "document.location.href='index.php?page=pemeriksaan_surat_sakit&idrj=$idpasienrj';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan..');
            echo "<script>";
            echo "document.location.href='index.php?page=pemeriksaan_surat_sakit&idrj=$idpasienrj';";
            echo "</script>";
        }
    }else{

    $idpasien = $_GET['idpsn'];
    $idpasienrj = $_GET['idrj'];
    $pelayanan = $_GET['pelayanan'];
    // tbpasienrj
    $dataregistrasi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'"));	
    $asuransi = $dataregistrasi['Asuransi'];
    
?>

<div class="tableborderdiv">
    <form action="pemeriksaan_surat_sakit.php" method="post">
        <input type="hidden" name="idpasien" value="<?php echo $dataregistrasi['IdPasien'];?>">
        <input type="hidden" name="idpasienrj" value="<?php echo $dataregistrasi['IdPasienrj'];?>">
        <input type="hidden" name="pelayanan" value="<?php echo $pelayanan;?>">
        <div class = "row">
            <div class="col-sm-12">
                <div class="formbg mt-2">
                    <a href="index.php?page=suratketerangan&idrj=<?php echo $idpasienrj;?>" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
                    <p style="font-size: 18px; font-weight: bold;" class="judul">Surat Keterangan Sakit</p>
                    <div class="table-responsive">
                        <table class="table-konten" width="100%">
                            <tr>
                                <td class="col-sm-2">Nomor Surat</td>
                                <td class="col-sm-10">
                                    <div class="btn-group btn-block">
                                        <input type="text" name="nomorsurat" class="form-control inputan" value="<?php echo $dtpuskesmas['NomorSuratSakit'];?>" readonly>
                                        <a href="#" class="btn btn-primary btnmodalnomorsurat" data-idpasienrj="<?php echo $dataregistrasi['IdPasienrj'];?>">Nomor Surat</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal Awal</td>
                                <td>
                                    <input type="date" name="tanggalawal" class="form-control inputan" value="<?php echo $hariini;?>" autofocus>
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal Akhir</td>
                                <td>
                                    <input type="date" name="tanggalakhir" class="form-control inputan" value="<?php echo $hariini;?>" autofocus>
                                </td>
                            </tr>
                            <tr>
                                <td>Ditujukan</td>
                                <td><input type="text" name="ditujukan" class="form-control inputan"></td>
                            </tr>
                            <tr>
                                <td>Diagnosa</td>
                                <td><input type="text" name="diagnosa" class="form-control inputan"></td>
                            </tr>
                            <tr>
                                <td>Tindakan</td>
                                <td><input type="text" name="tindakan" class="form-control inputan"></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td><input type="text" name="keterangan" class="form-control inputan"></td>
                            </tr>
                            <tr>
                                <td>Dokter</td>
                                <td>
                                    <select name="namadokter" class="form-control inputan" required>
                                        <option value="">--Plih Dokter--</option>
                                        <?php
                                        $query = mysqli_query($koneksi, "SELECT * FROM `tbpegawai` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Status`='Dokter' ORDER BY `NamaPegawai`");
                                            while($datadokter = mysqli_fetch_assoc($query)){
                                                if($data['NamaDokter'] == $datadokter['NamaPegawai']){
                                                    echo "<option value='$datadokter[NamaPegawai]' SELECTED>$datadokter[NamaPegawai]</option>";
                                                }else{
                                                    echo "<option value='$datadokter[NamaPegawai]'>$datadokter[NamaPegawai]</option>";
                                                }
                                            }
                                            
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        </table><hr/>
                        <div class="row">
                            <div class="col-sm-6">
                                <button type="submit" name="btnsimpan" value="simpan" class="btn btn-round btn-success btnsimpan"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                            <div class="col-sm-6">
                                <a href="index.php?page=suratketerangan&idrj=<?php echo $idpasienrj;?>" class="btn btn-info btn-round btninfo">Kembali</a>
                            </div>
                        </div><br/>
                    </div>
                </div>
            </div>	
        </div>
    </form>

    <div class="row mt-2">
        <div class="col-sm-12">
            <p style="font-size: 18px; font-weight: bold;" class="judul">Data Pemeriksaan</p>
            <div class="table-responsive">
                <table class="table-judul">
                    <thead>
                        <tr>
                            <th width="5%">No.</th>
                            <th width="15%">Tanggal Periksa</th>
                            <th width="20%">NomorSurat</th>
                            <th width="30%">Ditujukan</th>
                            <th width="20%">Nama Dokter</th>
                            <th width="10%">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $jumlah_perpage = 20;

                        if($_GET['h']==''){
                            $mulai=0;
                        }else{
                            $mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
                        }
                    
                        // tahap 1, pilih kunjungan             
                        $idpasien = $dataregistrasi['IdPasien'];           
                        $str = "SELECT * FROM `$tbsuratsakit` WHERE `IdPasien` = '$idpasien'";
                        $str2 = $str." ORDER BY `IdSuratSakit` DESC LIMIT $mulai,$jumlah_perpage";
                        // echo $str2;
                                    
                        if($_GET['h'] == null || $_GET['h'] == 1){
                            $no = 0;
                        }else{
                            $no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
                        }
                        
                        $query = mysqli_query($koneksi, $str2);
                        while($data = mysqli_fetch_assoc($query)){
                            $no = $no + 1;
                            $idsurat = $data['IdSuratSakit'];
                            $dtpasien = $data['IdPasienrj'];

                            // cek tagihan
                           // $cektagihan = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbtagihan` a JOIN tbtagihan_detail b ON a.IdTagihan = b.IdTagihan WHERE a.`IdPasienrj` = '$idpasienrj' AND b.IdTindakan = '$data[IdTindakan]' AND b.StatusBayar = '1'"));
                        ?>
                            <tr>
                                <td align="center"><?php echo $no;?></td>
                                <td align="center"><?php echo $data['TanggalPeriksa'];?></td>                  
                                <td align="left"><?php echo $data['NomorSurat'];?></td>                  
                                <td align="left"><?php echo $data['Ditujukan'];?></td>                  
                                <td align="left"><?php echo $data['NamaDokter'];?></td>                  
                                <td align="left">
                                    <?php //if($cektagihan == 0){?>
                                    <a onClick="return confirm('Data ingin dihapus...?')" href="pemeriksaan_surat_sakit_hapus.php?idrj=<?php echo $idpasienrj;?>&idsurat=<?php echo $idsurat;?>" class="btn btn-sm btn-round btn-danger"><i class="fas fa-trash-alt"></i></a>
                                    <a href="cetak_surat_sakit.php?idrj=<?php echo $dtpasien;?>&idpsn=<?php echo $idpasien;?>" class="btn btn-sm btn-round btn-info" target="_blank"><i class="fas fa-print"></i></a>
                                    <?php //}?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <ul class="pagination mt-4 noprint">
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
                                    echo "<li><a href='?page=pemeriksaan_surat_sakit&tgl=$tgl&nama=$key&asuransi=$_GET[asuransi]&h=$i'>$i</a></li>";
                                }
                            }
                        }
                    ?>	
                </ul>
            </div>
        </div>
    </div>
    <?php
        }
    ?>
</div>

<!-- Modal tombol cetak -->
<div class="hasilmodal"></div>

<script src="assets/js/jquery-2.1.4.min.js"></script>	
<script>
$('.btnmodalnomorsurat').click(function(){
    var idpasienrj = $(this).data("idpasienrj");
    // alert(idpasienrj);	
    $.post( "get_nomorsurat_sakit.php", { id: idpasienrj })
    .done(function( data ) {
        $( ".hasilmodal" ).html( data );
        $('#modaleditdata').modal('show');
    });	
});
</script>

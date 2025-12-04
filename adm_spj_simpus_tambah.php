<div class="tableborderdiv">
	<div class = "row">	
        <div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DATA UMUM PEKERJAAN BRIDGING BPJS</b></h3>
			<div class = "formbg">
                <form action="adm_spj_simpus_tambah_proses.php" method="post" enctype="multipart/form-data">
                    <table class="table-judul" wiidth="100%">	
                        <tbody>	
                            <tr>
                                <td class="col-sm-4">Nama Paket Pekerjaan</td>
                                <td class="col-sm-8">
                                    <input type="text" name="namakegiatan" style="text-transform: uppercase;" class="form-control" Placeholder="Nama Kegiatan">								
                                </td>
                            </tr>
                            <tr>
                                <td>Kode Rekening Belanja (Uraian di RBA)</td>
                                <td>
                                    <input type="text" name="kodrek" style="text-transform: uppercase;" class="form-control" Placeholder="Kode Rekening Belanja (Uraian di RBA)">								
                                </td>
                            </tr>
                            <tr>
                                <td>Kode Rekening Belanja (Pdf)</td>
                                <td>
                                    <input type="file" name="kodrekpdf" class="form-control-file">
                                </td>
                            </tr>
                            <tr>
                                <td>Nilai Pagu</td>
                                <td>
                                    <input type="text" name="nilaipagu" style="text-transform: uppercase;" class="form-control" Placeholder="Misal : 15000000 (tanpa titik/koma)">								
                                </td>
                            </tr>
                            <tr>
                                <td>Satuan</td>
                                <td>
                                    <input type="text" name="satuan" style="text-transform: uppercase;" class="form-control" Placeholder="Satuan Kegiatan">								
                                </td>
                            </tr>
                            <tr>
                                <td>Nama & Nip Pejabat Keuangan</td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input  type="text" name="namapejabatkeuangan" style="text-transform: uppercase;" class="form-control" Placeholder="Nama">
                                        </div> 
                                        <div class="col-sm-6">
                                            <input  type="text" name="nipkeuangan" style="text-transform: uppercase;" class="form-control" Placeholder="Nip">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Nama & Nip Bendahara Pengeluaran BLUD</td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input  type="text" name="namabendahara" style="text-transform: uppercase;" class="form-control" Placeholder="Nama">
                                        </div>  
                                        <div class="col-sm-6">
                                            <input  type="text" name="nipbendahara" style="text-transform: uppercase;" class="form-control" Placeholder="Nip">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Kop Surat (Pdf)</td>
                                <td>
                                    <input type="file" name="kopsurat" class="form-control-file">
                                </td>
                            </tr>
                            <tr>
                                <td>Rup / Sirup (Pdf)</td>
                                <td>
                                    <input type="file" name="sirup" class="form-control-file">
                                </td>
                            </tr>
                            <tr>
                                <td>SK PPK (Pdf)</td>
                                <td>
                                    <input type="file" name="skppk" class="form-control-file">
                                </td>
                            </tr>
                            <tr>
                                <td>SK PPBJ (Pdf)</td>
                                <td>
                                    <input type="file" name="skppbj" class="form-control-file">
                                </td>
                            </tr>
                        </tbody>
                    </table><hr/>
                    <button type="submit" class="btn btn-round btn-success btnsimpan">Simpan</button>
                </form>
			</div>

            <h3 class="judul"><b>DATA PAKET PEKERJAAN</b></h3>
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table-judul">
                            <thead>
                                <tr>
                                    <th width="3%" rowspan="2">NO.</th>
                                    <th width="10%" rowspan="2">NAMA PUSKESMAS</th>
                                    <th width="12%" rowspan="2">NAMA PEKERJAAN</th>
                                    <th width="5%" colspan="2">NAMA PEJABAT</th>
                                    <th width="5%" colspan="5">FILE PDF</th>
                                    <?php if (in_array("PROGRAMMER", $otoritas)){ ?>
                                    <th width="5%" rowspan="2">OPSI</th>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <th width="15%">KEUANGAN</th>
                                    <th width="15%">BND.PENGELUARAN</th>
                                    <th width="5%">KODREK</th>
                                    <th width="5%">KOP SURAT</th>
                                    <th width="5%">RUP SIRUP</th>
                                    <th width="5%">SK PPK</th>
                                    <th width="5%">SK PPBJ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // $otoritas = explode(',',$_SESSION['otoritas']);                                
                                // if (in_array("PROGRAMMER", $otoritas)){
                                    $str = "SELECT * FROM `tbadmspj`";
                                    $str2 = $str." ORDER BY NamaPuskesmas ASC";
                                // }else{
                                //     $namapuskesmas = $_SESSION['namapuskesmas'];
                                //     $str = "SELECT * FROM `tbadmspj` WHERE `NamaPuskesmas`='$namapuskesmas'";
                                //     $str2 = $str." ORDER BY NamaPuskesmas ASC";
                                // }
                                // echo $str2;
                                // die();
                                
                                $query = mysqli_query($koneksi,$str2);
                                while($data = mysqli_fetch_assoc($query)){
                                    $no = $no + 1;
                                    $noindex = $data['NoIndex'];                                  
                                    
                                    $stsl = 'pdf';
                                    $cekpdf = strpos($data['KodeRekPdf'],'pdf');
                                    if ($cekpdf === false) {
                                        $stsl = 'img';
                                    }

                                    $stsl2 = 'pdf';
                                    $cekpdf = strpos($data['KodeRekPdf'],'pdf');
                                    if ($cekpdf === false) {
                                        $stsl2 = 'img';
                                    }

                                    $stsl3 = 'pdf';
                                    $cekpdf = strpos($data['KodeRekPdf'],'pdf');
                                    if ($cekpdf === false) {
                                        $stsl3 = 'img';
                                    }

                                    $stsl4 = 'pdf';
                                    $cekpdf = strpos($data['KodeRekPdf'],'pdf');
                                    if ($cekpdf === false) {
                                        $stsl4 = 'img';
                                    }

                                    $stsl5 = 'pdf';
                                    $cekpdf = strpos($data['KodeRekPdf'],'pdf');
                                    if ($cekpdf === false) {
                                        $stsl5 = 'img';
                                    }
                                ?>
                                    <tr>
                                        <td align="center"><?php echo $no;?></td>
                                        <td align="left">
                                            <?php echo $data['NamaPuskesmas'];?><br/>
                                            <?php if($data['Status']=='Proses'){?>
                                            <span class="badge badge-info" style='font-style: italic; padding: 10px;'><?php echo $data['Status']?></span><br/>
                                            <?php }elseif($data['Status']=='Sending'){?>
                                            <span class="badge badge-success" style='font-style: italic; padding: 10px;'><?php echo $data['Status']?></span><br/>
                                            <?php }elseif($data['Status']=='Refisi'){?>
                                            <span class="badge badge-danger" style='font-style: italic; padding: 10px;'><?php echo $data['Status']?></span><br/>
                                            <?php }?>
                                            <span class="badge badge-warning" style='font-style: italic; padding: 10px;'><?php echo $data['TanggalKirim']?></span><br/>
                                            <span class="badge badge-secondary" style='font-style: italic; padding: 10px; text-align: left;'><?php echo str_replace(",","<br/>",$data['Keterangan'])?></span>
								
                                        </td>
                                        <td align="left"><?php echo "<b>".$data['NamaPaketPekerjaan']."</b><br/>".$data['KodeRekening']."<br/>".rupiah($data['NilaiPagu'])."<br/>".$data['Satuan'];;?></td>
                                        <td align="left"><?php echo strtoupper($data['NamaKeuangan'])."<br/>".$data['NipKeuangan'];?></td>
                                        <td align="left"><?php echo strtoupper($data['NamaBendahara'])."<br/>".$data['NipBendahara'];?></td>
                                        <td align="center">
                                            <a href="#" class="btn btn-round btn-info btn-sm btnlihat" data-img="spjsimpus/<?php echo $data['KodeRekPdf'];?>" data-stsl="<?php echo $stsl;?>">Lihat</a>
										</td>
                                        <td align="center">
                                            <a href="#" class="btn btn-round btn-info btn-sm btnlihat" data-img="spjsimpus/<?php echo $data['KopSurat'];?>" data-stsl="<?php echo $stsl2;?>">Lihat</a>
										</td>
                                        <td align="center">
                                            <a href="#" class="btn btn-round btn-info btn-sm btnlihat" data-img="spjsimpus/<?php echo $data['Sirup'];?>" data-stsl="<?php echo $stsl3;?>">Lihat</a>
										</td>
                                        <td align="center">
                                            <a href="#" class="btn btn-round btn-info btn-sm btnlihat" data-img="spjsimpus/<?php echo $data['SkPpk'];?>" data-stsl="<?php echo $stsl4;?>">Lihat</a>
										</td>
                                        <td align="center">
                                            <a href="#" class="btn btn-round btn-info btn-sm btnlihat" data-img="spjsimpus/<?php echo $data['SkPpbj'];?>" data-stsl="<?php echo $stsl5;?>">Lihat</a>
										</td>
                                        <?php if (in_array("PROGRAMMER", $otoritas)){ ?>
                                        <td align="center">
                                            <a onClick="return confirm('Data ingin di Hapus...?')" href="?page=adm_spj_simpus_delete&idspj=<?php echo $data['IdSpj'];?>&fotolama_kodrek=<?php echo $data['KodeRekPdf'];?>" data-ketconfirm="Apakah data ini akan dihapus?" class="btn btn-sm btn-round btn-danger">Hapus</a>
							            </td>
                                        <?php } ?>                                                      		
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
</div>

<div class="modal modal_prv" tabindex="-1">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Lihat Dokumen</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" height="70%">
            <img src="" class="img-fluid imgmodal" style="width:100%">
            <!-- <object data="" class="pdfmodal" type="application/pdf" width="100%" height="100%" style="display:none">
                <p><a href="" class="pdflink">to the PDF!</a></p>
            </object> -->
            <embed src="" class="pdfmodal" width="500" height="375" />
        </div>
        <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>

<script src="assets/js/jquery.js"></script>
<script src="assets/bootstrap-dist/js/bootstrap.min.js"></script>
<script>
    $(".btnlihat").click(function(){
        var srcval = $(this).data('img');
        var stsl = $(this).data('stsl');
        if(stsl == 'img'){
            $(".imgmodal").show();
            $(".pdfmodal").hide();
            $(".imgmodal").attr('src',srcval);
        }else{
            $(".imgmodal").hide();
            $(".pdfmodal").show();
            $(".pdfmodal").attr('src',srcval);
           // $(".pdflink").attr('href',srcval);
        }
        $(".modal_prv").modal('show');
    });
</script>




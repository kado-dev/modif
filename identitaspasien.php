<?php
    // tbpasienrj
    $idpasienrj = $_GET['idrj'];
    $query = mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'");
    $datapasienrj = mysqli_fetch_assoc($query);
 ?>

<div class="page-inner mt-0">	
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <b><?php echo strtoupper($datapasienrj['NamaPasien']);?></b>
                        <div><h4><b><i class="fas fa-check-circle"></i> <?php echo substr($datapasienrj['NoIndex'],-10);?></b></h4></div>
                        <div><h4><b><i class="fas fa-tags"></i> <?php echo $datapasienrj['Klaster']." - ".$datapasienrj['SiklusHidup'];?></b></h4></div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
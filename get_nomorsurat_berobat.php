<?php
	session_start();
	include "config/koneksi.php";
    include "config/helper_pasienrj.php";
	$idpasienrj = $_POST['id'];
    $str = "SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas`='$kodepuskesmas'";
	$query = mysqli_query($koneksi, $str);
	$data = mysqli_fetch_assoc($query);
?>

<style>
.modal-dialog {
    position: fixed; /* Posisi tetap di layar */
    top: 40%;
    left: 40%;
    transform: translate(-50%, -50%); Posisikan di tengah layar
    background-color: white;
    /* padding: 20px !important; */
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    z-index: 999;  /* Modal di atas backdrop */
    width: 300px;
    height: 170px;
    overflow: hidden !important; /* Hide scrollbars */
}
</style>

<div class="modal fade" id="modaleditdata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
            <form class="form-horizontal" action="get_nomorsurat_berobat_edit.php" method="post" role="form">
                <div class="modal-header" style="margin-bottom: -20px; border: none;">
                    <h5>Nomor Surat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="text" name="nomorsurat" class="form-control inputan" placeholder="Format Nomor Surat" value="<?php echo $data['NomorSuratSehat'];?>">
					<button type="submit" class="btn btn-success btn-block mt-1">Simpan</button>
                </div>	
                <input type="hidden" name="kodepuskesmas" class="form-control" value="<?php echo $kodepuskesmas;?>">
                <input type="text" name="idrj" class="form-control" value="<?php echo $idpasienrj;?>">
            </form>
		</div>
	</div>
</div>
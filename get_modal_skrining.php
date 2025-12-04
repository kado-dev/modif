<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
    $kodepuskesmas = $_SESSION['kodepuskesmas'];
    $namapuskesmas = str_replace(' ', '', $_SESSION['namapuskesmas']);

	$namafileskrining = "tb".$_POST['id']."_".$namapuskesmas;

    $klaster = $_POST['klaster'];
    $siklus = $_POST['siklushidup'];
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];

	$otoritas = explode(',',$_SESSION['otoritas']);
	

	error_reporting(0);


    if($_POST['bulan'] == null){
		$bln = date('m');
	}else{
		$bln = $_POST['bulan'];
	}	

    if($_POST['tahun'] == null){
		$thn = date('Y');
	}else{
		$thn = $_POST['tahun'];
	}	
	
	
    $strfilterklaster = "";
    if($_POST['klaster'] != null && $_POST['siklushidup'] != null){
        $strfilterklaster = " AND b.Klaster = '$_POST[klaster]' AND b.SiklusHidup = '$_POST[siklushidup]'";
    }
?>

<!--untuk menampilkan modal-->
<div class="modal fade" id="modalskrining" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Lihat Data Skrining</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
                <table class="table-judul" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">No.</th>
                            <th width="15%">Nik</th>
                            <th width="35%">Nama Pasien</th>
                            <th width="10%">Jenis Kelamin</th>                            
                            <th width="10%">Tanggal Lahir</th>
                            <th >Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
 

                            $str = "SELECT a.IdPasienrj, b.NoIndex, b.NamaPasien, b.TanggalLahir, b.Nik, b.JenisKelamin FROM `$namafileskrining` a JOIN $tbpasienrj b ON a.IdPasienrj = b.IdPasienrj WHERE MONTH(b.`TanggalRegistrasi`) = '$bln' AND YEAR(b.`TanggalRegistrasi`) = '$thn'".$strfilterklaster;
                            // echo "hasil".$str;
                       

                            $query = mysqli_query($koneksi, $str);
                            while($data = mysqli_fetch_assoc($query)){
                                //get alamat
                                $gealamat = mysqli_query($koneksi,"SELECT * FROM `tbkk_linggar` WHERE NoIndex = '$data[NoIndex]'");
                                $alamat = "";
                                if(mysqli_num_rows($gealamat) > 0){
                                    $dtalamat = mysqli_fetch_assoc($gealamat);
                                    $alamat = $dtalamat['Alamat'];
                                }

                                    $no = $no + 1;
                                
                       ?>
                             <tr>
                                <td><?php echo $no;?></td>
                                <td><?php echo $data['Nik'];?></td>
                                <td><?php echo $data['NamaPasien'];?></td>
                                <td><?php echo $data['JenisKelamin'];?></td>
                                <td><?php echo $data['TanggalLahir'];?></td>
                                <td><?php echo $alamat;?></td>
                            </tr>
                        <?php } ?>
                    </tbody>

                   
                </table>			
			</div>
		</div>
	</div>
</div>
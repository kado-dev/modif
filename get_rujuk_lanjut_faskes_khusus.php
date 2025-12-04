<style>
	.pilihfaskes{
		cursor:pointer
	}
	.pilihfaskes:hover{
		background:yellow;
	}
</style>
<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	include "config/helper_bpjs_v4.php";	

	
$kdkhusus = $_POST['kdkhusus'];
$subspesialis = $_POST['subspesialis'];
$nokartubpjs = $_POST['nokartubpjs'];
$tgl = date('d-m-Y',strtotime($_POST['tgl']));
//if($_SESSION['koneksi_bpjs'] == 'Stabil'){
	$data_faskes = get_data_referensi_faskes_khusus($kdkhusus,$subspesialis,$tgl,$nokartubpjs);
	//echo $data_faskes;
	$dtfaskes = json_decode($data_faskes,True);	
	if($dtfaskes['metaData']['code'] == 500 || $dtfaskes['metaData']['code'] == 428 || $dtfaskes['metaData']['code'] == 401){
		$pesan = $dtfaskes['metaData']['message'];
		echo "<p style='background:yellow;padding:8px 18px'>".$pesan."</p>";
	}else{
	
		$list = $dtfaskes['response']['list'];
		if($list == ""){
			echo "<div class='alert alert-danger'>Tidak ada rumah sakit yang sesuai poli</div>";
		}else{
?>
		<table class="table table-condensed">
			<thead>
				<tr>
					<th>No</th>
					<th>Faskes</th>
					<th>Kelas</th>
					<th>Kantor</th>
					<th>Alamat</th>
					<th>Telp</th>
					<th>Jarak</th>
					<th>Total Rujukan</th>
					<th>Jadwal</th>
					<th>Opsi</th>
				</tr>
			</thead>
			<tbody>
		<?php

				$no = 0;
					foreach($list as $ket){
					$no = $no + 1;
						echo "<tr class='pilihfaskes'>";
						echo "<td>".$no."</td>";
						echo "<td class='namappk'>".$ket['nmppk']."</td>";
						echo "<td>".$ket['kelas']."</td>";
						echo "<td>".$ket['nmkc']."</td>";
						echo "<td>".$ket['alamatPpk']."</td>";
						echo "<td>".$ket['telpPpk']."</td>";
						echo "<td>".$ket['distance']."</td>";
						echo "<td>".$ket['jmlRujuk']."</td>";
						echo "<td>".$ket['jadwal']."</td>";
						echo "<td><input type='radio' class='pilihradio' name='faskes' value='".$ket['kdppk']."'></td>";
						echo "</tr>";
					}
				
				
		?>	
			</tbody>
		</table>
<?php
		}
	}
//}
?>
<script>
	$('.pilihfaskes').click(function(){
		$('.pilihfaskes').css( "background-color", "white" );
		$(this).css( "background-color", "red" );
		$(this).find('.pilihradio').prop('checked',true);
		$(".namars").val($(this).find(".namappk").text());
	});
</script>
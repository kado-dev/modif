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

	$kdsubspesialis = $_POST['kdsubspesialis'];
	// echo $kdsubspesialis;
	$kdsarana = $_POST['kdsarana'];
	$tgl = date('d-m-Y',strtotime($_POST['tgl']));
	//echo $tgl;
//	if($_SESSION['koneksi_bpjs'] == 'Stabil'){
	$data_faskes = get_data_referensi_faskes_spesialis($kdsubspesialis,$kdsarana,$tgl);
	 // echo $data_faskes;
	 // die();
	$dtfaskes = json_decode($data_faskes,True);

		$list = $dtfaskes['response']['list'];
		if($list == ""){
			echo "<div class='alert alert-danger'>Tidak ada rumah sakit yang sesuai poli</div>";
		}else{
?>
<table class="table table-condensed" width="100%">
	<thead>
		<tr>
			<th width="2%">NO.</th>
			<th width="18%">FASKES</th>
			<th width="5%">KELAS</th>
			<!--<th width="10%">KANTOR</th>-->
			<th width="15%">ALAMAT</th>
			<th width="5%">JARAK</th>
			<th width="10%">TTL.RUJUKAN</th>
			<th width="10%">KAPASITAS</th>
			<th width="5%">(%)</th>
			<th width="10%">JADWAL</th>
			<th width="5%">#</th>
		</tr>
	</thead>
	<tbody>
<?php
			$no = 0;
			foreach($list as $ket){
			$no = $no + 1;
				echo "<tr class='pilihfaskes'>";
				echo "<td>".$no."</td>";
				echo "<td class='namappk'>".strtoupper($ket['nmppk'])."</td>";
				echo "<td align='center'>".$ket['kelas']."</td>";
				// echo "<td>".$ket['nmkc']."</td>";
				echo "<td>".$ket['alamatPpk'].", Telp.".$ket['telpPpk']."</td>";
				echo "<td align='center'>".round($ket['distance'] / 1000 ,2)."KM</td>";
				echo "<td align='center'>".$ket['jmlRujuk']."</td>";
				echo "<td align='center'>".$ket['kapasitas']."</td>";
				echo "<td align='center'>".$ket['persentase']."</td>";
				echo "<td>".$ket['jadwal']."</td>";
				echo "<td align='center'><input type='radio' class='pilihradio' name='faskes' value='".$ket['kdppk']."'></td>";
				echo "</tr>";
			}
?>	
	</tbody>
</table>
<?php
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
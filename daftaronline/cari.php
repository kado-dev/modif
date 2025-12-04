<style type="text/css">
	@media (max-width: 576px) {
		.kolomkonten2 h3{
			font-size: 14px
		}
	}	
</style>
<div class="kolomkonten2">
	<h3 align="center" style="border-bottom: 1px solid #ddd;margin-bottom: 20px;padding-bottom: 10px">PUSKESMAS <?php echo $_GET['simpus'];?></h3>
	<form class="form-inline formnik" action="index.php?page=cari_pasien" method="post">
		<input type="hidden" name="kode" value="<?php echo $_GET['kode'];?>"/>
		<input type="hidden" name="simpus" value="<?php echo $_GET['simpus'];?>"/>
		<input name="id" type="text" value="" class="form-control input-lg" placeholder="Ketikan Nomer (Kartu Berobat/BPJS/NIK)"/>
		<button name="button" type="submit" class="btn btn-primary btns">CARI</button>
	</form>
</div>
<script>
	$(".btn-ddd").click(function(){
		var input = $(".input-lg").val();
		if(input == ''){
			alert("Silahkan di isi");
		}else{
			$(".form-inline").submit();
		}
	});
</script>


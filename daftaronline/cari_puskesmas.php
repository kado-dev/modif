<style>
	.btnlengkung{
		border-radius:20px;
	}
	.bggreen{
		background:green;
		padding:15px 40px;
		min-height:650px;
	}
	.datapasien{
		background: #fff;padding:10px;margin-bottom: 20px;min-height: 300px
	}
	.formpuskesmas{
		margin-bottom: 10px;
	}
	.formpuskesmas input{
		border-radius: 15px; width: calc(100% - 90px) !important;
	}
	.listpuskesmas{
		width: 100%;
	}
	.listpuskesmas tr td{
		padding:10px;background: #f5f5f5;border-bottom: 1px solid #ddd;
	}
</style>

<div class="row">

	<div class="col-sm-12" style="padding-top: 30px">
		<form class="form-inline formpuskesmas" action="index.php?page=cari_pasien" method="post">
			<input name="id" type="text" class="form-control input-lg" placeholder="Nama Puskesamas"/>
			<button name="button" type="submit" class="btn btn-info btn-lg">
				<span class="glyphicon glyphicon-search"></span>
			</button>
		</form>	
		<div class="datapasien">
			<table class="listpuskesmas">
				<tr>
					<td width="90%">Bojongsoang</td>
					<td><a href="#" class="btn btn-info btn-md btns">Pilih</a></td>
				</tr>
				<tr>
					<td width="90%">Bojongsoang</td>
					<td><a href="#" class="btn btn-info btn-md btns">Pilih</a></td>
				</tr>
				<tr>
					<td width="90%">Bojongsoang</td>
					<td><a href="#" class="btn btn-info btn-md btns">Pilih</a></td>
				</tr>
			</table>
		</div>
		<p style="text-align: center">
			<a href="#" class="btn btn-info btn-lg btns">Kembali</a>
			<a href="?page=isi_form" class="btn btn-info btn-lg btns">Lanjutkan</a>
		</p>
	</div>
		
</div>
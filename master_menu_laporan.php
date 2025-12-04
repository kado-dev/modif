<nav class="navbar navbar-default noprint">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="?page=apotik">Laporan</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<!--<li class="<?php if($_GET['page'] == 'apotik') {echo'active';}?>"><a href="?page=apotik">Pelayanan Resep <span class="sr-only">(current)</span></a></li>-->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pendaftaran <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="?page=lap_loket_registrasi_kunjungan">Lap.Registrasi Kunjungan</a></li>
						<li><a href="#">Lap.Cara Bayar</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>
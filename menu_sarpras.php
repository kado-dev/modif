<?php 
	$kota = $_SESSION['kota'];
	$username = $_SESSION['username'];
?>

<li class="">
	<a href="?page=dashboard">
		<i class="menu-icon fa fa-pie-chart"></i>
		<span class="menu-text"> Dashboard </span>
	</a>
	<b class="arrow"></b>
</li>
<li class="">
	<a href="?page=sarpras_pemohon">
		<i class="menu-icon fa fa-area-chart"></i>
		<span class="menu-text">Data Pemohon</span>
	</a>
</li>
<li class="">
	<a href="?page=sarpras_apotek">
		<i class="menu-icon fa fa-area-chart"></i>
		<span class="menu-text">Izin Apotek</span>
	</a>
</li>
<li class="">
	<a href="?page=sarpras_pirt">
		<i class="menu-icon fa fa-area-chart"></i>
		<span class="menu-text">Izin Pirt</span>
	</a>
</li>
<li class="">
	<a href="?page=sarpras_tokoobat">
		<i class="menu-icon fa fa-area-chart"></i>
		<span class="menu-text">Izin Toko Obat</span>
	</a>
</li>	
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/jquery.autocomplete.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
	<style>

body{
	background: #f5f5f5;
}

.logologin{
	margin-top: 25%;
	margin-bottom:1px;
	padding:30px 0px;
	text-align:center;
}

.login-panel {
    margin-top: 1%;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.1);
    border-radius: 5px;
    background: rgba(255,255,255,0.65);
}
.juds{
	color:#222;
	font-weight:bold;
	font-size:21px;
	text-align:center;
	padding:20px 0px 0px 0px;
}

.input-group{
	margin-bottom:12px;
}
.container{
	width:100%;
}
.formregister{
	padding:15px 20px;
}
</style>
</head>

<body>
<?php
	include "config/koneksi.php";
	$id = $_GET['id'];
	$query = mysqli_query($koneksi,"select * from `tbpuskesmasregistrasi` where `KodePuskesmas` = '$id'");
	$data = mysqli_fetch_assoc($query);
?>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><b>Data Puskesmas</b></h3>
				</div>
				<div class="panel-body">
					<table class="table table-striped"> 					
						<tr>
							<td class="col-sm-2">IdPuskesmas</td>
							<td>:</td>
							<td class="col-sm-10"><?php echo $data['KodePuskesmas'];?></td>
						</tr>
						<tr>
							<td>Nama Puskesmas</td>
							<td>:</td>
							<td><?php echo $data['NamaPuskesmas'];?></td>
						</tr>	
						<tr>
							<td>Alamat</td>
							<td>:</td>
							<td><?php echo $data['Alamat'];?></td>
						</tr>
						<tr>
							<td>Telepon</td>
							<td>:</td>
							<td><?php echo $data['Telepon'];?></td>
						</tr>
						<tr>
							<td>No.HP/Watshap</td>
							<td>:</td>
							<td><?php echo $data['HP'];?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td>:</td>
							<td><?php echo $data['Email'];?></td>
						</tr>
						<tr>
							<td>Kepala Puskesmas</td>
							<td>:</td>
							<td><?php echo $data['KepalaPuskesmas'];?></td>
						</tr>
					</table>
					<div align="left">
						<a href="login.php" class="btn btn-sm btn-warning"> Kembali</a>
					</div>
				</div>
			</div>
			Terima kasih telah melakukan registrasi, kami akan melakukan validasi data yang anda daftarkan selama 1 x 24 jam.
			Jika data tersebut valid akan kami informasikan melalui Email / Watshap.
		</div>
	</div>
</div>

 </body>
 
 <!-- Bootstrap core JavaScript
    ==================================================-->
	<script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>	  
</html>
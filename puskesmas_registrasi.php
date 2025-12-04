<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>e-Puskesmas</title>

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
	border-left:1px solid #ddd;
	border-right:1px solid #ddd;
	background:#fff;
	width:900px;
}
.formregister{
	padding:15px 20px;
}
</style>
</head>

<body>
<div class="container">
    <div class="row">	
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
				  
				  <a class="navbar-brand" href="?page=data_kk">Registrasi Puskesmas</a>
				</div>
			</div>
		</nav>
		<div class="formregister">
			<p>Silahkan lengkapi data puskesmas, jika sudah pilih menu "SIMPAN"</p>
			<form class="form-horizontal" action="puskesmas_registrasi_proses.php" method="post" enctype="multipart/form-data">
				<table class="table">
					<tr>
						<td class="col-sm-3">Id Puskesmas</td>
						<td>:</td>
						<td class="col-sm-9">
							<input type="text" name="kodepuskesmas" class="form-control" maxlength ="15" required>
						</td>
					</tr>
					<tr>
						<td class="col-sm-3">Nama Puskesmas</td>
						<td>:</td>
						<td class="col-sm-9">
							<input type="text" name="namapuskesmas" style="text-transform: uppercase;" class="form-control" required>
						</td>
					</tr>
					<tr>
						<td class="col-sm-3">Alamat</td>
						<td>:</td>
						<td class="col-sm-9">
							<input type="text" name="alamat" style="text-transform: uppercase;" class="form-control" required>
						</td>
					</tr>
					<tr>
						<td class="col-sm-3">No.Telp Puskesmas</td>
						<td>:</td>
						<td class="col-sm-9">
							<input type="text" name="telepon" class="form-control" required>
						</td>
					</tr>
					<tr>
						<td class="col-sm-3">No.HP/Watshap</td>
						<td>:</td>
						<td class="col-sm-9">
							<input type="text" name="hp" class="form-control" required>
						</td>
					</tr>
					<tr>
						<td class="col-sm-3">Email Puskesmas</td>
						<td>:</td>
						<td class="col-sm-9">
							<input type="text" name="email" class="form-control" required>
						</td>
					</tr>
					<tr>
						<td class="col-sm-3">Nama Kepala Puskesmas</td>
						<td>:</td>
						<td class="col-sm-9">
							<input type="text" name="kepalapuskesmas" style="text-transform: uppercase;" class="form-control" required>
						</td>
					</tr>
					<tr>
						<td class="col-sm-3">NIP</td>
						<td>:</td>
						<td class="col-sm-9">
							<input type="text" name="nip" class="form-control" required>
						</td>
					</tr>
					<tr>
						<td class="col-sm-3">Foto Puskesmas</td>
						<td>:</td>
						<td class="col-sm-9">
							<input type="file" name="image" class="form-control" required>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">
						<td></td>
						<td class="col-sm-10"><button type="submit" class="btn btn-success">Simpan</button></td>
						</td>
					</tr>	
				</table>
			</form>
		</div>
	</div>
</div>
</body>
 
 <!-- Bootstrap core JavaScript
    ==================================================-->
	<script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>	  
</html>


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
    <link href="assets/bootstrap-dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/jquery.autocomplete.css" rel="stylesheet">

	<style>

body{
	background: #3C9113;
}
.hitams{
	position:absolute;
	top:0;
	left:0;
	bottom:0;
	right:0;
	width:100%;
	height:50%;
	background: #fff;
}
.logologin{
	margin-top:0px;
	margin-bottom:1px;
	padding:10px 0px;
	text-align:center;
	font-family: Verdana, Geneva, sans-serif;
}
.logologin h3{
	font-size:25px;
}
.login-panel {
    margin-top: -10px;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.1);
    border-radius: 5px;
    background: #fff;
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
.textbawah{
	color:#fff;
}
.textbawah a{
	color:#d8ea12;
}
.textbawah a:hover{
	text-decoration:none;
}
.logo{
	width:20%;
	margin-top:20px;
	margin-left:40%;
	margin-right:35%;
}
	</style>
</head>

 <body>
	<div class="hitams"></div>
    <div class="container">
       <div class="row">	
            <div class="col-md-12">
				<img src="image/puskesmasonline.png" class="logo"/>
			</div>
            <div class="col-md-4 col-md-offset-4">
				<div class="logologin">
					<h3>e-Puskesmas</h3>
					<p>Sistem Informasi Manajemen Puskesmas Online</p>
				</div>		
				<div class="login-panel panel panel-default">
                    <div class="panel-body">
						<form class="form-signin" action="login_proses.php" method="post">
							<input type="hidden" name="kodepuskesmas" class="form-control kodepuskesmas" required>
								<div class="input-group input-group-md">
								  <span class="input-group-addon"><span class = "glyphicon glyphicon-home"></span></span>
								  <input type="text" class="form-control input-md puskesmas" placeholder="Puskesmas">
								</div>	
								<div class="input-group input-group-md">
								  <span class="input-group-addon"><span class = "glyphicon glyphicon-user"></span></span>
								  <input type="text" name="username" class="form-control input-md pegawai" placeholder="Username">
								</div>	
								<div class="input-group input-group-md">
								  <span class="input-group-addon"><span class = "glyphicon glyphicon-lock"></span></span>
								  <input type="password" name="pass" class="form-control" placeholder="Password">
								</div>
							<button class="btn btn-md btn-success btn-login pull-right" type="button">Login</button>
						</form>
					</div>
				</div>
			</div>
		</div>
    </div>
	<div align="center" class="textbawah">
		Copyright 2017 - "www.puskesmasonline.com" | <a href="puskesmas_registrasi.php">Demo Program</a><br/>
		Hubungi Kami : 0822.4091.7567 (Whatsapp)
		
	</div>
 </body>
 
 <!-- Bootstrap core JavaScript
    ==================================================-->
	<script src="assets/js/jquery/jquery-2.0.3.min.js"></script>
	<!-- BOOTSTRAP -->
	<script src="assets/bootstrap-dist/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.autocomplete.js"></script>
    <script type="text/javascript">
				$(document).ready(function() {
					$('.puskesmas').autocomplete({
						serviceUrl: 'get_puskesmas.php',
						onSelect: function (suggestion) {
							$(this).val(suggestion.value);
							$(this).parent().parent().find(".kodepuskesmas").val(suggestion.kodepuskesmas);
							$(this).parent().parent().find(".btn-login").attr({type:"submit"});
						}
					});
					$('.pegawai').autocomplete({
						serviceUrl: 'get_pegawai.php',
						onSelect: function (suggestion) {
							$(this).val(suggestion.value);
						}
					});
				});	
	</script>	  
</html>


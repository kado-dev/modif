<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="puskesmas online, e-puskesmas, epuskesmas, aplikasi puskesmas, simpus, sip, sikda, puskesmas, kesehatan"/>
    <meta name="description" content="Puskesmas Online merupakan sebuah Aplikasi Manajemen Puskesmas, 
	aplikasi ini dikembangkan di kota Bandung sejak tahun 2011, fungsi dari Puskesmas Online salahsatunya sebagai media
	pengolahan data informasi yang ada di Puskesmas. Harapan kedepan dengan adanya aplikasi Puskesmas Online dapat membantu 
	memaksimalkan pelayanan kepada masyarakat dan mempermudah pekerjaan petugas yang ada di Puskesmas seluruh Indonesia">
    <meta name="author" content="Tommy Natalianto">
	<meta name="language"content="id"/>
    <link rel="icon" href="image/pkmonlineicon.png" type="image/png" sizes="16x16">
    <title>pkmonline</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap-dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/jquery.autocomplete.css" rel="stylesheet">

	<style>

body{
	background: #033F7A;
	width:100%;
}

.textlogin h2{
	color:#fff;
	font-size:30px;
	margin-bottom:5px;
	text-align:center;
	font-family: Verdana, Geneva, sans-serif;
}
.textlogin p{
	color:#fff;
	font-size:14px;
	text-align:center;
}
.login-panel {
    background: #2E363F;
}

.juds{
	color:#222;
	font-weight:bold;
	font-size:21px;
	text-align:center;
	padding:20px 0px 0px 0px;
}

.input-group{
	margin-bottom:20px;
}
.input-group>input,.input-group>span{
	border-radius:0px;
}	
.textbawah{
	margin-top:15px;
	color:#fff;
}
.textbawah a{
	color:#d8ea12;
}
.textbawah a:hover{
	text-decoration:none;
}
.logokiri{
	width:90px;
}
.logokanan{
	float:right;
	width:140px;
}
.iconlogin{
	position:fixed;
	top:120px;
	right:100px;
	width:300px;
}
.garis{
	margin-top:20px;
	padding-bottom:10px;
	border-top:1px solid #155d9b;
	border-bottom:1px solid #155d9b;
}
.textlogo{
	margin-top:12px;
	font-size:14px;
	font-weight:bold;
	font-style:italic;
}
	</style>
</head>

 <body>

    <div class="container">
       <div class="row">	
			<div class="col-md-4 col-md-offset-4" style="padding-top:50px;color:#fff;text-align:center">
				<img src="image/bandungkab.png" class="logokiri"/>
				<div class="textlogo">
					Dinas Kesehatan 
					Kabupaten Bandung
				</div>
			</div>
            <div class="col-md-4 col-md-offset-4 garis">
				<div class="textlogin">
					<h2>ePuskesmas</h2>
					<p>Aplikasi Puskesmas Online versi 1.3</p>
				</div>	
				
						<form class="form-signin" action="login_proses.php" method="post">
							<input type="hidden" name="kodepuskesmas" class="form-control kodepuskesmas" required>
								<div class="input-group">
								  <span class="input-group-addon" style="background:#28B779;border-color:#28B779;color:white"><span class="glyphicon glyphicon-home"></span></span>
								  <input type="text" class="form-control puskesmas" placeholder="Puskesmas">
								</div>	
								<div class="input-group">
								  <span class="input-group-addon" style="background:#FFB848;border-color:#FFB848;color:white"><span class="glyphicon glyphicon-user"></span></span>
								  <input type="text" name="username" class="form-control pegawai" placeholder="Username">
								</div>	
								<div class="input-group">
								  <span class="input-group-addon" style="background:#D7DF23;border-color:#D7DF23;color:white"><span class="glyphicon glyphicon-lock"></span></span>
								  <input type="password" name="pass" class="form-control" placeholder="Password">
								</div>
							<button class="btn btn-md btn-success btn-login pull-right" type="button">Login</button>
							<a href="indexawal.php" class="btn btn-md btn-primary btn-login pull-right" style="margin-right:10px">Dashboard</a>
						</form>
					
			</div>
		</div>

    </div>
	<div align="center" class="textbawah">
		<span style ="font-size:13px"> Copyright 2017 - Dinas Kesehatan Kabupaten Bandung<br/>
		IT Center : 0822.4091.7567 / 0823.1505.6850
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


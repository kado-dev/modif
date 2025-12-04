<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
	<link href="https://fonts.googleapis.com/css?family=Poppins|Ubuntu|Roboto+Condensed" rel="stylesheet">
    <!-- Custom styles for this template -->
    <style>
		body {
			font-family: 'Ubuntu', sans-serif;
			height: 100vh;
			overflow-x:hidden;
		}
		.mainbars{
			background-image: url("image/bg_log.jpg");
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
			min-height: 100vh;
			overflow-x:hidden;
			}
		.mainbars_p{
			padding: 250px 80px 50px 80px;
			color: white;
			font-size: 18px;
		}
		.mainbars_p h2{
			font-family: 'Ubuntu', sans-serif;
			font-size:30px;
		}
		.sidebars{
			background:#fff;
			color:#111;
			text-align:left;
			min-height: 100vh;
		}
		.container {
			width:100%;
			padding-left:0px;
			padding-right:0px;
		}
		.form-signin{
			width:60%;
			margin:auto;
			position:absolute;
			top:220px;
			left:0px;
			right:0px;
		}
		.form-signin p{
			margin-top: 30px;
			text-align: center;
			font-size: 11px;
			font-family 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
			color: #7f7f7f;
		}
		.form-group label{
			margin-bottom:0px;
		}
		.form-control,.form-control:focus{
			border-top:0px;
			border-left:0px;
			border-right:0px;
			border-radius:0px;
			box-shadow:none;
		}
		.btn-home{
			border-radius:15px;
			color:green;
			background:white;
			margin-right:8px;
			padding-right:25px;
			padding-left:25px;
		}
		.btn-login{
			border-radius:15px;
		}
		.logokiri{
			width:230px;
			position:absolute;
			top:20px;
			left:50px;
		}
		.logokanan{
			width:230px;
			position:absolute;
			top:20px;
			right:60px;
		}
		.logodinas{
			//width:140px;
			width: 85px;
			height: 100px;
			position:absolute;
			top:90px;
			left:0px;
			right:0px;
			margin:auto;
		}
		.fontbg{
			font-size: 42px;
			font-weight: bold;
			font-family: "Poppins", sans-serif;
			line-height: 40px;
		}
		.font_sioke{
			font-size: 24px;
			font-family: "Poppins", sans-serif;
		}
		
		@media screen and (max-width: 600px) {
			.fontbg{
				font-size: 22px;
				line-height: 25px;
			}
			.font_sioke{
				font-size: 16px;
				font-family: "Poppins", sans-serif;
			}
			.mainbars_p{
				padding: 190px 40px 30px 40px;
				font-size: 14px;
				color:white;
			}
			.btn-home{
				margin-bottom:10px;
			}
		}
		
		@media screen and (min-width:320px) and (max-width:767px) and (orientation:landscape) {
			.mainbars_p{
				padding: 80px 40px 30px 80px;
			}
		}
		
	</style>
  </head>

  <body>
    <main role="main">
		<div class="container">
			<div class="row">
				<div class="col-md-7" style="padding-right:0px">
					<div class="mainbars" >
						<!--<img src="image/pkmonline_white.png" class="logokiri">-->
						<!--<img src="image/pkmonline_white.png" class="logokanan">-->
						<div class="mainbars_p">
							<p>
								<div class="fontbg" style="margin-top: -10px">
								Sistem Informasi Obat <br/>
								& Perbekalan Kesehatan
								</div>
								<div class="font_sioke">sioke<span style="font-size: 18px; color: yellow;"> Versi 1.0</span></div>
							</p>
							<p align="left" style="margin-top:50px">
								<a href="pasienonline/index.php" class="btn btn-md btn-home btn-login">Pasien Online</a>
								<a href="antrian/index.php" class="btn btn-md btn-home btn-login">Antrian Online</a>
								<!--<a href="portal_index.php" class="btn btn-md btn-home btn-login">Portal Kesehatan</a>-->	
							</p>		
						</div>
					</div>
				</div>
				<div class="col-md-5" style="padding-left:0px">
					<div class="sidebars">
						<img src="image/bogorkab.png" class="logodinas">
						<form class="form-signin" action="login_proses.php" method="post" style="margin-top:25px">
							<?php 
								echo $_COOKIE['alert'];
							?>	
							<div class="form-group">
							  <label>Id</label>
							  <input type="text" name="id" class="form-control" placeholder="Nip / Nrptt">
							</div>	
							<div class="form-group">
							  <label>Password</label>
							  <input type="password" name="pass" class="form-control" Placeholder="Password">
							</div>
							<button class="btn btn-md btn-success btn-login btn-block" type="submit">Login</button>
							<p style="font-size:12px">2019 - Sistem Informasi Obat & Perbekalan Kesehatan Puskesmas<br/>Dinas Kesehatan Kabupaten Bogor</p>
							<!--<p>IT Support : 0822-4091-7567</p>-->
						</form>
					</div>
				</div>
			</div>
      </div>
    </main>
	
	<script src="assets/js/jquery/jquery-2.0.3.min.js"></script>
	<script src="assets/bootstrap-dist/js/bootstrap.min.js"></script>
	
  </body>
</html>
<?php
function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }
    return $ip;
}
?>


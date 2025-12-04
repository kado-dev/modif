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
    <link href="../assets/bootstrap-dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../assets/css/jquery.autocomplete.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins|Ubuntu|Roboto+Condensed|Nunito+Sans" rel="stylesheet">
    <!-- Custom styles for this template -->
    <style>
		body {
			font-family: 'Poppins', sans-serif;
			height: 100vh;
			overflow-x:hidden;
		}
		.mainbars{
			background-image: url("../image/bglogin.jpg");
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
			text-align: center;
		}
		.mainbars_p h2{
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
			width:50%;
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
		.form-control{
			border:0px;
			border-radius:5px;
			padding:25px 15px;
			font-size: 18px;
			background: #ededed;
			box-shadow: none;
			margin-bottom: 25px;
		}
		.form-control:focus{
			background: #fff;
			box-shadow: 0px 0px 10px #ccc;
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
			border-radius:5px;
			padding:15px 15px;
		}
		.btn-login:hover{
			border:none;
			box-shadow: 0px 5px 8px #5f5f61;
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
			width:120px;
			position:absolute;
			top:100px;
			left:0px;
			right:0px;
			margin:auto;
		}
		.fontbg{
			font-size: 52px;
			font-weight: bold;
			line-height: 48px;
		}
		.fontbg2{
			font-size: 28px;
			line-height: 59px;
			font-weight: bold;
			    font-family: 'Nunito Sans', sans-serif;
		}
		.fontdinkes{
			font-size: 16px;
			line-height: 0px;
			font-weight: normal;
			font-family: 'Nunito Sans', sans-serif;
		}
		
		@media screen and (max-width: 600px) {
			.fontbg{
				font-size: 20px;				
			}
			.fontdinkes{
				font-size: 12px;
				font-family: "Poppins", sans-serif;
				margin-top:-5px;
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
				<div class="col-md-6" style="padding-left:0px">
					<div class="sidebars">
						<img src="../image/bandungkab.png" class="logodinas">
						<form class="form-signin" action="login_proses.php" method="post" style="margin-top:10px" autocomplete="off">
							<p style="text-align: center;margin-top: 0px;margin-bottom: 25px">
								<span style="font-size: 24px;color: #111;font-weight: bold;">Dinas Kesehatan</span><br>
								<span style="font-size: 13px">Kabupaten Bandung</span>
							</p>
							<?php 
								echo $_COOKIE['alert'];
							?>	
							<input type="hidden" name="kodepuskesmas" class="form-control kodepuskesmas">
							<!--<div class="form-group">
							  <input type="text" name="namapuskesmas" class="form-control puskesmas" placeholder="Puskesmas">
							</div>-->
							<div class="form-group">
							  <input type="password" name="pass" class="form-control" Placeholder="Password">
							</div>
							<button class="btn btn-md btn-success btn-login btn-block" type="submit">Login</button>
						</form>
					</div>
				</div>
				<div class="col-md-6" style="padding-right:0px">
					<div class="mainbars" >
						<div class="mainbars_p">
							<p>
								<img src="../image/pkmonline_white.png" width="270px" class="logopkmonline">
								<div class="fontbg2" style="margin-top: -20px">
									Queue Management System
								</div>
								<div class="fontdinkes">
									<?php echo date('Y');?> Dinas Kesehatan Kabupaten Bandung
								</div><br/><br/>
								<a href="../index.php" class="btn btn-md btn-home">Simpus Online</a>
							</p>	
						</div>
					</div>
				</div>
			</div>
      </div>
    </main>
	
	<script src="../assets/js/jquery.js"></script>
    <script src="../assets/bootstrap-dist/js/bootstrap.min.js"></script>
	<script src="../assets/js/jquery.autocomplete.js"></script>
    <script type="text/javascript">
		$(document).ready(function() {
			$('.puskesmas').autocomplete({
				serviceUrl: '../get_puskesmas.php?keyword=',
				// serviceUrl: '../get_puskesmas.php',
				onSelect: function (suggestion){
					$(this).val(suggestion.value);
					$(".kodepuskesmas").val(suggestion.kodepuskesmas);
					$(".puskesmas").val(puskesmas.kota);
				}
			});
		});	
		
		
		
	
	</script>
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


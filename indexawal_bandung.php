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

    <!-- Custom styles for this template -->
    <style>
		body {
			padding-top: 0px;
			background: url(image/bg.png) repeat !important;
			font-family:century gothic;
		}
		
		.menudepan{
			text-align:center;
		}
		.menudepan img{
			width:230px;
		}
		
		.menudepan a:hover{
			text-decoration:none;
		}
		
		.sidebars{
			background:#fff;
			border:1px solid #ddd;
			border-radius:5px;
			box-shadow:0px 0px 8px #ccc;
			padding:10px;
			display:block;
			color:#111;
			text-align:left;
			margin-bottom:20px;
		}
	
		.container {
			padding-left:0px;
			padding-right:0px;
		}
		.sidebars h4{
			border-bottom:1px double #ddd;
		}		
		.sidebars p{
			font-size:14px;
		}
		.navbar-default{
			background: #031e49; 
			border-color: #031e49; 
			border-radius:0px;
		}
		.navbar-default .navbar-brand,.navbar-default .navbar-brand:hover{
			color:white;
		}
		.navbar-brand img{
			width:25px;
		}
		hr{
			border:0.3px solid #bfbfbf;
		}
		.mainmenu{
			padding:0px;
			//box-shadow:0px 0px 10px #afaeae;
			border-radius:8px;
		}
		.carousel-inner>.item>img, .carousel-inner>.item>a>img{
			border-radius:8px;
		}
		.input-group{
			margin-bottom:8px;
		}
		.divgaris{
			position:fixed;
			bottom:0px;
			width:100%;
			border-bottom:4px solid transparent;
		}
		.imgfooter{
			background-image: url('image/bg_header.png');
			width:100%;
			height:7px;
			position:fixed;
			top:50px;
		}
		.headinglogin{
			background:#031e49;
			padding:10px;
			color:white;
			text-align:center;
			border-radius:8px 8px 0px 0px;
			margin-top:-10px;
			margin-left:-10px;
			margin-right:-10px;
			margin-bottom:15px;
		}
	</style>
  </head>

  <body>
	<div id="navbar" class="navbar navbar-default">
		<div class="navbar-header pull-left navbar-footer">
			<a href="#" class="navbar-brand"> Puskesmas Juara</a> <!--<img src="image/bandungkab.png" class="logokiri"/>-->
		</div>
	</div>
	<div class="imgfooter"></div>
    <main role="main">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12 mainmenu">
							<?php
								include "config/koneksi.php";
								$page=$_GET['page'];
								$nama_file=$page.".php";
								$cek=strlen($page);
								
								if($cek>70 || empty($page)){
									include ("home.php");
								}else if(!file_exists($nama_file)){
									include ("error.php");
								}else{
									include ($nama_file);
								}
							?>
						</div>
						<div class="col-md-12" style="padding-top:30px">
							<div class="row">
								<div class="col-md-4 menudepan">
									<a href="antrian/index.php" target="_blank"><img src="image/bgmenu_01.png" class="img-fluid"></a>
								</div>
								<div class="col-md-4 menudepan">
									<a href="#"><img src="image/bgmenu_02.png" class="img-fluid"></a>
								</div>
								<div class="col-md-4 menudepan">
									<a href="#"><img src="image/bgmenu_03.png" class="img-fluid"></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4" style="padding-left:20px">
					<div class="sidebars" style="min-height:240px">
						<h4 class="headinglogin">Login</h4>
						<form class="form-signin" action="login_proses.php" method="post">
							<input type="hidden" name="kodepuskesmas" class="form-control kodepuskesmas" required>
							<div class="input-group">
							  <span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444"><span class="glyphicon glyphicon-home"></span></span>
							  <input type="text" class="form-control puskesmas" placeholder="Puskesmas">
							</div>	
							<div class="input-group">
							  <span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444"><span class="glyphicon glyphicon-user"></span></span>
							  <input type="text" name="username" class="form-control pegawai" placeholder="Username">
							</div>	
							<div class="input-group">
							  <span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444"><span class="glyphicon glyphicon-lock"></span></span>
							  <input type="password" name="pass" class="form-control" placeholder="Password">
							</div>
							<button class="btn btn-md btn-primary btn-login pull-right" type="button">Login</button>
						</form>
					</div>
					<div class="sidebars">
						<h4>Information</h4>
						<p>Visitor: <?php echo getUserIP();?></p>
					</div>
				</div>
			</div><hr/>
      </div><!-- /container -->
    </main>

    <footer class="container">
      <p>2018 | Dinas Kesehatan Kabupaten Bandung</p>
    </footer>
	
	<div class="divgaris"></div>
	<!--<div class="imgfooter"></div>-->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- Bootstrap core JavaScript
    ==================================================-->
	<script src="assets/js/jquery/jquery-2.0.3.min.js"></script>
	<!-- BOOTSTRAP -->
	<script src="assets/bootstrap-dist/js/bootstrap.min.js"></script>
	<script>
		$('.carousel').carousel({
		  interval: 3000
		})
	</script>

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


<?php error_reporting(0);?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Sehat</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="puskesmasonline, aplikasi puskesmas, sistem informasi puskesmas, sistem informasi kesehatan daerah, sik kesehatan, simpus, sikda, puskesmas, kesehatan"/>
    <meta name="description" content="PuskesmasOnline merupakan sebuah Aplikasi Manajemen Puskesmas, 
	aplikasi ini dikembangkan pertama kali di kota Bandung sejak tahun 2011, fungsi dari aplikasi PuskesmasOnline salah satunya sebagai media
	data informasi yang ada di Puskesmas. Harapan kedepan dengan adanya aplikasi PuskesmasOnline dapat membantu 
	peningkatan mutu pelayanan kesehatan kepada masyarakat dan mempermudah pekerjaan petugas di Puskesmas seluruh Indonesia">
    <meta name="author" content="Tommy Metrost">
	<meta name="language"content="id"/>

	<!--===============================================================================================-->	
		<link rel="icon" type="image/png" href="image/sehat.png"/>
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="assets/bootstrap-dist/css/bootstrap.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="assets_login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">

	<!--!font-->
	<link href="https://fonts.googleapis.com/css?family=Poppins|Ubuntu|Roboto+Condensed" rel="stylesheet">

	<!-- CSS Files -->
	<link rel="stylesheet" href="assets_atlantis/css/atlantis.min.css">
	
	<!-- Fonts and icons -->
	<script src="assets_atlantis/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['assets_atlantis/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS untuk form login -->
	<link rel="stylesheet" type="text/css" href="assets_login/css/util.css?1">
	<link rel="stylesheet" type="text/css" href="assets_login/css/main.css?4">

</head>
<style>
	body{
		font-family: "Poppins", sans-serif;
		overflow-x:hidden;
		color:#000;
	}
	.left-bg{
		background: linear-gradient(0deg, rgba(177, 231, 212, 0.8), rgba(0, 127, 255, 1));
		height:100vh;
		padding:8vh 0vw 8vh 8vw;
	}
	.left-bg-div{
		background:#e5effc;
		padding:3vh 2vw;
		height:84vh;
		border-radius:20px 0px 0px 20px;
	}
	.right-bg{
		/* background:#c6e0ff; */
		background: linear-gradient(0deg, rgba(177, 231, 212, 0.8), rgba(0, 127, 255, 1));
		height:100vh;
		padding:8vh 8vw 8vh 0vw;
	}
	.right-bg-div{
		background:rgba(249, 251, 253, 0.3);
		padding:1.5vh 2vw;
		height:84vh;
		border-radius:0px 20px 20px 0px;
	}
	.logo{
		width:50px;
	}
	.logologin{
		width:310px;display:block;
		margin:auto;
		
	}
	.formlogin{
		box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.2);	
		background: linear-gradient(0deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.4));
		color : red;
		margin:3vh 4vw;
		padding:40px 40px;
		border-radius:15px;		
		margin-bottom: 20px;		
	}
	.formlogin h2{
		font-size: 20px;
		text-align: center;
		font-family: "Poppins", sans-serif;
	}
	.label{
		font-size:14px;color:#000
	}
	.formlogin input{
		padding:1.6vh 2.5vh;
		height:7vh;
		width:100%;
		font-size:2vh;
		border-radius:4vh;
	}
	.wrap-input100{
		border-radius:4vh;
	}
	.tmp_cptcha img{
		width:100%;
		height:8vh;
		border-radius: 25px;
		margin-left: 15px
	}
	.carousel{
		margin-top:7vh;
	}
	.carousel-inner .item img{
		width: 30vw;
		margin: auto;
	}
	.btnsimpan{
		display: block;
		width: 100%;
		background-color: #08c999;
		border: none;
		color: #fff;
		padding: 1.8vh;
		cursor: pointer;
		font-size: 2.2vh;
		font-family: "Poppins", sans-serif;
		border-radius: 5px;
		transition: all 0.2s;
		text-align: center;
	}
	.btnsimpan:hover{
		color:#fff;
		background-color:#3ceabc;
	}

	@media (max-width: 576px) {
		.left-bg{
			display:none;
		}
		
		.right-bg{
			padding:8vh 8vw 8vh 8vw;
		}
		.right-bg-div{
			border-radius:10px;
		}
	}
</style>
<body>
	<div class="row">
		<div class="col-md-6 left-bg">
			<div class="left-bg-div">
				<!-- <img src="image/tarakan.png" class="logo">
				<img src="image/logo_puskesmas_noshadow.png" class="logo"> -->
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				 	 <!-- Indicators -->
				  	<ol class="carousel-indicators">
						<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
						<li data-target="#carousel-example-generic" data-slide-to="1"></li>
				 	 </ol>

				 	 <!-- Wrapper for slides -->
				  	<div class="carousel-inner" role="listbox">
						<div class="item active">
							<img src="image/banner/slide1.png" alt="Foto 1">
						</div>
						<div class="item">
							<img src="image/banner/slide2.png" alt="Foto 2">
						</div>
				 	 </div>
				</div>
			</div>
		</div>
		
		<div class="col-md-6 right-bg">
			<div class="right-bg-div">
				<div class="formlogin">
					<?php echo $_COOKIE['alert'];?>
					<form action="login_proses.php" method="post">
						<!-- <div class="p-t-10 p-b-5">
							<span class="label">Userid</span>
						</div> -->
						<div class="wrap-input100 validate-input" data-validate = "Username belum diisi">
							<input class="" type="text" name="id" placeholder="User ID">
							<span class="focus-input100"></span>
						</div>
						<!-- <div class="p-t-13 p-b-10">
							<span class="label">Password</span>
						</div> -->
						<div class="wrap-input100 validate-input m-t-17" data-validate = "Password belum diisi">
							<input class="" type="password" name="pass" placeholder="Password">
							<span class="focus-input100"></span>
						</div>
						<!-- <div class="p-t-13 p-b-10">
							<span class="label">Captcha</span>
						</div> -->
						<div class="row m-t-17">		
							<div class="col-md-8 ">
								<span class="tmp_cptcha"><img src="captcha.php"/></span>
							</div>
							<div class="col-md-4">
								<button type="button" class="btn btn-round btn-primary btn_cptcha" style="height:50px;width:50px;margin-top:5px;margin-left:-10px"><span class="fa fa-refresh"></span></button>
							</div>
						</div>
						<div class="wrap-input100 validate-input m-t-17" data-validate = "captcha belum diisi">
							<input class="" type="text" name="captcha" placeholder="Captcha">
						</div>
						<div class="container-login100-form-btn m-t-17">
							<button class="btn btn-round btn-success btnsimpan" type="submit"><i class="icon-login"></i> Login</button>
						</div>
						<div class="container-login100-form-btn m-t-17">
							<a href="antrian/index.php" class="btn btn-round btn-primary btnsimpan"><i class="icon-people"></i> Antrian Online</a>
						</div>
					</form>
				</div>
				<?php
					// minta tolong aktifkan mbstring extension
					// digunakan untuk konversi string
					// $str = "Hello";
					// $convert = mb_convert_encoding($str, "UTF-16LE");
					// print_r($convert);
				?>
				<p style="color: #fff; font-weight: bold;" align="center"><?php echo date("Y");?> | Sehat <br/> Puskesmas Linggar (G) Kabupaten Bandung</p>
			</div>
		</div>
	</div>	
</body>
</html>

<script src="assets/js/jquery-2.1.4.min.js"></script>
<script src="assets_login/vendor/bootstrap/js/popper.js"></script>
<script src="assets/bootstrap-dist/js/bootstrap.min.js"></script>

<script>
	$(".btn_cptcha").click(function(){
		$.get( "captcha_get.php")
			.done(function( data ) {
			$('.tmp_cptcha').html(data);
		});
	});
</script>
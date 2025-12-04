<!DOCTYPE html>
<html lang="en">
<head>
	<title>pkmonline</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="puskesmas online, aplikasi puskesmas, simpus, sip, sikda, puskesmas, kesehatan"/>
    <meta name="description" content="Puskesmas Online merupakan sebuah Aplikasi Manajemen Puskesmas, 
	aplikasi ini dikembangkan di kota Bandung sejak tahun 2011, fungsi dari Puskesmas Online salahsatunya sebagai media
	pengolahan data informasi yang ada di Puskesmas. Harapan kedepan dengan adanya aplikasi Puskesmas Online dapat membantu 
	memaksimalkan pelayanan kepada masyarakat dan mempermudah pekerjaan petugas yang ada di Puskesmas seluruh Indonesia">
    <meta name="author" content="Tommy Natalianto">
	<meta name="language"content="id"/>
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="assets_login/images/icons/pkmonlineicon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets_login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets_login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets_login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets_login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="assets_login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets_login/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets_login/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="assets_login/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets_login/css/util.css?1">
	<link rel="stylesheet" type="text/css" href="assets_login/css/main.css?4">
<!--===============================================================================================-->
	<link href="assets/css/jquery.autocomplete.css" rel="stylesheet">
	
</head>
<style>
	.logokabkota{
		width: 40%;
		margin: 0 auto;
		padding-bottom: 15px;
	}
	.judulkabkota{
		text-align: center;
		width: 100%;
		padding: 10px;
		position: absolute;
		top: 20px;
	}
	.judulsmartcity{
		text-align: center;
		width: 100%;
		position: absolute;
		bottom: 20px;
		padding: 10px;
		<!-- border: 3px solid green; -->
	}
	.font-dinkes{
		font-size: 22px;
		font-weight: bold;rtant;
		color: #fff;
	}
	.font-kabkota{
		font-size: 14px;
		margin-top: -5px;
		color: #fff;
	}
	.bglogin{
		background-image: url('assets_login/images/vektorpuskesmas.jpg');
		background-size: 100% 60%;
		background-position: bottom;
		background-repeat: no-repeat;
	}
	.wrap-login100 {
		box-shadow: 0px 4px 5px 0px rgba(0,0,0,0.60);	
		background: linear-gradient(0deg, rgba(74, 168, 67, 0.8), rgba(164, 229, 180, 1)), url('assets_login/images/bgpanellogin.jpg');
		background-repeat: no-repeat;
		background-position: bottom;
		background-size: 100% 100%;
	}
	.bgpanel{
		background: linear-gradient(0deg, rgba(74, 168, 67, 1), rgba(44, 117, 89, 0.8)), url('assets_login/images/bgpanellogin.jpg');
		background-size: 200%;
	}
</style>
<body>
	<div class="limiter">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-12" style="padding: 0px;">
					<div class="container-login100 bglogin">
							<div class="wrap-login100 p-l-110 p-r-110 p-t-35 p-b-33">
							<?php  echo $_COOKIE['alert']; ?>
							<form class="login100-form validate-form flex-sb flex-w" action="login_proses_replika.php" method="post">
								<div class="p-t-31 p-b-9">
									<span class="txt1">Puskesmas</span>
								</div>
								<div class="wrap-input100 validate-input" data-validate = "Puskesmas belum diisi">
									<input class="input100 puskesmas" type="text" name="id" >
									<span class="focus-input100"></span>
								</div>
								<div class="p-t-31 p-b-9">
									<span class="txt1">Username</span>
								</div>
								<div class="wrap-input100 validate-input" data-validate = "Username belum diisi">
									<input class="input100 pegawai" type="text" name="username" >
									<span class="focus-input100"></span>
								</div>
								<div class="p-t-13 p-b-9">
									<span class="txt1">Password</span>
								</div>
								<div class="wrap-input100 validate-input" data-validate = "Password belum diisi">
									<input class="input100" type="password" name="pass" >
									<span class="focus-input100"></span>
								</div>
								<div class="container-login100-form-btn m-t-17">
									<input type="hidden" name="kodepuskesmas" class="kodepuskesmas" required>
									<button class="login100-form-btn" type="submit">Login</button>
								</div>							
								<!--<div class="w-full text-center p-t-55">
									<span class="txt2">
										Belum punya akun?
									</span>
									<a href="#" class="txt2 bo1">
										Daftar Sekarang
									</a>
								</div>-->
							</form>
						</div>
					</div>
				</div>
				<!--<div class="col-md-3 bgpanel">
					<div class="container-login100">
						<div class="row judulkabkota">
							<img src="images/bandungkab.png" class="logokabkota">
							<div class="col-sm-12">
								<span class="font-dinkes">Dinas Kesehatan</span></br>
								<div class="font-kabkota">Kabupaten Bandung</div>
							</div>	
						</div>
						<div class="row judulsmartcity">
							<div class="col-sm-12">
								<span class="font-kabkota">Layanan Puskesmas</span>
								<div class="container-login100-form-btn m-t-17">
									<a href="#" class="btn-google">
										<img src="images/icons/mesin_antrian.png" alt="antrianonline">
										Antrian Online
									</a>
								</div>
							</div>	
						</div>	
					</div>
				</div>-->
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="assets_login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="assets_login/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="assets_login/vendor/bootstrap/js/popper.js"></script>
	<script src="assets_login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="assets_login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="assets_login/vendor/daterangepicker/moment.min.js"></script>
	<script src="assets_login/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="assets_login/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="assets_login/js/main.js"></script>
<!--<script src="assets/js/jquery/jquery-3.5.1.js"></script>-->
	<script src="assets/js/jquery.js"></script>
	<script src="assets/bootstrap-dist/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.autocomplete.js?2"></script>
    <script type="text/javascript">
		$(document).ready(function() {
			$('.puskesmas').autocomplete({
				serviceUrl: 'get_puskesmas.php?keyword=',
				onSelect: function (suggestion) {
					$(this).val(suggestion.value);
					$(this).parent().parent().find(".kodepuskesmas").val(suggestion.kodepuskesmas);
					$(this).parent().parent().find(".btn-login").attr({type:"submit"});
				}
			});
			$('.pegawai').autocomplete({
				serviceUrl: 'get_pegawai.php?keyword=',
				onSelect: function (suggestion) {
					$(this).val(suggestion.value);
				}
			});
		});	
	</script>	
</body>
</html>
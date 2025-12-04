<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Webservice Simpus</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('asset');?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url('asset/fontawesome');?>/css/fontawesome-all.min.css" rel="stylesheet">
	<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.13.0/build/styles/default.min.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&family=Roboto:wght@500&display=swap" rel="stylesheet">
	<style>
		html {
			font-family: 'Poppins', sans-serif;
			font-size: 14px;
		}
		body{
			/*background: #fff;*/
			background-image: url("<?=base_url()?>asset/img/bg.jpg");
			font-family: 'Roboto', sans-serif;
			color:#545454;
		}
		.container {
			max-width: 1000px;
		}
		.bgmains{
			padding:20px 30px;
			box-shadow:0px 0px 15px #103500;
			min-height:1000px;
			background: #fff;
		}
		.menutext{
			color:white;
		}
		.card-deck .card {
			min-width: 220px;
		}
		.logoweb{
			width:250px;
			transition:width 0.7s;
		}
		.logowebwarna{
			display: none;
			width:250px;
			transition:width 0.7s;
		}
		.logowebkecil{
			width:250px !important;
			transition:width 0.7s;
		}
		.header{
			background:transparent;
			height: 70px;
		}
		.texheader{
			color: #fff;
			padding: 15px 15px;
			border: none;
		}
		.texheader_black{
			color:#008000 !important;
		}
		.texheader:hover{
			color: yellow;
			text-decoration: none;
		}
		.btn-outline-primary:hover{
			background: yellow;
			color: #000; 
		}
		.header-fixed{
			background:rgba(255, 255, 255, 0.8);
		}
		
		.hljs {
			display: block;
			overflow-x: auto;
			padding: 10px;
			background:#fff;
			border:1px solid #ddd;
		}
		.footertext{
			text-align: center;
			color : #fff;
			margin-top: 10px;
			margin-bottom: 50px;
		}
		.contohurl{
			background:#f5f5f5;
			margin-top:10px;
			padding:10px;
			border-left:8px solid #ccc;
		}
		.hidexs{
			top:-15px;
		}
		
		.dropdowns{
			top:-15px;
		}
		.showxs{
			display: none;
		}
		@media (max-width: 576px) {
			.dropdown{
				position:absolute;
				right:20px;
				top:75px;
			}
			.dropdown-menu{
				margin-left:10px;
			}
			.navbar-collapse{
				background: #f5f5f5;position: fixed;top:0px;left:0px;right: 0px;
				padding-bottom: 10px;padding-top:10px;
			}
			.navbar-collapse .navbar-nav li{
				padding:6px 10px;color:#545454;
			}
			.navbar-collapse .navbar-nav li a{
				color:#545454;
			}
			.navbar-toggler{
				position: fixed;top:10px;right:10px;z-index: 2
			}
			.hidexs{
				display: none;
			}
			.showxs{
				display: block;
			}
		}
		
		.dropdown-menu{
			margin-top:-10px;
			margin-left:-35px;
		}
		.dropdown-menu a{
			color:#111;
		}
	</style>
  </head>

  <body>
	<!--<div style="background:#5BA54A;padding:5px 20px;color:white;font-size:13px; font-weight:bold; text-align:center;">
		Web Service Simpus V.1
	</div>-->
	<!--  border-bottom shadow-sm -->
	<!--
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 header">
		<h5 class="my-0 mr-md-auto font-weight-normal">
			<img src="<?php echo base_url('asset/img/pkmonline1.png');?>" class="logoweb"/>
			<img src="<?php echo base_url('asset/img/pkmonline.png');?>" class="logowebwarna"/>
		</h5>
		<nav class="my-2 my-md-0 mr-md-3">
			<a class="texheader" href="<?php echo site_url('home/index');?>">HOME</a>
			<a class="texheader" href="<?php echo site_url('home/bpjs');?>">ANTREAN BPJS</a>
			<a class="texheader" href="<?php echo site_url('home/kunjungan');?>">KUNJUNGAN</a>
			<a class="texheader" href="<?php echo site_url('home/penyakit');?>">PENYAKIT</a>
			<a class="texheader" href="<?php echo site_url('home/obat');?>">FARMASI</a>
			<a class="texheader" href="<?php echo site_url('home/pegawai');?>">KEPEGAWAIAN</a>
			<?php if($this->session->userdata("level") == 'programmer'){?>
			<a class="texheader" href="<?php echo site_url('home/registrasi');?>">REGISTRASI</a>
			<?php }?>
		</nav>
		<div class="dropdown">
            <a class="nav-link texheader btn btn-sm btn-info" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<?php echo strtoupper($this->session->userdata('username'));?>
			</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="<?php echo site_url('home/detail');?>">DETAIL</a>
              <a class="dropdown-item" href="<?php echo site_url('home/logout');?>">LOGOUT</a>
            </div>
        </div>
    </div>
-->
    		<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 header">
				<h5 class="my-0 mr-md-auto font-weight-normal">
					
					<img src="<?php echo base_url('asset/img/pkmonline1.png');?>" class="logoweb"/>
					<img src="<?php echo base_url('asset/img/pkmonline.png');?>" class="logowebwarna"/>
						
				</h5>
				<div class="my-2 my-md-0 mr-md-3">
					<nav class="navbar navbar-expand-md">
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
							<i class="fa fa-bars"></i>
						</button>
						<div class="collapse navbar-collapse" id="navbarsExampleDefault">
							<ul class="navbar-nav mr-auto">
								<li class="nav-item">
							       <a class="texheader" href="<?php echo site_url('home/index');?>">HOME</a>
							    </li>
								<li class="nav-item">
									<a class="texheader" href="<?php echo site_url('home/bpjs');?>">ANTREAN BPJS</a>
								</li>
								<li class="nav-item dropdown dropdowns">
									<a class="nav-link texheader" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">E-PROFIL</a>
									<div class="dropdown-menu nav-link-geser" style="width: 250px">
										<a class="dropdown-item" href="#"><i class="fa fa-users fa-gradient"></i> KESGA</a>
										<!--<a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-gradient"></i> LOGOUT</a>-->
									</div>
								</li>
								<li class="nav-item">
								<a class="texheader" href="<?php echo site_url('home/kunjungan');?>">KUNJUNGAN</a>
								</li>
								<li class="nav-item">
								<a class="texheader" href="<?php echo site_url('home/penyakit');?>">PENYAKIT</a>
								</li>
								<li class="nav-item">
								<a class="texheader" href="<?php echo site_url('home/obat');?>">FARMASI</a>
								</li>
								<li class="nav-item">
								<a class="texheader" href="<?php echo site_url('home/pegawai');?>">KEPEGAWAIAN</a>
								</li>
								
								<?php if($this->session->userdata("level") == 'programmer'){?>
								<li class="nav-item">
									<a class="texheader" href="<?php echo site_url('home/registrasi');?>">
									REGISTRASI</a>
								</li>
								<?php }?>
								<li class="nav-item dropdown hidexs">
									<a class="nav-link texheader" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo strtoupper($this->session->userdata('username'));?></a>
									<div class="dropdown-menu nav-link-geser" style="width: 250px">
										
										<a class="dropdown-item" href="<?php echo site_url('home/detail');?>"><i class="fa fa-users fa-gradient"></i> DATA USER</a>
										<a class="dropdown-item" href="<?php echo site_url('home/logout');?>"><i class="fas fa-sign-out-alt fa-gradient"></i> LOGOUT</a>
									</div>
								</li>
								<li class="nav-item showxs">
								<a class="texheader" href="<?php echo site_url('home/detail');?>">DATA USER</a>
								</li>
								<li class="nav-item showxs">
								<a class="texheader" href="<?php echo site_url('home/logout');?>">LOGOUT</a>
								</li>
							</ul>
						</div>
					</nav>
				</div> 
				
			</div> 

    

    <div class="container">
		<div class="bgmains">
		<?php
			echo $content;
		?>
		</div>
    </div>
	<div class="footertext">
		<p>
			<?php echo date('Y');?> | PT. Metro Smart Technology
		</p>
	</div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="<?php echo base_url('asset');?>/js/jquery.js"></script>
	<script src="<?php echo base_url('asset');?>/js/popper.js"></script>
    <script src="<?php echo base_url('asset');?>/js/bootstrap.min.js"></script>
    <script>
		$(window).bind('scroll', function () {
			if ($(window).scrollTop() > 25) {
				$('.header').addClass('header-fixed');
				$('.d-flex').addClass('fixed-top');
				$('.d-flex').addClass('border-bottom');
				$('.d-flex').addClass('shadow-sm');
				$('.texheader').addClass('texheader_black');
				$('.logoweb').addClass('logowebkecil');
				$('.logowebwarna').addClass('logowebkecil');
				$('.logoweb').hide();
				$('.logowebwarna').show();
			} else {
				$('.header').removeClass('header-fixed');
				$('.d-flex').removeClass('fixed-top');
				$('.d-flex').removeClass('border-bottom');
				$('.d-flex').removeClass('shadow-sm');
				$('.texheader').removeClass('texheader_black');
				$('.logoweb').removeClass('logowebkecil');
				$('.logowebwarna').removeClass('logowebkecil');				
				$('.logoweb').show();
				$('.logowebwarna').hide();
			}
		});
    </script>
	<script src="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.13.0/build/highlight.min.js"></script>
	<script>
	$(document).ready(function() {
	  $('pre code').each(function(i, block) {
		hljs.highlightBlock(block);
	  });
	});
	</script>
  </body>
</html>
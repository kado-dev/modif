
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="keywords" content="puskesmas online, aplikasi puskesmas, simpus, sip, sik, sikda, puskesmas, kesehatan"/>
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
		background: #f2f2f2;
		font-family:malgun gothic;
	}	
	.container {
		width:95%;
		padding-left:0px;
		padding-right:0px;
	}
	
	hr{
		border:0.3px solid #bfbfbf;
	}
	.mainmenu{
		padding:0px;
		border-radius:8px;
	}
	.footer{
		background:#f5f5f5;
		padding:15px 20px 30px 20px;
		border-top:1px solid #ddd;
		margin-top:20px;
		width:100%;
		overflow-x:hidden;
	}
	.navjudul{
		background:#0B6F56;
		padding:6px;
		margin-bottom:20px;
		color:#fff;
		font-weight:bold;
		text-align:center;
		font-size:18px;
	}
	.kotaks{
		background:#fff;
		padding:10px;
		border:1px solid #eee;
		text-align:center;
		border-radius:5px;
	}
	.kotaks span{
		font-weight:bold;
		font-size:32px;
	}
	.kotakgrafik{
		margin-top:20px;
		background:#fff;
		padding:15px 10px;
		border:1px solid #ccc;
		border-radius:5px 5px 0px 0px;
	}
	.kotakgrafik h2{
		font-size:14px;
		background:#f9f9f9;
		padding:20px 10px 15px;
		border-bottom:1px solid #ccc;
		border-radius:5px 5px 0px 0px;
		margin:-15px -10px 10px -10px;
	}
	canvas{
	  width:100% !important;
	  height:300px !important;
	}
	.btnmasuk{
		position:absolute;
		top:20px;
		right:20px;
		background:#f5f5f5;
		border:1px solid #ddd;
		padding:6px 20px;
	}
	.btnmasuk:hover{
		text-decoration:none;
		background: yellow;
	}
	.logo{
		padding: 0px;
		text-align: right;
	}
	.logo img{
		max-width: 45px;
		margin: 0px 40px;
	}	
	.header{
		background: url(image/bg.png) repeat !important;
		padding-top: 10px;
		padding-bottom: 10px;
		overflow: hidden;
	}	
	.textheader{
		line-height: 20px;
		font-family: malgun gothic;
		font-weight:bold;
		margin: -55px 95px;
	}
	
	@media (max-width: 576px){
		.header{
			text-align:center;
		}
		.logo{
			text-align:center;
		}
	}		
	@media screen and (max-width: 442px){
		.mainmenu{
			margin-bottom:30px;
		}
		.textheader{
			margin: 0px 0px;
		}
	}
</style>
</head>

<body>
<!--<div id="navbar" class="navbar navbar-default">
	<div class="navbar-header pull-left ">
		<a href="#" class="navbar-brand"> PORTAL</a>
		<a href="indexawal.php" class="btnmasuk">MASUK</a>
	</div>
</div>-->
<div class="header">
	<div class="row">
		<div class="col-12 col-md-1 logo">
			<img src="image/kukarkab.png">
		</div>
		<div class="col-12 col-md-11 textheader">
			<span style="font-size:14px;">PEMERINTAH KABUPATEN KUTAI KARTANEGARA</span><br/>
			<span style="font-size:24px;"><b>DINAS KESEHATAN</b></span>
		</div>
		<a href="indexawal.php" class="btnmasuk">MASUK</a>
	</div>
</div>
<div class="navjudul">
	PORTAL KESEHATAN
</div>
<!--<div class="imgfooter"></div>-->
<main role="main" class="main">
	<?php include ("portal_data.php");?>
</main>

<div class="footer">
	<div class="row">
		<div class="col-sm-4">
			<b>Dinas Kesehatan Kabupaten Kutai Kartanegara</b><br/>
			Jl. Cut Nyak Dien, Melayu, Tenggarong, Kabupaten Kutai Kartanegara, Kalimantan Timur 75513
		</div>
		<div class="col-sm-4">
			<b>Web :</b><br/>
			www.sikdapuskesmaskukar.com
		</div>
		<div class="col-sm-4">
		
		</div>
	</div>
</div>
<script src="assets/js/jquery.js"></script>
<script>
		function showDetail(){
			if ( $( ".detailgrafik" ).is( ":hidden" ) ) {
				$(".detailgrafik").slideDown();
			}else{
				$(".detailgrafik").slideUp();
			}
		}
		setInterval(function(){
			var sts = $( ".detailgrafik" ).is( ":hidden" );
			$.get( "portal_data.php",{stsdetail:sts}).done(function( data ) {
				$(".main").html(data);
			});
		}, 5000);
</script>

</body>
</html>

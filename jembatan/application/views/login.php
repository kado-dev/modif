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
		<!--<link href="<?php echo base_url('asset/css/loginstyle.css');?>" rel="stylesheet">-->
		<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.13.0/build/styles/default.min.css">
		<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
		<style>
			body{
				display: -ms-flexbox;
				display: flex;
				-ms-flex-align: center;
				align-items: center;
				padding-top: 70px;
				padding-bottom: 40px;
				background: url(../asset/img/bg.jpg);
			}
			.form-signin {
				width: 100%;
				max-width: 420px;
				padding: 15px;
				margin: auto;
				
			}
			.formlogin{
				background: #eff1f2;
				padding: 30px 17px 60px;
				border-radius: 10px;
				box-shadow: 0px 0px 25px #0a2600;
			}
			.formlogin p{
				text-align:center;
			}		
			.form-signin {
				width: 100%;
				max-width: 420px;
				padding: 15px;
				margin: auto;
			}
			.textfooter{
				text-align: center;
				color: #fff;
				font-size: 12px;
				margin-top: 15px;
			}
			.form-label-group {
				position: relative;
				margin-bottom: 1rem;
			}




		</style>
	</head>

	<body>
		
		<form class="form-signin" action="<?php echo site_url('login/proses');?>" method="post">
			<div class="text-center mb-4">
				<img src="<?php echo base_url('asset');?>/img/pkmonline1.png" class="img-responsive" width="300px"/>
			</div>
			<div class="formlogin">
				<?php
					echo $this->session->flashdata('report');
				?>
				<div class="form-label-group">
					<input type="text" name="username" id="inputNama" class="form-control" placeholder="Username" required autofocus>
				</div>
				<div class="form-label-group">
					<input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Password" required>
				</div>
				<button class="btn btn-md btn-primary" type="submit" style="float: right;">Login</button>
			</div>
			<p class="textfooter">
				2018 | Webservice Simpus, <a href="#" style="color: yellow; text-decoration: none;" data-toggle="modal" data-target="#exampleModalCenter"> Register</a>
			</p>
		</form>
		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="<?php echo base_url('asset');?>/js/jquery.js"></script>
		<script src="<?php echo base_url('asset');?>/js/popper.js"></script>
		<script src="<?php echo base_url('asset');?>/js/bootstrap.min.js"></script>
		<script>
		// Ensure modal works even if scripts load late
		$(document).ready(function() {
			// Prevent default on Register link
			$('a[data-toggle="modal"]').on('click', function(e) {
				e.preventDefault();
			});
			
			// Ensure modal can be opened
			$('#exampleModalCenter').on('show.bs.modal', function () {
				console.log('Modal is opening');
			});
		});
		</script>
   

		<!-- Modal -->
		<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalCenterTitle">Register</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="<?php echo site_url('Login/registrasi_proses');?>" method="post">
							<div class="form-group-sm">
								<label for="message-text" class="col-form-label">Username</label>
								<input type="text" name="username" class="form-control" id="recipient-name" maxlength="30">
							</div>
							<div class="form-group-sm">
								<label for="message-text" class="col-form-label">Password</label>
								<input type="password" name="pass" class="form-control" id="recipient-name" maxlength="15">
							</div>
							<div class="form-group-sm">
								<label for="message-text" class="col-form-label">Email</label>
								<input type="text" name="email" class="form-control" id="recipient-name" maxlength="30">
							</div>
							<div class="form-group-sm">
								<label for="message-text" class="col-form-label">No.Handphone/WA</label>
								<input type="number" name="handphone" class="form-control" id="recipient-name" maxlength="13">
							</div>
							<div class="modal-footer">
								<button class="btn btn-primary" type="submit">Simpan</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
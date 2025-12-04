<?php
	session_start();

	// $base='ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
	$base='123456789';
	$max=strlen($base)-1; 
	$acak='';  
	mt_srand((double)microtime()*1000000);  
	while (strlen($acak)<6){
		$acak.=$base[mt_rand(0,$max)]; 
	}		 
	
	$random = $acak;//rand(1, 9).rand(1, 9).rand(1, 9).rand(1, 9);	
	$_SESSION['captcha'] = $random;

	// $fn = rand(1,3);
	$fn = 1;
  	$font = "fontc/" . $fn . ".ttf";
	
	$captcha = imagecreatefromjpeg("image/captcha.jpg");
	$color = imagecolorallocate($captcha, 255, 255, 255);
	//$font = realpath('code.otf');
	imagettftext($captcha, 30, 0, rand(30, 30), rand(30, 60), $color, $font, $random );
	imagepng($captcha);
	imagedestroy($captcha);
?>
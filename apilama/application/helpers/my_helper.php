<?php
require_once 'vendor/autoload.php';

function stringDecrypt($key, $string){
	$encrypt_method = 'AES-256-CBC';
	// hash
	$key_hash = hex2bin(hash('sha256', $key));
	// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	$iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
	$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
	return $output;
}

// function lzstring decompress 
// download libraries lzstring : https://github.com/nullpunkt/lz-string-php
function decompress($string){
	return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
}

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

function navsidactive($ctrl, $uri){
	$ar = explode(",",$ctrl);
	
	if(in_array($uri,$ar)){
		echo "class='active'";
	}
}

function menuactive($x,$y){
	if($x == $y){
		echo "active";
	}
}

function selecteds($x,$y){
	if($x == $y){
		echo "SELECTED";
	}
}

function angkarupiah($angka)
{
	if($angka == 0){
		$jadi = " ";
	}else{
		$jadi = number_format($angka,0,',','.');
	}
	return $jadi;
}

function rupiah($angka)
{
	if($angka == 0){
		$jadi = " ";
	}else{
		$jadi = "Rp. " . number_format($angka,2,',','.');
	}
	return $jadi;
}

function get_password(){
	$panjangacak = 10;  
	$base='ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';  
	$max=strlen($base)-1;  
	$acak='';  
	mt_srand((double)microtime()*1000000);  
	while (strlen($acak)<$panjangacak)  
		$acak.=$base[mt_rand(0,$max)];  
	return $acak;
}


//================================ PAGINATION SECURITY 
// ============================ FOR SECURITY FILTERING INTPUT ===========================
function pagination_alpha($str)
{
	return ( ! preg_match("/^([a-z])+$/i", $str)) ? "" : $str;
}

function pagination_alpha_numeric($str)
{
	return ( ! preg_match("/^([a-z0-9])+$/i", $str)) ? "" : $str;
}


function pagination_alpha_dash($str)
{
	return ( ! preg_match("/^([-a-z0-9_-])+$/i", $str)) ? "" : $str;
}
function pagination_alpha_all($str)
{
	
    return $str;
	
}	
	
	function set_my_pagination()
	{
		$config['full_tag_open'] = '<ul class="pagination pull-left">';
		$config['full_tag_close'] = '</ul>';
		// Pagination's First Link
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		// Pagination's Last Link
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		// Pagination's Current Link
		$config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
		$config['cur_tag_close'] = '</a></li>';
		// Pagination's Num Link
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		// Pagination's Next Link
		$config['next_link'] = '<span class="glyphicon glyphicon-circle-arrow-right"></span>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		// Pagination's Previous Link
		$config['prev_link'] = '<span class="glyphicon glyphicon-circle-arrow-left"></span>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		
		return $config ; 
	}

function valid($text)
{
	$html = '<div class="alert alert-success alert-dismissible fade show" style="font-size:13px" role="alert">';
    $html .= $text;
    $html .= '<button type="button" class="close" style="padding:8px 8px" data-dismiss="alert" aria-label="Close">';
    $html .= '<span aria-hidden="true">&times;</span>';
    $html .= '</button>';
    $html .= '</div>';
	return $html;
}

function error($text)
{
	$html = '<div class="alert alert-danger alert-dismissible fade show" style="font-size:13px" role="alert">';
    $html .= $text;
    $html .= '<button type="button" class="close" style="padding:8px 8px" data-dismiss="alert" aria-label="Close">';
    $html .= '<span aria-hidden="true">&times;</span>';
    $html .= '</button>';
    $html .= '</div>';
	return $html;
}



function url($text){
	$arr = array(",",".","'","?","!","&");
	$text2 = str_replace($arr,"",$text);

	$hasil = str_replace(" ","-",$text2);
	return strtolower($hasil);
}
function urlkey($text){
	$hasil = str_replace("-"," ",$text);
	return $hasil;
}

function tgl_indos($date)
{
	$month_names = array(
		'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$for = explode("-",$date);
	$tanggal = $for[2]." ".$month_names[$for[1]-1]." ".$for[0];
	return $tanggal;
}

function bulan_indos($bln)
{
	$month_names = array(
		'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	return $month_names[$bln-1];
}

function tgl_indo($date)
{
	$for = explode("-",$date);
	$tanggal = $for[2]."-".$for[1]."-".$for[0];
	return $tanggal;
}


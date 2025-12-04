<?php
	function getUserPass(){
	$koneksi =	mysqli_connect("localhost","root","","dbsmartpuskesmas");
	$x['username'] = "covid19";
	$x['password'] = "Covid19%";
	return $x;
}

	function koneksi_covid($method,$url){
		$getuserpass = getUserPass();
		$username=$getuserpass['username'];
		$password=$getuserpass['password'];
		
		$curl = curl_init($url);
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 60,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $method,
			// CURLOPT_HTTPHEADER => array(
			// "x-secret-key: ".$password,
			// "x-user-id:".$username
			// ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		echo $err;
		curl_close($curl);    
		return $response;
	}


	function get_covid($url){
		//$url = "http://api.u9.nu/covid19";
		//$url = "https://data.kemkes.go.id/data/api/analytics.json?dimension=dx:U7BaEXUa1Ii&dimension=pe:TODAY&filter=ou:amZZzlibrMp&skipData=false&skipMeta=false&includeNumDen=false&displayProperty=SHORTNAME";
		//$url = "https://api.kawalcorona.com/indonesia/";
		$method = "GET";
		$res = koneksi_covid($method,$url);
		return $res;
	}

	function get_covid_prov($url){
		$method = "GET";
		$res = koneksi_covid($method,$url);
		return $res;
	}

	function array_sorting($array, $on, $order=SORT_ASC){
    $new_array = array();
    $sortable_array = array();
  
    if (count($array) > 0) {
      foreach ($array as $k => $v) {
        if (is_array($v)) {
          foreach ($v as $k2 => $v2) {
            if ($k2 == $on) {
              $sortable_array[$k] = $v2;
            }
          }
        } else {
          $sortable_array[$k] = $v;
        }
      }
      switch ($order) {
        case SORT_ASC:
          asort($sortable_array);
          break;
        case SORT_DESC:
          arsort($sortable_array);
          break;
      }

      foreach ($sortable_array as $k => $v) {
      	if($array[$k]['positif_kumulatif'] != null){
            $new_array[$k] = $array[$k];
        }
      }
    }
  
    return $new_array;
  }
	
	function array_filter_berita($array){
	$new_array = array();

    

      foreach ($array as $k => $v) {
      	if($array[$k]['kategori'] == 'Siaran Pers'){
            $new_array[$k] = $array[$k];
        }
      }
    
  
    return $new_array;	
	}
	
?>

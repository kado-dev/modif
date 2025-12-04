<?php 
function process()
{
    $ret = array();
    $timenow = date('Y-m-d H:i:s');         
    $metode_kirim = "online";       //required
    $tahun = "2017";                //date("Y")
    $bulan = "05";                  //date("m")
    $jenis_data = 'obatindikator';  //obatindikator, obatkadaluarsa, ketersediaan_obat (required)    
    $wil = "3471";                   //kode kabupaten atau kode provinsi. jika menggunakan kode provinsi maka ditambah 00 di paling belakang
    $hasil = '';                    //konten data yang dilaporkan diambil dari database
    $log = '';                      //log pelaporan (ambil dari database atau create sendiri)
    $logdata = "";
    $gel = "";
    if($metode_kirim == "online")
    {
        //konten laporan (contoh laporan obat indikator puskesmas)
        foreach($hasil as $key => $value)
        {
            $gel .= $value->kode_pusk. '|';             //kode puskesmas
            $gel .= $value->id_obatindikator.'|';       //kode obat indikator
            $gel .= $value->nama_indikator.'|';         //nama obat indikator
            $gel .= $value->sedia. "\n";                //jumlah
        }

        //konten log laporan
        $logdata .= $log['id'] . '|';               //date('d-m-Y')."/".date('H:i:s');
        $logdata .= $log['periode'] . '|';          //date('Y/m')
        $logdata .= $log['cara_kirim'].'|';         //online
        $logdata .= $log['tglsistem'].'|';          //date('Y-m-d H:i:s')
        $logdata .= $log['status'].'|';             //berhasil
        $logdata .= $log['namatable'].'|';          //obatindikator_05_2017_3471
        $logdata .= $log['id_user']."\n";           //username pengguna sim gudang farmasi
        /*
        Penamaan Tabel
        struktur: <jenis laporan>_<bulan laporan>_<tahun laporan>_<kode wilayah>
        khusus untuk obat kadaluarsa: <jenis laporan>_<kode wilayah>
        */
        
        require_once APPPATH . "libraries/nusoap/lib/nusoap.php";   //memanggil library nusoap
        $url = 'http://bankdataelog.kemkes.go.id/e-logistics-dc';   //url bank data
        $client = new nusoap_client($url."/sinkron?wsdl");          //fungsi integrasi
        $client->soap_defencoding = 'UTF-8';
        $params = array(
            'username'	 		=> base64_encode($username),  //username ifk, didaftarkan dulu melalui bankdataelog.kemkes.go.id/e-logistics-dc
            'password' 			=> base64_encode($password),  //password
            'tahun' 		    => $tahun,
            'bulan'             => $bulan,
            'jenis_data'        => $jenis_data,
            'wil'               => $wil,
            'data' 		        => $gel,
            'logkirim'          => $logdata
        ); //required absolutely

        $result = $client->call('Receive', $params);          //perintah untuk mengirim data
        if ($client->fault)
        {
          $ret['error'] = "failed";
          $ret['msg'] = "The request contains an invalid SOAP body";
        }elseif($result!='success'){
          $this->log_save('gagal',$timenow,$bulan,$tahun,$jenis_data,$wil);             //disimpan di local system
          $ret['error'] = "failed";
          $ret['msg'] = $result;
        }else{
            $err = $client->getError();
            if ($err) {
                $this->log_save('gagal',$timenow,$bulan,$tahun,$jenis_data,$wil);       //disimpan di local system
                $ret['error'] = "failed";
                $ret['msg'] = $err;
            } else {
                $this->log_save('berhasil',$timenow,$bulan,$tahun,$jenis_data,$wil);    //disimpan di local system
                $ret['error'] = "success";
                $ret['msg'] = $result;
            }
        }
    }
}
    // contoh isi variabel params:
    // Array ( 
    //     [username] =>  
    //     [password] => 
    //     [tahun] => 2017 
    //     [bulan] => 01 
    //     [jenis_data] => obatindikator 
    //     [wil] => 1274 
    //     [data] => 
    //         P1274011202|1|Albendazol Tablet|900 P1274020201|1|Albendazol Tablet|2000 P1274020203|1|Albendazol Tablet|600 P1274021202|1|Albendazol Tablet|0 P1274010201|1|Albendazol Tablet|0 P1274030201|1|Albendazol Tablet|2630 P1274011201|1|Albendazol Tablet|0 P1274011201|2|Amoxycilin Tablet 500 mg|2100 P1274021202|2|Amoxycilin Tablet 500 mg|1230 P1274011202|2|Amoxycilin Tablet 500 mg|2195 P1274030201|2|Amoxycilin Tablet 500 mg|1950 P1274020201|2|Amoxycilin Tablet 500 mg|2000 P1274020202|2|Amoxycilin Tablet 500 mg|1526 P1274020203|2|Amoxycilin Tablet 500 mg|2462 P1274010201|2|Amoxycilin Tablet 500 mg|1800 P1274021201|2|Amoxycilin Tablet 500 mg|5040 P1274020202|3|Amoxycilin Syrup|63 P1274020203|3|Amoxycilin Syrup|0 P1274010201|3|Amoxycilin Syrup|0 P1274021201|3|Amoxycilin Syrup|0 P1274011201|3|Amoxycilin Syrup|65 P1274021202|3|Amoxycilin Syrup|0 P1274011202|3|Amoxycilin Syrup|0 P1274030201|3|Amoxycilin Syrup|42 P1274020201|3|Amoxycilin Syrup|100 P1274011201|4|Deksametason Tablet|0 P1274021202|4|Deksametason Tablet|0 P1274011202|4|Deksametason Tablet|0 P1274030201|4|Deksametason Tablet|0 P1274020201|4|Deksametason Tablet|0 P1274020202|4|Deksametason Tablet|220 P1274020203|4|Deksametason Tablet|0 P1274010201|4|Deksametason Tablet|0 P1274021201|4|Deksametason Tablet|0 0|5|Diazepam injeksi 5 mg/ml|0 0|6|Epinefrin(Adrenalin) injeksi 0.1%|0 P1274020201|7|Phytomenadion (Vitamin K) Injeksi|0 P1274020202|7|Phytomenadion (Vitamin K) Injeksi|85 P1274020203|7|Phytomenadion (Vitamin K) Injeksi|230 P1274010201|7|Phytomenadion (Vitamin K) Injeksi|0 P1274021201|7|Phytomenadion (Vitamin K) Injeksi|0 P1274011201|7|Phytomenadion (Vitamin K) Injeksi|150 P1274021202|7|Phytomenadion (Vitamin K) Injeksi|94 P1274011202|7|Phytomenadion (Vitamin K) Injeksi|15 P1274030201|7|Phytomenadion (Vitamin K) Injeksi|0 P1274010201|8|Furosemid Tablet 40 mg \/ Hidroklortiazid (HCT)|0 P1274021201|8|Furosemid Tablet 40 mg \/ Hidroklortiazid (HCT)|229 P1274011201|8|Furosemid Tablet 40 mg \/ Hidroklortiazid (HCT)|60 P1274021202|8|Furosemid Tablet 40 mg \/ Hidroklortiazid (HCT)|100 P1274011202|8|Furosemid Tablet 40 mg \/ Hidroklortiazid (HCT)|180 P1274030201|8|Furosemid Tablet 40 mg \/ Hidroklortiazid (HCT)|120 P1274020201|8|Furosemid Tablet 40 mg \/ Hidroklortiazid (HCT)|200 P1274020202|8|Furosemid Tablet 40 mg \/ Hidroklortiazid (HCT)|70 P1274020203|8|Furosemid Tablet 40 mg \/ Hidroklortiazid (HCT)|400 0|9|Garam Oralit|0 P1274020201|10|Glibenklamid \/ Metformin|0 P1274020202|10|Glibenklamid \/ Metformin|0 P1274020203|10|Glibenklamid \/ Metformin|0 P1274010201|10|Glibenklamid \/ Metformin|0 P1274021201|10|Glibenklamid \/ Metformin|0 P1274011201|10|Glibenklamid \/ Metformin|0 P1274021202|10|Glibenklamid \/ Metformin|0 P1274011202|10|Glibenklamid \/ Metformin|0 P1274030201|10|Glibenklamid \/ Metformin|0 P1274020203|11|Captopril Tablet|398 P1274010201|11|Captopril Tablet|200 P1274021201|11|Captopril Tablet|406 P1274011201|11|Captopril Tablet|120 P1274021202|11|Captopril Tablet|100 P1274011202|11|Captopril Tablet|390 P1274030201|11|Captopril Tablet|300 P1274020201|11|Captopril Tablet|300 P1274020202|11|Captopril Tablet|498 0|12|Magnesium Sulphate Injeksi 20%|0 0|13|Metylergometrin Maleat Injeksi 0.2 mg-1 mL|0 0|14|Obat Anti Tuberculosis Dewasa|0 0|15|Oxytocin Injeksi|0 P1274011202|16|Paracetamol Tablet 500 mg|3425 P1274030201|16|Paracetamol Tablet 500 mg|3570 P1274020201|16|Paracetamol Tablet 500 mg|900 P1274020202|16|Paracetamol Tablet 500 mg|2968 P1274020203|16|Paracetamol Tablet 500 mg|2510 P1274010201|16|Paracetamol Tablet 500 mg|2500 P1274021201|16|Paracetamol Tablet 500 mg|3984 P1274011201|16|Paracetamol Tablet 500 mg|4300 P1274021202|16|Paracetamol Tablet 500 mg|1270 P1274020203|17|Tablet Tambah Darah|0 P1274010201|17|Tablet Tambah Darah|0 P1274021201|17|Tablet Tambah Darah|0 P1274011201|17|Tablet Tambah Darah|0 P1274021202|17|Tablet Tambah Darah|0 P1274011202|17|Tablet Tambah Darah|400 P1274030201|17|Tablet Tambah Darah|0 P1274020201|17|Tablet Tambah Darah|0 P1274020202|17|Tablet Tambah Darah|30 P1274011202|18|Vaksin BCG|20 P1274030201|18|Vaksin BCG|76 P1274020201|18|Vaksin BCG|33 P1274020202|18|Vaksin BCG|135 P1274020203|18|Vaksin BCG|10 P1274010201|18|Vaksin BCG|0 P1274021201|18|Vaksin BCG|6 P1274011201|18|Vaksin BCG|18 P1274021202|18|Vaksin BCG|30 P1274020203|19|Vaksin TT|5 P1274021201|19|Vaksin TT|10 P1274010201|19|Vaksin TT|0 P1274021202|19|Vaksin TT|20 P1274011201|19|Vaksin TT|17 P1274030201|19|Vaksin TT|55 P1274020201|19|Vaksin TT|20 P1274020202|19|Vaksin TT|70 0|20|Vaksin DPT\/DPT-HB\/DPT-HB-Hib|0 
    //     [logkirim] => 
    //         13-07-2017/11:01:33|01/2017|online|2017-07-13 11:01:31|berhasil|obatindikator_01_2017_1274|admin
    // )
?>
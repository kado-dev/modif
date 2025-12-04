<?php
//include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Antrean extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('Model_default');
    }

	public function index(){
		$username = $this->input->get_request_header('X-Username');
		$token = $this->input->get_request_header('X-Token');

		if($username != '' && $token != ''){
			// cek username dan password di db
			$cektoken  = $this->db->query("SELECT * FROM tbtoken a join tbapikey b ON a.id = b.id WHERE b.Username = '$username' AND a.token = '$token' AND a.expire >= CURRENT_TIMESTAMP() ");
			if($cektoken->num_rows() > 0){
				$dttoken = $cektoken->row();
				$kodepuskesmas = $dttoken->KodePuskesmas;
				$reqbdy = file_get_contents("php://input");
            	$datapost = json_decode($reqbdy,true);
            	$nomorkartu = $datapost['nomorkartu'];
            	$nik = $datapost['nik'];
            	$kodepoli = $datapost['kodepoli'];
            	$tanggalperiksa = $datapost['tanggalperiksa'];
            	$keluhan = $datapost['keluhan'];
            	//new v2
            	$KodeDokter = $datapost['kodedokter'];
            	$JamPraktek = $datapost['jampraktek'];
            	$NoRM = $datapost['norm'];
            	$NoHp = $datapost['nohp'];

            	if($nomorkartu == ''){
            		$resp['metadata']['message'] = 'Nomor Kartu Tidak Boleh Kosong';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
            	}
            	if($nik == ''){
            		$resp['metadata']['message'] = 'Nik Tidak Boleh Kosong';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
            	}
            	if($kodepoli == ''){
            		$resp['metadata']['message'] = 'Kode Poli Tidak Boleh Kosong';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
            	}
            	if($tanggalperiksa == ''){
            		$resp['metadata']['message'] = 'Tanggal Tidak Boleh Kosong';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
            	}

            	if(strlen($nomorkartu) != 13){
            		$resp['metadata']['message'] = 'Format Nomor Kartu Tidak Sesuai';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
            	}

            	if(strlen($nik) != 16){
            		$resp['metadata']['message'] = 'Format Nik Tidak Sesuai';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
            	}

            	if(validateDate($tanggalperiksa) == false){
					$resp['metadata']['message'] = 'Format Tanggal Tidak Sesuai, format yang benar adalah yyyy-mm-dd';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
				}

				if($tanggalperiksa < date('Y-m-d')){
					$resp['metadata']['message'] = 'Tanggal Periksa Tidak Berlaku Mundur';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
				}

				$awal = date_create();
				$akhir = date_create($tanggalperiksa);
				$diff  = date_diff( $awal, $akhir );
				if($diff->d >= 1){
					$resp['metadata']['message'] = 'Pendaftaran ke Poli Ini Sedang Tutup';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
				}

				// cek jadwal dokter antrean fktp
				$getjadwaldokter = $this->Model_default->get_jadwal_dokter_antrean($kodepoli,$tanggalperiksa);
				$dtdokter = json_decode($getjadwaldokter,true);
				$array_dtdokter = $dtdokter['response'];

				$cariindex_array = $this->searchForIndex_Kodedokter($KodeDokter, $array_dtdokter);
				// echo "tes: ".$cariindex_array;
				// die
				if(is_int($cariindex_array)){
					$getjampraktek_dokter = $array_dtdokter[$cariindex_array]['jampraktek'];
					if($getjampraktek_dokter != $JamPraktek){
						$resp['metadata']['message'] = 'jam praktek dokter tidak sesuai';
						$resp['metadata']['code'] = 201;
						echo json_encode($resp);
						die();
					}
				}else{					
					$resp['metadata']['message'] = 'Kodedokter tidak sesuai';
					$resp['metadata']['code'] = 201;
					echo json_encode($resp);
					die();
				}

				$getpuskesmas = $this->db->query("SELECT * FROM tbpuskesmas WHERE KodePuskesmas = '$kodepuskesmas'")->row();
				$tbpasien  = 'tbpasien_'.str_replace(' ', '', $getpuskesmas->NamaPuskesmas);
				$tbpasienbpjs  = 'tbpasien_'.str_replace(' ', '', $getpuskesmas->NamaPuskesmas)."_BPJS";
				$tbkk = 'tbkk_'.str_replace(' ', '', $getpuskesmas->NamaPuskesmas);

				// cek norm, keterangan: setelah di cek pihak bpjs, dihilangkan saja
            	// $cek_norm = $this->db->query("SELECT * FROM `$tbpasien` WHERE substring(`NoIndex`,-5) = '$NoRM'");
            	// if($cek_norm->num_rows() == 0){
            	// 	$resp['metadata']['message'] = 'Data Pasien ini tidak ditemukan, silahkan melalukan registrasi Pasien Baru';
				// 	$resp['metadata']['code'] = '202';
				// 	echo json_encode($resp);
				// 	die();
            	// }



            	// cek sts pasien baru/lama
				
				$ceksts = $this->db->query("SELECT IdPasien, NamaPasien, TanggalLahir, JenisKelamin FROM $tbpasien WHERE NoAsuransi = '$nomorkartu'");
            	if($ceksts->num_rows() > 0){
            		$namapasien = $ceksts->row()->NamaPasien;
            		$idpasien = $ceksts->row()->IdPasien;
            		$tglLahir = $ceksts->row()->TanggalLahir;
            		$jeniskelamin = $ceksts->row()->JenisKelamin;
            		$kodes = '200';
            	}else{
            		$dtnikbpjs = $this->Model_default->getDataBpjs($nomorkartu,$kodepuskesmas);
            		$dtjson = json_decode($dtnikbpjs,true);
            		echo $dtnikbpjs;
					die();
					
					// echo "hasil : ".$getnik;
					// $statustarik = $dtjson['content'][0]['RESPONSE_CODE'];
					if($dtjson['metaData']['code'] == '200'){
						$namapasien = $dtjson['response']['nama'];
						$tglLahir = date('Y-m-d',strtotime($dtjson['response']['tglLahir']));
						$jeniskelamin = ($dtjson['response']['sex'] == 'L') ? 'Laki-laki' : 'Perempuan';
	            		//$namapasien = '';
	            		$kodes = 200;
	            		$idpasien = '';
	            		$kodeprovider = $dtjson['response']['kdProviderPst']['kdProvider'];

						//					
						$tahun = date('Y');	
						$getMaxNoIndex = $this->db->query("SELECT max(NoIndex)as maxno FROM `$tbkk`")->row();
						$maxindexplus = substr($getMaxNoIndex->maxno,-5) + 1;
						$noindex = "ID".$kodepuskesmas."/".$tahun."/".sprintf("%05d", $maxindexplus);

						$getmaxNoCM = $this->db->query("SELECT max(NoCM)as maxno FROM `$tbpasien` WHERE substring(NoCM,13,4) = '$tahun'")->row();
						$maxnocmplus = substr($getmaxNoCM->maxno,-6) + 1;
						$nocm = $kodepuskesmas."/".$tahun."/".sprintf("%05d", $maxnocmplus);

						$array_stskeluarga = array(
							'KEPALA KELUARGA'=>'00',
							'ISTRI'=>'01',
							'ANAK 1'=>'02',
							'ANAK 2'=>'03',
							'ANAK 3'=>'04',
							'ANAK 4'=>'05',
							'ANAK 5'=>'06',
							'ANAK 6'=>'07',
							'ANAK 7'=>'08',
							'ANAK 8'=>'09',
							'ANAK 9'=>'10',
							'ANAK 10'=>'11',
							'ANAK 11'=>'12',
							'ANAK 12'=>'13',
							'ANAK 13'=>'14',
							'ANAK 14'=>'15',
							'ANAK 15'=>'16',
							'ANAK 16'=>'17',
							'ANAK 17'=>'18',
							'ANAK 18'=>'19',
							'ANAK 19'=>'20',
							'BAPAK'=>'90',
							'IBU'=>'91',
							'KAKEK'=>'92',
							'NENEK'=>'93',
							'CUCU'=>'94',
							'MENANTU'=>'95',
							'MERTUA'=>'96',
							'SAUDARA KANDUNG'=>'97',
							'KEPONAKAN'=>'98',
							'PONDOK PESANTREN'=>'99',
							'ANAK SEKOLAH'=>'100'
						);
						$norm = $kodepuskesmas.$array_stskeluarga[$dtjson['response']['hubunganKeluarga']].substr($noindex,-5).$tahun;

						$dtpasiennew['TanggalDaftar'] = date('Y-m-d');
						$dtpasiennew['NoIndex'] = $noindex;
						$dtpasiennew['NoCM'] = $nocm;
						$dtpasiennew['Nik'] = $dtjson['response']['noKTP'];
						$dtpasiennew['NoRM'] = $norm;
						$dtpasiennew['NamaPasien'] = $namapasien;
						$dtpasiennew['StatusKeluarga'] = $dtjson['response']['hubunganKeluarga'];
						$dtpasiennew['TanggalLahir'] = $tglLahir;
						$dtpasiennew['JenisKelamin'] = $dtjson['response']['sex'];
						$dtpasiennew['Agama'] = '';
						$dtpasiennew['StatusNikah'] = '';
						$dtpasiennew['Pendidikan'] = '';
						$dtpasiennew['Pekerjaan'] = $dtjson['response']['jnsPeserta']['nama'];
						$dtpasiennew['Asuransi'] = 'BPJS PBI';
						$dtpasiennew['StatusAsuransi'] = $dtjson['response']['hubunganKeluarga'];
						$dtpasiennew['NoAsuransi'] = $dtjson['response']['noKartu'];
						$dtpasiennew['kdprovider'] = $dtjson['response']['kdProviderPst']['kdProvider'];
						$dtpasiennew['Telpon'] = $dtjson['response']['noHP'];
						$dtpasiennew['StatusRetensi'] = 'N';
            			$this->db->insert($tbpasien,$dtpasiennew);


						$idpasien = $this->db->insert_id();

	            	}else{
	            		$resp['metadata']['message'] = 'Error get data nomor kartu bpjs';
						$resp['metadata']['code'] = 201;
						// $resp['metadata']['response'] = $dtnikbpjs;
						echo json_encode($resp);
						die();
	            	}
            	}

            	if($kodepoli == '001'){
            		$poli = 'UMUM';
            		$namapelayanan = "POLI UMUM";
            	}else{
            		$dtpelayanan = $this->db->query("SELECT * FROM `tbpelayanankesehatan` WHERE kdPoli = '$kodepoli'")->row();
            		$poli = str_replace("POLI ", "", $dtpelayanan->Pelayanan);
            		$namapelayanan = $dtpelayanan->Pelayanan;
            	}

            	// cek waktu pelayanan tutup
				date_default_timezone_set('Asia/Jakarta');
				$dtsettingantrian = $this->db->query("SELECT WaktuPelayananTutup FROM `tbantrian_setting` WHERE KodePuskesmas = '$kodepuskesmas'");
				if($dtsettingantrian->num_rows() > 0){
					$waktututup = str_replace(".", ":", $dtsettingantrian->row()->WaktuPelayananTutup);
					// echo date("h:i");
					// die();
					if($waktututup < date('h:i')){
						$resp['metadata']['message'] = 'Pendaftaran ke Poli('.$namapelayanan.') Sudah Tutup Jam '.$waktututup;
						$resp['metadata']['code'] = '201';
						echo json_encode($resp);
						die();
					}
				}

			$tbantranpasien = "tbantrian_pasien_".$kodepuskesmas;
            $tbpasienonline_kd = "tbpasienonline_".$kodepuskesmas;

            	// cek jumlah pelayanan
            	$cek_jumlahpel = $this->db->query("SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas` = '$kodepuskesmas' AND `Pelayanan` = '$poli' AND `Jumlah` = '0'");
            	if($cek_jumlahpel->num_rows() == 1){
            		$resp['metadata']['message'] = 'Pendaftaran ke Poli Ini Sedang Tutup';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
            	}

            	//cek kuota online
            	$kuotaonline = 0;
            	$ge_kuotaonline = $this->db->query("SELECT KuotaOnline FROM `tbantrian_pelayanan` WHERE `KodePuskesmas` = '$kodepuskesmas' AND `Pelayanan` = '$poli'");
            	if($ge_kuotaonline->num_rows() > 0){
            		$kuotaonline = $ge_kuotaonline->row()->KuotaOnline;
            	}

            	$kuotaonline_terpakai = $this->db->query("SELECT IdAntrian FROM `$tbantranpasien` WHERE KodePuskesmas = '$kodepuskesmas' AND PoliPertama = '$poli' AND DATE(WaktuAntrian) = '$tanggalperiksa'")->num_rows();

            	if($kuotaonline_terpakai >= $kuotaonline){
            		$resp['metadata']['message'] = 'Maaf kuota online sudah habis, silahkan daftar di hari berikutnya';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
            	}

            	// cek pernah daftar belum
            	
            	$cek_daftar = $this->db->query("SELECT IdAntrian FROM `$tbantranpasien` a JOIN $tbpasienonline_kd b ON a.IdPasienOnline = b.IdPasienOnline WHERE a.PoliPertama = '$poli' AND DATE(a.WaktuAntrian) = '$tanggalperiksa' AND b.NoAsuransi = '$nomorkartu'")->num_rows();
            	if($cek_daftar > 0){
            		$resp['metadata']['message'] = 'Nomor Antrian Hanya Dapat Diambil 1 Kali Pada Tanggal dan Poli Yang Sama';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
            	}

				// cek dulu nomer antrian endaftaran dan poli
				$noantrian = $this->db->query("SELECT IdAntrian FROM `$tbantranpasien` WHERE KodePuskesmas = '$kodepuskesmas' AND DATE(WaktuAntrian) = '$tanggalperiksa'")->num_rows() + 1;
            	$noantrianpoli = $this->db->query("SELECT IdAntrian FROM `$tbantranpasien` WHERE KodePuskesmas = '$kodepuskesmas' AND PoliPertama = '$poli' AND DATE(WaktuAntrian) = '$tanggalperiksa'")->num_rows() + 1;

            	// insert ke tbpasienonline
            	$tbpasienonline['IdPasien'] = $idpasien;
            	$tbpasienonline['Nik'] = $nik;
            	$tbpasienonline['NamaPasien'] = $namapasien;
            	$tbpasienonline['JenisKelamin'] = $jeniskelamin;
            	$tbpasienonline['TanggalLahir'] = $tglLahir;
            	$tbpasienonline['NoAsuransi'] = $nomorkartu;
            	$tbpasienonline['keluhan'] = $keluhan;
            	//new v2
            	$tbpasienonline['KodeDokter'] = $KodeDokter;
            	$tbpasienonline['JamPraktek'] = $JamPraktek;
            	$tbpasienonline['NoRM'] = $NoRM;
            	$tbpasienonline['NoHp'] = $NoHp;
            	// end new v2
            	$tbpasienonline['PoliPertama'] = $namapelayanan;
            	$tbpasienonline['Asuransi'] = 'BPJS';
            	$tbpasienonline['KodePuskesmas'] = $kodepuskesmas;
				$tbpasienonline['NomorAntrian'] = $noantrian;
            	$tbpasienonline['NomorAntrianPoli'] = $noantrianpoli;
            	$tbpasienonline['WaktuDaftar'] = date('Y-m-d',strtotime($tanggalperiksa))." ".date('G:i:s');
            	$tbpasienonline['StatusDaftar'] = 'M-JKN';            	
            	$tbpasienonline['Approve'] = 'N';            	
            	$this->db->insert($tbpasienonline_kd,$tbpasienonline);
            	$idpasienonline = $this->db->insert_id();
				
            	// insert ke antrian
            	$tbantrian['IdPasienOnline'] = $idpasienonline;
            	$tbantrian['WaktuAntrian'] = date('Y-m-d',strtotime($tanggalperiksa))." ".date('G:i:s');
            	$tbantrian['KodePuskesmas'] = $kodepuskesmas;
            	$tbantrian['NomorAntrian'] = $noantrian;
            	$tbantrian['NomorAntrianPoli'] = $noantrianpoli;
            	$tbantrian['PoliPertama'] = $poli;
            	$tbantrian['StatusAntrian'] = 'Selesai';
            	$tbantrian['StatusBpjs'] = 'Proses';
            	$tbantrian['nomorkartubpjs'] = $nomorkartu;
            	$tbantrian['kodepolibpjs'] = $kodepoli;
				$tbantrian['StatusDaftar'] = 'M-JKN';
            	$this->db->insert($tbantranpasien,$tbantrian);

				$dtkodepoli = $this->db->query("SELECT KodePelayanan, Jumlah FROM `tbantrian_pelayanan` WHERE KodePuskesmas = '$kodepuskesmas' AND  Pelayanan = '$poli'");
				if($dtkodepoli->num_rows() == 0){
					$kdpoli = '';
					$sisaantrean = 0;
				}else{
					$kdpoli = $dtkodepoli->row()->KodePelayanan;
					$jmlkuota = $dtkodepoli->row()->Jumlah;
					$totalantrean = $this->db->query("SELECT IdAntrian FROM `$tbantranpasien` WHERE KodePuskesmas = '$kodepuskesmas' AND PoliPertama = '$poli' AND DATE(WaktuAntrian) = '$tanggalperiksa'")->num_rows();
					// $totalantrean_selesai = $this->db->query("SELECT IdAntrian FROM `$tbantranpasien` WHERE KodePuskesmas = '$kodepuskesmas' AND PoliPertama = '$poli' AND DATE(WaktuAntrian) = '$tanggalperiksa' AND StatusBpjs = 'Selesai'")->num_rows();
					$sisaantrean = $jmlkuota - $totalantrean;
				}	
				
				// antreanpanggil -> yg sudah dipanggil
				$cekantreanpanggil = $this->db->query("SELECT NomorAntrianPoli FROM `$tbantranpasien` WHERE  PoliPertama = '$poli' AND DATE(WaktuAntrian) = '$tanggalperiksa' AND StatusAntrian = 'Antri' ORDER BY IdAntrian ASC LIMIT 1");	
				if($cekantreanpanggil->num_rows() > 0){
					$dtantreanpanggil = $cekantreanpanggil->row();
					$antreanpanggil = $kdpoli.$dtantreanpanggil->NomorAntrianPoli;
				}else{
					$antreanpanggil = '';
				}

            	$resp['response']['nomorantrean'] = $kdpoli.$noantrianpoli;
            	$resp['response']['angkaantrean'] = "$noantrianpoli";
            	$resp['response']['namapoli'] = $poli;
            	$resp['response']['sisaantrean'] = "$sisaantrean";
            	$resp['response']['antreanpanggil'] = $antreanpanggil;
            	$resp['response']['keterangan'] = 'Apabila antrean terlewat harap mengambil antrean kembali';
				$resp['metadata']['message'] = 'ok';
				$resp['metadata']['code'] = $kodes;
			}else{
				$resp['metadata']['message'] = 'Token Expired';
				$resp['metadata']['code'] = '201';
			}
		}else{
			$resp['metadata']['message'] = 'Username atau token harus diisi';
			$resp['metadata']['code'] = '201';
		}
		echo json_encode($resp);
	}

	// GET
	public function status(){
		$username = $this->input->get_request_header('X-Username');
		$token = $this->input->get_request_header('X-Token');

		if($username != '' && $token != ''){
			//cek username dan password di db
			$cektoken  = $this->db->query("SELECT * FROM tbtoken a join tbapikey b ON a.id = b.id WHERE b.Username = '$username' AND a.token = '$token' AND a.expire >= CURRENT_TIMESTAMP() ");
			if($cektoken->num_rows() > 0){
				$dttoken = $cektoken->row();
				$kodepuskesmas = $dttoken->KodePuskesmas;
				if(validateDate($this->uri->segment(4)) == false){
					$resp['metadata']['message'] = 'Format Tanggal Tidak Sesuai, format yang benar adalah yyyy-mm-dd';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
				}

				if($this->uri->segment(4) < date('Y-m-d')){
					$resp['metadata']['message'] = 'Tanggal Periksa Tidak Berlaku';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
				}

				//get token
				$kodepoli = $this->uri->segment(3);
				$tanggalperiksa = date('Y-m-d',strtotime($this->uri->segment(4)));
				$getnamapoli = $this->db->query("SELECT * FROM `tbpelayanankesehatan` WHERE kdPoli = '$kodepoli'");
				if($getnamapoli->num_rows() > 0){
					$dtpoli = $getnamapoli->row();
					$tbantranpasien = "tbantrian_pasien_".$kodepuskesmas;
					$tbpasienonline = "tbpasienonline_".$kodepuskesmas;

					if($kodepoli == '001'){
	            		$poli = 'UMUM';
	            		$namapelayanan = "UMUM";
	            	}else{
	            		$poli = str_replace("POLI ", "", $dtpoli->Pelayanan);
	            		$namapelayanan = $dtpoli->Pelayanan;
	            	}

	            	$dtkodepoli = $this->db->query("SELECT KodePelayanan FROM `tbantrian_pelayanan` WHERE KodePuskesmas = '$kodepuskesmas' AND  Pelayanan = '$poli'");
				
					if($dtkodepoli->num_rows() == 0){
						$kdpoli = '';
					}else{
						$kdpoli = $dtkodepoli->row()->KodePelayanan;
					}

	            	$totalantrean = $this->db->query("SELECT IdAntrian FROM `$tbantranpasien` WHERE PoliPertama = '$poli' AND DATE(WaktuAntrian) = '$tanggalperiksa' AND StatusBpjs != '-'")->num_rows();
					$totalantrean_selesai = $this->db->query("SELECT IdAntrian FROM `$tbantranpasien` WHERE PoliPertama = '$poli' AND DATE(WaktuAntrian) = '$tanggalperiksa' AND StatusAntrian = 'Selesai'")->num_rows();

					// StatusBpjs, maksudnya saat daftar mjkn defaulnya proses dan ketika approve melalui 
					// simpus (daftaronline) menjadi Selesai
					$getAntrian = $this->db->query("SELECT IdPasienOnline, NomorAntrian, NomorAntrianPoli, PoliPertama FROM `$tbantranpasien` WHERE PoliPertama = '$poli' AND DATE(WaktuAntrian) = '$tanggalperiksa' AND StatusBpjs = 'Proses' ORDER BY IdAntrian ASC");
					if($getAntrian->num_rows() > 0){

						foreach($getAntrian->result() as $dtantr){

							$kddokter = '';
							$nmdokter = '';
							$jampraktek = '';

							$idpasonline = $dtantr->IdPasienOnline;
							$getPasien = $this->db->query("SELECT * FROM $tbpasienonline WHERE IdPasienOnline = '$idpasonline'");
							if($getPasien->num_rows() > 0){								
								$dtpas = $getPasien->row();
								$kddokter = $dtpas->KodeDokter;
								$getnamadokter = $this->db->query("SELECT * FROM `tbpegawaibpjsjadwal` WHERE kodedokter = '$kddokter'");
								if($getnamadokter->num_rows() > 0){
									$nmdokter = $getnamadokter->row()->namadokter;
								}else{
									$nmdokter = '';
								}
								$jampraktek = $dtpas->JamPraktek;
							}

							
							$getnoantrianpoli = $dtantr->NomorAntrianPoli;
							$antreanpanggil = $kdpoli.$getnoantrianpoli;
							//$sisaantrean = $totalantrean - $totalantrean_selesai - 1;//ini sebelum update v2
							$sisaantrean = $totalantrean - $getnoantrianpoli;
							

							$resp_s['namapoli'] = $poli;
							$resp_s['totalantrean'] = "$totalantrean";
							$resp_s['sisaantrean'] = $sisaantrean;
							$resp_s['antreanpanggil'] = $antreanpanggil;
							$resp_s['keterangan'] = '';
							$resp_s['kodedokter'] = $kddokter;
							$resp_s['namadokter'] = $nmdokter;
							$resp_s['jampraktek'] = $jampraktek;

							$resparry[] = $resp_s;

						}

						$resp['response'] = $resparry;
						$resp['metadata']['message'] = 'Ok';
						$resp['metadata']['code'] = 200;
					}else{
						$resp['metadata']['message'] = 'Data Tidak Ditemukan';
						$resp['metadata']['code'] = 201;
					}					
				}else{
					$resp['metadata']['message'] = 'Poli Tidak Ditemukan';
					$resp['metadata']['code'] = 201;
				}
			}else{
				$resp['metadata']['message'] = 'Token Expired';
				$resp['metadata']['code'] = 201;
			}
		}else{
			$resp['metadata']['message'] = 'Username atau token harus diisi';
			$resp['metadata']['code'] = 201;
		}
		echo json_encode($resp);
	}


	// GET
	public function sisapeserta(){
		$username = $this->input->get_request_header('X-Username');
		$token = $this->input->get_request_header('X-Token');

		if($username != '' && $token != ''){
			//cek username dan password di db
			$cektoken  = $this->db->query("SELECT * FROM tbtoken a join tbapikey b ON a.id = b.id WHERE b.Username = '$username' AND a.token = '$token' AND a.expire >= CURRENT_TIMESTAMP() ");
			if($cektoken->num_rows() > 0){
				$dttoken = $cektoken->row();
				$kodepuskesmas = $dttoken->KodePuskesmas;

				if(validateDate($this->uri->segment(5)) == false){
					$resp['metadata']['message'] = 'Format Tanggal Tidak Sesuai, format yang benar adalah yyyy-mm-dd';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
				}

				//get token
				$nokartu = $this->uri->segment(3);
				$kodepoli = $this->uri->segment(4);
				$tanggalperiksa = date('Y-m-d',strtotime($this->uri->segment(5)));
				$getnamapoli = $this->db->query("SELECT * FROM `tbpelayanankesehatan` WHERE kdPoli = '$kodepoli'");
				if($getnamapoli->num_rows() > 0){
					$dtpoli = $getnamapoli->row();
					$tbantranpasien = "tbantrian_pasien_".$kodepuskesmas;
					$tbpasienonline = "tbpasienonline_".$kodepuskesmas;
					

					if($kodepoli == '001'){
	            		$poli = 'UMUM';
	            		$namapelayanan = "UMUM";
	            	}else{
	            		$poli = str_replace("POLI ", "", $dtpoli->Pelayanan);
	            		$namapelayanan = $dtpoli->Pelayanan;
	            	}
					
					//$totalantrean = $this->db->query("SELECT IdAntrian FROM `$tbantranpasien` WHERE KodePuskesmas = '$kodepuskesmas' AND PoliPertama = '$poli' AND DATE(WaktuAntrian) = '$tanggalperiksa'")->num_rows();
					$totalantrean_selesai = $this->db->query("SELECT IdAntrian FROM `$tbantranpasien` WHERE KodePuskesmas = '$kodepuskesmas' AND PoliPertama = '$poli' AND DATE(WaktuAntrian) = '$tanggalperiksa' AND StatusAntrian = 'Selesai'")->num_rows();
					
					$getnoantrean = $this->db->query("SELECT a.IdAntrian, a.NomorAntrianPoli FROM `$tbantranpasien` a join `$tbpasienonline` b ON a.IdPasienOnline = b.IdPasienOnline WHERE a.PoliPertama = '$poli' AND DATE(a.WaktuAntrian) = '$tanggalperiksa' AND b.NoAsuransi = '$nokartu'");
					if($getnoantrean->num_rows() > 0){
						$nomorantrean = $getnoantrean->row()->NomorAntrianPoli;
					}else{
						//$nomorantrean = 0;
						$resp['metadata']['message'] = 'Antrean Tidak Ditemukan';
						$resp['metadata']['code'] = 201;
						echo json_encode($resp);
						die();
					}

					$dtkodepoli = $this->db->query("SELECT KodePelayanan FROM `tbantrian_pelayanan` WHERE KodePuskesmas = '$kodepuskesmas' AND  Pelayanan = '$poli'");

					if($dtkodepoli->num_rows() == 0){
						$kdpoli = '';
					}else{
						$kdpoli = $dtkodepoli->row()->KodePelayanan;
					}

					$dtantrian_antri = $this->db->query("SELECT NomorAntrian, NomorAntrianPoli, PoliPertama FROM `$tbantranpasien` WHERE PoliPertama = '$poli' AND DATE(WaktuAntrian) = '$tanggalperiksa' AND StatusAntrian = 'Selesai' ORDER BY IdAntrian ASC Limit 1");
					if($dtantrian_antri->num_rows() == 0){
						$antreanpanggil = "0";
						$sisaantrean = "0";
					}else{
						$antreanpanggil = $kdpoli.$dtantrian_antri->row()->NomorAntrianPoli;
						$sisaantrean = $nomorantrean - 1;
					}

					
					$resp['response']['nomorantrean'] = $kdpoli.$nomorantrean;
					$resp['response']['namapoli'] = $poli;
					$resp['response']['sisaantrean'] = $sisaantrean;
					$resp['response']['antreanpanggil'] = $antreanpanggil;
					$resp['response']['keterangan'] = '';
					$resp['metadata']['message'] = 'Ok';
					$resp['metadata']['code'] = 200;
				}else{
					$resp['metadata']['message'] = 'kodepoli tidak cocok';
					$resp['metadata']['code'] = 201;
				}
			}else{
				$resp['metadata']['message'] = 'Token Expired';
				$resp['metadata']['code'] = 201;
			}
		}else{
			$resp['metadata']['message'] = 'Username atau token harus diisi';
			$resp['metadata']['code'] = 201;
		}
		echo json_encode($resp);
	}

	// GET
	public function batal(){
		$username = $this->input->get_request_header('X-Username');
		$token = $this->input->get_request_header('X-Token');

		if($username != '' && $token != ''){
			//cek username dan password di db
			$cektoken  = $this->db->query("SELECT * FROM tbtoken a join tbapikey b ON a.id = b.id WHERE b.Username = '$username' AND a.token = '$token' AND a.expire >= CURRENT_TIMESTAMP() ");
			if($cektoken->num_rows() > 0){
				$dttoken = $cektoken->row();
				$kodepuskesmas = $dttoken->KodePuskesmas;
				$tbantranpasien = "tbantrian_pasien_".$kodepuskesmas;
				$tbpasienonline = "tbpasienonline_".$kodepuskesmas;

				$reqbdy = file_get_contents("php://input");
            	$datapost = json_decode($reqbdy,true);
            	$nomorkartu = $datapost['nomorkartu'];
            	$kodepoli = $datapost['kodepoli'];
            	$keterangan_batal = $datapost['keterangan'];//update v2
            	$tanggalperiksa = date('Y-m-d',strtotime($datapost['tanggalperiksa']));

            	if(validateDate($datapost['tanggalperiksa']) == false){
					$resp['metadata']['message'] = 'Format Tanggal Tidak Sesuai, format yang benar adalah yyyy-mm-dd';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
				}

				// bisa dibatalkan ,dengan cara namabah status lagi, untuk yg daftar bpjs(karna antriannya langsung selesai)
				$cekdata = $this->db->query("SELECT a.IdAntrian, a.StatusAntrian, a.StatusBpjs, a.NomorAntrianPoli 
				FROM `$tbantranpasien` a join `$tbpasienonline` b ON a.IdPasienOnline = b.IdPasienOnline 
				WHERE DATE(a.WaktuAntrian) = '$tanggalperiksa' AND b.NoAsuransi = '$nomorkartu'");
				if($cekdata->num_rows() > 0){
					$idantrian = $cekdata->row()->IdAntrian;
					$statusAntrian = $cekdata->row()->StatusAntrian;
					$StatusBpjs = $cekdata->row()->StatusBpjs;
					if($StatusBpjs == 'Selesai'){
						$resp['metadata']['message'] = 'Pasien Sudah Dilayani, Antrian Tidak Dapat Dibatalkan';
						$resp['metadata']['code'] = 201;
						echo json_encode($resp);
						die();
					}

					if($statusAntrian == 'Batal'){
						$resp['metadata']['message'] = 'Antrian Tidak Ditemukan atau Sudah Dibatalkan';
						$resp['metadata']['code'] = 201;
						echo json_encode($resp);
						die();
					}

					$tbantrian['StatusAntrian'] = 'Batal';
					$tbantrian['KeteranganBatal'] = $keterangan_batal;
					$this->db->where('IdAntrian', $idantrian);
					$this->db->update($tbantranpasien, $tbantrian);
					

					$resp['metadata']['message'] = 'Ok';
					$resp['metadata']['code'] = 200;
				}else{
					$resp['metadata']['message'] = 'Antrean Tidak Ditemukan';
					$resp['metadata']['code'] = 201;
				}
			}else{
				$resp['metadata']['message'] = 'Token Expired';
				$resp['metadata']['code'] = 201;
			}
		}else{
			$resp['metadata']['message'] = 'Username atau token harus diisi';
			$resp['metadata']['code'] = 201;
		}
		echo json_encode($resp);
	}

	public function peserta(){
		$username = $this->input->get_request_header('X-Username');
		$token = $this->input->get_request_header('X-Token');

		if($username != '' && $token != ''){
			// cek username dan password di db
			$cektoken  = $this->db->query("SELECT * FROM tbtoken a join tbapikey b ON a.id = b.id WHERE b.Username = '$username' AND a.token = '$token' AND a.expire >= CURRENT_TIMESTAMP() ");
			if($cektoken->num_rows() > 0){
				$dttoken = $cektoken->row();
				$kodepuskesmas = $dttoken->KodePuskesmas;

				$getpuskesmas = $this->db->query("SELECT * FROM tbpuskesmas WHERE KodePuskesmas = '$kodepuskesmas'")->row();
				$tbpasien  = 'tbpasien_'.str_replace(' ', '', $getpuskesmas->NamaPuskesmas);
				$tbpasienbpjs  = 'tbpasien_'.str_replace(' ', '', $getpuskesmas->NamaPuskesmas)."_BPJS";
				
				$reqbdy = file_get_contents("php://input");
            	$datapost = json_decode($reqbdy,true);

            	$nomorkartu = $datapost['nomorkartu'];
            	$nik = $datapost['nik'];
            	$nomorkk = $datapost['nomorkk'];
            	$nama = $datapost['nama'];
            	$jeniskelamin = $datapost['jeniskelamin'];
            	$tanggallahir = $datapost['tanggallahir'];
            	$alamat = $datapost['alamat'];
            	$kodeprop = $datapost['kodeprop'];
            	$namaprop = $datapost['namaprop'];
            	$kodedati2 = $datapost['kodedati2'];
            	$namadati2 = $datapost['namadati2'];
            	$kodekec = $datapost['kodekec'];
            	$namakec = $datapost['namakec'];
            	$kodekel = $datapost['kodekel'];
            	$namakel = $datapost['namakel'];
            	$rw = $datapost['rw'];
            	$rt = $datapost['rt'];

            	if($nomorkartu == ''){
            		$resp['metadata']['message'] = 'Nomor Kartu Tidak Boleh Kosong';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
            	}
            	if($nik == ''){
            		$resp['metadata']['message'] = 'Nik Tidak Boleh Kosong';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
            	}
            	

            	if(strlen($nomorkartu) != 13){
            		$resp['metadata']['message'] = 'Format Nomor Kartu Tidak Sesuai';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
            	}

            	if(strlen($nik) != 16){
            		$resp['metadata']['message'] = 'Format Nik Tidak Sesuai';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
            	}            
				
            	// insert 
            	$dtpeserta['nomorkartu'] = $nomorkartu;
            	$dtpeserta['nik'] = $nik;
            	$dtpeserta['nomorkk'] = $nomorkk;
            	$dtpeserta['nama'] = $nama;
            	$dtpeserta['jeniskelamin'] = $jeniskelamin;
            	$dtpeserta['tanggallahir'] = $tanggallahir;
            	$dtpeserta['alamat'] = $alamat;
            	$dtpeserta['kodeprop'] = $kodeprop;
            	$dtpeserta['namaprop'] = $namaprop;
            	$dtpeserta['kodedati2'] = $kodedati2;
            	$dtpeserta['namadati2'] = $namadati2;
            	$dtpeserta['kodekec'] = $kodekec;
            	$dtpeserta['namakec'] = $namakec;
            	$dtpeserta['kodekel'] = $kodekel;
            	$dtpeserta['namakel'] = $namakel;
            	$dtpeserta['rt'] = $rt;
            	$dtpeserta['rw'] = $rw;
            	$this->db->insert($tbpasienbpjs,$dtpeserta);

				$resp['metadata']['message'] = 'ok';
				$resp['metadata']['code'] = '200';
			}else{
				$resp['metadata']['message'] = 'Token Expired';
				$resp['metadata']['code'] = '201';
			}
		}else{
			$resp['metadata']['message'] = 'Username atau token harus diisi';
			$resp['metadata']['code'] = '201';
		}
		echo json_encode($resp);
	}

	function getDataBpjs(){
		$dtnikbpjs = $this->Model_default->getDataBpjs('0002427779463','p0001060882');		
		//echo $dtnikbpjs;
		$dtjson = json_decode($dtnikbpjs,true);
		$kodeprovider = $dtjson['response']['kdProviderPst']['kdProvider'];
		echo $kodeprovider;
	}

	function searchForIndex_Kodedokter($kode, $array) {
		foreach ($array as $key => $val) {
			if ($val['kodedokter'] === $kode) {
				return $key;
			}
		}
		return null;
	 }
}
?>
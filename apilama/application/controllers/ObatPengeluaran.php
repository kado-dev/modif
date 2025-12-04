<?php
//include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class ObatPengeluaran extends CI_Controller {
	function __construct(){
        parent::__construct();
    }

	public function index(){
		$username = $this->input->get_request_header('X-username');
		$token = $this->input->get_request_header('X-token');

		if($username != '' && $token != ''){
			// cek username dan password di db
			$cektoken  = $this->db->query("SELECT * FROM tbtoken a join tbapikey b ON a.id = b.id WHERE b.Username = '$username' AND a.token = '$token' AND a.expire >= CURRENT_TIMESTAMP() ");
			if($cektoken->num_rows() > 0){
				$dttoken = $cektoken->row();
				$kodepuskesmas = $dttoken->KodePuskesmas;
				// $reqbdy = file_get_contents("php://input");
            	// $datapost = json_decode($reqbdy,true);
            	$TahunPengeluaran = $this->input->get('tahun');
            	$BulanPengeluaran = $this->input->get('bulan');
     

            	if($TahunPengeluaran == ''){
            		$resp['metadata']['message'] = 'Tahun Pengeluaran Tidak Boleh Kosong';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
            	}

                $wherbulan = "";
                if($BulanPengeluaran != ''){
                    $wherbulan = " AND MONTH(`TanggalPengeluaran`) = '$BulanPengeluaran'";
                }
            

            	$list = $this->db->query("SELECT * FROM `tbgfkpengeluaran` WHERE YEAR(`TanggalPengeluaran`)='$TahunPengeluaran' AND `KodePenerima` = '$kodepuskesmas'".$wherbulan);
                if($list->num_rows() > 0){
             
                    $jumlah_faktur = $this->db->query("SELECT * FROM tbgfkpengeluarandetail a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur WHERE b.KodePenerima = '$kodepuskesmas' AND YEAR(b.TanggalPengeluaran)='$TahunPengeluaran' GROUP BY a.NoFaktur")->num_rows();
                    $belum_validasi = $this->db->query("SELECT * FROM tbgfkpengeluarandetail a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur WHERE b.KodePenerima = '$kodepuskesmas' AND YEAR(b.TanggalPengeluaran)='$TahunPengeluaran' AND a.StatusValidasi='Belum' GROUP BY a.NoFaktur")->num_rows();

                    $getgrand_total = $this->db->query("SELECT SUM(a.Jumlah * a.Harga) AS Jumlah FROM tbgfkpengeluarandetail a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur WHERE b.KodePenerima = '$kodepuskesmas' AND YEAR(b.`TanggalPengeluaran`)='$TahunPengeluaran'");
                    $grantotals = 0;
                    if($getgrand_total->num_rows() > 0){
                        $dtjms = $getgrand_total->row();
                        $grantotals = $dtjms->Jumlah;
                    }

                    foreach($list->result() as $lst){
                        $x['IdDistribusi'] = $lst->IdDistribusi;
                        $x['TanggalEntry'] = $lst->TanggalEntry;
                        $x['TanggalPengeluaran'] = $lst->TanggalPengeluaran;
                        $x['JamPengeluaran'] = $lst->JamPengeluaran;
                        $x['NoFaktur'] = $lst->NoFaktur;
                        $x['StatusPengeluaran'] = $lst->StatusPengeluaran;
                        $x['KodePenerima'] = $lst->KodePenerima;
                        $x['Penerima'] = $lst->Penerima;
                        $x['PetugasPenerima'] = $lst->PetugasPenerima;
                        $x['NamaProgram'] = $lst->NamaProgram;
                        $x['Keterangan'] = $lst->Keterangan;
                        $x['GrandTotal'] = $lst->GrandTotal;

                        $jmlitem = $this->db->query("SELECT `KodeBarang` FROM `tbgfkpengeluarandetail` WHERE `NoFaktur`='$lst->NoFaktur'")->num_rows();
						$validasi_belum = $this->db->query("SELECT `KodeBarang` FROM `tbgfkpengeluarandetail` WHERE `NoFaktur`='$lst->NoFaktur' AND `StatusValidasi`='Belum'")->num_rows();

                        $grantot = 0;
                        $getdtjm = $this->db->query("SELECT SUM(Jumlah * Harga) AS Jumlah FROM tbgfkpengeluarandetail WHERE NoFaktur = '$lst->NoFaktur'");
                        if($getdtjm->num_rows() > 0){
                            $dtjm = $getdtjm->row();
                            $grantot = $dtjm->Jumlah;
                        }

                        $x['jmlitem'] = $jmlitem;
                        $x['validasi_belum'] = $validasi_belum;
                        $x['grandtotal'] = $grantot;

                        $y[] = $x;
                    }

                    
                    $hasil['Count'] = $list->num_rows();
                    $hasil['List'] = $y;
                    
                    $resp['metadata']['data'] = $hasil;
                    $resp['metadata']['jumlah_faktur'] = $jumlah_faktur;
                    $resp['metadata']['belum_validasi'] = $belum_validasi;
                    $resp['metadata']['grand_total'] = $grantotals;
                    $resp['metadata']['message'] = 'Berhasil';
                    $resp['metadata']['code'] = 200;
                }else{
                    $resp['metadata']['message'] = 'Tidak ada data';
                    $resp['metadata']['code'] = 204;
                }
                

			}else{
				$resp['metadata']['message'] = 'Token Expired';
				$resp['metadata']['code'] = '201';
			}
		}else{
			$resp['metadata']['message'] = 'Username atau token harus diisi '.$username.": ".$token;
			$resp['metadata']['code'] = '201';
		}
		echo json_encode($resp);
	}

    public function detail(){
		$username = $this->input->get_request_header('X-username');
		$token = $this->input->get_request_header('X-token');

		if($username != '' && $token != ''){
			// cek username dan password di db
			$cektoken  = $this->db->query("SELECT * FROM tbtoken a join tbapikey b ON a.id = b.id WHERE b.Username = '$username' AND a.token = '$token' AND a.expire >= CURRENT_TIMESTAMP() ");
			if($cektoken->num_rows() > 0){
				$dttoken = $cektoken->row();
				$kodepuskesmas = $dttoken->KodePuskesmas;
				// $reqbdy = file_get_contents("php://input");
            	// $datapost = json_decode($reqbdy,true);
            	$nofaktur = $this->input->get('nofaktur');
     

            	if($nofaktur == ''){
            		$resp['metadata']['message'] = 'nofaktur Tidak Boleh Kosong';
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
            	}
            

            	$list = $this->db->query("SELECT a.Id, a.IdDistribusi, a.NoFaktur, a.KodeBarang, b.NamaBarang, a.NoBatch, a.NoFakturTerima, b.Satuan, b.Expire, b.SumberAnggaran, b.TahunAnggaran, b.HargaBeli, a.Jumlah, a.StatusValidasi, b.IdProgram, b.NamaProgram FROM `tbgfkpengeluarandetail` a LEFT JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang WHERE a.NoFaktur = '$nofaktur' AND a.NoBatch = b.NoBatch GROUP BY a.Id ORDER BY NamaBarang");

                if($list->num_rows() > 0){
                                 
                    $hasil['Count'] = $list->num_rows();
                    $hasil['List'] = $list->result();

                    $dtpengeluaran = $this->db->query("SELECT * FROM `tbgfkpengeluaran` WHERE NoFaktur = '$nofaktur' AND `KodePenerima` = '$kodepuskesmas'".$wherbulan);
                    
                    
                    $resp['metadata']['data'] = $dtpengeluaran->row();
                    $resp['metadata']['list'] = $hasil;
                    $resp['metadata']['message'] = 'Berhasil';
                    $resp['metadata']['code'] = 200;
                }else{
                    $resp['metadata']['message'] = 'Tidak ada data';
                    $resp['metadata']['code'] = 204;
                }
                

			}else{
				$resp['metadata']['message'] = 'Token Expired';
				$resp['metadata']['code'] = '201';
			}
		}else{
			$resp['metadata']['message'] = 'Username atau token harus diisi '.$username.": ".$token;
			$resp['metadata']['code'] = '201';
		}
		echo json_encode($resp);
	}


    public function update_sts_detail(){
		$username = $this->input->get_request_header('X-username');
		$token = $this->input->get_request_header('X-token');

		if($username != '' && $token != ''){
			// cek username dan password di db
			$cektoken  = $this->db->query("SELECT * FROM tbtoken a join tbapikey b ON a.id = b.id WHERE b.Username = '$username' AND a.token = '$token' AND a.expire >= CURRENT_TIMESTAMP() ");
			if($cektoken->num_rows() > 0){
				$dttoken = $cektoken->row();
				$kodepuskesmas = $dttoken->KodePuskesmas;
				$reqbdy = file_get_contents("php://input");
            	$datapost = json_decode($reqbdy,true);
            	$faktur = $datapost['faktur'];
            	$kodebarang = $datapost['kodebarang'];
            	$nobatch = $datapost['nobatch'];
     

            	if($faktur == '' || $kodebarang == '' || $nobatch == ''){
            		$resp['metadata']['message'] = 'Form Tidak Boleh Kosong '.$faktur." | ".$kodebarang." | ".$nobatch;
					$resp['metadata']['code'] = '201';
					echo json_encode($resp);
					die();
            	}
            

            	$list = $this->db->query("SELECT * FROM tbgfkpengeluarandetail WHERE `NoFaktur`='$faktur' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'");

                if($list->num_rows() > 0){
                    $dtdet = $list->row();
                    $id = $dtdet->Id;
                                 
                    $strstsgfk = "UPDATE `tbgfkpengeluarandetail` SET StatusValidasi = 'Sudah' WHERE `Id`='$id'";
                    $this->db->query($strstsgfk);

                    $resp['metadata']['message'] = 'Update Status Berhasil';
                    $resp['metadata']['code'] = 200;
                }else{
                    $resp['metadata']['message'] = 'Tidak ada data';
                    $resp['metadata']['code'] = 204;
                }
                

			}else{
				$resp['metadata']['message'] = 'Token Expired';
				$resp['metadata']['code'] = '201';
			}
		}else{
			$resp['metadata']['message'] = 'Username atau token harus diisi '.$username.": ".$token;
			$resp['metadata']['code'] = '201';
		}
		echo json_encode($resp);
	}

}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_default extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Generic save function with table name validation
     * @param string $tabel
     * @param array $data
     * @return bool
     */
    function simpan($tabel, $data) {
        // Validate table name to prevent SQL injection
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $tabel)) {
            log_message('error', 'Invalid table name: ' . $tabel);
            return false;
        }
        return $this->db->insert($tabel, $data);
    }

    /**
     * Login pegawai with prepared statements
     * @param string $username
     * @param string $pass
     * @return bool
     */
    function login_pegawai($username, $pass) {
        // Use Query Builder with parameter binding
        $this->db->select('*');
        $this->db->from('tbapikey');
        $this->db->where('Username', $username);
        $this->db->where('Approve', 'Y');
        
        $cek = $this->db->get();
        
        if ($cek->num_rows() > 0) {
            $datauser = $cek->row();
            
            // Verify password properly - check bcrypt, md5, or plain
            $password_valid = false;
            if (password_verify($pass, $datauser->Password)) {
                $password_valid = true;
            } elseif (md5($pass) === $datauser->Password) {
                $password_valid = true;
            } elseif ($pass === $datauser->Password) {
                $password_valid = true;
            }
            
            if (!$password_valid) {
                return false;
            }
            
            // Set session
            $this->load->library('session');
            $this->session->set_userdata("username", $datauser->Username);
            $this->session->set_userdata("key", $datauser->keys);
            $this->session->set_userdata("approve", $datauser->Approve);
            $this->session->set_userdata("level", $datauser->level);
            
            // Don't store password in session
            return true;
        }
        return false;
    }

    /**
     * Check login status
     */
    function ceklogin() {
        $this->load->library('session');
        if ($this->session->userdata("username") == null) {
            redirect('login');
        }
    }

    /**
     * Get data from Dukcapil API
     * @param string $key (NIK)
     * @return string JSON response
     */
    function getDataCasip($key) {
        // Validate NIK format (16 digits)
        if (!preg_match('/^\d{16}$/', $key)) {
            return json_encode(['error' => 'Invalid NIK format']);
        }

        // Load from environment
        $userid = getEnv('DUKCAPIL_USER_ID', '');
        $password = getEnv('DUKCAPIL_PASSWORD', '');
        $ip = getEnv('DUKCAPIL_IP', '');
        $url = getEnv('DUKCAPIL_BASE_URL', '');

        if (empty($url)) {
            log_message('error', 'Dukcapil API URL not configured');
            return json_encode(['error' => 'API not configured']);
        }

        $data = array(
            "nik" => $key,
            "user_id" => $userid,
            "password" => $password,
            "ip_user" => $ip
        );
        $data_string = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        $error = curl_error($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($error || $http_code !== 200) {
            log_message('error', 'Dukcapil API Error: ' . $error);
            return json_encode(['error' => 'API request failed']);
        }

        return $result;
    }

    /**
     * Get data from BPJS API
     * @param string $key (Nomor Kartu)
     * @param string $kode (Kode Puskesmas)
     * @return string JSON response
     */
    function getDataBpjs($key, $kode) {
        // Validate nomor kartu (13 digits)
        if (!preg_match('/^\d{13}$/', $key)) {
            return json_encode(['metaData' => ['code' => '400', 'message' => 'Invalid card number format']]);
        }

        // Use prepared statement
        $this->db->select('KodePuskesmas, Username, Password, ConsId, SecretKey');
        $this->db->from('tbpuskesmasdetail');
        $this->db->where('KodePuskesmas', $kode);
        $dtpuskesmas = $this->db->get()->row();

        if (!$dtpuskesmas) {
            return json_encode(['metaData' => ['code' => '404', 'message' => 'Puskesmas not found']]);
        }

        $username = $dtpuskesmas->Username;
        $password = $dtpuskesmas->Password;
        $consId = $dtpuskesmas->ConsId;
        $secretKey = $dtpuskesmas->SecretKey;

        $baseUrl = getEnv('BPJS_BASE_URL', 'https://apijkn.bpjs-kesehatan.go.id/pcare-rest');
        $url = $baseUrl . "/peserta/" . $key;

        date_default_timezone_set('UTC');
        $tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $signature = hash_hmac('sha256', $consId . "&" . $tStamp, $secretKey, true);
        $encodedSignature = base64_encode($signature);
        $kdAplikasi = "095";
        $autorized = base64_encode($username . ":" . $password . ":" . $kdAplikasi);

        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_USERAGENT => "pkm",
            CURLOPT_AUTOREFERER => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_POST => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_VERBOSE => 1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "X-cons-id: " . $consId,
                "X-timestamp: " . $tStamp,
                "X-signature: " . $encodedSignature,
                "X-Authorization: Basic " . $autorized
            ),
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);

        if ($err || $header['http_code'] !== 200) {
            log_message('error', 'BPJS API Error: ' . $errmsg);
            return json_encode(['metaData' => ['code' => '500', 'message' => 'API request failed']]);
        }

        $res = json_decode($content, true);

        if (!isset($res['response']) || !isset($res['metaData'])) {
            return json_encode(['metaData' => ['code' => '500', 'message' => 'Invalid response format']]);
        }

        $key = $consId . $secretKey . $tStamp;
        $string = $res['response'];
        $des = stringDecrypt($key, $string);
        $dec = decompress($des);
        $resp['response'] = json_decode($dec);
        $resp['metaData'] = $res['metaData'];
        $x = json_encode($resp);

        return $x;
    }
}


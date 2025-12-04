<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_key_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get API key by key value
     * @param string $key
     * @return object|null
     */
    public function getByKey($key) {
        return $this->db->where('keys', $key)
                       ->where('Approve', 'Y')
                       ->get('tbapikey')
                       ->row();
    }

    /**
     * Get API key by username and password
     * @param string $username
     * @param string $password
     * @return object|null
     */
    public function getByCredentials($username, $password) {
        // Check both hashed and plain password for backward compatibility
        $this->db->where('Username', $username)
                 ->where('Approve', 'Y')
                 ->group_start()
                    ->where('Password', $password)
                    ->or_where('Password', password_hash($password, PASSWORD_BCRYPT))
                 ->group_end();
        
        return $this->db->get('tbapikey')->row();
    }

    /**
     * Verify password
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function verifyPassword($password, $hash) {
        // Check if it's a bcrypt hash
        if (password_verify($password, $hash)) {
            return true;
        }
        // Backward compatibility with MD5
        if (md5($password) === $hash) {
            return true;
        }
        // Plain text comparison (for migration)
        if ($password === $hash) {
            return true;
        }
        return false;
    }

    /**
     * Create new API key
     * @param array $data
     * @return int|bool
     */
    public function create($data) {
        // Hash password if provided
        if (isset($data['Password'])) {
            $data['Password'] = password_hash($data['Password'], PASSWORD_BCRYPT);
        }
        
        // Generate API key if not provided
        if (!isset($data['keys']) || empty($data['keys'])) {
            $data['keys'] = $this->generateApiKey();
        }
        
        return $this->db->insert('tbapikey', $data) ? $this->db->insert_id() : false;
    }

    /**
     * Generate secure API key
     * @param int $length
     * @return string
     */
    private function generateApiKey($length = 40) {
        return bin2hex(random_bytes($length / 2));
    }

    /**
     * Update API key
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data) {
        if (isset($data['Password'])) {
            $data['Password'] = password_hash($data['Password'], PASSWORD_BCRYPT);
        }
        return $this->db->where('id', $id)->update('tbapikey', $data);
    }
}


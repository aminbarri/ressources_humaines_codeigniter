<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilisateur_model extends CI_Model {

    // Table name
    private $table = 'utilisateur';

    // Insert a new utilisateure
    public function insert_utilisateur($data) {
        return $this->db->insert($this->table, $data);
    }

    // Fetch all utilisateures
    public function get_all_utilisateurs() {
        $query = $this->db->get($this->table);
        return $query->result();
    }
    public function save_session($user_id, $token, $expiration) {
        $data = [
            'user_id' => $user_id,
            'token' => $token,
            'expiration' => $expiration,
        ];
        $this->db->insert('sessions', $data);
    }
    public function get_session_by_token($token) {
        $this->db->where('token', $token);
        return $this->db->get('sessions')->row();
    }
    public function get_utilisateur_by_login($login) {
        $this->db->select('*');
        $this->db->from('utilisateur'); 
        $this->db->where('login', $login);
        $query = $this->db->get();
        return $query->row(); 
    }
    // Fetch an utilisateure by ID
    public function get_utilisateur_by_id($id) {
        $query = $this->db->get_where($this->table, ['id' => $id]);
        return $query->row();
    }
    public function get_utilisateur_by_info($data){
        $role = 0;
        if($data == 'user' || $data == 'User') {
            $role = 2;
        }
        if($data == 'admin' || $data == 'Admin') {
            $role = 1;
        }
      
        $this->db->select('*'); 
        $this->db->from('utilisateur');
        $this->db->like('nom', $data);
        $this->db->or_like('prenom', $data); 
        $this->db->or_where('login', $data);
        $this->db->or_where('role', $role);

        
        $query = $this->db->get(); 
        return $query->result();

    }

    public function update_utilisateur($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    // Delete an utilisateure by ID
    public function delete_utilisateur($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employe_model extends CI_Model {

    // Table name
    private $table = 'employe';

    // Insert a new employee
    public function insert_employe($data) {
        return $this->db->insert($this->table, $data);
    }

    // Fetch all employees
    public function get_all_employes() {
        $query = $this->db->get($this->table);
        return $query->result();
    }

    // Fetch an employee by ID
    public function get_employe_by_id($id) {
        $query = $this->db->get_where($this->table, ['id' => $id]);
        return $query->row();
    }
    public function get_employe_by_info($data){
        $this->db->select('*'); 
        $this->db->from('employe');
        $this->db->like('nom', $data);
        $this->db->or_like('prenom', $data); 
        $this->db->or_where('mail', $data);
        $this->db->or_where('adresse', $data); 
        $this->db->or_where('telephone', $data); 
        $this->db->or_where('poste', $data); 
        
        $query = $this->db->get(); 
        return $query->result();

    }

    public function update_employe($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    // Delete an employee by ID
    public function delete_employe($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}

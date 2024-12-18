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

    // Update an employee's data
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

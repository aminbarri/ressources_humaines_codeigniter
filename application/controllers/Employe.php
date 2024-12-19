<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Employe extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('Employe_model');
    }

    
    public function index(){
       
        $this->load->view('listEmploye');
    }
    public function getEmploye() {
        $searchData = $this->input->get('searchData'); 
        $employees = $this->Employe_model->get_employe_by_info($searchData);
        if (empty($employees)) {
            echo json_encode(['message' => 'No data found']);
        } else {
            
            echo json_encode($employees);
        }
    }
    public function dataempl(){
        $data= $this->Employe_model->get_all_employes();
        echo json_encode($data);
    }
    public function store(){
        $this->load->view('ajouterEmploye');
    }
    public function create(){
       
        $data = [
            'nom'       => $this->input->post('nom'),
            'prenom'    => $this->input->post('prenom'),
            'mail'      => $this->input->post('email'),
            'adresse'   => $this->input->post('address'),
            'telephone' => $this->input->post('telephone'),
            'poste'     => $this->input->post('poste')
        ];

        // Insert data into the database
        $this->Employe_model->insert_employe($data);

    }
    public function delete(){
        header('Content-Type: application/json'); 
         $id = $this->input->post('id'); 
        if ($id) {
        $this->Employe_model->delete_employe($id); 
        echo json_encode(['status' => 'success', 'message' => 'Employee archived successfully']);
        } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID provided']);
            }}

}
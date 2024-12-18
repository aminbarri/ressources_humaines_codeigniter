<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Employe extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('Employe_model');
    }

    
    public function index(){
        $data['employes'] = $this->Employe_model->get_all_employes();
         
        $this->load->view('listEmploye', $data);
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
}
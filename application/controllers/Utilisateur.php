<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilisateur extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('Utilisateur_model');
    }

    
    public function index(){
       
        $this->load->view('listutilisateur');
    }

    public function getutilisateurbyid() {
        header('Content-Type: application/json');
    
        $id = $this->input->get('id'); // Get the 'id' parameter from the GET request
    
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID is required.']);
            return;
        }
    
        $utilisateure = $this->Utilisateur_model->get_utilisateur_by_id($id);
        
        if ($utilisateure) {
            echo json_encode($utilisateure);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'utilisateure not found.']);
        }
    }
    
    public function getutilisateur() {
        $searchData = $this->input->get('searchData'); 
        $utilisateures = $this->Utilisateur_model->get_utilisateur_by_info($searchData);
        if (empty($utilisateures)) {
            echo json_encode(['message' => 'No data found']);
        } else {
            
            echo json_encode($utilisateures);
        }
    }
    public function dataempl(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    
        $data= $this->Utilisateur_model->get_all_utilisateurs();
        echo json_encode(value: $data);
    }
    public function store(){
        $this->load->view('ajouterutilisateur');
    }
    public function create()
    {
       
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
            header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
            exit(); 
        }
    
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    
        
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true); 
       
        if ($data) {
            $existingUser = $this->Utilisateur_model->get_utilisateur_by_login($data['login'] ?? '');

        if ($existingUser) {
            
            echo json_encode(['status' => 'error', 'message' => 'Le login existe déjà. Veuillez en choisir un autre.']);
            return;
        }
            $insertData = [
                'nom'       => $data['nom'] ?? null,
                'prenom'    => $data['prenom'] ?? null,
                'login'      => $data['login'] ?? null,
                'mot_de_passe'   => $data['mot_de_passe'] ?? null,
                'role' => $data['role'] ?? null,
            ];
    
            $this->Utilisateur_model->insert_utilisateur($insertData);
            echo json_encode(['message' => 'Employé créé avec succès !']);
        } else {
            http_response_code(400); 
            echo json_encode(['error' => 'Invalid or missing JSON payload']);
        }
    }
    public function edit(){
        $inputData = json_decode(file_get_contents('php://input'), true);

        if (!$inputData) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input.']);
            return;
        }
    
        $id = ($inputData['id']);
       
        $data = [];
        if (!empty($inputData['nom'])) {
            $data['nom'] = $inputData['nom'];
        }
        if (!empty($inputData['prenom'])) {
            $data['prenom'] = $inputData['prenom'];
        }
        if (!empty($inputData['login'])) {
            $data['login'] = $inputData['login'];
        }
        if (!empty($inputData['mot_de_passe'])) {
            $data['mot_de_passe'] = $inputData['mot_de_passe'];
        }
        if (!empty($inputData['role'])) {
            $data['role'] = $inputData['role'];
        }
    
        $updateStatus = $this->Utilisateur_model->update_utilisateur($id, $data);
        if ($updateStatus) {
            echo json_encode(['status' => 'success', 'message' =>'utilisateur mis à jour avec succès'  ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Échec de la mise à jour de lutilisateur.']);
        }
    }
    
    public function delete(){
        header('Content-Type: application/json'); 
         $id = $this->input->post('id'); 
        if ($id) {
        $this->Utilisateur_model->delete_utilisateur($id); 
        echo json_encode(['status' => 'success', 'message' => 'utilisateur archived successfully']);
        } else {
        echo json_encode(['status' => 'error', 'message' => 'ID non valide fourni']);
            }}

}
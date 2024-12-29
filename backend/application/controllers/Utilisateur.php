<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilisateur extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('Utilisateur_model');
      
    }

    
   

    public function getutilisateurbyid() {
        header('Content-Type: application/json');
    
        $id = $this->input->get('id'); 
    
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
        
        $data= $this->Utilisateur_model->get_all_utilisateurs();
        echo json_encode(value: $data);
    }
    
    public function create()
    {
        check_role(requiredRole: '1');

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
        $hashedPassword = password_hash($data['mot_de_passe'], PASSWORD_BCRYPT);

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
                'mot_de_passe'   => $hashedPassword ?? null,
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
        check_role(requiredRole: '1');
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
        if (empty($data)) {
            echo json_encode(['status' => 'empty', 'message' => 'Rien à mettre à jour']);
            return;
        }
        
        
        $updateStatus = $this->Utilisateur_model->update_utilisateur($id, $data);
        
        if ($updateStatus) {
            echo json_encode(['status' => 'success', 'message' => 'Utilisateur mis à jour avec succès']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Échec de la mise à jour de l\'utilisateur.']);
        }
    }
    
    public function delete(){
        check_role(requiredRole: '1');
        header('Content-Type: application/json'); 
         $id = $this->input->post('id'); 
        if ($id) {
        $this->Utilisateur_model->delete_utilisateur($id); 
        echo json_encode(['status' => 'success', 'message' => 'utilisateur archived successfully']);
        } else {
        echo json_encode(['status' => 'error', 'message' => 'ID non valide fourni']);
            }}

}
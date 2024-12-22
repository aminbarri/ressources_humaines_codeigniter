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

    public function getEmployebyid() {
        header('Content-Type: application/json');
    
        $id = $this->input->get('id'); // Get the 'id' parameter from the GET request
    
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID is required.']);
            return;
        }
    
        $employee = $this->Employe_model->get_employe_by_id($id);
    
        if ($employee) {
            echo json_encode($employee);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Employee not found.']);
        }
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
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    
        $data= $this->Employe_model->get_all_employes();
        echo json_encode($data);
    }
    public function store(){
        $this->load->view('ajouterEmploye');
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
    
        if ($data) {
            $insertData = [
                'nom'       => $data['nom'] ?? null,
                'prenom'    => $data['prenom'] ?? null,
                'mail'      => $data['mail'] ?? null,
                'adresse'   => $data['adresse'] ?? null,
                'telephone' => $data['telephone'] ?? null,
                'poste'     => $data['poste'] ?? null,
            ];
            $this->db->where('mail', $insertData['mail']);
            $this->db->or_where('telephone', $insertData['telephone']);
            $existingUser = $this->db->get('employe')->row();
            
            if ($existingUser) {
                if ($existingUser->mail === $insertData['mail']) {
                    echo json_encode(['status' => 'error', 'message' => 'L\'email existe déjà. Veuillez en choisir un autre.']);
                } elseif ($existingUser->telephone === $insertData['telephone']) {
                    echo json_encode(['status' => 'error', 'message' => 'Le numéro de téléphone existe déjà. Veuillez en choisir un autre.']);
                }
                return;
            }
            $this->Employe_model->insert_employe($insertData);
            echo json_encode(['status' => 'success','message' => 'Employé créé avec succès !']);
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
        if (!empty($inputData['mail'])) {
            $data['mail'] = $inputData['mail'];
        }
        if (!empty($inputData['adresse'])) {
            $data['adresse'] = $inputData['adresse'];
        }
        if (!empty($inputData['telephone'])) {
            $data['telephone'] = $inputData['telephone'];
        }
        if (!empty($inputData['poste'])) {
            $data['poste'] = $inputData['poste'];
        }
    
        $updateStatus = $this->Employe_model->update_employe($id, $data);
        if ($updateStatus) {
            echo json_encode(['status' => 'success', 'message' =>$id, $data  ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update employee.']);
        }
    }
    
    public function delete(){
        check_role(requiredRole: '1');
        header('Content-Type: application/json'); 
         $id = $this->input->post('id'); 
        if ($id) {
        $this->Employe_model->delete_employe($id); 
        echo json_encode(['status' => 'success', 'message' => 'Employee archived successfully']);
        } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID provided']);
            }}

}
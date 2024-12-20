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
        // Handle preflight (OPTIONS) request
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
            header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
            exit();  // Stop further execution for preflight
        }
    
        // Set CORS headers for POST request
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    
        // Your actual POST request handling code
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true); // Decode JSON payload into an associative array
    
        if ($data) {
            $insertData = [
                'nom'       => $data['nom'] ?? null,
                'prenom'    => $data['prenom'] ?? null,
                'mail'      => $data['mail'] ?? null,
                'adresse'   => $data['adresse'] ?? null,
                'telephone' => $data['telephone'] ?? null,
                'poste'     => $data['poste'] ?? null,
            ];
    
            $this->Employe_model->insert_employe($insertData);
            echo json_encode(['message' => 'Employé créé avec succès !']);
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Invalid or missing JSON payload']);
        }
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
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller{

  
  public function __construct() {
    parent::__construct();
    $this->load->model('Utilisateur_model');
    $this->load->library('session');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    header('Content-Type: application/json');

}
  
  public function login(){
    
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true); 
        $hashedPasswordFromFrontend = $data['mot_de_passe'];
        if (isset($data['login']) && isset($data['mot_de_passe'])) {
          if ($data) {
              $existingUser = $this->Utilisateur_model->get_utilisateur_by_login($data['login'] ?? '');
          }
      
          if ($existingUser) {
      
              if (password_verify($data['mot_de_passe'], $existingUser->mot_de_passe)) {
                $token = bin2hex(random_bytes(32)); 
                $expiration = date('Y-m-d H:i:s', strtotime('+1 hour')); 

                $this->Utilisateur_model->save_session($existingUser->id, $token, $expiration);

      
                 
                  $this->session->set_userdata('authToken', $token);
                  $this->session->set_userdata('user_id', $existingUser->id); 
                  $this->session->set_userdata('nom', $existingUser->nom);
                  $this->session->set_userdata('prenom', $existingUser->prenom);
                  $this->session->set_userdata('role', $existingUser->role);
                  header('Content-Type: application/json');
                  echo json_encode([
                      'status' => 'success',
                      'message' => 'Login successful.',
                      'token' => $token,
                      'user' => [
                         'nom' => $existingUser->nom,
                          'prenom' => $existingUser->prenom,
                          'role' => $existingUser->role,
                      ]
                  ]);
                  exit;
              } else {
                  echo json_encode(['status' => 'error', 'message' => 'Mot de passe incorrect.']);
                  return;
              }
          } else {
              echo json_encode(['status' => 'error', 'message' => 'Utilisateur introuvable.']);
              return;
          }
      }
      
      echo json_encode(['status' => 'error', 'message' => 'Données invalides.']);
      
       
      }
      public function verify_token() {
    
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true);
    
        $token = $data['token'] ?? '';
    
        if ($token) {
            $session = $this->Utilisateur_model->get_session_by_token($token);
    
            if ($session && strtotime($session->expiration) > time()) {
                echo json_encode(['status' => 'success', 'message' => 'Le jeton est valide.']);
                return;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Le jeton nest pas valide ou a expiré.']);
                return;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Aucun jeton fourni.']);
            return;
        }
    }
    
    public function logout()
    {
        
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true);
    
        if (isset($data['token'])) {
            $token = $data['token'];
    
            $this->db->where('token', $token);
            $deleted = $this->db->delete('sessions'); 
            if ($deleted) {
                $this->session->sess_destroy(); 
                echo json_encode(['status' => 'success', 'message' => 'Déconnecté et jeton supprimé avec succès.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Jeton non trouvé ou déjà invalidé.']);
            }
            return;
        }
    
        echo json_encode(['status' => 'error', 'message' => 'Jeton non fourni.']);
    }
    

}


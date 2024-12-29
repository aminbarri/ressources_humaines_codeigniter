<?php
function check_role($requiredRole) {
    $CI = &get_instance();
    $CI->load->library('session');
    $CI->load->database(); 

    $userId = $CI->session->userdata('user_id'); 

    if (!$userId) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized. Please log in.']);
        http_response_code(401); 
        exit;
    }

    
    $query = $CI->db->get_where('utilisateur', ['id' => $userId]);
    $user = $query->row();

    if (!$user || $user->role !== $requiredRole) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Access denied. Admins only.']);
        http_response_code(403);
        exit;
    }
}

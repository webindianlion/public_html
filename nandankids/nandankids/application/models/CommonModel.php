<?php

	if (!defined('BASEPATH'))
	exit('No direct script access allowed');


class CommonModel extends CI_Model {	
	
	public function get_user_dtls_by_email($email_id = '', $password = '') {
        if (!empty($email_id) && empty($password)) {
            $this->db->where('email_id', $email_id);
            $this->db->where('status', 1);
            $this->db->where('is_deleted', 0);
            //$this->db->where('password', '');
            $response = $this->db->get('user');
            return $response->num_rows();
        } else {
            return 0;
        }
    }	
    
    public function get_user_dtls_using_email($email_id = '') {
        if (!empty($email_id)) {
            $this->db->select('user_id,email_id,attempts,attempt_time');
            $this->db->where('email_id', $email_id);
            $this->db->where('status', 1);
            $this->db->where('is_deleted', 0);
            $response = $this->db->get('user');
            return $response->row();
        } else {
            return 0;
        }
    }
	
	public function validate_logged_in_user_session($email_id, $sess_id ) {
		
        if (!empty($email_id) && !empty($sess_id)) {
			$this->db->select('user_id,session_id'); 
            $this->db->where('user_data', $email_id);
			$this->db->where('session_id', $sess_id);
            $response = $this->db->get('maintain_users_session');
			$cnt = $response->num_rows();
			if($cnt>0){
				return 1;
			}else{
				return 0;
			}
        }
    }
	
	public function get_users_role(){
		
		$this->db->select('user_id,email_id,role_name');
		$this->db->where('email_id', $this->session->userdata('user_email_id'));
		$this->db->where('status', 1);
		$this->db->where('is_deleted', 0);
		$response = $this->db->get('user');
		return $response->row();
		 
	}
	
}

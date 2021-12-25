<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Post extends CI_Model {
    /*
     * Author:  Roop Kishor Mishra
     * Desc:    Get rows from the posts table
     */
	 
	 function __construct() {	
        parent::__construct();	
			$this->load->library('EncryptDecrypt');	
	}

    function getRows($params = array()) {
        //get latest published post id.
        $l_post_id = '';
        $lastest_post = $this->getRows_latest_post_dtls();
        if (!empty($lastest_post->post_id)) {
            $l_post_id = $lastest_post->post_id;
        }
        $this->db->select('*');
        $this->db->from('postings_details');
        $this->db->where('post_id!=', $l_post_id);
        $this->db->where('IsPublished', 1);
        $this->db->where('IsDeleted', 0);
        //filter data by searched keywords
        if (!empty($params['search']['keywords'])) {
            $this->db->like('post_title', $params['search']['keywords']);
        }
        //sort data by ascending or desceding order
        if (!empty($params['search']['sortBy'])) {
//            $this->db->order_by('post_description', $params['search']['sortBy']);
             $this->db->order_by('post_id', 'desc');
        } else {
            $this->db->order_by('post_id', 'desc');
        }
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    function getRows_onepost() {
        $this->db->select('post_id,post_title,post_description,post_image,publish_date');
        $this->db->where('IsPublished', 1);
        $this->db->where('IsDeleted', 0);
        $this->db->order_by('post_id', 'DESC');
        $this->db->limit(1, 0);
        $response = $this->db->get('postings_details');
        return $response->row();
    }

    function getRows_latest_post_dtls() {
        $this->db->select('post_id,post_title');
        $this->db->order_by('post_id', 'DESC');
        $this->db->where('IsPublished', 1);
        $this->db->where('IsDeleted', 0);
        $this->db->limit(1, 0);
        $response = $this->db->get('postings_details');
        return $response->row();
    }

    function getRows_heading_scroll() {
        $this->db->select('post_id,post_title');
        $this->db->order_by('post_id', 'DESC');
        $this->db->where('IsPublished', 1);
        $this->db->where('IsDeleted', 0);
        $this->db->where('headline_enabled', 1);
        $response = $this->db->get('postings_details');
        return $response->result_array();
    }

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
    /**
			 *  Author     : santhosh yelagandula
			 *  Description: get login user details
			 */
    public function get_user_details_by_email($email_id = '') {
        if (!empty($email_id) ) {
            $this->db->where('email_id', $email_id);
            $this->db->where('status', 1);
            $this->db->where('is_deleted', 0);
            //$this->db->where('password', '');
            $response = $this->db->get('user');
            return $response->result();
        } else {
            return 0;
        }
    }

    /**
			 *  Author     : santhosh yelagandula
			 *  Description: get login user where deactive users details
			 */
    public function get_user_dtls_by_email_re($email_id = '') {
        if (!empty($email_id) ) {
            $this->db->where('email_id', $email_id);
            $this->db->where('status', 0);
            $this->db->where('is_deleted', 0);
            //$this->db->where('password', '');
            $response = $this->db->get('user');
            return $response->result();
        } else {
            return 0;
        }
    }

    public function get_user_dtls_by_email_no_password($email_id = '', $password = '') {
        if (!empty($email_id) && empty($password)) {
            $this->db->where('email_id', $email_id);
            $this->db->where('status', 1);
            $this->db->where('is_deleted', 0);
            $this->db->where('password', '');
            $response = $this->db->get('user');
            return $response->num_rows();
        } else {
            return 0;
        }
    }
	
	/*
		name: get_users_password($email_id = '')
		Desc: Get Users Details.
	*/
	public function get_users_password($email_id = '') {
		
        if (!empty($email_id)) {
			$this->db->select('user_id,email_id,password');
            $this->db->where('email_id', $email_id);
            $response = $this->db->get('user');
            return $response->row();
        } else {
            return 0;
        }
    }
	
	/*
		name: get_user_dtls_by_email_and_password($email_id = '', $password = '')
		Desc: validate users enc password
	*/
	
	public function get_user_dtls_by_email_and_password($email_id = '', $password = '') {
				
        if (!empty($email_id) && !empty($password) && $password != 'undefined') {
			
			$usr_dtl = $this->get_users_password($email_id);
			if($this->encryptdecrypt->decryptPassword($usr_dtl->password) == $password){
				
				$this->db->where('email_id', $email_id);
				//$this->db->where('password', $password);
				$this->db->where('status', 1);
				$this->db->where('is_deleted', 0);
				$response = $this->db->get('user');
				return $response->num_rows();
			}else{
				return 0;
			}
            
        } else {
            return 0;
        }
    }

    /*public function get_user_dtls_by_email_and_password($email_id = '', $password = '') {
        if (!empty($email_id) && !empty($password) && $password != 'undefined') {
            $this->db->where('email_id', $email_id);
            $this->db->where('password', $password);
            $this->db->where('status', 1);
            $this->db->where('is_deleted', 0);
            $response = $this->db->get('user');
            return $response->num_rows();
        } else {
            return 0;
        }
    }*/

    public function get_post_details_by_id($post_id = '') {
        if (!empty($post_id)) {
            $this->db->where('post_id', $post_id);
            $response = $this->db->get('postings_details');
            return $response->row();
        } else {
            return 0;
        }
    }

    public function get_user_dtls_using_email($email_id = '') {
        if (!empty($email_id)) {
            $this->db->select('user_id,email_id,role_name,first_name,attempts,attempt_time, otp_users, otp_time, ,attempt_otp_time');
            $this->db->where('email_id', $email_id);
            $this->db->where('status', 1);
            $this->db->where('is_deleted', 0);
            $response = $this->db->get('user');
            return $response->row();
        } else {
            return 0;
        }
    }

    /**
     * @Auther:Roop
     * function Updating users login attempts.	 
     * @return array
     */
    public function update_login_attempts($update_data, $id) {
        $this->db->where('user_id', $id);
        $query = $this->db->update('user', $update_data);
        return $query;
    }
	
	/**
		* @Author: Roop
		* function Validate concurrent user login.
		* @return array.
    */	
	public function validate_concurrent_user($userId, $sessionId, $userEmail){
			
		//get previous mapped session ID.
		$this->db->select('user_id, session_id'); 
		$this->db->where('user_data', $userEmail);
		$this->db->where('user_id', $userId);
		$response = $this->db->get('maintain_users_session');
		
		if ($response->num_rows() > 0) {
			
			//updating current Session Logged In User now.
				/*	$this->db->where('user_id', $userId);
					$post_data = array('session_id'=> $sessionId);
					$query = $this->db->update('maintain_users_session', $post_data);
				*/
			
			return 1;
			
		}else{
			
			$post_data = array('session_id'=> $sessionId,'user_id'=> $userId, 'user_data' => $userEmail);
			$this->db->insert('maintain_users_session', $post_data);
			return 2;		
		}
	}
	
	public function update_ci_session($userId, $sessionId, $userEmail) {
		
		//updating current Session Logged In User now.
		$this->db->where('user_id', $userId);
		$post_data = array('session_id'=> $sessionId);
		$query = $this->db->update('maintain_users_session', $post_data);
	}
	
	
	public function validate_logged_in_user_session($email_id = '', $sess_id ) {
		
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
    
	public function delete_user_session($email){
		
		$this -> db -> where('user_data', $email);
		$this -> db -> delete('maintain_users_session');
	}
	
	public function add_user($create_data) {
        $this->db->insert('user', $create_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
	
	/*
		Function:  add_users_request($create_data):
		Desc    :  handle requests, add request.
	*/
	
	public function add_user_request($create_data) {
        $this->db->insert('users_request', $create_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
	
	/*
		Function:  add_users_reset_password($create_data, $email_id):
		Desc    :  handle requests is it Updated or Added.
	*/
	public function add_users_reset_password($create_data, $email_id) {
		
		if(!empty($email_id)){
			//check is given email have any record in the table...
			$this->db->select('ID,email,access_count'); 
            $this->db->where('email', $email_id);
            $response = $this->db->get('password_reset_temp');
			//$reset_usr_data = $response->row();
			$cnt = $response->num_rows();
			
			if($cnt>0){
				
				//query to update record
				/* $update_data = array('access_count' => $reset_usr_data->access_count+1);
				   $query = $this->db->update('password_reset_temp', $post_data);
				*/
				
				$this->db->where('email', $email_id);
				$this->db->delete('password_reset_temp');
				
				//first deleting record and adding record.
				$this->db->insert('password_reset_temp', $create_data);
				$insert_id = $this->db->insert_id();
				return $insert_id;				
				
			}else{
				$this->db->insert('password_reset_temp', $create_data);
				$insert_id = $this->db->insert_id();
				return $insert_id;
			}
		}else{
			return 0;	
		}        
    }
	
	/**
		 * @Auther:Roop
		 * function update_users_reset_password	 
		 * @return array
     */
    public function update_users_reset_password($update_data, $token) {
		
        $this->db->where('token', $token);
        $query = $this->db->update('password_reset_temp', $update_data);
        return $query;
    }	
	
	public function get_user_reset_password_dtls($token = '') {
        if (!empty($token)) {
            $this->db->select('ID,email,access_count,token,expires,expDate');
            $this->db->where('token', $token);
            $response = $this->db->get('password_reset_temp');
            return $response->row();
        } else {
            return 0;
        }
    }
	
	/**
		 * @Auther:Roop
		 * function update_users_password	 
		 * @return array
     */
    public function update_users_password($update_data, $email) {
		
		if(!empty($email)){
			
			$this->db->where('email_id', $email);
			$query = $this->db->update('user', $update_data);
			
			//after reset users password, delete rest_temp_users_dtl.
			$this -> db -> where('email', $email);
			$this -> db -> delete('password_reset_temp');
				
			return $query;
		}else{
			return 0;
		}
    }
	
	/**
     * @Auther:Roop
     * function Updating users details 
     * @return array
     */
    public function update_user_dtls($update_data, $email) {
        $this->db->where('email_id', $email);
        $query = $this->db->update('user', $update_data);
        return $query;
    }
}

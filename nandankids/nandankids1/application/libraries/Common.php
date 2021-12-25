<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**

	*   Author: Roop Kishor Mishra.
	*   Description: This class is used for those functions which are most commonly used with in our application.

*/

class Common 
{
	
	var $ci = '';
	public function __construct()
	{
		// Instantiate the class
		$this->ci =& get_instance();
		$this->ci->load->model("CommonModel");
	}
		
	/* 
		* Name:  login_user_dtls()  
		* Desc:  Getting logn user details as per login email ids.
	*/
	
	public function login_user_dtls($emailId){
		
		//get valid email user details.
		$rows = $this->ci->CommonModel->get_user_dtls_using_email($emailId);
		return $rows;
	}
	
	public function is_session_authorized($email_id,$sess_id){
		
		//authorized logged in user using current session ids.
		$rows = $this->ci->CommonModel->validate_logged_in_user_session($email_id, $sess_id);
		return $rows;
	}
	public function login_member_user_roles(){
		
		//authorized logged in user using current session ids.
		$rows = $this->ci->CommonModel->get_users_role();
		return $rows;
	}
	
	/*
		Name   : check_url_access_by_browser()
		Desc   : Function is used to check is given function is accessing by browser or not.
		Author : Roop Kishor Mishra
	*/
	
	public function check_url_access_by_browser(){
		
		if(!isset($_SERVER['HTTP_REFERER'])){
			// redirect them to your desired location
			echo '<p style="width:90%; border: 1px red solid; color:black; margin-left:50px; margin-top:10px;margin-bottom:10px; margin-right:50px; padding:40px;">404 - (access not allowed).</p>';
			die();
		}else{
			return  TRUE;
		}
	}
	
	/*
		Name   : is_logged_in_user_authorized()
		Desc   : Function validates that user is authorized user or not by session value.
		Author : Roop Kishor Mishra
	*/
	
	public function is_logged_in_user_authorized(){
		
		if(empty($this->ci->session->userdata('user_email_id'))){
			
			//this condition validates user accessing is unAuthorized
			$this->ci->session->sess_destroy();
			$this->ci->load->helper('url');
			redirect(base_url('posts/index'));
		}else{
			return  TRUE;
		}
	}
	
	public function delete_user_session($email){
		
		$this->ci->db->where('user_data', $email);
		$this->ci->db->delete('maintain_users_session');
	}
	
	/**
     * @Auther :ROOP KIHOR MISHRA
     * function: generate_random_number($total_char)
	 * Param   : Integer
     * @return : String
     */
	 
    public function generate_random_number($total_char) {
		if(!empty($total_char)){
			$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
			$pass = array(); //remember to declare $pass as an array
			$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
			for ($i = 0; $i < $total_char; $i++) {
				$n = rand(0, $alphaLength);
				$pass[] = $alphabet[$n];
			}
			return implode($pass); //turn the array into a string
		}else{
			return 0;
		}
	}
    
    public function get_user_reset_password_dtls($token = '') {
		
        if (!empty($token)) {
            $this->ci->db->select('ID,email,access_count,token,expires,expDate');
            $this->ci->db->where('token', $token);
            $response = $this->ci->db->get('password_reset_temp');
            return $response->row();
        } else {
            return 0;
        }
    }
	
	/**
		 * @Auther  : ROOP
		 * function : used for get post details by using the postid
		   Desc     : Related to Email Functionality.	
		 * @return  : array
     */
	 
    public function get_post_details_by_id($post_id) {
		
        $this->ci->db->where('post_id', $post_id);
        $response = $this->ci->db->get('postings_details');
        return $response->row();
    }
	
	
	/**
		 * @Auther  : ROOP
		 * function : used for get post details by using the postid
		   Desc     : Related to Email Functionality.	
		 * @return  : array
     */
	 
    public function get_all_active_users() {
		
        $this->ci->db->where('is_deleted', 0);
		$this->ci->db->where('status', 1);
        $response = $this->ci->db->get('user');
        return $response->result();
	}
	
	public function cron($get_users,$postid,$prep_post_desc,$title){
		// Store the cipher method
        $ciphering = "AES-128-CTR";
        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
		// Non-NULL Initialization Vector for encryption
        $encryption_iv = '1234567891011121';
		// Store the encryption key
		$encryption_key = "CTP@412";
        $title=openssl_encrypt($title, $ciphering,
            $encryption_key, $options, $encryption_iv);
    $cron=array();
	$date=date('Y-m-d H:i:s');
    if(!empty($postid)){
    foreach ($get_users as $key => $value) {
            $emmailid=openssl_encrypt($value->email_id, $ciphering,
            $encryption_key, $options, $encryption_iv);
        $cron[]=array('first_name'=>$value->first_name,'email'=>$emmailid,'postid'=>$postid,'post_title'=>$title,'description'=>$prep_post_desc,'status'=>0,'Date'=>$date);
	}
//	print_r($cron);exit;
	if($cron!= array()){
    $response=$this->ci->db->insert_batch('cronpost',$cron);
	if($response>0){
    return true;
	}else{
		return false;
	}
	}else {
		return false;
	}
    }
	}
    
	
}
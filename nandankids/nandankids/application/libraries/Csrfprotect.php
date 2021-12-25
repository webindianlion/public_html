<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**

	*   Author: Roop Kishor Mishra.
	*   Description: This class is used for CSRF related Functions to prevent application from CSRF attack.
*/

class Csrfprotect 
{
	
	var $ci;
	function __construct()
	{
	$this->ci = &get_instance();
	}
	  
	protected   $_secret_key;
	
	
	/**
	 * CSRF Hash
	 *
	 * Random hash for Cross Site Request Forgery protection cookie
	 *
	 * @var	string
	 */
	 
	protected $_csrf_hash;
	
	
	/**
	 * CSRF Expire time
	 *
	 * Expiration time for Cross Site Request Forgery protection cookie.
	 * Defaults to two hours (in seconds).
	 *
	 * @var	int
	 */
	protected  $csrf_expire_token =	1000;  //25 min. time for expire of token.
		
    /* 
		* Name:  generateToken()  
		* Desc:  GENERATE THE TOKEN, also store in session also set token expire time to secure application. TIMESTAMP.
	*/
	
	public function generate_token(){
		
		//reset previous stored session tokens, before generating any new token.
		$this->reset_session_token();
		
		$length = 32;
		$this->ci->session->set_userdata('csrf_unq_token', substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length));
		
		// 1 hour = 60 seconds * 60 minutes = 3600
		$this->ci->session->set_userdata('token_expire', time() + $this->csrf_expire_token);
	}
	
	/* 
		* Name:  resetSessionToken()  
		* Desc:  Reset all session related to CSRF to manage tokens created for 
	*/
	
	public function reset_session_token(){
		
		
		// We kill this since we're done and we don't want to pollute the _POST array
		if(!empty($this->ci->session->userdata('csrf_unq_token')) && !empty($this->ci->session->userdata('token_expire'))){
			$this->ci->session->unset_userdata('csrf_unq_token');
			$this->ci->session->unset_userdata('token_expire');
		}
		
	}
	
	/* 
		* Name:  validateBothTokens(form_post_token)  
		* Desc:  Validate both tokens as (Session token & Posted token) 
	*/
	
	public function validate_both_tokens($form_post_token=''){
		
				
		// Check CSRF token validity, but don't error on mismatch just yet - we'll want to regenerate
		$valid = (!empty($form_post_token) && !empty($this->ci->session->userdata('csrf_unq_token')))
			&& hash_equals($form_post_token, $this->ci->session->userdata('csrf_unq_token'));
			
		if ($valid !== TRUE)
		{
			//$this->csrf_show_error();
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/**
	 * Show CSRF Error
	 *
	 * @return	void
	 */
	public function csrf_show_error_vrgt()
	{
		//show_error('The action you have requested is not allowed.', 403);
	}
	
	
	
	
}
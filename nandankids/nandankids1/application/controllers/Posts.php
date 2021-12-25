<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  Author     : Roop Kishor Msihra
 *  Description: Handle all post for all HTTP requests.
 */
class Posts extends CI_Controller {

    function __construct() {

        parent::__construct();

        $this->load->model('emailer_model');
        $this->load->library("PHPMailer_Library");
        $this->load->library('session');
        $this->load->model('post');
        $this->load->library('Ajax_pagination');
        $this->load->library('EncryptDecrypt');
        $this->load->library("csrfprotect");
        $this->load->library("common");
        $this->perPage = 6;
    }
	//time zone
/* 	public function getDatetimeNow() {
    $tz_object = new DateTimeZone('Asia/Kolkata');
    //date_default_timezone_set('Brazil/East');
    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);
    return $datetime->format('Y-m-d H:i:s');
} */
//end

    public function index() {
		
        $this->csrfprotect->generate_token();
        $data = array();
        //total rows count
        $totalRec = count($this->post->getRows());
        //pagination configuration
        //$After = $this->encryptdecrypt->EncryptThis($myStr);
        //$this->encryptdecrypt->DecryptThis($After);

        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'posts/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //get the posts data
        $data['posts'] = $this->post->getRows(array('limit' => $this->perPage));
		
		//will check only in case when Google Captcha is not Used in COntact Us Form.
		//if (empty($this->session->flashdata('message_s'))){
			$data['contact'] = array(
				'email' => $this->input->post('email'),
				'name' => $this->input->post('name'),
				'surname' => $this->input->post('surname'),
				'phone' => $this->input->post('phone'),
				'message' => $this->input->post('message')
			);
		//}
		
        //load the view
        $this->load->view('posts/index', $data);
    }

    /**
     * log out functionality
     * @Author: Roop Kishor Mishra
     */
    public function logout() {
		
		//validates session, is that user is valid or not.
		$this->common->is_logged_in_user_authorized();
		
        //delete user session record from table.		
        $this->post->delete_user_session($this->session->userdata('user_email_id'));
        $this->session->sess_destroy();
        $this->load->helper('url');
        redirect(base_url('posts/index'));
    }
	

    public function ajaxPaginationData() {
        $conditions = array();
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        //set conditions for search
        $keywords = $this->input->post('keywords');
        $sortBy = $this->input->post('sortBy');
        if (!empty($keywords)) {
            $conditions['search']['keywords'] = $keywords;
        }
        if (!empty($sortBy)) {
            $conditions['search']['sortBy'] = $sortBy;
        }
        //total rows count
        if (!empty($this->post->getRows($conditions))) {
            $totalRec = count($this->post->getRows($conditions));
        } else {
            $totalRec = 0;
        }
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'posts/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        //get posts data
        $data['posts'] = $this->post->getRows($conditions);
		//load the view
        $this->load->view('posts/ajax-pagination-data', $data, false);
        // Define offset 
    }


	/*
		@ Function:otp_notification_for_users($email, $otp)
		@ Sending email OTP notification for current verified users email ids.
		
	*/
	public function otp_notification_for_users($email, $otp){
		
		
		if (!empty($email) && !empty($otp)) {
			/**
			 *  Author     : santhosh yelagandula
			 *  Description: get login user details
			 */
			$userdetails = $this->post->get_user_details_by_email($email);
			if(!empty($userdetails[0]->first_name)){
            $request_msg="Hi&nbsp;&nbsp;".$userdetails[0]->first_name;
			}else{
				$request_msg="Dear User";
			}
			//$from     =  "ctp-back3nd@infosharesystems.com";
			$from     =  "vptrack@infosharesystems.com";
			$name_urs =  "" ;
			$to       = $email;
			$name     = 'Cyber Threat Post';
			$cc       = "";
			$title    = "Message";
			$subject  = "Cyber Threat Post Login -  OTP for Secure Access" ;
			
			$body = '<html><body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #F2F3F8;" leftmargin="0">    
				<table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#F2F3F8"
					style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: "Open Sans", sans-serif;">
					<tr>
						<td>
							<table style="background-color: #F2F3F8; max-width:670px;  margin:0 auto;" width="100%" border="0"
								cellpadding="0" cellspacing="0">                    
								<tr>
									<td style="height:20px;">&nbsp;</td>
								</tr>
								<tr>
									<td>
										<table width="95%" border="0" cellpadding="0" cellspacing="0"
											style="max-width:670px;background-color:#FFFFFF; border-radius:3px; text-align:left;">
											<tr>
												<td></td>
											</tr>
											<tr>
												<td style="height:40px;">&nbsp;</td>
											</tr>
											<tr>
												<td style="padding:0 35px;">
													<p style="color:#455056; font-size:15px;line-height:2; margin:0;">'.$request_msg.',</p>
													<p style="color:#455056; font-size:15px;line-height:2; margin-top:8px;"></p>
													<p style="color:#455056; font-size:15px;line-height:2; margin:0;">Greetings!</p>
													<p style="color:#455056; font-size:15px;line-height:2; margin-top:8px;"></p>
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">You are one step away from accessing your Cyber Threat Post account. </p>
													
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">
														Your OTP is: <strong>'.$otp.' </strong> 
														<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">The OTP is valid for 5 minutes and is usable only once.<br><br>
														<strong>Never disclose your confidential information such as Username, Password, OTP etc. to anyone.</strong>
													</p><p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;"></p>
												</td>
											</tr>
											
											<tr>
												<td style="padding:0 35px;">										
													<p style="color: #455056;font-size: 15px;margin: 0;margin-top: 48px;">Best Regards,</p>
													<p style="color: #455056;font-size: 15px;line-height: 1.6;margin: 0;margin-top:8px;">Team Cyber Threat Post
													</p>
												</td>
											</tr>
											<tr>
												<td style="height:40px;">&nbsp;</td>
											</tr>
										</table>
									</td>
								</tr>                    
								<tr>
									<td style="height:80px;">&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				</body></html>';
				
				
				//perform transaction as required, sending emails to all type of active users.				
				//call send email function for all TYPE of to from here......
				 $flag = $this->emailer_model->sendemail($from, $to, $cc, $title, $subject, $body, $name, $this->config->item('user'), $this->config->item('password'));
		}
	
	}
		
	/*
		* @Name    :  Track_otp_attempts()
		* @Author  :  Roop Kishor Mishra
		* @Desc    :  Track OTP attempts 
    */
	 
	public function track_otp_attempts($emailId){
		
		/*  Check number of attempts, user is having for any transaction, 
			that includes(resend_otp, entering wrong otp, trying to ) 
		*/
		
		$user_dtls     = $this->post->get_user_dtls_using_email($emailId);
		
		/* otp account locking time */
		$cur_time         = date('Y-m-d H:i:s');
		$otp_attempt_time = $user_dtls->attempt_otp_time;
		$otp_min_lock     = round(abs(strtotime($cur_time) - strtotime($otp_attempt_time)) / 60, 2) . " minute";
		$otp_min_lock     = ceil($otp_min_lock);				
		/* end of acc. locking time variable prep. */
		
		//Check number of wrong OTP attempts.
		$otp_attempt = $this->session->userdata('otp_attempt');
		$otp_attempt++;
		$this->session->set_userdata('otp_attempt', $otp_attempt);
		
		/* locking user account for 10 min. when user is entering wrong otp */
		if($otp_attempt ==5 && $otp_min_lock<10){
			
			$update_data = array('attempt_otp_time' => date('Y-m-d H:i:s'));
			$data_success = $this->post->update_login_attempts($update_data, $user_dtl->user_id);
			
			//$this->session->set_flashdata('wrong_otp', 'WRONG_PASSWORD_V==');
			$data = array('error_otp_attempts' => 'Your account has been locked for next 10 minutes as there are 5 continues failed attempts for OTP.');
		}		
		
	}
	
	public function resend_otp(){
		
		if (!empty($this->uri->segment(3))) {

			$is_user_email =  $this->post->get_user_dtls_using_email($this->uri->segment(3));
			
			
			if(!empty($is_user_email->email_id)){
								
				$this->regenerate_otp($this->uri->segment(3));
				$this->session->set_flashdata('success_forgotpassword', 'OTP has been sent successfully in your email shown in textbox, please check your email id for OTP');				
				$this->index();
				redirect(base_url() . 'posts/index');
				
			}else{
				
				//UnAuth Access URls, Show error MSG.
				echo '<div class="alert alert-danger alert_error"> 404 - (access not allowed)</div>';
				die();
			}
		}		
	}
	
	/*
		Function    : regenerate_otp($email='')
		Description : OTP Code Regeneration using random AlphaNumraic digits.
		
	*/
	
	public function regenerate_otp($email) {
		
		$otp_expire_time =	300;  //25 min. time for expire of token.
		$otp_code = $this->common->generate_random_number(6);
		$this->session->unset_userdata('users_otp');
		$this->session->unset_userdata('otp_expire');
		//$this->session->unset_userdata('user_email_id');
		$this->session->unset_userdata('users_role_name');
		$this->session->set_userdata('users_otp', $otp_code);
		$this->session->set_userdata('otp_expire', time() + $otp_expire_time);
		
		//sending OTP for current session based user on his/her email id (varified email id)
		$this->otp_notification_for_users($email, $otp_code);
		
		//TO Do: storing OTP in database table. query request.
		//query to update database table, for locking users account.						
			$update_data = array('otp_time'  =>  date('Y-m-d H:i:s'),
								 'otp_users' =>  $otp_code
								);
		$data_success = $this->post->update_user_dtls($update_data, $email);
		
	}
	
	/*
		Reset session Data From here.
	*/
	public function reset_defined_users_data(){
		
		unset($_SESSION['WRONG_OTP']);
		unset($_SESSION['success_resend_otp']);
		$this->session->unset_userdata('resend_otp_attempt');
		$this->session->unset_userdata('otp_attempt');
		$this->session->unset_userdata('attempt');
		return true;
	}
	
    public function ajaxValidateLogin() {

        //check is post is valid or not, while getting response from front end.
        if ($this->input->post('post_id') != '') {
            if (!ctype_alnum($this->input->post('post_id'))) {
                $this->session->set_flashdata('invalid_post_error', '404 access not allowed ! <br /> accessing post is not valid.');
            }
        }

        $data = array();
        $this->load->library('session');
        $this->load->helper('url');
        
		/* unset session values */
		
        $this->session->unset_userdata('user_email_id');
        $this->session->unset_userdata('password');
		$this->session->unset_userdata('users_role_name');
		$this->session->unset_userdata('user_password');
        /* protect from injection, SANITIZE values */
        $userPwd = '';
        $emailId = trim($this->input->post('email'));
        $emailId = filter_var($emailId, FILTER_SANITIZE_EMAIL);
        $emailId = filter_var($emailId, FILTER_VALIDATE_EMAIL);
        $userPwd = $this->input->post('password');
				
        //Condition below are divided on 4 Phase.
        if (!empty($emailId)) {
            $data = array();
            $is_user_email = "";
            $is_email_np_pw = "";
            $is_email_with_pw = "";
            $is_user_email = $this->post->get_user_dtls_by_email($emailId);
            $is_email_np_pw = $this->post->get_user_dtls_by_email_no_password($emailId);
            $is_email_with_pw = $this->post->get_user_dtls_by_email_and_password($emailId, $userPwd);
			
			
			
            /* [First Phase]: Below if conditions Check is posted email id exists In DataBase */
            if ($is_user_email >= 1) {
				
				$user_dtl = $this->post->get_user_dtls_using_email($emailId);
                //get valid email user details.
                $usr_dtls = $this->post->get_user_dtls_using_email($emailId);
				if(empty($usr_dtls)){
					echo '<div class="alert alert-danger alert_error"> 404 - (access not allowed)</div>';
					die();
				}
				                
				//Store Login users Session, on Database.
				//$sessionId = session_id();
				$sessionId = $this->common->generate_random_number(32);
				$this->session->unset_userdata('loggedIn_users_session');
				$this->session->set_userdata('loggedIn_users_session', $sessionId);
				
                $this->session->set_userdata('user_id', $usr_dtls->user_id);
                $is_concurrent = $this->post->validate_concurrent_user($usr_dtls->user_id, $sessionId, $emailId);

                /*  Commented by Roop on 7 OCT-2020, reg. Concurrent Login....
				if (!empty($is_concurrent) && $is_concurrent == 1) {

                    $this->session->set_flashdata('concurrent_login_error', 'Since your email is already logged in, to other browser or other location & If you login again your previous session will be closed.');

                    $this->session->set_userdata('is_user_logged_in', 'Since your email is already logged in, to other browser or other location & If you login again your previous session will be closed');
                }
				*/				
                //code ends at here 3 Aug. by roop.
				
				//Check OTP AUTH for 5 min.
				$user_dtls     = $this->post->get_user_dtls_using_email($emailId);
				//$this->load->helper('date');
				//date_default_timezone_set('Asia/Kolkata'); 
                $cur_time	= date('Y-m-d H:i:s');
				$cur_time_one	= date("Y-m-d H:i:s", strtotime('+4 hours +30 minutes'));
                $from_otp_time = $user_dtls->otp_time;
                $otp_num_min   = round(abs(strtotime($cur_time) - strtotime($from_otp_time)) / 60, 2) . " minute";
                $otp_num_min   = ceil($otp_num_min);
				//add attempt otp time expires santhosh
                $attempt_otp_time = $user_dtls->attempt_otp_time;
                $attempt_otp_min   = round(abs(strtotime($cur_time_one) - strtotime($attempt_otp_time)) / 60, 2) . " minute";
                $attempt_otp_min   = ceil($attempt_otp_min);
				/* echo "cur_time=".$cur_time;
                echo "database_time";
				print_r($user_dtls->attempt_otp_time);
				echo "otp_min=",$attempt_otp_min;
				exit(); */
				//end
				//set session when role is clientuser.
				$this->session->unset_userdata('resend_by_user');
				if(!empty($user_dtls->role_name) && $user_dtls->role_name=="ClientUser") {
					$this->session->set_userdata('resend_by_user', $user_dtls->role_name);
				}
				
				/* otp account locking time */
				$otp_attempt_time = $user_dtls->attempt_otp_time;
                $otp_min_lock     = round(abs(strtotime($cur_time) - strtotime($otp_attempt_time)) / 60, 2) . " minute";
                $otp_min_lock     = ceil($otp_min_lock);				
				/* end of account locking time variable prep. */			
				
				//$this->regenerate_otp($emailId); //Commenting Code for sending OTP.				
                $data = array('users_email' => $emailId);
				
            } else {
				$this->session->set_flashdata('wrong_pwd', 'WRONG_PASSWORD_V==');
                $data = array('error' => 'USER_N_RECOGNIZED');
                $this->session->unset_userdata('user_email_id');
				/* End of first Phase */
            }
			
			
            /* Second PHASE: 
				If Email ID exists:  
				- Login User Role is only "Client User"
				- & OTP in session == POST otp 
			*/
			
			if ($is_user_email >= 1 && $is_email_np_pw >= 1) {
				
				$user_dtl = $this->post->get_user_dtls_using_email($emailId);
				
				//validate OTP DB & POSTED IN USER REDIRECTION, role.	
				$resend_otp = false;
				$this->session->unset_userdata('users_role_name');
				$this->session->set_userdata('users_role_name', "ClientUser");
				
				/* code related to avoiding OTP for varutra domain domain varutra */
				/* $is_varutra = false ;
				$domain_name = substr(strrchr($emailId, "@"), 1);
				if($domain_name == "varutra.com"){
					$is_varutra = true ;
				}
				
				if($is_varutra ==true){
					
					//regenerate new session values after Login Successfully by User...
					$this->session->sess_regenerate();
					$sessionId = $this->session->userdata('loggedIn_users_session');						
					$update_ci_sess = $this->post->update_ci_session($usr_dtls->user_id, $sessionId, $emailId);
					$this->session->set_userdata('updated_sess_id', $sessionId);
					$this->session->set_userdata('user_email_id', $emailId);
					
					//reset session data stored in variables.
					unset($_SESSION['WRONG_OTP']);
					unset($_SESSION['success_resend_otp']);
					unset($_SESSION['resend_otp_attempt']);
					unset($_SESSION['otp_attempt']);
					$this->reset_defined_users_data();
					//$data = array('users_role' => $user_dtls->role_name);
					$data = array('message' => 'IS_USER_ONLY');					
					
				} else{ */
				if ($otp_min_lock<10 && $this->uri->segment(3) == "resend_otp"){
					$resend_otp = true;
					$unlock_time = 10 - intval($otp_min_lock);
                    $this->session->set_flashdata('wrong_pwd', 'WRONG_PASSWORD_V==');
                    $data = array('resend_otp_attempt' => 'Your account has been locked for next  ' .$unlock_time.'  minutes as there are 3 consecutive attempts for Resending OTP');
					$this->reset_defined_users_data();
					
				}else if($otp_min_lock<10 && $this->uri->segment(3) != "resend_otp"){
					
					$resend_otp = true;	
					$unlock_time = 10 - intval($otp_min_lock);					
					$this->session->set_flashdata('wrong_pwd', 'WRONG_PASSWORD_V==');
					$data = array('login_attempts' => 'Your account has been locked for next ' .$unlock_time.' minutes as there are 5 continues failed attempts for OTP.');
					$this->reset_defined_users_data();
					
				}else if($this->input->post('otp')=="undefined"){
					
					//Regenerating OTP and send to respetive email_id.
					if((empty($this->input->post('otp')) || $this->input->post('otp') == 'undefined' || $this->input->post('otp')=='') && $this->uri->segment(3) != "resend_otp"){
							
							$this->regenerate_otp($emailId);
							$this->session->set_userdata('users_role_name',"ClientUser");
					}
					$data = array('users_email' => $emailId);
					
				}else{
					
						
					$data = array('users_email' => $emailId);
					
					//Handle "Resend OTP" requests & number of attempts for user.
					if (!empty($this->uri->segment(3)) && $this->uri->segment(3) == "resend_otp") 
					{
							$is_user_email =  $this->post->get_user_dtls_using_email($emailId);								
							if(!empty($is_user_email->email_id)){
							
								//removing this line: $this->regenerate_otp($emailId);
								$this->session->set_userdata('users_role_name',"ClientUser");
								//Code for 'Resend OTP' attempt count.
								$resend_otp_attempt = $this->session->userdata('resend_otp_attempt');
								$resend_otp_attempt++;
								$this->session->set_userdata('resend_otp_attempt', $resend_otp_attempt);
								
								//check $resend_otp_attempt !=3
								if($resend_otp_attempt !=3 && $resend_otp==false){
									$this->regenerate_otp($emailId);
								}
								
								/* locking user account for 10 min. when user is entering wrong otp */
								if($resend_otp_attempt == 3 && $resend_otp==false){
							
									$update_data = array('attempt_otp_time' => date('Y-m-d H:i:s'));
									$data_success = $this->post->update_login_attempts($update_data, $user_dtl->user_id);
									$data = array('resend_otp_attempt' => 'Your account has been locked for next 10 minutes as there are 3 consecutive attempts for Resending OTP');
									$this->session->set_flashdata('wrong_pwd', 'WRONG_PASSWORD_V==');
									$this->reset_defined_users_data();
									
								}else{
									
									//Send Email for successful resend OTP, Set Users Email id & password again.
									
									$data = array('users_email' => $emailId);
									$this->session->set_flashdata('success_resend_otp', 'OTP has been sent successfully in your email shown in textbox, please check your email id for OTP');
								}
								
							}else{
								
								//UnAuth Access URls, Show error MSG.
								echo '<div class="alert alert-danger alert_error"> 404 - (access not allowed)</div>';
								die();
							}						
						//End of code use to handle "Resend OTP" requests & number of attempts for user.
						
					}else if(!empty($this->input->post('otp')) && $this->input->post('otp') != 'undefined'){
						
						/* 
						   Handle requests & count number of Wrong OTP attempts for user.
						   If OTP is posted by client User & we are validating [OTP DB + POSTED OTP].
						*/						
						if($user_dtls->otp_users!=trim($this->input->post('otp'))){
										
							$otp_attempt = $this->session->userdata('otp_attempt');
							$otp_attempt++;
							$this->session->set_userdata('otp_attempt', $otp_attempt);
							
							/* locking user account for 10 min. when user is entering wrong otp */
							if($otp_attempt ==5 && $resend_otp == false){
								
								$update_data = array('attempt_otp_time' => date('Y-m-d H:i:s'));
								$data_success = $this->post->update_login_attempts($update_data, $user_dtl->user_id);								
								$this->session->set_flashdata('wrong_pwd', 'WRONG_PASSWORD_V==');
								$data = array('login_attempts' => 'Your account has been locked for next 10 minutes as there are 5 continues failed attempts for OTP.');
								$this->reset_defined_users_data();
								
							}else{	
								$this->session->set_flashdata('WRONG_OTP', 'WRONG_PASSWORD_V==');
							}
							
						}else{
							
							/* HAVING OLD CODE  */
							if($user_dtls->otp_users != trim($this->input->post('otp'))){
								$this->session->set_flashdata('WRONG_OTP', 'WRONG_PASSWORD_V==');
								
							}else{
								
								//regenerate new session values after Login Successfully by User...
								$this->session->sess_regenerate();
								$sessionId = $this->session->userdata('loggedIn_users_session');						
								$update_ci_sess = $this->post->update_ci_session($usr_dtls->user_id, $sessionId, $emailId);
								$this->session->set_userdata('updated_sess_id', $sessionId);
								$this->session->set_userdata('user_email_id', $emailId);
								
								//reset session data stored in variables.
								unset($_SESSION['WRONG_OTP']);
								unset($_SESSION['success_resend_otp']);
								unset($_SESSION['resend_otp_attempt']);
								unset($_SESSION['otp_attempt']);
								$this->reset_defined_users_data();
								//$data = array('users_role' => $user_dtls->role_name);
								$data = array('message' => 'IS_USER_ONLY');		
							}
						}		
					}
				}
				
				//}  //end of else case.
				
            } elseif($is_user_email >= 1 && $is_email_np_pw == 0 && !empty($userPwd) && $userPwd != 'undefined') {
				
				/* Third Phase: If Email ID exists(Valid) & Password also exits:
					* Login User Role is only Admin & OTP in session = POST otp 
					* Role is "Admin" ?
				*/
				
                /* new code for user is locked for 30 min. or not. */
                $user_dtl = $this->post->get_user_dtls_using_email($emailId);

                $to_time   = date('Y-m-d H:i:s');
                $from_time = $user_dtl->attempt_time;
                $num_min   = round(abs(strtotime($to_time) - strtotime($from_time)) / 60, 2) . " minute";
                $num_min   = ceil($num_min);
                $is_locked = false;
				
				/*
					Third Phase - [A]: Check Condition is account is locked for 30 min, due to 5 wrong password attempts.
					-Put all Conditionsa for Account Locking rules below.
					{
						-  Account Lock while entering Wrong Password 5 times continiously.
						-  Account Lock while Clicking to 'Resend OTP' link continiously 3 times, in same session. 
						-  Account Lock while  entering Wrong OTP 5 times continiously, in same session.
						-  Make sure all OTPs will valid for 5 min. only.
						@ Below as of now we have only one condition.
					}
				*/
				$resend_otp = false;
				
				/* code related to avoiding OTP for varutra domain domain varutra */
				/* $is_varutra = false ;
				//$email = "youremail@varutra.com";
				$domain_name = substr(strrchr($emailId, "@"), 1);
				if($domain_name == "varutra.com"){
					$is_varutra = true ;
				}
				
				if($is_varutra ==true){
					
					//regenerate new session value(destroying old values) after Login Successfully...
					$this->session->sess_regenerate();
					$sessionId = $this->session->userdata('loggedIn_users_session');							
					$update_ci_sess = $this->post->update_ci_session($usr_dtls->user_id, $sessionId, $emailId);
					$this->session->set_userdata('updated_sess_id', $sessionId);
					$this->session->set_userdata('user_email_id', $emailId);
					$this->session->set_userdata('user_password', $userPwd);
					
					$this->session->unset_tempdata('WRONG_OTP');//unset session data stored.
					unset($_SESSION['WRONG_OTP']);
					$this->session->unset_tempdata('success_resend_otp');
					unset($_SESSION['success_resend_otp']);
					$this->session->unset_userdata('resend_otp_attempt');
					$this->session->unset_userdata('otp_attempt');									
					//unset resend otp success message.
					
					$data = array('message' => 'ADMIN_ONLY');				
					
				}else{ */
                if ($num_min < 30) {
                    $is_locked = true;
					$unlock_acc_time = 30 - intval($num_min);
                    $this->session->set_flashdata('wrong_pwd', 'WRONG_PASSWORD_V==');
                    $data = array('login_attempts' => 'Your account has been locked for next  ' .$unlock_acc_time.' minutes as there are 5 continues failed attempts.');
					$this->reset_defined_users_data();
				}
				else if ($otp_min_lock<10 && $this->uri->segment(3) == "resend_otp"){
					
					$resend_otp = true;
					$unlock_time = 10 - intval($otp_min_lock);
                    $this->session->set_flashdata('wrong_pwd', 'WRONG_PASSWORD_V==');
                    $data = array('resend_otp_attempt' => 'Your account has been locked for next  ' .$unlock_time.' minutes as there are 5 continues failed attempts for Resending OTP.');
					$this->reset_defined_users_data();
					
				}else if ($otp_min_lock<10 && $this->uri->segment(3) != "resend_otp"){
					
					$resend_otp = true;
					$unlock_time = 10 - intval($otp_min_lock);
                    $this->session->set_flashdata('wrong_pwd', 'WRONG_PASSWORD_V==');
                    $data = array('resend_otp_attempt' => 'Your account has been locked for next ' .$unlock_time.' minutes as there are 3 continues failed attempts for OTP.');
					$this->reset_defined_users_data();
					
				}else {
					
					/*
						Fourth Phase: 
					   - When account is not locked. 
					   - Condition below defines that User role is having his/her password matching with Data server,
					    'is_locked = false' means account is not locked still.
					*/
					
                    if ($is_email_with_pw >= 1 && $is_locked == false) {					
						
						//Sending OTP to user at once when user is validating password.
						if((empty($this->input->post('otp')) || $this->input->post('otp') == 'undefined' || $this->input->post('otp')=='') && $this->uri->segment(3) != "resend_otp"){
							
							$this->regenerate_otp($emailId);
						}					
						
						/*	
							Fourth Phase:  [A]				
							- Since users password is Matching with user email-id, therefore we set users password on session.
							- validate OTP DB & POSTED IN ADMIN REDIRECTION, check number of attempts.
							- Check posted otp & users otp are different.							
						*/
						
						//Handle "Resend OTP" requests & number of attempts for user.
						if (!empty($this->uri->segment(3)) && $this->uri->segment(3) == "resend_otp") 
						{
								$is_user_email =  $this->post->get_user_dtls_using_email($emailId);								
								if(!empty($is_user_email->email_id)){
																									
									//Code for 'Resend OTP' attempt count.
									//$this->session->unset_userdata('attempt');
									$resend_otp_attempt = $this->session->userdata('resend_otp_attempt');
									$resend_otp_attempt++;
									$this->session->set_userdata('resend_otp_attempt', $resend_otp_attempt);
									
									//check $resend_otp_attempt !=3
									if($resend_otp_attempt !=3 && $resend_otp==false){
										$this->regenerate_otp($emailId);
									}
									//$this->reset_defined_users_data();
									
									/* locking user account for 10 min. when user is entering wrong otp */
									if($resend_otp_attempt ==3 && $resend_otp==false){
								
										$update_data = array('attempt_otp_time' => date('Y-m-d H:i:s'));
										$data_success = $this->post->update_login_attempts($update_data, $user_dtl->user_id);
										$data = array('resend_otp_attempt' => 'Your account has been locked for next 10 minutes as there are 3 continues failed attempts for Resending OTP.');
										$this->session->set_flashdata('wrong_pwd', 'WRONG_PASSWORD_V==');
										$this->reset_defined_users_data();
										
									}else{
										
										//Send Email for successful resend OTP, Set Users Email id & password again.
										$this->session->unset_userdata('user_password');
										$this->session->set_userdata('user_password', $userPwd);
										$data = array('users_email' => $emailId);
										$this->session->set_flashdata('success_resend_otp', 'OTP has been sent successfully in your email shown in textbox, please check your email id for OTP');
									}
									
								}else{
									
									//UnAuth Access URls, Show error MSG.
									echo '<div class="alert alert-danger alert_error"> 404 - (access not allowed)</div>';
									die();
								}
							//End of code use to handle "Resend OTP" requests & number of attempts for user.
							
						}else{
							
							/* 	Track user wrong OTP attempt. 	*/
							//$this->reset_defined_users_data();
							$this->session->unset_userdata('user_password');
							$this->session->set_userdata('user_password', $userPwd);
								
							if(!empty($this->input->post('otp')) && $user_dtls->otp_users != trim($this->input->post('otp')) && $this->input->post('otp') != 'undefined'){
									//$this->session->unset_userdata('attempt');
									$otp_attempt = $this->session->userdata('otp_attempt');
									$otp_attempt++;
									$this->session->set_userdata('otp_attempt', $otp_attempt);
									if ($attempt_otp_min>5){
										$data = array('users_email' => $emailId);
										$this->session->set_flashdata('OTP_EXPIRE', 'WRONG_PASSWORD_V==');
										//$this->reset_defined_users_data();
									}
									else if($otp_attempt ==5 && $otp_num_min<10){
										
										//query to update database table, for locking users account.						
										$update_data  = array('attempt_otp_time' => date('Y-m-d H:i:s'));
										$data_success = $this->post->update_login_attempts($update_data, $user_dtl->user_id);
										
										$data = array('login_attempts' => 'Your account has been locked for next 10 minutes as there are 5 continues failed attempts for OTP.');
										$this->session->set_flashdata('wrong_pwd', 'WRONG_PASSWORD_V==');
										$this->reset_defined_users_data();
										
									}else{
										
										$data = array('users_email' => $emailId);
										//$this->session->set_userdata('user_password', $userPwd);
										$this->session->set_flashdata('WRONG_OTP', 'WRONG_PASSWORD_V==');
									}
									
							}else{
								
								/*
									Fourth Phase:  [B]  { Conditions only for ADMIN Role }							
									- Check is OTP Posted is matching with Saved otp in data Dase with repect to user.
									- 
								*/
								
								$data = array('users_email' => $emailId);
								
								if(!empty($this->input->post('otp')) && $this->input->post('otp') != 'undefined'){
									if ($attempt_otp_min>5){
									$data = array('users_email' => $emailId);
										$this->session->set_flashdata('OTP_EXPIRE', 'WRONG_PASSWORD_V==');
										//$this->reset_defined_users_data();
									}
								else if($user_dtls->otp_users != trim($this->input->post('otp'))){																				
										$data = array('users_email' => $emailId);
										$this->session->set_userdata('user_password', $userPwd);
										$this->session->set_flashdata('WRONG_OTP', 'WRONG_PASSWORD_V==');
										
									}else{
										
										//regenerate new session value(destroying old values) after Login Successfully...
										//$this->session->sess_regenerate();
										$sessionId = $this->session->userdata('loggedIn_users_session');							
										/*$update_ci_sess = $this->post->update_ci_session($usr_dtls->user_id, $sessionId, $emailId);
										$this->session->set_userdata('updated_sess_id', $sessionId);
										$this->session->set_userdata('user_email_id', $emailId);
										$this->session->set_userdata('user_password', $userPwd);
										*/
										
										$this->session->unset_tempdata('WRONG_OTP');//unset session data stored.
										unset($_SESSION['WRONG_OTP']);
										$this->session->unset_tempdata('success_resend_otp');
										unset($_SESSION['success_resend_otp']);
										$this->session->unset_userdata('resend_otp_attempt');
										$this->session->unset_userdata('otp_attempt');									
										//unset resend otp success message.
										
										$data = array('message' => 'ADMIN_ONLY');		
									}						
								}
								
							}						
						} /* End of else part */
						
                    } else {

                        //Validating password and number of wrong password attempts for given users.
                        $attempt = $this->session->userdata('attempt');
                        $attempt++;
                        $this->session->set_userdata('attempt', $attempt);

                        if ($attempt < 5 && $is_locked == false) {

                            $this->session->set_flashdata('wrong_pwd', 'WRONG_PASSWORD_V==');
                            $data = array('login_attempts' => 'Email id Or Password is not correct!' . '<br />' . 'After 5 failed consecutive login attempts your account will be locked.');
                        } else if ($attempt == 5 && $is_locked == false) {

                            //query to update database table, for locking users account.						
                            $update_data = array(
                                'attempt_time' => date('Y-m-d H:i:s'),
                                'attempts' => $attempt
                            );
                            $data_success = $this->post->update_login_attempts($update_data, $user_dtl->user_id);
                            $this->session->set_flashdata('wrong_pwd', 'WRONG_PASSWORD_V==');
                            $data = array('login_attempts' => 'Your account has been locked for next 30 minutes as there are 5 continues failed attempts.');
							
                        } else {

                            //$data = array('error' => 'WRONG_PASSWORD');
                            if ($is_locked == false) {
                                $this->session->set_flashdata('wrong_pwd', 'WRONG_PASSWORD_V==');
                                $data = array('login_attempts' => 'Email id Or Password is not correct!' . '<br />' . ' After 5 failed consecutive login attempts your account will be locked.');
                                $this->session->unset_userdata('password');
                            }
                        }
						
						/* Ending of code for validating password & Count number Of Attempts. */
                    }
                }
			 //}
				/* end of elseif case at here */
            }
        }
		
        /* End of all three Phase conditions above */
		
        //validating post_ids
        if (!empty($this->input->post('post_id'))) {
            $this->session->unset_userdata('cur_post_id');
            $this->session->set_userdata('cur_post_id', $this->input->post('post_id'));
        }
        if (!empty($this->input->post('email')) && $this->input->post('password') != "undefined") {
            $data['email_id'] = $this->input->post('email');
        }if (!empty($this->input->post('password')) && $this->input->post('password') != "undefined") {
            //echo "PASSS=".$this->input->post('password');
        }
        //echo $this->session->userdata('user_email_id')."=SESSION";
        //load the view
        $this->load->view('posts/submit_form', $data, false);
    }

    
    public function postDetails() {

        $post_id = '';
		if (empty($this->session->userdata('user_email_id'))) {
			$this->session->set_userdata('last_accessed_post_id', $this->uri->segment(3));
			 $this->load->view('posts/login');
		}else if(!empty($this->session->userdata('last_accessed_post_id'))){
			
			//$url = redirect('posts/login', 'refresh');
			//redirect('posts/login/'.$this->session->userdata('last_accessed_post_id'), 'refresh');
			//redirect($this->session->userdata('last_accessed_page'), 'refresh');
			$post_id = $this->encryptdecrypt->DecryptThis($this->session->userdata('last_accessed_post_id'));
			$data['post_dtls'] = $this->post->get_post_details_by_id($post_id);
			$this->load->view('posts/description', $data, false);
			
			//check condition is, user is already logged in or Not
	    }else if (!empty($this->uri->segment(3)) && strtolower($this->uri->segment(2)) == 'postdetails') {

			
            $post_id = $this->encryptdecrypt->DecryptThis($this->uri->segment(3));
			$data['post_dtls'] = $this->post->get_post_details_by_id($post_id);
			$this->load->view('posts/description', $data, false);
			
        } else if (!empty($this->session->userdata('cur_post_id')) && $this->session->userdata('cur_post_id') != 'undefined') {

            $post_id = $this->session->userdata('cur_post_id');
			$data['post_dtls'] = $this->post->get_post_details_by_id($post_id);
			$this->load->view('posts/description', $data, false);
        }
    }
	
	/**
     * @Auther:Pradeep
     * function load view Login
     * @return View
     */
    public function login() {
        $this->load->view('posts/login');
    }
	
	
	/*
		* Author		   :   ROOP KISHOR MISHRA
		* Function Details :   Sending email notification when user role is client.
	*/
	public function users_notification_for_client_users($user_name, $email, $password){
		
		
		if (!empty($email)) {
			
			//$from     =  "ctp-back3nd@infosharesystems.com";
			$from     =  "vptrack@infosharesystems.com";
			$name_urs =  $user_name;
			if(!empty($name_urs)){
            $name_urs =  $user_name;
			}else{
				$name_urs =  "User";
			}
			$to       = $email;
			$name     = 'Cyber Threat Post';
			$cc       = "";
			$title    = "Message";
			$subject  = "Cyber Threat Post - Security Advisories Portal Registration" ;
			$prep_url_privacy  = base_url()."posts/Privacypolicy";
			$prep_app_url = base_url()."posts/index";
			
			$password_set = (!empty($password)) ? 'Password: '. $password : '';
			
			$body = '<html><body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #F2F3F8;" leftmargin="0">    
				<table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#F2F3F8"
					style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: "Open Sans", sans-serif;">
					<tr>
						<td>
							<table style="background-color: #F2F3F8; max-width:670px;  margin:0 auto;" width="100%" border="0"
								cellpadding="0" cellspacing="0">                    
								<tr>
									<td style="height:20px;">&nbsp;</td>
								</tr>
								<tr>
									<td>
										<table width="95%" border="0" cellpadding="0" cellspacing="0"
											style="max-width:670px;background-color:#FFFFFF; border-radius:3px; text-align:left;">
											<tr>
												<td></td>
											</tr>
											<tr>
												<td style="height:40px;">&nbsp;</td>
											</tr>
											<tr>
												<td style="padding:0 35px;">
													<p style="color:#455056; font-size:15px;line-height:2; margin:0;">Dear '.$name_urs.',</p>
													<p style="color:#455056; font-size:15px;line-height:2; margin-top:8px;"></p>
													
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">Greetings from Infoshare Varutra!</p>
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">
														Thank you for your cyber secure interest and registering for Cyber Threat Post advisories subscription.
													</p>
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">
													You may now log in by clicking the link below or copying and pasting it into your browser: Cyber Threat Post Portal: 
													<a href="'.$prep_app_url.'"
														style="color:blue;text-decoration:none !important; font-weight:500; margin-top:20px;font-size:12px;padding:6px 14px;display:inline-block;">'.$prep_app_url.'</a>
													</p>
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">
														To read the advisory post, you will be required to login via your registered Email address and gain access to the several other published security advisories.
													</p>
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">For any queries or any feedback, please contact with us at:<br> <a href="mailto:ctp-back3nd@infosharesystems.com" style="text-decoration:none !important;">ctp-back3nd@infosharesystems.com </a><br>
													<br><strong>Never disclose your confidential information such as Username, Password, OTP etc. to anyone.</strong>
													</p>													
												</td>
											</tr>
											
											<tr><td style="padding:0 35px;"><p style="color: #455056;font-size: 15px;margin: 0;margin-top: 48px;">Best Regards,</p>
											<p style="color: #455056;font-size: 15px;line-height: 1.6;margin: 0;margin-top:8px;">Team Cyber Threat Post
											</p></td>
											</tr>											
											<tr>
												<td style="height:40px;">&nbsp;</td>
											</tr>
										</table>
									</td>
								</tr>                    
								<tr>
									<td style="height:80px;">&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				</body></html>';
				
				
				//perform transaction as required, sending emails to all type of active users.				
				//call send email function for all TYPE of to from here......
				 $flag = $this->emailer_model->sendemail($from, $to, $cc, $title, $subject, $body, $name, $this->config->item('user'), $this->config->item('password'));
		}
	
	}
	
	
	
	/*
		* Author		   :   ROOP KISHOR MISHRA
		* Function Details :   Adding Data on Users table from Contact US form
	*/
	
	public function insert_users_data(){	
		
		$email 		= htmlspecialchars(trim($this->input->post('email')));
		$is_user_email = $this->post->get_user_dtls_by_email($email);
		
		//set variables.
		$userStatus  =  0;
		$pwd 		 =  $this->randomNumberGen(9);
		$role_id	 =  2;   
		$email 		 = filter_var($email, FILTER_SANITIZE_EMAIL);
		$email 		 = filter_var($email, FILTER_VALIDATE_EMAIL);
		$role 		 = htmlspecialchars("ClientUser");
		$role 		 = preg_replace("/[^a-zA-Z]+/", "", $role);
		$phone_post  = $this->input->post('phone');
		$phone_post  = !empty($phone_post) ? $phone_post : '';
		
		$first_name  = $this->input->post('name');
		$first_name  = !empty($first_name) ? $first_name : '';			
		$last_name   = $this->input->post('surname');
		$last_name   = !empty($last_name) ? $last_name : '';
		$phone   	 = $this->input->post('phone');
		$phone       = !empty($phone) ? $phone : '';
		$message     = $this->input->post('message');
		$message     = !empty($message) ? $message : '';
			
		if($is_user_email>=1){
			
			//sending email notification for Client users when data is captured from Contact Us Form.			
			$this->users_notification_for_client_users($first_name, $email, '');
			
		}else{
			$insertData = array(
								'first_name' => $first_name,
								'last_name'  => $last_name,
								'phone' 	 => $phone,
								'message'    => $message,
								'role_name'  => $role,
								'email_id'   => $email,
								'status' => $userStatus,
								/*'password' => $pwd,*/
								'is_user_new' => 1,
								/*'password_history' => json_encode(array($pwd)),*/
								'created_by' => $this->session->userdata('user_id') ? $this->session->userdata('user_id') : "",
								'role_id' => $role_id,
								'created_date' => date('Y-m-d H:i:s'),
								);
											
			//checking is domain is @YAHOO or @GMAIL @ REDIFFMAIL @HOTMAIL
			if(preg_match("/(hotmail|gmail|yahoo|rediffmail)/i", $email)){
				
				$insert_data = array(
									'first_name' => $first_name,
									'last_name'  => $last_name,
									'phone' 	 => $phone,
									'message'    => $message,
									'email_id'   => $email,
									'status'     => $userStatus,								
									'created_date' => date('Y-m-d H:i:s'),
									);
				$id = $this->post->add_user_request($insert_data);
				$this->users_notification_for_client_users($first_name, $email, '');
				
			}else{				
			
				$id = $this->post->add_user($insertData);
				//sending email notification for Client users when data is captured from Contact Us Form.
				$this->users_notification_for_client_users($first_name, $email, $pwd);
			}
			
		}
	}
	
	
    public function ContactUs() {
		
		$recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
		$userIp = $this->input->ip_address();
		$secret = $this->config->item('google_secret');
		$url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $recaptchaResponse . "&remoteip=" . $userIp;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		$status = json_decode($output, true);
		if ($status['success']==true) {
			if (!empty($this->input->post('email'))) {
				
				$validator = array('success_d' => true, 'messages' => 'Subscription request sent successfully');
				$from = 'vptrack@infosharesystems.com';//$this->input->post('email');
				$phone_post = $this->input->post('phone');
				$phone_post = !empty($phone_post) ? '<br /><b>Phone :</b>' . $phone_post : '';
				$user_name = $this->input->post('name') . '  ' . $this->input->post('surname');
				$message = $this->input->post('message');
				
				//prasanth.kantamaneni@infosharesystems.com, roopitonline@gmail.com,
				
				$to   = "ctp-back3nd@infosharesystems.com";
				$name = 'Cyber Threat Post';
				
				$cc = "";
				$title = "Message";
				$subject = "Message from Cyber Threat Post";
				$body = "<html><body>Hello Team,  <br /><br />You have received a message from <b>".$user_name."</b> <br /><br /> <b>Email :</b>".$from.$phone_post."<br /> <b>Message :</b> ".$message."<br></body></html>";

				/* CSRF code added by ROOP  */
				if ($this->input->server('REQUEST_METHOD') == 'POST') {

					if ($this->csrfprotect->validate_both_tokens($this->input->post('token_id'))) {

						if (time() >= $this->session->userdata('token_expire')) {

							$this->csrfprotect->reset_session_token();
							$this->session->set_flashdata('error', 'Error! Please reload page again to perform this action');
							$this->index('refresh');
						} else {
							
							//Insert users Data in Users Table.
							$this->insert_users_data();
							
							//perform transaction as required.			
							$flag = $this->emailer_model->sendemail($from, $to, $cc, $title, $subject, $body, $name, $this->config->item('user'), $this->config->item('password'));
							if($flag==1){
								
								//$validator = array('error' => false, 'messages' => 'Email sent successfully');
								$this->session->set_flashdata('message_contact_s', 'Subscription request sent successfully');
								redirect(base_url().'#contactus_1');								
							}else{
								
								$this->csrfprotect->reset_session_token();
								$this->session->set_flashdata('error', 'Error! Invalid user something went wrong');
								$this->index('refresh');
							}
						}
					} else {

						$this->csrfprotect->reset_session_token();
						$this->session->set_flashdata('error', 'Error! Invalid user something went wrong');
						$this->index('refresh');
					}
				} else {
					$this->csrfprotect->reset_session_token();
					$this->session->set_flashdata('error', 'Error! Unauthorised access of application');
					$this->index('refresh');
				}
				/* Ends CSRF Code at here  */

				/*
				  $flag = $this->emailer_model->sendemail($from, $to, $cc, $title, $subject, $body, $name, $this->config->item('user'), $this->config->item('password'));
				  $validator = array('error' => false, 'messages' => 'Email sent successfully');
				  $this->session->set_flashdata('message_s', 'Email sent successfully');
				 */
			} else {
				$validator = array('error' => false, 'messages' => 'Email not sent something went wrong');
				$this->session->set_flashdata('message_s', 'Email not sent something went wrong');
			}
			
		}else{
			
			//If Captcha Fails at here..
			$validator = array('error' => false, 'messages' => 'Sorry Google Recaptcha Unsuccessful!!');
			$this->session->set_flashdata('error', 'Sorry Google Recaptcha Unsuccessful!!');
		}
	
		$this->index();  //calling index function to redirect to server.
		//$this->session->set_flashdata('error', 'Error! Invalid user something went wrong');
		$this->index();
		redirect(base_url() . 'posts/index');
		//redirect(base_url('posts/index'));        
		//$this->db->close();
        //echo json_encode($validator);        
        //$this->load->view('posts/mail_post_response', $data, false);
        //$this->load->view('posts/index');
        //redirect(base_url('posts/index'));
    }

    
    /**
     * @Auther:Aarti
     * function load view Privicy policy
     * @return View
     */
    public function Privacypolicy() {
        $this->load->view('posts/Privacy_policy');
    }
	
		
/**
     * @Auther:ROOP KIHOR MISHRA
     * function: randon No Generation
     * @return   View
     */
    public function randomNumberGen($total_char) {
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
	
	/*
		* Author		   :   ROOP KISHOR MISHRA
		* Function Details :  insert_reset_password_data()
	*/
	
	public function insert_reset_password_data($email, $cur_token){
		
		$email 			= htmlspecialchars(trim($email));
		//$is_user_email  = $this->post->get_user_dtls_by_email($email);
		
		if(!empty($email) & !empty($cur_token)){
			$email 		= filter_var($email, FILTER_SANITIZE_EMAIL);
			$email 		= filter_var($email, FILTER_VALIDATE_EMAIL);			
			$insertData = array(
								'email' 		=> $email,
								'access_count'  => 1,
								'token'   		=> $cur_token,
								'expires' 		=> 0,
								'expDate' 		=> date('Y-m-d H:i:s'),
								);
								
			$id = $this->post->add_users_reset_password($insertData, $email);
		}
	}
	
	
		
	/**
		 * @Auther:ROOP KIHOR MISHRA
		 * function: forgotemail_link()
		 * @return   View
     */
	
	public function forgotemail_link(){
		
		if (!empty($this->uri->segment(3))) {				
			$cur_token 	   = $this->randomNumberGen(16);
			$is_user_email =  $this->post->get_user_dtls_using_email($this->uri->segment(3));
			$from          =  'vptrack@infosharesystems.com';//$this->uri->segment(3);
			$phone_post    =  $this->input->post('phone');
			$phone_post    =  !empty($phone_post) ? '<br /><b>Phone :</b>' . $phone_post : '';
			$name_urs      =  !empty($is_user_email->first_name) ? 'Dear '.$is_user_email->first_name : "Dear User";
			$to     = $this->uri->segment(3);
			//$to   = "roopitonline@gmail.com";
			$name   = 'Cyber Threat Post';

			$cc      = "";
			$title   = "Message";
			$subject = "Cyber Threat Post - Account Password Reset";
			
			//insert data on reset password field.
			$this->insert_reset_password_data($this->uri->segment(3), $cur_token);

			$prep_url         = base_url()."posts/Forgotpassword/".$cur_token . '/1';
			$prep_url_privacy = base_url()."posts/Privacypolicy";
			
			$body = '<html><body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #F2F3F8;" leftmargin="0">    
				<table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#F2F3F8"
					style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: "Open Sans", sans-serif;">
					<tr>
						<td>
							<table style="background-color: #F2F3F8; max-width:670px;  margin:0 auto;" width="100%" border="0"
								cellpadding="0" cellspacing="0">                    
								<tr>
									<td style="height:20px;">&nbsp;</td>
								</tr>
								<tr>
									<td>
										<table width="95%" border="0" cellpadding="0" cellspacing="0"
											style="max-width:670px;background-color:#FFFFFF; border-radius:3px; text-align:left;">
											<tr>
												<td></td>
											</tr>
											<tr>
												<td style="height:40px;">&nbsp;</td>
											</tr>
											<tr>
												<td style="padding:0 35px;">
													<p style="color:#455056; font-size:15px;line-height:2; margin:0;">'.$name_urs.',</p>
													<p style="color:#455056; font-size:15px;margin-top: 20px;">Greetings!</p>
													<p style="color:#455056; font-size:15px;line-height:1.6; margin-top:19px;">Someone requested a password reset of your CTP account and we wanted to check with you that it is you who has requested it. 
													</p>
													<p style="color:#455056; font-size:15px;line-height:1.6; margin-top:16px;">If you didn&apos;t make this request, please ignore this email and your account password is still safe.</p>
													<p style="color:#455056; font-size:15px;line-height:1.6; margin-top:16px;">If you did make this request, simply click below link to change your password.</p>
													<p style="color:#455056;font-size:15px;margin-top:16px;    margin-bottom:0;line-height:1.6;"><span style="font-weight:700;">Reset Password &nbsp;<span><a href="'.$prep_url.'"
														style="color:blue;text-decoration:none !important; font-weight:500; font-size:12px;display:inline-block;">'.$prep_url.'</a></p>
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">Your password will not be changed until you access the link above and create a new one.
													</p>
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;"><strong>Never disclose your confidential information such as Username, Password, OTP etc. to anyone.</strong></p>
												</td>
											</tr>
											
											<tr><td style="padding:0 35px;"><p style="color: #455056;font-size: 15px;margin: 0;margin-top: 48px;">Best Regards,</p>
											<p style="color: #455056;font-size: 15px;line-height: 1.6;margin-top:8px;">Team Cyber Threat Post
											</p></td>
											</tr>							
											<tr>
												<td style="height:40px;">&nbsp;</td>
											</tr>
										</table>
									</td>
								</tr>                    
								<tr>
									<td style="height:80px;">&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				</body></html>';
				
				//perform transaction as required.			
				$flag = $this->emailer_model->sendemail($from, $to, $cc, $title, $subject, $body, $name, $this->config->item('user'), $this->config->item('password'));
				
				if($flag==1){
					
					//insert data on.
					$this->insert_reset_password_data($email, $cur_token);
					
					$this->session->set_flashdata('success_forgotpassword', 'Email sent successfully, in yours registered email id for reseting your password');				
					$this->index();
					redirect(base_url() . 'posts/index');
												
				}else{
					
					//echo $flag;
					//die('ENDS at here');
					
					$this->session->set_flashdata('error', 'Error! Invalid user something went wrong');
					$this->index();
					redirect(base_url() . 'posts/index');
				}
		}
	}

	
	/**
		 * @Auther:ROOP
		 * function: Load Forgot password details.
		 * @return View
     */
	 
    public function Forgotpassword() {
		
		/* Calling conditions for forgot password, before loading view,
		   Set proper messages before displaying input box.		
		   @Is token present in table. &  @If count>2 or not.
		*/
		
		$data['users'] = array();
		
		if(!empty($this->uri->segment(3))){
			
			$is_expires = 0;
			$access_cnt = 0;
			$c_token    = $this->uri->segment(3);
			
			//list the data of given users for rest temp table.
			$user_reset_dtl   = $this->post->get_user_reset_password_dtls($c_token);
			if(!empty($user_reset_dtl->access_count) && !empty($user_reset_dtl->token)){
				$access_cnt   = $user_reset_dtl->access_count +1;			
				if($access_cnt>2){
					$is_expires = 1;
				}
				$update_data = array(
									'access_count' => $access_cnt,
									'expires' 	   => $is_expires
									);
				
				//update the given users details in reset temp table.	
				$this->post->update_users_reset_password($update_data, $c_token);
				$user_dtl   = $this->post->get_user_reset_password_dtls($c_token);
				
				if($user_dtl->access_count>2 || $user_dtl->expires==1){
					$this->session->set_flashdata('error_forgotpassword', 'Error! This link is no longer in used, its expired please follow logout steps again');
					
					//$this->load->view('posts/Forgot_password');
					$this->load->view('posts/Forgot_password', $data);
				}else{
					
					//$this->load->view('posts/Forgot_password');
					$this->load->view('posts/Forgot_password', $data);
				}
				
			}else{
				
				$this->session->set_flashdata('error_forgotpassword', 'Error! Un authorized access Something went wrong!');
				//$this->load->view('posts/Forgot_password');
				$this->load->view('posts/Forgot_password', $data);
			}			
			
		}else{
			
			//for of Now temp else case, it will have some error message if no token is accessed by URL......
			//Unauth access Something wne t wrong!
			$this->session->set_flashdata('error_forgotpassword', 'Error! Unauthorized access Something went wrong!');
			//$this->load->view('posts/Forgot_password');
			$this->load->view('posts/Forgot_password', $data);
		}
    }
	
	/**
		 * @Auther:ROOP
		 * function: Load Forgot password details.
		 * @return View
     */
	 
    public function reset_password(){
		
		$cur_email    = $this->input->post('user_email');
		$cur_password = $this->input->post('password');
		
		if(!empty($cur_email) && !empty($cur_password)){
			
			$update_data = array(
							'password' => $this->encryptdecrypt->encryptPassword($cur_password)
						);
						
				$data_success = $this->post->update_users_password($update_data, $cur_email);
				$this->session->set_flashdata('success_forgotpassword', 'Password changed successfully');				
				$this->index();
				redirect(base_url() . 'posts/index');
		}else{
			
			$this->session->set_flashdata('success_forgotpassword', 'Error! something went wrong.');				
			$this->load->view('posts/Forgot_password');
		}
	}



//start debug
	/* public function debug(){
		if(empty($this->input->post('btnSubmit'))){
        redirect('http://localhost/SADdec212020/posts/form');
    }else{
    	$pass="@147";
    	if($this->input->post('password')==$pass){
        echo form_open('http://localhost/SADdec212020/posts/email_debug', ['id' => 'frmUsers']);
        echo form_label('email', 'email');
        echo "<br>";
        echo form_input(['email' => 'email','required'=>'required','name'=>'email']);
        echo form_submit('btnemail', 'login');    
        echo form_close();     	               
    	}else{
    		echo '<script type=text/javascript nonce="2726c7f26c">alert("Wrong Password");</script>';
    		//$this->load->view('form');
    		echo anchor('http://localhost/SADdec212020/posts/form','refresh');
    		//redirect('http://localhost/SADdec212020/posts/form');
    	}
    }
	}
	public function form(){
		echo form_open('http://localhost/SADdec212020/posts/debug', ['id' => 'frmUsers']);
        echo form_label('password', 'password');
        echo "<br>";
        echo form_input(['password' => 'password','required'=>'required','name'=>'password']);
        echo form_submit('btnSubmit', 'login');    
        echo form_close();
	}
	public function email_debug(){
		$Email=$this->input->post('email');
		if(!empty($Email)){
		                 $from = "vptrack@infosharesystems.com";
                        $to = $Email;
                        $name = 'VRGT Admin';
                        $cc = "";
                        $title = "Email debug";
                        $subject = "Email OTP Verification";
                        $body = "<h1>Debug 51</h1>";
                        $this->objMail = $this->phpmailer_library->load();
				        $mail = $this->objMail;
				        try {
				            $mail->SMTPOptions = array(
				                'ssl' => array(
				                    'verify_peer' => false,
				                    'verify_peer_name' => false,
				                    'allow_self_signed' => true
				            ));
				            $mail->isSMTP();
				            $mail->protocal = 'smtp';
				            $mail->Host = 'smtp.office365.com';
				            $mail->SMTPDebug=2;
				            $mail->SMTPAuth = true;
				            $mail->Username = 'vptrack@infosharesystems.com';
				            $mail->Password = '!ZuX;ZPg5s';
				            $mail->SMTPSecure = 'tls';
				            $mail->Port = 587;
				            $mail->charset = 'utf-8';
				            $mail->mailtype = 'html';
				            //Recipients
				            $mail->setFrom($from, 'VRGT Admin');
				            $mail->addAddress($to, $name);
				            //$mail->addCC($cc, 'VRGT');
				            $mail->isHTML(true);
				            $mail->Subject = $subject;
				            $mail->Body = $body;
				            if ($mail->send()) {
				                return true;
				            } else {
				            	echo "false";
				                return false;
				            }
				        } catch (Exception $e) {
				            return false;
				        }
	}else{
		redirect('http://localhost/SADdec212020/posts/form');
	}
	  
		} */
		//debug end
	
}

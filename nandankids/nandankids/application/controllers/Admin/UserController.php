<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/** @Author: Aarti
 * Description: User Controller
 */
class UserController extends CI_Controller {

    public function __construct() {

        parent::__construct();
		$this->load->model('emailer_model');
        $this->load->model('post');
        $this->load->library("PHPMailer_Library");
        $this->load->library('EncryptDecrypt');
        $this->load->model('Admin/User_model');
        $this->load->library("csrfprotect");
        $this->load->library("common");
    }

    /**
     * @Auther:Aarti
     * function load view post
     * @return View
     */
    public function index() {
		
		//validates session, is that user is valid or not.
		$this->common->is_logged_in_user_authorized();
		
		//check url is accessing function by browser.
		//$this->common->check_url_access_by_browser();
		
        //$this->csrfprotect->generate_token();
        $this->load->view('Admin/create_user');
    }

    /**
     * @Auther:Aarti
     * function load view user
     * @return View
     */
    public function create() {
		
		//validates session, is that user is valid or not.
		$this->common->is_logged_in_user_authorized();
		
		//check url is accessing function by browser.
		//$this->common->check_url_access_by_browser();
		
		//check if user created a token or not.
		if(empty($this->session->userdata('csrf_unq_token'))){
			$this->csrfprotect->generate_token();
		}
        $this->load->view('Admin/create_user');
    }

    /**
     * @Auther:Aarti
     * function load edit view user
     * @return View
     */
    public function edit() {
		//validates session, is that user is valid or not.
		$this->common->is_logged_in_user_authorized();
		
		//check url is accessing function by browser.
		//$this->common->check_url_access_by_browser();
		
        $this->csrfprotect->generate_token();
        $user_id = $this->uri->segment(2);
        $id = $this->encryptdecrypt->DecryptThis($user_id);
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $data['user_details'] = $this->User_model->get_user_details_by_id($id);
        if (!empty($data['user_details'][0])) {
            $data['user_id'] = $id;
            $this->load->view('Admin/edit_user', $data);
        } else {
            $this->session->set_flashdata('error', 'Invalid attempt! Something went wrong.');
            redirect('CreateUser');
        }
    }

    /**
     * @Auther:Aarti
     * function retrieve get all user details
     * @return array
     */
    public function get_all_user() {
		
		//validates session, is that user is valid or not.
		$this->common->is_logged_in_user_authorized();
		
		//check url is accessing function by browser.
		//$this->common->check_url_access_by_browser();
		
        $data_fetch = $this->User_model->get_all_user();
		if (!empty($data_fetch)) {
		
			$output = array('data' => array());
			$x = 1;
			foreach ($data_fetch as $row) {
				$id = filter_var($row->user_id, FILTER_SANITIZE_NUMBER_INT);
				$id = filter_var($row->user_id, FILTER_VALIDATE_INT);
				$id = $this->encryptdecrypt->EncryptThis($id);
				$actionButton = '<div class="btn-group" style="margin-right:10px;">              
				<a href=' . base_url() . 'EditUser/' . $id . ' ><span class="datatable-span"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
				</span></a>
					   </div>';
				//condition to change label in dataTable.
				if($row->role_name=="ClientUser"){
					
					$user_role = "Client  User";
				}else{
					$user_role = $row->role_name;
				}
				
				$userStatus = ($row->status == 1) ? "Active" : "Inactive";
				$output['data'][] = array($x, $row->email_id, $user_role, $userStatus, $actionButton);
				$x++;
			}
			$this->db->close();
			echo json_encode($output);
		}else{
			
			$this->session->set_flashdata('error', 'Invalid attempt! Something went wrong.');
            redirect('CreateUser');
		}
    }

    
	/**
     * @Auther  : ROOP
     * function :users_notification_for_admin
	 * DESC     : Sending Email notification for all Active of Users, when new POST getting Published.
     * @return  : 
     */
	 public function users_notification_for_admin($user_id, $email, $password){
		
		
		if (!empty($email)) {
			
			$from     =  "vptrack@infosharesystems.com";
			$name_urs =  "User";
			$to       = $email;
			$name     = 'Cyber Threat Post';
			$cc       = "";
			$title    = "Message";
			$subject  = "Cyber Threat Post - Security Advisories Portal Registration" ;
			$prep_url = "https://www.varutra.com/ctp/";
			$prep_app_url = base_url()."posts/index";
			
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
													<p style="color:#455056; font-size:15px;line-height:2; margin:0;">Dear User,</p>
													<p style="color:#455056; font-size:15px;line-height:2; margin-top:8px;"></p>
													
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">Greetings from Infoshare Varutra!</p>
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">
														Thank you for your cyber secure interest and registering for Cyber Threat Post advisories subscription.<br><br>
													</p>
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">
														Your password to login into Cyber Threat Post application:<strong>&nbsp;'.$password.'</strong><br>
													</p>
													
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">
														You may now log in by clicking the link below or copying and pasting it into your browser: Cyber Threat Post Portal: 
														<strong><a href="'.$prep_url.'"
														style="color:blue;text-decoration:none !important; font-weight:500; margin-top:20px;font-size:12px;padding:6px 14px;display:inline-block;">'.$prep_url.'</a></strong><br>
													</p>
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">
													To read the advisory post, you will be required to login via your registered Email address and gain access to the several other published security advisories.
													</p>
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">For any queries or any feedback, please contact with us at:<br> <a href="mailto:ctp-back3nd@infosharesystems.com" style="text-decoration:none !important;">ctp-back3nd@infosharesystems.com </a><br>
													<br><strong>Never disclose your confidential information such as Username, Password, OTP etc. to anyone.</strong>
													</p>
												</td>
											</tr>
											
											<tr>
												<td style="padding:0 35px;"><p style="color: #455056;font-size: 15px;margin: 0;margin-top: 48px;">Best Regards,</p>
												<p style="color: #455056;font-size: 15px;line-height: 1.5;margin: 0;">Team Cyber Threat Post
												</p></td>
											</tr>								
											<tr>
												<td style="height:40px;">&nbsp;</td>
											</tr>
											<tr>
												<td style="height:20px;">&nbsp;</td>
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
	
	
	public function users_notification_for_client_users($user_id, $email, $password){
		
		
		if (!empty($email)) {
			
			$from     =  "vptrack@infosharesystems.com";
			$name_urs =  "User";
			$to       = $email;
			$name     = 'Cyber Threat Post';
			$cc       = "";
			$title    = "Message";
			$subject  = "Cyber Threat Post - Security Advisories Portal Registration" ;
			$prep_url_privacy  = base_url()."posts/Privacypolicy";
			$prep_url = "https://www.varutra.com/ctp/";
			$prep_app_url = base_url()."posts/index";
			
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
													<p style="color:#455056; font-size:15px;line-height:2; margin:0;">Dear User,</p>
													<p style="color:#455056; font-size:15px;line-height:2; margin-top:8px;"></p>
													
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">Greetings from Infoshare Varutra!</p>
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">
														Thank you for your cyber secure interest and registering for Cyber Threat Post advisories subscription.<br><br>
														Email notification will be sent post every new advisory has been published on the portal.<br><br>
													</p>
													
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">
														You may now log in by clicking the link below or copying and pasting it into your browser: Cyber Threat Post Portal:
														<strong><a href="'.$prep_url.'"
														style="color:blue;text-decoration:none !important; font-weight:500; margin-top:20px;font-size:12px;padding:6px 14px;display:inline-block;">'.$prep_url.'</a></strong><br>
													</p>
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">
													To read the advisory post, you will be required to login via your registered Email address and gain access to the several other published security advisories.
													</p>
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">For any queries or any feedback, please contact with us at:<br> <a href="mailto:ctp-back3nd@infosharesystems.com" style="text-decoration:none !important;">ctp-back3nd@infosharesystems.com </a><br>
													<br><strong>Never disclose your confidential information such as Username, Password, OTP etc. to anyone.</strong>
													</p>
												</td>
											</tr>
											
											<tr>
												<td style="padding:0 35px;"><p style="color: #455056;font-size: 15px;margin: 0;margin-top: 48px;">Best Regards,</p>
												<p style="color: #455056;font-size: 15px;line-height: 1.5;margin: 0;">Team Cyber Threat Post
												</p></td>
											</tr>								
											<tr>
												<td style="height:40px;">&nbsp;</td>
											</tr>
											<tr>
												<td style="height:20px;">&nbsp;</td>
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
	
	/**
     * @Auther:Aarti
     * function load view post
     * @return View
     */
    public function create_user() {
		
		//validates session, is that user is valid or not.
		$this->common->is_logged_in_user_authorized();
		
		//check url is accessing function by browser.
		//$this->common->check_url_access_by_browser();
		
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email', array('required' => 'The email name field is required.', 'valid_email' => 'Please enter valid email.'));
        $this->form_validation->set_rules('role_name', 'Role Name', 'required', array('required' => 'The role name field is required.'));
        if ($this->input->post('role_name') != "Client User") {
            $this->form_validation->set_rules('password', 'Password', 'differs[email]|callback_password_check');
        }
        if ($this->form_validation->run() == FALSE) {
            $result['validaion_error'] = array(
                'email' => form_error('email'),
                'role_name' => form_error('role_name'),
                'password' => form_error('password'),
            );
            $this->session->set_flashdata($result, 'Error while adding the member information.');
            $this->index();
        } else {
			
            if ($this->input->post('role_name') == 'Admin') {
				
				//Sending email notification when we any new admin User is created.
				$this->users_notification_for_admin(1, htmlspecialchars(trim($this->input->post('email'))), trim($this->input->post('password')));
				
                $role_id = "1";    //admin
            }else {
				
				//sending email notification when created user is having role as Client User.
				$this->users_notification_for_client_users(1, htmlspecialchars(trim($this->input->post('email'))), trim($this->input->post('password')));
				
                $role_id = "2"; //UserClient Role: having there will be no password.
            }
            if ($this->input->post('status') == 'active') {
                $userStatus = 1;
            } else {
                $userStatus = 0;
            }
			
			//set users password as Roles.
			if ($this->input->post('role_name') == 'Admin'){
				$users_password   = $this->encryptdecrypt->encryptPassword(trim($this->input->post('password')));
				$password_history = json_encode(array($this->encryptdecrypt->encryptPassword(trim($this->input->post('password')))));
			}else{
				$users_password   = "";
				$password_history = "";
			}
			
            $email = htmlspecialchars(trim($this->input->post('email')));
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            $role = htmlspecialchars(trim($this->input->post('role_name')));
            $role = preg_replace("/[^a-zA-Z]+/", "", $role);
            $insertData = array(
                'role_name' => $role,
                'email_id' => $email,
                'status' => $userStatus,
                'password'  => $users_password,
                'password_history' => $password_history,
                'created_by' => $this->session->userdata('user_id') ? $this->session->userdata('user_id') : "",
                'role_id' => $role_id,
                'created_date' => date('Y-m-d H:i:s'),
            );

            /* CSRF code added by ROOP  */
            $id = '';
            if (!empty($this->session->userdata('user_email_id')) && $this->input->server('REQUEST_METHOD') == 'POST') {
					
				//perform transaction as required.			
				/*$id = $this->User_model->add_user($insertData);
				if ($id != '') {
					$this->session->set_flashdata('success', 'User details added successfully.');
					$this->index('refresh');
				} else {
					$this->session->set_flashdata('error', 'Error while adding the member information.');
					$this->index('refresh');
				}*/
					
                if ($this->csrfprotect->validate_both_tokens($this->input->post('token_id'))) {

                    if (time() >= $this->session->userdata('token_expire')) {

                        $this->csrfprotect->reset_session_token();
                        $this->session->set_flashdata('error', 'Error! Please reload page again to perform this action');
                        $this->index('refresh');
                    } else {

                        //perform transaction as required.
						$duplicate_check = $this->User_model->CheckEmailExist(trim($this->input->post('email')));
						
						if($duplicate_check==1){
							
							$this->session->set_flashdata('error_duplicate', 'Error! Given email:  ' .$this->input->post('email'). '  already exits, please try another.');
							$this->index('refresh');
							
						}else{
							$id = $this->User_model->add_user($insertData);
							if ($id != '') {
								$this->session->set_flashdata('success', 'User details added successfully.');
								$this->index('refresh');
							} else {
								$this->session->set_flashdata('error', 'Error while adding the member information.');
								$this->index('refresh');
							}
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
        }
    }

    /**
     * Validate the password
     *
     * @param string $password
     *
     * @return bool
     */
    public function password_check($password = '') {
		
		//validates session, is that user is valid or not.
		$this->common->is_logged_in_user_authorized();
		
		//check url is accessing function by browser.
		//$this->common->check_url_access_by_browser();
		
        $password = trim($password);
        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';

        if (empty($password)) {
            $this->form_validation->set_message('password_check', 'The {field} name field is required.');

            return FALSE;
        }

        if (preg_match_all($regex_lowercase, $password) < 1) {
            $this->form_validation->set_message('password_check', 'The {field} field must be at least one lowercase letter.');

            return FALSE;
        }

        if (preg_match_all($regex_uppercase, $password) < 1) {
            $this->form_validation->set_message('password_check', 'The {field} field must be at least one uppercase letter.');

            return FALSE;
        }

        if (preg_match_all($regex_number, $password) < 1) {
            $this->form_validation->set_message('password_check', 'The {field} field must have at least one number.');

            return FALSE;
        }

        if (preg_match_all($regex_special, $password) < 1) {
            $this->form_validation->set_message('password_check', 'The {field} field must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>§~'));

            return FALSE;
        }

        if (strlen($password) < 8) {
            $this->form_validation->set_message('password_check', 'The {field} field must be at least 5 characters in length.');

            return FALSE;
        }

        if (strlen($password) > 15) {
            $this->form_validation->set_message('password_check', 'The {field} field cannot exceed 15 characters in length.');

            return FALSE;
        }

        return TRUE;
    }
	
	
	
	public function user_reactivation_email($email, $id){
		
		if (!empty($email)) {
			/**
			 *  Author     : santhosh yelagandula
			 *  Description: get login user details
			 */
			$userdetails = $this->post->get_user_dtls_by_email_re($email);

			if(!empty($userdetails[0]->first_name)){
             $request_msg="Dear&nbsp;&nbsp;".$userdetails[0]->first_name;
			}else{
				$request_msg="Dear User";
			}
			$from     =  "vptrack@infosharesystems.com";
			$name_urs =  "User";
			$to       = $email;
			$name     = 'Cyber Threat Post';
			$cc       = "";
			$title    = "Message";
			$subject  = "Cyber Threat Post - Account Re-activation Email" ;
			$prep_url_privacy  = base_url()."posts/Privacypolicy";
			
			$pwd_dtls = $this->User_model->get_all_pwd($id);
			$password = $pwd_dtls['password'];
			$prep_url 		   = "https://www.varutra.com/ctp/";
			
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
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">Greetings!</p>
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">We&apos;d like to let you know that your account registered with the email address: <a href="mailto:'.$email.'" style="text-decoration:none !important;">'.$email.'</a> has been re-activated.</p>
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">
														Please visit CTP to read more about recent cyber threats : <a href="'.$prep_url.'">'.$prep_url.'</a>.<br>
														<br>
													</p>
													
												
													<p style="color:#455056; font-size:15px;line-height:1.5; margin:0;margin-top:12px;">For any queries or any feedback, please contact with us at:<br> <a href="mailto:ctp-back3nd@infosharesystems.com" style="text-decoration:none !important;">ctp-back3nd@infosharesystems.com </a><br>
													<br><strong>Never disclose your confidential information such as Username, Password, OTP etc. to anyone.</strong>
													</p>
												</td>
											</tr>
											
											<tr>
												<td style="padding:0 35px;"><p style="color: #455056;font-size: 15px;margin: 0;margin-top: 48px;">Best Regards,</p>
												<p style="color: #455056;font-size: 15px;line-height: 1.5;margin: 0;">Team Cyber Threat Post
												</p></td>
											</tr>
										<tr>
											<td style="height:20px;">&nbsp;</td>
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

    /**
     * @Auther:Aarti
     * function  update specific users
     * @return array
     */
    public function update_user() {
		
		//validates session, is that user is valid or not.
		$this->common->is_logged_in_user_authorized();
		
		//check url is accessing function by browser.
		//$this->common->check_url_access_by_browser();
		
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email', array('required' => 'The email name field is required.', 'valid_email' => 'Please enter valid email.'));
        //$this->form_validation->set_rules('role_name', 'Role Name', 'required', array('required' => 'The role name field is required.'));
//        if ($this->input->post('role_name') != "Client User") {
//            $this->form_validation->set_rules('password', 'Password', 'differs[email]|callback_password_check');
//        }
        //@ROOP COMMENTED above line

        if ($this->form_validation->run() == FALSE) {
            $result['validaion_error'] = array(
                'email' => form_error('email'),
                'role_name' => form_error('role_name'),
              //  'password' => form_error('password'),
            );
            $this->session->set_flashdata($result, 'Error while adding the member information.');
            $this->index();
        } else {
            $id = filter_var($this->input->post('user_id'), FILTER_SANITIZE_NUMBER_INT);
            $id = filter_var($this->input->post('user_id'), FILTER_VALIDATE_INT);
			
            if ($this->input->post('status') == 'active') {
                $userStatus = 1;
				
				//calling a email when user is reactivating from ADMIN.
				$this->user_reactivation_email(htmlspecialchars(trim($this->input->post('email'))), $id);
				
            } else {
                $userStatus = 0;
            }
            if ($this->input->post('role_name') == 'Admin') {
                $role_id = "1";    //admin  
               // $pwd = trim($this->input->post('password'));
            } else {
                $role_id = "2"; //UserClient
               // $pwd = "";
            }
            $email = htmlspecialchars(trim($this->input->post('email')));
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            $role = htmlspecialchars(trim($this->input->post('role_name')));
            $role = preg_replace("/[^a-zA-Z]+/", "", $role);
          //  $old_pwd = $this->User_model->get_all_pwd($id);
//            if (!empty($old_pwd)) {
//                $this->session->set_userdata('session_pwd', $old_pwd['password']);
//                $old_passwords = json_decode($old_pwd['password_history']);
//            } else {
//                $this->session->set_flashdata('error', 'Invalid attempt!Something went wrong.');
//                redirect('CreateUser');
//            }

            /**
             * if(session password (pwd stored in edit mode) == posted pwd update the same record.
             * same json will update in db i.e password_history
             * ElSE
             * @first condition : old password(stored password) should not equal to new edited post password
             *  if (in_array($pwd, $old_passwords))  == true
             * else  
             *    second condition : check whether old password count equal to 3 or not
             *         if (count($old_passwords) == 3) { 
             *             thired condition :append push posted password in to old password
             *                    array_push($old_passwords,$pwd);
             * 
             *                     
             * 
             */
//            if ($pwd != "") {
//                if ($this->session->userdata('session_pwd') == $pwd) {
//                    $pwd = $pwd;
//                } else {
//
//                    /*   @ROOP COMMENTED THAT */
//                    if (count($old_passwords) == 3) {
//                        $remove_pwd = array_pop($old_passwords);
//                        if (in_array($pwd, $old_passwords)) {
//                            $pwd = $remove_pwd;
//                            $this->session->set_flashdata('error', 'Matching with old password.');
//                            redirect('CreateUser');
//                        } elseif (!in_array($pwd, $old_passwords)) {
//                            array_shift($old_passwords);
//                            array_splice($old_passwords, 1, 0, $remove_pwd);
//                        }
//                        if (count($old_passwords) <= 3) {
//                            array_push($old_passwords, $pwd);
//                        }
//                    } elseif (count($old_passwords) <= 3) {
//                        array_push($old_passwords, $pwd);
//                    }
//                }
//            }
            $update_data = array(
                
                'email_id' => $email,
                'status' => $userStatus,
               // 'password' => $pwd, //@ROOP ADDED THAT LINE.
               //   'password_history' => json_encode($old_passwords),
                'modified_by' => $this->session->userdata('user_id') ? $this->session->userdata('user_id') : "",
                'modified_date' => date('Y-m-d H:i:s'),
            );

            /* CSRF code added by ROOP  */
            if (!empty($this->session->userdata('user_email_id')) && $this->input->server('REQUEST_METHOD') == 'POST') {

                if ($this->csrfprotect->validate_both_tokens($this->input->post('token_id'))) {

                    if (time() >= $this->session->userdata('token_expire')) {

                        $this->csrfprotect->reset_session_token();
                        $this->session->set_flashdata('error', 'Error! Please reload page again to perform this action');
                        $this->index('refresh');
                    } else {

                        //perform transaction as required.			
                        $data_success = $this->User_model->Update($update_data, $id);
                        if ($data_success === TRUE) {
                            $this->session->set_flashdata('success', 'User details updated successfully.');
                            $this->index('refresh');
                        } else {
                            $this->session->set_flashdata('error', 'Error while adding the member information.');
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
        }
    }

    /** @Author: Aarti
     * Description: function used for is email id exist or not
     * 24-07-2020
     * *
     */
    public function CheckEmailExist() {
		
		//validates session, is that user is valid or not.
		$this->common->is_logged_in_user_authorized();
		
		//check url is accessing function by browser.
		//$this->common->check_url_access_by_browser();
		
        $email = htmlspecialchars($this->input->post('email'));
        if (!empty($email)) {
				if (!empty($result)) {
					$result = $this->User_model->CheckEmailExist($email);
					if (!empty($result) && $result == '1') {
						echo false;
						exit;
					} else {
						echo true;
						exit;
					}
				}else{
					$this->session->set_flashdata('error', 'Invalid attempt! Something went wrong.');
					redirect('CreateUser');
				}
        } else {
            echo '<br /><br /><br /><br /><br />';
            echo '<p style="width:90%; border: 1px red solid; color:black; margin-left:50px; margin-top:10px;margin-bottom:10px; margin-right:50px; padding:40px;">404 - (access not allowed).</p>';
            die();
        }
    }
	
	/**
     * @Auther:ROOP KISHOR MISHRA
     * function Change Password or Reset
     * @return View
     */
    public function resetpassword() {
		
		//validates session, is that user is valid or not.
		$this->common->is_logged_in_user_authorized();
        //$this->csrfprotect->generate_token();
        $this->load->view('Admin/reset_password');
    }
		
	/**
		 * @Auther:ROOP
		 * function: Check Old password is it existing in database
		 * @return View
     */
	public function checkOldPassword()
    {        
        $old_pwd  = $this->input->post('oldpwd');		
        $old_pwd  = preg_replace("/[^a-zA-Z1-9!@#$%&*?]+/", "", $old_pwd);
        $result   = $this->validateOldPassword($this->session->userdata('user_id'), $old_pwd);		
        if ($result == '1') {
            echo false;
            exit;
        } else {
            echo true;
            exit;
        }
    }
	
	/**
		 * @Auther:ROOP
		 * function: Validate password from db password for current logged in user.
		 * @return View
     */
	 
	public function validateOldPassword($user_id, $old_pwd)
    {
        if ($this->session->userdata('user_email_id'))
		{			
			$get_pwd = $this->User_model->get_all_pwd($user_id);			
			if($this->encryptdecrypt->decryptPassword($get_pwd['password']) == $old_pwd){			
				return 1;
			}else{
				return 0;
			}
        } else {
            return "unauthorized access";
            exit;
        }
    }
	
	/**
		 * @Auther:ROOP
		 * function: Used for updating password details.
		 * @return View
     */
	 
    public function updatePassword(){
		
		$cur_email    = $this->session->userdata('user_email_id');
		$cur_password = $this->input->post('renewpwd');
		
		if(!empty($cur_email) && !empty($cur_password)){
			
			$update_data = array(
								 'password' => $this->encryptdecrypt->encryptPassword($cur_password)
								);						
				$data_success = $this->User_model->update_users_password($update_data, $cur_email);
				$this->session->set_flashdata('success_forgotpassword', 'Password changed successfully');
				echo json_encode(array('success' => true, 'messages' => 'Password changed successfully'));
				
		}else{
			
			$this->session->set_flashdata('success_forgotpassword', 'Error! something went wrong.');				
			echo json_encode(array('error' => true, 'messages' => 'Error! something went wrong while updating your password.'));
		}
	}

}

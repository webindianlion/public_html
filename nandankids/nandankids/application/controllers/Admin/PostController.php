<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/** @Author: Aarti
 * Description: Post Controller
 */
class PostController extends CI_Controller {

    public function __construct() {
		
        parent::__construct();
		
		$this->load->model('emailer_model');
        $this->load->library("PHPMailer_Library");
        $this->load->library('EncryptDecrypt');
        $this->load->model('Admin/Post_model');
        $this->load->library("csrfprotect");
        $this->load->library("common");
    }

    /**
     * @Auther:Aarti
     * function load view post
     * @return View
     */
    public function index() {
		
        $this->load->view('Admin/post_list');    
	}

    /**
     * @Auther:Aarti
     * function load view post
     * @return View
     */
	 
    public function create() {
		
        //$this->csrfprotect->generate_token();		
		$this->session->set_userdata('post_title', $this->input->post('post_title'));
		$this->session->set_userdata('post_desc', $this->input->post('post_desc'));
		$this->session->set_userdata('cve_id', $this->input->post('cve_id'));	
		$this->session->set_userdata('recommendation', $this->input->post('post_recomd'));		
        $this->load->view('Admin/post_view');
    }
	

    /**
     * @Auther:Aarti
     * function load edit view post
     * @return View	 
     */
    public function edit() {
		
		//validates session, is that user is valid or not.
		$this->common->is_logged_in_user_authorized();
		
        $this->csrfprotect->generate_token();
        $post_id = $this->uri->segment(2);
        $post_id = $this->encryptdecrypt->DecryptThis($post_id);
        $post_id = filter_var($post_id, FILTER_SANITIZE_NUMBER_INT);
        $post_id = filter_var($post_id, FILTER_VALIDATE_INT);
        $data['post_details'] = $this->Post_model->get_post_details_by_id($post_id);
        
		$data['post_id'] = $post_id;
		
         if (!empty($data['post_details'][0])) {
            //$data['post_id'] = $id;
            $this->load->view('Admin/edit_post', $data);
        } else {
            $this->session->set_flashdata('error', 'Invalid attempt! Something went wrong.');
            redirect('CreatePost');
        }
    }

	
	/**
     * @Auther  : ROOP
     * function : load edit view post
	 * DESC     : Sending Email notification for all Active of Users, when new POST getting Published.
     * @return  : 
     */
	public function post_publish_notification_mail_to_users($post_id){
		
		
		if (!empty($post_id)) {
			
			$get_post_dtls = $this->common->get_post_details_by_id($post_id);	
			
			$from          =  "vptrack@infosharesystems.com";
			$phone_post    =  $this->input->post('phone');
            $phone_post    =  !empty($phone_post) ? '<br /><b>Phone :</b>' . $phone_post : '';
            //perform transaction as required, sending emails to all type of active users.
            $get_active_usr = $this->common->get_all_active_users();            
            $prep_post_dtl_url = base_url()."posts/postDetails/".$this->encryptdecrypt->EncryptThis($post_id);
            $prep_post_desc    = $get_post_dtls->post_description;
            $title=$get_post_dtls->post_title; 
            $flag=$this->common->cron($get_active_usr,$prep_post_dtl_url,$prep_post_desc,$title);
            //print_r($flag);exit;
            return $flag;
		}
	
	}
	
    /**
     * @Auther:Aarti
     * function load edit view post
     * @return View
     */
    public function publish() {
		//validates session, is that user is valid or not.
		$this->common->is_logged_in_user_authorized();
		
        $post_id = $this->encryptdecrypt->DecryptThis($this->input->get('post_id'));
        $post_id = filter_var($post_id, FILTER_SANITIZE_NUMBER_INT);
        $post_id = filter_var($post_id, FILTER_VALIDATE_INT);

        /* code added by roop */
        if (!empty($this->session->userdata('user_email_id'))) {
			 
			 /**
			 * @Author:santhosh
			* page excution time 
			*/
			ini_set('max_execution_time',4000);
			
			/* Sendind email to all active Users */
			$this->post_publish_notification_mail_to_users($post_id);
			
			
            $data_success = $this->Post_model->publish_post($post_id);
            if ($data_success === TRUE) {
                
				$this->session->set_flashdata('success', 'Post publish successfully.');
				redirect(base_url() . 'ManagePost');
                //$this->index();
            } else {
                $this->session->set_flashdata('error', 'something went wrong.');
				redirect(base_url() . 'ManagePost');
                //$this->index();
            }
        } else {
            $this->csrfprotect->reset_session_token();
            $this->session->set_flashdata('error', 'Error! Unauthorised access of application, some thing went wrong');
            $this->index('refresh');
        }

        /* $data_success = $this->Post_model->publish_post($post_id);
          if ($data_success === TRUE) {
          $this->session->set_flashdata('success', 'Post publish successfully.');
          $this->index();
          } else {
          $this->session->set_flashdata('error', 'something went wrong.');
          $this->index();
          } */
    }

    /**
     * @Auther:Aarti
     * function load edit view post
     * @return View
     */
    public function Delete() {
		
		//validates session, is that user is valid or not.
		$this->common->is_logged_in_user_authorized();
		
        $post_id = $this->input->post('post_id');
        $post_id = filter_var($post_id, FILTER_SANITIZE_NUMBER_INT);
        $post_id = filter_var($post_id, FILTER_VALIDATE_INT);

        /* code added by roop for CSRF */
        if (!empty($this->session->userdata('user_email_id'))) {

            $data_success = $this->Post_model->delete_post($post_id);
            if ($data_success === TRUE) {
                $validator = array('success' => true, 'messages' => 'Post Deleted successfully');
            } else {
                $validator = array('error' => false, 'messages' => 'something went wrong.');
            }
            echo json_encode($validator);
        } else {
            $this->csrfprotect->reset_session_token();
            $this->session->set_flashdata('error', 'Error! Unauthorised access of application, some thing went wrong');
            $this->index('refresh');
        }

        /*
          $data_success = $this->Post_model->delete_post($post_id);
          if ($data_success === TRUE) {
          $validator = array('success' => true, 'messages' => 'Post Deleted successfully');
          } else {
          $validator = array('error' => false, 'messages' => 'something went wrong.');
          }
          echo json_encode($validator);
         */
    }

    /**
     * @Auther:Aarti
     * function retrieve get all post details
     * @return array
     */
    public function get_all_post() {
		
		//validates session, is that user is valid or not.
		$this->common->is_logged_in_user_authorized();
		
        $data_fetch = $this->Post_model->get_all_post();
		
		if (!empty($data_fetch)) {
			
			$output = array('data' => array());
			$x = 1;
			foreach ($data_fetch as $row) {
				$id = filter_var($row->post_id, FILTER_SANITIZE_NUMBER_INT);
				$id = filter_var($row->post_id, FILTER_VALIDATE_INT);
				$id = $this->encryptdecrypt->EncryptThis($id);
				$actionButton = '<div class="btn-group" style="margin-right:10px;"><a href=' . base_url() . 'EditPost/' . $id . '  title="Edit"><span class="datatable-span"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
				</span></a></div>';
				if ($row->IsPublished == 0) {
					$actionButton .= '<div class="btn-group" style="margin-right:10px;"><a href=' . base_url() . 'publishPost?post_id=' . $id . ' title="Publish"><span class="datatable-span"><i class="fa fa-share-square-o" aria-hidden="true"></i></span></a></div>';
				} else {
					$actionButton .= '<div class="btn-group"> <button type="button" class="btn-sm btn-cust pbmb0-none removePost" data-toggle="modal" title="Delete" data-target="#deletePosttModal"  id='.html_escape($row->post_id).' title="Delete"><span class="datatable-span"><i class="fa fa-trash-o" aria-hidden="true"></i>
				</span>
				</button></div>';
				}
				$output['data'][] = array($x, $row->post_title, $row->affected_platforms, $row->attack_type, $row->business_type, $actionButton);
				$x++;
			}
			$this->db->close();
			echo json_encode($output);
			
		}else{
			
			$this->session->set_flashdata('error', 'Invalid attempt! Something went wrong.');
            redirect('CreatePost');
		}
    }

    /**
     * @Auther:Aarti
     * function load view post
     * @return View
     */
    public function create_post() {

		//validates session, is that user is valid or not.
		$this->common->is_logged_in_user_authorized();
		
        $this->load->helper("security");
        if ($this->input->post('save1') == "save") {
            $IsPublished = 0;
            $published_by = $this->session->userdata('user_email_id');
            $created_by = $this->session->userdata('user_id');
        } else {
            $IsPublished = 1;
            $published_by = $this->session->userdata('user_email_id');
            $created_by = $this->session->userdata('user_id');
        }
        $this->form_validation->set_rules('post_title', 'The Name field is required', 'required');
        $this->form_validation->set_rules('post_desc', 'The Address field is required', 'required');
        // $this->form_validation->set_rules('post_ref_url[]', 'The Contact field is required', 'required');
        // $this->form_validation->set_rules('post_end_date', 'The Active field is required', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Error while adding the post information.');
            $this->index();
        } else {
//            filter_var($post_desc, FILTER_SANITIZE_STRING);

            $filename = $this->security->sanitize_filename($_FILES["post_image"]["name"], TRUE);
            $filename = trim($_FILES["post_image"]["name"]);

            $filename = filter_var($filename, FILTER_SANITIZE_STRING);
            $filename = strip_tags($filename);
            $filename = htmlspecialchars($filename);
            /**
			 * @Author:santhosh
			 * string replace function
			 */
            $filename=str_replace(" ","-",$filename);
            /*end*/
            $x = substr($filename, 0, strrpos($filename, '.'));

            //print_r('s->'.$x.'@old='.$filename);exit;
			
			//  Commented code related to image name. By ROOP
            if (preg_match('/[!@#$%^&*()\_=+{};:,<.>§~]/', $x)) {
                $this->session->set_flashdata('error', 'Upload valid file name.');
                redirect('CreatePost');
//                return FALSE;
            }
            if (isset($_FILES["post_image"]["name"])) {
                $config['upload_path'] = './Resources/img/';
                $config['allowed_types'] = 'jpg|jpeg|JPG|JPEG';
                $config['max_size'] = 5000;
                $config['file_name'] = $filename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
				
                if (!$this->upload->do_upload('post_image') && !empty($this->input->post('post_title'))) {
                    
					
					$this->session->unset_userdata('post_title');
					$this->session->unset_userdata('post_desc');
					$this->session->unset_userdata('cve_id');
					$this->session->unset_userdata('recommendation');
					$this->session->set_userdata('post_title', $this->input->post('post_title'));
					$this->session->set_userdata('post_desc', $this->input->post('post_desc'));
					$this->session->set_userdata('cve_id', $this->input->post('cve_id'));
					$this->session->set_userdata('recommendation', $this->input->post('post_recomd'));

					//$array = $this->upload->display_errors();
					$array   = "File not uploading due to: size more than 5 MB, or fileformat is not correct, or file you are trying to upload  is corrupted"  ;
					$this->session->set_flashdata('error_post_img', $array);
					$this->load->view('Admin/post_view');
                    //$this->session->set_flashdata('error', $array);
                    //$this->index();
                    return FALSE;
                }
                /**
				 * @Author:santhosh
			 	* ramdom image name 
				*/
                    $file_info = $this->upload->data();
                    $filename_inc = $file_info['file_name']; 
                    /*end*/
            }
            $iocfile = $this->security->sanitize_filename($_FILES["ioc"]["name"], TRUE);

            if ($_FILES["ioc"]["name"]) {
                $config1['upload_path'] = './Resources/IOC/';
                $config1['allowed_types'] = 'xlsx';
                $config1['max_size'] = 5000;
                $config1['file_name'] = $iocfile;
                $this->upload->initialize($config1);
                $this->load->library('upload', $config1);
				
                if (!$this->upload->do_upload('ioc') && !empty($this->input->post('post_title'))) {
					
					$this->session->unset_userdata('post_title');
					$this->session->unset_userdata('post_desc');
					$this->session->unset_userdata('cve_id');
					$this->session->unset_userdata('recommendation');
					$this->session->set_userdata('post_title', $this->input->post('post_title'));
					$this->session->set_userdata('post_desc', $this->input->post('post_desc'));
					$this->session->set_userdata('cve_id', $this->input->post('cve_id'));
					$this->session->set_userdata('recommendation', $this->input->post('post_recomd'));
					
					//$array = $this->upload->display_errors();
					$array   = "File not uploading due to: size more than 5 MB, or fileformat is not correct, or file you are trying to upload  is corrupted"  ;
					$this->session->set_flashdata('error_ioc_file', $array);
					
					//echo $this->session->userdata('post_title');
					//die('YESSSS');
					$this->load->view('Admin/post_view');
					
					//redirect('CreatePost');
                    //$array = $this->upload->display_errors();
					//$array   = "File not uploadind due to: size more than 5 MB, or fileformat is not correct, or file you are trying to upload  is corrupted"  ;
                    //$this->session->set_flashdata('error', $array);
                    //$this->index();
                    return FALSE;
                }
            } else {
                $iocfile = "";
            }
            $arr = $this->input->post('post_ref_url');
            $new_arr = array();
            foreach ($arr as $key => $value) {
                array_push($new_arr, "URL" . $key);
            }
            $final_arr = array_combine($new_arr, $arr);
            if ($this->input->post('post_end_date')) {
                $post_end_date = date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('post_end_date'))));
            } else {
                $post_end_date = "";
            }
            if ($this->input->post('affected_platforms') == 'Other') {
                $affected_platforms = $this->input->post('aff_plat_other');
                $affected_platforms = filter_var($affected_platforms, FILTER_SANITIZE_STRING);
            } else {
                $affected_platforms = $this->input->post('affected_platforms');
                $affected_platforms = filter_var($affected_platforms, FILTER_SANITIZE_STRING);
            }
            if ($this->input->post('dist_method') == 'Other') {
                $dist_method = $this->input->post('dist_method_other');
                $dist_method = filter_var($dist_method, FILTER_SANITIZE_STRING);
            } else {
                $dist_method = $this->input->post('dist_method');
                $dist_method = filter_var($dist_method, FILTER_SANITIZE_STRING);
            }
            if ($this->input->post('attack_type') == 'Other') {
                $attack_type = $this->input->post('attack_type_other');
                $attack_type = filter_var($attack_type, FILTER_SANITIZE_STRING);
            } else {
                $attack_type = $this->input->post('attack_type');
                $attack_type = filter_var($attack_type, FILTER_SANITIZE_STRING);
            }
            if ($this->input->post('attack_source') == 'Other') {
                $attack_source = $this->input->post('attack_source_other');
                $attack_source = filter_var($attack_source, FILTER_SANITIZE_STRING);
            } else {
                $attack_source = $this->input->post('attack_source');
                $attack_source = filter_var($attack_source, FILTER_SANITIZE_STRING);
            }
            if ($this->input->post('region') == 'Others') {
                $region = $this->input->post('region_other');
                $region = filter_var($region, FILTER_SANITIZE_STRING);
            } else {
                $region = $this->input->post('region');
                $region = filter_var($region, FILTER_SANITIZE_STRING);
            }
            if ($this->input->post('business_type') == 'Others') {
                $business_type = $this->input->post('busi_other');
                $business_type = filter_var($business_type, FILTER_SANITIZE_STRING);
            } else {
                $business_type = $this->input->post('business_type');
                $business_type = filter_var($business_type, FILTER_SANITIZE_STRING);
            }
            if ($this->input->post('headline_flag') == 'on') {
                $headline_flag_hiddenvalue = 1;
            } else {
                $headline_flag_hiddenvalue = $this->input->post('headline_flag_hiddenvalue');
                $headline_flag_hiddenvalue = filter_var($headline_flag_hiddenvalue, FILTER_SANITIZE_NUMBER_INT);
                $headline_flag_hiddenvalue = filter_var($headline_flag_hiddenvalue, FILTER_VALIDATE_INT);
            }
            $post_title = $this->input->post('post_title');
            $post_title = filter_var($post_title, FILTER_SANITIZE_STRING);
            $cve_id = $this->input->post('cve_id');
            $cve_id = filter_var($cve_id, FILTER_SANITIZE_STRING);
            $post_desc = $this->input->post('post_desc');
            $post_desc = filter_var($post_desc, FILTER_SANITIZE_STRING);
            $post_recomd = $this->input->post('post_recomd');
            $post_recomd = filter_var($post_recomd, FILTER_SANITIZE_STRING);
            $insertData = array(
                'post_title' => trim($post_title),
                'post_description' => trim($post_desc),
                'cve_id' => trim($cve_id),
                'post_ref_url' => json_encode($final_arr),
                'post_recomd' => trim($post_recomd),
                'post_image' => $filename_inc,
                'ioc' => $_FILES["ioc"]["name"],
                'headline_end_date' => trim($post_end_date),
                'headline_enabled' => trim($headline_flag_hiddenvalue),
                'affected_platforms' => trim($affected_platforms),
                'dist_method' => trim($dist_method),
                'attack_type' => trim($attack_type),
                'attack_source' => trim($attack_source),
                'region' => trim($region),
                'post_created_date' => date('Y-m-d H:i:s'),
                'business_type' => trim($business_type),
                'IsPublished' => $IsPublished,
                'published_by' => $published_by,
                'created_by' => $created_by,
                'publish_date' => date('Y-m-d H:i:s'),
            );
            /* CSRF code added by ROOP  */
            $id = '';
            if (!empty($this->session->userdata('user_email_id')) && $this->input->server('REQUEST_METHOD') == 'POST') {
                if ($this->csrfprotect->validate_both_tokens($this->input->post('token_id'))) {
                    if (time() >= $this->session->userdata('token_expire')) {

                        $this->csrfprotect->reset_session_token();
                        $this->session->set_flashdata('error', 'Error! Please reload page again to perform this action');
                        $this->index('refresh');
                    } else {
                        //perform transaction as required.			
                        $id = $this->Post_model->add_post($insertData);
						
						//sending email notification, if Request for adding post is published.
						if(!empty($IsPublished) && $IsPublished == 1 && !empty($id))
						{
							/**
								* @Author:santhosh
								* page excution time 
								*/
							ini_set('max_execution_time',4000);
							/* Sendind email to all active Users, passing post_id as parameter */
							$this->post_publish_notification_mail_to_users($id);

						}
						if (!empty($id)) {
							if ($id != '') {
								$this->session->set_flashdata('success', 'Post details added successfully.');
								/**
								* @Author:santhosh
								* page refresh
								*/
								$this->index('refresh');
							} else {
								$this->session->set_flashdata('error', 'Error while adding the post information.');
								$this->index();
							}
						}else{
							
							$this->session->set_flashdata('error', 'Invalid attempt! Something went wrong.');
							redirect('CreatePost');
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
     * @Auther:Aarti
     * function  update specific Post
     * @return array
     */
    public function update_post() {
		
		//validates session, is that user is valid or not.
		$this->common->is_logged_in_user_authorized();
		
        $this->load->helper("security");
        $id = filter_var($this->input->post('post_id'), FILTER_SANITIZE_NUMBER_INT);
        $id = filter_var($this->input->post('post_id'), FILTER_VALIDATE_INT);
        
		/* validating entire */
		$final_arr  = array();		
		$new_arr 	= array();		
		$arr 		= $this->input->post('post_ref_url');
        if(!empty($arr)){
				foreach ($arr as $key => $value) {
				array_push($new_arr, "URL" . $key);
			}
			$final_arr = array_combine($new_arr, $arr);
		}
        //date replace  santhosh
		$orgDate=$this->input->post('post_end_date');
        //$orgDate=strtotime($orgDate);
        if(count(explode("/",$orgDate))>1){
            $nav=explode('/',$orgDate);
            $date=$nav[2].'-'.$nav[0].'-'.$nav[1];//str_replace('/', '-', $orgDate);
        }else{
            $nav=explode('/',$orgDate);
            $date = $nav[2].'/'.$nav[0].'/'.$nav[1];//str_replace('-', '/', $orgDate);
        }
        $post_end_date = @$date;//date('d-m-Y', strtotime($date));
        //end
        if(!empty($_FILES["post_image"]["name"])){
            $filename = $this->security->sanitize_filename($_FILES["post_image"]["name"], TRUE);
            //$filename = $_FILES["post_image"]["name"];
        } else {
            $filename = $this->security->sanitize_filename($this->input->post('old_post_img'), TRUE);
            //$filename = $this->input->post('old_post_img');
        }
        /**
		* @Author:santhosh
		* string replace function 
		*/
        $filename=str_replace(" ","-",$filename);
		//set upload file params.
        if(!empty($_FILES["post_image"]["name"])){
			
            $config2['upload_path']   = './Resources/img/';
            $config2['allowed_types'] = 'jpg|jpeg|JPG|JPEG';
            $config2['max_size']      = 5000;
            $config2['file_name']     = $filename;
            $this->load->library('upload', $config2);


			
            if (!$this->upload->do_upload('post_image')) {
				
                //$array = $this->upload->display_errors();
				$array   = "File not uploading due to: size more than 5 MB, or fileformat is not correct, or file you are trying to upload  is corrupted"  ;
				$this->session->set_flashdata('error_post_img', $array);
                redirect(base_url() . 'EditPost/'.$this->encryptdecrypt->EncryptThis($id));
            }
        }
		
		/**
		* @Author:santhosh
		* ramdom image name 
		*/
		if(!empty($_FILES["post_image"]["name"])){
			$x = substr($filename, 0, strrpos($filename, '.'));
        if (preg_match('/[!@#$%^&*()\_=+{};:,<.>§~]/', $x)) {
                $this->session->set_flashdata('error', 'Upload valid file name.');
                redirect('CreatePost');
//                return FALSE;
            }

		$filename=str_replace(" ","-",$filename);
		$file_info = $this->upload->data();
        $filename_inc = $file_info['file_name'];	
		}else{
         $filename_inc=$filename;
		}
		        /*end*/
        //IOC POST data, param setting
        if(!empty($_FILES["ioc"]["name"])) {			
            $iocfile = $this->security->sanitize_filename($_FILES["ioc"]["name"], TRUE);
        } else {
            $iocfile = $this->security->sanitize_filename($this->input->post('old_ioc'), TRUE);
        }
		
		
        if(!empty($_FILES["ioc"]["name"])) {
			
            $config['upload_path'] = './Resources/IOC/';
            $config['allowed_types'] = 'xlsx';
            $config['max_size'] = 5000;
            $config['file_name'] = $iocfile;
            $this->load->library('upload', $config);
            $this->upload->initialize($config); // initialized config.
			
            if (!$this->upload->do_upload('ioc')) {				
                $array   = "File not uploading due to: size more than 5 MB, or fileformat is not correct, or file you are trying to upload  is corrupted"  ;
				$this->session->set_flashdata('error_ioc_file', $array);
				redirect(base_url() . 'EditPost/'.$this->encryptdecrypt->EncryptThis($id));
            }
        }
		
        if ($this->input->post('affected_platforms') == 'Other') {
            $affected_platforms = $this->input->post('aff_plat_other');
            $affected_platforms = filter_var($affected_platforms, FILTER_SANITIZE_STRING);
        } else {
            $affected_platforms = $this->input->post('affected_platforms');
            $affected_platforms = filter_var($affected_platforms, FILTER_SANITIZE_STRING);
        }
        if ($this->input->post('dist_method') == 'Other') {
            $dist_method = $this->input->post('dist_method_other');
            $dist_method = filter_var($dist_method, FILTER_SANITIZE_STRING);
        } else {
            $dist_method = $this->input->post('dist_method');
            $dist_method = filter_var($dist_method, FILTER_SANITIZE_STRING);
        }
        if ($this->input->post('attack_type') == 'Other') {
            $attack_type = $this->input->post('attack_type_other');
            $attack_type = filter_var($attack_type, FILTER_SANITIZE_STRING);
        } else {
            $attack_type = $this->input->post('attack_type');
            $attack_type = filter_var($attack_type, FILTER_SANITIZE_STRING);
        }
        if ($this->input->post('attack_source') == 'Other') {
            $attack_source = $this->input->post('attack_source_other');
            $attack_source = filter_var($attack_source, FILTER_SANITIZE_STRING);
        } else {
            $attack_source = $this->input->post('attack_source');
            $attack_source = filter_var($attack_source, FILTER_SANITIZE_STRING);
        }
        if ($this->input->post('region') == 'Others') {
            $region = $this->input->post('region_other');
            $region = filter_var($region, FILTER_SANITIZE_STRING);
        } else {
            $region = $this->input->post('region');
            $region = filter_var($region, FILTER_SANITIZE_STRING);
        }
        if ($this->input->post('business_type') == 'Others') {
            $business_type = $this->input->post('busi_other');
            $business_type = filter_var($business_type, FILTER_SANITIZE_STRING);
        } else {
            $business_type = $this->input->post('business_type');
            $business_type = filter_var($business_type, FILTER_SANITIZE_STRING);
        }
        $post_title = $this->input->post('post_title');
        $post_title = filter_var($post_title, FILTER_SANITIZE_STRING);
        $post_desc = $this->input->post('post_desc');
        $cve_id = $this->input->post('cve_id');
        $cve_id = filter_var($cve_id, FILTER_SANITIZE_STRING);
        $post_desc = filter_var($post_desc, FILTER_SANITIZE_STRING);
        $post_recomd = $this->input->post('post_recomd');
        $post_recomd = filter_var($post_recomd, FILTER_SANITIZE_STRING);
        //flag condition santhosh
        if($this->input->post('headline_flag')=='on'){
        $headline_enabled_c=1;
        }else{
            $headline_enabled_c=0;
        }
        $date1 = $post_end_date; 
        $date2 = @date('Y-m-d'); 
        // Use comparison operator to  
        // compare dates 
        if ($date1 > $date2) {
            $headline_enabled_c=1; 
        }else{
        $headline_enabled_c=0; 
        }
        $update_data = array(
            'post_title' => trim($post_title),
            'post_description' => trim($post_desc),
            'cve_id' => trim($cve_id),
            'post_image' => $filename_inc,
            'ioc' => $iocfile,
            'post_ref_url' => json_encode($final_arr),
            'post_recomd' => trim($post_recomd),
            'headline_end_date' => trim($post_end_date),
            'headline_enabled' => trim($headline_enabled_c),
            'affected_platforms' => trim($affected_platforms),
            'dist_method' => trim($dist_method),
            'attack_type' => trim($attack_type),
            'attack_source' => trim($attack_source),
            'region' => trim($region),
            'business_type' => trim($business_type),
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
                    $data_success = $this->Post_model->Update($update_data, $id);
					
					//Condition added by ROOP.
					if (!empty($data_success)) {
					
						if ($data_success === TRUE) {
							$this->session->set_flashdata('success', 'Post details updated successfully.');
							$this->index();
						} else {
							$this->session->set_flashdata('error', 'Error while adding the member information.');
							$this->index();
						}
						
					}else{
						
						$this->session->set_flashdata('error', 'Invalid attempt! Something went wrong.');
						redirect('CreatePost');
						
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

        /* $data_success = $this->Post_model->Update($update_data, $id);
          if ($data_success === TRUE) {
          $this->session->set_flashdata('success', 'Post details updated successfully.');
          $this->index();
          } else {
          $this->session->set_flashdata('error', 'Error while adding the member information.');
          $this->index();
          } */
    }

}

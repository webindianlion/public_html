<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nandanhome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 function __construct() {

        parent::__construct();
		
        $this->load->library('session');
    }
	 
	
	public function index()
	{
		$this->load->helper('URL');
		$data['contact'] = array(
				'email' => $this->input->post('email'),
				'name' => $this->input->post('name'),
				'surname' => $this->input->post('surname'),
				'phone' => $this->input->post('phone'),
				'message' => $this->input->post('message')
			);
		
		//echo base_url(). "BASE_URLs";
		//die;
		//$this->load->view('template/header', $data);	
		$this->load->view('frontend/nandan_home', $data);
	}
}

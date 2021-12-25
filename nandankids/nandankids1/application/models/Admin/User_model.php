<?php

/** @Author: Aarti
 * Description: Post_model CI_Model
 */
class User_model extends CI_Model {

    /**
     * @Auther:Aarti
     * function used for post insert method
     * @return array
     */
    public function add_user($create_data) {
        $this->db->insert('user', $create_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    /**
     * @Auther:Aarti
     * function used for post insert method
     * @return array
     */
    public function get_all_user() {
        $this->db->order_by('user_id', 'DESC');
        $query = $this->db->get('user');
        return $query->result();
    }

    /**
     * @Auther:Aarti
     * function used for get user details by using the userid
     * @return array
     */
    public function get_user_details_by_id($user_id) {
        $this->db->where('user_id', $user_id);
        $response = $this->db->get('user');
        return $response->result();
    }

    /**
     * @Auther:Aarti
     * function used for  update specific manageusers details
     * @return array
     */
    public function Update($update_data, $id) {
        $this->db->where('user_id', $id);
        $query = $this->db->update('user', $update_data);
        return $query;
    }

    /** @Author: Aarti
     * Description: function used for is email id exist or not
     * 24-07-2020
     */
    public function CheckEmailExist($email) {
        $this->db->select('email_id');
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        $this->db->where('email_id', $email);
        $this->db->from('user');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return '1';
        } else {
            return '0';
        }
    }
	
	/** @Author: ROOP
     * Description: Function used for check old password details.
     */
	public function checkOldPassword($user_id, $old_pwd)
    {

        /*if (!empty($_SESSION['email'])) {
            $curUsrEmail['emailId'] = $_SESSION['email'];
            $curUsrEmail['username'] = $_SESSION['username'];
        } else {
            $curUsrEmail = $this->session->userdata();
        }*/
		
        if ($this->session->userdata('user_email_id'))
		{			
			$get_pwd = $this->get_all_pwd($user_id);
			/*echo '<pre>';
			print_r($get_pwd);			
			//validate password first.
			$old_pwd_param = $old_pwd; 
			echo "OLD=" .$old_pwd."OLD=";
			echo $this->encryptdecrypt->decryptPassword($get_pwd['password']);
			//echo "=NEXT=";
			echo $this->encryptdecrypt->decryptPassword($old_pwd_param);
			die('DONEEEEEE');
			*/
			
			if($this->encryptdecrypt->decryptPassword($old_pwd) == $this->encryptdecrypt->decryptPassword($get_pwd['password'])){				
				return '1';
				
			}else{
				return '0';
				exit;
			}
			
            $this->db->select('password');
            $this->db->from('user');

            $user_id = filter_var($user_id, FILTER_VALIDATE_INT);
            $curUsrE = $this->session->userdata('user_email_id');
            $old_pwd = preg_replace("/[^a-zA-Z1-9!@#$%&*?]+/", "", $old_pwd);

            $this->db->where('user_id', $user_id);
            $this->db->where('email_id', $curUsrE);
            //$this->db->where('password', $old_pwd);
            $query = $this->db->get();
			
			//echo $this->db->last_query();
			//die('YESSSS');
			
            if ($query->num_rows() > 0) {
                return '1';
            } else {
                return '0';
            }
        } else {
            return "unauthorized access";
            exit;
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
     * @Auther:Aarti
     * function all password using user id
     * @return array
     */
    public function get_all_pwd($id) {
        $this->db->select('password_history,password');
        $this->db->where('user_id', $id);
        $this->db->from('user');
        $query = $this->db->get();
        return $query->row_array();
    }

}

?>
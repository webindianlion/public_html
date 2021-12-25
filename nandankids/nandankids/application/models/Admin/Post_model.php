<?php

/** @Author: Aarti
 * Description: Post_model CI_Model
 */
class Post_model extends CI_Model {

    /**
     * @Auther:Aarti
     * function used for post insert method
     * @return array
     */
    public function add_post($create_data) {
        $this->db->insert('postings_details', $create_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    /**
     * @Auther:Aarti
     * function used for post insert method
     * @return array
     */
    public function get_all_post() {
        $this->db->order_by('post_id', 'DESC');
        $query = $this->db->get('postings_details');
        return $query->result();
    }

    /**
     * @Auther:Aarti
     * function used for get post details by using the postid
     * @return array
     */
    public function get_post_details_by_id($post_id) {
        $this->db->where('post_id', $post_id);
        $response = $this->db->get('postings_details');
        return $response->result();
    }

    /**
     * @Auther:Aarti
     * function used for  update specific post details
     * @return array
     */
    public function Update($update_data, $id) {
        $this->db->where('post_id', $id);
        $query = $this->db->update('postings_details', $update_data);
        return $query;
    }

    /**
     * @Auther:Aarti
     * function used for  delete post details
     * @return array
     */
    public function delete_post($post_id) {
        if ($post_id != '') {
            $post_id = filter_var($post_id, FILTER_SANITIZE_NUMBER_INT);  //a
            $post_id = filter_var($post_id, FILTER_VALIDATE_INT);
            $this->db->set('IsDeleted','1');
            $this->db->set('IsPublished','0');    
            $this->db->where('post_id', $post_id);
            $query = $this->db->update('postings_details');
            return $query;
        }
    }
/**
     * @Auther:Aarti
     * function used for  delete post details
     * @return array
     */
    public function publish_post($post_id) {
        if ($post_id != '') {
            $post_id = filter_var($post_id, FILTER_SANITIZE_NUMBER_INT);  //a
            $post_id = filter_var($post_id, FILTER_VALIDATE_INT);
            $this->db->set('IsDeleted','0');
            $this->db->set('IsPublished','1');
            $this->db->set('publish_date',date("Y-m-d h:i:s"));    
            $this->db->where('post_id', $post_id);
            $query = $this->db->update('postings_details');
            return $query;
        }
    }

}

?>
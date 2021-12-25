<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Emailer_model extends CI_Model {

    public function getEmailDetailsById($id) {
        $ci = & get_instance();
        $ci->db->select('*');
        $ci->db->from('email_template');
        $ci->db->where("id", $id);
        $ci->db->where("status", 'Active');
        $query = $ci->db->get();
        return $result = $query->result_array();
    }

    public function sendemail($from, $to, $cc, $title, $subject, $body, $name, $u_name, $u_pass) {
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
            $mail->SMTPAuth = true;
            $mail->Username = 'vptrack@infosharesystems.com';
//            $mail->Password = 'Tracker98*7';
            //$mail->Password = 'N3XP87n>SP';
            $mail->Password = '!ZuX;ZPg5s';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->charset = 'utf-8';
            $mail->mailtype = 'html';
            //Recipients
            $mail->setFrom($from, 'CTP Admin');
            $mail->addAddress($to, $name);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            if ($mail->send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return  false;
        }
    }

    public function sendemailForgot($from, $to, $cc, $title, $subject, $body, $name, $u_name, $u_pass) {
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
            $mail->SMTPAuth = true;
            $mail->Username = 'vptrack@infosharesystems.com';
//            $mail->Password = 'Tracker98*7';
            //$mail->Password = 'N3XP87n>SP';
            $mail->Password = '!ZuX;ZPg5s';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->charset = 'utf-8';
            
            $mail->mailtype = 'html';
            //Recipients
            $mail->setFrom($from, 'CTP Admin');
            $mail->addAddress($to, $name);
            
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            if ($mail->send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            
            return false;
        }
    }
 

}

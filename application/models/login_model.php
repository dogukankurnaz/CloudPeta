<?php
class Login_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }

    public function verify($user, $pass){
        $res = $this->db->get_where('uye', array('username' => $user, 'password' => $pass));
        if ($res->result_id->num_rows === 1){
            return $res->result_array();
        }else{
            return false;
        }
    }


    public function setAuthCode($id, $code){
        $this->db->where('id', $id)->update('uye', array('authcode' => $code));
    }

    public function signup($data){
        return $this->db->insert('uye', $data);
    }

    public function forgotpassword($mail, $data){
        return $this->db->where('mail', $mail)->update('uye', $data);
    }

    public function checkMail($mail){
        $check = $this->db->get_where('uye', array('mail' => $mail));
        if ($check->result_id->num_rows === 1){
            return true;
        }else{
            return false;
        }
    }
}
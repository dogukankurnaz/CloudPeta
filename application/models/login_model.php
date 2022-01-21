<?php
class Login_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }

    //----------------------Üye girişi---------------------------------
    public function verify($user, $pass){
        $res = $this->db->get_where('uye', array('username' => $user, 'password' => $pass));
        if ($res->result_id->num_rows === 1){
            return $res->result_array();
        }else{
            return false;
        }
    }
    //------------------------END--------------------------------------


    //--------------------Session--------------------------------------
    public function setAuthCode($id, $code){
        $this->db->where('id', $id)->update('uye', array('authcode' => $code));
    }
    //------------------------END--------------------------------------

    //-------------------Üye olma--------------------------------------
    public function signup($data){
        return $this->db->insert('uye', $data);
    }
    //------------------------END--------------------------------------

    //----------------Şifre güncellemesi-------------------------------
    public function forgotpassword($mail, $data){
        return $this->db->where('mail', $mail)->update('uye', $data);
    }
    //------------------------END--------------------------------------

    //-------------Kullanıcının Mailini kontrol ediyoruz.--------------
    public function checkMail($mail){
        $check = $this->db->get_where('uye', array('mail' => $mail));
        if ($check->result_id->num_rows === 1){
            return true;
        }else{
            return false;
        }
    }
    //------------------------END--------------------------------------
}
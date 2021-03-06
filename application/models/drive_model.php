<?php

class Drive_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getFiles($id)
    {
        return $this->db->order_by('filename', 'ASC')->get_where('files', array('userID' => $id))->result_array();
    }

    public function getFile($id)
    {
        return $this->db->get_where('files', array('id' => $id))->result_array()[0];
    }

    public function delete($id)
    {
        return $this->db->delete('files', array('id' => $id));
    }


    public function insert($data)
    {
        return $this->db->insert('files', $data);
    }

    public function getUserAuth($id)
    {
        $res = $this->db->get_where('uye', array('id' => $id))->result_array()[0]['authcode'];
        return $res;
    }

    public function changepass($ID, $pass)
    {
        return $this->db->where('id', $ID)->update('uye', array('password' => $pass));
    }
}
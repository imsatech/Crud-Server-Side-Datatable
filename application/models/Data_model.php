<?php

class Data_model extends CI_Model
{

    public function getData($table){
        // select * from table;
        $data  = $this->db->get($table);
        return $data->result_array();
    }

    public function insertData($tbl,$val){
        $this->db->insert($tbl,$val);
    }

    public function deleteData($tbl,$con){
        $this->db->where($con);
        $this->db->delete($tbl);
    }

    public function getSelectedData($tbl,$con){
        $this->db->where($con);
        $data = $this->db->get($tbl);
        return $data->result_array();

    }

    public function updateData($tbl,$data,$con){
        $this->db->where($con);
        $this->db->update($tbl,$data);
    }

    function __construct()
    {
        parent::__construct();
    }

    function Get_data($tbl)
    {
        $query = $this->db->get($tbl);
        return $query->result_array();
    }

    function Get_data_order($tbl, $tblcol, $type)
    {
        $this->db->order_by($tblcol, $type);
        $query = $this->db->get($tbl);
        return $query->result_array();
    }

    function Insert_data($tbl, $data)
    {
        $this->db->insert($tbl, $data);
    }

    function Insert_data_id($tbl, $data)
    {
        $this->db->insert($tbl, $data);
        $query = $this->db->insert_id();
        return $query;
    }

    function Insert_batch_data($tbl,$data){
        $this->db->insert_batch($tbl,$data);
    }

    function Update_batch_data($tbl,$data,$fld){
        $this->db->update_batch($tbl,$data, $fld);
    }

    function Update_data($tbl, $con, $data)
    {
        $this->db->where($con);
        $this->db->update($tbl, $data);
    }

    function Update_data_in($tbl, $con, $data,$fd)
    {
        $this->db->where_in($fd,$con);
        $this->db->update($tbl, $data);
    }

    function Deleta_data($tbl, $con)
    {
        $this->db->where($con);
        $this->db->delete($tbl);
    }

    function Get_data_all($tbl, $con)
    {
        $this->db->where($con);
        $query = $this->db->get($tbl);
        return $query->result_array();
    }

    function Get_data_order_all($tbl, $con, $tblcol, $type)
    {
        $this->db->order_by($tblcol, $type);
        $this->db->where($con);
        $query = $this->db->get($tbl);
        return $query->result_array();
    }

    function Get_data_one($tbl, $con)
    {
        $this->db->where($con);
        $res = $this->db->get($tbl);
        $query = $res->result_array();
        return $query[0];
    }

    function Custome_query($str)
    {
        $query = $this->db->query($str);
        return $query->result_array();
    }

    function Custome_query_exe($str)
    {
        $query = $this->db->query($str);
    }

    function change_status($id, $table)
    {
        $this->db->where($table . '_id', $id);
        $ans = $this->db->get($table);
        $data = $ans->result_array();
        if ($data[0]['status'] == 0)
            $info['status'] = 1;
        else
            $info['status'] = 0;
        $this->db->where($table . '_id', $id);
        $this->db->update($table, $info);
        return $info['status'];
    }

    function Process()
    {
        $username = $this->security->xss_clean($this->input->post('user_id'));
        $password = $this->security->xss_clean($this->input->post('password'));
        $this->db->where('user_id', $username);
        $this->db->where('password', $password);
        $this->db->where('status', 'A');
        $query = $this->db->get('gst_admin');
        $res = $query->result_array();
        if (count($res) == 1) {
            $row = $query->row();
            $data = array(
                'user_d' => $row->user_id,
                'password' => $row->password,
                'username' => $row->username
            );
            $this->session->set_userdata($data);
            return true;
        }
        return false;
    }

}
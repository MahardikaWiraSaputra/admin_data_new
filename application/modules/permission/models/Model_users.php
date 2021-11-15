<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_users extends CI_Model{

   function list_groups(){
        $this->db->select('a.id, a.`name`, a.description, a.`code`');
        $this->db->from('groups AS a');
        $query = $this->db->get(); 
        return $query->result();
    }

    function list_data($status,$like,$limit,$offset) {
        $this->db->select('a.id, a.username, a.active, a.full_name, a.email, group_concat(c.name) AS group_name');
        $this->db->from('users AS a');
        $this->db->join('users_groups AS b','a.id = b.user_id','LEFT');
        $this->db->join('groups AS c','b.group_id = c.id','LEFT');
        if($status)
        {
            $this->db->where('a.active', $status);
        }
        if($like)
        {
            $this->db->like('username' ,$like);
            $this->db->or_like('full_name' ,$like);
            $this->db->or_like('email' ,$like);
        }
        $this->db->group_by('a.id');
        $this->db->order_by('a.id','DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    function list_total($status,$like)
    {
        $this->db->select('count(*) as count');
        $this->db->from('users AS a');
        $this->db->join('users_groups AS b','a.id = b.user_id','LEFT');
        $this->db->join('groups AS c','b.group_id = c.id','LEFT');
        if($status)
        {
            $this->db->where('a.active', $status);
        }
        if($like)
        {
            $this->db->like('username' ,$like);
            $this->db->or_like('full_name' ,$like);
            $this->db->or_like('email' ,$like);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function tambah($data) {
        $this->db->trans_begin();
        $input  = array(
            'username' => $data['username'],
            'unique_us' => $data['username'],
            'password' =>  $data['password'],
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'active' => $data['active'],
            'CREATED' => $data['CREATED'],
            'CREATED_BY' => $data['CREATED_BY']
        );
        $this->db->insert('users', $input);
        
        $users_id = $this->db->insert_id();
        $result = array();
        foreach($data['groups'] as $key => $val) { 
            $result[] = array(
                'user_id'   => $users_id,
                'group_id'   => $data['groups'][$key]
            );
        } 
        $this->db->insert_batch('users_groups', $result);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } 
        else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    function detail($id) {
        $this->db->select('a.id, a.username, a.active, a.full_name, a.email, group_concat(c.name) AS group_name');
        $this->db->from('users AS a');
        $this->db->join('users_groups AS b','a.id = b.user_id','LEFT');
        $this->db->join('groups AS c','b.group_id = c.id','LEFT');
        $this->db->where('a.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function update($data) {
        $this->db->trans_begin();
        if ($data['password']) {
            $input  = array(
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'active' => $data['active'],
                'MODIFIED' => $data['MODIFIED'],
                'MODIFIED_BY' => $data['MODIFIED_BY']
            );
        }
        else {
            $input  = array(
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'active' => $data['active'],
                'MODIFIED' => $data['MODIFIED'],
                'MODIFIED_BY' => $data['MODIFIED_BY']
            );            
        }
        $this->db->where('id', $data['id']);
        $this->db->update('users', $input);
        
        $this->db->delete('users_groups', array('user_id' => $data['id']));
        $result = array();
        foreach($data['groups'] as $key => $val) { 
            $result[] = array(
                'user_id'   => $data['id'],
                'group_id'   => $data['groups'][$key],
            );
        } 
        $this->db->insert_batch('users_groups', $result);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } 
        else {
            $this->db->trans_commit();
            return TRUE;
        }
    }    

    function delete($id) {  
        $this->db->trans_begin();
        $this->db->delete('users', array('id' => $id));
        $this->db->delete('users_groups', array('user_id' => $id));
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } 
        else {
            $this->db->trans_commit();
            return TRUE;
        }
    } 

}
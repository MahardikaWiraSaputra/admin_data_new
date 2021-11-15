<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_group_permissions extends CI_Model{

   function list_group(){
        $this->db->select('a.id, a.`name`, a.description, a.`code`');
        $this->db->from('groups AS a');
        $query = $this->db->get(); 
        return $query->result();
    }

    function list_data($status,$like,$limit,$offset) {
        $this->db->select('a.perm_id,a.perm_key, a.perm_name, a.super_admin,a.admin_kab,a.admin_skpd');
        $this->db->from('v_group_permissions AS a');
        if($like)
        {
            $this->db->like('perm_key' ,$like);
            $this->db->or_like('perm_name' ,$like);
        }
        $this->db->order_by('a.perm_id','ASC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get(); 
        return $query->result_array();
    }

    function list_total($status,$like) {
        $this->db->select('count(*) as count');
        $this->db->from('v_group_permissions AS a');
        if($like)
        {
            $this->db->like('perm_key' ,$like);
            $this->db->or_like('perm_name' ,$like);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function tambah($data) {
        $this->db->trans_begin();
        $input  = array(
            'perm_key' => $data['perm_key'],
            'perm_name' => $data['perm_name']
        );
        $this->db->insert('permissions', $input);
        
        $perm_id = $this->db->insert_id();
        $result = array();
        foreach($data['groups'] as $key => $val) { 
            if (!isset($data['value'][$key])) {
                $data['value'][$key] = '0';
            }
            $result[] = array(
                'perm_id'   => $perm_id,
                'group_id'   => $data['groups'][$key],
                'value'   => $data['value'][$key],
                'created_at' => $data['created_at']
            );
        } 
        $this->db->insert_batch('groups_permissions', $result);
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
        $this->db->select('a.perm_id, a.perm_key, a.perm_name, a.super_admin,a.admin_kab,a.admin_skpd');
        $this->db->from('v_group_permissions AS a');
        $this->db->where('a.perm_id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function update($data) {
        $this->db->trans_begin();
        $input  = array(
            'perm_key' => $data['perm_key'],
            'perm_name' => $data['perm_name']
        );
        $this->db->where('id', $data['perm_id']);
        $this->db->update('permissions', $input);
        
        $this->db->delete('groups_permissions', array('perm_id' => $data['perm_id']));
        $result = array();
        foreach($data['groups'] as $key => $val) { 
            if (!isset($data['value'][$key])) {
                $data['value'][$key] = '0';
            }
            $result[] = array(
                'perm_id'   => $data['perm_id'],
                'group_id'   => $data['groups'][$key],
                'value'   => $data['value'][$key],
                'created_at' => $data['created_at']
            );
        } 
        $this->db->insert_batch('groups_permissions', $result);
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
        $this->db->delete('permissions', array('id' => $id));
        $this->db->delete('groups_permissions', array('perm_id' => $id));
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
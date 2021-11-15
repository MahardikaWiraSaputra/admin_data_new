<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_master_users extends CI_Model{
   
   function dropdown_skpd(){
        $this->db->select('a.ID, a.KODE_SKPD, a.NAMA_SKPD');
        $this->db->from('m_skpd AS a');
        $query = $this->db->get()->result_array();
        // $data['all'] = 'Semua Urusan';
        foreach ($query as $row) {
            $data[$row['ID']] = $row['KODE_SKPD'].' - '.$row['NAMA_SKPD'];
        }       
        return $data;
    }

   function list_groups(){
        $this->db->select('
            a.id,
            a.`name`,
            a.description,
            a.`code`
        ');
        $this->db->from('groups AS a');
        $query = $this->db->get()->result_array(); 
        return $query;
    }

    function get_list_total($where,$like){
        $this->db->select('count(*) as count');
        $this->db->from('users AS a');
        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_data($where,$like,$limit,$offset) {
        $this->db->select('
            a.id,
            a.unique_us,
            a.username,
            a.email,
            a.active,
            a.full_name,
            a.company,
            a.phone,
            c.name,
            c.description,
            GROUP_CONCAT(c.name) AS GROUPS,
            d.KODE_SKPD,
            d.NAMA_SKPD
        ');
        $this->db->from('users AS a');
        $this->db->join('users_groups AS b', 'a.id = b.user_id', 'LEFT');
        $this->db->join('groups AS c', 'b.group_id = c.id', 'LEFT');
        $this->db->join('m_skpd AS d', 'a.skpd_id = d.ID', 'LEFT');
        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        $this->db->group_by('a.id');
        $this->db->order_by('a.id', 'DESC');
        return $this->db->get()->result_array();
    }


    function tambah_users($username, $password, $fullname, $skpd, $email, $telp, $groups, $created, $created_by) {
        $this->db->trans_start();
        $data  = array(
            'username' => $username,
            'password' => $password,
            'full_name' => $fullname,
            'skpd_id' => $skpd,
            'email' => $email,
            'phone' => $telp,
            'active' => '1',
            'CREATED' => $created,
            'CREATED_BY' => $created_by
        );
        $this->db->insert('users', $data);
        
        $users_id = $this->db->insert_id();
        $result = array();
        foreach($groups as $key => $val) { 
            $result[] = array(
                'user_id'   => $users_id,
                'group_id'   => $groups[$key]
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

    function detail_users($id){
        $this->db->select('
            a.id,
            a.unique_us,
            a.username,
            a.password,
            a.skpd_id,
            a.email,
            a.active,
            a.full_name,
            a.company,
            a.phone,
            GROUP_CONCAT(c.id) AS GROUPS
        ');
        $this->db->from('users AS a');
        $this->db->join('users_groups AS b', 'a.id = b.user_id', 'LEFT');
        $this->db->join('groups AS c', 'b.group_id = c.id', 'LEFT');
        $this->db->where('a.id', $id);
        $this->db->group_by('a.id');
        return $this->db->get()->row_array();
    }

    function update_users($id, $username, $password, $fullname, $skpd, $email, $telp, $groups, $modified, $modified_by) {
        $this->db->trans_start();
        $data  = array(
            'username' => $username,
            'password' => $password,
            'full_name' => $fullname,
            'skpd_id' => $skpd,
            'email' => $email,
            'phone' => $telp,
            'MODIFIED' => $modified,
            'MODIFIED_BY' => $modified_by   
        );
        $this->db->where('id',$id);
        $this->db->update('users',$data);

        $this->db->delete('users_groups', array('user_id' => $id));

        $result = array();
        foreach($groups as $key => $val) { 
            $result[] = array(
                'user_id'   => $id,
                'group_id'   => $groups[$key]
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

    function delete_users($id){
        $this->db->trans_start();
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
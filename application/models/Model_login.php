<?php
class Model_login extends CI_Model{
    
    //cek login
	function signing($username,$password){
		$query=$this->db->query("SELECT * FROM users WHERE username='$username' AND password=MD5('$password')");
		return $query->row_array();
	}
}

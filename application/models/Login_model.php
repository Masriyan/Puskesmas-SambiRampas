<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function getUser($where="")
	{
		$query = "SELECT * FROM user $where";
		$stmt = $this->db->query($query);
		return $stmt->result();
	}

}

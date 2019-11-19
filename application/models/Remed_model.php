<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Remed_model extends CI_Model {

	var $table = 'tbl_detail_remed';
	var $column_order = array('no_kartu_rekam_medis','keluhan','nama_poli','create_at',null); //set column field database for datatable orderable
	var $column_search = array('no_kartu_rekam_medis','keluhan','nama_poli','create_at'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id_detail_remed' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();

	}

	public function get_data_ha($where)
	{
		# code...
		$stmt = $this->db->query("SELECT * FROM tbl_ha $where");
		return $stmt->row();
	}

	private function _get_dataRemed_query()
	{
		$this->db->from($this->table);
		$this->db->JOIN('tbl_poli', 'tbl_poli.id_poli=tbl_detail_remed.id_poli');

		$i = 0;

		foreach ($this->column_search as $item) // loop column
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{

				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_dataRemed()
	{
		$this->_get_dataRemed_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_dataRemed_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$stmt = $this->db->insert($this->table, $data);
		if($stmt){
			return true;
		}else {
			return false;
		}
	}


	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$this->db->delete($this->table,$id);
	}

	public function getDetDataRemed($where)
	{
		return $this->db->query("SELECT * FROM tbl_detail_remed INNER JOIN tbl_poli WHERE tbl_detail_remed.id_poli=tbl_poli.id_poli $where ORDER BY id_detail_remed DESC");
	}
}

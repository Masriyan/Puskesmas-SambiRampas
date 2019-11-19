<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ha extends CI_Controller {

	var $table = 'tbl_ha';
	// var $column_order = array('nama_ha',null); //set column field database for datatable orderable
	// var $column_search = array('nama_ha'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	// var $order = array('id_ha' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ha_model','ha');
	}

	public function index()
	{
		$this->load->view('layout/header');
		$this->load->view('content/ha');
		$this->load->view('layout/footer');
	}

	public function ajax_list()
	{
		$list = $this->ha->get_datatables();
		$data = array();
		// $no = $_POST['start'];
		$no = 0;
		foreach ($list as $ha) {
			$no+=1;
			$row = array();
			$row[] = $no;
			$row[] = $ha->nama_ha;

			//add html for action
			$row[] = "<a class='btn btn-sm btn-primary' href='javascript:;' title='Edit' onclick='edit_ha(".$ha->id_ha.")'><i class='glyphicon glyphicon-pencil'></i> Edit</a>
				  <a class='btn btn-sm btn-danger' href='javascript:;' title='Hapus' onclick='delete_ha(".$ha->id_ha.")'><i class='glyphicon glyphicon-trash'></i> Delete</a>";

			$data[] = $row;
			// print_r($data[]);
		}

		$output = array(
						// "draw" => $_POST['draw'],
						"recordsTotal" => $this->ha->count_all(),
						"recordsFiltered" => $this->ha->count_filtered(),
						"data" => $data,
				);
		//output to json format
		// print_r($output);
		echo json_encode($output);
	}

	public function ajax_edit()
	{
		# code...
		$where = "WHERE id_ha=".$_POST['id'];
		$stmt = $this->ha->get_data_ha($where);
		echo json_encode($stmt);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'nama_ha' => $_POST['nama']   //$this->input->post('nama')
			);
		$insert = $this->ha->save($data);
		echo json_encode(array("status" => true));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'nama_ha' => $_POST['nama']
			);
		$this->ha->update(array('id_ha' => $_POST['id']), $data);
		echo json_encode(array("status" => true));
	}

	public function ajax_delete()
	{
		# code...

		$this->ha->delete(array('id_ha' => $_POST['id']));
		echo json_encode(array('status' => true ));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = true;

		if($_POST['nama'] == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama harus Diisi.';
			$data['status'] = false;
		}

		if($data['status'] === false)
		{
			echo json_encode($data);
			exit();
		}
	}


}

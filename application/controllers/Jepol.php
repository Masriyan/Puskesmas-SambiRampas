<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jepol extends CI_Controller {

	var $table = 'tbl_poli';
	// var $column_order = array('nama_ha',null); //set column field database for datatable orderable
	// var $column_search = array('nama_ha'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	// var $order = array('id_ha' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->model('jepol_model','jpl');
	}

	public function index()
	{
		$this->load->view('layout/header');
		$this->load->view('content/jepol');
		$this->load->view('layout/footer');
	}

	public function ajax_list()
	{
		$list = $this->jpl->get_datatables();
		$data = array();
		// $no = $_POST['start'];
		$no = 0;
		foreach ($list as $ha) {
			$no+=1;
			$row = array();
			$row[] = $no;
			$row[] = $ha->nama_poli;

			//add html for action
			$row[] = "<a class='btn btn-sm btn-primary' href='javascript:;' title='Edit' onclick='edit_jepol(".$ha->id_poli.")'><i class='glyphicon glyphicon-pencil'></i> Edit</a>
					<a class='btn btn-sm btn-danger' href='javascript:;' title='Hapus' onclick='delete_jepol(".$ha->id_poli.")'><i class='glyphicon glyphicon-trash'></i> Delete</a>";

			$data[] = $row;
			// print_r($data[]);
		}

		$output = array(
						// "draw" => $_POST['draw'],
						"recordsTotal" => $this->jpl->count_all(),
						"recordsFiltered" => $this->jpl->count_filtered(),
						"data" => $data,
				);
		//output to json format
		// print_r($output);
		echo json_encode($output);
	}

	public function ajax_edit()
	{
		# code...
		$where = "WHERE id_poli=".$_POST['id'];
		$stmt = $this->jpl->get_data_jpl($where);
		echo json_encode($stmt);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'nama_poli' => $_POST['nama']   //$this->input->post('nama')
			);
		$insert = $this->jpl->save($data);
		echo json_encode(array("status" => true));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'nama_poli' => $_POST['nama']
			);
		$this->jpl->update(array('id_poli' => $_POST['id']), $data);
		echo json_encode(array("status" => true));
	}

	public function ajax_delete()
	{
		# code...

		$this->jpl->delete(array('id_poli' => $_POST['id']));
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

	public function dataJePol()
	{
		# code...
		$data = array();
		$stmt = $this->jpl->getDataJePol();
		$data[] = "<option value='0'>- Pilih Poli -</option>";

		foreach ($stmt as $jp) {
			# code...
			$data[] = "<option value=".$jp->id_poli.">".$jp->nama_poli."</option>";
		}
		echo json_encode($data);
	}

	public function detDataJePol()
	{
		# code...
		$data = array();
		$where=$_POST['id'];
		$stmt = $this->jpl->getDataJePol();
		$data[] = "<option value='0'>- Pilih -</option>";

		foreach ($stmt as $jp) {
			# code...
			if($jp->id_poli==$where){
				$data[] = "<option value=".$jp->id_poli." selected>".$jp->nama_poli."</option>";
			}else {
				$data[] = "<option value=".$jp->id_poli.">".$jp->nama_poli."</option>";
			}
		}
		//
		echo json_encode($data);
	}

}

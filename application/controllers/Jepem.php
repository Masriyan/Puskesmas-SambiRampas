<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jepem extends CI_Controller {

	var $table = 'tbl_pembayaran';
	// var $column_order = array('nama_pembayaran',null); //set column field database for datatable orderable
	// var $column_search = array('nama_pembayaran'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	// var $order = array('id_pembayaran' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->model('jepem_model','jpm');
	}

	public function index()
	{
		$this->load->view('layout/header');
		$this->load->view('content/jepem');
		$this->load->view('layout/footer');
	}

	public function ajax_list()
	{
		$list = $this->jpm->get_datatables();
		$data = array();
		// $no = $_POST['start'];
		$no = 0;
		foreach ($list as $ha) {
			$no+=1;
			$row = array();
			$row[] = $no;
			$row[] = $ha->nama_pembayaran;

			//add html for action
			$row[] = "<a class='btn btn-sm btn-primary' href='javascript:;' title='Edit' onclick='edit_jepem(".$ha->id_pembayaran.")'><i class='glyphicon glyphicon-pencil'></i> Edit</a>
				  <a class='btn btn-sm btn-danger' href='javascript:;' title='Hapus' onclick='delete_jepem(".$ha->id_pembayaran.")'><i class='glyphicon glyphicon-trash'></i> Delete</a>";

			$data[] = $row;
			// print_r($data[]);
		}

		$output = array(
						// "draw" => $_POST['draw'],
						"recordsTotal" => $this->jpm->count_all(),
						"recordsFiltered" => $this->jpm->count_filtered(),
						"data" => $data,
				);
		//output to json format
		// print_r($output);
		echo json_encode($output);
	}

	public function ajax_edit()
	{
		# code...
		$where = "WHERE id_pembayaran=".$_POST['id'];
		$stmt = $this->jpm->get_data_jpm($where);
		echo json_encode($stmt);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'nama_pembayaran' => $_POST['nama']   //$this->input->post('nama')
			);
		$insert = $this->jpm->save($data);
		echo json_encode(array("status" => true));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'nama_pembayaran' => $_POST['nama']
			);
		$this->jpm->update(array('id_pembayaran' => $_POST['id']), $data);
		echo json_encode(array("status" => true));
	}

	public function ajax_delete()
	{
		# code...

		$this->jpm->delete(array('id_pembayaran' => $_POST['id']));
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

	public function dataJePem()
	{
		# code...
		$data = array();

		$stmt = $this->jpm->getDataJePem();
		$data[] = "<option value='0'>- Pilih -</option>";

		foreach ($stmt as $jp) {
			# code...
			$data[] = "<option value=".$jp->id_pembayaran.">".$jp->nama_pembayaran."</option>";
		}
		//
		echo json_encode($data);
		// return $data;
		// echo $stmt->row();
	}

	public function detDataJePem()
	{
		# code...
		$data = array();
		$where=$_POST['id'];
		$stmt = $this->jpm->getDataJePem();
		$data[] = "<option value='0'>- Pilih -</option>";

		foreach ($stmt as $jp) {
			# code...
			if($jp->id_pembayaran==$where){
				$data[] = "<option value=".$jp->id_pembayaran." selected>".$jp->nama_pembayaran."</option>";
			}else {
				$data[] = "<option value=".$jp->id_pembayaran.">".$jp->nama_pembayaran."</option>";
			}
		}
		//
		echo json_encode($data);
		// return $data;
		// echo $stmt->row();
	}

}

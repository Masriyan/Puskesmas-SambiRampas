<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien extends CI_Controller {
  public function __construct()
  {
    # code...
    parent::__construct();
    $this->load->model('pasien_model','psn');
  }

  private function _validate()
  {
    $data = array();
    $data['error_string'] = array();
    $data['inputerror'] = array();
    $data['status'] = true;

    if($_POST['nokk'] == '')
    {
      $data['inputerror'][] = 'nokk';
      $data['error_string'][] = 'No KK harus Diisi.';
      $data['status'] = false;
    }

    if($_POST['nama'] == '')
    {
      $data['inputerror'][] = 'nama';
      $data['error_string'][] = 'Nama harus Diisi.';
      $data['status'] = false;
    }

    if($_POST['noTelp'] == '')
    {
      $data['inputerror'][] = 'noTelp';
      $data['error_string'][] = 'No Telephone harus Diisi.';
      $data['status'] = false;
    }

    if($_POST['alamat'] == '')
    {
      $data['inputerror'][] = 'alamat';
      $data['error_string'][] = 'Alamat harus Diisi.';
      $data['status'] = false;
    }

    if($data['status'] === false)
    {
      echo json_encode($data);
      exit();
    }
  }

  public function getDetDataPasien()
  {
    $idPs = $_POST['idPsn'];
    $where = "WHERE no_pasien=".$idPs;
    $stmt = $this->psn->getDetPasien($where);
    echo json_encode($stmt);
  }

  public function getDetPasien()
  {
    # code...
    $idRm = $_POST['idRm'];
    $where = "WHERE no_kartu_rekam_medis=".$idRm;
    $stmt = $this->psn->getDetPasien($where);
    echo json_encode($stmt);
  }

  public function ajax_list()
  {
    $stmt = $this->psn->get_dataPasien();
    $data = array();
    $no = 0;

    foreach ($stmt as $r) {
      $no+=1;
      $row = array();
      $row[] = $no;
      $row[] = $r->no_pasien;
      $row[] = $r->nama_pasien;
      $row[] = $r->nama_pembayaran;
      $row[] = $r->no_telephon;
      $row[] = "
        <a class='btn btn-sm btn-info' href='javascript:;' title='Add' onclick='add_remed(".$r->no_kartu_rekam_medis.")'><i class='fa fa-plus'></i></a>
        <a class='btn btn-sm btn-success' href='javascript:;' title='Detail' onclick='detail_remed(".$r->no_kartu_rekam_medis.")'><i class='fa fa-align-justify'></i></a>
        <a class='btn btn-sm btn-warning' href='javascript:;' title='Edit' onclick='edit_pasien(".$r->no_kartu_rekam_medis.")'><i class='fa fa-pencil'></i></a>
        <a class='btn btn-sm btn-danger' href='javascript:;' title='Delete' onclick='deletePasRm(".$r->no_kartu_rekam_medis.")'><i class='fa fa-trash'></i></a>
      ";
      $data[] = $row;
    }

    $output = array(
      "recordsTotal" => $this->psn->count_all(),
      "recordsFiltered" => $this->psn->count_filtered(),
      "data" => $data,
    );

    echo json_encode($output);
  }

  public function addPasien()
  {
    $_POST['tgl_daftar'] = date("Y-m-d");
    $this->_validate();
		$data = array(
      'no_pasien' => $_POST['noPas'],   //$this->input->post('nama')
      'no_kartu_rekam_medis' => $_POST['noRm'],   //$this->input->post('nama')
      'no_kk' => $_POST['nokk'],   //$this->input->post('nama')
      'nama_pasien' => $_POST['nama'],   //$this->input->post('nama')
      'tempat_lahir' => $_POST['temLa'],   //$this->input->post('nama')
      'tanggal_lahir' => $_POST['tangLa'],   //$this->input->post('nama')
      'jenis_kelamin' => $_POST['jk'],   //$this->input->post('nama')
      'id_pembayaran' => $_POST['jp'],   //$this->input->post('nama')
      'no_telephon' => $_POST['noTelp'],   //$this->input->post('nama')
      'alamat' => $_POST['alamat'],   //$this->input->post('nama')
			'create_at' => $_POST['tgl_daftar']   //$this->input->post('nama')
		);
		$insert = $this->psn->save($data);
		echo json_encode(array("status" => true));
  }

  public function updatePasien()
  {
    $this->_validate();
    $where = array(
      'no_pasien' => $_POST['noPas'],   //$this->input->post('nama')
    );
		$data = array(
      'no_kartu_rekam_medis' => $_POST['noRm'],   //$this->input->post('nama')
      'no_kk' => $_POST['nokk'],   //$this->input->post('nama')
      'nama_pasien' => $_POST['nama'],   //$this->input->post('nama')
      'tempat_lahir' => $_POST['temLa'],   //$this->input->post('nama')
      'tanggal_lahir' => $_POST['tangLa'],   //$this->input->post('nama')
      'jenis_kelamin' => $_POST['jk'],   //$this->input->post('nama')
      'id_pembayaran' => $_POST['jp'],   //$this->input->post('nama')
      'no_telephon' => $_POST['noTelp'],   //$this->input->post('nama')
      'alamat' => $_POST['alamat']   //$this->input->post('nama')
		);
		$insert = $this->psn->update($where,$data);
		echo json_encode(array("status" => true));
  }
}

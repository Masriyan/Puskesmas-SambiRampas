<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Remed extends CI_Controller {
  public function __construct()
  {
    # code...
    parent::__construct();
    $this->load->model('remed_model','rm');
    $this->load->model('pasien_model','psn');
  }

  public function index()
  {
    # code...
    $this->load->view("layout/header");
    $this->load->view("content/remed");
    $this->load->view("layout/footer");
  }

  public function ajax_list()
  {
    # code...
    $stmt = $this->rm->get_dataRemed();
    $data = array();
    $no = 0;

    foreach ($stmt as $r) {
      # code...
      $no+=1;
      $row = array();
      $row[] = $no;
      $row[] = $r->no_kartu_rekam_medis;
      $row[] = $r->keluhan;
      $row[] = $r->nama_poli;
      $row[] = $r->create_at;
      $row[] = "
        <a class='btn btn-sm btn-success' href='javascript:;' title='Detail' onclick='detail_remed(".$r->id_detail_remed.")'><i class='fa fa-align-justify'></i></a>
        <a class='btn btn-sm btn-warning' href='javascript:;' title='Edit' onclick='edit_remed(".$r->id_detail_remed.")'><i class='fa fa-pencil'></i></a>
        <a class='btn btn-sm btn-danger' href='javascript:;' title='Delete' onclick='deleteRm(".$r->id_detail_remed.")'><i class='fa fa-trash'></i></a>
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

  public function randomNoPas()
  {
    # code...
    echo substr(mt_rand(), 0,6);
  }

  public function randomNoRm()
  {
    # code...
    echo substr(mt_rand(), 0,8);
  }

  public function addDetailRemed()
  {
    $_POST['tgl_daftar'] = date("Y-m-d");
    $data = array(
      'no_kartu_rekam_medis' => $_POST['noRm'],   //$this->input->post('nama')
      'keluhan' => $_POST['keluhan'],   //$this->input->post('nama')
      'id_poli' => $_POST['poli'],   //$this->input->post('nama')
			'create_at' => $_POST['tgl_daftar']   //$this->input->post('nama')
		);
		$stmt = $this->rm->save($data);
		echo json_encode(array("status" => true));
  }

  public function getDetRemed(){
    $where = "AND id_detail_remed=".$_POST['idDet'];
    $stmt = $this->rm->getDetDataRemed($where);
    echo json_encode($stmt->result());
  }

  public function detRemed(){
    $where = "AND no_kartu_rekam_medis=".$_POST['id'];
    $dataRm = array();
    $i=0;
		$stmt = $this->rm->getDetDataRemed($where);
		if($stmt->num_rows() > 0){
      foreach ($stmt->result() as $drm) {
        $dataRm[] = "<tr>
          <td>".($i+=1)."</td>
          <td>".$drm->keluhan."</td>
          <td>".$drm->nama_poli."</td>
          <td>".$drm->create_at."</td>
        </tr>";
  		}
      echo json_encode($dataRm);
    }else {
      echo json_encode("<tr><td colspan='4' class='text-center'>Data Masih Kosong</td></tr>");
    }
  }

  public function deleteRm()
  {
    $id = array('id_detail_remed' => $_POST['idDel']);
    $this->rm->delete($id);
    echo json_encode(array('status' => true ));
  }

  public function delete()
  {
    $id = array('no_kartu_rekam_medis' => $_POST['idDel']);
    $this->psn->delete($id);
    $this->rm->delete($id);
    echo json_encode(array('status' => true ));
  }

  public function updateRm()
  {
    // $this->_validate();
    $where = array(
      'id_detail_remed' => $_POST['noRm'],   //$this->input->post('nama')
    );
    $data = array(
      'keluhan' => $_POST['keluhan'],   //$this->input->post('nama')
      'id_poli' => $_POST['poli'],   //$this->input->post('nama')
    );
    $insert = $this->rm->update($where,$data);
    echo json_encode(array("status" => true));
  }
}

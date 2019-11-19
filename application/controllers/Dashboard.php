<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	var $table = 'tbl_ha';
	// var $column_order = array('nama_ha',null); //set column field database for datatable orderable
	// var $column_search = array('nama_ha'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	// var $order = array('id_ha' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_model','dashboard');
	}

	public function index()
	{
		$this->load->view('layout/header');
		$this->load->view('content/dashboard');
		$this->load->view('layout/footer');
	}

}

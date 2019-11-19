<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model','lmd');
	}

	public function index()
	{
		$this->load->view('content/login');
	}

	public function logOut()
	{
		session_start();
		session_destroy();
		header("location:".base_url());
	}

	public function setSess()
	{
		session_start();
		if (isset($_POST)) {
			# code...
			$_SESSION["user_session"] = $_POST['nama_user'];
			$_SESSION["status_login"] = "y";
			$_SESSION["ha"] = $_POST['id_ha'];
			// return true;
			echo json_encode(array('status' => true ));
		}else {
			echo json_encode(array('status' => false ));
			// return false;
		}
		// echo json_encode($_SESSION);
	}

	public function checkLogin(){
		$usr_sess = "";
	 	if(isset($_POST)){
		  $user_name = trim($_POST['username']);
		  $user_password = trim($_POST['password']);
		  $password = md5($user_password);
		  try{
				$query = "WHERE username IN('".$user_name."') AND password IN('".$password."')";
				$stmt = $this->lmd->getUser($query);
		  	if($stmt){
					foreach ($stmt as $row) {
						echo json_encode($row);
					}
		  	}else{
		    	echo json_encode($stmt); // wrong details
		  	}
		  }catch(PDOException $e){
		  	echo $e->getMessage();
		  }
		}
	}
}

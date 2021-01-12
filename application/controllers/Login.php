<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->db->query("SET sql_mode = '' ");
		
		switch ($this->session->userdata('hasLogin')) {
			case 'admin':
				redirect('admin/');
				break;
		}
	}

	public function index()
	{
		$this->load->view('login/index');
	}

	function cekLogin()
	{
		$keys = array_column($this->input->post('data'), 'name');
		$values = array_column($this->input->post('data'), 'value');

		$data = array_combine($keys, $values);

		$user = $data['username'];
		$pass = $data['password'];

		$cek = $this->db->get_where('tbl_admin', array('username' => $user, 'password' => $pass))->result_array();

		if (count($cek) > 0) {
			$res = true;
			$set = array("hasLogin" => 'admin', "nama" => $cek[0]['nama']);
			$this->session->set_userdata($set);
		} else {
			$res = false;
		}

		echo json_encode($res);
	}
}

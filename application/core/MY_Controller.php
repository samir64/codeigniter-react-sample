<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	protected $rules = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('util');
		$this->load->dbforge();
		$this->db->query('use ' . $this->db->database);

		$user = $this->session->userdata("user");
		if ((uri_string() !== "") && (uri_string() !== "login/check") && !$user) {
			redirect("/");
		}
		if (((uri_string() === "") || (uri_string() === "login/check")) && !!$user) {
			redirect("/dashboard");
		}

		$this->rules['login'] = array(
			array(
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required'
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required'
			)
		);

		$this->rules['project'] = array(
			array(
				'field' => 'title',
				'label' => 'Title',
				'rules' => 'required'
			)
		);
	}
}

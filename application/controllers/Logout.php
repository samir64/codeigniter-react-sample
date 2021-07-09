<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		load_js(['app'], 'js_assets');

		$this->session->set_userdata("user", NULL);
		$this->session->set_flashdata("form_data", array(
			"values" => "username=" . $this->input->post("username")
		));
		redirect('/');
	}
}

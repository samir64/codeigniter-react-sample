<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		load_js(['app'], 'js_assets');

		$data = $this->session->flashdata("form_data");

		$this->load->view('header');
		$this->load->view('login', $data);
		$this->load->view('footer');
	}

	public function check()
	{
		load_js(['app'], 'js_assets');

		$this->form_validation->set_rules($this->rules['login']);
		$userIsValid = true;

		if ($this->form_validation->run() == TRUE) {
			$this->load->model('userModel');
			$user = $this->userModel->getUserByUsername($this->input->post("username"));
			if (md5($this->input->post("password")) === $user->password) {
				$this->session->set_userdata(
					"user",
					array(
						"username" => $user->username,
						"email" => $user->email,
						"firstname" => $user->firstname,
						"lastname" => $user->lastname
					)
				);

				redirect('/dashboard');
			} else {
				$userIsValid = false;
			}
		} else {
			$userIsValid = false;
		}

		if (!$userIsValid) {
			$this->session->set_userdata("user", NULL);
			$this->session->set_flashdata("form_data", array(
				"invalid" => "username,password",
				"values" => "username=" . $this->input->post("username")
			));
			redirect('/');
		}
	}
}

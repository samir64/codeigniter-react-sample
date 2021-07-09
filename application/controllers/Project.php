<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Project extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		redirect('/dashboard');
	}

	public function new()
	{
		load_js(['app'], 'js_assets');

		$this->load->model('userModel');

		$user = $this->session->userdata("user");
		$data = array(
			"page" => "project_new"
		);

		$this->load->view('header');
		$this->load->view('page_header', array_merge(array("user" => $user), $data));
		$this->load->view('new_project');
		$this->load->view('page_footer');
		$this->load->view('footer');
	}

	public function view()
	{
		$id = $this->uri->segment(3);

		load_js(['app'], 'js_assets');

		$this->load->model('userModel');

		$user = $this->session->userdata("user");
		$data = array(
			"page" => "project_view",
			"projectId" => $id
		);

		$this->load->view('header');
		$this->load->view('page_header', array_merge(array("user" => $user), $data));
		$this->load->view('page_footer');
		$this->load->view('footer');
	}
}

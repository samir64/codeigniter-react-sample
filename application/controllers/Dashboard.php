<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		load_js(['app'], 'js_assets');

		$this->load->model('projectModel');

		$rows = json_decode(json_encode($this->projectModel->getAll()), true);
		for ($i = 0; $i < count($rows); $i++) {
			$fields = array($rows[$i]['id'], $rows[$i]['title'], date("Y/m/d", $rows[$i]['date']));
			$rows[$i] = join(",", $fields);
		}
		$rows = join("|", $rows);

		$user = $this->session->userdata("user");
		$data = array(
			"page" => "project_list",
			"rows" => $rows
		);

		$this->load->view('header');
		$this->load->view('page_header', array_merge(array("user" => $user), $data));
		$this->load->view('dashboard', $data);
		$this->load->view('page_footer');
		$this->load->view('footer');
	}

	public function view()
	{
		var_dump(uri_string());
	}
}

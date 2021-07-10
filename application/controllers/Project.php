<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

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

	public function edit()
	{
		$id = $this->uri->segment(3);

		load_js(['app'], 'js_assets');

		$this->load->model('projectModel');

		$user = $this->session->userdata("user");
		$data = array(
			"page" => "project_edit",
			"project" => $this->projectModel->getProjectById($id)
		);

		$this->load->view('header');
		$this->load->view('page_header', array_merge(array("user" => $user), $data));
		$this->load->view('edit_project', $data);
		$this->load->view('page_footer');
		$this->load->view('footer');
	}

	public function save()
	{
		$id = $this->uri->segment(3);

		$config['upload_path'] = APPPATH . 'public/uploads/';
		$config['allowed_types'] = 'xls|xlsx';
		$config['max_size'] = 2000;
		$config['max_width'] = 1500;
		$config['max_height'] = 1500;
		$config['file_name'] = time() . '.xlsx';

		$this->load->library('upload', $config);
		$this->load->model('projectModel');
		$projectIsValid = TRUE;
		$hasFile = $_FILES["file"]["size"] > 0;
		// var_dump($this->input->file("file"));

		$this->form_validation->set_rules($this->rules['project']);
		if ($this->form_validation->run() == TRUE) {
			if ($this->upload->do_upload('file') || (!!$id && !$hasFile)) {
				if ($hasFile) {
					$fileData = $this->upload->data();
				}

				if (!$id) {
					$this->projectModel->setProject($this->input->post('title'), $this->input->post('description'), $fileData['file_name']);
				} else {
					//TODO: Update project
				}
				redirect('/dashboard');
			} else {
				$projectIsValid = FALSE;
			}
		} else {
			$projectIsValid = FALSE;
		}

		if (!$projectIsValid) {
			if (!!$id) {
				redirect('/project/edit/' . $id);
			} else {
				redirect('/project/new');
			}
		}
	}

	public function view()
	{
		$id = $this->uri->segment(3);

		load_js(['app'], 'js_assets');

		$this->load->model('projectModel');
		$project = $this->projectModel->getProjectById($id);

		$filePath = APPPATH . "public/uploads/" . $project->file;
		$reader = ReaderEntityFactory::createReaderFromFile($filePath);

		$reader->open($filePath);
		$table = array();
		$columns = array();

		foreach ($reader->getSheetIterator() as $sheet) {
			foreach ($sheet->getRowIterator() as $num => $row) {
				$cells = $row->getCells();
				foreach ($cells as $col => $cell) {
					if ($num === 1) {
						$table[$cell->getValue()] = array();
						array_push($columns, $cell->getValue());
					} else {
						array_push($table[$columns[$col]], $cell->getValue());
					}
				}
			}
		}

		$reader->close();

		var_dump($table);

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

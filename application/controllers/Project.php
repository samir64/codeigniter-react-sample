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

	public function delete()
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
		$this->load->view('delete_project', $data);
		$this->load->view('page_footer');
		$this->load->view('footer');
	}

	public function delete_confirm()
	{
		$id = $this->uri->segment(3);

		load_js(['app'], 'js_assets');

		$this->load->model('projectModel');

		$this->projectModel->delete($id);
		redirect("/dashboard");
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
					$data = array("title" => $this->input->post("title"), "description" => $this->input->post("description"));
					if ($hasFile) {
						$data["file"] = $fileData["file_name"];
					}
					$this->projectModel->update($id, $data);
				}
				redirect('/dashboard');
			} else {
				// var_dump($this->upload->display_errors());
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
		$columns = array("index");

		foreach ($reader->getSheetIterator() as $sheet) {
			foreach ($sheet->getRowIterator() as $num => $row) {
				if ($num > 1) {
					array_push($table, array('index' => $num - 2));
				}
				foreach ($row->getCells() as $col => $cell) {
					if ($num === 1) {
						array_push($columns, $cell->getValue());
					} else {
						$table[$num - 2][$columns[$col + 1]] = $cell->getValue();
					}
				}
			}
		}

		$reader->close();

		$user = $this->session->userdata("user");
		$data = array(
			"page" => "project_view",
			"project" => $project,
			"table" => $table
		);

		$this->load->view('header');
		$this->load->view('page_header', array_merge(array("user" => $user), $data));
		$this->load->view('view_project', $data);
		$this->load->view('page_footer');
		$this->load->view('footer');
	}

	public function animate()
	{
		$id = $this->uri->segment(3);

		load_js(['app'], 'js_assets');

		$this->load->model('projectModel');
		$project = $this->projectModel->getProjectById($id);

		$filePath = APPPATH . "public/uploads/" . $project->file;
		$reader = ReaderEntityFactory::createReaderFromFile($filePath);

		$reader->open($filePath);
		$table = array();
		$columns = array("index");

		foreach ($reader->getSheetIterator() as $sheet) {
			foreach ($sheet->getRowIterator() as $num => $row) {
				if ($num > 1) {
					array_push($table, array('index' => $num - 2));
				}
				foreach ($row->getCells() as $col => $cell) {
					if ($num === 1) {
						array_push($columns, $cell->getValue());
					} else {
						$table[$num - 2][$columns[$col + 1]] = $cell->getValue();
					}
				}
			}
		}

		$reader->close();

		$user = $this->session->userdata("user");
		$data = array(
			"page" => "project_view",
			"project" => $project,
			"table" => $table
		);

		$this->load->view('header');
		$this->load->view('page_header', array_merge(array("user" => $user), $data));
		$this->load->view('animate_project', $data);
		$this->load->view('page_footer');
		$this->load->view('footer');
	}
}

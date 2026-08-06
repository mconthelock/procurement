<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Partshortage extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		//$this->load->model('Partshortage_model');
	}

	public function index()
	{
		$data['title'] = 'Part Shortage';
		// 1. เรียกไฟล์ CSS ภายนอก (ใส่ URL เข้าไปใน Array)
		$data['custom_css'] = array(
			base_url('assets/style/partshortage/partshortage.css'),
		);
		//$data['shortages'] = $this->Partshortage_model->get_all();
		$this->views('Partshortage/index', $data);
	}

	/*public function create()
	{
		$data['title'] = 'Add Part Shortage';
		$this->load->view('partshortage/create', $data);
	}*/

	/*public function store()
	{
		if ($this->Partshortage_model->insert($_POST))
		{
			$this->session->set_flashdata('message', 'Part shortage added successfully');
			redirect('partshortage');
		}
		else
		{
			$this->session->set_flashdata('error', 'Failed to add part shortage');
			redirect('partshortage/create');
		}
	}*/

	/*public function edit($id)
	{
		$data['title'] = 'Edit Part Shortage';
		$data['shortage'] = $this->Partshortage_model->get($id);
		$this->load->view('partshortage/edit', $data);
	}*/

	/*public function update($id)
	{
		if ($this->Partshortage_model->update($id, $_POST))
		{
			$this->session->set_flashdata('message', 'Part shortage updated successfully');
			redirect('partshortage');
		}
		else
		{
			$this->session->set_flashdata('error', 'Failed to update part shortage');
			redirect('partshortage/edit/' . $id);
		}
	}*/

	/*public function delete($id)
	{
		if ($this->Partshortage_model->delete($id))
		{
			$this->session->set_flashdata('message', 'Part shortage deleted successfully');
		}
		else
		{
			$this->session->set_flashdata('error', 'Failed to delete part shortage');
		}
		redirect('partshortage');
	}*/
}

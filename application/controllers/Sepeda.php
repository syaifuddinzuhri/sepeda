<?php

class Sepeda extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model');
		if (!$this->auth_model->current_user()) {
			redirect('auth/login');
		}
	}

	public function index()
	{
		$data['main_content'] = 'sepeda/index';
		$this->load->view('master', $data);
	}


	/**
	 * Get All Data from this method.
	 *
	 * @return Response
	 */
	public function getAll()
	{
		$this->load->database();
		$query = $this->db->get("sepeda");
		$data['data'] = $query->result();
		$data['total'] = $this->db->count_all("sepeda");
		echo json_encode($data);
	}


	/**
	 * Store Data from this method.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->load->database();
		$this->form_validation->set_rules('plat_no', 'Plat Nomor', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('merk', 'merk', 'required');
		if ($this->form_validation->run()) {
			$insert = $this->input->post();
			$this->db->insert('sepeda', $insert);
			$id = $this->db->insert_id();
			$q = $this->db->get_where('sepeda', array('id' => $id));
			echo json_encode(array(
				'status' => true,
				'data' => $q->row()
			));
		} else {
			$array = array(
				'status'   => false,
				'message' => 'Data tidak valid',
				'errors' => array(
					'plat_no_error' => form_error('plat_no'),
					'nama_error' => form_error('nama'),
					'merk_error' => form_error('merk'),
				),
			);
			echo json_encode($array);
		}
	}


	/**
	 * Edit Data from this method.
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$this->load->database();
		$q = $this->db->get_where('sepeda', array('id' => $id));
		echo json_encode($q->row());
	}


	/**
	 * Update Data from this method.
	 *
	 * @return Response
	 */
	public function update($id)
	{
		$this->load->database();
		$this->form_validation->set_rules('plat_no', 'Plat Nomor', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('merk', 'merk', 'required');
		if ($this->form_validation->run()) {
			$insert = $this->input->post();
			$this->db->where('id', $id);
			$this->db->update('sepeda', $insert);
			$q = $this->db->get_where('sepeda', array('id' => $id));
			echo json_encode(array(
				'status' => true,
				'data' => $q->row()
			));
		} else {
			$array = array(
				'status'   => false,
				'message' => 'Data tidak valid',
				'errors' => array(
					'plat_no_error' => form_error('plat_no'),
					'nama_error' => form_error('nama'),
					'merk_error' => form_error('merk'),
				),
			);
			echo json_encode($array);
		}
	}


	/**
	 * Delete Data from this method.
	 *
	 * @return Response
	 */
	public function delete($id)
	{
		$this->load->database();
		$this->db->where('id', $id);
		$this->db->delete('sepeda');
		echo json_encode(['success' => true]);
	}
}

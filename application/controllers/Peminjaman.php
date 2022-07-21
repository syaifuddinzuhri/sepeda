<?php

class Peminjaman extends CI_Controller
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
		$pengguna = $this->db->get("pengguna");
		$sepeda = $this->db->get("sepeda");
		$data['data_pengguna'] = $pengguna->result();
		$data['data_sepeda'] = $sepeda->result();
		$data['main_content'] = 'peminjaman/index';
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
		$this->db->select('peminjaman.*, pengguna.nama as nama_pengguna, sepeda.nama as nama_sepeda')
			->from('peminjaman')
			->join('sepeda', 'sepeda.id = peminjaman.sepeda_id')
			->join('pengguna', 'pengguna.id = peminjaman.pengguna_id');
		$result = $this->db->get();
		$data['data'] = $result->result_array();
		$data['total'] = $result->num_rows();
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
		$this->form_validation->set_rules('tgl_pinjam', 'Tanggal Pinjam', 'required');
		$this->form_validation->set_rules('tgl_kembali', 'Tanggal Kembali', 'required');
		$this->form_validation->set_rules('pengguna_id', 'pengguna', 'required');
		$this->form_validation->set_rules('sepeda_id', 'sepeda', 'required');
		if ($this->form_validation->run()) {
			$insert = $this->input->post();
			$this->db->insert('peminjaman', $insert);
			$id = $this->db->insert_id();
			$q = $this->db->get_where('peminjaman', array('id' => $id));
			echo json_encode(array(
				'status' => true,
				'data' => $q->row()
			));
		} else {
			$array = array(
				'status'   => false,
				'message' => 'Data tidak valid',
				'errors' => array(
					'tgl_pinjam_error' => form_error('tgl_pinjam'),
					'tgl_kembali_error' => form_error('tgl_kembali'),
					'pengguna_id_error' => form_error('pengguna_id'),
					'sepeda_id_error' => form_error('sepeda_id'),
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
		$q = $this->db->get_where('peminjaman', array('id' => $id));
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
		$this->form_validation->set_rules('tgl_pinjam', 'Tanggal Pinjam', 'required');
		$this->form_validation->set_rules('tgl_kembali', 'Tanggal Kembali', 'required');
		$this->form_validation->set_rules('pengguna_id', 'Pengguna', 'required');
		$this->form_validation->set_rules('sepeda_id', 'Sepeda', 'required');
		if ($this->form_validation->run()) {
			$insert = $this->input->post();
			$this->db->where('id', $id);
			$this->db->update('peminjaman', $insert);
			$q = $this->db->get_where('peminjaman', array('id' => $id));
			echo json_encode(array(
				'status' => true,
				'data' => $q->row()
			));
		} else {
			$array = array(
				'status'   => false,
				'message' => 'Data tidak valid',
				'errors' => array(
					'tgl_pinjam_error' => form_error('tgl_pinjam'),
					'tgl_kembali_error' => form_error('tgl_kembali'),
					'pengguna_id_error' => form_error('pengguna_id'),
					'sepeda_id_error' => form_error('sepeda_id'),
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
		$this->db->delete('peminjaman');
		echo json_encode(['success' => true]);
	}
}

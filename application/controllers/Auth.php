<?php

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model');
	}

	public function index()
	{
		redirect('/auth/login', 'refresh');
	}

	public function login()
	{
		$this->load->model('auth_model');
		if ($this->auth_model->current_user()) {
			redirect('/');
		}

		$this->load->library('form_validation');

		$rules = $this->auth_model->rules();
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == FALSE) {
			return $this->load->view('login_form');
		}

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		if ($this->auth_model->login($username, $password)) {
			redirect('/', 'refresh');
		} else {
			$this->session->set_flashdata('message_login_error', 'Login Gagal, pastikan username dan passwrod benar!');
		}

		$this->load->view('login_form');
	}

	public function logout()
	{
		$this->load->model('auth_model');
		$this->auth_model->logout();
		redirect('/auth/login', 'refresh');
	}
}

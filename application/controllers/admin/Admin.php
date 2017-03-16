<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );


class Admin extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->model('login');
	}

	public function login()
	{
//		if( $this->session->userdata( 'logged_in' ) ) {
//			redirect( 'admin/main/hotels' );
//		}
//
//		if (isset($_POST['user']) && isset($_POST['pass']))
//		{
//			$username = htmlspecialchars(trim(strip_tags($_POST['user'])));
//			$password = htmlspecialchars(trim(strip_tags($_POST['pass'])));
//
//			$result = $this->login->checkCredentials($username, $password);
//
//			if (is_null($result)) {
//				$this->session->set_flashdata('wrong_credentials', '1');
//				$this->load->view('admin/login');
//			} else {
//				$this->session->set_userdata(['logged_in' => 1]);
//				redirect('admin/main/hotels');
//			}
//		} else {
//			$this->load->view('admin//login');
//		}
	}

	public function logout()
	{
		$this->session->unset_userdata('logged_in');
		redirect('admin/login');
	}

	public function changePass()
	{
		if (isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['new_pass']))
		{
			$username = htmlspecialchars(trim(strip_tags($_POST['user'])));
			$old_pass = htmlspecialchars(trim(strip_tags($_POST['pass'])));
			$new_pass = htmlspecialchars(trim(strip_tags($_POST['new_pass'])));

			$result = $this->login->changePass($username, $old_pass, $new_pass);

			if ($result) {
				$this->session->unset_userdata('logged_in');
				$this->session->set_flashdata('change_pass_success', 1);
				redirect('admin/login');
			} else {
				$this->session->set_flashdata('change_pass_error', 'Wrong Credentials');
				redirect('admin/change-pass');
			}
		} else {
			$this->load->view('admin/changepass');
		}
	}
}
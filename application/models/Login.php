<?php


class Login extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	public function checkCredentials($username, $password)
	{
		$login = $this->db->select('*')
				         ->where('username =', $username)
				         ->where('password =', md5($password))
				         ->get('login')
						->row();

		return $login;

	}

	//testets
	public function changePass($username, $old_pass, $new_pass)
	{
		$user = $this->db->where( 'username', $username )
				->where( 'password', md5( $old_pass ) )
				->get('login')
				->row();

		if ($user) {
			$this->db->where( 'username', $username )
					->where( 'password', md5( $old_pass ) )
					->update( 'login', ['password' => md5( $new_pass )] );
			return true;
		}

		return false;
	}
}
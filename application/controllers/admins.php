<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Admins extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler();
	}

	public function index()
	{
		echo "Welcome to CodeIgniter. The default Controller is admins.php";
	}
}
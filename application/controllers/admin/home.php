<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		if($this->session->userdata('level') == '')
		{
			redirect('home');
		}
	}

	function index()
	{
		$data = array(
			'main'		=> 'admin/home',
			'home'		=> 'class="active"',
			'type'		=> 'a'
		);
		$this->load->view('admin/template',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		if($this->session->userdata('level') == '' || $this->session->userdata('kd_ta') == '')
		{
			redirect('login/logout');
		}
		
		$this->load->model('mmenu','',TRUE);
	}

	function index()
	{
		$data = array(
			'main'		=> 'fguru/home',
			'home'		=> 'class="active"',
			'type'		=> 'a',
			'menu'		=> $this->mmenu->getTeamTeaching()
		);
		$this->load->view('fguru/template',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
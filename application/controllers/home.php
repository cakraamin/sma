<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('mhome','',TRUE);
	}

	function index($level=0)
	{
		//$this->create();
		if($level == 1 || $this->session->userdata('level') == 1)
		{
			redirect('admin/home');
		}
		elseif($level == 2)
		{
			redirect('home');
		}
		elseif($level == 3 || $this->session->userdata('level') == 3)
		{
			redirect('fguru/home');
		}
		else 
		{
			$data = array(
				'main'		=> 'home',
				'home'		=> 'class="active"',
				'ta'		=> $this->cekTA(),
				'type'		=> 'a',
				'sem'		=> $this->getSemester()
			);
			$this->load->view('template',$data);	
		}
	}
	
	function cekTA()
	{	
		$ta = $this->mhome->getTA();
		if($ta->num_rows() > 0)
		{
			$dt_ta = $ta->row();
			$nilai = $dt_ta->ta;
			$data = array(
				'kd_ta'  	=> $dt_ta->id_ta,
				'ta'  		=> $dt_ta->ta
			);
	
			$this->session->set_userdata($data);
		}
		else
		{
			$nilai = 0;
		}
		return $nilai;
	}
	
	function getSemester()
	{
		$data = array(
			'kd_sem'  	=> $this->mhome->getSemester()
		);
	
		$this->session->set_userdata($data);
	}
	
	function create()
	{
		$cek = $this->serial->create();
		if(!$cek)
		{
			redirect('register');		
		}
	}
}

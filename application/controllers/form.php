<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('page');
		$this->load->model('mabsen','',TRUE);
		
		if($this->session->userdata('kd_ta') == '' && $this->session->userdata('kd_sem') == '')
		{
			redirect('home');
		}
	}
	
	function index()
	{
		if($this->mabsen->getControl() == 0)
		{
			redirect('home');
		}
		
		$this->load->library('day');
		
		$data = array(
			'hari'		=> $this->day->getHari(),
			'tgl'		=> $this->day->getTgl(),
			'bln'		=> $this->day->getBulan(),
			'thn'		=> $this->day->getTahun(),
			'jam'		=> $this->mabsen->getJam()
		);
		
		$this->load->view('form',$data);
	}
	
	function cekJam($jam)
	{
		$batas = strtotime($this->mabsen->getControl());
		$sekarang = strtotime($jam);
		$buka = strtotime("06:00:00");
		if($batas < $sekarang)
		{
			echo "lewat";
		}
		elseif($buka < $sekarang)
		{
			echo $this->mabsen->getControl();	
		}
		else
		{
			echo $this->mabsen->getControl();	
		}
	}
	
	function submit_form()
	{
		if($this->mabsen->cekNis() == 0)
		{
			echo "kosong";
			exit();
		}
	
		if($this->mabsen->cekAbsen() > 0)
		{
			echo "sudah";
		}
		else
		{
			$this->mabsen->addAbsen();
			if($this->db->affected_rows() > 0)
			{
				echo "ok";
			}
			else
			{
				echo "gagal";
			}
		}
	}
	
	function detil($id)
	{
		$this->load->helper(array("tanggal","gambar"));
	
		$data = array(
			'kueri'		=> $this->mabsen->getSiswa($id)
		);
		
		$this->load->view('tabel',$data);
	}
}
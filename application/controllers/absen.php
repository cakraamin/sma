<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Absen extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('page');
		$this->load->model('mabsen','',TRUE);
		
		if($this->session->userdata('id') == '' || $this->session->userdata('kd_ta') == '' || $this->session->userdata('kd_sem') == '')
		{
			redirect('home');
		}
	}
	
	function index()
	{
		redirect('absen/daftar');
	}
	
	function daftar($short_by='a.nis',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->db->count_all('absen WHERE DATE(tgl)=DATE(NOW())');
		$per_page = 20;
		$url = 'absen/daftar/'.$short_by.'/'.$short_order.'/';

		$query = $this->mabsen->getAbsen($per_page,$page,$short_by,$short_order);
				
		$data = array(
			'kueri' 		=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'daftar_absen',
			'absen'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'urs'			=> 3,
			'ref'			=> 'refresh'
		);
		
		$this->load->view('template',$data);
	}
	
	function refresh($short_by='',$short_order='',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->db->count_all('absen WHERE DATE(tgl)=DATE(NOW())');
		$per_page = 20;
		$url = 'absen/daftar/'.$short_by.'/'.$short_order.'/';

		$query = $this->mabsen->getAbsen($per_page,$page,$short_by,$short_order);
				
		$data = array(
			'kueri' 		=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'absen'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'urs'			=> 3,
			'ref'			=> 'refresh'
		);
		
		$this->load->view('tabel_absen',$data);
	}
	
	function add_absen()
	{
		$data = array(	  
			'absen'			=> 'class="active"',
			'main'			=> 'absen',
			'type'			=> 'b',
			'tambah'			=> 'class="active"',
			'keterangan'	=> $this->mabsen->getKet()
		);
			
		$this->load->view('template',$data);
	}
	
	function edit_absen($id)
	{
		$data = array(	  
			'absen'			=> 'class="active"',
			'main'			=> 'edit_absen',
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'keterangan'	=> $this->mabsen->getKet(),
			'kueri'			=> $this->mabsen->getDetilAbsen($id)
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_absen()
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
			$this->mabsen->addAbsensi();
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
	
	function submit_edit_absen()
	{
		$this->mabsen->editAbsensi();
		if($this->db->affected_rows() > 0)
		{
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}
	
	function submit_cari()
	{
		$kunci = strip_tags(ascii_to_entities(addslashes($this->input->post('kunci',TRUE))));
		if($kunci == "")
		{
			redirect('absen/daftar');
		}
		else
		{
			redirect('absen/cari/'.$kunci);
		}
	}
	
	function cari($kunci,$short_by='a.nis',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->mabsen->getCari($kunci);
		$per_page = 20;
		$url = 'absen/cari/'.$short_by.'/'.$short_order.'/';

		$query = $this->mabsen->getAbsenCari($kunci,$per_page,$page,$short_by,$short_order);
				
		$data = array(
			'kueri' 		=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'daftar_absen',
			'absen'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'urs'			=> 3,
			'ref'			=> 'refreshcari/'.$kunci,
			'kunci'			=> $kunci
		);
		
		$this->load->view('template',$data);
	}
	
	function refreshcari($kunci,$short_by='a.nis',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->mabsen->getCari($kunci);
		$per_page = 20;
		$url = 'absen/cari/'.$short_by.'/'.$short_order.'/';

		$query = $this->mabsen->getAbsenCari($kunci,$per_page,$page,$short_by,$short_order);
				
		$data = array(
			'kueri' 		=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'absen'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'urs'			=> 3,
			'ref'			=> 'refreshcari/'.$kunci,
			'kunci'			=> $kunci
		);
		
		$this->load->view('tabel_absen',$data);
	}
	
	function del_absen($id)
	{
		$this->mabsen->delAbsen($id);
		echo "ok";
	}
}
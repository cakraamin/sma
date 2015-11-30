<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Keahlian extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('page');
		$this->load->model('mjurusan','',TRUE);
		
		if($this->session->userdata('id') == '' || $this->session->userdata('kd_ta') == '')
		{
			redirect('home');
		}
	}
	
	function index()
	{
		redirect('keahlian/daftar');
	}
	
	function daftar($short_by='nis',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->db->count_all('keahlian');
		$per_page = 20;
		$url = 'siswa/daftar/'.$short_by.'/'.$short_order.'/';

		$query = $this->mjurusan->getKeahlian($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('keahlian/daftar/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 			=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'daftar_ahli',
			'ahli'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'urs'				=> 3,
			'ref'				=> $this->uri->segment(2)
		);
		
		$this->load->view('template',$data);
	}
	
	function add_keahlian()
	{
		$this->load->library('arey');
	
		$data = array(	  
			'ahli'			=> 'class="active"',
			'main'			=> 'keahlian',
			'type'			=> 'b',
			'tambah'			=> 'class="active"'
		);
			
		$this->load->view('template',$data);
	}
	
	function edit_keahlian($id)
	{
		$this->load->library('arey');
		$this->load->helper(array('no','edit'));
	
		$data = array(	  
			'ahli'			=> 'class="active"',
			'main'			=> 'edit_keahlian',
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'kueri'			=> $this->mjurusan->getKeahlianId($id)
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_keahlian()
	{
		$this->load->helper('no');
	
		if($this->mjurusan->cekAhli($this->input->post('bidang',TRUE),$this->input->post('program',TRUE)) == 0)
		{
			$this->mjurusan->addAhli();
			if($this->db->affected_rows() > 0)
			{
				$this->message->set('succes','Keahlian Berhasil Ditambah');
				echo "ok";
			}
			else
			{
				echo "gagal";
			}
		}
		else
		{
			echo "exist";
			die();
		}
	}
	
	function submit_edit_keahlian()
	{
		$this->load->helper('no');
	
		$this->mjurusan->updateAhli();
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Keahlian Berhasil Diupdate');
		}
		else
		{
			$this->message->set('error','Keahlian Gagal Diupdate');
		}
		echo "edit";
	}
	
	function hapus()
	{
		$alamat = $this->input->post('alamat',TRUE);
		if($this->input->post('cek',TRUE) != "")
		{
			foreach($this->input->post('cek',TRUE) as $cek)
			{
				$this->mjurusan->delAhli($cek);
			}
			$this->message->set('succes','Keahlian Berhasil Dihapus');
			redirect($alamat);
		}
		else
		{
			$this->message->set('notice','Tidak Ada Keahlian Yang Dipilih');
			redirect($alamat);		
		}
	}
}
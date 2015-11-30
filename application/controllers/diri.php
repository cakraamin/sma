<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Diri extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('page');
		$this->load->model('mdiri','',TRUE);
		
		if($this->session->userdata('id') == '' || $this->session->userdata('kd_ta') == '')
		{
			redirect('home');
		}
	}
	
	function index()
	{
		redirect('diri/daftar');
	}
	
	function daftar($short_by='nis',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->db->count_all('diri');
		$per_page = 20;
		$url = 'diri/daftar/'.$short_by.'/'.$short_order.'/';

		$query = $this->mdiri->getDiri($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('diri/daftar/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 			=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'daftar_diri',
			'setting'		=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'urs'				=> 3,
			'ref'				=> $this->uri->segment(2)
		);
		
		$this->load->view('template',$data);
	}
	
	function add_diri()
	{
		$data = array(	  
			'setting'		=> 'class="active"',
			'main'			=> 'diri',
			'type'			=> 'b',
			'tambah'			=> 'class="active"'
		);
			
		$this->load->view('template',$data);
	}
	
	function edit_diri($id)
	{
		$this->load->helper('edit');
	
		$data = array(	  
			'siswa'			=> 'class="active"',
			'main'			=> 'edit_diri',
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'kueri'			=> $this->mdiri->getDiriId($id)
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_siswa()
	{
		$this->mdiri->addDiri();
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Pengembangan Diri Berhasil Ditambah');
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}
	
	function submit_edit_diri()
	{
		$this->mdiri->updateDiri();
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Pengembangan Diri Berhasil Diupdate');
		}
		else
		{
			$this->message->set('error','Pengembangan Diri Gagal Diupdate');
		}
		echo "edit";
	}
	
	function submit_cari()
	{
		$kunci = strip_tags(ascii_to_entities(addslashes($this->input->post('kunci',TRUE))));
		if($kunci == "")
		{
			redirect('diri/daftar');
		}
		else
		{
			redirect('diri/cari/'.$kunci);
		}
	}
	
	function cari($kunci,$short_by='nis',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->db->count_all("diri WHERE pengembangan_diri LIKE '%".$kunci."%'");
		$per_page = 20;
		$url = 'diri/daftar/'.$short_by.'/'.$short_order.'/';

		$query = $this->mdiri->getSearchDiri($kunci,$per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('diri/daftar/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 			=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'daftar_diri',
			'setting'		=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'urs'				=> 3,
			'ref'				=> $this->uri->segment(2),
			'kunci'			=> $kunci
		);
		
		$this->load->view('template',$data);
	}
	
	function hapus()
	{
		$alamat = $this->input->post('alamat',TRUE);
		if($this->input->post('cek',TRUE) != "")
		{
			foreach($this->input->post('cek',TRUE) as $cek)
			{
				$this->mdiri->delDiri($cek);
			}
			$this->message->set('succes','Pengembangan Diri Berhasil Dihapus');
			redirect($alamat);
		}
		else
		{
			$this->message->set('notice','Tidak Ada Pengembangan Diri Yang Dipilih');
			redirect($alamat);		
		}
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jurusan extends CI_Controller {

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
		redirect('jurusan/daftar');
	}
	
	function daftar($short_by='nis',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->db->count_all('siswa');
		$per_page = 20;
		$url = 'siswa/daftar/'.$short_by.'/'.$short_order.'/';

		$query = $this->mjurusan->getSiswa($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('siswa/daftar/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 			=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'daftar_siswa',
			'jur'				=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'urs'				=> 3,
			'ref'				=> $this->uri->segment(2)
		);
		
		$this->load->view('template',$data);
	}
	
	function add_siswa()
	{
		$this->load->library('arey');
	
		$data = array(	  
			'siswa'			=> 'class="active"',
			'main'			=> 'siswa',
			'hari'			=> $this->arey->getDay(),
			'bulan'			=> $this->arey->getBulan(),
			'tahun'			=> $this->arey->getTahun(),
			'agama'			=> $this->mjurusan->getAgama(),
			'type'			=> 'b',
			'tambah'			=> 'class="active"'
		);
			
		$this->load->view('template',$data);
	}
	
	function edit_siswa($id)
	{
		$this->load->library('arey');
		$this->load->helper(array('no','edit'));
	
		$data = array(	  
			'siswa'			=> 'class="active"',
			'main'			=> 'edit_siswa',
			'hari'			=> $this->arey->getDay(),
			'bulan'			=> $this->arey->getBulan(),
			'tahun'			=> $this->arey->getTahun(),
			'agama'			=> $this->mjurusan->getAgama(),
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'kueri'			=> $this->mjurusan->getNis($id)
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_siswa()
	{
		$this->load->helper('no');
	
		if($this->mjurusan->cekNis($this->input->post('nis',TRUE)) == 0)
		{
			$this->mjurusan->addSiswa();
			if($this->db->affected_rows() > 0)
			{
				$this->message->set('succes','Siswa Berhasil Ditambah');
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
	
	function submit_edit_siswa()
	{
		$this->load->helper('no');
	
		echo $this->mjurusan->updateSiswa();
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Siswa Berhasil Diupdate');
			echo "edit";
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
			redirect('siswa/daftar');
		}
		else
		{
			redirect('siswa/cari/'.$kunci);
		}
	}
	
	function cari($kunci,$short_by='nis',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->db->count_all("siswa WHERE nama LIKE '%$kunci%'");
		$per_page = 20;
		$url = 'siswa/cari/'.$kunci.'/'.$short_by.'/'.$short_order.'/';

		$query = $this->mjurusan->searchSiswa($kunci,$per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('siswa/cari/'.$kunci.'/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 			=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=6),
			'main'			=> 'daftar_siswa',
			'siswa'			=> 'class="active"',
			'sort_by' 		=> $short_order,
			'sort_order' 	=> $short_by,
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'kunci'			=> $kunci,
			'urs'				=> 4,
			'ref'				=> $this->uri->segment(2)."/".$kunci
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
				$this->mjurusan->delSiswa($cek);
			}
			$this->message->set('succes','Siswa Berhasil Dihapus');
			redirect($alamat);
		}
		else
		{
			$this->message->set('notice','Tidak Ada Siswa Yang Dipilih');
			redirect($alamat);		
		}
	}
}
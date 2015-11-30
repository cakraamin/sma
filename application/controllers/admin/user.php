<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('page');
		$this->load->model('muser','',TRUE);
		
		if($this->session->userdata('level') == '')
		{
			redirect('home');
		}
	}

	function index()
	{
		redirect('admin/user/daftar');
	}
	
	function daftar($short_by='nameid',$short_order='asc',$page=0)
	{
		$per_page = 20;
		$total_page = $this->db->count_all('users');
		$url = 'admin/user/daftar/'.$short_by.'/'.$short_order.'/';
		
		$query = $this->muser->getMember($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('admin/user/daftar/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 			=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=6),
			'main'			=> 'admin/user',
			'user'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'page'			=> $page
		);
		$this->load->view('admin/template',$data);
	}
	
	function add_user()
	{
		$this->load->library('arey');
		
		$data = array(	  
			'user'			=> 'class="active"',
			'main'			=> 'admin/add_user',
			'type'			=> 'b',
			'tambah'			=> 'class="active"',
			'pengguna'		=> $this->arey->getPengguna()
		);
			
		$this->load->view('admin/template',$data);
	}
	
	function submit_user()
	{				
		if($this->muser->cekUser() > 0)
		{
			echo "<p class='notice'>Maaf Username Telah Digunakan</p>";
			//exit();
			redirect('admin/user/daftar');
		}
		else
		{
			/*if($this->input->post('pengguna',TRUE) == 3)
			{
				if($this->muser->cekNip() == 0)
				{
					echo "belum";
				}			
			}*/
			$kueri = $this->muser->addMember();
			if($this->db->affected_rows() > 0)
			{
				$this->message->set('succes','User Berhasil Ditambah');
				redirect('admin/user/daftar');
				//echo "ok";
			}
			else
			{
				//echo "gagal";
				echo "<p class='notice'>Maaf Username Gagal Ditambahkan</p>";
				redirect('admin/user/daftar');
			}
		}
	}
	
	function hapus()
	{
		$alamat = $this->input->post('alamat',TRUE);
		if($this->input->post('cek',TRUE) != "")
		{
			foreach($this->input->post('cek',TRUE) as $cek)
			{
				if($cek == $this->session->userdata('id'))
				{
					$this->message->set('notice','Ada User Yang Aktif');
					redirect($alamat);
				}
				$this->muser->delMember($cek);
			}
			$this->message->set('succes','User Berhasil Dihapus');
			redirect($alamat);
		}
		else
		{
			$this->message->set('notice','Tidak Ada User Yang Dipilih');
			redirect($alamat);		
		}
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kelas extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('page');
		$this->load->model('mkelas','',TRUE);
		
		if($this->session->userdata('id') == '' || $this->session->userdata('kd_ta') == '')
		{
			redirect('home');
		}
	}

	function index()
	{
		redirect('kelas/daftar');
	}
	
	function daftar($short_by='a.nama',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->db->count_all('kelas');
		$per_page = 20;
		$url = 'kelas/daftar/'.$short_by.'/'.$short_order.'/';

		$query = $this->mkelas->getKelase($per_page,$page,$short_by,$short_order);
				
		$data = array(
			'kueri' 		=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'daftar_kelas',
			'kelas'			=> 'class="active"',
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
	
		$total_page = $this->db->count_all('kelas');
		$per_page = 20;
		$url = 'kelas/daftar/'.$short_by.'/'.$short_order.'/';

		$query = $this->mkelas->getKelase($per_page,$page,$short_by,$short_order);
				
		$data = array(
			'kueri' 		=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'kelas'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'urs'			=> 3,
			'ref'			=> 'refresh'
		);
		
		$this->load->view('tabel_kelas',$data);
	}
	
	function add_kelas()
	{
		$data = array(	  
			'kelas'			=> 'class="active"',
			'main'			=> 'kelas',
			'wali'			=> $this->mkelas->getGuru(),
			'type'			=> 'b',
			'tambah'		=> 'class="active"'
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_kelas()
	{
		if($this->mkelas->cekKelas() > 0)
		{
			echo "exist";
			die();
		}
		elseif($this->mkelas->cekWali() > 0)
		{
			echo "exists";
			die();
		}
		else
		{
			$this->mkelas->addKelas();
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
	
	function add_siswa($id=0,$short_by='c.nis',$short_order='asc',$page=0)
	{
		$total_page = $this->db->count_all('kelas_siswa');
		$per_page = 20;
		$url = 'kelas/add_siswa/'.$id.'/'.$short_by.'/'.$short_order.'/';

		$query = $this->mkelas->getKelass($id,$per_page,$page,$short_by,$short_order);
	
		$data = array(	  
			'kueri' 		=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=7),
			'kelas'			=> 'class="active"',
			'main'			=> 'kelas_siswa',
			'kls'			=> $this->mkelas->getKelas(),
			'type'			=> 'b',
			'tambah'		=> 'class="active"',
			'id'			=> $id,
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order
		);
			
		$this->load->view('template',$data);	
	}
	
	function refreshsiswa($id=0,$short_by='c.nis',$short_order='asc',$page=0)
	{
		$total_page = $this->db->count_all('kelas_siswa');
		$per_page = 20;
		$url = 'kelas/add_siswa/'.$id.'/'.$short_by.'/'.$short_order.'/';

		$query = $this->mkelas->getKelass($id,$per_page,$page,$short_by,$short_order);
	
		$data = array(	  
			'kueri' 		=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=7),
			'kelas'			=> 'class="active"',
			'kls'			=> $this->mkelas->getKelas(),
			'type'			=> 'b',
			'tambah'		=> 'class="active"',
			'id'			=> $id,
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order
		);
			
		$this->load->view('tabel_kelass_siswa',$data);	
	}
	
	function del_kelas($id)
	{
		$this->mkelas->del_kelas($id);
		echo "ok";
	}
	
	function show_kelas($id)
	{
		$kueri = $this->mkelas->getKelasSiswa($id);
		
		$data = array(	  
			'kueri'			=> $kueri->result()
		);
			
		$this->load->view('tabel_siswa',$data);
	}
	
	function submit_kelas_siswa()
	{
		if($this->mkelas->cekNis() == 0)
		{
			echo "kosong";
			die();
		}
		elseif($this->mkelas->cekKelasSiswa() > 0)
		{
			echo "exists";
			die();
		}
		elseif($this->input->post('kode') == 0)
		{
			echo "gagal";
			die();
		}
		else
		{
			$this->mkelas->addRecordSiswa();
			$this->mkelas->addKelasSiswa();
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
	
	function edit_kelas($id)
	{
		$data = array(	  
			'kelas'			=> 'class="active"',
			'main'			=> 'edit_kelas',
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'kueri'			=> $this->mkelas->getKelast($id),
			'wali'			=> $this->mkelas->getGuru()
		);
			
		$this->load->view('template',$data);
	}
	
	function edit_kelas_siswa($id)
	{
		$data = array(	  
			'kelas'			=> 'class="active"',
			'main'			=> 'edit_kelas_siswa',
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'kueri'			=> $this->mkelas->getKelasSiswaId($id),
			'kls'			=> $this->mkelas->getKelas(),
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_edit_kelas()
	{
		echo $this->mkelas->updateKelas();
		if($this->db->affected_rows() > 0)
		{
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}
	
	function daftar_siswa($kelas=0,$short_by='c.nama',$short_order='asc',$page=0)
	{
		$total_page = $this->db->count_all('kelas_siswa');
		$per_page = 20;
		$url = 'kelas/daftar_siswa/'.$kelas.'/'.$short_by.'/'.$short_order.'/';

		$query = $this->mkelas->getKelass($kelas,$per_page,$page,$short_by,$short_order);
				
		$data = array(
			'kueri' 		=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=6),
			'main'			=> 'daftar_kelas_siswa',
			'kelas'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'klas'			=> $this->mkelas->getKelas(),
			'kls'			=> $kelas,
			'ref'			=> 'refdaftar_siswa/'.$kelas
		);
		
		$this->load->view('template',$data);
	}
	
	function refdaftar_siswa($kelas='',$short_by='',$short_order='',$page=0)
	{
		$total_page = $this->db->count_all('kelas_siswa');
		$per_page = 20;
		$url = 'kelas/daftar_siswa/'.$kelas.'/'.$short_by.'/'.$short_order.'/';

		$query = $this->mkelas->getKelass($kelas,$per_page,$page,$short_by,$short_order);
				
		$data = array(
			'kueri' 		=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=6),
			'kelas'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'klas'			=> $this->mkelas->getKelas(),
			'kls'			=> $kelas,
			'ref'			=> 'refdaftar_siswa/'.$kelas
		);
		
		$this->load->view('tabel_kelas_siswa',$data);
	}
	
	function pilih_kelas()
	{
		$kelas = $this->input->post('kelas');
		if($kelas == 0)
		{
			redirect('kelas/daftar_siswa');
		}
		else
		{
			redirect('kelas/daftar_siswa/'.$kelas);
		}
	}
	
	function get_kelas()
	{
		$kelas = $this->input->post('kelas');
		if($kelas == 0)
		{
			redirect('kelas/add_siswa');
		}
		else
		{
			redirect('kelas/add_siswa/'.$kelas);
		}
	}
	
	function submit_edit_kelas_siswa()
	{
		$this->mkelas->updateKelasSiswa();
		if($this->db->affected_rows() > 0)
		{
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}
	
	function export()
	{
		$data = array(	  
			'kelas'			=> 'class="active"',
			'main'			=> 'export_kelas',
			'type'			=> 'b',
			'export'		=> 'class="active"'
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_export_kelas()
	{
		$nama = strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))));
		if($this->input->post('format') == 'csv')
		{
			$query = $this->mkelas->exportKelas();
 
			$this->load->helper('csv');
			query_to_csv($query, FALSE, str_replace(" ","_",$nama).'.csv');
		}
		else
		{
			$query = $this->mkelas->exportKelas();
			 
			$this->load->helper('xls');
			query_to_xls($query, FALSE, str_replace(" ","_",$nama).'.xls');
		}
	}
	
	function submit_cari()
	{
		$kunci = strip_tags(ascii_to_entities(addslashes($this->input->post('kunci',TRUE))));
		if($kunci == "")
		{
			redirect('kelas/daftar');
		}
		else
		{
			redirect('kelas/cari/'.$kunci);
		}
	}
	
	function cari($kunci,$short_by='a.nama',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->db->count_all('kelas');
		$per_page = 20;
		$url = 'kelas/cari/'.$kunci.'/'.$short_by.'/'.$short_order.'/';

		$query = $this->mkelas->searchKelase($kunci,$per_page,$page,$short_by,$short_order);
				
		$data = array(
			'kueri' 		=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=6),
			'main'			=> 'daftar_kelas',
			'kelas'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'urs'			=> 4,
			'kunci'			=> $kunci,
			'ref'			=> 'refreshcari/'.$kunci
		);
		
		$this->load->view('template',$data);
	}
	
	function refreshcari($kunci,$short_by='a.nama',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->db->count_all('kelas');
		$per_page = 20;
		$url = 'kelas/cari/'.$kunci.'/'.$short_by.'/'.$short_order.'/';

		$query = $this->mkelas->searchKelase($kunci,$per_page,$page,$short_by,$short_order);
				
		$data = array(
			'kueri' 		=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=6),
			'kelas'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'urs'			=> 4,
			'kunci'			=> $kunci,
			'ref'			=> 'refreshcari/'.$kunci
		);
		
		$this->load->view('tabel_kelas',$data);
	}
	
	function import()
	{
		$data = array(	  
			'siswa'			=> 'class="active"',
			'main'			=> 'import_kelas',
			'type'			=> 'b',
			'import'		=> 'class="active"'
		);
			
		$this->load->view('template',$data);
	}
	
	function upload()
	{
		$config['upload_path'] = './temp/';
		$config['allowed_types'] = 'csv|xls';
		$config['max_size']	= '50000';	
		$config['remove_spaces'] = TRUE;			
				
		$this->load->library('upload', $config);
		$uplod = $this->upload->do_upload("uploadfile");
			
		if ( !$uplod )
		{		    	
			echo "gagal";
		}
		else
		{
			$filename = './temp/'.$_FILES['uploadfile']['name'];
		
			if(end(explode(".", $_FILES['uploadfile']['name'])) == 'csv')
			{
				$this->load->helper('csv');
				$pecah = explode("*",csv_to_array($filename));
			}
			else
			{
				$this->load->helper('xls');
				$pecah = explode("*",xls_to_array($filename));
			}
			$this->mkelas->delKelas();
			foreach($pecah as $bagi)
			{
				$pecah1 = explode(",",$bagi);
				if(count($pecah1) == 3)
				{
					$value = "'".$pecah1[0]."','".$pecah1[1]."','".$this->mkelas->getNip($pecah1[2])."'";
					$this->mkelas->importKelas($value);
				}
			}
			if($this->db->affected_rows() > 0)
			{
				echo "<p class='succes'>Import File Berhasil</p>";
			}
			else
			{
				echo "<p class='notice'>Import File Gagal</p>";
			}
			unlink($filename);
		}
	}
	
	function del_kelas_siswa($id)
	{
		$pecah = explode("-",$id);
		$this->mkelas->delRecordSiswa($pecah[1]);
		$this->mkelas->del_kelas_siswa($pecah[0]);
		echo "ok";
	}
}
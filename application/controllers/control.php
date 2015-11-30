<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Control extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('mcontrol','',TRUE);
		
		if($this->session->userdata('id') == '' || $this->session->userdata('kd_ta') == '')
		{
			redirect('home');
		}
	}

	function index()
	{	
		redirect('control/semester');
	}
	
	function semester()
	{
		$data = array(	  
			'control'		=> 'class="active"',
			'main'			=> 'semester',
			'type'			=> 'a',
			'semester'		=> $this->mcontrol->getSemester(),
			'daftar'			=> 'class="active"',
			'sem'				=> $this->mcontrol->getSem(),
			'id_sem'			=> $this->mcontrol->getIdSemester()
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_control_sem()
	{
		$semester = $this->input->post('semester'); 		
		$sem_lama = $this->mcontrol->getIdSemester();
		$this->mcontrol->disableSemester($sem_lama);
		if($this->db->affected_rows() > 0)
		{
			$this->mcontrol->enableSemester($semester);
			if($this->db->affected_rows() > 0)
			{
				echo "<p class='caution'>Saat Ini Semester Yang Diset Adalah Semester <b>".$this->mcontrol->getSemsId($semester)."</b></p>";
			}
			else
			{
				echo "gagal";
			}
		}
		else
		{
			echo "gagal";
		}
	}
	
	function kepala()
	{
		$kueri = $this->mcontrol->getKepala();
		if($kueri->num_rows() > 0)
		{
			$kueri = $kueri->row();
			$kontrol = "edit_control_kepala/".$kueri->id_kepala;
		}
		else
		{
			$kontrol = "submit_control_kepala";
		}
	
		$data = array(	  
			'control'		=> 'class="active"',
			'main'			=> 'kepala',
			'type'			=> 'a',
			'daftar'		=> 'class="active"',
			'kontrol'		=> $kontrol,
			'kueri'			=> $kueri
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_control_kepala()
	{
		$this->mcontrol->simpanKepala();
		if($this->db->affected_rows() > 0)
		{
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}
	
	function edit_control_kepala($id)
	{
		$this->mcontrol->updateKepala($id);
		if($this->db->affected_rows() > 0)
		{
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}
	
	function ta($short_by='id_ta',$short_order='desc',$page=0)
	{
		$this->load->library('page');
		$this->load->helper('shorting');
	
		$total_page = $this->db->count_all('ta');
		$per_page = 20;
		$url = 'control/ta/'.$short_by.'/'.$short_order.'/';

		$query = $this->mcontrol->getTa($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('control/ta/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 		=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'ta',
			'control'		=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'urs'			=> 3,
			'ref'			=> $this->uri->segment(2)
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
				$this->mcontrol->delTa($cek);
			}
			$this->message->set('succes','Tahun Ajaran Berhasil Dihapus');
			redirect($alamat);
		}
		else
		{
			$this->message->set('notice','Tahun Ajaran Tidak Ada Yang Dipilih');
			redirect($alamat);		
		}
	}

	function add_ta()
	{
		$kode = date('Y').(intval(date('Y')) + 1);
		$tahun = date('Y').'/'.(intval(date('Y')) + 1);
	
		$data = array(	  
			'control'		=> 'class="active"',
			'main'			=> 'add_ta',
			'type'			=> 'b',
			'tambah'		=> 'class="active"',
			'kontrol'		=> 'submit_ta',
			'tahun'			=> $tahun,
			'kode'			=> $kode
		);
			
		$this->load->view('template',$data);
	}
	
	function edit_ta($id)
	{
		$this->load->helper('edit');
	
		$data = array(	  
			'control'		=> 'class="active"',
			'main'			=> 'edit_ta',
			'type'			=> 'b',
			'tambah'		=> 'class="active"',
			'kontrol'		=> 'update_ta/'.$id,
			'kueri'			=> $this->mcontrol->getIdTa($id)
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_ta()
	{
		$this->mcontrol->addTa();
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Guru Berhasil Ditambah');
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}
	
	function update_ta($id)
	{
		$this->mcontrol->updateTa($id);
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Guru Berhasil Ditambah');
			echo "edit";
		}
		else
		{
			echo "gagal";
		}
	}
	
	function updateSetTa($id)
	{
		$this->mcontrol->updateTaAll();
		$this->mcontrol->updateTaId($id);
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

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

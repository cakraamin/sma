<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengembangan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('mkembang','',TRUE);
		$this->load->model('mmenu','',TRUE);
		
		if($this->session->userdata('level') == '' || $this->session->userdata('kd_ta') == '')
		{
			redirect('login/logout');
		}
	}

	function index($id=NULL,$short_by='a.nama',$short_order='asc')
	{
		$data = array(
			'main'			=> 'fguru/daftar_kembang',
			'diri'			=> 'class="active"',
			'type'			=> 'a',
			'kueri'			=> $this->mkembang->getSiswaKelas($short_by,$short_order),
			'kelas'			=> $this->mkembang->getKelas(),
			'sort_by'		=> $short_by,
			'sort_order'	=> $short_order,
			'menu'			=> $this->mmenu->getTeamTeaching(),
			'kembang'		=> $this->mkembang->getKembang(),
			'id'				=> $id,
			'diris'			=> $this->mkembang->getKembangDiri()
		);
		$this->load->view('fguru/template',$data);
	}
	
	function input_diri($id,$klas,$nis,$biji)
	{
		$this->mkembang->addDiri($id,$klas,$nis,$biji);
		if($this->db->affected_rows() > 0)
		{
			echo $this->db->insert_id();
		}
		else
		{
			echo "gagal";
		}
	}
	
	function update_diri($nilai,$kode)
	{
		$this->mkembang->updateDiri($nilai,$kode);
		if($this->db->affected_rows() > 0)
		{
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}
	
	function submit_kategori()
	{
		$kat = $this->input->post('diri',TRUE);
		if($kat == 0)
		{
			redirect('fguru/pengembangan');		
		}
		else
		{
			redirect('fguru/pengembangan/index/'.$kat);		
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catatan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('mnaik','',TRUE);
		$this->load->model('mmenu','',TRUE);
		
		if($this->session->userdata('level') == '' || $this->session->userdata('kd_ta') == '')
		{
			redirect('login/logout');
		}
	}

	function index($short_by='a.nama',$short_order='asc')
	{
		$data = array(
			'main'			=> 'fguru/daftar_catat',
			'catat'			=> 'class="active"',
			'type'			=> 'a',
			'kueri'			=> $this->mnaik->getSiswaKelas($short_by,$short_order),
			'sort_by'		=> $short_by,
			'sort_order'	=> $short_order,
			'menu'			=> $this->mmenu->getTeamTeaching(),
			'id_kelas_sis'	=> $this->mnaik->getIdKelas()
		);
		$this->load->view('fguru/template',$data);
	}
	
	function submit_catatan($kls,$id,$catat=NULL)
	{
		if($catat != "")
		{
			$data_jum = $this->mnaik->addCatat($kls,$id,$catat);
			if($this->db->affected_rows() > 0)
			{
				echo $this->db->insert_id();
			}
			else
			{
				echo "gagal";
			}
		}
	}
	
	function submit_edit_catatan($id,$catat)
	{
		if($catat != "")
		{
			$data_jum = $this->mnaik->updateCatat($id,$catat);
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
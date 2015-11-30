<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kkm extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('mkkm','',TRUE);
		
		if($this->session->userdata('level') == '' || $this->session->userdata('kd_ta') == '')
		{
			redirect('home');
		}
	}

	function index($short_by='mapel',$short_order='asc')
	{
		$data = array(
			'main'			=> 'daftar_kkm',
			'setting'		=> 'class="active"',
			'type'			=> 'a',
			'kueri'			=> $this->mkkm->getKkm($short_by,$short_order),
			'sort_by'		=> $short_by,
			'sort_order'	=> $short_order
		);
		$this->load->view('template',$data);
	}
	
	function input_nilai($nip,$id,$kelas,$stat,$biji)
	{
		$this->mkkm->addNilai($nip,$id,$kelas,$stat,$biji,0);
		if($this->db->affected_rows() > 0)
		{
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}
	
	function input_kkm($kkm1=NULL,$kkm2=NULL,$kkm3=NULL,$kode=NULL)
	{
		if($kkm1 != "" && $kkm2 != "" && $kkm3 != "")
		{
			$this->mkkm->addKkm($kkm1,$kkm2,$kkm3,$kode);
		}
		if($this->db->affected_rows() > 0)
		{
			echo $this->db->insert_id();
		}
		else
		{
			echo "gagal";
		}
	}
	
	function update_kkm($kkm1,$kkm2,$kkm3,$kode)
	{
		$this->mkkm->updateKkm($kkm1,$kkm2,$kkm3,$kode);
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
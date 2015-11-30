<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kenaikan extends CI_Controller {

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
		$arey = array('X','XI','XII');
		$kelas = $this->mnaik->getIdKelas();
		$tingkat = $this->mnaik->getTingkatKelas();
		$lihat = array_search($tingkat->tingkat,$arey);
		$indeks = $lihat + 1;
		$berikutnya = $this->mnaik->getNextIdKelas($arey[$indeks],$tingkat->id_keahlian,$tingkat->nama);
		$kode = date('Y').(intval(date('Y')) + 1);
		$this->mnaik->updateAngkatan($kelas,$kode);
	
		$data = array(
			'main'			=> 'fguru/daftar_naik',
			'naik'			=> 'class="active"',
			'type'			=> 'a',
			'kueri'			=> $this->mnaik->getSiswaKelas($short_by,$short_order),
			'sort_by'		=> $short_by,
			'sort_order'	=> $short_order,
			'menu'			=> $this->mmenu->getTeamTeaching(),
			'id_kelas_sis'	=> $kelas,
			'next'			=> $berikutnya,
			'kode'			=> $kode
		);
		$this->load->view('fguru/template',$data);
	}
	
	function input($kls,$id,$stat,$next,$kode)
	{
		$data_jum = $this->mnaik->cekNaik($kls,$id);
		if($data_jum > 0)
		{
			if($this->mnaik->cekStatNaik($kls,$id) == 1)
			{
				$this->mnaik->updateNaik($kls,$id,0);
				$this->mnaik->updateKelasBaru($id,$kls,$kode);
			}
			else
			{
				$this->mnaik->updateNaik($kls,$id,1);
				$this->mnaik->updateKelasBaru($id,$next,$kode);
			}
		}
		else
		{
			$this->mnaik->addNaik($kls,$id,$stat);
			$this->mnaik->updateKelasBaru($id,$next,$kode);
		}
		if($this->db->affected_rows() > 0)
		{
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}
	
	function update($kls,$id,$stat,$next,$kode)
	{
		$this->mnaik->updateNaik($kls,$id,$stat);
		if($stat == 1)
		{
			$this->mnaik->updateKelasBaru($id,$next,$kode);
		}
		else
		{
			$this->mnaik->updateKelasBaru($id,$kls,$kode);
		}
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
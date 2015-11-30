<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrasi extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('madministrasi','',TRUE);
		$this->load->model('mmenu','',TRUE);
		
		if($this->session->userdata('level') == '' || $this->session->userdata('kd_ta') == '')
		{
			redirect('login/logout');
		}
	}

	function index()
	{
		$data = array(
			'main'		=> 'fguru/administrasi',
			'adminis'	=> 'class="active"',
			'type'		=> 'a',
			'menu'		=> $this->mmenu->getTeamTeaching(),
			'mapels'		=> $this->madministrasi->getMapells()
		);
		$this->load->view('fguru/template',$data);
	}
	
	function daftar($id,$short_by='administrasi',$short_order='asc')
	{
		if($id == "" || $id == 0)
		{
			redirect('fguru/nilai');		
		}
		$this->load->helper('shorting');

		$query = $this->madministrasi->getAdministrasi($id,$short_by,$short_order);
				
		$data = array(
			'kueri' 			=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'main'			=> 'fguru/daftar_administrasi',
			'adminis'		=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'urs'				=> 3,
			'ref'				=> 'refresh',
			'id'				=> $id,
			'menu'			=> $this->mmenu->getTeamTeaching()
		);

		$this->load->view('fguru/template',$data);	
	}
	
	function submit_administrasi()
	{
		$kunci = $this->input->post('mapel',TRUE);
		redirect('fguru/administrasi/daftar/'.$kunci);	
	}
	
	function add_sk($id)
	{
		if($id == "")
		{
			redirect('fguru/administrasi');		
		}	
	
		$this->load->library('arey');	
	
		$data = array(
			'main'		=> 'fguru/add_sk',
			'adminis'	=> 'class="active"',
			'type'		=> 'b',
			'tambah'		=> 'class="active"',
			'id'			=> $id,
			'jml'			=> $this->arey->getJam(),
			'menu'		=> $this->mmenu->getTeamTeaching()
		);
		$this->load->view('fguru/template',$data);
	}
	
	function edit_sk($id,$kode)
	{
		if($id == "")
		{
			redirect('fguru/administrasi');		
		}	
	
		$this->load->library('arey');	
	
		$data = array(
			'main'		=> 'fguru/edit_sk',
			'adminis'	=> 'class="active"',
			'type'		=> 'b',
			'daftar'		=> 'class="active"',
			'id'			=> $id,
			'jml'			=> $this->arey->getJam(),
			'kode'		=> $kode,
			'kueri'		=> $this->madministrasi->getIdAdministrasi($kode),
			'menu'		=> $this->mmenu->getTeamTeaching()
		);
		$this->load->view('fguru/template',$data);
	}
	
	function add_kd($id)
	{
		if($id == "")
		{
			redirect('fguru/administrasi');		
		}	
	
		$this->load->library('arey');	
	
		$data = array(
			'main'		=> 'fguru/add_kd',
			'adminis'	=> 'class="active"',
			'type'		=> 'b',
			'tambah1'	=> 'class="active"',
			'id'			=> $id,
			'jml'			=> $this->arey->getJam(),
			'sk'			=> $this->madministrasi->getSk($id),
			'menu'		=> $this->mmenu->getTeamTeaching()
		);
		$this->load->view('fguru/template',$data);
	}
	
	function edit_kd($id,$kode)
	{
		$data = array(
			'main'		=> 'fguru/edit_kd',
			'adminis'	=> 'class="active"',
			'type'		=> 'b',
			'daftar'		=> 'class="active"',
			'id'			=> $id,
			'kueri'		=> $this->madministrasi->getIdAdministrasi($kode),
			'menu'		=> $this->mmenu->getTeamTeaching()
		);
		$this->load->view('fguru/template',$data);
	}
	
	function submit_kd($id)
	{
		foreach($this->input->post('judul',TRUE) as $judul)
		{
			$this->madministrasi->addAdministrasi($id,$judul,$this->input->post('sk',TRUE),1);
		}	
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Administrasi Berhasil Disimpan');	
			echo $id;
		}
		else
		{
			$this->message->set('notice','Administrasi Gagal Disimpan');
			echo "gagal";
		}
	}
	
	function submit_edit_sk($id,$kode)
	{
		$this->madministrasi->updateAdministrasi($kode);	
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Administrasi Berhasil Disimpan');
			echo $id;
		}
		else
		{
			$this->message->set('notice','Administrasi Gagal Disimpan');
			echo "gagal";
		}
	}
	
	function submit_sk($id)
	{
		foreach($this->input->post('judul',TRUE) as $judul)
		{
			$id_mapel = $this->madministrasi->getIdMapel($id,$this->session->userdata('nip'));
			$this->madministrasi->addAdministrasi($id,$judul,$id_mapel,0);
		}	
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Administrasi Berhasil Disimpan');
			echo $id;
		}
		else
		{
			$this->message->set('notice','Administrasi Gagal Disimpan');
			echo "gagal";
		}
	}
	
	function submit_edit_kd($id,$kode)
	{
		$this->madministrasi->updateAdministrasi($kode);	
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Administrasi Berhasil Disimpan');
			echo $id;
		}
		else
		{
			$this->message->set('notice','Administrasi Gagal Disimpan');
			echo "gagal";
		}
	}
	
	function add_indikator($id)
	{
		if($id == "")
		{
			redirect('fguru/administrasi');		
		}	
	
		$this->load->library('arey');	
	
		$data = array(
			'main'		=> 'fguru/add_indikator',
			'adminis'	=> 'class="active"',
			'type'		=> 'b',
			'tambah2'	=> 'class="active"',
			'id'			=> $id,
			'jml'			=> $this->arey->getJam(),
			'kd'			=> $this->madministrasi->getKd($id),
			'menu'		=> $this->mmenu->getTeamTeaching()
		);
		$this->load->view('fguru/template',$data);
	}
	
	function edit_indikator($id,$kode)
	{
		$data = array(
			'main'		=> 'fguru/edit_indikator',
			'adminis'	=> 'class="active"',
			'type'		=> 'b',
			'daftar'		=> 'class="active"',
			'id'			=> $id,
			'kueri'		=> $this->madministrasi->getIdAdministrasi($kode),
			'menu'		=> $this->mmenu->getTeamTeaching()
		);
		$this->load->view('fguru/template',$data);
	}
	
	function submit_indikator($id)
	{
		foreach($this->input->post('judul',TRUE) as $judul)
		{
			$this->madministrasi->addAdministrasi($id,$judul,$this->input->post('kd',TRUE),2);
		}	
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Administrasi Berhasil Disimpan');
			echo $id;
		}
		else
		{
			$this->message->set('notice','Administrasi Gagal Disimpan');
			echo "gagal";
		}
	}
	
	function submit_edit_indikator($id,$kode)
	{
		$this->madministrasi->updateAdministrasi($kode);	
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Administrasi Berhasil Disimpan');
			echo $id;
		}
		else
		{
			$this->message->set('notice','Administrasi Gagal Disimpan');
			echo "gagal";
		}
	}
	
	function hapus($id,$kode)
	{
		$this->madministrasi->delKd($kode);
		$this->madministrasi->delIndikator($kode);
		$this->message->set('succes','Administrasi Berhasil Dihapus');		
		redirect('fguru/administrasi/daftar/'.$id);
	}
}
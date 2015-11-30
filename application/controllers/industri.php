<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Industri extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('mindustri','',TRUE);
	}

	function index()
	{
		redirect('industri/daftar_industri');		
	}
	
	function daftar_industri($kls=NULL,$short_by='b.nama',$short_order='asc')
	{
		$this->load->helper('shorting');

		$query = $this->mindustri->getSiswaKelas($kls,$short_by,$short_order);
				
		$data = array(
			'kueri' 			=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'main'			=> 'daftar_industri',
			'dudi'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'a',
			'daftar'			=> 'class="active"',
			'klas'			=> $this->mindustri->getKelas(),
			'kls'				=> $kls
		);

		$this->load->view('template',$data);	
	}
	
	function submit_industri()
	{
		$kelas = $this->input->post('kelas',TRUE);
		redirect('industri/daftar_industri/'.$kelas);	
	}
	
	function input_nilai($kls,$nip)
	{
		$this->mindustri->addNilai($kls,$nip);
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Nilai DU/DI siswa Berhasil Ditambah');
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}
	
	function update_nilai($id)
	{
		$this->mindustri->updateNilai($id);
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Nilai DU/DI siswa Berhasil Diupdate');
		}
		else
		{
			$this->message->set('error','Nilai DU/DI siswa Gagal Diupdate');
		}
		echo "ok";
	}
	
	function form_nilai($kls,$nis)
	{			
		$data = array(
			'main'			=> 'add_industri',
			'dudi'			=> 'class="active"',
			'type'			=> 'a',
			'daftar'			=> 'class="active"',
			'kls'				=> $kls,
			'nis'				=> $nis
		);

		$this->load->view('template',$data);		
	}
	
	function form_edit_nilai($kls,$id)
	{
		$data = array(
			'kueri'			=> $this->mindustri->getNilaiId($id),		
			'main'			=> 'edit_industri',
			'dudi'			=> 'class="active"',
			'type'			=> 'a',
			'daftar'			=> 'class="active"',
			'id'				=> $id,
			'kls'				=> $kls
		);

		$this->load->view('template',$data);
	}
}
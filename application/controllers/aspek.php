<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aspek extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('maspek','',TRUE);
		
		if($this->session->userdata('level') == '' || $this->session->userdata('kd_ta') == '')
		{
			redirect('home');
		}
	}

	function index()
	{
		redirect('aspek/nilai/1');
	}

	function nilai($id,$short_by='mapel')
	{		
		$this->load->helper('rumus');	
		$aspeke = ($id == 1)?"KD":"Aspek";
	
		$data = array(
			'main'			=> 'daftar_aspek',
			'aspek'			=> 'class="active"',
			'type'			=> 'a',
			'daftar'		=> 'class="active"',
			'kueri'			=> $this->maspek->getAspek($id,$short_by),
			'sort_by'		=> $short_by,
			'id'			=> $id,
			'aspeke'		=> $aspeke
		);
		$this->load->view('template',$data);
	}	

	public function edit_aspek($kode,$id,$order)
	{		
		$cekSpek = $this->maspek->getCekAspek($id);

		if($kode != 1 && !$cekSpek)
		{
			$this->message->set('notice','KD Pengetahuan Belum Ditentukan');
			redirect('aspek/nilai/'.$kode);
		}

		$aspekene = array(
			'1'			=> 'Pengetahuan',
			'2'			=> 'Keterampilan',
			'3'			=> 'Sikap'
		);

		$this->load->library('arey');
		$isine = ($kode == 1)?"KD":"Aspek";

		$data = array(
			'main'			=> 'add_aspek',
			'aspek'			=> 'class="active"',
			'type'			=> 'a',
			'tambah'		=> 'class="active"',
			'kueri'			=> $this->maspek->getAspekAll($kode,$id),
			'tingkat'		=> $this->arey->getTingkat(),
			'mapele'		=> $this->maspek->getMapel(),
			'id'			=> $id,
			'kode'			=> $kode,
			'order'			=> $order,
			'keterangan'	=> $aspekene[$kode],
			'isine'			=> $isine
		);
		$this->load->view('template',$data);
	}
	
	function input_aspek($kode,$id,$mapel)
	{
		$this->maspek->addAspek($kode,$id);

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Aspek Nilai Berhasil Disimpan');
		}
		else
		{
			$this->message->set('notice','Aspek Nilai Gagal Disimpan');
		}
	}

	function hapus($id)
	{
		$alamat = $this->input->post('alamat',TRUE);
		if($this->input->post('cek',TRUE) != "")
		{
			foreach($this->input->post('cek',TRUE) as $cek)
			{
				$this->maspek->delAspekPeng($cek,$id);
			}
			$this->message->set('succes','Aspek Pengetahuan Berhasil Dihapus');
			redirect($alamat);
		}
		else
		{
			$this->message->set('notice','Aspek Pengetahuan Gagal Dihapus');
			redirect($alamat);		
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
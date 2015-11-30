<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kenaikan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('mkenaikan','',TRUE);
		$this->load->library(array('page','arey'));

		//http://85038.zbigz.com/f/8fa2bf4890023eb94935eb18a32291e5/FuckTeamFive%20-%20Katja%20Kassin%2C%20Gianna%20Lynn%2C%20Ava%20Rose%20%28FuckTeam%20Recordings%29%20SD%20480p%20August%2022%2C%202008.mp4
	}

	function index($kelas=0,$short_by='c.nama',$short_order='asc')
	{
		$d_ta = $this->mkenaikan->getTingkatTa();
		if($d_ta['berikut'] == "0")
		{
			redirect('kenaikan/error');
		}

		$this->load->library('arey');		

		$query = $this->mkenaikan->getKelass($kelas,$short_by,$short_order,$d_ta['berikut']['id']);		
		$tingkat = $this->mkenaikan->getTingkatKelas($kelas);		
		$next_kelas = $this->mkenaikan->getNextDKelas($tingkat);
		$next_kelas = array_filter($next_kelas);

		if (empty($next_kelas)) 
		{
			$this->message->set('notice','Silahkan diisikan tingkat kelas diatasnya terlebih dahulu');
		}		
				
		$data = array(
			'kueri' 		=> $query,						
			'main'			=> 'daftar_kenaikan',
			'kenaikan'		=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'a',			
			'klas'			=> $this->mkenaikan->getKelas(),
			'kls'			=> $kelas,
			'ref'			=> $this->uri->segment(2),
			'd_ta'			=> $d_ta,
			'Nklas'			=> $next_kelas,
		);
		
		$this->load->view('template',$data);		
	}	

	function pilih_kelas()
	{	
		$kelas = $this->input->post('kelas');
		if($kelas == 0)
		{
			redirect('kenaikan/index');
		}
		else
		{
			redirect('kenaikan/index/'.$kelas);
		}
	}

	public function naik_kelas()
	{
		$tujuan = $this->input->post('Nkelas',TRUE);
		$ta_berikut = $this->input->post('ta_berikut',TRUE);
		$alamat = $this->input->post('alamat',TRUE);
		if($this->input->post('cek',TRUE) != "")
		{
			foreach($this->input->post('cek',TRUE) as $cek)
			{
				$this->mkenaikan->setNaik($cek,$tujuan,$ta_berikut);				
			}			
			$this->message->set('succes','Kenaikan Kelas Siswa Berhasil');
			redirect($alamat);
		}
		else
		{
			$this->message->set('notice','Tidak Ada Siswa yang Dipilih');
			redirect($alamat);
		}		
	}

	public function error()
	{
		echo "Ini halaman error";
	}
}

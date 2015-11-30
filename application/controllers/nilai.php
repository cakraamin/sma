<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nilai extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('mrumus','',TRUE);
		
		if($this->session->userdata('level') == '' || $this->session->userdata('kd_ta') == '')
		{
			redirect('home');
		}
	}

	function index($short_by='mapel',$short_order='asc')
	{
		$this->load->helper('rumus');	
	
		$data = array(
			'main'			=> 'daftar_nilai',
			'setting'		=> 'class="active"',
			'type'			=> 'a',
			'kueri'			=> $this->mrumus->getRumus($short_by,$short_order),
			'sort_by'		=> $short_by,
			'sort_order'	=> $short_order
		);
		$this->load->view('template',$data);
	}
	
	function input_rumus($rumus1,$rumus2,$rumus3,$kode)
	{
		if($rumus1 != 0 && $rumus2 != 0 && $rumus3 != 0)
		{
			$this->mrumus->addRumus($rumus1,$rumus2,$rumus3,$kode);
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
	
	function update_rumus($rumus1,$rumus2,$rumus3,$kode)
	{
		$this->mrumus->updateRumus($rumus1,$rumus2,$rumus3,$kode);
		if($this->db->affected_rows() > 0)
		{
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}

	function pilih($id=NULL)
	{
		if($id == "")
		{
			$data = array(
				'main'		=> 'nilai',
				'nilai'		=> 'class="active"',
				'type'		=> 'a',
				'mapels'	=> $this->mrumus->getMapells()
			);
			$this->load->view('template',$data);
		}
		else
		{
			$mapel = $this->mrumus->getMapel($id);
			redirect('nilai/daftar/'.$id.'/'.$mapel);	
		}
	}

	function submit_nilai()
	{
		$kunci = $this->input->post('mapel',TRUE);
		redirect('nilai/pilih/'.$kunci);
	}

	function daftar($id,$jenis=NULL,$kls=NULL,$kes=NULL,$short_by='b.nama',$short_order='asc')
	{
		if($id == "" || $id == 0)
		{
			redirect('nilai/pilih');		
		}
		$this->load->helper('shorting');
		$nilai = $this->mrumus->getMenu($id);
		if($nilai->harian == 0 && $nilai->tugas == 0 && $nilai->ulangan == 0)
		{
			$this->message->set('error','Maaf Mata Pelajaran Belum Diset Setting Penilaian');
			redirect('nilai/pilih');		
		}

		$query = $this->mrumus->getSiswaKelas($kls,$short_by,$short_order);
		$klassss = $this->mrumus->getKelas($id);
		foreach($klassss as $dt_klassss)
		{
			$data_array = $dt_klassss;
		}
		if(count($klassss) > 0 && empty($data_array))
		{
			redirect('nilai/pilih');
		}
				
		$data = array(
			'kueri' 			=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'main'			=> 'daftar_nilais',
			'nilai'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'urs'				=> 3,
			'ref'				=> 'refresh',
			'id'				=> $id,
			'ref'				=> 'refresh/'.$id,
			'klas'			=> $klassss,
			'kls'				=> $kls,
			'mnu'				=> $nilai,
			'jenis'			=> $jenis,
			'tingkat'		=> 1,
			'kes'				=> $kes
		);

		$this->load->view('template',$data);	
	}

	function daftar_tugas($id,$jenis=NULL,$kls=NULL,$kes=NULL,$short_by='b.nama',$short_order='asc')
	{
		if($id == "" || $id == 0)
		{
			redirect('nilai/pilih');		
		}
		$this->load->helper('shorting');
		$nilai = $this->mrumus->getMenu($id);
		if($nilai->harian == 0 && $nilai->tugas == 0 && $nilai->ulangan == 0)
		{
			$this->message->set('error','Maaf Mata Pelajaran Belum Diset Setting Penilaian');
			redirect('nilai/daftar_tugas');		
		}

		$query = $this->mrumus->getSiswaKelas($kls,$short_by,$short_order);
		$klassss = $this->mrumus->getKelas($id);
		if($klassss == 0)
		{
			redirect('nilai/pilih');
		}
				
		$data = array(
			'kueri' 			=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'main'			=> 'daftar_nilais',
			'nilai'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftart'		=> 'class="active"',
			'urs'				=> 3,
			'ref'				=> 'refresh',
			'id'				=> $id,
			'ref'				=> 'refresh/'.$id,
			'klas'			=> $klassss,
			'stat'			=> $this->mrumus->getStat($id),
			'kls'				=> $kls,
			'mnu'				=> $nilai,
			'jenis'			=> $jenis,
			'tingkat'		=> 2,
			'kes'				=> $kes
		);

		$this->load->view('template',$data);	
	}
	
	function daftar_ulangan($id,$jenis=NULL,$kls=NULL,$short_by='b.nama',$short_order='asc')
	{
		if($id == "" || $id == 0)
		{
			redirect('nilai/pilih');		
		}
		$this->load->helper('shorting');
 		$nilai = $this->mrumus->getMenu($id);
		if($nilai->harian == 0 && $nilai->tugas == 0 && $nilai->ulangan == 0)
		{
			$this->message->set('error','Maaf Mata Pelajaran Belum Diset Setting Penilaian');
			redirect('nilai/daftar_ulangan');		
		}

		$query = $this->mrumus->getSiswaKelas($kls,$short_by,$short_order);
		$klassss = $this->mrumus->getKelas($id);
		if($klassss == 0)
		{
			redirect('nilai/pilih');
		}
				
		$data = array(
			'kueri' 			=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'main'			=> 'daftar_nilais',
			'nilai'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftars'		=> 'class="active"',
			'urs'				=> 3,
			'ref'				=> 'refresh',
			'id'				=> $id,
			'ref'				=> 'refresh/'.$id,
			'klas'			=> $klassss,
			'stat'			=> $this->mrumus->getStat($id),
			'kls'				=> $kls,
			'mnu'				=> $nilai,
			'jenis'			=> $jenis,
			'tingkat'		=> 3,
			'kes'				=> ""
		);
		$this->load->view('template',$data);	
	}
	
	function daftar_akhir($id,$jenis=NULL,$kls=NULL,$short_by='b.nama',$short_order='asc')
	{
		if($id == "" || $id == 0)
		{
			redirect('nilai/pilih');		
		}
		$this->load->helper('shorting');
		$nilai = $this->mrumus->getMenu($id);
		if($nilai->harian == 0 && $nilai->tugas == 0 && $nilai->ulangan == 0)
		{
			$this->message->set('error','Maaf Mata Pelajaran Belum Diset Setting Penilaian');
			redirect('nilai/daftar_ulangan');		
		}

 		$query = $this->mrumus->getSiswaKelas($kls,$short_by,$short_order);
		$klassss = $this->mrumus->getKelas($id);
		if($klassss == 0)
		{
			redirect('nilai/pilih');
		}
				
		$data = array(
			'kueri' 			=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'main'			=> 'daftar_nilais',
			'nilai'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftara'		=> 'class="active"',
			'urs'				=> 3,
			'ref'				=> 'refresh',
			'id'				=> $id,
			'ref'				=> 'refresh/'.$id,
			'klas'			=> $klassss,
			'stat'			=> $this->mrumus->getStat($id),
			'kls'				=> $kls,
			'mnu'				=> $nilai,
			'jenis'			=> $jenis,
			'tingkat'		=> 4,
			'kes'				=> ""
		);
		$this->load->view('template',$data);	
	}
	
	function submit_kategori($alamat,$id,$jenis)
	{
		$kelas = $this->input->post('kelas',TRUE);
		$ke = $this->input->post('ke',TRUE);
		if($kelas == "")
		{
			redirect('nilai/'.$alamat.'/'.$id.'/'.$jenis);
		}
		else
		{
			redirect('nilai/'.$alamat.'/'.$id.'/'.$jenis.'/'.$kelas.'/'.($ke + 1));
		}	
	}
	
	function submit_kategoris($id)
	{
		$kelas = $this->input->post('kelas',TRUE);
		if($kelas == "")
		{
			redirect('nilai/daftar_ulangan/'.$id);
		}
		else
		{
			redirect('nilai/daftar_ulangan/'.$id.'/'.$kelas);
		}	
	}
	
	function input_nilai($nip,$id,$kelas,$stat,$biji,$tingkat,$ket=NULL)
	{
		$this->mrumus->addNilai($nip,$id,$kelas,$stat,$biji,$tingkat,$ket);
		if($this->db->affected_rows() > 0)
		{
			echo $this->db->insert_id();
		}
		else
		{
			echo "gagal";
		}
	}
	
	function cek_nilai($nip,$id,$kelas,$tingkat,$ket=NULL)
	{
		$kueri = $this->mrumus->cekNilai($nip,$id,$kelas,$tingkat,$ket);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			$hasil = array(
				'status'	=> 'ok',
				'id'		=> $data->id_nilai,
				'nilai'		=> $data->nilai
			);			
		}
		else
		{
			$hasil = array(
				'status'	=> 'gagal'
			);		
		}
		echo json_encode($hasil);
	}
	
	function input_nilaiu($nip,$id,$kelas,$biji)
	{
		$this->mrumus->addNilai($nip,$id,$kelas,0,$biji,1);
		if($this->db->affected_rows() > 0)
		{
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}
	
	function update_nilai($id,$biji)
	{
		$this->mrumus->updateNilai($id,$biji);
		if($this->db->affected_rows() > 0)
		{
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}
	
	function upload($id,$kls,$tingkat,$ket)
	{
		$config['upload_path'] = './temp/';
		$config['allowed_types'] = 'csv|xls';
		$config['max_size']	= '50000';	
		$config['remove_spaces'] = TRUE;			
				
		$this->load->library('upload', $config);
		$uplod = $this->upload->do_upload("uploadfile");
		
		$file = str_replace(" ","_",$_FILES['uploadfile']['name']);
			
		if ( !$uplod )
		{		    	
			echo "gagal";
		}
		else
		{
			$filename = './temp/'.$file;
		
			$this->load->library('excel');
			$data = $this->excel->reader($filename);
			$no = 0;
			foreach($data as $dt_excel)
			{
				if($no > 0)
				{
					if($this->mrumus->cekNilais($dt_excel['A'],$id,$kls,$tingkat,$ket) == 0)
					{
						$this->mrumus->addNilai($dt_excel['A'],$id,$kls,$dt_excel['C'],$tingkat,$ket);
					}
					else
					{	
						$this->mrumus->updateNilais($dt_excel['A'],$id,$kls,$dt_excel['C'],$tingkat,$ket);
					}
				}
				$no++;
			}
			if($this->db->affected_rows() > 0)
			{
				echo "ok";
			}
			else
			{
				echo "gagals";
			}
			unlink($filename);
		}
	}

	function sample($id)
	{
		$query = $this->mrumus->getExportSiswaKelas($id);
			 
		$this->load->helper('xls');
		query_to_xls($query, TRUE, 'daftar_nilai.xls');
		/*$this->load->helper('download');

		$data = file_get_contents(base_url()."sample/Nilai.csv");
		$name = 'Nilai.csv';

		force_download($name, $data);*/ 
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
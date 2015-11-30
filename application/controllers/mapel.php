<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mapel extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('page');
		$this->load->model('mmapel','',TRUE);
		
		if($this->session->userdata('id') == '' || $this->session->userdata('kd_ta') == '')
		{
			redirect('home');
		}
	}

	function index()
	{
		redirect('mapel/daftar');
	}
	
	function daftar($short_by='mapel',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
		$this->load->library('arey');
	
		$total_page = $this->db->count_all('mapel');
		$per_page = 20;
		$url = 'mapel/daftar/'.$short_by.'/'.$short_order.'/';

		$query = $this->mmapel->getMapel($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('mapel/daftar/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 			=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'daftar_mapel',
			'mapel'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'urs'				=> 3,
			'ref'				=> $this->uri->segment(2)
		);
		
		$this->load->view('template',$data);
	}

	function guru_kelas($kelas=0,$short_by='mapel',$short_order='asc')
	{		
		$this->load->library('arey');				
				
		$data = array(
			'kueri' 		=> $this->mmapel->getMapelKelase($kelas),						
			'main'			=> 'mapel_kelas',
			'mapel'			=> 'class="active"',			
			'type'			=> 'a',
			'daftar'		=> 'class="active"',
			'urs'			=> 3,
			'ref'			=> $this->uri->segment(2),
			'kls'			=> $kelas,
			'klas'			=> $this->mmapel->getKelasMu()
		);
		
		$this->load->view('template',$data);
	}

	function tambah_guru_kelas($jenis,$kelas)
	{
		if($jenis == "" AND $kelas == "")
		{
			$this->message->set('notice','Parameter Salah');
			redirect('mapel/guru_kelas');
		}

		$this->load->library('arey');				

		$data = array(
			'kueri' 		=> $this->mmapel->getMapelKelase($kelas),						
			'main'			=> 'add_guru_kelas',
			'mapel'			=> 'class="active"',			
			'type'			=> 'a',
			'daftar'		=> 'class="active"',
			'urs'			=> 3,
			'ref'			=> $this->uri->segment(2),
			'kls'			=> $kelas,
			'jenis'			=> $jenis,			
			'mapels'		=> $this->mmapel->getMapellsById($jenis)
		);
		
		$this->load->view('template',$data);
	}

	public function edit_mapel_kelas($id,$jenis,$kelas)
	{
		if($id == "")
		{
			$this->message->set('notice','Parameter Salah');
			redirect('mapel/guru_kelas');
		}

		$this->load->library('arey');				

		$data = array(			
			'main'			=> 'edit_guru_kelas',
			'mapel'			=> 'class="active"',			
			'type'			=> 'a',
			'daftar'		=> 'class="active"',
			'urs'			=> 3,
			'jenis'			=> $jenis,
			'kls'			=> $kelas,
			'ref'			=> $this->uri->segment(2),			
			//'klas'			=> $this->mmapel->getKelasMu(),
			'mapels'		=> $this->mmapel->getMapellsById($jenis),
			'kueri'			=> $this->mmapel->getDetailMapels($id),
			'id'			=> $id
		);
		
		$this->load->view('template',$data);
	}

	public function update_guru_kelas($id,$kelas)
	{
		$pecah = explode("-", $id);
		$Team = $this->mmapel->getDetailTeam($this->input->post('mapel',TRUE));
		if(count($Team) < count($pecah))
		{			
			$this->mmapel->updateGuruKelasKecil($id,$Team);
		}
		elseif(count($Team) > count($pecah))
		{
			$this->mmapel->updateGuruKelasBesar($id,$Team,$kelas);	
		}
		else
		{			
			$this->mmapel->updateGuruKelas($id,$Team);
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

	public function simpan_guru_kelas($jenis,$kelas)
	{
		$Team = $this->mmapel->getDetailTeam($this->input->post('mapel',TRUE));
		$this->mmapel->addGuruKelas($kelas,$Team);
		if($this->db->affected_rows() > 0)
		{
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}

	public function submit_guru_kelas()
	{
		$kelas = $this->input->post('kelas',TRUE);
		if($kelas == 0)
		{
			redirect('mapel/guru_kelas');
		}
		else
		{
			redirect('mapel/guru_kelas/'.$kelas);
		}
	}
	
	function add_mapel()
	{
		$this->load->library('arey');	
	
		$data = array(	  
			'mapel'			=> 'class="active"',
			'main'			=> 'mapel',
			'type'			=> 'b',
			'tambah'		=> 'class="active"',
			'jam'			=> $this->arey->getJam(),
			'jenis'			=> $this->arey->getKelompok()
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_mapel()
	{
		if($this->mmapel->cekMapel() > 0)
		{
			echo "exist";
			exit();		
		}
		else
		{
			$this->mmapel->addMapel();
			if($this->db->affected_rows() > 0)
			{
				$this->message->set('succes','Mata Pelajaran Berhasil Ditambah');
				echo "ok";
			}
			else
			{
				echo "gagal";
			}
		}
	}
	
	function submit_edit_mapel($id)
	{
		if($this->mmapel->cekMapels($id) > 0)
		{
			echo "exist";
			exit();		
		}
		else
		{
			$this->mmapel->updateMapel($id);
			if($this->db->affected_rows() > 0)
			{
				$this->message->set('succes','Mata Pelajaran Berhasil Diupdate');
			}
			else
			{
				$this->message->set('error','Mata Pelajaran Gagal Diupdate');
			}
			echo "edit";
		}
	}
	
	function del_mapel()
	{
		$alamat = $this->input->post('alamat',TRUE);
		if($this->input->post('cek',TRUE) != "")
		{
			foreach($this->input->post('cek',TRUE) as $cek)
			{
				$this->mmapel->delMapel($cek);
			}
			$this->message->set('succes','Siswa Berhasil Dihapus');
			redirect($alamat);
		}
		else
		{
			$this->message->set('notice','Tidak Ada Siswa Yang Dipilih');
			redirect($alamat);		
		}
	}
	
	function edit_mapel($id)
	{
		$this->load->library('arey');
		$this->load->helper('edit');		
	
		$data = array(	  
			'mapel'			=> 'class="active"',
			'main'			=> 'edit_mapel',
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'kueri'			=> $this->mmapel->getMapelId($id),
			'jam'			=> $this->arey->getJam(),
			'jenis'			=> $this->arey->getKelompok()
		);
			
		$this->load->view('template',$data);
	}
	
	function export()
	{
		$data = array(	  
			'kelas'			=> 'class="active"',
			'main'			=> 'export_kelas',
			'type'			=> 'b',
			'export'		=> 'class="active"'
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_export_kelas()
	{
		$nama = strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))));
		if($this->input->post('format') == 'csv')
		{
			$query = $this->mmapel->exportKelas();
 
			$this->load->helper('csv');
			query_to_csv($query, FALSE, str_replace(" ","_",$nama).'.csv');
		}
		else
		{
			$query = $this->mmapel->exportKelas();
			 
			$this->load->helper('xls');
			query_to_xls($query, FALSE, str_replace(" ","_",$nama).'.xls');
		}
	}
	
	function submit_cari()
	{
		$kunci = strip_tags(ascii_to_entities(addslashes($this->input->post('kunci',TRUE))));
		if($kunci == "")
		{
			redirect('mapel/daftar');
		}
		else
		{
			redirect('mapel/cari/'.$kunci);
		}
	}
	
	function cari($kunci,$short_by='a.nama',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->db->count_all("mapel WHERE mapel LIKE '%".$kunci."%'");
		$per_page = 20;
		$url = 'mapel/cari/'.$kunci.'/'.$short_by.'/'.$short_order.'/';

		$query = $this->mmapel->searchMapel($kunci,$per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('mapel/cari/'.$kunci.'/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 			=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=6),
			'main'			=> 'daftar_mapel',
			'mapel'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'urs'				=> 4,
			'kunci'			=> $kunci,
			'ref'				=> $this->uri->segment(2)
		);
		
		$this->load->view('template',$data);
	}
	
	function import()
	{
		$data = array(	  
			'siswa'			=> 'class="active"',
			'main'			=> 'import_kelas',
			'type'			=> 'b',
			'import'			=> 'class="active"'
		);
			
		$this->load->view('template',$data);
	}
	
	function upload()
	{
		$config['upload_path'] = './temp/';
		$config['allowed_types'] = 'csv|xls';
		$config['max_size']	= '50000';	
		$config['remove_spaces'] = TRUE;			
				
		$this->load->library('upload', $config);
		$uplod = $this->upload->do_upload("uploadfile");
			
		if ( !$uplod )
		{		    	
			echo "gagal";
		}
		else
		{
			$filename = './temp/'.$_FILES['uploadfile']['name'];
		
			if(end(explode(".", $_FILES['uploadfile']['name'])) == 'csv')
			{
				$this->load->helper('csv');
				$pecah = explode("*",csv_to_array($filename));
			}
			else
			{
				$this->load->helper('xls');
				$pecah = explode("*",xls_to_array($filename));
			}
			$this->mmapel->delKelas();
			foreach($pecah as $bagi)
			{
				$pecah1 = explode(",",$bagi);
				if(count($pecah1) == 3)
				{
					$value = "'".$pecah1[0]."','".$pecah1[1]."','".$this->mmapel->getNip($pecah1[2])."'";
					$this->mmapel->importKelas($value);
				}
			}
			if($this->db->affected_rows() > 0)
			{
				echo "<p class='succes'>Import File Berhasil</p>";
			}
			else
			{
				echo "<p class='notice'>Import File Gagal</p>";
			}
			unlink($filename);
		}
	}
	
	function guru_mapel($short_by='b.mapel',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->mmapel->numMapelGuru();
		$per_page = 20;
		$url = 'mapel/guru_mapel/'.$short_by.'/'.$short_order.'/';

		$query = $this->mmapel->getMapelGuru($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('mapel/guru_mapel/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 			=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'daftar_guru_mapel',
			'mapel'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'urs'				=> 3,
			'ref'				=> $this->uri->segment(2)
		);
		
		$this->load->view('template',$data);
	}
	
	function add_guru_mapel()
	{	
		$this->load->library('arey');
	
		$data = array(	  
			'mapel'			=> 'class="active"',
			'main'			=> 'guru_mapel',
			'type'			=> 'b',
			'tambah'		=> 'class="active"',
			'mapels'		=> $this->mmapel->getMapell(),
			'team'			=> $this->arey->getTeam()
		);
			
		$this->load->view('template',$data);
	}

	public function getKodeMapel($id)
	{
		$hasil = $this->mmapel->getKodeMapel($id);
		echo $hasil;
	}
	
	function edit_guru_mapel($id)
	{	
		$this->load->helper('edit');	
	
		$data = array(	  
			'mapel'			=> 'class="active"',
			'main'			=> 'edit_guru_mapel',
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'kueri'			=> $this->mmapel->getIdGuruMapel($id),			
			'mapels'		=> $this->mmapel->getMapell()
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_mapel_guru()
	{
		$team = $this->mmapel->getIdTeam();
		$nilai = '';
		$i = 0;	
		foreach($this->input->post('nip',TRUE) as $nip)
		{
			if($nip != "")
			{
				if($this->mmapel->cekNips($nip) == 0)
				{
					echo "kosong";
					exit();		
				}
				else
				{
					$persen = "";
					$this->mmapel->addMapelGuru($nip,$team,$persen);
				}
				$i++;
			}
		}	
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Guru Mata Pelajaran Berhasil Ditambah');
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}
	
	function submit_edit_mapel_guru($id)
	{
		$no = 0;
		foreach($this->input->post('nip',TRUE) as $nip)
		{
			if($this->mmapel->cekNips($nip) == 0)
			{
				echo "kosong";
				exit();		
			}
			else
			{
				$kd = $_POST['kd'][$no];
				$persen = "";
				$this->mmapel->updateMapelGuru($kd,$nip,$persen);
			}
			$no++;
		}
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Guru Mata Pelajaran Berhasil Diupdate');
		}
		else
		{
			$this->message->set('error','Guru Mata Pelajaran Gagal Diupdate');
		}
		echo "edit";
	}
	
	function del_guru_mapel()
	{
		$alamat = $this->input->post('alamat',TRUE);
		if($this->input->post('cek',TRUE) != "")
		{
			foreach($this->input->post('cek',TRUE) as $cek)
			{
				$this->mmapel->delGuruMapel($cek);
			}
			$this->message->set('succes','Guru Mata Pelajaran Berhasil Dihapus');
			redirect($alamat);
		}
		else
		{
			$this->message->set('notice','Tidak Ada Guru Mata Pelajaran Yang Dipilih');
			redirect($alamat);		
		}
	}
	
	function submit_cari_mapel()
	{
		$kunci = strip_tags(ascii_to_entities(addslashes($this->input->post('kunci',TRUE))));
		if($kunci == "")
		{
			redirect('mapel/guru_mapel');
		}
		else
		{
			redirect('mapel/carimapel/'.$kunci);
		}
	}
	
	function carimapel($kunci,$short_by='b.mapel',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->mmapel->numsearchMapelGuru($kunci);
		$per_page = 20;
		$url = 'mapel/cari/'.$kunci.'/'.$short_by.'/'.$short_order.'/';

		$query = $this->mmapel->searchMapelGuru($kunci,$per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('mapel/carimapel/'.$kunci.'/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 			=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=6),
			'main'			=> 'daftar_guru_mapel',
			'mapel'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'urs'				=> 4,
			'kunci'			=> $kunci,
			'ref'				=> $this->uri->segment(2)
		);
		
		$this->load->view('template',$data);
	}
	
	function guru_mapel_kelas($id=NULL,$short_by='b.nama',$short_order='asc',$page=0)
	{
		$this->load->library('arey');

		if($id == "")
		{	
			$data = array(
				'main'			=> 'daftar_guru_mapel_kelas',
				'mapel'			=> 'class="active"',
				'sort_by' 		=> $short_by,
				'sort_order' 	=> $short_order,
				'type'			=> 'b',
				'tambah'		=> 'class="active"',
				'mapels'		=> $this->mmapel->getMapells()
			);
		}
		else
		{
			$this->load->helper('shorting');
	
			$total_page = $this->mmapel->numMapelGuruKelas($id);
			$per_page = 20;
			$url = 'mapel/guru_mapel_kelas/'.$id.'/'.$short_by.'/'.$short_order.'/';

			$query = $this->mmapel->getMapelGuruKelas($id,$per_page,$page,$short_by,$short_order);
			if(count($query) == 0 && $page != 0)
			{
				redirect('mapel/guru_mapel_kelas/'.$id.'/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
			}
				
			$data = array(
				'kueri' 		=> $query,
				'page'			=> $page,
				'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
				'main'			=> 'daftar_guru_mapel_kelass',
				'mapel'			=> 'class="active"',
				'sort_by' 		=> $short_by,
				'sort_order' 	=> $short_order,
				'type'			=> 'b',
				'daftar'		=> 'class="active"',
				'urs'			=> 3,
				'ref'			=> $this->uri->segment(2)."/".$id,
				'kode'			=> $id,
				'nama'			=> $this->mmapel->getNamaGuru($id)
			);
		}
		
		$this->load->view('template',$data);
	}

	public function daftar_guru_mapel_kelas($kelas=NULL)
	{
		$this->load->library('arey');

		$data = array(
			'main'			=> 'daftare_guru_mapel_kelas',
			'mapel'			=> 'class="active"',			
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'kueri'			=> $this->mmapel->getDaftarGuruMapel($kelas),
			'klas'			=> $this->mmapel->getKelasAnyar(),
			'kls'			=> $kelas,
		);

		$this->load->view('template',$data);
	}

	public function pilih_daftar_kelas()
	{
		redirect('mapel/daftar_guru_mapel_kelas/'.$this->input->post('kelas',TRUE));		
	}
	
	function submit_guru_mapel()
	{
		$kunci = $this->input->post('mapel',TRUE);
		if($kunci == "")
		{
			redirect('mapel/guru_mapel_kelas');
		}
		else
		{
			redirect('mapel/guru_mapel_kelas/'.$kunci);
		}
	}
	
	function add_guru_mapels($id)
	{
		$this->load->library('arey');

		if($id == "")
		{
			redirect('mapel/guru_mapel_kelas');
		}	
		else
		{
			$data = array(	  
				'mapel'			=> 'class="active"',
				'main'			=> 'guru_mapels',
				'type'			=> 'b',
				'tambah'		=> 'class="active"',
				'kelase'		=> $this->mmapel->getKelasAnyar(),
				'kode'			=> $id
			);
			
			$this->load->view('template',$data);
		}	
	}
	
	function submit_guru_kelas_mapel($id)
	{
		$dTeam = $this->mmapel->getDetailTeam($id);

		$this->mmapel->addMapelKelasGuru($id,$dTeam);
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Guru Mata Pelajaran Berhasil Disimpan');
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}
	
	function edit_guru_mapel_kelas($id,$kode)
	{
		$this->load->helper('edit');
		$this->load->library('arey');	
	
		$data = array(	  
			'mapel'			=> 'class="active"',
			'main'			=> 'edit_guru_mapels',
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'kelase'		=> $this->mmapel->getKelasAnyar(),
			'kode'			=> $id,
			'nama'			=> $this->mmapel->getNamaGuru($id),
			'kueri'			=> $this->mmapel->getIdMapelKelas($kode),
			'kodene'		=> $kode
		);
			
		$this->load->view('template',$data);	
	}
	
	function submit_edit_guru_kelas_mapel($id)
	{
		$this->mmapel->updateMapelKelasGuru($id);
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Guru Mata Pelajaran Berhasil Diupdate');
		}
		else
		{
			$this->message->set('error','Guru Mata Pelajaran Gagal Diupdate');
		}
		echo "edit";
	}
	
	function del_guru_mapels($id)
	{
		$alamat = $this->input->post('alamat',TRUE);
		if($this->input->post('cek',TRUE) != "")
		{
			foreach($this->input->post('cek',TRUE) as $cek)
			{
				$pos = strpos($cek, "-");
				if($pos === false)
				{
					$this->mmapel->delGuruMapels($cek);
				}
				else
				{
					$pecah = explode("-", $cek);
					foreach($pecah as $pch)
					{
						$this->mmapel->delGuruMapels($pch);
					}
				}				
			}
			$this->message->set('succes','Guru Mata Pelajaran Berhasil Dihapus');
			redirect($alamat);
		}
		else
		{
			$this->message->set('notice','Tidak Ada Guru Mata Pelajaran Yang Dipilih');
			redirect($alamat);		
		}
	}

	public function hapus_mapel_kelas()
	{
		$alamat = $this->input->post('alamat',TRUE);
		if($this->input->post('cek',TRUE) != "")
		{
			foreach($this->input->post('cek',TRUE) as $cek)
			{
				$pos = strpos($cek, "-");
				if($pos === false)
				{
					$this->mmapel->delGuruMapels($cek);
				}
				else
				{
					$pecah = explode("-", $cek);
					foreach($pecah as $pch)
					{
						$this->mmapel->delGuruMapels($pch);						
					}
				}				
			}
			$this->message->set('succes','Mata Pelajaran Kelas Berhasil Dihapus');
			redirect($alamat);
		}
		else
		{
			$this->message->set('notice','Tidak Ada Mata Pelajaran Kelas Yang Dipilih');
			redirect($alamat);		
		}
	}
	
	function search()
	{
		$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->mmapel->lookup($keyword); 
        if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $data['message'][] = array( 
                                        'id'=>$row->nip,
                                        'value' => $row->nama,
                                        ''
                                     ); 
            }
        }
        if('IS_AJAX')
        {
            echo json_encode($data); 
        }
	}

	function search_mapel($jenis)
	{
		$keyword = $this->input->post('term');
        $data['response'] = 'false'; 
        $query = $this->mmapel->lookup_mapel($keyword,$jenis); 
        if( ! empty($query) )
        {
            $data['response'] = 'true'; 
            $data['message'] = array(); 
            foreach( $query as $row )
            {
                $data['message'][] = array( 
                                        'id'=>$row->id_guru_mapel,
                                        'value' => $row->mapel." : ".$row->nama,
                                        ''
                                     ); 
            }
        }
        if('IS_AJAX')
        {
            echo json_encode($data); 
        }
	}
}
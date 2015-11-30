<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kelas extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('page');
		$this->load->model('mkelas','',TRUE);
		
		if($this->session->userdata('id') == '' || $this->session->userdata('kd_ta') == '')
		{
			redirect('home');
		}
	}

	function index()
	{
		redirect('kelas/daftar');
	}
	
	function daftar($short_by='nama',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
		$this->load->library('arey');
	
		$total_page = $this->db->count_all('kelas');
		$per_page = 20;
		$url = 'kelas/daftar/'.$short_by.'/'.$short_order.'/';

		$query = $this->mkelas->getKelase($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('kelas/daftar/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 		=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'daftar_kelas',
			'kelas'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'urs'			=> 3,
			'hal'			=> $this->uri->segment(2)
		);
		
		$this->load->view('template',$data);
	}

	function daftar_wali($short_by='a.nama',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
		$this->load->library('arey');
	
		$total_page = $this->mkelas->getCountWaliKelas();
		$per_page = 20;
		$url = 'kelas/daftar/'.$short_by.'/'.$short_order.'/';

		$query = $this->mkelas->getKelaseW($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('kelas/daftar_wali/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 		=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'daftar_wali',
			'kelas'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'urs'			=> 3,
			'ref'			=> $this->uri->segment(2)
		);
		
		$this->load->view('template',$data);
	}
	
	function add_kelas()
	{
		$this->load->library('arey');

		$data = array(	  
			'kelas'			=> 'class="active"',
			'main'			=> 'kelas',
			'type'			=> 'b',
			'tambah'		=> 'class="active"',
			'ahli'			=> $this->arey->getPenjurusan(),
			'minat'			=> $this->mkelas->getMinat()
		);
			
		$this->load->view('template',$data);
	}
	
	function add_wali()
	{	
		$this->load->library('arey');

		$data = array(	  
			'kelas'			=> 'class="active"',
			'main'			=> 'wali',
			'type'			=> 'b',
			'tambah'		=> 'class="active"',
			'kls'			=> $this->mkelas->getKelasW()
		);
			
		$this->load->view('template',$data);
	}
	
	function edit_wali($id)
	{	
		$this->load->helper('edit');	
		$this->load->library('arey');
	
		$data = array(	  
			'kelas'			=> 'class="active"',
			'main'			=> 'edit_wali',
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'kls'			=> $this->mkelas->getKelasW(),
			'kueri'			=> $this->mkelas->getWaliKelas($id)
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_kelas_wali()
	{
		if($this->mkelas->cekWalis() > 0)
		{
			echo "exist";
			exit();		
		}
		elseif($this->mkelas->cekNip() == 0)
		{
			echo "kosong";
			exit();
		}
		else
		{
			$this->mkelas->addKelasWali();
			if($this->db->affected_rows() > 0)
			{
				$this->message->set('succes','Kelas Berhasil Disimpan');			
				echo "ok";
			}
			else
			{
				echo "gagal";
			}
		}
	}
	
	function submit_edit_kelas_wali($id)
	{
		if($this->mkelas->cekWalisE($id) > 0)
		{
			echo "exist";
			exit();		
		}
		elseif($this->mkelas->cekNip() == 0)
		{
			echo "kosong";
			exit();
		}
		else
		{
			$this->mkelas->updateKelasWali($id);
			if($this->db->affected_rows() > 0)
			{
				$this->message->set('succes','Wali Kelas Berhasil Diupdate');
			}
			else
			{
				$this->message->set('error','Wali Kelas Gagal Diupdate');
			}
			echo "edit";
		}
	}
	
	function submit_kelas()
	{
		if($this->mkelas->cekNewKelas() > 0)
		{
			echo "exist";
			die();
		}
		else
		{
			$this->mkelas->addKelas();
			if($this->db->affected_rows() > 0)
			{
				$this->message->set('succes','Kelas Berhasil Disimpan');	
				echo "ok";
			}
			else
			{
				echo "gagal";
			}
		}
	}
	
	function add_siswa($id=0,$short_by='c.nis',$short_order='asc',$page=0)
	{
		$this->load->library('arey');

		$total_page = $this->db->count_all('kelas_siswa WHERE id_kelas="$id"');
		$per_page = 20;
		$url = 'kelas/add_siswa/'.$id.'/'.$short_by.'/'.$short_order.'/';

		$query = $this->mkelas->getKelass($id,$per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('kelas/add_siswa/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}

		$JenisKelas = $this->mkelas->getJenisKelas($id);
		$maine = ($JenisKelas == 1)?"kelas_minat":"kelas_siswa";
		$links = ($JenisKelas == 1)?"submit_kelas_minat":"submit_kelas_siswa";
	
		$data = array(	  
			'kueri' 		=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=6),
			'kelas'			=> 'class="active"',
			'main'			=> $maine,
			'kls'			=> $this->mkelas->getKelask(),
			'type'			=> 'b',
			'tambah'		=> 'class="active"',
			'id'			=> $id,
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'page'			=> $page,
			'hari'			=> $this->arey->getDay(),
			'bulan'			=> $this->arey->getBulan(),
			'tahun'			=> $this->arey->getTahun(),
			'agama'			=> $this->mkelas->getAgama(),
			'links'			=> $links
		);
			
		$this->load->view('template',$data);	
	}
	
	function hapus_kelas()
	{
		$alamat = $this->input->post('alamat',TRUE);
		if($this->input->post('cek',TRUE) != "")
		{
			foreach($this->input->post('cek',TRUE) as $cek)
			{
				$this->mkelas->del_kelas($cek);
			}
			$this->message->set('succes','Kelas Berhasil Dihapus');
			redirect($alamat);
		}
		else
		{
			$this->message->set('notice','Tidak Ada Kelas Yang Dipilih');
			redirect($alamat);		
		}
	}
	
	function hapus_wali()
	{
		$alamat = $this->input->post('alamat',TRUE);
		if($this->input->post('cek',TRUE) != "")
		{
			foreach($this->input->post('cek',TRUE) as $cek)
			{
				$this->mkelas->del_wali($cek);
			}
			$this->message->set('succes','Wali Kelas Berhasil Dihapus');
			redirect($alamat);
		}
		else
		{
			$this->message->set('notice','Tidak Ada Wali Kelas Yang Dipilih');
			redirect($alamat);		
		}
	}
	
	function show_kelas($id)
	{
		$kueri = $this->mkelas->getKelasSiswa($id);
		
		$data = array(	  
			'kueri'			=> $kueri->result()
		);
			
		$this->load->view('tabel_siswa',$data);
	}
	
	function submit_kelas_siswa($id)
	{
		if($this->mkelas->cekKelasSiswa() > 0)
		{
			echo "exists";
			die();
		}
		else
		{
			$this->mkelas->addSiswa($id);
			//$this->mkelas->addRecordSiswa();
			$this->mkelas->addKelasSiswa();
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

	function submit_kelas_minat($id)
	{
		$this->mkelas->addKelasSiswa();
		if($this->db->affected_rows() > 0)
		{
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}
	
	function edit_kelas($id)
	{
		$this->load->helper('edit');	
		$this->load->library('arey');
	
		$data = array(	  
			'kelas'			=> 'class="active"',
			'main'			=> 'edit_kelas',
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'kueri'			=> $this->mkelas->getKelast($id),
			'ahli'			=> $this->arey->getPenjurusan(),
			'minat'			=> $this->mkelas->getMinat()
		);
			
		$this->load->view('template',$data);
	}
	
	function edit_kelas_siswa($id)
	{
		$this->load->helper('edit');	
		$this->load->library('arey');
	
		$data = array(	  
			'kelas'			=> 'class="active"',
			'main'			=> 'edit_kelas_siswa',
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'kueri'			=> $this->mkelas->getKelasSiswaId($id),
			'kls'			=> $this->mkelas->getKelas(),
			'hari'			=> $this->arey->getDay(),
			'bulan'			=> $this->arey->getBulan(),
			'tahun'			=> $this->arey->getTahun(),
			'agama'			=> $this->mkelas->getAgama()
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_edit_kelas()
	{
		$this->mkelas->updateKelas();
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Kelas Berhasil Diupdate');
		}
		else
		{
			$this->message->set('error','Kelas Gagal Diupdate');
		}
		echo "edit";
	}
	
	function daftar_siswa($kelas=0,$short_by='c.nama',$short_order='asc',$page=0)
	{
		$this->load->library('arey');

		$total_page = $this->mkelas->getNumKelass($kelas);
		$per_page = 20;
		$url = 'kelas/daftar_siswa/'.$kelas.'/'.$short_by.'/'.$short_order.'/';

		$query = $this->mkelas->getKelass($kelas,$per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('kelas/daftar_siswa/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 		=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=6),
			'main'			=> 'daftar_kelas_siswa',
			'kelas'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'klas'			=> $this->mkelas->getKelas(),
			'kls'			=> $kelas,
			'ref'			=> $this->uri->segment(2)
		);
		
		$this->load->view('template',$data);
	}
	
	function pilih_kelas()
	{
		$kelas = $this->input->post('kelas');
		if($kelas == 0)
		{
			redirect('kelas/daftar_siswa');
		}
		else
		{
			redirect('kelas/daftar_siswa/'.$kelas);
		}
	}
	
	function get_kelas()
	{
		$kelas = $this->input->post('kelas');
		if($kelas == 0)
		{
			redirect('kelas/add_siswa');
		}
		else
		{
			redirect('kelas/add_siswa/'.$kelas);
		}
	}
	
	function submit_edit_kelas_siswa()
	{
		$this->mkelas->updateKelasSiswa();
		$keahlian = $this->mkelas->getIdKeahlian();
		$this->mkelas->updateSiswa($keahlian);
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Siswa Kelas Berhasil Diupdate');
		}
		else
		{
			$this->message->set('error','Siswa Kelas Gagal Diupdate');
		}
		echo "edit";
	}
	
	function export($id=NULL)
	{
		$this->load->library('arey');
		
		$data = array(	  
			'kelas'			=> 'class="active"',
			'main'			=> 'export_kelas',
			'type'			=> 'b',
			'export'		=> 'class="active"',
			'id'			=> $id,
			'kls'			=> $this->mkelas->getKelasW()
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_export_kelas($id=NULL)
	{
		if($this->input->post('kode',TRUE) == '')
		{
			redirect('kelas/export/'.$this->input->post('kelas',TRUE));
		}
		else
		{
			$nama = strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))));
			if($this->input->post('format') == 'csv')
			{
				$query = $this->mkelas->exportKelas($id);
	
				$this->load->helper('csv');
				query_to_csv($query, TRUE, str_replace(" ","_",$nama).'.csv');
			}
			else
			{
				$query = $this->mkelas->exportKelas($id);
				
				$this->load->helper('xls');
				query_to_xls($query, TRUE, str_replace(" ","_",$nama).'.xls');
			}
		}
	}
	
	function submit_cari()
	{
		$kunci = strip_tags(ascii_to_entities(addslashes($this->input->post('kunci',TRUE))));
		if($kunci == "")
		{
			redirect('kelas/daftar');
		}
		else
		{
			redirect('kelas/cari/'.$kunci);
		}
	}
	
	function cari($kunci,$short_by='a.nama',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->db->count_all('kelas');
		$per_page = 20;
		$url = 'kelas/cari/'.$kunci.'/'.$short_by.'/'.$short_order.'/';

		$query = $this->mkelas->searchKelase($kunci,$per_page,$page,$short_by,$short_order);
				
		$data = array(
			'kueri' 			=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=6),
			'main'			=> 'daftar_kelas',
			'kelas'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'urs'				=> 4,
			'kunci'			=> $kunci,
			'hal'				=> $this->uri->segment(2)
		);
		
		$this->load->view('template',$data);
	}
	
	function import($id=NULL)
	{
		$this->load->library('arey');

		$data = array(	  
			'kelas'			=> 'class="active"',
			'main'			=> 'import_kelas',
			'type'			=> 'b',
			'import'		=> 'class="active"',
			'kls'			=> $this->mkelas->getKelasW(),
			'id'			=> $id
		);
			
		$this->load->view('template',$data);
	}
	
	function upload($id=NULL)
	{
		if($id == '')
		{
			echo "<p class='notice'>Kelas Belum Dipilih</p>";
			exit();
		}
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
			$objPHPExcel = PHPExcel_IOFactory::load($filename);										
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
						 					
			foreach ($cell_collection as $cell) 
			{
			    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
						 					 
			    if ($row == 1) 
			    {
			        $header[$row][$column] = $data_value;
			    } 
			    else 
			    {
			        $arr_data[$row][$column] = $data_value;
			    }
			}
						 			
			$data['header'] = $header;
			$data['values'] = $arr_data;									

			$no = 1;
			foreach($data['values'] as $value)
			{	
				if(isset($value['B']) AND trim($value['B']) != "" AND $no > 1)	
				{					
					if($this->mkelas->cekNiss($value['A']) == 0)
					{
						$status = (strtolower($value['H']) == "anak angkat")?"1":"0";

						$dt = array(
							'nis' => strip_tags(ascii_to_entities(addslashes($value['A']))),
							'nama' => strip_tags(ascii_to_entities(addslashes($value['B']))),
							'tempat_lahir' => strip_tags(ascii_to_entities(addslashes($value['C']))),
							'tanggal_lahir' => date('Y-m-d', strtotime($value['D'])),
							'agama' => $this->mkelas->getIdAgama($value['F']),
							'alamat' => strip_tags(ascii_to_entities(addslashes($value['E']))),
							'gambar' => '',
							'id_ta' => $this->session->userdata('kd_ta'),
							'id_keahlian' => $id,
							'status' => $status,
				  			'anak' => strip_tags(ascii_to_entities(addslashes($value['I']))),
				  			'telp_anak' => strip_tags(ascii_to_entities(addslashes($value['J']))),
				  			'ayah' => strip_tags(ascii_to_entities(addslashes($value['K']))),
				  			'ibu' => strip_tags(ascii_to_entities(addslashes($value['L']))),
				  			'alamat_ortu' => strip_tags(ascii_to_entities(addslashes($value['M']))),
				  			'kerja_ayah' => strip_tags(ascii_to_entities(addslashes($value['O']))),
				  			'kerja_ibu' => strip_tags(ascii_to_entities(addslashes($value['P']))),
				  			'telp_ortu' => strip_tags(ascii_to_entities(addslashes($value['N']))),
				  			'asal_sek' => strip_tags(ascii_to_entities(addslashes($value['U']))),
				  			'wali' => strip_tags(ascii_to_entities(addslashes($value['Q']))),
				  			'kerja_wali' => strip_tags(ascii_to_entities(addslashes($value['T']))),
				  			'alamat_wali' => strip_tags(ascii_to_entities(addslashes($value['R']))),
				  			'telp_wali' => strip_tags(ascii_to_entities(addslashes($value['S']))),
						);						
						//$isi = "'".$value['A']."','".strip_tags(ascii_to_entities(addslashes($value['B'])))."','".$value['C']."','".date('Y-m-d', strtotime($value['D']))."','".$value['E']."','".$this->mkelas->getIdAgama($value['F'])."','','".$this->mkelas->getIdTa($value['G'])."','".$this->mkelas->getIdJur($id)."'";
						//$this->mkelas->importSiswa($isi);
						$this->mkelas->importSiswane($dt);
						$isi = "'".$id."','".$value['A']."','".$this->session->userdata('kd_ta')."'";
						$this->mkelas->importKelas($isi);						
					}
					else
					{	
						$kode = $this->mkelas->getKelasSiswaIds($id,$value['A']);
						$this->mkelas->importUpdateKelas($kode,$value['A'],$id);
						$this->mkelas->importUpdateSiswa($value['A'],strip_tags(ascii_to_entities(addslashes($value['B']))),$value['C'],date('Y-m-d', strtotime($value['D'])),$value['E'],$this->mkelas->getIdAgama($value['F']),'',$this->mkelas->getIdTa($value['G']),$this->mkelas->getIdJur($id));						
					}
				}								
				$no++;
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

	function coba()
	{
		$this->load->view('uploadane');
	}
	
	function del_kelas_siswa($id)
	{
		$pecah = explode("-",$id);
		$this->mkelas->delRecordSiswa($pecah[1]);
		$this->mkelas->del_kelas_siswa($pecah[0]);
		echo "ok";
	}
	
	function hapus_kelas_siswa()
	{
		$alamat = $this->input->post('alamat',TRUE);
		if($this->input->post('cek',TRUE) != "")
		{
			foreach($this->input->post('cek',TRUE) as $cek)
			{
				$this->mkelas->delSiswaKelas($cek);
			}
			$this->message->set('succes','Siswa Kelas Berhasil Dihapus');
			redirect($alamat);
		}
		else
		{
			$this->message->set('notice','Tidak Ada Siswa Kelas Yang Dipilih');
			redirect($alamat);		
		}
	}
	
	function search()
	{
		$keyword = $this->input->post('term');
		$data['response'] = 'false'; 
		$query = $this->mkelas->lookup($keyword); 
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
	
	function search_sis()
	{
		$keyword = $this->input->post('term');
		$data['response'] = 'false'; 
		$query = $this->mkelas->lookups($keyword); 
		if( ! empty($query) )
		{
		$data['response'] = 'true'; 
		$data['message'] = array(); 
		foreach( $query as $row )
		{
			$data['message'][] = array( 
						'id'=>$row->nis,
						'value' => $row->nama." [".$row->nis."]",
						''
					); 
		}
		}
		if('IS_AJAX')
		{
		echo json_encode($data); 
		}
	}

	function sample()
	{
		$this->load->helper('download');

		$data = file_get_contents(base_url()."sample/SiswaKelas.xls");
		$name = 'SiswaKelas.xls';

		force_download($name, $data); 
	}

	function import_kelas()
	{
		if($this->input->post('kelas',TRUE) == '0')
		{
			redirect('kelas/import');
		}
		else
		{
			redirect('kelas/import/'.$this->input->post('kelas',TRUE));
		}
	}
	
	function mutasi($id=NULL)
	{
		$this->load->library('arey');

		if($id == "")
		{
			$data = array(	  
				'kelas'			=> 'class="active"',
				'main'			=> 'mutasi_siswa',
				'kls'			=> $this->mkelas->getKelask(),
				'type'			=> 'b',
				'mutasi'		=> 'class="active"'
			);
				
			$this->load->view('template',$data);
		}
		else
		{			
			$properties = $this->mkelas->getProperties($id);
		
			$data = array(
				'kueri' 		=> $this->mkelas->getKelasM($id),
				'main'			=> 'daftar_mutasi_siswa',
				'kelas'			=> 'class="active"',
				'type'			=> 'b',
				'mutasi'		=> 'class="active"',
				'klas'			=> $this->mkelas->getKelasMutasi($properties->kode),
				'kls'			=> $id
			);
			
			$this->load->view('template',$data);
		}
	}
	
	function submit_mutasi()
	{
		$kelas = $this->input->post('kelas',TRUE);
		redirect('kelas/mutasi/'.$kelas);
	}
	
	function simpan_mutasi()
	{
		$kelas = $this->input->post('kelas',TRUE);
		$nilai = "";
		foreach($this->input->post('cek',TRUE) as $cek)
		{
			$nilai = $nilai."-".$cek;
			$this->mkelas->updateMutasiSiswa($kelas,$cek);
		}
		echo $nilai;
	}
}
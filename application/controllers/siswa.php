<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Siswa extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('page');
		$this->load->model('msiswa','',TRUE);
		
		if($this->session->userdata('id') == '' || $this->session->userdata('kd_ta') == '')
		{
			redirect('home');
		}
	}
	
	function index()
	{
		redirect('siswa/daftar');
	}
	
	function daftar($short_by='nis',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->db->count_all('siswa');
		$per_page = 20;
		$url = 'siswa/daftar/'.$short_by.'/'.$short_order.'/';

		$query = $this->msiswa->getSiswa($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('siswa/daftar/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 			=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'daftar_siswa',
			'siswa'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'urs'				=> 3,
			'ref'				=> $this->uri->segment(2)
		);
		
		$this->load->view('template',$data);
	}
	
	function add_siswa()
	{
		$this->load->library('arey');
	
		$data = array(	  
			'siswa'			=> 'class="active"',
			'main'			=> 'siswa',
			'hari'			=> $this->arey->getDay(),
			'bulan'			=> $this->arey->getBulan(),
			'tahun'			=> $this->arey->getTahun(),
			'agama'			=> $this->msiswa->getAgama(),
			'ahli'			=> $this->msiswa->getAhli(),
			'type'			=> 'b',
			'tambah'			=> 'class="active"'
		);
			
		$this->load->view('template',$data);
	}
	
	function edit_siswa($id)
	{
		$this->load->library('arey');
		$this->load->helper(array('no','edit'));
	
		$data = array(	  
			'siswa'			=> 'class="active"',
			'main'			=> 'edit_siswa',
			'hari'			=> $this->arey->getDay(),
			'bulan'			=> $this->arey->getBulan(),
			'tahun'			=> $this->arey->getTahun(),
			'agama'			=> $this->msiswa->getAgama(),
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'kueri'			=> $this->msiswa->getNis($id),
			'ahli'			=> $this->msiswa->getAhli(),
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_siswa()
	{
		$this->load->helper('no');
	
		if($this->msiswa->cekNis($this->input->post('nis',TRUE)) == 0)
		{
			$this->msiswa->addSiswa();
			if($this->db->affected_rows() > 0)
			{
				$this->message->set('succes','Siswa Berhasil Ditambah');
				echo "ok";
			}
			else
			{
				echo "gagal";
			}
		}
		else
		{
			echo "exist";
			die();
		}
	}
	
	function submit_edit_siswa()
	{
		$this->load->helper('no');
	
		$this->msiswa->updateSiswa();
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Siswa Berhasil Diupdate');
		}
		else
		{
			$this->message->set('error','Siswa Gagal Diupdate');
		}
		echo "edit";
	}
	
	function submit_cari()
	{
		$kunci = strip_tags(ascii_to_entities(addslashes($this->input->post('kunci',TRUE))));
		if($kunci == "")
		{
			redirect('siswa/daftar');
		}
		else
		{
			redirect('siswa/cari/'.$kunci);
		}
	}
	
	function cari($kunci,$short_by='nis',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->db->count_all("siswa WHERE nama LIKE '%$kunci%'");
		$per_page = 20;
		$url = 'siswa/cari/'.$kunci.'/'.$short_by.'/'.$short_order.'/';

		$query = $this->msiswa->searchSiswa($kunci,$per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('siswa/cari/'.$kunci.'/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 		=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=6),
			'main'			=> 'daftar_siswa',
			'siswa'			=> 'class="active"',
			'sort_by' 		=> $short_order,
			'sort_order' 		=> $short_by,
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'kunci'			=> $kunci,
			'urs'			=> 4,
			'ref'			=> $this->uri->segment(2)."/".$kunci
		);
		
		$this->load->view('template',$data);
	}
	
	function hapus()
	{
		$alamat = $this->input->post('alamat',TRUE);
		if($this->input->post('cek',TRUE) != "")
		{
			foreach($this->input->post('cek',TRUE) as $cek)
			{
				$this->msiswa->delSiswa($cek);
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
	
	function export()
	{
		$data = array(	  
			'siswa'			=> 'class="active"',
			'main'			=> 'export_siswa',
			'type'			=> 'b',
			'export'		=> 'class="active"'
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_export_siswa()
	{
		$nama = strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))));
		if($this->input->post('format') == 'csv')
		{
			$query = $this->msiswa->exportSiswa();
 
			$this->load->helper('csv');
			query_to_csv($query, TRUE, str_replace(" ","_",$nama).'.csv');
		}
		else
		{
			$query = $this->msiswa->exportSiswa();
			 
			$this->load->helper('xls');
			query_to_xls($query, TRUE, str_replace(" ","_",$nama).'.xls');
		}
	}
	
	function import($id="")
	{
		$data = array(	  
			'siswa'			=> 'class="active"',
			'main'			=> 'import_siswa',
			'type'			=> 'b',
			'import'		=> 'class="active"',
			'id'			=> $id
		);
			
		$this->load->view('template',$data);
	}
	
	function upload($id="")
	{
		if($id == "")
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
			
		if ( !$uplod )
		{		    	
			echo "gagal";
		}
		else
		{
			$filename = './temp/'.$_FILES['uploadfile']['name'];

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
					if($this->msiswa->cekNis($value['A']) == 0)
					{
						$value = "'".$value['A']."','".$value['B']."','".$value['C']."','".date('Y-m-d', strtotime($value['D']))."','".$value['E']."','".$this->msiswa->getIdAgama($value['F'])."','','".$this->msiswa->getIdTa($value['G'])."','".$id."'";						
						$this->msiswa->importSiswa($value);
					}
					else
					{	
						$this->msiswa->importUpdateSiswa($this->spreadsheet_excel_reader->sheets[0]['cells'][$i][1],$this->spreadsheet_excel_reader->sheets[0]['cells'][$i][2],$this->spreadsheet_excel_reader->sheets[0]['cells'][$i][3],date('Y-m-d', strtotime($this->spreadsheet_excel_reader->sheets[0]['cells'][$i][4])),$this->spreadsheet_excel_reader->sheets[0]['cells'][$i][5],$this->msiswa->getIdAgama($this->spreadsheet_excel_reader->sheets[0]['cells'][$i][6]),'',$this->msiswa->getIdTa($this->spreadsheet_excel_reader->sheets[0]['cells'][$i][7]),$this->msiswa->getIdJur($this->spreadsheet_excel_reader->sheets[0]['cells'][$i][8]));
						//$this->msiswa->importUpdateSiswa($this->spreadsheet_excel_reader->sheets[0]['cells'][$i][1],$this->spreadsheet_excel_reader->sheets[0]['cells'][$i][2],$this->spreadsheet_excel_reader->sheets[0]['cells'][$i][3],date('Y-m-d', strtotime("\"".$this->spreadsheet_excel_reader->sheets[0]['cells'][$i][4]."\"")),$this->spreadsheet_excel_reader->sheets[0]['cells'][$i][5],$this->mguru->getIdAgama("\"".$this->spreadsheet_excel_reader->sheets[0]['cells'][$i][6]."\""));
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
	
	function do_upload($id=NULL)
	{
		$config['upload_path'] = './uploads/gambar/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '50000';	
		$config['remove_spaces'] = TRUE;			
				
		$this->load->library('upload', $config);
		$this->upload->display_errors('','');
		$uplod = $this->upload->do_upload("uploadfile");
			
		if ( !$uplod )
		{		    	
			echo "gagal";
		}	
		else
		{
			$nama = $_FILES['uploadfile']['name'];
			$ext = strrchr($_FILES['uploadfile']['name'], '.'); 
			$file = basename($nama, $ext); 
			$data = $this->proses($file);
			$nilai = json_decode($data);
			if($nilai->status == 'ok')
			{
				if($id != "")
				{
					$coba = $this->msiswa->editImage($id,$nilai->thumbnail);
					if($this->db->affected_rows() > 0)
					{
						echo $nilai->thumbnail;
					}
					else
					{
						echo "gagal";
					}
				}
				else
				{
					echo $nilai->thumbnail;
				}
			}
			else
			{
				echo "gagal";
			}
		}
	}
	
	function proses($nama)
	{
		$this->load->library('image_lib');								
							
		$ext = strrchr($_FILES['uploadfile']['name'], '.'); 
		$newimagename = $nama.$ext;
			
		rename('./uploads/gambar/'.str_replace(" ","_",$_FILES['uploadfile']['name']),'./uploads/gambar/'.$newimagename);
							
		$file = './uploads/gambar/'.$newimagename;
		$size = getimagesize($file);
		$width = $size[0];
		$height = $size[1];
							
		$config['image_library'] = 'GD2';
		$config['source_image'] = './uploads/gambar/'.$newimagename;
		$config['create_thumb'] = TRUE;
		$config['thumb_marker'] = '_tn';
		$config['master_dim'] = 'width';
		$config['quality'] = 600;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 200;
		$config['height'] = 200;
		if($width > $height)
		{
			$config['master_dim'] = 'height';	
		}
		else
		{
			$config['master_dim'] = 'width';	
		}
		$config['new_image'] = './uploads/thumbnail/'.$newimagename;
									
		$this->image_lib->initialize($config);
		if($this->image_lib->resize())
		{
			$this->image_lib->clear();
			$thumbnail = $nama.'_tn'.$ext;
			
			$data = array(
				'status'	=> 'ok',
				'thumbnail'	=> $thumbnail
			);
		}
		else
		{
			$data = array(
				'status'	=> 'gagal'
			);
		}
		
		return json_encode($data);
	}

	function sample()

	{

		$this->load->helper('download');



		$data = file_get_contents(base_url()."sample/Siswa.csv");

		$name = 'Siswa.csv';

		

		force_download($name, $data); 

	}
}
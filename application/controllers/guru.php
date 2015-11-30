<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Guru extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('page');
		$this->load->model('mguru','',TRUE);
		
		if($this->session->userdata('id') == '' || $this->session->userdata('kd_ta') == '')
		{
			redirect('home');
		}
	}

	function index()
	{
		redirect('guru/daftar');
	}
	
	function daftar($short_by='nip',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->db->count_all('guru');
		$per_page = 20;
		$url = 'guru/daftar/'.$short_by.'/'.$short_order.'/';

		$query = $this->mguru->getGuru($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('guru/daftar/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 		=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'daftar_guru',
			'guru'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'urs'			=> 3,
			'ref'			=> $this->uri->segment(2)
		);
		
		$this->load->view('template',$data);
	}
	
	function add_guru()
	{
		$this->load->library('arey');
	
		$data = array(	  
			'guru'			=> 'class="active"',
			'main'			=> 'guru',
			'hari'			=> $this->arey->getDay(),
			'bulan'			=> $this->arey->getBulan(),
			'tahun'			=> $this->arey->getTahunGuru(),
			'agama'			=> $this->mguru->getAgama(),
			'type'			=> 'b',
			'tambah'			=> 'class="active"'
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_guru()
	{
		if($this->mguru->cekNip($this->input->post('nip',TRUE)) == 0)
		{
			$this->mguru->addGuru();
			if($this->db->affected_rows() > 0)
			{
				$this->message->set('succes','Guru Berhasil Ditambah');
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
	
	function edit_guru($id)
	{		
		$this->load->library('arey');
		$this->load->helper('edit');
	
		$data = array(	  
			'guru'			=> 'class="active"',
			'main'			=> 'edit_guru',
			'hari'			=> $this->arey->getDay(),
			'bulan'			=> $this->arey->getBulan(),
			'tahun'			=> $this->arey->getTahunGuru(),
			'agama'			=> $this->mguru->getAgama(),
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'kueri'			=> $this->mguru->getNip($id)
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_edit_guru()
	{
		echo $this->mguru->updateGuru();
		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Guru Berhasil Diupdate');
		}
		else
		{
			$this->message->set('error','Guru Gagal Diupdate');
		}
		echo "edit";
	}
	
	function export()
	{
		$data = array(	  
			'guru'			=> 'class="active"',
			'main'			=> 'export_guru',
			'type'			=> 'b',
			'export'			=> 'class="active"'
		);
			
		$this->load->view('template',$data);
	}
	
	function submit_export_guru()
	{
		$nama = strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))));
		if($this->input->post('format') == 'csv')
		{
			$query = $this->mguru->exportGuru();
 
			$this->load->helper('csv');
			query_to_csv($query, TRUE, str_replace(" ","_",$nama).'.csv');
		}
		else
		{
			$query = $this->mguru->exportGuru();
			 
			$this->load->helper('xls');
			query_to_xls($query, TRUE, str_replace(" ","_",$nama).'.xls');
		}
	}
	
	function submit_cari()
	{
		$kunci = strip_tags(ascii_to_entities(addslashes($this->input->post('kunci',TRUE))));
		if($kunci == "")
		{
			redirect('guru/daftar');
		}
		else
		{
			redirect('guru/cari/'.$kunci);
		}
	}
	
	function cari($kunci,$short_by='nip',$short_order='asc',$page=0)
	{
		$this->load->helper('shorting');
	
		$total_page = $this->db->count_all("guru WHERE nama LIKE '%$kunci%'");
		$per_page = 20;
		$url = 'guru/cari/'.$kunci.'/'.$short_by.'/'.$short_order.'/';

		$query = $this->mguru->searchGuru($kunci,$per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('guru/cari/'.$kunci.'/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 			=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=6),
			'main'			=> 'daftar_guru',
			'guru'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'			=> 'class="active"',
			'kunci'			=> $kunci,
			'urs'				=> 4,
			'ref'				=> $this->uri->segment(2)."/".$kunci
		);
		
		$this->load->view('template',$data);
	}
	
	function import()
	{
		$data = array(	  
			'guru'			=> 'class="active"',
			'main'			=> 'import_guru',
			'type'			=> 'b',
			'import'		=> 'class="active"'
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
			$hasil = "";
			foreach($data['values'] as $value)
			{								
				if(isset($value['B']) AND trim($value['B']) != "" AND $no > 1)	
				{	
					if($value['A'] == "" OR $value['A'] == "-")					
					{
						$random = $this->generate_code(10);
						$value = "'".$random."','".strip_tags(ascii_to_entities(addslashes($value['B'])))."','".$value['C']."','".date('Y-m-d', strtotime("\"".$value['D']."\""))."','".$value['E']."','".$this->mguru->getIdAgama("\"".$value['F']."\"")."'";
						$this->mguru->importGuru($value);
					}
					else
					{
						if($this->mguru->cekNip($value['A']) == 0)
						{
							$value = "'".$value['A']."','".strip_tags(ascii_to_entities(addslashes($value['B'])))."','".$value['C']."','".date('Y-m-d', strtotime("\"".$value['D']."\""))."','".$value['E']."','".$this->mguru->getIdAgama("\"".$value['F']."\"")."'";
							$this->mguru->importGuru($value);
							//echo $value['A'];
							//echo "<br/>";
							//$hasil .= $value['B'];
						}
						else
						{
							$this->mguru->importUpdateGuru($value['A'],$value['B'],$value['C'],date('Y-m-d', strtotime("\"".$value['D']."\"")),$value['E'],$this->mguru->getIdAgama("\"".$value['F']."\""));
						}
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
				//echo $hasil;
			}
			unlink($filename);
		}
	}

	private function generate_code($length = 10)
    {
        if ($length <= 0)
        {
            return false;
        }
            
        $code = "";
        $chars = "123456789";
        srand((double)microtime() * 1000000);
        for ($i = 0; $i < $length; $i++)
        {
            $code = $code . substr($chars, rand() % strlen($chars), 1);
        }
        return $code;
            
    }
	
	function hapus()
	{
		$alamat = $this->input->post('alamat',TRUE);
		if($this->input->post('cek',TRUE) != "")
		{
			foreach($this->input->post('cek',TRUE) as $cek)
			{
				$this->mguru->delGuru($cek);
			}
			$this->message->set('succes','Guru Berhasil Dihapus');
			redirect($alamat);
		}
		else
		{
			$this->message->set('notice','Tidak Ada Guru Yang Dipilih');
			redirect($alamat);		
		}
	}

	function sample()
	{
		$this->load->helper('download');

		$data = file_get_contents(base_url()."sample/Guru.xls");
		$name = 'Guru.xls';

		force_download($name, $data); 
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nilai extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('mnilai','',TRUE);
		$this->load->model('mrumus','',TRUE);
		$this->load->model('mmenu','',TRUE);
		
		if($this->session->userdata('level') == '' || $this->session->userdata('kd_ta') == '')
		{
			redirect('login/logout');
		}
	}

	function index($id=NULL)
	{
		if($id == "")
		{
			$data = array(
				'main'		=> 'fguru/nilai',
				'nilai'		=> 'class="active"',
				'type'		=> 'a',
				'mapels'	=> $this->mnilai->getMapells(),
				'menu'		=> $this->mmenu->getTeamTeaching()
			);
			$this->load->view('fguru/template',$data);
		}
		else
		{
			$mapel = $this->mnilai->getMapel($id);
			redirect('fguru/nilai/daftar/'.$id.'/'.$mapel);	
		}
	}
	
	function submit_nilai()
	{
		$kunci = $this->input->post('mapel',TRUE);
		redirect('fguru/nilai/nilai/'.$kunci);	
	}
	
	function daftar($id,$jenis=NULL,$kls=NULL,$kes=NULL,$jns=1,$short_by='b.nama',$short_order='asc')
	{
		$sAkses = $this->mnilai->getAspek($id);		

		$this->load->library('arey');

		if($id == "" || $id == 0)
		{
			redirect('fguru/nilai');		
		}
		$this->load->helper('shorting');
		$nilai = $this->mnilai->getMenu($id);		

		$query = $this->mnilai->getSiswaKelas($kls,$short_by,$short_order);
		$tingkatane = $this->mnilai->getTingkatane(1,$id);
		$gKkm = $this->mnilai->getNilaKkn($id);
		if($tingkatane == 0 || $gKkm == 0)
		{
			$this->message->set('information','Aspek Nilai Belum Dibuat');
		}
		$j_keterampilan = 1;
		if($jns == 2)
		{
			$j_keterampilan = $this->mnilai->getTingkatane(2,$id);			
			if($j_keterampilan == 0)
			{
				$this->message->set('information','Aspek Nilai Keterampilan Belum Dibuat');		
			}
		}
		$klassss = $this->mnilai->getKelas($id);
		if($klassss == 0)
		{
			redirect('nilai/pilih');
		}
				
		$data = array(
			'kueri' 		=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'main'			=> 'fguru/daftar_nilai',
			'nilai'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftar'		=> 'class="active"',
			'urs'			=> 3,
			'ref'			=> 'refresh',
			'id'			=> $id,
			'ref'			=> 'refresh/'.$id,
			'klas'			=> $klassss,
			'kls'			=> $kls,
			'menu'			=> $this->mmenu->getTeamTeaching(),
			'mnu'			=> $nilai,
			'jenis'			=> $jenis,
			'tingkat'		=> 1,
			'kes'			=> $kes,
			'jenise'		=> $this->arey->getJenis(),
			'jns'			=> $jns,
			'tingkatane'	=> $tingkatane,
			'j_keterampilan'=> $j_keterampilan,
			'isi'			=> 'daftar',
			'penget'		=> $this->arey->getPengetahuan(),
			'kkm'			=> $gKkm,
			'mbuh'			=> '_'
		);

		$this->load->view('fguru/template',$data);	
	}
	
	function daftar_uts($id,$jenis=NULL,$kls=NULL,$kes=NULL,$short_by='b.nama',$short_order='asc')
	{
		if($id == "" || $id == 0)
		{
			redirect('fguru/nilai');		
		}
		$this->load->helper('shorting');
		$this->load->library('arey');

		$nilai = $this->mnilai->getMenu($id);

		$query = $this->mnilai->getSiswaKelas($kls,$short_by,$short_order);
		$klassss = $this->mrumus->getKelas($id);
		if($klassss == 0)
		{
			redirect('nilai/pilih');
		}
				
		$data = array(
			'kueri' 		=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'main'			=> 'fguru/daftar_nilai',
			'nilai'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftart'		=> 'class="active"',
			'urs'			=> 3,
			'ref'			=> 'refresh',
			'id'			=> $id,
			'ref'			=> 'refresh/'.$id,
			'klas'			=> $klassss,			
			'kls'			=> $kls,
			'menu'			=> $this->mmenu->getTeamTeaching(),
			'mnu'			=> $nilai,
			'jenis'			=> $jenis,
			'tingkat'		=> 2,
			'kes'			=> $kes,
			'jns'			=> 1,
			'tingkatane'	=> '',
			'isi'			=> 'tes',
			'penget'		=> '',
			'kkm'			=> $this->mnilai->getNilaKkn($id),
			'mbuh'			=> '_uts'
		);

		$this->load->view('fguru/template',$data);	
	}
	
	function daftar_uas($id,$jenis=NULL,$kls=NULL,$kes=NULL,$short_by='b.nama',$short_order='asc')
	{
		if($id == "" || $id == 0)
		{
			redirect('fguru/nilai');		
		}
		$this->load->helper('shorting');
		$this->load->library('arey');
		
		$nilai = $this->mnilai->getMenu($id);		

		$query = $this->mnilai->getSiswaKelas($kls,$short_by,$short_order);
		$klassss = $this->mrumus->getKelas($id);
		if($klassss == 0)
		{
			redirect('nilai/pilih');
		}
				
		$data = array(
			'kueri' 		=> $query->result(),
			'jum_kueri'		=> $query->num_rows(),
			'main'			=> 'fguru/daftar_nilai',
			'nilai'			=> 'class="active"',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,
			'type'			=> 'b',
			'daftars'		=> 'class="active"',
			'urs'			=> 3,
			'ref'			=> 'refresh',
			'id'			=> $id,
			'ref'			=> 'refresh/'.$id,
			'klas'			=> $klassss,			
			'kls'			=> $kls,
			'menu'			=> $this->mmenu->getTeamTeaching(),
			'mnu'			=> $nilai,
			'jenis'			=> $jenis,
			'tingkat'		=> 3,
			'kes'			=> $kes,
			'jns'			=> 1,
			'tingkatane'	=> '',
			'isi'			=> 'tes',
			'penget'		=> '',
			'kkm'			=> $this->mnilai->getNilaKkn($id),
			'mbuh'			=> '_uas'
		);
		$this->load->view('fguru/template',$data);	
	}	
	
	function submit_kategori($alamat,$id,$jenis)
	{
		$kelas = $this->input->post('kelas',TRUE);
		$ke = $this->input->post('ke',TRUE);
		$jenise = $this->input->post('jenise',TRUE);
		if($kelas == "")
		{
			redirect('fguru/nilai/'.$alamat.'/'.$id.'/'.$jenis);
		}
		else
		{
			redirect('fguru/nilai/'.$alamat.'/'.$id.'/'.$jenis.'/'.$kelas.'/'.($ke + 1).'/'.$jenise);
		}	
	}
	
	function submit_kategoris($id)
	{
		$kelas = $this->input->post('kelas',TRUE);
		if($kelas == "")
		{
			redirect('fguru/nilai/daftar_ulangan/'.$id);
		}
		else
		{
			redirect('fguru/nilai/daftar_ulangan/'.$id.'/'.$kelas);
		}	
	}
	
	function input_nilai($nip,$id,$kelas,$stat,$biji,$tingkat,$kode,$ket=NULL,$pengetahuan=1)
	{
		$data = array();

		$this->mnilai->addNilai($nip,$id,$kelas,$stat,$biji,$tingkat,$kode,$ket,$pengetahuan);
		if($this->db->affected_rows() > 0)
		{
			$data = array(
				'statuse'		=> 'ok',
				'kode'			=> $this->db->insert_id(),
				'awal'			=> $nip."_".$id."_".$kelas."__".$tingkat,
				'newK'			=> $nip."_".$id."_".$kelas."_".$this->db->insert_id()."_".$tingkat,
				'k2'			=> $nip."_".$id."_".$kelas."__".$tingkat."_2",
				'k3'			=> $nip."_".$id."_".$kelas."__".$tingkat."_3",
				'nilai'			=> $biji
			);			
		}
		else
		{
			$data = array(
				'status'		=> 'gagal'
			);
		}

		echo json_encode($data);
	}
	
	function cek_nilai($nip,$id,$kelas,$tingkat,$ket=NULL,$jns=NULL)
	{
		$kueri = $this->mnilai->cekNilai($nip,$id,$kelas,$tingkat,$ket,$jns);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			if($jns == 1)
			{
				$kode = $data->id_nilai;
				$nilai = (isset($data->nilai) && $data->nilai != "")?$data->nilai:"kosong";
			}
			elseif($jns == 2)
			{
				$kode = $data->id_nilai_trampil;
				$nilai = $this->mnilai->getNilaiTrampil($data->id_nilai_trampil);
			}
			else
			{
				$kode = $data->id_nilai_sikap;
				$nilai = $this->mnilai->getNilaiSikap($data->id_nilai_sikap);
			}
			
			$hasil = array(
				'status'	=> 'ok',
				'id'		=> $kode,
				'nilai'		=> $nilai,
				'remidi'	=> (isset($data->remidi) && $data->remidi != "")?$data->remidi:"kosong",
				'tugas'		=> (isset($data->tugas) && $data->tugas != "")?$data->tugas:"kosong",
				'newK'		=> $nip."_".$id."_".$kelas."_".$kode."_".$tingkat
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
		$this->mnilai->addNilai($nip,$id,$kelas,0,$biji,1);
		if($this->db->affected_rows() > 0)
		{
			echo "ok";
		}
		else
		{
			echo "gagal";
		}
	}
	
	function update_nilai($id,$biji,$pengetahuan)
	{
		$this->mnilai->updateNilai($id,$biji,$pengetahuan);
		$biji = ($biji == "0")?"kosong":$biji;
		if($this->db->affected_rows() > 0)
		{
			$data = array(
				'statuss'		=> 'ok',
				'nilai'			=> $biji,
				'kode'			=> $id
			);
		}
		else
		{
			$data = array(
				'statuss'		=> 'gagal',
				'nilai'			=> $biji,
				'kode'			=> $id
			);
		}
		echo json_encode($data);
	}
	
	function upload($id,$kls,$tingkat,$ket,$jenis)
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
			echo $this->upload->display_errors();
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
					if($jenis == 1)			
					{						
						if($this->mrumus->cekNilais($value['B'],$id,$kls,$tingkat,$ket,1) == 0)
						{
							$this->mrumus->addNilai($value['B'],$id,$kls,$value['D'],$value['E'],$value['F'],$tingkat,$ket);							
						}
						else
						{	
							$kodene = $this->mrumus->cekNilais($value['B'],$id,$kls,$tingkat,$ket,1);
							$this->mrumus->updateNilais($value['B'],$id,$kls,$value['D'],$value['E'],$value['F'],$tingkat,$ket,$kodene);
						}
					}
					elseif($jenis == 2)
					{
						if($this->mrumus->cekNilais($value['B'],$id,$kls,$tingkat,$ket,2) == 0)
						{
							$data = array(
								'id_nilai_trampil' => '',
							  	'id_guru_mapel' => $id,
							  	'id_kelas' => $kls,
							  	'nilai_1' => (isset($value['D']))?$value['D']:"",
							  	'nilai_2' => (isset($value['E']))?$value['E']:"",
							  	'nilai_3' => (isset($value['F']))?$value['F']:"",
							  	'nilai_4' => (isset($value['G']))?$value['G']:"",
							  	'nilai_5' => (isset($value['H']))?$value['H']:"",
							  	'nh' => (isset($value['I']))?$value['I']:"",
							  	'nis' => $value['B'],
							  	'id_ta' => $this->session->userdata('kd_ta'),
							  	'semester' => $this->session->userdata('kd_sem'),	
							  	'ket' => $ket,
							);							
							$this->mrumus->addKeterampilan($data);
						}
						else
						{	
							$kodene = $this->mrumus->cekNilais($value['B'],$id,$kls,$tingkat,$ket,2);
							$data = array(								
							  	'id_guru_mapel' => $id,
							  	'id_kelas' => $kls,
							  	'nilai_1' => (isset($value['D']))?$value['D']:"",
							  	'nilai_2' => (isset($value['E']))?$value['E']:"",
							  	'nilai_3' => (isset($value['F']))?$value['F']:"",
							  	'nilai_4' => (isset($value['G']))?$value['G']:"",
							  	'nilai_5' => (isset($value['H']))?$value['H']:"",
							  	'nh' => (isset($value['I']))?$value['I']:"",
							  	'nis' => $value['B'],
							  	'id_ta' => $this->session->userdata('kd_ta'),
							  	'semester' => $this->session->userdata('kd_sem'),	
							  	'ket' => $ket,
							);								
							$this->mrumus->updateKeterampilan($data,$kodene);
						}						
					}
					else
					{
						if($this->mrumus->cekNilais($value['B'],$id,$kls,$tingkat,$ket,3)== 0)
						{
							$data = array(
								'id_nilai_sikap' => '',
							  	'id_guru_mapel' => $id,
							  	'id_kelas' => $kls,
							  	'nilai_buka' => (isset($value['D']))?$value['D']:"",
							  	'nilai_tekun' => (isset($value['E']))?$value['E']:"",
							  	'nilai_rajin' => (isset($value['F']))?$value['F']:"",
							  	'nilai_rasa' => (isset($value['G']))?$value['G']:"",
							  	'nilai_disiplin' => (isset($value['H']))?$value['H']:"",
							  	'nilai_kerjasama' => (isset($value['I']))?$value['I']:"",
							  	'nilai_ramah' => (isset($value['J']))?$value['J']:"",
							  	'nilai_hormat' => (isset($value['K']))?$value['K']:"",
							  	'nilai_jujur' => (isset($value['L']))?$value['L']:"",
							  	'nilai_janji' => (isset($value['M']))?$value['M']:"",
							  	'nilai_peduli' => (isset($value['N']))?$value['N']:"",
							  	'nilai_jawab' => (isset($value['O']))?$value['O']:"",
							  	'nh' => (isset($value['P']))?$value['P']:"",
							  	'nis' => $value['B'],
							  	'id_ta' => $this->session->userdata('kd_ta'),
							  	'semester' => $this->session->userdata('kd_sem'),	
							  	'ket' => $ket,
							);						
							$this->mrumus->addSikap($data);
						}
						else
						{	
							$kodene = $this->mrumus->cekNilais($value['B'],$id,$kls,$tingkat,$ket,3);
							$data = array(
								'id_guru_mapel' => $id,
							  	'id_kelas' => $kls,
							  	'nilai_buka' => (isset($value['D']))?$value['D']:"",
							  	'nilai_tekun' => (isset($value['E']))?$value['E']:"",
							  	'nilai_rajin' => (isset($value['F']))?$value['F']:"",
							  	'nilai_rasa' => (isset($value['G']))?$value['G']:"",
							  	'nilai_disiplin' => (isset($value['H']))?$value['H']:"",
							  	'nilai_kerjasama' => (isset($value['I']))?$value['I']:"",
							  	'nilai_ramah' => (isset($value['J']))?$value['J']:"",
							  	'nilai_hormat' => (isset($value['K']))?$value['K']:"",
							  	'nilai_jujur' => (isset($value['L']))?$value['L']:"",
							  	'nilai_janji' => (isset($value['M']))?$value['M']:"",
							  	'nilai_peduli' => (isset($value['N']))?$value['N']:"",
							  	'nilai_jawab' => (isset($value['O']))?$value['O']:"",
							  	'nh' => (isset($value['P']))?$value['P']:"",
							  	'nis' => $value['B'],
							  	'id_ta' => $this->session->userdata('kd_ta'),
							  	'semester' => $this->session->userdata('kd_sem'),	
							  	'ket' => $ket,
							);							
							$this->mrumus->updateSikap($data,$kodene);
						}						
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
				//echo "gagals";
				echo $this->db->_error_message();
			}
			unlink($filename);
		}
	}

	function sample($id,$kes,$jns,$mapel,$isi)
	{
		$this->load->library(array('excel','arey'));	

		$query = $this->mrumus->getExportSiswaKelas($id);

		if($jns == 1)
		{
			$objPHPExcel = PHPExcel_IOFactory::load("./sample/pengetahuan_nilai".$isi.".xls");						
		}
		elseif($jns == 2)
		{
			$mapele = $this->mnilai->getAspekKeterampilan($mapel);

			$objPHPExcel = PHPExcel_IOFactory::load("./sample/keterampilan_nilai.xls");						

			$kolom = array("D4","E4","F4","G4","H4");
			foreach($mapele as $key => $detail_mapel)
			{				
				$objPHPExcel->getActiveSheet()->setCellValue($kolom[$key], $detail_mapel->aspek);				
			}			
		}
		else
		{
			$objPHPExcel = PHPExcel_IOFactory::load("./sample/sikap_nilai.xls");						
		}		

		$baris = 5;

		foreach($query as $detail)
		{			
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $detail->nis);			
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $detail->nama);			
			$baris++;
		}
			 
		$filename="DAFTAR NILAI ".mt_rand(1,100000).".xls"; 
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;filename='".$filename."'");
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
		$objWriter->save("php://output");

		exit;
	}

	function form($id,$jns,$kode,$tingkat)
	{
		$this->load->library('arey');
		$pecah = explode("_", $id);

		$ids = ($pecah[3] == "")?0:$pecah[3];		
		$kueri = ($jns == 2)?$this->mnilai->getAllKeterampilan($pecah[1],$ids):$this->mnilai->getAllSikap($ids);
		if($jns == 2)
		{
			$links = ($pecah[3] == "")?'simpan_keterampilan':'update_keterampilan/'.$pecah[3];
		}
		else
		{
			$links = ($pecah[3] == "")?'simpan_sikap':'update_sikap/'.$pecah[3];
		}

		$data = array(			
			'tingkat'		=> $kode,
			'nis'			=> $pecah[0],
			'id_guru_mapel'	=> $pecah[1],
			'id_kelas'		=> $pecah[2],
			'tingkat'		=> $tingkat,
			'kode'			=> $id,
			'kueri'			=> $kueri,
			'links'			=> $links,
			'jns'			=> $jns
		);

		$this->load->view('fguru/formNilaine',$data);		
	}

	function simpan_sikap()
	{
		$kode = $this->input->post('kode');
		$pecah = explode("_", $kode);		

		$this->mnilai->addSikap();
		if($this->db->affected_rows() > 0)
		{
			$data = array(
				'status'	=> 'ok',
				'id'		=> $this->db->insert_id(),
				'kode'		=> $kode,
				'nilai'		=> $this->mnilai->getNilaiSikap($this->db->insert_id()),
				'newK'		=> $pecah[0]."_".$pecah[1]."_".$pecah[2]."_".$this->db->insert_id()."_".$pecah[4]
			);	

			echo json_encode($data);
		}
		else
		{
			$data = array(
				'status'	=> 'gagal',				
			);	

			echo json_encode($data);
		}
	}

	function simpan_keterampilan()
	{
		$kode = $this->input->post('kode');
		$pecah = explode("_", $kode);

		$input = $this->input->post('buka',TRUE);
		$this->mnilai->addKeterampilan($input);
		if($this->db->affected_rows() > 0)
		{
			$data = array(
				'status'	=> 'ok',
				'id'		=> $this->db->insert_id(),
				'kode'		=> $kode,
				'nilai'		=> $this->mnilai->getNilaiTrampil($this->db->insert_id()),
				'newK'		=> $pecah[0]."_".$pecah[1]."_".$pecah[2]."_".$this->db->insert_id()."_".$pecah[4]
			);	

			echo json_encode($data);
		}
		else
		{
			$data = array(
				'status'	=> 'gagal',				
			);	

			echo json_encode($data);
		}
	}

	function update_keterampilan($id)
	{		
		$input = $this->input->post('buka',TRUE);
		$this->mnilai->updateKeterampilan($id,$input);		
		if($this->db->affected_rows() > 0)
		{
			$data = array(
				'status'	=> 'ok',
				'id'		=> $id,
				'newK'		=> $this->input->post('kode'),
				'nilai'		=> $this->mnilai->getNilaiTrampil($id)
			);	

			echo json_encode($data);
		}
		else
		{
			$data = array(
				'status'	=> 'gagal',				
			);	

			echo json_encode($data);
		}
	}

	function update_sikap($id)
	{
		$this->mnilai->updateSikap($id);
		if($this->db->affected_rows() > 0)
		{
			$data = array(
				'status'	=> 'ok',
				'id'		=> $id,
				'newK'		=> $this->input->post('kode'),
				'nilai'		=> $this->mnilai->getNilaiSikap($id)
			);	

			echo json_encode($data);
		}
		else
		{
			$data = array(
				'status'	=> 'gagal',				
			);	

			echo json_encode($data);
		}
	}	

	public function coba()
	{
		$this->load->view('fguru/upload');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
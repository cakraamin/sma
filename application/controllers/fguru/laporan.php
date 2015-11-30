<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('mnilai','',TRUE);
		$this->load->model('mmenu','',TRUE);
		$this->load->model('mlaporan','',TRUE);
		
		if($this->session->userdata('level') == '' || $this->session->userdata('kd_ta') == '')
		{
			redirect('login/logout');
		}
	}

	function index()
	{
		$this->load->library('arey');

		$data = array(
			'main'		=> 'fguru/laporan',
			'lap'		=> 'class="active"',
			'type'		=> 'b',
			'mapels'	=> $this->mlaporan->getMapells(),
			'menu'		=> $this->mmenu->getTeamTeaching(),	
			'laporan'	=> $this->arey->getJenisLaporan(),
			'guru'		=> "class='active'",
			'sWali'		=> $this->mlaporan->getStatWali()
		);

		$this->load->view('fguru/template',$data);
	}	

	public function wali($id=NULL)
	{
		if(is_null($id))
		{
			$this->message->set('information','Maaf Perwalian Tidak Ditemukan');
			redirect("fguru/laporan");
		}

		$this->load->library('arey');

		$data = array(
			'main'		=> 'fguru/laporan_wali',
			'lap'		=> 'class="active"',
			'type'		=> 'b',
			'mapels'	=> $this->mlaporan->getMapells(),
			'menu'		=> $this->mmenu->getTeamTeaching(),	
			'laporan'	=> $this->arey->getJenisLaporan(),
			'wali'		=> "class='active'",
			'sWali'		=> $id
		);

		$this->load->view('fguru/template',$data);
	}

	function submit_laporan()
	{
		$this->load->library(array('excel','arey'));		
		
		$jenis = $this->input->post('jenis',TRUE);
		$mapel = $this->input->post('mapel',TRUE);

		if($mapel == 0)
		{
			$this->message->set('information','Jenis Mapel Belum Dipilih');
			redirect("fguru/laporan");
		}

		$getAspek = $this->mlaporan->getAspekNilai($jenis);
		if(!$getAspek)
		{
			$this->message->set('information','Aspek '.$this->arey->getJenis($jenis).' Belum Ditentukan');
			redirect("fguru/laporan");	
		}		

		$master = $this->mlaporan->getMasterAll($mapel);	
		$kompetensi = $this->mlaporan->getKompetensi($master['kelas']['id_mapel'],1);			

		if($jenis == 1)
		{
			$objPHPExcel = PHPExcel_IOFactory::load("./template/PENGETAHUAN.xls");
			$judul = "PENGETAHUAN";						

			$objPHPExcel->getActiveSheet()->setCellValue('C11', ": ".$master['sem']);
			$objPHPExcel->getActiveSheet()->setCellValue('C12', ": ".$master['kelas']['kelas']);
			$objPHPExcel->getActiveSheet()->setCellValue('P11', "Mata Pelajaran : ".$master['kelas']['mapel']);
			$objPHPExcel->getActiveSheet()->setCellValue('P12', "Wali Kelas       : ".$master['kelas']['wali']['nama_wali']);

			$objPHPExcel->getActiveSheet()->setCellValue('A60', $master['kelas']['kepala']['nama_kepala']);
			$objPHPExcel->getActiveSheet()->setCellValue('A61', "'".$master['kelas']['kepala']['nip_kepala']);

			$objPHPExcel->getActiveSheet()->setCellValue('O55', "Rembang, ".date("d")." ".$this->arey->getBulane(date("n"))." ".date("Y"));

			$objPHPExcel->getActiveSheet()->setCellValue('O60', $master['kelas']['guru_mapel']['nama_mapel']);
			$objPHPExcel->getActiveSheet()->setCellValue('O61', "'".$master['kelas']['guru_mapel']['nip_mapel']);

			$pengetahuan = $this->mlaporan->getAllPengetahuan($master['kelas']['id_kelas'],$master['kelas']['id_guru_mapel'],$master['kelas']['id_mapel']);												

			$awal = 17;
			$no = 1;
			foreach($pengetahuan as $detail)
			{
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$awal, $no);				
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$awal, $detail['nis']);				
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$awal, $detail['nama']);
                                          
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$awal, $detail['detail']['1']);				
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$awal, $detail['detail']['2']);				
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$awal, $detail['detail']['3']);				
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$awal, $detail['detail']['4']);				
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$awal, $detail['detail']['5']);				
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$awal, $detail['uts']);				
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$awal, $detail['uas']);
				$objPHPExcel->getActiveSheet()->setCellValue('P'.$awal, $this->getDeskripsi(1,$detail['keterangan'],$detail['sempurna']));
				$awal++;
				$no++;
			}			
		}
		elseif($jenis == 2)
		{
			$objPHPExcel = PHPExcel_IOFactory::load("./template/KETERAMPILAN.xls");
			$judul = "KETERAMPILAN";			
			
			$keterampilan = $this->mlaporan->getAllKeterampilan($master['kelas']['id_kelas'],$master['kelas']['id_guru_mapel'],$master['kelas']['id_mapel']);	
			
			$k_trampil = $this->mlaporan->getKompetensi($master['kelas']['id_mapel'],2);			
			
			for($k=0;$k<5;$k++)
			{
				$objPHPExcel->setActiveSheetIndex($k);

				$awal = 16;
				$no = 1;
				foreach($keterampilan as $detail)
				{									
					//print_r($detail);
					//echo "<hr/>";

					$satu = (array_key_exists(0,$k_trampil))?$k_trampil[0]:"";
					$dua = (array_key_exists(1,$k_trampil))?$k_trampil[1]:"";
					$tiga = (array_key_exists(2,$k_trampil))?$k_trampil[2]:"";
					$empat = (array_key_exists(3,$k_trampil))?$k_trampil[3]:"";
					$lima = (array_key_exists(4,$k_trampil))?$k_trampil[4]:"";

					$objPHPExcel->getActiveSheet()->setCellValue('C11', ": ".$master['sem']);
					$objPHPExcel->getActiveSheet()->setCellValue('C12', ": ".$master['kelas']['kelas']);
					$objPHPExcel->getActiveSheet()->setCellValue('K11', ": ".$master['kelas']['mapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('K12', ": ".$master['kelas']['wali']['nama_wali']);

					$objPHPExcel->getActiveSheet()->setCellValue('D15', $satu);
					$objPHPExcel->getActiveSheet()->setCellValue('E15', $dua);
					$objPHPExcel->getActiveSheet()->setCellValue('F15', $tiga);
					$objPHPExcel->getActiveSheet()->setCellValue('G15', $empat);
					$objPHPExcel->getActiveSheet()->setCellValue('H15', $lima);

					$objPHPExcel->getActiveSheet()->setCellValue('A52', $master['kelas']['kepala']['nama_kepala']);
					$objPHPExcel->getActiveSheet()->setCellValue('A53', "'".$master['kelas']['kepala']['nip_kepala']);

					$objPHPExcel->getActiveSheet()->setCellValue('I47', "Rembang, ".date("d")." ".$this->arey->getBulane(date("n"))." ".date("Y"));
					$kompeten = (array_key_exists($k,$kompetensi))?$kompetensi[$k]:"";
					$objPHPExcel->getActiveSheet()->setCellValue('C13', $kompeten);

					$objPHPExcel->getActiveSheet()->setCellValue('I52', $master['kelas']['guru_mapel']['nama_mapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I53', "'".$master['kelas']['guru_mapel']['nip_mapel']);

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$awal, $no);
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$awal, $detail['nis']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$awal, $detail['nama']);

					$objPHPExcel->getActiveSheet()->setCellValue('D'.$awal, $detail['detail'][$k+1]['nilai_1']);
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$awal, $detail['detail'][$k+1]['nilai_2']);
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$awal, $detail['detail'][$k+1]['nilai_3']);
					$objPHPExcel->getActiveSheet()->setCellValue('G'.$awal, $detail['detail'][$k+1]['nilai_4']);
					$objPHPExcel->getActiveSheet()->setCellValue('H'.$awal, $detail['detail'][$k+1]['nilai_5']);
					$objPHPExcel->getActiveSheet()->setCellValue('O'.$awal, $detail['detail'][$k+1]['total']);
					$awal++;
					$no++;
				}				
			}
			//exit();

			$objPHPExcel->setActiveSheetIndex(5);

			$objPHPExcel->getActiveSheet()->setCellValue('C10', ": ".$master['sem']);
			$objPHPExcel->getActiveSheet()->setCellValue('C11', ": ".$master['kelas']['kelas']);
			$objPHPExcel->getActiveSheet()->setCellValue('M10', "Mapel           : ".$master['kelas']['mapel']);
			$objPHPExcel->getActiveSheet()->setCellValue('M11', "Wali Kelas      : ".$master['kelas']['wali']['nama_wali']);

			$objPHPExcel->getActiveSheet()->setCellValue('A57', $master['kelas']['kepala']['nama_kepala']);
			$objPHPExcel->getActiveSheet()->setCellValue('A58', "'".$master['kelas']['kepala']['nip_kepala']);

			$objPHPExcel->getActiveSheet()->setCellValue('M52', "Rembang, ".date("d")." ".$this->arey->getBulane(date("n"))." ".date("Y"));

			$objPHPExcel->getActiveSheet()->setCellValue('M57', $master['kelas']['guru_mapel']['nama_mapel']);
			$objPHPExcel->getActiveSheet()->setCellValue('M58', "'".$master['kelas']['guru_mapel']['nip_mapel']);

			$awal = 14;
			$no = 1;
			foreach($keterampilan as $detail)
			{											
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$awal, $no);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$awal, $detail['nis']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$awal, $detail['nama']);

				$objPHPExcel->getActiveSheet()->setCellValue('D'.$awal, $detail['detail'][1]['total']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$awal, $detail['detail'][2]['total']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$awal, $detail['detail'][3]['total']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$awal, $detail['detail'][4]['total']);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$awal, $detail['detail'][5]['total']);

				$objPHPExcel->getActiveSheet()->setCellValue('M'.$awal, $this->getDeskripsi(2,$detail['ket'],$detail['sempurna']));
				$awal++;
				$no++;
			}				
		}
		else
		{
			$objPHPExcel = PHPExcel_IOFactory::load("./template/SIKAP.xls");
			$judul = "SIKAP";			

			$sikap = $this->mlaporan->getAllSikap($master['kelas']['id_kelas'],$master['kelas']['id_guru_mapel'],$master['kelas']['id_mapel']);

			for($k=0;$k<5;$k++)
			{
				$objPHPExcel->setActiveSheetIndex($k);

				$awal = 14;
				$no = 1;
				foreach($sikap as $detail)
				{					
					//print_r($detail);
					//echo "<hr/>";

					$objPHPExcel->getActiveSheet()->setCellValue('C9', ": ".$master['sem']);
					$objPHPExcel->getActiveSheet()->setCellValue('C10', ": ".$master['kelas']['kelas']);
					$objPHPExcel->getActiveSheet()->setCellValue('N9', ": ".$master['kelas']['mapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('N10', ": ".$master['kelas']['wali']['nama_wali']);

					$objPHPExcel->getActiveSheet()->setCellValue('A56', $master['kelas']['kepala']['nama_kepala']);
					$objPHPExcel->getActiveSheet()->setCellValue('A57', "'".$master['kelas']['kepala']['nip_kepala']);

					$objPHPExcel->getActiveSheet()->setCellValue('K51', "Rembang, ".date("d")." ".$this->arey->getBulane(date("n"))." ".date("Y"));

					$kompeten = (array_key_exists($k,$kompetensi))?$kompetensi[$k]:"";
					$objPHPExcel->getActiveSheet()->setCellValue('C11', ": ".$kompeten);

					$objPHPExcel->getActiveSheet()->setCellValue('K56', $master['kelas']['guru_mapel']['nama_mapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('K57', "'".$master['kelas']['guru_mapel']['nip_mapel']);

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$awal, $no);
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$awal, $detail['nis']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$awal, $detail['nama']);

					$objPHPExcel->getActiveSheet()->setCellValue('D'.$awal, $detail['detail'][$k+1]['nilai_buka']);
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$awal, $detail['detail'][$k+1]['nilai_tekun']);
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$awal, $detail['detail'][$k+1]['nilai_rajin']);
					$objPHPExcel->getActiveSheet()->setCellValue('G'.$awal, $detail['detail'][$k+1]['nilai_rasa']);
					$objPHPExcel->getActiveSheet()->setCellValue('H'.$awal, $detail['detail'][$k+1]['nilai_disiplin']);
					$objPHPExcel->getActiveSheet()->setCellValue('I'.$awal, $detail['detail'][$k+1]['nilai_kerjasama']);
					$objPHPExcel->getActiveSheet()->setCellValue('J'.$awal, $detail['detail'][$k+1]['nilai_ramah']);
					$objPHPExcel->getActiveSheet()->setCellValue('K'.$awal, $detail['detail'][$k+1]['nilai_hormat']);
					$objPHPExcel->getActiveSheet()->setCellValue('L'.$awal, $detail['detail'][$k+1]['nilai_jujur']);
					$objPHPExcel->getActiveSheet()->setCellValue('M'.$awal, $detail['detail'][$k+1]['nilai_janji']);
					$objPHPExcel->getActiveSheet()->setCellValue('N'.$awal, $detail['detail'][$k+1]['nilai_peduli']);
					$objPHPExcel->getActiveSheet()->setCellValue('O'.$awal, $detail['detail'][$k+1]['nilai_jawab']);					
					$awal++;
					$no++;
				}				
			}
			//exit();

			$objPHPExcel->setActiveSheetIndex(5);

			$objPHPExcel->getActiveSheet()->setCellValue('C11', ": ".$master['sem']);
			$objPHPExcel->getActiveSheet()->setCellValue('C12', ": ".$master['kelas']['kelas']);
			$objPHPExcel->getActiveSheet()->setCellValue('L11', "Mapel           : ".$master['kelas']['mapel']);
			$objPHPExcel->getActiveSheet()->setCellValue('L12', "Wali Kelas      : ".$master['kelas']['wali']['nama_wali']);

			$objPHPExcel->getActiveSheet()->setCellValue('A53', $master['kelas']['kepala']['nama_kepala']);
			$objPHPExcel->getActiveSheet()->setCellValue('A54', "'".$master['kelas']['kepala']['nip_kepala']);

			$objPHPExcel->getActiveSheet()->setCellValue('L48', "Rembang, ".date("d")." ".$this->arey->getBulane(date("n"))." ".date("Y"));

			$objPHPExcel->getActiveSheet()->setCellValue('L53', $master['kelas']['guru_mapel']['nama_mapel']);
			$objPHPExcel->getActiveSheet()->setCellValue('L54', "'".$master['kelas']['guru_mapel']['nip_mapel']);

			$awal = 15;
			$no = 1;
			foreach($sikap as $detail)
			{				
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$awal, $no);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$awal, $detail['nis']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$awal, $detail['nama']);

				$objPHPExcel->getActiveSheet()->setCellValue('D'.$awal, $detail['detail'][1]['total']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$awal, $detail['detail'][2]['total']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$awal, $detail['detail'][3]['total']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$awal, $detail['detail'][4]['total']);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$awal, $detail['detail'][5]['total']);				

				$objPHPExcel->getActiveSheet()->setCellValue('L'.$awal, $this->getDeskripsi(3,$detail['ket'],$detail['sempurna']));
				$awal++;
				$no++;
			}
		}		
		
		/*$objWorkSheetBase = $objPHPExcel->getSheet();
		$objWorkSheet1 = clone $objWorkSheetBase;		
		$objWorkSheet1->setTitle('Pengamatan');		
		$objPHPExcel->addSheet($objWorkSheet1);*/

		$filename="DAFTAR ".$judul." ".mt_rand(1,100000).".xls"; 
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;filename=".$filename);
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
		$objWriter->save("php://output");

		exit;
	}

	public function submit_wali($id)
	{
		$this->load->library(array('excel','arey'));

		$mapel = $this->input->post('mapel',TRUE);	

		if($mapel == 0)
		{
			$this->message->set('information','Jenis Mapel Belum Dipilih');
			redirect("fguru/laporan/wali/".$id);
		}	

		$master = $this->mlaporan->getMasterUts($mapel);			
		
		$objPHPExcel = PHPExcel_IOFactory::load("./template/UTS.xls");
		$judul = "UTS";						
		
		$objPHPExcel->getActiveSheet()->setCellValue('C11', ": ".$master['sem']);
		$objPHPExcel->getActiveSheet()->setCellValue('C12', ": ".$master['kelas']['kelas']);
		$objPHPExcel->getActiveSheet()->setCellValue('T11', ": ".$master['kelas']['mapel']);
		$objPHPExcel->getActiveSheet()->setCellValue('T12', ": ".$master['kelas']['wali']['nama_wali']);

		$objPHPExcel->getActiveSheet()->setCellValue('A60', $master['kelas']['kepala']['nama_kepala']);
		$objPHPExcel->getActiveSheet()->setCellValue('A61', "'".$master['kelas']['kepala']['nip_kepala']);

		$objPHPExcel->getActiveSheet()->setCellValue('S55', "Rembang, ".date("d")." ".$this->arey->getBulane(date("n"))." ".date("Y"));

		$objPHPExcel->getActiveSheet()->setCellValue('S60', $master['kelas']['guru_mapel']['nama_mapel']);
		$objPHPExcel->getActiveSheet()->setCellValue('S61', "'".$master['kelas']['guru_mapel']['nip_mapel']);
		$objPHPExcel->getActiveSheet()->setCellValue('D49', $master['kelas']['kkm']);

		$uts = $this->mlaporan->getNilaiUts($master['kelas']['id_kelas']);	

		$awal = 17;
		$no = 1;
		foreach($uts as $dt_uts)
		{						
			//print_r($dt_uts);
			//echo "<hr/>";

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$awal, $no);			
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$awal, $dt_uts['nis']);			
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$awal, $dt_uts['nama']);			

			$objPHPExcel->getActiveSheet()->setCellValue('D'.$awal, $dt_uts['nh1']['nilai']);			
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$awal, $dt_uts['nh1']['remidi']);			
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$awal, $dt_uts['nh1']['tugas']);						

			$objPHPExcel->getActiveSheet()->setCellValue('H'.$awal, $dt_uts['trampil1']);						

			$objPHPExcel->getActiveSheet()->setCellValue('I'.$awal, $dt_uts['nh2']['nilai']);			
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$awal, $dt_uts['nh2']['remidi']);			
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$awal, $dt_uts['nh2']['tugas']);						

			$objPHPExcel->getActiveSheet()->setCellValue('M'.$awal, $dt_uts['trampil2']);						

			$objPHPExcel->getActiveSheet()->setCellValue('N'.$awal, $dt_uts['nh3']['nilai']);			
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$awal, $dt_uts['nh3']['remidi']);			
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$awal, $dt_uts['nh3']['tugas']);						

			$objPHPExcel->getActiveSheet()->setCellValue('R'.$awal, $dt_uts['trampil3']);						

			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$awal, $dt_uts['uts']);						
			$awal++;
			$no++;
		}	
		//exit();	

		$filename="UTS ".$judul." ".mt_rand(1,100000).".xls"; 
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;filename='".$filename."'");
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
		$objWriter->save("php://output");

		exit;
	}

	private function getDeskripsi($kode,$ket,$sempurna)
	{
		$kalimat = "";
		$awal = "";

		if($kode == 1)
		{
			$bidang = "Pengetahuan";
		}
		elseif($kode == 2)
		{
			$bidang = "Keterampilan";
		}
		else
		{
			$bidang = "Sikap";
		}	

		if($sempurna == 5)
		{
			$awal = "Nilai ".$bidang." Sempurna";
		}
		elseif($sempurna < 2)
		{
			$awal = "Nilai ".$bidang." Baik";
		}
		else
		{
			$awal = "Nilai ".$bidang." Sangat Baik";
		}

		if(implode(",", $ket) != "")
		{
			$kalimat = implode(",", $ket);
		}		

		return $awal." ".$kalimat;
	}

	/*$objWorkSheetBase = $objPHPExcel->getSheet();
	$objWorkSheet1 = clone $objWorkSheetBase;		
	$objWorkSheet1->setTitle($dt_master['nis']);		
	$objPHPExcel->addSheet($objWorkSheet1);*/
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
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
			redirect('home');
		}
	}

	function index()
	{
		$this->load->library('arey');

		$data = array(
			'main'			=> 'laporan',
			'lap'			=> 'class="active"',
			'type'			=> 'b',
			'mapels'		=> $this->mnilai->getMapells(),
			'menu'			=> $this->mmenu->getTeamTeaching(),		
			'tambah'		=> "class='active'",
			'jlaporan'		=> $this->arey->getJLaporan(),
			'kelasmu'		=> $this->mlaporan->getKelas(),			
		);
		$this->load->view('template',$data);
	}

	public function submit_laporan()
	{
		$this->load->library(array('excel','arey'));	

		$tanggal = $this->input->post('tanggal',TRUE);	
		$pecah = explode("/", $tanggal);
		$tanggal = $pecah[1]." ".$this->arey->getBulane($pecah[0])." ".$pecah[2];		

		$jenise = $this->input->post('jlaporan',TRUE);
		$kelas = $this->input->post('kelas',TRUE);

		$getTingkat = $this->mlaporan->getTingkatKelas($kelas);		

		$raport = $this->mlaporan->getRaport($kelas);		
		if(count($raport) > 1 && count($raport['0']['mapel']) < 13)
		{
			$this->message->set('notice','Jumlah Pelajaran Belum Semua Ditentukan');
			redirect('laporan');
		}
	
		if($jenise == 1)
		{
			if($getTingkat == "X")
			{
				$objPHPExcel = PHPExcel_IOFactory::load("./template/RAPOR_K1.xlsx");			

				foreach($raport as $key => $dt_raport)
				{																	
					$indeke = $key + 1;
					$objWorkSheetBase = $objPHPExcel->getSheet();
					$objWorkSheet1 = clone $objWorkSheetBase;		
					$objWorkSheet1->setTitle(reset(explode(" ", $dt_raport['nama'])));		
					$objPHPExcel->addSheet($objWorkSheet1);
					$objPHPExcel->setActiveSheetIndex($indeke);										

					$objPHPExcel->getActiveSheet()->setCellValue('A36', $dt_raport['nama']);
					$objPHPExcel->getActiveSheet()->setCellValue('I195', $dt_raport['nama']);
					$objPHPExcel->getActiveSheet()->setCellValue('I197', $dt_raport['t_lahir']);
					$objPHPExcel->getActiveSheet()->setCellValue('I198', "jk");
					$objPHPExcel->getActiveSheet()->setCellValue('I199', $dt_raport['agama']);
					$objPHPExcel->getActiveSheet()->setCellValue('I200', $dt_raport['status']);
					$objPHPExcel->getActiveSheet()->setCellValue('I201', $dt_raport['anak']);
					$objPHPExcel->getActiveSheet()->setCellValue('I202', $dt_raport['alamat_sis']);
					$objPHPExcel->getActiveSheet()->setCellValue('I204', $dt_raport['telp_a']);
					$objPHPExcel->getActiveSheet()->setCellValue('I205', $dt_raport['asal']);
					$objPHPExcel->getActiveSheet()->setCellValue('I207', "Diterima Kelas");
					$objPHPExcel->getActiveSheet()->setCellValue('I208', "Tahune");
					$objPHPExcel->getActiveSheet()->setCellValue('I210', $dt_raport['ayah']);
					$objPHPExcel->getActiveSheet()->setCellValue('I211', $dt_raport['ibu']);
					$objPHPExcel->getActiveSheet()->setCellValue('I212', $dt_raport['alamat_or']);
					$objPHPExcel->getActiveSheet()->setCellValue('I214', $dt_raport['telp_o']);
					$objPHPExcel->getActiveSheet()->setCellValue('I216', $dt_raport['k_ayah']);
					$objPHPExcel->getActiveSheet()->setCellValue('I217', $dt_raport['k_ibu']);
					$objPHPExcel->getActiveSheet()->setCellValue('I218', (isset($dt_raport['wali']) && $dt_raport['wali'] != "")?$dt_raport['wali']:"-");
					$objPHPExcel->getActiveSheet()->setCellValue('I219', (isset($dt_raport['alamat_w']) && $dt_raport['alamat_w'] != "")?$dt_raport['alamat_w']:"-");
					$objPHPExcel->getActiveSheet()->setCellValue('I221', (isset($dt_raport['telp_w']) && $dt_raport['telp_w'] != "")?$dt_raport['telp_w']:"-");
					$objPHPExcel->getActiveSheet()->setCellValue('I222', (isset($dt_raport['kerja_w']) && $dt_raport['kerja_w'] != "")?$dt_raport['kerja_w']:"-");

					//detail raport
					$objPHPExcel->getActiveSheet()->setCellValue('F244', $dt_raport['nama']);
					$objPHPExcel->getActiveSheet()->setCellValue('F245', $dt_raport['nis']);
					$objPHPExcel->getActiveSheet()->setCellValue('P242', $dt_raport['kelas']);
					$objPHPExcel->getActiveSheet()->setCellValue('P243', $dt_raport['sem']);
					$objPHPExcel->getActiveSheet()->setCellValue('P244', $dt_raport['tahun']);
					$objPHPExcel->getActiveSheet()->setCellValue('M62', $dt_raport['wali_k']['nama_w']);
					$objPHPExcel->getActiveSheet()->setCellValue('M63', "NIP. ".$dt_raport['wali_k']['nip_w']);
					$objPHPExcel->getActiveSheet()->setCellValue('M58', "Rembang, ".$tanggal);
					
					/*$objPHPExcel->getActiveSheet()->setCellValue('B11', $dt_raport['mapel']['0']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C12', $dt_raport['mapel']['0']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I11', $dt_raport['mapel']['0']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K11', $dt_raport['mapel']['0']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M11', $dt_raport['mapel']['0']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B13', $dt_raport['mapel']['1']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C14', $dt_raport['mapel']['1']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I13', $dt_raport['mapel']['1']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K13', $dt_raport['mapel']['1']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M13', $dt_raport['mapel']['1']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B15', $dt_raport['mapel']['2']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C16', $dt_raport['mapel']['2']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I15', $dt_raport['mapel']['2']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K15', $dt_raport['mapel']['2']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M15', $dt_raport['mapel']['2']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B17', $dt_raport['mapel']['3']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C18', $dt_raport['mapel']['3']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I17', $dt_raport['mapel']['3']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K17', $dt_raport['mapel']['3']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M17', $dt_raport['mapel']['3']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B19', $dt_raport['mapel']['4']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C20', $dt_raport['mapel']['4']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I19', $dt_raport['mapel']['4']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K19', $dt_raport['mapel']['4']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M19', $dt_raport['mapel']['4']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B21', $dt_raport['mapel']['5']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C22', $dt_raport['mapel']['5']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I21', $dt_raport['mapel']['5']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K21', $dt_raport['mapel']['5']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M21', $dt_raport['mapel']['5']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B24', $dt_raport['mapel']['6']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C25', $dt_raport['mapel']['6']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I24', $dt_raport['mapel']['6']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K24', $dt_raport['mapel']['6']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M24', $dt_raport['mapel']['6']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B26', $dt_raport['mapel']['7']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C27', $dt_raport['mapel']['7']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I26', $dt_raport['mapel']['7']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K26', $dt_raport['mapel']['7']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M26', $dt_raport['mapel']['7']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B28', $dt_raport['mapel']['8']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C29', $dt_raport['mapel']['8']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I28', $dt_raport['mapel']['8']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K28', $dt_raport['mapel']['8']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M28', $dt_raport['mapel']['8']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B30', $dt_raport['mapel']['9']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C31', $dt_raport['mapel']['9']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I30', $dt_raport['mapel']['9']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K30', $dt_raport['mapel']['9']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M30', $dt_raport['mapel']['9']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B34', $dt_raport['mapel']['10']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C35', $dt_raport['mapel']['10']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I34', $dt_raport['mapel']['10']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K34', $dt_raport['mapel']['10']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M34', $dt_raport['mapel']['10']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B36', $dt_raport['mapel']['11']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C37', $dt_raport['mapel']['11']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I36', $dt_raport['mapel']['11']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K36', $dt_raport['mapel']['11']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M36', $dt_raport['mapel']['11']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B38', $dt_raport['mapel']['12']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C39', $dt_raport['mapel']['12']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I38', $dt_raport['mapel']['12']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K38', $dt_raport['mapel']['12']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M38', $dt_raport['mapel']['12']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B40', $dt_raport['mapel']['13']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C41', $dt_raport['mapel']['13']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I40', $dt_raport['mapel']['13']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K40', $dt_raport['mapel']['13']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M40', $dt_raport['mapel']['13']['detail']['sikap']['konversi']);

					$awal = 43;
					foreach($dt_raport['lintas'] as $kunci => $lintas)
					{
						$objPHPExcel->getActiveSheet()->setCellValue('B'.$awal, $dt_raport['lintas'][$kunci]['NamaMapel']);				
						$kedua = $awal + 1;
						$objPHPExcel->getActiveSheet()->setCellValue('C'.$kedua, $dt_raport['lintas'][$kunci]['NGuruMapel']);
						$objPHPExcel->getActiveSheet()->setCellValue('I'.$awal, $dt_raport['mapel'][$kunci]['detail']['pengetahuan']['konversi']);
						$objPHPExcel->getActiveSheet()->setCellValue('K'.$awal, $dt_raport['mapel'][$kunci]['detail']['keterampilan']['konversi']);
						$objPHPExcel->getActiveSheet()->setCellValue('M'.$awal, $dt_raport['mapel'][$kunci]['detail']['sikap']['konversi']);
						$awal += 2;
					}*/
				}
			}
			else
			{
				$objPHPExcel = PHPExcel_IOFactory::load("./template/ERAPOR.xls");			

				foreach($raport as $key => $dt_raport)
				{												
					/*foreach ($dt_raport['mapel'] as $key => $dt_mapel) {
						echo count($dt_raport['mapel'])."<br/>";					
						print_r($dt_mapel);
						echo "<hr/>";
					}
					echo "<hr/>";*/
					$indeke = $key + 1;
					$objWorkSheetBase = $objPHPExcel->getSheet();
					$objWorkSheet1 = clone $objWorkSheetBase;		
					$objWorkSheet1->setTitle(reset(explode(" ", $dt_raport['nama'])));		
					$objPHPExcel->addSheet($objWorkSheet1);
					$objPHPExcel->setActiveSheetIndex($indeke);
					//$objPHPExcel->getActiveSheet()->setTitle(reset(explode(" ", $dt_raport['nama'])));
					$objPHPExcel->getActiveSheet()->setCellValue('F3', $dt_raport['nama']);
					$objPHPExcel->getActiveSheet()->setCellValue('F4', $dt_raport['nis']);
					$objPHPExcel->getActiveSheet()->setCellValue('P1', $dt_raport['kelas']);
					$objPHPExcel->getActiveSheet()->setCellValue('P2', $dt_raport['sem']);
					$objPHPExcel->getActiveSheet()->setCellValue('P3', $dt_raport['tahun']);
					$objPHPExcel->getActiveSheet()->setCellValue('M62', $dt_raport['wali_k']['nama_w']);
					$objPHPExcel->getActiveSheet()->setCellValue('M63', "NIP. ".$dt_raport['wali_k']['nip_w']);
					$objPHPExcel->getActiveSheet()->setCellValue('M58', "Rembang, ".$tanggal);

					$objPHPExcel->getActiveSheet()->setCellValue('B11', $dt_raport['mapel']['0']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C12', $dt_raport['mapel']['0']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I11', $dt_raport['mapel']['0']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K11', $dt_raport['mapel']['0']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M11', $dt_raport['mapel']['0']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B13', $dt_raport['mapel']['1']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C14', $dt_raport['mapel']['1']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I13', $dt_raport['mapel']['1']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K13', $dt_raport['mapel']['1']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M13', $dt_raport['mapel']['1']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B15', $dt_raport['mapel']['2']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C16', $dt_raport['mapel']['2']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I15', $dt_raport['mapel']['2']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K15', $dt_raport['mapel']['2']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M15', $dt_raport['mapel']['2']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B17', $dt_raport['mapel']['3']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C18', $dt_raport['mapel']['3']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I17', $dt_raport['mapel']['3']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K17', $dt_raport['mapel']['3']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M17', $dt_raport['mapel']['3']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B19', $dt_raport['mapel']['4']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C20', $dt_raport['mapel']['4']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I19', $dt_raport['mapel']['4']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K19', $dt_raport['mapel']['4']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M19', $dt_raport['mapel']['4']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B21', $dt_raport['mapel']['5']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C22', $dt_raport['mapel']['5']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I21', $dt_raport['mapel']['5']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K21', $dt_raport['mapel']['5']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M21', $dt_raport['mapel']['5']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B24', $dt_raport['mapel']['6']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C25', $dt_raport['mapel']['6']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I24', $dt_raport['mapel']['6']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K24', $dt_raport['mapel']['6']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M24', $dt_raport['mapel']['6']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B26', $dt_raport['mapel']['7']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C27', $dt_raport['mapel']['7']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I26', $dt_raport['mapel']['7']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K26', $dt_raport['mapel']['7']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M26', $dt_raport['mapel']['7']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B28', $dt_raport['mapel']['8']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C29', $dt_raport['mapel']['8']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I28', $dt_raport['mapel']['8']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K28', $dt_raport['mapel']['8']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M28', $dt_raport['mapel']['8']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B30', $dt_raport['mapel']['9']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C31', $dt_raport['mapel']['9']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I30', $dt_raport['mapel']['9']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K30', $dt_raport['mapel']['9']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M30', $dt_raport['mapel']['9']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B34', $dt_raport['mapel']['10']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C35', $dt_raport['mapel']['10']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I34', $dt_raport['mapel']['10']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K34', $dt_raport['mapel']['10']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M34', $dt_raport['mapel']['10']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B36', $dt_raport['mapel']['11']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C37', $dt_raport['mapel']['11']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I36', $dt_raport['mapel']['11']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K36', $dt_raport['mapel']['11']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M36', $dt_raport['mapel']['11']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B38', $dt_raport['mapel']['12']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C39', $dt_raport['mapel']['12']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I38', $dt_raport['mapel']['12']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K38', $dt_raport['mapel']['12']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M38', $dt_raport['mapel']['12']['detail']['sikap']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('B40', $dt_raport['mapel']['13']['NamaMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('C41', $dt_raport['mapel']['13']['NGuruMapel']);
					$objPHPExcel->getActiveSheet()->setCellValue('I40', $dt_raport['mapel']['13']['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('K40', $dt_raport['mapel']['13']['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('M40', $dt_raport['mapel']['13']['detail']['sikap']['konversi']);

					$awal = 43;
					foreach($dt_raport['lintas'] as $kunci => $lintas)
					{
						$objPHPExcel->getActiveSheet()->setCellValue('B'.$awal, $dt_raport['lintas'][$kunci]['NamaMapel']);				
						$kedua = $awal + 1;
						$objPHPExcel->getActiveSheet()->setCellValue('C'.$kedua, $dt_raport['lintas'][$kunci]['NGuruMapel']);
						$objPHPExcel->getActiveSheet()->setCellValue('I'.$awal, $dt_raport['mapel'][$kunci]['detail']['pengetahuan']['konversi']);
						$objPHPExcel->getActiveSheet()->setCellValue('K'.$awal, $dt_raport['mapel'][$kunci]['detail']['keterampilan']['konversi']);
						$objPHPExcel->getActiveSheet()->setCellValue('M'.$awal, $dt_raport['mapel'][$kunci]['detail']['sikap']['konversi']);
						$awal += 2;
					}
				}
			}
									
			//exit();
		}
		elseif($jenise == 2)
		{
			$objPHPExcel = PHPExcel_IOFactory::load("./template/DESKRIPSI".$tingkat.".xls");			

			foreach($raport as $key => $dt_raport)
			{								
				$objWorkSheetBase = $objPHPExcel->getSheet();
				$objWorkSheet1 = clone $objWorkSheetBase;		
				$objWorkSheet1->setTitle(reset(explode(" ", $dt_raport['nama'])));		
				$objPHPExcel->addSheet($objWorkSheet1);
				$objPHPExcel->setActiveSheetIndex($key);
				$objPHPExcel->getActiveSheet()->setCellValue('D3', $dt_raport['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('D4', $dt_raport['nis']);
				$objPHPExcel->getActiveSheet()->setCellValue('M1', $dt_raport['kelas']);
				$objPHPExcel->getActiveSheet()->setCellValue('M2', $dt_raport['sem']);
				$objPHPExcel->getActiveSheet()->setCellValue('M3', $dt_raport['tahun']);
				$objPHPExcel->getActiveSheet()->setCellValue('B67', $dt_raport['wali_k']['nama_w']);
				$objPHPExcel->getActiveSheet()->setCellValue('B68', "NIP. ".$dt_raport['wali_k']['nip_w']);
				$objPHPExcel->getActiveSheet()->setCellValue('J68', $tanggal);

				$objPHPExcel->getActiveSheet()->setCellValue('B9', $dt_raport['mapel']['0']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('J9', $dt_raport['mapel']['0']['detail']['pengetahuan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J10', $dt_raport['mapel']['0']['detail']['keterampilan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J11', $dt_raport['mapel']['0']['detail']['sikap']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('B12', $dt_raport['mapel']['1']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('J12', $dt_raport['mapel']['1']['detail']['pengetahuan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J13', $dt_raport['mapel']['1']['detail']['keterampilan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J14', $dt_raport['mapel']['1']['detail']['sikap']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('B15', $dt_raport['mapel']['2']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('J15', $dt_raport['mapel']['2']['detail']['pengetahuan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J16', $dt_raport['mapel']['2']['detail']['keterampilan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J17', $dt_raport['mapel']['2']['detail']['sikap']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('B18', $dt_raport['mapel']['3']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('J18', $dt_raport['mapel']['3']['detail']['pengetahuan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J19', $dt_raport['mapel']['3']['detail']['keterampilan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J20', $dt_raport['mapel']['3']['detail']['sikap']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('B21', $dt_raport['mapel']['4']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('J21', $dt_raport['mapel']['4']['detail']['pengetahuan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J22', $dt_raport['mapel']['4']['detail']['keterampilan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J23', $dt_raport['mapel']['4']['detail']['sikap']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('B24', $dt_raport['mapel']['5']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('J24', $dt_raport['mapel']['5']['detail']['pengetahuan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J25', $dt_raport['mapel']['5']['detail']['keterampilan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J26', $dt_raport['mapel']['5']['detail']['sikap']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('B28', $dt_raport['mapel']['6']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('J28', $dt_raport['mapel']['6']['detail']['pengetahuan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J29', $dt_raport['mapel']['6']['detail']['keterampilan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J30', $dt_raport['mapel']['6']['detail']['sikap']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('B31', $dt_raport['mapel']['7']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('J31', $dt_raport['mapel']['7']['detail']['pengetahuan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J32', $dt_raport['mapel']['7']['detail']['keterampilan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J33', $dt_raport['mapel']['7']['detail']['sikap']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('B34', $dt_raport['mapel']['8']['NamaMapel']);			
				$objPHPExcel->getActiveSheet()->setCellValue('J34', $dt_raport['mapel']['8']['detail']['pengetahuan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J35', $dt_raport['mapel']['8']['detail']['keterampilan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J36', $dt_raport['mapel']['8']['detail']['sikap']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('B37', $dt_raport['mapel']['9']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('J37', $dt_raport['mapel']['9']['detail']['pengetahuan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J38', $dt_raport['mapel']['9']['detail']['keterampilan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J39', $dt_raport['mapel']['9']['detail']['sikap']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('B42', $dt_raport['mapel']['10']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('J42', $dt_raport['mapel']['10']['detail']['pengetahuan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J43', $dt_raport['mapel']['10']['detail']['keterampilan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J44', $dt_raport['mapel']['10']['detail']['sikap']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('B45', $dt_raport['mapel']['11']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('J45', $dt_raport['mapel']['11']['detail']['pengetahuan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J46', $dt_raport['mapel']['11']['detail']['keterampilan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J47', $dt_raport['mapel']['11']['detail']['sikap']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('B48', $dt_raport['mapel']['12']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('J48', $dt_raport['mapel']['12']['detail']['pengetahuan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J49', $dt_raport['mapel']['12']['detail']['keterampilan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J50', $dt_raport['mapel']['12']['detail']['sikap']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('B51', $dt_raport['mapel']['13']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('J51', $dt_raport['mapel']['13']['detail']['pengetahuan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J52', $dt_raport['mapel']['13']['detail']['keterampilan']['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('J53', $dt_raport['mapel']['13']['detail']['sikap']['keterangan']);

				$awal = 55;
				foreach($dt_raport['lintas'] as $kunci => $lintas)
				{
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$awal, $dt_raport['lintas'][$kunci]['NamaMapel']);				
					$kedua = $awal + 1;
					$ketiga = $awal + 2;
					$objPHPExcel->getActiveSheet()->setCellValue('J'.$awal, $dt_raport['mapel'][$kunci]['detail']['pengetahuan']['keterangan']);
					$objPHPExcel->getActiveSheet()->setCellValue('J'.$kedua, $dt_raport['mapel'][$kunci]['detail']['keterampilan']['keterangan']);
					$objPHPExcel->getActiveSheet()->setCellValue('J'.$ketiga, $dt_raport['mapel'][$kunci]['detail']['sikap']['keterangan']);
					$awal += 3;
				}
			}
		}
		else
		{
			$objPHPExcel = PHPExcel_IOFactory::load("./template/LEGGER".$tingkat.".xls");			

			$baris = 7;
			foreach($raport as $key => $dt_raport)
			{																
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->setCellValue('A1', "LEGER NILAI KELAS ".$dt_raport['kelas']);
				$objPHPExcel->getActiveSheet()->setCellValue('A2', "SEMESTER ".$dt_raport['sem']." TAHUN PELAJARAN ".$dt_raport['tahun']);


				$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $dt_raport['nis']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $dt_raport['nama']);				
				$objPHPExcel->getActiveSheet()->setCellValue('DK43', $dt_raport['wali_k']['nama_w']);
				$objPHPExcel->getActiveSheet()->setCellValue('DK44', "NIP. ".$dt_raport['wali_k']['nip_w']);
				$objPHPExcel->getActiveSheet()->setCellValue('DK39', "Rembang, ".$tanggal);

				$objPHPExcel->getActiveSheet()->setCellValue('D4', $dt_raport['mapel']['0']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $dt_raport['mapel']['0']['detail']['pengetahuan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $dt_raport['mapel']['0']['detail']['keterampilan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, $dt_raport['mapel']['0']['detail']['sikap']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('K4', $dt_raport['mapel']['1']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, $dt_raport['mapel']['1']['detail']['pengetahuan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$baris, $dt_raport['mapel']['1']['detail']['keterampilan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('Q'.$baris, $dt_raport['mapel']['1']['detail']['sikap']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('R4', $dt_raport['mapel']['2']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('R'.$baris, $dt_raport['mapel']['2']['detail']['pengetahuan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('U'.$baris, $dt_raport['mapel']['2']['detail']['keterampilan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('X'.$baris, $dt_raport['mapel']['2']['detail']['sikap']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('Y4', $dt_raport['mapel']['3']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('Y'.$baris, $dt_raport['mapel']['3']['detail']['pengetahuan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('AB'.$baris, $dt_raport['mapel']['3']['detail']['keterampilan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('AE'.$baris, $dt_raport['mapel']['3']['detail']['sikap']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('AF4', $dt_raport['mapel']['4']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('AF'.$baris, $dt_raport['mapel']['4']['detail']['pengetahuan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('AI'.$baris, $dt_raport['mapel']['4']['detail']['keterampilan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('AL'.$baris, $dt_raport['mapel']['4']['detail']['sikap']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('AM4', $dt_raport['mapel']['5']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('AM'.$baris, $dt_raport['mapel']['5']['detail']['pengetahuan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('AP'.$baris, $dt_raport['mapel']['5']['detail']['keterampilan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('AS'.$baris, $dt_raport['mapel']['5']['detail']['sikap']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('AT4', $dt_raport['mapel']['6']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('AT'.$baris, $dt_raport['mapel']['6']['detail']['pengetahuan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('AW'.$baris, $dt_raport['mapel']['6']['detail']['keterampilan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('AZ'.$baris, $dt_raport['mapel']['6']['detail']['sikap']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('BA4', $dt_raport['mapel']['7']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('BA'.$baris, $dt_raport['mapel']['7']['detail']['pengetahuan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('BD'.$baris, $dt_raport['mapel']['7']['detail']['keterampilan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('BG'.$baris, $dt_raport['mapel']['7']['detail']['sikap']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('BH4', $dt_raport['mapel']['8']['NamaMapel']);			
				$objPHPExcel->getActiveSheet()->setCellValue('BH'.$baris, $dt_raport['mapel']['8']['detail']['pengetahuan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('BK'.$baris, $dt_raport['mapel']['8']['detail']['keterampilan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('BN'.$baris, $dt_raport['mapel']['8']['detail']['sikap']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('BO4', $dt_raport['mapel']['9']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('BO'.$baris, $dt_raport['mapel']['9']['detail']['pengetahuan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('BR'.$baris, $dt_raport['mapel']['9']['detail']['keterampilan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('BU'.$baris, $dt_raport['mapel']['9']['detail']['sikap']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('BV4', $dt_raport['mapel']['10']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('BV'.$baris, $dt_raport['mapel']['10']['detail']['pengetahuan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('BY'.$baris, $dt_raport['mapel']['10']['detail']['keterampilan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('CB'.$baris, $dt_raport['mapel']['10']['detail']['sikap']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('CC4', $dt_raport['mapel']['11']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('CC'.$baris, $dt_raport['mapel']['11']['detail']['pengetahuan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('CF'.$baris, $dt_raport['mapel']['11']['detail']['keterampilan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('CI'.$baris, $dt_raport['mapel']['11']['detail']['sikap']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('CJ4', $dt_raport['mapel']['12']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('CJ'.$baris, $dt_raport['mapel']['12']['detail']['pengetahuan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('CM'.$baris, $dt_raport['mapel']['12']['detail']['keterampilan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('CP'.$baris, $dt_raport['mapel']['12']['detail']['sikap']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('CQ4', $dt_raport['mapel']['13']['NamaMapel']);				
				$objPHPExcel->getActiveSheet()->setCellValue('CQ'.$baris, $dt_raport['mapel']['13']['detail']['pengetahuan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('CT'.$baris, $dt_raport['mapel']['13']['detail']['keterampilan']['konversi']);
				$objPHPExcel->getActiveSheet()->setCellValue('CW'.$baris, $dt_raport['mapel']['13']['detail']['sikap']['konversi']);

				$awal = 55;
				$kolom = array("CX4","DF4");
				foreach($dt_raport['lintas'] as $kunci => $lintas)
				{
					$objPHPExcel->getActiveSheet()->setCellValue($kolom[$kunci], $dt_raport['lintas'][$kunci]['NamaMapel']);									
					/*$kedua = $awal + 1;
					$ketiga = $awal + 2;
					$objPHPExcel->getActiveSheet()->setCellValue('J'.$awal, $dt_raport['mapel'][$kunci]['detail']['pengetahuan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('J'.$kedua, $dt_raport['mapel'][$kunci]['detail']['keterampilan']['konversi']);
					$objPHPExcel->getActiveSheet()->setCellValue('J'.$ketiga, $dt_raport['mapel'][$kunci]['detail']['sikap']['konversi']);*/
					$awal += 3;
				}
				$baris++;
			}
		}
		
		$filename="Laporan ".mt_rand(1,100000).".xls"; 
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;filename='".$filename."'");
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
		$objWriter->save("php://output");

		exit;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
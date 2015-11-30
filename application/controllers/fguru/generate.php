<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generate extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('mlaporan','',TRUE);
	}

	function index()
	{
		require_once("./application/libraries/Table/class.fpdf_table.php");
	
		require_once("./application/libraries/Table/header_footer.inc");
		require_once("./application/libraries/Table/table_def.inc");	
	
		$bg_color1 = array(234, 255, 218);
		$bg_color2 = array(165, 250, 220);
		$bg_color3 = array(255, 252, 249);	
	
		$pdf = new pdf_usage();		
		$pdf->SetAutoPageBreak(true, 20);
   	$pdf->SetMargins(-10, 20, -10, -10);	
	
		$kueri = $this->mlaporan->getSiswaKelas();
		foreach($kueri as $dt_kueri)
		{
	$pdf->AddPage();
	$pdf->AliasNbPages();

	$pdf->SetStyle("head1","arial","",8,"0,0,0");
		
	$pdf->SetY(10);
	$pdf->SetX(14);
	$pdf->MultiCellTag(100, 3, "<head1>Nama Peserta Didik</head1>");
	$pdf->SetY(10);
	$pdf->SetX(50);
	$pdf->MultiCellTag(100, 3, "<head1>: ".$dt_kueri->jeneng."</head1>");
	$pdf->SetY(10);
	$pdf->SetX(110);
	$pdf->MultiCellTag(100, 3, "<head1>Nomor Induk</head1>");
	$pdf->SetY(10);
	$pdf->SetX(140);
	$pdf->MultiCellTag(100, 3, "<head1>: ".$dt_kueri->nis."</head1>");
	
	$pdf->SetY(14);
	$pdf->SetX(14);
	$pdf->MultiCellTag(100, 3, "<head1>Bidang Keahlian</head1>");
	$pdf->SetY(14);
	$pdf->SetX(50);
	$pdf->MultiCellTag(100, 3, "<head1>: ".$dt_kueri->bidang_keahlian."</head1>");
	$pdf->SetY(14);
	$pdf->SetX(110);
	$pdf->MultiCellTag(100, 3, "<head1>Program Keahlian</head1>");
	$pdf->SetY(14);
	$pdf->SetX(140);
	$pdf->MultiCellTag(100, 3, "<head1>: ".$dt_kueri->program_keahlian."</head1>");
	
	$pdf->SetY(18);
	$pdf->SetX(14);
	$pdf->MultiCellTag(100, 3, "<head1>Tahun Pelajaran</head1>");
	$pdf->SetY(18);
	$pdf->SetX(50);
	$pdf->MultiCellTag(100, 3, "<head1>: ".$this->mlaporan->getTA($this->session->userdata('kd_ta'))."</head1>");
	$pdf->SetY(18);
	$pdf->SetX(110);
	$pdf->MultiCellTag(100, 3, "<head1>Kelas/Semester</head1>");
	$pdf->SetY(18);
	$pdf->SetX(140);
	$pdf->MultiCellTag(100, 3, "<head1>: ".$dt_kueri->tingkat." / ".$this->session->userdata('kd_sem')."</head1>");	
	
	$pdf->SetY(25);
	
	$columns = 7; //five columns

	$pdf->SetStyle("p","times","",10,"130,0,30");
	$pdf->SetStyle("t1","arial","",10,"0,151,200");
	$pdf->SetStyle("size","times","BI",10,"0,0,120");
    
	$ttxt1 = "<size>Tag-Based MultiCell Table</size>\nCreated by <t1 href='mailto:andy@interpid.eu'>Bintintan Andrei, Interpid Team</t1>";
	$ttxt2 = "<p>The cells in the table are fully functional <t1>Tag Based Multicells components</t1>. The description and usage of these components can be found <t1>here</t1>.</p>";
	
	//Initialize the table class
	$pdf->tbInitialize($columns, true, true);
	
	//set the Table Type
	$pdf->tbSetTableType($table_default_table_type);
	
	//Table Header
	for($i=0; $i<$columns; $i++) $header_type[$i] = $table_default_header_type;
	
	for($i=0; $i<$columns; $i++) {
		$header_type1[$i] = $table_default_header_type;
		$header_type2[$i] = $table_default_header_type;
	}

	$header_type1[0]['WIDTH'] = 10;
	$header_type1[1]['WIDTH'] = 60;
	$header_type1[2]['WIDTH'] = 15;
	$header_type1[3]['WIDTH'] = 15;
	$header_type1[4]['WIDTH'] = 45;
	$header_type1[5]['WIDTH'] = 15;
	$header_type1[6]['WIDTH'] = 20;
	
	$header_type1[0]['TEXT'] = "NO";
	$header_type1[1]['TEXT'] = "Mata Pelajaran";
	$header_type1[2]['TEXT'] = "KKM";
		
	$header_type1[3]['TEXT'] = "Nilai Hasil Belajar";
	$header_type1[3]['COLSPAN'] = 4;
	$header_type1[3]['T_ALIGN'] = 'C';
	
	$header_type1[0]['ROWSPAN'] = 2;
	
	$header_type1[1]['ROWSPAN'] = 2;
	
	$header_type1[2]['ROWSPAN'] = 2;
	
	$header_type2[3]['TEXT'] = "Angka";
	$header_type2[4]['TEXT'] = "Huruf";
	$header_type2[5]['TEXT'] = "Predikat";
	$header_type2[6]['TEXT'] = "Deskripsi Kemajuan Belajar";
	
	$aHeaderArray = array(
		$header_type1,
		$header_type2
	);	

	//set the Table Header
	$pdf->tbSetHeaderType($aHeaderArray, true);
	
	//Draw the Header
	$pdf->tbDrawHeader();

	//Table Data Settings
	$data_type = Array();//reset the array
	for ($i=0; $i<$columns; $i++) $data_type[$i] = $table_default_data_type;

	$pdf->tbSetDataType($data_type);

	for ($j=0; $j<43; $j++)
	{
		$data = Array();
		$data[0]['TEXT'] = $j + 1;
		$data[1]['TEXT'] = "Row No - $j";
		$data[1]['T_ALIGN'] = "L";
		$data[2]['TEXT'] = "Row No - $j";
		$data[2]['T_ALIGN'] = "L";
		$data[3]['TEXT'] = "Row No - $j";
		$data[3]['T_ALIGN'] = "L";
		$data[4]['TEXT'] = "Row No - $j";
		$data[4]['T_ALIGN'] = "L";
		$data[5]['TEXT'] = "Row No - $j";
		$data[5]['T_ALIGN'] = "L";
		$data[6]['TEXT'] = "Row No - $j";
		$data[6]['T_ALIGN'] = "L";
		$data[7]['TEXT'] = "Row No - $j";
		$data[7]['T_ALIGN'] = "L";	

		$pdf->tbDrawData($data);
	}	
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();
	
	$pdf->SetY(230);
	$pdf->SetX(75);
	$pdf->MultiCellTag(100, 3, "<head1>Mengetahui</head1>");
	$pdf->SetY(234);
	$pdf->SetX(72);
	$pdf->MultiCellTag(100, 3, "<head1>Orang Tua / Wali</head1>");
	$pdf->SetY(234);
	$pdf->SetX(140);
	$pdf->MultiCellTag(100, 3, "<head1>Wali Kelas,</head1>");
	$pdf->SetY(260);
	$pdf->SetX(66);
	$pdf->MultiCellTag(100, 3, "<head1>...........................................</head1>");
	$pdf->SetY(260);
	$pdf->SetX(133);
	$pdf->MultiCellTag(100, 3, "<head1>ok</head1>");
	$pdf->SetY(264);
	$pdf->SetX(133);
	$pdf->MultiCellTag(100, 3, "<head1>NIP. ok</head1>");

	$pdf->AddPage();
	
	$pdf->SetStyle("head1","arial","",8,"0,0,0");
	$pdf->SetStyle("head2","arial","B",8,"0,0,0");
	$pdf->SetStyle("head","arial","B",12,"0,0,0");
	
	$pdf->SetY(10);
	$pdf->SetX(75);
	$pdf->MultiCellTag(100, 3, "<head>CATATAN AKHIR SEMESTER</head>");
	
	$pdf->SetY(16);
	$pdf->SetX(14);
	$pdf->MultiCellTag(100, 3, "<head1>Kelas</head1>");
	$pdf->SetY(16);
	$pdf->SetX(50);
	$pdf->MultiCellTag(100, 3, "<head1>: ..................................</head1>");
	
	$pdf->SetY(20);
	$pdf->SetX(14);
	$pdf->MultiCellTag(100, 3, "<head1>Semester</head1>");
	$pdf->SetY(20);
	$pdf->SetX(50);
	$pdf->MultiCellTag(100, 3, "<head1>: ..................................</head1>");
	
	$pdf->SetY(28);
	$pdf->SetX(14);
	$pdf->MultiCellTag(100, 3, "<head2>1. Kegiatan Belajar di Dunia Usaha/Industri dan Instansi Relevan</head2>");
	
	$pdf->SetY(32);
	
	$columns = 6; //five columns

	$pdf->SetStyle("p","times","",10,"130,0,30");
	$pdf->SetStyle("t1","arial","",10,"0,151,200");
	$pdf->SetStyle("size","times","BI",10,"0,0,120");
    
	$ttxt1 = "<size>Tag-Based MultiCell Table</size>\nCreated by <t1 href='mailto:andy@interpid.eu'>Bintintan Andrei, Interpid Team</t1>";
	$ttxt2 = "<p>The cells in the table are fully functional <t1>Tag Based Multicells components</t1>. The description and usage of these components can be found <t1>here</t1>.</p>";
	
	//Initialize the table class
	$pdf->tbInitialize($columns, true, true);
	
	//set the Table Type
	$pdf->tbSetTableType($table_default_table_type);
	
	//Table Header
	for($i=0; $i<$columns; $i++) $header_type[$i] = $table_default_header_type;
	
	for($i=0; $i<$columns; $i++) {
		$header_type1[$i] = $table_default_header_type;
	}

	$header_type1[0]['WIDTH'] = 10;
	$header_type1[1]['WIDTH'] = 35;
	$header_type1[2]['WIDTH'] = 40;
	$header_type1[3]['WIDTH'] = 60;
	$header_type1[4]['WIDTH'] = 15;
	$header_type1[5]['WIDTH'] = 20;
	
	$header_type1[0]['TEXT'] = "NO";
	$header_type1[1]['TEXT'] = "Nama DU/DI atau Instansi Relevan";
	$header_type1[2]['TEXT'] = "Alamat";
	$header_type1[3]['TEXT'] = "Lama dan Waktu Pelaksanaan";
	$header_type1[4]['TEXT'] = "Nilai";
	$header_type1[5]['TEXT'] = "Predikat";

	$aHeaderArray = array(
		$header_type1
	);	

	//set the Table Header
	$pdf->tbSetHeaderType($aHeaderArray, true);
	
	//Draw the Header
	$pdf->tbDrawHeader();

	//Table Data Settings
	$data_type = Array();//reset the array
	for ($i=0; $i<$columns; $i++) $data_type[$i] = $table_default_data_type;

	$pdf->tbSetDataType($data_type);

	for ($j=0; $j<3; $j++)
	{
		$data = Array();
		$data[0]['TEXT'] = $j + 1;
		$data[1]['TEXT'] = "Row No - $j";
		$data[1]['T_ALIGN'] = "L";
		$data[2]['TEXT'] = "Row No - $j";
		$data[2]['T_ALIGN'] = "L";
		$data[3]['TEXT'] = "Row No - $j";
		$data[3]['T_ALIGN'] = "L";
		$data[4]['TEXT'] = "Row No - $j";
		$data[4]['T_ALIGN'] = "L";
		$data[5]['TEXT'] = "Row No - $j";
		$data[5]['T_ALIGN'] = "L";
		$data[6]['TEXT'] = "Row No - $j";
		$data[6]['T_ALIGN'] = "L";

		$pdf->tbDrawData($data);
	}	
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();
	
	$pdf->SetY(58);
	$pdf->SetX(14);
	$pdf->MultiCellTag(100, 3, "<head2>2. Pengembangan Diri dan Kepribadian</head2>");
	
	$pdf->SetY(62);
	
	$columns = 6; //five columns

	$pdf->SetStyle("p","times","",10,"130,0,30");
	$pdf->SetStyle("t1","arial","",10,"0,151,200");
	$pdf->SetStyle("size","times","BI",10,"0,0,120");
    
	$ttxt1 = "<size>Tag-Based MultiCell Table</size>\nCreated by <t1 href='mailto:andy@interpid.eu'>Bintintan Andrei, Interpid Team</t1>";
	$ttxt2 = "<p>The cells in the table are fully functional <t1>Tag Based Multicells components</t1>. The description and usage of these components can be found <t1>here</t1>.</p>";
	
	//Initialize the table class
	$pdf->tbInitialize($columns, true, true);
	
	//set the Table Type
	$pdf->tbSetTableType($table_default_table_type);
	
	//Table Header
	for($i=0; $i<$columns; $i++) $header_type[$i] = $table_default_header_type;
	
	for($i=0; $i<$columns; $i++) {
		$header_type1[$i] = $table_default_header_type;
	}

	$header_type1[0]['WIDTH'] = 50;
	$header_type1[1]['WIDTH'] = 70;
	$header_type1[2]['WIDTH'] = 15;
	$header_type1[3]['WIDTH'] = 15;
	$header_type1[4]['WIDTH'] = 15;
	$header_type1[5]['WIDTH'] = 15;
	
	$header_type1[0]['TEXT'] = "Kegiatan";
	$header_type1[1]['TEXT'] = "Jenis";
	$header_type1[2]['TEXT'] = "Nilai";
		
	$header_type1[3]['TEXT'] = "Keterangan";
	$header_type1[3]['COLSPAN'] = 3;
	$header_type1[3]['T_ALIGN'] = 'C';
	
	$aHeaderArray = array(
		$header_type1
	);	

	//set the Table Header
	$pdf->tbSetHeaderType($aHeaderArray, true);
	
	//Draw the Header
	$pdf->tbDrawHeader();

	//Table Data Settings
	$data_type = Array();//reset the array
	for ($i=0; $i<$columns; $i++) $data_type[$i] = $table_default_data_type;

	$pdf->tbSetDataType($data_type);

	for ($j=0; $j<6; $j++)
	{
		$data = Array();		
		$data[0]['TEXT'] = "Pengembangan Diri";
		$data[0]['ROWSPAN'] = 5;
		$data[1]['TEXT'] = "Row No - $j";
		$data[1]['T_ALIGN'] = "L";
		$data[2]['TEXT'] = "Row No - $j";
		$data[2]['T_ALIGN'] = "L";
		$data[3]['TEXT'] = "Row No - $j";
		$data[3]['T_ALIGN'] = "L";
		$data[4]['TEXT'] = "Row No - $j";
		$data[4]['T_ALIGN'] = "L";
		$data[5]['TEXT'] = "Row No - $j";
		$data[5]['T_ALIGN'] = "L";
		$data[6]['TEXT'] = "Row No - $j";
		$data[6]['T_ALIGN'] = "L";
		$data[7]['TEXT'] = "Row No - $j";
		$data[7]['T_ALIGN'] = "L";	
		if($j==5)
		{
			$data[0]['TEXT'] = "Kepribadian";
			$data[1]['COLSPAN'] = 5;
			$data[1]['T_ALIGN'] = "C";
			$data[1]['TEXT'] = "Baik / Cukup / Kurang";
		}
		$pdf->tbDrawData($data);
	}	
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();
	
	$pdf->SetY(96);
	$pdf->SetX(14);
	$pdf->MultiCellTag(100, 3, "<head2>3. Ketidakhadiran</head2>");
	
	$pdf->SetY(100);
	
	$columns = 6; //five columns

	$pdf->SetStyle("p","times","",10,"130,0,30");
	$pdf->SetStyle("t1","arial","",10,"0,151,200");
	$pdf->SetStyle("size","times","BI",10,"0,0,120");
    
	$ttxt1 = "<size>Tag-Based MultiCell Table</size>\nCreated by <t1 href='mailto:andy@interpid.eu'>Bintintan Andrei, Interpid Team</t1>";
	$ttxt2 = "<p>The cells in the table are fully functional <t1>Tag Based Multicells components</t1>. The description and usage of these components can be found <t1>here</t1>.</p>";
	
	//Initialize the table class
	$pdf->tbInitialize($columns, true, true);
	
	//set the Table Type
	$pdf->tbSetTableType($table_default_table_type);
	
	//Table Header
	for($i=0; $i<$columns; $i++) $header_type[$i] = $table_default_header_type;
	
	for($i=0; $i<$columns; $i++) {
		$header_type1[$i] = $table_default_header_type;
	}

	$header_type1[0]['WIDTH'] = 70;
	$header_type1[1]['WIDTH'] = 50;
	$header_type1[2]['WIDTH'] = 15;
	$header_type1[3]['WIDTH'] = 15;
	$header_type1[4]['WIDTH'] = 15;
	$header_type1[5]['WIDTH'] = 15;
	
	$header_type1[0]['TEXT'] = "Kegiatan";
	$header_type1[1]['TEXT'] = "Jenis";
	$header_type1[2]['TEXT'] = "Nilai";
		
	$header_type1[3]['TEXT'] = "Keterangan";
	$header_type1[3]['COLSPAN'] = 3;
	$header_type1[3]['T_ALIGN'] = 'C';
	
	$aHeaderArray = array(
		$header_type1
	);	

	//set the Table Header
	$pdf->tbSetHeaderType($aHeaderArray, true);

	//Table Data Settings
	$data_type = Array();//reset the array
	for ($i=0; $i<$columns; $i++) $data_type[$i] = $table_default_data_type;

	$pdf->tbSetDataType($data_type);

	for ($j=0; $j<3; $j++)
	{
		$data = Array();		
		$data[0]['TEXT'] = "Pengembangan Diri";
		$data[0]['ROWSPAN'] = 5;
		$data[1]['TEXT'] = $j + 1;
		$data[1]['T_ALIGN'] = "L";
		$data[1]['COLSPAN'] = 5;
	
		$pdf->tbDrawData($data);
	}	
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();
	
	$pdf->SetY(118);
	$pdf->SetX(14);
	$pdf->MultiCellTag(100, 3, "<head2>4. Catatan untuk perhatian orang tua/wali</head2>");
	
	$pdf->SetY(122);
	
	$columns = 6; //five columns

	$pdf->SetStyle("p","times","",10,"130,0,30");
	$pdf->SetStyle("t1","arial","",10,"0,151,200");
	$pdf->SetStyle("size","times","BI",10,"0,0,120");
    
	$ttxt1 = "<size>Tag-Based MultiCell Table</size>\nCreated by <t1 href='mailto:andy@interpid.eu'>Bintintan Andrei, Interpid Team</t1>";
	$ttxt2 = "<p>The cells in the table are fully functional <t1>Tag Based Multicells components</t1>. The description and usage of these components can be found <t1>here</t1>.</p>";
	
	//Initialize the table class
	$pdf->tbInitialize($columns, true, true);
	
	//set the Table Type
	$pdf->tbSetTableType($table_default_table_type);
	
	//Table Header
	for($i=0; $i<$columns; $i++) $header_type[$i] = $table_default_header_type;
	
	for($i=0; $i<$columns; $i++) {
		$header_type1[$i] = $table_default_header_type;
	}

	$header_type1[0]['WIDTH'] = 70;
	$header_type1[1]['WIDTH'] = 50;
	$header_type1[2]['WIDTH'] = 15;
	$header_type1[3]['WIDTH'] = 15;
	$header_type1[4]['WIDTH'] = 15;
	$header_type1[5]['WIDTH'] = 15;
	
	$header_type1[0]['TEXT'] = "Kegiatan";
	$header_type1[1]['TEXT'] = "Jenis";
	$header_type1[2]['TEXT'] = "Nilai";
		
	$header_type1[3]['TEXT'] = "Keterangan";
	$header_type1[3]['COLSPAN'] = 3;
	$header_type1[3]['T_ALIGN'] = 'C';
	
	$aHeaderArray = array(
		$header_type1
	);	

	//set the Table Header
	$pdf->tbSetHeaderType($aHeaderArray, true);

	//Table Data Settings
	$data_type = Array();//reset the array
	for ($i=0; $i<$columns; $i++) $data_type[$i] = $table_default_data_type;

	$pdf->tbSetDataType($data_type);

	for ($j=0; $j<3; $j++)
	{
		$data = Array();		
		$data[0]['TEXT'] = "\n\n\n\n";
		$data[0]['ROWSPAN'] = 3;
		$data[0]['COLSPAN'] = 6;
	
		$pdf->tbDrawData($data);
	}	
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();

	$pdf->SetY(143);
	$pdf->SetX(14);
	$pdf->MultiCellTag(100, 3, "<head2>5. Pernyataan</head2>");
	
	$pdf->SetY(147);
	
	$columns = 6; //five columns

	$pdf->SetStyle("p","times","",10,"130,0,30");
	$pdf->SetStyle("t1","arial","",10,"0,151,200");
	$pdf->SetStyle("size","times","BI",10,"0,0,120");
    
	$ttxt1 = "<size>Tag-Based MultiCell Table</size>\nCreated by <t1 href='mailto:andy@interpid.eu'>Bintintan Andrei, Interpid Team</t1>";
	$ttxt2 = "<p>The cells in the table are fully functional <t1>Tag Based Multicells components</t1>. The description and usage of these components can be found <t1>here</t1>.</p>";
	
	//Initialize the table class
	$pdf->tbInitialize($columns, true, true);
	
	//set the Table Type
	$pdf->tbSetTableType($table_default_table_type);
	
	//Table Header
	for($i=0; $i<$columns; $i++) $header_type[$i] = $table_default_header_type;
	
	for($i=0; $i<$columns; $i++) {
		$header_type1[$i] = $table_default_header_type;
	}

	$header_type1[0]['WIDTH'] = 70;
	$header_type1[1]['WIDTH'] = 50;
	$header_type1[2]['WIDTH'] = 15;
	$header_type1[3]['WIDTH'] = 15;
	$header_type1[4]['WIDTH'] = 15;
	$header_type1[5]['WIDTH'] = 15;
	
	$header_type1[0]['TEXT'] = "Kegiatan";
	$header_type1[1]['TEXT'] = "Jenis";
	$header_type1[2]['TEXT'] = "Nilai";
		
	$header_type1[3]['TEXT'] = "Keterangan";
	$header_type1[3]['COLSPAN'] = 3;
	$header_type1[3]['T_ALIGN'] = 'C';
	
	$aHeaderArray = array(
		$header_type1
	);	

	//set the Table Header
	$pdf->tbSetHeaderType($aHeaderArray, true);

	//Table Data Settings
	$data_type = Array();//reset the array
	for ($i=0; $i<$columns; $i++) $data_type[$i] = $table_default_data_type;

	$pdf->tbSetDataType($data_type);

	for ($j=0; $j<3; $j++)
	{
		$data = Array();		
		$data[0]['TEXT'] = "\n\n\n\n";
		$data[0]['ROWSPAN'] = 3;
		$data[0]['COLSPAN'] = 6;
		$data[0]['HEIGHT'] = 500;
	
		$pdf->tbDrawData($data);
	}	
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();	
	
	$pdf->SetY(180);
	$pdf->SetX(35);
	$pdf->MultiCellTag(100, 3, "<head1>Mengetahui</head1>");
	$pdf->SetY(180);
	$pdf->SetX(133);
	$pdf->MultiCellTag(100, 3, "<head1>Rembang, 19 Agustus 2011</head1>");
	$pdf->SetY(184);
	$pdf->SetX(32);
	$pdf->MultiCellTag(100, 3, "<head1>Orang Tua / Wali</head1>");
	$pdf->SetY(184);
	$pdf->SetX(140);
	$pdf->MultiCellTag(100, 3, "<head1>Wali Kelas,</head1>");
	$pdf->SetY(210);
	$pdf->SetX(26);
	$pdf->MultiCellTag(100, 3, "<head1>...........................................</head1>");
	$pdf->SetY(210);
	$pdf->SetX(133);
	$pdf->MultiCellTag(100, 3, "<head1>Cakra Aminuddin, S. Kom</head1>");
	$pdf->SetY(214);
	$pdf->SetX(133);
	$pdf->MultiCellTag(100, 3, "<head1>NIP. .............................</head1>");
	$pdf->SetY(218);
	$pdf->SetX(85);
	$pdf->MultiCellTag(100, 3, "<head1>Kepala Sekolah,</head1>");
	$pdf->SetY(244);
	$pdf->SetX(79);
	$pdf->MultiCellTag(100, 3, "<head1>Cakra Aminuddin, S. Kom</head1>");
	$pdf->SetY(248);
	$pdf->SetX(79);
	$pdf->MultiCellTag(100, 3, "<head1>NIP. 7979709137591375</head1>");
		
		}
		$pdf->Output();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
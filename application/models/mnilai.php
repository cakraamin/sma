<?php

class Mnilai extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}
	
	function getMapells()
	{
		$query = $this->db->query("SELECT * FROM guru_mapel a,mapel b WHERE a.id_mapel=b.id_mapel AND a.nip='".$this->session->userdata('nip')."' GROUP BY id_team");

		if ($query->num_rows()> 0)
		{
			$data[0] = "Pilih Nama Kelas";
			foreach ($query->result_array() as $row)
			{
				
				$data[$row['id_guru_mapel']] = $row['mapel']." [".$this->getAllGuru($row['id_team'])."]";
			}
		}
		else
		{
			$data[''] = "Tidak Ada Mapel";
		}
		return $data;
	}
	
	function getMapel($id)
	{
		$kueri = $this->db->query("SELECT * FROM guru_mapel WHERE id_guru_mapel='$id'");
		$data = $kueri->row();
		return $data->id_mapel;
	}
	
	function getMenu($id)
	{
		$sql = "SELECT * FROM mapel a,guru_mapel b WHERE a.id_mapel=b.id_mapel AND b.id_guru_mapel='$id'";
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			return $kueri->row();		
		}
	}
	
	function getAdministrasi($id,$sort_by,$sort_order)
	{
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('administrasi');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'administrasi';
		$sql = "SELECT * FROM administrasi WHERE tingkat=1 AND id_guru_mapel='$id' ORDER BY $sort_by $sort_order";
		$query = $this->db->query($sql);
		return $query;
	}
	
	function getSiswaKelas($id,$sort_by,$sort_order)
	{
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('b.nis','b.nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'b.nama';
		$sql = "SELECT * FROM kelas_siswa a,siswa b WHERE a.nis=b.nis AND a.id_kelas='$id' AND a.id_ta='".$this->session->userdata('kd_ta')."' ORDER BY $sort_by $sort_order";	
		$query = $this->db->query($sql);
		return $query;
	}
	
	function getAllGuru($id)
	{
		$kueri = $this->db->query("SELECT * FROM guru_mapel a,guru b WHERE a.nip=b.nip AND a.id_team='$id'");
		$data = $kueri->result();
		$daftar = '';
		foreach($data as $nilai)
		{
			$daftar .= $nilai->nama.", ";
		}
		$jumlah = strlen($daftar);
		return substr($daftar, 0, $jumlah - 2);
	}
	
	function cekSetNilai($id)
	{
		$kueri = $this->db->query("SELECT * FROM set_nilai WHERE id_guru_mapel='$id'");
		return $kueri->num_rows();
	}	
	
	function addSetNilai($id)
	{
		$kueri = $this->db->query("INSERT INTO set_nilai(id_guru_mapel,set_nilai) VALUES('$id','".$this->input->post('nilai',TRUE)."') ");
		return $kueri;
	}
	
	function updateSetNilai($id)
	{
		$kueri = $this->db->query("UPDATE set_nilai SET set_nilai='".$this->input->post('nilai',TRUE)."' WHERE id_guru_mapel='$id'");
		return $kueri;
	}
	
	function getIdSetNilai($id)
	{
		$kueri = $this->db->query("SELECT * FROM set_nilai WHERE id_guru_mapel='$id'");
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->set_nilai;
		}
	}
	
	function getSetNilai($id)
	{
		$kueri = $this->db->query("SELECT * FROM set_nilai WHERE id_guru_mapel='$id'");
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			if($data->set_nilai == 0)
			{
				return "Standard Kompetensi";			
			}
			elseif($data->set_nilai == 1)
			{
				return "Kompetensi Dasar";			
			}
			else
			{
				return "Indikator";
			}				
		}
		else
		{
			return "";
		}
	}
	
	function getKelas($id)
	{
		$query = $this->db->query("SELECT c.id_kelas,c.tingkat,c.nama,c.kode,c.jenis,c.id FROM guru_mapel_kelas a,guru_mapel b,kelas c WHERE a.id_guru_mapel=b.id_guru_mapel AND a.id_kelas=c.id_kelas AND b.id_guru_mapel='$id'");

		if ($query->num_rows()> 0)
		{
			$data[''] = 'Nama Kelas';
			foreach ($query->result_array() as $row)
			{
				if($row['jenis'] == 1)
				{
					$keterangan = $this->getMinatId($row['id']);
				}
				else
				{
					$keterangan = $this->arey->getPenjurusan($row['kode']);
				}
				$data[$row['id_kelas']] = $row['tingkat']." ".$keterangan." ".$row['nama'];
			}
		}
		else
		{
			$data[''] = "";
		}
		return $data;
	}

	private function getMinatId($id)	
	{
		$kueri = $this->db->query("SELECT * FROM mapel WHERE id_mapel='$id'");
		$data = $kueri->row();
		$hasil = (isset($data->mapel))?$data->mapel:"Minat";
		return $hasil;
	}
	
	function getNilai($id,$kode,$kls,$sem,$tingkat,$jenis,$ket=NULL)
	{
		$hasil = array();

		$gjenis = ($jenis == 0)?"":" AND jenis='$jenis' ";
		$sql = "SELECT * FROM nilai WHERE nis='$id' AND id_guru_mapel='$kode' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kls' AND semester='$sem' AND tingkat='$tingkat' AND ket='$ket' $gjenis";		
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			$hasil = array(
				'nilai'		=> ($data->nilai != "" && $data->nilai != "0")?$data->nilai:"kosong",
				'remidi'	=> ($data->remidi != "" && $data->remidi != "0")?$data->remidi:"kosong",
				'tugas'		=> ($data->tugas != "" && $data->tugas != "0")?$data->tugas:"kosong"
			);			
		}
		else
		{
			$hasil = array(
				'nilai'		=> "kosong",
				'remidi'	=> "kosong",
				'tugas'		=> "kosong"
			);	
		}
		return $hasil;			
	}

	function getSikap($id,$kode,$kls,$sem,$ket=NULL)
	{		
		$jumlah = 0;

		$sql = "SELECT * FROM nilai_sikap WHERE nis='$id' AND id_guru_mapel='$kode' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kls' AND semester='$sem' AND ket='$ket'";									
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();

			$nilai_buka = (isset($data->nilai_buka))?$data->nilai_buka:0;
			$nilai_tekun = (isset($data->nilai_tekun))?$data->nilai_tekun:0;
			$nilai_rajin = (isset($data->nilai_rajin))?$data->nilai_rajin:0;
			$nilai_rasa = (isset($data->nilai_rasa))?$data->nilai_rasa:0;
			$nilai_disiplin = (isset($data->nilai_disiplin))?$data->nilai_disiplin:0;
			$nilai_kerjasama = (isset($data->nilai_kerjasama))?$data->nilai_kerjasama:0;
			$nilai_ramah = (isset($data->nilai_ramah))?$data->nilai_ramah:0;
			$nilai_hormat = (isset($data->nilai_hormat))?$data->nilai_hormat:0;
			$nilai_jujur = isset($data->nilai_jujur)?$data->nilai_jujur:0;
			$nilai_janji = (isset($data->nilai_janji))?$data->nilai_janji:0;
			$nilai_peduli = (isset($data->nilai_peduli))?$data->nilai_peduli:0;
			$nilai_jawab = (isset($data->nilai_jawab))?$data->nilai_jawab:0;

			if(isset($data->nh) && $data->nh != "")
			{
				$jumlah = $data->nh;
			}
			else
			{
				$jumlah = $nilai_buka + $nilai_tekun + $nilai_rajin + $nilai_rasa + $nilai_disiplin + $data->nilai_kerjasama + $data->nilai_ramah + $data->nilai_hormat + $data->nilai_jujur + $data->nilai_jujur + $data->nilai_janji + $data->nilai_peduli + $data->nilai_jawab;			
			}
			
			return $this->getKodeSikap($jumlah);
			//return $jumlah;
		}
		else
		{
			return "kosong";		
		}
	}

	private function getKodeSikap($jumlah)
	{		
		$jumlah = ($jumlah/60)*100;
		if($jumlah < 60)
		{
			$ket = "K";
		}
		elseif($jumlah >= 60 && $jumlah <= 69)
		{
			$ket = "C";
		}
		elseif($jumlah >= 70 && $jumlah <= 79)
		{
			$ket = "B";
		}
		else
		{
			$ket = "A";
		}

		return $ket;
	}

	function getTrampil($id,$kode,$kls,$sem,$ket=NULL)
	{		
		$hasil = array();

		$sql = "SELECT * FROM nilai_trampil WHERE nis='$id' AND id_guru_mapel='$kode' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kls' AND semester='$sem' AND ket='$ket'";									
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();

			if(isset($data->nh) && $data->nh != "")
			{
				$val = $data->nh;
			}
			else
			{
				$data = $kueri->row_array();
				for($i=1;$i<=5;$i++)
				{
					if($data['nilai_'.$i] != "")
					{
						$hasil[] = isset($data['nilai_'.$i])?$data['nilai_'.$i]:"";
					}				
				}	

				if(count($hasil))
				{
					$c = array_count_values($hasil); 
					$val = array_search(max($c), $c);
				}
				else
				{				
					$val = 0;
				}	
			}

			return $val;				
		}
		else
		{
			return "kosong";		
		}		
	}
	
	function getIdNilai($id,$kode,$kls,$sem,$tingkat,$jenis,$ket=NULL)
	{
		$gjenis = ($jenis == 0)?"":" AND jenis='$jenis' ";
		$sql = "SELECT * FROM nilai WHERE nis='$id' AND id_guru_mapel='$kode' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kls' AND semester='$sem' AND tingkat='$tingkat' AND ket='$ket' $gjenis";
		
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->id_nilai;					
		}
		else
		{
			return "";		
		}
	}

	function getIdSikap($id,$kode,$kls,$sem,$tingkat,$jenis,$ket=NULL)
	{		
		$sql = "SELECT * FROM nilai_sikap WHERE nis='$id' AND id_guru_mapel='$kode' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kls' AND semester='$sem' AND ket='$ket'";
		
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->id_nilai_sikap;					
		}
		else
		{
			return "";		
		}
	}

	function getIdTrampil($id,$kode,$kls,$sem,$tingkat,$jenis,$ket=NULL)
	{		
		$sql = "SELECT * FROM nilai_trampil WHERE nis='$id' AND id_guru_mapel='$kode' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kls' AND semester='$sem' AND ket='$ket'";
		
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->id_nilai_trampil;					
		}
		else
		{
			return "";		
		}
	}
	
	function addNilai($nip,$id,$kelas,$biji,$tingkat,$jenis,$ket,$pengetahuan)
	{
		if($pengetahuan == 2)
		{	
			$kueri = $this->db->query("INSERT INTO nilai(id_guru_mapel,id_kelas,nis,tugas,id_ta,semester,tingkat,jenis,ket) VALUES('$id','$kelas','$nip','$biji','".$this->session->userdata('kd_ta')."','".$this->session->userdata('kd_sem')."','$tingkat','$jenis','$ket')");				
		}
		else
		{			
			$kueri = $this->db->query("INSERT INTO nilai(id_guru_mapel,id_kelas,nis,nilai,id_ta,semester,tingkat,jenis,ket) VALUES('$id','$kelas','$nip','$biji','".$this->session->userdata('kd_ta')."','".$this->session->userdata('kd_sem')."','$tingkat','$jenis','$ket')");	
		}		
		return $kueri;
	}

	function addKet($id,$kelas,$tingkat,$ket)
	{
		$kueri = $this->db->query("INSERT INTO cek_nilai(id_guru_mapel,id_kelas,id_ta,semester,tingkat,ket) VALUES('$id','$kelas','".$this->session->userdata('kd_ta')."','".$this->session->userdata('kd_sem')."','$tingkat','$ket')");	
		return $kueri;
	}
	
	function cekNilai($nip,$id,$kelas,$tingkat,$ket,$jns)
	{
		if($jns == 1)
		{
			$sql = "SELECT * FROM nilai WHERE id_guru_mapel='$id' AND id_kelas='$kelas' AND nis='$nip' AND id_ta='".$this->session->userdata('kd_ta')."' AND semester='".$this->session->userdata('kd_sem')."' AND tingkat='$tingkat' AND ket='$ket'";
		}
		elseif($jns == 2)
		{
			$sql = "SELECT * FROM nilai_trampil WHERE id_guru_mapel='$id' AND id_kelas='$kelas' AND nis='$nip' AND id_ta='".$this->session->userdata('kd_ta')."' AND semester='".$this->session->userdata('kd_sem')."' AND ket='$ket'";
		}
		else
		{	
			$sql = "SELECT * FROM nilai_sikap WHERE id_guru_mapel='$id' AND id_kelas='$kelas' AND nis='$nip' AND id_ta='".$this->session->userdata('kd_ta')."' AND semester='".$this->session->userdata('kd_sem')."' AND ket='$ket'";
		}
		$kueri = $this->db->query($sql);	
		return $kueri;
	}
	
	function updateNilai($id,$biji,$pengetahuan)
	{
		if($pengetahuan == 1)
		{
			$sql = "UPDATE nilai SET nilai='$biji' WHERE id_nilai='$id'";
		}
		elseif($pengetahuan == 2)
		{
			$sql = "UPDATE nilai SET tugas='$biji' WHERE id_nilai='$id'";
		}
		else
		{
			$sql = "UPDATE nilai SET remidi='$biji' WHERE id_nilai='$id'";
		}
		//return $sql;		
		$kueri = $this->db->query($sql);
		return $kueri;
	}

	function addSikap()
	{
		$data = array(
			'id_nilai_sikap' => '',
		  	'id_guru_mapel' => $this->input->post('id_guru_mapel',TRUE),
		  	'id_kelas' => $this->input->post('id_kelas',TRUE),
		  	'nilai_buka' => $this->input->post('buka',TRUE),
		  	'nilai_tekun' => $this->input->post('tekun',TRUE),
		  	'nilai_rajin' => $this->input->post('rajin',TRUE),
		  	'nilai_rasa' => $this->input->post('rasa',TRUE),
		  	'nilai_disiplin' => $this->input->post('disiplin',TRUE),
		  	'nilai_kerjasama' => $this->input->post('kerjasama',TRUE),
		  	'nilai_ramah' => $this->input->post('ramah',TRUE),
		  	'nilai_hormat' => $this->input->post('hormat',TRUE),
		  	'nilai_jujur' => $this->input->post('jujur',TRUE),
		  	'nilai_janji' => $this->input->post('janji',TRUE),
		  	'nilai_peduli' => $this->input->post('peduli',TRUE),
		  	'nilai_jawab' => $this->input->post('jawab',TRUE),
		  	'nis' => $this->input->post('nis',TRUE),
		  	'id_ta' => $this->session->userdata('kd_ta'),
		  	'semester' => $this->session->userdata('kd_sem'),	
		  	'ket' => $this->input->post('tingkat',TRUE),
		);

		$this->db->insert('nilai_sikap', $data); 
	}

	function addKeterampilan($nilai)
	{	
		$data = array(
			'id_nilai_trampil' => '',
		  	'id_guru_mapel' => $this->input->post('id_guru_mapel',TRUE),
		  	'id_kelas' => $this->input->post('id_kelas',TRUE),
		  	'nilai_1' => (isset($nilai[0]))?$nilai[0]:"",
		  	'nilai_2' => (isset($nilai[1]))?$nilai[1]:"",
		  	'nilai_3' => (isset($nilai[2]))?$nilai[2]:"",
		  	'nilai_4' => (isset($nilai[3]))?$nilai[3]:"",
		  	'nilai_5' => (isset($nilai[4]))?$nilai[4]:"",
		  	'nis' => $this->input->post('nis',TRUE),
		  	'id_ta' => $this->session->userdata('kd_ta'),
		  	'semester' => $this->session->userdata('kd_sem'),	
		  	'ket' => $this->input->post('tingkat',TRUE),
		);

		$this->db->insert('nilai_trampil', $data); 
	}

	function updateSikap($id)
	{
		$data = array(			
		  	'id_guru_mapel' => $this->input->post('id_guru_mapel',TRUE),
		  	'id_kelas' => $this->input->post('id_kelas',TRUE),
		  	'nilai_buka' => $this->input->post('buka',TRUE),
		  	'nilai_tekun' => $this->input->post('tekun',TRUE),
		  	'nilai_rajin' => $this->input->post('rajin',TRUE),
		  	'nilai_rasa' => $this->input->post('rasa',TRUE),
		  	'nilai_disiplin' => $this->input->post('disiplin',TRUE),
		  	'nilai_kerjasama' => $this->input->post('kerjasama',TRUE),
		  	'nilai_ramah' => $this->input->post('ramah',TRUE),
		  	'nilai_hormat' => $this->input->post('hormat',TRUE),
		  	'nilai_jujur' => $this->input->post('jujur',TRUE),
		  	'nilai_janji' => $this->input->post('janji',TRUE),
		  	'nilai_peduli' => $this->input->post('peduli',TRUE),
		  	'nilai_jawab' => $this->input->post('jawab',TRUE),
		  	'nis' => $this->input->post('nis',TRUE),
		  	'id_ta' => $this->session->userdata('kd_ta'),
		  	'semester' => $this->session->userdata('kd_sem'),	
		  	'ket' => $this->input->post('tingkat',TRUE),
		);

		$this->db->where('id_nilai_sikap', $id);
		$this->db->update('nilai_sikap', $data); 
	}

	function updateKeterampilan($id,$nilai)
	{	
		$data = array(			
		  	'id_guru_mapel' => $this->input->post('id_guru_mapel',TRUE),
		  	'id_kelas' => $this->input->post('id_kelas',TRUE),
		  	'nilai_1' => (isset($nilai[0]))?$nilai[0]:"",
		  	'nilai_2' => (isset($nilai[1]))?$nilai[1]:"",
		  	'nilai_3' => (isset($nilai[2]))?$nilai[2]:"",
		  	'nilai_4' => (isset($nilai[3]))?$nilai[3]:"",
		  	'nilai_5' => (isset($nilai[4]))?$nilai[4]:"",
		  	'nis' => $this->input->post('nis',TRUE),
		  	'id_ta' => $this->session->userdata('kd_ta'),
		  	'semester' => $this->session->userdata('kd_sem'),	
		  	'ket' => $this->input->post('tingkat',TRUE),
		);

		$this->db->where('id_nilai_trampil', $id);
		$this->db->update('nilai_trampil', $data); 
	}

	function getNilaiTrampil($id)
	{	
		$hasil = array();		

		$kueri = $this->db->query("SELECT * FROM nilai_trampil WHERE id_nilai_trampil='$id'");
		if($kueri->num_rows() > 0)
		{	
			$data = $kueri->row();		
			if(isset($data->nh) && $data->nh != "")
			{
				$val = $data->nh;
			}
			else
			{
				$data = $kueri->row_array();
				for($i=1;$i<=5;$i++)
				{
					if($data['nilai_'.$i] != "")
					{
						$hasil[] = isset($data['nilai_'.$i])?$data['nilai_'.$i]:"";
					}				
				}

				if(count($hasil))
				{
					$c = array_count_values($hasil); 
					$val = array_search(max($c), $c);
				}
				else
				{			
					$val = 0;
				}
			}			
		}

		return $val;
	}

	function getNilaiSikap($id)
	{
		$hasil = 0;

		$kueri = $this->db->query("SELECT * FROM nilai_sikap WHERE id_nilai_sikap='$id'");
		$data = $kueri->row();

		$buka = (isset($data->nilai_buka))?$data->nilai_buka:0;
		$tekun = (isset($data->nilai_tekun))?$data->nilai_tekun:0;
		$rajin = (isset($data->nilai_rajin))?$data->nilai_rajin:0;
		$rasa = (isset($data->nilai_rasa))?$data->nilai_rasa:0;
		$disiplin = (isset($data->nilai_disiplin))?$data->nilai_disiplin:0;
		$kerjasama = (isset($data->nilai_kerjasama))?$data->nilai_kerjasama:0;
		$ramah = (isset($data->nilai_ramah))?$data->nilai_ramah:0;
		$hormat = (isset($data->nilai_hormat))?$data->nilai_hormat:0;
		$jujur = (isset($data->nilai_jujur))?$data->nilai_jujur:0;
		$janji = (isset($data->nilai_janji))?$data->nilai_janji:0;
		$peduli = (isset($data->nilai_peduli))?$data->nilai_peduli:0;
		$jawab = (isset($data->nilai_jawab))?$data->nilai_jawab:0;

		if(isset($data->nh) && $data->nh != "")
		{
			$hasil = $data->nh;
		}
		else
		{
			$hasil = $buka+$tekun+$rajin+$rasa+$disiplin+$kerjasama+$ramah+$hormat+$jujur+$janji+$peduli+$jawab;		
		}
		
		return $this->getKodeSikap($hasil);
	}

	function getAllSikap($id)
	{
		$kueri = $this->db->query("SELECT * FROM nilai_sikap WHERE id_nilai_sikap='$id'");
		return $kueri->row();
	}

	function getAllKeterampilan($id,$kode)
	{
		$hasil = array();

		$kueri = $this->db->query("SELECT * FROM aspek_nilai a,guru_mapel b WHERE a.id_mapel=b.id_mapel AND b.id_guru_mapel='$id' AND a.jenis_aspek='2'");		
		foreach($kueri->result() as $detail)
		{
			unset($nilai);
			$nilai = array();

			$kue_nilai = $this->db->query("SELECT * FROM nilai_trampil WHERE id_nilai_trampil='$kode'");
			$nilai = $kue_nilai->row_array();			

			$hasil[] = array(
				'fom'		=> $detail->aspek,
				'nilai'		=> $nilai
			);
		}

		return $hasil;
	}

	public function getAspek($id)
	{
		$kueri = $this->db->query("SELECT a.mapel,c.jenis_aspek FROM mapel a,guru_mapel b,aspek_nilai c WHERE a.id_mapel=b.id_mapel AND a.id_mapel=c.id_mapel GROUP BY c.jenis_aspek");
		return $kueri->result();
	}

	public function getTingkatane($jenis,$id)
	{		
		$sql_tingkat = "SELECT * FROM aspek_nilai a,guru_mapel b WHERE a.id_mapel=b.id_mapel AND a.jenis_aspek='$jenis' AND b.id_guru_mapel='$id'";
		$kueri = $this->db->query($sql_tingkat);
		return $kueri->num_rows();
	}

	public function getNilaKkn($id)	
	{
		$sql_tingkat = "SELECT * FROM aspek_nilai a,guru_mapel b WHERE a.id_mapel=b.id_mapel AND a.jenis_aspek='1' AND b.id_guru_mapel='$id' AND a.kkm<>''";
		$kueri = $this->db->query($sql_tingkat);
		$data = $kueri->row();
		$hasil = (isset($data->kkm))?$data->kkm:0;
		return $hasil;
	}

	public function getAspekKeterampilan($id)
	{
		$sql = "SELECT * FROM guru_mapel a,aspek_nilai b WHERE a.id_mapel=b.id_mapel AND a.id_guru_mapel='$id' AND b.jenis_aspek='2'";		
		$kueri = $this->db->query($sql);
		return $kueri->result();		
	}
}
?>

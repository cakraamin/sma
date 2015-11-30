<?php

class Mlaporan extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function getSiswaKelas()
	{
		$sql = "SELECT c.id_kelas,a.nis,a.nama as jeneng,d.bidang_keahlian,d.program_keahlian,c.nama as kelas,c.tingkat,e.nip FROM siswa a,kelas_siswa b,kelas c,keahlian d,kelas_wali e WHERE a.nis=b.nis AND b.id_kelas=c.id_kelas AND c.id_kelas=e.id_kelas AND c.id_keahlian=d.id_keahlian AND b.id_ta='".$this->session->userdata('kd_ta')."' AND e.nip='".$this->session->userdata('nip')."' ORDER BY a.nis ASC ";		
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getMapells()
	{
		//$sql = "SELECT * FROM guru_mapel a,mapel b,guru_mapel_kelas c,kelas d WHERE a.id_mapel=b.id_mapel AND c.id_mapel=b.id_mapel AND c.id_kelas=d.id_kelas AND a.nip='".$this->session->userdata('nip')."'";		
		$sql = "SELECT * FROM guru_mapel_kelas a,guru_mapel b,mapel c,kelas d WHERE a.id_guru_mapel=b.id_guru_mapel AND b.id_mapel=c.id_mapel AND a.id_kelas=d.id_kelas AND b.nip='".$this->session->userdata('nip')."'";
		$query = $this->db->query($sql);

		if ($query->num_rows()> 0)
		{
			$data[0] = "Pilih Nama Pelajaran";
			foreach ($query->result_array() as $row)
			{
				
				$data[$row['id_mapel_kelas']] = $row['mapel']." Kelas ".$row['tingkat']." ".$this->arey->getPenjurusan($row['kode'])." ".$row['nama'];
			}
		}
		else
		{
			$data[''] = "Tidak Ada Mapel";
		}
		return $data;
	}

	public function getAspekNilai($id)
	{
		$kueri = $this->db->query("SELECT * FROM aspek_nilai WHERE jenis_aspek='$id'");
		if($kueri->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function getSiswaKelasId($id)
	{
		$sql = "SELECT c.id_kelas,a.nis,a.nama as jeneng,d.bidang_keahlian,d.program_keahlian,c.nama as kelas,c.tingkat,e.nip FROM siswa a,kelas_siswa b,kelas c,keahlian d,kelas_wali e WHERE a.nis=b.nis AND b.id_kelas=c.id_kelas AND c.id_kelas=e.id_kelas AND c.id_keahlian=d.id_keahlian AND b.id_ta='".$this->session->userdata('kd_ta')."' AND a.nis='".$id."' AND e.nip='".$this->session->userdata('nip')."' ";
		//$sql = "SELECT b.id_kelas,a.nis,a.nama as jeneng,d.bidang_keahlian,d.program_keahlian,e.nama as kelas,e.tingkat FROM siswa a,kelas_siswa b,kelas_wali c,keahlian d,kelas e WHERE c.id_kelas=b.id_kelas AND a.nis=b.nis AND c.nip='".$this->session->userdata('nip')."' AND a.id_keahlian=d.id_keahlian AND e.id_kelas=b.id_kelas AND b.id_ta='".$this->session->userdata('kd_ta')."' AND a.nis='$id'";		
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getSiswaKelasKls($id)
	{
		$sql = "SELECT c.id_kelas,a.nis,a.nama as jeneng,d.bidang_keahlian,d.program_keahlian,c.nama as kelas,c.tingkat,e.nip FROM siswa a,kelas_siswa b,kelas c,keahlian d,kelas_wali e WHERE a.nis=b.nis AND b.id_kelas=c.id_kelas AND c.id_kelas=e.id_kelas AND c.id_keahlian=d.id_keahlian AND b.id_ta='".$this->session->userdata('kd_ta')."' AND c.id_kelas='".$id."' ";
		//$sql = "SELECT b.id_kelas,a.nis,a.nama as jeneng,d.bidang_keahlian,d.program_keahlian,e.nama as kelas,e.tingkat,c.nip FROM siswa a,kelas_siswa b,kelas_wali c,keahlian d,kelas e WHERE c.id_kelas=b.id_kelas AND a.nis=b.nis AND a.id_keahlian=d.id_keahlian AND e.id_kelas=b.id_kelas AND b.id_ta='".$this->session->userdata('kd_ta')."' AND e.id_kelas='$id'";		
		$query = $this->db->query($sql);
		return $query->result();
		//return $sql;
	}
	
	function getListSiswaKelas()
	{
		$sql = "SELECT b.id_kelas,a.nis,a.nama as jeneng,d.bidang_keahlian,d.program_keahlian,e.nama as kelas,e.tingkat FROM siswa a,kelas_siswa b,kelas_wali c,keahlian d,kelas e WHERE c.id_kelas=b.id_kelas AND a.nis=b.nis AND c.nip='".$this->session->userdata('nip')."' AND a.id_keahlian=d.id_keahlian AND e.id_kelas=b.id_kelas AND b.id_ta='".$this->session->userdata('kd_ta')."'";		
		$query = $this->db->query($sql);
		if ($query->num_rows()> 0)
		{
			foreach ($query->result_array() as $row)
			{
				$data[$row['nis']] = $row['jeneng'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
	}
	
	function getKelas()
	{
		$sql = "SELECT a.id_kelas,a.tingkat,a.nama,a.kode,a.jenis,a.id FROM kelas a";		
		$query = $this->db->query($sql);
		if ($query->num_rows()> 0)
		{
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
		$query->free_result();
		return $data;
	}

	public function getRaport($kls)
	{
		$hasil = array();
		$kueri = $this->db->query("SELECT * FROM kelas_siswa a,siswa b WHERE a.nis=b.nis AND a.id_kelas='$kls' AND a.id_ta='".$this->session->userdata('kd_ta')."'");
		$data = $kueri->result();
		foreach($data as $dt)
		{
			$semester = ($this->session->userdata('kd_sem') == 1)?"1 (Satu)":"2 (Dua)";
			$hasil[] = array(
				'nis'		=> $dt->nis,
				'nama'		=> $dt->nama,
				't_lahir'	=> $dt->tempat_lahir,
				'tgl_lahir'	=> $dt->tanggal_lahir,
				'alamat_sis'=> $dt->alamat,
				'agama'		=> $dt->agama,
				'status'	=> $dt->status,
				'anak'		=> $dt->anak,
				'telp_a'	=> $dt->telp_anak,
				'ayah'		=> $dt->ayah,
				'ibu'		=> $dt->ibu,
				'alamat_or'	=> $dt->alamat_ortu,
				'k_ayah'	=> $dt->kerja_ayah,
				'k_ibu'		=> $dt->kerja_ibu,
				'telp_o'	=> $dt->telp_ortu,
				'asal'		=> $dt->asal_sek,
				'wali'		=> $dt->wali,
				'alamat_w'	=> $dt->alamat_wali,
				'kerja_w'	=> $dt->kerja_wali,
				'telp_w'	=> $dt->telp_wali,
				'tahun'		=> $this->getTahunRaport($this->session->userdata('kd_ta')),
				'sem'		=> $semester,
				'kelas'		=> $this->getDetailKelas($kls),
				'wali_k'	=> $this->getWaliKelase($kls),
				'mapel'		=> $this->getDetailMapel($kls),
				'lintas'	=> $this->getLintasMinat($dt->nis)
			);
		}

		return $hasil;
	}

	public function getTingkatKelas($id)
	{
		$kueri = $this->db->query("SELECT * FROM kelas WHERE id_kelas='$id'");
		$data = $kueri->row();
		$hasil = (isset($kueri->tingkat))?$kueri->tingkat:"X";
		return $hasil;
	}

	private function getLintasMinat($id)
	{
		$hasil = array();

		$sql = "SELECT c.id_mapel,c.mapel,e.id_guru_mapel,f.nip,f.nama FROM kelas_siswa a,kelas b,mapel c,guru_mapel_kelas d,guru_mapel e,guru f WHERE a.id_kelas=b.id_kelas AND b.jenis='1' AND a.nis='$id' AND a.id_ta='".$this->session->userdata('kd_ta')."' AND b.id=c.id_mapel AND a.id_kelas=d.id_kelas AND d.id_guru_mapel=e.id_guru_mapel AND e.nip=f.nip";		
		$kueri = $this->db->query($sql);
		$data = $kueri->result();
		foreach($data as $dt)
		{
			$kkm = $this->getNilaiKkm($dt->id_mapel);
			$jAspek = $this->getJumlahAspek($dt->id_mapel);
			$hasil[] = array(
				'NGuruMapel'	=> $dt->nama,
				'NipGuruMapel'	=> $dt->nip,
				'NamaMapel'		=> $dt->mapel,
				'IdMapel'		=> $dt->id_mapel,
				'detail'		=> array(
					'pengetahuan'		=> $this->getNAPengetahuan($dt->id_guru_mapel,$id,$jAspek,$kkm,$dt->id_mapel,1),
					'keterampilan'		=> $this->getNAKeterampilan($dt->id_guru_mapel,$id,$jAspek,$kkm,$dt->id_mapel),
					'sikap'				=> $this->getNASikap($dt->id_guru_mapel,$id,$jAspek,$kkm,$dt->id_mapel)
				)
			);
		}
		return $hasil;				
	}

	private function getDetailMapel($id)
	{
		$hasil = array();

		$sql = "SELECT c.nip,c.nama,b.id_guru_mapel,d.mapel,d.id_mapel FROM guru_mapel_kelas a,guru_mapel b,guru c,mapel d WHERE a.id_guru_mapel=b.id_guru_mapel AND b.nip=c.nip AND b.id_mapel=d.id_mapel AND a.id_kelas='$id' AND a.id_ta='".$this->session->userdata('kd_ta')."' GROUP BY a.id_guru_mapel";				
		$kueri = $this->db->query($sql);
		$data = $kueri->result();
		foreach($data as $dt)
		{
			$kkm = $this->getNilaiKkm($dt->id_mapel);
			$jAspek = $this->getJumlahAspek($dt->id_mapel);
			$hasil[] = array(
				'NGuruMapel'	=> $dt->nama,
				'NipGuruMapel'	=> $dt->nip,
				'NamaMapel'		=> $dt->mapel,
				'IdMapel'		=> $dt->id_mapel,
				'detail'		=> array(
					'pengetahuan'		=> $this->getNAPengetahuan($dt->id_guru_mapel,$id,$jAspek,$kkm,$dt->id_mapel,1),
					'keterampilan'		=> $this->getNAKeterampilan($dt->id_guru_mapel,$id,$jAspek,$kkm,$dt->id_mapel),
					'sikap'				=> $this->getNASikap($dt->id_guru_mapel,$id,$jAspek,$kkm,$dt->id_mapel)
				)
			);
		}
		return $hasil;
	}	

	private function getDeskripsi($ket,$kosong,$kode)
	{
		if($kode == 1)
		{
			$nama = "Nilai pengetahuan";
		}
		elseif($kode == 2)
		{
			$nama = "Nilai keterampilan";
		}
		else
		{
			$nama = "Nilai sikap";
		}

		if($kosong == 0)
		{
			$keterangan = "";
		}
		elseif($kosong > 0 && $kosong < 3)
		{
			$keterangan = $nama." baik dan ";
		}
		else
		{
			$keterangan = $nama." sangat baik dan ";
		}
		return $keterangan.implode(", ", $ket);
	}

	/*
	$id = id_guru_mapel
	$kls = id_kelas		
	$jum = jumlah aspek
	$kkm = nilai kkm
	$mapel = id_mapel,
	$tingkat = $tingkat
	*/
	public function getNASikap($id,$kls,$jum,$kkm,$mapel)
	{
		$hasil = array();
		$ket = array();
		$nilai = 0;
		$tugas = 0;
		$jumlah = 0;
		$total = 0;
		$all = 0;
		$kosonge = 0;

		for($i=1;$i<=$jum;$i++)
		{
			$tkt = $i + 1;
			$sql = "SELECT * FROM nilai_sikap WHERE id_guru_mapel='$id' AND id_kelas='$kls' AND ket='$tkt' AND id_ta='".$this->session->userdata('kd_ta')."' AND semester='".$this->session->userdata('kd_sem')."'";
			$kueri = $this->db->query($sql);
			if($kueri->num_rows > 0)
			{
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

				$total = $buka + $tekun + $rajin + $rasa + $disiplin + $kerjasama + $ramah + $hormat + $jujur + $janji + $peduli + $jawab;				
			}
			
			$hasil[$i] = $nilai;						
			$all = $all + $nilai;
			$keterangansss = $this->getEKeterangan($hasil[$i],$i,$mapel,2,$kkm);
			if($keterangansss == "")
			{
				$kosonge = $kosonge + 1;
			}
			else
			{
				$ket[$i] = $keterangansss;
			}
		}

		$jum = ($jum == 0)?1:$jum;
		$konversi = $this->getKonversi($all/$jum);

		$akhir = array(
			'nilai'		=> $hasil,
			'keterangan'=> $this->getDeskripsi($ket,$kosonge,1),
			'total'		=> $all,			
			'konversi'	=> $konversi,
			'rata'		=> $this->getKodeSikap($all/$jum),
		);
		return $akhir;
	}

	/*
	$id = id_guru_mapel
	$kls = id_kelas		
	$jum = jumlah aspek
	$kkm = nilai kkm
	$mapel = id_mapel,
	$tingkat = $tingkat
	*/
	public function getNAKeterampilan($id,$kls,$jum,$kkm,$mapel)
	{
		$hasil = array();
		$ket = array();
		$nilai = 0;
		$tugas = 0;
		$jumlah = 0;
		$total = 0;
		$kosonge = 0;

		for($i=1;$i<=$jum;$i++)
		{
			$tkt = $i + 1;
			$sql = "SELECT * FROM nilai_trampil WHERE id_guru_mapel='$id' AND id_kelas='$kls' AND ket='$tkt' AND id_ta='".$this->session->userdata('kd_ta')."' AND semester='".$this->session->userdata('kd_sem')."'";
			$kueri = $this->db->query($sql);
			if($kueri->num_rows > 0)
			{
				$data = $kueri->row();
				$satu = (isset($data->nilai_1))?$data->nilai_1:0;
				$dua = (isset($data->nilai_2))?$data->nilai_2:0;
				$tiga = (isset($data->nilai_3))?$data->nilai_3:0;
				$empat = (isset($data->nilai_4))?$data->nilai_4:0;
				$lima = (isset($data->nilai_5))?$data->nilai_5:0;

				$total = $satu + $dua + $tiga + $empat + $lima;
				$nilai = $total/$aspek;
			}
			
			$hasil[$i] = $nilai;		
			$jumlah = $jumlah + $nilai;				
			$keterangansss = $this->getEKeterangan($hasil[$i],$i,$mapel,2,$kkm);
			if($keterangansss == "")
			{
				$kosonge = $kosonge + 1;
			}
			else
			{
				$ket[$i] = $keterangansss;
			}
		}

		$jum = ($jum == 0)?1:$jum;
		$konversi = $this->getKonversi($jumlah/$jum);

		$akhir = array(
			'nilai'		=> $hasil,
			'keterangan'=> $this->getDeskripsi($ket,$kosonge,2),
			'rata'		=> $jumlah/$jum,			
			'konversi'	=> $konversi,
			'predikat'	=> $this->getPredikat($konversi)
		);
		return $akhir;
	}

	/*
	$id = id_guru_mapel
	$kls = id_kelas		
	$jum = jumlah aspek
	$kkm = nilai kkm
	$mapel = id_mapel,
	$tingkat = $tingkat
	*/
	public function getNAPengetahuan($id,$kls,$jum,$kkm,$mapel,$tingkat)
	{
		$hasil = array();
		$nilai = 0;
		$tugas = 0;
		$jumlah = 0;
		$ket = array();
		$kosonge = 0;

		for($i=1;$i<=$jum;$i++)
		{
			$tkt = $i + 1;
			$sql = "SELECT * FROM nilai WHERE id_guru_mapel='$id' AND id_kelas='$kls' AND tingkat='$tingkat' AND ket='$tkt' AND id_ta='".$this->session->userdata('kd_ta')."' AND semester='".$this->session->userdata('kd_sem')."'";
			$kueri = $this->db->query($sql);
			if($kueri->num_rows > 0)
			{
				$data = $kueri->row();
				$tugas = ($data->tugas == "")?0:$data->tugas;
				if($data->nilai > $kkm)
				{
					$nilai = $data->nilai;
				}
				else
				{
					if($data->nilai > $kkm)
					{
						$nilai = $kkm;
					}
					else
					{
						$nilai = $data->nilai;
					}
				}
				$nilai = ($nilai + $tugas) / 2;
			}
			else
			{
				$nilai = 0;
			}
			
			$hasil[$i] = $nilai;
			$jumlah = $jumlah + $nilai;			
			$keterangansss = $this->getEKeterangan($hasil[$i],$i,$mapel,1,$kkm);
			if($keterangansss == "")
			{
				$kosonge = $kosonge + 1;
			}
			else
			{
				$ket[$i] = $keterangansss;
			}
		}		
		$jum = ($jum == 0)?1:$jum;
		$konversi = $this->getKonversi($jumlah/$jum);

		$akhir = array(
			'nilai'		=> $hasil,
			'keterangan'=> $this->getDeskripsi($ket,$kosonge,3),
			'rata'		=> $jumlah/$jum,			
			'konversi'	=> $konversi,
			'predikat'	=> $this->getPredikat($konversi)
		);
		return $akhir;
	}

	private function getKonversi($nilai)
	{
		$nilai = ($nilai/100)*4;
		return round($nilai, 2);
	}

	private function getPredikat($nilai)
	{
		if($nilai >= 3.85 && $nilai <= 4)
		{
			$hasil = "A";
		}
		elseif($nilai >= 3.51 && $nilai <= 3.84)
		{
			$hasil = "A-";
		}
		elseif($nilai >= 3.18 && $nilai <= 3.50)
		{
			$hasil = "B+";			
		}
		elseif($nilai >= 2.85 && $nilai <= 3.17)
		{
			$hasil = "B";
		}
		elseif($nilai >= 2.51 && $nilai <= 2.84)
		{
			$hasil = "B-";
		}
		elseif($nilai >= 2.18 && $nilai <= 2.50)
		{
			$hasil = "C+";		
		}
		else
		{
			$hasil = "C";
		}

		return $hasil;
	}

	private function getJumlahAspek($id)
	{
		$kueri = $this->db->query("SELECT * FROM aspek_nilai WHERE id_mapel='$id' AND jenis_aspek='1'");
		return $kueri->num_rows();
	}

	private function getEKeterangan($nilai,$id,$mapel,$jenis,$kkm)
	{
		$hasil = "";
		$keterangan = "";
		$aspek = "";		

		$sql = "SELECT * FROM aspek_nilai WHERE id_mapel='$mapel' AND tingkat_aspek='$id' AND jenis_aspek='$jenis'";
		$kueri = $this->db->query($sql);
		$data = $kueri->row();
		if($nilai < $kkm)
		{
			$aspek = (isset($data->aspek))?$data->aspek:"";
			$keterangan = "kurang dalam ";
		}						

		return $keterangan.$aspek;
	}

	private function getDetailKelas($id)
	{
		$kueri = $this->db->query("SELECT * FROM kelas WHERE id_kelas='$id'");
		$data = $kueri->row();
		$keterangan = ($data->jenis == 1)?$this->getMinatId($data->jenis):$this->arey->getPenjurusan($data->kode);
		$hasil = $data->tingkat." ".$keterangan." ".$data->nama;
		return $hasil;
	}

	private function getWaliKelase($id)
	{
		$hasil = array();

		$kueri = $this->db->query("SELECT * FROM kelas_wali a,guru b WHERE a.nip=b.nip AND a.id_kelas='$id'");
		$data = $kueri->row();
		$hasil = array(
			'nama_w'		=> (isset($data->nama))?$data->nama:"",
			'nip_w'			=> (isset($data->nip))?$data->nip:""
		);

		return $hasil;
	}

	public function getMinatId($id)
	{
		$sql = "SELECT * FROM mapel WHERE id_mapel='$id'";
		$kueri = $this->db->query($sql);
		$data = $kueri->row();
		$hasil = (isset($data->mapel))?$data->mapel:"Minat";
		return $hasil;
		//return $sql;
	}
	
	function getDudi($kls,$nis)
	{
		$kueri = $this->db->query("SELECT * FROM industri WHERE id_kelas='$kls' AND nis='$nis' AND id_ta='".$this->session->userdata('kd_ta')."'");
		return $kueri->result();
	}
	
	function getCatat($kls,$nis)
	{
		$kueri = $this->db->query("SELECT * FROM catatan WHERE id_kelas='$kls' AND nis='$nis' AND id_ta='".$this->session->userdata('kd_ta')."' AND semester='".$this->session->userdata('kd_sem')."'");
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->catatan;
		}
		else
		{
			return "";
		}
	}
	
	function getDiri($kls,$nis)
	{
		$kueri = $this->db->query("SELECT * FROM diri a,nilai_diri b WHERE a.id_diri=b.id_diri AND b.id_kelas='$kls' AND b.nis='$nis' AND b.id_ta='".$this->session->userdata('kd_ta')."' AND b.semester='".$this->session->userdata('kd_sem')."'");
		return $kueri->result();	
	}
	
	function getTA($id)
	{
		$kueri = $this->db->query("SELECT * FROM ta WHERE id_ta='$id'");
		$data = $kueri->row();
		return $data->ta;		
	}
	
	function getNamaWali()
	{
		$sql = "SELECT * FROM guru WHERE nip='".$this->session->userdata('nip')."'";
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->nama;
		}
	}
	
	function getNamaWalis($id)
	{
		$sql = "SELECT * FROM guru WHERE nip='$id'";
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->nama;
		}
	}
	
	function getNipWalis($id)
	{
		$sql = "SELECT * FROM guru WHERE nip='$id'";
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->nip;
		}
	}
	
	function getNipWali()
	{
		$sql = "SELECT * FROM guru WHERE nip='".$this->session->userdata('nip')."'";
		$kueri = $this->db->query($sql);
		$data = $kueri->row();
		return $data->nip;
	}
	
	function getMapel($kelas,$jenis)
	{
		$sql = "SELECT e.mapel,e.id_mapel FROM kelas a,kelas_siswa b,guru_mapel_kelas c,guru_mapel d,mapel e WHERE a.id_kelas=b.id_kelas AND a.id_kelas=c.id_kelas AND c.id_mapel AND d.id_mapel AND d.id_mapel=e.id_mapel AND b.id_kelas='$kelas' AND e.jenis='$jenis' AND c.id_mapel=e.id_mapel GROUP BY e.id_mapel";
		$kueri = $this->db->query($sql);
		return $kueri->result();
	}
	
	function getKkm($mapel,$tingkat)
	{
		if($tingkat == "X")
		{
			$sql = "SELECT kkm1 as nilai FROM kkm WHERE id_mapel='$mapel' AND id_ta='".$this->session->userdata('kd_ta')."'";
		}
		elseif($tingkat == "XI")
		{
			$sql = "SELECT kkm2 as nilai FROM kkm WHERE id_mapel='$mapel' AND id_ta='".$this->session->userdata('kd_ta')."'";
		}
		else
		{
			$sql = "SELECT kkm3 as nilai FROM kkm WHERE id_mapel='$mapel' AND id_ta='".$this->session->userdata('kd_ta')."'";
		}
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->nilai;
		}
		else
		{
			return "";		
		}
	}
	
	function getMapelAll($mapel,$kls)
	{
		$kueri = $this->db->query("SELECT b.persen,b.id_guru_mapel,d.rumus1,d.rumus2,d.rumus3 FROM mapel a,guru_mapel b,guru_mapel_kelas c,rumus_nilai d WHERE a.id_mapel=b.id_mapel AND a.id_mapel=c.id_mapel AND a.id_mapel='$mapel' AND c.id_kelas='$kls' AND c.id_ta='".$this->session->userdata('kd_ta')."' AND a.id_mapel=d.id_mapel GROUP BY b.id_guru_mapel");
		return $kueri->result();
	}
	
	function jumNilai($guru,$kls,$nis,$no)
	{
		$kueri = $this->db->query("SELECT * FROM nilai WHERE id_guru_mapel='$guru' AND id_kelas='$kls' AND nis='$nis' AND tingkat='$no'");
		return $kueri->result();
	}
	
	function jumNilaiCount($guru,$kls,$nis,$no)
	{
		$kueri = $this->db->query("SELECT nilai FROM nilai WHERE id_guru_mapel='$guru' AND id_kelas='$kls' AND nis='$nis' AND tingkat='$no'");
		$data = $kueri->result();
		return $kueri->num_rows();
	}
	
	function getStateNaik($kls,$nis)
	{
		$kueri = $this->db->query("SELECT * FROM kenaikan WHERE id_kelas_siswa='$kls' AND nis='$nis' AND id_ta='".$this->session->userdata('kd_ta')."'");
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->status;
		}
		else
		{
			return "0";		
		}
	}

	function getMasterAll($id)
	{
		$hasil = array(
			'tahun'		=> $this->getTahun($this->session->userdata('kd_ta')),
			'sem'		=> $this->session->userdata('kd_sem'),
			'kelas'		=> $this->getKelasMapel($id),
			'aspek'		=> $this->getDetailAspek($id)
		);

		return $hasil;
	}

	private function getDetailAspek($id)
	{
		$hasil = array();

		$sql = "SELECT * FROM guru_mapel_kelas a,guru_mapel b,aspek_nilai c WHERE  a.id_guru_mapel=b.id_guru_mapel AND a.id_mapel_kelas='$id' AND b.id_mapel=c.id_mapel AND c.jenis_aspek='1'";
		$kueri = $this->db->query($sql);
		$nilai = $kueri->row();

		$hasil = array(
			'jumlah'		=> $kueri->num_rows(),
			'kkm'			=> (isset($nilai->kkm))?$nilai->kkm:0
		);

		return $hasil;		
	}

	public function getMasterUts($id)
	{
		$hasil = array(
			'tahun'		=> $this->getTahun($this->session->userdata('kd_ta')),
			'sem'		=> $this->session->userdata('kd_sem'),
			'kelas'		=> $this->getKelasId($id)
		);

		return $hasil;
	}

	private function getKelasId($id)
	{
		$sql = "SELECT * FROM guru a,mapel b,guru_mapel c,guru_mapel_kelas d,kelas e WHERE c.nip=a.nip AND c.id_mapel=b.id_mapel AND d.id_guru_mapel=c.id_guru_mapel AND d.id_kelas=e.id_kelas AND d.id_mapel_kelas='$id'";	
		//echo $sql;
		//exit();
		$kueri = $this->db->query($sql);
		$data = $kueri->row();
		$hasil = array(
			'kelas'			=> $data->tingkat." ".$this->arey->getPenjurusan($data->kode)." ".$data->nama,
			'mapel'			=> $data->mapel,			
			'wali'			=> $this->getWaliKelas($data->id_kelas),
			'guru_mapel'	=> $this->getGuruMapel($data->id_mapel),
			'kepala'		=> $this->getKepala(),
			'tanggal'		=> date("dd-mm-yyyy"),
			'id_kelas'		=> $data->id_kelas,
			'id_guru_mapel'	=> $data->id_guru_mapel,
			'id_mapel'		=> $data->id_mapel,
			'kkm'			=> $this->getNilaiKkm($data->id_mapel)
		);
		return $hasil;
	}

	private function getNilaiKkm($id)
	{
		$kueri = $this->db->query("SELECT * FROM aspek_nilai WHERE id_mapel='$id'");
		$data = $kueri->row();
		$hasil = (isset($data->kkm))?$data->kkm:0;
		return $hasil;
	}

	public function getNilaiUts($id)
	{
		$hasil = array();

		$sql = "SELECT * FROM kelas_siswa a,siswa b WHERE a.nis=b.nis AND a.id_kelas='$id'";
		//echo $sql;
		//exit();
		$kueri = $this->db->query($sql);
		$data = $kueri->result();
		foreach($data as $dt)
		{
			$hasil[] = array(
				'nis'		=> $dt->nis,
				'nama'		=> $dt->nama,
				'nh1'		=> $this->getNilaiHarian($dt->nis,1,$id),
				'nh2'		=> $this->getNilaiHarian($dt->nis,2,$id),
				'nh3'		=> $this->getNilaiHarian($dt->nis,3,$id),
				'trampil1'	=> $this->getNilaiTrampil($dt->nis,1,$id),
				'trampil2'	=> $this->getNilaiTrampil($dt->nis,2,$id),
				'trampil3'	=> $this->getNilaiTrampil($dt->nis,3,$id),
				'uts'		=> $this->getNilaiHUts($dt->nis,$id),
			);			
		}

		return $hasil;
	}

	private function getNilaiHarian($nis,$id,$kelas)
	{
		$hasil = array();

		$id = $id + 1;
		$kueri = $this->db->query("SELECT * FROM nilai WHERE nis='$nis' AND ket='$id' AND tingkat='1' AND id_kelas='$kelas' AND id_ta='".$this->session->userdata('kd_ta')."' AND semester='".$this->session->userdata('kd_sem')."'");
		$data = $kueri->row();

		$hasil = array(
			'nilai'		=> (isset($data->nilai) && $data->nilai != "")?$data->nilai:"",
			'remidi'	=> (isset($data->remidi) && $data->remidi != "")?$data->remidi:"",
			'tugas'		=> (isset($data->tugas) && $data->tugas != "")?$data->tugas:""
		);

		return $hasil;
	}

	private function getNilaiTrampil($nis,$id,$kelas)
	{
		$nilai = array();

		$id = $id + 1;
		$sql = "SELECT * FROM nilai_trampil WHERE nis='$nis' AND ket='$id' AND id_kelas='$kelas' AND id_ta='".$this->session->userdata('kd_ta')."' AND semester='".$this->session->userdata('kd_sem')."'";
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
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

			return ($val/100)*4;
		}
		else
		{
			return 0;
		}
		//return $sql;
	}

	private function getNilaiHUts($nis,$kelas)
	{
		$hasil = array();

		$kueri = $this->db->query("SELECT * FROM nilai WHERE nis='$nis' AND ket='2' AND id_kelas='$kelas' AND id_ta='".$this->session->userdata('kd_ta')."' AND semester='".$this->session->userdata('kd_sem')."'");
		$data = $kueri->row();
		$hasil = (isset($data->nilai))?$data->nilai:0;		

		return $hasil;
	}

	private function getTahun($id)
	{
		$kueri = $this->db->query("SELECT * FROM ta WHERE id_ta='$id'");
		$data = $kueri->row();
		$hasil = (isset($data->ta))?"Tahun Pelajaran ".$data->ta:"";
		return $hasil;
	}

	private function getTahunRaport($id)
	{
		$kueri = $this->db->query("SELECT * FROM ta WHERE id_ta='$id'");
		$data = $kueri->row();
		$hasil = (isset($data->ta))?$data->ta:"";
		return $hasil;
	}

	private function getKelasMapel($id)
	{
		$sql = "SELECT * FROM guru a,mapel b,guru_mapel c,guru_mapel_kelas d,kelas e WHERE c.nip=a.nip AND c.id_mapel=b.id_mapel AND d.id_guru_mapel=c.id_guru_mapel AND d.id_kelas=e.id_kelas AND d.id_mapel_kelas='$id'";			
		$kueri = $this->db->query($sql);
		$data = $kueri->row();
		$hasil = array(
			'kelas'			=> $data->tingkat." ".$this->arey->getPenjurusan($data->kode)." ".$data->nama,
			'mapel'			=> $data->mapel,			
			'wali'			=> $this->getWaliKelas($data->id_kelas),
			'guru_mapel'	=> $this->getGuruMapel($data->id_mapel),
			'kepala'		=> $this->getKepala(),
			'tanggal'		=> date("dd-mm-yyyy"),
			'id_kelas'		=> $data->id_kelas,
			'id_guru_mapel'	=> $data->id_guru_mapel,
			'id_mapel'		=> $data->id_mapel
		);
		return $hasil;
	}

	public function getKompetensi($id,$kode)
	{
		$hasil = array();

		$kueri = $this->db->query("SELECT * FROM aspek_nilai WHERE id_mapel='$id' AND jenis_aspek='$kode' ORDER BY tingkat_aspek ASC");
		$data = $kueri->result();
		foreach($data as $key => $detail)
		{
			$hasil[$key] = $detail->aspek;
		}

		return $hasil;
	}

	private function getGuruMapel($id)
	{
		$kueri = $this->db->query("SELECT * FROM guru_mapel a,guru b WHERE a.nip=b.nip AND a.id_mapel='$id'");
		$hasil = $kueri->row();
		$data = array(
			'nama_mapel'		=> (isset($hasil->nama))?$hasil->nama:"",
			'nip_mapel'			=> (isset($hasil->nip))?$hasil->nip:""
		);

		return $data;		
	}

	private function getWaliKelas($id)
	{
		$data = array();

		$kueri = $this->db->query("SELECT * FROM kelas_wali a,guru b WHERE a.nip=b.nip AND a.id_kelas='$id'");
		$hasil = $kueri->row();
		$data = array(
			'nama_wali'		=> (isset($hasil->nama))?$hasil->nama:"",
			'nip_wali'		=> (isset($hasil->nip))?$hasil->nip:""
		);

		return $data;
	}

	private function getKepala()
	{
		$data = array();

		$kueri = $this->db->query("SELECT * FROM kepala");
		$hasil = $kueri->row();

		$data = array(
			'nama_kepala'	=> (isset($hasil->nama_kep))?$hasil->nama_kep:"",
			'nip_kepala'	=> (isset($hasil->nip_kep))?$hasil->nip_kep:""
		);
		return $data;
	}

	public function getStatWali()
	{
		$kueri = $this->db->query("SELECT * FROM kelas_wali WHERE nip='".$this->session->userdata('nip')."'");
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			$hasil = (isset($data->id_kelas))?$data->id_kelas:0;
		}	
		else
		{
			$hasil = 0;
		}	

		return $hasil;

	}

	public function getAllPengetahuan($kelas,$mapel,$id_mapel)
	{
		$hasil = array();
		$detail = array();
		$ket = array();

		$kueri = $this->db->query("SELECT * FROM kelas_siswa a,siswa b WHERE a.nis=b.nis AND a.id_kelas='$kelas' AND a.id_ta='".$this->session->userdata('kd_ta')."'");
		$data = $kueri->result();
		foreach($data as $dt)
		{
			$sempurna = 0;
			for($i=1;$i<=5;$i++)
			{
				$detail[$i] = $this->getNilaiPengetahuan($dt->nis,$kelas,1,$mapel,$i);
				$kete = $this->getKeterangan($detail[$i],$id_mapel,$i,1);
				if($kete != "")
				{
					$ket[$i] = $kete;
				}
				else
				{
					$sempurna = $sempurna + 1;
				}
			}

			$hasil[] = array(
				'nis'			=> $dt->nis,
				'nama'			=> $dt->nama,
				'detail'		=> $detail,
				'keterangan'	=> $ket,
				'sempurna'		=> $sempurna,
				'uts'			=> $this->getTesPengetahuan($dt->nis,$kelas,$mapel,2),
				'uas'			=> $this->getTesPengetahuan($dt->nis,$kelas,$mapel,3)
			);
		}

		return $hasil;				
	}

	private function getKeterangan($nilai,$mapel,$tingkat,$jenis)
	{
		$kJenis = ($jenis == 3)?"70":"77";
		if($nilai < $kJenis)
		{
			$kueri = $this->db->query("SELECT * FROM aspek_nilai WHERE id_mapel='$mapel' AND tingkat_aspek='$tingkat' AND jenis_aspek='$jenis'");
			$data = $kueri->row();
			if(isset($data->aspek))
			{
				$hasil = $data->aspek." kurang";
			}
			else
			{
				$hasil = "";
			}					
		}
		else
		{
			$hasil = "";
		}

		return $hasil;
	}

	private function getNilaiPengetahuan($nis,$kelas,$tingkat,$mapel,$id)
	{
		$id = $id + 1;
		$sql = "SELECT * FROM nilai WHERE nis='$nis' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kelas' AND semester='".$this->session->userdata('kd_sem')."' AND tingkat='$tingkat' AND id_guru_mapel='$mapel' AND ket='$id'";		
		$kueri = $this->db->query($sql);
		$data = $kueri->row();
		if(isset($data->nilai) && $data->nilai >= 76 )
		{
			$hasil = $data->nilai;			
		}	
		else
		{
			if(isset($data->remidi) && $data->remidi > 76)
			{
				$hasil = 76;
			}
			else
			{
				$hasil = (isset($data->nilai))?$data->nilai:0;;
			}			
		}
		$tugas = (isset($data->tugas))?$data->tugas:0;
		$hasil = $hasil + $tugas;
		$hasil = $hasil / 2;
		$hasile = ($hasil == 0)?"":$hasil;
		return $hasile;
	}

	private function getTesPengetahuan($nis,$kelas,$mapel,$kode)
	{
		$sql = "SELECT * FROM nilai WHERE nis='$nis' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kelas' AND semester='".$this->session->userdata('kd_sem')."' AND id_guru_mapel='$mapel' AND tingkat='$kode'";		
		$kueri = $this->db->query($sql);
		$data = $kueri->row();
		$hasil = (isset($data->nilai))?$data->nilai:0;
		return $hasil;
	}

	public function getAllKeterampilan($kelas,$mapel,$id_mapel)
	{
		$hasil = array();		
		$ket = array();

		$kueri = $this->db->query("SELECT * FROM kelas_siswa a,siswa b WHERE a.nis=b.nis AND a.id_kelas='$kelas' AND a.id_ta='".$this->session->userdata('kd_ta')."'");
		$data = $kueri->result();
		foreach($data as $dt)
		{
			unset($detail);
			$detail = array();
			$sempurna = 0;

			for($i=1;$i<=5;$i++)
			{
				$detail[$i] = $this->getNilaiKeterampilan($dt->nis,$kelas,$i,$mapel);
				$kete = $this->getKeterangan($detail[$i]['total'],$id_mapel,$i,2);
				if($kete != "")
				{
					$ket[$i] = $kete;
				}
				else
				{
					$sempurna = $sempurna + 1;
				}
			}

			$hasil[] = array(
				'nis'			=> $dt->nis,
				'nama'			=> $dt->nama,
				'detail'		=> $detail,
				'ket'			=> $ket,
				'sempurna'		=> $sempurna
			);
		}

		return $hasil;
	}

	private function getNilaiKeterampilan($nis,$kelas,$tingkat,$mapel)
	{
		unset($hasil);
		$hasil = array();
		$total = 0;

		$tingkat = $tingkat + 1;
		$sql = "SELECT nilai_1,nilai_2,nilai_3,nilai_4,nilai_5 FROM nilai_trampil WHERE nis='$nis' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kelas' AND semester='".$this->session->userdata('kd_sem')."' AND ket='$tingkat' AND id_guru_mapel='$mapel'";
		$kueri = $this->db->query($sql);		
		$data = $kueri->row();
		
		$nilai_1 = (isset($data->nilai_1))?$data->nilai_1:"";
		$nilai_2 = (isset($data->nilai_2))?$data->nilai_2:"";
		$nilai_3 = (isset($data->nilai_3))?$data->nilai_3:"";
		$nilai_4 = (isset($data->nilai_4))?$data->nilai_4:"";
		$nilai_5 = (isset($data->nilai_5))?$data->nilai_5:"";

		if($kueri->num_rows() > 0)
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

			$total = $val;
		}
		else
		{
			$total = 0;
		}		

		$totale = ($total == 0)?"":$total;

		$hasil = array(
			'nilai_1'		=> $nilai_1,
			'nilai_2'		=> $nilai_2,
			'nilai_3'		=> $nilai_3,
			'nilai_4'		=> $nilai_4,
			'nilai_5'		=> $nilai_5,
			'total'			=> $totale
		);

		return $hasil;		
	}

	public function getAllSikap($kelas,$mapel,$id_mapel)
	{
		$hasil = array();
		$detail = array();
		$ket = array();

		$kueri = $this->db->query("SELECT * FROM kelas_siswa a,siswa b WHERE a.nis=b.nis AND a.id_kelas='$kelas' AND a.id_ta='".$this->session->userdata('kd_ta')."'");
		$data = $kueri->result();
		foreach($data as $dt)
		{
			$sempurna = 0;

			for($i=1;$i<=5;$i++)
			{
				$detail[$i] = $this->getNilaiSikap($dt->nis,$kelas,$i,$mapel);
				$kete = $this->getKeterangan($detail[$i]['value'],$id_mapel,$i,3);
				if($kete != "")
				{
					$ket[$i] = $kete;
				}
				else
				{
					$sempurna = $sempurna + 1;
				}
			}

			$hasil[] = array(
				'nis'			=> $dt->nis,
				'nama'			=> $dt->nama,
				'detail'		=> $detail,
				'ket'			=> $ket,
				'sempurna'		=> $sempurna
			);
		}

		return $hasil;
	}

	private function getNilaiSikap($nis,$kelas,$tingkat,$mapel)
	{
		unset($hasil);
		$hasil = array();
		$total = 0;

		$tingkat = $tingkat + 1;
		$kueri = $this->db->query("SELECT * FROM nilai_sikap WHERE nis='$nis' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kelas' AND semester='".$this->session->userdata('kd_sem')."' AND ket='$tingkat' AND id_guru_mapel='$mapel'");		
		$data = $kueri->row();

		$nilai_buka = (isset($data->nilai_buka))?$data->nilai_buka:"";
		$nilai_tekun = (isset($data->nilai_tekun))?$data->nilai_tekun:"";
		$nilai_rajin = (isset($data->nilai_rajin))?$data->nilai_rajin:"";
		$nilai_rasa = (isset($data->nilai_rasa))?$data->nilai_rasa:"";
		$nilai_disiplin = (isset($data->nilai_disiplin))?$data->nilai_disiplin:"";
		$nilai_kerjasama = (isset($data->nilai_kerjasama))?$data->nilai_kerjasama:"";
		$nilai_ramah = (isset($data->nilai_ramah))?$data->nilai_ramah:"";
		$nilai_hormat = (isset($data->nilai_hormat))?$data->nilai_hormat:"";
		$nilai_jujur = (isset($data->nilai_jujur))?$data->nilai_jujur:"";
		$nilai_janji = (isset($data->nilai_janji))?$data->nilai_janji:"";
		$nilai_peduli = (isset($data->nilai_peduli))?$data->nilai_peduli:"";
		$nilai_jawab = (isset($data->nilai_jawab))?$data->nilai_jawab:"";
		
		$total = $nilai_buka + $nilai_tekun + $nilai_rajin + $nilai_rasa + $nilai_disiplin + $nilai_kerjasama + $nilai_ramah + $nilai_hormat + $nilai_jujur + $nilai_janji + $nilai_peduli + $nilai_jawab;

		$hasil = array(
			'nilai_buka'		=> $nilai_buka,
			'nilai_tekun'		=> $nilai_tekun,
			'nilai_rajin'		=> $nilai_rajin,
			'nilai_rasa'		=> $nilai_rasa,
			'nilai_disiplin'	=> $nilai_disiplin,
			'nilai_kerjasama'	=> $nilai_kerjasama,
			'nilai_ramah'		=> $nilai_ramah,
			'nilai_hormat'		=> $nilai_hormat,
			'nilai_jujur'		=> $nilai_jujur,
			'nilai_janji'		=> $nilai_janji,
			'nilai_peduli'		=> $nilai_peduli,
			'nilai_jawab'		=> $nilai_jawab,
			'total'				=> $this->getKodeSikap($total),
			'value'				=> $total
		);

		return $hasil;
	}

	private function getKodeSikap($jumlah)
	{		
		$jumlah = ($jumlah/60)*100;
		if($jumlah == 0)
		{
			$ket = "";
		}
		elseif($jumlah < 60)
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
}
?>
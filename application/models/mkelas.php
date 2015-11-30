<?php

class Mkelas extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function addKelas()
	{	
		$sql = "INSERT INTO kelas(nama,tingkat,kode,jenis,id) VALUES('".strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))."','".$this->input->post('tingkat',TRUE)."','".$this->input->post('program',TRUE)."','".$this->input->post('jenis',TRUE)."','".$this->input->post('minat',TRUE)."')";		
		$this->db->query($sql);
	}
	
	function delSiswaKelas($id)
	{		
		$kueri = $this->db->query("DELETE FROM kelas_siswa WHERE nis='$id' AND id_ta='".$this->session->userdata('kd_ta')."'");
		$kueri = $this->db->query("DELETE FROM kenaikan WHERE nis='$id' AND id_ta='".$this->session->userdata('kd_ta')."'");
		$kueri = $this->db->query("DELETE FROM nilai WHERE nis='$id' AND id_ta='".$this->session->userdata('kd_ta')."'");	
		return $kueri;
	}

	public function getJenisKelas($id)
	{
		$kueri = $this->db->query("SELECT * FROM kelas WHERE id_kelas='$id'");
		$data = $kueri->row();
		$hasil = (isset($data->jenis))?$data->jenis:0;
		return $hasil;
	}

	public function getMinat()
	{
		$query = $this->db->query("SELECT * FROM mapel WHERE jenis='Peminatan'");		

		if ($query->num_rows()> 0){
			foreach ($query->result_array() as $row)
			{
				$data[$row['id_mapel']] = $row['mapel'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
	}
	
	function updateKelasWali($id)
	{
		$kueri = $this->db->query("UPDATE kelas_wali SET nip='".strip_tags(ascii_to_entities(addslashes($this->input->post('nip',TRUE))))."',id_kelas='".$this->input->post('kelas',TRUE)."' WHERE id_kelas_wali='$id' ");
		return $kueri;
	}
	
	function addKelasWali()
	{	
		$this->db->query("INSERT INTO kelas_wali(id_kelas,nip,id_ta) VALUES('".$this->input->post('kelas',TRUE)."','".strip_tags(ascii_to_entities(addslashes($this->input->post('nip',TRUE))))."','".$this->session->userdata('kd_ta')."')");
	}

	function cekKelas()
	{
		$kueri = $this->db->query(" SELECT * FROM kelas WHERE nama='".strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))."' AND tingkat='".$this->input->post('tingkat',TRUE)."' AND kode='".$this->input->post('program',TRUE)."' ");
		return $kueri->num_rows();
	}

	function cekNewKelas()
	{
		$kueri = $this->db->query(" SELECT * FROM kelas WHERE nama='".strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))."' AND tingkat='".$this->input->post('tingkat',TRUE)."' AND kode='".$this->input->post('program',TRUE)."' AND jenis='".$this->input->post('jenis',TRUE)."'");
		return $kueri->num_rows();
	}
	
	function cekWali()
	{
		$kueri = $this->db->query(" SELECT * FROM kelas WHERE nip='".$this->input->post('wali',TRUE)."' AND id_ta='".$this->session->userdata('kd_ta')."' ");
		return $kueri->num_rows();
	}
	
	function cekWalis()
	{
		$kueri = $this->db->query(" SELECT * FROM kelas_wali WHERE nip='".strip_tags(ascii_to_entities(addslashes($this->input->post('nip',TRUE))))."' AND id_ta='".$this->session->userdata('kd_ta')."' ");
		return $kueri->num_rows();
	}
	
	function cekWalisE($id)
	{
		$kueri = $this->db->query(" SELECT * FROM kelas_wali WHERE nip='".strip_tags(ascii_to_entities(addslashes($this->input->post('nip',TRUE))))."' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas_wali<>'$id' ");
		return $kueri->num_rows();
	}
	
	function getGuru()
	{
		$query = $this->db->query("SELECT * FROM guru");

		if ($query->num_rows()> 0){
			foreach ($query->result_array() as $row)
			{
				$data[$row['nip']] = $row['nama'];
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
		$query = $this->db->query("SELECT a.id_kelas,a.tingkat,a.kode,a.nama,a.jenis,a.id FROM kelas a");

		if ($query->num_rows()> 0)
		{
			$data[0] = "Nama Kelas";
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
	
	function getKelasMutasi($id)
	{
		$query = $this->db->query("SELECT a.id_kelas,a.tingkat,a.kode,a.nama FROM kelas a WHERE a.kode='$id'");

		if ($query->num_rows()> 0)
		{
			foreach ($query->result_array() as $row)
			{
				$data[$row['id_kelas']] = $row['tingkat']." ".$this->arey->getPenjurusan($row['kode'])." ".$row['nama'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
	}
	
	function getKelask()
	{
		$query = $this->db->query("SELECT a.id_kelas,a.tingkat,a.kode,a.nama,a.jenis,a.id FROM kelas a");

		if ($query->num_rows()> 0)
		{
			$data[0] = "Pilih Kelas";
		
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
	
	function getKelasW()
	{
		$query = $this->db->query("SELECT a.id_kelas,a.tingkat,a.kode as kode,a.nama,a.jenis,a.id FROM kelas a");

		if ($query->num_rows()> 0){
			$data[0] = "Pilih Kelas";
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
			$data[''] = "Belum Ada Kelas";
		}
		$query->free_result();
		return $data;
	}
	
	function getKelasSiswa($id)
	{
		$kueri = $this->db->query("SELECT * FROM kelas a,kelas_siswa b,siswa b WHERE a.id_kelas=b.id_kelas AND b.nip=c.nip AND a.id_kelas='$id'");
		return $kueri;
	}
	
	function getAhli()
	{
		$query = $this->db->query("SELECT * FROM keahlian");

		if ($query->num_rows()> 0){
			foreach ($query->result_array() as $row)
			{
				$data[$row['id_keahlian']] = $row['program_keahlian'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
	}
	
	function cekNis()
	{
		$kueri = $this->db->query(" SELECT * FROM siswa WHERE nis='".strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE))))."' ");
		return $kueri->num_rows();
	}
	
	function cekNip()
	{
		$kueri = $this->db->query(" SELECT * FROM guru WHERE nip='".strip_tags(ascii_to_entities(addslashes($this->input->post('nip',TRUE))))."' ");
		return $kueri->num_rows();
	}
	
	function cekKelasSiswa()
	{
		$kueri = $this->db->query(" SELECT * FROM kelas_siswa WHERE nis='".strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE))))."' AND id_ta='".$this->session->userdata('kd_ta')."' ");
		return $kueri->num_rows();
	}

	function cekKelasSiswaMinat()
	{
		$kueri = $this->db->query(" SELECT * FROM kelas_siswa WHERE nis='".strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE))))."' AND id_ta='".$this->session->userdata('kd_ta')."' ");
		return $kueri->num_rows();	
	}
	
	function addKelasSiswa()
	{	
		$this->db->query("INSERT INTO kelas_siswa(id_kelas,nis,id_ta) VALUES('".$this->input->post('kode',TRUE)."','".strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE))))."','".$this->session->userdata('kd_ta')."')");
	}
	
	function getKelass($kelas,$num,$offset,$sort_by,$sort_order)//menu admin
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('c.nis','c.nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'c.nis';
		$sql = "SELECT a.id_kelas_sis,b.nama as kelas,c.nama as jeneng,c.nis,b.tingkat,b.kode FROM kelas_siswa a,kelas b,siswa c WHERE a.nis=c.nis AND a.id_kelas=b.id_kelas AND a.id_kelas='$kelas' AND a.id_ta='".$this->session->userdata('kd_ta')."' GROUP BY c.nis ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getKelasM($kelas)//menu admin
	{
		$sql = "SELECT a.id_kelas_sis,b.nama as kelas,c.nama as jeneng,c.nis,b.tingkat,b.kode as kode FROM kelas_siswa a,kelas b,siswa c WHERE a.nis=c.nis AND a.id_kelas=b.id_kelas AND a.id_kelas='$kelas' AND a.id_ta='".$this->session->userdata('kd_ta')."' GROUP BY c.nis";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getNumKelass($kelas)//menu admin
	{
		$sql = "SELECT a.id_kelas_sis,b.nama as kelas,c.nama as jeneng,c.nis,b.tingkat,b.kode as kode FROM kelas_siswa a,kelas b,siswa c WHERE a.nis=c.nis AND a.id_kelas=b.id_kelas AND a.id_kelas='$kelas' AND a.id_ta='".$this->session->userdata('kd_ta')."'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	function getKelase($num,$offset,$sort_by,$sort_order)//menu admin
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'nama';
		$sql = "SELECT id_kelas,nama,tingkat,kode,jenis,id FROM kelas ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
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
	
	function getKelaseW($num,$offset,$sort_by,$sort_order)//menu admin
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('a.nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'a.nama';
		$sql = "SELECT a.id_kelas,a.nama as nama,c.nama as wali,b.id_kelas_wali,a.tingkat,a.kode as kode,a.jenis,a.id FROM kelas a,kelas_wali b,guru c WHERE b.nip=c.nip AND a.id_kelas=b.id_kelas AND b.id_ta='".$this->session->userdata('kd_ta')."' ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getCountWaliKelas()
	{
		$kueri = $this->db->query("SELECT * FROM kelas_wali WHERE id_ta='".$this->session->userdata('kd_ta')."'");
		return $kueri->num_rows();
	}
	
	function updateMutasiSiswa($kelas,$nis)
	{
		$sql = "UPDATE kelas_siswa SET id_kelas='$kelas' WHERE nis='$nis' AND id_ta='".$this->session->userdata('kd_ta')."'";
		$kueri = $this->db->query($sql);
		return $kueri;
	}
	
	function getWaliKelas($id)
	{
		$kueri = $this->db->query("SELECT * FROM kelas_wali a,guru b WHERE a.nip=b.nip AND a.id_kelas_wali='$id' ");
		return $kueri->row();
	}
	
	function searchKelase($kunci,$num,$offset,$sort_by,$sort_order)
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('a.nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'a.nama';
		$sql = "SELECT a.id_kelas,a.nama as nama FROM kelas a WHERE a.nama LIKE '%$kunci%' ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getKelast($id)
	{
		$sql = "SELECT * FROM kelas WHERE id_kelas='$id'";
		$query = $this->db->query($sql);
		return $query->row();
	}
	
	function getKelasSiswaId($id)
	{
		$sql = "SELECT a.id_kelas,a.id_kelas_sis,b.nis,nama,b.tempat_lahir,b.alamat,b.gambar,b.agama,day(b.tanggal_lahir) as tanggal,month(b.tanggal_lahir) as bulan,year(b.tanggal_lahir) as tahun,b.status,b.asal_sek,b.anak,b.ayah,b.ibu,b.alamat_ortu,b.alamat_wali,b.kerja_ayah,b.kerja_ibu,b.telp_anak,b.telp_ortu,b.telp_wali,b.wali,b.alamat_wali,b.kerja_wali FROM kelas_siswa a,siswa b WHERE a.id_kelas_sis='$id' AND a.nis=b.nis";
		$query = $this->db->query($sql);
		return $query->row();
	}
	
	function updateKelas()
	{
		$sql = "UPDATE kelas SET nama='".strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))."',tingkat='".$this->input->post('tingkat',TRUE)."',kode='".$this->input->post('program',TRUE)."',jenis='".$this->input->post('jenis',TRUE)."',id='".$this->input->post('minat',TRUE)."' WHERE id_kelas='".$this->input->post('kode',TRUE)."' ";
		$this->db->query($sql);	
	}
	
	function updateKelasSiswa()
	{
		$sql = "UPDATE kelas_siswa SET nis='".strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE))))."',id_kelas='".$this->input->post('kelas',TRUE)."' WHERE id_kelas_sis='".$this->input->post('kode',TRUE)."' ";
		$this->db->query($sql);	
	}
	
	function delKelas()
	{
		$this->db->query("DELETE FROM kelas");
	}
	
	function getNip($id)
	{
		$query = "SELECT * FROM guru WHERE nama='$id'";
		$kueri = $this->db->query($query);
		$data = $kueri->row();
		return $data->nip;
	}
	
	function importKelas($value)
	{
		$kueri = $this->db->query("INSERT INTO kelas_siswa(id_kelas,nis,id_ta) VALUES($value)");
		return $kueri;
	}

	function exportKelas($kelas)
	{
		$sql = "SELECT c.nis,c.nama as nama,c.tempat_lahir,c.tanggal_lahir,c.alamat,d.agama,e.ta as tahun_ajaran FROM kelas_siswa a,kelas b,siswa c,agama d,ta e WHERE a.nis=c.nis AND a.id_kelas=b.id_kelas AND a.id_kelas='$kelas' AND a.id_ta='".$this->session->userdata('kd_ta')."' AND c.agama=d.id_agama AND e.id_ta=c.id_ta";
		return $this->db->query($sql);
	}
	
	function del_kelas($id)
	{
		$kueri = $this->db->query("DELETE FROM kelas WHERE id_kelas='$id'");
		return $kueri;
	}
	
	function del_wali($id)
	{
		$kueri = $this->db->query("DELETE FROM kelas_wali WHERE id_kelas_wali='$id' AND id_ta='".$this->session->userdata('kd_ta')."'");
		return $kueri;
	}
	
	function del_kelas_siswa($id)
	{
		$kueri = $this->db->query("DELETE FROM kelas_siswa WHERE id_kelas_sis='$id'");
		return $kueri;
	}
	
	function addRecordSiswa()
	{
		$kueri = $this->db->query("INSERT INTO record_siswa(nis,id_ta) VALUES('".strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE))))."','".$this->session->userdata('kd_ta')."')");
		return $kueri;
	}
	
	function delRecordSiswa($id)
	{
		$kueri = $this->db->query("DELETE FROM record_siswa WHERE nis='".$id."' AND id_ta='".$this->session->userdata('kd_ta')."'");
		return $kueri;
	}
	
	function lookup($keyword)
	{
		$this->db->select('*')->from('guru');
		$this->db->like('nama',$keyword,'after');
		$query = $this->db->get();    
		
		return $query->result();
	}
	
	function lookups($keyword)
	{
		$this->db->select('*')->from('siswa');
		$this->db->like('nama',$keyword,'after');
		$query = $this->db->get();    
		
		return $query->result();
	}

	function cekKelasSiswass($kls,$id)
	{
		$kueri = $this->db->query("SELECT * FROM kelas_siswa WHERE id_kelas='$kls' AND nis='$id' AND id_ta='".$this->session->userdata('kd_ta')."'");
		return $kueri->num_rows();
	}

	function getKelasSiswaIds($kls,$id)
	{
		$sql = "SELECT * FROM kelas_siswa WHERE nis='$id' AND id_ta='".$this->session->userdata('kd_ta')."'";
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->id_kelas_sis;
		}
	}

	function importUpdateKelas($kls,$id,$ids)
	{
		$sql = "UPDATE kelas_siswa SET nis='$id',id_kelas='$ids' WHERE id_kelas_sis='$kls'";
		$kueri = $this->db->query($sql);
	}

	function cekNiss($nis)
	{
		$kueri = $this->db->query("SELECT * FROM siswa WHERE nis='".strip_tags(ascii_to_entities(addslashes($nis)))."' ");
		return $kueri->num_rows();
	}

	function getIdAgama($id)
	{
		$agama = ucfirst(strtolower($id));
		$query = "SELECT * FROM agama WHERE agama='$agama'";
		$kueri = $this->db->query($query);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->id_agama;
		}
		else
		{
			return "1";	
		}
	}

	function getIdTa($id)
	{
		$query = "SELECT * FROM ta WHERE ta='$id'";
		$kueri = $this->db->query($query);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->id_ta;
		}
		else
		{
			return 	$this->session->userdata('kd_ta');
		}
	}

	function getIdJur($id)
	{
		$kueri = $this->db->query("SELECT * FROM kelas a WHERE a.id_kelas='$id'");
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->id_kelas;
		}
	}

	/*function importSiswa($value)
	{
		$kueri = $this->db->query("INSERT INTO siswa VALUES($value)");
		return $kueri;
	}*/

	function importSiswa($value)
	{
		$kueri = $this->db->query("INSERT INTO siswa VALUES($value)");
		return $kueri;
	}

	function importSiswane($dt)
	{
		$this->db->insert('siswa',$dt);
	}

	function getAgama()
	{
		$query = $this->db->query("SELECT * FROM agama");

		if ($query->num_rows()> 0){
			foreach ($query->result_array() as $row)
			{
				$data[$row['id_agama']] = $row['agama'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
	}

	function addSiswa($id)
	{	
		$dt = array(
			'nis' => strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE)))),
			'nama' => strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),
			'tempat_lahir' => strip_tags(ascii_to_entities(addslashes($this->input->post('tempat',TRUE)))),
			'tanggal_lahir' => $this->input->post('tahun',TRUE)."-".$this->input->post('bulan',TRUE)."-".$this->input->post('hari',TRUE),
			'agama' => $this->input->post('agama',TRUE),
			'alamat' => strip_tags(ascii_to_entities(addslashes($this->input->post('alamat',TRUE)))),
			'gambar' => $this->input->post('images',TRUE),
			'id_ta' => $this->session->userdata('kd_ta'),
			'id_keahlian' => $id,
			'status' => $this->input->post('status',TRUE),
  			'anak' => strip_tags(ascii_to_entities(addslashes($this->input->post('anak_ke',TRUE)))),
  			'telp_anak' => strip_tags(ascii_to_entities(addslashes($this->input->post('telp',TRUE)))),
  			'ayah' => strip_tags(ascii_to_entities(addslashes($this->input->post('ayah',TRUE)))),
  			'ibu' => strip_tags(ascii_to_entities(addslashes($this->input->post('ibu',TRUE)))),
  			'alamat_ortu' => strip_tags(ascii_to_entities(addslashes($this->input->post('alamat_o',TRUE)))),
  			'kerja_ayah' => strip_tags(ascii_to_entities(addslashes($this->input->post('p_ayah',TRUE)))),
  			'kerja_ibu' => strip_tags(ascii_to_entities(addslashes($this->input->post('p_ibu',TRUE)))),
  			'telp_ortu' => strip_tags(ascii_to_entities(addslashes($this->input->post('telp_o',TRUE)))),
  			'asal_sek' => strip_tags(ascii_to_entities(addslashes($this->input->post('asal',TRUE)))),
  			'wali' => strip_tags(ascii_to_entities(addslashes($this->input->post('wali',TRUE)))),
  			'kerja_wali' => strip_tags(ascii_to_entities(addslashes($this->input->post('p_wali',TRUE)))),
  			'alamat_wali' => strip_tags(ascii_to_entities(addslashes($this->input->post('alamat_w',TRUE)))),
  			'telp_wali' => strip_tags(ascii_to_entities(addslashes($this->input->post('telp_w',TRUE)))),
		);
		$this->db->insert('siswa',$dt);
	}

	function updateSiswa($keahlian)
	{
		$dt = array(			
			'nama' => strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),
			'tempat_lahir' => strip_tags(ascii_to_entities(addslashes($this->input->post('tempat',TRUE)))),
			'tanggal_lahir' => $this->input->post('tahun',TRUE)."-".$this->input->post('bulan',TRUE)."-".$this->input->post('hari',TRUE),
			'agama' => $this->input->post('agama',TRUE),
			'alamat' => strip_tags(ascii_to_entities(addslashes($this->input->post('alamat',TRUE)))),
			'gambar' => $this->input->post('images',TRUE),
			'id_ta' => $this->session->userdata('kd_ta'),
			'id_keahlian' => $this->input->post('ahli',TRUE),
			'status' => $this->input->post('status',TRUE),
  			'anak' => strip_tags(ascii_to_entities(addslashes($this->input->post('anak_ke',TRUE)))),
  			'telp_anak' => strip_tags(ascii_to_entities(addslashes($this->input->post('telp',TRUE)))),
  			'ayah' => strip_tags(ascii_to_entities(addslashes($this->input->post('ayah',TRUE)))),
  			'ibu' => strip_tags(ascii_to_entities(addslashes($this->input->post('ibu',TRUE)))),
  			'alamat_ortu' => strip_tags(ascii_to_entities(addslashes($this->input->post('alamat_o',TRUE)))),
  			'kerja_ayah' => strip_tags(ascii_to_entities(addslashes($this->input->post('p_ayah',TRUE)))),
  			'kerja_ibu' => strip_tags(ascii_to_entities(addslashes($this->input->post('p_ibu',TRUE)))),
  			'telp_ortu' => strip_tags(ascii_to_entities(addslashes($this->input->post('telp_o',TRUE)))),
  			'asal_sek' => strip_tags(ascii_to_entities(addslashes($this->input->post('asal',TRUE)))),
  			'wali' => strip_tags(ascii_to_entities(addslashes($this->input->post('wali',TRUE)))),
  			'kerja_wali' => strip_tags(ascii_to_entities(addslashes($this->input->post('p_wali',TRUE)))),
  			'alamat_wali' => strip_tags(ascii_to_entities(addslashes($this->input->post('alamat_w',TRUE)))),
  			'telp_wali' => strip_tags(ascii_to_entities(addslashes($this->input->post('telp_w',TRUE)))),
		);
		$this->db->where('nis', strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE)))));
		$this->db->update('siswa', $dt); 
	}

	function getIdKeahlian()
	{
		$kueri = $this->db->query("SELECT * FROM kelas_siswa a,kelas b WHERE a.id_kelas=b.id_kelas");
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->id_keahlian;
		}
		else
		{
			return "1";
		}
	}

	function importUpdateSiswa($nis,$nama,$tempat,$tgl,$alamat,$agama,$ta,$jur)
	{
		$kueri = $this->db->query("UPDATE siswa SET nama='$nama',tempat_lahir='$tempat',tanggal_lahir='$tgl',alamat='$alamat',agama='$agama',id_ta='$ta',id_keahlian='$jur' WHERE nis='$nis'");
	}
	
	function getProperties($id)
	{
		$sql = "SELECT * FROM kelas WHERE id_kelas='$id'";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			$data = $query->row();
			return $data;
		}
	}
}
?>

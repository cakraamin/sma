<?php

class Mrumus extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}
	
	function getRumus($sort_by,$sort_order)
	{
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('mapel');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'mapel';
		$sql = "SELECT * FROM mapel ORDER BY $sort_by $sort_order";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function addRumus($rumus1,$rumus2,$rumus3,$kode)
	{
		$kueri = $this->db->query("INSERT INTO rumus_nilai(id_mapel,rumus1,rumus2,rumus3,id_ta) VALUES('$kode','$rumus1','$rumus2','$rumus3','".$this->session->userdata('kd_ta')."')");	
		return $kueri;
	}
	
	function updateRumus($rumus1,$rumus2,$rumus3,$kode)
	{
		$kueri = $this->db->query("UPDATE rumus_nilai SET rumus1='$rumus1',rumus2='$rumus2',rumus3='$rumus3' WHERE id_rumus='$kode'");
		return $kueri;
	}
	
	function getRumuss($id)
	{
		$kueri = $this->db->query("SELECT * FROM rumus_nilai WHERE id_mapel='$id' AND id_ta='".$this->session->userdata('kd_ta')."'");
		if($kueri->num_rows() > 0)
		{
			return $kueri->row();
		}	
	}

	function getMapells()
	{
		$query = $this->db->query("SELECT * FROM guru_mapel a,mapel b WHERE a.id_mapel=b.id_mapel GROUP BY id_team");

		if ($query->num_rows()> 0)
		{
			$data[0] = "Pilih Nama Kelas";
			foreach ($query->result_array() as $row)
			{
				if($this->getNumAllGuru($row['id_team']) > 0)
				{
					$data[$row['id_guru_mapel']] = $row['mapel']." [".$this->getAllGuru($row['id_team'])."]";
				}
			}
		}
		else
		{
			$data[''] = "";
		}
		return $data;
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
	
	function getNumAllGuru($id)
	{
		$kueri = $this->db->query("SELECT * FROM guru_mapel a,guru b WHERE a.nip=b.nip AND a.id_team='$id'");
		return $kueri->num_rows();
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

	function getMapel($id)
	{
		$kueri = $this->db->query("SELECT * FROM guru_mapel WHERE id_guru_mapel='$id'");
		$data = $kueri->row();
		return $data->id_mapel;
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
	
	function getExportSiswaKelas($id)
	{
		$sql = "SELECT b.nis,b.nama FROM kelas_siswa a,siswa b WHERE a.nis=b.nis AND a.id_kelas='$id' AND a.id_ta='".$this->session->userdata('kd_ta')."' ORDER BY b.nis ASC";	
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getKelas($id)
	{
		$query = $this->db->query("SELECT c.id_kelas,c.tingkat,c.kode,c.nama FROM guru_mapel_kelas a,guru_mapel b,kelas c WHERE a.id_guru_mapel=b.id_guru_mapel AND a.id_kelas=c.id_kelas AND b.id_guru_mapel='$id'");

		if ($query->num_rows()> 0)
		{
			$data[''] = 'Nama Kelas';
			foreach ($query->result_array() as $row)
			{
				
				$data[$row['id_kelas']] = $row['tingkat']." ".$this->arey->getPenjurusan($row['kode'])." ".$row['nama'];
			}
		}
		else
		{
			$data[''] = "";
		}
		return $data;
	}

	function getStat($id)
	{
		$kueri = $this->db->query("SELECT * FROM set_nilai WHERE id_guru_mapel='$id'");
		if($kueri->num_rows() > 0)
		{
			$datas = $kueri->row();		
			$query = $this->db->query("SELECT * FROM administrasi WHERE id_guru_mapel='$id' AND tingkat='".$datas->set_nilai."'");

			if ($query->num_rows()> 0)
			{
				foreach ($query->result_array() as $row)
				{
					$data[$row['id_administrasi']] = $row['administrasi'];
				}
			}
			else
			{
				$data[''] = "";
			}
			return $data;
		}
	}

	function getIdNilai($id,$kode,$kls,$sem,$tingkat,$ket=NULL)
	{
		$sql = "SELECT * FROM nilai WHERE nis='$id' AND id_guru_mapel='$kode' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kls' AND semester='$sem' AND tingkat='$tingkat' AND ket='$ket'";
		
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

	function getNilai($id,$kode,$kls,$sem,$tingkat,$ket=NULL)
	{
		$sql = "SELECT * FROM nilai WHERE nis='$id' AND id_guru_mapel='$kode' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kls' AND semester='$sem' AND tingkat='$tingkat' AND ket='$ket'";	
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->nilai;					
		}
		else
		{
			return "kosong";		
		}
	}

	function addNilai($nip,$id,$kelas,$biji,$remidi,$tugas,$tingkat,$ket)
	{
		$kueri = $this->db->query("INSERT INTO nilai(id_guru_mapel,id_kelas,nis,nilai,remidi,tugas,id_ta,semester,tingkat,ket,jenis) VALUES('$id','$kelas','$nip','$biji','$remidi','$tugas','".$this->session->userdata('kd_ta')."','".$this->session->userdata('kd_sem')."','$tingkat','$ket','1')");	
		return $kueri;
	}
	
	function updateNilais($nip,$id,$kelas,$biji,$remidi,$tugas,$tingkat,$ket,$kodene)
	{
		$kueri = $this->db->query("UPDATE nilai SET nilai='$biji',remidi='$remidi',tugas='$tugas' WHERE id_guru_mapel='$id' AND id_kelas='$kelas' AND nis='$nip' AND id_ta='".$this->session->userdata('kd_ta')."' AND semester='".$this->session->userdata('kd_sem')."' AND tingkat='$tingkat' AND ket='$ket' WHERE id_nilai='$kodene'");	
		return $kueri;
	}
	
	function cekNilais($nip,$id,$kelas,$tingkat,$ket,$jenis)
	{
		if($jenis == 1)
		{
			$sql = "SELECT id_nilai as kode FROM nilai WHERE id_guru_mapel='$id' AND id_kelas='$kelas' AND nis='$nip' AND id_ta='".$this->session->userdata('kd_ta')."' AND semester='".$this->session->userdata('kd_sem')."' AND tingkat='$tingkat' AND ket='$ket' AND jenis='1'";
		}
		elseif($jenis == 2)
		{
			$sql = "SELECT id_nilai_trampil as kode FROM nilai_trampil WHERE id_guru_mapel='$id' AND id_kelas='$kelas' AND nis='$nip' AND id_ta='".$this->session->userdata('kd_ta')."' AND semester='".$this->session->userdata('kd_sem')."' AND ket='$ket'";
		}
		else
		{
			$sql = "SELECT id_nilai_sikap as kode FROM nilai_sikap WHERE id_guru_mapel='$id' AND id_kelas='$kelas' AND nis='$nip' AND id_ta='".$this->session->userdata('kd_ta')."' AND semester='".$this->session->userdata('kd_sem')."' AND ket='$ket'";
		}		
		$kueri = $this->db->query($sql);	
		$data = $kueri->row();
		$hasil = (isset($data->kode))?$data->kode:0;
		return $hasil;
	}

	function cekNilai($nip,$id,$kelas,$tingkat,$ket)
	{
		$kueri = $this->db->query("SELECT * FROM nilai WHERE id_guru_mapel='$id' AND id_kelas='$kelas' AND nis='$nip' AND id_ta='".$this->session->userdata('kd_ta')."' AND semester='".$this->session->userdata('kd_sem')."' AND tingkat='$tingkat' AND ket='$ket'");	
		return $kueri;
	}
	
	function updateNilai($id,$biji)
	{
		$kueri = $this->db->query("UPDATE nilai SET nilai='$biji' WHERE id_nilai='$id'");
		return $kueri;
	}

	public function addKeterampilan($data)
	{
		$this->db->insert('nilai_trampil', $data); 
	}

	public function updateKeterampilan($data,$id)
	{
		$this->db->where('id_nilai_trampil', $id);
		$this->db->update('nilai_trampil', $data); 
	}

	public function addSikap($data)
	{
		$this->db->insert('nilai_sikap', $data); 
	}

	public function updateSikap($data,$id)
	{
		$this->db->where('id_nilai_sikap', $id);
		$this->db->update('nilai_sikap', $data); 
	}
}
?>

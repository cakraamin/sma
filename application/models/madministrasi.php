<?php

class Madministrasi extends CI_Model{
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
			$data[''] = "";
		}
		return $data;
	}
	
	function getTeamTeaching()
	{
		$query = $this->db->query("SELECT * FROM guru_mapel a,mapel b WHERE a.id_mapel=b.id_mapel AND a.nip='".$this->session->userdata('nip')."' GROUP BY id_team");
		return $query->result();
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
	
	function addAdministrasi($id,$judul,$mapel,$tingkat)
	{
		$kueri = $this->db->query("INSERT INTO administrasi(id_guru_mapel,id_mapel,administrasi,id_ta,tingkat) VALUES('".$id."','$mapel','".strip_tags(ascii_to_entities(addslashes($judul)))."','".$this->session->userdata('kd_ta')."','$tingkat')");
		return $kueri;
	}
	
	function updateAdministrasi($id)
	{
		$kueri = $this->db->query("UPDATE administrasi SET administrasi='".strip_tags(ascii_to_entities(addslashes($this->input->post('judul',TRUE))))."' WHERE id_administrasi='$id'");
		return $kueri;
	}
	
	function getIdMapel($id,$kode)
	{
		$kueri = $this->db->query("SELECT * FROM guru_mapel WHERE id_guru_mapel='$id' AND nip='".$this->session->userdata('nip')."'");
		$data = $kueri->row();
		return $data->id_mapel;
	}
	
	function getKd($id)
	{
		$query = $this->db->query("SELECT * FROM administrasi a,guru_mapel b WHERE a.id_guru_mapel=b.id_guru_mapel AND a.id_guru_mapel='$id' AND b.nip='".$this->session->userdata('nip')."' AND a.tingkat=1");

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
	
	function getSk($id)
	{
		$query = $this->db->query("SELECT * FROM administrasi a,guru_mapel b WHERE a.id_guru_mapel=b.id_guru_mapel AND a.id_guru_mapel='$id' AND b.nip='".$this->session->userdata('nip')."' AND a.tingkat=0");

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
	
	function getAdministrasi($id,$sort_by,$sort_order)
	{
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('administrasi');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'administrasi';
		$sql = "SELECT * FROM administrasi WHERE tingkat=0 AND id_guru_mapel='$id' ORDER BY $sort_by $sort_order";
		$query = $this->db->query($sql);
		return $query;
	}
	
	function numAdministrasi($id)
	{
		$sql = "SELECT * FROM administrasi WHERE tingkat=1 AND id_guru_mapel='$id'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	function getKompetensi($id)
	{
		$kueri = $this->db->query("SELECT * FROM administrasi WHERE tingkat=1 AND id_mapel='$id'");
		return $kueri->result();
	}	
	
	function getIndikator($id)
	{
		$kueri = $this->db->query("SELECT * FROM administrasi WHERE tingkat=2 AND id_mapel='$id'");
		return $kueri->result();
	}
	
	function getIdAdministrasi($id)
	{
		$kueri = $this->db->query("SELECT * FROM administrasi WHERE id_administrasi='$id'");
		return $kueri->row();
	}
	
	function delKd($id)
	{
		$kueri = $this->db->query("DELETE FROM administrasi WHERE id_administrasi='$id'");
		return $kueri;
	}
	
	function delIndikator($id)
	{
		$kueri = $this->db->query("DELETE FROM administrasi WHERE id_mapel='$id'");
		return $kueri;
	}
}
?>

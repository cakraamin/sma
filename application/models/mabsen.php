<?php

class Mabsen extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function getAbsen($num,$offset,$sort_by,$sort_order)//menu admin
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('a.nis','b.nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'a.nis';
		$sql = "SELECT * FROM absen a,siswa b,ket c WHERE a.nis=b.nis AND a.ket=c.id_ket AND DATE(a.tgl)=DATE(NOW()) ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query;
	}
	
	function getKet()
	{
		$kueri = $this->db->query("SELECT * FROM ket");
		return $kueri->result();
	}
	
	function getControl()
	{
		$kueri = $this->db->query("SELECT * FROM waktu");
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->waktu;
		}
		else
		{
			return $kueri->num_rows();
		}
	}
	
	function cekAbsen()
	{
		$kueri = $this->db->query("SELECT * FROM absen WHERE nis='".strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE))))."' AND DATE(tgl)=DATE(NOW())");
		return $kueri->num_rows();
	}
	
	function addAbsen()
	{
		$kueri = $this->db->query("INSERT INTO absen(nis,tgl,ket,id_ta) VALUES('".strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE))))."',NOW(),'M','".$this->session->userdata('kd_ta')."')");
		return $kueri;
	}
	
	function cekNis()
	{
		$kueri = $this->db->query("SELECT * FROM siswa a,kelas_siswa b WHERE a.nis=b.nis AND a.nis='".strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE))))."'");
		return $kueri->num_rows();
	}
	
	function getSiswa($id)
	{
		$kueri = $this->db->query("SELECT a.nis,a.nama,a.tempat_lahir,a.alamat,b.ta,a.gambar,DATE(a.tanggal_lahir) as tanggal,c.agama FROM siswa a,ta b,agama c WHERE a.id_ta=b.id_ta AND a.agama=c.id_agama AND nis='$id'");
		return $kueri->row();
	}
	
	function addAbsensi()
	{
		$kueri = $this->db->query("INSERT INTO absen(nis,tgl,ket,id_ta,absen) VALUES('".strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE))))."',NOW(),'".$this->input->post('ket',TRUE)."','".$this->session->userdata('kd_ta')."','".$this->session->userdata('kd_sem')."')");
		return $kueri;
	}
	
	function getDetilAbsen($id)
	{
		$kueri = $this->db->query("SELECT * FROM absen WHERE id_absen='$id'");
		return $kueri->row();
	}
	
	function editAbsensi()
	{
		$kueri = $this->db->query("UPDATE absen SET nis='".strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE))))."',ket='".$this->input->post('ket',TRUE)."' WHERE id_absen='".$this->input->post('kode',TRUE)."'");
		return $kueri;
	}
	
	function getCari($id)
	{
		$kueri = $this->db->query("SELECT * FROM absen a,siswa b WHERE a.nis=b.nis AND DATE(a.tgl)=DATE(NOW()) AND b.nama LIKE '%".$id."%'");
		return $kueri->num_rows();
	}
	
	function getAbsenCari($kunci,$num,$offset,$sort_by,$sort_order)//menu admin
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('a.nis','b.nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'a.nis';
		$sql = "SELECT * FROM absen a,siswa b,ket c WHERE a.nis=b.nis AND a.ket=c.id_ket AND DATE(a.tgl)=DATE(NOW()) AND b.nama LIKE '%".$kunci."%' ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query;
	}
	
	function getJam()
	{
		$kueri = $this->db->query("SELECT * FROM waktu");
		$data_waktu = $kueri->row();
		return $data_waktu->waktu;
	}
	
	function delAbsen($id)
	{
		$kueri = $this->db->query("DELETE FROM absen WHERE id_absen='$id'");
		return $kueri;
	}
}
?>

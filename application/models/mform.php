<?php

class Mform extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
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
		$kueri = $this->db->query("INSERT INTO absen(nis,tgl,ket) VALUES('".strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE))))."',NOW(),'M')");
		return $kueri;
	}
	
	function cekNis()
	{
		$kueri = $this->db->query("SELECT * FROM siswa WHERE nis='".strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE))))."'");
		return $kueri->num_rows();
	}
	
	function getSiswa($id)
	{
		$kueri = $this->db->query("SELECT * FROM siswa WHERE nis='$id'");
		return $kueri->row();
	}
}
?>
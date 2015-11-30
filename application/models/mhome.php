<?php

class Mhome extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
	}

	function getTA()
	{
		$kueri = $this->db->query("SELECT * FROM ta WHERE status='1' ORDER BY id_ta DESC");
		return $kueri;
	}
		
	function getSemester()
	{
		$kueri = $this->db->query("SELECT * FROM semester WHERE status='1'");
		$data = $kueri->row();
		return $data->id_semester;
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
}
?>
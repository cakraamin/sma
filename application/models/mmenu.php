<?php

class Mmenu extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
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
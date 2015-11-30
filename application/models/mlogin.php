<?php

class Mlogin extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}

	function verifyPengguna($u,$pw)
	{
		$sql = " SELECT * FROM users WHERE userid = '".$u."' AND passid ='".md5($pw)."' ";
		$query = $this->db->query($sql);
		return $query;
	}
	
	function getIdGuru($id,$kode)
	{
		$sql = " SELECT * FROM kelas_wali WHERE nip='$id' AND id_ta='$kode' ";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	function getTaId($id)
	{
		$kueri = $this->db->query("SELECT * FROM ta WHERE id_ta='$id'");
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->ta;
		}
	}

	function getKdTa()
	{
		$kueri = $this->db->query("SELECT * FROM ta WHERE status='1'");
		if($kueri->num_rows() > 0)
		{
			return $kueri->row();
		}
		else
		{
			return 0;
		}
	}
}
?>
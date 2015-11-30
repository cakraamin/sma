<?php

class Muser extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}

	function getMember($num,$offset,$sort_by,$sort_order)//menu admin
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('nameid');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'nameid';
		$sql = "SELECT * FROM users ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getMembers($num,$offset,$sort_by,$sort_order)//menu admin
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('nameid');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'nameid';
		$sql = "SELECT * FROM users ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		/*echo $sql;
		exit();*/
		$query = $this->db->query($sql);
		return $query;
	}
	
	function getPerson($id)
	{
		$query = $this->db->query(" SELECT * FROM users WHERE user_id='$id' ");
		return $query;
	}
	
	function delMember($id)
	{
		$query = $this->db->query("DELETE FROM users WHERE user_id='$id'");
	}
	
	function addMember()
	{
		$nama = strip_tags(ascii_to_entities(addslashes($this->input->post('name',TRUE))));
		$alamat = strip_tags(ascii_to_entities(addslashes($this->input->post('alamat',TRUE))));
		$user = strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))));
		$nip = strip_tags(ascii_to_entities(addslashes($this->input->post('nip',TRUE))));
		//$nip = "";
		$pass = md5(strip_tags(ascii_to_entities(addslashes($this->input->post('pass',TRUE)))));
		$pengguna = $this->input->post('pengguna',TRUE);
		
		$this->db->query("INSERT INTO users(userid,passid,nameid,alamatid,tingkatid,nip) VALUES ('$user','$pass','$nama','$alamat','$pengguna','$nip')");
	}
	
	function updateMember()
	{
		$user = strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))));
		$pass = md5(strip_tags(ascii_to_entities(addslashes($this->input->post('pass',TRUE)))));
		$passl = md5(strip_tags(ascii_to_entities(addslashes($this->input->post('passl',TRUE)))));
		
		$this->db->query("UPDATE users SET userid='$user',passid='$pass' WHERE user_id=".$this->session->userdata('id')." ");
	}
	
	function cekUser()
	{
		$user = strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))));
		
		$kueri = $this->db->query("SELECT * FROM users WHERE userid='$user'");
		return $kueri->num_rows();
	}
	
	function cekUserEdit()
	{
		$user = strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))));
		
		$kueri = $this->db->query("SELECT * FROM users WHERE userid='$user' AND user_id <> ".$this->session->userdata('id')."");
		return $kueri->num_rows();
	}
	
	function cekUserPass()
	{
		$user = strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))));
		$passl = md5(strip_tags(ascii_to_entities(addslashes($this->input->post('passl',TRUE)))));
		
		$kueri = $this->db->query("SELECT * FROM users WHERE userid='$user' AND passid='$passl' AND user_id <> ".$this->session->userdata('id')."");
		return $kueri->num_rows();
	}
	
	function cekNip()
	{
		$kueri = $this->db->query(" SELECT * FROM guru WHERE nip='".strip_tags(ascii_to_entities(addslashes($this->input->post('nip',TRUE))))."' ");
		return $kueri->num_rows();
	}
}
?>

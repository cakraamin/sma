<?php

class Mjurusan extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function getKeahlian($num,$offset,$sort_by,$sort_order)
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('bidang_keahlian','program_keahlian');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'bidang_keahlian';
		$sql = "SELECT * FROM keahlian ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}	
	
	function cekAhli($bidang,$program)
	{
		$kueri = $this->db->query(" SELECT * FROM keahlian WHERE bidang_keahlian='".strip_tags(ascii_to_entities(addslashes($bidang)))."' OR program_keahlian='".strip_tags(ascii_to_entities(addslashes($program)))."' ");
		return $kueri->num_rows();
	}
	
	function addAhli()
	{	
		$dt = array(
			'bidang_keahlian'=>strip_tags(ascii_to_entities(addslashes($this->input->post('bidang',TRUE)))),
			'program_keahlian'=>strip_tags(ascii_to_entities(addslashes($this->input->post('program',TRUE)))),
			'kode_keahlian'=>strip_tags(ascii_to_entities(addslashes($this->input->post('kodea',TRUE))))
		);
		$this->db->insert('keahlian',$dt);
	}
	
	function updateAhli()
	{
		$sql = "UPDATE keahlian SET bidang_keahlian='".strip_tags(ascii_to_entities(addslashes($this->input->post('bidang',TRUE))))."',program_keahlian='".strip_tags(ascii_to_entities(addslashes($this->input->post('program',TRUE))))."',kode_keahlian='".strip_tags(ascii_to_entities(addslashes($this->input->post('kodea',TRUE))))."' WHERE id_keahlian='".$this->input->post('kode',TRUE)."' ";
		$this->db->query($sql);	
	}
	
	function delAhli($id)
	{
		$sql = "DELETE FROM keahlian WHERE id_keahlian='$id'";
		$this->db->query($sql);
	}
	
	function getKeahlianId($id)
	{
		$sql = "SELECT * FROM keahlian WHERE id_keahlian='$id'";
		$query = $this->db->query($sql);
		return $query->row();
	}
}
?>

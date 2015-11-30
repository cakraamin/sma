<?php

class Mdiri extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}
	
	function addDiri()
	{	
		$kueri = $this->db->query("INSERT INTO diri(pengembangan_diri) VALUES('".strip_tags(ascii_to_entities(addslashes($this->input->post('diri',TRUE))))."')");
		return $kueri;
	}

	function cekNis($nis)
	{
		$kueri = $this->db->query(" SELECT * FROM siswa WHERE nis='".strip_tags(ascii_to_entities(addslashes($nis)))."' ");
		return $kueri->num_rows();
	}
	
	function getDiri($num,$offset,$sort_by,$sort_order)
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('pengembangan_diri');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'pengembangan_diri';
		$sql = "SELECT * FROM diri ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getSearchDiri($kunci,$num,$offset,$sort_by,$sort_order)
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('pengembangan_diri');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'pengembangan_diri';
		$sql = "SELECT * FROM diri WHERE pengembangan_diri LIKE '%".$kunci."%' ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getDiriId($id)
	{
		$sql = "SELECT * FROM diri WHERE id_diri='$id'";
		$query = $this->db->query($sql);
		return $query->row();
	}
	
	function updateDiri()
	{
		$sql = "UPDATE diri SET pengembangan_diri='".strip_tags(ascii_to_entities(addslashes($this->input->post('diri',TRUE))))."' WHERE id_diri='".$this->input->post('kode',TRUE)."' ";
		$this->db->query($sql);	
	}
	
	function delDiri($id)
	{
		$sql = "DELETE FROM diri WHERE id_diri='$id'";
		$this->db->query($sql);
	}
	
	function getIdTa($id)
	{
		$query = "SELECT * FROM ta WHERE ta='$id'";
		$kueri = $this->db->query($query);
		$data = $kueri->row();
		return $data->id_ta;
	}
}
?>

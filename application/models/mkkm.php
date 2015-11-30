<?php

class Mkkm extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}
	
	function getKkm($sort_by,$sort_order)
	{
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('mapel');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'mapel';
		$sql = "SELECT * FROM mapel ORDER BY $sort_by $sort_order";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function addKkm($kkm1,$kkm2,$kkm3,$kode)
	{
		$kueri = $this->db->query("INSERT INTO kkm(id_mapel,kkm1,kkm2,kkm3,id_ta) VALUES('$kode','$kkm1','$kkm2','$kkm3','".$this->session->userdata('kd_ta')."')");	
		return $kueri;
	}
	
	function updateKkm($kkm1,$kkm2,$kkm3,$kode)
	{
		$kueri = $this->db->query("UPDATE kkm SET kkm1='$kkm1',kkm2='$kkm2',kkm3='$kkm3' WHERE id_kkm='$kode'");
		return $kueri;
	}
	
	function getKkmIsi($id)
	{
		$kueri = $this->db->query("SELECT id_kkm,kkm1,kkm2,kkm3 FROM kkm WHERE id_mapel='$id' AND id_ta='".$this->session->userdata('kd_ta')."'");
		if($kueri->num_rows() > 0)
		{
			return $kueri->row();
		}	
	}
}
?>

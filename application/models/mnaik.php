<?php

class Mnaik extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}
	
	function getSiswaKelas($sort_by,$sort_order)
	{
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('a.nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'a.nama';
		$sql = "SELECT * FROM siswa a,kelas_siswa b,kelas_wali c WHERE c.id_kelas=b.id_kelas AND a.nis=b.nis AND c.nip='".$this->session->userdata('nip')."' AND b.id_ta='".$this->session->userdata('kd_ta')."' ORDER BY $sort_by $sort_order";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function updateAngkatan($tingkat,$kode)
	{
		$sql = "SELECT a.nis FROM siswa a,kelas_siswa b,kelas_wali c WHERE c.id_kelas=b.id_kelas AND a.nis=b.nis AND c.nip='".$this->session->userdata('nip')."' AND b.id_ta='".$this->session->userdata('kd_ta')."' ";
		$query = $this->db->query($sql);
		$hasil = $query->result();
		foreach($hasil as $data)
		{
			$cek_insert = "SELECT * FROM kelas_siswa WHERE id_kelas='$tingkat' AND nis='".$data->nis."' AND id_ta='$kode'";
			$cek = $this->db->query($cek_insert);
			if($cek->num_rows() == 0)
			{
				$sql_insert = "INSERT INTO kelas_siswa(id_kelas,nis,id_ta) VALUES('$tingkat','".$data->nis."','$kode')";
				$query_insert = $this->db->query($sql_insert);
			}
		}
	}
	
	function addNaik($kls,$id,$stat)
	{
		$kueri = $this->db->query("INSERT INTO kenaikan(id_kelas_siswa,nis,status,id_ta) VALUES('$kls','$id','$stat','".$this->session->userdata('kd_ta')."')");	
		return $kueri;
	}
	
	function updateKelasBaru($nis,$kelas,$ta)
	{
		$sql = "UPDATE kelas_siswa SET id_kelas='$kelas' WHERE nis='$nis' AND id_ta='$ta'";
		//echo $sql;
		$kueri = $this->db->query($sql);
		return $kueri;
	}
	
	function cekNaik($kls,$id)
	{
		$kueri = $this->db->query("SELECT * FROM kenaikan WHERE id_kelas_siswa='$kls' AND nis='$id' AND id_ta='".$this->session->userdata('kd_ta')."'");	
		return $kueri->num_rows();	
	}
	
	function addCatat($kls,$id,$catat)
	{
		$kueri = $this->db->query("INSERT INTO catatan(id_kelas,catatan,nis,id_ta,semester) VALUES('$kls','".strip_tags(ascii_to_entities(addslashes($catat)))."','$id','".$this->session->userdata('kd_ta')."','".$this->session->userdata('kd_sem')."')");	
		return $kueri;	
	}
	
	function updateCatat($id,$catat)
	{
		$kueri = $this->db->query("UPDATE catatan SET catatan='".strip_tags(ascii_to_entities(addslashes($catat)))."' WHERE id_catatan='$id'");	
		return $kueri;	
	}
	
	function cekCatatan($kls,$id)
	{
		$kueri = $this->db->query("SELECT * FROM catatan WHERE id_kelas='$kls' AND nis='$id' AND id_ta='".$this->session->userdata('kd_ta')."'");	
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->id_catatan;
		}
		else
		{
			return "";
		}			
	}	
	
	function getCatatanId($id)
	{
		$kueri = $this->db->query("SELECT * FROM catatan WHERE id_catatan='$id'");
		return $kueri->row();
	}
	
	function delCatat($id)
	{
		$kueri = $this->db->query("DELETE FROM catatan WHERE id_catatan='$id'");
	}
	
	function cekStatNaik($kls,$id)
	{
		$kueri = $this->db->query("SELECT * FROM kenaikan WHERE id_kelas_siswa='$kls' AND nis='$id' AND id_ta='".$this->session->userdata('kd_ta')."'");	
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->status;
		}	
	}
	
	function updateNaik($kls,$id,$stat)
	{
		$sql = "UPDATE kenaikan SET status='$stat' WHERE id_kelas_siswa='$kls' AND nis='$id' AND id_ta='".$this->session->userdata('kd_ta')."'";
		echo $sql;
		$kueri = $this->db->query($sql);
		return $kueri;
	}
	
	function getRumuss($id)
	{
		$kueri = $this->db->query("SELECT * FROM rumus_nilai WHERE id_mapel='$id' AND id_ta='".$this->session->userdata('kd_ta')."'");
		if($kueri->num_rows() > 0)
		{
			return $kueri->row();
		}	
	}
	
	function getIdKelas()
	{
		$sql = "SELECT * FROM kelas_wali a,kelas_siswa b WHERE a.id_kelas=b.id_kelas AND a.nip='".$this->session->userdata('nip')."' AND a.id_ta='".$this->session->userdata('kd_ta')."'";
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->id_kelas;
		}
	}
	
	function getNextIdKelas($tingkat,$jur,$nama)
	{
		$sql = "SELECT * FROM kelas WHERE nama='$nama' AND tingkat='$tingkat' AND id_keahlian='$jur'";
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->id_kelas;
		}
	}
	
	function getTingkatKelas()
	{
		$sql = "SELECT * FROM kelas_wali a,kelas_siswa b,kelas c WHERE a.id_kelas=b.id_kelas AND a.nip='".$this->session->userdata('nip')."' AND a.id_ta='".$this->session->userdata('kd_ta')."' AND b.id_kelas=c.id_kelas";
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data;
		}
	}
	
	function getCatat($nis,$kls,$sem)
	{
		$sql = "SELECT * FROM catatan WHERE nis='$nis' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kls' AND semester='$sem'";	
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->catatan;					
		}
		else
		{
			return "kosong";		
		}
	}
	
	function getIdCatat($nis,$kls,$sem)
	{
		$sql = "SELECT * FROM catatan WHERE nis='$nis' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kls' AND semester='$sem'";
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->id_catatan;					
		}
		else
		{
			return "";		
		}
	}
}
?>

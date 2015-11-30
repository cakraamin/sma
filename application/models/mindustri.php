<?php

class Mindustri extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}
	
	function getSiswaKelas($id,$sort_by,$sort_order)
	{
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('b.nis','b.nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'b.nama';
		$sql = "SELECT * FROM kelas_siswa a,siswa b WHERE a.nis=b.nis AND a.id_kelas='$id' AND a.id_ta='".$this->session->userdata('kd_ta')."' ORDER BY $sort_by $sort_order";	
		$query = $this->db->query($sql);
		return $query;
	}
	
	function getKelas()
	{
		$query = $this->db->query("SELECT a.id_kelas,a.tingkat,b.kode_keahlian as kode,a.nama FROM kelas a,keahlian b WHERE a.id_keahlian=b.id_keahlian AND a.tingkat='XII'");

		if ($query->num_rows()> 0)
		{
			$data[''] = 'Nama Kelas';
			foreach ($query->result_array() as $row)
			{
				
				$data[$row['id_kelas']] = $row['tingkat']." ".$row['kode']." ".$row['nama'];
			}
		}
		else
		{
			$data[''] = "";
		}
		return $data;
	}
	
	function getNilai($id,$kls)
	{
		$sql = "SELECT * FROM industri WHERE nis='$id' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kls'";	
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			return $kueri->row();					
		}
		else
		{
			return "kosong";		
		}
	}
	
	function getNilaiDudi($kls,$nis)
	{
		$sql = "SELECT * FROM industri WHERE nis='$id' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kls'";	
		$kueri = $this->db->query($sql);
	}
	
	function getIdNilai($id,$kls)
	{
		$sql = "SELECT * FROM industri WHERE nis='$id' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kls'";
		
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->id_industri;					
		}
		else
		{
			return "";		
		}
	}
	
	function addNilai($kls,$nip)
	{
		$nama = strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))));
		$alamat = strip_tags(ascii_to_entities(addslashes($this->input->post('alamat',TRUE))));
		$lama = strip_tags(ascii_to_entities(addslashes($this->input->post('lama',TRUE))));
		$biji = strip_tags(ascii_to_entities(addslashes($this->input->post('nilai',TRUE))));	
	
		$kueri = $this->db->query("INSERT INTO industri(id_kelas,nis,industri,id_ta,nama_industri,alamat_industri,lama_industri) VALUES('$kls','$nip','$biji','".$this->session->userdata('kd_ta')."','$nama','$alamat','$lama')");	
		return $kueri;
	}
	
	function updateNilai($id)
	{
		$nama = strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))));
		$alamat = strip_tags(ascii_to_entities(addslashes($this->input->post('alamat',TRUE))));
		$lama = strip_tags(ascii_to_entities(addslashes($this->input->post('lama',TRUE))));
		$biji = strip_tags(ascii_to_entities(addslashes($this->input->post('nilai',TRUE))));	
	
		$kueri = $this->db->query("UPDATE industri SET industri='$biji',nama_industri='$nama',alamat_industri='$alamat',lama_industri='$lama' WHERE id_industri='$id'");
		return $kueri;
	}
	
	function getNilaiId($id)
	{
		$kueri = $this->db->query("SELECT * FROM industri WHERE id_industri='$id'");
		return $kueri->row();
	}
}
?>

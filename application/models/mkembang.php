<?php

class Mkembang extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}
	
	function getSiswaKelas($sort_by,$sort_order)
	{
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('a.nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'a.nama';
		$sql = "SELECT * FROM siswa a,kelas_siswa b,kelas_wali c WHERE c.id_kelas=b.id_kelas AND a.nis=b.nis AND c.nip='".$this->session->userdata('nip')."' ORDER BY $sort_by $sort_order";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getKelas()
	{
		$sql = "SELECT * FROM siswa a,kelas_siswa b,kelas_wali c WHERE c.id_kelas=b.id_kelas AND a.nis=b.nis AND c.nip='".$this->session->userdata('nip')."'";	
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			$data = $query->row();
			return $data->id_kelas;
		}
	}
	
	function addDiri($id,$klas,$nis,$biji)
	{
		$kueri = $this->db->query("INSERT INTO nilai_diri(id_diri,id_kelas,nilai_diri,nis,id_ta,semester) VALUES('$id','$klas','$biji','$nis','".$this->session->userdata('kd_ta')."','".$this->session->userdata('kd_sem')."')");	
		return $kueri;
	}
	
	function updateDiri($biji,$kode)
	{
		$kueri = $this->db->query("UPDATE nilai_diri SET nilai_diri='$biji' WHERE id_nilai_diri='$kode'");
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
	
	function getKembang()
	{
		$kueri = $this->db->query("SELECT * FROM diri");
		return $kueri->result();
	}
	
	function getNilaiDiri($diri,$nis,$kelas)
	{
		$sql = "SELECT * FROM nilai_diri WHERE id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kelas' AND nis='$nis' AND id_diri='$diri' ";	
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->id_nilai_diri;
		}
		else
		{	
			return "";
		}
	}
	
	function getNilaiDiris($diri,$nis,$kelas)
	{
		$sql = "SELECT * FROM nilai_diri WHERE id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas='$kelas' AND nis='$nis' AND id_diri='$diri' ";	
		$kueri = $this->db->query($sql);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->nilai_diri;
		}
		else
		{	
			return "Kosong";
		}
	}
	
	function getKembangDiri()
	{
		$query = $this->db->query("SELECT * FROM diri");

		if ($query->num_rows()> 0)
		{
			$data[0] = "Pilih Pengembangan Diri";
			foreach ($query->result_array() as $row)
			{
				
				$data[$row['id_diri']] = $row['pengembangan_diri'];
			}
		}
		else
		{
			$data[''] = "";
		}
		return $data;	
	}
}
?>

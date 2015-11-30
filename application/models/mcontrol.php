<?php

class Mcontrol extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}
	
	function getControl()
	{
		$kueri = $this->db->query("SELECT * FROM waktu");
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->waktu;
		}
		else
		{
			return $kueri->num_rows();
		}
	}	
	
	function addControl()
	{
		$kueri = $this->db->query("INSERT INTO waktu(waktu) VALUES('".strip_tags(ascii_to_entities(addslashes($this->input->post('jam',TRUE))))."')");
		return $kueri;
	}
	
	function updateControl()
	{
		$kueri = $this->db->query("UPDATE waktu SET waktu='".strip_tags(ascii_to_entities(addslashes($this->input->post('jam',TRUE))))."'");
		return $kueri;
	}
	
	function getSemester()
	{
		$kueri = $this->db->query("SELECT * FROM semester WHERE status='1'");
		$data = $kueri->row();
		return $data->semester;
	}
	
	function getIdSemester()
	{
		$kueri = $this->db->query("SELECT * FROM semester WHERE status='1'");
		$data = $kueri->row();
		return $data->id_semester;
	}
	
	function getSem()
	{
		$query = $this->db->query("SELECT * FROM semester");

		if ($query->num_rows()> 0){
			foreach ($query->result_array() as $row)
			{
				$data[$row['id_semester']] = $row['semester'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
	}
	
	function disableSemester($id)
	{
		$kueri = $this->db->query("UPDATE semester SET status='0' WHERE id_semester='$id'");
		return $kueri;
	}
	
	function enableSemester($id)
	{
		$kueri = $this->db->query("UPDATE semester SET status='1' WHERE id_semester='$id'");
		return $kueri;
	}

	function getSemsId($id)
	{
		$kueri = $this->db->query("SELECT * FROM semester WHERE id_semester='$id'");
		$data = $kueri->row();
		return $data->semester;
	}
	
	function getKepala()
	{
		$kueri = $this->db->query("SELECT * FROM kepala ORDER BY id_kepala DESC");
		return $kueri;
	}
	
	function simpanKepala()
	{
		$nip = strip_tags(ascii_to_entities(addslashes($this->input->post('nip',TRUE))));
		$nama = strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))));
		$this->db->query("INSERT INTO kepala(nama_kep,nip_kep) VALUES('$nama','$nip')");
	}
	
	function updateKepala($id)
	{
		$nip = strip_tags(ascii_to_entities(addslashes($this->input->post('nip',TRUE))));
		$nama = strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))));
		$this->db->query("UPDATE kepala SET nam_kep='$nama',$nip_kep='$nip' WHERE id_kepala='$id'");
	}
	
	function getTa($num,$offset,$sort_by,$sort_order)
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('id_ta','ta');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'id_ta';
		$sql = "SELECT * FROM ta ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function delTa($id)
	{
		$kueri = $this->db->query("DELETE FROM ta WHERE id_ta='$id'");
		$kueri = $this->db->query("DELETE FROM catatan WHERE id_ta='$id'");
		$kueri = $this->db->query("DELETE FROM guru_mapel_kelas WHERE id_ta='$id'");
		$kueri = $this->db->query("DELETE FROM industri WHERE id_ta='$id'");
		$kueri = $this->db->query("DELETE FROM kelas_siswa WHERE id_ta='$id'");
		$kueri = $this->db->query("DELETE FROM kelas_wali WHERE id_ta='$id'");
		$kueri = $this->db->query("DELETE FROM kenaikan WHERE id_ta='$id'");
		$kueri = $this->db->query("DELETE FROM kkm WHERE id_ta='$id'");
		$kueri = $this->db->query("DELETE FROM nilai WHERE id_ta='$id'");
		$kueri = $this->db->query("DELETE FROM nilai_diri WHERE id_ta='$id'");
		$kueri = $this->db->query("DELETE FROM rumus_nilai WHERE id_ta='$id'");
		$kueri = $this->db->query("DELETE FROM siswa WHERE id_ta='$id'");
		return $kueri;
	}
	
	function addTa()
	{
		$kueri = $this->db->query("INSERT INTO ta(id_ta,ta) VALUES('".$this->input->post('kode',TRUE)."','".$this->input->post('tahun',TRUE)."')");
		return $kueri;
	}
	
	function updateTa($id)
	{
		$kueri = $this->db->query("UPDATE ta SET ta='".strip_tags(ascii_to_entities(addslashes($this->input->post('ta',TRUE))))."' WHERE id_ta='$id'");
		return $kueri;
	}
	
	function getIdTa($id)
	{
		$kueri = $this->db->query("SELECT * FROM ta WHERE id_ta='$id'");
		return $kueri->row();
	}
	
	function updateTaAll()
	{
		$this->db->query("UPDATE ta SET status='0'");
	}
	
	function updateTaId($id)
	{
		$this->db->query("UPDATE ta SET status='1' WHERE id_ta='$id'");
	}
}
?>

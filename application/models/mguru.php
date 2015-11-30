<?php

class Mguru extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function addGuru()
	{	
		$dt = array(
			'nip'=>strip_tags(ascii_to_entities(addslashes($this->input->post('nip',TRUE)))),
			'nama'=>strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),
			'tempat_lahir'=>strip_tags(ascii_to_entities(addslashes($this->input->post('tempat',TRUE)))),
			'tanggal_lahir'=>$this->input->post('tahun',TRUE)."-".$this->input->post('bulan',TRUE)."-".$this->input->post('hari',TRUE),
			'agama'=>$this->input->post('agama',TRUE),
			'alamat'=>strip_tags(ascii_to_entities(addslashes($this->input->post('alamat',TRUE))))
		);
		$this->db->insert('guru',$dt);
	}

	function cekNip($nip)
	{
		$kueri = $this->db->query(" SELECT * FROM guru WHERE nip='".strip_tags(ascii_to_entities(addslashes($nip)))."' ");
		return $kueri->num_rows();
	}
	
	function getGuru($num,$offset,$sort_by,$sort_order)
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('nip','nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'nip';
		$sql = "SELECT * FROM guru ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function searchGuru($kunci,$num,$offset,$sort_by,$sort_order)
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('nip','nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'nip';
		$sql = "SELECT * FROM guru WHERE nama LIKE '%$kunci%' ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getNip($id)
	{
		$id = urldecode($id);
		$sql = "SELECT nip,nama,tempat_lahir,alamat,agama,day(tanggal_lahir) as tanggal,month(tanggal_lahir) as bulan,year(tanggal_lahir) as tahun FROM guru WHERE nip='$id'";
		//echo $sql;
		//exit();
		$query = $this->db->query($sql);
		return $query->row();
	}
	
	function updateGuru()
	{
		$sql = "UPDATE guru SET nama='".strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))."',alamat='".strip_tags(ascii_to_entities(addslashes($this->input->post('alamat',TRUE))))."',tanggal_lahir='".$this->input->post('tahun').'-'.$this->input->post('bulan').'-'.$this->input->post('hari')."',agama='".$this->input->post('agama')."' WHERE nip='".$this->input->post('kode',TRUE)."' ";
		$this->db->query($sql);	
	}
	
	function getAgama()
	{
		$query = $this->db->query("SELECT * FROM agama");

		if ($query->num_rows()> 0){
			foreach ($query->result_array() as $row)
			{
				$data[$row['id_agama']] = $row['agama'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
	}
	
	function getIdAgama($id)
	{
		$agama = ucfirst(strtolower($id));
		$query = "SELECT * FROM agama WHERE agama='$agama'";
		$kueri = $this->db->query($query);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->id_agama;
		}
		else
		{
			return "1";
		}
	}
	
	function exportGuru()
	{
		$this->db->select('guru.nip,guru.nama,guru.tempat_lahir,guru.tanggal_lahir,guru.alamat,agama.agama');
		$this->db->from('guru');
		$this->db->join('agama', 'agama.id_agama = guru.agama');
			
		$query = $this->db->get();
		return $query;
	}
	
	function importGuru($value)
	{
		$sql = "INSERT INTO guru VALUES($value)";
		$kueri = $this->db->query($sql);
		return $kueri;
	}
	
	function delGuru($id)
	{
		$kueri = $this->db->query("DELETE FROM guru WHERE nip='$id'");
		$kueri_cek = $this->db->query("SELECT * FROM guru_mapel WHERE nip='$id'");
		if($kueri_cek->num_rows() > 0)
		{
			$data = $kueri_cek->row();
			$kode = $data->id_guru_mapel;
			$kueri = $this->db->query("DELETE FROM nilai WHERE id_guru_mapel='".$kode."'");
		}
		$kueri = $this->db->query("DELETE FROM guru_mapel WHERE nip='$id'");
		$kueri = $this->db->query("DELETE FROM users WHERE nip='$id'");
		return $kueri;
	}
	
	function importUpdateGuru($nip,$nama,$tempat,$tgl,$alamat,$agama)
	{
		$sql = "UPDATE guru SET nama='".strip_tags(ascii_to_entities(addslashes($nama)))."',tempat_lahir='$tempat',tanggal_lahir='$tgl',alamat='$alamat',agama='$agama' WHERE nip='$nip'";
		$kueri = $this->db->query($sql);
		return $kueri;
	}
}
?>

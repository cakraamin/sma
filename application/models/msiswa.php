<?php

class Msiswa extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function addSiswa()
	{	
		$dt = array(
			'nis'=>strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE)))),
			'nama'=>strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE)))),
			'tempat_lahir'=>strip_tags(ascii_to_entities(addslashes($this->input->post('tempat',TRUE)))),
			'tanggal_lahir'=>$this->input->post('tahun',TRUE)."-".$this->input->post('bulan',TRUE)."-".$this->input->post('hari',TRUE),
			'agama'=>$this->input->post('agama',TRUE),
			'alamat'=>strip_tags(ascii_to_entities(addslashes($this->input->post('alamat',TRUE)))),
			'gambar'=>$this->input->post('images',TRUE),
			'id_ta'=>$this->session->userdata('kd_ta'),
			'id_keahlian'=>$this->input->post('ahli',TRUE)
		);
		$this->db->insert('siswa',$dt);
	}

	function cekNis($nis)
	{
		$kueri = $this->db->query(" SELECT * FROM siswa WHERE nis='".strip_tags(ascii_to_entities(addslashes($nis)))."' ");
		return $kueri->num_rows();
	}
	
	function getSiswa($num,$offset,$sort_by,$sort_order)
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('nis','nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'nis';
		$sql = "SELECT * FROM siswa ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function searchSiswa($kunci,$num,$offset,$sort_by,$sort_order)//menu admin
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('nis','nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'nis';
		$sql = "SELECT * FROM siswa WHERE nama LIKE '%$kunci%' ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getNis($id)
	{
		$sql = "SELECT id_keahlian,nis,nama,tempat_lahir,alamat,gambar,agama,day(tanggal_lahir) as tanggal,month(tanggal_lahir) as bulan,year(tanggal_lahir) as tahun FROM siswa WHERE nis='$id'";
		$query = $this->db->query($sql);
		return $query->row();
	}
	
	function updateSiswa()
	{
		$sql = "UPDATE siswa SET nama='".strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))."',alamat='".strip_tags(ascii_to_entities(addslashes($this->input->post('alamat',TRUE))))."',tanggal_lahir='".$this->input->post('tahun').'-'.$this->input->post('bulan').'-'.$this->input->post('hari')."',agama='".$this->input->post('agama',TRUE)."',id_keahlian='".$this->input->post('ahli',TRUE)."' WHERE nis='".$this->input->post('kode',TRUE)."' ";
		$this->db->query($sql);	
	}
	
	function delSiswa($id)
	{
		$kueri_del = $this->db->query("SELECT * FROM siswa WHERE nis='$id'");
		$data_del = $kueri_del->row();
		if($data_del->gambar != "")
		{
			unlink("./uploads/thumbnail/".$data_del->gambar);
			unlink("./uploads/gambar/".str_replace("_tn","",$data_del->gambar));
		}
	
		$sql = "DELETE FROM siswa WHERE nis='$id'";
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
	
	function getAhli()
	{
		$query = $this->db->query("SELECT * FROM keahlian");

		if ($query->num_rows()> 0){
			foreach ($query->result_array() as $row)
			{
				$data[$row['id_keahlian']] = $row['program_keahlian'];
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
	
	function getIdTa($id)
	{
		$query = "SELECT * FROM ta WHERE ta='$id'";
		$kueri = $this->db->query($query);
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->id_ta;
		}
		else
		{
			return 	$this->session->userdata('kd_ta');
		}
	}
	
	function exportSiswa()
	{
		$this->db->select('siswa.nis,siswa.nama,siswa.tempat_lahir,siswa.tanggal_lahir,siswa.alamat,agama.agama,ta.ta,keahlian.program_keahlian');
		$this->db->from('siswa');
		$this->db->join('agama', 'agama.id_agama = siswa.agama');
		$this->db->join('ta', 'ta.id_ta = siswa.id_ta');
		$this->db->join('keahlian', 'keahlian.id_keahlian = siswa.id_keahlian');
			
		$query = $this->db->get();
		return $query;
	}
	
	function importSiswa($value)
	{
		$kueri = $this->db->query("INSERT INTO siswa VALUES($value)");
		return $kueri;
	}

	function importUpdateSiswa($nis,$nama,$tempat,$tgl,$alamat,$agama,$gambar,$ta,$prog)
	{
		$kueri = $this->db->query("UPDATE siswa SET nama='".strip_tags(ascii_to_entities(addslashes($nama)))."',tempat_lahir='$tempat',tanggal_lahir='$tgl',alamat='$alamat',agama='$agama',gambar='$gambar',id_ta='$ta',id_keahlian='$prog' WHERE nis='$nis'");
	}
	
	function editImage($id,$thumb)
	{
		$query_del = $this->db->query("SELECT * FROM siswa WHERE nis='$id'");
		$data_del = $query_del->row();
		if($data_del->gambar != "")
		{
			unlink("./uploads/thumbnail/".$data_del->gambar);
			unlink("./uploads/gambar/".str_replace("_tn","",$data_del->gambar));
		}
	
		$query = $this->db->query("UPDATE siswa SET gambar='".$thumb."' WHERE nis='$id'");
		return $query;
	}

	function getIdJur($id)
	{
		$jur = strtoupper($id);
		$kueri = $this->db->query("SELECT * FROM keahlian WHERE program_keahlian='$jur'");
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			return $data->id_keahlian;
		}
	}
}
?>

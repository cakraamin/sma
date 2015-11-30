<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MKenaikan extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}	

	function getTingkatTa()
	{
		$hasil = array();
		$nilai = "";

		$kueri = $this->db->query("SELECT * FROM ta");
		$d_kueri = $kueri->result();		
		foreach($d_kueri as $key => $dt_kueri)
		{
			$hasil[$key] = $dt_kueri->id_ta;
		}

		while ($status = current($hasil)) 
		{
		    if ($status == $this->session->userdata('kd_ta')) 
		    {
		        $nilai = key($hasil);
		    }
		    next($hasil);
		}

		if(array_key_exists ( $nilai+1 , $hasil ))
		{
			$data = array(
				'sekarang'		=> array(
					'id'		=> $this->session->userdata('kd_ta'),
					'tahun'		=> $this->getTa($this->session->userdata('kd_ta'))
				),
				'berikut'		=> array(
					'id'		=> $hasil[$nilai+1],
					'tahun'		=> $this->getTa($hasil[$nilai+1])
				)
			);
		}
		else
		{
			$data = array(
				'sekarang'		=> $this->session->userdata('kd_ta'),
				'berikut'		=> 0
			);
		}

		return $data;
	}

	private function getTa($id)
	{
		$kueri = $this->db->query("SELECT * FROM ta WHERE id_ta='$id'");
		$data = $kueri->row();
		$hasil = (isset($data->ta))?$data->ta:"Tidak Ketemu";
		return $hasil;
	}	

	function getKelass($kelas,$sort_by,$sort_order,$lain)//menu admin
	{		
		$hasil = array();

		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('c.nis','c.nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'c.nis';
		$sql = "SELECT a.id_kelas_sis,b.nama as kelas,c.nama as jeneng,c.nis,b.tingkat,b.kode FROM kelas_siswa a,kelas b,siswa c WHERE a.nis=c.nis AND a.id_kelas=b.id_kelas AND a.id_kelas='$kelas' AND a.id_ta='".$this->session->userdata('kd_ta')."' GROUP BY c.nis ORDER BY $sort_by $sort_order";
		$query = $this->db->query($sql);
		$data = $query->result();
		foreach($data as $dt)
		{
			$hasil[] = array(
				'id_kelas_sis'		=> $dt->id_kelas_sis,
				'nis'				=> $dt->nis,
				'jeneng'			=> $dt->jeneng,
				'sekarang'			=> $dt->tingkat." ".$this->arey->getPenjurusan($dt->kode)." ".$dt->kelas,
				'depan'				=> $this->getNextKelas($dt->nis,$lain)
			);
		}

		return $hasil;
	}

	private function getNextKelas($nis,$lain)
	{
		$sql = "SELECT * FROM kelas_siswa a,kelas b WHERE a.id_kelas=b.id_kelas AND a.nis='$nis' AND a.id_ta='$lain'";
		$kueri = $this->db->query($sql);
		$data = $kueri->row();
		$hasil = (isset($data->id_kelas_sis))?$data->tingkat." ".$this->arey->getPenjurusan($data->kode)." ".$data->nama:"";
		return $hasil;
		//return $sql;
	}

	function getKelas()
	{
		$query = $this->db->query("SELECT a.id_kelas,a.tingkat,a.kode,a.nama,a.jenis,a.id FROM kelas a WHERE a.jenis='0'");

		if ($query->num_rows()> 0)
		{
			$data[0] = "Nama Kelas";
			foreach ($query->result_array() as $row)
			{
				$keterangan = $this->arey->getPenjurusan($row['kode']);
				$data[$row['id_kelas']] = $row['tingkat']." ".$keterangan." ".$row['nama'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
	}

	function getNextDKelas($id)
	{
		$query = $this->db->query("SELECT a.id_kelas,a.tingkat,a.kode,a.nama,a.jenis,a.id FROM kelas a WHERE a.jenis='0' AND a.tingkat='$id'");

		if ($query->num_rows()> 0)
		{
			$data[0] = "Nama Kelas";
			foreach ($query->result_array() as $row)
			{
				$keterangan = $this->arey->getPenjurusan($row['kode']);
				$data[$row['id_kelas']] = $row['tingkat']." ".$keterangan." ".$row['nama'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
	}

	public function getTingkatKelas($id)
	{
		$kelas = $this->arey->getTingkatKelas();
		$nilai = "";

		$kueri = $this->db->query("SELECT * FROM kelas WHERE id_kelas='$id'");
		$data = $kueri->row();
		$hasil = (isset($data->tingkat))?$data->tingkat:"X";

		while ($kelase = current($kelas)) 
		{
		    if ($kelase == $hasil) 
		    {
		        $nilai = key($kelas);
		    }
		    next($kelas);
		}
		return $kelas[$nilai+1];
	}

	public function setNaik($nis,$kelas,$ta)
	{
		$data = array(
		   'id_kelas' 	=> $kelas,
		   'nis' 		=> $nis,
		   'id_ta' 		=> $ta
		);

		$this->db->insert('kelas_siswa', $data); 
	}
}
?>

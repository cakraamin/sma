<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maspek extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}
	
	function getAspek($kode,$sort_by)
	{
		$hasil = array();				
		
		$sort_columns = array('mapel');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'mapel';
		$query = $this->db->query("SELECT * FROM mapel ORDER BY $sort_by");		
		$data = $query->result();
		foreach($data as $detail)
		{
			unset($details);
			$kkm = "";
			$details = array();
			$q_detail = $this->db->query("SELECT * FROM aspek_nilai WHERE id_mapel='".$detail->id_mapel."' AND jenis_aspek='$kode' ORDER BY tingkat_aspek ASC");
			$d_detail = $q_detail->result();
			foreach($d_detail as $detaile)
			{
				$details[$detaile->tingkat_aspek] = $detaile->aspek;
				$kkm = $detaile->kkm;
			}

			$hasil[] = array(
				'id_mapel'		=> $detail->id_mapel,
				'nama_mapel'	=> $detail->mapel,
				'detail'		=> $details,
				'kkm'			=> $kkm
			);
		}
		return $hasil;
	}

	public function getCekAspek($id)
	{
		$kueri = $this->db->query("SELECT * FROM aspek_nilai WHERE id_mapel='$id' AND tingkat_aspek='1'");
		if($kueri->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function getMapel()
	{
		$query = $this->db->query("SELECT * FROM mapel");

		if ($query->num_rows()> 0){
			foreach ($query->result_array() as $row)
			{
				$data[$row['id_mapel']] = $row['mapel'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
	}

	function getAspekAll($kode,$id)
	{
		$hasil = array();
		$kkm = "";

		$kueri = $this->db->query("SELECT * FROM aspek_nilai WHERE id_mapel='$id' AND jenis_aspek='$kode' ORDER BY tingkat_aspek ASC");
		$data = $kueri->result();

		unset($detaile);
		$detaile = array();

		foreach($data as $dt)
		{			
			$detaile[] = $dt->aspek;
			$kkm = $dt->kkm;
		}

		$hasil = array(
			'id_mapel'		=> $id,
			'jumlah'		=> $kueri->num_rows(),
			'detaile'		=> $detaile,
			'kkm'			=> $kkm
		);

		return $hasil;
	}

	function addAspek($jenis,$id)
	{
		$this->db->delete('aspek_nilai', array('id_mapel' => $id, 'jenis_aspek' => $jenis)); 

		$aspek = $this->input->post('aspek',TRUE);

		foreach ($aspek as $key => $value) 
		{
			$tingkat = $key + 1;

			$data = array(
				'id_aspek_nilai' 	=> '',
			   	'jenis_aspek' 		=> $jenis,
			   	'tingkat_aspek'		=> $tingkat,
			   	'id_mapel'			=> $this->input->post('mapel',TRUE),
			   	'aspek'				=> $value,
			   	'kkm'				=> $this->input->post('kkm',TRUE)
			);

			$this->db->insert('aspek_nilai', $data); 
		}
	}

	function delAspekPeng($id,$nilai)
	{
		$this->db->delete('aspek_nilai', array('id_mapel' => $id,'jenis_aspek' => $nilai)); 
	}
}
?>

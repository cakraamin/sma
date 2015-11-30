<?php

class Mmapel extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function getMapel($num,$offset,$sort_by,$sort_order)
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('mapel');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'mapel';
		$sql = "SELECT * FROM mapel ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}	

	public function getDetailMapels($id)
	{
		$hasil = array();

		$sql = "SELECT c.mapel,d.nama,b.id_guru_mapel FROM guru_mapel_kelas a,guru_mapel b,mapel c,guru d WHERE a.id_guru_mapel=b.id_guru_mapel AND b.id_mapel=c.id_mapel AND b.nip=d.nip AND a.id_mapel_kelas='$id'";		
		$kueri = $this->db->query($sql);
		$data = $kueri->row();
		$mapel = (isset($data->mapel))?$data->mapel:"";
		$nama = (isset($data->nama))?$data->nama:"";
		$kode = (isset($data->id_guru_mapel))?$data->id_guru_mapel:"0";
		$hasil = array(
			'id'		=> $id,
			'value'		=> $mapel." : ".$nama,
			'kode'		=> $kode
		);

		return $hasil;
	}

	function getMapelKelase($id)
	{
		$hasil = array();		
		$jenis = array('A','B','C');		
		foreach($jenis as $dt_jenis)
		{
			$sql = "SELECT c.id_mapel_kelas,a.mapel,d.nama,b.id_team FROM mapel a,guru_mapel b,guru_mapel_kelas c,guru d WHERE a.id_mapel=b.id_mapel AND b.id_guru_mapel=c.id_guru_mapel AND c.id_kelas='$id' AND a.jenis='$dt_jenis' AND b.nip=d.nip GROUP BY b.id_team";			
			$kueri = $this->db->query($sql);			
			$data = $kueri->result();

			unset($detil);
			$detil = array();
			foreach($data as $dt)
			{
				$detil[] = array(
					'id_mapel_kelas'		=> $dt->id_mapel_kelas,
					'mapel'					=> $dt->mapel,
					'nama'					=> $this->getAllGuru($dt->id_team),
					'kode_mapel_kelas'		=> $this->getKodeMapelKelas($dt->id_team,$dt_jenis,$id)
				);
			}

			$hasil[$dt_jenis] = $detil;							
		}

		return $hasil;
	}	

	private function getKodeMapelKelas($id,$dt_jenis,$id)
	{
		$hasil = array();
		$sql = "SELECT c.id_mapel_kelas FROM mapel a,guru_mapel b,guru_mapel_kelas c,guru d WHERE a.id_mapel=b.id_mapel AND b.id_guru_mapel=c.id_guru_mapel AND c.id_kelas='$id' AND a.jenis='$dt_jenis' AND b.nip=d.nip";			
		$kueri = $this->db->query($sql);
		$data = $kueri->result();
		foreach($data as $dt)
		{
			$hasil[] = $dt->id_mapel_kelas;
		}
		return implode("-", $hasil);
	}

	public function getDaftarGuruMapel($id)
	{
		$hasil = array();

		$sql = "SELECT a.id_mapel_kelas,d.mapel,b.tingkat,b.jenis,b.id_kelas,e.nama FROM guru_mapel_kelas a,kelas b,guru_mapel c,mapel d,guru e WHERE a.id_kelas=b.id_kelas AND a.id_guru_mapel=c.id_guru_mapel AND c.id_mapel=d.id_mapel AND c.nip=e.nip AND a.id_kelas='$id'";
		$kueri = $this->db->query($sql);
		$nilai = $kueri->result();
		foreach($nilai as $detail)
		{
			$hasil[] = array(
				'id_mapel_kelas'		=> $detail->id_mapel_kelas,
				'mapel'					=> $detail->mapel,
				'kelas'					=> $detail->tingkat." ".$detail->jenis." ".$detail->nama,
				'id_kelas'				=> $detail->id_kelas,
				'nama'					=> $detail->nama
			);
		}
		return $hasil;
	}
	
	function cekMapel()
	{
		$kueri = $this->db->query(" SELECT * FROM mapel WHERE mapel='".strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))."' ");
		return $kueri->num_rows();
	}
	
	function cekMapels($id)
	{
		$kueri = $this->db->query(" SELECT * FROM mapel WHERE mapel='".strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))."' AND id_mapel<>'$id' ");
		return $kueri->num_rows();
	}
	
	function addMapel()
	{	
		$this->db->query("INSERT INTO mapel(mapel,jum_jam_mapel,jenis,harian,tugas,ulangan,dual_guru) VALUES('".strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))."','".$this->input->post('jam',TRUE)."','".$this->input->post('jenis',TRUE)."','".$this->input->post('harian',TRUE)."','".$this->input->post('tugas',TRUE)."','".$this->input->post('ulangan',TRUE)."','".$this->input->post('guru')."')");
	}	
	
	function getMapelId($id)
	{
		$sql = "SELECT * FROM mapel WHERE id_mapel='$id'";
		$query = $this->db->query($sql);
		return $query->row();
	}
	
	function updateMapel($id)
	{
		$sql = "UPDATE mapel SET mapel='".strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))."',jum_jam_mapel='".$this->input->post('jam',TRUE)."',jenis='".$this->input->post('jenis',TRUE)."',harian='".$this->input->post('harian',TRUE)."',tugas='".$this->input->post('tugas',TRUE)."',ulangan='".$this->input->post('ulangan',TRUE)."',dual_guru='".$this->input->post('guru')."' WHERE id_mapel='$id' ";		
		$kueri = $this->db->query($sql);
		return $kueri;
	}

	public function getKodeMapel($id)
	{
		$kueri = $this->db->query("SELECT * FROM mapel WHERE id_mapel='$id'");
		$hasil = $kueri->row();
		$data = (isset($hasil->dual_guru))?$hasil->dual_guru:0;
		return $data;
	}
	
	function delMapel($id)
	{
		$kueri = $this->db->query("DELETE FROM mapel WHERE id_mapel='$id'");
		return $kueri;
	}
	
	function searchMapel($kunci,$num,$offset,$sort_by,$sort_order)
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('mapel');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'mapel';
		$sql = "SELECT * FROM mapel WHERE mapel LIKE '%$kunci%' ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function lookup($keyword)
	{
		$this->db->select('*')->from('guru');
        $this->db->like('nama',$keyword,'after');
        $query = $this->db->get();    
        
        return $query->result();
	}

	function lookup_mapel($keyword,$jenis)
	{
		$query = $this->db->query("SELECT b.nama,a.mapel,c.id_guru_mapel FROM mapel a,guru b,guru_mapel c WHERE a.id_mapel=c.id_mapel AND c.nip=b.nip AND (a.mapel LIKE '%".$keyword."%' OR b.nama LIKE '%".$keyword."%') AND a.jenis='$jenis'");
        
        return $query->result();
	}

	public function addGuruKelas($kelas,$nip)
	{
		foreach($nip as $detail)
		{
			$data = array(
			   'id_mapel_kelas' => '',
			   'id_guru_mapel' 	=> $detail->id_guru_mapel,
			   'id_kelas' 		=> $kelas,
			   'id_ta'			=> $this->session->userdata('kd_ta')
			);

			$this->db->insert('guru_mapel_kelas', $data); 
		}		
	}

	public function updateGuruKelas($id,$team)
	{
		$pecah = explode("-", $id);
		foreach($team as $key => $dt_team)
		{
			$data = array(		  
			   'id_guru_mapel' 	=> $dt_team->id_guru_mapel
			);

			$this->db->where('id_mapel_kelas', $pecah[$key]);
			$this->db->update('guru_mapel_kelas', $data); 		
		}		
	}

	public function updateGuruKelasKecil($id,$team)
	{
		$pecah = explode("-", $id);
		foreach($team as $key => $dt_team)
		{
			$data = array(		  
			   'id_guru_mapel' 	=> $dt_team->id_guru_mapel
			);

			$this->db->where('id_mapel_kelas', $pecah[$key]);
			$this->db->update('guru_mapel_kelas', $data); 		
		}
		$this->delGuruMapels($pecah['1']);
	}
	
	function getMapelGuru($num,$offset,$sort_by,$sort_order)
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('b.mapel');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'b.mapel';
		$sql = "SELECT * FROM guru_mapel a,mapel b WHERE a.id_mapel=b.id_mapel GROUP BY id_team ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function numMapelGuru()
	{
		$sql = "SELECT * FROM guru_mapel a,mapel b WHERE a.id_mapel=b.id_mapel GROUP BY id_team";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	function getMapell()
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
		//$query->free_result();
		return $data;
	}
	
	function getMapells()
	{
		$query = $this->db->query("SELECT * FROM guru_mapel a,mapel b WHERE a.id_mapel=b.id_mapel GROUP BY id_team");

		if ($query->num_rows()> 0)
		{
			$data[0] = "Pilih Nama Kelas";
			foreach ($query->result_array() as $row)
			{			
				$data[$row['id_team']] = $row['mapel']." [".$this->getAllGuru($row['id_team'])."]";
			}
		}
		else
		{
			$data[''] = "";
		}
		return $data;
	}

	function getMapellsById($id)
	{
		$query = $this->db->query("SELECT * FROM guru_mapel a,mapel b WHERE a.id_mapel=b.id_mapel AND b.jenis='$id' GROUP BY id_team");

		if ($query->num_rows()> 0)
		{
			$data[0] = "Pilih Nama Kelas";
			foreach ($query->result_array() as $row)
			{			
				$data[$row['id_team']] = $row['mapel']." [".$this->getAllGuru($row['id_team'])."]";
			}
		}
		else
		{
			$data[''] = "";
		}
		return $data;
	}
	
	function cekMapelGuru()
	{
		$kueri = $this->db->query(" SELECT * FROM guru_mapel WHERE nip='".strip_tags(ascii_to_entities(addslashes($this->input->post('nip',TRUE))))."' AND id_mapel='".$this->input->post('nip',TRUE)."' ");
		return $kueri->num_rows();
	}
	
	function addMapelGuru($nip,$tim,$persen)
	{
		$sql = "INSERT INTO guru_mapel(nip,id_mapel,id_team,persen) VALUES('".strip_tags(ascii_to_entities(addslashes($nip)))."','".$this->input->post('mapel',TRUE)."','$tim','".strip_tags(ascii_to_entities(addslashes($persen)))."')";
		$kueri = $this->db->query($sql);
		return $kueri;	
	}
	
	function cekNip()
	{
		$kueri = $this->db->query(" SELECT * FROM guru WHERE nip='".strip_tags(ascii_to_entities(addslashes($this->input->post('nip',TRUE))))."' ");
		return $kueri->num_rows();
	}
	
	function cekNips($id)
	{
		$kueri = $this->db->query(" SELECT * FROM guru WHERE nip='".strip_tags(ascii_to_entities(addslashes($id)))."' ");
		return $kueri->num_rows();
	}
	
	function getIdGuruMapel($id)
	{
		$kueri = $this->db->query("SELECT * FROM guru_mapel a,guru b WHERE a.nip=b.nip AND a.id_team='$id'");
		return $kueri->row();
	}
	
	function cekMapelGurus($id)
	{
		$kueri = $this->db->query(" SELECT * FROM guru_mapel WHERE nip='".strip_tags(ascii_to_entities(addslashes($this->input->post('nip',TRUE))))."' AND id_mapel='".$this->input->post('nip',TRUE)."' AND id_guru_mapel<>'$id' ");
		return $kueri->num_rows();
	}
	
	function updateMapelGuru($id,$nip,$persen)
	{
		$sql = "UPDATE guru_mapel SET nip='".strip_tags(ascii_to_entities(addslashes($nip)))."',persen='".strip_tags(ascii_to_entities(addslashes($persen)))."' WHERE id_guru_mapel='$id'";
		$kueri = $this->db->query($sql);
		return $kueri;	
	}
	
	function delGuruMapel($id)
	{
		$kueri = $this->db->query("DELETE FROM guru_mapel WHERE id_team='$id'");
		return $kueri;
	}
	
	function searchMapelGuru($kunci,$num,$offset,$sort_by,$sort_order)
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('b.mapel');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'b.mapel';
		$sql = "SELECT * FROM guru_mapel a,mapel b WHERE a.id_mapel=b.id_mapel AND b.mapel LIKE '%".$kunci."%' GROUP BY id_team ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function numsearchMapelGuru($kunci)
	{
		$sql = "SELECT * FROM guru_mapel a,mapel b WHERE a.id_mapel=b.id_mapel AND b.mapel LIKE '%".$kunci."%' GROUP BY id_team ";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	function getMapelKelas($kunci,$num,$offset,$sort_by,$sort_order)
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('c.nama','b.mapel');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'c.nama';
		$sql = "SELECT * FROM guru_mapel_kelas a,guru b WHERE a.nip=c.nip AND a.id_mapel=b.id_mapel AND c.nama LIKE '%".$kunci."%' ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query;
	}
	
	function getKelas()
	{
		$query = $this->db->query("SELECT a.id_kelas,a.tingkat,a.nama,a.kode,a.jenis,a.id FROM kelas a");

		if ($query->num_rows()> 0)
		{
			foreach ($query->result_array() as $row)
			{			
				if($row['jenis'] == 1)
				{
					$keterangan = $this->getMinatId($row['id']);
				}
				else
				{
					$keterangan = $this->arey->getPenjurusan($row['kode']);
				}
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

	function getKelasMu()
	{
		$query = $this->db->query("SELECT a.id_kelas,a.tingkat,a.nama,a.kode,a.jenis,a.id FROM kelas a WHERE a.jenis='0'");

		if ($query->num_rows()> 0)
		{
			$data[0] = "Pilih Kelas";

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

	function getKelasAnyar()
	{
		$query = $this->db->query("SELECT a.id_kelas,a.tingkat,a.nama,a.kode,a.jenis,a.id FROM kelas a WHERE a.jenis='0'");

		if ($query->num_rows()> 0)
		{
			$data[0] = "Pilih Kelas";
			foreach ($query->result_array() as $row)
			{			
				if($row['jenis'] == 1)
				{
					$keterangan = $this->getMinatId($row['id']);
				}
				else
				{
					$keterangan = $this->arey->getPenjurusan($row['kode']);
				}
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

	public function getMinatId($id)
	{
		$kueri = $this->db->query("SELECT * FROM mapel WHERE id_mapel='$id'");
		$data = $kueri->row();
		$hasil = (isset($data->mapel))?$data->mapel:"Minat";
		return $hasil;
	}
	
	function getNamaGuru($id)
	{
		$kueri = $this->db->query("SELECT * FROM guru a,guru_mapel b WHERE a.nip=b.nip AND b.id_team='$id'");
		return $kueri->row();
	}
	
	function addMapelKelasGuru($id,$nips)
	{
		foreach($nips as $detail)
		{
			$data = array(
			   'id_mapel_kelas' => '',
			   'id_guru_mapel' 	=> $detail->id_guru_mapel,
			   'id_kelas' 		=> $this->input->post('kelas',TRUE),
			   'id_ta'			=> $this->session->userdata('kd_ta')
			);

			$this->db->insert('guru_mapel_kelas', $data); 			
		}		
	}

	function getDetailTeam($id)
	{
		$kueri = $this->db->query("SELECT id_guru_mapel FROM guru_mapel WHERE id_team='$id'");
		return $kueri->result();
	}
	
	function getMapelGuruKelas($id,$num,$offset,$sort_by,$sort_order)
	{
		$hasil = array();
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('b.nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'b.nama';
		//$sql = "SELECT a.id_mapel_kelas,b.nama,b.id_kelas,b.tingkat,b.kode,b.jenis,b.id FROM guru_mapel_kelas a,kelas b,guru_mapel c WHERE a.id_kelas=b.id_kelas AND a.id_guru_mapel=c.id_guru_mapel AND c.id_team='$id' GROUP BY a.id_kelas ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$sql = "SELECT a.id_mapel_kelas,b.nama,b.id_kelas,b.tingkat,b.kode,b.jenis,b.id FROM guru_mapel_kelas a,kelas b,guru_mapel c WHERE a.id_kelas=b.id_kelas AND a.id_guru_mapel=c.id_guru_mapel AND c.id_team='$id' GROUP BY a.id_kelas ORDER BY $sort_by $sort_order";
		$query = $this->db->query($sql);
		$query = $query->result();
		foreach($query as $d_query)
		{
			$allKode = $this->getAllKodeMapel($id);
			$keterangan = ($d_query->jenis == 1)?$this->getMinatId($d_query->id): $this->arey->getPenjurusan($d_query->kode);
			$hasil[] = array(
				'nama'		=> $d_query->tingkat." ".$keterangan." ".$d_query->nama,
				'kode'		=> $allKode
			);
		}
		return array_splice($hasil, $offset, $num);
	}

	private function getAllKodeMapel($id)
	{
		$hasil = array();
		$sql = "SELECT b.id_mapel_kelas FROM guru_mapel a,guru_mapel_kelas b WHERE a.id_guru_mapel=b.id_guru_mapel AND a.id_team='$id'";
		$kueri = $this->db->query($sql);
		$data = $kueri->result();		
		foreach($data as $dt)
		{
			$hasil[] = $dt->id_mapel_kelas;
		}
		return implode("-", $hasil);
	}
	
	function numMapelGuruKelas($id)
	{
		$sql = "SELECT a.id_mapel_kelas,b.nama,b.id_kelas FROM guru_mapel_kelas a,kelas b,guru_mapel c WHERE a.id_kelas=b.id_kelas AND a.id_guru_mapel=c.id_guru_mapel AND c.id_team='$id' ";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	function getIdMapelKelas($id)
	{
		$pos = strpos($id, "-");
		$ket = ($pos === false)?$id:end(explode("-", $id));		
		$sql = "SELECT * FROM guru_mapel_kelas WHERE id_mapel_kelas='$ket'";		
		$kueri = $this->db->query($sql);
		return $kueri->row();		
	}
	
	function updateMapelKelasGuru($id)
	{
		$pos = strpos($id, "-");
		if($pos === false)
		{
			$data = array(
               'id_kelas' => $this->input->post('kelas',TRUE)      
            );

			$this->db->where('id_mapel_kelas', $id);
			$this->db->update('guru_mapel_kelas', $data); 
		}
		else
		{
			$pecah = explode("-", $id);
			foreach($pecah as $detail)
			{
				$data = array(
	               'id_kelas' => $this->input->post('kelas',TRUE)             
	            );

				$this->db->where('id_mapel_kelas', $detail);
				$this->db->update('guru_mapel_kelas', $data); 
			}
		}		
	}
	
	function delGuruMapels($id)
	{
		$kueri = $this->db->query("DELETE FROM guru_mapel_kelas WHERE id_mapel_kelas='$id'");
		return $kueri;
	}	
	
	function getIdTeam()
	{
		$kueri = $this->db->query("SELECT id_team FROM guru_mapel ORDER BY id_guru_mapel DESC ");
		if($kueri->num_rows() > 0)
		{
			$data = $kueri->row();
			$id = $data->id_team + 1;
		}
		else
		{
			$id = 1;
		}		
		return $id;
	}
	
	function getAllGuru($id)
	{
		$kueri = $this->db->query("SELECT * FROM guru_mapel a,guru b WHERE a.nip=b.nip AND a.id_team='$id'");
		$data = $kueri->result();
		$daftar = '';
		foreach($data as $nilai)
		{
			$daftar .= $nilai->nama.", ";
		}
		$jumlah = strlen($daftar);
		return substr($daftar, 0, $jumlah - 2);
	}
	
	function getAllPersen($id)
	{
		$kueri = $this->db->query("SELECT * FROM guru_mapel WHERE id_team='$id'");
		$data = $kueri->result();
		$daftar = '';
		foreach($data as $nilai)
		{
			$daftar .= $nilai->persen.":";
		}
		$jumlah = strlen($daftar);
		return substr($daftar, 0, $jumlah - 1);
	}
	
	function getAllGuruEdit($id)
	{
		$kueri = $this->db->query("SELECT * FROM guru_mapel a,guru b WHERE a.nip=b.nip AND a.id_team='$id'");
		return $kueri->result();
	}
	
	
	
	
	
	
	
	
	
	function addKelas()
	{	
		$this->db->query("INSERT INTO kelas(nama) VALUES('".strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))."')");
	}
	
	function updateKelasWali($id)
	{
		$kueri = $this->db->query("UPDATE kelas_wali SET nip='".strip_tags(ascii_to_entities(addslashes($this->input->post('nip',TRUE))))."',id_kelas='".$this->input->post('kelas',TRUE)."' WHERE id_kelas_wali='$id' ");
		return $kueri;
	}
	
	function addKelasWali()
	{	
		$this->db->query("INSERT INTO kelas_wali(id_kelas,nip,id_ta) VALUES('".$this->input->post('kelas',TRUE)."','".strip_tags(ascii_to_entities(addslashes($this->input->post('nip',TRUE))))."','".$this->session->userdata('kd_ta')."')");
	}

	function cekKelas()
	{
		$kueri = $this->db->query(" SELECT * FROM kelas WHERE nama='".strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))."' ");
		return $kueri->num_rows();
	}
	
	function cekWali()
	{
		$kueri = $this->db->query(" SELECT * FROM kelas WHERE nip='".$this->input->post('wali',TRUE)."' AND id_ta='".$this->session->userdata('kd_ta')."' ");
		return $kueri->num_rows();
	}
	
	function cekWalis()
	{
		$kueri = $this->db->query(" SELECT * FROM kelas_wali WHERE nip='".strip_tags(ascii_to_entities(addslashes($this->input->post('nip',TRUE))))."' AND id_ta='".$this->session->userdata('kd_ta')."' ");
		return $kueri->num_rows();
	}
	
	function cekWalisE($id)
	{
		$kueri = $this->db->query(" SELECT * FROM kelas_wali WHERE nip='".strip_tags(ascii_to_entities(addslashes($this->input->post('nip',TRUE))))."' AND id_ta='".$this->session->userdata('kd_ta')."' AND id_kelas_wali<>'$id' ");
		return $kueri->num_rows();
	}
	
	function getGuru()
	{
		$query = $this->db->query("SELECT * FROM guru");

		if ($query->num_rows()> 0){
			foreach ($query->result_array() as $row)
			{
				$data[$row['nip']] = $row['nama'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
	}
	
	function getKelasW()
	{
		$query = $this->db->query("SELECT * FROM kelas");

		if ($query->num_rows()> 0){
			foreach ($query->result_array() as $row)
			{
				$data[$row['id_kelas']] = $row['nama'];
			}
		}
		else
		{
			$data[''] = "";
		}
		$query->free_result();
		return $data;
	}
	
	function getKelasSiswa($id)
	{
		$kueri = $this->db->query("SELECT * FROM kelas a,kelas_siswa b,siswa b WHERE a.id_kelas=b.id_kelas AND b.nip=c.nip AND a.id_kelas='$id'");
		return $kueri;
	}
	
	function cekNis()
	{
		$kueri = $this->db->query(" SELECT * FROM siswa WHERE nis='".strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE))))."' ");
		return $kueri->num_rows();
	}
	
	function cekKelasSiswa()
	{
		$kueri = $this->db->query(" SELECT * FROM kelas_siswa WHERE nis='".strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE))))."' AND id_ta='".$this->session->userdata('kd_ta')."' ");
		return $kueri->num_rows();
	}
	
	function addKelasSiswa()
	{	
		$this->db->query("INSERT INTO kelas_siswa(id_kelas,nis,id_ta) VALUES('".$this->input->post('kode',TRUE)."','".strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE))))."','".$this->session->userdata('kd_ta')."')");
	}
	
	function getKelass($kelas,$num,$offset,$sort_by,$sort_order)//menu admin
	{
		if (empty($offset))
		{
			$offset=0;
		}
		if (empty($kelas))
		{
			$kelas = "";
		}
		else
		{
			$kelas = "AND a.id_kelas='$kelas'";
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('c.nis','c.nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'c.nis';
		$sql = "SELECT a.id_kelas_sis,b.nama as kelas,c.nama as jeneng,c.nis FROM kelas_siswa a,kelas b,siswa c WHERE a.nis=c.nis AND a.id_kelas=b.id_kelas $kelas AND a.id_ta='".$this->session->userdata('kd_ta')."' ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query;
	}
	
	function getKelase($num,$offset,$sort_by,$sort_order)//menu admin
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'nama';
		$sql = "SELECT id_kelas,nama FROM kelas ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query;
	}
	
	function getKelaseW($num,$offset,$sort_by,$sort_order)//menu admin
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('a.nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'a.nama';
		$sql = "SELECT a.id_kelas,a.nama as nama,c.nama as wali,b.id_kelas_wali FROM kelas a,kelas_wali b,guru c WHERE b.nip=c.nip AND a.id_kelas=b.id_kelas ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query;
	}
	
	function getWaliKelas($id)
	{
		$kueri = $this->db->query("SELECT * FROM kelas_wali WHERE id_kelas_wali='$id' ");
		return $kueri->row();
	}
	
	function searchKelase($kunci,$num,$offset,$sort_by,$sort_order)
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('a.nama');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'a.nama';
		$sql = "SELECT a.id_kelas,a.nama as nama,b.nama as wali FROM kelas a,guru b WHERE a.nip=b.nip AND a.nama LIKE '%$kunci%' ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query;
	}
	
	function getKelast($id)
	{
		$sql = "SELECT * FROM kelas WHERE id_kelas='$id'";
		$query = $this->db->query($sql);
		return $query->row();
	}
	
	function getKelasSiswaId($id)
	{
		$sql = "SELECT * FROM kelas_siswa WHERE id_kelas_sis='$id'";
		$query = $this->db->query($sql);
		return $query->row();
	}
	
	function updateKelas()
	{
		$sql = "UPDATE kelas SET nama='".strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))))."' WHERE id_kelas='".$this->input->post('kode',TRUE)."' ";
		$this->db->query($sql);	
	}
	
	function updateKelasSiswa()
	{
		$sql = "UPDATE kelas_siswa SET nis='".strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE))))."',id_kelas='".$this->input->post('kelas',TRUE)."' WHERE id_kelas_sis='".$this->input->post('kode',TRUE)."' ";
		$this->db->query($sql);	
	}
	
	function delKelas()
	{
		$this->db->query("DELETE FROM kelas");
	}
	
	function getNip($id)
	{
		$query = "SELECT * FROM guru WHERE nama='$id'";
		$kueri = $this->db->query($query);
		$data = $kueri->row();
		return $data->nip;
	}
	
	function importKelas($value)
	{
		$kueri = $this->db->query("INSERT INTO kelas VALUES($value)");
		return $kueri;
	}
	
	function exportKelas()
	{
		$query = $this->db->query("SELECT a.id_kelas,a.nama as nama,b.nama as wali FROM kelas a,guru b WHERE a.nip=b.nip");
		return $query;
	}
	
	function del_kelas($id)
	{
		$kueri = $this->db->query("DELETE FROM kelas WHERE id_kelas='$id'");
		return $kueri;
	}
	
	function del_wali($id)
	{
		$kueri = $this->db->query("DELETE FROM kelas_wali WHERE id_kelas_wali='$id' AND id_ta='".$this->session->userdata('kd_ta')."'");
		return $kueri;
	}
	
	function del_kelas_siswa($id)
	{
		$kueri = $this->db->query("DELETE FROM kelas_siswa WHERE id_kelas_sis='$id'");
		return $kueri;
	}
	
	function addRecordSiswa()
	{
		$kueri = $this->db->query("INSERT INTO record_siswa(nis,id_ta) VALUES('".strip_tags(ascii_to_entities(addslashes($this->input->post('nis',TRUE))))."','".$this->session->userdata('kd_ta')."')");
		return $kueri;
	}
	
	function delRecordSiswa($id)
	{
		$kueri = $this->db->query("DELETE FROM record_siswa WHERE nis='".$id."' AND id_ta='".$this->session->userdata('kd_ta')."'");
		return $kueri;
	}
}
?>
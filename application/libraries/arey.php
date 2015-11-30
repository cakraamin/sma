<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Arey
{
	function Arey()
	{}
	
	function getDay()
	{
		for($i=1;$i<=31;$i++)
		{
			$data[$i] = $i;
		}
		return $data;
	}	
	
	function getJam()
	{
		for($i=1;$i<10;$i++)
		{
			$data[$i] = $i;
		}
		return $data;
	}	
	
	function getBulan()
	{
		for($i=1;$i<=12;$i++)
		{
			$data[$i] = $i;
		}
		return $data;
	}
	
	function getBul()
	{
		$bulan = array("Pilih Bulan","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");	
	
		for($i=0;$i<=12;$i++)
		{
			$data[$i] = $bulan[$i];
		}
		return $data;
	}
	
	function getTahun()
	{
		$now = date("Y");
		for($i=$now;$i>=$now-30;$i--)
		{
			$data[$i] = $i;
		}
		return $data;
	}
	
	function getTahunGuru()
	{
		$now = date("Y");
		for($i=$now;$i>=$now-60;$i--)
		{
			$data[$i] = $i;
		}
		return $data;
	}
	
	function getJangkaLaporan()
	{
		$laporan = array(
				"0"	=> "Pilih Jenis",
				"1"	=> "Tahunan",
				"2"	=> "Bulanan"
		);
		return $laporan;
	}
	
	function getFormatLaporan()
	{
		$format = array(
			'xls'		=> 'xls',
			'pdf'		=> 'pdf'		
		);
		return $format;
	}
	
	function getPengguna()
	{
		$data = array(
			'2'	=> 'Operator',
			'3'	=> 'Guru'		
		);	
		return $data;
	}
	
	function getTeam()
	{
		$data = array(
			'1'	=> 'Satu Guru',
			'2'	=> 'Dua Guru',
			'3'	=> 'Tiga Guru',
			'4'	=> 'Empat Guru'		
		);	
		return $data;
	}

	function getPenjurusan($id="")
	{
		$data = array(
			'1'	=> 'MIPA',
			'2'	=> 'IPS'
		);

		if($id == "")
		{
			return $data;
		}
		else
		{
			return $data[$id];
		}		
	}

	function getKelompok($id="")
	{
		$jenis = array(
			'A'			=> 'Kelompok A',
			'B'			=> 'Kelompok B',
			'C'			=> 'Kelompok C',
			'Peminatan'	=> 'Lintas Minat'		
		);

		if($id == "")
		{
			return $jenis;
		}
		else
		{
			return $jenis[$id];
		}		
	}

	function getJenis($id="")
	{
		$data = array(
			'1'		=> 'Nilai Pengetahuan',
			'2'		=> 'Nilai Keterampilan',
			'3'		=> 'Nilai Sikap'
		);

		if($id == "")
		{
			return $data;
		}		
		else
		{
			return $data[$id];
		}
	}

	function getSikap($id="")
	{
		$data = array(
			'1'		=> 'SB',
			'2'		=> 'B',
			'3'		=> 'C',
			'4'		=> 'K'
		);
		
		if($id == "")
		{
			return $data;	
		}
		else
		{
			return $data[$id];
		}
	}

	function getJenisLaporan()
	{
		$data = array(
			'1'		=> 'Nilai Pengetahuan',
			'2'		=> 'Nilai Keterampilan',
			'3'		=> 'Nilai Sikap'
		);

		return $data;
	}

	function getTingkat()
	{
		$data = array();

		for($i=1;$i<=5;$i++)
		{
			$data[$i] = $i;
		}

		return $data;
	}

	function getPengetahuan()
	{
		$data = array(
			'1'		=> 'Ulangan',
			'2'		=> 'Tugas'
		);

		return $data;
	}

	function getBulane($id)
	{
		$bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");	
		return $bulan[intval($id)-1];
	}

	function getJLaporan()
	{
		$data = array(
			'1'			=> 'Laporan Rapor Siswa',
			'2'			=> 'Deskripsi Nilai Siswa',
			'3'			=> 'Leger Nilai'
		);

		return $data;
	}	

	function getTingkatKelas()
	{
		$data = array(
			'1'		=> 'X',
			'2'		=> 'XI',
			'3'		=> 'XII'
		);	

		return $data;
	}
}

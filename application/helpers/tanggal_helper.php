<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('ganti_tanggal'))
{
	function ganti_tanggal($var)
	{	
		$bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
		$pecah = explode("-",$var);
		return $pecah[2]." ".$bulan[$pecah[1] - 1]." ".$pecah[0];
	}
}
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Day
{
	function Day()
	{
	
	}
	
	function getHari()
	{
		$hari = array('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu');
		return $hari[date("N") - 1];
	}
	
	function getTgl()
	{
		return date("j");
	}
	
	function getBulan()
	{
		$bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
		return $bulan[date("n") - 1];
	}
	
	function getTahun()
	{
		return date("Y");
	}
}

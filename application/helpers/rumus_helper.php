<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('rumus'))
{
	function rumus($rumus)
	{
		$pecah = explode("-",$rumus);
		$harian = $pecah[0] != 0 ? $pecah[0]."xNH" : "";
		$tugas = $pecah[1] != 0 ? "+".$pecah[1]."xNT" : "";
		$ulangan = $pecah[2] != 0 ? "+".$pecah[2]."xNU" : "";
		if($harian == "" && $tugas == "" && $ulangan == "")
		{
			return "Kosong";		
		}
		else
		{
			return $harian.$tugas.$ulangan;
		}		
	}
}
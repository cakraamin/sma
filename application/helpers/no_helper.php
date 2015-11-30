<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('ganti_no'))
{
    function ganti_no($var = '')
    {
		if(substr($var,0,3) == '+62')
		{
			$nomor = str_replace('+62','0',$var);
		}
		else
		{
			$nomor = $var;
		}
    	return $nomor;
    }	
}

if ( ! function_exists('ubah_no'))
{
    function ubah_no($var = '')
    {
		if(substr($var,0,2) == '08')
		{
			$panjang = strlen($var);
			$nomor = '+62'.substr($var,1,$panjang);
		}
		else
		{
			$nomor = $var;
		}
    	return $nomor;
    }	
}	

/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */
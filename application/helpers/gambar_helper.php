<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('cek_gambar'))
{
	function cek_gambar($var,$folder)
	{	
		if(empty($var))
		{
			$gambar = "";
		}
		else
		{
			if (file_exists("./".$folder."/".$var)) 
			{
				$gambar = '<img src="'.base_url().$folder.'/'.$var.'" alt="Image 1" width="110px" />';		
			} 
			else 
			{
    			$gambar = '<img src="'.base_url().'asset/images/who.jpg" alt="Image 1" width="110px" />';
			} 		
		}
		return $gambar;
	}
}
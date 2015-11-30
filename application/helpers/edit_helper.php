<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_edit'))
{
	function get_edit($current,$digit)
	{
		$ci =& get_instance();
		$url = "";
		for($i=$digit+1;$i<=$ci->uri->total_segments();$i++)
		{
			$segmen = $i == $ci->uri->total_segments()?"":"/";
			$url .= $ci->uri->segment($i).$segmen; 		
		}
		return $url;
	}
}
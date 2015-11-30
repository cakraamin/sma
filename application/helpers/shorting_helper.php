<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('shorting_page'))
{
	function shorting_page($addr,$uri,$repl)
	{
		$ci =& get_instance();
		if($ci->uri->segment($uri) == "" && $ci->uri->segment($uri + 1) == "")
		{
			return $addr."/".$repl;
		}
		else
		{
			$awal = $ci->uri->segment($uri)."/".$ci->uri->segment($uri + 1);
			return str_replace($awal,$repl,$addr);
		}
	}
}
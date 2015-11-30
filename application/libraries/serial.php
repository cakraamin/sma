<?php
class Serial
{
	function create() 
	{
		$file = "./system/core/ser.txt";
		if (file_exists($file)) 
		{
    		$open = fopen($file,'r');
			$hasil = fread($open, filesize($file));
			fclose($open);
			$ser = $this->exkrip($this->getMac());
			if(trim($hasil) != trim($ser))
			{
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
		else 
		{
    		$fh = fopen($file, 'w') or die("can't open file");
			$stringData = "";
			fwrite($fh, $stringData);
			fclose($fh);
			return FALSE;			
		}
	}
	
	function getMac()
	{
		$os_string = php_uname('s');
		if (strpos(strtoupper($os_string), 'WIN')!==false)
		{
			exec("ipconfig /all", $output);
			foreach($output as $line)
			{
				if (preg_match("/(.*)Physical Address(.*)/", $line))
				{
					$mac = $line;
					$mac = str_replace("Physical Address. . . . . . . . . :","",$mac);
				}
			}	
		}
		else
		{
			exec("ifconfig", $output);
			foreach($output as $line)
			{
				if (preg_match("/(.*)eth0(.*)/", $line))
				{
					$mac = $line;
					$mac = str_replace("eth0      Link encap:Ethernet  HWaddr ","",$mac);
				}
			}
		}
		$mac = trim($mac);
		return $mac;
	}
	
	function exkrip($id)
	{
		$os_string = php_uname('s');
		if (strpos(strtoupper($os_string), 'WIN')!==false)
		{
			$pch = "-";
		}
		else
		{
			$pch = ":";		
		}
		$pecah = explode($pch,$id);
		$n = 0;
		$nilai = '';
		foreach($pecah as $pcah)
		{
			$ekrp = md5($pcah);
			$lagi = substr($ekrp,$n,5);
			$n += 2;
			$nilai .= $lagi."-"; 
		}
		$kal = $nilai;
		$jum = strlen($kal);
		return substr($kal,0,$jum - 1);
	}
}

?>

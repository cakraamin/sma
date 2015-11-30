<?php
class Words
{
	function ctword($x) 
	{
		$number = array("nol", "satu", "dua", "tiga", "empat", "lima",
"enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		$jumlah = strlen($x);
		for($i=0;$i<$jumlah;$i++)
		{
			$temp .= $number[substr($x, $i, 1)]." ";
		}	
	
		return $temp;
	}

	function terbilang($x,$style=4,$strcomma=",") 
	{
		$result = '';
		if($x<0) 
		{
			$result = "minus ". trim($this->ctword($x));
		} 
		else 
		{
			$arrnum = explode("$strcomma",$x);
			$jum = count($arrnum);
			$j = 1;
			foreach($arrnum as $dt_arrnum)
			{
				$koma = ($jum == $j)?"":" koma ";
				$result .= trim($this->ctword($dt_arrnum)).$koma;
				$j++;
			}
		}
		switch ($style) 
		{
			case 1: //1=uppercase  dan
				$result = strtoupper($result);
				break;
			case 2: //2= lowercase
				$result = strtolower($result);
				break;
			case 3: //3= uppercase on first letter for each wor
				$result = ucwords($result);
				break;
			default: //4= uppercase on first letter
				$result = ucfirst($result);
			break;
		}
		return $result;
	}
}

?>

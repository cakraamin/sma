<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('array_to_csv'))
{
	function array_to_csv($array, $download = "")
	{
		if ($download != "")
		{	
			header('Content-Type: application/csv');
			header('Content-Disposition: attachement; filename="' . $download . '"');
		}		

		ob_start();
		$f = fopen('php://output', 'w') or show_error("Can't open php://output");
		$n = 0;		
		foreach ($array as $line)
		{
			$n++;
			if ( ! fputcsv($f, $line))
			{
				show_error("Can't write line $n: $line");
			}
		}
		fclose($f) or show_error("Can't close php://output");
		$str = ob_get_contents();
		ob_end_clean();

		if ($download == "")
		{
			return $str;	
		}
		else
		{	
			echo $str;
		}		
	}
}

// ------------------------------------------------------------------------

/**
 * Query to CSV
 *
 * download == "" -> return CSV string
 * download == "toto.csv" -> download file toto.csv
 */
if ( ! function_exists('query_to_csv'))
{
	function query_to_csv($query, $headers = TRUE, $download = "")
	{
		if ( ! is_object($query) OR ! method_exists($query, 'list_fields'))
		{
			show_error('invalid query');
		}
		
		$array = array();
		
		if ($headers)
		{
			$line = array();
			foreach ($query->list_fields() as $name)
			{
				$line[] = $name;
			}
			$array[] = $line;
		}
		
		foreach ($query->result_array() as $row)
		{
			$line = array();
			foreach ($row as $item)
			{
				$line[] = $item;
			}
			$array[] = $line;
		}

		echo array_to_csv($array, $download);
	}
}

if ( ! function_exists('csv_to_array'))
{
	function csv_to_array($filename,$limit=0)
	{
		$str = "";
	
		if (file_exists($filename)) 
		{
			$row = 1;
			if (($handle = fopen($filename, "r")) !== FALSE) 
			{
				while (($data = fgetcsv($handle, $limit, ",")) !== FALSE) 
				{
					$num = count($data);
					$row++;
					for ($c=0; $c < $num; $c++) 
					{
						if($c == $num - 1)
						{
							$sepa = "*";
						}
						else
						{
							$sepa = ",";
						}
						$str .= $data[$c].$sepa;
					}
				}
				fclose($handle);
				return $str;
			}
		} 
		else 
		{
			show_error("File Not Exist");
		}		
	}
}

/* End of file csv_helper.php */
/* Location: ./system/helpers/csv_helper.php */
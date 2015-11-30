<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel{
	
	function Excel($params)
	{
		$this->CI =& get_instance();
	  	$php_page = $params['file'];
    	$excel_file_name = $params['name'];
		$this->setHeader($excel_file_name);
		$this->CI->load->view($php_page);	
	}
	function setHeader($excel_file_name)//this function used to set the header variable
	{		
		header("Content-type: application/octet-stream");//A MIME attachment with the content type "application/octet-stream" is a binary file.
		//Typically, it will be an application or a document that must be opened in an application, such as a spreadsheet or word processor. 
		header("Content-Disposition: attachment; filename=$excel_file_name");//with this extension of file name you tell what kind of file it is.
		header("Pragma: no-cache");//Prevent Caching
		header("Expires: 0");//Expires and 0 mean that the browser will not cache the page on your hard drive	
	}
}
?>
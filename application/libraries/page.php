<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Page
{
	function Page()
	{
		$this->SG =& get_instance();
		$this->SG->load->library(array('pagination'));
	}
	
	function getPagination($total_page,$per_page,$url,$uri=3)
	{
		$config['base_url'] = base_url().$url;
		$config['total_rows'] = $total_page;
		$config['per_page'] = $per_page;
		$config['first_link'] = 'Pertama';
		$config['first_tag_open'] = '&nbsp;<strong>';
		$config['first_tag_close'] = '</strong>';
		$config['uri_segment'] = $uri;	
		$config['last_link'] = 'Terakhir';
		$config['last_tag_open'] = '&nbsp;<strong>';
		$config['last_tag_close'] = '</strong>';
		$config['next_link'] = 'Berikutnya';
		$config['next_tag_open'] = '&nbsp;<strong>';
		$config['next_tag_close'] = '</strong>';
		$config['prev_link'] = 'Sebelumnya';
		$config['prev_tag_open'] = '&nbsp;<strong>';
		$config['prev_tag_close'] = '</strong>';
		$config['cur_tag_open'] = '&nbsp;<span>';
		$config['cur_tag_close'] = '</span>';
	    $config['full_tag_open'] = '<div class="pagination"><p>';
    	$config['full_tag_close'] = '</div></p>';
		
		$this->SG->pagination->initialize($config);
		
		return $this->SG->pagination->create_links();
	}	
}

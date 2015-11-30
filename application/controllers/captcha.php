<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('captcha');
		
		$this->load->model('mcaptcha','',TRUE);
	}

	function index()
	{
		
	}
	
	function gambar()
	{
		$vals = array(
						'img_path'	 => './asset/captcha/',
						'img_url'	 => base_url().'asset/captcha/'
					);
		
		$cap = create_captcha($vals);
	
		$data = array(
						'captcha_id'	=> '',
						'captcha_time'	=> $cap['time'],
						'ip_address'	=> $this->input->ip_address(),
						'word'			=> $cap['word']
					);
	
		$query = $this->db->insert_string('captcha', $data);
		$this->db->query($query);
			
		echo $cap['image'];
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
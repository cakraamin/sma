<?php
class Mcaptcha extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}
	
	function cekCapca()
	{
		$expiration = time()-7200;
		$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
		
		$word = $this->input->post('kode',TRUE);
		$ip = $this->input->ip_address();
		
		$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = '".$this->db->escape_str($word)."' AND ip_address = '$ip'";
		$query = $this->db->query($sql);
		
		return $query;
		
	}
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->load->view('register');	
	}
	
	function input()
	{
		$nilai = $this->input->post('satu',TRUE)."-".$this->input->post('dua',TRUE)."-".$this->input->post('tiga',TRUE)."-".$this->input->post('empat',TRUE)."-".$this->input->post('lima',TRUE)."-".$this->input->post('enam',TRUE);
		if($this->serial->exkrip($this->serial->getMac()) == $nilai)
		{
			$file = "./system/core/ser.txt";
			unlink($file);
			$fh = fopen($file, 'w') or die("can't open file");
			$stringData = $nilai;
			fwrite($fh, $stringData);
			fclose($fh);
			redirect('home');		
		}
		else
		{
			$this->message->set('notice','Nomor Register Salah');
			redirect('register');
		}
	}
}
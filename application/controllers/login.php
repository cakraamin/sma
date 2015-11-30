<?php
class Login extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('mlogin','',TRUE);
		$this->load->model('mcaptcha','',TRUE);
	}

	function index()
	{
		$query=$this->mcaptcha->cekCapca();
		/*foreach ($query->result() as $row)
		{
			$jum=$row->count;
		}
		if ($jum == 0)
		{
			$this->session->userdata('kode');
			echo "salah";
			exit();
		} */
	
		$username = strip_tags(ascii_to_entities(addslashes($this->input->post('nama',TRUE))));    
	    $password = strip_tags(ascii_to_entities(addslashes($this->input->post('pass',TRUE))));
		
		$cekPengguna = $this->mlogin->verifyPengguna($username,$password);
		if ($cekPengguna->num_rows() > 0)
		{
			$ta = $this->mlogin->getKdTa();
			$id_ta = $ta->id_ta;
			$ta = $ta->ta;
			$this->session->userdata('kode');
			$row = $cekPengguna->row_array();
			
			if($row['tingkatid'] == 3)
			{
				if($this->mlogin->getIdGuru($row['nip'],$id_ta) > 0)
				{
					$data = array(
						'id'  		=> $row['user_id'],
						'username'  => $row['nameid'],
						'level' 	=> $row['tingkatid'],
						'nip'		=> $row['nip'],
						'sttus'		=> 'wali',
						'kd_ta'  	=> $id_ta,
						'ta'  		=> $ta
					);
				}
				else
				{
					$data = array(
						'id'  		=> $row['user_id'],
						'username'  => $row['nameid'],
						'level' 	=> $row['tingkatid'],
						'nip'		=> $row['nip'],
						'kd_ta'  	=> $id_ta,
						'ta'  		=> $ta
					);				
				}
			}
			else
			{
				$data = array(
					'id'  		=> $row['user_id'],
					'username'  => $row['nameid'],
					'level' 	=> $row['tingkatid'],
					'kd_ta'  	=> $id_ta,
					'ta'  		=> $ta
				);
			}

			$this->session->set_userdata($data);
			
			echo $this->session->userdata('level');
		}
		else
		{
			echo "gagal";
		}
	}

	function logout()
	{	
		$this->session->sess_destroy();
		
		redirect('home','refresh');
	}
}
?>
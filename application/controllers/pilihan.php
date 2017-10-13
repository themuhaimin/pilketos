<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pilihan extends MY_Controller
{
    public $data = array('pesan'=> '');

	public function __construct()
    {
		parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
		$this->load->model('Login_model', 'login', TRUE);
		$this->load->model('Pilketos_model', 'pilketos', TRUE);
	}

	public function index()
    {
		
		$memilih=$this->pilketos->cek_memilih($this->session->userdata("nis"));
		foreach($memilih as $row){
			$this->data['terpilih']=$row->hasil;
		}
		$this->data['nis']= $this->session->userdata("nis");
		$this->data['login']= $this->session->userdata("login");
		$this->data['calon']= $this->pilketos->calon();
		$this->load->view('pilihan',$this->data);
	}
	public function input_pilihan(){
	$id_terpilih= $this->input->post('idnya');
	$nis=$this->session->userdata('nis');
	$terisi=$this->pilketos->cek_memilih($nis);
	if ($terisi){
	$this->pilketos->updatepilihan($nis,$id_terpilih);
	       } else {
	$this->pilketos->tambahpilihan($nis,$id_terpilih);
	       }
	}
	public function logout()
	{
        $this->login->logout();
		redirect('login');
	}
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */
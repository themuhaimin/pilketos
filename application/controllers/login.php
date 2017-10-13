<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
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
            // validasi sukses
            if($this->login->validasi())
            {
                // cek di database sukses
                if($this->login->cek_user())
                {  
					if(!$this->login->cek_memilih())
					{	
						$this->pilketos->tambahpilihan($this->session->userdata('nis'),'0');
						redirect('pilihan');
					}
					else {
						$this->data['pesan'] = 'Sebelumnya Anda Sudah memilih. Silakan cek data NIS';
						$this->session->unset_userdata(array('username' => '', 'login' => FALSE, 'id_ujian' => '','waktu_ujian' => '','limit' => '','kode_acak' => ''));
						$this->session->sess_destroy();
						$this->load->view('login/login_form', $this->data);
					}
                }
                // cek database gagal
                else
                {
                    $this->data['pesan'] = 'Nomor Induk anda Salah.';
                    $this->load->view('login/login_form', $this->data);
                }
            }
            // validasi gagal
            else
            {
                $this->load->view('login/login_form', $this->data);
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
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

    public $db_tabel = 'siswa';

    public function load_form_rules()
    {
        $form_rules = array(
                            array(
                                'field' => 'username',
                                'label' => 'Nomor Induk',
                                'rules' => 'required'
                            ),
        );
        return $form_rules;
    }

    public function validasi()
    {
        $form = $this->load_form_rules();
        $this->form_validation->set_rules($form);

        if ($this->form_validation->run())
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    // cek status user, login atau tidak?
    public function cek_user()
    {
        $nis = $this->input->post('username');
        $query = $this->db->where('nis', $nis)
                          ->limit(1)
                          ->get($this->db_tabel);

        if ($query->num_rows() == 1)
        {
            $data = array('nis' => $nis, 'login' => TRUE);
            // buat data session jika login benar
            $this->session->set_userdata($data);
            return TRUE;
        }
        else
        {

            return FALSE;
        }
    }
	public function cek_memilih()
    {
		$nis = $this->input->post('username');
        $query = $this->db->where('nis', $nis)
                          ->limit(1)
                          ->get('hasil');

        if ($query->num_rows() == 1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
	}
	public function calon()
    {
		$query = $this->db->get('calon')->result();
	}
    public function logout()
    {
        $this->session->unset_userdata(array('username' => '', 'login' => FALSE, 'id_ujian' => '','waktu_ujian' => '','limit' => '','kode_acak' => ''));
        $this->session->sess_destroy();
    }
}
/* End of file login_model.php */
/* Location: ./application/models/login_model.php */
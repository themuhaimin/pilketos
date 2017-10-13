<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pilketos_model extends CI_Model {

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
   
	public function calon()
    {
		return $query = $this->db->select('*')->get('calon')->result();
	}
	public function cek_memilih($nis){
		return $this->db->select('*')
						->where('nis',$nis)
                        ->get('hasil')
                        ->result();
	}
	    public function tambahpilihan($nis,$id_terpilih)
    {	

        $hasil = array(
            'nis' => $nis,
			'hasil'=>$id_terpilih
        );
        $this->db->insert('hasil', $hasil);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
	 public function updatepilihan($nis,$id_terpilih)
    {

        $hasil = array(
            'hasil'=>$id_terpilih,
        );
        // update db
		$this->db->where('nis', $nis);
        $this->db->update('hasil', $hasil);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    public function logout()
    {
        $this->session->unset_userdata(array('username' => '', 'login' => FALSE, 'id_ujian' => '','waktu_ujian' => '','limit' => '','kode_acak' => ''));
        $this->session->sess_destroy();
    }
}
/* End of file login_model.php */
/* Location: ./application/models/login_model.php */
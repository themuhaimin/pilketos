<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public $db_tabel = 'siswa';

    public function load_form_rules()
    {
        $form_rules = array(
                            array(
                                'field' => 'id_calon',
                                'label' => 'Username',
                                'rules' => 'required'
                            ),
        );
        return $form_rules;
    }

    public function validasi_tambah()
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
	 public function rekap()
    {
        $sql = $sql=$this->db->query("SELECT id_calon as id,nama,kelas.kelas,(SELECT COUNT(hasil) AS OrdersFromCustomerID7 FROM hasil
				WHERE hasil=id) as hasil FROM `calon` LEFT JOIN `kelas` ON `kelas`.`id_kelas`=`calon`.kelas");
        return $sql->result();
    }
	 public function buat_tabel($data)
    {
        $this->load->library('table');

        // buat class zebra di <tr>,untuk warna selang-seling
        $tmpl = array('row_alt_start'  => '<tr class="zebra">');
        $this->table->set_template($tmpl);

        // heading tabel
        $this->table->set_heading('No Urut', 'Nama', 'Kelas', 'Perolehan Suara');

         foreach ($data as $row)
        {
            $this->table->add_row(
                $row->id,
                $row->nama,
				$row->kelas,
                $row->hasil
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }
	 public function cari_semua($offset)
	{
       
        /**
         * $offset start
         * Gunakan hanya jika class 'PAGINATION' menggunakan option
         * 'use_page_numbers' => TRUE
         * Jika tidak, beri comment
         */        
		if (is_null($offset) || empty($offset))
        {
            $this->offset = 0;
        }
        else
        {
            $this->offset = ($offset * $this->per_halaman) - $this->per_halaman;
        }		
        // $offset end

        return $this->db->select('id_calon,nama,kelas.kelas,foto')
                        ->from('calon')
						->join('kelas','kelas.id_kelas=calon.kelas','left')
                        ->order_by('id_calon', 'ASC')
                        ->get()
                        ->result();
	}

    public function cari($id_calon)
    {
        return $this->db->where('id_calon', $id_calon)
            ->limit(1)
            ->get('calon')
            ->row();
    }

    public function buat_tabel_siswa($data)
    {
        $this->load->library('table');

        // buat class zebra di <tr>,untuk warna selang-seling
        $tmpl = array('row_alt_start'  => '<tr class="zebra">');
        $this->table->set_template($tmpl);

        // heading tabel
        $this->table->set_heading('No', 'NIS', 'Nama', 'Status', 'Aksi');

        // no urut data
        $no = 0 + $this->offset;

        foreach ($data as $row)
        {
            $this->table->add_row(
                $row->id_calon,
                $row->nama,
				$row->kelas,
				'<img src="'.base_url().$row->foto.'" width="50"/>',
                anchor('admin/edit_calon/'.$row->id_calon,'Edit',array('class' => 'btn btn-primary')).' '.
                anchor('admin/hapus_calon/'.$row->id_calon,'Hapus',array('class'=> 'btn btn-danger','onclick'=>"return confirm('Anda yakin akan menghapus data ini?')"))
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }
	    public function tambah($gbr)
    {
        $kelas = array(
                      'id_calon' => $this->input->post('id_calon'),
					  'nama' => $this->input->post('nama'),
					  'tpt_lahir' => $this->input->post('tpt_lahir'),
					  'tgl_lahir' => $this->input->post('tgl_lahir'),
					  'foto' => $gbr,
                      'kelas' => $this->input->post('id_kelas')
                      );
        $this->db->insert('calon', $kelas);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
	public function edit($id_calon)
    {
            $siswa = array(
            'id_calon'=>$this->input->post('id_calon'),
            'nama'=>$this->input->post('nama'),
            'tpt_lahir' => $this->input->post('tpt_lahir'),
			'tgl_lahir' => $this->input->post('tgl_lahir'),
			'kelas' => $this->input->post('id_kelas'),
			
        );

        // update db
        $this->db->where('id_calon', $id_calon);
        $this->db->update('calon', $siswa);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }public function hapus($id_calon)
    {
        $this->db->where('id_calon', $id_calon)->delete('calon');

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
	//untuk chart
	function report(){
        $query = $sql=$this->db->query("SELECT id_calon as id,nama,kelas,(SELECT COUNT(hasil) AS OrdersFromCustomerID7 FROM hasil
				WHERE hasil=id) as hasil FROM `calon`");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasilnya[] = $data;
            }
            return $hasilnya;
        }
    }
	function tampil_jawaban($id)
	{
		$sql = $sql=$this->db->query("SELECT id_calon as id,nama,kelas,(SELECT COUNT(hasil) AS OrdersFromCustomerID7 FROM hasil
				WHERE hasil=id) as hasil FROM `calon`");
        return $sql;
	}
	    public function logout_admin()
    {
        $this->session->unset_userdata(array('username' => '', 'login' => FALSE, 'id_ujian' => '','waktu_ujian' => '','limit' => '','kode_acak' => ''));
        $this->session->sess_destroy();
    }
}
/* End of file login_model.php */
/* Location: ./application/models/login_model.php */
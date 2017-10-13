<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public $data = array('pesan'=> '');

	public function __construct()
    {
		parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
		//$this->load->library('graph');
		$this->load->model('Login_admin', 'login_admin', TRUE);
		$this->load->model('Admin_model', 'admin', TRUE);
		$this->load->model('Kelas_model', 'kelas', TRUE);
		 $this->load->helper(array('url')); //load helper url 
	}

	public function index($data=0)
    {
		echo $this->uri->segment(2);
		// status user login = BENAR, pindah ke halaman absen
        if ($this->session->userdata('admin') == TRUE)
        {
			redirect('ujian/beranda');
		}
        // status login salah, tampilkan form login
        else
        {
            // validasi sukses
            if($this->login_admin->validasi())
            {    $this->session->set_userdata('kcfinder_mati',FALSE);
                // cek di database sukses
                if($this->login_admin->cek_user())
                {   
					
                    redirect('admin/rekap');
					
                }
                // cek database gagal
                else
                {
                    $this->data['pesan'] = 'Username atau Password salah.';
                    $this->load->view('login/login_admin', $this->data);
                }
            }
            // validasi gagal
            else
            {
                $this->load->view('login/login_admin', $this->data);
            }
		}
	}
	public function rekap(){
	$this->pembatas_user();
	$this->data['main_view']='rekap';
	$this->data['breadcrumb']='REKAPITULASI HASIL SUARA';
	$this->data['tabel_data']=$this->admin->buat_tabel($this->admin->rekap());
	$this->load->view('template',$this->data);
	}
	public function grafik(){
	$this->pembatas_user();
	$this->data['main_view']='grafik';
	$this->data['breadcrumb']='REKAPITULASI HASIL SUARA';
	$this->data['tabel_data']=$this->admin->buat_tabel($this->admin->rekap());
	$this->load->view('template',$this->data);
	}
	public function calon($offset = 0)
	{
        $this->pembatas_user();
		$this->data['main_view']='calon/siswa';
		// hapus data temporary proses update
        $this->session->unset_userdata('nis_sekarang', '');

        // cari data calon
        $calon = $this->admin->cari_semua($offset);

        // ada data siswa, tampilkan
        if ($calon)
        {
            $tabel = $this->admin->buat_tabel_siswa($calon);
            $this->data['tabel_data'] = $tabel;


        }
        // tidak ada data siswa
        else
        {
            $this->data['pesan'] = 'Tidak ada data siswa.';
        }
        $this->load->view('template', $this->data);
	}
	 //chart
	 	function chart()
	{
		$this->pembatas_user();
		$data['main_view']='grafik';
		 $data['hasilnya'] = $this->admin->report();
		
		$this->load->view('template',$data);
	}
	    public function tambah_calon()
    {
		$this->pembatas_user();
		$this->data['breadcrumb']  = 'Siswa > Tambah';
        $this->data['main_view']   = 'calon/siswa_form';
        $this->data['form_action'] = 'admin/tambah_calon';
		$id_calon=$this->input->post('id_calon');

                //status
            $this->data['option_jk']['L'] = 'Laki-laki';
			$this->data['option_jk']['P'] = 'Perempuan';
		// option kelas, untuk menu dropdown
        $kelas = $this->kelas->cari_semua();

        // data kelas ada
        if($kelas)
        {
            foreach($kelas as $row)
            {
                $this->data['option_kelas'][$row->id_kelas] = $row->kelas;
            }
        }


        // if submit
        if($this->input->post('submit'))
        {
					//konfigurasi upload
					$this->load->library('upload');
        $nmfile = "img".$this->input->post('id_calon'); //nama file saya beri nama langsung dan diikuti fungsi time
        $config['upload_path'] = 'foto2';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '2048'; //maksimum besar file 2M
        $config['max_width']  = '1288'; //lebar maksimum 1288 px
        $config['max_height']  = '768'; //tinggi maksimu 768 px
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);
        
        if($_FILES['foto']['name'])
        {
            if ($this->upload->do_upload('foto'))
            {   $g = $this->upload->data();
                $gbr = 'foto2/'.$g['file_name'];
                // validasi sukses
				if($this->admin->validasi_tambah())
					{
					if($this->admin->tambah($gbr))
						{
							$this->session->set_flashdata('pesan', 'Proses tambah data berhasil.');
							redirect('siswa');
					}
						else
					{
							$this->data['pesan'] = 'Proses tambah data gagal.';
							$this->load->view('template', $this->data);
						}
					}
            // validasi gagal
            else
            { 
                $this->load->view('template', $this->data);
            }
            }else{
                //pesan yang muncul jika terdapat error dimasukkan pada session flashdata
                $this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-danger\" id=\"alert\">Gagal upload gambar !!</div></div>");
                redirect('admin/calon'); //jika gagal maka akan ditampilkan form upload
            }
        }
            
        }
        // if no submit
        else
        {
            $this->load->view('template', $this->data);
        }
    }

    public function edit_calon($id_calon = NULL)
    {
        $this->pembatas_user();
		$this->data['breadcrumb']  = 'Siswa > Edit';
        $this->data['main_view']   = 'calon/siswa_form';
        $this->data['form_action'] = 'admin/edit_calon/' . $id_calon;

		// option kelas, untuk menu dropdown
        $kelas = $this->kelas->cari_semua();

        // data kelas ada
        if($kelas)
        {
            foreach($kelas as $row)
            {
                $this->data['option_kelas'][$row->id_kelas] = $row->kelas;
            }
        }

        // Mencegah error http://localhost/absensi2014/siswa/edit/$nis (edit tanpa ada parameter)
        // Ada parameter
        if( ! empty($id_calon))
        {
            // submit
            if($this->input->post('submit'))
            {
                // validasi berhasil
                if($this->admin->validasi_tambah() === TRUE)
                {
                    //update db
                    $this->admin->edit($this->session->userdata('nis_sekarang'));
                    $this->session->set_flashdata('pesan', 'Proses update data berhasil.');

                    redirect('admin/calon');
                }
                // validasi gagal
                else
                { echo "aaaa";
                    $this->load->view('template', $this->data);
                }

            }
            // tidak disubmit, form pertama kali dimuat
            else
            { 
                // ambil data dari database, $form_value sebagai nilai default form
                $siswa = $this->admin->cari($id_calon);
                foreach($siswa as $key => $value)
                {
                    $this->data['form_value'][$key] = $value;
                }

                // set temporary data untuk edit
                $this->session->set_userdata('nis_sekarang', $siswa->id_calon);

                $this->load->view('template', $this->data);
            }
        }
        // tidak ada parameter $nis di URL, kembalikan ke halaman siswa
        else
        {
            redirect('siswa');
        }
    }

    public function hapus_calon($id_calon = NULL)
    {
        if( ! empty($id_calon))
        {
            if($this->admin->hapus($id_calon))
            {
                $this->session->set_flashdata('pesan', 'Proses hapus data berhasil.');
                redirect('siswa');
            }
            else
            {
                $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
                redirect('siswa');
            }
        }
        else
        {
            $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
            redirect('kelas');
        }
    }

    public function is_nis_exist()
    {
        $nis_sekarang  = $this->session->userdata('nis_sekarang');
        $nis_baru      = $this->input->post('nis');

        if ($nis_baru === $nis_sekarang)
        {
            return TRUE;
        }
        else
        {
            // cek database untuk nis yang sama
            $query = $this->db->get_where('siswa', array('nis' => $nis_baru));
            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_nis_exist',
                                                    "Siswa dengan NIS $nis_baru sudah terdaftar");
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
    }

	public function logout_admin()
	{
        $this->admin->logout_admin();
		redirect('admin');
	}
	public function pembatas_user(){
				        if ($this->session->userdata('admin') == FALSE)
        {
           
			redirect('admin');
			 
        } 
	}
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */